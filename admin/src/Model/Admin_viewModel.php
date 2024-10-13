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
 * Componentbuilder Admin_view Admin Model
 *
 * @since  1.6
 */
class Admin_viewModel extends AdminModel
{
	use VersionableModelTrait;

	/**
	 * The tab layout fields array.
	 *
	 * @var    array
	 * @since  3.0.0
	 */
	protected $tabLayoutFields = array(
		'details' => array(
			'left' => array(
				'name_single',
				'name_list',
				'type',
				'icon',
				'icon_add',
				'icon_category'
			),
			'right' => array(
				'short_description',
				'description',
				'add_fadein'
			),
			'fullwidth' => array(
				'note_linked_to_notice'
			),
			'above' => array(
				'system_name'
			),
			'under' => array(
				'not_required'
			)
		),
		'php' => array(
			'fullwidth' => array(
				'add_php_ajax',
				'php_ajaxmethod',
				'ajax_input',
				'add_php_getitem',
				'php_getitem',
				'add_php_getitems',
				'php_getitems',
				'add_php_getitems_after_all',
				'php_getitems_after_all',
				'add_php_getlistquery',
				'php_getlistquery',
				'add_php_getform',
				'php_getform',
				'add_php_before_save',
				'php_before_save',
				'add_php_save',
				'php_save',
				'add_php_postsavehook',
				'php_postsavehook',
				'add_php_allowadd',
				'php_allowadd',
				'add_php_allowedit',
				'php_allowedit',
				'add_php_before_cancel',
				'php_before_cancel',
				'add_php_after_cancel',
				'php_after_cancel',
				'add_php_batchcopy',
				'php_batchcopy',
				'add_php_batchmove',
				'php_batchmove',
				'add_php_before_publish',
				'php_before_publish',
				'add_php_after_publish',
				'php_after_publish',
				'add_php_before_delete',
				'php_before_delete',
				'add_php_after_delete',
				'php_after_delete',
				'add_php_document',
				'php_document'
			)
		),
		'custom_import' => array(
			'fullwidth' => array(
				'note_beginner_import',
				'note_advanced_import',
				'add_custom_import',
				'php_import_display',
				'html_import_view',
				'php_import',
				'php_import_headers',
				'php_import_setdata',
				'php_import_save',
				'php_import_ext'
			)
		),
		'mysql' => array(
			'left' => array(
				'mysql_table_engine',
				'mysql_table_charset',
				'mysql_table_collate',
				'mysql_table_row_format',
				'add_sql',
				'source',
				'addtables'
			),
			'fullwidth' => array(
				'sql'
			)
		),
		'settings' => array(
			'fullwidth' => array(
				'note_on_permissions',
				'addpermissions',
				'note_on_tabs',
				'addtabs',
				'note_custom_tabs_note',
				'note_on_linked_views',
				'addlinked_views'
			)
		),
		'fields' => array(
			'left' => array(
				'note_create_edit_notice',
				'alias_builder_type',
				'note_alias_builder_custom',
				'note_alias_builder_default',
				'alias_builder',
				'note_category_menu_switch',
				'add_category_submenu'
			),
			'right' => array(
				'note_create_edit_buttons'
			),
			'fullwidth' => array(
				'note_create_edit_display'
			)
		),
		'css' => array(
			'fullwidth' => array(
				'add_css_view',
				'css_view',
				'add_css_views',
				'css_views'
			)
		),
		'javascript' => array(
			'fullwidth' => array(
				'add_javascript_view_file',
				'javascript_view_file',
				'add_javascript_view_footer',
				'javascript_view_footer',
				'add_javascript_views_file',
				'javascript_views_file',
				'add_javascript_views_footer',
				'javascript_views_footer'
			)
		),
		'custom_buttons' => array(
			'left' => array(
				'add_custom_button',
				'custom_button'
			),
			'fullwidth' => array(
				'php_controller',
				'php_model',
				'php_controller_list',
				'php_model_list'
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
		'administrator/components/com_componentbuilder/assets/css/admin_view.css'
 	];

	/**
	 * The scripts array.
	 *
	 * @var    array
	 * @since  4.3
	 */
	protected array $scripts = [
		'administrator/components/com_componentbuilder/assets/js/admin.js',
		'media/com_componentbuilder/js/admin_view.js'
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
	public $typeAlias = 'com_componentbuilder.admin_view';

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
	public function getTable($type = 'admin_view', $prefix = 'Administrator', $config = [])
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
			if (($vdm = SessionHelper::get('admin_view__'.$id)) !== null)
			{
				$this->vastDevMod = $vdm;
			}
			else
			{
				// set the vast development method key
				$this->vastDevMod = UtilitiesStringHelper::random(50);
				SessionHelper::set($this->vastDevMod, 'admin_view__'.$id);
				SessionHelper::set('admin_view__'.$id, $this->vastDevMod);
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

			if (!empty($item->php_allowedit))
			{
				// base64 Decode php_allowedit.
				$item->php_allowedit = base64_decode($item->php_allowedit);
			}

			if (!empty($item->php_postsavehook))
			{
				// base64 Decode php_postsavehook.
				$item->php_postsavehook = base64_decode($item->php_postsavehook);
			}

			if (!empty($item->php_before_save))
			{
				// base64 Decode php_before_save.
				$item->php_before_save = base64_decode($item->php_before_save);
			}

			if (!empty($item->php_getlistquery))
			{
				// base64 Decode php_getlistquery.
				$item->php_getlistquery = base64_decode($item->php_getlistquery);
			}

			if (!empty($item->php_import_ext))
			{
				// base64 Decode php_import_ext.
				$item->php_import_ext = base64_decode($item->php_import_ext);
			}

			if (!empty($item->php_after_publish))
			{
				// base64 Decode php_after_publish.
				$item->php_after_publish = base64_decode($item->php_after_publish);
			}

			if (!empty($item->php_after_cancel))
			{
				// base64 Decode php_after_cancel.
				$item->php_after_cancel = base64_decode($item->php_after_cancel);
			}

			if (!empty($item->php_batchmove))
			{
				// base64 Decode php_batchmove.
				$item->php_batchmove = base64_decode($item->php_batchmove);
			}

			if (!empty($item->php_after_delete))
			{
				// base64 Decode php_after_delete.
				$item->php_after_delete = base64_decode($item->php_after_delete);
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

			if (!empty($item->php_getform))
			{
				// base64 Decode php_getform.
				$item->php_getform = base64_decode($item->php_getform);
			}

			if (!empty($item->php_save))
			{
				// base64 Decode php_save.
				$item->php_save = base64_decode($item->php_save);
			}

			if (!empty($item->php_allowadd))
			{
				// base64 Decode php_allowadd.
				$item->php_allowadd = base64_decode($item->php_allowadd);
			}

			if (!empty($item->php_before_cancel))
			{
				// base64 Decode php_before_cancel.
				$item->php_before_cancel = base64_decode($item->php_before_cancel);
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

			if (!empty($item->php_import_setdata))
			{
				// base64 Decode php_import_setdata.
				$item->php_import_setdata = base64_decode($item->php_import_setdata);
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

			if (!empty($item->php_getitem))
			{
				// base64 Decode php_getitem.
				$item->php_getitem = base64_decode($item->php_getitem);
			}

			if (!empty($item->php_import_headers))
			{
				// base64 Decode php_import_headers.
				$item->php_import_headers = base64_decode($item->php_import_headers);
			}

			if (!empty($item->php_import_save))
			{
				// base64 Decode php_import_save.
				$item->php_import_save = base64_decode($item->php_import_save);
			}

			if (!empty($item->php_getitems))
			{
				// base64 Decode php_getitems.
				$item->php_getitems = base64_decode($item->php_getitems);
			}

			if (!empty($item->addpermissions))
			{
				// Convert the addpermissions field to an array.
				$addpermissions = new Registry;
				$addpermissions->loadString($item->addpermissions);
				$item->addpermissions = $addpermissions->toArray();
			}

			if (!empty($item->addtabs))
			{
				// Convert the addtabs field to an array.
				$addtabs = new Registry;
				$addtabs->loadString($item->addtabs);
				$item->addtabs = $addtabs->toArray();
			}

			if (!empty($item->addlinked_views))
			{
				// Convert the addlinked_views field to an array.
				$addlinked_views = new Registry;
				$addlinked_views->loadString($item->addlinked_views);
				$item->addlinked_views = $addlinked_views->toArray();
			}

			if (!empty($item->alias_builder))
			{
				// Convert the alias_builder field to an array.
				$alias_builder = new Registry;
				$alias_builder->loadString($item->alias_builder);
				$item->alias_builder = $alias_builder->toArray();
			}

			if (!empty($item->custom_button))
			{
				// Convert the custom_button field to an array.
				$custom_button = new Registry;
				$custom_button->loadString($item->custom_button);
				$item->custom_button = $custom_button->toArray();
			}

			if (!empty($item->addtables))
			{
				// Convert the addtables field to an array.
				$addtables = new Registry;
				$addtables->loadString($item->addtables);
				$item->addtables = $addtables->toArray();
			}

			if (!empty($item->ajax_input))
			{
				// Convert the ajax_input field to an array.
				$ajax_input = new Registry;
				$ajax_input->loadString($item->ajax_input);
				$item->ajax_input = $ajax_input->toArray();
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
			if (($vdm = SessionHelper::get('admin_view__'.$id)) !== null)
			{
				$this->vastDevMod = $vdm;
			}
			else
			{
				// set the vast development method key
				$this->vastDevMod = UtilitiesStringHelper::random(50);
				SessionHelper::set($this->vastDevMod, 'admin_view__'.$id);
				SessionHelper::set('admin_view__'.$id, $this->vastDevMod);
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
				'addlinked_views' => 'adminview',
				'ajax_input' => 'value_name',
				'custom_button' => 'name',
				'addpermissions' => 'action',
				'addtables' => 'table',
				'addtabs' => 'name'
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
				$this->_db->updateObject('#__componentbuilder_admin_view', $objectUpdate, 'id');
			}

			// update the mysql_table_engine defaults
			if (isset($item->mysql_table_engine) && is_numeric($item->mysql_table_engine))
			{
				$item->mysql_table_engine = 'MyISAM';
			}
			// update the mysql_table_charset defaults
			if (isset($item->mysql_table_charset) && is_numeric($item->mysql_table_charset))
			{
				$item->mysql_table_charset = 'utf8';
			}
			// update the mysql_table_collate defaults
			if (isset($item->mysql_table_collate) && is_numeric($item->mysql_table_collate))
			{
				$item->mysql_table_collate = 'utf8_general_ci';
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
		$form = $this->loadForm('com_componentbuilder.admin_view', 'admin_view', $options, $clear, $xpath);

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
		if ($id != 0 && (!$user->authorise('admin_view.edit.state', 'com_componentbuilder.admin_view.' . (int) $id))
			|| ($id == 0 && !$user->authorise('admin_view.edit.state', 'com_componentbuilder')))
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
		if ($id != 0 && (!$user->authorise('admin_view.edit.created_by', 'com_componentbuilder.admin_view.' . (int) $id))
			|| ($id == 0 && !$user->authorise('admin_view.edit.created_by', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('created_by', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('created_by', 'readonly', 'true');
			// Disable fields while saving.
			$form->setFieldAttribute('created_by', 'filter', 'unset');
		}
		// Modify the form based on Edit Creaded Date access controls.
		if ($id != 0 && (!$user->authorise('admin_view.edit.created', 'com_componentbuilder.admin_view.' . (int) $id))
			|| ($id == 0 && !$user->authorise('admin_view.edit.created', 'com_componentbuilder')))
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

		// update the ajax_input (sub form) layout
		$form->setFieldAttribute('ajax_input', 'layout', ComponentbuilderHelper::getSubformLayout('admin_view', 'ajax_input'));

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
		return $this->getCurrentUser()->authorise('admin_view.delete', 'com_componentbuilder.admin_view.' . (int) $record->id);
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
			$permission = $user->authorise('admin_view.edit.state', 'com_componentbuilder.admin_view.' . (int) $recordId);
			if (!$permission && !is_null($permission))
			{
				return false;
			}
		}
		// In the absence of better information, revert to the component permissions.
		return $user->authorise('admin_view.edit.state', 'com_componentbuilder');
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

		return $user->authorise('admin_view.edit', 'com_componentbuilder.admin_view.'. ((int) isset($data[$key]) ? $data[$key] : 0)) or $user->authorise('admin_view.edit',  'com_componentbuilder');
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
	 * @since   1.6
	 */
	protected function loadFormData()
	{
		// Check the session for previously entered form data.
		$data = Factory::getApplication()->getUserState('com_componentbuilder.edit.admin_view.data', []);

		if (empty($data))
		{
			$data = $this->getItem();
		}

		// run the perprocess of the data
		$this->preprocessData('com_componentbuilder.admin_view', $data);

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

		// we must also delete the linked tables found
		if (UtilitiesArrayHelper::check($pks))
		{
			$_tablesArray = array(
				'admin_fields',
				'admin_fields_conditions',
				'admin_fields_relations',
				'admin_custom_tabs'
			);
			foreach($_tablesArray as $_updateTable)
			{
				// get the linked IDs
				if ($_pks = ComponentbuilderHelper::getVars($_updateTable, $pks, 'admin_view', 'id'))
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
	 * @since   12.2
	 */
	public function publish(&$pks, $value = 1)
	{
		if (!parent::publish($pks, $value))
		{
			return false;
		}

		// we must also update all linked tables
		if (UtilitiesArrayHelper::check($pks))
		{
			$_tablesArray = array(
				'admin_fields',
				'admin_fields_conditions',
				'admin_fields_relations',
				'admin_custom_tabs'
			);
			foreach($_tablesArray as $_updateTable)
			{
				// get the linked IDs
				if ($_pks = ComponentbuilderHelper::getVars($_updateTable, $pks, 'admin_view', 'id'))
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
		$this->canDo = ComponentbuilderHelper::getActions('admin_view');
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
			$this->canDo		= ComponentbuilderHelper::getActions('admin_view');
		}

		if (!$this->canDo->get('admin_view.create') && !$this->canDo->get('admin_view.batch'))
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
		elseif (isset($values['published']) && !$this->canDo->get('admin_view.edit.state'))
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
			if (!$this->user->authorise('admin_view.edit', $contexts[$pk]))
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
			$this->canDo		= ComponentbuilderHelper::getActions('admin_view');
		}

		if (!$this->canDo->get('admin_view.edit') && !$this->canDo->get('admin_view.batch'))
		{
			$this->setError(Text::_('JLIB_APPLICATION_ERROR_BATCH_CANNOT_EDIT'));
			return false;
		}

		// make sure published only updates if user has the permission.
		if (isset($values['published']) && !$this->canDo->get('admin_view.edit.state'))
		{
			unset($values['published']);
		}
		// remove move_copy from array
		unset($values['move_copy']);

		// Parent exists so we proceed
		foreach ($pks as $pk)
		{
			if (!$this->user->authorise('admin_view.edit', $contexts[$pk]))
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

		// if system name is empty create a system name from the name_single
		if (empty($data['system_name']) || !UtilitiesStringHelper::check($data['system_name']))
		{
			$data['system_name'] = $data['name_single'];
		}

		// validate that the list and single view name are not the same
		if ($data['name_single'] === $data['name_list'])
		{
			$data['name_list'] .= '_s';
		}

		// Set the GUID if empty or not valid
		if (empty($data['guid']) && $data['id'] > 0)
		{
			// get the existing one
			$data['guid'] = (string) GetHelper::var('admin_view', $data['id'], 'id', 'guid');
		}

		// Set the GUID if empty or not valid
		while (!GuidHelper::valid($data['guid'], "admin_view", $data['id']))
		{
			// must always be set
			$data['guid'] = (string) GuidHelper::get();
		}

		// Set the addpermissions items to data.
		if (isset($data['addpermissions']) && is_array($data['addpermissions']))
		{
			$addpermissions = new Registry;
			$addpermissions->loadArray($data['addpermissions']);
			$data['addpermissions'] = (string) $addpermissions;
		}
		elseif (!isset($data['addpermissions']))
		{
			// Set the empty addpermissions to data
			$data['addpermissions'] = '';
		}

		// Set the addtabs items to data.
		if (isset($data['addtabs']) && is_array($data['addtabs']))
		{
			$addtabs = new Registry;
			$addtabs->loadArray($data['addtabs']);
			$data['addtabs'] = (string) $addtabs;
		}
		elseif (!isset($data['addtabs']))
		{
			// Set the empty addtabs to data
			$data['addtabs'] = '';
		}

		// Set the addlinked_views items to data.
		if (isset($data['addlinked_views']) && is_array($data['addlinked_views']))
		{
			$addlinked_views = new Registry;
			$addlinked_views->loadArray($data['addlinked_views']);
			$data['addlinked_views'] = (string) $addlinked_views;
		}
		elseif (!isset($data['addlinked_views']))
		{
			// Set the empty addlinked_views to data
			$data['addlinked_views'] = '';
		}

		// Set the alias_builder items to data.
		if (isset($data['alias_builder']) && is_array($data['alias_builder']))
		{
			$alias_builder = new Registry;
			$alias_builder->loadArray($data['alias_builder']);
			$data['alias_builder'] = (string) $alias_builder;
		}
		elseif (!isset($data['alias_builder']))
		{
			// Set the empty alias_builder to data
			$data['alias_builder'] = '';
		}

		// Set the custom_button items to data.
		if (isset($data['custom_button']) && is_array($data['custom_button']))
		{
			$custom_button = new Registry;
			$custom_button->loadArray($data['custom_button']);
			$data['custom_button'] = (string) $custom_button;
		}
		elseif (!isset($data['custom_button']))
		{
			// Set the empty custom_button to data
			$data['custom_button'] = '';
		}

		// Set the addtables items to data.
		if (isset($data['addtables']) && is_array($data['addtables']))
		{
			$addtables = new Registry;
			$addtables->loadArray($data['addtables']);
			$data['addtables'] = (string) $addtables;
		}
		elseif (!isset($data['addtables']))
		{
			// Set the empty addtables to data
			$data['addtables'] = '';
		}

		// Set the ajax_input items to data.
		if (isset($data['ajax_input']) && is_array($data['ajax_input']))
		{
			$ajax_input = new Registry;
			$ajax_input->loadArray($data['ajax_input']);
			$data['ajax_input'] = (string) $ajax_input;
		}
		elseif (!isset($data['ajax_input']))
		{
			// Set the empty ajax_input to data
			$data['ajax_input'] = '';
		}

		// Set the php_allowedit string to base64 string.
		if (isset($data['php_allowedit']))
		{
			$data['php_allowedit'] = base64_encode($data['php_allowedit']);
		}

		// Set the php_postsavehook string to base64 string.
		if (isset($data['php_postsavehook']))
		{
			$data['php_postsavehook'] = base64_encode($data['php_postsavehook']);
		}

		// Set the php_before_save string to base64 string.
		if (isset($data['php_before_save']))
		{
			$data['php_before_save'] = base64_encode($data['php_before_save']);
		}

		// Set the php_getlistquery string to base64 string.
		if (isset($data['php_getlistquery']))
		{
			$data['php_getlistquery'] = base64_encode($data['php_getlistquery']);
		}

		// Set the php_import_ext string to base64 string.
		if (isset($data['php_import_ext']))
		{
			$data['php_import_ext'] = base64_encode($data['php_import_ext']);
		}

		// Set the php_after_publish string to base64 string.
		if (isset($data['php_after_publish']))
		{
			$data['php_after_publish'] = base64_encode($data['php_after_publish']);
		}

		// Set the php_after_cancel string to base64 string.
		if (isset($data['php_after_cancel']))
		{
			$data['php_after_cancel'] = base64_encode($data['php_after_cancel']);
		}

		// Set the php_batchmove string to base64 string.
		if (isset($data['php_batchmove']))
		{
			$data['php_batchmove'] = base64_encode($data['php_batchmove']);
		}

		// Set the php_after_delete string to base64 string.
		if (isset($data['php_after_delete']))
		{
			$data['php_after_delete'] = base64_encode($data['php_after_delete']);
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

		// Set the php_getform string to base64 string.
		if (isset($data['php_getform']))
		{
			$data['php_getform'] = base64_encode($data['php_getform']);
		}

		// Set the php_save string to base64 string.
		if (isset($data['php_save']))
		{
			$data['php_save'] = base64_encode($data['php_save']);
		}

		// Set the php_allowadd string to base64 string.
		if (isset($data['php_allowadd']))
		{
			$data['php_allowadd'] = base64_encode($data['php_allowadd']);
		}

		// Set the php_before_cancel string to base64 string.
		if (isset($data['php_before_cancel']))
		{
			$data['php_before_cancel'] = base64_encode($data['php_before_cancel']);
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

		// Set the php_import_setdata string to base64 string.
		if (isset($data['php_import_setdata']))
		{
			$data['php_import_setdata'] = base64_encode($data['php_import_setdata']);
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

		// Set the php_getitem string to base64 string.
		if (isset($data['php_getitem']))
		{
			$data['php_getitem'] = base64_encode($data['php_getitem']);
		}

		// Set the php_import_headers string to base64 string.
		if (isset($data['php_import_headers']))
		{
			$data['php_import_headers'] = base64_encode($data['php_import_headers']);
		}

		// Set the php_import_save string to base64 string.
		if (isset($data['php_import_save']))
		{
			$data['php_import_save'] = base64_encode($data['php_import_save']);
		}

		// Set the php_getitems string to base64 string.
		if (isset($data['php_getitems']))
		{
			$data['php_getitems'] = base64_encode($data['php_getitems']);
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
}
