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
namespace VDM\Component\Componentbuilder\Api\View\Powers;

use Joomla\CMS\Factory;
use Joomla\CMS\MVC\View\JsonApiView as BaseApiView;
use Joomla\Registry\Registry;
use VDM\Component\Componentbuilder\Administrator\Helper\ComponentbuilderHelper;
use VDM\Component\Componentbuilder\Api\Serializer\PowerSerializer;

// No direct access to this file
\defined('_JEXEC') or die;

/**
 * Componentbuilder Json View class for the Powers
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
		'namespace',
		'type',
		'power_version',
		'load_selection',
		'description',
		'composer',
		'licensing_template',
		'approved',
		'extendsinterfaces_custom',
		'add_head',
		'extends',
		'extends_custom',
		'implements_custom',
		'implements',
		'property_selection',
		'extendsinterfaces',
		'method_selection',
		'approved_paths',
		'head',
		'use_selection',
		'add_licensing_template',
		'main_class_code',
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
	 * The relationships the items have
	 *
	 * @var    array
	 * @since  4.0.0
	 */
	protected $relationship = [
		'extends',
		'implements',
		'extendsinterfaces',
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
			$this->serializer = new PowerSerializer($config['contentType']);
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
		if (isset($item->licensing_template) && is_string($item->licensing_template) && $item->licensing_template !== '')
		{
			// base64 Decode licensing_template.
			$item->licensing_template = base64_decode($item->licensing_template);
		}

		if (isset($item->head) && is_string($item->head) && $item->head !== '')
		{
			// base64 Decode head.
			$item->head = base64_decode($item->head);
		}

		if (isset($item->main_class_code) && is_string($item->main_class_code) && $item->main_class_code !== '')
		{
			// base64 Decode main_class_code.
			$item->main_class_code = base64_decode($item->main_class_code);
		}

		if (isset($item->load_selection) && is_string($item->load_selection) && $item->load_selection !== '')
		{
			// Convert the load_selection field to an array.
			$registry = new Registry;
			$registry->loadString($item->load_selection);
			$item->load_selection = $registry->toArray();
		}

		if (isset($item->composer) && is_string($item->composer) && $item->composer !== '')
		{
			// Convert the composer field to an array.
			$registry = new Registry;
			$registry->loadString($item->composer);
			$item->composer = $registry->toArray();
		}

		if (isset($item->implements) && is_string($item->implements) && $item->implements !== '')
		{
			// Convert the implements field to an array.
			$registry = new Registry;
			$registry->loadString($item->implements);
			$item->implements = $registry->toArray();
		}

		if (isset($item->property_selection) && is_string($item->property_selection) && $item->property_selection !== '')
		{
			// Convert the property_selection field to an array.
			$registry = new Registry;
			$registry->loadString($item->property_selection);
			$item->property_selection = $registry->toArray();
		}

		if (isset($item->extendsinterfaces) && is_string($item->extendsinterfaces) && $item->extendsinterfaces !== '')
		{
			// Convert the extendsinterfaces field to an array.
			$registry = new Registry;
			$registry->loadString($item->extendsinterfaces);
			$item->extendsinterfaces = $registry->toArray();
		}

		if (isset($item->method_selection) && is_string($item->method_selection) && $item->method_selection !== '')
		{
			// Convert the method_selection field to an array.
			$registry = new Registry;
			$registry->loadString($item->method_selection);
			$item->method_selection = $registry->toArray();
		}

		if (isset($item->use_selection) && is_string($item->use_selection) && $item->use_selection !== '')
		{
			// Convert the use_selection field to an array.
			$registry = new Registry;
			$registry->loadString($item->use_selection);
			$item->use_selection = $registry->toArray();
		}

		if (isset($item->approved_paths) && is_string($item->approved_paths) && $item->approved_paths !== '')
		{
			// JSON Decode approved_paths.
			$item->approved_paths = json_decode($item->approved_paths);
		}

		return parent::prepareItem($item);
	}
}
