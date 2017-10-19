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

	@version		@update number 439 of this MVC
	@build			18th October, 2017
	@created		6th May, 2015
	@package		Component Builder
	@subpackage		joomla_components.php
	@author			Llewellyn van der Merwe <http://vdm.bz/component-builder>	
	@copyright		Copyright (C) 2015. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html 
	
	Builds Complex Joomla Components 
                                                             
/-----------------------------------------------------------------------------------------------------------------------------*/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import the Joomla modellist library
jimport('joomla.application.component.modellist');

/**
 * Joomla_components Model
 */
class ComponentbuilderModelJoomla_components extends JModelList
{
	public function __construct($config = array())
	{
		if (empty($config['filter_fields']))
        {
			$config['filter_fields'] = array(
				'a.id','id',
				'a.published','published',
				'a.ordering','ordering',
				'a.created_by','created_by',
				'a.modified_by','modified_by',
				'a.system_name','system_name',
				'a.name_code','name_code',
				'a.component_version','component_version',
				'a.short_description','short_description',
				'a.companyname','companyname',
				'a.author','author'
			);
		}

		parent::__construct($config);
	}

	public $user;
	public $packagePath		= false;
	public $packageName		= false;
	public $zipPath			= false;
	public $key			= array();
	public $exportBuyLinks		= array();
	public $exportPackageLinks	= array();
	public $info			= array(
						'name' => array(),
						'short_description' => array(),
						'component_version' => array(),
						'companyname' => array(),
						'author' => array(),
						'email' => array(),
						'website' => array(),
						'license' => array(),
						'copyright' => array(),
						'getKeyFrom' => null
						);
	public $activeType		= 'export';

	protected $params;
	protected $tempPath;
	protected $customPath;
	protected $smartExport		= array();
	protected $templateIds		= array();
	protected $dynamicGetIds		= array();
	protected $adminViewIds		= array();
	protected $fieldTypeIds		= array();
	protected $snippetIds		= array();
	protected $layoutIds		= array();
	protected $customCodeIds	= array();
	protected $customCodeM		= array();
	protected $fieldTypes		= array();
	protected $isMultiple		= array();

