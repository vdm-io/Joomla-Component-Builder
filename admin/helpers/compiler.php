<?php
/*--------------------------------------------------------------------------------------------------------|  www.vdm.io  |------/
    __      __       _     _____                 _                                  _     __  __      _   _               _
    \ \    / /      | |   |  __ \               | |                                | |   |  \/  |    | | | |             | |
     \ \  / /_ _ ___| |_  | |  | | _____   _____| | ___  _ __  _ __ ___   ___ _ __ | |_  | \  / | ___| |_| |__   ___   __| |
      \ \/ / _` / __| __| | |  | |/ _ \ \ / / _ \ |/ _ \| '_ \| '_ ` _ \ / _ \ '_ \| __| | |\/| |/ _ \ __| '_ \ / _ \ / _` |
       \  / (_| \__ \ |_  | |__| |  __/\ V /  __/ | (_) | |_) | | | | | |  __/ | | | |_  | |  | |  __/ |_| | | | (_) | (_| |
        \/ \__,_|___/\__| |_____/ \___| \_/ \___|_|\___/| .__/|_| |_| |_|\___|_| |_|\__| |_|  |_|\___|\__|_| |_|\___/ \__,_|
                                                        | |                                                                 
                                                        |_| 				
/-------------------------------------------------------------------------------------------------------------------------------/

	@version			2.2.0
	@created		30th April, 2015
	@package		Component Builder
	@subpackage		compiler.php
	@author			Llewellyn van der Merwe <http://www.vdm.io>
	@my wife		Roline van der Merwe <http://www.vdm.io/>	
	@copyright		Copyright (C) 2015. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html 
	
	Builds Complex Joomla Components 
                                                             
/-----------------------------------------------------------------------------------------------------------------------------*/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// Use the component builder autoloader
ComponentbuilderHelper::autoLoader();

/**
 * Compiler class
 */
class Compiler extends Infusion
{
	/*
	 * The Temp path
	 * 
	 * @var      string
	 */
	private $tempPath;
	
	public $filepath		= '';
	// fixed pathes
	protected $dynamicIntegration	= false;
	protected $backupPath		= false;
	protected $gitPath		= false;

	/**
	 * Constructor
	 */
	public function __construct($config = array ())
	{
		// first we run the perent constructor
		if (parent::__construct($config))
		{
			// set temp directory
			$comConfig			= JFactory::getConfig();
			$this->tempPath			= $comConfig->get('tmp_path');
			// set some folder paths in relation to distribution
			if ($config['addBackup'])
			{
				$this->backupPath		= $this->params->get('backup_folder_path', $this->tempPath).'/'.$this->componentBackupName.'.zip';
				$this->dynamicIntegration	= true;
			}
			if ($config['addGit'])
			{
				$this->gitPath		= $this->params->get('git_folder_path', null);
			}
			// remove site folder if not needed (TODO add check if custom script was moved to site folder then we must do a more complex cleanup here)
			if ($this->removeSiteFolder)
			{
				// first remove the files and folders
				$this->removeFolder($this->componentPath . '/site');
				// clear form component xml
				$xmlPath = $this->componentPath . '/'. $this->fileContentStatic['###component###']. '.xml';
				$componentXML = JFile::read($xmlPath);
				$textToSite = ComponentbuilderHelper::getBetween($componentXML,'<files folder="site">','</files>');
				$textToSiteLang = ComponentbuilderHelper::getBetween($componentXML,'<languages folder="site">','</languages>');
				$componentXML = str_replace(array('<files folder="site">'.$textToSite."</files>", '<languages folder="site">'.$textToSiteLang."</languages>"), array('',''), $componentXML);
				$this->writeFile($xmlPath,$componentXML);
			}
			// now update the files
			if (!$this->updateFiles())
			{
				return false;
			}
			// we can remove all undeeded data
			$this->freeMemory();
			// check if this component is install on the current website
			if ($paths = $this->getLocalInstallPaths())
			{
				// start Automatic import of custom code
				$userId = JFactory::getUser()->id;
				$today = JFactory::getDate()->toSql();
				// Get a db connection.
				$db = JFactory::getDbo();
				// get the custom code from installed files
				$this->customCodeFactory($paths, $db, $userId, $today);
			}
			// check if we have custom code to add
			$this->getCustomCode();
			// now insert into the new files
			if (ComponentbuilderHelper::checkArray($this->customCode))
			{
				$this->addCustomCode();
			}
			// move the update server into place
			$this->setUpdateServer();
			// zip the component
			if (!$this->zipComponent())
			{
				// done
				return false;
			}
			return true;
		}
		return false;
	}
	
