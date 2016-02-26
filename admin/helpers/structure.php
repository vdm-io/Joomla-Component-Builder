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

	@version		2.0.8
	@build			30th January, 2016
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

// import the Joomla librarys
jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.archive');

/**
 * Structure class
 */
class Structure extends Get
{		
	/*
	 * The foulder counter
	 * 
	 * @var     int
	 */
	public $folderCount = 0;
	
	/*
	 * The foulder counter
	 * 
	 * @var     int
	 */
	public $fileCount = 0;
	
	/*
	 * The line counter
	 * 
	 * @var     int
	 */
	public $lineCount = 0;
	
	/*
	 * The Joomla Version
	 * 
	 * @var     string
	 */
	public $joomlaVersion;
	
	/*
	 * The template path
	 * 
	 * @var     string
	 */
	public $templatePath;
	
	/*
	 * The custom template path
	 * 
	 * @var     string
	 */
	public $templatePathCustom;
	
	/*
	 * The Joomla Version Data
	 * 
	 * @var      object
	 */
	public $joomlaVersionData;
	
	/*
	 * Static File Content
	 * 
	 * @var      array
	 */
	public $fileContentStatic = array();
	
	/*
	 * Dynamic File Content
	 * 
	 * @var      array
	 */
	public $fileContentDynamic = array();
	
	/*
	 * The Component Sales name
	 * 
	 * @var      string
	 */
	public $componentSalesName;
	
	/*
	 * The Component Backup name
	 * 
	 * @var      string
	 */
	public $componentBackupName;
	
	/*
	 * The Component Folder name
	 * 
	 * @var      string
	 */
	public $componentFolderName;
	
	/*
	 * The Component path
	 * 
	 * @var      string
	 */
	public $componentPath;
	
	/*
	 * The not new static items
	 * 
	 * @var      array
	 */
	public $notNew = array();
	
	/*
	 * The new files
	 * 
	 * @var     array
	 */
	public $newFiles = array();
	
	/*
	 * The Checkin Switch
	 * 
	 * @var     boolean
	 */
	public $addCheckin = false;
	
