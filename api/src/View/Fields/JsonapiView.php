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
namespace VDM\Component\Componentbuilder\Api\View\Fields;

use Joomla\CMS\Factory;
use Joomla\CMS\MVC\View\JsonApiView as BaseApiView;
use Joomla\Registry\Registry;
use VDM\Component\Componentbuilder\Administrator\Helper\ComponentbuilderHelper;
use VDM\Component\Componentbuilder\Api\Serializer\FieldSerializer;

// No direct access to this file
\defined('_JEXEC') or die;

/**
 * Componentbuilder Json View class for the Fields
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
		'fieldtype',
		'datatype',
		'indexes',
		'null_switch',
		'store',
		'catid',
		'on_get_model_field',
		'on_save_model_field',
		'initiator_on_get_model',
		'xml',
		'datalenght',
		'javascript_view_footer',
		'css_views',
		'css_view',
		'datadefault_other',
		'datadefault',
		'datalenght_other',
		'javascript_views_footer',
		'add_css_view',
		'add_css_views',
		'add_javascript_view_footer',
		'add_javascript_views_footer',
		'initiator_on_save_model',
		'guid',
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
		'fieldtype',
		'catid',
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
			$this->serializer = new FieldSerializer($config['contentType']);
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
		if (isset($item->on_get_model_field) && is_string($item->on_get_model_field) && $item->on_get_model_field !== '')
		{
			// base64 Decode on_get_model_field.
			$item->on_get_model_field = base64_decode($item->on_get_model_field);
		}

		if (isset($item->on_save_model_field) && is_string($item->on_save_model_field) && $item->on_save_model_field !== '')
		{
			// base64 Decode on_save_model_field.
			$item->on_save_model_field = base64_decode($item->on_save_model_field);
		}

		if (isset($item->initiator_on_get_model) && is_string($item->initiator_on_get_model) && $item->initiator_on_get_model !== '')
		{
			// base64 Decode initiator_on_get_model.
			$item->initiator_on_get_model = base64_decode($item->initiator_on_get_model);
		}

		if (isset($item->javascript_view_footer) && is_string($item->javascript_view_footer) && $item->javascript_view_footer !== '')
		{
			// base64 Decode javascript_view_footer.
			$item->javascript_view_footer = base64_decode($item->javascript_view_footer);
		}

		if (isset($item->css_views) && is_string($item->css_views) && $item->css_views !== '')
		{
			// base64 Decode css_views.
			$item->css_views = base64_decode($item->css_views);
		}

		if (isset($item->css_view) && is_string($item->css_view) && $item->css_view !== '')
		{
			// base64 Decode css_view.
			$item->css_view = base64_decode($item->css_view);
		}

		if (isset($item->javascript_views_footer) && is_string($item->javascript_views_footer) && $item->javascript_views_footer !== '')
		{
			// base64 Decode javascript_views_footer.
			$item->javascript_views_footer = base64_decode($item->javascript_views_footer);
		}

		if (isset($item->initiator_on_save_model) && is_string($item->initiator_on_save_model) && $item->initiator_on_save_model !== '')
		{
			// base64 Decode initiator_on_save_model.
			$item->initiator_on_save_model = base64_decode($item->initiator_on_save_model);
		}

		if (isset($item->xml) && is_string($item->xml) && $item->xml !== '')
		{
			// JSON Decode xml.
			$item->xml = json_decode($item->xml);
		}

		return parent::prepareItem($item);
	}
}
