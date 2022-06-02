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


/**
 * Structure class
 */
class Structure extends Get
{

	/**
	 * The folder counter
	 *
	 * @var     int
	 */
	public $folderCount = 0;

	/**
	 * The file counter
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
	 * The Dynamic paths
	 *
	 * @var      array
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
	public function __construct($config = array())
	{
		// first we run the perent constructor
		if (parent::__construct($config))
		{
			// set the standard admin file
			$this->stdRootFiles[] = $this->componentData->name_code . '.php';
			// set incase no extra admin folder are loaded
			$this->fileContentStatic[$this->hhh . 'EXSTRA_ADMIN_FOLDERS'
			. $this->hhh]
				= '';
			// set incase no extra site folder are loaded
			$this->fileContentStatic[$this->hhh . 'EXSTRA_SITE_FOLDERS'
			. $this->hhh]
				= '';
			// set incase no extra media folder are loaded
			$this->fileContentStatic[$this->hhh . 'EXSTRA_MEDIA_FOLDERS'
			. $this->hhh]
				= '';
			// set incase no extra admin files are loaded
			$this->fileContentStatic[$this->hhh . 'EXSTRA_ADMIN_FILES'
			. $this->hhh]
				= '';
			// set incase no extra site files are loaded
			$this->fileContentStatic[$this->hhh . 'EXSTRA_SITE_FILES'
			. $this->hhh]
				= '';
			// set incase no extra media files are loaded
			$this->fileContentStatic[$this->hhh . 'EXSTRA_MEDIA_FILES'
			. $this->hhh]
				= '';
			// run global updater
			ComponentbuilderHelper::runGlobalUpdater();
			// set the template path
			$this->templatePath = $this->compilerPath . '/joomla_'
				. $this->joomlaVersions[$this->joomlaVersion]['folder_key'];
			// set some default names
			$this->componentSalesName  = 'com_'
				. $this->componentData->sales_name . '__J'
				. $this->joomlaVersion;
			$this->componentBackupName = 'com_'
				. $this->componentData->sales_name . '_v' . str_replace(
					'.', '_', $this->componentData->component_version
				) . '__J' . $this->joomlaVersion;
			$this->componentFolderName = 'com_'
				. $this->componentData->name_code . '_v' . str_replace(
					'.', '_', $this->componentData->component_version
				) . '__J' . $this->joomlaVersion;
			// set component folder path
			$this->componentPath = $this->compilerPath . '/'
				. $this->componentFolderName;
			// set the template path for custom
			$this->templatePathCustom = $this->params->get(
				'custom_folder_path', JPATH_COMPONENT_ADMINISTRATOR . '/custom'
			);
			// make sure there is no old build
			$this->removeFolder($this->componentPath);
			// load the libraries files/folders and url's
			$this->setLibraries();
			// load the powers files/folders
			$this->buildPowers();
			// load the module files/folders and url's
			$this->buildModules();
			// load the plugin files/folders and url's
			$this->buildPlugins();
			// set the Joomla Version Data
			$this->joomlaVersionData = $this->setJoomlaVersionData();
			// Trigger Event: jcb_ce_onAfterSetJoomlaVersionData
			$this->triggerEvent(
				'jcb_ce_onAfterSetJoomlaVersionData',
				array(&$this->componentContext, &$this->joomlaVersionData)
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
	 * Set the line number in comments
	 *
	 * @param   int  $nr  The line number
	 *
	 * @return  string
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
	 * Build the Powers files, folders
	 *
	 * @return  void
	 *
	 */
	private function buildPowers()
	{
		if (ArrayHelper::check($this->powers))
		{
			// Trigger Event: jcb_ce_onBeforeSetModules
			$this->triggerEvent(
				'jcb_ce_onBeforeBuildPowers',
				array(&$this->componentContext, &$this->powers)
			);
			// we track the creation of htaccess files
			$htaccess = array();
			foreach ($this->powers as $power)
			{
				if (ObjectHelper::check($power)
					&& isset($power->path)
					&& StringHelper::check(
						$power->path
					))
				{
					// activate dynamic folders
					$this->setDynamicFolders();
					// power path
					$power->full_path        = $this->componentPath . '/'
						. $power->path;
					$power->full_path_jcb    = $this->componentPath . '/'
						. $power->path_jcb;
					$power->full_path_parent = $this->componentPath . '/'
						. $power->path_parent;
					// set the power paths
					$this->dynamicPaths[$power->key] = $power->full_path_parent;
					// create the power folder if it does not exist
					// we do it like this to add html files to each part
					$this->createFolder($power->full_path_jcb);
					$this->createFolder($power->full_path_parent);
					$this->createFolder($power->full_path);
					// set power file
					$fileDetails = array('path' => $power->full_path . '/'
						. $power->file_name . '.php',
					                     'name' => $power->file_name . '.php',
					                     'zip' => $power->file_name . '.php');
					$this->writeFile(
						$fileDetails['path'],
						'<?php' . PHP_EOL . '// A POWER FILE' .
						PHP_EOL . $this->hhh . 'BOM' . $this->hhh . PHP_EOL .
						PHP_EOL . $this->hhh . 'POWERCODE' . $this->hhh
					);
					$this->newFiles[$power->key][] = $fileDetails;
					// count the file created
					$this->fileCount++;
					if (!isset($htaccess[$power->path_jcb]))
					{
						// set the htaccess data
						$data = '# Apache 2.4+' . PHP_EOL .
							'<IfModule mod_authz_core.c>' . PHP_EOL .
							'  Require all denied' . PHP_EOL .
							'</IfModule>' . PHP_EOL . PHP_EOL .
							'# Apache 2.0-2.2' . PHP_EOL .
							'<IfModule !mod_authz_core.c>' . PHP_EOL .
							'  Deny from all' . PHP_EOL .
							'</IfModule>' . PHP_EOL;
						// now we must add the .htaccess file
						$fileDetails = array('path' => $power->full_path_jcb . '/.htaccess',
						                     'name' => '.htaccess',
						                     'zip'  => '.htaccess');
						$this->writeFile(
							$fileDetails['path'], $data
						);
						$this->newFiles[$power->key][] = $fileDetails;
						// count the file created
						$this->fileCount++;
						// now we must add the htaccess.txt file where the zip package my not get the [.] files
						$fileDetails = array('path' => $power->full_path_jcb . '/htaccess.txt',
						                     'name' => 'htaccess.txt',
						                     'zip'  => 'htaccess.txt');
						$this->writeFile(
							$fileDetails['path'], $data
						);
						$this->newFiles[$power->key][] = $fileDetails;
						// count the file created
						$this->fileCount++;
						// now we must add the web.config file
						$fileDetails = array('path' => $power->full_path_jcb . '/web.config',
						                     'name' => 'web.config',
						                     'zip'  => 'web.config');
						$this->writeFile(
							$fileDetails['path'],
							'<?xml version="1.0"?>' . PHP_EOL .
							'    <system.web>' . PHP_EOL .
							'        <authorization>' . PHP_EOL .
							'            <deny users="*" />' . PHP_EOL .
							'        </authorization>' . PHP_EOL .
							'    </system.web>' . PHP_EOL .
							'</configuration>' . PHP_EOL
						);
						$this->newFiles[$power->key][] = $fileDetails;
						// count the file created
						$this->fileCount++;
						// we set these files only once
						$htaccess[$power->path_jcb] = true;
					}
				}
			}
		}
	}