	/**
	 * Set the line number in comments
	 * 
	 * @param   int   $nr  The line number
	 * 
	 * @return  void
	 * 
	 */
	private function setLine($nr)
	{
		if ($this->loadLineNr)
		{
			return ' [Compiler '.$nr.']';	
		}
		return '';
	}
	
	/**
	 * Set the dynamic data to the created fils
	 * 
	 * @return  bool true on success
	 * 
	 */
	protected function updateFiles()
	{
		if (isset($this->newFiles['static']) && ComponentbuilderHelper::checkArray($this->newFiles['static']) && isset($this->newFiles['dynamic']) && ComponentbuilderHelper::checkArray($this->newFiles['dynamic']))
		{
			// get the bom file
			$bom = JFile::read($this->bomPath);
			// first we do the static files
			foreach ($this->newFiles['static'] as $static)
			{
				if (JFile::exists($static['path']))
				{
					$this->fileContentStatic['###FILENAME###'] = $static['name'];
					$php = '';
					if (ComponentbuilderHelper::checkFileType($static['name'],'php'))
					{
						$php = "<?php\n";
					}
					$string = JFile::read($static['path']);
					if (strpos($string,'###BOM###') !== false)
					{
						list($wast,$code) = explode('###BOM###',$string);
						$answer = str_replace(array_keys($this->fileContentStatic),array_values($this->fileContentStatic),$php.$bom.$code);
						// add to zip array
						$this->writeFile($static['path'],$answer);
					}
					else
					{
						$answer = str_replace(array_keys($this->fileContentStatic),array_values($this->fileContentStatic),$string);
						// add to zip array
						$this->writeFile($static['path'],$answer);
					}
					$this->lineCount = $this->lineCount + substr_count($answer, PHP_EOL );
				}
			}
			// now we do the dynamic files
			foreach ($this->newFiles['dynamic'] as $view => $files)
			{
				if (isset($this->fileContentDynamic[$view]) && ComponentbuilderHelper::checkArray($this->fileContentDynamic[$view]))
				{
					foreach ($files as $file)
					{
						if ($file['view'] == $view)
						{
							if (JFile::exists($file['path']))
							{
								$this->fileContentStatic['###FILENAME###'] = $file['name'];
								// do some weird stuff to improve the verion and dates being added to the license
								$this->fixLicenseValues($file);
								$php = '';
								if (ComponentbuilderHelper::checkFileType($file['name'],'php'))
								{
									$php = "<?php\n";
								}
								$string = JFile::read($file['path']);
								if (strpos($string,'###BOM###') !== false)
								{
									list($bin,$code) = explode('###BOM###',$string);
									$answer = str_replace(array_keys($this->fileContentStatic),array_values($this->fileContentStatic),$php.$bom.$code);
									$answer = str_replace(array_keys($this->fileContentDynamic[$view]),array_values($this->fileContentDynamic[$view]),$answer);
									// add to zip array
									$this->writeFile($file['path'],$answer);
								}
								else
								{
									$answer = str_replace(array_keys($this->fileContentStatic),array_values($this->fileContentStatic),$string);
									$answer = str_replace(array_keys($this->fileContentDynamic[$view]),array_values($this->fileContentDynamic[$view]),$answer);
									// add to zip array
									$this->writeFile($file['path'],$answer);
								}
								$this->lineCount = $this->lineCount + substr_count($answer, PHP_EOL );
							}
						}
					}
				}
				// free up some memory
				unset($this->fileContentDynamic[$view]);
			}
			// free up some memory
			unset($this->newFiles['dynamic']);
			// do a final run to update the readme file
			$two = 0;
			foreach ($this->newFiles['static'] as $static)
			{
				if (('README.md' == $static['name'] || 'README.txt' == $static['name']) && $this->componentData->addreadme && JFile::exists($static['path']))
				{
					$this->buildReadMe($static['path']);
					$two++;
				}
				if ($two == 2)
				{
					break;
				}
			}
			return true;
		}
		return false;
	}
	
