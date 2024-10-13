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
namespace VDM\Component\Componentbuilder\Administrator\Model;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Application\CMSApplicationInterface;
use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\Form\Form;
use Joomla\CMS\Filter\InputFilter;
use Joomla\CMS\Filter\OutputFilter;
use Joomla\CMS\MVC\Model\AdminModel;
use Joomla\CMS\MVC\Factory\MVCFactoryInterface;
use Joomla\CMS\Table\Table;
use Joomla\CMS\UCM\UCMType;
use Joomla\CMS\Versioning\VersionableModelTrait;
use Joomla\CMS\User\User;
use Joomla\Registry\Registry;
use Joomla\String\StringHelper;
use Joomla\Utilities\ArrayHelper;
use Joomla\Input\Input;
use VDM\Component\Componentbuilder\Administrator\Helper\ComponentbuilderHelper;
use Joomla\CMS\Helper\TagsHelper;
use VDM\Joomla\Utilities\SessionHelper;
use VDM\Joomla\Utilities\StringHelper as UtilitiesStringHelper;
use VDM\Joomla\Utilities\ObjectHelper;
use VDM\Joomla\Utilities\GuidHelper;
use VDM\Joomla\Utilities\ArrayHelper as UtilitiesArrayHelper;
use VDM\Joomla\Utilities\GetHelper;

// No direct access to this file
\defined('_JEXEC') or die;

/**
 * Componentbuilder Dynamic_get Admin Model
 *
 * @since  1.6
 */
class Dynamic_getModel extends AdminModel
{
	use VersionableModelTrait;

	/**
	 * The tab layout fields array.
	 *
	 * @var    array
	 * @since  3.0.0
	 */
	protected $tabLayoutFields = array(
		'main' => array(
			'left' => array(
				'main_source',
				'view_table_main',
				'db_table_main',
				'select_all',
				'view_selection',
				'db_selection'
			),
			'right' => array(
				'plugin_events'
			),
			'fullwidth' => array(
				'php_custom_get',
				'note_linked_to_notice'
			),
			'above' => array(
				'name',
				'gettype',
				'getcustom',
				'pagination'
			),
			'under' => array(
				'not_required'
			)
		),
		'abacus' => array(
			'left' => array(
				'addcalculation'
			),
			'fullwidth' => array(
				'note_calculation_item',
				'note_calculation_items',
				'php_calculation'
			)
		),
		'custom_script' => array(
			'fullwidth' => array(
				'add_php_before_getitem',
				'php_before_getitem',
				'add_php_after_getitem',
				'php_after_getitem',
				'add_php_getlistquery',
				'php_getlistquery',
				'add_php_before_getitems',
				'php_before_getitems',
				'add_php_after_getitems',
				'php_after_getitems',
				'add_php_router_parse',
				'php_router_parse_notice',
				'php_router_parse'
			)
		),
		'joint' => array(
			'fullwidth' => array(
				'join_view_table',
				'join_db_table'
			)
		),
		'tweak' => array(
			'fullwidth' => array(
				'filter',
				'where',
				'order',
				'group',
				'global'
			)
		)
	);

	/**
	 * The styles array.
	 *
	 * @var    array
	 * @since  4.3
	 */
	protected array $styles = [
		'administrator/components/com_componentbuilder/assets/css/admin.css',
		'administrator/components/com_componentbuilder/assets/css/dynamic_get.css'
 	];

	/**
	 * The scripts array.
	 *
	 * @var    array
	 * @since  4.3
	 */
	protected array $scripts = [
		'administrator/components/com_componentbuilder/assets/js/admin.js',
		'media/com_componentbuilder/js/dynamic_get.js'
 	];

	/**
	 * @var     string    The prefix to use with controller messages.
	 * @since   1.6
	 */
	protected $text_prefix = 'COM_COMPONENTBUILDER';

	/**
	 * The type alias for this content type.
	 *
	 * @var      string
	 * @since    3.2
	 */
	public $typeAlias = 'com_componentbuilder.dynamic_get';

	/**
	 * Returns a Table object, always creating it
	 *
	 * @param   type    $type    The table type to instantiate
	 * @param   string  $prefix  A prefix for the table class name. Optional.
	 * @param   array   $config  Configuration array for model. Optional.
	 *
	 * @return  Table  A database object
	 * @since   3.0
	 * @throws  \Exception
	 */
	public function getTable($type = 'dynamic_get', $prefix = 'Administrator', $config = [])
	{
		// get instance of the table
		return parent::getTable($type, $prefix, $config);
	}


