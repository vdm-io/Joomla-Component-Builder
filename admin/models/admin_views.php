<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <http://www.joomlacomponentbuilder.com>
 * @github     Joomla Component Builder <https://github.com/vdm-io/Joomla-Component-Builder>
 * @copyright  Copyright (C) 2015 - 2019 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * Admin_views Model
 */
class ComponentbuilderModelAdmin_views extends JModelList
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
				'a.name_single','name_single',
				'a.short_description','short_description',
				'a.add_fadein','add_fadein',
				'a.type','type',
				'a.add_custom_button','add_custom_button',
				'a.add_php_ajax','add_php_ajax',
				'a.add_custom_import','add_custom_import'
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
		$system_name = $this->getUserStateFromRequest($this->context . '.filter.system_name', 'filter_system_name');
		$this->setState('filter.system_name', $system_name);

		$name_single = $this->getUserStateFromRequest($this->context . '.filter.name_single', 'filter_name_single');
		$this->setState('filter.name_single', $name_single);

		$short_description = $this->getUserStateFromRequest($this->context . '.filter.short_description', 'filter_short_description');
		$this->setState('filter.short_description', $short_description);

		$add_fadein = $this->getUserStateFromRequest($this->context . '.filter.add_fadein', 'filter_add_fadein');
		$this->setState('filter.add_fadein', $add_fadein);

		$type = $this->getUserStateFromRequest($this->context . '.filter.type', 'filter_type');
		$this->setState('filter.type', $type);

		$add_custom_button = $this->getUserStateFromRequest($this->context . '.filter.add_custom_button', 'filter_add_custom_button');
		$this->setState('filter.add_custom_button', $add_custom_button);

		$add_php_ajax = $this->getUserStateFromRequest($this->context . '.filter.add_php_ajax', 'filter_add_php_ajax');
		$this->setState('filter.add_php_ajax', $add_php_ajax);

		$add_custom_import = $this->getUserStateFromRequest($this->context . '.filter.add_custom_import', 'filter_add_custom_import');
		$this->setState('filter.add_custom_import', $add_custom_import);
        
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
				$access = ($user->authorise('admin_view.access', 'com_componentbuilder.admin_view.' . (int) $item->id) && $user->authorise('admin_view.access', 'com_componentbuilder'));
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
				// convert add_fadein
				$item->add_fadein = $this->selectionTranslation($item->add_fadein, 'add_fadein');
				// convert type
				$item->type = $this->selectionTranslation($item->type, 'type');
				// convert add_custom_button
				$item->add_custom_button = $this->selectionTranslation($item->add_custom_button, 'add_custom_button');
				// convert add_php_ajax
				$item->add_php_ajax = $this->selectionTranslation($item->add_php_ajax, 'add_php_ajax');
				// convert add_custom_import
				$item->add_custom_import = $this->selectionTranslation($item->add_custom_import, 'add_custom_import');
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
		// Array of add_fadein language strings
		if ($name === 'add_fadein')
		{
			$add_fadeinArray = array(
				1 => 'COM_COMPONENTBUILDER_ADMIN_VIEW_ADD',
				0 => 'COM_COMPONENTBUILDER_ADMIN_VIEW_REMOVE'
			);
			// Now check if value is found in this array
			if (isset($add_fadeinArray[$value]) && ComponentbuilderHelper::checkString($add_fadeinArray[$value]))
			{
				return $add_fadeinArray[$value];
			}
		}
		// Array of type language strings
		if ($name === 'type')
		{
			$typeArray = array(
				1 => 'COM_COMPONENTBUILDER_ADMIN_VIEW_READWRITE',
				2 => 'COM_COMPONENTBUILDER_ADMIN_VIEW_READONLY'
			);
			// Now check if value is found in this array
			if (isset($typeArray[$value]) && ComponentbuilderHelper::checkString($typeArray[$value]))
			{
				return $typeArray[$value];
			}
		}
		// Array of add_custom_button language strings
		if ($name === 'add_custom_button')
		{
			$add_custom_buttonArray = array(
				1 => 'COM_COMPONENTBUILDER_ADMIN_VIEW_YES',
				0 => 'COM_COMPONENTBUILDER_ADMIN_VIEW_NO'
			);
			// Now check if value is found in this array
			if (isset($add_custom_buttonArray[$value]) && ComponentbuilderHelper::checkString($add_custom_buttonArray[$value]))
			{
				return $add_custom_buttonArray[$value];
			}
		}
		// Array of add_php_ajax language strings
		if ($name === 'add_php_ajax')
		{
			$add_php_ajaxArray = array(
				1 => 'COM_COMPONENTBUILDER_ADMIN_VIEW_YES',
				0 => 'COM_COMPONENTBUILDER_ADMIN_VIEW_NO'
			);
			// Now check if value is found in this array
			if (isset($add_php_ajaxArray[$value]) && ComponentbuilderHelper::checkString($add_php_ajaxArray[$value]))
			{
				return $add_php_ajaxArray[$value];
			}
		}
		// Array of add_custom_import language strings
		if ($name === 'add_custom_import')
		{
			$add_custom_importArray = array(
				1 => 'COM_COMPONENTBUILDER_ADMIN_VIEW_YES',
				0 => 'COM_COMPONENTBUILDER_ADMIN_VIEW_NO'
			);
			// Now check if value is found in this array
			if (isset($add_custom_importArray[$value]) && ComponentbuilderHelper::checkString($add_custom_importArray[$value]))
			{
				return $add_custom_importArray[$value];
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

		// From the componentbuilder_item table
		$query->from($db->quoteName('#__componentbuilder_admin_view', 'a'));

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
				$query->where('(a.system_name LIKE '.$search.' OR a.name_single LIKE '.$search.' OR a.short_description LIKE '.$search.' OR a.name_list LIKE '.$search.' OR a.description LIKE '.$search.' OR a.type LIKE '.$search.')');
			}
		}

		// Filter by Add_fadein.
		if ($add_fadein = $this->getState('filter.add_fadein'))
		{
			$query->where('a.add_fadein = ' . $db->quote($db->escape($add_fadein)));
		}
		// Filter by Type.
		if ($type = $this->getState('filter.type'))
		{
			$query->where('a.type = ' . $db->quote($db->escape($type)));
		}
		// Filter by Add_custom_button.
		if ($add_custom_button = $this->getState('filter.add_custom_button'))
		{
			$query->where('a.add_custom_button = ' . $db->quote($db->escape($add_custom_button)));
		}
		// Filter by Add_php_ajax.
		if ($add_php_ajax = $this->getState('filter.add_php_ajax'))
		{
			$query->where('a.add_php_ajax = ' . $db->quote($db->escape($add_php_ajax)));
		}
		// Filter by Add_custom_import.
		if ($add_custom_import = $this->getState('filter.add_custom_import'))
		{
			$query->where('a.add_custom_import = ' . $db->quote($db->escape($add_custom_import)));
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
	 * @param   array  $pks  The ids of the items to get
	 * @param   JUser  $user  The user making the request
	 *
	 * @return mixed  An array of data items on success, false on failure.
	 */
	public function getExportData($pks, $user = null)
	{
		// setup the query
		if (ComponentbuilderHelper::checkArray($pks))
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

			// From the componentbuilder_admin_view table
			$query->from($db->quoteName('#__componentbuilder_admin_view', 'a'));
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

				// Set values to display correctly.
				if (ComponentbuilderHelper::checkArray($items))
				{
					foreach ($items as $nr => &$item)
					{
						// Remove items the user can't access.
						$access = ($user->authorise('admin_view.access', 'com_componentbuilder.admin_view.' . (int) $item->id) && $user->authorise('admin_view.access', 'com_componentbuilder'));
						if (!$access)
						{
							unset($items[$nr]);
							continue;
						}

						// decode php_before_cancel
						$item->php_before_cancel = base64_decode($item->php_before_cancel);
						// decode php_allowadd
						$item->php_allowadd = base64_decode($item->php_allowadd);
						// decode php_save
						$item->php_save = base64_decode($item->php_save);
						// decode php_getform
						$item->php_getform = base64_decode($item->php_getform);
						// decode php_import_display
						$item->php_import_display = base64_decode($item->php_import_display);
						// decode php_before_delete
						$item->php_before_delete = base64_decode($item->php_before_delete);
						// decode php_batchcopy
						$item->php_batchcopy = base64_decode($item->php_batchcopy);
						// decode php_before_publish
						$item->php_before_publish = base64_decode($item->php_before_publish);
						// decode php_document
						$item->php_document = base64_decode($item->php_document);
						// decode sql
						$item->sql = base64_decode($item->sql);
						// decode php_import_setdata
						$item->php_import_setdata = base64_decode($item->php_import_setdata);
						// decode php_getlistquery
						$item->php_getlistquery = base64_decode($item->php_getlistquery);
						// decode php_before_save
						$item->php_before_save = base64_decode($item->php_before_save);
						// decode php_postsavehook
						$item->php_postsavehook = base64_decode($item->php_postsavehook);
						// decode php_allowedit
						$item->php_allowedit = base64_decode($item->php_allowedit);
						// decode php_after_cancel
						$item->php_after_cancel = base64_decode($item->php_after_cancel);
						// decode php_batchmove
						$item->php_batchmove = base64_decode($item->php_batchmove);
						// decode php_after_publish
						$item->php_after_publish = base64_decode($item->php_after_publish);
						// decode php_after_delete
						$item->php_after_delete = base64_decode($item->php_after_delete);
						// decode php_import
						$item->php_import = base64_decode($item->php_import);
						// decode php_import_ext
						$item->php_import_ext = base64_decode($item->php_import_ext);
						// decode css_view
						$item->css_view = base64_decode($item->css_view);
						// decode css_views
						$item->css_views = base64_decode($item->css_views);
						// decode javascript_view_file
						$item->javascript_view_file = base64_decode($item->javascript_view_file);
						// decode javascript_view_footer
						$item->javascript_view_footer = base64_decode($item->javascript_view_footer);
						// decode javascript_views_file
						$item->javascript_views_file = base64_decode($item->javascript_views_file);
						// decode javascript_views_footer
						$item->javascript_views_footer = base64_decode($item->javascript_views_footer);
						// decode php_controller
						$item->php_controller = base64_decode($item->php_controller);
						// decode php_model
						$item->php_model = base64_decode($item->php_model);
						// decode php_controller_list
						$item->php_controller_list = base64_decode($item->php_controller_list);
						// decode php_model_list
						$item->php_model_list = base64_decode($item->php_model_list);
						// decode php_ajaxmethod
						$item->php_ajaxmethod = base64_decode($item->php_ajaxmethod);
						// decode php_getitem
						$item->php_getitem = base64_decode($item->php_getitem);
						// decode html_import_view
						$item->html_import_view = base64_decode($item->html_import_view);
						// decode php_import_headers
						$item->php_import_headers = base64_decode($item->php_import_headers);
						// decode php_getitems
						$item->php_getitems = base64_decode($item->php_getitems);
						// decode php_import_save
						$item->php_import_save = base64_decode($item->php_import_save);
						// decode php_getitems_after_all
						$item->php_getitems_after_all = base64_decode($item->php_getitems_after_all);
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
		$columns = $db->getTableColumns("#__componentbuilder_admin_view");
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
		$id .= ':' . $this->getState('filter.name_single');
		$id .= ':' . $this->getState('filter.short_description');
		$id .= ':' . $this->getState('filter.add_fadein');
		$id .= ':' . $this->getState('filter.type');
		$id .= ':' . $this->getState('filter.add_custom_button');
		$id .= ':' . $this->getState('filter.add_php_ajax');
		$id .= ':' . $this->getState('filter.add_custom_import');

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
			$query->from($db->quoteName('#__componentbuilder_admin_view'));
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
				$query->update($db->quoteName('#__componentbuilder_admin_view'))->set($fields)->where($conditions); 

				$db->setQuery($query);

				$db->execute();
			}
		}

		return false;
	}
}
