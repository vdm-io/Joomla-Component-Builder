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

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\MVC\Model\ListModel;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\Utilities\ArrayHelper;
use Joomla\CMS\Helper\TagsHelper;
use VDM\Joomla\Utilities\ArrayHelper as UtilitiesArrayHelper;
use VDM\Joomla\Utilities\ObjectHelper;
use VDM\Joomla\Utilities\StringHelper;

/**
 * Repositories List Model
 */
class ComponentbuilderModelRepositories extends ListModel
{
	public function __construct($config = [])
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
				'a.organisation','organisation',
				'a.repository','repository',
				'a.target','target',
				'a.base','base',
				'a.type','type'
			);
		}

		parent::__construct($config);
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
		$app = Factory::getApplication();

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

		$organisation = $this->getUserStateFromRequest($this->context . '.filter.organisation', 'filter_organisation');
		if ($formSubmited)
		{
			$organisation = $app->input->post->get('organisation');
			$this->setState('filter.organisation', $organisation);
		}

		$repository = $this->getUserStateFromRequest($this->context . '.filter.repository', 'filter_repository');
		if ($formSubmited)
		{
			$repository = $app->input->post->get('repository');
			$this->setState('filter.repository', $repository);
		}

		$target = $this->getUserStateFromRequest($this->context . '.filter.target', 'filter_target');
		if ($formSubmited)
		{
			$target = $app->input->post->get('target');
			$this->setState('filter.target', $target);
		}

		$base = $this->getUserStateFromRequest($this->context . '.filter.base', 'filter_base');
		if ($formSubmited)
		{
			$base = $app->input->post->get('base');
			$this->setState('filter.base', $base);
		}

		$type = $this->getUserStateFromRequest($this->context . '.filter.type', 'filter_type');
		if ($formSubmited)
		{
			$type = $app->input->post->get('type');
			$this->setState('filter.type', $type);
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
		if (UtilitiesArrayHelper::check($items))
		{
			// Get the user object if not set.
			if (!isset($user) || !ObjectHelper::check($user))
			{
				$user = Factory::getUser();
			}
			foreach ($items as $nr => &$item)
			{
				// Remove items the user can't access.
				$access = ($user->authorise('repository.access', 'com_componentbuilder.repository.' . (int) $item->id) && $user->authorise('repository.access', 'com_componentbuilder'));
				if (!$access)
				{
					unset($items[$nr]);
					continue;
				}

			}
		}

		// set selection value to a translatable value
		if (UtilitiesArrayHelper::check($items))
		{
			foreach ($items as $nr => &$item)
			{
				// convert target
				$item->target = $this->selectionTranslation($item->target, 'target');
				// convert type
				$item->type = $this->selectionTranslation($item->type, 'type');
			}
		}


		// return items
		return $items;
	}

	/**
	 * Method to convert selection values to translatable string.
	 *
	 * @return  string   The translatable string.
	 */
	public function selectionTranslation($value,$name)
	{
		// Array of target language strings
		if ($name === 'target')
		{
			$targetArray = array(
				0 => 'COM_COMPONENTBUILDER_REPOSITORY_SELECT_AN_OPTION',
				1 => 'COM_COMPONENTBUILDER_REPOSITORY_SUPER_POWER',
				2 => 'COM_COMPONENTBUILDER_REPOSITORY_JOOMLA_POWER',
				3 => 'COM_COMPONENTBUILDER_REPOSITORY_JOOMLA_FIELD_TYPES'
			);
			// Now check if value is found in this array
			if (isset($targetArray[$value]) && StringHelper::check($targetArray[$value]))
			{
				return $targetArray[$value];
			}
		}
		// Array of type language strings
		if ($name === 'type')
		{
			$typeArray = array(
				0 => 'COM_COMPONENTBUILDER_REPOSITORY_SELECT_AN_OPTION',
				1 => 'COM_COMPONENTBUILDER_REPOSITORY_GITEA'
			);
			// Now check if value is found in this array
			if (isset($typeArray[$value]) && StringHelper::check($typeArray[$value]))
			{
				return $typeArray[$value];
			}
		}
		return $value;
	}

	/**
	 * Method to build an SQL query to load the list data.
	 *
	 * @return    string    An SQL query
	 */
	protected function getListQuery()
	{
		// Get the user object.
		$user = Factory::getUser();
		// Create a new query object.
		$db = Factory::getDBO();
		$query = $db->getQuery(true);

		// Select some fields
		$query->select('a.*');

		// From the componentbuilder_item table
		$query->from($db->quoteName('#__componentbuilder_repository', 'a'));

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
		elseif (UtilitiesArrayHelper::check($_access))
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
				$query->where('(a.organisation LIKE '.$search.' OR a.repository LIKE '.$search.' OR a.target LIKE '.$search.' OR a.type LIKE '.$search.' OR a.base LIKE '.$search.' OR a.guid LIKE '.$search.' OR a.username LIKE '.$search.')');
			}
		}

		// Filter by Organisation.
		$_organisation = $this->getState('filter.organisation');
		if (is_numeric($_organisation))
		{
			if (is_float($_organisation))
			{
				$query->where('a.organisation = ' . (float) $_organisation);
			}
			else
			{
				$query->where('a.organisation = ' . (int) $_organisation);
			}
		}
		elseif (StringHelper::check($_organisation))
		{
			$query->where('a.organisation = ' . $db->quote($db->escape($_organisation)));
		}
		// Filter by Repository.
		$_repository = $this->getState('filter.repository');
		if (is_numeric($_repository))
		{
			if (is_float($_repository))
			{
				$query->where('a.repository = ' . (float) $_repository);
			}
			else
			{
				$query->where('a.repository = ' . (int) $_repository);
			}
		}
		elseif (StringHelper::check($_repository))
		{
			$query->where('a.repository = ' . $db->quote($db->escape($_repository)));
		}
		// Filter by Target.
		$_target = $this->getState('filter.target');
		if (is_numeric($_target))
		{
			if (is_float($_target))
			{
				$query->where('a.target = ' . (float) $_target);
			}
			else
			{
				$query->where('a.target = ' . (int) $_target);
			}
		}
		elseif (StringHelper::check($_target))
		{
			$query->where('a.target = ' . $db->quote($db->escape($_target)));
		}
		// Filter by Base.
		$_base = $this->getState('filter.base');
		if (is_numeric($_base))
		{
			if (is_float($_base))
			{
				$query->where('a.base = ' . (float) $_base);
			}
			else
			{
				$query->where('a.base = ' . (int) $_base);
			}
		}
		elseif (StringHelper::check($_base))
		{
			$query->where('a.base = ' . $db->quote($db->escape($_base)));
		}

		// Add the list ordering clause.
		$orderCol = $this->getState('list.ordering', 'a.id');
		$orderDirn = $this->getState('list.direction', 'desc');
		if ($orderCol != '')
		{
			// Check that the order direction is valid encase we have a field called direction as part of filers.
			$orderDirn = (is_string($orderDirn) && in_array(strtolower($orderDirn), ['asc', 'desc'])) ? $orderDirn : 'desc';
			$query->order($db->escape($orderCol . ' ' . $orderDirn));
		}

		return $query;
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
		if (UtilitiesArrayHelper::check($_access))
		{
			$id .= ':' . implode(':', $_access);
		}
		// Check if this is only an number or string
		elseif (is_numeric($_access)
		 || StringHelper::check($_access))
		{
			$id .= ':' . $_access;
		}
		$id .= ':' . $this->getState('filter.ordering');
		$id .= ':' . $this->getState('filter.created_by');
		$id .= ':' . $this->getState('filter.modified_by');
		$id .= ':' . $this->getState('filter.organisation');
		$id .= ':' . $this->getState('filter.repository');
		$id .= ':' . $this->getState('filter.target');
		$id .= ':' . $this->getState('filter.base');
		$id .= ':' . $this->getState('filter.type');

		return parent::getStoreId($id);
	}

	/**
	 * Build an SQL query to checkin all items left checked out longer then a set time.
	 *
	 * @return bool
	 * @since 3.2.0
	 */
	protected function checkInNow(): bool
	{
		// Get set check in time
		$time = ComponentHelper::getParams('com_componentbuilder')->get('check_in');

		if ($time)
		{
			// Get a db connection.
			$db = Factory::getDbo();
			// Reset query.
			$query = $db->getQuery(true);
			$query->select('*');
			$query->from($db->quoteName('#__componentbuilder_repository'));
			// Only select items that are checked out.
			$query->where($db->quoteName('checked_out') . '!=0');
			$db->setQuery($query, 0, 1);
			$db->execute();
			if ($db->getNumRows())
			{
				// Get Yesterdays date.
				$date = Factory::getDate()->modify($time)->toSql();
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
				$query->update($db->quoteName('#__componentbuilder_repository'))->set($fields)->where($conditions); 

				$db->setQuery($query);

				return $db->execute();
			}
		}

		return false;
	}
}
