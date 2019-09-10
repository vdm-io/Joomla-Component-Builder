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
 * Custom_codes Model
 */
class ComponentbuilderModelCustom_codes extends JModelList
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
				'a.component','component',
				'a.path','path',
				'a.target','target',
				'a.type','type',
				'a.comment_type','comment_type'
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
		$component = $this->getUserStateFromRequest($this->context . '.filter.component', 'filter_component');
		$this->setState('filter.component', $component);

		$path = $this->getUserStateFromRequest($this->context . '.filter.path', 'filter_path');
		$this->setState('filter.path', $path);

		$target = $this->getUserStateFromRequest($this->context . '.filter.target', 'filter_target');
		$this->setState('filter.target', $target);

		$type = $this->getUserStateFromRequest($this->context . '.filter.type', 'filter_type');
		$this->setState('filter.type', $type);

		$comment_type = $this->getUserStateFromRequest($this->context . '.filter.comment_type', 'filter_comment_type');
		$this->setState('filter.comment_type', $comment_type);
        
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
				$access = ($user->authorise('custom_code.access', 'com_componentbuilder.custom_code.' . (int) $item->id) && $user->authorise('custom_code.access', 'com_componentbuilder'));
				if (!$access)
				{
					unset($items[$nr]);
					continue;
				}

			}
		}

		if (ComponentbuilderHelper::checkArray($items) && !isset($_export))
		{
			foreach ($items as $nr => &$item) 
			{
				if ($item->target == 2)
				{
					$item->component_system_name = $item->system_name;
					$item->path = '[CUSTO'.'MCODE='.$item->id.']'; // so it is not detected
					if (ComponentbuilderHelper::checkString($item->function_name))
					{
						$item->path =  '[CUSTO'.'MCODE='.$item->function_name.']'; // so it is not detected
					}
					$item->type = 2;
				}
			}
		}

		// set selection value to a translatable value
		if (ComponentbuilderHelper::checkArray($items))
		{
			foreach ($items as $nr => &$item)
			{
				// convert target
				$item->target = $this->selectionTranslation($item->target, 'target');
				// convert type
				$item->type = $this->selectionTranslation($item->type, 'type');
				// convert comment_type
				$item->comment_type = $this->selectionTranslation($item->comment_type, 'comment_type');
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
		// Array of target language strings
		if ($name === 'target')
		{
			$targetArray = array(
				2 => 'COM_COMPONENTBUILDER_CUSTOM_CODE_JCB_MANUAL',
				1 => 'COM_COMPONENTBUILDER_CUSTOM_CODE_HASH_AUTOMATION'
			);
			// Now check if value is found in this array
			if (isset($targetArray[$value]) && ComponentbuilderHelper::checkString($targetArray[$value]))
			{
				return $targetArray[$value];
			}
		}
		// Array of type language strings
		if ($name === 'type')
		{
			$typeArray = array(
				1 => 'COM_COMPONENTBUILDER_CUSTOM_CODE_REPLACEMENT',
				2 => 'COM_COMPONENTBUILDER_CUSTOM_CODE_INSERTION'
			);
			// Now check if value is found in this array
			if (isset($typeArray[$value]) && ComponentbuilderHelper::checkString($typeArray[$value]))
			{
				return $typeArray[$value];
			}
		}
		// Array of comment_type language strings
		if ($name === 'comment_type')
		{
			$comment_typeArray = array(
				1 => 'COM_COMPONENTBUILDER_CUSTOM_CODE_PHPJS',
				2 => 'COM_COMPONENTBUILDER_CUSTOM_CODE_HTML'
			);
			// Now check if value is found in this array
			if (isset($comment_typeArray[$value]) && ComponentbuilderHelper::checkString($comment_typeArray[$value]))
			{
				return $comment_typeArray[$value];
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
		$query->from($db->quoteName('#__componentbuilder_custom_code', 'a'));

		// From the componentbuilder_joomla_component table.
		$query->select($db->quoteName('g.system_name','component_system_name'));
		$query->join('LEFT', $db->quoteName('#__componentbuilder_joomla_component', 'g') . ' ON (' . $db->quoteName('a.component') . ' = ' . $db->quoteName('g.id') . ')');

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
				$query->where('(a.component LIKE '.$search.' OR g.system_name LIKE '.$search.' OR a.path LIKE '.$search.' OR a.comment_type LIKE '.$search.' OR a.function_name LIKE '.$search.' OR a.system_name LIKE '.$search.')');
			}
		}

		// Filter by component.
		if ($component = $this->getState('filter.component'))
		{
			$query->where('a.component = ' . $db->quote($db->escape($component)));
		}
		// Filter by Target.
		if ($target = $this->getState('filter.target'))
		{
			$query->where('a.target = ' . $db->quote($db->escape($target)));
		}
		// Filter by Type.
		if ($type = $this->getState('filter.type'))
		{
			$query->where('a.type = ' . $db->quote($db->escape($type)));
		}
		// Filter by Comment_type.
		if ($comment_type = $this->getState('filter.comment_type'))
		{
			$query->where('a.comment_type = ' . $db->quote($db->escape($comment_type)));
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

			// From the componentbuilder_custom_code table
			$query->from($db->quoteName('#__componentbuilder_custom_code', 'a'));
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
						$access = ($user->authorise('custom_code.access', 'com_componentbuilder.custom_code.' . (int) $item->id) && $user->authorise('custom_code.access', 'com_componentbuilder'));
						if (!$access)
						{
							unset($items[$nr]);
							continue;
						}

						// decode code
						$item->code = base64_decode($item->code);
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

				if (ComponentbuilderHelper::checkArray($items) && !isset($_export))
		{
			foreach ($items as $nr => &$item) 
			{
				if ($item->target == 2)
				{
					$item->component_system_name = $item->system_name;
					$item->path = '[CUSTO'.'MCODE='.$item->id.']'; // so it is not detected
					if (ComponentbuilderHelper::checkString($item->function_name))
					{
						$item->path =  '[CUSTO'.'MCODE='.$item->function_name.']'; // so it is not detected
					}
					$item->type = 2;
				}
			}
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
		$columns = $db->getTableColumns("#__componentbuilder_custom_code");
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
		$id .= ':' . $this->getState('filter.component');
		$id .= ':' . $this->getState('filter.path');
		$id .= ':' . $this->getState('filter.target');
		$id .= ':' . $this->getState('filter.type');
		$id .= ':' . $this->getState('filter.comment_type');

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
			$query->from($db->quoteName('#__componentbuilder_custom_code'));
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
				$query->update($db->quoteName('#__componentbuilder_custom_code'))->set($fields)->where($conditions); 

				$db->setQuery($query);

				$db->execute();
			}
		}

		return false;
	}
}
