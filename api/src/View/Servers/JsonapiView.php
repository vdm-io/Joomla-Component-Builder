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
namespace VDM\Component\Componentbuilder\Api\View\Servers;

use Joomla\CMS\Factory;
use Joomla\CMS\MVC\View\JsonApiView as BaseApiView;
use Joomla\Registry\Registry;
use VDM\Component\Componentbuilder\Administrator\Helper\ComponentbuilderHelper;
use VDM\Component\Componentbuilder\Api\Serializer\ServerSerializer;
use VDM\Joomla\FOF\Encrypt\AES;

// No direct access to this file
\defined('_JEXEC') or die;

/**
 * Componentbuilder Json View class for the Servers
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
		'protocol',
		'signature',
		'private_key',
		'secret',
		'password',
		'private',
		'authentication',
		'path',
		'port',
		'host',
		'username',
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
			$this->serializer = new ServerSerializer($config['contentType']);
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
		// Get the basic encryption.
		$basickey = ComponentbuilderHelper::getCryptKey('basic');
		// Get the encryption object.
		$basic = new AES($basickey);

		if (!empty($item->signature) && $basickey && is_string($item->signature) && !is_numeric($item->signature) && $item->signature === base64_encode(base64_decode($item->signature, true)))
		{
			// basic decrypt data signature.
			$item->signature = rtrim($basic->decryptString($item->signature), "\0");
		}

		if (!empty($item->private_key) && $basickey && is_string($item->private_key) && !is_numeric($item->private_key) && $item->private_key === base64_encode(base64_decode($item->private_key, true)))
		{
			// basic decrypt data private_key.
			$item->private_key = rtrim($basic->decryptString($item->private_key), "\0");
		}

		if (!empty($item->secret) && $basickey && is_string($item->secret) && !is_numeric($item->secret) && $item->secret === base64_encode(base64_decode($item->secret, true)))
		{
			// basic decrypt data secret.
			$item->secret = rtrim($basic->decryptString($item->secret), "\0");
		}

		if (!empty($item->password) && $basickey && is_string($item->password) && !is_numeric($item->password) && $item->password === base64_encode(base64_decode($item->password, true)))
		{
			// basic decrypt data password.
			$item->password = rtrim($basic->decryptString($item->password), "\0");
		}

		if (!empty($item->private) && $basickey && is_string($item->private) && !is_numeric($item->private) && $item->private === base64_encode(base64_decode($item->private, true)))
		{
			// basic decrypt data private.
			$item->private = rtrim($basic->decryptString($item->private), "\0");
		}

		if (!empty($item->path) && $basickey && is_string($item->path) && !is_numeric($item->path) && $item->path === base64_encode(base64_decode($item->path, true)))
		{
			// basic decrypt data path.
			$item->path = rtrim($basic->decryptString($item->path), "\0");
		}

		if (!empty($item->port) && $basickey && is_string($item->port) && !is_numeric($item->port) && $item->port === base64_encode(base64_decode($item->port, true)))
		{
			// basic decrypt data port.
			$item->port = rtrim($basic->decryptString($item->port), "\0");
		}

		if (!empty($item->host) && $basickey && is_string($item->host) && !is_numeric($item->host) && $item->host === base64_encode(base64_decode($item->host, true)))
		{
			// basic decrypt data host.
			$item->host = rtrim($basic->decryptString($item->host), "\0");
		}

		if (!empty($item->username) && $basickey && is_string($item->username) && !is_numeric($item->username) && $item->username === base64_encode(base64_decode($item->username, true)))
		{
			// basic decrypt data username.
			$item->username = rtrim($basic->decryptString($item->username), "\0");
		}

		return parent::prepareItem($item);
	}
}
