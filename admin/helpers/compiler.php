<?php

/* --------------------------------------------------------------------------------------------------------|  www.vdm.io  |------/
  __      __       _     _____                 _                                  _     __  __      _   _               _
  \ \    / /      | |   |  __ \               | |                                | |   |  \/  |    | | | |             | |
   \ \  / /_ _ ___| |_  | |  | | _____   _____| | ___  _ __  _ __ ___   ___ _ __ | |_  | \  / | ___| |_| |__   ___   __| |
    \ \/ / _` / __| __| | |  | |/ _ \ \ / / _ \ |/ _ \| '_ \| '_ ` _ \ / _ \ '_ \| __| | |\/| |/ _ \ __| '_ \ / _ \ / _` |
     \  / (_| \__ \ |_  | |__| |  __/\ V /  __/ | (_) | |_) | | | | | |  __/ | | | |_  | |  | |  __/ |_| | | | (_) | (_| |
      \/ \__,_|___/\__| |_____/ \___| \_/ \___|_|\___/| .__/|_| |_| |_|\___|_| |_|\__| |_|  |_|\___|\__|_| |_|\___/ \__,_|
                                                      | |
                                                      |_|
  /-------------------------------------------------------------------------------------------------------------------------------/

  @version		2.6.x
  @created		30th April, 2015
  @package		Component Builder
  @subpackage	compiler.php
  @author		Llewellyn van der Merwe <http://www.vdm.io>
  @my wife		Roline van der Merwe <http://www.vdm.io/>
  @copyright	Copyright (C) 2015. All Rights Reserved
  @license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html

  Builds Complex Joomla Components

  /----------------------------------------------------------------------------------------------------------------------------- */

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
	public $secondsCompiled;
	public $filepath = '';
	// fixed pathes
	protected $dynamicIntegration = false;
	protected $backupPath = false;
	protected $repoPath = false;
	protected $addCustomCodeAt = array();

	/**
	 * Constructor
	 */
	public function __construct($config = array())
	{
		// to check the compiler speed
		$this->time_start = microtime(true);
		// first we run the perent constructors
		if (parent::__construct($config))
		{
			// set temp directory
			$comConfig = JFactory::getConfig();
			$this->tempPath = $comConfig->get('tmp_path');
			// set some folder paths in relation to distribution
			if ($config['addBackup'])
			{
				$this->backupPath = $this->params->get('backup_folder_path', $this->tempPath) . '/' . $this->componentBackupName . '.zip';
				$this->dynamicIntegration = true;
			}
			if ($config['addRepo'])
			{
				$this->repoPath = $this->params->get('git_folder_path', null);
			}
			// remove site folder if not needed (TODO add check if custom script was moved to site folder then we must do a more complex cleanup here)
			if ($this->removeSiteFolder)
			{
				// first remove the files and folders
				$this->removeFolder($this->componentPath . '/site');
				// clear form component xml
				$xmlPath = $this->componentPath . '/' . $this->fileContentStatic['###component###'] . '.xml';
				$componentXML = ComponentbuilderHelper::getFileContents($xmlPath);
				$textToSite = ComponentbuilderHelper::getBetween($componentXML, '<files folder="site">', '</files>');
				$textToSiteLang = ComponentbuilderHelper::getBetween($componentXML, '<languages folder="site">', '</languages>');
				$componentXML = str_replace(array('<files folder="site">' . $textToSite . "</files>", '<languages folder="site">' . $textToSiteLang . "</languages>"), array('', ''), $componentXML);
				$this->writeFile($xmlPath, $componentXML);
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
			// set the language notice if it was set
			if (ComponentbuilderHelper::checkArray($this->langNot) || ComponentbuilderHelper::checkArray($this->langSet))
			{
				if (ComponentbuilderHelper::checkArray($this->langNot))
				{
					foreach ($this->langNot as $tag => $percentage)
					{
						$this->app->enqueueMessage(JText::sprintf('The <b>%s</b> language has %s&#37; translated, you will need to translate %s&#37; of the language strings before it will be added.', $tag, $percentage, $this->percentageLanguageAdd), 'Warning');
					}
					$this->app->enqueueMessage(JText::sprintf('<b>You can change this percentage of translated strings required in the global options of JCB.</b><br />Please watch this <a href=%s>tutorial for more help surrounding the JCB translations manager</a>.', '"https://youtu.be/zzAcVkn_cWU?list=PLQRGFI8XZ_wtGvPQZWBfDzzlERLQgpMRE" target="_blank" title="JCB Tutorial surrounding Translation Manager"'), 'Notice');
				}
				// set why the strings were added
				$whyAddedLang = JText::sprintf('because more then %s&#37; of the strings have been translated.', $this->percentageLanguageAdd);
				if ($this->debugLinenr)
				{
					$whyAddedLang = JText::_('because the debugging mode is on. (debug line numbers)');
				}
				// show languages that were added
				if (ComponentbuilderHelper::checkArray($this->langSet))
				{
					foreach ($this->langSet as $tag => $percentage)
					{
						$this->app->enqueueMessage(JText::sprintf('The <b>%s</b> language has %s&#37; translated. Was addeded %s', $tag, $percentage, $whyAddedLang), 'Notice');
					}
				}
			}
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
			// do lang mismatch check
			if (ComponentbuilderHelper::checkArray($this->langMismatch))
			{
				if (ComponentbuilderHelper::checkArray($this->langMatch))
				{
					$mismatch = array_diff(array_unique($this->langMismatch), array_unique($this->langMatch));
				}
				else
				{
					$mismatch = array_unique($this->langMismatch);
				}
				// set a notice if we have a mismatch
				if (isset($mismatch) && ComponentbuilderHelper::checkArray($mismatch))
				{
					if (count($mismatch) > 1)
					{
						$this->app->enqueueMessage(JText::_('<h3>Please check the following mismatching Joomla.JText language constants.</h3>'), 'Warning');
					}
					else
					{
						$this->app->enqueueMessage(JText::_('<h3>Please check the following mismatch Joomla.JText language constant.</h3>'), 'Warning');
					}
					// add the mismatching issues
					foreach ($mismatch as $string)
					{
						$constant = $this->langPrefix . '_' . ComponentbuilderHelper::safeString($string, 'U');
						$this->app->enqueueMessage(JText::sprintf('The <b>Joomla.JText._(\'%s\')</b> language constant for (%s) does not have a corresponding JText::Script() decalaration.', $constant, $string), 'Warning');
					}
					$this->app->enqueueMessage('<hr />', 'Warning');
				}
			}
			// check if we should add a EXTERNALCODE notice
			if (ComponentbuilderHelper::checkArray($this->externalCodeString))
			{
				// number of external code strings
				$externalCount = count($this->externalCodeString);
				// the correct string
				$externalCodeString = ($externalCount == 1) ? JText::_('code/string') : JText::_('code/strings');
				// the notice
				$this->app->enqueueMessage(JText::sprintf('There has been <b>%s - %s</b> added to this component as EXTERNALCODE. To avoid shipping your component with malicious %s always make sure that the correct <b>code/string values</b> were used.', $externalCount, $externalCodeString, $externalCodeString), 'Notice');
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
		if ($this->debugLinenr)
		{
			return ' [Compiler ' . $nr . ']';
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
			$bom = ComponentbuilderHelper::getFileContents($this->bomPath);
			// first we do the static files
			foreach ($this->newFiles['static'] as $static)
			{
				if (JFile::exists($static['path']))
				{
					$this->fileContentStatic['###FILENAME###'] = $static['name'];
					$php = '';
					if (ComponentbuilderHelper::checkFileType($static['name'], 'php'))
					{
						$php = "<?php\n";
					}
					$string = ComponentbuilderHelper::getFileContents($static['path']);
					if (strpos($string, '###BOM###') !== false)
					{
						list($wast, $code) = explode('###BOM###', $string);
						$string = $php . $bom . $code;
						$answer = $this->setPlaceholders($string, $this->fileContentStatic, 3);
						// add to zip array
						$this->writeFile($static['path'], $answer);
					}
					else
					{
						$answer = $this->setPlaceholders($string, $this->fileContentStatic, 3);
						// add to zip array
						$this->writeFile($static['path'], $answer);
					}
					$this->lineCount = $this->lineCount + substr_count($answer, PHP_EOL);
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
								if (ComponentbuilderHelper::checkFileType($file['name'], 'php'))
								{
									$php = "<?php\n";
								}
								$string = ComponentbuilderHelper::getFileContents($file['path']);
								if (strpos($string, '###BOM###') !== false)
								{
									list($bin, $code) = explode('###BOM###', $string);
									$string = $php . $bom . $code;
									$answer = $this->setPlaceholders($string, $this->fileContentStatic, 3);
									$answer = $this->setPlaceholders($answer, $this->fileContentDynamic[$view], 3);
									// add to zip array
									$this->writeFile($file['path'], $answer);
								}
								else
								{
									$answer = $this->setPlaceholders($string, $this->fileContentStatic, 3);
									$answer = $this->setPlaceholders($answer, $this->fileContentDynamic[$view], 3);
									// add to zip array
									$this->writeFile($file['path'], $answer);
								}
								$this->lineCount = $this->lineCount + substr_count($answer, PHP_EOL);
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
		if ($this->componentData->add_update_server == 1 && $this->componentData->update_server_target == 1 && isset($this->updateServerFileName) && $this->dynamicIntegration)
		{
			$xml_update_server_path = $this->componentPath . '/' . $this->updateServerFileName . '.xml';
			// make sure we have the correct file
			if (JFile::exists($xml_update_server_path) && isset($this->componentData->update_server))
			{
				// use FTP
				if ($this->componentData->update_server_protocol == 1)
				{
					// Get the basic encription.
					$basickey = ComponentbuilderHelper::getCryptKey('basic');
					// Get the encription object.
					$basic = new FOFEncryptAes($basickey, 128);
					if (!empty($this->componentData->update_server) && $basickey && !is_numeric($this->componentData->update_server) && $this->componentData->update_server === base64_encode(base64_decode($this->componentData->update_server, true)))
					{
						// basic decript data update_server.
						$this->componentData->update_server = rtrim($basic->decryptString($this->componentData->update_server), "\0");
					}
					// now move the file
					$this->moveFileToFtpServer($xml_update_server_path, $this->componentData->update_server);
				}
				// use SFTP
				elseif ($this->componentData->update_server_protocol == 2)
				{
					if ($sftp = ComponentbuilderHelper::getSftp((int) $this->componentData->update_server))
					{
						// now move the file
						if (!$sftp->put($sftp->remote_server_path . $this->updateServerFileName . '.xml', ComponentbuilderHelper::getFileContents($xml_update_server_path, null)))
						{
							$this->app->enqueueMessage(JText::sprintf('The <b>%s</b> file could not be moved to <b>%s</b> path on <b>%s</b> server.', $this->updateServerFileName . '.xml', $sftp->remote_server_path, $sftp->remote_server_name), 'Error');
						}
						// remove the local file
						JFile::delete($xml_update_server_path);
					}
				}
			}
		}
	}

	// link canges made to views into the file license
	protected function fixLicenseValues($data)
	{
		// check if these files have its own config data)
		if (isset($data['config']) && ComponentbuilderHelper::checkArray($data['config']) && $this->componentData->mvc_versiondate == 1)
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
						$value = '@update number ' . $value . ' of this MVC';
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
		$this->pageCount = round($this->lineCount / 56);
		// setup the unrealistic numbers
		$this->folderSeconds = $this->folderCount * 5;
		$this->fileSeconds = $this->fileCount * 5;
		$this->lineSeconds = $this->lineCount * 10;
		$this->seconds = $this->folderSeconds + $this->fileSeconds + $this->lineSeconds;
		$this->totalHours = round($this->seconds / 3600);
		$this->totalDays = round($this->totalHours / 8);
		// setup the more realistic numbers
		$this->secondsDebugging = $this->seconds / 4;
		$this->secondsPlanning = $this->seconds / 7;
		$this->secondsMapping = $this->seconds / 10;
		$this->secondsOffice = $this->seconds / 6;
		$this->actualSeconds = $this->folderSeconds + $this->fileSeconds + $this->lineSeconds + $this->secondsDebugging + $this->secondsPlanning + $this->secondsMapping + $this->secondsOffice;
		$this->actualTotalHours = round($this->actualSeconds / 3600);
		$this->actualTotalDays = round($this->actualTotalHours / 8);
		$this->debuggingHours = round($this->secondsDebugging / 3600);
		$this->planningHours = round($this->secondsPlanning / 3600);
		$this->mappingHours = round($this->secondsMapping / 3600);
		$this->officeHours = round($this->secondsOffice / 3600);
		// the actual time spent
		$this->actualHoursSpent = $this->actualTotalHours - $this->totalHours;
		$this->actualDaysSpent = $this->actualTotalDays - $this->totalDays;
		// calculate the projects actual time frame of completion
		$this->projectWeekTime = round($this->actualTotalDays / 5, 1);
		$this->projectMonthTime = round($this->actualTotalDays / 24, 1);
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
		$string = ComponentbuilderHelper::getFileContents($path);
		// update the file
		$answer = $this->setPlaceholders($string, $this->fileContentStatic);
		// add to zip array
		$this->writeFile($path, $answer);
	}

	private function buildReadMeData()
	{
		// set some defaults
		$this->fileContentStatic['###LINE_COUNT###'] = $this->lineCount;
		$this->fileContentStatic['###FIELD_COUNT###'] = $this->fieldCount;
		$this->fileContentStatic['###FILE_COUNT###'] = $this->fileCount;
		$this->fileContentStatic['###FOLDER_COUNT###'] = $this->folderCount;
		$this->fileContentStatic['###PAGE_COUNT###'] = $this->pageCount;
		$this->fileContentStatic['###folders###'] = $this->folderSeconds;
		$this->fileContentStatic['###foldersSeconds###'] = $this->folderSeconds;
		$this->fileContentStatic['###files###'] = $this->fileSeconds;
		$this->fileContentStatic['###filesSeconds###'] = $this->fileSeconds;
		$this->fileContentStatic['###lines###'] = $this->lineSeconds;
		$this->fileContentStatic['###linesSeconds###'] = $this->lineSeconds;
		$this->fileContentStatic['###seconds###'] = $this->actualSeconds;
		$this->fileContentStatic['###actualSeconds###'] = $this->actualSeconds;
		$this->fileContentStatic['###totalHours###'] = $this->totalHours;
		$this->fileContentStatic['###totalDays###'] = $this->totalDays;
		$this->fileContentStatic['###debugging###'] = $this->secondsDebugging;
		$this->fileContentStatic['###secondsDebugging###'] = $this->secondsDebugging;
		$this->fileContentStatic['###planning###'] = $this->secondsPlanning;
		$this->fileContentStatic['###secondsPlanning###'] = $this->secondsPlanning;
		$this->fileContentStatic['###mapping###'] = $this->secondsMapping;
		$this->fileContentStatic['###secondsMapping###'] = $this->secondsMapping;
		$this->fileContentStatic['###office###'] = $this->secondsOffice;
		$this->fileContentStatic['###secondsOffice###'] = $this->secondsOffice;
		$this->fileContentStatic['###actualTotalHours###'] = $this->actualTotalHours;
		$this->fileContentStatic['###actualTotalDays###'] = $this->actualTotalDays;
		$this->fileContentStatic['###debuggingHours###'] = $this->debuggingHours;
		$this->fileContentStatic['###planningHours###'] = $this->planningHours;
		$this->fileContentStatic['###mappingHours###'] = $this->mappingHours;
		$this->fileContentStatic['###officeHours###'] = $this->officeHours;
		$this->fileContentStatic['###actualHoursSpent###'] = $this->actualHoursSpent;
		$this->fileContentStatic['###actualDaysSpent###'] = $this->actualDaysSpent;
		$this->fileContentStatic['###projectWeekTime###'] = $this->projectWeekTime;
		$this->fileContentStatic['###projectMonthTime###'] = $this->projectMonthTime;
	}

	private function zipComponent()
	{
		// before we zip the component we first need to move it to the repo folder if set
		if (ComponentbuilderHelper::checkString($this->repoPath))
		{
			// set the repo path
			$repoFullPath = $this->repoPath . '/com_' . $this->componentData->sales_name . '__joomla_' . $this->joomlaVersion;
			// remove old data
			$this->removeFolder($repoFullPath, $this->componentData->toignore);
			// set the new data
			JFolder::copy($this->componentPath, $repoFullPath, '', true);
		}
		// the name of the zip file to create
		$this->filepath = $this->tempPath . '/' . $this->componentFolderName . '.zip';

		//create the zip file
		if (ComponentbuilderHelper::zip($this->componentPath, $this->filepath))
		{
			// now move to backup if zip was made and backup is requered
			if ($this->backupPath && $this->dynamicIntegration)
			{
				JFile::copy($this->filepath, $this->backupPath);
			}

			// move to sales server host
			if ($this->componentData->add_sales_server == 1 && $this->dynamicIntegration)
			{
				// make sure we have the correct file
				if (isset($this->componentData->sales_server))
				{
					// use FTP
					if ($this->componentData->sales_server_protocol == 1)
					{
						// Get the basic encription.
						$basickey = ComponentbuilderHelper::getCryptKey('basic');
						// Get the encription object.
						$basic = new FOFEncryptAes($basickey, 128);
						if (!empty($this->componentData->sales_server) && $basickey && !is_numeric($this->componentData->sales_server) && $this->componentData->sales_server === base64_encode(base64_decode($this->componentData->sales_server, true)))
						{
							// basic decript data sales_server.
							$this->componentData->sales_server = rtrim($basic->decryptString($this->componentData->sales_server), "\0");
						}
						// now move the file
						$this->moveFileToFtpServer($this->filepath, $this->componentData->sales_server, $this->componentSalesName . '.zip', false);
					}
					// use SFTP
					elseif ($this->componentData->sales_server_protocol == 2)
					{
						if ($sftp = ComponentbuilderHelper::getSftp((int) $this->componentData->sales_server))
						{
							// now move the file
							if (!$sftp->put($sftp->remote_server_path . $this->componentSalesName . '.zip', ComponentbuilderHelper::getFileContents($this->filepath, null)))
							{
								$this->app->enqueueMessage(JText::sprintf('The <b>%s</b> file could not be moved to <b>%s</b> path on <b>%s</b> server.', $this->componentSalesName . '.zip', $sftp->remote_server_path, $sftp->remote_server_name), 'Error');
							}
						}
					}
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
			if ($ftp->store($localPath, $remote))
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
		$s1GnAtnr3 = md5($clientInput);
		if (isset($this->FTP[$s1GnAtnr3]) && $this->FTP[$s1GnAtnr3] instanceof JClientFtp)
		{
			// return the FTP instance
			return $this->FTP[$s1GnAtnr3];
		}
		else
		{
			// make sure we have a string and it is not default or empty
			if (ComponentbuilderHelper::checkString($clientInput))
			{
				// turn into variables
				parse_str($clientInput); // because of this I am using strand variable naming to avoid any collisions.
				// set options
				if (isset($options) && ComponentbuilderHelper::checkArray($options))
				{
					foreach ($options as $o__p0t1on => $vAln3)
					{
						if ('timeout' === $o__p0t1on)
						{
							$options[$o__p0t1on] = (int) $vAln3;
						}
						if ('type' === $o__p0t1on)
						{
							$options[$o__p0t1on] = (string) $vAln3;
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
					$this->FTP[$s1GnAtnr3] = JClientFtp::getInstance($host, $port, $options, $username, $password);
					// return the FTP instance
					return $this->FTP[$s1GnAtnr3];
				}
			}
		}
		return false;
	}

	protected function addCustomCode()
	{
		// reset all these
		$this->clearFromPlaceHolders('view');
		$this->clearFromPlaceHolders('arg');
		foreach ($this->customCode as $nr => $target)
		{
			// reset each time per custom code
			$fingerPrint = array();
			if (isset($target['hashtarget'][0]) && $target['hashtarget'][0] > 3 && isset($target['path']) && ComponentbuilderHelper::checkString($target['path']) && isset($target['hashtarget'][1]) && ComponentbuilderHelper::checkString($target['hashtarget'][1]))
			{
				$file = $this->componentPath . '/' . $target['path'];
				$size = (int) $target['hashtarget'][0];
				$hash = $target['hashtarget'][1];
				$cut = $size - 1;
				$found = false;
				$bites = 0;
				$lineBites = array();
				$replace = array();
				if ($target['type'] == 1 && isset($target['hashendtarget'][0]) && $target['hashendtarget'][0] > 0)
				{
					$foundEnd = false;
					$sizeEnd = (int) $target['hashendtarget'][0];
					$hashEnd = $target['hashendtarget'][1];
					$cutEnd = $sizeEnd - 1;
				}
				else
				{
					// replace to the end of the file
					$foundEnd = true;
				}
				$counter = 0;
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
								$fingerTest = md5(implode('', $fingerPrint));
								if ($fingerTest === $hashEnd)
								{
									// we are done here
									$foundEnd = true;
									$replace = array_slice($replace, 0, count($replace) - $sizeEnd);
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
							$fingerTest = md5(implode('', $fingerPrint));
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
						$placeholder = $this->getPlaceHolder((int) $target['comment_type'] . $target['type'], $target['id']);
						$data = $placeholder['start'] . PHP_EOL . $this->setPlaceholders($target['code'], $this->placeholders) . $placeholder['end'] . PHP_EOL;
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
							$this->app->enqueueMessage(JText::sprintf('Custom code could not be added to <b>%s</b> please review the file at <b>line %s</b>. This could be due to a change to lines below the custom code.', $target['path'], $target['from_line']), 'Warning');
						}
					}
					else
					{
						// Load escaped code since the target hash has changed
						$this->loadEscapedCode($file, $target, $lineBites);
						$this->app->enqueueMessage(JText::sprintf('Custom code could not be added to <b>%s</b> please review the file at <b>line %s</b>. This could be due to a change to lines above the custom code.', $target['path'], $target['from_line']), 'Warning');
					}
				}
				else
				{
					// Give developer a notice that file is not found.
					$this->app->enqueueMessage(JText::sprintf('File <b>%s</b> could not be found, so the custom code for this file could not be addded.', $target['path']), 'Warning');
				}
			}
		}
	}

	protected function loadEscapedCode($file, $target, $lineBites)
	{
		// get comment type
		if ($target['comment_type'] == 1)
		{
			$commentType = "// ";
			$_commentType = "";
		}
		else
		{
			$commentType = "<!--";
			$_commentType = " -->";
		}
		// escape the code
		$code = explode(PHP_EOL, $target['code']);
		$code = PHP_EOL . $commentType . implode($_commentType . PHP_EOL . $commentType, $code) . $_commentType . PHP_EOL;
		// get place holders
		$placeholder = $this->getPlaceHolder((int) $target['comment_type'] . $target['type'], $target['id']);
		// build the data
		$data = $placeholder['start'] . $code . $placeholder['end'] . PHP_EOL;
		// get the bites before insertion
		$bitBucket = array();
		foreach ($lineBites as $line => $value)
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
