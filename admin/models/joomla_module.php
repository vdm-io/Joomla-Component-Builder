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

use Joomla\Registry\Registry;

/**
 * Componentbuilder Joomla_module Model
 */
class ComponentbuilderModelJoomla_module extends JModelAdmin
{
	/**
	 * The tab layout fields array.
	 *
	 * @var      array
	 */
	protected $tabLayoutFields = array(
		'html' => array(
			'left' => array(
				'name',
				'description',
				'libraries',
				'note_libraries_options',
				'note_add_language_string'
			),
			'right' => array(
				'snippet',
				'note_uikit_snippet',
				'note_snippet_usage'
			),
			'fullwidth' => array(
				'default',
				'note_linked_to_notice',
				'not_required'
			),
			'above' => array(
				'system_name',
				'module_version'
			)
		),
		'script_file' => array(
			'fullwidth' => array(
				'add_php_script_construct',
				'php_script_construct',
				'add_php_preflight_install',
				'php_preflight_install',
				'add_php_preflight_update',
				'php_preflight_update',
				'add_php_preflight_uninstall',
				'php_preflight_uninstall',
				'add_php_postflight_install',
				'php_postflight_install',
				'add_php_postflight_update',
				'php_postflight_update',
				'add_php_method_uninstall',
				'php_method_uninstall'
			)
		),
		'dynamic_integration' => array(
			'left' => array(
				'add_update_server',
				'update_server_url',
				'update_server_target',
				'note_update_server_note_ftp',
				'note_update_server_note_zip',
				'note_update_server_note_other',
				'update_server',
				'add_sales_server',
				'sales_server'
			)
		),
		'readme' => array(
			'left' => array(
				'addreadme',
				'readme'
			)
		),
		'mysql' => array(
			'fullwidth' => array(
				'add_sql',
				'sql',
				'add_sql_uninstall',
				'sql_uninstall'
			)
		),
		'code' => array(
			'left' => array(
				'custom_get'
			),
			'right' => array(
				'note_mod_file_options'
			),
			'fullwidth' => array(
				'mod_code'
			)
		),
		'helper' => array(
			'left' => array(
				'add_class_helper'
			),
			'right' => array(
				'add_class_helper_header'
			),
			'fullwidth' => array(
				'class_helper_header',
				'class_helper_code'
			)
		),
		'forms_fields' => array(
			'fullwidth' => array(
				'fields'
			)
		)
	);

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
	public $typeAlias = 'com_componentbuilder.joomla_module';

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
	public function getTable($type = 'joomla_module', $prefix = 'ComponentbuilderTable', $config = array())
	{
		// add table path for when model gets used from other component
		$this->addTablePath(JPATH_ADMINISTRATOR . '/components/com_componentbuilder/tables');
		// get instance of the table
		return JTable::getInstance($type, $prefix, $config);
	}


