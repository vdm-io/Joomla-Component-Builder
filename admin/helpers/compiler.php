<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <http://www.joomlacomponentbuilder.com>
 * @github     Joomla Component Builder <https://github.com/vdm-io/Joomla-Component-Builder>
 * @copyright  Copyright (C) 2015 - 2018 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

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
			if ($config['backup'])
			{
				$this->backupPath = $this->params->get('backup_folder_path', $this->tempPath) . '/' . $this->componentBackupName . '.zip';
				$this->dynamicIntegration = true;
			}
			if ($config['repository'])
			{
				$this->repoPath = $this->params->get('git_folder_path', null);
			}
			// remove site folder if not needed (TODO add check if custom script was moved to site folder then we must do a more complex cleanup here)
			if ($this->removeSiteFolder)
			{
				// first remove the files and folders
				$this->removeFolder($this->componentPath . '/site');
				// clear form component xml
				$xmlPath = $this->componentPath . '/' . $this->fileContentStatic[$this->hhh . 'component' . $this->hhh] . '.xml';
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
						$this->app->enqueueMessage(JText::sprintf('The <b>Joomla.JText._(&apos;%s&apos;)</b> language constant for <b>%s</b> does not have a corresponding <code>JText::script(&apos;%s&apos;)</code> decalaration, please add it.', $constant, $string, $string), 'Warning');
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
				$this->app->enqueueMessage(JText::_('<hr /><h3>External Code Notice</h3>'), 'Notice');
				$this->app->enqueueMessage(JText::sprintf('There has been <b>%s - %s</b> added to this component as EXTERNALCODE. To avoid shipping your component with malicious %s always make sure that the correct <b>code/string values</b> were used.', $externalCount, $externalCodeString, $externalCodeString), 'Notice');
				$this->app->enqueueMessage('<hr />', 'Notice');
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
					$this->setFileContent($static['name'], $static['path'], $bom);
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
								$this->setFileContent($file['name'], $file['path'], $bom, $file['view']);
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
	 * set the file content
	 *
	 * @return  void
	 *
	 */
	protected function setFileContent(&$name, &$path, &$bom, $view = null)
	{
		// set the file name
		$this->fileContentStatic[$this->hhh . 'FILENAME' . $this->hhh] = $name;
		// check if the file should get PHP opening
		$php = '';
		if (ComponentbuilderHelper::checkFileType($name, 'php'))
		{
			$php = "<?php\n";
		}
		// get content of the file
		$string = ComponentbuilderHelper::getFileContents($path);
		// see if we should add a BOM
		if (strpos($string, $this->hhh . 'BOM' . $this->hhh) !== false)
		{
			list($wast, $code) = explode($this->hhh . 'BOM' . $this->hhh, $string);
			$string = $php . $bom . $code;
		}
		// set the answer
		$answer = $this->setPlaceholders($string, $this->fileContentStatic, 3);
		// set the dynamic answer
		if ($view)
		{
			$answer = $this->setPlaceholders($answer, $this->fileContentDynamic[$view], 3);
		}
		// add answer back to file
		$this->writeFile($path, $answer);
		// count the file lines
		$this->lineCount = $this->lineCount + substr_count($answer, PHP_EOL);
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
				// move to server
				ComponentbuilderHelper::moveToServer($xml_update_server_path, $this->updateServerFileName . '.xml', (int) $this->componentData->update_server, $this->componentData->update_server_protocol);
				// remove the local file
				JFile::delete($xml_update_server_path);
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
				if ($this->hhh . 'VERSION' . $this->hhh === $key)
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
		$this->fileContentStatic[$this->hhh . 'CREATIONDATE' . $this->hhh] = $this->fileContentStatic[$this->hhh . 'CREATIONDATE' . $this->hhh . 'GLOBAL'];
		$this->fileContentStatic[$this->hhh . 'BUILDDATE' . $this->hhh] = $this->fileContentStatic[$this->hhh . 'BUILDDATE' . $this->hhh . 'GLOBAL'];
		$this->fileContentStatic[$this->hhh . 'VERSION' . $this->hhh] = $this->fileContentStatic[$this->hhh . 'VERSION' . $this->hhh . 'GLOBAL'];
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
		if (!isset($this->fileContentStatic[$this->hhh . 'LINE_COUNT' . $this->hhh]) || $this->fileContentStatic[$this->hhh . 'LINE_COUNT' . $this->hhh] != $this->lineCount)
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
		$this->fileContentStatic[$this->hhh . 'LINE_COUNT' . $this->hhh] = $this->lineCount;
		$this->fileContentStatic[$this->hhh . 'FIELD_COUNT' . $this->hhh] = $this->fieldCount;
		$this->fileContentStatic[$this->hhh . 'FILE_COUNT' . $this->hhh] = $this->fileCount;
		$this->fileContentStatic[$this->hhh . 'FOLDER_COUNT' . $this->hhh] = $this->folderCount;
		$this->fileContentStatic[$this->hhh . 'PAGE_COUNT' . $this->hhh] = $this->pageCount;
		$this->fileContentStatic[$this->hhh . 'folders' . $this->hhh] = $this->folderSeconds;
		$this->fileContentStatic[$this->hhh . 'foldersSeconds' . $this->hhh] = $this->folderSeconds;
		$this->fileContentStatic[$this->hhh . 'files' . $this->hhh] = $this->fileSeconds;
		$this->fileContentStatic[$this->hhh . 'filesSeconds' . $this->hhh] = $this->fileSeconds;
		$this->fileContentStatic[$this->hhh . 'lines' . $this->hhh] = $this->lineSeconds;
		$this->fileContentStatic[$this->hhh . 'linesSeconds' . $this->hhh] = $this->lineSeconds;
		$this->fileContentStatic[$this->hhh . 'seconds' . $this->hhh] = $this->actualSeconds;
		$this->fileContentStatic[$this->hhh . 'actualSeconds' . $this->hhh] = $this->actualSeconds;
		$this->fileContentStatic[$this->hhh . 'totalHours' . $this->hhh] = $this->totalHours;
		$this->fileContentStatic[$this->hhh . 'totalDays' . $this->hhh] = $this->totalDays;
		$this->fileContentStatic[$this->hhh . 'debugging' . $this->hhh] = $this->secondsDebugging;
		$this->fileContentStatic[$this->hhh . 'secondsDebugging' . $this->hhh] = $this->secondsDebugging;
		$this->fileContentStatic[$this->hhh . 'planning' . $this->hhh] = $this->secondsPlanning;
		$this->fileContentStatic[$this->hhh . 'secondsPlanning' . $this->hhh] = $this->secondsPlanning;
		$this->fileContentStatic[$this->hhh . 'mapping' . $this->hhh] = $this->secondsMapping;
		$this->fileContentStatic[$this->hhh . 'secondsMapping' . $this->hhh] = $this->secondsMapping;
		$this->fileContentStatic[$this->hhh . 'office' . $this->hhh] = $this->secondsOffice;
		$this->fileContentStatic[$this->hhh . 'secondsOffice' . $this->hhh] = $this->secondsOffice;
		$this->fileContentStatic[$this->hhh . 'actualTotalHours' . $this->hhh] = $this->actualTotalHours;
		$this->fileContentStatic[$this->hhh . 'actualTotalDays' . $this->hhh] = $this->actualTotalDays;
		$this->fileContentStatic[$this->hhh . 'debuggingHours' . $this->hhh] = $this->debuggingHours;
		$this->fileContentStatic[$this->hhh . 'planningHours' . $this->hhh] = $this->planningHours;
		$this->fileContentStatic[$this->hhh . 'mappingHours' . $this->hhh] = $this->mappingHours;
		$this->fileContentStatic[$this->hhh . 'officeHours' . $this->hhh] = $this->officeHours;
		$this->fileContentStatic[$this->hhh . 'actualHoursSpent' . $this->hhh] = $this->actualHoursSpent;
		$this->fileContentStatic[$this->hhh . 'actualDaysSpent' . $this->hhh] = $this->actualDaysSpent;
		$this->fileContentStatic[$this->hhh . 'projectWeekTime' . $this->hhh] = $this->projectWeekTime;
		$this->fileContentStatic[$this->hhh . 'projectMonthTime' . $this->hhh] = $this->projectMonthTime;
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
					// move to server
					ComponentbuilderHelper::moveToServer($this->filepath, $this->componentSalesName . '.zip', (int) $this->componentData->sales_server, $this->componentData->sales_server_protocol);
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
							$bites = (int) $this->bcmath('add', $lineBites[$lineNumber], $bites);
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
		$remove = $this->bcmath('add', $position, mb_strlen($data, '8bit'));
		ftruncate($fpFile, $remove);
		// check if this was a replacement of data
		if ($replace)
		{
			$position = $this->bcmath('add', $position, $replace);
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
