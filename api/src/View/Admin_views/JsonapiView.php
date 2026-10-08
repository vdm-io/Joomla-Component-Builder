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
namespace VDM\Component\Componentbuilder\Api\View\Admin_views;

use Joomla\CMS\Factory;
use Joomla\CMS\MVC\View\JsonApiView as BaseApiView;
use Joomla\Registry\Registry;
use VDM\Component\Componentbuilder\Administrator\Helper\ComponentbuilderHelper;
use VDM\Component\Componentbuilder\Api\Serializer\Admin_viewSerializer;

// No direct access to this file
\defined('_JEXEC') or die;

/**
 * Componentbuilder Json View class for the Admin_views
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
		'name_single',
		'short_description',
		'php_postsavehook',
		'php_before_save',
		'php_getlistquery',
		'php_getitems',
		'ajax_input',
		'source',
		'icon',
		'php_batchmove',
		'add_fadein',
		'description',
		'icon_category',
		'icon_add',
		'php_allowedit',
		'php_after_delete',
		'php_after_cancel',
		'type',
		'php_after_publish',
		'mysql_table_charset',
		'name_list',
		'addpermissions',
		'php_getitem',
		'php_getitems_after_all',
		'addtabs',
		'php_getform',
		'php_save',
		'php_allowadd',
		'addlinked_views',
		'php_before_cancel',
		'php_batchcopy',
		'alias_builder_type',
		'php_before_publish',
		'php_before_delete',
		'php_document',
		'alias_builder',
		'mysql_table_row_format',
		'sql',
		'add_category_submenu',
		'php_ajaxmethod',
		'add_php_getitem',
		'add_php_getitems',
		'add_css_view',
		'add_php_getitems_after_all',
		'css_view',
		'add_php_getlistquery',
		'add_css_views',
		'add_php_getform',
		'css_views',
		'add_php_before_save',
		'add_javascript_view_file',
		'add_php_save',
		'javascript_view_file',
		'add_php_postsavehook',
		'add_javascript_view_footer',
		'add_php_allowadd',
		'javascript_view_footer',
		'add_php_allowedit',
		'add_javascript_views_file',
		'add_php_before_cancel',
		'javascript_views_file',
		'add_php_after_cancel',
		'add_javascript_views_footer',
		'add_php_batchcopy',
		'javascript_views_footer',
		'add_php_batchmove',
		'add_custom_button',
		'add_php_before_publish',
		'custom_button',
		'add_php_after_publish',
		'php_controller',
		'add_php_before_delete',
		'php_model',
		'add_php_after_delete',
		'php_controller_list',
		'add_php_document',
		'php_model_list',
		'mysql_table_engine',
		'add_view_toolbar',
		'mysql_table_collate',
		'view_toolbar',
		'add_sql',
		'add_views_toolbar',
		'addtables',
		'views_toolbar',
		'guid',
		'add_php_ajax',
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
		'alias_builder',
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
			$this->serializer = new Admin_viewSerializer($config['contentType']);
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
		if (isset($item->php_postsavehook) && is_string($item->php_postsavehook) && $item->php_postsavehook !== '')
		{
			// base64 Decode php_postsavehook.
			$item->php_postsavehook = base64_decode($item->php_postsavehook);
		}

		if (isset($item->php_before_save) && is_string($item->php_before_save) && $item->php_before_save !== '')
		{
			// base64 Decode php_before_save.
			$item->php_before_save = base64_decode($item->php_before_save);
		}

		if (isset($item->php_getlistquery) && is_string($item->php_getlistquery) && $item->php_getlistquery !== '')
		{
			// base64 Decode php_getlistquery.
			$item->php_getlistquery = base64_decode($item->php_getlistquery);
		}

		if (isset($item->php_getitems) && is_string($item->php_getitems) && $item->php_getitems !== '')
		{
			// base64 Decode php_getitems.
			$item->php_getitems = base64_decode($item->php_getitems);
		}

		if (isset($item->php_batchmove) && is_string($item->php_batchmove) && $item->php_batchmove !== '')
		{
			// base64 Decode php_batchmove.
			$item->php_batchmove = base64_decode($item->php_batchmove);
		}

		if (isset($item->php_allowedit) && is_string($item->php_allowedit) && $item->php_allowedit !== '')
		{
			// base64 Decode php_allowedit.
			$item->php_allowedit = base64_decode($item->php_allowedit);
		}

		if (isset($item->php_after_delete) && is_string($item->php_after_delete) && $item->php_after_delete !== '')
		{
			// base64 Decode php_after_delete.
			$item->php_after_delete = base64_decode($item->php_after_delete);
		}

		if (isset($item->php_after_cancel) && is_string($item->php_after_cancel) && $item->php_after_cancel !== '')
		{
			// base64 Decode php_after_cancel.
			$item->php_after_cancel = base64_decode($item->php_after_cancel);
		}

		if (isset($item->php_after_publish) && is_string($item->php_after_publish) && $item->php_after_publish !== '')
		{
			// base64 Decode php_after_publish.
			$item->php_after_publish = base64_decode($item->php_after_publish);
		}

		if (isset($item->php_getitem) && is_string($item->php_getitem) && $item->php_getitem !== '')
		{
			// base64 Decode php_getitem.
			$item->php_getitem = base64_decode($item->php_getitem);
		}

		if (isset($item->php_getitems_after_all) && is_string($item->php_getitems_after_all) && $item->php_getitems_after_all !== '')
		{
			// base64 Decode php_getitems_after_all.
			$item->php_getitems_after_all = base64_decode($item->php_getitems_after_all);
		}

		if (isset($item->php_getform) && is_string($item->php_getform) && $item->php_getform !== '')
		{
			// base64 Decode php_getform.
			$item->php_getform = base64_decode($item->php_getform);
		}

		if (isset($item->php_save) && is_string($item->php_save) && $item->php_save !== '')
		{
			// base64 Decode php_save.
			$item->php_save = base64_decode($item->php_save);
		}

		if (isset($item->php_allowadd) && is_string($item->php_allowadd) && $item->php_allowadd !== '')
		{
			// base64 Decode php_allowadd.
			$item->php_allowadd = base64_decode($item->php_allowadd);
		}

		if (isset($item->php_before_cancel) && is_string($item->php_before_cancel) && $item->php_before_cancel !== '')
		{
			// base64 Decode php_before_cancel.
			$item->php_before_cancel = base64_decode($item->php_before_cancel);
		}

		if (isset($item->php_batchcopy) && is_string($item->php_batchcopy) && $item->php_batchcopy !== '')
		{
			// base64 Decode php_batchcopy.
			$item->php_batchcopy = base64_decode($item->php_batchcopy);
		}

		if (isset($item->php_before_publish) && is_string($item->php_before_publish) && $item->php_before_publish !== '')
		{
			// base64 Decode php_before_publish.
			$item->php_before_publish = base64_decode($item->php_before_publish);
		}

		if (isset($item->php_before_delete) && is_string($item->php_before_delete) && $item->php_before_delete !== '')
		{
			// base64 Decode php_before_delete.
			$item->php_before_delete = base64_decode($item->php_before_delete);
		}

		if (isset($item->php_document) && is_string($item->php_document) && $item->php_document !== '')
		{
			// base64 Decode php_document.
			$item->php_document = base64_decode($item->php_document);
		}

		if (isset($item->sql) && is_string($item->sql) && $item->sql !== '')
		{
			// base64 Decode sql.
			$item->sql = base64_decode($item->sql);
		}

		if (isset($item->php_ajaxmethod) && is_string($item->php_ajaxmethod) && $item->php_ajaxmethod !== '')
		{
			// base64 Decode php_ajaxmethod.
			$item->php_ajaxmethod = base64_decode($item->php_ajaxmethod);
		}

		if (isset($item->css_view) && is_string($item->css_view) && $item->css_view !== '')
		{
			// base64 Decode css_view.
			$item->css_view = base64_decode($item->css_view);
		}

		if (isset($item->css_views) && is_string($item->css_views) && $item->css_views !== '')
		{
			// base64 Decode css_views.
			$item->css_views = base64_decode($item->css_views);
		}

		if (isset($item->javascript_view_file) && is_string($item->javascript_view_file) && $item->javascript_view_file !== '')
		{
			// base64 Decode javascript_view_file.
			$item->javascript_view_file = base64_decode($item->javascript_view_file);
		}

		if (isset($item->javascript_view_footer) && is_string($item->javascript_view_footer) && $item->javascript_view_footer !== '')
		{
			// base64 Decode javascript_view_footer.
			$item->javascript_view_footer = base64_decode($item->javascript_view_footer);
		}

		if (isset($item->javascript_views_file) && is_string($item->javascript_views_file) && $item->javascript_views_file !== '')
		{
			// base64 Decode javascript_views_file.
			$item->javascript_views_file = base64_decode($item->javascript_views_file);
		}

		if (isset($item->javascript_views_footer) && is_string($item->javascript_views_footer) && $item->javascript_views_footer !== '')
		{
			// base64 Decode javascript_views_footer.
			$item->javascript_views_footer = base64_decode($item->javascript_views_footer);
		}

		if (isset($item->php_controller) && is_string($item->php_controller) && $item->php_controller !== '')
		{
			// base64 Decode php_controller.
			$item->php_controller = base64_decode($item->php_controller);
		}

		if (isset($item->php_model) && is_string($item->php_model) && $item->php_model !== '')
		{
			// base64 Decode php_model.
			$item->php_model = base64_decode($item->php_model);
		}

		if (isset($item->php_controller_list) && is_string($item->php_controller_list) && $item->php_controller_list !== '')
		{
			// base64 Decode php_controller_list.
			$item->php_controller_list = base64_decode($item->php_controller_list);
		}

		if (isset($item->php_model_list) && is_string($item->php_model_list) && $item->php_model_list !== '')
		{
			// base64 Decode php_model_list.
			$item->php_model_list = base64_decode($item->php_model_list);
		}

		if (isset($item->view_toolbar) && is_string($item->view_toolbar) && $item->view_toolbar !== '')
		{
			// base64 Decode view_toolbar.
			$item->view_toolbar = base64_decode($item->view_toolbar);
		}

		if (isset($item->views_toolbar) && is_string($item->views_toolbar) && $item->views_toolbar !== '')
		{
			// base64 Decode views_toolbar.
			$item->views_toolbar = base64_decode($item->views_toolbar);
		}

		if (isset($item->ajax_input) && is_string($item->ajax_input) && $item->ajax_input !== '')
		{
			// Convert the ajax_input field to an array.
			$registry = new Registry;
			$registry->loadString($item->ajax_input);
			$item->ajax_input = $registry->toArray();
		}

		if (isset($item->addpermissions) && is_string($item->addpermissions) && $item->addpermissions !== '')
		{
			// Convert the addpermissions field to an array.
			$registry = new Registry;
			$registry->loadString($item->addpermissions);
			$item->addpermissions = $registry->toArray();
		}

		if (isset($item->addtabs) && is_string($item->addtabs) && $item->addtabs !== '')
		{
			// Convert the addtabs field to an array.
			$registry = new Registry;
			$registry->loadString($item->addtabs);
			$item->addtabs = $registry->toArray();
		}

		if (isset($item->addlinked_views) && is_string($item->addlinked_views) && $item->addlinked_views !== '')
		{
			// Convert the addlinked_views field to an array.
			$registry = new Registry;
			$registry->loadString($item->addlinked_views);
			$item->addlinked_views = $registry->toArray();
		}

		if (isset($item->alias_builder) && is_string($item->alias_builder) && $item->alias_builder !== '')
		{
			// Convert the alias_builder field to an array.
			$registry = new Registry;
			$registry->loadString($item->alias_builder);
			$item->alias_builder = $registry->toArray();
		}

		if (isset($item->custom_button) && is_string($item->custom_button) && $item->custom_button !== '')
		{
			// Convert the custom_button field to an array.
			$registry = new Registry;
			$registry->loadString($item->custom_button);
			$item->custom_button = $registry->toArray();
		}

		if (isset($item->addtables) && is_string($item->addtables) && $item->addtables !== '')
		{
			// Convert the addtables field to an array.
			$registry = new Registry;
			$registry->loadString($item->addtables);
			$item->addtables = $registry->toArray();
		}

		return parent::prepareItem($item);
	}
}