	/**
	* Method to build the export package
	*
	* @return bool on success.
	*/
	public function getSmartExport($pks)
	{
		// setup the query
		if (ComponentbuilderHelper::checkArray($pks))
		{
			// Get the user object.
			if (!ComponentbuilderHelper::checkObject($this->user))
			{
				$this->user = JFactory::getUser();
			}
			// Create a new query object.
			if (!ComponentbuilderHelper::checkObject($this->_db))
			{
				$this->_db = JFactory::getDBO();
			}
			$query = $this->_db->getQuery(true);

			// Select some fields
			$query->select(array('a.*'));
			
			// From the componentbuilder_joomla_component table
			$query->from($this->_db->quoteName('#__componentbuilder_joomla_component', 'a'));
			$query->where('a.id IN (' . implode(',',$pks) . ')');
			
			// Implement View Level Access
			if (!$this->user->authorise('core.options', 'com_componentbuilder'))
			{
				$groups = implode(',', $this->user->getAuthorisedViewLevels());
				$query->where('a.access IN (' . $groups . ')');
			}

			// Order the results by ordering
			$query->order('a.ordering  ASC');

			// Load the items
			$this->_db->setQuery($query);
			$this->_db->execute();
			if ($this->_db->getNumRows())
			{
				// load the items from db
				$items = $this->_db->loadObjectList();
				// check if we have items
				if (ComponentbuilderHelper::checkArray($items))
				{
					// set params
					$this->params = JComponentHelper::getParams('com_componentbuilder');
					// set custom folder path
					$this->customPath = $this->params->get('custom_folder_path', JPATH_COMPONENT_ADMINISTRATOR.'/custom');
					// check what type of export or backup this is
					if ('backup' === $this->activeType || 'manualBackup' === $this->activeType)
					{
						// set the paths
						if (!$this->backupPath = $this->params->get('cronjob_backup_folder_path', null))
						{
							// set the paths
							$comConfig = JFactory::getConfig();
							$this->backupPath = $comConfig->get('tmp_path');
						}
						// set the date array
						$date = JFactory::getDate();
						$placeholderDate = array();
						$placeholderDate['[YEAR]'] = $date->format('Y');
						$placeholderDate['[MONTH]'] = $date->format('m');
						$placeholderDate['[DAY]'] = $date->format('d');
						$placeholderDate['[HOUR]'] = $date->format('H');
						$placeholderDate['[MINUTE]'] = $date->format('i');
						// get the package name
						$packageName = $this->params->get('backup_package_name', 'JCB_Backup_[YEAR]_[MONTH]_[DAY]');
						$this->packageName = str_replace(array_keys($placeholderDate), array_values($placeholderDate), $packageName);
					}
					else
					{
						// set the paths
						$comConfig = JFactory::getConfig();
						$this->backupPath = $comConfig->get('tmp_path');
						// set the package name
						if (count($items) == 1)
						{
							$this->packageName = 'JCB_' . $this->getPackageName($items);
						}
						else
						{
							$this->packageName = 'JCB_smartPackage';
						}
					}
					// set the package path
					$this->packagePath = rtrim($this->backupPath, '/') . '/' . $this->packageName;
					$this->zipPath = $this->packagePath .'.zip';
					if (JFolder::exists($this->packagePath))
					{
						// remove if old folder is found
						ComponentbuilderHelper::removeFolder($this->packagePath);
					}
					// create the folders
					JFolder::create($this->packagePath);
					// Get the basic encription.
					$basickey = ComponentbuilderHelper::getCryptKey('basic');
					// Get the encription object.
					if ($basickey)
					{
						$basic = new FOFEncryptAes($basickey, 128);
					}
					// add custom code
					$this->setData('custom_code', $pks, 'component');
					// start loading the components
					$this->smartExport['joomla_component'] = array();
					foreach ($items as $nr => &$item)
					{
						// check if user has access
						$access = ($this->user->authorise('joomla_component.access', 'com_componentbuilder.joomla_component.' . (int) $item->id) && $this->user->authorise('joomla_component.access', 'com_componentbuilder'));
						if (!$access)
						{
							unset($items[$nr]);
							continue;
						}
						// build information data set
						$this->info['name'][$item->id]			= $item->name;
						$this->info['short_description'][$item->id]	= $item->short_description;
						$this->info['component_version'][$item->id]	= $item->component_version;
						$this->info['companyname'][$item->id]		= $item->companyname;
						$this->info['author'][$item->id]		= $item->author;
						$this->info['email'][$item->id]			= $item->email;
						$this->info['website'][$item->id]		= $item->website;
						$this->info['license'][$item->id]		= $item->license;
						$this->info['copyright'][$item->id]		= $item->copyright;
						// set the keys
						if (isset($item->export_key) && ComponentbuilderHelper::checkString($item->export_key))
						{
							// keep the key locked for exported data set
							$export_key = $item->export_key;
							if ($basickey && !is_numeric($item->export_key) && $item->export_key === base64_encode(base64_decode($item->export_key, true)))
							{
								$export_key = rtrim($basic->decryptString($item->export_key), "\0");
							}
							// make sure we have a string
							if (strlen($export_key) > 4 )
							{
								$this->key[$item->id] = $export_key;
							}
						}
						// get name of this item key_name
						if (isset($item->system_name))
						{
							$keyName = ComponentbuilderHelper::safeString($item->system_name, 'cAmel');
						}
						else
						{
							$keyName = ComponentbuilderHelper::safeString($item->name_code);
						}
						// set the export buy links
						if (isset($item->export_buy_link) && ComponentbuilderHelper::checkString($item->export_buy_link))
						{
							// keep the key locked for exported data set
							$this->exportBuyLinks[$keyName] = $item->export_buy_link;
						}
						// set the export buy links
						if (isset($item->export_package_link) && ComponentbuilderHelper::checkString($item->export_package_link))
						{
							// keep the key locked for exported data set
							$this->exportPackageLinks[$keyName] = $item->export_package_link;
						}
						// build files
						$this->moveIt($item->addfiles, 'file');
						// build folders
						$this->moveIt($item->addfolders, 'folder');
						// component image
						$this->moveIt(array('image' => array($item->image)), 'image');
						// add config fields
						$this->setData('field', $this->getIds($item->addconfig, 'repeatable', 'field'), 'id');
						// add admin views
						$this->setData('admin_view', $this->getIds($item->addadmin_views, 'repeatable', 'adminview'), 'id');
						// add custom admin views
						$this->setData('custom_admin_view', $this->getIds($item->addcustom_admin_views, 'repeatable', 'customadminview'), 'id');
						// add site views
						$this->setData('site_view', $this->getIds($item->addsite_views, 'repeatable', 'siteview'), 'id');
						// set the custom code ID's
						$this->setCustomCodeIds($item, 'joomla_component');
						// set the language strings for this component
						$this->setLanguageTranslation($item->id);						
						// load to global object
						$this->smartExport['joomla_component'][$item->id] = $item;
					}
					// add fields and conditions
					if (ComponentbuilderHelper::checkArray($this->adminViewIds))
					{
						$this->setData('admin_fields', $this->adminViewIds, 'id');
						$this->setData('admin_fields_conditions', $this->adminViewIds, 'id');
					}
					// add field types
					if (ComponentbuilderHelper::checkArray($this->fieldTypeIds))
					{
						$this->setData('fieldtype', $this->fieldTypeIds, 'id');
					}
					// add dynamic get
					if (ComponentbuilderHelper::checkArray($this->dynamicGetIds))
					{
						$this->setData('dynamic_get', $this->dynamicGetIds, 'id');
					}
					// add snippets
					if (ComponentbuilderHelper::checkArray($this->snippetIds))
					{
						$this->setData('snippet', $this->snippetIds, 'id');
					}
					// add templates
					if (ComponentbuilderHelper::checkArray($this->templateIds))
					{
						$this->setData('template', $this->templateIds, 'id');
					}
					// add layouts
					if (ComponentbuilderHelper::checkArray($this->layoutIds))
					{
						$this->setData('layout', $this->layoutIds, 'id');
					}
					// add custom code
					if (ComponentbuilderHelper::checkArray($this->customCodeIds))
					{
						$this->setData('custom_code', $this->customCodeIds, 'id');
					}
					// has any data been set
					if (ComponentbuilderHelper::checkArray($this->smartExport['joomla_component']))
					{
						// set the folder and move the files of each component to the folder
						return $this->smartExportBuilder();
					}
				}
			}
		}
		return false;
	}


	/**
	* Method to get ids.
	*
	* @return mixed  An array of ids on success, false on failure.
	*/
	protected function getIds($values, $type, $key = null)
	{
		// the ids bucket
		$bucket = array();
		// if json convert to array
		if (ComponentbuilderHelper::checkJson($values))
		{
			$values = json_decode($values, true);
		}
		// check that the array has values
		if (ComponentbuilderHelper::checkArray($values))
		{
			// check if the key is an array (targeting subform)
			if ('subform' === $type && $key)
			{
				foreach ($values as $value)
				{
					if (isset($value[$key]))
					{
						if (is_numeric($value[$key]))
						{
							$bucket[] = $value[$key];
						}
						elseif (ComponentbuilderHelper::checkString($value[$key]))
						{
							$bucket[] = $this->_db->quote($value[$key]);
						}
					}
				}
				// only return if we set the ids
				if (ComponentbuilderHelper::checkArray($bucket))
				{
					// now set the values back
					return array_unique($bucket);
				}
			}
			// check if the key is an array (targeting subform)
			if ('repeatable' === $type && $key)
			{
				if (isset($values[$key]))
				{
					return array_map(function($id) {
						if (is_numeric($id))
						{
							return $id;
						}
						elseif (ComponentbuilderHelper::checkString($id))
						{
							return  $this->_db->quote($id);
						}
					}, array_unique($values[$key]) );
				}
			}
		}
		return false;
	}

