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
namespace VDM\Component\Componentbuilder\Api\View\Joomla_module;

use Joomla\CMS\Factory;
use Joomla\CMS\Helper\TagsHelper;
use Joomla\CMS\MVC\View\JsonApiView as BaseApiView;
use VDM\Component\Componentbuilder\Administrator\Helper\ComponentbuilderHelper;
use VDM\Component\Componentbuilder\Api\Serializer\Joomla_moduleSerializer;

// No direct access to this file
\defined('_JEXEC') or die;

/**
 * Joomla_module Json View class
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
	 * The relationships the item has
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
