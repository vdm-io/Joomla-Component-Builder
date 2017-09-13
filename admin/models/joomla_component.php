<?php
/*--------------------------------------------------------------------------------------------------------|  www.vdm.io  |------/
    __      __       _     _____                 _                                  _     __  __      _   _               _
    \ \    / /      | |   |  __ \               | |                                | |   |  \/  |    | | | |             | |
     \ \  / /_ _ ___| |_  | |  | | _____   _____| | ___  _ __  _ __ ___   ___ _ __ | |_  | \  / | ___| |_| |__   ___   __| |
      \ \/ / _` / __| __| | |  | |/ _ \ \ / / _ \ |/ _ \| '_ \| '_ ` _ \ / _ \ '_ \| __| | |\/| |/ _ \ __| '_ \ / _ \ / _` |
       \  / (_| \__ \ |_  | |__| |  __/\ V /  __/ | (_) | |_) | | | | | |  __/ | | | |_  | |  | |  __/ |_| | | | (_) | (_| |
        \/ \__,_|___/\__| |_____/ \___| \_/ \___|_|\___/| .__/|_| |_| |_|\___|_| |_|\__| |_|  |_|\___|\__|_| |_|\___/ \__,_|
                                                        | |                                                                 
                                                        |_| 				
/-------------------------------------------------------------------------------------------------------------------------------/

	@version		@update number 366 of this MVC
	@build			7th September, 2017
	@created		6th May, 2015
	@package		Component Builder
	@subpackage		joomla_component.php
	@author			Llewellyn van der Merwe <http://vdm.bz/component-builder>	
	@copyright		Copyright (C) 2015. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html 
	
	Builds Complex Joomla Components 
                                                             
/-----------------------------------------------------------------------------------------------------------------------------*/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

use Joomla\Registry\Registry;

// import Joomla modelform library
jimport('joomla.application.component.modeladmin');

/**
 * Componentbuilder Joomla_component Model
 */
class ComponentbuilderModelJoomla_component extends JModelAdmin
{    
	/**
	 * @var        string    The prefix to use with controller messages.
	 * @since   1.6
	 */
	protected $text_prefix = 'COM_COMPONENTBUILDER';
    
	/**
	 * The type alias for this content type.
	 *
	 * @var      string
	 * @since    3.2
	 */
	public $typeAlias = 'com_componentbuilder.joomla_component';

	/**
	 * Returns a Table object, always creating it
	 *
	 * @param   type    $type    The table type to instantiate
	 * @param   string  $prefix  A prefix for the table class name. Optional.
	 * @param   array   $config  Configuration array for model. Optional.
	 *
	 * @return  JTable  A database object
	 *
	 * @since   1.6
	 */
	public function getTable($type = 'joomla_component', $prefix = 'ComponentbuilderTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}
    
	/**
	 * Method to get a single record.
	 *
	 * @param   integer  $pk  The id of the primary key.
	 *
	 * @return  mixed  Object on success, false on failure.
	 *
	 * @since   1.6
	 */
	public function getItem($pk = null)
	{
		if ($item = parent::getItem($pk))
		{
			if (!empty($item->params))
			{
				// Convert the params field to an array.
				$registry = new Registry;
				$registry->loadString($item->params);
				$item->params = $registry->toArray();
			}

			if (!empty($item->metadata))
			{
				// Convert the metadata field to an array.
				$registry = new Registry;
				$registry->loadString($item->metadata);
				$item->metadata = $registry->toArray();
			}

			if (!empty($item->readme))
			{
				// base64 Decode readme.
				$item->readme = base64_decode($item->readme);
			}

			if (!empty($item->php_postflight_install))
			{
				// base64 Decode php_postflight_install.
				$item->php_postflight_install = base64_decode($item->php_postflight_install);
			}

			if (!empty($item->php_preflight_install))
			{
				// base64 Decode php_preflight_install.
				$item->php_preflight_install = base64_decode($item->php_preflight_install);
			}

			if (!empty($item->php_method_uninstall))
			{
				// base64 Decode php_method_uninstall.
				$item->php_method_uninstall = base64_decode($item->php_method_uninstall);
			}

			if (!empty($item->css))
			{
				// base64 Decode css.
				$item->css = base64_decode($item->css);
			}

			if (!empty($item->php_preflight_update))
			{
				// base64 Decode php_preflight_update.
				$item->php_preflight_update = base64_decode($item->php_preflight_update);
			}

			if (!empty($item->php_postflight_update))
			{
				// base64 Decode php_postflight_update.
				$item->php_postflight_update = base64_decode($item->php_postflight_update);
			}

			if (!empty($item->sql))
			{
				// base64 Decode sql.
				$item->sql = base64_decode($item->sql);
			}

			if (!empty($item->php_helper_both))
			{
				// base64 Decode php_helper_both.
				$item->php_helper_both = base64_decode($item->php_helper_both);
			}

			if (!empty($item->php_helper_admin))
			{
				// base64 Decode php_helper_admin.
				$item->php_helper_admin = base64_decode($item->php_helper_admin);
			}

			if (!empty($item->php_admin_event))
			{
				// base64 Decode php_admin_event.
				$item->php_admin_event = base64_decode($item->php_admin_event);
			}

			if (!empty($item->php_helper_site))
			{
				// base64 Decode php_helper_site.
				$item->php_helper_site = base64_decode($item->php_helper_site);
			}

			if (!empty($item->php_site_event))
			{
				// base64 Decode php_site_event.
				$item->php_site_event = base64_decode($item->php_site_event);
			}

			if (!empty($item->php_dashboard_methods))
			{
				// base64 Decode php_dashboard_methods.
				$item->php_dashboard_methods = base64_decode($item->php_dashboard_methods);
			}

			if (!empty($item->buildcompsql))
			{
				// base64 Decode buildcompsql.
				$item->buildcompsql = base64_decode($item->buildcompsql);
			}

			// Get the basic encryption.
			$basickey = ComponentbuilderHelper::getCryptKey('basic');
			// Get the encryption object.
			$basic = new FOFEncryptAes($basickey, 128);

			if (!empty($item->whmcs_key) && $basickey && !is_numeric($item->whmcs_key) && $item->whmcs_key === base64_encode(base64_decode($item->whmcs_key, true)))
			{
				// basic decrypt data whmcs_key.
				$item->whmcs_key = rtrim($basic->decryptString($item->whmcs_key), "\0");
			}

			if (!empty($item->export_key) && $basickey && !is_numeric($item->export_key) && $item->export_key === base64_encode(base64_decode($item->export_key, true)))
			{
				// basic decrypt data export_key.
				$item->export_key = rtrim($basic->decryptString($item->export_key), "\0");
			}
			
			if (!empty($item->id))
			{
				$item->tags = new JHelperTags;
				$item->tags->getTagIds($item->id, 'com_componentbuilder.joomla_component');
			}
		}
		$this->idvvvv = $item->addadmin_views;
		$this->idvvvw = $item->addcustom_admin_views;
		$this->idvvvx = $item->addsite_views;
		$this->componentsvvvy = $item->id;

		return $item;
	}

	/**
	* Method to get list data.
	*
	* @return mixed  An array of data items on success, false on failure.
	*/
	public function getVwmadmin_views()
	{
		// Get the user object.
		$user = JFactory::getUser();
		// Create a new query object.
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);

		// Select some fields
		$query->select('a.*');

		// From the componentbuilder_admin_view table
		$query->from($db->quoteName('#__componentbuilder_admin_view', 'a'));

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

		// Order the results by ordering
		$query->order('a.published  ASC');
		$query->order('a.ordering  ASC');

		// Load the items
		$db->setQuery($query);
		$db->execute();
		if ($db->getNumRows())
		{
			$items = $db->loadObjectList();

			// set values to display correctly.
			if (ComponentbuilderHelper::checkArray($items))
			{
				// get user object.
				$user = JFactory::getUser();
				foreach ($items as $nr => &$item)
				{
					$access = ($user->authorise('admin_view.access', 'com_componentbuilder.admin_view.' . (int) $item->id) && $user->authorise('admin_view.access', 'com_componentbuilder'));
					if (!$access)
					{
						unset($items[$nr]);
						continue;
					}

				}
			}

			// Filter by id Repetable Field
			$idvvvv = json_decode($this->idvvvv,true);
			if (ComponentbuilderHelper::checkArray($items) && isset($idvvvv) && ComponentbuilderHelper::checkArray($idvvvv))
			{
				foreach ($items as $nr => &$item)
				{
					if ($item->id && isset($idvvvv['adminview']) && ComponentbuilderHelper::checkArray($idvvvv['adminview']))
					{
						if (!in_array($item->id,$idvvvv['adminview']))
						{
							unset($items[$nr]);
							continue;
						}
					}
					else
					{
						unset($items[$nr]);
						continue;
					}
				}
			}
			else
			{
				return false;
			}
			return $items;
		}
		return false;
	}

	/**
	* Method to get list data.
	*
	* @return mixed  An array of data items on success, false on failure.
	*/
	public function getVwncustom_admin_views()
	{
		// Get the user object.
		$user = JFactory::getUser();
		// Create a new query object.
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);

		// Select some fields
		$query->select('a.*');

		// From the componentbuilder_custom_admin_view table
		$query->from($db->quoteName('#__componentbuilder_custom_admin_view', 'a'));

		// From the componentbuilder_snippet table.
		$query->select($db->quoteName('g.name','snippet_name'));
		$query->join('LEFT', $db->quoteName('#__componentbuilder_snippet', 'g') . ' ON (' . $db->quoteName('a.snippet') . ' = ' . $db->quoteName('g.id') . ')');

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

		// Order the results by ordering
		$query->order('a.published  ASC');
		$query->order('a.ordering  ASC');