	protected function freeMemory()
	{		
		// free up some memory
		unset($this->newFiles['static']);
		unset($this->customScriptBuilder);
		unset($this->permissionCore);
		unset($this->permissionDashboard);
		unset($this->componentData->admin_views);
		unset($this->componentData->site_views);
		unset($this->componentData->custom_admin_views);
		unset($this->componentData->config);
		unset($this->joomlaVersionData);
		unset($this->langContent);
		unset($this->dbKeys);
		unset($this->permissionBuilder);
		unset($this->layoutBuilder);
		unset($this->historyBuilder);
		unset($this->aliasBuilder);
		unset($this->titleBuilder);
		unset($this->customBuilderList);
		unset($this->hiddenFieldsBuilder);
		unset($this->intFieldsBuilder);
		unset($this->dynamicfieldsBuilder);
		unset($this->maintextBuilder);
		unset($this->customFieldLinksBuilder);
		unset($this->setScriptUserSwitch);
		unset($this->categoryBuilder);
		unset($this->catCodeBuilder);
		unset($this->checkboxBuilder);
		unset($this->jsonItemBuilder);
		unset($this->base64Builder);
		unset($this->basicEncryptionBuilder);
		unset($this->advancedEncryptionBuilder);
		unset($this->getItemsMethodListStringFixBuilder);
		unset($this->getItemsMethodEximportStringFixBuilder);
		unset($this->selectionTranslationFixBuilder);
		unset($this->listBuilder);
		unset($this->customBuilder);
		unset($this->editBodyViewScriptBuilder);
		unset($this->queryBuilder);
		unset($this->sortBuilder);
		unset($this->searchBuilder);
		unset($this->filterBuilder);
		unset($this->fieldsNames);
		unset($this->siteFields);
		unset($this->siteFieldData);
		unset($this->customFieldScript);
		unset($this->configFieldSets);
		unset($this->jsonStringBuilder);
		unset($this->importCustomScripts);
		unset($this->eximportView);
		unset($this->uninstallBuilder);
		unset($this->listColnrBuilder);
		unset($this->customFieldBuilder);
		unset($this->permissionFields);
		unset($this->getAsLookup);
		unset($this->secondRunAdmin);
		unset($this->uninstallScriptBuilder);
		unset($this->buildCategories);
		unset($this->iconBuilder);
		unset($this->validationFixBuilder);
		unset($this->targetRelationControl);
		unset($this->targetControlsScriptChecker);
		unset($this->accessBuilder);
		unset($this->tabCounter);
		unset($this->linkedAdminViews);
		unset($this->uniquekeys);
		unset($this->uniquecodes);
		$this->unsetNow('_adminViewData');
		$this->unsetNow('_fieldData');
	}
	
	/**
	 * move the local update server xml file to a remote ftp server
	 * 
	 * @return  void
	 * 
	 */
	protected function setUpdateServer()
	{
		// move the update server to host
		if ($this->componentData->add_update_server && $this->componentData->update_server_target == 1 && isset($this->updateServerFileName) && $this->dynamicIntegration)
		{
			$xml_update_server_path = $this->componentPath.'/'.$this->updateServerFileName.'.xml';
			// make sure we have the correct file
			if (JFile::exists($xml_update_server_path) && isset($this->componentData->update_server_ftp))
			{
				// Get the basic encription.
				$basickey = ComponentbuilderHelper::getCryptKey('basic');
				// Get the encription object.
				$basic = new FOFEncryptAes($basickey, 128);
				if (!empty($this->componentData->update_server_ftp) && $basickey && !is_numeric($this->componentData->update_server_ftp) && $this->componentData->update_server_ftp === base64_encode(base64_decode($this->componentData->update_server_ftp, true)))
				{
					// basic decript data update_server_ftp.
					$this->componentData->update_server_ftp = rtrim($basic->decryptString($this->componentData->update_server_ftp), "\0");
				}
				// now move the file
				$this->moveFileToFtpServer($xml_update_server_path,$this->componentData->update_server_ftp);
			}
		}
	}