	/**
	* Method to get data of a given table.
	*
	* @return mixed  An array of data items on success, false on failure.
	*/
	protected function setData($table, $values, $key)
	{
		// make sure we have an array of values
		if (!ComponentbuilderHelper::checkArray($values) || !ComponentbuilderHelper::checkString($table) || !ComponentbuilderHelper::checkString($key))
		{
			return false;
		}
		// start the query
		$query = $this->_db->getQuery(true);

		// Select some fields
		$query->select(array('a.*'));
			
		// From the componentbuilder_ANY table
		$query->from($this->_db->quoteName('#__componentbuilder_'. $table, 'a'));
		// set the where query
		$query->where('a.'.$key.' IN (' . implode(',',$values) . ')');
		// Implement View Level Access
		if (!$this->user->authorise('core.options', 'com_componentbuilder'))
		{
			$groups = implode(',', $this->user->getAuthorisedViewLevels());
			$query->where('a.access IN (' . $groups . ')');
		}

		// Order the results by ordering
		$query->order('a.ordering  ASC');

		// Load the items
		$this->_db->setQuery($query);
		$this->_db->execute();
		if ($this->_db->getNumRows())
		{
			$items = $this->_db->loadObjectList();
			// check if we have items
			if (ComponentbuilderHelper::checkArray($items))
			{
				// set search array
				if ('site_view' === $table || 'custom_admin_view' === $table)
				{
					$searchArray = array('php_view','php_jview','php_jview_display','php_document','js_document','css_document','css');
				}
				// reset the global array
				if ('template' === $table)
				{
					$this->templateIds = array();
				}
				elseif ('layout' === $table)
				{
					$this->layoutIds = array();
				}
				// start loading the data
				if (!isset($this->smartExport[$table]))
				{
					$this->smartExport[$table] = array();
				}
				// start loading the found items
				foreach ($items as $nr => &$item)
				{
					// set the data per id only once
					if (isset($this->smartExport[$table][$item->id]))
					{
						continue;
					}
					// load to global object
					$this->smartExport[$table][$item->id] = $item;
					// set the custom code ID's
					$this->setCustomCodeIds($item, $table);
					// actions to take if table is admin_view
					if ('admin_view' === $table)
					{
						// add fields & conditions
						$this->adminViewIds[$item->id] = $item->id;
						// admin icon
						$this->moveIt(array('image' => array($item->icon)), 'image');
						// admin icon_add
						$this->moveIt(array('image' => array($item->icon_add)), 'image');
						// admin icon_category
						$this->moveIt(array('image' => array($item->icon_category)), 'image');
					}
					// actions to take if table is admin_fields
					if ('admin_fields' === $table)
					{
						// add fields
						$this->setData('field', $this->getIds($item->addfields, 'subform', 'field'), 'id');
					}
					// actions to take if table is field
					if ('field' === $table)
					{
						// add field types
						$this->fieldTypeIds[$item->fieldtype] = $item->fieldtype;
						// check if this field has multiple fields
						if ($this->checkMultiFields($item->fieldtype))
						{
							$fields = ComponentbuilderHelper::getBetween(json_decode($item->xml), 'fields="', '"');
							$fieldsSets = array();
							if (strpos($fields, ',') !== false)
							{
								// multiple fields
								$fieldsSets = (array) explode(',', $fields);
							}
							elseif (is_numeric($fields))
							{
								// single field
								$fieldsSets[] = (int) $fields;
							}
							// get fields
							if (ComponentbuilderHelper::checkArray($fieldsSets))
							{
								$this->setData('field', $fieldsSets, 'id');
							}
						}
					}
					// actions to take if table is site_view and custom_admin_view
					if ('site_view' === $table || 'custom_admin_view' === $table)
					{
						// search for templates & layouts
						$this->getTemplateLayout(base64_decode($item->default));
						// add search array templates and layouts
						foreach ($searchArray as $scripter)
						{
							if (isset($item->{'add_'.$scripter}) && $item->{'add_'.$scripter} == 1)
							{
								$this->getTemplateLayout($item->$scripter);
							}
						}
						// add dynamic gets
						$this->dynamicGetIds[$item->main_get] = $item->main_get;
						if (ComponentbuilderHelper::checkArray($item->custom_get))
						{
							foreach ($item->custom_get as $custom_get)
							{
								// add dynamic gets
								$this->dynamicGetIds[$custom_get] = $custom_get;
							}
						}
						if ('custom_admin_view' === $table && isset($item->icon))
						{
							// view icon
							$this->moveIt(array('image' => array($item->icon)), 'image');
						}
						// add snippets
						$this->snippetIds[$item->snippet] = $item->snippet;
					}
					// actions to take if table is template and layout
					if ('layout' === $table || 'template' === $table)
					{
						// search for templates & layouts
						$this->getTemplateLayout(base64_decode($item->$table), $this->user);
						// add search array templates and layouts
						if (isset($item->add_php_view) && $item->add_php_view == 1)
						{
							$this->getTemplateLayout($item->php_view, $this->user);
						}
						// add dynamic gets
						$this->dynamicGetIds[$item->dynamic_get] = $item->dynamic_get;
						// add snippets
						$this->snippetIds[$item->snippet] = $item->snippet;
					}
				}
			}
		}
	}

