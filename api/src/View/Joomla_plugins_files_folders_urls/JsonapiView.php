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
namespace VDM\Component\Componentbuilder\Api\View\Joomla_plugins_files_folders_urls;

use Joomla\CMS\Factory;
use Joomla\CMS\MVC\View\JsonApiView as BaseApiView;
use Joomla\Registry\Registry;
use VDM\Component\Componentbuilder\Administrator\Helper\ComponentbuilderHelper;
use VDM\Component\Componentbuilder\Api\Serializer\Joomla_plugin_files_folders_urlsSerializer;

// No direct access to this file
\defined('_JEXEC') or die;

/**
 * Componentbuilder Json View class for the Joomla_plugins_files_folders_urls
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
		'joomla_plugin',
		'addfoldersfullpath',
		'addfilesfullpath',
		'addfolders',
		'addfiles',
		'addurls',
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
		'joomla_plugin',
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
			$this->serializer = new Joomla_plugin_files_folders_urlsSerializer($config['contentType']);
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
		if (isset($item->addfoldersfullpath) && is_string($item->addfoldersfullpath) && $item->addfoldersfullpath !== '')
		{
			// Convert the addfoldersfullpath field to an array.
			$registry = new Registry;
			$registry->loadString($item->addfoldersfullpath);
			$item->addfoldersfullpath = $registry->toArray();
		}

		if (isset($item->addfilesfullpath) && is_string($item->addfilesfullpath) && $item->addfilesfullpath !== '')
		{
			// Convert the addfilesfullpath field to an array.
			$registry = new Registry;
			$registry->loadString($item->addfilesfullpath);
			$item->addfilesfullpath = $registry->toArray();
		}

		if (isset($item->addfolders) && is_string($item->addfolders) && $item->addfolders !== '')
		{
			// Convert the addfolders field to an array.
			$registry = new Registry;
			$registry->loadString($item->addfolders);
			$item->addfolders = $registry->toArray();
		}

		if (isset($item->addfiles) && is_string($item->addfiles) && $item->addfiles !== '')
		{
			// Convert the addfiles field to an array.
			$registry = new Registry;
			$registry->loadString($item->addfiles);
			$item->addfiles = $registry->toArray();
		}

		if (isset($item->addurls) && is_string($item->addurls) && $item->addurls !== '')
		{
			// Convert the addurls field to an array.
			$registry = new Registry;
			$registry->loadString($item->addurls);
			$item->addurls = $registry->toArray();
		}

		return parent::prepareItem($item);
	}
}