	/**
	 * Retrieves or generates a Vast Development Method (VDM) key for the current item.
	 *
	 * This function performs the following operations:
	 * 1. Checks if the VDM key is already set. If not, it proceeds to generate or retrieve one.
	 * 2. Determines the item ID based on the presence of a specific argument.
	 * 3. Attempts to retrieve an existing VDM key from a helper method using the item ID.
	 * 4. If a VDM key is not found, it generates a new random VDM key.
	 * 5. Stores the VDM key and associates it with the item ID in a helper method.
	 * 6. Optionally, stores return and GUID values if available.
	 * 7. Returns the VDM key.
	 *
	 * @return string The VDM key for the current item.
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
			if (($vdm = SessionHelper::get('dynamic_get__'.$id)) !== null)
			{
				$this->vastDevMod = $vdm;
			}
			else
			{
				// set the vast development method key
				$this->vastDevMod = UtilitiesStringHelper::random(50);
				SessionHelper::set($this->vastDevMod, 'dynamic_get__'.$id);
				SessionHelper::set('dynamic_get__'.$id, $this->vastDevMod);
				// set a return value if found
				$jinput = Factory::getApplication()->input;
				$return = $jinput->get('return', null, 'base64');
				SessionHelper::set($this->vastDevMod . '__return', $return);
				// set a GUID value if found
				if (isset($item) && ObjectHelper::check($item) && isset($item->guid)
					&& GuidHelper::valid($item->guid))
				{
					SessionHelper::set($this->vastDevMod . '__guid', $item->guid);
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

			if (!empty($item->php_calculation))
			{
				// base64 Decode php_calculation.
				$item->php_calculation = base64_decode($item->php_calculation);
			}

			if (!empty($item->php_router_parse))
			{
				// base64 Decode php_router_parse.
				$item->php_router_parse = base64_decode($item->php_router_parse);
			}

			if (!empty($item->php_custom_get))
			{
				// base64 Decode php_custom_get.
				$item->php_custom_get = base64_decode($item->php_custom_get);
			}

			if (!empty($item->php_before_getitem))
			{
				// base64 Decode php_before_getitem.
				$item->php_before_getitem = base64_decode($item->php_before_getitem);
			}

			if (!empty($item->php_after_getitem))
			{
				// base64 Decode php_after_getitem.
				$item->php_after_getitem = base64_decode($item->php_after_getitem);
			}

			if (!empty($item->php_getlistquery))
			{
				// base64 Decode php_getlistquery.
				$item->php_getlistquery = base64_decode($item->php_getlistquery);
			}

			if (!empty($item->php_before_getitems))
			{
				// base64 Decode php_before_getitems.
				$item->php_before_getitems = base64_decode($item->php_before_getitems);
			}

			if (!empty($item->php_after_getitems))
			{
				// base64 Decode php_after_getitems.
				$item->php_after_getitems = base64_decode($item->php_after_getitems);
			}

			if (!empty($item->join_db_table))
			{
				// Convert the join_db_table field to an array.
				$join_db_table = new Registry;
				$join_db_table->loadString($item->join_db_table);
				$item->join_db_table = $join_db_table->toArray();
			}

			if (!empty($item->filter))
			{
				// Convert the filter field to an array.
				$filter = new Registry;
				$filter->loadString($item->filter);
				$item->filter = $filter->toArray();
			}

			if (!empty($item->where))
			{
				// Convert the where field to an array.
				$where = new Registry;
				$where->loadString($item->where);
				$item->where = $where->toArray();
			}

			if (!empty($item->order))
			{
				// Convert the order field to an array.
				$order = new Registry;
				$order->loadString($item->order);
				$item->order = $order->toArray();
			}

			if (!empty($item->group))
			{
				// Convert the group field to an array.
				$group = new Registry;
				$group->loadString($item->group);
				$item->group = $group->toArray();
			}

			if (!empty($item->global))
			{
				// Convert the global field to an array.
				$global = new Registry;
				$global->loadString($item->global);
				$item->global = $global->toArray();
			}

			if (!empty($item->join_view_table))
			{
				// Convert the join_view_table field to an array.
				$join_view_table = new Registry;
				$join_view_table->loadString($item->join_view_table);
				$item->join_view_table = $join_view_table->toArray();
			}

			if (!empty($item->plugin_events))
			{
				// JSON Decode plugin_events.
				$item->plugin_events = json_decode($item->plugin_events);
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
			if (($vdm = SessionHelper::get('dynamic_get__'.$id)) !== null)
			{
				$this->vastDevMod = $vdm;
			}
			else
			{
				// set the vast development method key
				$this->vastDevMod = UtilitiesStringHelper::random(50);
				SessionHelper::set($this->vastDevMod, 'dynamic_get__'.$id);
				SessionHelper::set('dynamic_get__'.$id, $this->vastDevMod);
				// set a return value if found
				$jinput = Factory::getApplication()->input;
				$return = $jinput->get('return', null, 'base64');
				SessionHelper::set($this->vastDevMod . '__return', $return);
				// set a GUID value if found
				if (isset($item) && ObjectHelper::check($item) && isset($item->guid)
					&& GuidHelper::valid($item->guid))
				{
					SessionHelper::set($this->vastDevMod . '__guid', $item->guid);
				}
			}

			// update the fields
			$objectUpdate = new \stdClass();
			$objectUpdate->id = (int) $item->id;
			// repeatable values to check
			$arrayChecker = array(
				'join_view_table' => 'view_table',
				'join_db_table' => 'db_table',
				'filter' => 'filter_type',
				'where' => 'table_key',
				'order' => 'table_key',
				'global' => 'name'
			);
			foreach ($arrayChecker as $_value => $checker)
			{
				// check what type of array we have here (should be subform... but just in case)
				// This could happen due to huge data sets
				if (isset($item->{$_value}) && isset($item->{$_value}[$checker]))
				{
					$bucket = array();
					foreach($item->{$_value} as $option => $values)
					{
						foreach($values as $nr => $value)
						{
							$bucket[$_value.$nr][$option] = $value;
						}
					}
					$item->{$_value} = $bucket;
					$objectUpdate->{$_value} = json_encode($bucket);
				}
			}
			// be sure to update the table if we found repeatable fields that are still not converted
			if (count((array) $objectUpdate) > 1)
			{
				$this->_db->updateObject('#__componentbuilder_dynamic_get', $objectUpdate, 'id');
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
	 * @return  Form|boolean  A Form object on success, false on failure
	 * @since   1.6
	 */
	public function getForm($data = [], $loadData = true, $options = ['control' => 'jform'])
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
		$form = $this->loadForm('com_componentbuilder.dynamic_get', 'dynamic_get', $options, $clear, $xpath);

