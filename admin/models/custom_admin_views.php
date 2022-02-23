<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <http://www.joomlacomponentbuilder.com>
 * @gitea      Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @github     Joomla Component Builder <https://github.com/vdm-io/Joomla-Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

use Joomla\Utilities\ArrayHelper;

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
				'a.access','access',
				'a.ordering','ordering',
				'a.created_by','created_by',
				'a.modified_by','modified_by',
				'g.name','main_get',
				'a.add_php_ajax','add_php_ajax',
				'a.add_custom_button','add_custom_button',
				'a.system_name','system_name',
				'a.name','name',
				'a.description','description'
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

		// Create the "joomla_component" filter
		$attributes = array(
			'name' => 'joomla_component',
			'type' => 'list',
			'onchange' => 'this.form.submit();',
		);
		$options = array(
			'' => '-  ' . JText::_('COM_COMPONENTBUILDER_NO_COMPONENTS_FOUND') . '  -'
		);
		// check if we have joomla components
		if (($joomla_components = ComponentbuilderHelper::getByTypeTheIdsSystemNames('joomla_component')) !== false)
		{
			$options = array(
				'' => '-  ' . JText::_('COM_COMPONENTBUILDER_SELECT_COMPONENT') . '  -'
			);
			// make sure we do not lose the key values in normal merge
			$options = $options + $joomla_components;
		}

		$form->setField(ComponentbuilderHelper::getFieldXML($attributes, $options),'filter');
		$form->setValue(
			'joomla_component',
			'filter',
			$this->state->get("filter.joomla_component")
		);
		array_push($this->filter_fields, 'joomla_component');

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

		$main_get = $this->getUserStateFromRequest($this->context . '.filter.main_get', 'filter_main_get');
		if ($formSubmited)
		{
			$main_get = $app->input->post->get('main_get');
			$this->setState('filter.main_get', $main_get);
		}

		$add_php_ajax = $this->getUserStateFromRequest($this->context . '.filter.add_php_ajax', 'filter_add_php_ajax');
		if ($formSubmited)
		{
			$add_php_ajax = $app->input->post->get('add_php_ajax');
			$this->setState('filter.add_php_ajax', $add_php_ajax);
		}

		$add_custom_button = $this->getUserStateFromRequest($this->context . '.filter.add_custom_button', 'filter_add_custom_button');
		if ($formSubmited)
		{
			$add_custom_button = $app->input->post->get('add_custom_button');
			$this->setState('filter.add_custom_button', $add_custom_button);
		}

		$system_name = $this->getUserStateFromRequest($this->context . '.filter.system_name', 'filter_system_name');
		if ($formSubmited)
		{
			$system_name = $app->input->post->get('system_name');
			$this->setState('filter.system_name', $system_name);
		}

		$name = $this->getUserStateFromRequest($this->context . '.filter.name', 'filter_name');
		if ($formSubmited)
		{
			$name = $app->input->post->get('name');
			$this->setState('filter.name', $name);
		}

		$description = $this->getUserStateFromRequest($this->context . '.filter.description', 'filter_description');
		if ($formSubmited)
		{
			$description = $app->input->post->get('description');
			$this->setState('filter.description', $description);
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

		// do not use these filters in the export method
		if (!isset($_export) || !$_export)
		{
			// Filtering "joomla components"
			$filter_joomla_component = $this->state->get("filter.joomla_component");
			if ($filter_joomla_component !== null && !empty($filter_joomla_component))
			{
				if (($ids = ComponentbuilderHelper::getAreaLinkedIDs($filter_joomla_component, 'joomla_component_custom_admin_views')) !== false)
				{
					$query->where($db->quoteName('a.id') . ' IN (' . implode(',', $ids) . ')');
				}
				else
				{
					// there is none
					$query->where($db->quoteName('a.id') . ' = ' . 0);
				}
			}
		}

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
				$query->where('(a.system_name LIKE '.$search.' OR a.name LIKE '.$search.' OR a.description LIKE '.$search.' OR a.main_get LIKE '.$search.' OR g.name LIKE '.$search.' OR a.codename LIKE '.$search.' OR a.context LIKE '.$search.')');
			}
		}

		// Filter by Main_get.
		$_main_get = $this->getState('filter.main_get');
		if (is_numeric($_main_get))
		{
			if (is_float($_main_get))
			{
				$query->where('a.main_get = ' . (float) $_main_get);
			}
			else
			{
				$query->where('a.main_get = ' . (int) $_main_get);
			}
		}
		elseif (ComponentbuilderHelper::checkString($_main_get))
		{
			$query->where('a.main_get = ' . $db->quote($db->escape($_main_get)));
		}
		elseif (ComponentbuilderHelper::checkArray($_main_get))
		{
			// Secure the array for the query
			$_main_get = array_map( function ($val) use(&$db) {
				if (is_numeric($val))
				{
					if (is_float($val))
					{
						return (float) $val;
					}
					else
					{
						return (int) $val;
					}
				}
				elseif (ComponentbuilderHelper::checkString($val))
				{
					return $db->quote($db->escape($val));
				}
			}, $_main_get);
			// Filter by the Main_get Array.
			$query->where('a.main_get IN (' . implode(',', $_main_get) . ')');
		}
		// Filter by Add_php_ajax.
		$_add_php_ajax = $this->getState('filter.add_php_ajax');
		if (is_numeric($_add_php_ajax))
		{
			if (is_float($_add_php_ajax))
			{
				$query->where('a.add_php_ajax = ' . (float) $_add_php_ajax);
			}
			else
			{
				$query->where('a.add_php_ajax = ' . (int) $_add_php_ajax);
			}
		}
		elseif (ComponentbuilderHelper::checkString($_add_php_ajax))
		{
			$query->where('a.add_php_ajax = ' . $db->quote($db->escape($_add_php_ajax)));
		}
		// Filter by Add_custom_button.
		$_add_custom_button = $this->getState('filter.add_custom_button');
		if (is_numeric($_add_custom_button))
		{
			if (is_float($_add_custom_button))
			{
				$query->where('a.add_custom_button = ' . (float) $_add_custom_button);
			}
			else
			{
				$query->where('a.add_custom_button = ' . (int) $_add_custom_button);
			}
		}
		elseif (ComponentbuilderHelper::checkString($_add_custom_button))
		{
			$query->where('a.add_custom_button = ' . $db->quote($db->escape($_add_custom_button)));
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

			// From the componentbuilder_custom_admin_view table
			$query->from($db->quoteName('#__componentbuilder_custom_admin_view', 'a'));
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
			// Filtering "joomla components"
			$filter_joomla_component = $this->state->get("filter.joomla_component");
			if ($filter_joomla_component !== null && !empty($filter_joomla_component))
			{
				if (($ids = ComponentbuilderHelper::getAreaLinkedIDs($filter_joomla_component, 'joomla_component_custom_admin_views')) !== false)
				{
					$query->where($db->quoteName('a.id') . ' IN (' . implode(',', $ids) . ')');
				}
				else
				{
					// there is none
					$query->where($db->quoteName('a.id') . ' = ' . 0);
				}
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
		// Check if the value is an array
		$_main_get = $this->getState('filter.main_get');
		if (ComponentbuilderHelper::checkArray($_main_get))
		{
			$id .= ':' . implode(':', $_main_get);
		}
		// Check if this is only an number or string
		elseif (is_numeric($_main_get)
		 || ComponentbuilderHelper::checkString($_main_get))
		{
			$id .= ':' . $_main_get;
		}
		$id .= ':' . $this->getState('filter.add_php_ajax');
		$id .= ':' . $this->getState('filter.add_custom_button');
		$id .= ':' . $this->getState('filter.system_name');
		$id .= ':' . $this->getState('filter.name');
		$id .= ':' . $this->getState('filter.description');

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
			$query->from($db->quoteName('#__componentbuilder_custom_admin_view'));
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
				$query->update($db->quoteName('#__componentbuilder_custom_admin_view'))->set($fields)->where($conditions); 

				$db->setQuery($query);

				$db->execute();
			}
		}

		return false;
	}
}