	/**
	 * Constructor
	 */
	public function __construct($config = array ())
	{
		// first we run the perent constructor
		if (parent::__construct($config))
		{			
			// set the Joomla version
			$this->joomlaVersion		= $config['joomlaVersion'];
			// set the template path
			$this->templatePath		= $this->compilerPath.'/joomla_'.$config['joomlaVersion'];
			// set some default names
			$this->componentSalesName	= 'com_'.$this->componentData->sales_name.'__J'.$this->joomlaVersion;
			$this->componentBackupName	= 'com_'.$this->componentData->sales_name.'_v'.str_replace('.','_',$this->componentData->component_version).'__J'.$this->joomlaVersion;
			$this->componentFolderName	= 'com_'.$this->componentData->name_code.'_v'.str_replace('.','_',$this->componentData->component_version).'__J'.$this->joomlaVersion;
			// set component folder path
			$this->componentPath		= $this->compilerPath.'/'.$this->componentFolderName;
			// set the template path for custom
			$this->templatePathCustom	= $this->params->get('custom_folder_path', JPATH_COMPONENT_ADMINISTRATOR.'/custom');
			// set the Joomla Version Data
			$this->joomlaVersionData	= $this->setJoomlaVersionData();
			// make sure there is no old build
			$this->removeFolder($this->componentPath);
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
	
	/*
	 * Build the Initial Folders
	 * 
	 * @return  void
	 * 
	 */
	private function setFolders()
	{
		if (ComponentbuilderHelper::checkObject($this->joomlaVersionData->create))
		{
			// creat the main componet folder
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
				if (!JFolder::exists($this->componentPath.'/'.$main))
				{
					JFolder::create($this->componentPath.'/'.$main);
					// count the folder created
					$this->folderCount++;
					$this->indexHTML($main);
				}
				if (ComponentbuilderHelper::checkObject($folders))
				{
					foreach ($folders as $sub => $subFolders)
					{
						if (!JFolder::exists($this->componentPath.'/'.$main.'/'.$sub))
						{
							JFolder::create($this->componentPath.'/'.$main.'/'.$sub);
							// count the folder created
							$this->folderCount++;
							$this->indexHTML($main.'/'.$sub);
						}
						if (ComponentbuilderHelper::checkObject($subFolders))
						{
							foreach ($subFolders as $sub_2 => $subFolders_2)
							{
								if (!JFolder::exists($this->componentPath.'/'.$main.'/'.$sub.'/'.$sub_2))
								{
									JFolder::create($this->componentPath.'/'.$main.'/'.$sub.'/'.$sub_2);
									// count the folder created
									$this->folderCount++;
									$this->indexHTML($main.'/'.$sub.'/'.$sub_2);
								}
								if (ComponentbuilderHelper::checkObject($subFolders_2))
								{
									foreach ($subFolders_2 as $sub_3 => $subFolders_3)
									{

										if (!JFolder::exists($this->componentPath.'/'.$main.'/'.$sub.'/'.$sub_2.'/'.$sub_3))
										{
											JFolder::create($this->componentPath.'/'.$main.'/'.$sub.'/'.$sub_2.'/'.$sub_3);
											// count the folder created
											$this->folderCount++;
											$this->indexHTML($main.'/'.$sub.'/'.$sub_2.'/'.$sub_3);
										}
										if (ComponentbuilderHelper::checkObject($subFolders_3))
										{
											foreach ($subFolders_3 as $sub_4 => $subFolders_4)
											{
												if (!JFolder::exists($this->componentPath.'/'.$main.'/'.$sub.'/'.$sub_2.'/'.$sub_3.'/'.$sub_4))
												{
													JFolder::create($this->componentPath.'/'.$main.'/'.$sub.'/'.$sub_2.'/'.$sub_3.'/'.$sub_4);
													// count the folder created
													$this->folderCount++;
													$this->indexHTML($main.'/'.$sub.'/'.$sub_2.'/'.$sub_3.'/'.$sub_4);
												}
												if (ComponentbuilderHelper::checkObject($subFolders_4))
												{
													foreach ($subFolders_4 as $sub_5 => $subFolders_5)
													{
														if (!JFolder::exists($this->componentPath.'/'.$main.'/'.$sub.'/'.$sub_2.'/'.$sub_3.'/'.$sub_4.'/'.$sub_5))
														{
															JFolder::create($this->componentPath.'/'.$main.'/'.$sub.'/'.$sub_2.'/'.$sub_3.'/'.$sub_4.'/'.$sub_5);
															// count the folder created
															$this->folderCount++;
															$this->indexHTML($main.'/'.$sub.'/'.$sub_2.'/'.$sub_3.'/'.$sub_4.'/'.$sub_5);
														}
														if (ComponentbuilderHelper::checkObject($subFolders_5))
														{
															foreach ($subFolders_5 as $sub_6 => $subFolders_6)
															{
																if (!JFolder::exists($this->componentPath.'/'.$main.'/'.$sub.'/'.$sub_2.'/'.$sub_3.'/'.$sub_4.'/'.$sub_5.'/'.$sub_6))
																{
																	JFolder::create($this->componentPath.'/'.$main.'/'.$sub.'/'.$sub_2.'/'.$sub_3.'/'.$sub_4.'/'.$sub_5.'/'.$sub_6);
																	// count the folder created
																	$this->folderCount++;
																	$this->indexHTML($main.'/'.$sub.'/'.$sub_2.'/'.$sub_3.'/'.$sub_4.'/'.$sub_5.'/'.$sub_6);
																}
																if (ComponentbuilderHelper::checkObject($subFolders_6))
																{
																	foreach ($subFolders_6 as $sub_7 => $subFolders_7)
																	{
																		if (!JFolder::exists($this->componentPath.'/'.$main.'/'.$sub.'/'.$sub_2.'/'.$sub_3.'/'.$sub_4.'/'.$sub_5.'/'.$sub_6.'/'.$sub_7))
																		{
																			JFolder::create($this->componentPath.'/'.$main.'/'.$sub.'/'.$sub_2.'/'.$sub_3.'/'.$sub_4.'/'.$sub_5.'/'.$sub_6.'/'.$sub_7);
																			// count the folder created
																			$this->folderCount++;
																			$this->indexHTML($main.'/'.$sub.'/'.$sub_2.'/'.$sub_3.'/'.$sub_4.'/'.$sub_5.'/'.$sub_6.'/'.$sub_7);
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
	
	/*
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
			if (strpos($licenseChecker,'gnu') !== false && strpos($licenseChecker,'gpl') !== false)
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
			// start moving
			foreach ($this->joomlaVersionData->move->static as $ftem => $details)
			{
				// set item
				$item = $details->naam;
				// do the file renaming
				if ($details->rename)
				{
					if ($details->rename == 'new')
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
				if ($item == 'LICENSE.txt' && !$LICENSE)
				{
					continue;
				}
				// if not needed do not add
				if ($item == 'README.md' && !$README)
				{
					continue;
				}
				// set destination path
				$zipPath	= str_replace('c0mp0n3nt/','', $details->path);
				$path		= str_replace('c0mp0n3nt/',$this->componentPath.'/', $details->path);
				// set the template folder path
				$templatePath = (isset($details->custom) && $details->custom) ? $this->templatePathCustom : $this->templatePath;
				// now mov the file
				if ($details->type == 'file')
				{
					// move the file to its place
					JFile::copy($templatePath.'/'.$item, $path.'/'.$new);
					// count the file created
					$this->fileCount++;
					// store the new files
					if (!in_array($ftem,$this->notNew))
					{
						$this->newFiles['static'][] = array( 'path' => $path.'/'.$new, 'name' => $new, 'zip' => $zipPath.'/'.$new );
					}
				}
				elseif ($details->type == 'folder')
				{
					// move the folder to its place
					JFolder::copy($templatePath.'/'.$item, $path.'/'.$new);
					// count the folder created
					$this->folderCount++;
				}
			}
			return true;
		}
		return false;
	}
	
	/*
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
			// setup dashboard
			$target = array('admin' => $this->componentData->name_code);
			$this->buildDynamique($target,'dashboard');
			// now the rest of the views
			foreach ($this->componentData->admin_views as $nr => $view)
			{
				if (ComponentbuilderHelper::checkObject($view['settings']))
				{
					if ($view['settings']->name_list != 'null')
					{
						$target = array('admin' => $view['settings']->name_list);
						$this->buildDynamique($target,'list');
					}
					if ($view['settings']->name_single != 'null')
					{
						$target = array('admin' => $view['settings']->name_single);
						$this->buildDynamique($target,'single');
					}
					if($view['edit_create_site_view'])
					{
						// setup the front site edit-view files
						$target = array('site' => $view['settings']->name_single);
						$this->buildDynamique($target,'edit');
					}
				}
				// quick set of checkin once
				if ($view['checkin'] == 1 && !$this->addCheckin)
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
				if ($view['settings']->main_get->gettype == 2)
				{
					// set list view
					$target = array('site' => $view['settings']->code);
					$this->buildDynamique($target,'list');
				}
				elseif ($view['settings']->main_get->gettype == 1)
				{
					// set single view
					$target = array('site' => $view['settings']->code);
					$this->buildDynamique($target,'single');
				}
			}
			$front = true;
		}
		if ((isset($this->joomlaVersionData->move->dynamic) && ComponentbuilderHelper::checkObject($this->joomlaVersionData->move->dynamic)) && (isset($this->componentData->custom_admin_views) && ComponentbuilderHelper::checkArray($this->componentData->custom_admin_views)))
		{
			foreach ($this->componentData->custom_admin_views as $nr => $view)
			{
				if ($view['settings']->main_get->gettype == 2)
				{
					// set list view
					$target = array('custom_admin' => $view['settings']->code);
					$this->buildDynamique($target,'list');
				}
				elseif ($view['settings']->main_get->gettype == 1)
				{
					// set single view
					$target = array('custom_admin' => $view['settings']->code);
					$this->buildDynamique($target,'single');
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
	
	/*
	 * Set the Static File & Folder
	 *  
	 * @param   array   $target  The main target and name
	 * @param   string   $type  The type in the target
	 * @param   string   $fileName  The custom file name
	 * 
	 * @return  boolean
	 * 
	 */
	public function buildDynamique($target,$type,$fileName = false)
	{
		if (ComponentbuilderHelper::checkArray($target))
		{
			foreach ($target as  $main => $name)
			{
				// make sure it is lower case
				$name = ComponentbuilderHelper::safeString($name);
				// setup the files
				foreach ($this->joomlaVersionData->move->dynamic->{$main} as $item => $details)
				{
					if ($details->type == $type)
					{
						// set destination path
						$path =  '';
						if (strpos($details->path,'VIEW') !== false)
						{
							$path = str_replace('VIEW',$name,$details->path);
						}
						else
						{
							$path = $details->path;
						}
						$zipPath	= str_replace('c0mp0n3nt/','', $path);
						$path		= str_replace('c0mp0n3nt/',$this->componentPath.'/', $path);

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
								$name = $name.'_'.$fileName;
							}
							elseif ($details->rename == 'new')
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
						if (!JFile::exists($path.'/'.$new))
						{
							// move the file to its place
							JFile::copy($this->templatePath.'/'.$item, $path.'/'.$new,'',true);
							// count the file created
							$this->fileCount++;
						}
						// store the new files
						$this->newFiles['dynamic'][$name][] = array( 'path' => $path.'/'.$new, 'name' => $new , 'view' => $name, 'zip' => $zipPath.'/'.$new);
					}
				}
			}
			return true;
		}
		return false;
	}
	
	/*
	 * set the Joomla Version Data
	 * 
	 *
	 * @return  oject The version data
	 * 
	 */
	private function setJoomlaVersionData()
	{
		// set the version data
		$versionData = json_decode(file_get_contents($this->templatePath.'/settings.json'));
		// add custom folders
		if ((isset($this->componentData->folders) && ComponentbuilderHelper::checkArray($this->componentData->folders)) || $this->addEximport || $this->uikit || $this->footable)
		{
			if ($this->addEximport)
			{
				// move the import view folder in place
				$importView = array( 'folder' => 'importViews', 'path' => 'admin/views/import', 'rename' => 1);
				$this->componentData->folders[] = $importView;
				// move the PHPExel Folder
				$PHPExcel = array( 'folder' => 'PHPExcel', 'path' => 'admin/helpers', 'rename' => 0);
				$this->componentData->folders[] = $PHPExcel;
			}
			if ($this->uikit)
			{
				// move the UIKIT Folder into place
				$uikit = array( 'folder' => 'uikit', 'path' => 'media', 'rename' => 0);
				$this->componentData->folders[] = $uikit;
			}
			if ($this->footable)
			{
				// move the footable folder into place
				$footable = array( 'folder' => 'footable', 'path' => 'media', 'rename' => 0);
				$this->componentData->folders[] = $footable;

			}
			
			// pointer tracker
			$pointer_tracker = 'h';
			foreach ($this->componentData->folders as $custom)
			{
				// fix path
				$custom['path'] = rtrim($custom['path'], '/');
				$custom['path'] = ltrim($custom['path'], '/');
				// make sure we use the correct name
				$pathArray = (array) explode('/',$custom['path']);
				$firstFolder = array_values($pathArray)[0];
				$lastFolder = end($pathArray);
				// only rename folder if last has folder name
				if ($custom['rename'] == 1)
				{
					$custom['path'] = str_replace('/'.$lastFolder,'',$custom['path']);
					$rename = 'new';
					$newname = $lastFolder;
					if(($tkey = array_search($lastFolder, $pathArray)) !== false)
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
				if (count($pathArray) == 1 && $firstFolder == 'media')
				{
					$this->fileContentStatic['###EXSTRA_MEDIA_FOLDERS###'] .= "\n\t\t<folder>".$lastFolder."</folder>";
				}
				// check if we sould add it to the site xml list
				if (!isset($this->fileContentStatic['###EXSTRA_SITE_FOLDERS###']))
				{
					$this->fileContentStatic['###EXSTRA_SITE_FOLDERS###'] = '';
				}
				if (count($pathArray) == 1 && $firstFolder == 'site')
				{
					$this->fileContentStatic['###EXSTRA_SITE_FOLDERS###'] .= "\n\t\t<folder>".$lastFolder."</folder>";
				}
				// check if we sould add it to the admin xml list
				if (!isset($this->fileContentStatic['###EXSTRA_ADMIN_FOLDERS###']))
				{
					$this->fileContentStatic['###EXSTRA_ADMIN_FOLDERS###'] = '';
				}
				if (count($pathArray) == 1 && $firstFolder == 'admin')
				{
					$this->fileContentStatic['###EXSTRA_ADMIN_FOLDERS###'] .= "\n\t\t\t<folder>".$lastFolder."</folder>";
				}
				// make we have not duplicates
				$key_pointer = ComponentbuilderHelper::safeString($custom['folder']).'_f'.$pointer_tracker;
				$pointer_tracker++;
				// set new folder to object
				$versionData->move->static->$key_pointer = new stdClass();
				$versionData->move->static->$key_pointer->naam = $custom['folder'];
				$versionData->move->static->$key_pointer->path = 'c0mp0n3nt/'.$custom['path'];
				$versionData->move->static->$key_pointer->rename = $rename;
				$versionData->move->static->$key_pointer->newName = $newname;
				$versionData->move->static->$key_pointer->type = 'folder';
				$versionData->move->static->$key_pointer->custom = true;
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
				$PHPExcel = array( 'file' => 'PHPExcel.php', 'path' => 'admin/helpers', 'rename' => 0);
				$this->componentData->files[] = $PHPExcel;
			}
			if ($this->googlechart)
			{
				// move the google chart files
				$googleChart = array( 'file' => 'google.jsapi.js', 'path' => 'media/js', 'rename' => 0);
				$this->componentData->files[] = $googleChart;
				$googleChart = array( 'file' => 'chartbuilder.php', 'path' => 'admin/helpers', 'rename' => 0);
				$this->componentData->files[] = $googleChart;
			}
			
			// pointer tracker
			$pointer_tracker = 'h';
			foreach ($this->componentData->files as $custom)
			{
				// make we have not duplicates
				$key_pointer = ComponentbuilderHelper::safeString($custom['file']).'_g'.$pointer_tracker;
				$pointer_tracker++;
				// set new file to object
				$versionData->move->static->$key_pointer = new stdClass();
				$versionData->move->static->$key_pointer->naam = $custom['file'];
				// get the path info
				$pathInfo = pathinfo($custom['path']);
				if (isset($pathInfo['extension']) && $pathInfo['extension'])
				{
					$pathInfo['dirname'] = rtrim($pathInfo['dirname'], '/');
					$pathInfo['dirname'] = ltrim($pathInfo['dirname'], '/');
					$versionData->move->static->$key_pointer->path = 'c0mp0n3nt/'.$pathInfo['dirname'];
					$versionData->move->static->$key_pointer->rename = 'new';
					$versionData->move->static->$key_pointer->newName = $pathInfo['basename'];
					// set the name
					$name = $pathInfo['basename'];
				}
				else
				{
					$custom['path'] = rtrim($custom['path'], '/');
					$custom['path'] = ltrim($custom['path'], '/');
					$versionData->move->static->$key_pointer->path = 'c0mp0n3nt/'.$custom['path'];
					$versionData->move->static->$key_pointer->rename = false;
					// set the name
					$name = $custom['file'];
				}
				// check if file should be updated
				if (isset($custom['notnew']) && $custom['notnew'] == 0)
				{
					$this->notNew[] = $key_pointer;
				}
				$versionData->move->static->$key_pointer->type = 'file';
				$versionData->move->static->$key_pointer->custom = true;
			}
			unset($this->componentData->files);
			unset($custom);
		}
		return $versionData;
	}
	
	/*
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
			JFile::copy($this->templatePath.'/index.html', $this->componentPath.'/'.$path.'/index.html');
			// count the file created
			$this->fileCount++;
		}
		else
		{
			JFile::copy($this->templatePath.'/index.html', $this->componentPath.'/index.html');
			// count the file created
			$this->fileCount++;
		}
	}
	
	/*
	 * Remove folders with files
	 * 
	 * @param   string   $dir  The path to folder to remove
	 * @param   boolean   $git  if there is a git folder in that must not be removed
	 *
	 * @return  boolean   True in all is removed
	 * 
	 */
	protected function removeFolder($dir, $git = false)
	{
		if (JFolder::exists($dir))
		{
			$it = new RecursiveDirectoryIterator($dir);
			$it = new RecursiveIteratorIterator($it, RecursiveIteratorIterator::CHILD_FIRST);
			foreach ($it as $file)
			{
				if ('.' === $file->getBasename() || '..' ===  $file->getBasename()) continue;
				if ($file->isDir())
				{
					if ($git && strpos($file->getPathname(), $dir.'/.git') !== false) continue;
					JFolder::delete($file->getPathname());
				}
				else
				{
					if ($git && strpos($file->getPathname(), $dir.'/.git') !== false) continue;
					JFile::delete($file->getPathname());
				}
			}
			if (!$git && JFolder::delete($dir))
			{
				return true;
			}
		}
		return false;
	}
}
