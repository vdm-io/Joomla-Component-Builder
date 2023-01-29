<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @gitea      Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @github     Joomla Component Builder <https://github.com/vdm-io/Joomla-Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Filesystem\File;
use Joomla\CMS\Filesystem\Folder;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\ObjectHelper;
use VDM\Joomla\Utilities\GetHelper;
use VDM\Joomla\Utilities\FileHelper;
use VDM\Joomla\Componentbuilder\Compiler\Factory as CFactory;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Placefix;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;


/**
 * Structure class
 * @deprecated 3.3
 */
class Structure extends Get
{

	/**
	 * The folder counter
	 *
	 * @var     int
	 * @deprecated 3.3 Use CFactory::_('Utilities.Counter')->folder;
	 */
	public $folderCount = 0;

	/**
	 * The file counter
	 *
	 * @var     int
	 * @deprecated 3.3 Use CFactory::_('Utilities.Counter')->file;
	 */
	public $fileCount = 0;

	/**
	 * The page counter
	 *
	 * @var     int
	 * @deprecated 3.3
	 */
	public $pageCount = 0;

	/**
	 * The line counter
	 *
	 * @var     int
	 * @deprecated 3.3
	 * @deprecated 3.3 Use CFactory::_('Utilities.Counter')->line;
	 */
	public $lineCount = 0;

	/**
	 * The field counter
	 *
	 * @var     int
	 * @deprecated 3.3
	 */
	public $fieldCount = 0;

	/**
	 * The seconds counter
	 *
	 * @var     int
	 * @deprecated 3.3
	 */
	public $seconds = 0;

	/**
	 * The actual seconds counter
	 *
	 * @var     int
	 * @deprecated 3.3
	 */
	public $actualSeconds = 0;

	/**
	 * The folder seconds counter
	 *
	 * @var     int
	 * @deprecated 3.3
	 */
	public $folderSeconds = 0;

	/**
	 * The file seconds counter
	 *
	 * @var     int
	 * @deprecated 3.3
	 */
	public $fileSeconds = 0;

	/**
	 * The line seconds counter
	 *
	 * @var     int
	 * @deprecated 3.3
	 */
	public $lineSeconds = 0;

	/**
	 * The seconds debugging counter
	 *
	 * @var     int
	 * @deprecated 3.3
	 */
	public $secondsDebugging = 0;

	/**
	 * The seconds planning counter
	 *
	 * @var     int
	 * @deprecated 3.3
	 */
	public $secondsPlanning = 0;

	/**
	 * The seconds mapping counter
	 *
	 * @var     int
	 * @deprecated 3.3
	 */
	public $secondsMapping = 0;

	/**
	 * The seconds office counter
	 *
	 * @var     int
	 * @deprecated 3.3
	 */
	public $secondsOffice = 0;

	/**
	 * The total hours counter
	 *
	 * @var     int
	 * @deprecated 3.3
	 */
	public $totalHours = 0;

	/**
	 * The debugging hours counter
	 *
	 * @var     int
	 * @deprecated 3.3
	 */
	public $debuggingHours = 0;

	/**
	 * The planning hours counter
	 *
	 * @var     int
	 * @deprecated 3.3
	 */
	public $planningHours = 0;

	/**
	 * The mapping hours counter
	 *
	 * @var     int
	 * @deprecated 3.3
	 */
	public $mappingHours = 0;

	/**
	 * The office hours counter
	 *
	 * @var     int
	 * @deprecated 3.3
	 */
	public $officeHours = 0;

	/**
	 * The actual Total Hours counter
	 *
	 * @var     int
	 * @deprecated 3.3
	 */
	public $actualTotalHours = 0;

	/**
	 * The actual hours spent counter
	 *
	 * @var     int
	 * @deprecated 3.3
	 */
	public $actualHoursSpent = 0;

	/**
	 * The actual days spent counter
	 *
	 * @var     int
	 * @deprecated 3.3
	 */
	public $actualDaysSpent = 0;

	/**
	 * The total days counter
	 *
	 * @var     int
	 * @deprecated 3.3
	 */
	public $totalDays = 0;

	/**
	 * The actual Total Days counter
	 *
	 * @var     int
	 * @deprecated 3.3
	 */
	public $actualTotalDays = 0;

	/**
	 * The project week time counter
	 *
	 * @var     int
	 * @deprecated 3.3
	 */
	public $projectWeekTime = 0;

	/**
	 * The project month time counter
	 *
	 * @var     int
	 * @deprecated 3.3
	 */
	public $projectMonthTime = 0;

	/**
	 * The template path
	 *
	 * @var     string
	 * @deprecated 3.3 Use CFactory::_('Utilities.Paths')->template_path;
	 */
	public $templatePath;

	/**
	 * The custom template path
	 *
	 * @var     string
	 * @deprecated 3.3 Use CFactory::_('Utilities.Paths')->template_path_custom;
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
	 * @deprecated 3.3 Use CFactory::_('Content')->active
	 */
	public $fileContentStatic = array();

	/**
	 * Extention Custom Fields
	 *
	 * @var    array
	 */
	public $extentionCustomfields = array();

	/**
	 * Extention Tracking Files Moved
	 *
	 * @var    array
	 */
	public $extentionTrackingFilesMoved = array();

	/**
	 * The standard folders
	 *
	 * @var      array
	 */
	public $stdFolders = array('site', 'admin', 'media');

	/**
	 * The standard root files
	 *
	 * @var      array
	 */
	public $stdRootFiles
		= array('access.xml', 'config.xml', 'controller.php', 'index.html',
			'README.txt');

	/**
	 * Dynamic File Content
	 *
	 * @var      array
	 * @deprecated 3.3 Use CFactory::_('Content')->_active
	 */
	public $fileContentDynamic = array();

	/**
	 * The Component Sales name
	 *
	 * @var      string
	 * @deprecated 3.3 Use CFactory::_('Utilities.Paths')->component_sales_name;
	 */
	public $componentSalesName;

	/**
	 * The Component Backup name
	 *
	 * @var      string
	 * @deprecated 3.3 Use CFactory::_('Utilities.Paths')->component_backup_name;
	 */
	public $componentBackupName;

	/**
	 * The Component Folder name
	 *
	 * @var      string
	 * @deprecated 3.3 Use CFactory::_('Utilities.Paths')->component_folder_name;
	 */
	public $componentFolderName;