	/**
	* Method to build the package to export
	*
	* @return void
	*/
	protected function smartExportBuilder()
	{
		// set db data
		$data = serialize($this->smartExport);
		// lock the data if set
		if (ComponentbuilderHelper::checkArray($this->key))
		{
			// lock the data
			$this->key = md5(implode('', $this->key));
			$locker = new FOFEncryptAes($this->key, 128);
			$data = $locker->encryptString($data);		
			// Set the key owner information
			$this->info['getKeyFrom'] = array();
			$this->info['getKeyFrom']['company']		= $this->params->get('export_company', null);
			$this->info['getKeyFrom']['owner']			= $this->params->get('export_owner', null);
			$this->info['getKeyFrom']['email']			= $this->params->get('export_email', null);
			$this->info['getKeyFrom']['website']		= $this->params->get('export_website', null);
			$this->info['getKeyFrom']['license']		= $this->params->get('export_license', null);
			$this->info['getKeyFrom']['copyright']		= $this->params->get('export_copyright', null);
			// making provision for future changes 
			if (count($this->exportBuyLinks) == 1)
			{
				$this->info['getKeyFrom']['buy_links'] = $this->exportBuyLinks;
			}
			else
			{
				// use global if more then one component is exported, or if none has a buy link
				$this->info['getKeyFrom']['buy_link'] = $this->params->get('export_buy_link', null);
			}
			$this->info['getKeyFrom']['package_links']	= $this->exportPackageLinks;
		}
		else
		{
			// Set the owner information
			$data = base64_encode($data);
		}
		// set the path
		$dbPath = $this->packagePath . '/db.vdm';
		// write the db data to file in package
		if (!ComponentbuilderHelper::writeFile($dbPath, wordwrap($data, 128, "\n", true)))
		{
			return false;
		}
		// set info data
		$locker = new FOFEncryptAes('V4stD3vel0pmEntMethOd@YoUrS3rv!s', 128);
		$info = $locker->encryptString(json_encode($this->info));
		// set the path
		$infoPath = $this->packagePath . '/info.vdm';
		// write the db data to file in package
		if (!ComponentbuilderHelper::writeFile($infoPath, wordwrap($info, 128, "\n", true)))
		{
				return false;
		}
		// lock all files
		$this->lockFiles();
		// remove old zip files with the same name
		if (JFile::exists($this->zipPath))
		{
			// remove file if found
			JFile::delete($this->zipPath);
		}
		// zip the folder
		if (!ComponentbuilderHelper::zip($this->packagePath, $this->zipPath))
		{
			return false;
		}
		// remove the folder
		if (!ComponentbuilderHelper::removeFolder($this->packagePath))
		{
			return false;
		}
		return true;
	}

	/**
	* Method to lock all files
	*
	* @return void
	*/
	protected function lockFiles()
	{
		// lock the data if set
		if (ComponentbuilderHelper::checkString($this->key) && strlen($this->key) == 32)
		{
			$locker = new FOFEncryptAes($this->key, 128);
			// we must first store the current working directory
			$joomla = getcwd();
			// setup the type path
			$customPath = $this->packagePath . '/custom';
			// go to the custom folder if found
			if (JFolder::exists($customPath))
			{
				$this->lock($customPath, $locker);
			}
			// setup the type path
			$imagesPath = $this->packagePath . '/images';
			// go to the custom folder if found
			if (JFolder::exists($imagesPath))
			{
				$this->lock($imagesPath, $locker);
			}
			// change back to working dir
			chdir($joomla);
		}
	}

	/**
	* The Locker
	*
	* @return void
	*/	
	protected function lock(&$tmpPath, &$locker)
	{
		// we are changing the working directory to the tmp path (important)
		chdir($tmpPath);
		// get a list of files in the current directory tree (all)
		$files = JFolder::files('.', '.', true, true);
		// read in the file content
		foreach ($files as $file)
		{
			// write the encrypted string back to file
			if (!ComponentbuilderHelper::writeFile($file, wordwrap($locker->encryptString(file_get_contents($file)), 128, "\n", true)))
			{
				// we should add error handler here in case file could not be locked
			}
		}
	}

	/**
	* Method to move the files and folder to the package folder
	*
	* @return bool
	*/
	protected function moveIt($data, $type)
	{
		// if json convert to array
		if (ComponentbuilderHelper::checkJson($data))
		{
			$data = json_decode($data, true);
		}
		// make sure we have an array
		if (!ComponentbuilderHelper::checkArray($data) || !isset($data[$type]) || !ComponentbuilderHelper::checkArray($data[$type]))
		{
			return false;
		}
		// set the name of the folder
		if ('file' === $type || 'folder' === $type)
		{
			$name = 'custom';
		}
		if ('image' === $type)
		{
			$name = 'images';
		}
		// setup the type path
		$tmpPath = str_replace('//', '/', $this->packagePath . '/' . $name);
		// create type path if not set
		if (!JFolder::exists($tmpPath))
		{
			// create the folders if not found
			JFolder::create($tmpPath);
		}
		// now move it
		foreach ($data[$type] as $item)
		{
			if (ComponentbuilderHelper::checkString($item))
			{
				if ('file' === $type)
				{
					$tmpFilePath = str_replace('//', '/', $tmpPath.'/'.$item);
					$customFilePath = str_replace('//', '/', $this->customPath.'/'.$item);
					if (!JFile::exists($tmpFilePath) && JFile::exists($customFilePath))
					{
						// move the file to its place
						JFile::copy($customFilePath, $tmpFilePath);
					}
				}
				if ('image' === $type)
				{
					$imageName = basename($item);
					$imagePath = str_replace($imageName, '', $item);
					$imageFolderPath = str_replace('//', '/', $this->packagePath.'/'. $imagePath);
					// check if image folder exist
					if (!JFolder::exists($imageFolderPath))
					{
						// create the folders if not found
						JFolder::create($imageFolderPath);
					}
					$tmpImagePath = str_replace('//', '/', $this->packagePath.'/'.$item);
					$customImagePath = str_replace('//', '/', JPATH_ROOT.'/'.$item);
					if (!JFile::exists($tmpImagePath) && JFile::exists($customImagePath))
					{
						// move the file to its place
						JFile::copy($customImagePath, $tmpImagePath);
					}
				}
				if ('folder' === $type)
				{
					$tmpFolderPath = str_replace('//', '/', $tmpPath.'/'.$item);
					$customFolderPath = str_replace('//', '/', $this->customPath.'/'.$item);
					if (!JFolder::exists($tmpFolderPath) && JFolder::exists($customFolderPath))
					{
						// move the folder to its place
						JFolder::copy($customFolderPath, $tmpFolderPath,'',true);
					}
				}
			}
		}
		return true;
	}

	/**
	 * Check if a field has multiple fields
	 * 
	 * @param   string   $typeID  The type ID
	 *
	 * @return  bool true on success
	 * 
	 */
	protected function checkMultiFields($typeID)
	{
		if(isset($this->isMultiple[$typeID]))
		{
			return $this->isMultiple[$typeID];
		}
		elseif ($type = $this->getFieldType($typeID))
		{
			if ('repeatable' === $type || 'subform' === $type )
			{
				$this->isMultiple[$typeID] = true;
			}
			else
			{
				$this->isMultiple[$typeID] = false;
			}
			return $this->isMultiple[$typeID];
		}
		return false;
	}

