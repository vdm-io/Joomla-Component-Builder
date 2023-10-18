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

use Joomla\CMS\MVC\Model\AdminModel;
use Joomla\Registry\Registry;
use Joomla\String\StringHelper;
use Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Componentbuilder\Power\Factory as PowerFactory;
use VDM\Joomla\Utilities\StringHelper as UtilitiesStringHelper;
use VDM\Joomla\Utilities\ObjectHelper;
use VDM\Joomla\Utilities\ArrayHelper as UtilitiesArrayHelper;
use VDM\Joomla\Utilities\GuidHelper;
use VDM\Joomla\Utilities\String\ClassfunctionHelper;
use VDM\Joomla\Utilities\GetHelper;

/**
 * Componentbuilder Power Admin Model
 */
class ComponentbuilderModelPower extends AdminModel
{
	/**
	 * The tab layout fields array.
	 *
	 * @var      array
	 */
	protected $tabLayoutFields = array(
		'code' => array(
			'left' => array(
				'name',
				'description',
				'extends',
				'extends_custom',
				'implements',
				'implements_custom',
				'namespace',
				'add_head'
			),
			'right' => array(
				'property_selection',
				'method_selection',
				'namespace_details'
			),
			'fullwidth' => array(
				'head',
				'use_selection',
				'main_class_code',
				'load_powers_note',
				'load_selection',
				'note_linked_to_notice',
				'not_required'
			),
			'above' => array(
				'system_name',
				'type',
				'power_version'
			)
		),
		'licensing' => array(
			'fullwidth' => array(
				'add_licensing_template',
				'licensing_template'
			)
		),
		'super_power' => array(
			'left' => array(
				'approved',
				'approved_paths'
			),
			'right' => array(
				'note_approved_paths'
			)
		),
		'composer' => array(
			'fullwidth' => array(
				'autoload_composer_note',
				'composer'
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
	public $typeAlias = 'com_componentbuilder.power';

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
	public function getTable($type = 'power', $prefix = 'ComponentbuilderTable', $config = array())
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
			if ($vdm = ComponentbuilderHelper::get('power__'.$id))
			{
				$this->vastDevMod = $vdm;
			}
			else
			{
				// set the vast development method key
				$this->vastDevMod = UtilitiesStringHelper::random(50);
				ComponentbuilderHelper::set($this->vastDevMod, 'power__'.$id);
				ComponentbuilderHelper::set('power__'.$id, $this->vastDevMod);
				// set a return value if found
				$jinput = JFactory::getApplication()->input;
				$return = $jinput->get('return', null, 'base64');
				ComponentbuilderHelper::set($this->vastDevMod . '__return', $return);
				// set a GUID value if found
				if (isset($item) && ObjectHelper::check($item) && isset($item->guid)
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

			if (!empty($item->licensing_template))
			{
				// base64 Decode licensing_template.
				$item->licensing_template = base64_decode($item->licensing_template);
			}

			if (!empty($item->head))
			{
				// base64 Decode head.
				$item->head = base64_decode($item->head);
			}

			if (!empty($item->main_class_code))
			{
				// base64 Decode main_class_code.
				$item->main_class_code = base64_decode($item->main_class_code);
			}

			if (!empty($item->method_selection))
			{
				// Convert the method_selection field to an array.
				$method_selection = new Registry;
				$method_selection->loadString($item->method_selection);
				$item->method_selection = $method_selection->toArray();
			}

			if (!empty($item->load_selection))
			{
				// Convert the load_selection field to an array.
				$load_selection = new Registry;
				$load_selection->loadString($item->load_selection);
				$item->load_selection = $load_selection->toArray();
			}

			if (!empty($item->composer))
			{
				// Convert the composer field to an array.
				$composer = new Registry;
				$composer->loadString($item->composer);
				$item->composer = $composer->toArray();
			}

			if (!empty($item->property_selection))
			{
				// Convert the property_selection field to an array.
				$property_selection = new Registry;
				$property_selection->loadString($item->property_selection);
				$item->property_selection = $property_selection->toArray();
			}

			if (!empty($item->implements))
			{
				// Convert the implements field to an array.
				$implements = new Registry;
				$implements->loadString($item->implements);
				$item->implements = $implements->toArray();
			}

			if (!empty($item->use_selection))
			{
				// Convert the use_selection field to an array.
				$use_selection = new Registry;
				$use_selection->loadString($item->use_selection);
				$item->use_selection = $use_selection->toArray();
			}

			if (!empty($item->approved_paths))
			{
				// JSON Decode approved_paths.
				$item->approved_paths = json_decode($item->approved_paths);
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
			if ($vdm = ComponentbuilderHelper::get('power__'.$id))
			{
				$this->vastDevMod = $vdm;
			}
			else
			{
				// set the vast development method key
				$this->vastDevMod = UtilitiesStringHelper::random(50);
				ComponentbuilderHelper::set($this->vastDevMod, 'power__'.$id);
				ComponentbuilderHelper::set('power__'.$id, $this->vastDevMod);
				// set a return value if found
				$jinput = JFactory::getApplication()->input;
				$return = $jinput->get('return', null, 'base64');
				ComponentbuilderHelper::set($this->vastDevMod . '__return', $return);
				// set a GUID value if found
				if (isset($item) && ObjectHelper::check($item) && isset($item->guid)
					&& method_exists('ComponentbuilderHelper', 'validGUID')
					&& ComponentbuilderHelper::validGUID($item->guid))
				{
					ComponentbuilderHelper::set($this->vastDevMod . '__guid', $item->guid);
				}
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
		$form = $this->loadForm('com_componentbuilder.power', 'power', $options, $clear, $xpath);

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
		if ($id != 0 && (!$user->authorise('power.edit.state', 'com_componentbuilder.power.' . (int) $id))
			|| ($id == 0 && !$user->authorise('power.edit.state', 'com_componentbuilder')))
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
		if ($id != 0 && (!$user->authorise('power.edit.created_by', 'com_componentbuilder.power.' . (int) $id))
			|| ($id == 0 && !$user->authorise('power.edit.created_by', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('created_by', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('created_by', 'readonly', 'true');
			// Disable fields while saving.
			$form->setFieldAttribute('created_by', 'filter', 'unset');
		}
		// Modify the form based on Edit Creaded Date access controls.
		if ($id != 0 && (!$user->authorise('power.edit.created', 'com_componentbuilder.power.' . (int) $id))
			|| ($id == 0 && !$user->authorise('power.edit.created', 'com_componentbuilder')))
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
		if (UtilitiesArrayHelper::check($editors))
		{
			foreach ($editors as $editor)
			{
				// get the field names
				$name = (string) $editor['name'];
				// set the field editor value (with none as fallback)
				$form->setFieldAttribute($name, 'editor', $global_editor . '|none');
			}
		}


		// Only load the GUID if new item (or empty)
		if (0 == $id || !($val = $form->getValue('guid')))
		{
			$form->setValue('guid', null, GuidHelper::get());
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
		return 'media/com_componentbuilder/js/power.js';
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
			return $user->authorise('power.delete', 'com_componentbuilder.power.' . (int) $record->id);
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
			$permission = $user->authorise('power.edit.state', 'com_componentbuilder.power.' . (int) $recordId);
			if (!$permission && !is_null($permission))
			{
				return false;
			}
		}
		// In the absence of better information, revert to the component permissions.
		return $user->authorise('power.edit.state', 'com_componentbuilder');
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

		return $user->authorise('power.edit', 'com_componentbuilder.power.'. ((int) isset($data[$key]) ? $data[$key] : 0)) or $user->authorise('power.edit',  'com_componentbuilder');
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
					->from($db->quoteName('#__componentbuilder_power'));
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
		$data = JFactory::getApplication()->getUserState('com_componentbuilder.edit.power.data', array());

		if (empty($data))
		{
			$data = $this->getItem();
			// run the perprocess of the data
			$this->preprocessData('com_componentbuilder.power', $data);
		}

		return $data;
	}

	/**
	 * Method to get the unique fields of this table.
	 *
	 * @return  mixed  An array of field names, boolean false if none is set.
	 *
	 * @since   3.0
	 */
	protected function getUniqueFields()
	{
		return array('guid');
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
		ArrayHelper::toInteger($pks);

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
		$this->canDo			= ComponentbuilderHelper::getActions('power');
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
			$cmd = ArrayHelper::getValue($commands, 'move_copy', 'c');

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
			$this->canDo		= ComponentbuilderHelper::getActions('power');
		}

		if (!$this->canDo->get('power.create') && !$this->canDo->get('power.batch'))
		{
			return false;
		}

		// get list of unique fields
		$uniqueFields = $this->getUniqueFields();
		// remove move_copy from array
		unset($values['move_copy']);

		// make sure published is set
		if (!isset($values['published']))
		{
			$values['published'] = 0;
		}
		elseif (isset($values['published']) && !$this->canDo->get('power.edit.state'))
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
			if (!$this->user->authorise('power.edit', $contexts[$pk]))
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
				$this->table->system_name = $this->generateUnique('system_name',$this->table->system_name);
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

			// update all unique fields
			if (ComponentbuilderHelper::checkArray($uniqueFields))
			{
				foreach ($uniqueFields as $uniqueField)
				{
					$this->table->$uniqueField = $this->generateUnique($uniqueField,$this->table->$uniqueField);
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
			$this->canDo		= ComponentbuilderHelper::getActions('power');
		}

		if (!$this->canDo->get('power.edit') && !$this->canDo->get('power.batch'))
		{
			$this->setError(JText::_('JLIB_APPLICATION_ERROR_BATCH_CANNOT_EDIT'));
			return false;
		}

		// make sure published only updates if user has the permission.
		if (isset($values['published']) && !$this->canDo->get('power.edit.state'))
		{
			unset($values['published']);
		}
		// remove move_copy from array
		unset($values['move_copy']);

		// Parent exists so we proceed
		foreach ($pks as $pk)
		{
			if (!$this->user->authorise('power.edit', $contexts[$pk]))
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

		// Set the empty approved_paths item to data
		if (!isset($data['approved_paths']))
		{
			$data['approved_paths'] = '';
		}

		// check if the name has placeholder
		if (strpos($data['name'], '[[[') === false && strpos($data['name'], '###') === false)
		{
			// make sure the name is safe to be used as a function name
			$data['name'] = ClassfunctionHelper::safe($data['name']);
		}

		// if system name is empty create from name
		if (empty($data['system_name']) || !UtilitiesStringHelper::check($data['system_name']))
		{
			$data['system_name'] = $data['name'];
		}

		// must set the version if empty
		if (empty($data['power_version']) && $data['id'] > 0 && ($power_version = GetHelper::var('power', $data['id'], 'id', 'power_version')) !== false)
		{
			$data['power_version'] = $power_version;
		}
		// we must preserve versions (so that a change to the version number must result in save as copy)
		elseif ($data['id'] > 0 && ($old_version = GetHelper::var('power', $data['id'], 'id', 'power_version')) && $data['power_version'] != $old_version)
		{
			// lets check if we already have this version
			if (($existing_id = ComponentbuilderHelper::checkExist('power', ['power_version' => $data['power_version'], 'name' => $data['name'], 'namespace' => $data['namespace']])) !== false)
			{
				// class of that version already exist so we reset the version
				\JFactory::getApplication()->enqueueMessage(JText::sprintf("COM_COMPONENTBUILDER_POWERS_A_HREFS_TARGET_BLANK_TITLEOPEN_POWERSA_WITH_VERSION_S_ALREADY_EXIST", $existing_id, 'index.php?option=com_componentbuilder&view=powers&task=power.edit&id=' . $existing_id, $data['namespace'] . '\\' . $data['name'], $data['power_version']), 'error');
				$data['power_version'] = $old_version;
			}
			else
			{
				// does not exist so we allow save2copy
				$data['id'] = 0;
				JFactory::getApplication()->input->set('task', 'save2copy');
			}
		}

		// load dynamic code if relevant
		if (($main_class_code = PowerFactory::_('Power.Generator')->get($data)) !== null)
		{
			$data['main_class_code'] = $main_class_code;
		}

		// Set the GUID if empty or not valid
		if (empty($data['guid']) && $data['id'] > 0)
		{
			// get the existing one
			$data['guid'] = (string) GetHelper::var('power', $data['id'], 'id', 'guid');
		}

		// Set the GUID if empty or not valid
		while (!GuidHelper::valid($data['guid'], "power", $data['id']))
		{
			// must always be set
			$data['guid'] = (string) GuidHelper::get();
		}

		// Set the method_selection items to data.
		if (isset($data['method_selection']) && is_array($data['method_selection']))
		{
			$method_selection = new JRegistry;
			$method_selection->loadArray($data['method_selection']);
			$data['method_selection'] = (string) $method_selection;
		}
		elseif (!isset($data['method_selection']))
		{
			// Set the empty method_selection to data
			$data['method_selection'] = '';
		}

		// Set the load_selection items to data.
		if (isset($data['load_selection']) && is_array($data['load_selection']))
		{
			$load_selection = new JRegistry;
			$load_selection->loadArray($data['load_selection']);
			$data['load_selection'] = (string) $load_selection;
		}
		elseif (!isset($data['load_selection']))
		{
			// Set the empty load_selection to data
			$data['load_selection'] = '';
		}

		// Set the composer items to data.
		if (isset($data['composer']) && is_array($data['composer']))
		{
			$composer = new JRegistry;
			$composer->loadArray($data['composer']);
			$data['composer'] = (string) $composer;
		}
		elseif (!isset($data['composer']))
		{
			// Set the empty composer to data
			$data['composer'] = '';
		}

		// Set the property_selection items to data.
		if (isset($data['property_selection']) && is_array($data['property_selection']))
		{
			$property_selection = new JRegistry;
			$property_selection->loadArray($data['property_selection']);
			$data['property_selection'] = (string) $property_selection;
		}
		elseif (!isset($data['property_selection']))
		{
			// Set the empty property_selection to data
			$data['property_selection'] = '';
		}

		// Set the implements items to data.
		if (isset($data['implements']) && is_array($data['implements']))
		{
			$implements = new JRegistry;
			$implements->loadArray($data['implements']);
			$data['implements'] = (string) $implements;
		}
		elseif (!isset($data['implements']))
		{
			// Set the empty implements to data
			$data['implements'] = '';
		}

		// Set the use_selection items to data.
		if (isset($data['use_selection']) && is_array($data['use_selection']))
		{
			$use_selection = new JRegistry;
			$use_selection->loadArray($data['use_selection']);
			$data['use_selection'] = (string) $use_selection;
		}
		elseif (!isset($data['use_selection']))
		{
			// Set the empty use_selection to data
			$data['use_selection'] = '';
		}

		// Set the approved_paths string to JSON string.
		if (isset($data['approved_paths']))
		{
			$data['approved_paths'] = (string) json_encode($data['approved_paths']);
		}

		// Set the licensing_template string to base64 string.
		if (isset($data['licensing_template']))
		{
			$data['licensing_template'] = base64_encode($data['licensing_template']);
		}

		// Set the head string to base64 string.
		if (isset($data['head']))
		{
			$data['head'] = base64_encode($data['head']);
		}

		// Set the main_class_code string to base64 string.
		if (isset($data['main_class_code']))
		{
			$data['main_class_code'] = base64_encode($data['main_class_code']);
		}
        
		// Set the Params Items to data
		if (isset($data['params']) && is_array($data['params']))
		{
			$params = new JRegistry;
			$params->loadArray($data['params']);
			$data['params'] = (string) $params;
		}

		// Alter the unique field for save as copy
		if ($input->get('task') === 'save2copy')
		{
			// Automatic handling of other unique fields
			$uniqueFields = $this->getUniqueFields();
			if (ComponentbuilderHelper::checkArray($uniqueFields))
			{
				foreach ($uniqueFields as $uniqueField)
				{
					$data[$uniqueField] = $this->generateUnique($uniqueField,$data[$uniqueField]);
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
	 * Method to generate a unique value.
	 *
	 * @param   string  $field name.
	 * @param   string  $value data.
	 *
	 * @return  string  New value.
	 *
	 * @since   3.0
	 */
	protected function generateUnique($field,$value)
	{

		// set field value unique
		$table = $this->getTable();

		while ($table->load(array($field => $value)))
		{
			$value = StringHelper::increment($value);
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
			$title = StringHelper::increment($title);
		}

		return $title;
	}
}