	/**
	 * get VDM internal session key
	 *
	 * @return  string  the session key
	 *
	 */
	public function getVDM()
	{
		if (!isset($this->vastDevMod))
		{
			$_id = 0; // new item probably (since it was not set in the getItem method)

			if (empty($_id))
			{
				$id = 0;
			}
			else
			{
				$id = $_id;
			}
			// set the id and view name to session
			if ($vdm = ComponentbuilderHelper::get('joomla_module__'.$id))
			{
				$this->vastDevMod = $vdm;
			}
			else
			{
				// set the vast development method key
				$this->vastDevMod = ComponentbuilderHelper::randomkey(50);
				ComponentbuilderHelper::set($this->vastDevMod, 'joomla_module__'.$id);
				ComponentbuilderHelper::set('joomla_module__'.$id, $this->vastDevMod);
				// set a return value if found
				$jinput = JFactory::getApplication()->input;
				$return = $jinput->get('return', null, 'base64');
				ComponentbuilderHelper::set($this->vastDevMod . '__return', $return);
				// set a GUID value if found
				if (isset($item) && ComponentbuilderHelper::checkObject($item) && isset($item->guid)
					&& method_exists('ComponentbuilderHelper', 'validGUID')
					&& ComponentbuilderHelper::validGUID($item->guid))
				{
					ComponentbuilderHelper::set($this->vastDevMod . '__guid', $item->guid);
				}
			}
		}
		return $this->vastDevMod;
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
			if (!empty($item->params) && !is_array($item->params))
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

			if (!empty($item->default))
			{
				// base64 Decode default.
				$item->default = base64_decode($item->default);
			}

			if (!empty($item->php_preflight_update))
			{
				// base64 Decode php_preflight_update.
				$item->php_preflight_update = base64_decode($item->php_preflight_update);
			}

			if (!empty($item->php_preflight_uninstall))
			{
				// base64 Decode php_preflight_uninstall.
				$item->php_preflight_uninstall = base64_decode($item->php_preflight_uninstall);
			}

			if (!empty($item->mod_code))
			{
				// base64 Decode mod_code.
				$item->mod_code = base64_decode($item->mod_code);
			}

			if (!empty($item->php_postflight_install))
			{
				// base64 Decode php_postflight_install.
				$item->php_postflight_install = base64_decode($item->php_postflight_install);
			}

			if (!empty($item->php_postflight_update))
			{
				// base64 Decode php_postflight_update.
				$item->php_postflight_update = base64_decode($item->php_postflight_update);
			}

			if (!empty($item->php_method_uninstall))
			{
				// base64 Decode php_method_uninstall.
				$item->php_method_uninstall = base64_decode($item->php_method_uninstall);
			}

			if (!empty($item->class_helper_header))
			{
				// base64 Decode class_helper_header.
				$item->class_helper_header = base64_decode($item->class_helper_header);
			}

			if (!empty($item->sql))
			{
				// base64 Decode sql.
				$item->sql = base64_decode($item->sql);
			}

			if (!empty($item->class_helper_code))
			{
				// base64 Decode class_helper_code.
				$item->class_helper_code = base64_decode($item->class_helper_code);
			}

			if (!empty($item->sql_uninstall))
			{
				// base64 Decode sql_uninstall.
				$item->sql_uninstall = base64_decode($item->sql_uninstall);
			}

			if (!empty($item->readme))
			{
				// base64 Decode readme.
				$item->readme = base64_decode($item->readme);
			}

			if (!empty($item->php_script_construct))
			{
				// base64 Decode php_script_construct.
				$item->php_script_construct = base64_decode($item->php_script_construct);
			}

			if (!empty($item->php_preflight_install))
			{
				// base64 Decode php_preflight_install.
				$item->php_preflight_install = base64_decode($item->php_preflight_install);
			}

			if (!empty($item->libraries))
			{
				// Convert the libraries field to an array.
				$libraries = new Registry;
				$libraries->loadString($item->libraries);
				$item->libraries = $libraries->toArray();
			}

			if (!empty($item->custom_get))
			{
				// Convert the custom_get field to an array.
				$custom_get = new Registry;
				$custom_get->loadString($item->custom_get);
				$item->custom_get = $custom_get->toArray();
			}

			if (!empty($item->fields))
			{
				// Convert the fields field to an array.
				$fields = new Registry;
				$fields->loadString($item->fields);
				$item->fields = $fields->toArray();
			}


			if (empty($item->id))
			{
				$id = 0;
			}
			else
			{
				$id = $item->id;
			}
			// set the id and view name to session
			if ($vdm = ComponentbuilderHelper::get('joomla_module__'.$id))
			{
				$this->vastDevMod = $vdm;
			}
			else
			{
				// set the vast development method key
				$this->vastDevMod = ComponentbuilderHelper::randomkey(50);
				ComponentbuilderHelper::set($this->vastDevMod, 'joomla_module__'.$id);
				ComponentbuilderHelper::set('joomla_module__'.$id, $this->vastDevMod);
				// set a return value if found
				$jinput = JFactory::getApplication()->input;
				$return = $jinput->get('return', null, 'base64');
				ComponentbuilderHelper::set($this->vastDevMod . '__return', $return);
				// set a GUID value if found
				if (isset($item) && ComponentbuilderHelper::checkObject($item) && isset($item->guid)
					&& method_exists('ComponentbuilderHelper', 'validGUID')
					&& ComponentbuilderHelper::validGUID($item->guid))
				{
					ComponentbuilderHelper::set($this->vastDevMod . '__guid', $item->guid);
				}
			}
			
			if (!empty($item->id))
			{
				$item->tags = new JHelperTags;
				$item->tags->getTagIds($item->id, 'com_componentbuilder.joomla_module');
			}
		}