		// Load the items
		$db->setQuery($query);
		$db->execute();
		if ($db->getNumRows())
		{
			$items = $db->loadObjectList();

			// set values to display correctly.
			if (ComponentbuilderHelper::checkArray($items))
			{
				// get user object.
				$user = JFactory::getUser();
				foreach ($items as $nr => &$item)
				{
					$access = ($user->authorise('custom_admin_view.access', 'com_componentbuilder.custom_admin_view.' . (int) $item->id) && $user->authorise('custom_admin_view.access', 'com_componentbuilder'));
					if (!$access)
					{
						unset($items[$nr]);
						continue;
					}

				}
			}

			// Filter by id Repetable Field
			$idvvvw = json_decode($this->idvvvw,true);
			if (ComponentbuilderHelper::checkArray($items) && isset($idvvvw) && ComponentbuilderHelper::checkArray($idvvvw))
			{
				foreach ($items as $nr => &$item)
				{
					if ($item->id && isset($idvvvw['customadminview']) && ComponentbuilderHelper::checkArray($idvvvw['customadminview']))
					{
						if (!in_array($item->id,$idvvvw['customadminview']))
						{
							unset($items[$nr]);
							continue;
						}
					}
					else
					{
						unset($items[$nr]);
						continue;
					}
				}
			}
			else
			{
				return false;
			}
			return $items;
		}
		return false;
	}

	/**
	* Method to get list data.
	*
	* @return mixed  An array of data items on success, false on failure.
	*/
	public function getVwosite_views()
	{
		// Get the user object.
		$user = JFactory::getUser();
		// Create a new query object.
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);

		// Select some fields
		$query->select('a.*');

		// From the componentbuilder_site_view table
		$query->from($db->quoteName('#__componentbuilder_site_view', 'a'));

		// From the componentbuilder_snippet table.
		$query->select($db->quoteName('g.name','snippet_name'));
		$query->join('LEFT', $db->quoteName('#__componentbuilder_snippet', 'g') . ' ON (' . $db->quoteName('a.snippet') . ' = ' . $db->quoteName('g.id') . ')');

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

		// Order the results by ordering
		$query->order('a.published  ASC');
		$query->order('a.ordering  ASC');

		// Load the items
		$db->setQuery($query);
		$db->execute();
		if ($db->getNumRows())
		{
			$items = $db->loadObjectList();

			// set values to display correctly.
			if (ComponentbuilderHelper::checkArray($items))
			{
				// get user object.
				$user = JFactory::getUser();
				foreach ($items as $nr => &$item)
				{
					$access = ($user->authorise('site_view.access', 'com_componentbuilder.site_view.' . (int) $item->id) && $user->authorise('site_view.access', 'com_componentbuilder'));
					if (!$access)
					{
						unset($items[$nr]);
						continue;
					}

				}
			}

			// Filter by id Repetable Field
			$idvvvx = json_decode($this->idvvvx,true);
			if (ComponentbuilderHelper::checkArray($items) && isset($idvvvx) && ComponentbuilderHelper::checkArray($idvvvx))
			{
				foreach ($items as $nr => &$item)
				{
					if ($item->id && isset($idvvvx['siteview']) && ComponentbuilderHelper::checkArray($idvvvx['siteview']))
					{
						if (!in_array($item->id,$idvvvx['siteview']))
						{
							unset($items[$nr]);
							continue;
						}
					}
					else
					{
						unset($items[$nr]);
						continue;
					}
				}
			}
			else
			{
				return false;
			}
			return $items;
		}
		return false;
	}

	/**
	* Method to get list data.
	*
	* @return mixed  An array of data items on success, false on failure.
	*/
	public function getVwptranslation()
	{
		// Get the user object.
		$user = JFactory::getUser();
		// Create a new query object.
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);

		// Select some fields
		$query->select('a.*');

		// From the componentbuilder_language_translation table
		$query->from($db->quoteName('#__componentbuilder_language_translation', 'a'));

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

		// Order the results by ordering
		$query->order('a.published  ASC');
		$query->order('a.ordering  ASC');

		// Load the items
		$db->setQuery($query);
		$db->execute();
		if ($db->getNumRows())
		{
			$items = $db->loadObjectList();

			// set values to display correctly.
			if (ComponentbuilderHelper::checkArray($items))
			{
				// get user object.
				$user = JFactory::getUser();
				foreach ($items as $nr => &$item)
				{
					$access = ($user->authorise('language_translation.access', 'com_componentbuilder.language_translation.' . (int) $item->id) && $user->authorise('language_translation.access', 'com_componentbuilder'));
					if (!$access)
					{
						unset($items[$nr]);
						continue;
					}

				}
			}

			// Filter by componentsvvvy Array Field
			$componentsvvvy = $this->componentsvvvy;
			if (ComponentbuilderHelper::checkArray($items) && $componentsvvvy)
			{
				foreach ($items as $nr => &$item)
				{
					if (ComponentbuilderHelper::checkJson($item->components))
					{
						$item->components = json_decode($item->components, true);
					}
					elseif (!isset($item->components) || !ComponentbuilderHelper::checkArray($item->components))
					{
						unset($items[$nr]);
						continue;
					}
					if (!in_array($componentsvvvy,$item->components))
					{
						unset($items[$nr]);
						continue;
					}
				}
			}
			else
			{
				return false;
			}

				// show all languages that are already set for this string
			if (!isset($_export) && ComponentbuilderHelper::checkArray($items))
			{
				foreach ($items as $nr => &$item)
				{
					$langBucket = array();
					if (ComponentbuilderHelper::checkJson($item->translation))
					{
						$translations = json_decode($item->translation, true);
						if (ComponentbuilderHelper::checkArray($translations) && isset($translations['language']) && ComponentbuilderHelper::checkArray($translations['language']))
						{
							foreach ($translations['language'] as $language)
							{
								$langBucket[$language] = $language;
							}
						}
					}
					// set how many component use this string
					$componentCounter = '';
					if (ComponentbuilderHelper::checkJson($item->components))
					{
						$item->components = json_decode($item->components, true);
					}
					if (ComponentbuilderHelper::checkArray($item->components))
					{
						$componentCounter = ' - <small>' . JText::_('COM_COMPONENTBUILDER_USED_IN') . ' ' . count($item->components) . '</small>';
					}
					// load the languages to the string
					if (ComponentbuilderHelper::checkArray($langBucket))
					{
						$item->entranslation = '<small><em>(' . implode(', ', $langBucket) . ')</em></small> ' . ComponentbuilderHelper::htmlEscape($item->entranslation, 'UTF-8', true, 150) . $componentCounter;
					}
					else
					{
						$item->entranslation = '<small><em>(' . JText::_('COM_COMPONENTBUILDER_NOTRANSLATION') . ')</em></small> ' . ComponentbuilderHelper::htmlEscape($item->entranslation, 'UTF-8', true, 150) . $componentCounter;
					}
				}
			}
			return $items;
		}
		return false;
	} 

	/**
	 * Method to get the record form.
	 *
	 * @param   array    $data      Data for the form.
	 * @param   boolean  $loadData  True if the form is to load its own data (default case), false if not.
	 *
	 * @return  mixed  A JForm object on success, false on failure
	 *
	 * @since   1.6
	 */
	public function getForm($data = array(), $loadData = true)
	{
		// Get the form.
		$form = $this->loadForm('com_componentbuilder.joomla_component', 'joomla_component', array('control' => 'jform', 'load_data' => $loadData));

		if (empty($form))
		{
			return false;
		}

		$jinput = JFactory::getApplication()->input;

		// The front end calls this model and uses a_id to avoid id clashes so we need to check for that first.
		if ($jinput->get('a_id'))
		{
			$id = $jinput->get('a_id', 0, 'INT');
		}
		// The back end uses id so we use that the rest of the time and set it to 0 by default.
		else
		{
			$id = $jinput->get('id', 0, 'INT');
		}

		$user = JFactory::getUser();

		// Check for existing item.
		// Modify the form based on Edit State access controls.
		if ($id != 0 && (!$user->authorise('core.edit.state', 'com_componentbuilder.joomla_component.' . (int) $id))
			|| ($id == 0 && !$user->authorise('core.edit.state', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('ordering', 'disabled', 'true');
			$form->setFieldAttribute('published', 'disabled', 'true');
			// Disable fields while saving.
			$form->setFieldAttribute('ordering', 'filter', 'unset');
			$form->setFieldAttribute('published', 'filter', 'unset');
		}
		// If this is a new item insure the greated by is set.
		if (0 == $id)
		{
			// Set the created_by to this user
			$form->setValue('created_by', null, $user->id);
		}
		// Modify the form based on Edit Creaded By access controls.
		if (!$user->authorise('core.edit.created_by', 'com_componentbuilder'))
		{
			// Disable fields for display.
			$form->setFieldAttribute('created_by', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('created_by', 'readonly', 'true');
			// Disable fields while saving.
			$form->setFieldAttribute('created_by', 'filter', 'unset');
		}
		// Modify the form based on Edit Creaded Date access controls.
		if (!$user->authorise('core.edit.created', 'com_componentbuilder'))
		{
			// Disable fields for display.
			$form->setFieldAttribute('created', 'disabled', 'true');
			// Disable fields while saving.
			$form->setFieldAttribute('created', 'filter', 'unset');
		}
		// Modify the form based on Edit System Name access controls.
		if ($id != 0 && (!$user->authorise('joomla_component.edit.system_name', 'com_componentbuilder.joomla_component.' . (int) $id))
			|| ($id == 0 && !$user->authorise('joomla_component.edit.system_name', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('system_name', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('system_name', 'readonly', 'true');
			if (!$form->getValue('system_name'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('system_name', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('system_name', 'required', 'false');
			}
		}
		// Modify the form based on Edit Name Code access controls.
		if ($id != 0 && (!$user->authorise('joomla_component.edit.name_code', 'com_componentbuilder.joomla_component.' . (int) $id))
			|| ($id == 0 && !$user->authorise('joomla_component.edit.name_code', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('name_code', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('name_code', 'readonly', 'true');
			if (!$form->getValue('name_code'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('name_code', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('name_code', 'required', 'false');
			}
		}
		// Modify the form based on Edit Component Version access controls.
		if ($id != 0 && (!$user->authorise('joomla_component.edit.component_version', 'com_componentbuilder.joomla_component.' . (int) $id))
			|| ($id == 0 && !$user->authorise('joomla_component.edit.component_version', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('component_version', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('component_version', 'readonly', 'true');
			if (!$form->getValue('component_version'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('component_version', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('component_version', 'required', 'false');
			}
		}
		// Modify the form based on Edit Short Description access controls.
		if ($id != 0 && (!$user->authorise('joomla_component.edit.short_description', 'com_componentbuilder.joomla_component.' . (int) $id))
			|| ($id == 0 && !$user->authorise('joomla_component.edit.short_description', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('short_description', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('short_description', 'readonly', 'true');
			if (!$form->getValue('short_description'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('short_description', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('short_description', 'required', 'false');
			}
		}
		// Modify the form based on Edit Companyname access controls.
		if ($id != 0 && (!$user->authorise('joomla_component.edit.companyname', 'com_componentbuilder.joomla_component.' . (int) $id))
			|| ($id == 0 && !$user->authorise('joomla_component.edit.companyname', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('companyname', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('companyname', 'readonly', 'true');
			if (!$form->getValue('companyname'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('companyname', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('companyname', 'required', 'false');
			}
		}
		// Modify the form based on Edit Author access controls.
		if ($id != 0 && (!$user->authorise('joomla_component.edit.author', 'com_componentbuilder.joomla_component.' . (int) $id))
			|| ($id == 0 && !$user->authorise('joomla_component.edit.author', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('author', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('author', 'readonly', 'true');
			if (!$form->getValue('author'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('author', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('author', 'required', 'false');
			}
		}
		// Modify the form based on Edit Readme access controls.
		if ($id != 0 && (!$user->authorise('joomla_component.edit.readme', 'com_componentbuilder.joomla_component.' . (int) $id))
			|| ($id == 0 && !$user->authorise('joomla_component.edit.readme', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('readme', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('readme', 'readonly', 'true');
			if (!$form->getValue('readme'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('readme', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('readme', 'required', 'false');
			}
		}
		// Modify the form based on Edit Add Php Dashboard Methods access controls.
		if ($id != 0 && (!$user->authorise('joomla_component.edit.add_php_dashboard_methods', 'com_componentbuilder.joomla_component.' . (int) $id))
			|| ($id == 0 && !$user->authorise('joomla_component.edit.add_php_dashboard_methods', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('add_php_dashboard_methods', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('add_php_dashboard_methods', 'readonly', 'true');
			// Disable radio button for display.
			$class = $form->getFieldAttribute('add_php_dashboard_methods', 'class', '');
			$form->setFieldAttribute('add_php_dashboard_methods', 'class', $class.' disabled no-click');
			if (!$form->getValue('add_php_dashboard_methods'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('add_php_dashboard_methods', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('add_php_dashboard_methods', 'required', 'false');
			}
		}
		// Modify the form based on Edit Description access controls.
		if ($id != 0 && (!$user->authorise('joomla_component.edit.description', 'com_componentbuilder.joomla_component.' . (int) $id))
			|| ($id == 0 && !$user->authorise('joomla_component.edit.description', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('description', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('description', 'readonly', 'true');
			if (!$form->getValue('description'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('description', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('description', 'required', 'false');
			}
		}
		// Modify the form based on Edit Add Php Helper Admin access controls.
		if ($id != 0 && (!$user->authorise('joomla_component.edit.add_php_helper_admin', 'com_componentbuilder.joomla_component.' . (int) $id))
			|| ($id == 0 && !$user->authorise('joomla_component.edit.add_php_helper_admin', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('add_php_helper_admin', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('add_php_helper_admin', 'readonly', 'true');
			// Disable radio button for display.
			$class = $form->getFieldAttribute('add_php_helper_admin', 'class', '');
			$form->setFieldAttribute('add_php_helper_admin', 'class', $class.' disabled no-click');
			if (!$form->getValue('add_php_helper_admin'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('add_php_helper_admin', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('add_php_helper_admin', 'required', 'false');
			}
		}
		// Modify the form based on Edit Copyright access controls.
		if ($id != 0 && (!$user->authorise('joomla_component.edit.copyright', 'com_componentbuilder.joomla_component.' . (int) $id))
			|| ($id == 0 && !$user->authorise('joomla_component.edit.copyright', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('copyright', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('copyright', 'readonly', 'true');
			if (!$form->getValue('copyright'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('copyright', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('copyright', 'required', 'false');
			}
		}
		// Modify the form based on Edit Php Postflight Install access controls.
		if ($id != 0 && (!$user->authorise('joomla_component.edit.php_postflight_install', 'com_componentbuilder.joomla_component.' . (int) $id))
			|| ($id == 0 && !$user->authorise('joomla_component.edit.php_postflight_install', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('php_postflight_install', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('php_postflight_install', 'readonly', 'true');
			if (!$form->getValue('php_postflight_install'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('php_postflight_install', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('php_postflight_install', 'required', 'false');
			}
		}
		// Modify the form based on Edit Debug Linenr access controls.
		if ($id != 0 && (!$user->authorise('joomla_component.edit.debug_linenr', 'com_componentbuilder.joomla_component.' . (int) $id))
			|| ($id == 0 && !$user->authorise('joomla_component.edit.debug_linenr', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('debug_linenr', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('debug_linenr', 'readonly', 'true');
			// Disable radio button for display.
			$class = $form->getFieldAttribute('debug_linenr', 'class', '');
			$form->setFieldAttribute('debug_linenr', 'class', $class.' disabled no-click');
			if (!$form->getValue('debug_linenr'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('debug_linenr', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('debug_linenr', 'required', 'false');
			}
		}
		// Modify the form based on Edit Mvc Versiondate access controls.
		if ($id != 0 && (!$user->authorise('joomla_component.edit.mvc_versiondate', 'com_componentbuilder.joomla_component.' . (int) $id))
			|| ($id == 0 && !$user->authorise('joomla_component.edit.mvc_versiondate', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('mvc_versiondate', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('mvc_versiondate', 'readonly', 'true');
			// Disable radio button for display.
			$class = $form->getFieldAttribute('mvc_versiondate', 'class', '');
			$form->setFieldAttribute('mvc_versiondate', 'class', $class.' disabled no-click');
			if (!$form->getValue('mvc_versiondate'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('mvc_versiondate', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('mvc_versiondate', 'required', 'false');
			}
		}
		// Modify the form based on Edit Update Server Ftp access controls.
		if ($id != 0 && (!$user->authorise('joomla_component.edit.update_server_ftp', 'com_componentbuilder.joomla_component.' . (int) $id))
			|| ($id == 0 && !$user->authorise('joomla_component.edit.update_server_ftp', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('update_server_ftp', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('update_server_ftp', 'readonly', 'true');
			if (!$form->getValue('update_server_ftp'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('update_server_ftp', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('update_server_ftp', 'required', 'false');
			}
		}
		// Modify the form based on Edit Add Php Helper Site access controls.
		if ($id != 0 && (!$user->authorise('joomla_component.edit.add_php_helper_site', 'com_componentbuilder.joomla_component.' . (int) $id))
			|| ($id == 0 && !$user->authorise('joomla_component.edit.add_php_helper_site', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('add_php_helper_site', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('add_php_helper_site', 'readonly', 'true');
			// Disable radio button for display.
			$class = $form->getFieldAttribute('add_php_helper_site', 'class', '');
			$form->setFieldAttribute('add_php_helper_site', 'class', $class.' disabled no-click');
			if (!$form->getValue('add_php_helper_site'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('add_php_helper_site', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('add_php_helper_site', 'required', 'false');
			}
		}
		// Modify the form based on Edit Php Preflight Install access controls.
		if ($id != 0 && (!$user->authorise('joomla_component.edit.php_preflight_install', 'com_componentbuilder.joomla_component.' . (int) $id))
			|| ($id == 0 && !$user->authorise('joomla_component.edit.php_preflight_install', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('php_preflight_install', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('php_preflight_install', 'readonly', 'true');
			if (!$form->getValue('php_preflight_install'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('php_preflight_install', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('php_preflight_install', 'required', 'false');
			}
		}
		// Modify the form based on Edit Creatuserhelper access controls.
		if ($id != 0 && (!$user->authorise('joomla_component.edit.creatuserhelper', 'com_componentbuilder.joomla_component.' . (int) $id))
			|| ($id == 0 && !$user->authorise('joomla_component.edit.creatuserhelper', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('creatuserhelper', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('creatuserhelper', 'readonly', 'true');
			// Disable radio button for display.
			$class = $form->getFieldAttribute('creatuserhelper', 'class', '');
			$form->setFieldAttribute('creatuserhelper', 'class', $class.' disabled no-click');
			if (!$form->getValue('creatuserhelper'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('creatuserhelper', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('creatuserhelper', 'required', 'false');
			}
		}
		// Modify the form based on Edit Php Method Uninstall access controls.
		if ($id != 0 && (!$user->authorise('joomla_component.edit.php_method_uninstall', 'com_componentbuilder.joomla_component.' . (int) $id))
			|| ($id == 0 && !$user->authorise('joomla_component.edit.php_method_uninstall', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('php_method_uninstall', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('php_method_uninstall', 'readonly', 'true');
			if (!$form->getValue('php_method_uninstall'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('php_method_uninstall', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('php_method_uninstall', 'required', 'false');
			}
		}
		// Modify the form based on Edit Css access controls.
		if ($id != 0 && (!$user->authorise('joomla_component.edit.css', 'com_componentbuilder.joomla_component.' . (int) $id))
			|| ($id == 0 && !$user->authorise('joomla_component.edit.css', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('css', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('css', 'readonly', 'true');
			if (!$form->getValue('css'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('css', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('css', 'required', 'false');
			}
		}
		// Modify the form based on Edit Version Update access controls.
		if ($id != 0 && (!$user->authorise('joomla_component.edit.version_update', 'com_componentbuilder.joomla_component.' . (int) $id))
			|| ($id == 0 && !$user->authorise('joomla_component.edit.version_update', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('version_update', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('version_update', 'readonly', 'true');
			// Disable radio button for display.
			$class = $form->getFieldAttribute('version_update', 'class', '');
			$form->setFieldAttribute('version_update', 'class', $class.' disabled no-click');
			if (!$form->getValue('version_update'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('version_update', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('version_update', 'required', 'false');
			}
		}
		// Modify the form based on Edit Email access controls.
		if ($id != 0 && (!$user->authorise('joomla_component.edit.email', 'com_componentbuilder.joomla_component.' . (int) $id))
			|| ($id == 0 && !$user->authorise('joomla_component.edit.email', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('email', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('email', 'readonly', 'true');
			if (!$form->getValue('email'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('email', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('email', 'required', 'false');
			}
		}
		// Modify the form based on Edit Buildcomp access controls.
		if ($id != 0 && (!$user->authorise('joomla_component.edit.buildcomp', 'com_componentbuilder.joomla_component.' . (int) $id))
			|| ($id == 0 && !$user->authorise('joomla_component.edit.buildcomp', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('buildcomp', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('buildcomp', 'readonly', 'true');
			// Disable radio button for display.
			$class = $form->getFieldAttribute('buildcomp', 'class', '');
			$form->setFieldAttribute('buildcomp', 'class', $class.' disabled no-click');
			if (!$form->getValue('buildcomp'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('buildcomp', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('buildcomp', 'required', 'false');
			}
		}
		// Modify the form based on Edit Website access controls.
		if ($id != 0 && (!$user->authorise('joomla_component.edit.website', 'com_componentbuilder.joomla_component.' . (int) $id))
			|| ($id == 0 && !$user->authorise('joomla_component.edit.website', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('website', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('website', 'readonly', 'true');
			if (!$form->getValue('website'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('website', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('website', 'required', 'false');
			}
		}
		// Modify the form based on Edit Export Package Link access controls.
		if ($id != 0 && (!$user->authorise('joomla_component.edit.export_package_link', 'com_componentbuilder.joomla_component.' . (int) $id))
			|| ($id == 0 && !$user->authorise('joomla_component.edit.export_package_link', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('export_package_link', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('export_package_link', 'readonly', 'true');
			if (!$form->getValue('export_package_link'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('export_package_link', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('export_package_link', 'required', 'false');
			}
		}
		// Modify the form based on Edit Add License access controls.
		if ($id != 0 && (!$user->authorise('joomla_component.edit.add_license', 'com_componentbuilder.joomla_component.' . (int) $id))
			|| ($id == 0 && !$user->authorise('joomla_component.edit.add_license', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('add_license', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('add_license', 'readonly', 'true');
			// Disable radio button for display.
			$class = $form->getFieldAttribute('add_license', 'class', '');
			$form->setFieldAttribute('add_license', 'class', $class.' disabled no-click');
			if (!$form->getValue('add_license'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('add_license', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('add_license', 'required', 'false');
			}
		}
		// Modify the form based on Edit Addfootable access controls.
		if ($id != 0 && (!$user->authorise('joomla_component.edit.addfootable', 'com_componentbuilder.joomla_component.' . (int) $id))
			|| ($id == 0 && !$user->authorise('joomla_component.edit.addfootable', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('addfootable', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('addfootable', 'readonly', 'true');
			// Disable radio button for display.
			$class = $form->getFieldAttribute('addfootable', 'class', '');
			$form->setFieldAttribute('addfootable', 'class', $class.' disabled no-click');
			if (!$form->getValue('addfootable'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('addfootable', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('addfootable', 'required', 'false');
			}
		}
		// Modify the form based on Edit License Type access controls.
		if ($id != 0 && (!$user->authorise('joomla_component.edit.license_type', 'com_componentbuilder.joomla_component.' . (int) $id))
			|| ($id == 0 && !$user->authorise('joomla_component.edit.license_type', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('license_type', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('license_type', 'readonly', 'true');
			if (!$form->getValue('license_type'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('license_type', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('license_type', 'required', 'false');
			}
		}
		// Modify the form based on Edit Add Php Helper Both access controls.
		if ($id != 0 && (!$user->authorise('joomla_component.edit.add_php_helper_both', 'com_componentbuilder.joomla_component.' . (int) $id))
			|| ($id == 0 && !$user->authorise('joomla_component.edit.add_php_helper_both', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('add_php_helper_both', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('add_php_helper_both', 'readonly', 'true');
			// Disable radio button for display.
			$class = $form->getFieldAttribute('add_php_helper_both', 'class', '');
			$form->setFieldAttribute('add_php_helper_both', 'class', $class.' disabled no-click');
			if (!$form->getValue('add_php_helper_both'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('add_php_helper_both', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('add_php_helper_both', 'required', 'false');
			}
		}
		// Modify the form based on Edit Add Admin Event access controls.
		if ($id != 0 && (!$user->authorise('joomla_component.edit.add_admin_event', 'com_componentbuilder.joomla_component.' . (int) $id))
			|| ($id == 0 && !$user->authorise('joomla_component.edit.add_admin_event', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('add_admin_event', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('add_admin_event', 'readonly', 'true');
			// Disable radio button for display.
			$class = $form->getFieldAttribute('add_admin_event', 'class', '');
			$form->setFieldAttribute('add_admin_event', 'class', $class.' disabled no-click');
			if (!$form->getValue('add_admin_event'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('add_admin_event', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('add_admin_event', 'required', 'false');
			}
		}
		// Modify the form based on Edit Whmcs Key access controls.
		if ($id != 0 && (!$user->authorise('joomla_component.edit.whmcs_key', 'com_componentbuilder.joomla_component.' . (int) $id))
			|| ($id == 0 && !$user->authorise('joomla_component.edit.whmcs_key', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('whmcs_key', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('whmcs_key', 'readonly', 'true');
			if (!$form->getValue('whmcs_key'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('whmcs_key', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('whmcs_key', 'required', 'false');
			}
		}
		// Modify the form based on Edit Add Site Event access controls.
		if ($id != 0 && (!$user->authorise('joomla_component.edit.add_site_event', 'com_componentbuilder.joomla_component.' . (int) $id))
			|| ($id == 0 && !$user->authorise('joomla_component.edit.add_site_event', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('add_site_event', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('add_site_event', 'readonly', 'true');
			// Disable radio button for display.
			$class = $form->getFieldAttribute('add_site_event', 'class', '');
			$form->setFieldAttribute('add_site_event', 'class', $class.' disabled no-click');
			if (!$form->getValue('add_site_event'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('add_site_event', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('add_site_event', 'required', 'false');
			}
		}
		// Modify the form based on Edit Whmcs Url access controls.
		if ($id != 0 && (!$user->authorise('joomla_component.edit.whmcs_url', 'com_componentbuilder.joomla_component.' . (int) $id))
			|| ($id == 0 && !$user->authorise('joomla_component.edit.whmcs_url', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('whmcs_url', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('whmcs_url', 'readonly', 'true');
			if (!$form->getValue('whmcs_url'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('whmcs_url', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('whmcs_url', 'required', 'false');
			}
		}
		// Modify the form based on Edit Dashboard Tab access controls.
		if ($id != 0 && (!$user->authorise('joomla_component.edit.dashboard_tab', 'com_componentbuilder.joomla_component.' . (int) $id))
			|| ($id == 0 && !$user->authorise('joomla_component.edit.dashboard_tab', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('dashboard_tab', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('dashboard_tab', 'readonly', 'true');
			// Disable radio button for display.
			$class = $form->getFieldAttribute('dashboard_tab', 'class', '');
			$form->setFieldAttribute('dashboard_tab', 'class', $class.' disabled no-click');
			if (!$form->getValue('dashboard_tab'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('dashboard_tab', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('dashboard_tab', 'required', 'false');
			}
		}
		// Modify the form based on Edit License access controls.
		if ($id != 0 && (!$user->authorise('joomla_component.edit.license', 'com_componentbuilder.joomla_component.' . (int) $id))
			|| ($id == 0 && !$user->authorise('joomla_component.edit.license', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('license', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('license', 'readonly', 'true');
			if (!$form->getValue('license'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('license', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('license', 'required', 'false');
			}
		}
		// Modify the form based on Edit Php Preflight Update access controls.
		if ($id != 0 && (!$user->authorise('joomla_component.edit.php_preflight_update', 'com_componentbuilder.joomla_component.' . (int) $id))
			|| ($id == 0 && !$user->authorise('joomla_component.edit.php_preflight_update', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('php_preflight_update', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('php_preflight_update', 'readonly', 'true');
			if (!$form->getValue('php_preflight_update'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('php_preflight_update', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('php_preflight_update', 'required', 'false');
			}
		}
		// Modify the form based on Edit Bom access controls.
		if ($id != 0 && (!$user->authorise('joomla_component.edit.bom', 'com_componentbuilder.joomla_component.' . (int) $id))
			|| ($id == 0 && !$user->authorise('joomla_component.edit.bom', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('bom', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('bom', 'readonly', 'true');
			if (!$form->getValue('bom'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('bom', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('bom', 'required', 'false');
			}
		}
		// Modify the form based on Edit Php Postflight Update access controls.
		if ($id != 0 && (!$user->authorise('joomla_component.edit.php_postflight_update', 'com_componentbuilder.joomla_component.' . (int) $id))
			|| ($id == 0 && !$user->authorise('joomla_component.edit.php_postflight_update', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('php_postflight_update', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('php_postflight_update', 'readonly', 'true');
			if (!$form->getValue('php_postflight_update'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('php_postflight_update', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('php_postflight_update', 'required', 'false');
			}
		}
		// Modify the form based on Edit Image access controls.
		if ($id != 0 && (!$user->authorise('joomla_component.edit.image', 'com_componentbuilder.joomla_component.' . (int) $id))
			|| ($id == 0 && !$user->authorise('joomla_component.edit.image', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('image', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('image', 'readonly', 'true');
			if (!$form->getValue('image'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('image', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('image', 'required', 'false');
			}
		}
		// Modify the form based on Edit Sql access controls.
		if ($id != 0 && (!$user->authorise('joomla_component.edit.sql', 'com_componentbuilder.joomla_component.' . (int) $id))
			|| ($id == 0 && !$user->authorise('joomla_component.edit.sql', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('sql', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('sql', 'readonly', 'true');
			if (!$form->getValue('sql'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('sql', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('sql', 'required', 'false');
			}
		}
		// Modify the form based on Edit Update Server Target access controls.
		if ($id != 0 && (!$user->authorise('joomla_component.edit.update_server_target', 'com_componentbuilder.joomla_component.' . (int) $id))
			|| ($id == 0 && !$user->authorise('joomla_component.edit.update_server_target', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('update_server_target', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('update_server_target', 'readonly', 'true');
			// Disable radio button for display.
			$class = $form->getFieldAttribute('update_server_target', 'class', '');
			$form->setFieldAttribute('update_server_target', 'class', $class.' disabled no-click');
			if (!$form->getValue('update_server_target'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('update_server_target', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('update_server_target', 'required', 'false');
			}
		}
		// Modify the form based on Edit Add Update Server access controls.
		if ($id != 0 && (!$user->authorise('joomla_component.edit.add_update_server', 'com_componentbuilder.joomla_component.' . (int) $id))
			|| ($id == 0 && !$user->authorise('joomla_component.edit.add_update_server', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('add_update_server', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('add_update_server', 'readonly', 'true');
			// Disable radio button for display.
			$class = $form->getFieldAttribute('add_update_server', 'class', '');
			$form->setFieldAttribute('add_update_server', 'class', $class.' disabled no-click');
			if (!$form->getValue('add_update_server'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('add_update_server', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('add_update_server', 'required', 'false');
			}
		}
		// Modify the form based on Edit Sales Server Ftp access controls.
		if ($id != 0 && (!$user->authorise('joomla_component.edit.sales_server_ftp', 'com_componentbuilder.joomla_component.' . (int) $id))
			|| ($id == 0 && !$user->authorise('joomla_component.edit.sales_server_ftp', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('sales_server_ftp', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('sales_server_ftp', 'readonly', 'true');
			if (!$form->getValue('sales_server_ftp'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('sales_server_ftp', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('sales_server_ftp', 'required', 'false');
			}
		}
		// Modify the form based on Edit Addadmin Views access controls.
		if ($id != 0 && (!$user->authorise('joomla_component.edit.addadmin_views', 'com_componentbuilder.joomla_component.' . (int) $id))
			|| ($id == 0 && !$user->authorise('joomla_component.edit.addadmin_views', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('addadmin_views', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('addadmin_views', 'readonly', 'true');
			// Disable radio button for display.
			$class = $form->getFieldAttribute('addadmin_views', 'class', '');
			$form->setFieldAttribute('addadmin_views', 'class', $class.' disabled no-click');
			if (!$form->getValue('addadmin_views'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('addadmin_views', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('addadmin_views', 'required', 'false');
			}
		}
		// Modify the form based on Edit Name access controls.
		if ($id != 0 && (!$user->authorise('joomla_component.edit.name', 'com_componentbuilder.joomla_component.' . (int) $id))
			|| ($id == 0 && !$user->authorise('joomla_component.edit.name', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('name', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('name', 'readonly', 'true');
			if (!$form->getValue('name'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('name', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('name', 'required', 'false');
			}
		}
		// Modify the form based on Edit Addcustom Admin Views access controls.
		if ($id != 0 && (!$user->authorise('joomla_component.edit.addcustom_admin_views', 'com_componentbuilder.joomla_component.' . (int) $id))
			|| ($id == 0 && !$user->authorise('joomla_component.edit.addcustom_admin_views', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('addcustom_admin_views', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('addcustom_admin_views', 'readonly', 'true');
			// Disable radio button for display.
			$class = $form->getFieldAttribute('addcustom_admin_views', 'class', '');
			$form->setFieldAttribute('addcustom_admin_views', 'class', $class.' disabled no-click');
			if (!$form->getValue('addcustom_admin_views'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('addcustom_admin_views', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('addcustom_admin_views', 'required', 'false');
			}
		}
		// Modify the form based on Edit Export Key access controls.
		if ($id != 0 && (!$user->authorise('joomla_component.edit.export_key', 'com_componentbuilder.joomla_component.' . (int) $id))
			|| ($id == 0 && !$user->authorise('joomla_component.edit.export_key', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('export_key', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('export_key', 'readonly', 'true');
			if (!$form->getValue('export_key'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('export_key', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('export_key', 'required', 'false');
			}
		}
		// Modify the form based on Edit Addsite Views access controls.
		if ($id != 0 && (!$user->authorise('joomla_component.edit.addsite_views', 'com_componentbuilder.joomla_component.' . (int) $id))
			|| ($id == 0 && !$user->authorise('joomla_component.edit.addsite_views', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('addsite_views', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('addsite_views', 'readonly', 'true');
			// Disable radio button for display.
			$class = $form->getFieldAttribute('addsite_views', 'class', '');
			$form->setFieldAttribute('addsite_views', 'class', $class.' disabled no-click');
			if (!$form->getValue('addsite_views'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('addsite_views', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('addsite_views', 'required', 'false');
			}
		}
		// Modify the form based on Edit Export Buy Link access controls.
		if ($id != 0 && (!$user->authorise('joomla_component.edit.export_buy_link', 'com_componentbuilder.joomla_component.' . (int) $id))
			|| ($id == 0 && !$user->authorise('joomla_component.edit.export_buy_link', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('export_buy_link', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('export_buy_link', 'readonly', 'true');
			if (!$form->getValue('export_buy_link'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('export_buy_link', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('export_buy_link', 'required', 'false');
			}
		}
		// Modify the form based on Edit Adduikit access controls.
		if ($id != 0 && (!$user->authorise('joomla_component.edit.adduikit', 'com_componentbuilder.joomla_component.' . (int) $id))
			|| ($id == 0 && !$user->authorise('joomla_component.edit.adduikit', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('adduikit', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('adduikit', 'readonly', 'true');
			// Disable radio button for display.
			$class = $form->getFieldAttribute('adduikit', 'class', '');
			$form->setFieldAttribute('adduikit', 'class', $class.' disabled no-click');
			if (!$form->getValue('adduikit'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('adduikit', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('adduikit', 'required', 'false');
			}
		}
		// Modify the form based on Edit Add Css access controls.
		if ($id != 0 && (!$user->authorise('joomla_component.edit.add_css', 'com_componentbuilder.joomla_component.' . (int) $id))
			|| ($id == 0 && !$user->authorise('joomla_component.edit.add_css', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('add_css', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('add_css', 'readonly', 'true');
			// Disable radio button for display.
			$class = $form->getFieldAttribute('add_css', 'class', '');
			$form->setFieldAttribute('add_css', 'class', $class.' disabled no-click');
			if (!$form->getValue('add_css'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('add_css', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('add_css', 'required', 'false');
			}
		}
		// Modify the form based on Edit Sql Tweak access controls.
		if ($id != 0 && (!$user->authorise('joomla_component.edit.sql_tweak', 'com_componentbuilder.joomla_component.' . (int) $id))
			|| ($id == 0 && !$user->authorise('joomla_component.edit.sql_tweak', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('sql_tweak', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('sql_tweak', 'readonly', 'true');
			// Disable radio button for display.
			$class = $form->getFieldAttribute('sql_tweak', 'class', '');
			$form->setFieldAttribute('sql_tweak', 'class', $class.' disabled no-click');
			if (!$form->getValue('sql_tweak'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('sql_tweak', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('sql_tweak', 'required', 'false');
			}
		}
		// Modify the form based on Edit Add Email Helper access controls.
		if ($id != 0 && (!$user->authorise('joomla_component.edit.add_email_helper', 'com_componentbuilder.joomla_component.' . (int) $id))
			|| ($id == 0 && !$user->authorise('joomla_component.edit.add_email_helper', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('add_email_helper', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('add_email_helper', 'readonly', 'true');
			// Disable radio button for display.
			$class = $form->getFieldAttribute('add_email_helper', 'class', '');
			$form->setFieldAttribute('add_email_helper', 'class', $class.' disabled no-click');
			if (!$form->getValue('add_email_helper'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('add_email_helper', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('add_email_helper', 'required', 'false');
			}
		}
		// Modify the form based on Edit Php Helper Both access controls.
		if ($id != 0 && (!$user->authorise('joomla_component.edit.php_helper_both', 'com_componentbuilder.joomla_component.' . (int) $id))
			|| ($id == 0 && !$user->authorise('joomla_component.edit.php_helper_both', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('php_helper_both', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('php_helper_both', 'readonly', 'true');
			if (!$form->getValue('php_helper_both'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('php_helper_both', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('php_helper_both', 'required', 'false');
			}
		}
		// Modify the form based on Edit Php Helper Admin access controls.
		if ($id != 0 && (!$user->authorise('joomla_component.edit.php_helper_admin', 'com_componentbuilder.joomla_component.' . (int) $id))
			|| ($id == 0 && !$user->authorise('joomla_component.edit.php_helper_admin', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('php_helper_admin', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('php_helper_admin', 'readonly', 'true');
			if (!$form->getValue('php_helper_admin'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('php_helper_admin', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('php_helper_admin', 'required', 'false');
			}
		}
		// Modify the form based on Edit Addcustommenus access controls.
		if ($id != 0 && (!$user->authorise('joomla_component.edit.addcustommenus', 'com_componentbuilder.joomla_component.' . (int) $id))
			|| ($id == 0 && !$user->authorise('joomla_component.edit.addcustommenus', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('addcustommenus', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('addcustommenus', 'readonly', 'true');
			// Disable radio button for display.
			$class = $form->getFieldAttribute('addcustommenus', 'class', '');
			$form->setFieldAttribute('addcustommenus', 'class', $class.' disabled no-click');
			if (!$form->getValue('addcustommenus'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('addcustommenus', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('addcustommenus', 'required', 'false');
			}
		}
		// Modify the form based on Edit Php Admin Event access controls.
		if ($id != 0 && (!$user->authorise('joomla_component.edit.php_admin_event', 'com_componentbuilder.joomla_component.' . (int) $id))
			|| ($id == 0 && !$user->authorise('joomla_component.edit.php_admin_event', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('php_admin_event', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('php_admin_event', 'readonly', 'true');
			if (!$form->getValue('php_admin_event'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('php_admin_event', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('php_admin_event', 'required', 'false');
			}
		}
		// Modify the form based on Edit Php Helper Site access controls.
		if ($id != 0 && (!$user->authorise('joomla_component.edit.php_helper_site', 'com_componentbuilder.joomla_component.' . (int) $id))
			|| ($id == 0 && !$user->authorise('joomla_component.edit.php_helper_site', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('php_helper_site', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('php_helper_site', 'readonly', 'true');
			if (!$form->getValue('php_helper_site'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('php_helper_site', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('php_helper_site', 'required', 'false');
			}
		}
		// Modify the form based on Edit Php Site Event access controls.
		if ($id != 0 && (!$user->authorise('joomla_component.edit.php_site_event', 'com_componentbuilder.joomla_component.' . (int) $id))
			|| ($id == 0 && !$user->authorise('joomla_component.edit.php_site_event', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('php_site_event', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('php_site_event', 'readonly', 'true');
			if (!$form->getValue('php_site_event'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('php_site_event', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('php_site_event', 'required', 'false');
			}
		}
		// Modify the form based on Edit Addconfig access controls.
		if ($id != 0 && (!$user->authorise('joomla_component.edit.addconfig', 'com_componentbuilder.joomla_component.' . (int) $id))
			|| ($id == 0 && !$user->authorise('joomla_component.edit.addconfig', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('addconfig', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('addconfig', 'readonly', 'true');
			// Disable radio button for display.
			$class = $form->getFieldAttribute('addconfig', 'class', '');
			$form->setFieldAttribute('addconfig', 'class', $class.' disabled no-click');
			if (!$form->getValue('addconfig'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('addconfig', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('addconfig', 'required', 'false');
			}
		}
		// Modify the form based on Edit Php Dashboard Methods access controls.
		if ($id != 0 && (!$user->authorise('joomla_component.edit.php_dashboard_methods', 'com_componentbuilder.joomla_component.' . (int) $id))
			|| ($id == 0 && !$user->authorise('joomla_component.edit.php_dashboard_methods', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('php_dashboard_methods', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('php_dashboard_methods', 'readonly', 'true');
			if (!$form->getValue('php_dashboard_methods'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('php_dashboard_methods', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('php_dashboard_methods', 'required', 'false');
			}
		}
		// Modify the form based on Edit Add Php Preflight Install access controls.
		if ($id != 0 && (!$user->authorise('joomla_component.edit.add_php_preflight_install', 'com_componentbuilder.joomla_component.' . (int) $id))
			|| ($id == 0 && !$user->authorise('joomla_component.edit.add_php_preflight_install', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('add_php_preflight_install', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('add_php_preflight_install', 'readonly', 'true');
			// Disable radio button for display.
			$class = $form->getFieldAttribute('add_php_preflight_install', 'class', '');
			$form->setFieldAttribute('add_php_preflight_install', 'class', $class.' disabled no-click');
			if (!$form->getValue('add_php_preflight_install'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('add_php_preflight_install', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('add_php_preflight_install', 'required', 'false');
			}
		}
		// Modify the form based on Edit Addcontributors access controls.
		if ($id != 0 && (!$user->authorise('joomla_component.edit.addcontributors', 'com_componentbuilder.joomla_component.' . (int) $id))
			|| ($id == 0 && !$user->authorise('joomla_component.edit.addcontributors', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('addcontributors', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('addcontributors', 'readonly', 'true');
			// Disable radio button for display.
			$class = $form->getFieldAttribute('addcontributors', 'class', '');
			$form->setFieldAttribute('addcontributors', 'class', $class.' disabled no-click');
			if (!$form->getValue('addcontributors'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('addcontributors', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('addcontributors', 'required', 'false');
			}
		}
		// Modify the form based on Edit Add Php Preflight Update access controls.
		if ($id != 0 && (!$user->authorise('joomla_component.edit.add_php_preflight_update', 'com_componentbuilder.joomla_component.' . (int) $id))
			|| ($id == 0 && !$user->authorise('joomla_component.edit.add_php_preflight_update', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('add_php_preflight_update', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('add_php_preflight_update', 'readonly', 'true');
			// Disable radio button for display.
			$class = $form->getFieldAttribute('add_php_preflight_update', 'class', '');
			$form->setFieldAttribute('add_php_preflight_update', 'class', $class.' disabled no-click');
			if (!$form->getValue('add_php_preflight_update'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('add_php_preflight_update', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('add_php_preflight_update', 'required', 'false');
			}
		}
		// Modify the form based on Edit Emptycontributors access controls.
		if ($id != 0 && (!$user->authorise('joomla_component.edit.emptycontributors', 'com_componentbuilder.joomla_component.' . (int) $id))
			|| ($id == 0 && !$user->authorise('joomla_component.edit.emptycontributors', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('emptycontributors', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('emptycontributors', 'readonly', 'true');
			// Disable radio button for display.
			$class = $form->getFieldAttribute('emptycontributors', 'class', '');
			$form->setFieldAttribute('emptycontributors', 'class', $class.' disabled no-click');
			if (!$form->getValue('emptycontributors'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('emptycontributors', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('emptycontributors', 'required', 'false');
			}
		}
		// Modify the form based on Edit Add Php Postflight Install access controls.
		if ($id != 0 && (!$user->authorise('joomla_component.edit.add_php_postflight_install', 'com_componentbuilder.joomla_component.' . (int) $id))
			|| ($id == 0 && !$user->authorise('joomla_component.edit.add_php_postflight_install', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('add_php_postflight_install', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('add_php_postflight_install', 'readonly', 'true');
			// Disable radio button for display.
			$class = $form->getFieldAttribute('add_php_postflight_install', 'class', '');
			$form->setFieldAttribute('add_php_postflight_install', 'class', $class.' disabled no-click');
			if (!$form->getValue('add_php_postflight_install'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('add_php_postflight_install', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('add_php_postflight_install', 'required', 'false');
			}
		}
		// Modify the form based on Edit Number access controls.
		if ($id != 0 && (!$user->authorise('joomla_component.edit.number', 'com_componentbuilder.joomla_component.' . (int) $id))
			|| ($id == 0 && !$user->authorise('joomla_component.edit.number', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('number', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('number', 'readonly', 'true');
			if (!$form->getValue('number'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('number', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('number', 'required', 'false');
			}
		}
		// Modify the form based on Edit Add Php Postflight Update access controls.
		if ($id != 0 && (!$user->authorise('joomla_component.edit.add_php_postflight_update', 'com_componentbuilder.joomla_component.' . (int) $id))
			|| ($id == 0 && !$user->authorise('joomla_component.edit.add_php_postflight_update', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('add_php_postflight_update', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('add_php_postflight_update', 'readonly', 'true');
			// Disable radio button for display.
			$class = $form->getFieldAttribute('add_php_postflight_update', 'class', '');
			$form->setFieldAttribute('add_php_postflight_update', 'class', $class.' disabled no-click');
			if (!$form->getValue('add_php_postflight_update'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('add_php_postflight_update', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('add_php_postflight_update', 'required', 'false');
			}
		}
		// Modify the form based on Edit Add Php Method Uninstall access controls.
		if ($id != 0 && (!$user->authorise('joomla_component.edit.add_php_method_uninstall', 'com_componentbuilder.joomla_component.' . (int) $id))
			|| ($id == 0 && !$user->authorise('joomla_component.edit.add_php_method_uninstall', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('add_php_method_uninstall', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('add_php_method_uninstall', 'readonly', 'true');
			// Disable radio button for display.
			$class = $form->getFieldAttribute('add_php_method_uninstall', 'class', '');
			$form->setFieldAttribute('add_php_method_uninstall', 'class', $class.' disabled no-click');
			if (!$form->getValue('add_php_method_uninstall'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('add_php_method_uninstall', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('add_php_method_uninstall', 'required', 'false');
			}
		}
		// Modify the form based on Edit Add Sql access controls.
		if ($id != 0 && (!$user->authorise('joomla_component.edit.add_sql', 'com_componentbuilder.joomla_component.' . (int) $id))
			|| ($id == 0 && !$user->authorise('joomla_component.edit.add_sql', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('add_sql', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('add_sql', 'readonly', 'true');
			// Disable radio button for display.
			$class = $form->getFieldAttribute('add_sql', 'class', '');
			$form->setFieldAttribute('add_sql', 'class', $class.' disabled no-click');
			if (!$form->getValue('add_sql'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('add_sql', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('add_sql', 'required', 'false');
			}
		}
		// Modify the form based on Edit Addfiles access controls.
		if ($id != 0 && (!$user->authorise('joomla_component.edit.addfiles', 'com_componentbuilder.joomla_component.' . (int) $id))
			|| ($id == 0 && !$user->authorise('joomla_component.edit.addfiles', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('addfiles', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('addfiles', 'readonly', 'true');
			// Disable radio button for display.
			$class = $form->getFieldAttribute('addfiles', 'class', '');
			$form->setFieldAttribute('addfiles', 'class', $class.' disabled no-click');
			if (!$form->getValue('addfiles'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('addfiles', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('addfiles', 'required', 'false');
			}
		}
		// Modify the form based on Edit Addreadme access controls.
		if ($id != 0 && (!$user->authorise('joomla_component.edit.addreadme', 'com_componentbuilder.joomla_component.' . (int) $id))
			|| ($id == 0 && !$user->authorise('joomla_component.edit.addreadme', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('addreadme', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('addreadme', 'readonly', 'true');
			// Disable radio button for display.
			$class = $form->getFieldAttribute('addreadme', 'class', '');
			$form->setFieldAttribute('addreadme', 'class', $class.' disabled no-click');
			if (!$form->getValue('addreadme'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('addreadme', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('addreadme', 'required', 'false');
			}
		}
		// Modify the form based on Edit Update Server access controls.
		if ($id != 0 && (!$user->authorise('joomla_component.edit.update_server', 'com_componentbuilder.joomla_component.' . (int) $id))
			|| ($id == 0 && !$user->authorise('joomla_component.edit.update_server', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('update_server', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('update_server', 'readonly', 'true');
			if (!$form->getValue('update_server'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('update_server', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('update_server', 'required', 'false');
			}
		}
		// Modify the form based on Edit Addfolders access controls.
		if ($id != 0 && (!$user->authorise('joomla_component.edit.addfolders', 'com_componentbuilder.joomla_component.' . (int) $id))
			|| ($id == 0 && !$user->authorise('joomla_component.edit.addfolders', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('addfolders', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('addfolders', 'readonly', 'true');
			// Disable radio button for display.
			$class = $form->getFieldAttribute('addfolders', 'class', '');
			$form->setFieldAttribute('addfolders', 'class', $class.' disabled no-click');
			if (!$form->getValue('addfolders'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('addfolders', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('addfolders', 'required', 'false');
			}
		}
		// Modify the form based on Edit Add Sales Server access controls.
		if ($id != 0 && (!$user->authorise('joomla_component.edit.add_sales_server', 'com_componentbuilder.joomla_component.' . (int) $id))
			|| ($id == 0 && !$user->authorise('joomla_component.edit.add_sales_server', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('add_sales_server', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('add_sales_server', 'readonly', 'true');
			// Disable radio button for display.
			$class = $form->getFieldAttribute('add_sales_server', 'class', '');
			$form->setFieldAttribute('add_sales_server', 'class', $class.' disabled no-click');
			if (!$form->getValue('add_sales_server'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('add_sales_server', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('add_sales_server', 'required', 'false');
			}
		}
		// Modify the form based on Edit Toignore access controls.
		if ($id != 0 && (!$user->authorise('joomla_component.edit.toignore', 'com_componentbuilder.joomla_component.' . (int) $id))
			|| ($id == 0 && !$user->authorise('joomla_component.edit.toignore', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('toignore', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('toignore', 'readonly', 'true');
			if (!$form->getValue('toignore'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('toignore', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('toignore', 'required', 'false');
			}
		}
		// Modify the form based on Edit Buildcompsql access controls.
		if ($id != 0 && (!$user->authorise('joomla_component.edit.buildcompsql', 'com_componentbuilder.joomla_component.' . (int) $id))
			|| ($id == 0 && !$user->authorise('joomla_component.edit.buildcompsql', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('buildcompsql', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('buildcompsql', 'readonly', 'true');
			if (!$form->getValue('buildcompsql'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('buildcompsql', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('buildcompsql', 'required', 'false');
			}
		}
		// Only load these values if no id is found
		if (0 == $id)
		{
			// Set redirected field name
			$redirectedField = $jinput->get('ref', null, 'STRING');
			// Set redirected field value
			$redirectedValue = $jinput->get('refid', 0, 'INT');
			if (0 != $redirectedValue && $redirectedField)
			{
				// Now set the local-redirected field default value
				$form->setValue($redirectedField, null, $redirectedValue);
			}
		}

		return $form;
	}

	/**
	 * Method to get the script that have to be included on the form
	 *
	 * @return string	script files
	 */
	public function getScript()
	{
		return 'administrator/components/com_componentbuilder/models/forms/joomla_component.js';
	}
    
	/**
	 * Method to test whether a record can be deleted.
	 *
	 * @param   object  $record  A record object.
	 *
	 * @return  boolean  True if allowed to delete the record. Defaults to the permission set in the component.
	 *
	 * @since   1.6
	 */
	protected function canDelete($record)
	{
		if (!empty($record->id))
		{
			if ($record->published != -2)
			{
				return;
			}

			$user = JFactory::getUser();
			// The record has been set. Check the record permissions.
			return $user->authorise('core.delete', 'com_componentbuilder.joomla_component.' . (int) $record->id);
		}
		return false;
	}

	/**
	 * Method to test whether a record can have its state edited.
	 *
	 * @param   object  $record  A record object.
	 *
	 * @return  boolean  True if allowed to change the state of the record. Defaults to the permission set in the component.
	 *
	 * @since   1.6
	 */
	protected function canEditState($record)
	{
		$user = JFactory::getUser();
		$recordId	= (!empty($record->id)) ? $record->id : 0;

		if ($recordId)
		{
			// The record has been set. Check the record permissions.
			$permission = $user->authorise('core.edit.state', 'com_componentbuilder.joomla_component.' . (int) $recordId);
			if (!$permission && !is_null($permission))
			{
				return false;
			}
		}
		// In the absense of better information, revert to the component permissions.
		return parent::canEditState($record);
	}
    
	/**
	 * Method override to check if you can edit an existing record.
	 *
	 * @param	array	$data	An array of input data.
	 * @param	string	$key	The name of the key for the primary key.
	 *
	 * @return	boolean
	 * @since	2.5
	 */
	protected function allowEdit($data = array(), $key = 'id')
	{
		// Check specific edit permission then general edit permission.

		return JFactory::getUser()->authorise('core.edit', 'com_componentbuilder.joomla_component.'. ((int) isset($data[$key]) ? $data[$key] : 0)) or parent::allowEdit($data, $key);
	}
    
	/**
	 * Prepare and sanitise the table data prior to saving.
	 *
	 * @param   JTable  $table  A JTable object.
	 *
	 * @return  void
	 *
	 * @since   1.6
	 */
	protected function prepareTable($table)
	{
		$date = JFactory::getDate();
		$user = JFactory::getUser();
		
		if (isset($table->name))
		{
			$table->name = htmlspecialchars_decode($table->name, ENT_QUOTES);
		}
		
		if (isset($table->alias) && empty($table->alias))
		{
			$table->generateAlias();
		}
		
		if (empty($table->id))
		{
			$table->created = $date->toSql();
			// set the user
			if ($table->created_by == 0 || empty($table->created_by))
			{
				$table->created_by = $user->id;
			}
			// Set ordering to the last item if not set
			if (empty($table->ordering))
			{
				$db = JFactory::getDbo();
				$query = $db->getQuery(true)
					->select('MAX(ordering)')
					->from($db->quoteName('#__componentbuilder_joomla_component'));
				$db->setQuery($query);
				$max = $db->loadResult();

				$table->ordering = $max + 1;
			}
		}
		else
		{
			$table->modified = $date->toSql();
			$table->modified_by = $user->id;
		}
        
		if (!empty($table->id))
		{
			// Increment the items version number.
			$table->version++;
		}
	}

	/**
	 * Method to get the data that should be injected in the form.
	 *
	 * @return  mixed  The data for the form.
	 *
	 * @since   1.6
	 */
	protected function loadFormData() 
	{
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState('com_componentbuilder.edit.joomla_component.data', array());

		if (empty($data))
		{
			$data = $this->getItem();
		}

		return $data;
	}

	/**
	* Method to validate the form data.
	*
	* @param   JForm   $form   The form to validate against.
	* @param   array   $data   The data to validate.
	* @param   string  $group  The name of the field group to validate.
	*
	* @return  mixed  Array of filtered data if valid, false otherwise.
	*
	* @see     JFormRule
	* @see     JFilterInput
	* @since   12.2
	*/
	public function validate($form, $data, $group = null)
	{
		// check if the not_required field is set
		if (ComponentbuilderHelper::checkString($data['not_required']))
		{
			$requiredFields = (array) explode(',',(string) $data['not_required']);
			$requiredFields = array_unique($requiredFields);
			// now change the required field attributes value
			foreach ($requiredFields as $requiredField)
			{
				// make sure there is a string value
				if (ComponentbuilderHelper::checkString($requiredField))
				{
					// change to false
					$form->setFieldAttribute($requiredField, 'required', 'false');
					// also clear the data set
					$data[$requiredField] = '';
				}
			}
		}
		return parent::validate($form, $data, $group);
	} 

	/**
	 * Method to get the unique fields of this table.
	 *
	 * @return  mixed  An array of field names, boolean false if none is set.
	 *
	 * @since   3.0
	 */
	protected function getUniqeFields()
	{
		return false;
	}
	
	/**
	 * Method to delete one or more records.
	 *
	 * @param   array  &$pks  An array of record primary keys.
	 *
	 * @return  boolean  True if successful, false if an error occurs.
	 *
	 * @since   12.2
	 */
	public function delete(&$pks)
	{
		if (!parent::delete($pks))
		{
			return false;
		}
		
		return true;
	}

	/**
	 * Method to change the published state of one or more records.
	 *
	 * @param   array    &$pks   A list of the primary keys to change.
	 * @param   integer  $value  The value of the published state.
	 *
	 * @return  boolean  True on success.
	 *
	 * @since   12.2
	 */
	public function publish(&$pks, $value = 1)
	{
		if (!parent::publish($pks, $value))
		{
			return false;
		}
		
		return true;
        }
    
	/**
	 * Method to perform batch operations on an item or a set of items.
	 *
	 * @param   array  $commands  An array of commands to perform.
	 * @param   array  $pks       An array of item ids.
	 * @param   array  $contexts  An array of item contexts.
	 *
	 * @return  boolean  Returns true on success, false on failure.
	 *
	 * @since   12.2
	 */
	public function batch($commands, $pks, $contexts)
	{
		// Sanitize ids.
		$pks = array_unique($pks);
		JArrayHelper::toInteger($pks);

		// Remove any values of zero.
		if (array_search(0, $pks, true))
		{
			unset($pks[array_search(0, $pks, true)]);
		}

		if (empty($pks))
		{
			$this->setError(JText::_('JGLOBAL_NO_ITEM_SELECTED'));
			return false;
		}

		$done = false;

		// Set some needed variables.
		$this->user			= JFactory::getUser();
		$this->table			= $this->getTable();
		$this->tableClassName		= get_class($this->table);
		$this->contentType		= new JUcmType;
		$this->type			= $this->contentType->getTypeByTable($this->tableClassName);
		$this->canDo			= ComponentbuilderHelper::getActions('joomla_component');
		$this->batchSet			= true;

		if (!$this->canDo->get('core.batch'))
		{
			$this->setError(JText::_('JLIB_APPLICATION_ERROR_INSUFFICIENT_BATCH_INFORMATION'));
			return false;
		}
        
		if ($this->type == false)
		{
			$type = new JUcmType;
			$this->type = $type->getTypeByAlias($this->typeAlias);
		}

		$this->tagsObserver = $this->table->getObserverOfClass('JTableObserverTags');

		if (!empty($commands['move_copy']))
		{
			$cmd = JArrayHelper::getValue($commands, 'move_copy', 'c');

			if ($cmd == 'c')
			{
				$result = $this->batchCopy($commands, $pks, $contexts);

				if (is_array($result))
				{
					foreach ($result as $old => $new)
					{
						$contexts[$new] = $contexts[$old];
					}
					$pks = array_values($result);
				}
				else
				{
					return false;
				}
			}
			elseif ($cmd == 'm' && !$this->batchMove($commands, $pks, $contexts))
			{
				return false;
			}

			$done = true;
		}

		if (!$done)
		{
			$this->setError(JText::_('JLIB_APPLICATION_ERROR_INSUFFICIENT_BATCH_INFORMATION'));

			return false;
		}

		// Clear the cache
		$this->cleanCache();

		return true;
	}

	/**
	 * Batch copy items to a new category or current.
	 *
	 * @param   integer  $values    The new values.
	 * @param   array    $pks       An array of row IDs.
	 * @param   array    $contexts  An array of item contexts.
	 *
	 * @return  mixed  An array of new IDs on success, boolean false on failure.
	 *
	 * @since	12.2
	 */
	protected function batchCopy($values, $pks, $contexts)
	{
		if (empty($this->batchSet))
		{
			// Set some needed variables.
			$this->user 		= JFactory::getUser();
			$this->table 		= $this->getTable();
			$this->tableClassName	= get_class($this->table);
			$this->contentType	= new JUcmType;
			$this->type		= $this->contentType->getTypeByTable($this->tableClassName);
			$this->canDo		= ComponentbuilderHelper::getActions('joomla_component');
		}

		if (!$this->canDo->get('core.create') || !$this->canDo->get('core.batch'))
		{
			return false;
		}

		// get list of uniqe fields
		$uniqeFields = $this->getUniqeFields();
		// remove move_copy from array
		unset($values['move_copy']);

		// make sure published is set
		if (!isset($values['published']))
		{
			$values['published'] = 0;
		}
		elseif (isset($values['published']) && !$this->canDo->get('core.edit.state'))
		{
				$values['published'] = 0;
		}

		$newIds = array();

		// Parent exists so let's proceed
		while (!empty($pks))
		{
			// Pop the first ID off the stack
			$pk = array_shift($pks);

			$this->table->reset();

			// only allow copy if user may edit this item.

			if (!$this->user->authorise('core.edit', $contexts[$pk]))

			{

				// Not fatal error

				$this->setError(JText::sprintf('JLIB_APPLICATION_ERROR_BATCH_MOVE_ROW_NOT_FOUND', $pk));

				continue;

			}

			// Check that the row actually exists
			if (!$this->table->load($pk))
			{
				if ($error = $this->table->getError())
				{
					// Fatal error
					$this->setError($error);

					return false;
				}
				else
				{
					// Not fatal error
					$this->setError(JText::sprintf('JLIB_APPLICATION_ERROR_BATCH_MOVE_ROW_NOT_FOUND', $pk));
					continue;
				}
			}

			$this->table->name = $this->generateUniqe('name',$this->table->name);

			// insert all set values
			if (ComponentbuilderHelper::checkArray($values))
			{
				foreach ($values as $key => $value)
				{
					if (strlen($value) > 0 && isset($this->table->$key))
					{
						$this->table->$key = $value;
					}
				}
			}

			// update all uniqe fields
			if (ComponentbuilderHelper::checkArray($uniqeFields))
			{
				foreach ($uniqeFields as $uniqeField)
				{
					$this->table->$uniqeField = $this->generateUniqe($uniqeField,$this->table->$uniqeField);
				}
			}

			// Reset the ID because we are making a copy
			$this->table->id = 0;

			// TODO: Deal with ordering?
			// $this->table->ordering	= 1;

			// Check the row.
			if (!$this->table->check())
			{
				$this->setError($this->table->getError());

				return false;
			}

			if (!empty($this->type))
			{
				$this->createTagsHelper($this->tagsObserver, $this->type, $pk, $this->typeAlias, $this->table);
			}

			// Store the row.
			if (!$this->table->store())
			{
				$this->setError($this->table->getError());

				return false;
			}

			// Get the new item ID
			$newId = $this->table->get('id');

			// Add the new ID to the array
			$newIds[$pk] = $newId;
		}

		// Clean the cache
		$this->cleanCache();

		return $newIds;
	} 

	/**
	 * Batch move items to a new category
	 *
	 * @param   integer  $value     The new category ID.
	 * @param   array    $pks       An array of row IDs.
	 * @param   array    $contexts  An array of item contexts.
	 *
	 * @return  boolean  True if successful, false otherwise and internal error is set.
	 *
	 * @since	12.2
	 */
	protected function batchMove($values, $pks, $contexts)
	{
		if (empty($this->batchSet))
		{
			// Set some needed variables.
			$this->user		= JFactory::getUser();
			$this->table		= $this->getTable();
			$this->tableClassName	= get_class($this->table);
			$this->contentType	= new JUcmType;
			$this->type		= $this->contentType->getTypeByTable($this->tableClassName);
			$this->canDo		= ComponentbuilderHelper::getActions('joomla_component');
		}

		if (!$this->canDo->get('core.edit') && !$this->canDo->get('core.batch'))
		{
			$this->setError(JText::_('JLIB_APPLICATION_ERROR_BATCH_CANNOT_EDIT'));
			return false;
		}

		// make sure published only updates if user has the permission.
		if (isset($values['published']) && !$this->canDo->get('core.edit.state'))
		{
			unset($values['published']);
		}
		// remove move_copy from array
		unset($values['move_copy']);

		// Parent exists so we proceed
		foreach ($pks as $pk)
		{
			if (!$this->user->authorise('core.edit', $contexts[$pk]))
			{
				$this->setError(JText::_('JLIB_APPLICATION_ERROR_BATCH_CANNOT_EDIT'));

				return false;
			}

			// Check that the row actually exists
			if (!$this->table->load($pk))
			{
				if ($error = $this->table->getError())
				{
					// Fatal error
					$this->setError($error);

					return false;
				}
				else
				{
					// Not fatal error
					$this->setError(JText::sprintf('JLIB_APPLICATION_ERROR_BATCH_MOVE_ROW_NOT_FOUND', $pk));
					continue;
				}
			}

			// insert all set values.
			if (ComponentbuilderHelper::checkArray($values))
			{
				foreach ($values as $key => $value)
				{
					// Do special action for access.
					if ('access' === $key && strlen($value) > 0)
					{
						$this->table->$key = $value;
					}
					elseif (strlen($value) > 0 && isset($this->table->$key))
					{
						$this->table->$key = $value;
					}
				}
			}


			// Check the row.
			if (!$this->table->check())
			{
				$this->setError($this->table->getError());

				return false;
			}

			if (!empty($this->type))
			{
				$this->createTagsHelper($this->tagsObserver, $this->type, $pk, $this->typeAlias, $this->table);
			}

			// Store the row.
			if (!$this->table->store())
			{
				$this->setError($this->table->getError());

				return false;
			}
		}

		// Clean the cache
		$this->cleanCache();

		return true;
	}
	
	/**
	 * Method to save the form data.
	 *
	 * @param   array  $data  The form data.
	 *
	 * @return  boolean  True on success.
	 *
	 * @since   1.6
	 */
	public function save($data)
	{
		$input	= JFactory::getApplication()->input;
		$filter	= JFilterInput::getInstance();
        
		// set the metadata to the Item Data
		if (isset($data['metadata']) && isset($data['metadata']['author']))
		{
			$data['metadata']['author'] = $filter->clean($data['metadata']['author'], 'TRIM');
            
			$metadata = new JRegistry;
			$metadata->loadArray($data['metadata']);
			$data['metadata'] = (string) $metadata;
		} 

		// Set the readme string to base64 string.
		if (isset($data['readme']))
		{
			$data['readme'] = base64_encode($data['readme']);
		}

		// Set the php_postflight_install string to base64 string.
		if (isset($data['php_postflight_install']))
		{
			$data['php_postflight_install'] = base64_encode($data['php_postflight_install']);
		}

		// Set the php_preflight_install string to base64 string.
		if (isset($data['php_preflight_install']))
		{
			$data['php_preflight_install'] = base64_encode($data['php_preflight_install']);
		}

		// Set the php_method_uninstall string to base64 string.
		if (isset($data['php_method_uninstall']))
		{
			$data['php_method_uninstall'] = base64_encode($data['php_method_uninstall']);
		}

		// Set the css string to base64 string.
		if (isset($data['css']))
		{
			$data['css'] = base64_encode($data['css']);
		}

		// Set the php_preflight_update string to base64 string.
		if (isset($data['php_preflight_update']))
		{
			$data['php_preflight_update'] = base64_encode($data['php_preflight_update']);
		}

		// Set the php_postflight_update string to base64 string.
		if (isset($data['php_postflight_update']))
		{
			$data['php_postflight_update'] = base64_encode($data['php_postflight_update']);
		}

		// Set the sql string to base64 string.
		if (isset($data['sql']))
		{
			$data['sql'] = base64_encode($data['sql']);
		}

		// Set the php_helper_both string to base64 string.
		if (isset($data['php_helper_both']))
		{
			$data['php_helper_both'] = base64_encode($data['php_helper_both']);
		}

		// Set the php_helper_admin string to base64 string.
		if (isset($data['php_helper_admin']))
		{
			$data['php_helper_admin'] = base64_encode($data['php_helper_admin']);
		}

		// Set the php_admin_event string to base64 string.
		if (isset($data['php_admin_event']))
		{
			$data['php_admin_event'] = base64_encode($data['php_admin_event']);
		}

		// Set the php_helper_site string to base64 string.
		if (isset($data['php_helper_site']))
		{
			$data['php_helper_site'] = base64_encode($data['php_helper_site']);
		}

		// Set the php_site_event string to base64 string.
		if (isset($data['php_site_event']))
		{
			$data['php_site_event'] = base64_encode($data['php_site_event']);
		}

		// Set the php_dashboard_methods string to base64 string.
		if (isset($data['php_dashboard_methods']))
		{
			$data['php_dashboard_methods'] = base64_encode($data['php_dashboard_methods']);
		}

		// Set the buildcompsql string to base64 string.
		if (isset($data['buildcompsql']))
		{
			$data['buildcompsql'] = base64_encode($data['buildcompsql']);
		}

		// Get the basic encryption key.
		$basickey = ComponentbuilderHelper::getCryptKey('basic');
		// Get the encryption object
		$basic = new FOFEncryptAes($basickey, 128);

		// Encrypt data whmcs_key.
		if (isset($data['whmcs_key']) && $basickey)
		{
			$data['whmcs_key'] = $basic->encryptString($data['whmcs_key']);
		}

		// Encrypt data export_key.
		if (isset($data['export_key']) && $basickey)
		{
			$data['export_key'] = $basic->encryptString($data['export_key']);
		}

		// we check if component should be build from sql file
		ComponentbuilderHelper::dynamicBuilder($data, 1);
        
		// Set the Params Items to data
		if (isset($data['params']) && is_array($data['params']))
		{
			$params = new JRegistry;
			$params->loadArray($data['params']);
			$data['params'] = (string) $params;
		}

		// Alter the uniqe field for save as copy
		if ($input->get('task') === 'save2copy')
		{
			// Automatic handling of other uniqe fields
			$uniqeFields = $this->getUniqeFields();
			if (ComponentbuilderHelper::checkArray($uniqeFields))
			{
				foreach ($uniqeFields as $uniqeField)
				{
					$data[$uniqeField] = $this->generateUniqe($uniqeField,$data[$uniqeField]);
				}
			}
		}
		
		if (parent::save($data))
		{
			return true;
		}
		return false;
	}
	
	/**
	 * Method to generate a uniqe value.
	 *
	 * @param   string  $field name.
	 * @param   string  $value data.
	 *
	 * @return  string  New value.
	 *
	 * @since   3.0
	 */
	protected function generateUniqe($field,$value)
	{

		// set field value uniqe 
		$table = $this->getTable();

		while ($table->load(array($field => $value)))
		{
			$value = JString::increment($value);
		}

		return $value;
	}

	/**
	* Method to change the title & alias.
	*
	* @param   string   $title        The title.
	*
	* @return	array  Contains the modified title and alias.
	*
	*/
	protected function _generateNewTitle($title)
	{

		// Alter the title
		$table = $this->getTable();

		while ($table->load(array('title' => $title)))
		{
			$title = JString::increment($title);
		}

		return $title;
	}
}
