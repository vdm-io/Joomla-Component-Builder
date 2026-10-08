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
namespace VDM\Component\Componentbuilder\Api\View\Field;

use Joomla\CMS\Factory;
use Joomla\CMS\Helper\TagsHelper;
use Joomla\CMS\MVC\View\JsonApiView as BaseApiView;
use VDM\Component\Componentbuilder\Administrator\Helper\ComponentbuilderHelper;
use VDM\Component\Componentbuilder\Api\Serializer\FieldSerializer;

// No direct access to this file
\defined('_JEXEC') or die;

/**
 * Field Json View class
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
	 * The relationships the item has
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