	/**
	 * Get the field type
	 * 
	 * @param   string   $id  The field type id
	 *
	 * @return  string field type
	 * 
	 */
	protected function getFieldType($id)
	{
		if (!isset($this->fieldTypes[$id]))
		{
			$properties = ComponentbuilderHelper::getVar('fieldtype', $id, 'id', 'properties');
			if (ComponentbuilderHelper::checkJson($properties))
			{
				$properties = json_decode($properties, true);
				foreach ($properties as $property)
				{
					if ('type' === $property['name'])
					{
						if (isset($property['example'])  && ComponentbuilderHelper::checkString($property['example']))
						{
							$this->fieldTypes[$id] = $property['example'];
							break;
						}
					}
				}
			}
			// if not found
			if (!isset($this->fieldTypes[$id]) && $name = ComponentbuilderHelper::getVar('fieldtype', $id, 'id', 'name'))
			{
				$this->fieldTypes[$id] = ComponentbuilderHelper::safeString($name);
			}
		}
		// return the type
		if (isset($this->fieldTypes[$id]))
		{
			return $this->fieldTypes[$id];
		}
		return false;
	}

	/**
	 * Set Template and Layout Data
	 * 
	 * @param   string   $default  The content to check
	 *
	 * @return  void
	 * 
	 */
	protected function getTemplateLayout($default, $user = false)
	{
		// set the Template data
		$temp1 = ComponentbuilderHelper::getAllBetween($default, "\$this->loadTemplate('","')");
		$temp2 = ComponentbuilderHelper::getAllBetween($default, '$this->loadTemplate("','")');
		$templates = array();
		$again = array();
		if (ComponentbuilderHelper::checkArray($temp1) && ComponentbuilderHelper::checkArray($temp2))
		{
			$templates = array_merge($temp1,$temp2);
		}
		else
		{
			if (ComponentbuilderHelper::checkArray($temp1))
			{
				$templates = $temp1;
			}
			elseif (ComponentbuilderHelper::checkArray($temp2))
			{
				$templates = $temp2;
			}
		}
		if (ComponentbuilderHelper::checkArray($templates))
		{
			foreach ($templates as $template)
			{
				$data = $this->getDataWithAlias($template, 'template');
				if (ComponentbuilderHelper::checkArray($data))
				{
					if (!isset($this->templateIds[$data['id']]))
					{
						$this->templateIds[$data['id']] = $data['id'];
						// call self to get child data
						$again[] = $data['html'];
						$again[] = $data['php_view'];
					}
				}
			}
		}
		// set  the layout data
		$lay1 = ComponentbuilderHelper::getAllBetween($default, "JLayoutHelper::render('","',");
		$lay2 = ComponentbuilderHelper::getAllBetween($default, 'JLayoutHelper::render("','",');
		if (ComponentbuilderHelper::checkArray($lay1) && ComponentbuilderHelper::checkArray($lay2))
		{
			$layouts = array_merge($lay1,$lay2);
		}
		else
		{
			if (ComponentbuilderHelper::checkArray($lay1))
			{
				$layouts = $lay1;
			}
			elseif (ComponentbuilderHelper::checkArray($lay2))
			{
				$layouts = $lay2;
			}
		}
		if (isset($layouts) && ComponentbuilderHelper::checkArray($layouts))
		{
			foreach ($layouts as $layout)
			{
				$data = $this->getDataWithAlias($layout, 'layout');
				if (ComponentbuilderHelper::checkArray($data))
				{
					if (!isset($this->layoutIds[$data['id']]))
					{
						$this->layoutIds[$data['id']] = $data['id'];
						// call self to get child data
						$again[] = $data['html'];
						$again[] = $data['php_view'];
					}
				}
			}
		}
		if (ComponentbuilderHelper::checkArray($again))
		{
			foreach ($again as $get)
			{
				$this->getTemplateLayout($get);
			}
		}
		// Set the Data 
		if ($user)
		{
			// add templates
			if (ComponentbuilderHelper::checkArray($this->templateIds))
			{
				$this->setData('template', $this->templateIds, 'id');
			}
			// add layouts
			if (ComponentbuilderHelper::checkArray($this->layoutIds))
			{
				$this->setData('layout', $this->layoutIds, 'id');
			}
		}
	}
	
	/**
	 * Get Data With Alias
	 * 
	 * @param   string   $n_ame  The alias name
	 * @param   string   $table  The table where to find the alias
	 * @param   string   $view  The view code name
	 *
	 * @return  array The data found with the alias
	 * 
	 */
	protected function getDataWithAlias($n_ame, $table)
	{
		// Create a new query object.
		$query = $this->_db->getQuery(true);
		$query->select($this->_db->quoteName(array('a.id', 'a.alias', 'a.'.$table, 'a.php_view', 'a.add_php_view')));
		$query->from('#__componentbuilder_'.$table.' AS a');
		$this->_db->setQuery($query);
		$rows = $this->_db->loadObjectList();
		foreach ($rows as $row)
		{
			$k_ey = ComponentbuilderHelper::safeString($row->alias);
			$key = preg_replace("/[^A-Za-z]/", '', $k_ey);
			$name = preg_replace("/[^A-Za-z]/", '', $n_ame);
			if ($k_ey == $n_ame || $key == $name)
			{
				$php_view = '';
				if ($row->add_php_view == 1)
				{
					$php_view = base64_decode($row->php_view);
				}
				$contnent = base64_decode($row->{$table});
				// return to continue the search
				return array('id' => $row->id, 'html' => $contnent, 'php_view' => $php_view);
			}
		}
		return false;
	}

