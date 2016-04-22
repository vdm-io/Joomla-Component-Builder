<?php
/**--------------------------------------------------------------------------------------------------------|  www.vdm.io  |------/
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

/**
 * Get class as the main compilers class
 */
class Get
{
	/**
	 * The Params
	 * 
	 * @var     object
	 */
	public $params;
	
	/**
	 * The Compiler Path
	 * 
	 * @var     object
	 */
	public $compilerPath;
	
	/**
	 * The Component data
	 * 
	 * @var      object
	 */
	public $componentData;
	
	/**
	 * The Language prefix
	 * 
	 * @var      string
	 */
	public $langPrefix = 'COM_';
	
	/**
	 * The Language content
	 * 
	 * @var      array
	 */
	public $langContent = array();
	
	/**
	 * The Component Code Name
	 * 
	 * @var      string
	 */
	public $componentCodeName;
	
	/**
	 * The Component version
	 * 
	 * @var      string
	 */
	public $component_version;
	
	/**
	 * The UIKIT Switch
	 * 
	 * @var	boolean
	 */
	public $uikit = false;
	
	/**
	 * The UIKIT component checker
	 * 
	 * @var     array
	 */
	public $uikitComp = array();
	
	/**
	 * The FOOTABLE Switch
	 * 
	 * @var      boolean
	 */
	public $footable = false;
	
	/**
	 * The FOOTABLE Version
	 * 
	 * @var      int
	 */
	public $footableVersion;
	
	/**
	 * The Google Chart Switch per view
	 * 
	 * @var     array
	 */
	public $googleChart = array();
	
	/**
	 * The Google Chart Switch
	 * 
	 * @var     boolean
	 */
	public $googlechart = false;
	
	/**
	 * The Import & Export Switch
	 * 
	 * @var      boolean
	 */
	public $addEximport = false;
	
	/**
	 * The Tag & History Switch
	 * 
	 * @var      boolean
	 */
	public $setTagHistory = false;
	
	/**
	 * The site edit views
	 * 
	 * @var     array
	 */
	public $siteEditView = array();
	
	/**
	 * The Language target
	 * 
	 * @var     string
	 */
	public $lang = 'admin';
	
	/**
	 * The Build target Switch
	 * 
	 * @var     string
	 */
	public $target;
	
	/**
	 * The unique codes
	 * 
	 * @var     array
	 */
	public $uniquecodes = array();
	
	/**
	 * The unique keys
	 * 
	 * @var     array
	 */
	public $uniquekeys = array();
	
	/**
	 * The Ad contributors Switch
	 * 
	 * @var     boolean
	 */
	public $addContributors = false;
	
	/**
	 * The Custom Script Builder
	 * 
	 * @var     array
	 */
	public $customScriptBuilder = array();
	
	/**
	 * The Footable Script Builder
	 * 
	 * @var     array
	 */
	public $footableScripts = array();
	
	/**
	 * The pathe to the bom file to be used
	 * 
	 * @var     string
	 */
	public $bomPath;
	
	/**
	 * The SQL Tweak of admin views
	 * 
	 * @var     array
	 */
	public $sqlTweak = array();
	
	/**
	 * The admin views data array
	 * 
	 * @var     array
	 */
	private $_adminViewData = array();
	
	/**
	 * The field data array
	 * 
	 * @var     array
	 */
	private $_fieldData = array();
	
	/**
	 * The linked admin view tabs
	 * 
	 * @var     array
	 */
	public $linkedAdminViews = array();
	
	/**
	 * The Add Ajax Switch
	 * 
	 * @var    boolean
	 */
	public $addAjax = false;
	
	/**
	 * The Add Site Ajax Switch
	 * 
	 * @var     boolean
	 */
	public $addSiteAjax = false;
	
	/**
	 * The get Module Script Switch
	 * 
	 * @var    array
	 */
	public $getModule = array();
	
	/**
	 * The template data
	 * 
	 * @var    array
	 */
	public $templateData = array();
	
	/**
	 * The layout data
	 * 
	 * @var    array
	 */
	public $layoutData = array();
	
	/**
	 * The Advanced Encryption Switch
	 * 
	 * @var    boolean
	 */
	public $advancedEncryption = false;
	
	/**
	 * The Basic Encryption Switch
	 * 
	 * @var    boolean
	 */
	public $basicEncryption = false;
	
	/**
	 * The Custom field Switch per view
	 * 
	 * @var    array
	 */
	public $customFieldScript = array();
	
	/**
	 * The site main get
	 * 
	 * @var    array
	 */
	public $siteMainGet = array();
	
	/**
	 * The site dynamic get
	 * 
	 * @var    array
	 */
	public $siteDynamicGet = array();
	
	/**
	 * The get AS lookup
	 * 
	 * @var    array
	 */
	public $getAsLookup = array();
	
	/**
	 * The site fields
	 * 
	 * @var    array
	 */
	public $siteFields = array();


	/***
	 * Constructor
	 */
	public function __construct($config = array ())
	{
		if (isset($config) && count($config))
		{
			// Set the params
			$this->params			= JComponentHelper::getParams('com_componentbuilder');
			// load the compiler path
			$this->compilerPath		= $this->params->get('compiler_folder_path', JPATH_COMPONENT_ADMINISTRATOR.'/compiler');
			// get the component data
			$this->componentData		= $this->getComponentData($config['componentId']);
			
			return true;
		}
		return false;
	}
	
