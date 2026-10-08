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
namespace VDM\Component\Componentbuilder\Api\View\Custom_admin_view;

use Joomla\CMS\Factory;
use Joomla\CMS\Helper\TagsHelper;
use Joomla\CMS\MVC\View\JsonApiView as BaseApiView;
use VDM\Component\Componentbuilder\Administrator\Helper\ComponentbuilderHelper;
use VDM\Component\Componentbuilder\Api\Serializer\Custom_admin_viewSerializer;

// No direct access to this file
\defined('_JEXEC') or die;

/**
 * Custom_admin_view Json View class
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
		'name',
		'description',
		'main_get',
		'add_php_view',
		'javascript_file',
		'css_document',
		'view_toolbar',
		'js_document',
		'default',
		'snippet',
		'icon',
		'add_php_jview_display',
		'context',
		'add_php_jview',
		'codename',
		'custom_get',
		'add_js_document',
		'css',
		'add_javascript_file',
		'php_ajaxmethod',
		'add_css_document',
		'add_php_document',
		'add_css',
		'libraries',
		'add_php_ajax',
		'dynamic_get',
		'ajax_input',
		'php_document',
		'add_custom_button',
		'php_view',
		'custom_button',
		'php_jview_display',
		'php_controller',
		'php_jview',
		'php_model',
		'guid',
		'add_view_toolbar',
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
		'main_get',
		'snippet',
		'custom_get',
		'libraries',
		'dynamic_get',
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
			$this->serializer = new Custom_admin_viewSerializer($config['contentType']);
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
