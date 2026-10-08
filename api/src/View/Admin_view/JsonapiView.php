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
namespace VDM\Component\Componentbuilder\Api\View\Admin_view;

use Joomla\CMS\Factory;
use Joomla\CMS\Helper\TagsHelper;
use Joomla\CMS\MVC\View\JsonApiView as BaseApiView;
use VDM\Component\Componentbuilder\Administrator\Helper\ComponentbuilderHelper;
use VDM\Component\Componentbuilder\Api\Serializer\Admin_viewSerializer;

// No direct access to this file
\defined('_JEXEC') or die;

/**
 * Admin_view Json View class
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
	 * The relationships the item has
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
