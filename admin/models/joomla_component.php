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
use Joomla\CMS\Filter\InputFilter;
use Joomla\CMS\Filter\OutputFilter;
use Joomla\CMS\MVC\Model\AdminModel;
use Joomla\CMS\Table\Table;
use Joomla\CMS\UCM\UCMType;
use Joomla\Registry\Registry;
use Joomla\String\StringHelper;
use Joomla\Utilities\ArrayHelper;
use Joomla\CMS\Helper\TagsHelper;
use VDM\Joomla\Utilities\StringHelper as UtilitiesStringHelper;
use VDM\Joomla\Utilities\ObjectHelper;
use VDM\Joomla\Utilities\GuidHelper;
use VDM\Joomla\FOF\Encrypt\AES;
use VDM\Joomla\Utilities\ArrayHelper as UtilitiesArrayHelper;
use VDM\Joomla\Utilities\GetHelper;

/**
 * Componentbuilder Joomla_component Admin Model
 */
class ComponentbuilderModelJoomla_component extends AdminModel
{
	/**
	 * The tab layout fields array.
	 *
	 * @var      array
	 */
	protected $tabLayoutFields = array(
		'details' => array(
			'left' => array(
				'name',
				'name_code',
				'component_version',
				'debug_linenr',
				'add_placeholders',
				'remove_line_breaks',
				'mvc_versiondate',
				'note_version_options_1',
				'note_version_options_2',
				'note_version_options_3',
				'short_description',
				'description'
			),
			'right' => array(
				'companyname',
				'author',
				'email',
				'website',
				'add_license',
				'license_type',
				'note_whmcs_lisencing_note',
				'whmcs_key',
				'whmcs_url',
				'whmcs_buy_link',
				'license',
				'bom',
				'image',
				'copyright'
			),
			'above' => array(
				'system_name',
				'add_powers'
			),
			'under' => array(
				'not_required'
			)
		),
		'libs_helpers' => array(
			'fullwidth' => array(
				'creatuserhelper',
				'adduikit',
				'addfootable',
				'add_email_helper',
				'add_php_helper_both',
				'php_helper_both',
				'add_php_helper_admin',
				'php_helper_admin',
				'add_admin_event',
				'php_admin_event',
				'add_php_helper_site',
				'php_helper_site',
				'add_site_event',
				'php_site_event',
				'add_javascript',
				'javascript',
				'add_css_admin',
				'css_admin',
				'add_css_site',
				'css_site'
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
				'sales_server',
				'add_backup_folder_path',
				'note_backup_folder_path',
				'backup_folder_path',
				'add_git_folder_path',
				'note_git_folder_path',
				'git_folder_path'
			),
			'right' => array(
				'translation_tool',
				'note_crowdin',
				'crowdin_project_identifier',
				'crowdin_project_api_key',
				'crowdin_username',
				'crowdin_account_api_key'
			)
		),
		'dynamic_build_beta' => array(
			'fullwidth' => array(
				'note_buildcomp_dynamic_mysql',
				'buildcomp',
				'buildcompsql'
			)
		),
		'readme' => array(
			'left' => array(
				'addreadme',
				'readme'
			),
			'right' => array(
				'note_readme'
			)
		),
		'dash_install' => array(
			'left' => array(
				'dashboard_type'
			),
			'right' => array(
				'note_dynamic_dashboard',
				'dashboard',
				'note_botton_component_dashboard'
			),
			'fullwidth' => array(
				'add_php_preflight_install',
				'php_preflight_install',
				'add_php_preflight_update',
				'php_preflight_update',
				'add_php_postflight_install',
				'php_postflight_install',
				'add_php_postflight_update',
				'php_postflight_update',
				'add_php_method_uninstall',
				'php_method_uninstall'
			)
		),
		'mysql' => array(
			'fullwidth' => array(
				'add_sql',
				'sql',
				'add_sql_uninstall',
				'sql_uninstall',
				'assets_table_fix'
			)
		),
		'settings' => array(
			'left' => array(
				'note_moved_views',
				'spacer_hr_1',
				'note_mysql_tweak_options',
				'spacer_hr_2',
				'note_add_custom_menus',
				'spacer_hr_3',
				'note_add_config'
			),
			'right' => array(
				'note_component_files_folders',
				'spacer_hr_4',
				'add_namespace_prefix',
				'namespace_prefix',
				'spacer_hr_5',
				'add_menu_prefix',
				'menu_prefix',
				'spacer_hr_6',
				'to_ignore_note',
				'toignore',
				'spacer_hr_7',
				'jcb_export_package_note',
				'export_key',
				'joomla_source_link',
				'export_buy_link'
			),
			'fullwidth' => array(
				'spacer_hr_8',
				'note_on_contributors',
				'addcontributors',
				'emptycontributors',
				'number'
			)
		),
		'admin_views' => array(
			'fullwidth' => array(
				'note_on_admin_views',
				'note_display_component_admin_views'
			)
		),
		'site_views' => array(
			'fullwidth' => array(
				'note_on_site_views',
				'note_display_component_site_views'
			)
		),
		'custom_admin_views' => array(
			'fullwidth' => array(
				'note_on_custom_admin_views',
				'note_display_component_custom_admin_views'
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
	public $typeAlias = 'com_componentbuilder.joomla_component';

	/**
	 * Returns a Table object, always creating it
	 *
	 * @param   type    $type    The table type to instantiate
	 * @param   string  $prefix  A prefix for the table class name. Optional.
	 * @param   array   $config  Configuration array for model. Optional.
	 *
	 * @return  Table  A database object
	 *
	 * @since   1.6
	 */
	public function getTable($type = 'joomla_component', $prefix = 'ComponentbuilderTable', $config = [])
	{
		// add table path for when model gets used from other component
		$this->addTablePath(JPATH_ADMINISTRATOR . '/components/com_componentbuilder/tables');
		// get instance of the table
		return Table::getInstance($type, $prefix, $config);
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
			if ($vdm = ComponentbuilderHelper::get('joomla_component__'.$id))
			{
				$this->vastDevMod = $vdm;
			}
			else
			{
				// set the vast development method key
				$this->vastDevMod = UtilitiesStringHelper::random(50);
				ComponentbuilderHelper::set($this->vastDevMod, 'joomla_component__'.$id);
				ComponentbuilderHelper::set('joomla_component__'.$id, $this->vastDevMod);
				// set a return value if found
				$jinput = Factory::getApplication()->input;
				$return = $jinput->get('return', null, 'base64');
				ComponentbuilderHelper::set($this->vastDevMod . '__return', $return);
				// set a GUID value if found
				if (isset($item) && ObjectHelper::check($item) && isset($item->guid)
					&& GuidHelper::valid($item->guid))
				{
					ComponentbuilderHelper::set($this->vastDevMod . '__guid', $item->guid);
				}
			}
		}
		return $this->vastDevMod;
	}

	/**
	 * The assistant form fields
	 *
	 * @var      array
	 */
	public $assistantForm = array(
		'left' => array(
			'name',
			'short_description',
			'guid',
			'copyright'
		),
		'right' => array( 
			'name_code',
			'license',
			'bom',
			'image'
		)
	);


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

			if (!empty($item->php_site_event))
			{
				// base64 Decode php_site_event.
				$item->php_site_event = base64_decode($item->php_site_event);
			}

			if (!empty($item->buildcompsql))
			{
				// base64 Decode buildcompsql.
				$item->buildcompsql = base64_decode($item->buildcompsql);
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

			if (!empty($item->css_admin))
			{
				// base64 Decode css_admin.
				$item->css_admin = base64_decode($item->css_admin);
			}

			if (!empty($item->php_postflight_install))
			{
				// base64 Decode php_postflight_install.
				$item->php_postflight_install = base64_decode($item->php_postflight_install);
			}

			if (!empty($item->sql_uninstall))
			{
				// base64 Decode sql_uninstall.
				$item->sql_uninstall = base64_decode($item->sql_uninstall);
			}

			if (!empty($item->php_helper_both))
			{
				// base64 Decode php_helper_both.
				$item->php_helper_both = base64_decode($item->php_helper_both);
			}

			if (!empty($item->php_admin_event))
			{
				// base64 Decode php_admin_event.
				$item->php_admin_event = base64_decode($item->php_admin_event);
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

			if (!empty($item->javascript))
			{
				// base64 Decode javascript.
				$item->javascript = base64_decode($item->javascript);
			}

			if (!empty($item->css_site))
			{
				// base64 Decode css_site.
				$item->css_site = base64_decode($item->css_site);
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

			if (!empty($item->readme))
			{
				// base64 Decode readme.
				$item->readme = base64_decode($item->readme);
			}

			// Get the basic encryption.
			$basickey = ComponentbuilderHelper::getCryptKey('basic');
			// Get the encryption object.
			$basic = new AES($basickey);

			if (!empty($item->crowdin_username) && $basickey && !is_numeric($item->crowdin_username) && $item->crowdin_username === base64_encode(base64_decode($item->crowdin_username, true)))
			{
				// basic decrypt data crowdin_username.
				$item->crowdin_username = rtrim($basic->decryptString($item->crowdin_username), "\0");
			}

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

			if (!empty($item->crowdin_project_api_key) && $basickey && !is_numeric($item->crowdin_project_api_key) && $item->crowdin_project_api_key === base64_encode(base64_decode($item->crowdin_project_api_key, true)))
			{
				// basic decrypt data crowdin_project_api_key.
				$item->crowdin_project_api_key = rtrim($basic->decryptString($item->crowdin_project_api_key), "\0");
			}

			if (!empty($item->crowdin_account_api_key) && $basickey && !is_numeric($item->crowdin_account_api_key) && $item->crowdin_account_api_key === base64_encode(base64_decode($item->crowdin_account_api_key, true)))
			{
				// basic decrypt data crowdin_account_api_key.
				$item->crowdin_account_api_key = rtrim($basic->decryptString($item->crowdin_account_api_key), "\0");
			}

			if (!empty($item->addcontributors))
			{
				// Convert the addcontributors field to an array.
				$addcontributors = new Registry;
				$addcontributors->loadString($item->addcontributors);
				$item->addcontributors = $addcontributors->toArray();
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
			if ($vdm = ComponentbuilderHelper::get('joomla_component__'.$id))
			{
				$this->vastDevMod = $vdm;
			}
			else
			{
				// set the vast development method key
				$this->vastDevMod = UtilitiesStringHelper::random(50);
				ComponentbuilderHelper::set($this->vastDevMod, 'joomla_component__'.$id);
				ComponentbuilderHelper::set('joomla_component__'.$id, $this->vastDevMod);
				// set a return value if found
				$jinput = Factory::getApplication()->input;
				$return = $jinput->get('return', null, 'base64');
				ComponentbuilderHelper::set($this->vastDevMod . '__return', $return);
				// set a GUID value if found
				if (isset($item) && ObjectHelper::check($item) && isset($item->guid)
					&& GuidHelper::valid($item->guid))
				{
					ComponentbuilderHelper::set($this->vastDevMod . '__guid', $item->guid);
				}
			}

			// update the fields
			$objectUpdate = new \stdClass();
			$objectUpdate->id = (int) $item->id;
			// repeatable values to check
			$arrayChecker = array(
				'addcontributors' => 'name'
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
					$objectUpdate->{$_value} = json_encode($bucket, JSON_FORCE_OBJECT);
				}
			}
			// be sure to update the table if we found repeatable fields that are still not converted
			if (count((array) $objectUpdate) > 1)
			{
				$this->_db->updateObject('#__componentbuilder_joomla_component', $objectUpdate, 'id');
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
	public function getForm($data = [], $loadData = true, $options = array('control' => 'jform'))
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
		$form = $this->loadForm('com_componentbuilder.joomla_component', 'joomla_component', $options, $clear, $xpath);

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

		$user = Factory::getUser();

		// Check for existing item.
		// Modify the form based on Edit State access controls.
		if ($id != 0 && (!$user->authorise('joomla_component.edit.state', 'com_componentbuilder.joomla_component.' . (int) $id))
			|| ($id == 0 && !$user->authorise('joomla_component.edit.state', 'com_componentbuilder')))
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
		if ($id != 0 && (!$user->authorise('joomla_component.edit.created_by', 'com_componentbuilder.joomla_component.' . (int) $id))
			|| ($id == 0 && !$user->authorise('joomla_component.edit.created_by', 'com_componentbuilder')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('created_by', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('created_by', 'readonly', 'true');
			// Disable fields while saving.
			$form->setFieldAttribute('created_by', 'filter', 'unset');
		}
		// Modify the form based on Edit Creaded Date access controls.
		if ($id != 0 && (!$user->authorise('joomla_component.edit.created', 'com_componentbuilder.joomla_component.' . (int) $id))
			|| ($id == 0 && !$user->authorise('joomla_component.edit.created', 'com_componentbuilder')))
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
		// Only load these values if no id is found
		if (0 == $id)
		{
			// set company defaults
			$form->setValue('companyname', null, ComponentHelper::getParams('com_componentbuilder')->get('export_company', ''));
			$form->setValue('author', null, ComponentHelper::getParams('com_componentbuilder')->get('export_owner', ''));
			$form->setValue('email', null, ComponentHelper::getParams('com_componentbuilder')->get('export_email', ''));
			$form->setValue('website', null, ComponentHelper::getParams('com_componentbuilder')->get('export_website', ''));
			$form->setValue('copyright', null, ComponentHelper::getParams('com_componentbuilder')->get('export_copyright', 'Copyright (C) 2015. All Rights Reserved'));
			$form->setValue('license', null, ComponentHelper::getParams('com_componentbuilder')->get('export_license', 'GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html'));
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

		return $form;
	}

	/**
	 * Method to get the script that have to be included on the form
	 *
	 * @return string    script files
	 */
	public function getScript()
	{
		return 'media/com_componentbuilder/js/joomla_component.js';
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

			$user = Factory::getUser();
			// The record has been set. Check the record permissions.
			return $user->authorise('joomla_component.delete', 'com_componentbuilder.joomla_component.' . (int) $record->id);
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
		$user = Factory::getUser();
		$recordId = $record->id ??  0;

		if ($recordId)
		{
			// The record has been set. Check the record permissions.
			$permission = $user->authorise('joomla_component.edit.state', 'com_componentbuilder.joomla_component.' . (int) $recordId);
			if (!$permission && !is_null($permission))
			{
				return false;
			}
		}
		// In the absence of better information, revert to the component permissions.
		return $user->authorise('joomla_component.edit.state', 'com_componentbuilder');
	}

	/**
	 * Method override to check if you can edit an existing record.
	 *
	 * @param    array    $data   An array of input data.
	 * @param    string   $key    The name of the key for the primary key.
	 *
	 * @return    boolean
	 * @since    2.5
	 */
	protected function allowEdit($data = [], $key = 'id')
	{
		// Check specific edit permission then general edit permission.
		$user = Factory::getUser();

		return $user->authorise('joomla_component.edit', 'com_componentbuilder.joomla_component.'. ((int) isset($data[$key]) ? $data[$key] : 0)) or $user->authorise('joomla_component.edit',  'com_componentbuilder');
	}

	/**
	 * Prepare and sanitise the table data prior to saving.
	 *
	 * @param   Table  $table  A Table object.
	 *
	 * @return  void
	 *
	 * @since   1.6
	 */
	protected function prepareTable($table)
	{
		$date = Factory::getDate();
		$user = Factory::getUser();

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
				$db = Factory::getDbo();
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
		$data = Factory::getApplication()->getUserState('com_componentbuilder.edit.joomla_component.data', []);

		if (empty($data))
		{
			$data = $this->getItem();
			// run the perprocess of the data
			$this->preprocessData('com_componentbuilder.joomla_component', $data);
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

		// we must also delete the linked tables found
		if (UtilitiesArrayHelper::check($pks))
		{
			$_tablesArray = array(
				'component_admin_views' => 'joomla_component',
				'component_site_views' => 'joomla_component',
				'component_custom_admin_views' => 'joomla_component',
				'component_updates' => 'joomla_component',
				'component_mysql_tweaks' => 'joomla_component',
				'component_custom_admin_menus' => 'joomla_component',
				'component_config' => 'joomla_component',
				'component_dashboard' => 'joomla_component',
				'component_files_folders' => 'joomla_component',
				'component_placeholders' => 'joomla_component',
				'custom_code' => 'component'
			);
			foreach($_tablesArray as $_updateTable => $_key)
			{
				// get the linked IDs
				if ($_pks = ComponentbuilderHelper::getVars($_updateTable, $pks, $_key, 'id'))
				{
					// load the model
					$_Model = ComponentbuilderHelper::getModel($_updateTable);
					// delete items
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
		if (UtilitiesArrayHelper::check($pks))
		{
			$_tablesArray = array(
				'component_admin_views' => 'joomla_component',
				'component_site_views' => 'joomla_component',
				'component_custom_admin_views' => 'joomla_component',
				'component_updates' => 'joomla_component',
				'component_mysql_tweaks' => 'joomla_component',
				'component_custom_admin_menus' => 'joomla_component',
				'component_config' => 'joomla_component',
				'component_dashboard' => 'joomla_component',
				'component_files_folders' => 'joomla_component',
				'component_placeholders' => 'joomla_component',
				'custom_code' => 'component'
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
		$this->user = Factory::getUser();
		$this->table = $this->getTable();
		$this->tableClassName = get_class($this->table);
		$this->contentType = new UCMType;
		$this->type = $this->contentType->getTypeByTable($this->tableClassName);
		$this->canDo = ComponentbuilderHelper::getActions('joomla_component');
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
			$this->user 		= Factory::getUser();
			$this->table 		= $this->getTable();
			$this->tableClassName	= get_class($this->table);
			$this->canDo		= ComponentbuilderHelper::getActions('joomla_component');
		}

		if (!$this->canDo->get('joomla_component.create') && !$this->canDo->get('joomla_component.batch'))
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
		elseif (isset($values['published']) && !$this->canDo->get('joomla_component.edit.state'))
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
			if (!$this->user->authorise('joomla_component.edit', $contexts[$pk]))
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
			if (UtilitiesStringHelper::check($this->table->system_name) && !is_numeric($this->table->system_name))
			{
				$this->table->system_name = $this->generateUnique('system_name',$this->table->system_name);
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
			$this->user		= Factory::getUser();
			$this->table		= $this->getTable();
			$this->tableClassName	= get_class($this->table);
			$this->canDo		= ComponentbuilderHelper::getActions('joomla_component');
		}

		if (!$this->canDo->get('joomla_component.edit') && !$this->canDo->get('joomla_component.batch'))
		{
			$this->setError(Text::_('JLIB_APPLICATION_ERROR_BATCH_CANNOT_EDIT'));
			return false;
		}

		// make sure published only updates if user has the permission.
		if (isset($values['published']) && !$this->canDo->get('joomla_component.edit.state'))
		{
			unset($values['published']);
		}
		// remove move_copy from array
		unset($values['move_copy']);

		// Parent exists so we proceed
		foreach ($pks as $pk)
		{
			if (!$this->user->authorise('joomla_component.edit', $contexts[$pk]))
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
	 *
	 * @since   1.6
	 */
	public function save($data)
	{
		$input    = Factory::getApplication()->input;
		$filter   = InputFilter::getInstance();

		// set the metadata to the Item Data
		if (isset($data['metadata']) && isset($data['metadata']['author']))
		{
			$data['metadata']['author'] = $filter->clean($data['metadata']['author'], 'TRIM');

			$metadata = new Registry;
			$metadata->loadArray($data['metadata']);
			$data['metadata'] = (string) $metadata;
		}

		// if system name is empty create from name
		if (empty($data['system_name']) || !UtilitiesStringHelper::check($data['system_name']))
		{
			$data['system_name'] = $data['name'];
		}

		// Set the GUID if empty or not valid
		if (empty($data['guid']) && $data['id'] > 0)
		{
			// get the existing one
			$data['guid'] = (string) GetHelper::var('joomla_component', $data['id'], 'id', 'guid');
		}

		// Set the GUID if empty or not valid
		while (!GuidHelper::valid($data['guid'], "joomla_component", $data['id']))
		{
			// must always be set
			$data['guid'] = (string) GuidHelper::get();
		}

		// Set the addcontributors items to data.
		if (isset($data['addcontributors']) && is_array($data['addcontributors']))
		{
			$addcontributors = new Registry;
			$addcontributors->loadArray($data['addcontributors']);
			$data['addcontributors'] = (string) $addcontributors;
		}
		elseif (!isset($data['addcontributors']))
		{
			// Set the empty addcontributors to data
			$data['addcontributors'] = '';
		}

		// Set the php_site_event string to base64 string.
		if (isset($data['php_site_event']))
		{
			$data['php_site_event'] = base64_encode($data['php_site_event']);
		}

		// Set the buildcompsql string to base64 string.
		if (isset($data['buildcompsql']))
		{
			$data['buildcompsql'] = base64_encode($data['buildcompsql']);
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

		// Set the css_admin string to base64 string.
		if (isset($data['css_admin']))
		{
			$data['css_admin'] = base64_encode($data['css_admin']);
		}

		// Set the php_postflight_install string to base64 string.
		if (isset($data['php_postflight_install']))
		{
			$data['php_postflight_install'] = base64_encode($data['php_postflight_install']);
		}

		// Set the sql_uninstall string to base64 string.
		if (isset($data['sql_uninstall']))
		{
			$data['sql_uninstall'] = base64_encode($data['sql_uninstall']);
		}

		// Set the php_helper_both string to base64 string.
		if (isset($data['php_helper_both']))
		{
			$data['php_helper_both'] = base64_encode($data['php_helper_both']);
		}

		// Set the php_admin_event string to base64 string.
		if (isset($data['php_admin_event']))
		{
			$data['php_admin_event'] = base64_encode($data['php_admin_event']);
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

		// Set the javascript string to base64 string.
		if (isset($data['javascript']))
		{
			$data['javascript'] = base64_encode($data['javascript']);
		}

		// Set the css_site string to base64 string.
		if (isset($data['css_site']))
		{
			$data['css_site'] = base64_encode($data['css_site']);
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

		// Set the readme string to base64 string.
		if (isset($data['readme']))
		{
			$data['readme'] = base64_encode($data['readme']);
		}

		// Get the basic encryption key.
		$basickey = ComponentbuilderHelper::getCryptKey('basic');
		// Get the encryption object
		$basic = new AES($basickey);

		// Encrypt data crowdin_username.
		if (isset($data['crowdin_username']) && $basickey)
		{
			$data['crowdin_username'] = $basic->encryptString($data['crowdin_username']);
		}

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

		// Encrypt data crowdin_project_api_key.
		if (isset($data['crowdin_project_api_key']) && $basickey)
		{
			$data['crowdin_project_api_key'] = $basic->encryptString($data['crowdin_project_api_key']);
		}

		// Encrypt data crowdin_account_api_key.
		if (isset($data['crowdin_account_api_key']) && $basickey)
		{
			$data['crowdin_account_api_key'] = $basic->encryptString($data['crowdin_account_api_key']);
		}

		// we check if component should be build from sql file
		if (isset($data['buildcomp']) && 1 == $data['buildcomp'])
		{
			ComponentbuilderHelper::dynamicBuilder($data, 1);
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

		while ($table->load(['title' => $title]))
		{
			$title = StringHelper::increment($title);
		}

		return $title;
	}
}