	/**
	 * get all Component Data
	 * 
	 * @param   int   $id  The component ID
	 *
	 * @return  oject The component data
	 * 
	 */
	public function getComponentData($id)
	{
		// Get a db connection.
		$db = JFactory::getDbo();

		// Create a new query object.
		$query = $db->getQuery(true);

		$query->select('a.*');
		$query->from('#__componentbuilder_component AS a');
		$query->where($db->quoteName('a.id') . ' = '. $db->quote($id));

		// Reset the query using our newly populated query object.
		$db->setQuery($query);

		// Load the results as a list of stdClass objects
		$component = $db->loadObject();
		// set lang prefix
		$this->langPrefix .= ComponentbuilderHelper::safeString($component->name_code,'U');
		// set component code name
		$this->componentCodeName = ComponentbuilderHelper::safeString($component->name_code);
		// set component sales name
		$component->sales_name = ComponentbuilderHelper::safeString($component->system_name);
		// ensure version naming is correct
		$this->component_version = preg_replace('/[^0-9.]+/', '', $component->component_version);
		// ser the addfolders data
		$addfolders	= json_decode($component->addfolders,true);
		if (ComponentbuilderHelper::checkArray($addfolders))
		{
			foreach ($addfolders as $option => $values)
			{
				foreach ($values as $nr => $value)
				{
					$component->folders[$nr][$option] = $value;
				}
			}
			unset($component->addfolders);
		}
		// ser the addfiles data
		$addfiles	= json_decode($component->addfiles,true);
		if (ComponentbuilderHelper::checkArray($addfiles))
		{
			foreach ($addfiles as $option => $values)
			{
				foreach ($values as $nr => $value)
				{
					$component->files[$nr][$option] = $value;
				}
			}
			unset($component->addfiles);
		}
		// set the uikit switch
		if ($component->adduikit)
		{
			$this->uikit = true;
		}
		// set the footable switch
		if ($component->addfootable)
		{
			$this->footable = true;
			// add the version
			$this->footableVersion = (1 == $component->addfootable || 2 == $component->addfootable) ? 2 : $component->addfootable;
		}

		// ser the addcustommenu data
		$addcustommenus	= json_decode($component->addcustommenus,true);
		if (ComponentbuilderHelper::checkArray($addcustommenus))
		{
			foreach ($addcustommenus as $option => $values)
			{
				foreach ($values as $nr => $value)
				{
					$component->custommenus[$nr][$option] = $value;
				}
			}
			unset($component->addcustommenus);
		}
		
		// tweak the mysql dump settings if needed
		$sql_tweak	= json_decode($component->sql_tweak,true);
		if (ComponentbuilderHelper::checkArray($sql_tweak))
		{
			$component->sql_tweak = array();
			foreach ($sql_tweak as $option => $values)
			{
				foreach ($values as $nr => $value)
				{
					if ((string)(int)$value == $value)
					{
						$component->sql_tweak[$nr][$option] = (int) $value;
					}
					else
					{
						$component->sql_tweak[$nr][$option] = $value;
					}
				}
			}
			// build the tweak settings
			$this->setSqlTweaking($component->sql_tweak);
			unset($component->sql_tweak);
		}
		
		// set the admin_view data
		$admin_views	= json_decode($component->addadmin_views,true);
		if (ComponentbuilderHelper::checkArray($admin_views))
		{
			foreach ($admin_views as $option => $values)
			{
				foreach ($values as $nr => $value)
				{
					if ((string)(int)$value == $value)
					{
						$component->admin_views[$nr][$option] = (int) $value;
					}
					else
					{
						$component->admin_views[$nr][$option] = $value;
					}
				}
			}
			unset($component->addadmin_views);
			// sort the views acording to order
			usort($component->admin_views, function($a, $b)
			{
				if ($a['order'] != 0 && $b['order'] != 0)
				{
					return $a['order'] - $b['order'];
				}
				elseif ($b['order'] != 0 && $a['order'] == 0)
				{
					return 1;
				}
				elseif ($a['order'] != 0 && $b['order'] == 0)
				{
					return 0;
				}
				return 1;
			});
			// load the view and field data
			foreach ($component->admin_views as $key => &$view)
			{
				if ($view['port'] && !$this->addEximport)
				{
					$this->addEximport = true;
				}
				if ($view['history'] && !$this->setTagHistory)
				{
					$this->setTagHistory = true;
				}
				if ($view['edit_create_site_view'])
				{
					$this->siteEditView[$view['adminview']] = true;
				}
				// TODO this is a temp fix until front view is added
				$view['view'] = $view['adminview'];
				$view['settings'] = $this->getAdminViewData($view['view']);
			}
			unset($component->addadmin_view);
		}

		// set the site_view data
		$site_views	= json_decode($component->addsite_views,true);
		if (ComponentbuilderHelper::checkArray($site_views))
		{
			foreach ($site_views as $option => $values)
			{
				foreach ($values as $nr => $value)
				{
					if ((string)(int)$value == $value)
					{
						$component->site_views[$nr][$option] = (int) $value;
					}
					else
					{
						$component->site_views[$nr][$option] = $value;
					}
				}
			}
			unset($component->addsite_views);
			$this->lang = 'site';
			$this->target = 'site';
			// load the view and field data
			foreach ($component->site_views as $key => &$view)
			{
				// TODO this is a temp fix until front view is added
				$view['view'] = $view['siteview'];
				$view['settings'] = $this->getCustomViewData($view['view']);
			}
		}

		// set the custom_admin_views data
		$custom_admin_views	= json_decode($component->addcustom_admin_views,true);
		if (ComponentbuilderHelper::checkArray($custom_admin_views))
		{
			foreach ($custom_admin_views as $option => $values)
			{
				foreach ($values as $nr => $value)
				{
					if ((string)(int)$value == $value)
					{
						$component->custom_admin_views[$nr][$option] = (int) $value;
					}
					else
					{
						$component->custom_admin_views[$nr][$option] = $value;
					}
				}
			}
			unset($component->addcustom_admin_views);
			$this->lang = 'admin';
			$this->target = 'custom_admin';
			// load the view and field data
			foreach ($component->custom_admin_views as $key => &$view)
			{
				// TODO this is a temp fix until front view is added
				$view['view'] = $view['customadminview'];
				$view['settings'] = $this->getCustomViewData($view['view'], 'custom_admin_view');
			}
		}

		// ser the config data
		$addconfig	= json_decode($component->addconfig,true);
		if (ComponentbuilderHelper::checkArray($addconfig))
		{
			foreach ($addconfig as $option => $values)
			{
				foreach ($values as $nr => $value)
				{
					$component->config[$nr]['alias'] = 0;
					$component->config[$nr]['title'] = 0;
					if ($option == 'field')
					{
						// load the field data
						$component->config[$nr]['settings'] = $this->getFieldData($value);
					}
					else
					{
						$component->config[$nr][$option] = $value;
					}
				}
			}
			unset($component->addconfig);
		}

		// check if any contributors is to be added
		$contributors = json_decode($component->addcontributors,true);
		if (ComponentbuilderHelper::checkArray($contributors))
		{
			$this->addContributors = true;
			foreach ($contributors as $option => $values)
			{
				foreach ($values as $nr => $value)
				{
					$component->contributors[$nr][$option] = $value;
				}
			}
			unset($component->addcontributors);
		}

		// check if version updating is set
		$version_update = json_decode($component->version_update,true);
		if (ComponentbuilderHelper::checkArray($version_update))
		{
			$component->version_update = array();
			foreach ($version_update as $option => $values)
			{
				foreach ($values as $nr => $value)
				{
					$component->version_update[$nr][$option] = $value;
				}
			}
		}

		// add_css
		if ($component->add_css == 1)
		{
			$this->customScriptBuilder['component_css'] = base64_decode($component->css);
			unset($component->css);
		}
		else
		{
			$this->customScriptBuilder['component_css'] = '';
		}
		// add_php_helper
		if ($component->add_php_helper_admin == 1)
		{
			$this->lang = 'admin';
			$this->customScriptBuilder['component_php_helper_admin'] = "\n\n".$this->setCustomContentLang(base64_decode($component->php_helper_admin));
			unset($component->php_helper);
		}
		else
		{
			$this->customScriptBuilder['component_php_helper_admin'] = '';
		}
		// add_admin_event
		if ($component->add_admin_event == 1)
		{
			$this->lang = 'admin';
			$this->customScriptBuilder['component_php_admin_event'] = $this->setCustomContentLang(base64_decode($component->php_admin_event));
			unset($component->php_admin_event);
		}
		else
		{
			$this->customScriptBuilder['component_php_admin_event'] = '';
		}
		// add_php_helper_site
		if ($component->add_php_helper_site == 1)
		{
			$this->lang = 'site';
			$this->customScriptBuilder['component_php_helper_site'] = "\n\n".$this->setCustomContentLang(base64_decode($component->php_helper_site));
			unset($component->php_helper);
		}
		else
		{
			$this->customScriptBuilder['component_php_helper_site'] = '';
		}
		// add_site_event
		if ($component->add_site_event == 1)
		{
			$this->lang = 'site';
			$this->customScriptBuilder['component_php_site_event'] = $this->setCustomContentLang(base64_decode($component->php_site_event));
			unset($component->php_site_event);
		}
		else
		{
			$this->customScriptBuilder['component_php_site_event'] = '';
		}
		// add_sql
		if ($component->add_sql == 1)
		{
			$this->customScriptBuilder['sql']['component_sql'] = base64_decode($component->sql);
			unset($component->sql);
		}
		// bom
		if (ComponentbuilderHelper::checkString($component->bom))
		{
			$this->bomPath = $this->compilerPath.'/'.$component->bom;
			unset($component->bom);
		}
		else
		{
			$this->bomPath = $this->compilerPath.'/default.txt';
		}
		// README
		if ($component->addreadme)
		{
			$component->readme = base64_decode($component->readme);
		}
		else
		{
			$component->readme = '';
		}
		
		// dashboard methods
		if ($component->add_php_dashboard_methods)
		{
			// load the php for the dashboard model
			$component->php_dashboard_methods = base64_decode($component->php_dashboard_methods);
			// check if dashboard_tab is set
			$dashboard_tab = json_decode($component->dashboard_tab,true);
			if (ComponentbuilderHelper::checkArray($dashboard_tab))
			{
				$component->dashboard_tab = array();
				$nowLang = $this->lang;
				$this->lang = 'admin';
				foreach ($dashboard_tab as $option => $values)
				{
					foreach ($values as $nr => $value)
					{
						if ('html' == $option)
						{	
							$value = $this->setCustomContentLang($value);
						}
						$component->dashboard_tab[$nr][$option] = $value;
					}
				}
				$this->lang = $nowLang;
			}
			else
			{
				$component->dashboard_tab = '';
			}
		}
		else
		{
			$component->php_dashboard_methods = '';
			$component->dashboard_tab = '';
		}

		// return the found component data
		return $component;
	}
	
	/**
	 * To limit the SQL Demo date build in the views
	 * 
	 * @param   array   $settings  Teaking array.
	 *
	 * @return  void
	 * 
	 */	
	public function setSqlTweaking($settings)
	{
		if (ComponentbuilderHelper::checkArray($settings))
		{
			foreach($settings as $setting)
			{
				// should sql dump be added
				if (1 == $setting['add_sql'])
				{
					// add sql (by option)
					if (2 == $setting['add_sql_options'])
					{
						// rest always 
						$id_array = array();
						// by id (first remove backups)
						$ids = $setting['ids'];
						// now get the ids
						if (strpos($ids, ',') !== false)
						{
							$id_array = (array) array_map('trim',explode(',', $ids));
						}
						else
						{
							$id_array[] = trim($ids);
						}
						$id_array_new = array();
						// check for ranges
						foreach ($id_array as $key => $id)
						{
							if (strpos($id, '=>') !== false)
							{
								$id_range = (array) array_map('trim', explode('=>', $id));
								unset($id_array[$key]);
								// build range
								if (count($id_range) == 2)
								{
									$range = range($id_range[0],$id_range[1]);
									$id_array_new = array_merge($id_array_new,$range);
								}
							}
						}
						if (ComponentbuilderHelper::checkArray($id_array_new))
						{
							$id_array = array_merge($id_array_new, $id_array);
						}
						// final fixing to array
						if (ComponentbuilderHelper::checkArray($id_array))
						{
							// uniqe
							$id_array = array_unique($id_array, SORT_NUMERIC);
							// sort
							sort($id_array, SORT_NUMERIC);
							// now set it to global
							$this->sqlTweak[ (int) $setting['adminview']]['where'] = implode(',', $id_array);
						}
					}
				}
				else
				{
					// remove all sql dump options
					$this->sqlTweak[ (int) $setting['adminview']]['remove'] = true;
					
				}
			}
		}
	}
	