	/**
	 * Build the Modules files, folders, url's and config
	 *
	 * @return  void
	 *
	 */
	private function buildModules()
	{
		if (ArrayHelper::check($this->joomlaModules))
		{
			// Trigger Event: jcb_ce_onBeforeSetModules
			$this->triggerEvent(
				'jcb_ce_onBeforeBuildModules',
				array(&$this->componentContext, &$this->joomlaModules)
			);
			foreach ($this->joomlaModules as $module)
			{
				if (ObjectHelper::check($module)
					&& isset($module->folder_name)
					&& StringHelper::check(
						$module->folder_name
					))
				{
					// module path
					$module->folder_path = $this->compilerPath . '/'
						. $module->folder_name;
					// set the module paths
					$this->dynamicPaths[$module->key] = $module->folder_path;
					// make sure there is no old build
					$this->removeFolder($module->folder_path);
					// creat the main module folder
					$this->createFolder($module->folder_path);
					// set main mod file
					$fileDetails = array('path' => $module->folder_path . '/'
						. $module->file_name . '.php',
					                     'name' => $module->file_name . '.php',
					                     'zip'  => $module->file_name . '.php');
					$this->writeFile(
						$fileDetails['path'],
						'<?php' . PHP_EOL . '// main modfile' .
						PHP_EOL . $this->hhh . 'BOM' . $this->hhh . PHP_EOL .
						PHP_EOL . '// No direct access to this file' . PHP_EOL .
						"defined('_JEXEC') or die('Restricted access');"
						. PHP_EOL .
						$this->hhh . 'MODCODE' . $this->hhh
					);
					$this->newFiles[$module->key][] = $fileDetails;
					// count the file created
					$this->fileCount++;
					// set custom_get
					if ($module->custom_get)
					{
						$fileDetails = array('path' => $module->folder_path
							. '/data.php',
						                     'name' => 'data.php',
						                     'zip'  => 'data.php');
						$this->writeFile(
							$fileDetails['path'],
							'<?php' . PHP_EOL . '// get data file' .
							PHP_EOL . $this->hhh . 'BOM' . $this->hhh . PHP_EOL
							.
							PHP_EOL . '// No direct access to this file'
							. PHP_EOL .
							"defined('_JEXEC') or die('Restricted access');"
							. PHP_EOL . PHP_EOL .
							'/**' . PHP_EOL .
							' * Module ' . $module->official_name . ' Data'
							. PHP_EOL .
							' */' . PHP_EOL .
							"class " . $module->class_data_name
							. ' extends \JObject' . PHP_EOL .
							"{" . $this->hhh . 'DYNAMICGETS' . $this->hhh . "}"
							. PHP_EOL
						);
						$this->newFiles[$module->key][] = $fileDetails;
						// count the file created
						$this->fileCount++;
					}
					// set helper file
					if ($module->add_class_helper >= 1)
					{
						$fileDetails = array('path' => $module->folder_path
							. '/helper.php',
						                     'name' => 'helper.php',
						                     'zip'  => 'helper.php');
						$this->writeFile(
							$fileDetails['path'],
							'<?php' . PHP_EOL . '// helper file' .
							PHP_EOL . $this->hhh . 'BOM' . $this->hhh . PHP_EOL
							.
							PHP_EOL . '// No direct access to this file'
							. PHP_EOL .
							"defined('_JEXEC') or die('Restricted access');"
							. PHP_EOL .
							$this->hhh . 'HELPERCODE' . $this->hhh
						);
						$this->newFiles[$module->key][] = $fileDetails;
						// count the file created
						$this->fileCount++;
					}
					// set main xml file
					$fileDetails = array('path' => $module->folder_path . '/'
						. $module->file_name . '.xml',
					                     'name' => $module->file_name . '.xml',
					                     'zip'  => $module->file_name . '.xml');
					$this->writeFile(
						$fileDetails['path'],
						$this->getModuleXMLTemplate($module)
					);
					$this->newFiles[$module->key][] = $fileDetails;
					// count the file created
					$this->fileCount++;
					// set tmpl folder
					$this->createFolder($module->folder_path . '/tmpl');
					// set default file
					$fileDetails = array('path' => $module->folder_path
						. '/tmpl/default.php',
					                     'name' => 'default.php',
					                     'zip'  => 'tmpl/default.php');
					$this->writeFile(
						$fileDetails['path'],
						'<?php' . PHP_EOL . '// default tmpl' .
						PHP_EOL . $this->hhh . 'BOM' . $this->hhh . PHP_EOL .
						PHP_EOL . '// No direct access to this file' . PHP_EOL .
						"defined('_JEXEC') or die('Restricted access');"
						. PHP_EOL .
						$this->hhh . 'MODDEFAULT' . $this->hhh
					);
					$this->newFiles[$module->key][] = $fileDetails;
					// count the file created
					$this->fileCount++;
					// set install script if needed
					if ($module->add_install_script)
					{
						$fileDetails = array('path' => $module->folder_path
							. '/script.php',
						                     'name' => 'script.php',
						                     'zip'  => 'script.php');
						$this->writeFile(
							$fileDetails['path'],
							'<?php' . PHP_EOL . '// Script template' .
							PHP_EOL . $this->hhh . 'BOM' . $this->hhh . PHP_EOL
							.
							PHP_EOL . '// No direct access to this file'
							. PHP_EOL .
							"defined('_JEXEC') or die('Restricted access');"
							. PHP_EOL .
							$this->hhh . 'INSTALLCLASS' . $this->hhh
						);
						$this->newFiles[$module->key][] = $fileDetails;
						// count the file created
						$this->fileCount++;
					}
					// set readme if found
					if ($module->addreadme)
					{
						$fileDetails = array('path' => $module->folder_path
							. '/README.md',
						                     'name' => 'README.md',
						                     'zip'  => 'README.md');
						$this->writeFile($fileDetails['path'], $module->readme);
						$this->newFiles[$module->key][] = $fileDetails;
						// count the file created
						$this->fileCount++;
					}
					// set the folders target path
					$target_path = '';
					if ($module->target_client === 'administrator')
					{
						$target_path = '/administrator';
					}
					// check if we have custom fields needed for scripts
					$module->add_scripts_field = false;
					$field_script_bucket       = array();
					// add any css from the fields
					if (($css = $this->getCustomScriptBuilder(
							'css_view', $module->key
						)) !== null
						&& StringHelper::check($css))
					{
						// make sure this script does not have PHP
						if (strpos($css, '<?php') === false)
						{
							// make sure the field is added
							$module->add_scripts_field = true;
							// create the css folder
							$this->createFolder($module->folder_path . '/css');
							// add the CSS file
							$fileDetails = array('path' => $module->folder_path
								. '/css/mod_admin.css',
							                     'name' => 'mod_admin.css',
							                     'zip'  => 'mod_admin.css');
							$this->writeFile(
								$fileDetails['path'],
								$this->hhh . 'BOM' . $this->hhh . PHP_EOL
								. PHP_EOL . $css
							);
							$this->newFiles[$module->key][] = $fileDetails;
							// count the file created
							$this->fileCount++;
							// add the field script
							$field_script_bucket[] = $this->_t(2) . "//"
								. $this->setLine(__LINE__) . " Custom CSS";
							$field_script_bucket[] = $this->_t(2)
								. "\$document->addStyleSheet('" . $target_path
								. "/modules/" . $module->folder_name
								. "/css/mod_admin.css', ['version' => 'auto', 'relative' => true]);";
						}
					}
					// add any JavaScript from the fields
					if (($javascript = $this->getCustomScriptBuilder(
							'view_footer', $module->key
						)) !== null
						&& StringHelper::check($javascript))
					{
						// make sure this script does not have PHP
						if (strpos($javascript, '<?php') === false)
						{
							// make sure the field is added
							$module->add_scripts_field = true;
							// add the JavaScript file
							$this->createFolder($module->folder_path . '/js');
							// add the CSS file
							$fileDetails = array('path' => $module->folder_path
								. '/js/mod_admin.js',
							                     'name' => 'mod_admin.js',
							                     'zip'  => 'mod_admin.js');
							$this->writeFile(
								$fileDetails['path'],
								$this->hhh . 'BOM' . $this->hhh . PHP_EOL
								. PHP_EOL . $javascript
							);
							$this->newFiles[$module->key][] = $fileDetails;
							// count the file created
							$this->fileCount++;
							// add the field script
							$field_script_bucket[] = $this->_t(2) . "//"
								. $this->setLine(__LINE__) . " Custom JS";
							$field_script_bucket[] = $this->_t(2)
								. "\$document->addScript('" . $target_path
								. "/modules/" . $module->folder_name
								. "/js/mod_admin.js', ['version' => 'auto', 'relative' => true]);";
						}
					}
					// set fields folders if needed
					if ($module->add_scripts_field
						|| (isset($module->fields_rules_paths)
							&& $module->fields_rules_paths == 2))
					{
						// create fields folder
						$this->createFolder($module->folder_path . '/fields');
						// add the custom script field
						if ($module->add_scripts_field)
						{
							$fileDetails = array('path' => $module->folder_path
								. '/fields/modadminvvvvvvvdm.php',
							                     'name' => 'modadminvvvvvvvdm.php',
							                     'zip'  => 'modadminvvvvvvvdm.php');
							$this->writeFile(
								$fileDetails['path'],
								$this->getModAdminVvvvvvvdm(
									$field_script_bucket
								)
							);
							$this->newFiles[$module->key][] = $fileDetails;
							// count the file created
							$this->fileCount++;
						}
					}
					// set rules folders if needed
					if (isset($module->fields_rules_paths)
						&& $module->fields_rules_paths == 2)
					{
						// create rules folder
						$this->createFolder($module->folder_path . '/rules');
					}
					// set forms folder if needed
					if (isset($module->form_files)
						&& ArrayHelper::check(
							$module->form_files
						))
					{
						// create forms folder
						$this->createFolder($module->folder_path . '/forms');
						// set the template files
						foreach ($module->form_files as $file => $fields)
						{
							// set file details
							$fileDetails = array('path' => $module->folder_path
								. '/forms/' . $file . '.xml',
							                     'name' => $file . '.xml',
							                     'zip'  => 'forms/' . $file
								                     . '.xml');
							// build basic XML
							$xml = '<?xml version="1.0" encoding="utf-8"?>';
							$xml .= PHP_EOL . '<!--' . $this->setLine(__LINE__)
								. ' default paths of ' . $file
								. ' form points to ' . $this->componentCodeName
								. ' -->';
							// search if we must add the component path
							$add_component_path = false;
							foreach ($fields as $field_name => $fieldsets)
							{
								if (!$add_component_path)
								{
									foreach ($fieldsets as $fieldset => $field)
									{
										if (!$add_component_path
											&& isset(
												$module->fieldsets_paths[$file
												. $field_name . $fieldset]
											)
											&& $module->fieldsets_paths[$file
											. $field_name . $fieldset] == 1)
										{
											$add_component_path = true;
										}
									}
								}
							}
							// only add if part of the component field types path is required
							if ($add_component_path)
							{
								$xml .= PHP_EOL . '<form';
								$xml .= PHP_EOL . $this->_t(1)
									. 'addrulepath="/administrator/components/com_'
									. $this->componentCodeName
									. '/models/rules"';
								$xml .= PHP_EOL . $this->_t(1)
									. 'addfieldpath="/administrator/components/com_'
									. $this->componentCodeName
									. '/models/fields"';
								$xml .= PHP_EOL . '>';
							}
							else
							{
								$xml .= PHP_EOL . '<form>';
							}
							// add the fields
							foreach ($fields as $field_name => $fieldsets)
							{
								// check if we have an double fields naming set
								$field_name_inner = '';
								$field_name_outer = $field_name;
								if (strpos($field_name, '.') !== false)
								{
									$field_names = explode('.', $field_name);
									if (count((array) $field_names) == 2)
									{
										$field_name_outer = $field_names[0];
										$field_name_inner = $field_names[1];
									}
								}
								$xml .= PHP_EOL . $this->_t(1)
									. '<fields name="' . $field_name_outer
									. '">';
								foreach ($fieldsets as $fieldset => $field)
								{
									// default to the field set name
									$label = $fieldset;
									if (isset($module->fieldsets_label[$file . $field_name . $fieldset]))
									{
										$label = $module->fieldsets_label[$file . $field_name . $fieldset];
									}
									// add path to module rules and custom fields
									if (isset($module->fieldsets_paths[$file . $field_name . $fieldset])
										&& ($module->fieldsets_paths[$file . $field_name . $fieldset] == 2
											|| $module->fieldsets_paths[$file . $field_name . $fieldset] == 3))
									{
										if ($module->target == 2)
										{
											if (!isset($module->add_rule_path[$file . $field_name . $fieldset]))
											{
												$module->add_rule_path[$file . $field_name . $fieldset] =
													'/administrator/modules/'
													. $module->file_name . '/rules';
											}

											if (!isset($module->add_field_path[$file . $field_name . $fieldset]))
											{
												$module->add_field_path[$file . $field_name . $fieldset] =
													'/administrator/modules/'
													. $module->file_name . '/fields';
											}
										}
										else
										{
											if (!isset($module->add_rule_path[$file . $field_name . $fieldset]))
											{
												$module->add_rule_path[$file . $field_name . $fieldset] =
													'/modules/' . $module->file_name
													. '/rules';
											}

											if (!isset($module->add_field_path[$file . $field_name . $fieldset]))
											{
												$module->add_field_path[$file . $field_name . $fieldset] =
													'/modules/' . $module->file_name
													. '/fields';
											}
										}
									}
									// add path to module rules and custom fields
									if (isset($module->add_rule_path[$file . $field_name . $fieldset])
										|| isset($module->add_field_path[$file . $field_name . $fieldset]))
									{

										$xml .= PHP_EOL . $this->_t(1) . '<!--'
											. $this->setLine(__LINE__) . ' default paths of '
											. $fieldset . ' fieldset points to the module -->';

										$xml .= PHP_EOL . $this->_t(1) . '<fieldset name="'
											. $fieldset . '" label="' . $label . '"';

										if (isset($module->add_rule_path[$file . $field_name . $fieldset]))
										{
											$xml .= PHP_EOL . $this->_t(2)
												. 'addrulepath="' . $module->add_rule_path[$file . $field_name . $fieldset] . '"';
										}

										if (isset($module->add_field_path[$file . $field_name . $fieldset]))
										{
											$xml .= PHP_EOL . $this->_t(2)
												. 'addfieldpath="' . $module->add_field_path[$file . $field_name . $fieldset] . '"';
										}

										$xml .= PHP_EOL . $this->_t(1) . '>';
									}
									else
									{
										$xml .= PHP_EOL . $this->_t(1) . '<fieldset name="'
											. $fieldset . '" label="' . $label . '">';
									}
									// check if we have an inner field set
									if (StringHelper::check(
										$field_name_inner
									))
									{
										$xml .= PHP_EOL . $this->_t(1)
											. '<fields name="'
											. $field_name_inner . '">';
									}
									// add the placeholder of the fields
									$xml .= $this->hhh . 'FIELDSET_' . $file
										. $field_name . $fieldset . $this->hhh;
									// check if we have an inner field set
									if (StringHelper::check(
										$field_name_inner
									))
									{
										$xml .= PHP_EOL . $this->_t(1)
											. '</fields>';
									}
									$xml .= PHP_EOL . $this->_t(1)
										. '</fieldset>';
								}
								$xml .= PHP_EOL . $this->_t(1) . '</fields>';
							}
							$xml .= PHP_EOL . '</form>';
							// add xml to file
							$this->writeFile($fileDetails['path'], $xml);
							$this->newFiles[$module->key][] = $fileDetails;
							// count the file created
							$this->fileCount++;
						}
					}
					// set SQL stuff if needed
					if ($module->add_sql || $module->add_sql_uninstall)
					{
						// create SQL folder
						$this->createFolder($module->folder_path . '/sql');
						// create mysql folder
						$this->createFolder(
							$module->folder_path . '/sql/mysql'
						);
						// now set the install file
						if ($module->add_sql)
						{
							$this->writeFile(
								$module->folder_path . '/sql/mysql/install.sql',
								$module->sql
							);
							// count the file created
							$this->fileCount++;
						}
						// now set the uninstall file
						if ($module->add_sql_uninstall)
						{
							$this->writeFile(
								$module->folder_path
								. '/sql/mysql/uninstall.sql',
								$module->sql_uninstall
							);
							// count the file created
							$this->fileCount++;
						}
					}
					// creat the language folder
					$this->createFolder($module->folder_path . '/language');
					// also create the lang tag folder
					$this->createFolder(
						$module->folder_path . '/language/' . $this->langTag
					);
					// check if this lib has files
					if (isset($module->files)
						&& ArrayHelper::check($module->files))
					{
						// add to component files
						foreach ($module->files as $file)
						{
							// set the path finder
							$file['target_type']          = $module->target_type;
							$file['target_id']            = $module->id;
							$this->componentData->files[] = $file;
						}
					}
					// check if this lib has folders
					if (isset($module->folders)
						&& ArrayHelper::check($module->folders))
					{
						// add to component folders
						foreach ($module->folders as $folder)
						{
							// set the path finder
							$folder['target_type']          = $module->target_type;
							$folder['target_id']            = $module->id;
							$this->componentData->folders[] = $folder;
						}
					}
					// check if this module has urls
					if (isset($module->urls)
						&& ArrayHelper::check($module->urls))
					{
						// add to component urls
						foreach ($module->urls as $n => &$url)
						{
							// should we add the local folder
							if (isset($url['type']) && $url['type'] > 1
								&& isset($url['url'])
								&& StringHelper::check(
									$url['url']
								))
							{
								// set file name
								$fileName = basename($url['url']);
								// get the file contents
								$data = FileHelper::getContent(
									$url['url']
								);
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
								$this->createFolder(
									$module->folder_path . $path
								);
								// set the path to module file
								$url['path'] = $module->folder_path . $path
									. '/' . $fileName; // we need this for later
								// write data to path
								$this->writeFile($url['path'], $data);
								// count the file created
								$this->fileCount++;
							}
						}
					}
				}
			}
		}
	}