		if (empty($form))
		{
			return false;
		}

		$jinput = Factory::getApplication()->input;

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

		$user = Factory::getApplication()->getIdentity();

		// Check for existing item.
		// Modify the form based on Edit State access controls.
		if ($id != 0 && (!$user->authorise('dynamic_get.edit.state', 'com_componentbuilder.dynamic_get.' . (int) $id))
			|| ($id == 0 && !$user->authorise('dynamic_get.edit.state', 'com_componentbuilder')))
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
		$global_editor = ComponentHelper::getParams('com_componentbuilder')->get('editor', 'none');
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
 

		// update the join_view_table (sub form) layout
		$form->setFieldAttribute('join_view_table', 'layout', ComponentbuilderHelper::getSubformLayout('dynamic_get', 'join_view_table'));

		// update the join_db_table (sub form) layout
		$form->setFieldAttribute('join_db_table', 'layout', ComponentbuilderHelper::getSubformLayout('dynamic_get', 'join_db_table'));
		return $form;
	}

	/**
	 * Method to get the styles that have to be included on the view
	 *
	 * @return  array    styles files
	 * @since   4.3
	 */
	public function getStyles(): array
	{
		return $this->styles;
	}

	/**
	 * Method to set the styles that have to be included on the view
	 *
	 * @return  void
	 * @since   4.3
	 */
	public function setStyles(string $path): void
	{
		$this->styles[] = $path;
	}

	/**
	 * Method to get the script that have to be included on the view
	 *
	 * @return  array    script files
	 * @since   4.3
	 */
	public function getScripts(): array
	{
		return $this->scripts;
	}

	/**
	 * Method to set the script that have to be included on the view
	 *
	 * @return  void
	 * @since   4.3
	 */
	public function setScript(string $path): void
	{
		$this->scripts[] = $path;
	}

	/**
	 * Method to test whether a record can be deleted.
	 *
	 * @param   object  $record  A record object.
	 *
	 * @return  boolean  True if allowed to delete the record. Defaults to the permission set in the component.
	 * @since   1.6
	 */
	protected function canDelete($record)
	{
		if (empty($record->id) || ($record->published != -2))
		{
			return false;
		}

		// The record has been set. Check the record permissions.
		return $this->getCurrentUser()->authorise('dynamic_get.delete', 'com_componentbuilder.dynamic_get.' . (int) $record->id);
	}

	/**
	 * Method to test whether a record can have its state edited.
	 *
	 * @param   object  $record  A record object.
	 *
	 * @return  boolean  True if allowed to change the state of the record. Defaults to the permission set in the component.
	 * @since   1.6
	 */
	protected function canEditState($record)
	{
		$user = $this->getCurrentUser();
		$recordId = $record->id ?? 0;

		if ($recordId)
		{
			// The record has been set. Check the record permissions.
			$permission = $user->authorise('dynamic_get.edit.state', 'com_componentbuilder.dynamic_get.' . (int) $recordId);
			if (!$permission && !is_null($permission))
			{
				return false;
			}
		}
		// In the absence of better information, revert to the component permissions.
		return $user->authorise('dynamic_get.edit.state', 'com_componentbuilder');
	}

	/**
	 * Method override to check if you can edit an existing record.
	 *
	 * @param    array    $data   An array of input data.
	 * @param    string   $key    The name of the key for the primary key.
	 *
	 * @return   boolean
	 * @since    2.5
	 */
	protected function allowEdit($data = [], $key = 'id')
	{
		// Check specific edit permission then general edit permission.
		$user = Factory::getApplication()->getIdentity();

		return $user->authorise('dynamic_get.edit', 'com_componentbuilder.dynamic_get.'. ((int) isset($data[$key]) ? $data[$key] : 0)) or $user->authorise('dynamic_get.edit',  'com_componentbuilder');
	}

	/**
	 * Prepare and sanitise the table data prior to saving.
	 *
	 * @param   Table  $table  A Table object.
	 *
	 * @return  void
	 * @since   1.6
	 */
	protected function prepareTable($table)
	{
		$date = Factory::getDate();
		$user = $this->getCurrentUser();

		if (isset($table->name))
		{
			$table->name = \htmlspecialchars_decode($table->name, ENT_QUOTES);
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
				$db = $this->getDatabase();
				$query = $db->getQuery(true)
					->select('MAX(ordering)')
					->from($db->quoteName('#__componentbuilder_dynamic_get'));
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
	 * @since   1.6
	 */
	protected function loadFormData()
	{
		// Check the session for previously entered form data.
		$data = Factory::getApplication()->getUserState('com_componentbuilder.edit.dynamic_get.data', []);

		if (empty($data))
		{
			$data = $this->getItem();
		}

		// run the perprocess of the data
		$this->preprocessData('com_componentbuilder.dynamic_get', $data);

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
		if (isset($data['not_required']) && UtilitiesStringHelper::check($data['not_required']))
		{
			$requiredFields = (array) explode(',',(string) $data['not_required']);
			$requiredFields = array_unique($requiredFields);
			// now change the required field attributes value
			foreach ($requiredFields as $requiredField)
			{
				// make sure there is a string value
				if (UtilitiesStringHelper::check($requiredField))
				{
					// change to false
					$form->setFieldAttribute($requiredField, 'required', 'false');
					// also clear the data set
					unset($data[$requiredField]);
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
	protected function getUniqueFields()
	{
		return array('guid');
	}

	/**
	 * Method to delete one or more records.
	 *
	 * @param   array  &$pks  An array of record primary keys.
	 *
	 * @return  boolean  True if successful, false if an error occurs
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
			$this->setError(Text::_('JGLOBAL_NO_ITEM_SELECTED'));
			return false;
		}

		$done = false;

		// Set some needed variables.
		$this->user ??= $this->getCurrentUser();
		$this->table = $this->getTable();
		$this->tableClassName = get_class($this->table);
		$this->contentType = new UCMType;
		$this->type = $this->contentType->getTypeByTable($this->tableClassName);
		$this->canDo = ComponentbuilderHelper::getActions('dynamic_get');
		$this->batchSet = true;

		if (!$this->canDo->get('core.batch'))
		{
			$this->setError(Text::_('JLIB_APPLICATION_ERROR_INSUFFICIENT_BATCH_INFORMATION'));
			return false;
		}

		if ($this->type == false)
		{
			$type = new UCMType;
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
			$this->setError(Text::_('JLIB_APPLICATION_ERROR_INSUFFICIENT_BATCH_INFORMATION'));
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
			$this->user 		= Factory::getApplication()->getIdentity();
			$this->table 		= $this->getTable();
			$this->tableClassName	= get_class($this->table);
			$this->canDo		= ComponentbuilderHelper::getActions('dynamic_get');
		}

		if (!$this->canDo->get('dynamic_get.create') && !$this->canDo->get('dynamic_get.batch'))
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
		elseif (isset($values['published']) && !$this->canDo->get('dynamic_get.edit.state'))
		{
				$values['published'] = 0;
		}

		$newIds = [];
		// Parent exists so let's proceed
		while (!empty($pks))
		{
			// Pop the first ID off the stack
			$pk = array_shift($pks);

			$this->table->reset();

			// only allow copy if user may edit this item.
			if (!$this->user->authorise('dynamic_get.edit', $contexts[$pk]))
			{
				// Not fatal error
				$this->setError(Text::sprintf('JLIB_APPLICATION_ERROR_BATCH_MOVE_ROW_NOT_FOUND', $pk));
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
					$this->setError(Text::sprintf('JLIB_APPLICATION_ERROR_BATCH_MOVE_ROW_NOT_FOUND', $pk));
					continue;
				}
			}

			// Only for strings
			if (UtilitiesStringHelper::check($this->table->name) && !is_numeric($this->table->name))
			{
				$this->table->name = $this->generateUnique('name',$this->table->name);
			}

			// insert all set values
			if (UtilitiesArrayHelper::check($values))
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
			if (UtilitiesArrayHelper::check($uniqueFields))
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
			$this->user		= Factory::getApplication()->getIdentity();
			$this->table		= $this->getTable();
			$this->tableClassName	= get_class($this->table);
			$this->canDo		= ComponentbuilderHelper::getActions('dynamic_get');
		}

		if (!$this->canDo->get('dynamic_get.edit') && !$this->canDo->get('dynamic_get.batch'))
		{
			$this->setError(Text::_('JLIB_APPLICATION_ERROR_BATCH_CANNOT_EDIT'));
			return false;
		}

		// make sure published only updates if user has the permission.
		if (isset($values['published']) && !$this->canDo->get('dynamic_get.edit.state'))
		{
			unset($values['published']);
		}
		// remove move_copy from array
		unset($values['move_copy']);

		// Parent exists so we proceed
		foreach ($pks as $pk)
		{
			if (!$this->user->authorise('dynamic_get.edit', $contexts[$pk]))
			{
				$this->setError(Text::_('JLIB_APPLICATION_ERROR_BATCH_CANNOT_EDIT'));
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
					$this->setError(Text::sprintf('JLIB_APPLICATION_ERROR_BATCH_MOVE_ROW_NOT_FOUND', $pk));
					continue;
				}
			}

			// insert all set values.
			if (UtilitiesArrayHelper::check($values))
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
	 * @since   1.6
	 */
	public function save($data)
	{
		$input    = Factory::getApplication()->getInput();
		$filter   = InputFilter::getInstance();

		// set the metadata to the Item Data
		if (isset($data['metadata']) && isset($data['metadata']['author']))
		{
			$data['metadata']['author'] = $filter->clean($data['metadata']['author'], 'TRIM');

			$metadata = new Registry;
			$metadata->loadArray($data['metadata']);
			$data['metadata'] = (string) $metadata;
		}


		// Set the GUID if empty or not valid
		if (empty($data['guid']) && $data['id'] > 0)
		{
			// get the existing one
			$data['guid'] = (string) GetHelper::var('dynamic_get', $data['id'], 'id', 'guid');
		}

		// Set the GUID if empty or not valid
		while (!GuidHelper::valid($data['guid'], "dynamic_get", $data['id']))
		{
			// must always be set
			$data['guid'] = (string) GuidHelper::get();
		}

		// Set the join_db_table items to data.
		if (isset($data['join_db_table']) && is_array($data['join_db_table']))
		{
			$join_db_table = new Registry;
			$join_db_table->loadArray($data['join_db_table']);
			$data['join_db_table'] = (string) $join_db_table;
		}
		elseif (!isset($data['join_db_table']))
		{
			// Set the empty join_db_table to data
			$data['join_db_table'] = '';
		}

		// Set the filter items to data.
		if (isset($data['filter']) && is_array($data['filter']))
		{
			$filter = new Registry;
			$filter->loadArray($data['filter']);
			$data['filter'] = (string) $filter;
		}
		elseif (!isset($data['filter']))
		{
			// Set the empty filter to data
			$data['filter'] = '';
		}

		// Set the where items to data.
		if (isset($data['where']) && is_array($data['where']))
		{
			$where = new Registry;
			$where->loadArray($data['where']);
			$data['where'] = (string) $where;
		}
		elseif (!isset($data['where']))
		{
			// Set the empty where to data
			$data['where'] = '';
		}

		// Set the order items to data.
		if (isset($data['order']) && is_array($data['order']))
		{
			$order = new Registry;
			$order->loadArray($data['order']);
			$data['order'] = (string) $order;
		}
		elseif (!isset($data['order']))
		{
			// Set the empty order to data
			$data['order'] = '';
		}

		// Set the group items to data.
		if (isset($data['group']) && is_array($data['group']))
		{
			$group = new Registry;
			$group->loadArray($data['group']);
			$data['group'] = (string) $group;
		}
		elseif (!isset($data['group']))
		{
			// Set the empty group to data
			$data['group'] = '';
		}

		// Set the global items to data.
		if (isset($data['global']) && is_array($data['global']))
		{
			$global = new Registry;
			$global->loadArray($data['global']);
			$data['global'] = (string) $global;
		}
		elseif (!isset($data['global']))
		{
			// Set the empty global to data
			$data['global'] = '';
		}

		// Set the join_view_table items to data.
		if (isset($data['join_view_table']) && is_array($data['join_view_table']))
		{
			$join_view_table = new Registry;
			$join_view_table->loadArray($data['join_view_table']);
			$data['join_view_table'] = (string) $join_view_table;
		}
		elseif (!isset($data['join_view_table']))
		{
			// Set the empty join_view_table to data
			$data['join_view_table'] = '';
		}

		// Set the plugin_events string to JSON string.
		if (isset($data['plugin_events']))
		{
			$data['plugin_events'] = (string) json_encode($data['plugin_events']);
		}

		// Set the php_calculation string to base64 string.
		if (isset($data['php_calculation']))
		{
			$data['php_calculation'] = base64_encode($data['php_calculation']);
		}

		// Set the php_router_parse string to base64 string.
		if (isset($data['php_router_parse']))
		{
			$data['php_router_parse'] = base64_encode($data['php_router_parse']);
		}

		// Set the php_custom_get string to base64 string.
		if (isset($data['php_custom_get']))
		{
			$data['php_custom_get'] = base64_encode($data['php_custom_get']);
		}

		// Set the php_before_getitem string to base64 string.
		if (isset($data['php_before_getitem']))
		{
			$data['php_before_getitem'] = base64_encode($data['php_before_getitem']);
		}

		// Set the php_after_getitem string to base64 string.
		if (isset($data['php_after_getitem']))
		{
			$data['php_after_getitem'] = base64_encode($data['php_after_getitem']);
		}

		// Set the php_getlistquery string to base64 string.
		if (isset($data['php_getlistquery']))
		{
			$data['php_getlistquery'] = base64_encode($data['php_getlistquery']);
		}

		// Set the php_before_getitems string to base64 string.
		if (isset($data['php_before_getitems']))
		{
			$data['php_before_getitems'] = base64_encode($data['php_before_getitems']);
		}

		// Set the php_after_getitems string to base64 string.
		if (isset($data['php_after_getitems']))
		{
			$data['php_after_getitems'] = base64_encode($data['php_after_getitems']);
		}

		// Set the Params Items to data
		if (isset($data['params']) && is_array($data['params']))
		{
			$params = new Registry;
			$params->loadArray($data['params']);
			$data['params'] = (string) $params;
		}

		// Alter the unique field for save as copy
		if ($input->get('task') === 'save2copy')
		{
			// Automatic handling of other unique fields
			$uniqueFields = $this->getUniqueFields();
			if (UtilitiesArrayHelper::check($uniqueFields))
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
	 * @since   3.0
	 */
	protected function generateUnique($field, $value)
	{
		// set field value unique
		$table = $this->getTable();

		while ($table->load([$field => $value]))
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

		while ($table->load(['title' => $title]))
		{
			$title = StringHelper::increment($title);
		}

		return $title;
	}
}