	/**
	 * Get all Admin View Data
	 * 
	 * @param   int   $id  The view ID
	 *
	 * @return  oject The view data
	 * 
	 */
	public function getAdminViewData($id)
	{
		if (!isset($this->_adminViewData[$id]))
		{
			// Get a db connection.
			$db = JFactory::getDbo();

			// Create a new query object.
			$query = $db->getQuery(true);

			$query->select('a.*');
			$query->from('#__componentbuilder_admin_view AS a');
			$query->where($db->quoteName('a.id') . ' = '. (int) $id);

			// Reset the query using our newly populated query object.
			$db->setQuery($query);

			// Load the results as a list of stdClass objects (see later for more options on retrieving data).
			$view = $db->loadObject();
			// reset fields
			$view->fields = array();
			// setup view name to use in storing the data
			$name_single = ComponentbuilderHelper::safeString($view->name_single);
			$name_list = ComponentbuilderHelper::safeString($view->name_list);
			// setup token check
			$this->customScriptBuilder['token'][$name_single] = false;
			$this->customScriptBuilder['token'][$name_list] = false;
			// load the values form params
			$permissions	= json_decode($view->addpermissions,true);
			unset($view->addpermissions);
			$tabs			= json_decode($view->addtabs,true);
			unset($view->addtabs);
			$fields			= json_decode($view->addfields,true);
			unset($view->addfields);
			$conditions		= json_decode($view->addconditions,true);
			unset($view->addconditions);
			$linked_views	= json_decode($view->addlinked_views,true);
			unset($view->addlinked_views);
			$tables	= json_decode($view->addtables,true);
			unset($view->addtables);
			// sort the values
			if (ComponentbuilderHelper::checkArray($tables))
			{
				foreach ($tables as $option => $values)
				{
					foreach ($values as $nr => $value)
					{
						$view->tables[$nr][$option] = $value;
					}
				}
			}
			if (ComponentbuilderHelper::checkArray($tabs))
			{
				foreach ($tabs as $option => $values)
				{
					foreach ($values as $nr => $value)
					{
						$fix = $nr+1;
						$view->tabs[$fix] = $value;
					}
				}
			}
			if (ComponentbuilderHelper::checkArray($permissions))
			{
				foreach ($permissions as $option => $values)
				{
					foreach ($values as $nr => $value)
					{
						$view->permissions[$nr][$option] = $value;
					}
				}
			}
			if (ComponentbuilderHelper::checkArray($fields))
			{
				foreach ($fields as $option => $values)
				{
					foreach ($values as $nr => $value)
					{
						$view->fields[$nr][$option] = (int) $value;
					}
				}
				// sort the fields acording to order
				usort($view->fields, function($a, $b)
				{
					if ($a['order_list'] != 0 && $b['order_list'] != 0)
					{
						return $a['order_list'] - $b['order_list'];
					}
					elseif ($b['order_list'] != 0 && $a['order_list'] == 0)
					{
						return 1;
					}
					elseif ($a['order_list'] != 0 && $b['order_list'] == 0)
					{
						return 0;
					}
					return 1;
				});
				// load the field data
				foreach ($view->fields as $key => &$field)
				{
					$field['settings'] = $this->getFieldData($field['field'],$name_single,$name_list);
				}
			}
			if (ComponentbuilderHelper::checkArray($conditions))
			{
				foreach ($conditions as $condition => $conditionValues)
				{
					foreach ($conditionValues as $nr => $conditionValue)
					{
						if ($condition == 'target_field')
						{
							if (ComponentbuilderHelper::checkArray($conditionValue) && ComponentbuilderHelper::checkArray($view->fields))
							{
								foreach ($conditionValue as $fieldKey => $fieldId)
								{
									foreach ($view->fields as $fieldValues)
									{
										if ((int) $fieldValues['field'] == (int) $fieldId)
										{
											// load the field details
											$required	= ComponentbuilderHelper::getBetween($fieldValues['settings']->xml,'required="','"');
											$required	= ($required == true) ? 'yes' : 'no';
											$filter		= ComponentbuilderHelper::getBetween($fieldValues['settings']->xml,'filter="','"');
											$filter		= ComponentbuilderHelper::checkString($filter) ? $filter : 'none';
											// get name
											$name		= ComponentbuilderHelper::getBetween($fieldValues['settings']->xml,'name="','"');
											$name		= ComponentbuilderHelper::checkString($name) ? $name : $fieldValues['settings']->name;
											// get type
											$type		= ComponentbuilderHelper::getBetween($fieldValues['settings']->xml,'type="','"');
											$type		= ComponentbuilderHelper::checkString($type) ? $type : $fieldValues['settings']->type_name;
											// set the field name
											$conditionValue[$fieldKey] = array(
												'name' => ComponentbuilderHelper::safeString($name),
												'type' => ComponentbuilderHelper::safeString($type),
												'required' => $required,
												'filter' => $filter
												);
											break;
										}
									}
								}
							}
						}
						if ($condition == 'match_field')
						{
							foreach ($view->fields as $fieldValue)
							{
								if ((int) $fieldValue['field'] == (int) $conditionValue)
								{
									// get name
									$name = ComponentbuilderHelper::getBetween($fieldValue['settings']->xml,'name="','"');
									$name = ComponentbuilderHelper::checkString($name) ? $name : $fieldValue['settings']->name;
									// get type
									$type = ComponentbuilderHelper::getBetween($fieldValue['settings']->xml,'type="','"');
									$type = ComponentbuilderHelper::checkString($type) ? $type : $fieldValue['settings']->type_name;
									// set the field details
									$view->conditions[$nr]['match_name']	= ComponentbuilderHelper::safeString($name);
									$view->conditions[$nr]['match_type']	= ComponentbuilderHelper::safeString($type);
									$view->conditions[$nr]['match_xml']		= $fieldValue['settings']->xml;
									break;
								}
							}
						}
						// set condition values
						$view->conditions[$nr][$condition] = $conditionValue;
					}
				}
			}
			// set linked views
			$linked_views_sorted = null;
			if (ComponentbuilderHelper::checkArray($linked_views))
			{
				$linked_views_sorted = array();
				foreach ($linked_views as $option => $values)
				{
					foreach ($values as $nr => $value)
					{
						$linked_views_sorted[$nr][$option] = $value;
					}
				}
			}
			unset($linked_views);
			// setup linked views to global data sets
			$this->linkedAdminViews[$name_single] = $linked_views_sorted;
			unset($linked_views_sorted);
			// add_javascript_view_file
			if ($view->add_javascript_view_file == 1)
			{
				$view->javascript_view_file = base64_decode($view->javascript_view_file);
				$this->customScriptBuilder['view_file'][$name_single] = $view->javascript_view_file;
				if (strpos($view->javascript_view_file,"token") !== false && strpos($view->javascript_view_file,"task=ajax") !== false)
				{
					if (!$this->customScriptBuilder['token'][$name_single])
					{
						$this->customScriptBuilder['token'][$name_single] = true;
					}
				}
				unset($view->javascript_view_file);
			}
			// add_javascript_view_footer
			if ($view->add_javascript_view_footer == 1)
			{
				$view->javascript_view_footer = base64_decode($view->javascript_view_footer);
				if (!isset($this->customScriptBuilder['view_footer'][$name_single]))
				{
					$this->customScriptBuilder['view_footer'][$name_single] = '';
				}
				$this->customScriptBuilder['view_footer'][$name_single] .= $view->javascript_view_footer;
				if (strpos($view->javascript_view_footer,"token") !== false && strpos($view->javascript_view_footer,"task=ajax") !== false)
				{
					if (!$this->customScriptBuilder['token'][$name_single])
					{
						$this->customScriptBuilder['token'][$name_single] = true;
					}
				}
				unset($view->javascript_view_footer);
			}
			// add_javascript_view_file
			if ($view->add_javascript_views_file == 1)
			{
				$view->javascript_views_file = base64_decode($view->javascript_views_file);
				$this->customScriptBuilder['views_file'][$name_list] = $view->javascript_views_file;
				if (strpos($view->javascript_views_file,"token") !== false && strpos($view->javascript_views_file,"task=ajax") !== false)
				{
					if (!$this->customScriptBuilder['token'][$name_list])
					{
						$this->customScriptBuilder['token'][$name_list] = true;
					}
				}
				unset($view->javascript_views_file);
			}
			// add_javascript_views_footer
			if ($view->add_javascript_views_footer == 1)
			{
				$view->javascript_views_footer = base64_decode($view->javascript_views_footer);
				$this->customScriptBuilder['views_footer'][$name_list] .= $view->javascript_views_footer;
				if (strpos($view->javascript_views_footer,"token") !== false && strpos($view->javascript_views_footer,"task=ajax") !== false)
				{
					if (!$this->customScriptBuilder['token'][$name_list])
					{
						$this->customScriptBuilder['token'][$name_list] = true;
					}
				}
				unset($view->javascript_views_footer);
			}
			// add_css_view
			if ($view->add_css_view == 1)
			{
				$this->customScriptBuilder['css_view'][$name_single] .= base64_decode($view->css_view);
				unset($view->css_view);
			}
			// add_css_views
			if ($view->add_css_views == 1)
			{
				$this->customScriptBuilder['css_views'][$name_list] .= base64_decode($view->css_views);
				unset($view->css_views);
			}

			$this->lang = 'admin';
			$addArray = array('php_getitem','php_save','php_postsavehook','php_getitems','php_getlistquery','php_allowedit','php_before_delete','php_after_delete','php_batchcopy','php_batchmove');
			foreach ($addArray as $scripter)
			{
				if (isset($view->{'add_'.$scripter}) && $view->{'add_'.$scripter} == 1)
				{
					$this->customScriptBuilder[$scripter][$name_single] = $this->setCustomContentLang(base64_decode($view->$scripter));
					unset($view->$scripter);
				}
			}

			// add_Ajax for this view
			if ($view->add_php_ajax == 1)
			{
				$addAjaxSite = false;
				if (isset($this->siteEditView[$id]) && $this->siteEditView[$id])
				{
					// we should add this site ajax to fron ajax
					$addAjaxSite = true;
					if (!isset($this->addSiteAjax) || !$this->addSiteAjax)
					{
						$this->addSiteAjax = true;
					}
				}
				// check if controller input as been set
				$ajax_input = json_decode($view->ajax_input,true);
				if (ComponentbuilderHelper::checkArray($ajax_input))
				{
					foreach ($ajax_input as $option => $values)
					{
						foreach ($values as $nr => $value)
						{
							if ($addAjaxSite)
							{
								$this->customScriptBuilder['site']['ajax_controller'][$name_single][$nr][$option] = $value;
							}
							$this->customScriptBuilder['admin']['ajax_controller'][$name_single][$nr][$option] = $value;
						}
					}
					if ($addAjaxSite)
					{
						$this->customScriptBuilder['site']['ajax_model'][$name_single] = $this->setCustomContentLang(base64_decode($view->php_ajaxmethod));
					}
					$this->customScriptBuilder['admin']['ajax_model'][$name_single] = $this->setCustomContentLang(base64_decode($view->php_ajaxmethod));
					$this->addAjax = true;
					unset($view->ajax_input);
				}
				// unset anyway
				unset($view->php_ajaxmethod);
			}
			// add_sql
			if ($view->add_sql == 1)
			{
				if ($view->source == 1)
				{
					// build and add the SQL dump
					$this->customScriptBuilder['sql'][$name_single] = $this->buildSqlDump($view->tables,$name_single, $id);
					unset($view->tables);
				}
				elseif ($view->source == 2)
				{
					// add the SQL dump string
					$this->customScriptBuilder['sql'][$name_single] = base64_decode($view->sql);
					unset($view->sql);
				}
			}
			$this->_adminViewData[$id] = $view;
		}
		// return the found view data
		return $this->_adminViewData[$id];
	}
	
