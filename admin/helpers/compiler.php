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

	@version			2.3.0
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
	
	/*
	 * The timer
	 * 
	 * @var      string
	 */
	private $time_start;
	private $time_end;
	public  $secondsCompiled;
	
	public $filepath		= '';
	// fixed pathes
	protected $dynamicIntegration	= false;
	protected $backupPath		= false;
	protected $gitPath		= false;
	protected $addCustomCodeAt	= array();

	/**
	 * Constructor
	 */
	public function __construct($config = array ())
	{
		// to check the compiler speed
		$this->time_start = microtime(true);
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
			// now insert into the new files
			if ($this->getCustomCode())
			{				
				$this->addCustomCode();
			}
			// set the lang data now
			$this->setLangFileData();
			// move the update server into place
			$this->setUpdateServer();
			// set the global counters
			$this->setCountingStuff();
			// build read me
			$this->buildReadMe();
			// zip the component
			if (!$this->zipComponent())
			{
				// done with error
				return false;
			}
			// end the timer here
			$this->time_end = microtime(true);
			$this->secondsCompiled = $this->time_end - $this->time_start;
			// completed the compilation
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
			// we don't update lang now since we will still posible add custom code
			$langCheck = 'en-GB.com_'.$this->fileContentStatic['###component###'].'.';
			// get the bom file
			$bom = JFile::read($this->bomPath);
			// first we do the static files
			foreach ($this->newFiles['static'] as $static)
			{
				if (JFile::exists($static['path']))
				{
					// skip lang files and store for later
					if (strpos($static['path'], $langCheck))
					{
						$this->langFiles[] = $static;
						continue;
					}
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
						$string = $php.$bom.$code;
						$answer = $this->setPlaceholders($string, $this->fileContentStatic, 3);
						// add to zip array
						$this->writeFile($static['path'],$answer);
					}
					else
					{
						$answer = $this->setPlaceholders($string, $this->fileContentStatic, 3);
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
									$string = $php.$bom.$code;
									$answer = $this->setPlaceholders($string, $this->fileContentStatic, 3);
									$answer = $this->setPlaceholders($answer, $this->fileContentDynamic[$view], 3);
									// add to zip array
									$this->writeFile($file['path'],$answer);
								}
								else
								{
									$answer = $this->setPlaceholders($string, $this->fileContentStatic, 3);
									$answer = $this->setPlaceholders($answer, $this->fileContentDynamic[$view], 3);
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
			return true;
		}
		return false;
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
		// check if these files have its own config data)
		if (isset($data['config']) && ComponentbuilderHelper::checkArray($data['config']) && (!isset($this->componentData->mvc_versiondate) || $this->componentData->mvc_versiondate == 1))
		{
			foreach ($data['config'] as $key => $value)
			{
				if ('###VERSION###' === $key)
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

	// set all global numbers
	protected function setCountingStuff()
	{
		// what is the size in terms of an A4 book
		$this->pageCount		= round($this->lineCount / 56);
		// setup the unrealistic numbers
		$this->folderSeconds		= $this->folderCount * 5;
		$this->fileSeconds		= $this->fileCount * 5;
		$this->lineSeconds		= $this->lineCount * 10;
		$this->seconds			= $this->folderSeconds + $this->fileSeconds + $this->lineSeconds;
		$this->totalHours		= round($this->seconds / 3600);
		$this->totalDays		= round($this->totalHours / 8);
		// setup the more realistic numbers
		$this->secondsDebugging		= $this->seconds / 4;
		$this->secondsPlanning		= $this->seconds / 7;
		$this->secondsMapping		= $this->seconds / 10;
		$this->secondsOffice		= $this->seconds / 6;
		$this->actualSeconds		= $this->folderSeconds + $this->fileSeconds + $this->lineSeconds + $this->secondsDebugging + $this->secondsPlanning + $this->secondsMapping + $this->secondsOffice;
		$this->actualTotalHours		= round($this->actualSeconds / 3600);
		$this->actualTotalDays		= round($this->actualTotalHours / 8);
		$this->debuggingHours		= round($this->secondsDebugging / 3600);
		$this->planningHours		= round($this->secondsPlanning / 3600);
		$this->mappingHours		= round($this->secondsMapping / 3600);
		$this->officeHours		= round($this->secondsOffice / 3600);
		// the actual time spent
		$this->actualHoursSpent		= $this->actualTotalHours - $this->totalHours;
		$this->actualDaysSpent		= $this->actualTotalDays - $this->totalDays;
		// calculate the projects actual time frame of completion
		$this->projectWeekTime		= round($this->actualTotalDays / 5,1);
		$this->projectMonthTime		= round($this->actualTotalDays / 24,1);		
	}
	
	private function buildReadMe()
	{
		// do a final run to update the readme file
		$two = 0;
		foreach ($this->newFiles['static'] as $static)
		{
			if (('README.md' === $static['name'] || 'README.txt' === $static['name']) && $this->componentData->addreadme && JFile::exists($static['path']))
			{
				$this->setReadMe($static['path']);
				$two++;
			}
			if ($two == 2)
			{
				break;
			}
		}
		unset($this->newFiles['static']);
	}
	
	private function setReadMe($path)
	{
		// set readme data if not set already
		if (!isset($this->fileContentStatic['###LINE_COUNT###']) || $this->fileContentStatic['###LINE_COUNT###'] != $this->lineCount)
		{
			$this->buildReadMeData();
		}
		// get the file
		$string = JFile::read($path);
		// update the file
		$answer = $this->setPlaceholders($string, $this->fileContentStatic);
		// add to zip array
		$this->writeFile($path,$answer);
	}	
	
	private function buildReadMeData()
	{
		// set some defaults
		$this->fileContentStatic['###LINE_COUNT###']		= $this->lineCount;
		$this->fileContentStatic['###FILE_COUNT###']		= $this->fileCount;
		$this->fileContentStatic['###FOLDER_COUNT###']		= $this->folderCount;
		$this->fileContentStatic['###PAGE_COUNT###']		= $this->pageCount;
		$this->fileContentStatic['###folders###']		= $this->folderSeconds;
		$this->fileContentStatic['###foldersSeconds###']	= $this->folderSeconds;
		$this->fileContentStatic['###files###']			= $this->fileSeconds;
		$this->fileContentStatic['###filesSeconds###']		= $this->fileSeconds;
		$this->fileContentStatic['###lines###']			= $this->lineSeconds;
		$this->fileContentStatic['###linesSeconds###']		= $this->lineSeconds;
		$this->fileContentStatic['###seconds###']		= $this->actualSeconds;
		$this->fileContentStatic['###actualSeconds###']		= $this->actualSeconds;
		$this->fileContentStatic['###totalHours###']		= $this->totalHours;
		$this->fileContentStatic['###totalDays###']		= $this->totalDays;
		$this->fileContentStatic['###debugging###']		= $this->secondsDebugging;
		$this->fileContentStatic['###secondsDebugging###']	= $this->secondsDebugging;
		$this->fileContentStatic['###planning###']		= $this->secondsPlanning;
		$this->fileContentStatic['###secondsPlanning###']	= $this->secondsPlanning;
		$this->fileContentStatic['###mapping###']		= $this->secondsMapping;
		$this->fileContentStatic['###secondsMapping###']	= $this->secondsMapping;
		$this->fileContentStatic['###office###']		= $this->secondsOffice;
		$this->fileContentStatic['###secondsOffice###']		= $this->secondsOffice;
		$this->fileContentStatic['###actualTotalHours###']	= $this->actualTotalHours;
		$this->fileContentStatic['###actualTotalDays###']	= $this->actualTotalDays;
		$this->fileContentStatic['###debuggingHours###']	= $this->debuggingHours;
		$this->fileContentStatic['###planningHours###']		= $this->planningHours;
		$this->fileContentStatic['###mappingHours###']		= $this->mappingHours;
		$this->fileContentStatic['###officeHours###']		= $this->officeHours;
		$this->fileContentStatic['###actualHoursSpent###']	= $this->actualHoursSpent;
		$this->fileContentStatic['###actualDaysSpent###']	= $this->actualDaysSpent;
		$this->fileContentStatic['###projectWeekTime###']	= $this->projectWeekTime;
		$this->fileContentStatic['###projectMonthTime###']	= $this->projectMonthTime;
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
						if ('timeout' === $option)
						{
							$options[$option] = (int) $value;
						}
						if ('type' === $option)
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
		// load error messages incase code can not be added
		$app = JFactory::getApplication();
		// reset all these
		$this->clearFromPlaceHolders('view');
		$this->clearFromPlaceHolders('arg');
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
				$lineBites	= array();
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
				// check if file exist			
				if (JFile::exists($file))
				{
					foreach (new SplFileObject($file) as $lineNumber => $lineContent)
					{
						// if not found we need to load line bites per line
						$lineBites[$lineNumber] = (int) mb_strlen($lineContent, '8bit');
						if (!$found)
						{
							$bites = (int) bcadd($lineBites[$lineNumber], $bites);
						}
						if ($found && !$foundEnd)
						{
							$replace[] = (int) $lineBites[$lineNumber];
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
							continue;
						}
						if ($found && $foundEnd)
						{
							$replace[] = (int) $lineBites[$lineNumber];
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
						$placeholder	= $this->getPlaceHolder((int) $target['comment_type'].$target['type'], $target['id']);
						$data		= $placeholder['start'] . PHP_EOL . $this->setPlaceholders($target['code'], $this->placeholders). $placeholder['end'] . PHP_EOL;
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
							// Load escaped code since the target endhash has changed
							$this->loadEscapedCode($file, $target, $lineBites);
							$app->enqueueMessage(JText::sprintf('Custom code could not be added to <b>%s</b> please review the file at <b>line %s</b>. This could be due to a change to lines below the custom code.', $target['path'], $target['from_line']), 'warning');
						}
					}
					else
					{
						// Load escaped code since the target hash has changed
						$this->loadEscapedCode($file, $target, $lineBites);
						$app->enqueueMessage(JText::sprintf('Custom code could not be added to <b>%s</b> please review the file at <b>line %s</b>. This could be due to a change to lines above the custom code.', $target['path'], $target['from_line']), 'warning');
					}
				}
				else
				{
					// Give developer a notice that file is not found.
					$app->enqueueMessage(JText::sprintf('File <b>%s</b> could not be found, so the custom code for this file could not be addded.', $target['path']), 'warning');
				}
			}
		}
	}

	protected function loadEscapedCode($file, $target, $lineBites)
	{
		// escape the code
		$code = explode(PHP_EOL, $target['code']);
		$code = PHP_EOL."// " .implode(PHP_EOL."// ",$code). PHP_EOL;
		// get place holders
		$placeholder	= $this->getPlaceHolder((int) $target['comment_type'].$target['type'], $target['id']);
		// build the data
		$data		= $placeholder['start'] . $code . $placeholder['end']. PHP_EOL;
		// get the bites before insertion
		$bitBucket	= array();
		foreach($lineBites as $line => $value)
		{
			if ($line < $target['from_line'])
			{
				$bitBucket[] = $value;
			}
		}
		// add to the file
		$this->addDataToFile($file, $data, (int) array_sum($bitBucket));
	}

	// Thanks to http://stackoverflow.com/a/16813550/1429677
	protected function addDataToFile($file, $data, $position, $replace = null)
	{
		// start the process
		$fpFile = fopen($file, "rw+");
		$fpTemp = fopen('php://temp', "rw+");
		// make a copy of the file
		stream_copy_to_stream($fpFile, $fpTemp);
		// move to the position where we should add the data
		fseek($fpFile, $position);
		// Add the data
		fwrite($fpFile, $data);
		// truncate file at the end of the data that was added
		$remove = bcadd($position, mb_strlen($data, '8bit'));
		ftruncate($fpFile, $remove);
		// check if this was a replacement of data
		if ($replace)
		{
			$position = bcadd($position, $replace);
		}
		// move to the position of the data that should remain below the new data
		fseek($fpTemp, $position);
		// copy that remaining data to the file
		stream_copy_to_stream($fpTemp, $fpFile); // @Jack
		// done close both files
		fclose($fpFile);
		fclose($fpTemp);
		
		// any help to improve this is welcome...
	}
}
