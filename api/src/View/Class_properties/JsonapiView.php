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
namespace VDM\Component\Componentbuilder\Api\View\Class_properties;

use Joomla\CMS\Factory;
use Joomla\CMS\MVC\View\JsonApiView as BaseApiView;
use Joomla\Registry\Registry;
use VDM\Component\Componentbuilder\Administrator\Helper\ComponentbuilderHelper;
use VDM\Component\Componentbuilder\Api\Serializer\Class_propertySerializer;

// No direct access to this file
\defined('_JEXEC') or die;

/**
 * Componentbuilder Json View class for the Class_properties
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
		'visibility',
		'extension_type',
		'guid',
		'comment',
		'joomla_plugin_group',
		'default',
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
		'joomla_plugin_group',
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
			$this->serializer = new Class_propertySerializer($config['contentType']);
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
		if (isset($item->comment) && is_string($item->comment) && $item->comment !== '')
		{
			// base64 Decode comment.
			$item->comment = base64_decode($item->comment);
		}

		if (isset($item->default) && is_string($item->default) && $item->default !== '')
		{
			// base64 Decode default.
			$item->default = base64_decode($item->default);
		}

		return parent::prepareItem($item);
	}
}
