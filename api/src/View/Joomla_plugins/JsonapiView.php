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
namespace VDM\Component\Componentbuilder\Api\View\Joomla_plugins;

use Joomla\CMS\Factory;
use Joomla\CMS\MVC\View\JsonApiView as BaseApiView;
use Joomla\Registry\Registry;
use VDM\Component\Componentbuilder\Administrator\Helper\ComponentbuilderHelper;
use VDM\Component\Componentbuilder\Api\Serializer\Joomla_pluginSerializer;

// No direct access to this file
\defined('_JEXEC') or die;

/**
 * Componentbuilder Json View class for the Joomla_plugins
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
		'class_extends',
		'joomla_plugin_group',
		'add_sql',
		'add_php_method_uninstall',
		'add_php_postflight_update',
		'add_php_postflight_install',
		'sales_server',
		'add_update_server',
		'method_selection',
		'property_selection',
		'add_head',
		'add_sql_uninstall',
		'addreadme',
		'head',
		'update_server_target',
		'main_class_code',
		'update_server',
		'description',
		'php_postflight_install',
		'plugin_version',
		'php_postflight_update',
		'fields',
		'php_method_uninstall',
		'add_php_script_construct',
		'sql',
		'php_script_construct',
		'sql_uninstall',
		'add_php_preflight_install',
		'readme',
		'php_preflight_install',
		'update_server_url',
		'add_php_preflight_update',
		'php_preflight_update',
		'add_php_preflight_uninstall',
		'add_sales_server',
		'php_preflight_uninstall',
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
		'class_extends',
		'joomla_plugin_group',
		'sales_server',
		'update_server',
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
			$this->serializer = new Joomla_pluginSerializer($config['contentType']);
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
		if (isset($item->head) && is_string($item->head) && $item->head !== '')
		{
			// base64 Decode head.
			$item->head = base64_decode($item->head);
		}

		if (isset($item->main_class_code) && is_string($item->main_class_code) && $item->main_class_code !== '')
		{
			// base64 Decode main_class_code.
			$item->main_class_code = base64_decode($item->main_class_code);
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

		if (isset($item->php_script_construct) && is_string($item->php_script_construct) && $item->php_script_construct !== '')
		{
			// base64 Decode php_script_construct.
			$item->php_script_construct = base64_decode($item->php_script_construct);
		}

		if (isset($item->sql_uninstall) && is_string($item->sql_uninstall) && $item->sql_uninstall !== '')
		{
			// base64 Decode sql_uninstall.
			$item->sql_uninstall = base64_decode($item->sql_uninstall);
		}

		if (isset($item->readme) && is_string($item->readme) && $item->readme !== '')
		{
			// base64 Decode readme.
			$item->readme = base64_decode($item->readme);
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

		if (isset($item->php_preflight_uninstall) && is_string($item->php_preflight_uninstall) && $item->php_preflight_uninstall !== '')
		{
			// base64 Decode php_preflight_uninstall.
			$item->php_preflight_uninstall = base64_decode($item->php_preflight_uninstall);
		}

		if (isset($item->method_selection) && is_string($item->method_selection) && $item->method_selection !== '')
		{
			// Convert the method_selection field to an array.
			$registry = new Registry;
			$registry->loadString($item->method_selection);
			$item->method_selection = $registry->toArray();
		}

		if (isset($item->property_selection) && is_string($item->property_selection) && $item->property_selection !== '')
		{
			// Convert the property_selection field to an array.
			$registry = new Registry;
			$registry->loadString($item->property_selection);
			$item->property_selection = $registry->toArray();
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