		return $item;
	}

	/**
	 * Method to get the record form.
	 *
	 * @param   array    $data      Data for the form.
	 * @param   boolean  $loadData  True if the form is to load its own data (default case), false if not.
	 * @param   array    $options   Optional array of options for the form creation.
	 *
	 * @return  mixed  A JForm object on success, false on failure
	 *
	 * @since   1.6
	 */
	public function getForm($data = array(), $loadData = true, $options = array('control' => 'jform'))
	{
		// set load data option
		$options['load_data'] = $loadData;
		// check if xpath was set in options
		$xpath = false;
		if (isset($options['xpath']))
		{
			$xpath = $options['xpath'];
			unset($options['xpath']);
		}
		// check if clear form was set in options
		$clear = false;
		if (isset($options['clear']))
		{
			$clear = $options['clear'];
			unset($options['clear']);
		}

		// Get the form.
		$form = $this->loadForm('com_componentbuilder.joomla_module', 'joomla_module', $options, $clear, $xpath);

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
		if ($id != 0 && (!$user->authorise('joomla_module.edit.state', 'com_componentbuilder.joomla_module.' . (int) $id))
			|| ($id == 0 && !$user->authorise('joomla_module.edit.state', 'com_componentbuilder')))
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
		if ($id != 0 && (!$user->authorise('joomla_module.edit.created_by', 'com_componentbuilder.joomla_module.' . (int) $id))
			|| ($id == 0 && !$user->authorise('joomla_module.edit.created_by', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('created_by', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('created_by', 'readonly', 'true');
			// Disable fields while saving.
			$form->setFieldAttribute('created_by', 'filter', 'unset');
		}
		// Modify the form based on Edit Creaded Date access controls.
		if ($id != 0 && (!$user->authorise('joomla_module.edit.created', 'com_componentbuilder.joomla_module.' . (int) $id))
			|| ($id == 0 && !$user->authorise('joomla_module.edit.created', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('created', 'disabled', 'true');
			// Disable fields while saving.
			$form->setFieldAttribute('created', 'filter', 'unset');
		}
		// Only load these values if no id is found
		if (0 == $id)
		{
			// Set redirected view name
			$redirectedView = $jinput->get('ref', null, 'STRING');
			// Set field name (or fall back to view name)
			$redirectedField = $jinput->get('field', $redirectedView, 'STRING');
			// Set redirected view id
			$redirectedId = $jinput->get('refid', 0, 'INT');
			// Set field id (or fall back to redirected view id)
			$redirectedValue = $jinput->get('field_id', $redirectedId, 'INT');
			if (0 != $redirectedValue && $redirectedField)
			{
				// Now set the local-redirected field default value
				$form->setValue($redirectedField, null, $redirectedValue);
			}
		}

		// update all editors to use this components global editor
		$global_editor = JComponentHelper::getParams('com_componentbuilder')->get('editor', 'none');
		// now get all the editor fields
		$editors = $form->getXml()->xpath("//field[@type='editor']");
		// check if we found any
		if (ComponentbuilderHelper::checkArray($editors))
		{
			foreach ($editors as $editor)
			{
				// get the field names
				$name = (string) $editor['name'];
				// set the field editor value (with none as fallback)
				$form->setFieldAttribute($name, 'editor', $global_editor . '|none');
			}
		}


		// Only load the GUID if new item
		if (0 == $id)
		{
			$form->setValue('guid', null, ComponentbuilderHelper::GUID());
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
		return 'administrator/components/com_componentbuilder/models/forms/joomla_module.js';
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
			return $user->authorise('joomla_module.delete', 'com_componentbuilder.joomla_module.' . (int) $record->id);
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
		$recordId = (!empty($record->id)) ? $record->id : 0;

		if ($recordId)
		{
			// The record has been set. Check the record permissions.
			$permission = $user->authorise('joomla_module.edit.state', 'com_componentbuilder.joomla_module.' . (int) $recordId);
			if (!$permission && !is_null($permission))
			{
				return false;
			}
		}
		// In the absense of better information, revert to the component permissions.
		return $user->authorise('joomla_module.edit.state', 'com_componentbuilder');
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

		return $user->authorise('joomla_module.edit', 'com_componentbuilder.joomla_module.'. ((int) isset($data[$key]) ? $data[$key] : 0)) or $user->authorise('joomla_module.edit',  'com_componentbuilder');
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
					->from($db->quoteName('#__componentbuilder_joomla_module'));
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
		$data = JFactory::getApplication()->getUserState('com_componentbuilder.edit.joomla_module.data', array());

		if (empty($data))
		{
			$data = $this->getItem();
			// run the perprocess of the data
			$this->preprocessData('com_componentbuilder.joomla_module', $data);
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

		// we must also delete the linked tables found
		if (ComponentbuilderHelper::checkArray($pks))
		{
			// linked tables to update
			$_tablesArray = array(
				'joomla_module_updates' => 'joomla_module',
				'joomla_module_files_folders_urls' => 'joomla_module'
			);
			foreach($_tablesArray as $_updateTable => $_key)
			{
				// get the linked IDs
				if ($_pks = ComponentbuilderHelper::getVars($_updateTable, $pks, $_key, 'id'))
				{
					// load the model
					$_Model = ComponentbuilderHelper::getModel($_updateTable);
					// change publish state
					$_Model->delete($_pks);
				}
			}
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

		// we must also update all linked tables
		if (ComponentbuilderHelper::checkArray($pks))
		{
			// linked tables to update
			$_tablesArray = array(
				'joomla_module_updates' => 'joomla_module',
				'joomla_module_files_folders_urls' => 'joomla_module'
			);
			foreach($_tablesArray as $_updateTable => $_key)
			{
				// get the linked IDs
				if ($_pks = ComponentbuilderHelper::getVars($_updateTable, $pks, $_key, 'id'))
				{
					// load the model
					$_Model = ComponentbuilderHelper::getModel($_updateTable);
					// change publish state
					$_Model->publish($_pks, $value);
				}
			}
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
		$this->canDo			= ComponentbuilderHelper::getActions('joomla_module');
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
	 * @since 12.2
	 */
	protected function batchCopy($values, $pks, $contexts)
	{
		if (empty($this->batchSet))
		{
			// Set some needed variables.
			$this->user 		= JFactory::getUser();
			$this->table 		= $this->getTable();
			$this->tableClassName	= get_class($this->table);
			$this->canDo		= ComponentbuilderHelper::getActions('joomla_module');
		}

		if (!$this->canDo->get('joomla_module.create') && !$this->canDo->get('joomla_module.batch'))
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
		elseif (isset($values['published']) && !$this->canDo->get('joomla_module.edit.state'))
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
			if (!$this->user->authorise('joomla_module.edit', $contexts[$pk]))
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

			// Only for strings
			if (ComponentbuilderHelper::checkString($this->table->system_name) && !is_numeric($this->table->system_name))
			{
				$this->table->system_name = $this->generateUniqe('system_name',$this->table->system_name);
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
			// $this->table->ordering = 1;

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
	 * @since 12.2
	 */
	protected function batchMove($values, $pks, $contexts)
	{
		if (empty($this->batchSet))
		{
			// Set some needed variables.
			$this->user		= JFactory::getUser();
			$this->table		= $this->getTable();
			$this->tableClassName	= get_class($this->table);
			$this->canDo		= ComponentbuilderHelper::getActions('joomla_module');
		}

		if (!$this->canDo->get('joomla_module.edit') && !$this->canDo->get('joomla_module.batch'))
		{
			$this->setError(JText::_('JLIB_APPLICATION_ERROR_BATCH_CANNOT_EDIT'));
			return false;
		}

		// make sure published only updates if user has the permission.
		if (isset($values['published']) && !$this->canDo->get('joomla_module.edit.state'))
		{
			unset($values['published']);
		}
		// remove move_copy from array
		unset($values['move_copy']);

		// Parent exists so we proceed
		foreach ($pks as $pk)
		{
			if (!$this->user->authorise('joomla_module.edit', $contexts[$pk]))
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

		// check if the name has placeholder
		if (strpos($data['name'], '[[[') === false && strpos($data['name'], '###') === false)
		{
			// make sure the name is safe to be used as a function name
			$data['name'] = ComponentbuilderHelper::safeClassFunctionName($data['name']);
		}
		// always reset the snippets
		$data['snippet'] = 0;
		// if system name is empty create from name
		if (empty($data['system_name']) || !ComponentbuilderHelper::checkString($data['system_name']))
		{
			$data['system_name'] = $data['name'];
		}

		// Set the GUID if empty or not valid
		if (isset($data['guid']) && !ComponentbuilderHelper::validGUID($data['guid']))
		{
			$data['guid'] = (string) ComponentbuilderHelper::GUID();
		}


		// Set the libraries items to data.
		if (isset($data['libraries']) && is_array($data['libraries']))
		{
			$libraries = new JRegistry;
			$libraries->loadArray($data['libraries']);
			$data['libraries'] = (string) $libraries;
		}
		elseif (!isset($data['libraries']))
		{
			// Set the empty libraries to data
			$data['libraries'] = '';
		}

		// Set the custom_get items to data.
		if (isset($data['custom_get']) && is_array($data['custom_get']))
		{
			$custom_get = new JRegistry;
			$custom_get->loadArray($data['custom_get']);
			$data['custom_get'] = (string) $custom_get;
		}
		elseif (!isset($data['custom_get']))
		{
			// Set the empty custom_get to data
			$data['custom_get'] = '';
		}

		// Set the fields items to data.
		if (isset($data['fields']) && is_array($data['fields']))
		{
			$fields = new JRegistry;
			$fields->loadArray($data['fields']);
			$data['fields'] = (string) $fields;
		}
		elseif (!isset($data['fields']))
		{
			// Set the empty fields to data
			$data['fields'] = '';
		}

		// Set the default string to base64 string.
		if (isset($data['default']))
		{
			$data['default'] = base64_encode($data['default']);
		}

		// Set the php_preflight_update string to base64 string.
		if (isset($data['php_preflight_update']))
		{
			$data['php_preflight_update'] = base64_encode($data['php_preflight_update']);
		}

		// Set the php_preflight_uninstall string to base64 string.
		if (isset($data['php_preflight_uninstall']))
		{
			$data['php_preflight_uninstall'] = base64_encode($data['php_preflight_uninstall']);
		}

		// Set the mod_code string to base64 string.
		if (isset($data['mod_code']))
		{
			$data['mod_code'] = base64_encode($data['mod_code']);
		}

		// Set the php_postflight_install string to base64 string.
		if (isset($data['php_postflight_install']))
		{
			$data['php_postflight_install'] = base64_encode($data['php_postflight_install']);
		}

		// Set the php_postflight_update string to base64 string.
		if (isset($data['php_postflight_update']))
		{
			$data['php_postflight_update'] = base64_encode($data['php_postflight_update']);
		}

		// Set the php_method_uninstall string to base64 string.
		if (isset($data['php_method_uninstall']))
		{
			$data['php_method_uninstall'] = base64_encode($data['php_method_uninstall']);
		}

		// Set the class_helper_header string to base64 string.
		if (isset($data['class_helper_header']))
		{
			$data['class_helper_header'] = base64_encode($data['class_helper_header']);
		}

		// Set the sql string to base64 string.
		if (isset($data['sql']))
		{
			$data['sql'] = base64_encode($data['sql']);
		}

		// Set the class_helper_code string to base64 string.
		if (isset($data['class_helper_code']))
		{
			$data['class_helper_code'] = base64_encode($data['class_helper_code']);
		}

		// Set the sql_uninstall string to base64 string.
		if (isset($data['sql_uninstall']))
		{
			$data['sql_uninstall'] = base64_encode($data['sql_uninstall']);
		}

		// Set the readme string to base64 string.
		if (isset($data['readme']))
		{
			$data['readme'] = base64_encode($data['readme']);
		}

		// Set the php_script_construct string to base64 string.
		if (isset($data['php_script_construct']))
		{
			$data['php_script_construct'] = base64_encode($data['php_script_construct']);
		}

		// Set the php_preflight_install string to base64 string.
		if (isset($data['php_preflight_install']))
		{
			$data['php_preflight_install'] = base64_encode($data['php_preflight_install']);
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

	/**
	 * Method to change the title
	 *
	 * @param   string   $title   The title.
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
