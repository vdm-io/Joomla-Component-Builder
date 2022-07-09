<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\MVC\Model\ListModel;
use Joomla\Utilities\ArrayHelper;

/**
 * Fields List Model
 */
class ComponentbuilderModelFields extends ListModel
{
	public function __construct($config = array())
	{
		if (empty($config['filter_fields']))
        {
			$config['filter_fields'] = array(
				'a.id','id',
				'a.published','published',
				'a.access','access',
				'a.ordering','ordering',
				'a.created_by','created_by',
				'a.modified_by','modified_by',
				'g.name','fieldtype',
				'a.datatype','datatype',
				'a.indexes','indexes',
				'a.null_switch','null_switch',
				'a.store','store',
				'c.title','category_title',
				'c.id', 'category_id',
				'a.catid','catid',
				'a.name','name'
			);
		}

		parent::__construct($config);
	}

	/**
	 * Get the filter form - Override the parent method
	 *
	 * @param   array    $data      data
	 * @param   boolean  $loadData  load current data
	 *
	 * @return  \JForm|boolean  The \JForm object or false on error
	 *
	 * @since   JCB 2.12.5
	 */
	public function getFilterForm($data = array(), $loadData = true)
	{
		// load form from the parent class
		$form = parent::getFilterForm($data, $loadData);

		// Create the "extension" filter
		$form->setField(new SimpleXMLElement(
			ComponentbuilderHelper::getExtensionGroupedListXml()
			),'filter');
		$form->setValue(
			'extension',
			'filter',
			$this->state->get("filter.extension")
		);
		array_push($this->filter_fields, 'extension');

		// Create the "admin_view" filter
		$attributes = array(
			'name' => 'admin_view',
			'type' => 'list',
			'onchange' => 'this.form.submit();',
		);
		$options = array(
			'' => '-  ' . JText::_('COM_COMPONENTBUILDER_NO_ADMIN_VIEWS_FOUND') . '  -'
		);
		// check if we have admin views (and limit to an extension if it is set)
		if (($admin_views = ComponentbuilderHelper::getByTypeTheIdsSystemNames('admin_view', $this->state->get("filter.extension"))) !== false)
		{
			$options = array(
				'' => '-  ' . JText::_('COM_COMPONENTBUILDER_SELECT_ADMIN_VIEW') . '  -'
			);
			// make sure we do not lose the key values in normal merge
			$options = $options + $admin_views;
		}

		$form->setField(ComponentbuilderHelper::getFieldXML($attributes, $options),'filter');
		$form->setValue(
			'admin_view',
			'filter',
			$this->state->get("filter.admin_view")
		);
		array_push($this->filter_fields, 'admin_view');

		return $form;
	}

	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @param   string  $ordering   An optional ordering field.
	 * @param   string  $direction  An optional direction (asc|desc).
	 *
	 * @return  void
	 *
	 */
	protected function populateState($ordering = null, $direction = null)
	{
		$app = JFactory::getApplication();

		// Adjust the context to support modal layouts.
		if ($layout = $app->input->get('layout'))
		{
			$this->context .= '.' . $layout;
		}

		// Check if the form was submitted
		$formSubmited = $app->input->post->get('form_submited');

		$access = $this->getUserStateFromRequest($this->context . '.filter.access', 'filter_access', 0, 'int');
		if ($formSubmited)
		{
			$access = $app->input->post->get('access');
			$this->setState('filter.access', $access);
		}

		$published = $this->getUserStateFromRequest($this->context . '.filter.published', 'filter_published', '');
		$this->setState('filter.published', $published);

		$created_by = $this->getUserStateFromRequest($this->context . '.filter.created_by', 'filter_created_by', '');
		$this->setState('filter.created_by', $created_by);

		$created = $this->getUserStateFromRequest($this->context . '.filter.created', 'filter_created');
		$this->setState('filter.created', $created);

		$sorting = $this->getUserStateFromRequest($this->context . '.filter.sorting', 'filter_sorting', 0, 'int');
		$this->setState('filter.sorting', $sorting);

		$search = $this->getUserStateFromRequest($this->context . '.filter.search', 'filter_search');
		$this->setState('filter.search', $search);

		$fieldtype = $this->getUserStateFromRequest($this->context . '.filter.fieldtype', 'filter_fieldtype');
		if ($formSubmited)
		{
			$fieldtype = $app->input->post->get('fieldtype');
			$this->setState('filter.fieldtype', $fieldtype);
		}

		$datatype = $this->getUserStateFromRequest($this->context . '.filter.datatype', 'filter_datatype');
		if ($formSubmited)
		{
			$datatype = $app->input->post->get('datatype');
			$this->setState('filter.datatype', $datatype);
		}

		$indexes = $this->getUserStateFromRequest($this->context . '.filter.indexes', 'filter_indexes');
		if ($formSubmited)
		{
			$indexes = $app->input->post->get('indexes');
			$this->setState('filter.indexes', $indexes);
		}

		$null_switch = $this->getUserStateFromRequest($this->context . '.filter.null_switch', 'filter_null_switch');
		if ($formSubmited)
		{
			$null_switch = $app->input->post->get('null_switch');
			$this->setState('filter.null_switch', $null_switch);
		}

		$store = $this->getUserStateFromRequest($this->context . '.filter.store', 'filter_store');
		if ($formSubmited)
		{
			$store = $app->input->post->get('store');
			$this->setState('filter.store', $store);
		}

		$category = $app->getUserStateFromRequest($this->context . '.filter.category', 'filter_category');
		$this->setState('filter.category', $category);

		$categoryId = $this->getUserStateFromRequest($this->context . '.filter.category_id', 'filter_category_id');
		$this->setState('filter.category_id', $categoryId);

		$catid = $this->getUserStateFromRequest($this->context . '.filter.catid', 'filter_catid');
		if ($formSubmited)
		{
			$catid = $app->input->post->get('catid');
			$this->setState('filter.catid', $catid);
		}

		$name = $this->getUserStateFromRequest($this->context . '.filter.name', 'filter_name');
		if ($formSubmited)
		{
			$name = $app->input->post->get('name');
			$this->setState('filter.name', $name);
		}

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
		// Check in items
		$this->checkInNow();

		// load parent items
		$items = parent::getItems();

		// Set values to display correctly.
		if (ComponentbuilderHelper::checkArray($items))
		{
			// Get the user object if not set.
			if (!isset($user) || !ComponentbuilderHelper::checkObject($user))
			{
				$user = JFactory::getUser();
			}
			foreach ($items as $nr => &$item)
			{
				// Remove items the user can't access.
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
		if ($name === 'datatype')
		{
			$datatypeArray = array(
				0 => 'COM_COMPONENTBUILDER_FIELD_SELECT_AN_OPTION',
				'CHAR' => 'COM_COMPONENTBUILDER_FIELD_CHAR',
				'VARCHAR' => 'COM_COMPONENTBUILDER_FIELD_VARCHAR',
				'TEXT' => 'COM_COMPONENTBUILDER_FIELD_TEXT',
				'MEDIUMTEXT' => 'COM_COMPONENTBUILDER_FIELD_MEDIUMTEXT',
				'LONGTEXT' => 'COM_COMPONENTBUILDER_FIELD_LONGTEXT',
				'BLOB' => 'COM_COMPONENTBUILDER_FIELD_BLOB',
				'TINYBLOB' => 'COM_COMPONENTBUILDER_FIELD_TINYBLOB',
				'MEDIUMBLOB' => 'COM_COMPONENTBUILDER_FIELD_MEDIUMBLOB',
				'LONGBLOB' => 'COM_COMPONENTBUILDER_FIELD_LONGBLOB',
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
		if ($name === 'indexes')
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
		if ($name === 'null_switch')
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
		if ($name === 'store')
		{
			$storeArray = array(
				0 => 'COM_COMPONENTBUILDER_FIELD_DEFAULT',
				1 => 'COM_COMPONENTBUILDER_FIELD_JSON',
				2 => 'COM_COMPONENTBUILDER_FIELD_BASE64',
				3 => 'COM_COMPONENTBUILDER_FIELD_BASIC_ENCRYPTION_LOCALDBKEY',
				5 => 'COM_COMPONENTBUILDER_FIELD_MEDIUM_ENCRYPTION_LOCALFILEKEY',
				4 => 'COM_COMPONENTBUILDER_FIELD_WHMCSKEY_ENCRYPTION',
				6 => 'COM_COMPONENTBUILDER_FIELD_EXPERT_MODE_CUSTOM'
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

		// do not use these filters in the export method
		if (!isset($_export) || !$_export)
		{
			// Filtering "extension"
			$filter_extension = $this->state->get("filter.extension");
			$field_ids = array();
			$get_ids = true;
			if ($get_ids && $filter_extension !== null && !empty($filter_extension))
			{
				// column name, and id
				$type_extension = explode('__', $filter_extension);
				if (($ids = ComponentbuilderHelper::getAreaLinkedIDs($type_extension[1], $type_extension[0])) !== false)
				{
					$field_ids = $ids;
				}
				else
				{
					// there is none
					$query->where($db->quoteName('a.id') . ' = ' . 0);
					$get_ids = false;
				}
			}

			// Filtering "admin_view"
			$filter_admin_view = $this->state->get("filter.admin_view");
			if ($get_ids && $filter_admin_view !== null && !empty($filter_admin_view))
			{
				if (($ids = ComponentbuilderHelper::getAreaLinkedIDs($filter_admin_view, 'admin_view')) !== false)
				{
					// view will return less fields, so we ignore the component
					$field_ids = $ids;
				}
				else
				{
					// there is none
					$query->where($db->quoteName('a.id') . ' = ' . 0);
					$get_ids = false;
				}
			}
			// now check if we have IDs
			if ($get_ids && ComponentbuilderHelper::checkArray($field_ids))
			{
				$query->where($db->quoteName('a.id') . ' IN (' . implode(',', $field_ids) . ')');
			}
		}

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
		$_access = $this->getState('filter.access');
		if ($_access && is_numeric($_access))
		{
			$query->where('a.access = ' . (int) $_access);
		}
		elseif (ComponentbuilderHelper::checkArray($_access))
		{
			// Secure the array for the query
			$_access = ArrayHelper::toInteger($_access);
			// Filter by the Access Array.
			$query->where('a.access IN (' . implode(',', $_access) . ')');
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
				$query->where('(a.name LIKE '.$search.' OR a.fieldtype LIKE '.$search.' OR g.name LIKE '.$search.' OR a.datatype LIKE '.$search.' OR a.indexes LIKE '.$search.' OR a.null_switch LIKE '.$search.' OR a.store LIKE '.$search.' OR a.catid LIKE '.$search.' OR a.xml LIKE '.$search.')');
			}
		}

		// Filter by Fieldtype.
		$_fieldtype = $this->getState('filter.fieldtype');
		if (is_numeric($_fieldtype))
		{
			if (is_float($_fieldtype))
			{
				$query->where('a.fieldtype = ' . (float) $_fieldtype);
			}
			else
			{
				$query->where('a.fieldtype = ' . (int) $_fieldtype);
			}
		}
		elseif (ComponentbuilderHelper::checkString($_fieldtype))
		{
			$query->where('a.fieldtype = ' . $db->quote($db->escape($_fieldtype)));
		}
		// Filter by Datatype.
		$_datatype = $this->getState('filter.datatype');
		if (is_numeric($_datatype))
		{
			if (is_float($_datatype))
			{
				$query->where('a.datatype = ' . (float) $_datatype);
			}
			else
			{
				$query->where('a.datatype = ' . (int) $_datatype);
			}
		}
		elseif (ComponentbuilderHelper::checkString($_datatype))
		{
			$query->where('a.datatype = ' . $db->quote($db->escape($_datatype)));
		}
		// Filter by Indexes.
		$_indexes = $this->getState('filter.indexes');
		if (is_numeric($_indexes))
		{
			if (is_float($_indexes))
			{
				$query->where('a.indexes = ' . (float) $_indexes);
			}
			else
			{
				$query->where('a.indexes = ' . (int) $_indexes);
			}
		}
		elseif (ComponentbuilderHelper::checkString($_indexes))
		{
			$query->where('a.indexes = ' . $db->quote($db->escape($_indexes)));
		}
		// Filter by Null_switch.
		$_null_switch = $this->getState('filter.null_switch');
		if (is_numeric($_null_switch))
		{
			if (is_float($_null_switch))
			{
				$query->where('a.null_switch = ' . (float) $_null_switch);
			}
			else
			{
				$query->where('a.null_switch = ' . (int) $_null_switch);
			}
		}
		elseif (ComponentbuilderHelper::checkString($_null_switch))
		{
			$query->where('a.null_switch = ' . $db->quote($db->escape($_null_switch)));
		}
		// Filter by Store.
		$_store = $this->getState('filter.store');
		if (is_numeric($_store))
		{
			if (is_float($_store))
			{
				$query->where('a.store = ' . (float) $_store);
			}
			else
			{
				$query->where('a.store = ' . (int) $_store);
			}
		}
		elseif (ComponentbuilderHelper::checkString($_store))
		{
			$query->where('a.store = ' . $db->quote($db->escape($_store)));
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
			$categoryId = ArrayHelper::toInteger($categoryId);
			$categoryId = implode(',', $categoryId);
			$query->where('a.catid IN (' . $categoryId . ')');
		}


		// Add the list ordering clause.
		$orderCol = $this->state->get('list.ordering', 'a.id');
		$orderDirn = $this->state->get('list.direction', 'desc');
		if ($orderCol != '')
		{
			$query->order($db->escape($orderCol . ' ' . $orderDirn));
		}

		return $query;
	}

	/**
	 * Method to get list export data.
	 *
	 * @param   array  $pks  The ids of the items to get
	 * @param   JUser  $user  The user making the request
	 *
	 * @return mixed  An array of data items on success, false on failure.
	 */
	public function getExportData($pks, $user = null)
	{
		// setup the query
		if (($pks_size = ComponentbuilderHelper::checkArray($pks)) !== false || 'bulk' === $pks)
		{
			// Set a value to know this is export method. (USE IN CUSTOM CODE TO ALTER OUTCOME)
			$_export = true;
			// Get the user object if not set.
			if (!isset($user) || !ComponentbuilderHelper::checkObject($user))
			{
				$user = JFactory::getUser();
			}
			// Create a new query object.
			$db = JFactory::getDBO();
			$query = $db->getQuery(true);

			// Select some fields
			$query->select('a.*');

			// From the componentbuilder_field table
			$query->from($db->quoteName('#__componentbuilder_field', 'a'));
			// The bulk export path
			if ('bulk' === $pks)
			{
				$query->where('a.id > 0');
			}
			// A large array of ID's will not work out well
			elseif ($pks_size > 500)
			{
				// Use lowest ID
				$query->where('a.id >= ' . (int) min($pks));
				// Use highest ID
				$query->where('a.id <= ' . (int) max($pks));
			}
			// The normal default path
			else
			{
				$query->where('a.id IN (' . implode(',',$pks) . ')');
			}

			// do not use these filters in the export method
		if (!isset($_export) || !$_export)
		{
			// Filtering "extension"
			$filter_extension = $this->state->get("filter.extension");
			$field_ids = array();
			$get_ids = true;
			if ($get_ids && $filter_extension !== null && !empty($filter_extension))
			{
				// column name, and id
				$type_extension = explode('__', $filter_extension);
				if (($ids = ComponentbuilderHelper::getAreaLinkedIDs($type_extension[1], $type_extension[0])) !== false)
				{
					$field_ids = $ids;
				}
				else
				{
					// there is none
					$query->where($db->quoteName('a.id') . ' = ' . 0);
					$get_ids = false;
				}
			}

			// Filtering "admin_view"
			$filter_admin_view = $this->state->get("filter.admin_view");
			if ($get_ids && $filter_admin_view !== null && !empty($filter_admin_view))
			{
				if (($ids = ComponentbuilderHelper::getAreaLinkedIDs($filter_admin_view, 'admin_view')) !== false)
				{
					// view will return less fields, so we ignore the component
					$field_ids = $ids;
				}
				else
				{
					// there is none
					$query->where($db->quoteName('a.id') . ' = ' . 0);
					$get_ids = false;
				}
			}
			// now check if we have IDs
			if ($get_ids && ComponentbuilderHelper::checkArray($field_ids))
			{
				$query->where($db->quoteName('a.id') . ' IN (' . implode(',', $field_ids) . ')');
			}
		}
			// Implement View Level Access
			if (!$user->authorise('core.options', 'com_componentbuilder'))
			{
				$groups = implode(',', $user->getAuthorisedViewLevels());
				$query->where('a.access IN (' . $groups . ')');
			}

			// Order the results by ordering
			$query->order('a.id desc');

			// Load the items
			$db->setQuery($query);
			$db->execute();
			if ($db->getNumRows())
			{
				$items = $db->loadObjectList();

				// Set values to display correctly.
				if (ComponentbuilderHelper::checkArray($items))
				{
					foreach ($items as $nr => &$item)
					{
						// Remove items the user can't access.
						$access = ($user->authorise('field.access', 'com_componentbuilder.field.' . (int) $item->id) && $user->authorise('field.access', 'com_componentbuilder'));
						if (!$access)
						{
							unset($items[$nr]);
							continue;
						}

						// decode on_get_model_field
						$item->on_get_model_field = base64_decode($item->on_get_model_field);
						// decode on_save_model_field
						$item->on_save_model_field = base64_decode($item->on_save_model_field);
						// decode initiator_on_get_model
						$item->initiator_on_get_model = base64_decode($item->initiator_on_get_model);
						// decode css_view
						$item->css_view = base64_decode($item->css_view);
						// decode javascript_view_footer
						$item->javascript_view_footer = base64_decode($item->javascript_view_footer);
						// decode css_views
						$item->css_views = base64_decode($item->css_views);
						// decode javascript_views_footer
						$item->javascript_views_footer = base64_decode($item->javascript_views_footer);
						// decode initiator_on_save_model
						$item->initiator_on_save_model = base64_decode($item->initiator_on_save_model);
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
		// Check if the value is an array
		$_access = $this->getState('filter.access');
		if (ComponentbuilderHelper::checkArray($_access))
		{
			$id .= ':' . implode(':', $_access);
		}
		// Check if this is only an number or string
		elseif (is_numeric($_access)
		 || ComponentbuilderHelper::checkString($_access))
		{
			$id .= ':' . $_access;
		}
		$id .= ':' . $this->getState('filter.ordering');
		$id .= ':' . $this->getState('filter.created_by');
		$id .= ':' . $this->getState('filter.modified_by');
		$id .= ':' . $this->getState('filter.fieldtype');
		$id .= ':' . $this->getState('filter.datatype');
		$id .= ':' . $this->getState('filter.indexes');
		$id .= ':' . $this->getState('filter.null_switch');
		$id .= ':' . $this->getState('filter.store');
		// Check if the value is an array
		$_category = $this->getState('filter.category');
		if (ComponentbuilderHelper::checkArray($_category))
		{
			$id .= ':' . implode(':', $_category);
		}
		// Check if this is only an number or string
		elseif (is_numeric($_category)
		 || ComponentbuilderHelper::checkString($_category))
		{
			$id .= ':' . $_category;
		}
		// Check if the value is an array
		$_category_id = $this->getState('filter.category_id');
		if (ComponentbuilderHelper::checkArray($_category_id))
		{
			$id .= ':' . implode(':', $_category_id);
		}
		// Check if this is only an number or string
		elseif (is_numeric($_category_id)
		 || ComponentbuilderHelper::checkString($_category_id))
		{
			$id .= ':' . $_category_id;
		}
		// Check if the value is an array
		$_catid = $this->getState('filter.catid');
		if (ComponentbuilderHelper::checkArray($_catid))
		{
			$id .= ':' . implode(':', $_catid);
		}
		// Check if this is only an number or string
		elseif (is_numeric($_catid)
		 || ComponentbuilderHelper::checkString($_catid))
		{
			$id .= ':' . $_catid;
		}
		$id .= ':' . $this->getState('filter.name');

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
			// Reset query.
			$query = $db->getQuery(true);
			$query->select('*');
			$query->from($db->quoteName('#__componentbuilder_field'));
			// Only select items that are checked out.
			$query->where($db->quoteName('checked_out') . '!=0');
			$db->setQuery($query, 0, 1);
			$db->execute();
			if ($db->getNumRows())
			{
				// Get Yesterdays date.
				$date = JFactory::getDate()->modify($time)->toSql();
				// Reset query.
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

				// Check table.
				$query->update($db->quoteName('#__componentbuilder_field'))->set($fields)->where($conditions); 

				$db->setQuery($query);

				$db->execute();
			}
		}

		return false;
	}
}
