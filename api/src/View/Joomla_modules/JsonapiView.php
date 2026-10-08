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
namespace VDM\Component\Componentbuilder\Api\View\Joomla_modules;

use Joomla\CMS\Factory;
use Joomla\CMS\MVC\View\JsonApiView as BaseApiView;
use Joomla\Registry\Registry;
use VDM\Component\Componentbuilder\Administrator\Helper\ComponentbuilderHelper;
use VDM\Component\Componentbuilder\Api\Serializer\Joomla_moduleSerializer;

// No direct access to this file
\defined('_JEXEC') or die;

/**
 * Componentbuilder Json View class for the Joomla_modules
 *
 * @since  4.0.0
 */
class JsonapiView extends BaseApiView
{
	/**
	 * The fields to render items in the documents
	 *
	 * @var    array
	 * @since  4.0.0
	 */
	protected $fieldsToRenderList = [
		'id',
		'system_name',
		'target',
		'description',
		'add_php_postflight_install',
		'add_php_preflight_uninstall',
		'add_php_preflight_update',
		'update_server_target',
		'addreadme',
		'add_sql',
		'default',
		'default_header',
		'snippet',
		'add_default_header',
		'add_php_postflight_update',
		'add_php_method_uninstall',
		'add_sql_uninstall',
		'add_update_server',
		'update_server',
		'libraries',
		'sales_server',
		'module_version',
		'php_preflight_install',
		'php_preflight_update',
		'layout_data',
		'php_preflight_uninstall',
		'custom_get',
		'php_postflight_install',
		'php_postflight_update',
		'mod_code',
		'php_method_uninstall',
		'add_class_helper',
		'sql',
		'add_class_helper_header',
		'sql_uninstall',
		'class_helper_header',
		'readme',
		'class_helper_code',
		'update_server_url',
		'fields',
		'add_php_script_construct',
		'php_script_construct',
		'add_sales_server',
		'add_php_preflight_install',
		'guid',
		'name',
		'created',
		'created_by',
		'modified',
		'modified_by',
		'published',
		'ordering',
		'access',
		'version',
		'hits',
	];

	/**
	 * The relationships the items have
	 *
	 * @var    array
	 * @since  4.0.0
	 */
	protected $relationship = [
		'snippet',
		'update_server',
		'libraries',
		'sales_server',
		'custom_get',
		'created_by',
		'modified_by',
	];

	/**
	 * Constructor.
	 *
	 * @param   array  $config  A named configuration array for object construction.
	 *                          contentType: the name (optional) of the content type to use for the serialization
	 *
	 * @since   4.0.0
	 */
	public function __construct($config = [])
	{
		if (\array_key_exists('contentType', $config))
		{
			$this->serializer = new Joomla_moduleSerializer($config['contentType']);
		}

		parent::__construct($config);
	}

	/**
	 * Execute and display a template script.
	 *
	 * @param   ?array  $items  Array of items
	 *
	 * @return  string
	 *
	 * @since   4.0.0
	 */
	public function displayList(?array $items = null)
	{

		return parent::displayList($items);
	}

	/**
	 * Prepare item before render.
	 *
	 * @param   object  $item  The model item
	 *
	 * @return  object
	 *
	 * @since   4.0.0
	 */
	protected function prepareItem($item)
	{
		if (isset($item->default) && is_string($item->default) && $item->default !== '')
		{
			// base64 Decode default.
			$item->default = base64_decode($item->default);
		}

		if (isset($item->default_header) && is_string($item->default_header) && $item->default_header !== '')
		{
			// base64 Decode default_header.
			$item->default_header = base64_decode($item->default_header);
		}

		if (isset($item->php_preflight_install) && is_string($item->php_preflight_install) && $item->php_preflight_install !== '')
		{
			// base64 Decode php_preflight_install.
			$item->php_preflight_install = base64_decode($item->php_preflight_install);
		}

		if (isset($item->php_preflight_update) && is_string($item->php_preflight_update) && $item->php_preflight_update !== '')
		{
			// base64 Decode php_preflight_update.
			$item->php_preflight_update = base64_decode($item->php_preflight_update);
		}

		if (isset($item->layout_data) && is_string($item->layout_data) && $item->layout_data !== '')
		{
			// base64 Decode layout_data.
			$item->layout_data = base64_decode($item->layout_data);
		}

		if (isset($item->php_preflight_uninstall) && is_string($item->php_preflight_uninstall) && $item->php_preflight_uninstall !== '')
		{
			// base64 Decode php_preflight_uninstall.
			$item->php_preflight_uninstall = base64_decode($item->php_preflight_uninstall);
		}

		if (isset($item->php_postflight_install) && is_string($item->php_postflight_install) && $item->php_postflight_install !== '')
		{
			// base64 Decode php_postflight_install.
			$item->php_postflight_install = base64_decode($item->php_postflight_install);
		}

		if (isset($item->php_postflight_update) && is_string($item->php_postflight_update) && $item->php_postflight_update !== '')
		{
			// base64 Decode php_postflight_update.
			$item->php_postflight_update = base64_decode($item->php_postflight_update);
		}

		if (isset($item->mod_code) && is_string($item->mod_code) && $item->mod_code !== '')
		{
			// base64 Decode mod_code.
			$item->mod_code = base64_decode($item->mod_code);
		}

		if (isset($item->php_method_uninstall) && is_string($item->php_method_uninstall) && $item->php_method_uninstall !== '')
		{
			// base64 Decode php_method_uninstall.
			$item->php_method_uninstall = base64_decode($item->php_method_uninstall);
		}

		if (isset($item->sql) && is_string($item->sql) && $item->sql !== '')
		{
			// base64 Decode sql.
			$item->sql = base64_decode($item->sql);
		}

		if (isset($item->sql_uninstall) && is_string($item->sql_uninstall) && $item->sql_uninstall !== '')
		{
			// base64 Decode sql_uninstall.
			$item->sql_uninstall = base64_decode($item->sql_uninstall);
		}

		if (isset($item->class_helper_header) && is_string($item->class_helper_header) && $item->class_helper_header !== '')
		{
			// base64 Decode class_helper_header.
			$item->class_helper_header = base64_decode($item->class_helper_header);
		}

		if (isset($item->readme) && is_string($item->readme) && $item->readme !== '')
		{
			// base64 Decode readme.
			$item->readme = base64_decode($item->readme);
		}

		if (isset($item->class_helper_code) && is_string($item->class_helper_code) && $item->class_helper_code !== '')
		{
			// base64 Decode class_helper_code.
			$item->class_helper_code = base64_decode($item->class_helper_code);
		}

		if (isset($item->php_script_construct) && is_string($item->php_script_construct) && $item->php_script_construct !== '')
		{
			// base64 Decode php_script_construct.
			$item->php_script_construct = base64_decode($item->php_script_construct);
		}

		if (isset($item->libraries) && is_string($item->libraries) && $item->libraries !== '')
		{
			// Convert the libraries field to an array.
			$registry = new Registry;
			$registry->loadString($item->libraries);
			$item->libraries = $registry->toArray();
		}

		if (isset($item->custom_get) && is_string($item->custom_get) && $item->custom_get !== '')
		{
			// Convert the custom_get field to an array.
			$registry = new Registry;
			$registry->loadString($item->custom_get);
			$item->custom_get = $registry->toArray();
		}

		if (isset($item->fields) && is_string($item->fields) && $item->fields !== '')
		{
			// Convert the fields field to an array.
			$registry = new Registry;
			$registry->loadString($item->fields);
			$item->fields = $registry->toArray();
		}

		return parent::prepareItem($item);
	}
}
