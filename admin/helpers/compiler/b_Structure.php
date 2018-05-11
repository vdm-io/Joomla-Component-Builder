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

  @version		2.7.x
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

/**
 * Structure class
 */
class Structure extends Get
{

	/**
	 * The foulder counter
	 * 
	 * @var     int
	 */
	public $folderCount = 0;

	/**
	 * The foulder counter
	 * 
	 * @var     int
	 */
	public $fileCount = 0;

	/**
	 * The page counter
	 * 
	 * @var     int
	 */
	public $pageCount = 0;

	/**
	 * The line counter
	 * 
	 * @var     int
	 */
	public $lineCount = 0;

	/**
	 * The field counter
	 * 
	 * @var     int
	 */
	public $fieldCount = 0;

	/**
	 * The seconds counter
	 * 
	 * @var     int
	 */
	public $seconds = 0;

	/**
	 * The actual seconds counter
	 * 
	 * @var     int
	 */
	public $actualSeconds = 0;

	/**
	 * The folder seconds counter
	 * 
	 * @var     int
	 */
	public $folderSeconds = 0;

	/**
	 * The file seconds counter
	 * 
	 * @var     int
	 */
	public $fileSeconds = 0;

	/**
	 * The line seconds counter
	 * 
	 * @var     int
	 */
	public $lineSeconds = 0;

	/**
	 * The seconds debugging counter
	 * 
	 * @var     int
	 */
	public $secondsDebugging = 0;

	/**
	 * The seconds planning counter
	 * 
	 * @var     int
	 */
	public $secondsPlanning = 0;

	/**
	 * The seconds mapping counter
	 * 
	 * @var     int
	 */
	public $secondsMapping = 0;

	/**
	 * The seconds office counter
	 * 
	 * @var     int
	 */
	public $secondsOffice = 0;

	/**
	 * The total hours counter
	 * 
	 * @var     int
	 */
	public $totalHours = 0;

	/**
	 * The debugging hours counter
	 * 
	 * @var     int
	 */
	public $debuggingHours = 0;

	/**
	 * The planning hours counter
	 * 
	 * @var     int
	 */
	public $planningHours = 0;

	/**
	 * The mapping hours counter
	 * 
	 * @var     int
	 */
	public $mappingHours = 0;

	/**
	 * The office hours counter
	 * 
	 * @var     int
	 */
	public $officeHours = 0;

	/**
	 * The actual Total Hours counter
	 * 
	 * @var     int
	 */
	public $actualTotalHours = 0;

	/**
	 * The actual hours spent counter
	 * 
	 * @var     int
	 */
	public $actualHoursSpent = 0;

	/**
	 * The actual days spent counter
	 * 
	 * @var     int
	 */
	public $actualDaysSpent = 0;

	/**
	 * The total days counter
	 * 
	 * @var     int
	 */
	public $totalDays = 0;

	/**
	 * The actual Total Days counter
	 * 
	 * @var     int
	 */
	public $actualTotalDays = 0;

	/**
	 * The project week time counter
	 * 
	 * @var     int
	 */
	public $projectWeekTime = 0;

	/**
	 * The project month time counter
	 * 
	 * @var     int
	 */
	public $projectMonthTime = 0;

	/**
	 * The Joomla Version
	 * 
	 * @var     string
	 */
	public $joomlaVersion;

	/**
	 * The template path
	 * 
	 * @var     string
	 */
	public $templatePath;

	/**
	 * The custom template path
	 * 
	 * @var     string
	 */
	public $templatePathCustom;

	/**
	 * The Joomla Version Data
	 * 
	 * @var      object
	 */
	public $joomlaVersionData;

	/**
	 * Static File Content
	 * 
	 * @var      array
	 */
	public $fileContentStatic = array();

	/**
	 * Dynamic File Content
	 * 
	 * @var      array
	 */
	public $fileContentDynamic = array();

	/**
	 * The Component Sales name
	 * 
	 * @var      string
	 */
	public $componentSalesName;

	/**
	 * The Component Backup name
	 * 
	 * @var      string
	 */
	public $componentBackupName;

	/**
	 * The Component Folder name
	 * 
	 * @var      string
	 */
	public $componentFolderName;

	/**
	 * The Component path
	 * 
	 * @var      string
	 */
	public $componentPath;

	/**
	 * The not new static items
	 * 
	 * @var      array
	 */
	public $notNew = array();

	/**
	 * The new files
	 * 
	 * @var     array
	 */
	public $newFiles = array();

	/**
	 * The Checkin Switch
	 * 
	 * @var     boolean
	 */
	public $addCheckin = false;

	/**
	 * The Move Folders Switch
	 * 
	 * @var     boolean
	 */
	public $setMoveFolders = false;

	/**
	 * The array of last modified dates
	 * 
	 * @var     array
	 */
	protected $lastModifiedDate = array();

	/**
	 * The default view switch
	 * 
	 * @var     bool/string
	 */
	public $dynamicDashboard = false;