	/**
	 * Build the Plugins files, folders, url's and config
	 *
	 * @return  void
	 *
	 */
	private function buildPlugins()
	{
		if (ArrayHelper::check($this->joomlaPlugins))
		{
			// Trigger Event: jcb_ce_onBeforeSetPlugins
			$this->triggerEvent(
				'jcb_ce_onBeforeBuildPlugins',
				array(&$this->componentContext, &$this->joomlaPlugins)
			);
			foreach ($this->joomlaPlugins as $plugin)
			{
				if (ObjectHelper::check($plugin)
					&& isset($plugin->folder_name)
					&& StringHelper::check(
						$plugin->folder_name
					))
				{
					// plugin path
					$plugin->folder_path = $this->compilerPath . '/'
						. $plugin->folder_name;
					// set the plugin paths
					$this->dynamicPaths[$plugin->key] = $plugin->folder_path;
					// make sure there is no old build
					$this->removeFolder($plugin->folder_path);
					// creat the main component folder
					$this->createFolder($plugin->folder_path);
					// set main class file
					$fileDetails = array('path' => $plugin->folder_path . '/'
						. $plugin->file_name . '.php',
					                     'name' => $plugin->file_name . '.php',
					                     'zip'  => $plugin->file_name . '.php');
					$this->writeFile(
						$fileDetails['path'],
						'<?php' . PHP_EOL . '// Plugin main class template' .
						PHP_EOL . $this->hhh . 'BOM' . $this->hhh . PHP_EOL .
						PHP_EOL . '// No direct access to this file' . PHP_EOL .
						"defined('_JEXEC') or die('Restricted access');"
						. PHP_EOL .
						$this->hhh . 'MAINCLASS' . $this->hhh
					);
					$this->newFiles[$plugin->key][] = $fileDetails;
					// count the file created
					$this->fileCount++;
					// set main xml file
					$fileDetails = array('path' => $plugin->folder_path . '/'
						. $plugin->file_name . '.xml',
					                     'name' => $plugin->file_name . '.xml',
					                     'zip'  => $plugin->file_name . '.xml');
					$this->writeFile(
						$fileDetails['path'],
						$this->getPluginXMLTemplate($plugin)
					);
					$this->newFiles[$plugin->key][] = $fileDetails;
					// count the file created
					$this->fileCount++;
					// set install script if needed
					if ($plugin->add_install_script)
					{
						$fileDetails = array('path' => $plugin->folder_path
							. '/script.php',
						                     'name' => 'script.php',
						                     'zip'  => 'script.php');
						$this->writeFile(
							$fileDetails['path'],
							'<?php' . PHP_EOL . '// Script template' .
							PHP_EOL . $this->hhh . 'BOM' . $this->hhh . PHP_EOL
							.
							PHP_EOL . '// No direct access to this file'
							. PHP_EOL .
							"defined('_JEXEC') or die('Restricted access');"
							. PHP_EOL .
							$this->hhh . 'INSTALLCLASS' . $this->hhh
						);
						$this->newFiles[$plugin->key][] = $fileDetails;
						// count the file created
						$this->fileCount++;
					}
					// set readme if found
					if ($plugin->addreadme)
					{
						$fileDetails = array('path' => $plugin->folder_path
							. '/README.md',
						                     'name' => 'README.md',
						                     'zip'  => 'README.md');
						$this->writeFile($fileDetails['path'], $plugin->readme);
						$this->newFiles[$plugin->key][] = $fileDetails;
						// count the file created
						$this->fileCount++;
					}
					// set fields & rules folders if needed
					if (isset($plugin->fields_rules_paths)
						&& $plugin->fields_rules_paths == 2)
					{
						// create fields folder
						$this->createFolder($plugin->folder_path . '/fields');
						// create rules folder
						$this->createFolder($plugin->folder_path . '/rules');
					}
					// set forms folder if needed
					if (isset($plugin->form_files)
						&& ArrayHelper::check(
							$plugin->form_files
						))
					{
						// create forms folder
						$this->createFolder($plugin->folder_path . '/forms');
						// set the template files
						foreach ($plugin->form_files as $file => $fields)
						{
							// set file details
							$fileDetails = array('path' => $plugin->folder_path
								. '/forms/' . $file . '.xml',
							                     'name' => $file . '.xml',
							                     'zip'  => 'forms/' . $file
								                     . '.xml');
							// biuld basic XML
							$xml = '<?xml version="1.0" encoding="utf-8"?>';
							$xml .= PHP_EOL . '<!--' . $this->setLine(__LINE__)
								. ' default paths of ' . $file
								. ' form points to ' . $this->componentCodeName
								. ' -->';
							// search if we must add the component path
							$add_component_path = false;
							foreach ($fields as $field_name => $fieldsets)
							{
								if (!$add_component_path)
								{
									foreach ($fieldsets as $fieldset => $field)
									{
										if (!$add_component_path
											&& isset(
												$plugin->fieldsets_paths[$file
												. $field_name . $fieldset]
											)
											&& $plugin->fieldsets_paths[$file
											. $field_name . $fieldset] == 1)
										{
											$add_component_path = true;
										}
									}
								}
							}
							// only add if part of the component field types path is required
							if ($add_component_path)
							{
								$xml .= PHP_EOL . '<form';
								$xml .= PHP_EOL . $this->_t(1)
									. 'addrulepath="/administrator/components/com_'
									. $this->componentCodeName
									. '/models/rules"';
								$xml .= PHP_EOL . $this->_t(1)
									. 'addfieldpath="/administrator/components/com_'
									. $this->componentCodeName
									. '/models/fields"';
								$xml .= PHP_EOL . '>';
							}
							else
							{
								$xml .= PHP_EOL . '<form>';
							}
							// add the fields
							foreach ($fields as $field_name => $fieldsets)
							{
								// check if we have an double fields naming set
								$field_name_inner = '';
								$field_name_outer = $field_name;
								if (strpos($field_name, '.') !== false)
								{
									$field_names = explode('.', $field_name);
									if (count((array) $field_names) == 2)
									{
										$field_name_outer = $field_names[0];
										$field_name_inner = $field_names[1];
									}
								}
								$xml .= PHP_EOL . $this->_t(1)
									. '<fields name="' . $field_name_outer
									. '">';
								foreach ($fieldsets as $fieldset => $field)
								{
									// default to the field set name
									$label = $fieldset;
									if (isset($plugin->fieldsets_label[$file . $field_name . $fieldset]))
									{
										$label = $plugin->fieldsets_label[$file . $field_name . $fieldset];
									}
									// add path to plugin rules and custom fields
									if (isset($plugin->fieldsets_paths[$file . $field_name . $fieldset])
										&& ($plugin->fieldsets_paths[$file . $field_name . $fieldset] == 2
											|| $plugin->fieldsets_paths[$file . $field_name . $fieldset] == 3))
									{
										if (!isset($plugin->add_rule_path[$file . $field_name . $fieldset]))
										{
											$plugin->add_rule_path[$file . $field_name . $fieldset] =
												'/plugins/' . strtolower($plugin->group
												) . '/' . strtolower($plugin->code_name)
												. '/rules';
										}

										if (!isset($plugin->add_field_path[$file . $field_name . $fieldset]))
										{
											$plugin->add_field_path[$file . $field_name . $fieldset] =
												'/plugins/' . strtolower($plugin->group
												) . '/' . strtolower($plugin->code_name)
												. '/fields';
										}
									}
									// add path to plugin rules and custom fields
									if (isset($plugin->add_rule_path[$file . $field_name . $fieldset])
										|| isset($plugin->add_field_path[$file . $field_name . $fieldset]))
									{
										$xml .= PHP_EOL . $this->_t(1) . '<!--'
											. $this->setLine(__LINE__) . ' default paths of '
											. $fieldset . ' fieldset points to the plugin -->';

										$xml .= PHP_EOL . $this->_t(1) . '<fieldset name="'
											. $fieldset . '" label="' . $label . '"';

										if (isset($plugin->add_rule_path[$file . $field_name . $fieldset]))
										{
											$xml .= PHP_EOL . $this->_t(2)
												. 'addrulepath="' . $plugin->add_rule_path[$file . $field_name . $fieldset] . '"';
										}

										if (isset($plugin->add_field_path[$file . $field_name . $fieldset]))
										{
											$xml .= PHP_EOL . $this->_t(2)
												. 'addfieldpath="' . $plugin->add_field_path[$file . $field_name . $fieldset] . '"';
										}

										$xml .= PHP_EOL . $this->_t(1) . '>';
									}
									else
									{
										$xml .= PHP_EOL . $this->_t(1) . '<fieldset name="'
											. $fieldset . '" label="' . $label . '">';
									}
									// check if we have an inner field set
									if (StringHelper::check(
										$field_name_inner
									))
									{
										$xml .= PHP_EOL . $this->_t(1)
											. '<fields name="'
											. $field_name_inner . '">';
									}
									// add the placeholder of the fields
									$xml .= $this->hhh . 'FIELDSET_' . $file
										. $field_name . $fieldset . $this->hhh;
									// check if we have an inner field set
									if (StringHelper::check(
										$field_name_inner
									))
									{
										$xml .= PHP_EOL . $this->_t(1)
											. '</fields>';
									}
									$xml .= PHP_EOL . $this->_t(1)
										. '</fieldset>';
								}
								$xml .= PHP_EOL . $this->_t(1) . '</fields>';
							}
							$xml .= PHP_EOL . '</form>';
							// add xml to file
							$this->writeFile($fileDetails['path'], $xml);
							$this->newFiles[$plugin->key][] = $fileDetails;
							// count the file created
							$this->fileCount++;
						}
					}
					// set SQL stuff if needed
					if ($plugin->add_sql || $plugin->add_sql_uninstall)
					{
						// create SQL folder
						$this->createFolder($plugin->folder_path . '/sql');
						// create mysql folder
						$this->createFolder(
							$plugin->folder_path . '/sql/mysql'
						);
						// now set the install file
						if ($plugin->add_sql)
						{
							$this->writeFile(
								$plugin->folder_path . '/sql/mysql/install.sql',
								$plugin->sql
							);
							// count the file created
							$this->fileCount++;
						}
						// now set the uninstall file
						if ($plugin->add_sql_uninstall)
						{
							$this->writeFile(
								$plugin->folder_path
								. '/sql/mysql/uninstall.sql',
								$plugin->sql_uninstall
							);
							// count the file created
							$this->fileCount++;
						}
					}
					// creat the language folder path
					$this->createFolder($plugin->folder_path . '/language');
					// also creat the lang tag folder path
					$this->createFolder(
						$plugin->folder_path . '/language/' . $this->langTag
					);
					// check if this lib has files
					if (isset($plugin->files)
						&& ArrayHelper::check($plugin->files))
					{
						// add to component files
						foreach ($plugin->files as $file)
						{
							// set the path finder
							$file['target_type']          = $plugin->target_type;
							$file['target_id']            = $plugin->id;
							$this->componentData->files[] = $file;
						}
					}
					// check if this lib has folders
					if (isset($plugin->folders)
						&& ArrayHelper::check($plugin->folders))
					{
						// add to component folders
						foreach ($plugin->folders as $folder)
						{
							// set the path finder
							$folder['target_type']          = $plugin->target_type;
							$folder['target_id']            = $plugin->id;
							$this->componentData->folders[] = $folder;
						}
					}
					// check if this plugin has urls
					if (isset($plugin->urls)
						&& ArrayHelper::check($plugin->urls))
					{
						// add to component urls
						foreach ($plugin->urls as $n => &$url)
						{
							// should we add the local folder
							if (isset($url['type']) && $url['type'] > 1
								&& isset($url['url'])
								&& StringHelper::check(
									$url['url']
								))
							{
								// set file name
								$fileName = basename($url['url']);
								// get the file contents
								$data = FileHelper::getContent(
									$url['url']
								);
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
								// create sub media media folder path if not set
								$this->createFolder(
									$plugin->folder_path . $path
								);
								// set the path to plugin file
								$url['path'] = $plugin->folder_path . $path
									. '/' . $fileName; // we need this for later
								// write data to path
								$this->writeFile($url['path'], $data);
								// count the file created
								$this->fileCount++;
							}
						}
					}
				}
			}
		}
	}

