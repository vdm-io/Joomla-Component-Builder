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
namespace VDM\Component\Componentbuilder\Api\View\Dynamic_gets;

use Joomla\CMS\Factory;
use Joomla\CMS\MVC\View\JsonApiView as BaseApiView;
use Joomla\Registry\Registry;
use VDM\Component\Componentbuilder\Administrator\Helper\ComponentbuilderHelper;
use VDM\Component\Componentbuilder\Api\Serializer\Dynamic_getSerializer;

// No direct access to this file
\defined('_JEXEC') or die;

/**
 * Componentbuilder Json View class for the Dynamic_gets
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
		'name',
		'main_source',
		'gettype',
		'php_calculation',
		'php_router_parse',
		'add_php_after_getitems',
		'add_php_router_parse',
		'view_selection',
		'add_php_before_getitems',
		'add_php_before_getitem',
		'add_php_after_getitem',
		'db_table_main',
		'php_custom_get',
		'plugin_events',
		'db_selection',
		'view_table_main',
		'add_php_getlistquery',
		'join_db_table',
		'select_all',
		'php_before_getitem',
		'getcustom',
		'php_after_getitem',
		'pagination',
		'php_getlistquery',
		'php_before_getitems',
		'filter',
		'php_after_getitems',
		'where',
		'order',
		'addcalculation',
		'group',
		'global',
		'guid',
		'join_view_table',
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
		'view_table_main',
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
			$this->serializer = new Dynamic_getSerializer($config['contentType']);
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
		if (isset($item->php_calculation) && is_string($item->php_calculation) && $item->php_calculation !== '')
		{
			// base64 Decode php_calculation.
			$item->php_calculation = base64_decode($item->php_calculation);
		}

		if (isset($item->php_router_parse) && is_string($item->php_router_parse) && $item->php_router_parse !== '')
		{
			// base64 Decode php_router_parse.
			$item->php_router_parse = base64_decode($item->php_router_parse);
		}

		if (isset($item->php_custom_get) && is_string($item->php_custom_get) && $item->php_custom_get !== '')
		{
			// base64 Decode php_custom_get.
			$item->php_custom_get = base64_decode($item->php_custom_get);
		}

		if (isset($item->php_before_getitem) && is_string($item->php_before_getitem) && $item->php_before_getitem !== '')
		{
			// base64 Decode php_before_getitem.
			$item->php_before_getitem = base64_decode($item->php_before_getitem);
		}

		if (isset($item->php_after_getitem) && is_string($item->php_after_getitem) && $item->php_after_getitem !== '')
		{
			// base64 Decode php_after_getitem.
			$item->php_after_getitem = base64_decode($item->php_after_getitem);
		}

		if (isset($item->php_getlistquery) && is_string($item->php_getlistquery) && $item->php_getlistquery !== '')
		{
			// base64 Decode php_getlistquery.
			$item->php_getlistquery = base64_decode($item->php_getlistquery);
		}

		if (isset($item->php_before_getitems) && is_string($item->php_before_getitems) && $item->php_before_getitems !== '')
		{
			// base64 Decode php_before_getitems.
			$item->php_before_getitems = base64_decode($item->php_before_getitems);
		}

		if (isset($item->php_after_getitems) && is_string($item->php_after_getitems) && $item->php_after_getitems !== '')
		{
			// base64 Decode php_after_getitems.
			$item->php_after_getitems = base64_decode($item->php_after_getitems);
		}

		if (isset($item->join_db_table) && is_string($item->join_db_table) && $item->join_db_table !== '')
		{
			// Convert the join_db_table field to an array.
			$registry = new Registry;
			$registry->loadString($item->join_db_table);
			$item->join_db_table = $registry->toArray();
		}

		if (isset($item->filter) && is_string($item->filter) && $item->filter !== '')
		{
			// Convert the filter field to an array.
			$registry = new Registry;
			$registry->loadString($item->filter);
			$item->filter = $registry->toArray();
		}

		if (isset($item->where) && is_string($item->where) && $item->where !== '')
		{
			// Convert the where field to an array.
			$registry = new Registry;
			$registry->loadString($item->where);
			$item->where = $registry->toArray();
		}

		if (isset($item->order) && is_string($item->order) && $item->order !== '')
		{
			// Convert the order field to an array.
			$registry = new Registry;
			$registry->loadString($item->order);
			$item->order = $registry->toArray();
		}

		if (isset($item->group) && is_string($item->group) && $item->group !== '')
		{
			// Convert the group field to an array.
			$registry = new Registry;
			$registry->loadString($item->group);
			$item->group = $registry->toArray();
		}

		if (isset($item->global) && is_string($item->global) && $item->global !== '')
		{
			// Convert the global field to an array.
			$registry = new Registry;
			$registry->loadString($item->global);
			$item->global = $registry->toArray();
		}

		if (isset($item->join_view_table) && is_string($item->join_view_table) && $item->join_view_table !== '')
		{
			// Convert the join_view_table field to an array.
			$registry = new Registry;
			$registry->loadString($item->join_view_table);
			$item->join_view_table = $registry->toArray();
		}

		if (isset($item->plugin_events) && is_string($item->plugin_events) && $item->plugin_events !== '')
		{
			// JSON Decode plugin_events.
			$item->plugin_events = json_decode($item->plugin_events);
		}

		return parent::prepareItem($item);
	}
}
