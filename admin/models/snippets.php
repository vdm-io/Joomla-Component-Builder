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
use Joomla\CMS\Filesystem\Folder;
use Joomla\CMS\Filesystem\File;

/**
 * Snippets List Model
 */
class ComponentbuilderModelSnippets extends ListModel
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
				'g.name','type',
				'h.name','library',
				'a.name','name',
				'a.url','url',
				'a.heading','heading'
			);
		}

		parent::__construct($config);
	}

	public $user;
	public $zipPath;

	/**
	*	Method to build the export package
	*
	*	@return bool on success.
	*/
	public function shareSnippets($pks)
	{
		// setup the query
		if (UtilitiesArrayHelper::check($pks))
		{
			// Get the user object.
			if (!ObjectHelper::check($this->user))
			{
				$this->user = Factory::getUser();
			}
			// Create a new query object.
			if (!ObjectHelper::check($this->_db))
			{
				$this->_db = Factory::getDBO();
			}
			$query = $this->_db->getQuery(true);

			// Select some fields
			$query->select($this->_db->quoteName(
				array('a.name','a.heading','a.description','a.usage','a.snippet','a.url','b.name','c.name','a.created','a.modified','a.contributor_company','a.contributor_name','a.contributor_email','a.contributor_website'),
				array('name','heading','description','usage','snippet','url','type','library','created','modified','contributor_company','contributor_name','contributor_email','contributor_website')
			));
			
			// From the componentbuilder_snippet table
			$query->from($this->_db->quoteName('#__componentbuilder_snippet', 'a'));
			// From the componentbuilder_snippet_type table.
			$query->join('LEFT', $this->_db->quoteName('#__componentbuilder_snippet_type', 'b') . ' ON (' . $this->_db->quoteName('a.type') . ' = ' . $this->_db->quoteName('b.id') . ')');
			// From the componentbuilder_library table.
			$query->join('LEFT', $this->_db->quoteName('#__componentbuilder_library', 'c') . ' ON (' . $this->_db->quoteName('a.library') . ' = ' . $this->_db->quoteName('c.id') . ')');
			$query->where('a.id IN (' . implode(',',$pks) . ')');
			
			// Implement View Level Access
			if (!$this->user->authorise('core.options', 'com_componentbuilder'))
			{
				$groups = implode(',', $this->user->getAuthorisedViewLevels());
				$query->where('a.access IN (' . $groups . ')');
			}

			// Order the results by ordering
			$query->order('a.ordering  ASC');

			// Load the items
			$this->_db->setQuery($query);
			$this->_db->execute();
			if ($this->_db->getNumRows())
			{
				// load the items from db
				$items = $this->_db->loadObjectList();
				// check if we have items
				if (UtilitiesArrayHelper::check($items))
				{
					// get the shared paths
					$this->fullPath = rtrim(ComponentbuilderHelper::getFolderPath('path', 'sharepath', Factory::getConfig()->get('tmp_path')), '/') . '/snippets';
					// remove old folder with the same name
					if (is_dir($this->fullPath))
					{
						// remove if old folder is found
						ComponentbuilderHelper::removeFolder($this->fullPath);
					}
					// create the full path
					Folder::create($this->fullPath);
					// set zip path
					$this->zipPath = $this->fullPath .'.zip';
					// remove old zip files with the same name
					if (is_file($this->zipPath))
					{
						// remove file if found
						File::delete($this->zipPath);
					}
					// prep the item
					foreach($items as $item)
					{
						// just unlock the snippet
						$item->snippet = base64_decode($item->snippet);
						// build filename
						$fileName = StringHelper::safe($item->library . ' - (' . $item->type . ') ' . $item->name, 'filename', '', false) . '.json';
						// if the snippet has its own contributor details set, then do not change
						if (!strlen($item->contributor_company) || !strlen($item->contributor_name) || !strlen($item->contributor_email) || !strlen($item->contributor_website))
						{
							// load the correct contributor details to each snippet (this is very slow)
							$_contributor = ComponentbuilderHelper::getContributorDetails($fileName);
							$item->contributor_company = $_contributor['contributor_company'];
							$item->contributor_name = $_contributor['contributor_name'];
							$item->contributor_email = $_contributor['contributor_email'];
							$item->contributor_website = $_contributor['contributor_website'];
						}
						// now store the snippet info
						ComponentbuilderHelper::writeFile($this->fullPath . '/' . $fileName, json_encode($item, JSON_PRETTY_PRINT));
					}
					// zip the folder
					if (!ComponentbuilderHelper::zip($this->fullPath, $this->zipPath))
					{
						return false;
					}
					// remove the folder
					if (!ComponentbuilderHelper::removeFolder($this->fullPath))
					{
						return false;
					}
					return true;
				}
			}
		}
		return false;
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

		$type = $this->getUserStateFromRequest($this->context . '.filter.type', 'filter_type');
		if ($formSubmited)
		{
			$type = $app->input->post->get('type');
			$this->setState('filter.type', $type);
		}

		$library = $this->getUserStateFromRequest($this->context . '.filter.library', 'filter_library');
		if ($formSubmited)
		{
			$library = $app->input->post->get('library');
			$this->setState('filter.library', $library);
		}

		$name = $this->getUserStateFromRequest($this->context . '.filter.name', 'filter_name');
		if ($formSubmited)
		{
			$name = $app->input->post->get('name');
			$this->setState('filter.name', $name);
		}

		$url = $this->getUserStateFromRequest($this->context . '.filter.url', 'filter_url');
		if ($formSubmited)
		{
			$url = $app->input->post->get('url');
			$this->setState('filter.url', $url);
		}

		$heading = $this->getUserStateFromRequest($this->context . '.filter.heading', 'filter_heading');
		if ($formSubmited)
		{
			$heading = $app->input->post->get('heading');
			$this->setState('filter.heading', $heading);
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
				$access = ($user->authorise('snippet.access', 'com_componentbuilder.snippet.' . (int) $item->id) && $user->authorise('snippet.access', 'com_componentbuilder'));
				if (!$access)
				{
					unset($items[$nr]);
					continue;
				}

			}
		}

		// return items
		return $items;
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
		$query->from($db->quoteName('#__componentbuilder_snippet', 'a'));

		// From the componentbuilder_snippet_type table.
		$query->select($db->quoteName('g.name','type_name'));
		$query->join('LEFT', $db->quoteName('#__componentbuilder_snippet_type', 'g') . ' ON (' . $db->quoteName('a.type') . ' = ' . $db->quoteName('g.id') . ')');

		// From the componentbuilder_library table.
		$query->select($db->quoteName('h.name','library_name'));
		$query->join('LEFT', $db->quoteName('#__componentbuilder_library', 'h') . ' ON (' . $db->quoteName('a.library') . ' = ' . $db->quoteName('h.id') . ')');

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
				$query->where('(a.name LIKE '.$search.' OR a.url LIKE '.$search.' OR a.type LIKE '.$search.' OR g.name LIKE '.$search.' OR a.heading LIKE '.$search.' OR a.library LIKE '.$search.' OR h.name LIKE '.$search.' OR a.description LIKE '.$search.')');
			}
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
		elseif (StringHelper::check($_type))
		{
			$query->where('a.type = ' . $db->quote($db->escape($_type)));
		}
		// Filter by Library.
		$_library = $this->getState('filter.library');
		if (is_numeric($_library))
		{
			if (is_float($_library))
			{
				$query->where('a.library = ' . (float) $_library);
			}
			else
			{
				$query->where('a.library = ' . (int) $_library);
			}
		}
		elseif (StringHelper::check($_library))
		{
			$query->where('a.library = ' . $db->quote($db->escape($_library)));
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
		if (($pks_size = UtilitiesArrayHelper::check($pks)) !== false || 'bulk' === $pks)
		{
			// Set a value to know this is export method. (USE IN CUSTOM CODE TO ALTER OUTCOME)
			$_export = true;
			// Get the user object if not set.
			if (!isset($user) || !ObjectHelper::check($user))
			{
				$user = Factory::getUser();
			}
			// Create a new query object.
			$db = Factory::getDBO();
			$query = $db->getQuery(true);

			// Select some fields
			$query->select('a.*');

			// From the componentbuilder_snippet table
			$query->from($db->quoteName('#__componentbuilder_snippet', 'a'));
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
				if (UtilitiesArrayHelper::check($items))
				{
					foreach ($items as $nr => &$item)
					{
						// Remove items the user can't access.
						$access = ($user->authorise('snippet.access', 'com_componentbuilder.snippet.' . (int) $item->id) && $user->authorise('snippet.access', 'com_componentbuilder'));
						if (!$access)
						{
							unset($items[$nr]);
							continue;
						}

						// decode snippet
						$item->snippet = base64_decode($item->snippet);
						// unset the values we don't want exported.
						unset($item->asset_id);
						unset($item->checked_out);
						unset($item->checked_out_time);
					}
				}
				// Add headers to items array.
				$headers = $this->getExImPortHeaders();
				if (ObjectHelper::check($headers))
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
		$db = Factory::getDbo();
		// get the columns
		$columns = $db->getTableColumns("#__componentbuilder_snippet");
		if (UtilitiesArrayHelper::check($columns))
		{
			// remove the headers you don't import/export.
			unset($columns['asset_id']);
			unset($columns['checked_out']);
			unset($columns['checked_out_time']);
			$headers = new \stdClass();
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
		$id .= ':' . $this->getState('filter.type');
		$id .= ':' . $this->getState('filter.library');
		$id .= ':' . $this->getState('filter.name');
		$id .= ':' . $this->getState('filter.url');
		$id .= ':' . $this->getState('filter.heading');

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
			$query->from($db->quoteName('#__componentbuilder_snippet'));
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
				$query->update($db->quoteName('#__componentbuilder_snippet'))->set($fields)->where($conditions); 

				$db->setQuery($query);

				return $db->execute();
			}
		}

		return false;
	}
}
