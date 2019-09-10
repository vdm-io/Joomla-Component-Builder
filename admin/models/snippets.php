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
 * Snippets Model
 */
class ComponentbuilderModelSnippets extends JModelList
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
				'a.url','url',
				'a.type','type',
				'a.heading','heading',
				'a.library','library'
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
		if (ComponentbuilderHelper::checkArray($pks))
		{
			// Get the user object.
			if (!ComponentbuilderHelper::checkObject($this->user))
			{
				$this->user = JFactory::getUser();
			}
			// Create a new query object.
			if (!ComponentbuilderHelper::checkObject($this->_db))
			{
				$this->_db = JFactory::getDBO();
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
				if (ComponentbuilderHelper::checkArray($items))
				{
					// get the shared paths
					$this->fullPath = rtrim(ComponentbuilderHelper::getFolderPath('path', 'sharepath', JFactory::getConfig()->get('tmp_path')), '/') . '/snippets';
					// remove old folder with the same name
					if (JFolder::exists($this->fullPath))
					{
						// remove if old folder is found
						ComponentbuilderHelper::removeFolder($this->fullPath);
					}
					// create the full path
					JFolder::create($this->fullPath);
					// set zip path
					$this->zipPath = $this->fullPath .'.zip';
					// remove old zip files with the same name
					if (JFile::exists($this->zipPath))
					{
						// remove file if found
						JFile::delete($this->zipPath);
					}
					// prep the item
					foreach($items as $item)
					{
						// just unlock the snippet
						$item->snippet = base64_decode($item->snippet);
						// build filename
						$fileName = ComponentbuilderHelper::safeString($item->library . ' - (' . $item->type . ') ' . $item->name, 'filename', '', false) . '.json';
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

		$url = $this->getUserStateFromRequest($this->context . '.filter.url', 'filter_url');
		$this->setState('filter.url', $url);

		$type = $this->getUserStateFromRequest($this->context . '.filter.type', 'filter_type');
		$this->setState('filter.type', $type);

		$heading = $this->getUserStateFromRequest($this->context . '.filter.heading', 'filter_heading');
		$this->setState('filter.heading', $heading);

		$library = $this->getUserStateFromRequest($this->context . '.filter.library', 'filter_library');
		$this->setState('filter.library', $library);
        
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
				$query->where('(a.name LIKE '.$search.' OR a.url LIKE '.$search.' OR a.type LIKE '.$search.' OR g.name LIKE '.$search.' OR a.heading LIKE '.$search.' OR a.library LIKE '.$search.' OR h.name LIKE '.$search.' OR a.description LIKE '.$search.')');
			}
		}

		// Filter by type.
		if ($type = $this->getState('filter.type'))
		{
			$query->where('a.type = ' . $db->quote($db->escape($type)));
		}
		// Filter by library.
		if ($library = $this->getState('filter.library'))
		{
			$query->where('a.library = ' . $db->quote($db->escape($library)));
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

			// From the componentbuilder_snippet table
			$query->from($db->quoteName('#__componentbuilder_snippet', 'a'));
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
		$columns = $db->getTableColumns("#__componentbuilder_snippet");
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
		$id .= ':' . $this->getState('filter.url');
		$id .= ':' . $this->getState('filter.type');
		$id .= ':' . $this->getState('filter.heading');
		$id .= ':' . $this->getState('filter.library');

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
			$query->from($db->quoteName('#__componentbuilder_snippet'));
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
				$query->update($db->quoteName('#__componentbuilder_snippet'))->set($fields)->where($conditions); 

				$db->setQuery($query);

				$db->execute();
			}
		}

		return false;
	}
}