	/**
	 * Constructor
	 */
	public function __construct($config = array())
	{
		// first we run the perent constructor
		if (parent::__construct($config))
		{
			// run global updater
			ComponentbuilderHelper::runGlobalUpdater();
			// set the Joomla version
			$this->joomlaVersion = $config['version'];
			// set the template path
			$this->templatePath = $this->compilerPath . '/joomla_' . $config['version'];
			// set some default names
			$this->componentSalesName = 'com_' . $this->componentData->sales_name . '__J' . $this->joomlaVersion;
			$this->componentBackupName = 'com_' . $this->componentData->sales_name . '_v' . str_replace('.', '_', $this->componentData->component_version) . '__J' . $this->joomlaVersion;
			$this->componentFolderName = 'com_' . $this->componentData->name_code . '_v' . str_replace('.', '_', $this->componentData->component_version) . '__J' . $this->joomlaVersion;

			// set component folder path
			$this->componentPath = $this->compilerPath . '/' . $this->componentFolderName;
			// set the template path for custom
			$this->templatePathCustom = $this->params->get('custom_folder_path', JPATH_COMPONENT_ADMINISTRATOR . '/custom');
			// make sure there is no old build
			$this->removeFolder($this->componentPath);
			// load the libraries files/folders and url's
			$this->setLibaries();
			// set the Joomla Version Data
			$this->joomlaVersionData = $this->setJoomlaVersionData();
			// set the dashboard
			$this->setDynamicDashboard();
			// set the new folders
			if (!$this->setFolders())
			{
				return false;
			}
			// set all static folders and files
			if (!$this->setStatic())
			{
				return false;
			}
			// set all the dynamic folders and files
			if (!$this->setDynamique())
			{
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
		if ($this->debugLinenr)
		{
			return ' [Structure ' . $nr . ']';
		}
		return '';
	}

	/**
	 * Build the Libraries files, folders, url's and config
	 * 
	 * @return  void
	 * 
	 */
	private function setLibaries()
	{
		if (ComponentbuilderHelper::checkArray($this->libraries))
		{
			// creat the main component folder
			if (!JFolder::exists($this->componentPath))
			{
				JFolder::create($this->componentPath);
				// count the folder created
				$this->folderCount++;
				$this->indexHTML('');
			}
			// create media path if not set
			if (!JFolder::exists($this->componentPath . '/media'))
			{
				JFolder::create($this->componentPath . '/media');
				// count the folder created
				$this->folderCount++;
				$this->indexHTML('/media');
			}
			foreach ($this->libraries as $id => &$library)
			{
				if (ComponentbuilderHelper::checkObject($library))
				{
					// check if this lib has files
					if (isset($library->files) && ComponentbuilderHelper::checkArray($library->files))
					{
						// add to component files
						foreach ($library->files as $file)
						{
							$this->componentData->files[] = $file;
						}
					}
					// check if this lib has folders
					if (isset($library->folders) && ComponentbuilderHelper::checkArray($library->folders))
					{
						// add to component folders
						foreach ($library->folders as $folder)
						{
							$this->componentData->folders[] = $folder;
						}
					}
					// check if this lib has urls
					if (isset($library->urls) && ComponentbuilderHelper::checkArray($library->urls))
					{
						// build media folder path
						$libFolder = strtolower(preg_replace('/\s+/', '-', ComponentbuilderHelper::safeString($library->name, 'filename', ' ', false)));
						$mediaPath = '/media/' . $libFolder;
						// should we add the local folder
						$addLocalFolder = false;
						// add to component urls
						foreach ($library->urls as $n => &$url)
						{
							if (isset($url['type']) && $url['type'] > 1 && isset($url['url']) && ComponentbuilderHelper::checkString($url['url']))
							{
								// create media/lib path if not set
								if (!JFolder::exists($this->componentPath . $mediaPath))
								{
									JFolder::create($this->componentPath . $mediaPath);
									// count the folder created
									$this->folderCount++;
									$this->indexHTML($mediaPath);
								}
								// add local folder
								$addLocalFolder = true;
								// set file name
								$fileName = basename($url['url']);
								// get the file contents
								$data = ComponentbuilderHelper::getFileContents($url['url']);
								// build sub path
								if (strpos($fileName, '.js') !== false)
								{
									$path = '/js';
								}
								elseif (strpos($fileName, '.css') !== false)
								{
									$path = '/css';
								}
								else
								{
									$path = '';
								}
								// create sub media path if not set
								if (!JFolder::exists($this->componentPath . $mediaPath . $path))
								{
									JFolder::create($this->componentPath . $mediaPath . $path);
									// count the folder created
									$this->folderCount++;
									$this->indexHTML($mediaPath . $path);
								}
								// set the path to library file
								$url['path'] = $mediaPath . $path . '/' . $fileName; // we need this for later
								// set full path
								$path = $this->componentPath . $url['path'];
								// write data to path
								$this->writeFile($path, $data);
								// count the file created
								$this->fileCount++;
							}
						}
						// only add if local
						if ($addLocalFolder)
						{
							// check if we sould add it to the media xml list
							if (!isset($this->fileContentStatic['###EXSTRA_MEDIA_FOLDERS###']))
							{
								$this->fileContentStatic['###EXSTRA_MEDIA_FOLDERS###'] = '';
							}
							$this->fileContentStatic['###EXSTRA_MEDIA_FOLDERS###'] .= PHP_EOL . "\t\t<folder>" . $libFolder . "</folder>";
						}
					}
					// if config fields are found load into component config (avoiding dublicates)
					if (isset($library->how) && $library->how > 1 && isset($library->config) && ComponentbuilderHelper::checkArray($library->config))
					{
						foreach ($library->config as $cofig)
						{
							$found = array_filter($this->componentData->config, function($item) use($cofig)
							{
								return $item['field'] == $cofig['field'];
							});
							// set the config data if not found
							if (!ComponentbuilderHelper::checkArray($found))
							{
								$this->componentData->config[] = $cofig;
							}
						}
					}
				}
			}
		}
	}

	/**
	 * set the dynamic dashboard if set
	 * 
	 * @return  void
	 * 
	 */
	private function setDynamicDashboard()
	{
		// only add the dynamic dashboard if all checks out
		if (isset($this->componentData->dashboard_type) && 2 == $this->componentData->dashboard_type && isset($this->componentData->dashboard) && ComponentbuilderHelper::checkString($this->componentData->dashboard) && strpos($this->componentData->dashboard, '_') !== false)
		{
			// set the default view
			$getter = explode('_', $this->componentData->dashboard);
			if (count($getter) == 2 && is_numeric($getter[1]))
			{
				// the pointers
				$t = ComponentbuilderHelper::safeString($getter[0], 'U');
				$id = (int) $getter[1];
				// the dynamic stuff
				$targets = array('A' => 'admin_views', 'C' => 'custom_admin_views');
				$names = array('A' => 'admin view', 'C' => 'custom admin view');
				$types = array('A' => 'adminview', 'C' => 'customadminview');
				$keys = array('A' => 'name_list', 'C' => 'code');
				// check the target values
				if (isset($targets[$t]) && $id > 0)
				{
					// set the type name
					$type_names = ComponentbuilderHelper::safeString($targets[$t], 'w');
					// set the dynamic dash
					if (isset($this->componentData->{$targets[$t]}) && ComponentbuilderHelper::checkArray($this->componentData->{$targets[$t]}))
					{
						// search the target views
						$dashboard = (array) array_filter($this->componentData->{$targets[$t]}, function($view) use($id, $t, $types)
							{
								if (isset($view[$types[$t]]) && $id == $view[$types[$t]])
								{
									return true;
								}
								return false;
							});
						// check if view was found (this should be true)
						if (count($dashboard) && isset($dashboard[0]['settings']) && isset($dashboard[0]['settings']->{$keys[$t]}))
						{
							$this->dynamicDashboard = ComponentbuilderHelper::safeString($dashboard[0]['settings']->{$keys[$t]});
						}
						else
						{
							// set massage that something is wrong
							$this->app->enqueueMessage(JText::sprintf('The <b>%s</b> (<b>%s</b>) is not available in your component! Please insure to only used %s, for a dynamic dashboard, that are still linked to your component.', $names[$t], $this->componentData->dashboard, $type_names), 'Error');
						}
					}
					else
					{
						// set massage that something is wrong
						$this->app->enqueueMessage(JText::sprintf('The <b>%s</b> (<b>%s</b>) is not available in your component! Please insure to only used %s, for a dynamic dashboard, that are still linked to your component.', $names[$t], $this->componentData->dashboard, $type_names), 'Error');
					}
				}
				else
				{
					// the target value is wrong
					$this->app->enqueueMessage(JText::sprintf('The <b>%s</b> value for the dynamic dashboard is invalid.', $this->componentData->dashboard), 'Error');
				}
			}
			else
			{
				// the target value is wrong
				$this->app->enqueueMessage(JText::sprintf('The <b>%s</b> value for the dynamic dashboard is invalid.', $this->componentData->dashboard), 'Error');
			}
			// if default was changed to dynamic dashboard the remove default tab and methods
			if (ComponentbuilderHelper::checkString($this->dynamicDashboard))
			{
				// dynamic dashboard is used
				$this->componentData->dashboard_tab = '';
				$this->componentData->php_dashboard_methods = '';
			}
		}
	}

	/**
	 * Write data to file
	 * 
	 * @return  bool true on success
	 * 
	 */
	public function writeFile($path, $data)
	{
		return ComponentbuilderHelper::writeFile($path, $data);
	}

	/**
	 * Build the Initial Folders
	 * 
	 * @return  void
	 * 
	 */
	private function setFolders()
	{
		if (ComponentbuilderHelper::checkObject($this->joomlaVersionData->create))
		{
			// creat the main component folder
			if (!JFolder::exists($this->componentPath))
			{
				JFolder::create($this->componentPath);
				// count the folder created
				$this->folderCount++;
				$this->indexHTML('');
			}
			// now build all folders needed for this component
			foreach ($this->joomlaVersionData->create as $main => $folders)
			{
				if (!JFolder::exists($this->componentPath . '/' . $main))
				{
					JFolder::create($this->componentPath . '/' . $main);
					// count the folder created
					$this->folderCount++;
					$this->indexHTML($main);
				}
				if (ComponentbuilderHelper::checkObject($folders))
				{
					foreach ($folders as $sub => $subFolders)
					{
						if (!JFolder::exists($this->componentPath . '/' . $main . '/' . $sub))
						{
							JFolder::create($this->componentPath . '/' . $main . '/' . $sub);
							// count the folder created
							$this->folderCount++;
							$this->indexHTML($main . '/' . $sub);
						}
						if (ComponentbuilderHelper::checkObject($subFolders))
						{
							foreach ($subFolders as $sub_2 => $subFolders_2)
							{
								if (!JFolder::exists($this->componentPath . '/' . $main . '/' . $sub . '/' . $sub_2))
								{
									JFolder::create($this->componentPath . '/' . $main . '/' . $sub . '/' . $sub_2);
									// count the folder created
									$this->folderCount++;
									$this->indexHTML($main . '/' . $sub . '/' . $sub_2);
								}
								if (ComponentbuilderHelper::checkObject($subFolders_2))
								{
									foreach ($subFolders_2 as $sub_3 => $subFolders_3)
									{

										if (!JFolder::exists($this->componentPath . '/' . $main . '/' . $sub . '/' . $sub_2 . '/' . $sub_3))
										{
											JFolder::create($this->componentPath . '/' . $main . '/' . $sub . '/' . $sub_2 . '/' . $sub_3);
											// count the folder created
											$this->folderCount++;
											$this->indexHTML($main . '/' . $sub . '/' . $sub_2 . '/' . $sub_3);
										}
										if (ComponentbuilderHelper::checkObject($subFolders_3))
										{
											foreach ($subFolders_3 as $sub_4 => $subFolders_4)
											{
												if (!JFolder::exists($this->componentPath . '/' . $main . '/' . $sub . '/' . $sub_2 . '/' . $sub_3 . '/' . $sub_4))
												{
													JFolder::create($this->componentPath . '/' . $main . '/' . $sub . '/' . $sub_2 . '/' . $sub_3 . '/' . $sub_4);
													// count the folder created
													$this->folderCount++;
													$this->indexHTML($main . '/' . $sub . '/' . $sub_2 . '/' . $sub_3 . '/' . $sub_4);
												}
												if (ComponentbuilderHelper::checkObject($subFolders_4))
												{
													foreach ($subFolders_4 as $sub_5 => $subFolders_5)
													{
														if (!JFolder::exists($this->componentPath . '/' . $main . '/' . $sub . '/' . $sub_2 . '/' . $sub_3 . '/' . $sub_4 . '/' . $sub_5))
														{
															JFolder::create($this->componentPath . '/' . $main . '/' . $sub . '/' . $sub_2 . '/' . $sub_3 . '/' . $sub_4 . '/' . $sub_5);
															// count the folder created
															$this->folderCount++;
															$this->indexHTML($main . '/' . $sub . '/' . $sub_2 . '/' . $sub_3 . '/' . $sub_4 . '/' . $sub_5);
														}
														if (ComponentbuilderHelper::checkObject($subFolders_5))
														{
															foreach ($subFolders_5 as $sub_6 => $subFolders_6)
															{
																if (!JFolder::exists($this->componentPath . '/' . $main . '/' . $sub . '/' . $sub_2 . '/' . $sub_3 . '/' . $sub_4 . '/' . $sub_5 . '/' . $sub_6))
																{
																	JFolder::create($this->componentPath . '/' . $main . '/' . $sub . '/' . $sub_2 . '/' . $sub_3 . '/' . $sub_4 . '/' . $sub_5 . '/' . $sub_6);
																	// count the folder created
																	$this->folderCount++;
																	$this->indexHTML($main . '/' . $sub . '/' . $sub_2 . '/' . $sub_3 . '/' . $sub_4 . '/' . $sub_5 . '/' . $sub_6);
																}
																if (ComponentbuilderHelper::checkObject($subFolders_6))
																{
																	foreach ($subFolders_6 as $sub_7 => $subFolders_7)
																	{
																		if (!JFolder::exists($this->componentPath . '/' . $main . '/' . $sub . '/' . $sub_2 . '/' . $sub_3 . '/' . $sub_4 . '/' . $sub_5 . '/' . $sub_6 . '/' . $sub_7))
																		{
																			JFolder::create($this->componentPath . '/' . $main . '/' . $sub . '/' . $sub_2 . '/' . $sub_3 . '/' . $sub_4 . '/' . $sub_5 . '/' . $sub_6 . '/' . $sub_7);
																			// count the folder created
																			$this->folderCount++;
																			$this->indexHTML($main . '/' . $sub . '/' . $sub_2 . '/' . $sub_3 . '/' . $sub_4 . '/' . $sub_5 . '/' . $sub_6 . '/' . $sub_7);
																		}
																	}
																}
															}
														}
													}
												}
											}
										}
									}
								}
							}
						}
					}
				}
			}
			return true;
		}
		return false;
	}

	/**
	 * Set the Static File & Folder
	 *  
	 * @return  boolean
	 * 
	 */
	private function setStatic()
	{
		if (ComponentbuilderHelper::checkObject($this->joomlaVersionData->move->static))
		{
			$codeName = ComponentbuilderHelper::safeString($this->componentData->name_code);
			// TODO needs more looking at this must be dynamic actualy
			$this->notNew[] = 'PHPExcel.php';
			$this->notNew[] = 'LICENSE.txt';
			// do license check
			$LICENSE = false;
			$licenseChecker = strtolower($this->componentData->license);
			if (strpos($licenseChecker, 'gnu') !== false && strpos($licenseChecker, 'gpl') !== false)
			{
				$LICENSE = true;
			}
			// do README check
			$README = false;
			// add the README file if needed
			if ($this->componentData->addreadme)
			{
				$README = true;
			}
			// set the standard folders
			$stdFolders = array('site', 'admin', 'media');
			// start moving
			foreach ($this->joomlaVersionData->move->static as $ftem => $details)
			{
				// set item
				$item = $details->naam;
				// do the file renaming
				if ($details->rename)
				{
					if ($details->rename === 'new')
					{
						$new = $details->newName;
					}
					else
					{
						$new = str_replace($details->rename, $codeName, $item);
					}
				}
				else
				{
					$new = $item;
				}
				// if not gnu/gpl license dont add the LICENSE.txt file
				if ($item === 'LICENSE.txt' && !$LICENSE)
				{
					continue;
				}
				// if not needed do not add
				if (($item === 'README.md' || $item === 'README.txt') && !$README)
				{
					continue;
				}
				// set destination path
				$zipPath = str_replace('c0mp0n3nt/', '', $details->path);
				$path = str_replace('c0mp0n3nt/', $this->componentPath . '/', $details->path);
				// set the template folder path
				$templatePath = (isset($details->custom) && $details->custom) ? (($details->custom !== 'full') ? $this->templatePathCustom . '/' : '') : $this->templatePath . '/';
				// set the final paths
				$currentFullPath = str_replace('//', '/', $templatePath . '/' . $item);
				$packageFullPath = str_replace('//', '/', $path . '/' . $new);
				$zipFullPath = str_replace('//', '/', $zipPath . '/' . $new);
				// now move the file
				if ($details->type === 'file')
				{
					if (!JFile::exists($currentFullPath))
					{
						$this->app->enqueueMessage(JText::sprintf('The file path: <b>%s</b> does not exist, and was not added!', $currentFullPath), 'Error');
					}
					else
					{
						// move the file to its place
						JFile::copy($currentFullPath, $packageFullPath);
						// count the file created
						$this->fileCount++;
						// store the new files
						if (!in_array($ftem, $this->notNew))
						{
							$this->newFiles['static'][] = array('path' => $packageFullPath, 'name' => $new, 'zip' => $zipFullPath);
						}
					}
				}
				elseif ($details->type === 'folder')
				{
					if (!JFolder::exists($currentFullPath))
					{
						$this->app->enqueueMessage(JText::sprintf('The folder path: <b>%s</b> does not exist, and was not added!', $currentFullPath), 'Error');
					}
					else
					{
						// move the folder to its place
						JFolder::copy($currentFullPath, $packageFullPath);
						// count the folder created
						$this->folderCount++;
					}
				}
				// check if we should add the dynamic folder moving script to the installer script
				if (!$this->setMoveFolders)
				{
					$checker = explode('/', $zipFullPath);
					// TODO <-- this may not be the best way, will keep an eye on this.
					// We basicly only want to check if a folder is added that is not in the stdFolders array
					if (isset($checker[0]) && ComponentbuilderHelper::checkString($checker[0]) && !in_array($checker[0], $stdFolders))
					{
						// add the setDynamicF0ld3rs() method to the install scipt.php file
						$this->setMoveFolders = true;
						// set message that this was done (will still add a tutorial link later)
						$this->app->enqueueMessage(JText::sprintf('<p><b>Dynamic folder/s were detected.</b><br />A method (setDynamicF0ld3rs) was added to the install <b>script.php</b> of this package to insure that the folder/s are copied into the correct place when this componet is installed!</p>'), 'Notice');
					}
				}
			}
			return true;
		}
		return false;
	}

	/**
	 * Set the Dynamic File & Folder
	 *  
	 * @return  boolean
	 * 
	 */
	private function setDynamique()
	{
		$back = false;
		$front = false;
		if ((isset($this->joomlaVersionData->move->dynamic) && ComponentbuilderHelper::checkObject($this->joomlaVersionData->move->dynamic)) && (isset($this->componentData->admin_views) && ComponentbuilderHelper::checkArray($this->componentData->admin_views)))
		{
			if (!ComponentbuilderHelper::checkString($this->dynamicDashboard))
			{
				// setup dashboard
				$target = array('admin' => $this->componentData->name_code);
				$this->buildDynamique($target, 'dashboard');
			}
			// now the rest of the views
			foreach ($this->componentData->admin_views as $nr => $view)
			{
				if (ComponentbuilderHelper::checkObject($view['settings']))
				{
					$created = $this->getCreatedDate($view);
					$modified = $this->getLastModifiedDate($view);
					if ($view['settings']->name_list != 'null')
					{
						$target = array('admin' => $view['settings']->name_list);
						$config = array('###CREATIONDATE###' => $created, '###BUILDDATE###' => $modified, '###VERSION###' => $view['settings']->version);
						$this->buildDynamique($target, 'list', false, $config);
					}
					if ($view['settings']->name_single != 'null')
					{
						$target = array('admin' => $view['settings']->name_single);
						$config = array('###CREATIONDATE###' => $created, '###BUILDDATE###' => $modified, '###VERSION###' => $view['settings']->version);
						$this->buildDynamique($target, 'single', false, $config);
					}
					if (isset($view['edit_create_site_view']) && $view['edit_create_site_view'])
					{
						// setup the front site edit-view files
						$target = array('site' => $view['settings']->name_single);
						$config = array('###CREATIONDATE###' => $created, '###BUILDDATE###' => $modified, '###VERSION###' => $view['settings']->version);
						$this->buildDynamique($target, 'edit', false, $config);
					}
				}
				// quick set of checkin once
				if (isset($view['checkin']) && $view['checkin'] == 1 && !$this->addCheckin)
				{
					// switch to add checking to config
					$this->addCheckin = true;
				}
			}
			$back = true;
		}
		if ((isset($this->joomlaVersionData->move->dynamic) && ComponentbuilderHelper::checkObject($this->joomlaVersionData->move->dynamic)) && (isset($this->componentData->site_views) && ComponentbuilderHelper::checkArray($this->componentData->site_views)))
		{

			foreach ($this->componentData->site_views as $nr => $view)
			{
				$created = $this->getCreatedDate($view);
				$modified = $this->getLastModifiedDate($view);
				if ($view['settings']->main_get->gettype == 2)
				{
					// set list view
					$target = array('site' => $view['settings']->code);
					$config = array('###CREATIONDATE###' => $created, '###BUILDDATE###' => $modified, '###VERSION###' => $view['settings']->version);
					$this->buildDynamique($target, 'list', false, $config);
				}
				elseif ($view['settings']->main_get->gettype == 1)
				{
					// set single view
					$target = array('site' => $view['settings']->code);
					$config = array('###CREATIONDATE###' => $created, '###BUILDDATE###' => $modified, '###VERSION###' => $view['settings']->version);
					$this->buildDynamique($target, 'single', false, $config);
				}
			}
			$front = true;
		}
		if ((isset($this->joomlaVersionData->move->dynamic) && ComponentbuilderHelper::checkObject($this->joomlaVersionData->move->dynamic)) && (isset($this->componentData->custom_admin_views) && ComponentbuilderHelper::checkArray($this->componentData->custom_admin_views)))
		{
			foreach ($this->componentData->custom_admin_views as $nr => $view)
			{
				$created = $this->getCreatedDate($view);
				$modified = $this->getLastModifiedDate($view);
				if ($view['settings']->main_get->gettype == 2)
				{
					// set list view$view
					$target = array('custom_admin' => $view['settings']->code);
					$config = array('###CREATIONDATE###' => $created, '###BUILDDATE###' => $modified, '###VERSION###' => $view['settings']->version);
					$this->buildDynamique($target, 'list', false, $config);
				}
				elseif ($view['settings']->main_get->gettype == 1)
				{
					// set single view
					$target = array('custom_admin' => $view['settings']->code);
					$config = array('###CREATIONDATE###' => $created, '###BUILDDATE###' => $modified, '###VERSION###' => $view['settings']->version);
					$this->buildDynamique($target, 'single', false, $config);
				}
			}
			$back = true;
		}
		// chekc if we had success
		if ($back || $front)
		{
			return true;
		}
		return false;
	}

	/**
	 * get the created date of the (view)
	 *  
	 * @param   array   $view  The view values
	 * 
	 * @return  string Last Modified Date
	 * 
	 */
	public function getCreatedDate($view)
	{
		if (isset($view['settings']->created) && ComponentbuilderHelper::checkString($view['settings']->created))
		{
			// first set the main date
			$date = strtotime($view['settings']->created);
		}
		else
		{
			// first set the main date
			$date = strtotime("now");
		}
		return JFactory::getDate($date)->format('jS F, Y');
	}

	/**
	 * get the last modified date of a MVC (view)
	 *  
	 * @param   array   $view  The view values
	 * 
	 * @return  string Last Modified Date
	 * 
	 */
	public function getLastModifiedDate($view)
	{
		// first set the main date
		if (isset($view['settings']->modified) && ComponentbuilderHelper::checkString($view['settings']->modified) && '0000-00-00 00:00:00' !== $view['settings']->modified)
		{
			$date = strtotime($view['settings']->modified);
		}
		else
		{
			// use todays date
			$date = strtotime("now");
		}
		// search for the last modified date
		if (isset($view['adminview']))
		{
			$id = $view['adminview'] . 'admin';
			// now check if value has been set
			if (!isset($this->lastModifiedDate[$id]))
			{
				if (isset($view['settings']->fields) && ComponentbuilderHelper::checkArray($view['settings']->fields))
				{
					foreach ($view['settings']->fields as $field)
					{
						if (isset($field['settings']) && ComponentbuilderHelper::checkObject($field['settings']) && isset($field['settings']->modified) && ComponentbuilderHelper::checkString($field['settings']->modified) && '0000-00-00 00:00:00' !== $field['settings']->modified)
						{
							$anotherDate = strtotime($field['settings']->modified);
							if ($anotherDate > $date)
							{
								$date = $anotherDate;
							}
						}
					}
				}
			}
		}
		elseif (isset($view['siteview']))
		{
			$id = $view['siteview'] . 'site';
			// now check if value has been set
			if (!isset($this->lastModifiedDate[$id]))
			{
				if (isset($view['settings']->main_get->modified) && ComponentbuilderHelper::checkString($view['settings']->main_get->modified) && '0000-00-00 00:00:00' !== $view['settings']->main_get->modified)
				{
					$anotherDate = strtotime($view['settings']->main_get->modified);
					if ($anotherDate > $date)
					{
						$date = $anotherDate;
					}
				}
			}
		}
		elseif (isset($view['customadminview']))
		{
			$id = $view['customadminview'] . 'customadmin';
			// now check if value has been set
			if (!isset($this->lastModifiedDate[$id]))
			{
				if (isset($view['settings']->main_get->modified) && ComponentbuilderHelper::checkString($view['settings']->main_get->modified) && '0000-00-00 00:00:00' !== $view['settings']->main_get->modified)
				{
					$anotherDate = strtotime($view['settings']->main_get->modified);
					if ($anotherDate > $date)
					{
						$date = $anotherDate;
					}
				}
			}
		}
		// check if ID was found
		if (!isset($id))
		{
			$id = md5($date);
		}
		// now load the date
		if (!isset($this->lastModifiedDate[$id]))
		{
			$this->lastModifiedDate[$id] = $date;
		}

		return JFactory::getDate($this->lastModifiedDate[$id])->format('jS F, Y');
	}

	/**
	 * Set the Static File & Folder
	 *
	 * @param   array    $target  The main target and name
	 * @param   string   $type  The type in the target
	 * @param   string   $fileName  The custom file name
	 * @param   array    $cofig to add more data to the files info
	 *
	 * @return  boolean
	 *
	 */
	public function buildDynamique($target, $type, $fileName = false, $config = false)
	{
		if (ComponentbuilderHelper::checkArray($target))
		{
			foreach ($target as $main => $name)
			{
				// make sure it is lower case
				$name = ComponentbuilderHelper::safeString($name);
				// setup the files
				foreach ($this->joomlaVersionData->move->dynamic->{$main} as $item => $details)
				{
					if ($details->type == $type)
					{
						// set destination path
						$path = '';
						if (strpos($details->path, 'VIEW') !== false)
						{
							$path = str_replace('VIEW', $name, $details->path);
						}
						else
						{
							$path = $details->path;
						}
						$zipPath = str_replace('c0mp0n3nt/', '', $path);
						$path = str_replace('c0mp0n3nt/', $this->componentPath . '/', $path);

						// setup the folder
						if (!JFolder::exists($path))
						{
							JFolder::create($path);
							$this->indexHTML($zipPath);
							// count the folder created
							$this->folderCount++;
						}
						// do the file renaming
						if ($details->rename)
						{
							if ($fileName)
							{
								$new = str_replace($details->rename, $fileName, $item);
								$name = $name . '_' . $fileName;
							}
							elseif ($details->rename === 'new')
							{
								$new = $details->newName;
							}
							else
							{
								$new = str_replace($details->rename, $name, $item);
							}
						}
						else
						{
							$new = $item;
						}
						if (!JFile::exists($path . '/' . $new))
						{
							// move the file to its place
							JFile::copy($this->templatePath . '/' . $item, $path . '/' . $new, '', true);
							// count the file created
							$this->fileCount++;
						}
						// setup array for new file
						$newFIle = array('path' => $path . '/' . $new, 'name' => $new, 'view' => $name, 'zip' => $zipPath . '/' . $new);
						if (ComponentbuilderHelper::checkArray($config))
						{
							$newFIle['config'] = $config;
						}
						// store the new files
						$this->newFiles['dynamic'][$name][] = $newFIle;
					}
				}
			}
			return true;
		}
		return false;
	}

	/**
	 * set the Joomla Version Data
	 * 
	 *
	 * @return  oject The version data
	 * 
	 */
	private function setJoomlaVersionData()
	{
		// set the version data
		$versionData = json_decode(ComponentbuilderHelper::getFileContents($this->templatePath . '/settings.json'));
		// add custom folders
		if ((isset($this->componentData->folders) && ComponentbuilderHelper::checkArray($this->componentData->folders)) || $this->addEximport || $this->uikit || $this->footable)
		{
			if ($this->addEximport)
			{
				// move the import view folder in place
				$importView = array('folder' => 'importViews', 'path' => 'admin/views/import', 'rename' => 1);
				$this->componentData->folders[] = $importView;
				// move the PHPExel Folder
				$PHPExcel = array('folder' => 'PHPExcel', 'path' => 'admin/helpers', 'rename' => 0);
				$this->componentData->folders[] = $PHPExcel;
			}
			if (2 == $this->uikit || 1 == $this->uikit)
			{
				// move the UIKIT Folder into place
				$uikit = array('folder' => 'uikit-v2', 'path' => 'media', 'rename' => 0);
				$this->componentData->folders[] = $uikit;
			}
			if (2 == $this->uikit || 3 == $this->uikit)
			{
				// move the UIKIT-3 Folder into place
				$uikit = array('folder' => 'uikit-v3', 'path' => 'media', 'rename' => 0);
				$this->componentData->folders[] = $uikit;
			}
			if ($this->footable && (!isset($this->footableVersion) || 2 == $this->footableVersion))
			{
				// move the footable folder into place
				$footable = array('folder' => 'footable-v2', 'path' => 'media', 'rename' => 0);
				$this->componentData->folders[] = $footable;
			}
			elseif ($this->footable && 3 == $this->footableVersion)
			{
				// move the footable folder into place
				$footable = array('folder' => 'footable-v3', 'path' => 'media', 'rename' => 0);
				$this->componentData->folders[] = $footable;
			}

			// pointer tracker
			$pointer_tracker = 'h';
			foreach ($this->componentData->folders as $custom)
			{
				// by default custom path is true
				$customPath = 'custom';
				// fix custom path
				if (isset($custom['path']) && ComponentbuilderHelper::checkString($custom['path']))
				{
					$custom['path'] = trim($custom['path'], '/');
				}
				// set full path if this is a full path folder
				if (!isset($custom['folder']) && isset($custom['folderpath']))
				{
					$custom['folder'] = '/' . trim($custom['folderpath'], '/');
					// update the dynamic path
					$custom['folder'] = $this->updateDynamicPath($custom['folder']);
					// remove the file path
					unset($custom['folderpath']);
					// triget fullpath
					$customPath = 'full';
				}
				// make sure we use the correct name
				$pathArray = (array) explode('/', $custom['path']);
				$firstFolder = array_values($pathArray)[0];
				$lastFolder = end($pathArray);
				// only rename folder if last has folder name
				if (isset($custom['rename']) && $custom['rename'] == 1)
				{
					$custom['path'] = str_replace('/' . $lastFolder, '', $custom['path']);
					$rename = 'new';
					$newname = $lastFolder;
					// add fix to insure it gets added to xml if needed
					if (($tkey = array_search($lastFolder, $pathArray)) !== false)
					{
						unset($pathArray[$tkey]);
					}
				}
				elseif ('full' === $customPath)
				{
					// make sure we use the correct name
					$folderArray = (array) explode('/', $custom['folder']);
					$lastFolder = end($folderArray);
					$rename = 'new';
					$newname = $lastFolder;
					// add fix to insure it gets added to xml if needed
					if (($tkey = array_search($lastFolder, $pathArray)) !== false)
					{
						unset($pathArray[$tkey]);
					}
				}
				else
				{
					$lastFolder = $custom['folder'];
					$rename = false;
					$newname = '';
				}
				// check if we sould add it to the media xml list
				if (!isset($this->fileContentStatic['###EXSTRA_MEDIA_FOLDERS###']))
				{
					$this->fileContentStatic['###EXSTRA_MEDIA_FOLDERS###'] = '';
				}
				if (count($pathArray) == 1 && $firstFolder === 'media')
				{
					$this->fileContentStatic['###EXSTRA_MEDIA_FOLDERS###'] .= PHP_EOL . "\t\t<folder>" . $lastFolder . "</folder>";
				}
				// check if we sould add it to the site xml list
				if (!isset($this->fileContentStatic['###EXSTRA_SITE_FOLDERS###']))
				{
					$this->fileContentStatic['###EXSTRA_SITE_FOLDERS###'] = '';
				}
				if (count($pathArray) == 1 && $firstFolder === 'site')
				{
					$this->fileContentStatic['###EXSTRA_SITE_FOLDERS###'] .= PHP_EOL . "\t\t<folder>" . $lastFolder . "</folder>";
				}
				// check if we sould add it to the admin xml list
				if (!isset($this->fileContentStatic['###EXSTRA_ADMIN_FOLDERS###']))
				{
					$this->fileContentStatic['###EXSTRA_ADMIN_FOLDERS###'] = '';
				}
				if (count($pathArray) == 1 && $firstFolder === 'admin')
				{
					$this->fileContentStatic['###EXSTRA_ADMIN_FOLDERS###'] .= PHP_EOL . "\t\t\t<folder>" . $lastFolder . "</folder>";
				}
				// make we have not duplicates
				$key_pointer = ComponentbuilderHelper::safeString($custom['folder']) . '_f' . $pointer_tracker;
				$pointer_tracker++;
				// set new folder to object
				$versionData->move->static->$key_pointer = new stdClass();
				$versionData->move->static->$key_pointer->naam = $custom['folder'];
				$versionData->move->static->$key_pointer->path = 'c0mp0n3nt/' . $custom['path'];
				$versionData->move->static->$key_pointer->rename = $rename;
				$versionData->move->static->$key_pointer->newName = $newname;
				$versionData->move->static->$key_pointer->type = 'folder';
				$versionData->move->static->$key_pointer->custom = $customPath;
			}
			unset($this->componentData->folders);
			unset($custom);
		}
		// add custom files
		if ((isset($this->componentData->files) && ComponentbuilderHelper::checkArray($this->componentData->files)) || $this->addEximport || $this->googlechart)
		{
			if ($this->addEximport)
			{
				// move the PHPExel main file
				$PHPExcel = array('file' => 'PHPExcel.php', 'path' => 'admin/helpers', 'rename' => 0);
				$this->componentData->files[] = $PHPExcel;
			}
			if ($this->googlechart)
			{
				// move the google chart files
				$googleChart = array('file' => 'google.jsapi.js', 'path' => 'media/js', 'rename' => 0);
				$this->componentData->files[] = $googleChart;
				$googleChart = array('file' => 'chartbuilder.php', 'path' => 'admin/helpers', 'rename' => 0);
				$this->componentData->files[] = $googleChart;
			}

			// pointer tracker
			$pointer_tracker = 'h';
			foreach ($this->componentData->files as $custom)
			{
				$customPath = 'custom';
				// set full path if this is a full path file
				if (!isset($custom['file']) && isset($custom['filepath']))
				{
					$custom['file'] = '/' . trim($custom['filepath'], '/');
					// update the dynamic path
					$custom['file'] = $this->updateDynamicPath($custom['file']);
					// remove the file path
					unset($custom['filepath']);
					// triget fullpath
					$customPath = 'full';
				}
				// make we have not duplicates
				$key_pointer = ComponentbuilderHelper::safeString($custom['file']) . '_g' . $pointer_tracker;
				$pointer_tracker++;
				// set new file to object
				$versionData->move->static->$key_pointer = new stdClass();
				$versionData->move->static->$key_pointer->naam = $custom['file'];
				// update the dynamic component name placholders in file names
				$custom['path'] = $this->setPlaceholders($custom['path'], $this->placeholders);
				// get the path info
				$pathInfo = pathinfo($custom['path']);
				if (isset($pathInfo['extension']) && $pathInfo['extension'])
				{
					$pathInfo['dirname'] = trim($pathInfo['dirname'], '/');
					// set the info
					$versionData->move->static->$key_pointer->path = 'c0mp0n3nt/' . $pathInfo['dirname'];
					$versionData->move->static->$key_pointer->rename = 'new';
					$versionData->move->static->$key_pointer->newName = $pathInfo['basename'];
				}
				elseif ('full' === $customPath)
				{
					$fileArray = explode('/', $custom['file']);
					// set the info
					$versionData->move->static->$key_pointer->path = 'c0mp0n3nt/' . $custom['path'];
					$versionData->move->static->$key_pointer->rename = 'new';
					$versionData->move->static->$key_pointer->newName = end($fileArray);
				}
				else
				{
					// fix custom path
					$custom['path'] = trim($custom['path'], '/');
					// set the info
					$versionData->move->static->$key_pointer->path = 'c0mp0n3nt/' . $custom['path'];
					$versionData->move->static->$key_pointer->rename = false;
				}
				// check if file should be updated
				if (!isset($custom['notnew']) || $custom['notnew'] == 0 || $custom['notnew'] != 1)
				{
					$this->notNew[] = $key_pointer;
				}
				$versionData->move->static->$key_pointer->type = 'file';
				$versionData->move->static->$key_pointer->custom = $customPath;
			}
			unset($this->componentData->files);
			unset($custom);
		}
		return $versionData;
	}

	/**
	 * set the index.html file in a folder path
	 * 
	 * @param   string   $path  The path to place the index.html file in
	 *
	 * @return  void
	 * 
	 */
	private function indexHTML($path)
	{
		if (strlen($path) > 0)
		{
			JFile::copy($this->templatePath . '/index.html', $this->componentPath . '/' . $path . '/index.html');
			// count the file created
			$this->fileCount++;
		}
		else
		{
			JFile::copy($this->templatePath . '/index.html', $this->componentPath . '/index.html');
			// count the file created
			$this->fileCount++;
		}
	}

	/**
	 * Update paths with real value
	 * 
	 * @param   string   $path  The full path
	 *
	 * @return  string   The updated path
	 * 
	 */
	protected function updateDynamicPath($path)
	{
		return $this->setPlaceholders($path, ComponentbuilderHelper::$constantPaths);
	}

	/**
	 * Remove folders with files
	 * 
	 * @param   string   $dir     The path to folder to remove
	 * @param   boolean  $ignore  The files and folders to ignore
	 *
	 * @return  boolean   True if all is removed
	 * 
	 */
	protected function removeFolder($dir, $ignore = false)
	{
		return ComponentbuilderHelper::removeFolder($dir, $ignore);
	}

}
