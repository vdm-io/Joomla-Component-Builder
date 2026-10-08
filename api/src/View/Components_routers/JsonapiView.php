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
namespace VDM\Component\Componentbuilder\Api\View\Components_routers;

use Joomla\CMS\Factory;
use Joomla\CMS\MVC\View\JsonApiView as BaseApiView;
use Joomla\Registry\Registry;
use VDM\Component\Componentbuilder\Administrator\Helper\ComponentbuilderHelper;
use VDM\Component\Componentbuilder\Api\Serializer\Component_routerSerializer;

// No direct access to this file
\defined('_JEXEC') or die;

/**
 * Componentbuilder Json View class for the Components_routers
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
		'joomla_component',
		'mode_constructor_before_parent',
		'mode_constructor_after_parent',
		'mode_methods',
		'methods_code',
		'constructor_after_parent_code',
		'constructor_before_parent_manual',
		'constructor_before_parent_code',
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
		'joomla_component',
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
			$this->serializer = new Component_routerSerializer($config['contentType']);
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
		if (isset($item->methods_code) && is_string($item->methods_code) && $item->methods_code !== '')
		{
			// base64 Decode methods_code.
			$item->methods_code = base64_decode($item->methods_code);
		}

		if (isset($item->constructor_after_parent_code) && is_string($item->constructor_after_parent_code) && $item->constructor_after_parent_code !== '')
		{
			// base64 Decode constructor_after_parent_code.
			$item->constructor_after_parent_code = base64_decode($item->constructor_after_parent_code);
		}

		if (isset($item->constructor_before_parent_code) && is_string($item->constructor_before_parent_code) && $item->constructor_before_parent_code !== '')
		{
			// base64 Decode constructor_before_parent_code.
			$item->constructor_before_parent_code = base64_decode($item->constructor_before_parent_code);
		}

		if (isset($item->constructor_before_parent_manual) && is_string($item->constructor_before_parent_manual) && $item->constructor_before_parent_manual !== '')
		{
			// Convert the constructor_before_parent_manual field to an array.
			$registry = new Registry;
			$registry->loadString($item->constructor_before_parent_manual);
			$item->constructor_before_parent_manual = $registry->toArray();
		}

		return parent::prepareItem($item);
	}
}