	/**
	 * Create Path if not exist
	 *
	 * @return void
	 */
	private function createFolder($path)
	{
		// check if the path exist
		if (!Folder::exists(
			$path
		))
		{
			// create the path
			Folder::create(
				$path
			);
			// count the folder created
			$this->folderCount++;
			// add index.html (boring I know)
			$this->indexHTML(
				$path, ''
			);
		}
	}

	/**
	 * Build the Libraries files, folders, url's and config
	 *
	 * @return  void
	 *
	 */
	private function setLibraries()
	{
		if (ArrayHelper::check($this->libraries))
		{
			// Trigger Event: jcb_ce_onBeforeSetLibraries
			$this->triggerEvent(
				'jcb_ce_onBeforeSetLibraries',
				array(&$this->componentContext, &$this->libraries)
			);
			// creat the main component folder
			if (!Folder::exists($this->componentPath))
			{
				Folder::create($this->componentPath);
				// count the folder created
				$this->folderCount++;
				$this->indexHTML('');
			}
			// create media path if not set
			$this->createFolder($this->componentPath . '/media');
			foreach ($this->libraries as $id => &$library)
			{
				if (ObjectHelper::check($library))
				{
					// check if this lib has files
					if (isset($library->files)
						&& ArrayHelper::check($library->files))
					{
						// add to component files
						foreach ($library->files as $file)
						{
							$this->componentData->files[] = $file;
						}
					}
					// check if this lib has folders
					if (isset($library->folders)
						&& ArrayHelper::check(
							$library->folders
						))
					{
						// add to component folders
						foreach ($library->folders as $folder)
						{
							$this->componentData->folders[] = $folder;
						}
					}
					// check if this lib has urls
					if (isset($library->urls)
						&& ArrayHelper::check($library->urls))
					{
						// build media folder path
						$libFolder = strtolower(
							preg_replace(
								'/\s+/', '-',
								StringHelper::safe(
									$library->name, 'filename', ' ', false
								)
							)
						);
						$mediaPath = '/media/' . $libFolder;
						// should we add the local folder
						$addLocalFolder = false;
						// add to component urls
						foreach ($library->urls as $n => &$url)
						{
							if (isset($url['type']) && $url['type'] > 1
								&& isset($url['url'])
								&& StringHelper::check(
									$url['url']
								))
							{
								// create media/lib path if not set
								$this->createFolder(
									$this->componentPath . $mediaPath
								);
								// add local folder
								$addLocalFolder = true;
								// set file name
								$fileName = basename($url['url']);
								// get the file contents
								$data = FileHelper::getContent(
									$url['url']
								);
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
								$this->createFolder(
									$this->componentPath . $mediaPath . $path
								);
								// set the path to library file
								$url['path'] = $mediaPath . $path . '/'
									. $fileName; // we need this for later
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
							// add folder to xml of media folders
							$this->fileContentStatic[$this->hhh
							. 'EXSTRA_MEDIA_FOLDERS' . $this->hhh]
								.= PHP_EOL . $this->_t(2) . "<folder>"
								. $libFolder . "</folder>";
						}
					}
					// if config fields are found load into component config (avoiding duplicates)
					if (isset($library->how) && $library->how > 1
						&& isset($library->config)
						&& ArrayHelper::check($library->config))
					{
						foreach ($library->config as $cofig)
						{
							$found = array_filter(
								$this->componentData->config,
								function ($item) use ($cofig) {
									return $item['field'] == $cofig['field'];
								}
							);
							// set the config data if not found
							if (!ArrayHelper::check($found))
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
		if (isset($this->componentData->dashboard_type)
			&& 2 == $this->componentData->dashboard_type
			&& isset($this->componentData->dashboard)
			&& StringHelper::check(
				$this->componentData->dashboard
			)
			&& strpos($this->componentData->dashboard, '_') !== false)
		{
			// set the default view
			$getter = explode('_', $this->componentData->dashboard);
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
					if (isset($this->componentData->{$targets[$t]})
						&& ArrayHelper::check(
							$this->componentData->{$targets[$t]}
						))
					{
						// search the target views
						$dashboard = (array) array_filter(
							$this->componentData->{$targets[$t]},
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
									$names[$t], $this->componentData->dashboard,
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
								$names[$t], $this->componentData->dashboard,
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
							$this->componentData->dashboard
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
						$this->componentData->dashboard
					), 'Error'
				);
			}
			// if default was changed to dynamic dashboard the remove default tab and methods
			if (StringHelper::check($this->dynamicDashboard))
			{
				// dynamic dashboard is used
				$this->componentData->dashboard_tab         = '';
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
			if (!Folder::exists($this->componentPath))
			{
				Folder::create($this->componentPath);
				// count the folder created
				$this->folderCount++;
				$this->indexHTML('');
			}
			// now build all folders needed for this component
			foreach ($this->joomlaVersionData->create as $main => $folders)
			{
				$this->createFolder($this->componentPath . '/' . $main);
				if (ObjectHelper::check($folders))
				{
					foreach ($folders as $sub => $subFolders)
					{
						$this->createFolder(
							$this->componentPath . '/' . $main . '/' . $sub
						);
						if (ObjectHelper::check($subFolders))
						{
							foreach ($subFolders as $sub_2 => $subFolders_2)
							{
								$this->createFolder(
									$this->componentPath . '/' . $main . '/'
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
										$this->createFolder(
											$this->componentPath . '/' . $main
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
												$this->createFolder(
													$this->componentPath . '/'
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
														$this->createFolder(
															$this->componentPath
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
																$this->createFolder(
																	$this->componentPath
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
																		$this->createFolder(
																			$this->componentPath
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
			$codeName = $this->componentCodeName;
			// TODO needs more looking at this must be dynamic actually
			$this->notNew[] = 'LICENSE.txt';
			// do license check
			$LICENSE        = false;
			$licenseChecker = strtolower($this->componentData->license);
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
			if ($this->componentData->addreadme)
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
						$details->_target['type'] . '/', '', $details->path
					);
					$path    = str_replace(
						$details->_target['type'] . '/',
						$this->dynamicPaths[$details->_target['key']] . '/',
						$details->path
					);
				}
				else
				{
					// set destination path
					$zipPath = str_replace('c0mp0n3nt/', '', $details->path);
					$path    = str_replace(
						'c0mp0n3nt/', $this->componentPath . '/', $details->path
					);
				}
				// set the template folder path
				$templatePath = (isset($details->custom) && $details->custom)
					? (($details->custom !== 'full') ? $this->templatePathCustom
						. '/' : '') : $this->templatePath . '/';
				// set the final paths
				$currentFullPath = (preg_match('/^[a-z]:/i', $item)) ? $item
					: $templatePath . '/' . $item;
				$currentFullPath = str_replace('//', '/', $currentFullPath);
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
						$this->fileCount++;
						// store the new files
						if (!in_array($ftem, $this->notNew))
						{
							if (isset($details->_target))
							{
								$this->newFiles[$details->_target['key']][]
									= array('path' => $packageFullPath,
									        'name' => $new,
									        'zip'  => $zipFullPath);
							}
							else
							{
								$this->newFiles['static'][]
									= array('path' => $packageFullPath,
									        'name' => $new,
									        'zip'  => $zipFullPath);
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
						$this->folderCount++;
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
							$eTab = $this->_t(2);
							if ('admin' === $checker[0])
							{
								$eTab = $this->_t(3);
							}
							// set the xml file
							$this->fileContentStatic[$this->hhh . 'EXSTRA_'
							. StringHelper::safe(
								$checker[0], 'U'
							) . '_' . $eNAME . $this->hhh]
								.= PHP_EOL . $eTab . "<" . $ename . ">"
								. $checker[1] . "</" . $ename . ">";
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
			&& (isset($this->componentData->admin_views)
				&& ArrayHelper::check(
					$this->componentData->admin_views
				)))
		{
			if (!StringHelper::check($this->dynamicDashboard))
			{
				// setup dashboard
				$target = array('admin' => $this->componentData->name_code);
				$this->buildDynamique($target, 'dashboard');
			}
			// now the rest of the views
			foreach ($this->componentData->admin_views as $nr => $view)
			{
				if (ObjectHelper::check($view['settings']))
				{
					$created  = $this->getCreatedDate($view);
					$modified = $this->getLastModifiedDate($view);
					if ($view['settings']->name_list != 'null')
					{
						$target
							    = array('admin' => $view['settings']->name_list);
						$config = array($this->hhh . 'CREATIONDATE'
						                . $this->hhh => $created,
						                $this->hhh . 'BUILDDATE'
						                . $this->hhh => $modified,
						                $this->hhh . 'VERSION'
						                . $this->hhh => $view['settings']->version);
						$this->buildDynamique($target, 'list', false, $config);
					}
					if ($view['settings']->name_single != 'null')
					{
						$target
							    = array('admin' => $view['settings']->name_single);
						$config = array($this->hhh . 'CREATIONDATE'
						                . $this->hhh => $created,
						                $this->hhh . 'BUILDDATE'
						                . $this->hhh => $modified,
						                $this->hhh . 'VERSION'
						                . $this->hhh => $view['settings']->version);
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
						$config = array($this->hhh . 'CREATIONDATE'
						                . $this->hhh => $created,
						                $this->hhh . 'BUILDDATE'
						                . $this->hhh => $modified,
						                $this->hhh . 'VERSION'
						                . $this->hhh => $view['settings']->version);
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
			&& (isset($this->componentData->site_views)
				&& ArrayHelper::check(
					$this->componentData->site_views
				)))
		{

			foreach ($this->componentData->site_views as $nr => $view)
			{
				$created  = $this->getCreatedDate($view);
				$modified = $this->getLastModifiedDate($view);
				if ($view['settings']->main_get->gettype == 2)
				{
					// set list view
					$target = array('site' => $view['settings']->code);
					$config = array($this->hhh . 'CREATIONDATE'
					                . $this->hhh => $created,
					                $this->hhh . 'BUILDDATE'
					                . $this->hhh => $modified,
					                $this->hhh . 'VERSION'
					                . $this->hhh => $view['settings']->version);
					$this->buildDynamique($target, 'list', false, $config);
				}
				elseif ($view['settings']->main_get->gettype == 1)
				{
					// set single view
					$target = array('site' => $view['settings']->code);
					$config = array($this->hhh . 'CREATIONDATE'
					                . $this->hhh => $created,
					                $this->hhh . 'BUILDDATE'
					                . $this->hhh => $modified,
					                $this->hhh . 'VERSION'
					                . $this->hhh => $view['settings']->version);
					$this->buildDynamique($target, 'single', false, $config);
				}
			}
			$front = true;
		}
		if ((isset($this->joomlaVersionData->move->dynamic)
				&& ObjectHelper::check(
					$this->joomlaVersionData->move->dynamic
				))
			&& (isset($this->componentData->custom_admin_views)
				&& ArrayHelper::check(
					$this->componentData->custom_admin_views
				)))
		{
			foreach ($this->componentData->custom_admin_views as $nr => $view)
			{
				$created  = $this->getCreatedDate($view);
				$modified = $this->getLastModifiedDate($view);
				if ($view['settings']->main_get->gettype == 2)
				{
					// set list view$view
					$target = array('custom_admin' => $view['settings']->code);
					$config = array($this->hhh . 'CREATIONDATE'
					                . $this->hhh => $created,
					                $this->hhh . 'BUILDDATE'
					                . $this->hhh => $modified,
					                $this->hhh . 'VERSION'
					                . $this->hhh => $view['settings']->version);
					$this->buildDynamique($target, 'list', false, $config);
				}
				elseif ($view['settings']->main_get->gettype == 1)
				{
					// set single view
					$target = array('custom_admin' => $view['settings']->code);
					$config = array($this->hhh . 'CREATIONDATE'
					                . $this->hhh => $created,
					                $this->hhh . 'BUILDDATE'
					                . $this->hhh => $modified,
					                $this->hhh . 'VERSION'
					                . $this->hhh => $view['settings']->version);
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
						$this->componentPath . '/admin/models/fields/'
						. $field['type_name'] . '.php'
					))
					{
						// copy the custom field
						File::copy(
							$this->componentPath . '/admin/models/fields/'
							. $field['type_name'] . '.php',
							$path . '/fields/' . $field['type_name'] . '.php'
						);
					}
					// stop from doing this again.
					$this->extentionTrackingFilesMoved[$check] = true;
				}
			}
			// check if this has validation that should be moved
			if (isset($this->validationLinkedFields[$field['field']]))
			{
				$check = md5(
					$path . 'rule'
					. $this->validationLinkedFields[$field['field']]
				);
				// lets check if we already moved this
				if (!isset($this->extentionTrackingFilesMoved[$check]))
				{
					// check files exist
					if (File::exists(
						$this->componentPath . '/admin/models/rules/'
						. $this->validationLinkedFields[$field['field']]
						. '.php'
					))
					{
						// copy the custom field
						File::copy(
							$this->componentPath . '/admin/models/rules/'
							. $this->validationLinkedFields[$field['field']]
							. '.php', $path . '/rules/'
							. $this->validationLinkedFields[$field['field']]
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
				GetHelper::between(
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
				$this->setFieldDetails($field);
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
								$field['settings']->modified
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
						$view['settings']->main_get->modified
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
						$view['settings']->main_get->modified
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
						if (strpos($details->path, 'VIEW') !== false)
						{
							$path = str_replace('VIEW', $name, $details->path);
						}
						else
						{
							$path = $details->path;
						}
						// make sure we have component to replace
						if (strpos($path, 'c0mp0n3nt') !== false)
						{
							$zipPath = str_replace('c0mp0n3nt/', '', $path);
							$path    = str_replace(
								'c0mp0n3nt/', $this->componentPath . '/', $path
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
							$this->indexHTML($zipPath);
							// count the folder created
							$this->folderCount++;
						}
						// do the file renaming
						if ($details->rename)
						{
							if ($fileName)
							{
								$new  = str_replace(
									$details->rename, $fileName, $item
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
									$details->rename, $name, $item
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
								$this->templatePath . '/' . $item,
								$path . '/' . $new
							);
							// count the file created
							$this->fileCount++;
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
						$this->newFiles['dynamic'][$name][] = $newFIle;
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
		$custom_settings = $this->templatePath . '/settings_' . $this->componentCodeName . '.json';
		// set the version data
		if (File::exists($custom_settings))
		{
			$version_data = json_decode(
				FileHelper::getContent(
					$custom_settings
				)
			);
		}
		else
		{
			$version_data = json_decode(
				FileHelper::getContent(
					$this->templatePath . '/settings.json'
				)
			);
		}
		// add custom folders
		if ((isset($this->componentData->folders)
				&& ArrayHelper::check(
					$this->componentData->folders
				))
			|| $this->addEximport
			|| $this->uikit
			|| $this->footable)
		{
			if ($this->addEximport)
			{
				// move the import view folder in place
				$importView                     = array('folder' => 'importViews',
				                                        'path'   => 'admin/views/import',
				                                        'rename' => 1);
				$this->componentData->folders[] = $importView;
				// move the phpspreadsheet Folder (TODO we must move this to a library package)
				$PHPExcel
					                            = array('folderpath' => 'JPATH_LIBRARIES/phpspreadsheet/vendor',
					                                    'path'       => '/libraries/phpspreadsheet/',
					                                    'rename'     => 0);
				$this->componentData->folders[] = $PHPExcel;
			}
			if (2 == $this->uikit || 1 == $this->uikit)
			{
				// move the UIKIT Folder into place
				$uikit                          = array('folder' => 'uikit-v2',
				                                        'path'   => 'media',
				                                        'rename' => 0);
				$this->componentData->folders[] = $uikit;
			}
			if (2 == $this->uikit || 3 == $this->uikit)
			{
				// move the UIKIT-3 Folder into place
				$uikit                          = array('folder' => 'uikit-v3',
				                                        'path'   => 'media',
				                                        'rename' => 0);
				$this->componentData->folders[] = $uikit;
			}
			if ($this->footable
				&& (!isset($this->footableVersion)
					|| 2 == $this->footableVersion))
			{
				// move the footable folder into place
				$footable                       = array('folder' => 'footable-v2',
				                                        'path'   => 'media',
				                                        'rename' => 0);
				$this->componentData->folders[] = $footable;
			}
			elseif ($this->footable && 3 == $this->footableVersion)
			{
				// move the footable folder into place
				$footable                       = array('folder' => 'footable-v3',
				                                        'path'   => 'media',
				                                        'rename' => 0);
				$this->componentData->folders[] = $footable;
			}

			// pointer tracker
			$pointer_tracker = 'h';
			foreach ($this->componentData->folders as $custom)
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
					$custom['path'] = trim($custom['path'], '/');
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
				$pathArray   = (array) explode('/', $custom['path']);
				$firstFolder = array_values($pathArray)[0];
				$lastFolder  = end($pathArray);
				// only rename folder if last has folder name
				if (isset($custom['rename']) && $custom['rename'] == 1)
				{
					$custom['path'] = str_replace(
						'/' . $lastFolder, '', $custom['path']
					);
					$rename         = 'new';
					$newname        = $lastFolder;
				}
				elseif ('full' === $customPath)
				{
					// make sure we use the correct name
					$folderArray = (array) explode('/', $custom['folder']);
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
				$custom['path'] = ltrim($custom['path'], '/');
				// set new folder to object
				$version_data->move->static->{$key_pointer}          = new stdClass();
				$version_data->move->static->{$key_pointer}->naam
				                                                    = str_replace(
					'//', '/', $custom['folder']
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
			unset($this->componentData->folders);
			unset($custom);
		}
		// add custom files
		if ((isset($this->componentData->files)
				&& ArrayHelper::check(
					$this->componentData->files
				))
			|| $this->googlechart)
		{
			if ($this->googlechart)
			{
				// move the google chart files
				$googleChart                  = array('file'   => 'google.jsapi.js',
				                                      'path'   => 'media/js',
				                                      'rename' => 0);
				$this->componentData->files[] = $googleChart;
				$googleChart
				                              = array('file'   => 'chartbuilder.php',
				                                      'path'   => 'admin/helpers',
				                                      'rename' => 0);
				$this->componentData->files[] = $googleChart;
			}

			// pointer tracker
			$pointer_tracker = 'h';
			foreach ($this->componentData->files as $custom)
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
					'//', '/', $custom['file']
				);
				// update the dynamic component name placholders in file names
				$custom['path'] = $this->setPlaceholders(
					$custom['path'], $this->placeholders
				);
				// get the path info
				$pathInfo = pathinfo($custom['path']);
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
					$custom['path'] = ltrim($custom['path'], '/');
					// get file array
					$fileArray = (array) explode('/', $custom['file']);
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
					$custom['path'] = ltrim($custom['path'], '/');
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
			unset($this->componentData->files);
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
		if (!$this->setMoveFolders)
		{
			// add the setDynamicF0ld3rs() method to the install scipt.php file
			$this->setMoveFolders = true;
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
	 *
	 */
	private function indexHTML($path, $root = 'component')
	{
		if ('component' === $root)
		{
			$root = $this->componentPath . '/';
		}
		// use path if exist
		if (strlen($path) > 0)
		{
			File::copy(
				$this->templatePath . '/index.html',
				$root . $path . '/index.html'
			);
			// count the file created
			$this->fileCount++;
		}
		else
		{
			File::copy(
				$this->templatePath . '/index.html', $root . '/index.html'
			);
			// count the file created
			$this->fileCount++;
		}
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
		return $this->setPlaceholders(
			$this->setPlaceholders(
				$path, ComponentbuilderHelper::$constantPaths
			), $this->placeholders
		);
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