	// link canges made to views into the file license
	protected function fixLicenseValues($data)
	{
		// check if these files have its own config data
		if (isset($data['config']) && ComponentbuilderHelper::checkArray($data['config']))
		{
			foreach ($data['config'] as $key => $value)
			{
				if ('###VERSION###' == $key)
				{
					// hmm we sould in some way make it known that this version number
					// is not in relation the the project but to the file only... any ideas?
					// this is the best for now...
					if (1 == $value)
					{
						$value = '@first version of this MVC';
					}
					else
					{
						$value = '@update number '.$value.' of this MVC';
					}
				}
				$this->fileContentStatic[$key] = $value;
			}
			return true;
		}
		// else insure to reset to global
		$this->fileContentStatic['###CREATIONDATE###'] = $this->fileContentStatic['###CREATIONDATE###GLOBAL'];
		$this->fileContentStatic['###BUILDDATE###'] = $this->fileContentStatic['###BUILDDATE###GLOBAL'];
		$this->fileContentStatic['###VERSION###'] = $this->fileContentStatic['###VERSION###GLOBAL'];
	}
	
	private function buildReadMe($path)
	{
		// set readme data if not set already
		if (!isset($this->fileContentStatic['###LINE_COUNT###']) || $this->fileContentStatic['###LINE_COUNT###'] != $this->lineCount)
		{
			$this->buildReadMeData();
		}
		// get the file
		$string = JFile::read($path);
		// update the file
		$answer = str_replace(array_keys($this->fileContentStatic),array_values($this->fileContentStatic),$string);
		// add to zip array
		$this->writeFile($path,$answer);
	}	
	
	private function buildReadMeData()
	{
		// setup the unrealistic numbers
		$folders	= $this->folderCount * 5;
		$files		= $this->fileCount * 5;
		$lines		= $this->lineCount * 10;
		$seconds	= $folders + $files + $lines;
		$totalHours	= round($seconds / 3600);
		$totalDays	= round($totalHours / 8);
		// setup the more realistic numbers
		$debugging		= $seconds / 4;
		$planning		= $seconds / 7;
		$mapping		= $seconds / 10;
		$office			= $seconds / 6;
		$seconds		= $folders + $files + $lines + $debugging + $planning + $mapping + $office;
		$actualTotalHours	= round($seconds / 3600);
		$actualTotalDays	= round($actualTotalHours / 8);
		$debuggingHours		= round($debugging / 3600);
		$planningHours		= round($planning / 3600);
		$mappingHours		= round($mapping / 3600);
		$officeHours		= round($office / 3600);
		// the actual time spent
		$actualHoursSpent = $actualTotalHours - $totalHours;
		$actualDaysSpent = $actualTotalDays - $totalDays;
		// calculate the projects actual time frame of completion
		$projectWeekTime = round($actualTotalDays / 5,1);
		$projectMonthTime = round($actualTotalDays / 24,1);
		// set some defaults
		$this->fileContentStatic['###LINE_COUNT###'] = $this->lineCount;
		$this->fileContentStatic['###FILE_COUNT###'] = $this->fileCount;
		$this->fileContentStatic['###FOLDER_COUNT###'] = $this->folderCount;
		$this->fileContentStatic['###folders###'] = $folders;
		$this->fileContentStatic['###files###'] = $files;
		$this->fileContentStatic['###lines###'] = $lines;
		$this->fileContentStatic['###seconds###'] = $seconds;
		$this->fileContentStatic['###totalHours###'] = $totalHours;
		$this->fileContentStatic['###totalDays###'] = $totalDays;
		$this->fileContentStatic['###debugging###'] = $debugging;
		$this->fileContentStatic['###planning###'] = $planning;
		$this->fileContentStatic['###mapping###'] = $mapping;
		$this->fileContentStatic['###office###'] = $office;
		$this->fileContentStatic['###actualTotalHours###'] = $actualTotalHours;
		$this->fileContentStatic['###actualTotalDays###'] = $actualTotalDays;
		$this->fileContentStatic['###debuggingHours###'] = $debuggingHours;
		$this->fileContentStatic['###planningHours###'] = $planningHours;
		$this->fileContentStatic['###mappingHours###'] = $mappingHours;
		$this->fileContentStatic['###officeHours###'] = $officeHours;
		$this->fileContentStatic['###actualHoursSpent###'] = $actualHoursSpent;
		$this->fileContentStatic['###actualDaysSpent###'] = $actualDaysSpent;
		$this->fileContentStatic['###projectWeekTime###'] = $projectWeekTime;
		$this->fileContentStatic['###projectMonthTime###'] = $projectMonthTime;
	}