	/**
	 * The Component path
	 *
	 * @var      string
	 * @deprecated 3.3 Use CFactory::_('Utilities.Paths')->component_path;
	 */
	public $componentPath;

	/**
	 * The Dynamic paths
	 *
	 * @var      array
	 * @deprecated 3.3 Use CFactory::_('Registry')->get('dynamic_paths');
	 */
	public $dynamicPaths = array();

	/**
	 * The not new static items
	 *
	 * @var      array
	 */
	public $notNew = array();

	/**
	 * Update the file content
	 *
	 * @var      array
	 */
	public $updateFileContent = array();

	/**
	 * The new files
	 *
	 * @var     array
	 * @deprecated 3.3 Use CFactory::_('Utilities.Files');
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
	 * The default view type
	 *
	 * @var    string
	 */
	public $dynamicDashboardType;

	/**
	 * Constructor
	 */
	public function __construct()
	{
		// first we run the parent constructor
		if (parent::__construct())
		{
			// set the standard admin file
			$this->stdRootFiles[] = CFactory::_('Component')->get('name_code') . '.php';
			// set incase no extra admin folder are loaded
			CFactory::_('Content')->set('EXSTRA_ADMIN_FOLDERS', '');
			// set incase no extra site folder are loaded
			CFactory::_('Content')->set('EXSTRA_SITE_FOLDERS', '');
			// set incase no extra media folder are loaded
			CFactory::_('Content')->set('EXSTRA_MEDIA_FOLDERS', '');
			// set incase no extra admin files are loaded
			CFactory::_('Content')->set('EXSTRA_ADMIN_FILES', '');
			// set incase no extra site files are loaded
			CFactory::_('Content')->set('EXSTRA_SITE_FILES', '');
			// set incase no extra media files are loaded
			CFactory::_('Content')->set('EXSTRA_MEDIA_FILES', '');
			// make sure there is no old build
			CFactory::_('Utilities.Folder')->remove(CFactory::_('Utilities.Paths')->component_path);
			// load the libraries files/folders and url's
			CFactory::_('Library.Builder')->run();
			// load the powers files/folders
			CFactory::_('Power.Builder')->run();
			// load the module files/folders and url's
			CFactory::_('Joomlamodule.Builder')->run();
			// load the plugin files/folders and url's
			CFactory::_('Joomlaplugin.Builder')->run();
			// set the Joomla Version Data
			$this->joomlaVersionData = $this->setJoomlaVersionData();
			// for plugin event TODO change event api signatures
			$component_context = CFactory::_('Config')->component_context;
			// Trigger Event: jcb_ce_onAfterSetJoomlaVersionData
			CFactory::_('Event')->trigger(
				'jcb_ce_onAfterSetJoomlaVersionData',
				array(&$component_context, &$this->joomlaVersionData)
			);
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
	 * Build the Powers files, folders
	 *
	 * @return  void
	 * @deprecated 3.3 Use CFactory::_('Power.Builder')->run();
	 */
	private function buildPowers()
	{
		CFactory::_('Power.Builder')->run();
	}

	/**
	 * Build the Modules files, folders, url's and config
	 *
	 * @return  void
	 * @deprecated 3.3 Use CFactory::_('Joomlamodule.Builder')->run();
	 */
	private function buildModules()
	{
		CFactory::_('Joomlamodule.Builder')->run();
	}

	/**
	 * Build the Plugins files, folders, url's and config
	 *
	 * @return  void
	 * @deprecated 3.3 Use CFactory::_('Joomlaplugin.Builder')->run();
	 */
	private function buildPlugins()
	{
		CFactory::_('Joomlaplugin.Builder')->run();
	}

	/**
	 * Create Path if not exist
	 *
	 * @return void
	 * @deprecated 3.3 Use CFactory::_('Utilities.Folder')->create($path);
	 */
	private function createFolder($path)
	{
		CFactory::_('Utilities.Folder')->create($path);
	}

	/**
	 * Build the Libraries files, folders, url's and config
	 *
	 * @return  void
	 * @deprecated 3.3 Use CFactory::_('Library.Builder')->run();
	 */
	private function setLibraries()
	{
		CFactory::_('Library.Builder')->run();
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
		if (CFactory::_('Component')->get('dashboard_type', 0) == 2
			&& ($dashboard_ = CFactory::_('Component')->get('dashboard')) !== null
			&& StringHelper::check($dashboard_)
			&& strpos((string) $dashboard_, '_') !== false)
		{
			// set the default view
			$getter = explode('_', (string) $dashboard_);
			if (count((array) $getter) == 2 && is_numeric($getter[1]))
			{
				// the pointers
				$t  = StringHelper::safe($getter[0], 'U');
				$id = (int) $getter[1];
				// the dynamic stuff
				$targets = array('A' => 'admin_views',
				                 'C' => 'custom_admin_views');
				$names   = array('A' => 'admin view',
				                 'C' => 'custom admin view');
				$types   = array('A' => 'adminview', 'C' => 'customadminview');
				$keys    = array('A' => 'name_list', 'C' => 'code');
				// check the target values
				if (isset($targets[$t]) && $id > 0)
				{
					// set the type name
					$type_names = StringHelper::safe(
						$targets[$t], 'w'
					);
					// set the dynamic dash
					if (($target_ = CFactory::_('Component')->get($targets[$t])) !== null
						&& ArrayHelper::check($target_))
					{
						// search the target views
						$dashboard = (array) array_filter(
							$target_,
							function ($view) use ($id, $t, $types) {
								if (isset($view[$types[$t]])
									&& $id == $view[$types[$t]])
								{
									return true;
								}

								return false;
							}
						);
						// set dashboard
						if (ArrayHelper::check($dashboard))
						{
							$dashboard = array_values($dashboard)[0];
						}
						// check if view was found (this should be true)
						if (isset($dashboard['settings'])
							&& isset($dashboard['settings']->{$keys[$t]}))
						{
							$this->dynamicDashboard
								= StringHelper::safe(
								$dashboard['settings']->{$keys[$t]}
							);
							$this->dynamicDashboardType
								= $targets[$t];
						}
						else
						{
							// set massage that something is wrong
							$this->app->enqueueMessage(
								JText::_('<hr /><h3>Dashboard Error</h3>'),
								'Error'
							);
							$this->app->enqueueMessage(
								JText::sprintf(
									'The <b>%s</b> (<b>%s</b>) is not available in your component! Please insure to only used %s, for a dynamic dashboard, that are still linked to your component.',
									$names[$t], $dashboard_,
									$type_names
								), 'Error'
							);
						}
					}
					else
					{
						// set massage that something is wrong
						$this->app->enqueueMessage(
							JText::_('<hr /><h3>Dashboard Error</h3>'), 'Error'
						);
						$this->app->enqueueMessage(
							JText::sprintf(
								'The <b>%s</b> (<b>%s</b>) is not available in your component! Please insure to only used %s, for a dynamic dashboard, that are still linked to your component.',
								$names[$t], $dashboard_,
								$type_names
							), 'Error'
						);
					}
				}
				else
				{
					// the target value is wrong
					$this->app->enqueueMessage(
						JText::_('<hr /><h3>Dashboard Error</h3>'), 'Error'
					);
					$this->app->enqueueMessage(
						JText::sprintf(
							'The <b>%s</b> value for the dynamic dashboard is invalid.',
							$dashboard_
						), 'Error'
					);
				}
			}
			else
			{
				// the target value is wrong
				$this->app->enqueueMessage(
					JText::_('<hr /><h3>Dashboard Error</h3>'), 'Error'
				);
				$this->app->enqueueMessage(
					JText::sprintf(
						'The <b>%s</b> value for the dynamic dashboard is invalid.',
						$dashboard_
					), 'Error'
				);
			}
			// if default was changed to dynamic dashboard the remove default tab and methods
			if (StringHelper::check($this->dynamicDashboard))
			{
				// dynamic dashboard is used
				CFactory::_('Component')->remove('dashboard_tab');
				CFactory::_('Component')->remove('php_dashboard_methods');
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
		return FileHelper::write($path, $data);
	}

	/**
	 * Build the Initial Folders
	 *
	 * @return  void
	 *
	 */
	private function setFolders()
	{
		if (ObjectHelper::check(
			$this->joomlaVersionData->create
		))
		{
			// creat the main component folder
			if (!Folder::exists(CFactory::_('Utilities.Paths')->component_path))
			{
				Folder::create(CFactory::_('Utilities.Paths')->component_path);
				// count the folder created
				CFactory::_('Utilities.Counter')->folder++;
				CFactory::_('Utilities.File')->html('');
			}
			// now build all folders needed for this component
			foreach ($this->joomlaVersionData->create as $main => $folders)
			{
				CFactory::_('Utilities.Folder')->create(CFactory::_('Utilities.Paths')->component_path . '/' . $main);
				if (ObjectHelper::check($folders))
				{
					foreach ($folders as $sub => $subFolders)
					{
						CFactory::_('Utilities.Folder')->create(
							CFactory::_('Utilities.Paths')->component_path . '/' . $main . '/' . $sub
						);
						if (ObjectHelper::check($subFolders))
						{
							foreach ($subFolders as $sub_2 => $subFolders_2)
							{
								CFactory::_('Utilities.Folder')->create(
									CFactory::_('Utilities.Paths')->component_path . '/' . $main . '/'
									. $sub . '/' . $sub_2
								);
								if (ObjectHelper::check(
									$subFolders_2
								))
								{
									foreach (
										$subFolders_2 as $sub_3 => $subFolders_3
									)
									{
										CFactory::_('Utilities.Folder')->create(
											CFactory::_('Utilities.Paths')->component_path . '/' . $main
											. '/' . $sub . '/' . $sub_2 . '/'
											. $sub_3
										);
										if (ObjectHelper::check(
											$subFolders_3
										))
										{
											foreach (
												$subFolders_3 as $sub_4 =>
												$subFolders_4
											)
											{
												CFactory::_('Utilities.Folder')->create(
													CFactory::_('Utilities.Paths')->component_path . '/'
													. $main . '/' . $sub . '/'
													. $sub_2 . '/' . $sub_3
													. '/' . $sub_4
												);
												if (ObjectHelper::check(
													$subFolders_4
												))
												{
													foreach (
														$subFolders_4 as $sub_5
													=> $subFolders_5
													)
													{
														CFactory::_('Utilities.Folder')->create(
															CFactory::_('Utilities.Paths')->component_path
															. '/' . $main . '/'
															. $sub . '/'
															. $sub_2 . '/'
															. $sub_3 . '/'
															. $sub_4 . '/'
															. $sub_5
														);
														if (ObjectHelper::check(
															$subFolders_5
														))
														{
															foreach (
																$subFolders_5 as
																$sub_6 =>
																$subFolders_6
															)
															{
																CFactory::_('Utilities.Folder')->create(
																	CFactory::_('Utilities.Paths')->component_path
																	. '/'
																	. $main
																	. '/'
																	. $sub
																	. '/'
																	. $sub_2
																	. '/'
																	. $sub_3
																	. '/'
																	. $sub_4
																	. '/'
																	. $sub_5
																	. '/'
																	. $sub_6
																);
																if (ObjectHelper::check(
																	$subFolders_6
																))
																{
																	foreach (
																		$subFolders_6
																		as
																		$sub_7
																	=>
																		$subFolders_7
																	)
																	{
																		CFactory::_('Utilities.Folder')->create(
																			CFactory::_('Utilities.Paths')->component_path
																			. '/'
																			. $main
																			. '/'
																			. $sub
																			. '/'
																			. $sub_2
																			. '/'
																			. $sub_3
																			. '/'
																			. $sub_4
																			. '/'
																			. $sub_5
																			. '/'
																			. $sub_6
																			. '/'
																			. $sub_7
																		);
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
		if (ObjectHelper::check(
			$this->joomlaVersionData->move->static
		))
		{
			$codeName = CFactory::_('Config')->component_code_name;
			// TODO needs more looking at this must be dynamic actually
			$this->notNew[] = 'LICENSE.txt';
			// do license check
			$LICENSE        = false;
			$licenseChecker = strtolower((string) CFactory::_('Component')->get('license', ''));
			if (strpos($licenseChecker, 'gnu') !== false
				&& strpos(
					$licenseChecker, '2'
				) !== false
				&& (strpos($licenseChecker, 'gpl') !== false
					|| strpos(
						$licenseChecker, 'general public license'
					) !== false))
			{
				$LICENSE
					= true; // we only add version 2 auto at this time (TODO)
			}
			// do README check
			$README = false;
			// add the README file if needed
			if (CFactory::_('Component')->get('addreadme', false))
			{
				$README = true;
			}
			// start moving
			foreach (
				$this->joomlaVersionData->move->static as $ftem => $details
			)
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
						$new = str_replace($details->rename, $codeName, (string) $item);
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
				if (($item === 'README.md' || $item === 'README.txt')
					&& !$README)
				{
					continue;
				}
				// check if we have a target value
				if (isset($details->_target))
				{
					// set destination path
					$zipPath = str_replace(
						$details->_target['type'] . '/', '', (string) $details->path
					);
					$path    = str_replace(
						$details->_target['type'] . '/',
						CFactory::_('Registry')->get('dynamic_paths.' . $details->_target['key'], '') . '/',
						(string) $details->path
					);
				}
				else
				{
					// set destination path
					$zipPath = str_replace('c0mp0n3nt/', '', (string) $details->path);
					$path    = str_replace(
						'c0mp0n3nt/', CFactory::_('Utilities.Paths')->component_path . '/', (string) $details->path
					);
				}
				// set the template folder path
				$templatePath = (isset($details->custom) && $details->custom)
					? (($details->custom !== 'full') ? CFactory::_('Utilities.Paths')->template_path_custom
						. '/' : '') : CFactory::_('Utilities.Paths')->template_path . '/';
				// set the final paths
				$currentFullPath = (preg_match('/^[a-z]:/i', (string) $item)) ? $item
					: $templatePath . '/' . $item;
				$currentFullPath = str_replace('//', '/', (string) $currentFullPath);
				$packageFullPath = str_replace('//', '/', $path . '/' . $new);
				$zipFullPath     = str_replace(
					'//', '/', $zipPath . '/' . $new
				);
				// now move the file
				if ($details->type === 'file')
				{
					if (!File::exists($currentFullPath))
					{
						$this->app->enqueueMessage(
							JText::_('<hr /><h3>File Path Error</h3>'), 'Error'
						);
						$this->app->enqueueMessage(
							JText::sprintf(
								'The file path: <b>%s</b> does not exist, and was not added!',
								$currentFullPath
							), 'Error'
						);
					}
					else
					{
						// get base name && get the path only
						$packageFullPath0nly = str_replace(
							basename($packageFullPath), '', $packageFullPath
						);
						// check if path exist, if not creat it
						if (!Folder::exists($packageFullPath0nly))
						{
							Folder::create($packageFullPath0nly);
						}
						// move the file to its place
						File::copy($currentFullPath, $packageFullPath);
						// count the file created
						CFactory::_('Utilities.Counter')->file++;
						// store the new files
						if (!in_array($ftem, $this->notNew))
						{
							if (isset($details->_target))
							{
								CFactory::_('Utilities.Files')->appendArray($details->_target['key'],
									[
										'path' => $packageFullPath,
									    'name' => $new,
									    'zip'  => $zipFullPath
									]
								);
							}
							else
							{
								CFactory::_('Utilities.Files')->appendArray('static',
									[
										'path' => $packageFullPath,
									    'name' => $new,
									    'zip'  => $zipFullPath
									]
								);
							}
						}
						// ensure we update this file if needed
						if (isset($this->updateFileContent[$ftem])
							&& $this->updateFileContent[$ftem])
						{
							// remove the pointer
							unset($this->updateFileContent[$ftem]);
							// set the full path
							$this->updateFileContent[$packageFullPath]
								= $packageFullPath;
						}
					}
				}
				elseif ($details->type === 'folder')
				{
					if (!Folder::exists($currentFullPath))
					{
						$this->app->enqueueMessage(
							JText::_('<hr /><h3>Folder Path Error</h3>'),
							'Error'
						);
						$this->app->enqueueMessage(
							JText::sprintf(
								'The folder path: <b>%s</b> does not exist, and was not added!',
								$currentFullPath
							), 'Error'
						);
					}
					else
					{
						// move the folder to its place
						Folder::copy(
							$currentFullPath, $packageFullPath, '', true
						);
						// count the folder created
						CFactory::_('Utilities.Counter')->folder++;
					}
				}
				// only add if no target found since those belong to plugins and modules
				if (!isset($details->_target))
				{
					// check if we should add the dynamic folder moving script to the installer script
					$checker = array_values((array) explode('/', $zipFullPath));
					// TODO <-- this may not be the best way, will keep an eye on this.
					// We basicly only want to check if a folder is added that is not in the stdFolders array
					if (isset($checker[0])
						&& StringHelper::check($checker[0])
						&& !in_array($checker[0], $this->stdFolders))
					{
						// activate dynamic folders
						$this->setDynamicFolders();
					}
					elseif (count((array) $checker) == 2
						&& StringHelper::check($checker[0]))
					{
						$add_to_extra = false;
						// set the target
						$eNAME = 'FILES';
						$ename = 'filename';
						// this should not happen and must have been caught by the above if statment
						if ($details->type === 'folder')
						{
							// only folders outside the standard folder are added
							$eNAME        = 'FOLDERS';
							$ename        = 'folder';
							$add_to_extra = true;
						}
						// if this is a file, it can only be added to the admin/site/media folders 
						// all other folders are moved as a whole so their files do not need to be declared
						elseif (in_array($checker[0], $this->stdFolders)
							&& !in_array($checker[1], $this->stdRootFiles))
						{
							$add_to_extra = true;
						}
						// add if valid folder/file
						if ($add_to_extra)
						{
							// set the tab
							$eTab = Indent::_(2);
							if ('admin' === $checker[0])
							{
								$eTab = Indent::_(3);
							}
							// set the xml file
							$key_ = 'EXSTRA_'
								. StringHelper::safe(
									$checker[0], 'U'
								) . '_' . $eNAME;
							CFactory::_('Content')->add($key_,
								PHP_EOL . $eTab . "<" . $ename . ">"
								. $checker[1] . "</" . $ename . ">");
						}
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
		$back  = false;
		$front = false;
		if ((isset($this->joomlaVersionData->move->dynamic)
				&& ObjectHelper::check(
					$this->joomlaVersionData->move->dynamic
				))
			&& CFactory::_('Component')->isArray('admin_views'))
		{
			if (!StringHelper::check($this->dynamicDashboard))
			{
				// setup dashboard
				$target = array('admin' => CFactory::_('Component')->get('name_code'));
				$this->buildDynamique($target, 'dashboard');
			}
			// now the rest of the views
			foreach (CFactory::_('Component')->get('admin_views') as $nr => $view)
			{
				if (ObjectHelper::check($view['settings']))
				{
					$created  = $this->getCreatedDate($view);
					$modified = $this->getLastModifiedDate($view);
					if ($view['settings']->name_list != 'null')
					{
						$target
							    = array('admin' => $view['settings']->name_list);
						$config = array(Placefix::_h('CREATIONDATE') => $created,
						                Placefix::_h('BUILDDATE') => $modified,
						                Placefix::_h('VERSION') => $view['settings']->version);
						$this->buildDynamique($target, 'list', false, $config);
					}
					if ($view['settings']->name_single != 'null')
					{
						$target
							    = array('admin' => $view['settings']->name_single);
						$config = array(Placefix::_h('CREATIONDATE') => $created,
						                Placefix::_h('BUILDDATE') => $modified,
						                Placefix::_h('VERSION') => $view['settings']->version);
						$this->buildDynamique(
							$target, 'single', false, $config
						);
					}
					if (isset($view['edit_create_site_view'])
						&& is_numeric(
							$view['edit_create_site_view']
						)
						&& $view['edit_create_site_view'] > 0)
					{
						// setup the front site edit-view files
						$target
							    = array('site' => $view['settings']->name_single);
						$config = array(Placefix::_h('CREATIONDATE') => $created,
						                Placefix::_h('BUILDDATE') => $modified,
						                Placefix::_h('VERSION') => $view['settings']->version);
						$this->buildDynamique($target, 'edit', false, $config);
					}
				}
				// quick set of checkin once
				if (isset($view['checkin']) && $view['checkin'] == 1
					&& !$this->addCheckin)
				{
					// switch to add checking to config
					$this->addCheckin = true;
				}
			}
			$back = true;
		}
		if ((isset($this->joomlaVersionData->move->dynamic)
				&& ObjectHelper::check(
					$this->joomlaVersionData->move->dynamic
				))
			&& CFactory::_('Component')->isArray('site_views'))
		{

			foreach (CFactory::_('Component')->get('site_views') as $nr => $view)
			{
				$created  = $this->getCreatedDate($view);
				$modified = $this->getLastModifiedDate($view);
				if ($view['settings']->main_get->gettype == 2)
				{
					// set list view
					$target = array('site' => $view['settings']->code);
					$config = array(Placefix::_h('CREATIONDATE') => $created,
					                Placefix::_h('BUILDDATE') => $modified,
					                Placefix::_h('VERSION') => $view['settings']->version);
					$this->buildDynamique($target, 'list', false, $config);
				}
				elseif ($view['settings']->main_get->gettype == 1)
				{
					// set single view
					$target = array('site' => $view['settings']->code);
					$config = array(Placefix::_h('CREATIONDATE') => $created,
					                Placefix::_h('BUILDDATE') => $modified,
					                Placefix::_h('VERSION') => $view['settings']->version);
					$this->buildDynamique($target, 'single', false, $config);
				}
			}
			$front = true;
		}
		if ((isset($this->joomlaVersionData->move->dynamic)
				&& ObjectHelper::check(
					$this->joomlaVersionData->move->dynamic
				))
			&& CFactory::_('Component')->isArray('custom_admin_views'))
		{
			foreach (CFactory::_('Component')->get('custom_admin_views') as $nr => $view)
			{
				$created  = $this->getCreatedDate($view);
				$modified = $this->getLastModifiedDate($view);
				if ($view['settings']->main_get->gettype == 2)
				{
					// set list view$view
					$target = array('custom_admin' => $view['settings']->code);
					$config = array(Placefix::_h('CREATIONDATE') => $created,
					                Placefix::_h('BUILDDATE') => $modified,
					                Placefix::_h('VERSION') => $view['settings']->version);
					$this->buildDynamique($target, 'list', false, $config);
				}
				elseif ($view['settings']->main_get->gettype == 1)
				{
					// set single view
					$target = array('custom_admin' => $view['settings']->code);
					$config = array(Placefix::_h('CREATIONDATE') => $created,
					                Placefix::_h('BUILDDATE') => $modified,
					                Placefix::_h('VERSION') => $view['settings']->version);
					$this->buildDynamique($target, 'single', false, $config);
				}
			}
			$back = true;
		}
		// check if we had success
		if ($back || $front)
		{
			return true;
		}

		return false;
	}

	/**
	 * move the fields and Rules
	 *
	 * @param   array   $field  The field data
	 * @param   string  $path   The path to move to
	 *
	 * @return void
	 *
	 */
	public function moveFieldsRules($field, $path)
	{
		// check if we have a subform or repeatable field
		if ($field['type_name'] === 'subform'
			|| $field['type_name'] === 'repeatable')
		{
			// since we could have a custom field or rule inside
			$this->moveMultiFieldsRules($field, $path);
		}
		else
		{
			// check if this is a custom field that should be moved
			if (isset($this->extentionCustomfields[$field['type_name']]))
			{
				$check = md5($path . 'type' . $field['type_name']);
				// lets check if we already moved this
				if (!isset($this->extentionTrackingFilesMoved[$check]))
				{
					// check files exist
					if (File::exists(
						CFactory::_('Utilities.Paths')->component_path . '/admin/models/fields/'
						. $field['type_name'] . '.php'
					))
					{
						// copy the custom field
						File::copy(
							CFactory::_('Utilities.Paths')->component_path . '/admin/models/fields/'
							. $field['type_name'] . '.php',
							$path . '/fields/' . $field['type_name'] . '.php'
						);
					}
					// stop from doing this again.
					$this->extentionTrackingFilesMoved[$check] = true;
				}
			}
			// check if this has validation that should be moved
			if (CFactory::_('Registry')->get('validation.linked.' . $field['field']) !== null)
			{
				$check = md5(
					$path . 'rule'
					. CFactory::_('Registry')->get('validation.linked.' . $field['field'])
				);
				// lets check if we already moved this
				if (!isset($this->extentionTrackingFilesMoved[$check]))
				{
					// check files exist
					if (File::exists(
						CFactory::_('Utilities.Paths')->component_path . '/admin/models/rules/'
						. CFactory::_('Registry')->get('validation.linked.' . $field['field'])
						. '.php'
					))
					{
						// copy the custom field
						File::copy(
							CFactory::_('Utilities.Paths')->component_path . '/admin/models/rules/'
							. CFactory::_('Registry')->get('validation.linked.' . $field['field'])
							. '.php', $path . '/rules/'
							. CFactory::_('Registry')->get('validation.linked.' . $field['field'])
							. '.php'
						);
					}
					// stop from doing this again.
					$this->extentionTrackingFilesMoved[$check] = true;
				}
			}
		}
	}

	/**
	 * move the fields and Rules of multi fields
	 *
	 * @param   array   $multi_field  The field data
	 * @param   string  $path         The path to move to
	 *
	 * @return void
	 *
	 */
	protected function moveMultiFieldsRules($multi_field, $path)
	{
		// get the fields ids
		$ids = array_map(
			'trim',
			explode(
				',',
				(string) GetHelper::between(
					$multi_field['settings']->xml, 'fields="', '"'
				)
			)
		);
		if (ArrayHelper::check($ids))
		{
			foreach ($ids as $id)
			{
				// setup the field
				$field          = array();
				$field['field'] = $id;
				CFactory::_('Field')->set($field);
				// move field and rules if needed
				$this->moveFieldsRules($field, $path);
			}
		}
	}

	/**
	 * get the created date of the (view)
	 *
	 * @param   array  $view  The view values
	 *
	 * @return  string Last Modified Date
	 *
	 */
	public function getCreatedDate($view)
	{
		if (isset($view['settings']->created)
			&& StringHelper::check($view['settings']->created))
		{
			// first set the main date
			$date = strtotime((string) $view['settings']->created);
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
	 * @param   array  $view  The view values
	 *
	 * @return  string Last Modified Date
	 *
	 */
	public function getLastModifiedDate($view)
	{
		// first set the main date
		if (isset($view['settings']->modified)
			&& StringHelper::check($view['settings']->modified)
			&& '0000-00-00 00:00:00' !== $view['settings']->modified)
		{
			$date = strtotime((string) $view['settings']->modified);
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
				if (isset($view['settings']->fields)
					&& ArrayHelper::check(
						$view['settings']->fields
					))
				{
					foreach ($view['settings']->fields as $field)
					{
						if (isset($field['settings'])
							&& ObjectHelper::check(
								$field['settings']
							)
							&& isset($field['settings']->modified)
							&& StringHelper::check(
								$field['settings']->modified
							)
							&& '0000-00-00 00:00:00'
							!== $field['settings']->modified)
						{
							$anotherDate = strtotime(
								(string) $field['settings']->modified
							);
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
				if (isset($view['settings']->main_get->modified)
					&& StringHelper::check(
						$view['settings']->main_get->modified
					)
					&& '0000-00-00 00:00:00'
					!== $view['settings']->main_get->modified)
				{
					$anotherDate = strtotime(
						(string) $view['settings']->main_get->modified
					);
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
				if (isset($view['settings']->main_get->modified)
					&& StringHelper::check(
						$view['settings']->main_get->modified
					)
					&& '0000-00-00 00:00:00'
					!== $view['settings']->main_get->modified)
				{
					$anotherDate = strtotime(
						(string) $view['settings']->main_get->modified
					);
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

		return JFactory::getDate($this->lastModifiedDate[$id])->format(
			'jS F, Y'
		);
	}

	/**
	 * Set the Static File & Folder
	 *
	 * @param   array   $target    The main target and name
	 * @param   string  $type      The type in the target
	 * @param   string  $fileName  The custom file name
	 * @param   array   $cofig     to add more data to the files info
	 *
	 * @return  boolean
	 *
	 */
	public function buildDynamique($target, $type, $fileName = false,
	                               $config = false
	)
	{
		// did we build the files (any number)
		$build_status = false;
		// check that we have the target values
		if (ArrayHelper::check($target))
		{
			// search the target
			foreach ($target as $main => $name)
			{
				// make sure it is lower case
				$name = StringHelper::safe($name);
				// setup the files
				foreach (
					$this->joomlaVersionData->move->dynamic->{$main} as $item =>
					$details
				)
				{
					if ($details->type === $type)
					{
						// set destination path
						$path = '';
						if (strpos((string) $details->path, 'VIEW') !== false)
						{
							$path = str_replace('VIEW', $name, (string) $details->path);
						}
						else
						{
							$path = $details->path;
						}
						// make sure we have component to replace
						if (strpos((string) $path, 'c0mp0n3nt') !== false)
						{
							$zipPath = str_replace('c0mp0n3nt/', '', (string) $path);
							$path    = str_replace(
								'c0mp0n3nt/', CFactory::_('Utilities.Paths')->component_path . '/', (string) $path
							);
						}
						else
						{
							$this->app->enqueueMessage(
								JText::sprintf(
									'<hr /><h3>c0mp0n3nt issue found</h3><p>The path (%s) could not be used.</p>',
									$path
								), 'Error'
							);
							continue;
						}

						// setup the folder
						if (!Folder::exists($path))
						{
							Folder::create($path);
							CFactory::_('Utilities.File')->html($zipPath);
							// count the folder created
							CFactory::_('Utilities.Counter')->folder++;
						}
						// do the file renaming
						if ($details->rename)
						{
							if ($fileName)
							{
								$new  = str_replace(
									$details->rename, $fileName, (string) $item
								);
								$name = $name . '_' . $fileName;
							}
							elseif ($details->rename === 'new')
							{
								$new = $details->newName;
							}
							else
							{
								$new = str_replace(
									$details->rename, $name, (string) $item
								);
							}
						}
						else
						{
							$new = $item;
						}
						if (!File::exists($path . '/' . $new))
						{
							// move the file to its place
							File::copy(
								CFactory::_('Utilities.Paths')->template_path . '/' . $item,
								$path . '/' . $new
							);
							// count the file created
							CFactory::_('Utilities.Counter')->file++;
						}
						// we can't have dots in a file name (oops)
						if (strpos($name, '.') !== false)
						{
							$name = preg_replace('/[\.]+/', '_', (string) $name);
						}
						// setup array for new file
						$newFIle = array('path' => $path . '/' . $new,
						                 'name' => $new, 'view' => $name,
						                 'zip'  => $zipPath . '/' . $new);
						if (ArrayHelper::check($config))
						{
							$newFIle['config'] = $config;
						}
						// store the new files
						CFactory::_('Utilities.Files')->appendArray('dynamic.' . $name, $newFIle);
						// we have build atleast one
						$build_status = true;
					}
				}
			}
		}

		return $build_status;
	}

	/**
	 * set the Joomla Version Data
	 *
	 * @return  object The version data
	 *
	 */
	private function setJoomlaVersionData()
	{
		// option to load other settings
		$custom_settings = CFactory::_('Utilities.Paths')->template_path . '/settings_' . CFactory::_('Config')->component_code_name . '.json';
		// set the version data
		if (File::exists($custom_settings))
		{
			$version_data = json_decode(
				(string) FileHelper::getContent(
					$custom_settings
				)
			);
		}
		else
		{
			$version_data = json_decode(
				(string) FileHelper::getContent(
					CFactory::_('Utilities.Paths')->template_path . '/settings.json'
				)
			);
		}
		// set some defaults
		$uikit = CFactory::_('Config')->get('uikit', 0);
		$footable = CFactory::_('Config')->get('footable', false);
		$add_eximport = CFactory::_('Config')->get('add_eximport', false);
		// add custom folders
		if (CFactory::_('Component')->isArray('folders')
			|| $add_eximport || $uikit || $footable)
		{
			if ($add_eximport)
			{
				// move the import view folder in place
				CFactory::_('Component')->appendArray('folders', array('folder' => 'importViews',
				                                        'path'   => 'admin/views/import',
				                                        'rename' => 1));
				// move the phpspreadsheet Folder (TODO we must move this to a library package)
				CFactory::_('Component')->appendArray('folders', array('folderpath' => 'JPATH_LIBRARIES/phpspreadsheet/vendor',
					                                    'path'       => '/libraries/phpspreadsheet/',
					                                    'rename'     => 0));
			}

			// set uikit
			if (2 == $uikit || 1 == $uikit)
			{
				// move the UIKIT Folder into place
				CFactory::_('Component')->appendArray('folders', array('folder' => 'uikit-v2',
				                                        'path'   => 'media',
				                                        'rename' => 0));
			}
			if (2 == $uikit || 3 == $uikit)
			{
				// move the UIKIT-3 Folder into place
				CFactory::_('Component')->appendArray('folders', array('folder' => 'uikit-v3',
				                                        'path'   => 'media',
				                                        'rename' => 0));
			}

			// set footable
			$footable_version = CFactory::_('Config')->get('footable_version', 2);
			if ($footable && 2 == $footable_version)
			{
				// move the footable folder into place
				CFactory::_('Component')->appendArray('folders', array('folder' => 'footable-v2',
				                                        'path'   => 'media',
				                                        'rename' => 0));
			}
			elseif ($footable && 3 == $footable_version)
			{
				// move the footable folder into place
				CFactory::_('Component')->appendArray('folders', array('folder' => 'footable-v3',
				                                        'path'   => 'media',
				                                        'rename' => 0));
			}

			// pointer tracker
			$pointer_tracker = 'h';
			foreach (CFactory::_('Component')->get('folders') as $custom)
			{
				// check type of target type
				$_target_type = 'c0mp0n3nt';
				if (isset($custom['target_type']))
				{
					$_target_type = $custom['target_type'];
				}
				// for good practice
				ComponentbuilderHelper::fixPath(
					$custom, array('path', 'folder', 'folderpath')
				);
				// fix custom path
				if (isset($custom['path'])
					&& StringHelper::check($custom['path']))
				{
					$custom['path'] = trim((string) $custom['path'], '/');
				}
				// by default custom path is true
				$customPath = 'custom';
				// set full path if this is a full path folder
				if (!isset($custom['folder']) && isset($custom['folderpath']))
				{
					// update the dynamic path
					$custom['folderpath'] = $this->updateDynamicPath(
						$custom['folderpath']
					);
					// set the folder path with / if does not have a drive/windows full path
					$custom['folder'] = (preg_match(
						'/^[a-z]:/i', $custom['folderpath']
					))
						? trim($custom['folderpath'], '/')
						: '/' . trim($custom['folderpath'], '/');
					// remove the file path
					unset($custom['folderpath']);
					// triget fullpath
					$customPath = 'full';
				}
				// make sure we use the correct name
				$pathArray   = (array) explode('/', (string) $custom['path']);
				$firstFolder = array_values($pathArray)[0];
				$lastFolder  = end($pathArray);
				// only rename folder if last has folder name
				if (isset($custom['rename']) && $custom['rename'] == 1)
				{
					$custom['path'] = str_replace(
						'/' . $lastFolder, '', (string) $custom['path']
					);
					$rename         = 'new';
					$newname        = $lastFolder;
				}
				elseif ('full' === $customPath)
				{
					// make sure we use the correct name
					$folderArray = (array) explode('/', (string) $custom['folder']);
					$lastFolder  = end($folderArray);
					$rename      = 'new';
					$newname     = $lastFolder;
				}
				else
				{
					$lastFolder = $custom['folder'];
					$rename     = false;
					$newname    = '';
				}
				// insure we have no duplicates
				$key_pointer = StringHelper::safe(
						$custom['folder']
					) . '_f' . $pointer_tracker;
				$pointer_tracker++;
				// fix custom path
				$custom['path'] = ltrim((string) $custom['path'], '/');
				// set new folder to object
				$version_data->move->static->{$key_pointer}          = new stdClass();
				$version_data->move->static->{$key_pointer}->naam
				                                                    = str_replace(
					'//', '/', (string) $custom['folder']
				);
				$version_data->move->static->{$key_pointer}->path
				                                                    = $_target_type
					. '/' . $custom['path'];
				$version_data->move->static->{$key_pointer}->rename  = $rename;
				$version_data->move->static->{$key_pointer}->newName = $newname;
				$version_data->move->static->{$key_pointer}->type    = 'folder';
				$version_data->move->static->{$key_pointer}->custom
				                                                    = $customPath;
				// set the target if type and id is found
				if (isset($custom['target_id'])
					&& isset($custom['target_type']))
				{
					$version_data->move->static->{$key_pointer}->_target
						= array('key'  => $custom['target_id'] . '_'
						. $custom['target_type'],
						        'type' => $custom['target_type']);
				}
			}
			CFactory::_('Component')->remove('folders');
			unset($custom);
		}
		// get the google chart switch
		$google_chart = CFactory::_('Config')->get('google_chart', false);
		// add custom files
		if (CFactory::_('Component')->isArray('files')
				|| $google_chart)
		{
			if ($google_chart)
			{
				// move the google chart files
				CFactory::_('Component')->appendArray('files', array('file'   => 'google.jsapi.js',
				                                      'path'   => 'media/js',
				                                      'rename' => 0));
				CFactory::_('Component')->appendArray('files', array('file'   => 'chartbuilder.php',
				                                      'path'   => 'admin/helpers',
				                                      'rename' => 0));
			}

			// pointer tracker
			$pointer_tracker = 'h';
			foreach (CFactory::_('Component')->get('files') as $custom)
			{
				// check type of target type
				$_target_type = 'c0mp0n3nt';
				if (isset($custom['target_type']))
				{
					$_target_type = $custom['target_type'];
				}
				// for good practice
				ComponentbuilderHelper::fixPath(
					$custom, array('path', 'file', 'filepath')
				);
				// by default custom path is true
				$customPath = 'custom';
				// set full path if this is a full path file
				if (!isset($custom['file']) && isset($custom['filepath']))
				{
					// update the dynamic path
					$custom['filepath'] = $this->updateDynamicPath(
						$custom['filepath']
					);
					// set the file path with / if does not have a drive/windows full path
					$custom['file'] = (preg_match(
						'/^[a-z]:/i', $custom['filepath']
					))
						? trim($custom['filepath'], '/')
						: '/' . trim($custom['filepath'], '/');
					// remove the file path
					unset($custom['filepath']);
					// triget fullpath
					$customPath = 'full';
				}
				// make sure we have not duplicates
				$key_pointer = StringHelper::safe(
						$custom['file']
					) . '_g' . $pointer_tracker;
				$pointer_tracker++;
				// set new file to object
				$version_data->move->static->{$key_pointer}       = new stdClass();
				$version_data->move->static->{$key_pointer}->naam = str_replace(
					'//', '/', (string) $custom['file']
				);
				// update the dynamic component name placholders in file names
				$custom['path'] = CFactory::_('Placeholder')->update_(
					$custom['path']
				);
				// get the path info
				$pathInfo = pathinfo((string) $custom['path']);
				if (isset($pathInfo['extension']) && $pathInfo['extension'])
				{
					$pathInfo['dirname'] = trim($pathInfo['dirname'], '/');
					// set the info
					$version_data->move->static->{$key_pointer}->path
						                                               = $_target_type
						. '/' . $pathInfo['dirname'];
					$version_data->move->static->{$key_pointer}->rename = 'new';
					$version_data->move->static->{$key_pointer}->newName
						                                               = $pathInfo['basename'];
				}
				elseif ('full' === $customPath)
				{
					// fix custom path
					$custom['path'] = ltrim((string) $custom['path'], '/');
					// get file array
					$fileArray = (array) explode('/', (string) $custom['file']);
					// set the info
					$version_data->move->static->{$key_pointer}->path
						                                                = $_target_type
						. '/' . $custom['path'];
					$version_data->move->static->{$key_pointer}->rename  = 'new';
					$version_data->move->static->{$key_pointer}->newName = end(
						$fileArray
					);
				}
				else
				{
					// fix custom path
					$custom['path'] = ltrim((string) $custom['path'], '/');
					// set the info
					$version_data->move->static->{$key_pointer}->path
						                                               = $_target_type
						. '/' . $custom['path'];
					$version_data->move->static->{$key_pointer}->rename = false;
				}
				$version_data->move->static->{$key_pointer}->type = 'file';
				$version_data->move->static->{$key_pointer}->custom
				                                                 = $customPath;
				// set the target if type and id is found
				if (isset($custom['target_id'])
					&& isset($custom['target_type']))
				{
					$version_data->move->static->{$key_pointer}->_target
						= array('key'  => $custom['target_id'] . '_'
						. $custom['target_type'],
						        'type' => $custom['target_type']);
				}
				// check if file should be updated
				if (!isset($custom['notnew']) || $custom['notnew'] == 0
					|| $custom['notnew'] != 1)
				{
					$this->notNew[] = $key_pointer;
				}
				else
				{
					// update the file content
					$this->updateFileContent[$key_pointer] = true;
				}
			}
			CFactory::_('Component')->remove('files');
			unset($custom);
		}

		return $version_data;
	}

	/**
	 * Add the dynamic folders
	 */
	protected function setDynamicFolders()
	{
		// check if we should add the dynamic folder moving script to the installer script
		if (!CFactory::_('Registry')->get('set_move_folders_install_script'))
		{
			// add the setDynamicF0ld3rs() method to the install scipt.php file
			CFactory::_('Registry')->set('set_move_folders_install_script', true);
			// set message that this was done (will still add a tutorial link later)
			$this->app->enqueueMessage(
				JText::_(
					'<hr /><h3>Dynamic folder(s) were detected.</h3>'
				), 'Notice'
			);
			$this->app->enqueueMessage(
				JText::sprintf(
					'A method (setDynamicF0ld3rs) was added to the install <b>script.php</b> of this package to insure that the folder(s) are copied into the correct place when this component is installed!'
				), 'Notice'
			);
		}
	}

	/**
	 * set the index.html file in a folder path
	 *
	 * @param   string  $path  The path to place the index.html file in
	 *
	 * @return  void
	 * @deprecated 3.3 Use CFactory::_('Utilities.File')->write($path, $root);
	 *
	 */
	private function indexHTML($path, $root = 'component')
	{
		CFactory::_('Utilities.File')->write($path, $root);
	}

	/**
	 * Update paths with real value
	 *
	 * @param   string  $path  The full path
	 *
	 * @return  string   The updated path
	 *
	 */
	protected function updateDynamicPath($path)
	{
		return CFactory::_('Placeholder')->update_(
			CFactory::_('Placeholder')->update(
				$path, ComponentbuilderHelper::$constantPaths
			)
		);
	}

	/**
	 * Remove folders with files
	 *
	 * @param   string   $dir     The path to folder to remove
	 * @param   boolean  $ignore  The files and folders to ignore
	 *
	 * @return  boolean   True if all is removed
	 * @deprecated 3.3 Use CFactory::_('Utilities.Folder')->remove($dir, $ignore);
	 */
	protected function removeFolder($dir, $ignore = false)
	{
		return CFactory::_('Utilities.Folder')->remove($dir, $ignore);
	}

}