	/**
	 * Get all Custom View Data
	 * 
	 * @param   int      $id  The view ID
	 * @param   string   $table  The view table
	 *
	 * @return  oject The view data
	 * 
	 */
	public function getCustomViewData($id, $table = 'site_view')
	{
		// Get a db connection.
		$db = JFactory::getDbo();

		// Create a new query object.
		$query = $db->getQuery(true);

		$query->select('a.*');
		$query->from('#__componentbuilder_'.$table.' AS a');
		$query->where($db->quoteName('a.id') . ' = '. (int) $id);

		// Reset the query using our newly populated query object.
		$db->setQuery($query);

		// Load the results as a list of stdClass objects (see later for more options on retrieving data).
		$view = $db->loadObject();
		if ($table == 'site_view')
		{
			$this->lang = 'site';
		}
		else
		{
			$this->lang = 'admin';
		}
		// set the default data
		$view->default = base64_decode($view->default);
		$view->default = $this->setCustomContentLang($view->default);
		// fix alias to use in code
		$view->code = $this->uniqueCode(ComponentbuilderHelper::safeString($view->alias));
		$view->Code = ComponentbuilderHelper::safeString($view->code, 'F');
		$view->CODE = ComponentbuilderHelper::safeString($view->code, 'U');
		// insure the uikit components are loaded
		if (!isset($this->uikitComp[$view->code]))
		{
			$this->uikitComp[$view->code] = array();
		}
		$this->uikitComp[$view->code] = ComponentbuilderHelper::getUikitComp($view->default,$this->uikitComp[$view->code]);
		// check for footable
		if (!isset($this->footableScripts[$this->target][$view->code]) || !$this->footableScripts[$this->target][$view->code])
		{
			$foundFoo = $this->getFootableScripts($view->default);
			if ($foundFoo)
			{
				$this->footableScripts[$this->target][$view->code] = true;
			}
			if ($foundFoo && !$this->footableScripts)
			{
				$this->footable = true;
			}
		}
		// check for get module
		if (!isset($this->getModule[$this->target][$view->code]) || !$this->getModule[$this->target][$view->code])
		{
			$found = $this->getGetModule($view->default);
			if ($found)
			{
				$this->getModule[$this->target][$view->code] = true;
			}
		}
		// setup template array
		$this->templateData[$this->target][$view->code] = array();
		// setup template and layout data
		$this->setTemplateAndLayoutData($view->default,$view->code);
		// set the main get data
		$main_get = $this->setGetData(array($view->main_get),$view->code);
		$view->main_get = $main_get[0];
		// set the custom_get data
		$view->custom_get = $this->setGetData(json_decode($view->custom_get,true),$view->code);
		// set array adding array of scripts
		$addArray = array('php_view','php_jview','php_jview_display','php_document','js_document','css_document','css');
		foreach ($addArray as $scripter)
		{
			if (isset($view->{'add_'.$scripter}) && $view->{'add_'.$scripter} == 1)
			{
				$view->$scripter = base64_decode($view->$scripter);
				$view->$scripter = $this->setCustomContentLang($view->$scripter);
				// set uikit to views
				$this->uikitComp[$view->code] = ComponentbuilderHelper::getUikitComp($view->$scripter,$this->uikitComp[$view->code]);
				
				$this->setTemplateAndLayoutData($view->$scripter,$view->code);
				
				// check for footable
				if (!isset($this->footableScripts[$this->target][$view->code]) || !$this->footableScripts[$this->target][$view->code])
				{
					$foundFoo = $this->getFootableScripts($view->$scripter);
					if ($foundFoo)
					{
						$this->footableScripts[$this->target][$view->code] = true;
					}
					if ($foundFoo && !$this->footable)
					{
						$this->footable = true;
					}
				}
				// check for google chart
				if (!isset($this->googleChart[$this->target][$view->code]) || !$this->googleChart[$this->target][$view->code])
				{
					$found = $this->getGoogleChart($view->$scripter);
					if ($found)
					{
						$this->googleChart[$this->target][$view->code] = true;
					}
					if ($found && !$this->googlechart)
					{
						$this->googlechart = true;
					}
				}
				// check for get module
				if (!isset($this->getModule[$this->target][$view->code]) || !$this->getModule[$this->target][$view->code])
				{
					$found = $this->getGetModule($view->$scripter);
					if ($found)
					{
						$this->getModule[$this->target][$view->code] = true;
					}
				}
			}
		}
		// add_Ajax for this view
		if (isset($view->add_php_ajax) && $view->add_php_ajax == 1)
		{
			// check if controller input as been set
			$ajax_input = json_decode($view->ajax_input,true);
			if (ComponentbuilderHelper::checkArray($ajax_input))
			{
				foreach ($ajax_input as $option => $values)
				{
					foreach ($values as $nr => $value)
					{
						$this->customScriptBuilder[$this->target]['ajax_controller'][$view->code][$nr][$option] = $value;
					}
				}
				$this->customScriptBuilder[$this->target]['ajax_model'][$view->code] = $this->setCustomContentLang(base64_decode($view->php_ajaxmethod));
				$this->addSiteAjax = true;
				unset($view->ajax_input);
			}
			// unset anyway
			unset($view->php_ajaxmethod);
		}
		// add the custom buttons
		if (isset($view->add_custom_button) && $view->add_custom_button == 1)
		{
			if (ComponentbuilderHelper::checkString($view->php_model))
			{
				$view->php_model = base64_decode($view->php_model);
				$view->php_model = $this->setCustomContentLang($view->php_model);
			}
			$view->php_controller = base64_decode($view->php_controller);
			$view->php_controller = $this->setCustomContentLang($view->php_controller);
			// set the button array
			$buttons = json_decode($view->custom_button,true);
			unset($view->custom_button);
			// sort the values
			if (ComponentbuilderHelper::checkArray($buttons))
			{
				foreach ($buttons as $option => $values)
				{
					foreach ($values as $nr => $value)
					{
						$view->custom_buttons[$nr][$option] = $value;
					}
				}
			}
		}
		// return the found view data
		return $view;
	}
	