	private function zipComponent()
	{
		// before we zip the component we first need to move it to the git folder if set
		if (ComponentbuilderHelper::checkString($this->gitPath))
		{
			// set the git path
			$this->gitPath = $this->gitPath.'/com_'.$this->componentData->sales_name.'__joomla_'.$this->joomlaVersion;
			// remove old data
			$this->removeFolder($this->gitPath,true);
			// set the new data
			JFolder::copy($this->componentPath, $this->gitPath, '', true);
		}
		// the name of the zip file to create
		$this->filepath = $this->tempPath.'/'.$this->componentFolderName.'.zip';
		// store the current joomla working directory
		$joomla = getcwd();

		// we are changing the working directory to the componet temp folder
		chdir($this->componentPath);

		// the full file path of the zip file
		$this->filepath = JPath::clean($this->filepath);

		// delete an existing zip file (or use an exclusion parameter in JFolder::files()
		JFile::delete($this->filepath);

		// get a list of files in the current directory tree
		$files = JFolder::files('.', '', true, true);
		$zipArray = array();
		// setup the zip array
		foreach ($files as $file)
		{
		   $tmp = array();
		   $tmp['name'] = str_replace('./', '', $file);
		   $tmp['data'] = JFile::read($file);
		   $tmp['time'] = filemtime($file);
		   $zipArray[] = $tmp;
		}

		// change back to joomla working directory
		chdir($joomla);

		// get the zip adapter
		$zip = JArchive::getAdapter('zip');

		//create the zip file
		if ($zip->create($this->filepath, $zipArray))
		{
			// now move to backup if zip was made and backup is requered
			if ($this->backupPath && $this->dynamicIntegration)
			{
				JFile::copy($this->filepath, $this->backupPath);
			}
			// move to sales server host
			if ($this->componentData->add_sales_server && $this->dynamicIntegration)
			{
				// make sure we have the correct file
				if (isset($this->componentData->sales_server_ftp))
				{
					// Get the basic encription.
					$basickey = ComponentbuilderHelper::getCryptKey('basic');
					// Get the encription object.
					$basic = new FOFEncryptAes($basickey, 128);
					if (!empty($this->componentData->sales_server_ftp) && $basickey && !is_numeric($this->componentData->sales_server_ftp) && $this->componentData->sales_server_ftp === base64_encode(base64_decode($this->componentData->sales_server_ftp, true)))
					{
						// basic decript data update_server_ftp.
						$this->componentData->sales_server_ftp = rtrim($basic->decryptString($this->componentData->sales_server_ftp), "\0");
					}
					// now move the file
					$this->moveFileToFtpServer($this->filepath, $this->componentData->sales_server_ftp, $this->componentSalesName.'.zip',false);
				}
			}
			// remove the component folder since we are done
			if ($this->removeFolder($this->componentPath))
			{
				return true;
			}
		}
		return false;
	}
	
	private function moveFileToFtpServer($localPath, $clientInput, $remote = null, $removeLocal = true)
	{
		// get the ftp opbject
		$ftp = $this->getFTP($clientInput);
		// chack if we are conected
		if ($ftp instanceof JClientFtp && $ftp->isConnected())
		{
			// move the file
			if ($ftp->store($localPath,$remote))
			{
				// if moved then remove the file from repository
				if ($removeLocal)
				{
					JFile::delete($localPath);
				}
			}
			// at the end close the conection
			$ftp->quit();
		}
	}
	
	private function getFTP($clientInput)
	{
		$signature = md5($clientInput);
		if (isset($this->FTP[$signature]) && $this->FTP[$signature] instanceof JClientFtp)
		{
			return $this->FTP[$signature];
		}
		else
		{
			// make sure we have a string and it is not default or empty
			if (ComponentbuilderHelper::checkString($clientInput))
			{
				// turn into vars
				parse_str($clientInput);
				// set options
				if (isset($options) && ComponentbuilderHelper::checkArray($options))
				{
					foreach ($options as $option => $value)
					{
						if ('timeout' == $option)
						{
							$options[$option] = (int) $value;
						}
						if ('type' == $option)
						{
							$options[$option] = (string) $value;
						}
					}
				}
				else
				{
					$options = array();
				}
				// get ftp object
				if (isset($host) && $host != 'HOSTNAME' && isset($port) && $port != 'PORT_INT' && isset($username) && $username != 'user@name.com' && isset($password) && $password != 'password')
				{
					// load for reuse
					$this->FTP[$signature] = JClientFtp::getInstance($host, $port, $options, $username, $password);
					return $this->FTP[$signature];
				}
			}
		}
		return false;
	}
	