	/**
	* Set the ids of the found custom code
	*
	*  @param   object    $item   The item being searched
	*  @param   string    $target  The target table
	* 
	*  @return  void
	* 
	*/
	protected function setCustomCodeIds($item, $target)
	{
		if ($keys = $this->getCodeSearchKeys($target))
		{
			foreach ($keys['search'] as $key)
			{
				if (!isset($keys['not_base64'][$key]))
				{
					$value = base64_decode($item->{$key});
				}
				else
				{
					$value = $item->{$key};
				}
				// search the value to see if it has custom code
				$codeArray = ComponentbuilderHelper::getAllBetween($value, '[CUSTOMC' . 'ODE=',']');
				if (ComponentbuilderHelper::checkArray($codeArray))
				{
					foreach ($codeArray as $func)
					{
						// first make sure we have only the function key
						if (strpos($func, '+') !== false)
						{
							$funcArray = explode('+', $func);
							$func = $funcArray[0];
						}
						if (!isset($this->customCodeM[$func]))
						{
							$this->customCodeM[$func] = $func;
							// if numeric add to ids
							if (is_numeric($func))
							{
								$this->customCodeIds[$func] = (int) $func;
							}
							elseif (ComponentbuilderHelper::checkString($func))
							{
								if ($funcID = ComponentbuilderHelper::getVar('custom_code', $func, 'function_name', 'id'))
								{
									$this->customCodeIds[$funcID] = (int) $funcID;
								}
							}
						}
					}
				}
			}
		}
	}

	/**
	* Set the language strings for this component
	*
	*  @param   int    $id   The component id
	* 
	*  @return  void
	* 
	*/
	protected function setLanguageTranslation(&$id)
	{
		// Create a new query object.
		$query = $this->_db->getQuery(true);
		$query->select(array('a.*'));
		$query->from('#__componentbuilder_language_translation AS a');
		// Implement View Level Access
		if (!$this->user->authorise('core.options', 'com_componentbuilder'))
		{
			$groups = implode(',', $this->user->getAuthorisedViewLevels());
			$query->where('a.access IN (' . $groups . ')');
		}

		// Order the results by ordering
		$query->order('a.ordering  ASC');

		// Load the items
		$this->_db->setQuery($query);
		$this->_db->execute();
		if ($this->_db->getNumRows())
		{
			$items = $this->_db->loadObjectList();
			// check if we have items
			if (ComponentbuilderHelper::checkArray($items))
			{
				if (!isset($this->smartExport['language_translation']))
				{
					$this->smartExport['language_translation'] = array();
				}
				foreach ($items as $item)
				{
					if (!isset($this->smartExport['language_translation'][$item->id]) && ComponentbuilderHelper::checkJson($item->components))
					{
						$components = json_decode($item->components, true);
						if (in_array($id, $components))
						{
							// load to global object
							$this->smartExport['language_translation'][$item->id] = $item;
							// add languages
							if (isset($item->translation))
							{
								$this->setData('language', $this->getIds($item->translation, 'subform', 'language'), 'langtag');
							}
						}
					}
				}
			}
		}
	}

	/**
	* Get the package name
	*
	*  @param   array    $items of all components
	* 
	*  @return  string     The package name
	* 
	*/
	protected function getPackageName(&$items)
	{
		foreach ($items as $item)
		{
			if (isset($item->system_name))
			{
				return ComponentbuilderHelper::safeString($item->system_name, 'cAmel');
			}
			else
			{
				return ComponentbuilderHelper::safeString($item->name_code);
			}
		}
	}

	/**
	* Get the keys of the values to search custom code in
	*
	*  @param   string    $targe  The table targeted
	* 
	*  @return  array      The query options
	* 
	*/
	protected function getCodeSearchKeys($target)
	{
		$targets = array();
		// #__componentbuilder_joomla_component as a
		$targets['joomla_component'] = array();
		$targets['joomla_component']['search'] = array('php_preflight_install','php_postflight_install',
			'php_preflight_update','php_postflight_update','php_method_uninstall',
			'php_helper_admin','php_admin_event','php_helper_both','php_helper_site',
			'php_site_event','php_dashboard_methods','dashboard_tab');
		$targets['joomla_component']['not_base64'] = array('dashboard_tab' => 'json');

		// #__componentbuilder_admin_view as b
		$targets['admin_view'] = array();
		$targets['admin_view']['search'] = array('javascript_view_file','javascript_view_footer','javascript_views_file',
			'javascript_views_footer','php_getitem','php_save','php_postsavehook','php_getitems',
			'php_getitems_after_all','php_getlistquery','php_allowedit','php_before_delete',
			'php_after_delete','php_before_publish','php_after_publish','php_batchcopy',
			'php_batchmove','php_document','php_model','php_controller','php_import_display',
			'php_import','php_import_setdata','php_import_save','html_import_view','php_ajaxmethod');
		$targets['admin_view']['not_base64'] = array();

		// #__componentbuilder_custom_admin_view as c
		$targets['custom_admin_view'] = array();
		$targets['custom_admin_view']['search'] = array('default','php_view','php_jview','php_jview_display','php_document',
			'js_document','css_document','css','php_model','php_controller');
		$targets['custom_admin_view']['not_base64'] = array();

		// #__componentbuilder_site_view as d
		$targets['site_view'] = array();
		$targets['site_view']['search'] = array('default','php_view','php_jview','php_jview_display','php_document',
			'js_document','css_document','css','php_ajaxmethod','php_model','php_controller');
		$targets['site_view']['not_base64'] = array();

		// #__componentbuilder_field as e
		$targets['field'] = array();
		$targets['field']['search'] = array('xml','javascript_view_footer','javascript_views_footer');
		$targets['field']['not_base64'] = array('xml' => 'json');

		// #__componentbuilder_dynamic_get as f
		$targets['dynamic_get'] = array();
		$targets['dynamic_get']['search'] = array('php_before_getitem','php_after_getitem','php_before_getitems','php_after_getitems',
			'php_getlistquery');
		$targets['dynamic_get']['not_base64'] = array();

		// #__componentbuilder_template as g
		$targets['template'] = array();
		$targets['template']['search'] = array('php_view','template');
		$targets['template']['not_base64'] = array();

		// #__componentbuilder_layout as h
		$targets['layout'] = array();
		$targets['layout']['search'] = array('php_view','layout');
		$targets['layout']['not_base64'] = array();

		// return the query string to search
		if (isset($targets[$target]))
		{
			return $targets[$target];
		}
		return false;
	}
	
