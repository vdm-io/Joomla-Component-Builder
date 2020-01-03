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
 * Custom_admin_views Model
 */
class ComponentbuilderModelCustom_admin_views extends JModelList
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
				'a.name','name',
				'a.description','description',
				'a.main_get','main_get',
				'a.add_php_ajax','add_php_ajax',
				'a.add_custom_button','add_custom_button'
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

		$name = $this->getUserStateFromRequest($this->context . '.filter.name', 'filter_name');
		$this->setState('filter.name', $name);

		$description = $this->getUserStateFromRequest($this->context . '.filter.description', 'filter_description');
		$this->setState('filter.description', $description);

		$main_get = $this->getUserStateFromRequest($this->context . '.filter.main_get', 'filter_main_get');
		$this->setState('filter.main_get', $main_get);

		$add_php_ajax = $this->getUserStateFromRequest($this->context . '.filter.add_php_ajax', 'filter_add_php_ajax');
		$this->setState('filter.add_php_ajax', $add_php_ajax);

		$add_custom_button = $this->getUserStateFromRequest($this->context . '.filter.add_custom_button', 'filter_add_custom_button');
		$this->setState('filter.add_custom_button', $add_custom_button);
        
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
				$access = ($user->authorise('custom_admin_view.access', 'com_componentbuilder.custom_admin_view.' . (int) $item->id) && $user->authorise('custom_admin_view.access', 'com_componentbuilder'));
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
				// convert add_php_ajax
				$item->add_php_ajax = $this->selectionTranslation($item->add_php_ajax, 'add_php_ajax');
				// convert add_custom_button
				$item->add_custom_button = $this->selectionTranslation($item->add_custom_button, 'add_custom_button');
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
		// Array of add_php_ajax language strings
		if ($name === 'add_php_ajax')
		{
			$add_php_ajaxArray = array(
				1 => 'COM_COMPONENTBUILDER_CUSTOM_ADMIN_VIEW_YES',
				0 => 'COM_COMPONENTBUILDER_CUSTOM_ADMIN_VIEW_NO'
			);
			// Now check if value is found in this array
			if (isset($add_php_ajaxArray[$value]) && ComponentbuilderHelper::checkString($add_php_ajaxArray[$value]))
			{
				return $add_php_ajaxArray[$value];
			}
		}
		// Array of add_custom_button language strings
		if ($name === 'add_custom_button')
		{
			$add_custom_buttonArray = array(
				1 => 'COM_COMPONENTBUILDER_CUSTOM_ADMIN_VIEW_YES',
				0 => 'COM_COMPONENTBUILDER_CUSTOM_ADMIN_VIEW_NO'
			);
			// Now check if value is found in this array
			if (isset($add_custom_buttonArray[$value]) && ComponentbuilderHelper::checkString($add_custom_buttonArray[$value]))
			{
				return $add_custom_buttonArray[$value];
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
		$query->from($db->quoteName('#__componentbuilder_custom_admin_view', 'a'));

		// From the componentbuilder_dynamic_get table.
		$query->select($db->quoteName('g.name','main_get_name'));
		$query->join('LEFT', $db->quoteName('#__componentbuilder_dynamic_get', 'g') . ' ON (' . $db->quoteName('a.main_get') . ' = ' . $db->quoteName('g.id') . ')');

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
				$query->where('(a.system_name LIKE '.$search.' OR a.name LIKE '.$search.' OR a.description LIKE '.$search.' OR a.main_get LIKE '.$search.' OR g.name LIKE '.$search.' OR a.codename LIKE '.$search.' OR a.context LIKE '.$search.')');
			}
		}

		// Filter by main_get.
		if ($main_get = $this->getState('filter.main_get'))
		{
			$query->where('a.main_get = ' . $db->quote($db->escape($main_get)));
		}
		// Filter by Add_php_ajax.
		if ($add_php_ajax = $this->getState('filter.add_php_ajax'))
		{
			$query->where('a.add_php_ajax = ' . $db->quote($db->escape($add_php_ajax)));
		}
		// Filter by Add_custom_button.
		if ($add_custom_button = $this->getState('filter.add_custom_button'))
		{
			$query->where('a.add_custom_button = ' . $db->quote($db->escape($add_custom_button)));
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

			// From the componentbuilder_custom_admin_view table
			$query->from($db->quoteName('#__componentbuilder_custom_admin_view', 'a'));
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
						$access = ($user->authorise('custom_admin_view.access', 'com_componentbuilder.custom_admin_view.' . (int) $item->id) && $user->authorise('custom_admin_view.access', 'com_componentbuilder'));
						if (!$access)
						{
							unset($items[$nr]);
							continue;
						}

						// decode css_document
						$item->css_document = base64_decode($item->css_document);
						// decode css
						$item->css = base64_decode($item->css);
						// decode js_document
						$item->js_document = base64_decode($item->js_document);
						// decode javascript_file
						$item->javascript_file = base64_decode($item->javascript_file);
						// decode default
						$item->default = base64_decode($item->default);
						// decode php_ajaxmethod
						$item->php_ajaxmethod = base64_decode($item->php_ajaxmethod);
						// decode php_document
						$item->php_document = base64_decode($item->php_document);
						// decode php_view
						$item->php_view = base64_decode($item->php_view);
						// decode php_jview_display
						$item->php_jview_display = base64_decode($item->php_jview_display);
						// decode php_jview
						$item->php_jview = base64_decode($item->php_jview);
						// decode php_controller
						$item->php_controller = base64_decode($item->php_controller);
						// decode php_model
						$item->php_model = base64_decode($item->php_model);
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
		$columns = $db->getTableColumns("#__componentbuilder_custom_admin_view");
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
		$id .= ':' . $this->getState('filter.name');
		$id .= ':' . $this->getState('filter.description');
		$id .= ':' . $this->getState('filter.main_get');
		$id .= ':' . $this->getState('filter.add_php_ajax');
		$id .= ':' . $this->getState('filter.add_custom_button');

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
			$query->from($db->quoteName('#__componentbuilder_custom_admin_view'));
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
				$query->update($db->quoteName('#__componentbuilder_custom_admin_view'))->set($fields)->where($conditions); 

				$db->setQuery($query);

				$db->execute();
			}
		}

		return false;
	}
}