	/**
	 * Get all Field Data
	 * 
	 * @param   int      $id  The field ID
	 * @param   string   $name_single The view edit or single name
	 * @param   string   $name_list  The view list name
	 *
	 * @return  oject The field data
	 * 
	 */
	public function getFieldData($id,$name_single = null,$name_list = null)
	{
		if (!isset($this->_fieldData[$id]))
		{
			// Get a db connection.
			$db = JFactory::getDbo();

			// Create a new query object.
			$query = $db->getQuery(true);

			// Order it by the ordering field.
			$query->select('a.*');
			$query->select($db->quoteName(array('c.name', 'c.properties'),array('type_name','type_properties')));
			$query->from('#__componentbuilder_field AS a');
			$query->join('LEFT', $db->quoteName('#__componentbuilder_fieldtype', 'c') . ' ON (' . $db->quoteName('a.fieldtype') . ' = ' . $db->quoteName('c.id') . ')');
			$query->where($db->quoteName('a.id') . ' = '. $db->quote($id));

			// Reset the query using our newly populated query object.
			$db->setQuery($query);

			// Load the results as a list of stdClass objects (see later for more options on retrieving data).
			$field = $db->loadObject();
			
			// adding a fix for the changed name of type to fieldtype
			$field->type = $field->fieldtype;

			// load the values form params
			$field->xml = json_decode($field->xml);

			// load the type values form type params
			$properties = json_decode($field->type_properties,true);
			unset($field->type_properties);

			if (ComponentbuilderHelper::checkArray($properties))
			{
				foreach ($properties as $option => $values)
				{
					foreach ($values as $nr => $value)
					{
						$field->properties[$nr][$option] = $value;
					}
				}
			}
			// check if we have advanced encryption
			if (4 == $field->store &&  (!isset($this->advancedEncryption) || !$this->advancedEncryption))
			{
				 $this->advancedEncryption = true;
			}
			// check if we have basic encryption
			elseif (3 == $field->store &&  (!isset($this->basicEncryption) || !$this->basicEncryption))
			{
				 $this->basicEncryption = true;
			}

			// check if we should load scripts for single view
			if (ComponentbuilderHelper::checkString($name_single) && !isset($this->customFieldScript[$name_single][$id]))
			{
				// add_javascript_view_footer
				if ($field->add_javascript_view_footer == 1)
				{
					if(!isset($this->customScriptBuilder['view_footer']))
					{
						$this->customScriptBuilder['view_footer'] = array();
					}
					if (!isset($this->customScriptBuilder['view_footer'][$name_single]))
					{
						$this->customScriptBuilder['view_footer'][$name_single] = '';
					}
					$this->customScriptBuilder['view_footer'][$name_single] .= "\n".$this->setCustomContentLang(base64_decode($field->javascript_view_footer));
					if (strpos($field->javascript_view_footer,"token") !== false && strpos($field->javascript_view_footer,"task=ajax") !== false)
					{
						if (!isset($this->customScriptBuilder['token'][$name_single]) || !$this->customScriptBuilder['token'][$name_single])
						{
							if(!isset($this->customScriptBuilder['token']))
							{
								$this->customScriptBuilder['token'] = array();
							}
							$this->customScriptBuilder['token'][$name_single] = true;
						}
					}
					unset($field->javascript_view_footer);
				}

				// add_css_view
				if ($field->add_css_view == 1)
				{
					if (!isset($this->customScriptBuilder['css_view'][$name_single]))
					{
						$this->customScriptBuilder['css_view'][$name_single] = '';
					}
					$this->customScriptBuilder['css_view'][$name_single] .= "\n".base64_decode($field->css_view);
					unset($field->css_view);
				}

				// add this only once to view.
				$this->customFieldScript[$name_single][$id] = true;
			}
			else
			{
				// unset if not needed
				unset($field->javascript_view_footer);
				unset($field->css_view);
			}
			// check if we should load scripts for list views
			if (ComponentbuilderHelper::checkString($name_list))
			{
				// add_javascript_views_footer
				if ($field->add_javascript_views_footer == 1)
				{
					$this->customScriptBuilder['views_footer'][$name_list] .= $this->setCustomContentLang(base64_decode($field->javascript_views_footer));
					if (strpos($field->javascript_views_footer,"token") !== false && strpos($field->javascript_views_footer,"task=ajax") !== false)
					{
						if (!$this->customScriptBuilder['token'][$name_list])
						{
							$this->customScriptBuilder['token'][$name_list] = true;
						}
					}
					unset($field->javascript_views_footer);
				}
				// add_css_views
				if ($field->add_css_views == 1)
				{
					if (!isset($this->customScriptBuilder['css_views'][$name_list]))
					{
						$this->customScriptBuilder['css_views'][$name_list] = '';
					}
					$this->customScriptBuilder['css_views'][$name_list] .= base64_decode($field->css_views);
					unset($field->css_views);
				}
			}
			else
			{
				// unset if not needed
				unset($field->javascript_views_footer);
				unset($field->css_views);

			}
			$this->_fieldData[$id] = $field;
		}
		// return the found field data
		return $this->_fieldData[$id];
	}
	