	/**
	 * Method to auto-populate the model state.
	 *
	 * @return  void
	 */
	protected function populateState($ordering = null, $direction = null)
	{
		$app = JFactory::getApplication();

		// Adjust the context to support modal layouts.
		if ($layout = $app->input->get('layout'))
		{
			$this->context .= '.' . $layout;
		}
		$system_name = $this->getUserStateFromRequest($this->context . '.filter.system_name', 'filter_system_name');
		$this->setState('filter.system_name', $system_name);

		$name_code = $this->getUserStateFromRequest($this->context . '.filter.name_code', 'filter_name_code');
		$this->setState('filter.name_code', $name_code);

		$component_version = $this->getUserStateFromRequest($this->context . '.filter.component_version', 'filter_component_version');
		$this->setState('filter.component_version', $component_version);

		$short_description = $this->getUserStateFromRequest($this->context . '.filter.short_description', 'filter_short_description');
		$this->setState('filter.short_description', $short_description);

		$companyname = $this->getUserStateFromRequest($this->context . '.filter.companyname', 'filter_companyname');
		$this->setState('filter.companyname', $companyname);

		$author = $this->getUserStateFromRequest($this->context . '.filter.author', 'filter_author');
		$this->setState('filter.author', $author);
        
		$sorting = $this->getUserStateFromRequest($this->context . '.filter.sorting', 'filter_sorting', 0, 'int');
		$this->setState('filter.sorting', $sorting);
        
		$access = $this->getUserStateFromRequest($this->context . '.filter.access', 'filter_access', 0, 'int');
		$this->setState('filter.access', $access);
        
		$search = $this->getUserStateFromRequest($this->context . '.filter.search', 'filter_search');
		$this->setState('filter.search', $search);

		$published = $this->getUserStateFromRequest($this->context . '.filter.published', 'filter_published', '');
		$this->setState('filter.published', $published);
        
		$created_by = $this->getUserStateFromRequest($this->context . '.filter.created_by', 'filter_created_by', '');
		$this->setState('filter.created_by', $created_by);

		$created = $this->getUserStateFromRequest($this->context . '.filter.created', 'filter_created');
		$this->setState('filter.created', $created);

		// List state information.
		parent::populateState($ordering, $direction);
	}
	
	/**
	 * Method to get an array of data items.
	 *
	 * @return  mixed  An array of data items on success, false on failure.
	 */
	public function getItems()
	{ 
		// check in items
		$this->checkInNow();

		// load parent items
		$items = parent::getItems();

		// set values to display correctly.
		if (ComponentbuilderHelper::checkArray($items))
		{
			// get user object.
			$user = JFactory::getUser();
			foreach ($items as $nr => &$item)
			{
				$access = ($user->authorise('joomla_component.access', 'com_componentbuilder.joomla_component.' . (int) $item->id) && $user->authorise('joomla_component.access', 'com_componentbuilder'));
				if (!$access)
				{
					unset($items[$nr]);
					continue;
				}

			}
		}  
        
		// return items
		return $items;
	}
	
	/**
	 * Method to build an SQL query to load the list data.
	 *
	 * @return	string	An SQL query
	 */
	protected function getListQuery()
	{
		// Get the user object.
		$user = JFactory::getUser();
		// Create a new query object.
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);

		// Select some fields
		$query->select('a.*');

		// From the componentbuilder_item table
		$query->from($db->quoteName('#__componentbuilder_joomla_component', 'a'));

		// Filter by published state
		$published = $this->getState('filter.published');
		if (is_numeric($published))
		{
			$query->where('a.published = ' . (int) $published);
		}
		elseif ($published === '')
		{
			$query->where('(a.published = 0 OR a.published = 1)');
		}

		// Join over the asset groups.
		$query->select('ag.title AS access_level');
		$query->join('LEFT', '#__viewlevels AS ag ON ag.id = a.access');
		// Filter by access level.
		if ($access = $this->getState('filter.access'))
		{
			$query->where('a.access = ' . (int) $access);
		}
		// Implement View Level Access
		if (!$user->authorise('core.options', 'com_componentbuilder'))
		{
			$groups = implode(',', $user->getAuthorisedViewLevels());
			$query->where('a.access IN (' . $groups . ')');
		}
		// Filter by search.
		$search = $this->getState('filter.search');
		if (!empty($search))
		{
			if (stripos($search, 'id:') === 0)
			{
				$query->where('a.id = ' . (int) substr($search, 3));
			}
			else
			{
				$search = $db->quote('%' . $db->escape($search) . '%');
				$query->where('(a.system_name LIKE '.$search.' OR a.name_code LIKE '.$search.' OR a.short_description LIKE '.$search.' OR a.companyname LIKE '.$search.' OR a.author LIKE '.$search.' OR a.name LIKE '.$search.')');
			}
		}

		// Filter by Companyname.
		if ($companyname = $this->getState('filter.companyname'))
		{
			$query->where('a.companyname = ' . $db->quote($db->escape($companyname)));
		}
		// Filter by Author.
		if ($author = $this->getState('filter.author'))
		{
			$query->where('a.author = ' . $db->quote($db->escape($author)));
		}

		// Add the list ordering clause.
		$orderCol = $this->state->get('list.ordering', 'a.id');
		$orderDirn = $this->state->get('list.direction', 'asc');	
		if ($orderCol != '')
		{
			$query->order($db->escape($orderCol . ' ' . $orderDirn));
		}

