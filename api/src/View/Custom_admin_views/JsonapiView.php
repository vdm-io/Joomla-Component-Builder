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
namespace VDM\Component\Componentbuilder\Api\View\Custom_admin_views;

use Joomla\CMS\Factory;
use Joomla\CMS\MVC\View\JsonApiView as BaseApiView;
use Joomla\Registry\Registry;
use VDM\Component\Componentbuilder\Administrator\Helper\ComponentbuilderHelper;
use VDM\Component\Componentbuilder\Api\Serializer\Custom_admin_viewSerializer;

// No direct access to this file
\defined('_JEXEC') or die;

/**
 * Componentbuilder Json View class for the Custom_admin_views
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
	 * The relationships the items have
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
		if (isset($item->javascript_file) && is_string($item->javascript_file) && $item->javascript_file !== '')
		{
			// base64 Decode javascript_file.
			$item->javascript_file = base64_decode($item->javascript_file);
		}

		if (isset($item->css_document) && is_string($item->css_document) && $item->css_document !== '')
		{
			// base64 Decode css_document.
			$item->css_document = base64_decode($item->css_document);
		}

		if (isset($item->view_toolbar) && is_string($item->view_toolbar) && $item->view_toolbar !== '')
		{
			// base64 Decode view_toolbar.
			$item->view_toolbar = base64_decode($item->view_toolbar);
		}

		if (isset($item->js_document) && is_string($item->js_document) && $item->js_document !== '')
		{
			// base64 Decode js_document.
			$item->js_document = base64_decode($item->js_document);
		}

		if (isset($item->default) && is_string($item->default) && $item->default !== '')
		{
			// base64 Decode default.
			$item->default = base64_decode($item->default);
		}

		if (isset($item->css) && is_string($item->css) && $item->css !== '')
		{
			// base64 Decode css.
			$item->css = base64_decode($item->css);
		}

		if (isset($item->php_ajaxmethod) && is_string($item->php_ajaxmethod) && $item->php_ajaxmethod !== '')
		{
			// base64 Decode php_ajaxmethod.
			$item->php_ajaxmethod = base64_decode($item->php_ajaxmethod);
		}

		if (isset($item->php_document) && is_string($item->php_document) && $item->php_document !== '')
		{
			// base64 Decode php_document.
			$item->php_document = base64_decode($item->php_document);
		}

		if (isset($item->php_view) && is_string($item->php_view) && $item->php_view !== '')
		{
			// base64 Decode php_view.
			$item->php_view = base64_decode($item->php_view);
		}

		if (isset($item->php_jview_display) && is_string($item->php_jview_display) && $item->php_jview_display !== '')
		{
			// base64 Decode php_jview_display.
			$item->php_jview_display = base64_decode($item->php_jview_display);
		}

		if (isset($item->php_controller) && is_string($item->php_controller) && $item->php_controller !== '')
		{
			// base64 Decode php_controller.
			$item->php_controller = base64_decode($item->php_controller);
		}

		if (isset($item->php_jview) && is_string($item->php_jview) && $item->php_jview !== '')
		{
			// base64 Decode php_jview.
			$item->php_jview = base64_decode($item->php_jview);
		}

		if (isset($item->php_model) && is_string($item->php_model) && $item->php_model !== '')
		{
			// base64 Decode php_model.
			$item->php_model = base64_decode($item->php_model);
		}

		if (isset($item->custom_get) && is_string($item->custom_get) && $item->custom_get !== '')
		{
			// Convert the custom_get field to an array.
			$registry = new Registry;
			$registry->loadString($item->custom_get);
			$item->custom_get = $registry->toArray();
		}

		if (isset($item->libraries) && is_string($item->libraries) && $item->libraries !== '')
		{
			// Convert the libraries field to an array.
			$registry = new Registry;
			$registry->loadString($item->libraries);
			$item->libraries = $registry->toArray();
		}

		if (isset($item->ajax_input) && is_string($item->ajax_input) && $item->ajax_input !== '')
		{
			// Convert the ajax_input field to an array.
			$registry = new Registry;
			$registry->loadString($item->ajax_input);
			$item->ajax_input = $registry->toArray();
		}

		if (isset($item->custom_button) && is_string($item->custom_button) && $item->custom_button !== '')
		{
			// Convert the custom_button field to an array.
			$registry = new Registry;
			$registry->loadString($item->custom_button);
			$item->custom_button = $registry->toArray();
		}

		return parent::prepareItem($item);
	}
}