	/**
	 * Set get Data
	 * 
	 * @param   array    $ids  The ids of the dynamic get
	 * @param   string   $view_code  The view code name
	 *
	 * @return  oject the get dynamicGet data
	 * 
	 */
	public function setGetData($ids,$view_code)
	{
		if (ComponentbuilderHelper::checkArray($ids))
		{
			$ids = implode(',', $ids);
			if (ComponentbuilderHelper::checkString($ids))
			{
				// Get a db connection.
				$db = JFactory::getDbo();
				// Create a new query object.
				$query = $db->getQuery(true);
				$query->select('a.*');
				$query->from('#__componentbuilder_dynamic_get AS a');
				$query->where('a.id IN (' . $ids . ')');
				$db->setQuery($query);
				$db->execute();
				if ($db->getNumRows())
				{
					$results = $db->loadObjectList();
					$typeArray = array(1 => 'LEFT', 2 => 'LEFT OUTER', 3 => 'INNER', 4 => 'RIGHT', 5 => 'RIGHT OUTER');
					$operatorArray = array(1 => '=', 2 => '!=', 3 => '<>', 4 => '>', 5 => '<', 6 => '>=', 7 => '<=', 8 => '!<', 9 => '!>', 10 => 'IN', 11 => 'NOT IN');
					foreach ($results as $nr => &$result)
					{
						// add calculations if set
						if($result->addcalculation == 1)
						{
							$result->php_calculation = base64_decode($result->php_calculation);
						}
						// add php custom scripting (php_before_getitem)
						if($result->add_php_before_getitem == 1)
						{
							if (!isset($this->customScriptBuilder[$this->target.'_php_before_getitem'][$view_code]))
							{
								$this->customScriptBuilder[$this->target.'_php_before_getitem'][$view_code] = '';
							}
							$this->customScriptBuilder[$this->target.'_php_before_getitem'][$view_code] .= "\n\n".base64_decode($result->php_before_getitem);
							unset($result->php_before_getitem);
						}
						// add php custom scripting (php_after_getitem)
						if($result->add_php_after_getitem == 1)
						{
							if (!isset($this->customScriptBuilder[$this->target.'_php_after_getitem'][$view_code]))
							{
								$this->customScriptBuilder[$this->target.'_php_after_getitem'][$view_code] = '';
							}
							$this->customScriptBuilder[$this->target.'_php_after_getitem'][$view_code] .= "\n\n".base64_decode($result->php_after_getitem);
							unset($result->php_after_getitem);
						}
						// add php custom scripting (php_before_getitems)
						if($result->add_php_before_getitems == 1)
						{
							if (!isset($this->customScriptBuilder[$this->target.'_php_before_getitems'][$view_code]))
							{
								$this->customScriptBuilder[$this->target.'_php_before_getitems'][$view_code] = '';
							}
							$this->customScriptBuilder[$this->target.'_php_before_getitems'][$view_code] .= "\n\n".base64_decode($result->php_before_getitems);
							unset($result->php_before_getitems);
						}
						// add php custom scripting (php_after_getitems)
						if($result->add_php_after_getitems == 1)
						{
							if (!isset($this->customScriptBuilder[$this->target.'_php_after_getitems'][$view_code]))
							{
								$this->customScriptBuilder[$this->target.'_php_after_getitems'][$view_code] = '';
							}
							$this->customScriptBuilder[$this->target.'_php_after_getitems'][$view_code] .= "\n\n".base64_decode($result->php_after_getitems);
							unset($result->php_after_getitems);
						}
						// add php custom scripting (php_getlistquery)
						if($result->add_php_getlistquery == 1)
						{
							if (!isset($this->customScriptBuilder[$this->target.'_php_getlistquery'][$view_code]))
							{
								$this->customScriptBuilder[$this->target.'_php_getlistquery'][$view_code] = '';
							}
							$this->customScriptBuilder[$this->target.'_php_getlistquery'][$view_code] .= "\n".base64_decode($result->php_getlistquery);
							unset($result->php_getlistquery);
						}
						// set the getmethod code name
						$result->key = ComponentbuilderHelper::safeString($view_code. ' ' .$result->name . ' ' .$result->id);
						// reset buckets
						$result->main_get = array();
						$result->custom_get = array();
						// set source data
						switch ($result->main_source)
						{
							case 1:
							// set the view data
							$result->main_get[0]['selection'] = $this->setDataSelection($result->key,$view_code,$result->view_selection,$result->view_table_main,'a','','view');
							$result->main_get[0]['as'] = 'a';
							$result->main_get[0]['key'] = $result->key;
							unset($result->view_selection);
							break;
							case 2:
							// set the database data
							$result->main_get[0]['selection'] = $this->setDataSelection($result->key,$view_code,$result->db_selection,$result->db_table_main,'a','','db');
							$result->main_get[0]['as'] = 'a';
							$result->main_get[0]['key'] = $result->key;
							unset($result->db_selection);
							break;
							case 3:
							// set custom script
							$result->main_get[0]['selection'] = array(
								'select' => base64_decode($result->php_custom_get),
								'from' => '', 'table' => '', 'type' => '');
							break;
						}
						// set join_view_table details
						$join_view_table = json_decode($result->join_view_table,true);
						unset($result->join_view_table);
						$result->join_view_table = array();
						if (ComponentbuilderHelper::checkArray($join_view_table))
						{
							foreach ($join_view_table as $option => $values)
							{
								foreach ($values as $nr => $value)
								{
									if (ComponentbuilderHelper::checkString($value))
									{
										if ($option == 'selection')
										{
											$on_field_as = '';
											$on_field = '';
											list($on_field_as,$on_field) = array_map('trim', explode('.',$result->join_view_table[$nr]['on_field']));
											$join_field_as = '';
											$join_field = '';
											list($join_field_as,$join_field) = array_map('trim', explode('.',$result->join_view_table[$nr]['join_field']));
											$result->join_view_table[$nr][$option] =
											$this->setDataSelection($result->key,$view_code,$value,$result->join_view_table[$nr]['view_table'],$result->join_view_table[$nr]['as'],$result->join_view_table[$nr]['row_type'],'view');
											$result->join_view_table[$nr]['key'] = $result->key;
											if ($result->join_view_table[$nr]['row_type'] == 1)
											{
												$result->main_get[] = $result->join_view_table[$nr];
												if ($on_field_as == 'a')
												{
													$this->siteMainGet[$this->target][$view_code][$result->join_view_table[$nr]['as']] = $result->join_view_table[$nr]['as'];
												}
												else
												{
													$this->siteDynamicGet[$this->target][$view_code][$result->join_view_table[$nr]['as']][$join_field] = $on_field_as;
												}
											}
											elseif ($result->join_view_table[$nr]['row_type'] == 2)
											{
												$result->custom_get[] = $result->join_view_table[$nr];
												if ($on_field_as != 'a')
												{
													$this->siteDynamicGet[$this->target][$view_code][$result->join_view_table[$nr]['as']][$join_field] = $on_field_as;
												}
											}
											unset($result->join_view_table[$nr]);
										}
										else
										{
											if ($option == 'type')
											{
												$value = $typeArray[$value];
											}
											if ($option == 'operator')
											{
												$value = $operatorArray[$value];
											}
											$result->join_view_table[$nr][$option] = $value;
										}
									}
								}
							}
						}
						unset($result->join_view_table);
						// set join_db_table details
						$join_db_table = json_decode($result->join_db_table,true);
						unset($result->join_db_table);
						$result->join_db_table = array();
						if (ComponentbuilderHelper::checkArray($join_db_table))
						{
							foreach ($join_db_table as $option => $values)
							{
								foreach ($values as $nr => $value)
								{
									if (ComponentbuilderHelper::checkString($value))
									{
										if ($option == 'selection')
										{
											$on_field_as = '';
											$on_field = '';
											list($on_field_as,$on_field) = array_map('trim', explode('.',$result->join_db_table[$nr]['on_field']));
											$join_field_as = '';
											$join_field = '';
											list($join_field_as,$join_field) = array_map('trim', explode('.',$result->join_db_table[$nr]['join_field']));
											$result->join_db_table[$nr][$option] =
											$this->setDataSelection($result->key,$view_code,$value,$result->join_db_table[$nr]['db_table'],$result->join_db_table[$nr]['as'],$result->join_db_table[$nr]['row_type'],'db');
											$result->join_db_table[$nr]['key'] = $result->key;
											if ($result->join_db_table[$nr]['row_type'] == 1)
											{
												$result->main_get[] = $result->join_db_table[$nr];
												if ($on_field_as == 'a')
												{
													$this->siteMainGet[$this->target][$view_code][$result->join_db_table[$nr]['as']] = $result->join_db_table[$nr]['as'];
												}
												else
												{
													$this->siteDynamicGet[$this->target][$view_code][$result->join_db_table[$nr]['as']][$join_field] = $on_field_as;
												}
											}
											elseif ($result->join_db_table[$nr]['row_type'] == 2)
											{
												$result->custom_get[] = $result->join_db_table[$nr];
												if ($on_field_as != 'a')
												{
													$this->siteDynamicGet[$this->target][$view_code][$result->join_db_table[$nr]['as']][$join_field] = $on_field_as;
												}
											}
											unset($result->join_db_table[$nr]);
										}
										else
										{
											if ($option == 'type')
											{
												$value = $typeArray[$value];
											}
											if ($option == 'operator')
											{
												$value = $operatorArray[$value];
											}
											$result->join_db_table[$nr][$option] = $value;
										}
									}
								}
							}
						}
						unset($result->join_db_table);
						// set filter details
						$filter = json_decode($result->filter,true);
						unset($result->filter);
						$result->filter = array();
						if (ComponentbuilderHelper::checkArray($filter))
						{
							foreach ($filter as $option => $values)
							{
								foreach ($values as $nr => $value)
								{
									if (ComponentbuilderHelper::checkString($value))
									{
										if ($option == 'operator')
										{
											$value = $operatorArray[$value];
											$result->filter[$nr]['key'] = $result->key;
										}
										$result->filter[$nr][$option] = $value;
									}
								}
							}
						}
						// set global details
						$global = json_decode($result->global,true);
						unset($result->global);
						$result->global = array();
						if (ComponentbuilderHelper::checkArray($global))
						{
							foreach ($global as $option => $values)
							{
								foreach ($values as $nr => $value)
								{
									if (ComponentbuilderHelper::checkString($value))
									{
										$result->global[$nr][$option] = $value;
									}
								}
							}
						}
						// set order details
						$order = json_decode($result->order,true);
						unset($result->order);
						$result->order = array();
						if (ComponentbuilderHelper::checkArray($order))
						{
							foreach ($order as $option => $values)
							{
								foreach ($values as $nr => $value)
								{
									if (ComponentbuilderHelper::checkString($value))
									{
										$result->order[$nr][$option] = $value;
									}
								}
							}
						}
						// set where details
						$where = json_decode($result->where,true);
						unset($result->where);
						$result->where = array();
						if (ComponentbuilderHelper::checkArray($where))
						{
							foreach ($where as $option => $values)
							{
								foreach ($values as $nr => $value)
								{
									if (ComponentbuilderHelper::checkString($value))
									{
										if ($option == 'operator')
										{
											$value = $operatorArray[$value];
										}
										$result->where[$nr][$option] = $value;
									}
								}
							}
						}
					}
					return $results;
				}
			}
		}
		return false;
	}
	
