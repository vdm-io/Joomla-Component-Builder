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

	@version		@update number 112 of this MVC
	@build			18th March, 2017
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

	public $smartExport = array();
	protected $templateIds = array();
	protected $layoutIds = array();

	/**
	* Method to get list export data.
	*
	* @return mixed  An array of data items on success, false on failure.
	*/
	public function getSmartExport($pks)
	{
		// setup the query
		if (ComponentbuilderHelper::checkArray($pks))
		{
			// Get the user object.
			$user = JFactory::getUser();
			// Create a new query object.
			$db = JFactory::getDBO();
			$query = $db->getQuery(true);

			// Select some fields
			$query->select($db->quoteName('a.*'));
			
			// From the componentbuilder_joomla_componet table
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
				// check if we have items
				if (ComponentbuilderHelper::checkArray($items))
				{
					// start loading the components
					$this->smartExport['components'] = array();
					foreach ($items as $nr => &$item)
					{
						$access = ($user->authorise('joomla_component.access', 'com_componentbuilder.joomla_component.' . (int) $item->id) && $user->authorise('joomla_component.access', 'com_componentbuilder'));
						if (!$access)
						{
							unset($items[$nr]);
							continue;
						}						
						// add config fields
						$this->setData($user, $db, 'field', $item->addconfig, 'field');
						// add admin views
						$this->setData($user, $db, 'admin_view', $item->addadmin_views, 'adminview');
						// add custom admin views
						$this->setData($user, $db, 'custom_admin_view', $item->addcustom_admin_views, 'customadminview');
						// add site views
						$this->setData($user, $db, 'site_view', $item->addsite_views, 'siteview');
						// load to global object
						$this->smartExport['components'][$item->id] = $item;
					}
					// add templates
					if (ComponentbuilderHelper::checkArray($this->templateIds))
					{
						$this->setData($user, $db, 'template', array('template' => $this->templateIds), 'template');
					}
					// add layouts
					if (ComponentbuilderHelper::checkArray($this->layoutIds))
					{
						$this->setData($user, $db, 'layout', array('layout' => $this->layoutIds), 'layout');
					}
					// has any data been set
					if (ComponentbuilderHelper::checkArray($this->smartExport['components']))
					{
						return true;
					}
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
	protected function setData(&$user, &$db, $table, $values, $key)
	{
		// if json convert to array
		if (ComponentbuilderHelper::checkJson($values))
		{
			$values = json_decode($values, true);
		}
		// make sure we have an array
		if (!ComponentbuilderHelper::checkArray($values) || !isset($values[$key]) || !ComponentbuilderHelper::checkArray($values[$key]))
		{
			return false;
		}
		$query = $db->getQuery(true);

		// Select some fields
		$query->select($db->quoteName('a.*'));
			
		// From the componentbuilder_ANY table
		$query->from($db->quoteName('#__componentbuilder_'. $table, 'a'));
		$query->where('a.id IN (' . implode(',',$values[$key]) . ')');
			
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
			// check if we have items
			if (ComponentbuilderHelper::checkArray($items))
			{
				// set search array
				if ('site_view' === $table || 'custom_admin_view' === $table)
				{
					$searchArray = array('php_view','php_jview','php_jview_display','php_document','js_document','css_document','css');
				}
				// start loading the data
				if (!isset($this->smartExport[$table]))
				{
					$this->smartExport[$table] = array();
				}
				foreach ($items as $nr => &$item)
				{
					if (isset($this->smartExport[$table][$item->id]))
					{
						continue;
					}
					// actions to take if table is admin_view
					if ('admin_view' === $table)
					{
						// add fields
						$this->setData($user, $db, 'field', $item->addfields, 'field');
					}
					// actions to take if table is field
					if ('field' === $table)
					{
						// add field types
						$this->setData($user, $db, 'fieldtype', array('fieldtype' => array($item->fieldtype)), 'fieldtype');
					}
					// actions to take if table is site_view and custom_admin_view
					if ('site_view' === $table || 'custom_admin_view' === $table)
					{
						// search for templates & layouts
						$this->getTemplateLayout(base64_decode($item->default), $db);
						// add search array templates and layouts
						foreach ($searchArray as $scripter)
						{
							if (isset($view->{'add_'.$scripter}) && $view->{'add_'.$scripter} == 1)
							{
								$this->getTemplateLayout($view->$scripter, $db);
							}
						}
						// add dynamic gets
						$this->setData($user, $db, 'dynamic_get', array('dynamic_get' => array($item->main_get)), 'dynamic_get');
						$this->setData($user, $db, 'dynamic_get', array('dynamic_get' => $item->custom_get), 'dynamic_get');
					}
					// load to global object
					$this->smartExport[$table][$item->id] = $item;
				}
			}
		}
	}

	/**
	 * Set Template and Layout Data
	 * 
	 * @param   string   $default  The content to check
	 *
	 * @return  void
	 * 
	 */
	protected function getTemplateLayout($default, &$db)
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
				$data = $this->getDataWithAlias($template, 'template', $db);
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
				$data = $this->getDataWithAlias($layout, 'layout', $db);
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
				$this->getTemplateLayout($get, $db);
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
	protected function getDataWithAlias($n_ame, $table, &$db)
	{
		// Create a new query object.
		$query = $db->getQuery(true);
		$query->select($db->quoteName(array('a.id', 'a.alias', 'a.'.$table, 'a.php_view', 'a.add_php_view')));
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
				}
				$contnent = base64_decode($row->{$table});
				// return to continue the search
				return array('id' => $row->id, 'html' => $contnent, 'php_view' => $php_view);
			}
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

				// Get the basic encription key.
				$basickey = ComponentbuilderHelper::getCryptKey('basic');
				// Get the encription object.
				$basic = new FOFEncryptAes($basickey, 128);

				// set values to display correctly.
				if (ComponentbuilderHelper::checkArray($items))
				{
					foreach ($items as $nr => &$item)
					{
						if ($basickey && !is_numeric($item->update_server_ftp) && $item->update_server_ftp === base64_encode(base64_decode($item->update_server_ftp, true)))
						{
							// decrypt update_server_ftp
							$item->update_server_ftp = $basic->decryptString($item->update_server_ftp);
						}
						// decode php_postflight_install
						$item->php_postflight_install = base64_decode($item->php_postflight_install);
						// decode readme
						$item->readme = base64_decode($item->readme);
						// decode php_preflight_install
						$item->php_preflight_install = base64_decode($item->php_preflight_install);
						// decode css
						$item->css = base64_decode($item->css);
						// decode php_method_uninstall
						$item->php_method_uninstall = base64_decode($item->php_method_uninstall);
						if ($basickey && !is_numeric($item->whmcs_key) && $item->whmcs_key === base64_encode(base64_decode($item->whmcs_key, true)))
						{
							// decrypt whmcs_key
							$item->whmcs_key = $basic->decryptString($item->whmcs_key);
						}
						// decode php_preflight_update
						$item->php_preflight_update = base64_decode($item->php_preflight_update);
						// decode php_postflight_update
						$item->php_postflight_update = base64_decode($item->php_postflight_update);
						// decode sql
						$item->sql = base64_decode($item->sql);
						if ($basickey && !is_numeric($item->sales_server_ftp) && $item->sales_server_ftp === base64_encode(base64_decode($item->sales_server_ftp, true)))
						{
							// decrypt sales_server_ftp
							$item->sales_server_ftp = $basic->decryptString($item->sales_server_ftp);
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
