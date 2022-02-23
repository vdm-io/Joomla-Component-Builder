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
				'a.access','access',
				'a.ordering','ordering',
				'a.created_by','created_by',
				'a.modified_by','modified_by',
				'a.add_fadein','add_fadein',
				'a.type','type',
				'a.add_custom_button','add_custom_button',
				'a.add_php_ajax','add_php_ajax',
				'a.add_custom_import','add_custom_import',
				'a.system_name','system_name',
				'a.name_single','name_single',
				'a.short_description','short_description'
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

		$add_fadein = $this->getUserStateFromRequest($this->context . '.filter.add_fadein', 'filter_add_fadein');
		if ($formSubmited)
		{
			$add_fadein = $app->input->post->get('add_fadein');
			$this->setState('filter.add_fadein', $add_fadein);
		}

		$type = $this->getUserStateFromRequest($this->context . '.filter.type', 'filter_type');
		if ($formSubmited)
		{
			$type = $app->input->post->get('type');
			$this->setState('filter.type', $type);
		}

		$add_custom_button = $this->getUserStateFromRequest($this->context . '.filter.add_custom_button', 'filter_add_custom_button');
		if ($formSubmited)
		{
			$add_custom_button = $app->input->post->get('add_custom_button');
			$this->setState('filter.add_custom_button', $add_custom_button);
		}

		$add_php_ajax = $this->getUserStateFromRequest($this->context . '.filter.add_php_ajax', 'filter_add_php_ajax');
		if ($formSubmited)
		{
			$add_php_ajax = $app->input->post->get('add_php_ajax');
			$this->setState('filter.add_php_ajax', $add_php_ajax);
		}

		$add_custom_import = $this->getUserStateFromRequest($this->context . '.filter.add_custom_import', 'filter_add_custom_import');
		if ($formSubmited)
		{
			$add_custom_import = $app->input->post->get('add_custom_import');
			$this->setState('filter.add_custom_import', $add_custom_import);
		}

		$system_name = $this->getUserStateFromRequest($this->context . '.filter.system_name', 'filter_system_name');
		if ($formSubmited)
		{
			$system_name = $app->input->post->get('system_name');
			$this->setState('filter.system_name', $system_name);
		}

		$name_single = $this->getUserStateFromRequest($this->context . '.filter.name_single', 'filter_name_single');
		if ($formSubmited)
		{
			$name_single = $app->input->post->get('name_single');
			$this->setState('filter.name_single', $name_single);
		}

		$short_description = $this->getUserStateFromRequest($this->context . '.filter.short_description', 'filter_short_description');
		if ($formSubmited)
		{
			$short_description = $app->input->post->get('short_description');
			$this->setState('filter.short_description', $short_description);
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

		// do not use these filters in the export method
		if (!isset($_export) || !$_export)
		{
			// Filtering "joomla components"
			$filter_joomla_component = $this->state->get("filter.joomla_component");
			if ($filter_joomla_component !== null && !empty($filter_joomla_component))
			{
				if (($ids = ComponentbuilderHelper::getAreaLinkedIDs($filter_joomla_component, 'joomla_component_admin_views')) !== false)
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
				$query->where('(a.system_name LIKE '.$search.' OR a.name_single LIKE '.$search.' OR a.short_description LIKE '.$search.' OR a.description LIKE '.$search.' OR a.type LIKE '.$search.' OR a.name_list LIKE '.$search.')');
			}
		}

		// Filter by Add_fadein.
		$_add_fadein = $this->getState('filter.add_fadein');
		if (is_numeric($_add_fadein))
		{
			if (is_float($_add_fadein))
			{
				$query->where('a.add_fadein = ' . (float) $_add_fadein);
			}
			else
			{
				$query->where('a.add_fadein = ' . (int) $_add_fadein);
			}
		}
		elseif (ComponentbuilderHelper::checkString($_add_fadein))
		{
			$query->where('a.add_fadein = ' . $db->quote($db->escape($_add_fadein)));
		}
		// Filter by Type.
		$_type = $this->getState('filter.type');
		if (is_numeric($_type))
		{
			if (is_float($_type))
			{
				$query->where('a.type = ' . (float) $_type);
			}
			else
			{
				$query->where('a.type = ' . (int) $_type);
			}
		}
		elseif (ComponentbuilderHelper::checkString($_type))
		{
			$query->where('a.type = ' . $db->quote($db->escape($_type)));
		}
		elseif (ComponentbuilderHelper::checkArray($_type))
		{
			// Secure the array for the query
			$_type = array_map( function ($val) use(&$db) {
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
			}, $_type);
			// Filter by the Type Array.
			$query->where('a.type IN (' . implode(',', $_type) . ')');
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
		// Filter by Add_custom_import.
		$_add_custom_import = $this->getState('filter.add_custom_import');
		if (is_numeric($_add_custom_import))
		{
			if (is_float($_add_custom_import))
			{
				$query->where('a.add_custom_import = ' . (float) $_add_custom_import);
			}
			else
			{
				$query->where('a.add_custom_import = ' . (int) $_add_custom_import);
			}
		}
		elseif (ComponentbuilderHelper::checkString($_add_custom_import))
		{
			$query->where('a.add_custom_import = ' . $db->quote($db->escape($_add_custom_import)));
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

			// From the componentbuilder_admin_view table
			$query->from($db->quoteName('#__componentbuilder_admin_view', 'a'));
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
				if (($ids = ComponentbuilderHelper::getAreaLinkedIDs($filter_joomla_component, 'joomla_component_admin_views')) !== false)
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
						$access = ($user->authorise('admin_view.access', 'com_componentbuilder.admin_view.' . (int) $item->id) && $user->authorise('admin_view.access', 'com_componentbuilder'));
						if (!$access)
						{
							unset($items[$nr]);
							continue;
						}

						// decode php_allowedit
						$item->php_allowedit = base64_decode($item->php_allowedit);
						// decode php_postsavehook
						$item->php_postsavehook = base64_decode($item->php_postsavehook);
						// decode php_before_save
						$item->php_before_save = base64_decode($item->php_before_save);
						// decode php_getlistquery
						$item->php_getlistquery = base64_decode($item->php_getlistquery);
						// decode php_import_ext
						$item->php_import_ext = base64_decode($item->php_import_ext);
						// decode php_after_publish
						$item->php_after_publish = base64_decode($item->php_after_publish);
						// decode php_after_cancel
						$item->php_after_cancel = base64_decode($item->php_after_cancel);
						// decode php_batchmove
						$item->php_batchmove = base64_decode($item->php_batchmove);
						// decode php_after_delete
						$item->php_after_delete = base64_decode($item->php_after_delete);
						// decode php_import
						$item->php_import = base64_decode($item->php_import);
						// decode php_getitems_after_all
						$item->php_getitems_after_all = base64_decode($item->php_getitems_after_all);
						// decode php_getform
						$item->php_getform = base64_decode($item->php_getform);
						// decode php_save
						$item->php_save = base64_decode($item->php_save);
						// decode php_allowadd
						$item->php_allowadd = base64_decode($item->php_allowadd);
						// decode php_before_cancel
						$item->php_before_cancel = base64_decode($item->php_before_cancel);
						// decode php_batchcopy
						$item->php_batchcopy = base64_decode($item->php_batchcopy);
						// decode php_before_publish
						$item->php_before_publish = base64_decode($item->php_before_publish);
						// decode php_before_delete
						$item->php_before_delete = base64_decode($item->php_before_delete);
						// decode php_document
						$item->php_document = base64_decode($item->php_document);
						// decode sql
						$item->sql = base64_decode($item->sql);
						// decode php_import_display
						$item->php_import_display = base64_decode($item->php_import_display);
						// decode php_import_setdata
						$item->php_import_setdata = base64_decode($item->php_import_setdata);
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
						// decode html_import_view
						$item->html_import_view = base64_decode($item->html_import_view);
						// decode php_getitem
						$item->php_getitem = base64_decode($item->php_getitem);
						// decode php_import_headers
						$item->php_import_headers = base64_decode($item->php_import_headers);
						// decode php_import_save
						$item->php_import_save = base64_decode($item->php_import_save);
						// decode php_getitems
						$item->php_getitems = base64_decode($item->php_getitems);
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
		$id .= ':' . $this->getState('filter.add_fadein');
		// Check if the value is an array
		$_type = $this->getState('filter.type');
		if (ComponentbuilderHelper::checkArray($_type))
		{
			$id .= ':' . implode(':', $_type);
		}
		// Check if this is only an number or string
		elseif (is_numeric($_type)
		 || ComponentbuilderHelper::checkString($_type))
		{
			$id .= ':' . $_type;
		}
		$id .= ':' . $this->getState('filter.add_custom_button');
		$id .= ':' . $this->getState('filter.add_php_ajax');
		$id .= ':' . $this->getState('filter.add_custom_import');
		$id .= ':' . $this->getState('filter.system_name');
		$id .= ':' . $this->getState('filter.name_single');
		$id .= ':' . $this->getState('filter.short_description');

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
			$query->from($db->quoteName('#__componentbuilder_admin_view'));
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
				$query->update($db->quoteName('#__componentbuilder_admin_view'))->set($fields)->where($conditions); 

				$db->setQuery($query);

				$db->execute();
			}
		}

		return false;
	}
}