		return $query;
	}

	/**
	* Method to get list export data.
	*
	* @return mixed  An array of data items on success, false on failure.
	*/
	public function getExportData($pks)
	{
		// setup the query
		if (ComponentbuilderHelper::checkArray($pks))
		{
			// Set a value to know this is exporting method.
			$_export = true;
			// Get the user object.
			$user = JFactory::getUser();
			// Create a new query object.
			$db = JFactory::getDBO();
			$query = $db->getQuery(true);

			// Select some fields
			$query->select('a.*');

			// From the componentbuilder_joomla_component table
			$query->from($db->quoteName('#__componentbuilder_joomla_component', 'a'));
			$query->where('a.id IN (' . implode(',',$pks) . ')');
			// Implement View Level Access
			if (!$user->authorise('core.options', 'com_componentbuilder'))
			{
				$groups = implode(',', $user->getAuthorisedViewLevels());
				$query->where('a.access IN (' . $groups . ')');
			}

			// Order the results by ordering
			$query->order('a.ordering  ASC');

			// Load the items
			$db->setQuery($query);
			$db->execute();
			if ($db->getNumRows())
			{
				$items = $db->loadObjectList();

				// Get the basic encryption key.
				$basickey = ComponentbuilderHelper::getCryptKey('basic');
				// Get the encryption object.
				$basic = new FOFEncryptAes($basickey, 128);

				// set values to display correctly.
				if (ComponentbuilderHelper::checkArray($items))
				{
					// get user object.
					$user = JFactory::getUser();
					foreach ($items as $nr => &$item)
					{
						$access = ($user->authorise('joomla_component.access', 'com_componentbuilder.joomla_component.' . (int) $item->id) && $user->authorise('joomla_component.access', 'com_componentbuilder'));
						if (!$access)
						{
							unset($items[$nr]);
							continue;
						}

						// decode sql
						$item->sql = base64_decode($item->sql);
						// decode php_preflight_update
						$item->php_preflight_update = base64_decode($item->php_preflight_update);
						// decode php_postflight_update
						$item->php_postflight_update = base64_decode($item->php_postflight_update);
						if ($basickey && !is_numeric($item->whmcs_key) && $item->whmcs_key === base64_encode(base64_decode($item->whmcs_key, true)))
						{
							// decrypt whmcs_key
							$item->whmcs_key = $basic->decryptString($item->whmcs_key);
						}
						// decode php_preflight_install
						$item->php_preflight_install = base64_decode($item->php_preflight_install);
						// decode php_postflight_install
						$item->php_postflight_install = base64_decode($item->php_postflight_install);
						// decode php_method_uninstall
						$item->php_method_uninstall = base64_decode($item->php_method_uninstall);
						// decode readme
						$item->readme = base64_decode($item->readme);
						if ($basickey && !is_numeric($item->export_key) && $item->export_key === base64_encode(base64_decode($item->export_key, true)))
						{
							// decrypt export_key
							$item->export_key = $basic->decryptString($item->export_key);
						}
						// decode php_helper_both
						$item->php_helper_both = base64_decode($item->php_helper_both);
						// decode php_helper_admin
						$item->php_helper_admin = base64_decode($item->php_helper_admin);
						// decode php_admin_event
						$item->php_admin_event = base64_decode($item->php_admin_event);
						// decode php_helper_site
						$item->php_helper_site = base64_decode($item->php_helper_site);
						// decode php_site_event
						$item->php_site_event = base64_decode($item->php_site_event);
						// decode javascript
						$item->javascript = base64_decode($item->javascript);
						// decode css
						$item->css = base64_decode($item->css);
						// decode php_dashboard_methods
						$item->php_dashboard_methods = base64_decode($item->php_dashboard_methods);
						// decode buildcompsql
						$item->buildcompsql = base64_decode($item->buildcompsql);
						// unset the values we don't want exported.
						unset($item->asset_id);
						unset($item->checked_out);
						unset($item->checked_out_time);
					}
				}
				// Add headers to items array.
				$headers = $this->getExImPortHeaders();
				if (ComponentbuilderHelper::checkObject($headers))
				{
					array_unshift($items,$headers);
				}
				return $items;
			}
		}
		return false;
	}

	/**
	* Method to get header.
	*
	* @return mixed  An array of data items on success, false on failure.
	*/
	public function getExImPortHeaders()
	{
		// Get a db connection.
		$db = JFactory::getDbo();
		// get the columns
		$columns = $db->getTableColumns("#__componentbuilder_joomla_component");
		if (ComponentbuilderHelper::checkArray($columns))
		{
			// remove the headers you don't import/export.
			unset($columns['asset_id']);
			unset($columns['checked_out']);
			unset($columns['checked_out_time']);
			$headers = new stdClass();
			foreach ($columns as $column => $type)
			{
				$headers->{$column} = $column;
			}
			return $headers;
		}
		return false;
	} 
	
	/**
	 * Method to get a store id based on model configuration state.
	 *
	 * @return  string  A store id.
	 *
	 */
	protected function getStoreId($id = '')
	{
		// Compile the store id.
		$id .= ':' . $this->getState('filter.id');
		$id .= ':' . $this->getState('filter.search');
		$id .= ':' . $this->getState('filter.published');
		$id .= ':' . $this->getState('filter.ordering');
		$id .= ':' . $this->getState('filter.created_by');
		$id .= ':' . $this->getState('filter.modified_by');
		$id .= ':' . $this->getState('filter.system_name');
		$id .= ':' . $this->getState('filter.name_code');
		$id .= ':' . $this->getState('filter.component_version');
		$id .= ':' . $this->getState('filter.short_description');
		$id .= ':' . $this->getState('filter.companyname');
		$id .= ':' . $this->getState('filter.author');

		return parent::getStoreId($id);
	}

	/**
	* Build an SQL query to checkin all items left checked out longer then a set time.
	*
	* @return  a bool
	*
	*/
	protected function checkInNow()
	{
		// Get set check in time
		$time = JComponentHelper::getParams('com_componentbuilder')->get('check_in');
		
		if ($time)
		{

			// Get a db connection.
			$db = JFactory::getDbo();
			// reset query
			$query = $db->getQuery(true);
			$query->select('*');
			$query->from($db->quoteName('#__componentbuilder_joomla_component'));
			$db->setQuery($query);
			$db->execute();
			if ($db->getNumRows())
			{
				// Get Yesterdays date
				$date = JFactory::getDate()->modify($time)->toSql();
				// reset query
				$query = $db->getQuery(true);

				// Fields to update.
				$fields = array(
					$db->quoteName('checked_out_time') . '=\'0000-00-00 00:00:00\'',
					$db->quoteName('checked_out') . '=0'
				);

				// Conditions for which records should be updated.
				$conditions = array(
					$db->quoteName('checked_out') . '!=0', 
					$db->quoteName('checked_out_time') . '<\''.$date.'\''
				);

				// Check table
				$query->update($db->quoteName('#__componentbuilder_joomla_component'))->set($fields)->where($conditions); 

				$db->setQuery($query);

				$db->execute();
			}
		}

		return false;
	}
}
