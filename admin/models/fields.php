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

	@version		2.2.4
	@build			25th November, 2016
	@created		30th April, 2015
	@package		Component Builder
	@subpackage		fields.php
	@author			Llewellyn van der Merwe <https://www.vdm.io/joomla-component-builder>	
	@copyright		Copyright (C) 2015. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html 
	
	Builds Complex Joomla Components 
                                                             
/-----------------------------------------------------------------------------------------------------------------------------*/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import the Joomla modellist library
jimport('joomla.application.component.modellist');

/**
 * Fields Model
 */
class ComponentbuilderModelFields extends JModelList
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
				'a.name','name',
				'a.fieldtype','fieldtype',
				'a.datatype','datatype',
				'a.indexes','indexes',
				'a.null_switch','null_switch',
				'c.title','category_title',
				'c.id', 'category_id',
				'a.catid', 'catid',
				'a.store','store'
			);
		}

		parent::__construct($config);
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
		$name = $this->getUserStateFromRequest($this->context . '.filter.name', 'filter_name');
		$this->setState('filter.name', $name);

		$fieldtype = $this->getUserStateFromRequest($this->context . '.filter.fieldtype', 'filter_fieldtype');
		$this->setState('filter.fieldtype', $fieldtype);

		$datatype = $this->getUserStateFromRequest($this->context . '.filter.datatype', 'filter_datatype');
		$this->setState('filter.datatype', $datatype);

		$indexes = $this->getUserStateFromRequest($this->context . '.filter.indexes', 'filter_indexes');
		$this->setState('filter.indexes', $indexes);

		$null_switch = $this->getUserStateFromRequest($this->context . '.filter.null_switch', 'filter_null_switch');
		$this->setState('filter.null_switch', $null_switch);

		$category = $app->getUserStateFromRequest($this->context . '.filter.category', 'filter_category');
		$this->setState('filter.category', $category);

		$categoryId = $this->getUserStateFromRequest($this->context . '.filter.category_id', 'filter_category_id');
		$this->setState('filter.category_id', $categoryId);

		$catid = $app->getUserStateFromRequest($this->context . '.filter.catid', 'filter_catid');
		$this->setState('filter.catid', $catid);

		$store = $this->getUserStateFromRequest($this->context . '.filter.store', 'filter_store');
		$this->setState('filter.store', $store);
        
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
				$access = ($user->authorise('field.access', 'com_componentbuilder.field.' . (int) $item->id) && $user->authorise('field.access', 'com_componentbuilder'));
				if (!$access)
				{
					unset($items[$nr]);
					continue;
				}

			}
		} 

		// set selection value to a translatable value
		if (ComponentbuilderHelper::checkArray($items))
		{
			foreach ($items as $nr => &$item)
			{
				// convert datatype
				$item->datatype = $this->selectionTranslation($item->datatype, 'datatype');
				// convert indexes
				$item->indexes = $this->selectionTranslation($item->indexes, 'indexes');
				// convert null_switch
				$item->null_switch = $this->selectionTranslation($item->null_switch, 'null_switch');
				// convert store
				$item->store = $this->selectionTranslation($item->store, 'store');
			}
		}
 
        
		// return items
		return $items;
	}

	/**
	* Method to convert selection values to translatable string.
	*
	* @return translatable string
	*/
	public function selectionTranslation($value,$name)
	{
		// Array of datatype language strings
		if ($name == 'datatype')
		{
			$datatypeArray = array(
				'CHAR' => 'COM_COMPONENTBUILDER_FIELD_CHAR',
				'VARCHAR' => 'COM_COMPONENTBUILDER_FIELD_VARCHAR',
				'TEXT' => 'COM_COMPONENTBUILDER_FIELD_TEXT',
				'MEDIUMTEXT' => 'COM_COMPONENTBUILDER_FIELD_MEDIUMTEXT',
				'LONGTEXT' => 'COM_COMPONENTBUILDER_FIELD_LONGTEXT',
				'DATETIME' => 'COM_COMPONENTBUILDER_FIELD_DATETIME',
				'DATE' => 'COM_COMPONENTBUILDER_FIELD_DATE',
				'TIME' => 'COM_COMPONENTBUILDER_FIELD_TIME',
				'INT' => 'COM_COMPONENTBUILDER_FIELD_INT',
				'TINYINT' => 'COM_COMPONENTBUILDER_FIELD_TINYINT',
				'BIGINT' => 'COM_COMPONENTBUILDER_FIELD_BIGINT',
				'FLOAT' => 'COM_COMPONENTBUILDER_FIELD_FLOAT',
				'DECIMAL' => 'COM_COMPONENTBUILDER_FIELD_DECIMAL',
				'DOUBLE' => 'COM_COMPONENTBUILDER_FIELD_DOUBLE'
			);
			// Now check if value is found in this array
			if (isset($datatypeArray[$value]) && ComponentbuilderHelper::checkString($datatypeArray[$value]))
			{
				return $datatypeArray[$value];
			}
		}
		// Array of indexes language strings
		if ($name == 'indexes')
		{
			$indexesArray = array(
				1 => 'COM_COMPONENTBUILDER_FIELD_UNIQUE_KEY',
				2 => 'COM_COMPONENTBUILDER_FIELD_KEY',
				0 => 'COM_COMPONENTBUILDER_FIELD_NONE'
			);
			// Now check if value is found in this array
			if (isset($indexesArray[$value]) && ComponentbuilderHelper::checkString($indexesArray[$value]))
			{
				return $indexesArray[$value];
			}
		}
		// Array of null_switch language strings
		if ($name == 'null_switch')
		{
			$null_switchArray = array(
				'NULL' => 'COM_COMPONENTBUILDER_FIELD_NULL',
				'NOT NULL' => 'COM_COMPONENTBUILDER_FIELD_NOT_NULL'
			);
			// Now check if value is found in this array
			if (isset($null_switchArray[$value]) && ComponentbuilderHelper::checkString($null_switchArray[$value]))
			{
				return $null_switchArray[$value];
			}
		}
		// Array of store language strings
		if ($name == 'store')
		{
			$storeArray = array(
				0 => 'COM_COMPONENTBUILDER_FIELD_DEFAULT',
				1 => 'COM_COMPONENTBUILDER_FIELD_JSON',
				2 => 'COM_COMPONENTBUILDER_FIELD_BASESIXTY_FOUR',
				3 => 'COM_COMPONENTBUILDER_FIELD_BASIC_ENCRYPTION_LOCALKEY',
				4 => 'COM_COMPONENTBUILDER_FIELD_ADVANCE_ENCRYPTION_WHMCSKEY'
			);
			// Now check if value is found in this array
			if (isset($storeArray[$value]) && ComponentbuilderHelper::checkString($storeArray[$value]))
			{
				return $storeArray[$value];
			}
		}
		return $value;
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
		$query->select($db->quoteName('c.title','category_title'));

		// From the componentbuilder_item table
		$query->from($db->quoteName('#__componentbuilder_field', 'a'));
		$query->join('LEFT', $db->quoteName('#__categories', 'c') . ' ON (' . $db->quoteName('a.catid') . ' = ' . $db->quoteName('c.id') . ')');

		// From the componentbuilder_fieldtype table.
		$query->select($db->quoteName('g.name','fieldtype_name'));
		$query->join('LEFT', $db->quoteName('#__componentbuilder_fieldtype', 'g') . ' ON (' . $db->quoteName('a.fieldtype') . ' = ' . $db->quoteName('g.id') . ')');

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
				$query->where('(a.name LIKE '.$search.' OR a.fieldtype LIKE '.$search.' OR g.name LIKE '.$search.' OR a.datatype LIKE '.$search.' OR a.indexes LIKE '.$search.' OR a.null_switch LIKE '.$search.' OR a.xml LIKE '.$search.' OR a.catid LIKE '.$search.' OR a.store LIKE '.$search.')');
			}
		}

		// Filter by fieldtype.
		if ($fieldtype = $this->getState('filter.fieldtype'))
		{
			$query->where('a.fieldtype = ' . $db->quote($db->escape($fieldtype)));
		}
		// Filter by Datatype.
		if ($datatype = $this->getState('filter.datatype'))
		{
			$query->where('a.datatype = ' . $db->quote($db->escape($datatype)));
		}
		// Filter by Indexes.
		if ($indexes = $this->getState('filter.indexes'))
		{
			$query->where('a.indexes = ' . $db->quote($db->escape($indexes)));
		}
		// Filter by Null_switch.
		if ($null_switch = $this->getState('filter.null_switch'))
		{
			$query->where('a.null_switch = ' . $db->quote($db->escape($null_switch)));
		}
		// Filter by Store.
		if ($store = $this->getState('filter.store'))
		{
			$query->where('a.store = ' . $db->quote($db->escape($store)));
		}

		// Filter by a single or group of categories.
		$baselevel = 1;
		$categoryId = $this->getState('filter.category_id');

		if (is_numeric($categoryId))
		{
			$cat_tbl = JTable::getInstance('Category', 'JTable');
			$cat_tbl->load($categoryId);
			$rgt = $cat_tbl->rgt;
			$lft = $cat_tbl->lft;
			$baselevel = (int) $cat_tbl->level;
			$query->where('c.lft >= ' . (int) $lft)
				->where('c.rgt <= ' . (int) $rgt);
		}
		elseif (is_array($categoryId))
		{
			JArrayHelper::toInteger($categoryId);
			$categoryId = implode(',', $categoryId);
			$query->where('a.category IN (' . $categoryId . ')');
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

			// From the componentbuilder_field table
			$query->from($db->quoteName('#__componentbuilder_field', 'a'));
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

				// set values to display correctly.
				if (ComponentbuilderHelper::checkArray($items))
				{
					// get user object.
					$user = JFactory::getUser();
					foreach ($items as $nr => &$item)
					{
						$access = ($user->authorise('field.access', 'com_componentbuilder.field.' . (int) $item->id) && $user->authorise('field.access', 'com_componentbuilder'));
						if (!$access)
						{
							unset($items[$nr]);
							continue;
						}

						// decode css_view
						$item->css_view = base64_decode($item->css_view);
						// decode css_views
						$item->css_views = base64_decode($item->css_views);
						// decode javascript_view_footer
						$item->javascript_view_footer = base64_decode($item->javascript_view_footer);
						// decode javascript_views_footer
						$item->javascript_views_footer = base64_decode($item->javascript_views_footer);
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
		$columns = $db->getTableColumns("#__componentbuilder_field");
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
		$id .= ':' . $this->getState('filter.name');
		$id .= ':' . $this->getState('filter.fieldtype');
		$id .= ':' . $this->getState('filter.datatype');
		$id .= ':' . $this->getState('filter.indexes');
		$id .= ':' . $this->getState('filter.null_switch');
		$id .= ':' . $this->getState('filter.category');
		$id .= ':' . $this->getState('filter.category_id');
		$id .= ':' . $this->getState('filter.catid');
		$id .= ':' . $this->getState('filter.store');

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
			$query->from($db->quoteName('#__componentbuilder_field'));
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
				$query->update($db->quoteName('#__componentbuilder_field'))->set($fields)->where($conditions); 

				$db->setQuery($query);

				$db->execute();
			}
		}

		return false;
	}
}
