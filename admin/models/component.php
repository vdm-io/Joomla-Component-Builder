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

	@version		2.1.0
	@build			26th February, 2016
	@created		30th April, 2015
	@package		Component Builder
	@subpackage		component.php
	@author			Llewellyn van der Merwe <https://www.vdm.io/joomla-component-builder>
	@my wife		Roline van der Merwe <http://www.vdm.io/>	
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
 * Componentbuilder Component Model
 */
class ComponentbuilderModelComponent extends JModelAdmin
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
	public $typeAlias = 'com_componentbuilder.component';

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
	public function getTable($type = 'component', $prefix = 'ComponentbuilderTable', $config = array())
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

			if (!empty($item->php_helper_admin))
			{
				// base64 Decode php_helper_admin.
				$item->php_helper_admin = base64_decode($item->php_helper_admin);
			}

			if (!empty($item->php_helper_site))
			{
				// base64 Decode php_helper_site.
				$item->php_helper_site = base64_decode($item->php_helper_site);
			}

			if (!empty($item->sql))
			{
				// base64 Decode sql.
				$item->sql = base64_decode($item->sql);
			}

			if (!empty($item->css))
			{
				// base64 Decode css.
				$item->css = base64_decode($item->css);
			}

			if (!empty($item->php_admin_event))
			{
				// base64 Decode php_admin_event.
				$item->php_admin_event = base64_decode($item->php_admin_event);
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

			if (!empty($item->readme))
			{
				// base64 Decode readme.
				$item->readme = base64_decode($item->readme);
			}

			// Get the basic encription.
			$basickey = ComponentbuilderHelper::getCryptKey('basic');
			// Get the encription object.
			$basic = new FOFEncryptAes($basickey, 128);

			if (!empty($item->whmcs_key) && $basickey && !is_numeric($item->whmcs_key) && $item->whmcs_key === base64_encode(base64_decode($item->whmcs_key, true)))
			{
				// basic decript data whmcs_key.
				$item->whmcs_key = rtrim($basic->decryptString($item->whmcs_key), "\0");
			}
			
			if (!empty($item->id))
			{
				$item->tags = new JHelperTags;
				$item->tags->getTagIds($item->id, 'com_componentbuilder.component');
			}
		}
		$this->idfwlm = $item->addadmin_views;
		$this->idjdbz = $item->addsite_views;

		return $item;
	}

	/**
	* Method to get list data.
	*
	* @return mixed  An array of data items on success, false on failure.
	*/
	public function getZifadmin_views()
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
			$idfwlm = json_decode($this->idfwlm,true);
			if (ComponentbuilderHelper::checkArray($items) && isset($idfwlm) && ComponentbuilderHelper::checkArray($idfwlm))
			{
				foreach ($items as $nr => &$item)
				{
					if ($item->id && isset($idfwlm['adminview']) && ComponentbuilderHelper::checkArray($idfwlm['adminview']))
					{
						if (!in_array($item->id,$idfwlm['adminview']))
						{
							unset($items[$nr]);
							continue;
						}
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
	public function getHdssite_views()
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
			$idjdbz = json_decode($this->idjdbz,true);
			if (ComponentbuilderHelper::checkArray($items) && isset($idjdbz) && ComponentbuilderHelper::checkArray($idjdbz))
			{
				foreach ($items as $nr => &$item)
				{
					if ($item->id && isset($idjdbz['siteview']) && ComponentbuilderHelper::checkArray($idjdbz['siteview']))
					{
						if (!in_array($item->id,$idjdbz['siteview']))
						{
							unset($items[$nr]);
							continue;
						}
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
	{		// Get the form.
		$form = $this->loadForm('com_componentbuilder.component', 'component', array('control' => 'jform', 'load_data' => $loadData));

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
		if ($id != 0 && (!$user->authorise('core.edit.state', 'com_componentbuilder.component.' . (int) $id))
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
		return 'administrator/components/com_componentbuilder/models/forms/component.js';
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
			return $user->authorise('core.delete', 'com_componentbuilder.component.' . (int) $record->id);
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
			$permission = $user->authorise('core.edit.state', 'com_componentbuilder.component.' . (int) $recordId);
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

		return JFactory::getUser()->authorise('core.edit', 'com_componentbuilder.component.'. ((int) isset($data[$key]) ? $data[$key] : 0)) or parent::allowEdit($data, $key);
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
					->from($db->quoteName('#__componentbuilder_component'));
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
		$data = JFactory::getApplication()->getUserState('com_componentbuilder.edit.component.data', array());

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
		$this->canDo			= ComponentbuilderHelper::getActions('component');
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
			$this->canDo		= ComponentbuilderHelper::getActions('component');
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
			$this->canDo		= ComponentbuilderHelper::getActions('component');
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
					if ('access' == $key && strlen($value) > 0)
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

		// Set the php_helper_admin string to base64 string.
		if (isset($data['php_helper_admin']))
		{
			$data['php_helper_admin'] = base64_encode($data['php_helper_admin']);
		}

		// Set the php_helper_site string to base64 string.
		if (isset($data['php_helper_site']))
		{
			$data['php_helper_site'] = base64_encode($data['php_helper_site']);
		}

		// Set the sql string to base64 string.
		if (isset($data['sql']))
		{
			$data['sql'] = base64_encode($data['sql']);
		}

		// Set the css string to base64 string.
		if (isset($data['css']))
		{
			$data['css'] = base64_encode($data['css']);
		}

		// Set the php_admin_event string to base64 string.
		if (isset($data['php_admin_event']))
		{
			$data['php_admin_event'] = base64_encode($data['php_admin_event']);
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

		// Set the readme string to base64 string.
		if (isset($data['readme']))
		{
			$data['readme'] = base64_encode($data['readme']);
		}

		// Get the basic encription key.
		$basickey = ComponentbuilderHelper::getCryptKey('basic');
		// Get the encription object
		$basic = new FOFEncryptAes($basickey, 128);

		// Encript data whmcs_key.
		if (isset($data['whmcs_key']) && $basickey)
		{
			$data['whmcs_key'] = $basic->encryptString($data['whmcs_key']);
		}
        
		// Set the Params Items to data
		if (isset($data['params']) && is_array($data['params']))
		{
			$params = new JRegistry;
			$params->loadArray($data['params']);
			$data['params'] = (string) $params;
		}

		// Alter the uniqe field for save as copy
		if ($input->get('task') == 'save2copy')
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
