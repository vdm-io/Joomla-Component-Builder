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

	@version		@update number 114 of this MVC
	@build			28th August, 2017
	@created		30th April, 2015
	@package		Component Builder
	@subpackage		admin_view.php
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
 * Componentbuilder Admin_view Model
 */
class ComponentbuilderModelAdmin_view extends JModelAdmin
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
	public $typeAlias = 'com_componentbuilder.admin_view';

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
	public function getTable($type = 'admin_view', $prefix = 'ComponentbuilderTable', $config = array())
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

			if (!empty($item->php_batchmove))
			{
				// base64 Decode php_batchmove.
				$item->php_batchmove = base64_decode($item->php_batchmove);
			}

			if (!empty($item->php_save))
			{
				// base64 Decode php_save.
				$item->php_save = base64_decode($item->php_save);
			}

			if (!empty($item->php_after_delete))
			{
				// base64 Decode php_after_delete.
				$item->php_after_delete = base64_decode($item->php_after_delete);
			}

			if (!empty($item->php_getlistquery))
			{
				// base64 Decode php_getlistquery.
				$item->php_getlistquery = base64_decode($item->php_getlistquery);
			}

			if (!empty($item->php_allowedit))
			{
				// base64 Decode php_allowedit.
				$item->php_allowedit = base64_decode($item->php_allowedit);
			}

			if (!empty($item->php_after_publish))
			{
				// base64 Decode php_after_publish.
				$item->php_after_publish = base64_decode($item->php_after_publish);
			}

			if (!empty($item->php_getitems))
			{
				// base64 Decode php_getitems.
				$item->php_getitems = base64_decode($item->php_getitems);
			}

			if (!empty($item->php_import))
			{
				// base64 Decode php_import.
				$item->php_import = base64_decode($item->php_import);
			}

			if (!empty($item->php_getitems_after_all))
			{
				// base64 Decode php_getitems_after_all.
				$item->php_getitems_after_all = base64_decode($item->php_getitems_after_all);
			}

			if (!empty($item->php_before_save))
			{
				// base64 Decode php_before_save.
				$item->php_before_save = base64_decode($item->php_before_save);
			}

			if (!empty($item->php_postsavehook))
			{
				// base64 Decode php_postsavehook.
				$item->php_postsavehook = base64_decode($item->php_postsavehook);
			}

			if (!empty($item->php_batchcopy))
			{
				// base64 Decode php_batchcopy.
				$item->php_batchcopy = base64_decode($item->php_batchcopy);
			}

			if (!empty($item->php_before_publish))
			{
				// base64 Decode php_before_publish.
				$item->php_before_publish = base64_decode($item->php_before_publish);
			}

			if (!empty($item->php_before_delete))
			{
				// base64 Decode php_before_delete.
				$item->php_before_delete = base64_decode($item->php_before_delete);
			}

			if (!empty($item->php_document))
			{
				// base64 Decode php_document.
				$item->php_document = base64_decode($item->php_document);
			}

			if (!empty($item->sql))
			{
				// base64 Decode sql.
				$item->sql = base64_decode($item->sql);
			}

			if (!empty($item->php_import_display))
			{
				// base64 Decode php_import_display.
				$item->php_import_display = base64_decode($item->php_import_display);
			}

			if (!empty($item->php_getitem))
			{
				// base64 Decode php_getitem.
				$item->php_getitem = base64_decode($item->php_getitem);
			}

			if (!empty($item->php_import_save))
			{
				// base64 Decode php_import_save.
				$item->php_import_save = base64_decode($item->php_import_save);
			}

			if (!empty($item->css_view))
			{
				// base64 Decode css_view.
				$item->css_view = base64_decode($item->css_view);
			}

			if (!empty($item->css_views))
			{
				// base64 Decode css_views.
				$item->css_views = base64_decode($item->css_views);
			}

			if (!empty($item->javascript_view_file))
			{
				// base64 Decode javascript_view_file.
				$item->javascript_view_file = base64_decode($item->javascript_view_file);
			}

			if (!empty($item->javascript_view_footer))
			{
				// base64 Decode javascript_view_footer.
				$item->javascript_view_footer = base64_decode($item->javascript_view_footer);
			}

			if (!empty($item->javascript_views_file))
			{
				// base64 Decode javascript_views_file.
				$item->javascript_views_file = base64_decode($item->javascript_views_file);
			}

			if (!empty($item->javascript_views_footer))
			{
				// base64 Decode javascript_views_footer.
				$item->javascript_views_footer = base64_decode($item->javascript_views_footer);
			}

			if (!empty($item->php_controller))
			{
				// base64 Decode php_controller.
				$item->php_controller = base64_decode($item->php_controller);
			}

			if (!empty($item->php_model))
			{
				// base64 Decode php_model.
				$item->php_model = base64_decode($item->php_model);
			}

			if (!empty($item->php_controller_list))
			{
				// base64 Decode php_controller_list.
				$item->php_controller_list = base64_decode($item->php_controller_list);
			}

			if (!empty($item->php_model_list))
			{
				// base64 Decode php_model_list.
				$item->php_model_list = base64_decode($item->php_model_list);
			}

			if (!empty($item->php_ajaxmethod))
			{
				// base64 Decode php_ajaxmethod.
				$item->php_ajaxmethod = base64_decode($item->php_ajaxmethod);
			}

			if (!empty($item->html_import_view))
			{
				// base64 Decode html_import_view.
				$item->html_import_view = base64_decode($item->html_import_view);
			}

			if (!empty($item->php_import_setdata))
			{
				// base64 Decode php_import_setdata.
				$item->php_import_setdata = base64_decode($item->php_import_setdata);
			}

			if (!empty($item->php_import_ext))
			{
				// base64 Decode php_import_ext.
				$item->php_import_ext = base64_decode($item->php_import_ext);
			}
			
			if (!empty($item->id))
			{
				$item->tags = new JHelperTags;
				$item->tags->getTagIds($item->id, 'com_componentbuilder.admin_view');
			}
		}
		$this->idvvvz = $item->addfields;
		$this->addadmin_viewsvvwa = $item->id;

		return $item;
	}

	/**
	* Method to get list data.
	*
	* @return mixed  An array of data items on success, false on failure.
	*/
	public function getVxzfields()
	{
		// Get the user object.
		$user = JFactory::getUser();
		// Create a new query object.
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);

		// Select some fields
		$query->select('a.*');
		$query->select($db->quoteName('c.title','category_title'));

		// From the componentbuilder_field table
		$query->from($db->quoteName('#__componentbuilder_field', 'a'));
		$query->join('LEFT', $db->quoteName('#__categories', 'c') . ' ON (' . $db->quoteName('a.catid') . ' = ' . $db->quoteName('c.id') . ')');

		// From the componentbuilder_fieldtype table.
		$query->select($db->quoteName('g.name','fieldtype_name'));
		$query->join('LEFT', $db->quoteName('#__componentbuilder_fieldtype', 'g') . ' ON (' . $db->quoteName('a.fieldtype') . ' = ' . $db->quoteName('g.id') . ')');

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
					$access = ($user->authorise('field.access', 'com_componentbuilder.field.' . (int) $item->id) && $user->authorise('field.access', 'com_componentbuilder'));
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
					// convert datatype
					$item->datatype = $this->selectionTranslationVxzfields($item->datatype, 'datatype');
					// convert indexes
					$item->indexes = $this->selectionTranslationVxzfields($item->indexes, 'indexes');
					// convert null_switch
					$item->null_switch = $this->selectionTranslationVxzfields($item->null_switch, 'null_switch');
					// convert store
					$item->store = $this->selectionTranslationVxzfields($item->store, 'store');
				}
			}


			// Filter by id Repetable Field
			$idvvvz = json_decode($this->idvvvz,true);
			if (ComponentbuilderHelper::checkArray($items) && isset($idvvvz) && ComponentbuilderHelper::checkArray($idvvvz))
			{
				foreach ($items as $nr => &$item)
				{
					if ($item->id && isset($idvvvz['field']) && ComponentbuilderHelper::checkArray($idvvvz['field']))
					{
						if (!in_array($item->id,$idvvvz['field']))
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
	* Method to convert selection values to translatable string.
	*
	* @return translatable string
	*/
	public function selectionTranslationVxzfields($value,$name)
	{
		// Array of datatype language strings
		if ($name === 'datatype')
		{
			$datatypeArray = array(
				'CHAR' => 'COM_COMPONENTBUILDER_FIELD_CHAR',
				'VARCHAR' => 'COM_COMPONENTBUILDER_FIELD_VARCHAR',
				'TEXT' => 'COM_COMPONENTBUILDER_FIELD_TEXT',
				'MEDIUMTEXT' => 'COM_COMPONENTBUILDER_FIELD_MEDIUMTEXT',
				'LONGTEXT' => 'COM_COMPONENTBUILDER_FIELD_LONGTEXT',
				'DATETIME' => 'COM_COMPONENTBUILDER_FIELD_DATETIME',
				'DATE' => 'COM_COMPONENTBUILDER_FIELD_DATE',
				'TIME' => 'COM_COMPONENTBUILDER_FIELD_TIME',
				'INT' => 'COM_COMPONENTBUILDER_FIELD_INT',
				'TINYINT' => 'COM_COMPONENTBUILDER_FIELD_TINYINT',
				'BIGINT' => 'COM_COMPONENTBUILDER_FIELD_BIGINT',
				'FLOAT' => 'COM_COMPONENTBUILDER_FIELD_FLOAT',
				'DECIMAL' => 'COM_COMPONENTBUILDER_FIELD_DECIMAL',
				'DOUBLE' => 'COM_COMPONENTBUILDER_FIELD_DOUBLE'
			);
			// Now check if value is found in this array
			if (isset($datatypeArray[$value]) && ComponentbuilderHelper::checkString($datatypeArray[$value]))
			{
				return $datatypeArray[$value];
			}
		}
		// Array of indexes language strings
		if ($name === 'indexes')
		{
			$indexesArray = array(
				1 => 'COM_COMPONENTBUILDER_FIELD_UNIQUE_KEY',
				2 => 'COM_COMPONENTBUILDER_FIELD_KEY',
				0 => 'COM_COMPONENTBUILDER_FIELD_NONE'
			);
			// Now check if value is found in this array
			if (isset($indexesArray[$value]) && ComponentbuilderHelper::checkString($indexesArray[$value]))
			{
				return $indexesArray[$value];
			}
		}
		// Array of null_switch language strings
		if ($name === 'null_switch')
		{
			$null_switchArray = array(
				'NULL' => 'COM_COMPONENTBUILDER_FIELD_NULL',
				'NOT NULL' => 'COM_COMPONENTBUILDER_FIELD_NOT_NULL'
			);
			// Now check if value is found in this array
			if (isset($null_switchArray[$value]) && ComponentbuilderHelper::checkString($null_switchArray[$value]))
			{
				return $null_switchArray[$value];
			}
		}
		// Array of store language strings
		if ($name === 'store')
		{
			$storeArray = array(
				0 => 'COM_COMPONENTBUILDER_FIELD_DEFAULT',
				1 => 'COM_COMPONENTBUILDER_FIELD_JSON',
				2 => 'COM_COMPONENTBUILDER_FIELD_BASESIXTY_FOUR',
				3 => 'COM_COMPONENTBUILDER_FIELD_BASIC_ENCRYPTION_LOCALKEY',
				4 => 'COM_COMPONENTBUILDER_FIELD_ADVANCE_ENCRYPTION_WHMCSKEY'
			);
			// Now check if value is found in this array
			if (isset($storeArray[$value]) && ComponentbuilderHelper::checkString($storeArray[$value]))
			{
				return $storeArray[$value];
			}
		}
		return $value;
	}

	/**
	* Method to get list data.
	*
	* @return mixed  An array of data items on success, false on failure.
	*/
	public function getVyalinked_components()
	{
		// Get the user object.
		$user = JFactory::getUser();
		// Create a new query object.
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);

		// Select some fields
		$query->select('a.*');

		// From the componentbuilder_joomla_component table
		$query->from($db->quoteName('#__componentbuilder_joomla_component', 'a'));

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

			// Filter by addadmin_viewsvvwa in this Repetable Field
			if (ComponentbuilderHelper::checkArray($items) && isset($this->addadmin_viewsvvwa))
			{
				foreach ($items as $nr => &$item)
				{
					if (isset($item->addadmin_views) && ComponentbuilderHelper::checkJson($item->addadmin_views))
					{
						$tmpArray = json_decode($item->addadmin_views,true);
						if (!isset($tmpArray['adminview']) || !ComponentbuilderHelper::checkArray($tmpArray['adminview']) || !in_array($this->addadmin_viewsvvwa, $tmpArray['adminview']))
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
		$form = $this->loadForm('com_componentbuilder.admin_view', 'admin_view', array('control' => 'jform', 'load_data' => $loadData));

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
		if ($id != 0 && (!$user->authorise('core.edit.state', 'com_componentbuilder.admin_view.' . (int) $id))
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
		if ($id != 0 && (!$user->authorise('admin_view.edit.system_name', 'com_componentbuilder.admin_view.' . (int) $id))
			|| ($id == 0 && !$user->authorise('admin_view.edit.system_name', 'com_componentbuilder')))
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
		// Modify the form based on Edit Name Single access controls.
		if ($id != 0 && (!$user->authorise('admin_view.edit.name_single', 'com_componentbuilder.admin_view.' . (int) $id))
			|| ($id == 0 && !$user->authorise('admin_view.edit.name_single', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('name_single', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('name_single', 'readonly', 'true');
			if (!$form->getValue('name_single'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('name_single', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('name_single', 'required', 'false');
			}
		}
		// Modify the form based on Edit Name List access controls.
		if ($id != 0 && (!$user->authorise('admin_view.edit.name_list', 'com_componentbuilder.admin_view.' . (int) $id))
			|| ($id == 0 && !$user->authorise('admin_view.edit.name_list', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('name_list', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('name_list', 'readonly', 'true');
			if (!$form->getValue('name_list'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('name_list', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('name_list', 'required', 'false');
			}
		}
		// Modify the form based on Edit Short Description access controls.
		if ($id != 0 && (!$user->authorise('admin_view.edit.short_description', 'com_componentbuilder.admin_view.' . (int) $id))
			|| ($id == 0 && !$user->authorise('admin_view.edit.short_description', 'com_componentbuilder')))
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
		// Modify the form based on Edit Php Batchmove access controls.
		if ($id != 0 && (!$user->authorise('admin_view.edit.php_batchmove', 'com_componentbuilder.admin_view.' . (int) $id))
			|| ($id == 0 && !$user->authorise('admin_view.edit.php_batchmove', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('php_batchmove', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('php_batchmove', 'readonly', 'true');
			if (!$form->getValue('php_batchmove'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('php_batchmove', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('php_batchmove', 'required', 'false');
			}
		}
		// Modify the form based on Edit Type access controls.
		if ($id != 0 && (!$user->authorise('admin_view.edit.type', 'com_componentbuilder.admin_view.' . (int) $id))
			|| ($id == 0 && !$user->authorise('admin_view.edit.type', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('type', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('type', 'readonly', 'true');
			if (!$form->getValue('type'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('type', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('type', 'required', 'false');
			}
		}
		// Modify the form based on Edit Php Save access controls.
		if ($id != 0 && (!$user->authorise('admin_view.edit.php_save', 'com_componentbuilder.admin_view.' . (int) $id))
			|| ($id == 0 && !$user->authorise('admin_view.edit.php_save', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('php_save', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('php_save', 'readonly', 'true');
			if (!$form->getValue('php_save'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('php_save', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('php_save', 'required', 'false');
			}
		}
		// Modify the form based on Edit Description access controls.
		if ($id != 0 && (!$user->authorise('admin_view.edit.description', 'com_componentbuilder.admin_view.' . (int) $id))
			|| ($id == 0 && !$user->authorise('admin_view.edit.description', 'com_componentbuilder')))
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
		// Modify the form based on Edit Php After Delete access controls.
		if ($id != 0 && (!$user->authorise('admin_view.edit.php_after_delete', 'com_componentbuilder.admin_view.' . (int) $id))
			|| ($id == 0 && !$user->authorise('admin_view.edit.php_after_delete', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('php_after_delete', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('php_after_delete', 'readonly', 'true');
			if (!$form->getValue('php_after_delete'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('php_after_delete', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('php_after_delete', 'required', 'false');
			}
		}
		// Modify the form based on Edit Add Fadein access controls.
		if ($id != 0 && (!$user->authorise('admin_view.edit.add_fadein', 'com_componentbuilder.admin_view.' . (int) $id))
			|| ($id == 0 && !$user->authorise('admin_view.edit.add_fadein', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('add_fadein', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('add_fadein', 'readonly', 'true');
			// Disable radio button for display.
			$class = $form->getFieldAttribute('add_fadein', 'class', '');
			$form->setFieldAttribute('add_fadein', 'class', $class.' disabled no-click');
			if (!$form->getValue('add_fadein'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('add_fadein', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('add_fadein', 'required', 'false');
			}
		}
		// Modify the form based on Edit Icon access controls.
		if ($id != 0 && (!$user->authorise('admin_view.edit.icon', 'com_componentbuilder.admin_view.' . (int) $id))
			|| ($id == 0 && !$user->authorise('admin_view.edit.icon', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('icon', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('icon', 'readonly', 'true');
			if (!$form->getValue('icon'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('icon', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('icon', 'required', 'false');
			}
		}
		// Modify the form based on Edit Php Getlistquery access controls.
		if ($id != 0 && (!$user->authorise('admin_view.edit.php_getlistquery', 'com_componentbuilder.admin_view.' . (int) $id))
			|| ($id == 0 && !$user->authorise('admin_view.edit.php_getlistquery', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('php_getlistquery', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('php_getlistquery', 'readonly', 'true');
			if (!$form->getValue('php_getlistquery'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('php_getlistquery', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('php_getlistquery', 'required', 'false');
			}
		}
		// Modify the form based on Edit Icon Add access controls.
		if ($id != 0 && (!$user->authorise('admin_view.edit.icon_add', 'com_componentbuilder.admin_view.' . (int) $id))
			|| ($id == 0 && !$user->authorise('admin_view.edit.icon_add', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('icon_add', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('icon_add', 'readonly', 'true');
			if (!$form->getValue('icon_add'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('icon_add', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('icon_add', 'required', 'false');
			}
		}
		// Modify the form based on Edit Php Allowedit access controls.
		if ($id != 0 && (!$user->authorise('admin_view.edit.php_allowedit', 'com_componentbuilder.admin_view.' . (int) $id))
			|| ($id == 0 && !$user->authorise('admin_view.edit.php_allowedit', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('php_allowedit', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('php_allowedit', 'readonly', 'true');
			if (!$form->getValue('php_allowedit'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('php_allowedit', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('php_allowedit', 'required', 'false');
			}
		}
		// Modify the form based on Edit Icon Category access controls.
		if ($id != 0 && (!$user->authorise('admin_view.edit.icon_category', 'com_componentbuilder.admin_view.' . (int) $id))
			|| ($id == 0 && !$user->authorise('admin_view.edit.icon_category', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('icon_category', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('icon_category', 'readonly', 'true');
			if (!$form->getValue('icon_category'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('icon_category', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('icon_category', 'required', 'false');
			}
		}
		// Modify the form based on Edit Php After Publish access controls.
		if ($id != 0 && (!$user->authorise('admin_view.edit.php_after_publish', 'com_componentbuilder.admin_view.' . (int) $id))
			|| ($id == 0 && !$user->authorise('admin_view.edit.php_after_publish', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('php_after_publish', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('php_after_publish', 'readonly', 'true');
			if (!$form->getValue('php_after_publish'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('php_after_publish', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('php_after_publish', 'required', 'false');
			}
		}
		// Modify the form based on Edit Source access controls.
		if ($id != 0 && (!$user->authorise('admin_view.edit.source', 'com_componentbuilder.admin_view.' . (int) $id))
			|| ($id == 0 && !$user->authorise('admin_view.edit.source', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('source', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('source', 'readonly', 'true');
			// Disable radio button for display.
			$class = $form->getFieldAttribute('source', 'class', '');
			$form->setFieldAttribute('source', 'class', $class.' disabled no-click');
			if (!$form->getValue('source'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('source', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('source', 'required', 'false');
			}
		}
		// Modify the form based on Edit Php Getitems access controls.
		if ($id != 0 && (!$user->authorise('admin_view.edit.php_getitems', 'com_componentbuilder.admin_view.' . (int) $id))
			|| ($id == 0 && !$user->authorise('admin_view.edit.php_getitems', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('php_getitems', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('php_getitems', 'readonly', 'true');
			if (!$form->getValue('php_getitems'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('php_getitems', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('php_getitems', 'required', 'false');
			}
		}
		// Modify the form based on Edit Php Import access controls.
		if ($id != 0 && (!$user->authorise('admin_view.edit.php_import', 'com_componentbuilder.admin_view.' . (int) $id))
			|| ($id == 0 && !$user->authorise('admin_view.edit.php_import', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('php_import', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('php_import', 'readonly', 'true');
			if (!$form->getValue('php_import'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('php_import', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('php_import', 'required', 'false');
			}
		}
		// Modify the form based on Edit Addpermissions access controls.
		if ($id != 0 && (!$user->authorise('admin_view.edit.addpermissions', 'com_componentbuilder.admin_view.' . (int) $id))
			|| ($id == 0 && !$user->authorise('admin_view.edit.addpermissions', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('addpermissions', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('addpermissions', 'readonly', 'true');
			// Disable radio button for display.
			$class = $form->getFieldAttribute('addpermissions', 'class', '');
			$form->setFieldAttribute('addpermissions', 'class', $class.' disabled no-click');
			if (!$form->getValue('addpermissions'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('addpermissions', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('addpermissions', 'required', 'false');
			}
		}
		// Modify the form based on Edit Php Getitems After All access controls.
		if ($id != 0 && (!$user->authorise('admin_view.edit.php_getitems_after_all', 'com_componentbuilder.admin_view.' . (int) $id))
			|| ($id == 0 && !$user->authorise('admin_view.edit.php_getitems_after_all', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('php_getitems_after_all', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('php_getitems_after_all', 'readonly', 'true');
			if (!$form->getValue('php_getitems_after_all'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('php_getitems_after_all', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('php_getitems_after_all', 'required', 'false');
			}
		}
		// Modify the form based on Edit Addtabs access controls.
		if ($id != 0 && (!$user->authorise('admin_view.edit.addtabs', 'com_componentbuilder.admin_view.' . (int) $id))
			|| ($id == 0 && !$user->authorise('admin_view.edit.addtabs', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('addtabs', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('addtabs', 'readonly', 'true');
			// Disable radio button for display.
			$class = $form->getFieldAttribute('addtabs', 'class', '');
			$form->setFieldAttribute('addtabs', 'class', $class.' disabled no-click');
			if (!$form->getValue('addtabs'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('addtabs', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('addtabs', 'required', 'false');
			}
		}
		// Modify the form based on Edit Php Before Save access controls.
		if ($id != 0 && (!$user->authorise('admin_view.edit.php_before_save', 'com_componentbuilder.admin_view.' . (int) $id))
			|| ($id == 0 && !$user->authorise('admin_view.edit.php_before_save', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('php_before_save', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('php_before_save', 'readonly', 'true');
			if (!$form->getValue('php_before_save'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('php_before_save', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('php_before_save', 'required', 'false');
			}
		}
		// Modify the form based on Edit Php Postsavehook access controls.
		if ($id != 0 && (!$user->authorise('admin_view.edit.php_postsavehook', 'com_componentbuilder.admin_view.' . (int) $id))
			|| ($id == 0 && !$user->authorise('admin_view.edit.php_postsavehook', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('php_postsavehook', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('php_postsavehook', 'readonly', 'true');
			if (!$form->getValue('php_postsavehook'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('php_postsavehook', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('php_postsavehook', 'required', 'false');
			}
		}
		// Modify the form based on Edit Addfields access controls.
		if ($id != 0 && (!$user->authorise('admin_view.edit.addfields', 'com_componentbuilder.admin_view.' . (int) $id))
			|| ($id == 0 && !$user->authorise('admin_view.edit.addfields', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('addfields', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('addfields', 'readonly', 'true');
			// Disable radio button for display.
			$class = $form->getFieldAttribute('addfields', 'class', '');
			$form->setFieldAttribute('addfields', 'class', $class.' disabled no-click');
			if (!$form->getValue('addfields'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('addfields', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('addfields', 'required', 'false');
			}
		}
		// Modify the form based on Edit Php Batchcopy access controls.
		if ($id != 0 && (!$user->authorise('admin_view.edit.php_batchcopy', 'com_componentbuilder.admin_view.' . (int) $id))
			|| ($id == 0 && !$user->authorise('admin_view.edit.php_batchcopy', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('php_batchcopy', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('php_batchcopy', 'readonly', 'true');
			if (!$form->getValue('php_batchcopy'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('php_batchcopy', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('php_batchcopy', 'required', 'false');
			}
		}
		// Modify the form based on Edit Php Before Publish access controls.
		if ($id != 0 && (!$user->authorise('admin_view.edit.php_before_publish', 'com_componentbuilder.admin_view.' . (int) $id))
			|| ($id == 0 && !$user->authorise('admin_view.edit.php_before_publish', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('php_before_publish', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('php_before_publish', 'readonly', 'true');
			if (!$form->getValue('php_before_publish'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('php_before_publish', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('php_before_publish', 'required', 'false');
			}
		}
		// Modify the form based on Edit Addconditions access controls.
		if ($id != 0 && (!$user->authorise('admin_view.edit.addconditions', 'com_componentbuilder.admin_view.' . (int) $id))
			|| ($id == 0 && !$user->authorise('admin_view.edit.addconditions', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('addconditions', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('addconditions', 'readonly', 'true');
			// Disable radio button for display.
			$class = $form->getFieldAttribute('addconditions', 'class', '');
			$form->setFieldAttribute('addconditions', 'class', $class.' disabled no-click');
			if (!$form->getValue('addconditions'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('addconditions', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('addconditions', 'required', 'false');
			}
		}
		// Modify the form based on Edit Php Before Delete access controls.
		if ($id != 0 && (!$user->authorise('admin_view.edit.php_before_delete', 'com_componentbuilder.admin_view.' . (int) $id))
			|| ($id == 0 && !$user->authorise('admin_view.edit.php_before_delete', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('php_before_delete', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('php_before_delete', 'readonly', 'true');
			if (!$form->getValue('php_before_delete'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('php_before_delete', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('php_before_delete', 'required', 'false');
			}
		}
		// Modify the form based on Edit Addlinked Views access controls.
		if ($id != 0 && (!$user->authorise('admin_view.edit.addlinked_views', 'com_componentbuilder.admin_view.' . (int) $id))
			|| ($id == 0 && !$user->authorise('admin_view.edit.addlinked_views', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('addlinked_views', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('addlinked_views', 'readonly', 'true');
			// Disable radio button for display.
			$class = $form->getFieldAttribute('addlinked_views', 'class', '');
			$form->setFieldAttribute('addlinked_views', 'class', $class.' disabled no-click');
			if (!$form->getValue('addlinked_views'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('addlinked_views', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('addlinked_views', 'required', 'false');
			}
		}
		// Modify the form based on Edit Php Document access controls.
		if ($id != 0 && (!$user->authorise('admin_view.edit.php_document', 'com_componentbuilder.admin_view.' . (int) $id))
			|| ($id == 0 && !$user->authorise('admin_view.edit.php_document', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('php_document', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('php_document', 'readonly', 'true');
			if (!$form->getValue('php_document'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('php_document', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('php_document', 'required', 'false');
			}
		}
		// Modify the form based on Edit Sql access controls.
		if ($id != 0 && (!$user->authorise('admin_view.edit.sql', 'com_componentbuilder.admin_view.' . (int) $id))
			|| ($id == 0 && !$user->authorise('admin_view.edit.sql', 'com_componentbuilder')))
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
		// Modify the form based on Edit Php Import Display access controls.
		if ($id != 0 && (!$user->authorise('admin_view.edit.php_import_display', 'com_componentbuilder.admin_view.' . (int) $id))
			|| ($id == 0 && !$user->authorise('admin_view.edit.php_import_display', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('php_import_display', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('php_import_display', 'readonly', 'true');
			if (!$form->getValue('php_import_display'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('php_import_display', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('php_import_display', 'required', 'false');
			}
		}
		// Modify the form based on Edit Php Getitem access controls.
		if ($id != 0 && (!$user->authorise('admin_view.edit.php_getitem', 'com_componentbuilder.admin_view.' . (int) $id))
			|| ($id == 0 && !$user->authorise('admin_view.edit.php_getitem', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('php_getitem', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('php_getitem', 'readonly', 'true');
			if (!$form->getValue('php_getitem'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('php_getitem', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('php_getitem', 'required', 'false');
			}
		}
		// Modify the form based on Edit Php Import Save access controls.
		if ($id != 0 && (!$user->authorise('admin_view.edit.php_import_save', 'com_componentbuilder.admin_view.' . (int) $id))
			|| ($id == 0 && !$user->authorise('admin_view.edit.php_import_save', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('php_import_save', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('php_import_save', 'readonly', 'true');
			if (!$form->getValue('php_import_save'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('php_import_save', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('php_import_save', 'required', 'false');
			}
		}
		// Modify the form based on Edit Add Css View access controls.
		if ($id != 0 && (!$user->authorise('admin_view.edit.add_css_view', 'com_componentbuilder.admin_view.' . (int) $id))
			|| ($id == 0 && !$user->authorise('admin_view.edit.add_css_view', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('add_css_view', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('add_css_view', 'readonly', 'true');
			// Disable radio button for display.
			$class = $form->getFieldAttribute('add_css_view', 'class', '');
			$form->setFieldAttribute('add_css_view', 'class', $class.' disabled no-click');
			if (!$form->getValue('add_css_view'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('add_css_view', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('add_css_view', 'required', 'false');
			}
		}
		// Modify the form based on Edit Css View access controls.
		if ($id != 0 && (!$user->authorise('admin_view.edit.css_view', 'com_componentbuilder.admin_view.' . (int) $id))
			|| ($id == 0 && !$user->authorise('admin_view.edit.css_view', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('css_view', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('css_view', 'readonly', 'true');
			if (!$form->getValue('css_view'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('css_view', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('css_view', 'required', 'false');
			}
		}
		// Modify the form based on Edit Add Php Getitems access controls.
		if ($id != 0 && (!$user->authorise('admin_view.edit.add_php_getitems', 'com_componentbuilder.admin_view.' . (int) $id))
			|| ($id == 0 && !$user->authorise('admin_view.edit.add_php_getitems', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('add_php_getitems', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('add_php_getitems', 'readonly', 'true');
			// Disable radio button for display.
			$class = $form->getFieldAttribute('add_php_getitems', 'class', '');
			$form->setFieldAttribute('add_php_getitems', 'class', $class.' disabled no-click');
			if (!$form->getValue('add_php_getitems'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('add_php_getitems', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('add_php_getitems', 'required', 'false');
			}
		}
		// Modify the form based on Edit Add Css Views access controls.
		if ($id != 0 && (!$user->authorise('admin_view.edit.add_css_views', 'com_componentbuilder.admin_view.' . (int) $id))
			|| ($id == 0 && !$user->authorise('admin_view.edit.add_css_views', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('add_css_views', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('add_css_views', 'readonly', 'true');
			// Disable radio button for display.
			$class = $form->getFieldAttribute('add_css_views', 'class', '');
			$form->setFieldAttribute('add_css_views', 'class', $class.' disabled no-click');
			if (!$form->getValue('add_css_views'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('add_css_views', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('add_css_views', 'required', 'false');
			}
		}
		// Modify the form based on Edit Add Php Getitems After All access controls.
		if ($id != 0 && (!$user->authorise('admin_view.edit.add_php_getitems_after_all', 'com_componentbuilder.admin_view.' . (int) $id))
			|| ($id == 0 && !$user->authorise('admin_view.edit.add_php_getitems_after_all', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('add_php_getitems_after_all', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('add_php_getitems_after_all', 'readonly', 'true');
			// Disable radio button for display.
			$class = $form->getFieldAttribute('add_php_getitems_after_all', 'class', '');
			$form->setFieldAttribute('add_php_getitems_after_all', 'class', $class.' disabled no-click');
			if (!$form->getValue('add_php_getitems_after_all'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('add_php_getitems_after_all', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('add_php_getitems_after_all', 'required', 'false');
			}
		}
		// Modify the form based on Edit Css Views access controls.
		if ($id != 0 && (!$user->authorise('admin_view.edit.css_views', 'com_componentbuilder.admin_view.' . (int) $id))
			|| ($id == 0 && !$user->authorise('admin_view.edit.css_views', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('css_views', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('css_views', 'readonly', 'true');
			if (!$form->getValue('css_views'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('css_views', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('css_views', 'required', 'false');
			}
		}
		// Modify the form based on Edit Add Php Getlistquery access controls.
		if ($id != 0 && (!$user->authorise('admin_view.edit.add_php_getlistquery', 'com_componentbuilder.admin_view.' . (int) $id))
			|| ($id == 0 && !$user->authorise('admin_view.edit.add_php_getlistquery', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('add_php_getlistquery', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('add_php_getlistquery', 'readonly', 'true');
			// Disable radio button for display.
			$class = $form->getFieldAttribute('add_php_getlistquery', 'class', '');
			$form->setFieldAttribute('add_php_getlistquery', 'class', $class.' disabled no-click');
			if (!$form->getValue('add_php_getlistquery'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('add_php_getlistquery', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('add_php_getlistquery', 'required', 'false');
			}
		}
		// Modify the form based on Edit Add Javascript View File access controls.
		if ($id != 0 && (!$user->authorise('admin_view.edit.add_javascript_view_file', 'com_componentbuilder.admin_view.' . (int) $id))
			|| ($id == 0 && !$user->authorise('admin_view.edit.add_javascript_view_file', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('add_javascript_view_file', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('add_javascript_view_file', 'readonly', 'true');
			// Disable radio button for display.
			$class = $form->getFieldAttribute('add_javascript_view_file', 'class', '');
			$form->setFieldAttribute('add_javascript_view_file', 'class', $class.' disabled no-click');
			if (!$form->getValue('add_javascript_view_file'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('add_javascript_view_file', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('add_javascript_view_file', 'required', 'false');
			}
		}
		// Modify the form based on Edit Add Php Before Save access controls.
		if ($id != 0 && (!$user->authorise('admin_view.edit.add_php_before_save', 'com_componentbuilder.admin_view.' . (int) $id))
			|| ($id == 0 && !$user->authorise('admin_view.edit.add_php_before_save', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('add_php_before_save', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('add_php_before_save', 'readonly', 'true');
			// Disable radio button for display.
			$class = $form->getFieldAttribute('add_php_before_save', 'class', '');
			$form->setFieldAttribute('add_php_before_save', 'class', $class.' disabled no-click');
			if (!$form->getValue('add_php_before_save'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('add_php_before_save', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('add_php_before_save', 'required', 'false');
			}
		}
		// Modify the form based on Edit Javascript View File access controls.
		if ($id != 0 && (!$user->authorise('admin_view.edit.javascript_view_file', 'com_componentbuilder.admin_view.' . (int) $id))
			|| ($id == 0 && !$user->authorise('admin_view.edit.javascript_view_file', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('javascript_view_file', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('javascript_view_file', 'readonly', 'true');
			if (!$form->getValue('javascript_view_file'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('javascript_view_file', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('javascript_view_file', 'required', 'false');
			}
		}
		// Modify the form based on Edit Add Php Save access controls.
		if ($id != 0 && (!$user->authorise('admin_view.edit.add_php_save', 'com_componentbuilder.admin_view.' . (int) $id))
			|| ($id == 0 && !$user->authorise('admin_view.edit.add_php_save', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('add_php_save', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('add_php_save', 'readonly', 'true');
			// Disable radio button for display.
			$class = $form->getFieldAttribute('add_php_save', 'class', '');
			$form->setFieldAttribute('add_php_save', 'class', $class.' disabled no-click');
			if (!$form->getValue('add_php_save'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('add_php_save', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('add_php_save', 'required', 'false');
			}
		}
		// Modify the form based on Edit Add Javascript View Footer access controls.
		if ($id != 0 && (!$user->authorise('admin_view.edit.add_javascript_view_footer', 'com_componentbuilder.admin_view.' . (int) $id))
			|| ($id == 0 && !$user->authorise('admin_view.edit.add_javascript_view_footer', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('add_javascript_view_footer', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('add_javascript_view_footer', 'readonly', 'true');
			// Disable radio button for display.
			$class = $form->getFieldAttribute('add_javascript_view_footer', 'class', '');
			$form->setFieldAttribute('add_javascript_view_footer', 'class', $class.' disabled no-click');
			if (!$form->getValue('add_javascript_view_footer'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('add_javascript_view_footer', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('add_javascript_view_footer', 'required', 'false');
			}
		}
		// Modify the form based on Edit Add Php Postsavehook access controls.
		if ($id != 0 && (!$user->authorise('admin_view.edit.add_php_postsavehook', 'com_componentbuilder.admin_view.' . (int) $id))
			|| ($id == 0 && !$user->authorise('admin_view.edit.add_php_postsavehook', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('add_php_postsavehook', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('add_php_postsavehook', 'readonly', 'true');
			// Disable radio button for display.
			$class = $form->getFieldAttribute('add_php_postsavehook', 'class', '');
			$form->setFieldAttribute('add_php_postsavehook', 'class', $class.' disabled no-click');
			if (!$form->getValue('add_php_postsavehook'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('add_php_postsavehook', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('add_php_postsavehook', 'required', 'false');
			}
		}
		// Modify the form based on Edit Javascript View Footer access controls.
		if ($id != 0 && (!$user->authorise('admin_view.edit.javascript_view_footer', 'com_componentbuilder.admin_view.' . (int) $id))
			|| ($id == 0 && !$user->authorise('admin_view.edit.javascript_view_footer', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('javascript_view_footer', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('javascript_view_footer', 'readonly', 'true');
			if (!$form->getValue('javascript_view_footer'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('javascript_view_footer', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('javascript_view_footer', 'required', 'false');
			}
		}
		// Modify the form based on Edit Add Php Allowedit access controls.
		if ($id != 0 && (!$user->authorise('admin_view.edit.add_php_allowedit', 'com_componentbuilder.admin_view.' . (int) $id))
			|| ($id == 0 && !$user->authorise('admin_view.edit.add_php_allowedit', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('add_php_allowedit', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('add_php_allowedit', 'readonly', 'true');
			// Disable radio button for display.
			$class = $form->getFieldAttribute('add_php_allowedit', 'class', '');
			$form->setFieldAttribute('add_php_allowedit', 'class', $class.' disabled no-click');
			if (!$form->getValue('add_php_allowedit'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('add_php_allowedit', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('add_php_allowedit', 'required', 'false');
			}
		}
		// Modify the form based on Edit Add Javascript Views File access controls.
		if ($id != 0 && (!$user->authorise('admin_view.edit.add_javascript_views_file', 'com_componentbuilder.admin_view.' . (int) $id))
			|| ($id == 0 && !$user->authorise('admin_view.edit.add_javascript_views_file', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('add_javascript_views_file', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('add_javascript_views_file', 'readonly', 'true');
			// Disable radio button for display.
			$class = $form->getFieldAttribute('add_javascript_views_file', 'class', '');
			$form->setFieldAttribute('add_javascript_views_file', 'class', $class.' disabled no-click');
			if (!$form->getValue('add_javascript_views_file'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('add_javascript_views_file', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('add_javascript_views_file', 'required', 'false');
			}
		}
		// Modify the form based on Edit Add Php Batchcopy access controls.
		if ($id != 0 && (!$user->authorise('admin_view.edit.add_php_batchcopy', 'com_componentbuilder.admin_view.' . (int) $id))
			|| ($id == 0 && !$user->authorise('admin_view.edit.add_php_batchcopy', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('add_php_batchcopy', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('add_php_batchcopy', 'readonly', 'true');
			// Disable radio button for display.
			$class = $form->getFieldAttribute('add_php_batchcopy', 'class', '');
			$form->setFieldAttribute('add_php_batchcopy', 'class', $class.' disabled no-click');
			if (!$form->getValue('add_php_batchcopy'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('add_php_batchcopy', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('add_php_batchcopy', 'required', 'false');
			}
		}
		// Modify the form based on Edit Javascript Views File access controls.
		if ($id != 0 && (!$user->authorise('admin_view.edit.javascript_views_file', 'com_componentbuilder.admin_view.' . (int) $id))
			|| ($id == 0 && !$user->authorise('admin_view.edit.javascript_views_file', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('javascript_views_file', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('javascript_views_file', 'readonly', 'true');
			if (!$form->getValue('javascript_views_file'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('javascript_views_file', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('javascript_views_file', 'required', 'false');
			}
		}
		// Modify the form based on Edit Add Php Batchmove access controls.
		if ($id != 0 && (!$user->authorise('admin_view.edit.add_php_batchmove', 'com_componentbuilder.admin_view.' . (int) $id))
			|| ($id == 0 && !$user->authorise('admin_view.edit.add_php_batchmove', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('add_php_batchmove', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('add_php_batchmove', 'readonly', 'true');
			// Disable radio button for display.
			$class = $form->getFieldAttribute('add_php_batchmove', 'class', '');
			$form->setFieldAttribute('add_php_batchmove', 'class', $class.' disabled no-click');
			if (!$form->getValue('add_php_batchmove'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('add_php_batchmove', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('add_php_batchmove', 'required', 'false');
			}
		}
		// Modify the form based on Edit Add Javascript Views Footer access controls.
		if ($id != 0 && (!$user->authorise('admin_view.edit.add_javascript_views_footer', 'com_componentbuilder.admin_view.' . (int) $id))
			|| ($id == 0 && !$user->authorise('admin_view.edit.add_javascript_views_footer', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('add_javascript_views_footer', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('add_javascript_views_footer', 'readonly', 'true');
			// Disable radio button for display.
			$class = $form->getFieldAttribute('add_javascript_views_footer', 'class', '');
			$form->setFieldAttribute('add_javascript_views_footer', 'class', $class.' disabled no-click');
			if (!$form->getValue('add_javascript_views_footer'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('add_javascript_views_footer', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('add_javascript_views_footer', 'required', 'false');
			}
		}
		// Modify the form based on Edit Add Php Before Publish access controls.
		if ($id != 0 && (!$user->authorise('admin_view.edit.add_php_before_publish', 'com_componentbuilder.admin_view.' . (int) $id))
			|| ($id == 0 && !$user->authorise('admin_view.edit.add_php_before_publish', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('add_php_before_publish', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('add_php_before_publish', 'readonly', 'true');
			// Disable radio button for display.
			$class = $form->getFieldAttribute('add_php_before_publish', 'class', '');
			$form->setFieldAttribute('add_php_before_publish', 'class', $class.' disabled no-click');
			if (!$form->getValue('add_php_before_publish'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('add_php_before_publish', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('add_php_before_publish', 'required', 'false');
			}
		}
		// Modify the form based on Edit Javascript Views Footer access controls.
		if ($id != 0 && (!$user->authorise('admin_view.edit.javascript_views_footer', 'com_componentbuilder.admin_view.' . (int) $id))
			|| ($id == 0 && !$user->authorise('admin_view.edit.javascript_views_footer', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('javascript_views_footer', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('javascript_views_footer', 'readonly', 'true');
			if (!$form->getValue('javascript_views_footer'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('javascript_views_footer', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('javascript_views_footer', 'required', 'false');
			}
		}
		// Modify the form based on Edit Add Php After Publish access controls.
		if ($id != 0 && (!$user->authorise('admin_view.edit.add_php_after_publish', 'com_componentbuilder.admin_view.' . (int) $id))
			|| ($id == 0 && !$user->authorise('admin_view.edit.add_php_after_publish', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('add_php_after_publish', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('add_php_after_publish', 'readonly', 'true');
			// Disable radio button for display.
			$class = $form->getFieldAttribute('add_php_after_publish', 'class', '');
			$form->setFieldAttribute('add_php_after_publish', 'class', $class.' disabled no-click');
			if (!$form->getValue('add_php_after_publish'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('add_php_after_publish', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('add_php_after_publish', 'required', 'false');
			}
		}
		// Modify the form based on Edit Add Custom Button access controls.
		if ($id != 0 && (!$user->authorise('admin_view.edit.add_custom_button', 'com_componentbuilder.admin_view.' . (int) $id))
			|| ($id == 0 && !$user->authorise('admin_view.edit.add_custom_button', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('add_custom_button', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('add_custom_button', 'readonly', 'true');
			// Disable radio button for display.
			$class = $form->getFieldAttribute('add_custom_button', 'class', '');
			$form->setFieldAttribute('add_custom_button', 'class', $class.' disabled no-click');
			if (!$form->getValue('add_custom_button'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('add_custom_button', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('add_custom_button', 'required', 'false');
			}
		}
		// Modify the form based on Edit Add Php Before Delete access controls.
		if ($id != 0 && (!$user->authorise('admin_view.edit.add_php_before_delete', 'com_componentbuilder.admin_view.' . (int) $id))
			|| ($id == 0 && !$user->authorise('admin_view.edit.add_php_before_delete', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('add_php_before_delete', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('add_php_before_delete', 'readonly', 'true');
			// Disable radio button for display.
			$class = $form->getFieldAttribute('add_php_before_delete', 'class', '');
			$form->setFieldAttribute('add_php_before_delete', 'class', $class.' disabled no-click');
			if (!$form->getValue('add_php_before_delete'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('add_php_before_delete', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('add_php_before_delete', 'required', 'false');
			}
		}
		// Modify the form based on Edit Custom Button access controls.
		if ($id != 0 && (!$user->authorise('admin_view.edit.custom_button', 'com_componentbuilder.admin_view.' . (int) $id))
			|| ($id == 0 && !$user->authorise('admin_view.edit.custom_button', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('custom_button', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('custom_button', 'readonly', 'true');
			// Disable radio button for display.
			$class = $form->getFieldAttribute('custom_button', 'class', '');
			$form->setFieldAttribute('custom_button', 'class', $class.' disabled no-click');
			if (!$form->getValue('custom_button'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('custom_button', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('custom_button', 'required', 'false');
			}
		}
		// Modify the form based on Edit Add Php After Delete access controls.
		if ($id != 0 && (!$user->authorise('admin_view.edit.add_php_after_delete', 'com_componentbuilder.admin_view.' . (int) $id))
			|| ($id == 0 && !$user->authorise('admin_view.edit.add_php_after_delete', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('add_php_after_delete', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('add_php_after_delete', 'readonly', 'true');
			// Disable radio button for display.
			$class = $form->getFieldAttribute('add_php_after_delete', 'class', '');
			$form->setFieldAttribute('add_php_after_delete', 'class', $class.' disabled no-click');
			if (!$form->getValue('add_php_after_delete'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('add_php_after_delete', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('add_php_after_delete', 'required', 'false');
			}
		}
		// Modify the form based on Edit Php Controller access controls.
		if ($id != 0 && (!$user->authorise('admin_view.edit.php_controller', 'com_componentbuilder.admin_view.' . (int) $id))
			|| ($id == 0 && !$user->authorise('admin_view.edit.php_controller', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('php_controller', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('php_controller', 'readonly', 'true');
			if (!$form->getValue('php_controller'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('php_controller', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('php_controller', 'required', 'false');
			}
		}
		// Modify the form based on Edit Add Php Document access controls.
		if ($id != 0 && (!$user->authorise('admin_view.edit.add_php_document', 'com_componentbuilder.admin_view.' . (int) $id))
			|| ($id == 0 && !$user->authorise('admin_view.edit.add_php_document', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('add_php_document', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('add_php_document', 'readonly', 'true');
			// Disable radio button for display.
			$class = $form->getFieldAttribute('add_php_document', 'class', '');
			$form->setFieldAttribute('add_php_document', 'class', $class.' disabled no-click');
			if (!$form->getValue('add_php_document'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('add_php_document', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('add_php_document', 'required', 'false');
			}
		}
		// Modify the form based on Edit Php Model access controls.
		if ($id != 0 && (!$user->authorise('admin_view.edit.php_model', 'com_componentbuilder.admin_view.' . (int) $id))
			|| ($id == 0 && !$user->authorise('admin_view.edit.php_model', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('php_model', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('php_model', 'readonly', 'true');
			if (!$form->getValue('php_model'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('php_model', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('php_model', 'required', 'false');
			}
		}
		// Modify the form based on Edit Add Sql access controls.
		if ($id != 0 && (!$user->authorise('admin_view.edit.add_sql', 'com_componentbuilder.admin_view.' . (int) $id))
			|| ($id == 0 && !$user->authorise('admin_view.edit.add_sql', 'com_componentbuilder')))
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
		// Modify the form based on Edit Php Controller List access controls.
		if ($id != 0 && (!$user->authorise('admin_view.edit.php_controller_list', 'com_componentbuilder.admin_view.' . (int) $id))
			|| ($id == 0 && !$user->authorise('admin_view.edit.php_controller_list', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('php_controller_list', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('php_controller_list', 'readonly', 'true');
			if (!$form->getValue('php_controller_list'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('php_controller_list', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('php_controller_list', 'required', 'false');
			}
		}
		// Modify the form based on Edit Addtables access controls.
		if ($id != 0 && (!$user->authorise('admin_view.edit.addtables', 'com_componentbuilder.admin_view.' . (int) $id))
			|| ($id == 0 && !$user->authorise('admin_view.edit.addtables', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('addtables', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('addtables', 'readonly', 'true');
			// Disable radio button for display.
			$class = $form->getFieldAttribute('addtables', 'class', '');
			$form->setFieldAttribute('addtables', 'class', $class.' disabled no-click');
			if (!$form->getValue('addtables'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('addtables', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('addtables', 'required', 'false');
			}
		}
		// Modify the form based on Edit Php Model List access controls.
		if ($id != 0 && (!$user->authorise('admin_view.edit.php_model_list', 'com_componentbuilder.admin_view.' . (int) $id))
			|| ($id == 0 && !$user->authorise('admin_view.edit.php_model_list', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('php_model_list', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('php_model_list', 'readonly', 'true');
			if (!$form->getValue('php_model_list'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('php_model_list', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('php_model_list', 'required', 'false');
			}
		}
		// Modify the form based on Edit Add Php Ajax access controls.
		if ($id != 0 && (!$user->authorise('admin_view.edit.add_php_ajax', 'com_componentbuilder.admin_view.' . (int) $id))
			|| ($id == 0 && !$user->authorise('admin_view.edit.add_php_ajax', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('add_php_ajax', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('add_php_ajax', 'readonly', 'true');
			// Disable radio button for display.
			$class = $form->getFieldAttribute('add_php_ajax', 'class', '');
			$form->setFieldAttribute('add_php_ajax', 'class', $class.' disabled no-click');
			if (!$form->getValue('add_php_ajax'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('add_php_ajax', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('add_php_ajax', 'required', 'false');
			}
		}
		// Modify the form based on Edit Add Custom Import access controls.
		if ($id != 0 && (!$user->authorise('admin_view.edit.add_custom_import', 'com_componentbuilder.admin_view.' . (int) $id))
			|| ($id == 0 && !$user->authorise('admin_view.edit.add_custom_import', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('add_custom_import', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('add_custom_import', 'readonly', 'true');
			// Disable radio button for display.
			$class = $form->getFieldAttribute('add_custom_import', 'class', '');
			$form->setFieldAttribute('add_custom_import', 'class', $class.' disabled no-click');
			if (!$form->getValue('add_custom_import'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('add_custom_import', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('add_custom_import', 'required', 'false');
			}
		}
		// Modify the form based on Edit Php Ajaxmethod access controls.
		if ($id != 0 && (!$user->authorise('admin_view.edit.php_ajaxmethod', 'com_componentbuilder.admin_view.' . (int) $id))
			|| ($id == 0 && !$user->authorise('admin_view.edit.php_ajaxmethod', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('php_ajaxmethod', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('php_ajaxmethod', 'readonly', 'true');
			if (!$form->getValue('php_ajaxmethod'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('php_ajaxmethod', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('php_ajaxmethod', 'required', 'false');
			}
		}
		// Modify the form based on Edit Html Import View access controls.
		if ($id != 0 && (!$user->authorise('admin_view.edit.html_import_view', 'com_componentbuilder.admin_view.' . (int) $id))
			|| ($id == 0 && !$user->authorise('admin_view.edit.html_import_view', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('html_import_view', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('html_import_view', 'readonly', 'true');
			if (!$form->getValue('html_import_view'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('html_import_view', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('html_import_view', 'required', 'false');
			}
		}
		// Modify the form based on Edit Ajax Input access controls.
		if ($id != 0 && (!$user->authorise('admin_view.edit.ajax_input', 'com_componentbuilder.admin_view.' . (int) $id))
			|| ($id == 0 && !$user->authorise('admin_view.edit.ajax_input', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('ajax_input', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('ajax_input', 'readonly', 'true');
			// Disable radio button for display.
			$class = $form->getFieldAttribute('ajax_input', 'class', '');
			$form->setFieldAttribute('ajax_input', 'class', $class.' disabled no-click');
			if (!$form->getValue('ajax_input'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('ajax_input', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('ajax_input', 'required', 'false');
			}
		}
		// Modify the form based on Edit Php Import Setdata access controls.
		if ($id != 0 && (!$user->authorise('admin_view.edit.php_import_setdata', 'com_componentbuilder.admin_view.' . (int) $id))
			|| ($id == 0 && !$user->authorise('admin_view.edit.php_import_setdata', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('php_import_setdata', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('php_import_setdata', 'readonly', 'true');
			if (!$form->getValue('php_import_setdata'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('php_import_setdata', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('php_import_setdata', 'required', 'false');
			}
		}
		// Modify the form based on Edit Add Php Getitem access controls.
		if ($id != 0 && (!$user->authorise('admin_view.edit.add_php_getitem', 'com_componentbuilder.admin_view.' . (int) $id))
			|| ($id == 0 && !$user->authorise('admin_view.edit.add_php_getitem', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('add_php_getitem', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('add_php_getitem', 'readonly', 'true');
			// Disable radio button for display.
			$class = $form->getFieldAttribute('add_php_getitem', 'class', '');
			$form->setFieldAttribute('add_php_getitem', 'class', $class.' disabled no-click');
			if (!$form->getValue('add_php_getitem'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('add_php_getitem', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('add_php_getitem', 'required', 'false');
			}
		}
		// Modify the form based on Edit Php Import Ext access controls.
		if ($id != 0 && (!$user->authorise('admin_view.edit.php_import_ext', 'com_componentbuilder.admin_view.' . (int) $id))
			|| ($id == 0 && !$user->authorise('admin_view.edit.php_import_ext', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('php_import_ext', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('php_import_ext', 'readonly', 'true');
			if (!$form->getValue('php_import_ext'))
			{
				// Disable fields while saving.
				$form->setFieldAttribute('php_import_ext', 'filter', 'unset');
				// Disable fields while saving.
				$form->setFieldAttribute('php_import_ext', 'required', 'false');
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
		return 'administrator/components/com_componentbuilder/models/forms/admin_view.js';
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
			return $user->authorise('core.delete', 'com_componentbuilder.admin_view.' . (int) $record->id);
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
			$permission = $user->authorise('core.edit.state', 'com_componentbuilder.admin_view.' . (int) $recordId);
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
		$user = JFactory::getUser();

		return $user->authorise('core.edit', 'com_componentbuilder.admin_view.'. ((int) isset($data[$key]) ? $data[$key] : 0)) or $user->authorise('core.edit',  'com_componentbuilder');
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
					->from($db->quoteName('#__componentbuilder_admin_view'));
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
		$data = JFactory::getApplication()->getUserState('com_componentbuilder.edit.admin_view.data', array());

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
		$this->canDo			= ComponentbuilderHelper::getActions('admin_view');
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
			$this->canDo		= ComponentbuilderHelper::getActions('admin_view');
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
			$this->canDo		= ComponentbuilderHelper::getActions('admin_view');
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

		// Set the php_batchmove string to base64 string.
		if (isset($data['php_batchmove']))
		{
			$data['php_batchmove'] = base64_encode($data['php_batchmove']);
		}

		// Set the php_save string to base64 string.
		if (isset($data['php_save']))
		{
			$data['php_save'] = base64_encode($data['php_save']);
		}

		// Set the php_after_delete string to base64 string.
		if (isset($data['php_after_delete']))
		{
			$data['php_after_delete'] = base64_encode($data['php_after_delete']);
		}

		// Set the php_getlistquery string to base64 string.
		if (isset($data['php_getlistquery']))
		{
			$data['php_getlistquery'] = base64_encode($data['php_getlistquery']);
		}

		// Set the php_allowedit string to base64 string.
		if (isset($data['php_allowedit']))
		{
			$data['php_allowedit'] = base64_encode($data['php_allowedit']);
		}

		// Set the php_after_publish string to base64 string.
		if (isset($data['php_after_publish']))
		{
			$data['php_after_publish'] = base64_encode($data['php_after_publish']);
		}

		// Set the php_getitems string to base64 string.
		if (isset($data['php_getitems']))
		{
			$data['php_getitems'] = base64_encode($data['php_getitems']);
		}

		// Set the php_import string to base64 string.
		if (isset($data['php_import']))
		{
			$data['php_import'] = base64_encode($data['php_import']);
		}

		// Set the php_getitems_after_all string to base64 string.
		if (isset($data['php_getitems_after_all']))
		{
			$data['php_getitems_after_all'] = base64_encode($data['php_getitems_after_all']);
		}

		// Set the php_before_save string to base64 string.
		if (isset($data['php_before_save']))
		{
			$data['php_before_save'] = base64_encode($data['php_before_save']);
		}

		// Set the php_postsavehook string to base64 string.
		if (isset($data['php_postsavehook']))
		{
			$data['php_postsavehook'] = base64_encode($data['php_postsavehook']);
		}

		// Set the php_batchcopy string to base64 string.
		if (isset($data['php_batchcopy']))
		{
			$data['php_batchcopy'] = base64_encode($data['php_batchcopy']);
		}

		// Set the php_before_publish string to base64 string.
		if (isset($data['php_before_publish']))
		{
			$data['php_before_publish'] = base64_encode($data['php_before_publish']);
		}

		// Set the php_before_delete string to base64 string.
		if (isset($data['php_before_delete']))
		{
			$data['php_before_delete'] = base64_encode($data['php_before_delete']);
		}

		// Set the php_document string to base64 string.
		if (isset($data['php_document']))
		{
			$data['php_document'] = base64_encode($data['php_document']);
		}

		// Set the sql string to base64 string.
		if (isset($data['sql']))
		{
			$data['sql'] = base64_encode($data['sql']);
		}

		// Set the php_import_display string to base64 string.
		if (isset($data['php_import_display']))
		{
			$data['php_import_display'] = base64_encode($data['php_import_display']);
		}

		// Set the php_getitem string to base64 string.
		if (isset($data['php_getitem']))
		{
			$data['php_getitem'] = base64_encode($data['php_getitem']);
		}

		// Set the php_import_save string to base64 string.
		if (isset($data['php_import_save']))
		{
			$data['php_import_save'] = base64_encode($data['php_import_save']);
		}

		// Set the css_view string to base64 string.
		if (isset($data['css_view']))
		{
			$data['css_view'] = base64_encode($data['css_view']);
		}

		// Set the css_views string to base64 string.
		if (isset($data['css_views']))
		{
			$data['css_views'] = base64_encode($data['css_views']);
		}

		// Set the javascript_view_file string to base64 string.
		if (isset($data['javascript_view_file']))
		{
			$data['javascript_view_file'] = base64_encode($data['javascript_view_file']);
		}

		// Set the javascript_view_footer string to base64 string.
		if (isset($data['javascript_view_footer']))
		{
			$data['javascript_view_footer'] = base64_encode($data['javascript_view_footer']);
		}

		// Set the javascript_views_file string to base64 string.
		if (isset($data['javascript_views_file']))
		{
			$data['javascript_views_file'] = base64_encode($data['javascript_views_file']);
		}

		// Set the javascript_views_footer string to base64 string.
		if (isset($data['javascript_views_footer']))
		{
			$data['javascript_views_footer'] = base64_encode($data['javascript_views_footer']);
		}

		// Set the php_controller string to base64 string.
		if (isset($data['php_controller']))
		{
			$data['php_controller'] = base64_encode($data['php_controller']);
		}

		// Set the php_model string to base64 string.
		if (isset($data['php_model']))
		{
			$data['php_model'] = base64_encode($data['php_model']);
		}

		// Set the php_controller_list string to base64 string.
		if (isset($data['php_controller_list']))
		{
			$data['php_controller_list'] = base64_encode($data['php_controller_list']);
		}

		// Set the php_model_list string to base64 string.
		if (isset($data['php_model_list']))
		{
			$data['php_model_list'] = base64_encode($data['php_model_list']);
		}

		// Set the php_ajaxmethod string to base64 string.
		if (isset($data['php_ajaxmethod']))
		{
			$data['php_ajaxmethod'] = base64_encode($data['php_ajaxmethod']);
		}

		// Set the html_import_view string to base64 string.
		if (isset($data['html_import_view']))
		{
			$data['html_import_view'] = base64_encode($data['html_import_view']);
		}

		// Set the php_import_setdata string to base64 string.
		if (isset($data['php_import_setdata']))
		{
			$data['php_import_setdata'] = base64_encode($data['php_import_setdata']);
		}

		// Set the php_import_ext string to base64 string.
		if (isset($data['php_import_ext']))
		{
			$data['php_import_ext'] = base64_encode($data['php_import_ext']);
		}

	if (isset($data['addfields']) && ComponentbuilderHelper::checkJson($data['addfields']))
	{
		// Sort fields by 'Tab' ASC, 'Order in Edit' ASC
		$addfields = json_decode($data['addfields'], true);
		if (ComponentbuilderHelper::checkArray($addfields))
		{
			$out = array();
			foreach ($addfields as $key => $subarr)
			{
				if (ComponentbuilderHelper::checkArray($subarr))
				{
					foreach ($subarr as $subkey => $subvalue)
					{
						$out[$subkey][$key] = $subvalue;
					}
				}
			}
			if (ComponentbuilderHelper::checkArray($out))
			{
				// do the actual sort by tab and order_edit
				usort($out, function ($a, $b) {
					$val_a = sprintf('%02u', $a['tab']) . sprintf('%02u', $a['alignment']) . sprintf('%03u', $a['order_edit']);
					$val_b = sprintf('%02u', $b['tab']) . sprintf('%02u', $b['alignment']) . sprintf('%03u', $b['order_edit']);
					return strcmp($val_a, $val_b);
				});

				$addfields = array();
				foreach ($out as $key => $subarr)
				{
					foreach ($subarr as $subkey => $subvalue)
					{
						$addfields[$subkey][$key] = $subvalue;
					}
				}
				$data['addfields'] = json_encode($addfields, true);
			}
		}
	}
        
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
}
