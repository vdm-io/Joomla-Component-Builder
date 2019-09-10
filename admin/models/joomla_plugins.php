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
 * Joomla_plugins Model
 */
class ComponentbuilderModelJoomla_plugins extends JModelList
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
				'a.class_extends','class_extends',
				'a.joomla_plugin_group','joomla_plugin_group'
			);
		}

		parent::__construct($config);
	}


	/**
	 * get Boilerplate
	 *
	 * @return  boolean
	 */
	public function getBoilerplate()
	{
		// get boilerplate repo root details
		if (($repo_tree = ComponentbuilderHelper::getGithubRepoFileList('boilerplate', ComponentbuilderHelper::$bolerplateAPI)) !== false)
		{
			$found = array_values(array_filter(
				$repo_tree,
				function($tree) {
					if (isset($tree->path) && $tree->path === 'plugins')
					{
						return true;
					}
					return false;
				}
			));
			// make sure we have the correct boilerplate
			if (ComponentbuilderHelper::checkArray($found) && count($found) == 1 && method_exists(__CLASS__, 'getPluginsBoilerplate'))
			{
				// get the plugins boilerplate
				return $this->getPluginsBoilerplate($found[0]->url);
			}
		}
		return false;
	}

	/**
	 * get Plugin Boilerplate
	 *
	 * @return  boolean true on success
	 *
	 */
	protected function getPluginsBoilerplate($url)
	{
		// get boilerplate root for plugins
		if (($plugin_tree = ComponentbuilderHelper::getGithubRepoFileList('boilerplate_plugins', $url)) !== false)
		{
			// get the app object
			$app = JFactory::getApplication();
			// set the table names
			$tables = array();
			$tables['e'] = 'class_extends';
			$tables['g'] = 'joomla_plugin_group';
			$tables['m'] = 'class_method';
			$tables['p'] = 'class_property';
			// load the needed models
			$models = array();
			$models['e'] = ComponentbuilderHelper::getModel($tables['e']);
			$models['g'] = ComponentbuilderHelper::getModel($tables['g']);
			$models['p'] = ComponentbuilderHelper::getModel($tables['p']);
			$models['m'] = ComponentbuilderHelper::getModel($tables['m']);
			// get the needed data of each plugin group
			$groups = array_map(
				function($tree) use(&$app, &$models, &$tables){
					if (($fooClass = ComponentbuilderHelper::getFileContents(ComponentbuilderHelper::$bolerplatePath . '/plugins/' . $tree->path . '/foo.php')) !== false && ComponentbuilderHelper::checkString($fooClass))
					{
						// extract the boilerplate class extends and check if already set
						if (($classExtends = ComponentbuilderHelper::extractBoilerplateClassExtends($fooClass, 'plugins')) !== false &&
							($classExtendsID = ComponentbuilderHelper::getVar('class_extends', $classExtends, 'name', 'id')) === false)
						{
							// load the extends class name
							$class = array('id' => 0, 'published' => 1, 'version' => 1, 'name' => $classExtends);
							// extract the boilerplate class header
							$class['head'] = ComponentbuilderHelper::extractBoilerplateClassHeader($fooClass, $classExtends, 'plugins');
							// extract the boilerplate class comment
							$class['comment'] = ComponentbuilderHelper::extractBoilerplateClassComment($fooClass, $classExtends, 'plugins');
							// set the extension type
							$class['extension_type'] = 'plugins';
							// store the class
							$this->storePluginBoilerplate($tables['e'], $models['e'], $class, $app);
							// work around
							$classExtendsID = ComponentbuilderHelper::getVar('class_extends', $classExtends, 'name', 'id');
						}
						// set plugin group if not already set
						if (($pluginGroupID = ComponentbuilderHelper::getVar('joomla_plugin_group', $tree->path, 'name', 'id')) === false)
						{
							// load the plugin group name
							$pluginGroup = array('id' => 0, 'published' => 1, 'version' => 1, 'name' => $tree->path, 'class_extends' => $classExtendsID);
							// store the group
							$this->storePluginBoilerplate($tables['g'], $models['g'], $pluginGroup, $app);
							// work around
							$pluginGroupID = ComponentbuilderHelper::getVar('joomla_plugin_group', $tree->path, 'name', 'id');
						}
						// extract the boilerplate class property and methods
						if (($classProperiesMethods = ComponentbuilderHelper::extractBoilerplateClassPropertiesMethods($fooClass, $classExtends, 'plugins', $pluginGroupID)) !== false)
						{
							// create the properties found
							if (isset($classProperiesMethods['property']) && ComponentbuilderHelper::checkArray($classProperiesMethods['property']))
							{
								foreach ($classProperiesMethods['property'] as $_property)
								{
									// force update by default
									$this->storePluginBoilerplate($tables['p'], $models['p'], $_property, $app);
								}
							}
							// create the method found (TODO just create for now but we could later add a force update)
							if (isset($classProperiesMethods['method']) && ComponentbuilderHelper::checkArray($classProperiesMethods['method']))
							{
								foreach ($classProperiesMethods['method'] as $_method)
								{
									// force update by default
									$this->storePluginBoilerplate($tables['m'], $models['m'], $_method, $app);
								}
							}
						}
					}
				},
				$plugin_tree
			);
		}
	}

	/**
	 * store Plugin Boilerplate
	 *
	 * @return  boolean true on success
	 *
	 */
	protected function storePluginBoilerplate(&$table, &$method, &$boilerplate, &$app)
	{
		// Sometimes the form needs some posted data, such as for plugins and modules.
		$form = $method->getForm($boilerplate, false);
		if (!$form)
		{
			$app->enqueueMessage($method->getError(), 'error');
			return false;
		}
		// Send an object which can be modified through the plugin event
		$objData = (object) $boilerplate;
		$app->triggerEvent(
			'onContentNormaliseRequestData',
			array('com_componentbuilder.' . $table, $objData, $form)
		);
		$boilerplate = (array) $objData;
		// Test whether the data is valid.
		$validData = $method->validate($form, $boilerplate);
		// Check for validation errors.
		if ($validData === false)
		{
			// Get the validation messages.
			$errors = $method->getErrors();
			// Push up to three validation messages out to the user.
			for ($i = 0, $n = count($errors); $i < $n && $i < 3; $i++)
			{
				if ($errors[$i] instanceof \Exception)
				{
					$app->enqueueMessage($errors[$i]->getMessage(), 'warning');
				}
				else
				{
					$app->enqueueMessage($errors[$i], 'warning');
				}
			}
			return false;
		}
		// Attempt to save the data.
		if (!$method->save($validData))
		{
			$app->enqueueMessage(JText::sprintf('COM_COMPONENTBUILDER_BOILERPLATE_PLUGIN_S_DATA_COULD_NOT_BE_SAVED', $table), 'error');
			return false;
		}
		return true;
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

		$class_extends = $this->getUserStateFromRequest($this->context . '.filter.class_extends', 'filter_class_extends');
		$this->setState('filter.class_extends', $class_extends);

		$joomla_plugin_group = $this->getUserStateFromRequest($this->context . '.filter.joomla_plugin_group', 'filter_joomla_plugin_group');
		$this->setState('filter.joomla_plugin_group', $joomla_plugin_group);
        
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
				$access = ($user->authorise('joomla_plugin.access', 'com_componentbuilder.joomla_plugin.' . (int) $item->id) && $user->authorise('joomla_plugin.access', 'com_componentbuilder'));
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
		$query->from($db->quoteName('#__componentbuilder_joomla_plugin', 'a'));

		// From the componentbuilder_class_extends table.
		$query->select($db->quoteName('g.name','class_extends_name'));
		$query->join('LEFT', $db->quoteName('#__componentbuilder_class_extends', 'g') . ' ON (' . $db->quoteName('a.class_extends') . ' = ' . $db->quoteName('g.id') . ')');

		// From the componentbuilder_joomla_plugin_group table.
		$query->select($db->quoteName('h.name','joomla_plugin_group_name'));
		$query->join('LEFT', $db->quoteName('#__componentbuilder_joomla_plugin_group', 'h') . ' ON (' . $db->quoteName('a.joomla_plugin_group') . ' = ' . $db->quoteName('h.id') . ')');

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
				$query->where('(a.system_name LIKE '.$search.' OR a.class_extends LIKE '.$search.' OR g.name LIKE '.$search.' OR a.joomla_plugin_group LIKE '.$search.' OR h.name LIKE '.$search.' OR a.description LIKE '.$search.' OR a.name LIKE '.$search.')');
			}
		}

		// Filter by class_extends.
		if ($class_extends = $this->getState('filter.class_extends'))
		{
			$query->where('a.class_extends = ' . $db->quote($db->escape($class_extends)));
		}
		// Filter by joomla_plugin_group.
		if ($joomla_plugin_group = $this->getState('filter.joomla_plugin_group'))
		{
			$query->where('a.joomla_plugin_group = ' . $db->quote($db->escape($joomla_plugin_group)));
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
		$id .= ':' . $this->getState('filter.class_extends');
		$id .= ':' . $this->getState('filter.joomla_plugin_group');

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
			$query->from($db->quoteName('#__componentbuilder_joomla_plugin'));
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
				$query->update($db->quoteName('#__componentbuilder_joomla_plugin'))->set($fields)->where($conditions); 

				$db->setQuery($query);

				$db->execute();
			}
		}

		return false;
	}
}
