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
namespace VDM\Component\Componentbuilder\Api\View\Joomla_plugin;

use Joomla\CMS\Factory;
use Joomla\CMS\Helper\TagsHelper;
use Joomla\CMS\MVC\View\JsonApiView as BaseApiView;
use VDM\Component\Componentbuilder\Administrator\Helper\ComponentbuilderHelper;
use VDM\Component\Componentbuilder\Api\Serializer\Joomla_pluginSerializer;

// No direct access to this file
\defined('_JEXEC') or die;

/**
 * Joomla_plugin Json View class
 *
 * @since  4.0.0
 */
class JsonapiView extends BaseApiView
{
	/**
	 * The fields to render item in the documents
	 *
	 * @var    array
	 * @since  4.0.0
	 */
	protected $fieldsToRenderItem = [
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
	 * The relationships the item has
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
	 * @param   object  $item  Item
	 *
	 * @return  string
	 *
	 * @since   4.0.0
	 */
	public function displayItem($item = null)
	{
		if ($item === null)
		{
			$item = $this->prepareItem($this->getModel()->getItem());
		}

		return parent::displayItem($item);
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
		return parent::prepareItem($item);
	}
}