	/**
	 * Set Template and Layout Data
	 * 
	 * @param   string   $default  The content to check
	 * @param   string   $view  The view code name
	 *
	 * @return  void
	 * 
	 */
	public function setTemplateAndLayoutData($default,$view)
	{
		// set the Tempale date
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
				if (!isset($this->templateData[$this->target][$view]) || !array_key_exists($template,$this->templateData[$this->target][$view]))
				{
					$data = $this->getDataWithAlias($template,'template',$view);
					if (ComponentbuilderHelper::checkArray($data))
					{
						$this->templateData[$this->target][$view][$template] = $data;
						// call self to get child data
						$again[] = array($data['html'],$view);
						$again[] = array($data['php_view'],$view);
					}
				}
			}
		}
		// set  the layout data
		$lay1 = ComponentbuilderHelper::getAllBetween($default, "JLayoutHelper::render('","',");
		$lay2 = ComponentbuilderHelper::getAllBetween($default, 'JLayoutHelper::render("','",');;
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
				if (!isset($this->layoutData[$this->target]) || !ComponentbuilderHelper::checkArray($this->layoutData[$this->target]) || !array_key_exists($layout,$this->layoutData[$this->target]))
				{
					$data = $this->getDataWithAlias($layout,'layout',$view);
					if (ComponentbuilderHelper::checkArray($data))
					{
						$this->layoutData[$this->target][$layout] = $data;
						// call self to get child data
						$again[] = array($data['html'],$view);
						$again[] = array($data['php_view'],$view);
					}
				}
			}
		}
		if (ComponentbuilderHelper::checkArray($again))
		{
			foreach ($again as $go)
			{
				$this->setTemplateAndLayoutData($go[0],$go[1]);
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
	public function getDataWithAlias($n_ame,$table,$view)
	{
		// Get a db connection.
		$db = JFactory::getDbo();
		// Create a new query object.
		$query = $db->getQuery(true);
		$query->select('a.*');
		$query->from('#__componentbuilder_'.$table.' AS a');
		$db->setQuery($query);
		$rows = $db->loadObjectList();
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
					$php_view = $this->setCustomContentLang($php_view);
				}
				$contnent = base64_decode($row->{$table});
				$contnent = $this->setCustomContentLang($contnent);
				// set uikit to views
				$this->uikitComp[$view] = ComponentbuilderHelper::getUikitComp($contnent,$this->uikitComp[$view]);
				// set footable to views and turn it on
				if (!isset($this->footableScripts[$this->target][$view]) || !$this->footableScripts[$this->target][$view])
				{
					$foundFoo = $this->getFootableScripts($contnent);
					if ($foundFoo)
					{
						$this->footableScripts[$this->target][$view] = true;
					}
					if ($foundFoo && !$this->footable)
					{
						$this->footable = true;
					}
				}
				// set google charts to views and turn it on
				if (!isset($this->googleChart[$this->target][$view]) || !$this->googleChart[$this->target][$view])
				{
					$foundA = $this->getGoogleChart($php_view);
					$foundB = $this->getGoogleChart($contnent);
					if ($foundA || $foundB)
					{
						$this->googleChart[$this->target][$view] = true;
					}
					if ($foundA || $foundB && !$this->googlechart)
					{
						$this->googlechart = true;
					}
				}
				// check for get module
				if (!isset($this->getModule[$this->target][$view]) || !$this->getModule[$this->target][$view])
				{
					$foundA = $this->getGetModule($php_view);
					$foundB = $this->getGetModule($contnent);
					if ($foundA || $foundB)
					{
						$this->getModule[$this->target][$view] = true;
					}
				}
				return array('id' => $row->id, 'html' => $contnent, 'php_view' => $php_view);
			}
		}
		return false;
	}
	
	/**
	 * Set Custom Content Language Place Holders
	 * 
	 * @param   string   $content  The content
	 *
	 * @return  string The content with the updated Language place holder
	 * 
	 */
	public function setCustomContentLang($content)
	{
		// set language data
		$langCheck[] = ComponentbuilderHelper::getAllBetween($content, "JText::_('","')");
		$langCheck[] = ComponentbuilderHelper::getAllBetween($content, 'JText::_("','")');
		$langCheck[] = ComponentbuilderHelper::getAllBetween($content, "JText::sprintf('","'");
		$langCheck[] = ComponentbuilderHelper::getAllBetween($content, 'JText::sprintf("','"');
		$langHolders = array();
		$lang = array();
		foreach ($langCheck as $langChecked)
		{
			if (ComponentbuilderHelper::checkArray($langChecked))
			{
				$lang = array_merge($lang,$langChecked);
			}
		}
		if (ComponentbuilderHelper::checkArray($lang))
		{
			foreach ($lang as $string)
			{
				if (ComponentbuilderHelper::safeString($string,'U') == $string)
				{
					continue;
				}
				// only load if string is not already set
				$keyLang = $this->langPrefix.'_'.ComponentbuilderHelper::safeString($string,'U');
				$this->langContent[$this->lang][$keyLang] = trim($string);
				$langHolders["JText::_('".$string."')"] = "JText::_('".$keyLang."')";
				$langHolders['JText::_("'.$string.'")'] = 'JText::_("'.$keyLang.'")';
				$langHolders["JText::sprintf('".$string."',"] = "JText::sprintf('".$keyLang."',";
				$langHolders['JText::sprintf("'.$string.'",'] = 'JText::sprintf("'.$keyLang.'",';
			}
			$content = str_replace(array_keys($langHolders),array_values($langHolders),$content);
		}
		return $content;
	}
	
	/**
	 * Set Data Selection of the dynamic get
	 * 
	 * @param   string         $method_key  The method unique key
	 * @param   string         $view_code  The code name of the view
	 * @param   string         $string  The data string
	 * @param   string || INT  $asset  The asset in question
	 * @param   string         $as  The as string
	 * @param   int            $row_type  The row type
	 * @param   string         $type  The target type (db||view)
	 *
	 * @return  array the select query
	 * 
	 */
	public function setDataSelection($method_key,$view_code,$string,$asset,$as,$row_type,$type)
	{
		if (ComponentbuilderHelper::checkString($string))
		{
			$lines = explode(PHP_EOL,$string);
			if (ComponentbuilderHelper::checkArray($lines))
			{
				$db = JFactory::getDbo();
				if ('db' == $type)
				{
					$table = '#__'.$asset;
					$queryName = $asset;
					$view =  '';
				}
				elseif ('view' == $type)
				{
					$view = $this->getViewTableName($asset);
					$table = '#__'.$this->componentCodeName.'_'.$view;
					$queryName = $view;
				}
				$gets = array();
				$keys = array();
				foreach ($lines as $line)
				{
					if (strpos($line,'AS') !== false)
					{
						list($get,$key) = explode("AS",$line);
					}
					elseif (strpos($line,'as') !== false)
					{
						list($get,$key) = explode("as",$line);
					}
					else
					{
						$get = $line;
						$key = null;
					}
					$get = trim($get);
					$key = trim($key);
					// only add the view
					if ('a' != $as && 1 == $row_type && 'view' == $type && strpos('#'.$key,'#'.$view.'_') === false)
					{
						$key = $view.'_'.trim($key);
					}
					if (ComponentbuilderHelper::checkString($get))
					{
						$gets[] = $db->quote($get);
						if (ComponentbuilderHelper::checkString($key))
						{
							$this->getAsLookup[$method_key][$get] = $key;
							$keys[] = $db->quote($key);
						}
						else
						{
							$key = str_replace($as.'.','',$get);
							$this->getAsLookup[$method_key][$get] = $key;
							$keys[] = $db->quote($key);
						}
						if (ComponentbuilderHelper::checkString($view))
						{
							$field = str_replace($as.'.','',$get);
							$this->siteFields[$view][$field][$method_key] = array('site' => $view_code, 'get' => $get, 'as' => $as, 'key' => $key);
						}
					}
				}
				if (ComponentbuilderHelper::checkArray($gets) && ComponentbuilderHelper::checkArray($keys))
				{
					$querySelect = '$query->select($db->quoteName('."\n\t\t\t".'array('.implode(',',$gets).'),'."\n\t\t\t".'array('.implode(',',$keys).')));';
					$queryFrom = '$db->quoteName('.$db->quote($table).', '.$db->quote($as).')';
					// return the select query
					return array('select' => $querySelect, 'from' => $queryFrom, 'name' => $queryName, 'table' => $table, 'type' => $type, 'select_gets' => $gets, 'select_keys' => $keys);
				}
			}
		}
		return false;
	}
	
	/**
	 * Get the View Table Name
	 * 
	 * @param   int   $id  The admin view in
	 *
	 * @return  string view code name
	 * 
	 */
	public function getViewTableName($id)
	{
		// Get a db connection.
		$db = JFactory::getDbo();
		// Create a new query object.
		$query = $db->getQuery(true);
		$query->select($db->quoteName(array('a.name_single')));
		$query->from($db->quoteName('#__componentbuilder_admin_view','a'));
		$query->where($db->quoteName('a.id') . ' = '. (int) $id);
		$db->setQuery($query);
		return ComponentbuilderHelper::safeString($db->loadResult());

	}
	
	/**
	 * Build the SQL dump String for a view
	 * 
	 * @param   string   $tables  The tables to use in build
	 * @param   string   $view  The target view/table to dump in
	 * @param   int      $view_id  The id of the target view
	 *
	 * @return  string on success with the Dump SQL
	 * 
	 */
	public function buildSqlDump($tables,$view,$view_id)
	{
		// first build a query statment to get all the data (insure it must be added - check the tweaking)
		if (ComponentbuilderHelper::checkArray($tables) && (!isset($this->sqlTweak[$view_id]['remove']) || !$this->sqlTweak[$view_id]['remove']))
		{
			$counter = 'a';
			// Get a db connection.
			$db = JFactory::getDbo();
			// Create a new query object.
			$query = $db->getQuery(true);
			foreach ($tables as $table)
			{
				if ($counter == 'a')
				{
					// the main table fields
					if (strpos($table['sourcemap'],PHP_EOL) !== false)
					{
						$fields = explode(PHP_EOL,$table['sourcemap']);
						if (ComponentbuilderHelper::checkArray($fields))
						{
							// reset array buckets
							$sourceArray = array();
							$targetArray = array();
							foreach ($fields as $field)
							{
								if (strpos($field,"=>") !== false)
								{
									list($source,$target) = explode("=>",$field);
									$sourceArray[] = $counter.'.'.trim($source);
									$targetArray[] = trim($target);
								}
							}
							if (ComponentbuilderHelper::checkArray($sourceArray) && ComponentbuilderHelper::checkArray($targetArray))
							{
								// add to query
								$query->select($db->quoteName($sourceArray,$targetArray));
								$query->from('#__'.$table['table'].' AS a');
							}
							// we may need to filter the selection
							if (isset($this->sqlTweak[$view_id]['where']))
							{
								// add to query the where filter
								$query->where('a.id IN (' . $this->sqlTweak[$view_id]['where'] . ')');
							}
						}
					}
				}
				else
				{
					// the other tables
					if (strpos($table['sourcemap'],PHP_EOL) !== false)
					{
						$fields = explode(PHP_EOL,$table['sourcemap']);
						if (ComponentbuilderHelper::checkArray($fields))
						{
							// reset array buckets
							$sourceArray = array();
							$targetArray = array();
							foreach ($fields as $field)
							{
								if (strpos($field,"=>") !== false)
								{
									list($source,$target) = explode("=>",$field);
									$sourceArray[] = $counter.'.'.trim($source);
									$targetArray[] = trim($target);
								}
								if (strpos($field,"==") !== false)
								{
									list($aKey,$bKey) = explode("==",$field);
									// add to query
									$query->join('LEFT', $db->quoteName('#__'.$table['table'], $counter) . ' ON (' . $db->quoteName('a.'.trim($aKey)) . ' = ' . $db->quoteName($counter.'.'.trim($bKey)) . ')');
								}
							}
							if (ComponentbuilderHelper::checkArray($sourceArray) && ComponentbuilderHelper::checkArray($targetArray))
							{
								// add to query
								$query->select($db->quoteName($sourceArray,$targetArray));
							}
						}
					}
				}
				$counter++;
			}
			// now get the data
			$db->setQuery($query);
			$db->execute();
			if ($db->getNumRows())
			{
				// get the data
				$data = $db->loadObjectList();
				// start building the MySql dump
				$dump = "--";
				$dump .= "\n-- Dumping data for table `#__[[[component]]]_".$view."`";
				$dump .= "\n--";
				$dump .= "\n\nINSERT INTO `#__[[[component]]]_".$view."` (";
				foreach ($data as $line)
				{
					$comaSet = 0;
					foreach($line as $fieldName => $fieldValue)
					{
						if ($comaSet == 0)
						{
							$dump .= $db->quoteName($fieldName);
						}
						else
						{
							$dump .= ", ".$db->quoteName($fieldName);
						}
						$comaSet++;
					}
					break;
				}
				$dump .= ") VALUES";
				$coma = 0;
				foreach ($data as $line)
				{
					if ($coma == 0)
					{
						$dump .= "\n(";
					}
					else
					{
						$dump .= ",\n(";
					}
					$comaSet = 0;
					foreach($line as $fieldName => $fieldValue)
					{
						if ($comaSet == 0)
						{
							$dump .= $this->mysql_escape($fieldValue);
						}
						else
						{
							$dump .= ", ". $this->mysql_escape($fieldValue);
						}
						$comaSet++;
					}
					$dump .= ")";
					$coma++;
				}
				$dump .= ";";
				// return build dump query
				return $dump;
			}
		}
		return false;
	}
	
	/**
	 * Escape the values for a SQL dump
	 * 
	 * @param   string   $value  the value to escape
	 *
	 * @return  string on success with escaped string
	 * 
	 */
	public function mysql_escape($value)
	{
		// if array then return maped
		if(ComponentbuilderHelper::checkArray($value))
		{
			return array_map(__METHOD__, $value);
		}
		// if string make sure it is correctly escaped
		if(ComponentbuilderHelper::checkString($value) && !is_numeric($value))
		{
			// Get a db connection.
			$db = JFactory::getDbo();
			return $db->quote($value);
		}
		// if empty value return place holder
		if(empty($value))
		{
			return "''";
		}
		// if not array or string then return number
		return $value;
	}
	
	/**
	 * Creating an uniqueCode
	 * 
	 * @param   string   $code The planed code
	 *
	 * @return  string The unique code
	 * 
	 */
	public function uniqueCode($code)
	{
		if (!isset($this->uniquecodes[$this->target]) || !in_array($code,$this->uniquecodes[$this->target]))
		{
			$this->uniquecodes[$this->target][] = $code;
			return $code;
		}
		// make sure it is unique
		return $this->uniqueCode($code.$this->uniquekey(1));
	}
	
	/**
	 * Creating an unique local key
	 * 
	 * @param   int   $size The key size
	 *
	 * @return  string The unique localkey
	 * 
	 */
	public function uniquekey($size, $random = false)
	{
		if ($random)
		{
			$bag = "abcefghijknopqrstuwxyzABCDDEFGHIJKLLMMNOPQRSTUVVWXYZabcddefghijkllmmnopqrstuvvwxyzABCEFGHIJKNOPQRSTUWXYZ";
		}
		else
		{
			$bag = "vvvvvvvvvvvvvvvvvvv";
		}
		$key = array();
		$bagsize = strlen($bag) - 1;
		for ($i = 0; $i < $size; $i++)
		{
			$get = rand(0, $bagsize);
			$key[] = $bag[$get];
		}
		$key = implode($key);
		while (in_array($key, $this->uniquekeys))
		{
			$key++;
		}
		$this->uniquekeys[] = $key;
		return $key;
	}
	
	/**
	 * Check for footable scripts
	 * 
	 * @param   string   $content The content to check
	 *
	 * @return  boolean True if found
	 * 
	 */
	public function getFootableScripts($content)
	{
		if (strpos($content,'footable') !== false)
		{
			return true;
		}
		return false;
	}
	
	/**
	 * Check for getModules script
	 * 
	 * @param   string   $content The content to check
	 *
	 * @return  boolean True if found
	 * 
	 */
	public function getGetModule($content)
	{
		if (strpos($content,'this->getModules(') !== false)
		{
			return true;
		}
		return false;
	}
	
	/**
	 * Check for getModules script
	 * 
	 * @param   string   $content The content to check
	 *
	 * @return  boolean True if found
	 * 
	 */
	public function getGoogleChart($content)
	{
		if (strpos($content,'Chartbuilder(') !== false)
		{
			return true;
		}
		return false;
	}
}