	protected function addCustomCode()
	{
		foreach($this->customCode as $nr => $target)
		{
			// reset each time per custom code
			$fingerPrint = array();
			if (isset($target['hashtarget'][0]) && $target['hashtarget'][0] > 3 
				&& isset($target['path']) && ComponentbuilderHelper::checkString($target['path'])
				&& isset($target['hashtarget'][1]) && ComponentbuilderHelper::checkString($target['hashtarget'][1]))
			{
				$file		= $this->componentPath . '/'. $target['path'];
				$size		= (int) $target['hashtarget'][0];
				$hash		= $target['hashtarget'][1];
				$cut		= $size - 1;
				$found		= false;
				$bites		= 0;
				$replace	= array();
				if ($target['type'] == 1 && isset($target['hashendtarget'][0]) && $target['hashendtarget'][0] > 0)
				{
					$foundEnd	= false;
					$sizeEnd	= (int) $target['hashendtarget'][0];
					$hashEnd	= $target['hashendtarget'][1];
					$cutEnd		= $sizeEnd - 1;
				}
				else
				{
					// replace to the end of the file
					$foundEnd	= true;
				}
				$counter	= 0;
				// check if file is new structure			
				if (JFile::exists($file))
				{
					foreach (new SplFileObject($file) as $lineNumber => $lineContent)
					{
						if (!$found)
						{
							$bites = (int) bcadd(mb_strlen($lineContent, '8bit'), $bites);
						}
						if ($found && !$foundEnd)
						{
							$replace[] = (int) mb_strlen($lineContent, '8bit');
							// we musk keep last three lines to dynamic find target entry
							$fingerPrint[$lineNumber] = trim($lineContent);
							// check lines each time if it fits our target
							if (count($fingerPrint) === $sizeEnd && !$foundEnd)
							{
								$fingerTest = md5(implode('',$fingerPrint));
								if ($fingerTest === $hashEnd)
								{
									// we are done here
									$foundEnd = true;
									$replace = array_slice($replace, 0, count($replace)-$sizeEnd);
									break;
								}
								else
								{
									$fingerPrint = array_slice($fingerPrint, -$cutEnd, $cutEnd, true);
								}
							}
						}
						if ($found && $foundEnd)
						{
							$replace[] = (int) mb_strlen($lineContent, '8bit');
						}
						// we musk keep last three lines to dynamic find target entry
						$fingerPrint[$lineNumber] = trim($lineContent);
						// check lines each time if it fits our target
						if (count($fingerPrint) === $size && !$found)
						{
							$fingerTest = md5(implode('',$fingerPrint));
							if ($fingerTest === $hash)
							{
								// we are done here
								$found = true;
								// reset in case
								$fingerPrint = array();
								// break if it is insertion
								if ($target['type'] == 2)
								{
									break;
								}
							}
							else
							{
								$fingerPrint = array_slice($fingerPrint, -$cut, $cut, true);
							}
						}
					}
					if ($found)
					{
						$placeholder	= $this->getPlaceHolder($target['type'], $target['id']);
						$data		= $placeholder['start'] . "\n" . $target['code'] . $placeholder['end'] . "\n";
						if ($target['type'] == 2)
						{
							// found it now add code from the next line
							$this->addDataToFile($file, $data, $bites);
						}
						elseif ($target['type'] == 1 && $foundEnd)
						{
							// found it now add code from the next line
							$this->addDataToFile($file, $data, $bites, (int) array_sum($replace));
						}
						else
						{
							// TODO give developer a notice that the code could not be added and needs his attention.
						}
					}
					else
					{
						// TODO give developer a notice that the code could not be added and needs his attention.
					}
				}
				else
				{
					// TODO give developer a notice that the code could not be added and needs his attention.
				}
			}
		}
	}

	// Thanks to http://stackoverflow.com/a/16813550/1429677
	protected function addDataToFile($file, $data, $position, $replace = null)
	{
		$fpFile = fopen($file, "rw+");
		$fpTemp = fopen('php://temp', "rw+");

		$len = stream_copy_to_stream($fpFile, $fpTemp); // make a copy

		fseek($fpFile, $position); // move to the position
		if ($replace)
		{
			$position = bcadd($position, $replace);
		}
		fseek($fpTemp, $position); // move to the position

		fwrite($fpFile, $data); // Add the data

		stream_copy_to_stream($fpTemp, $fpFile); // @Jack

		fclose($fpFile); // close file
		fclose($fpTemp); // close tmp
	}
}
