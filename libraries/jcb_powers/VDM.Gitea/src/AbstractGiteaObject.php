<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <http://www.joomlacomponentbuilder.com>
 * @gitea      Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @github     Joomla Component Builder <https://github.com/vdm-io/Joomla-Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Gitea;


use Joomla\CMS\Http\Http as BaseHttp;
use Joomla\CMS\Http\HttpFactory;
use Joomla\CMS\Http\Response;
use Joomla\Registry\Registry;
use Joomla\Uri\Uri;
use VDM\Joomla\Utilities\JsonHelper;

abstract class AbstractGiteaObject
{
	/**
	 * Options for the Gitea object.
	 *
	 * @var    Registry
	 * @since  1.0
	 */
	protected $options;

	/**
	 * The HTTP client object to use in sending HTTP requests.
	 *
	 * @var    BaseHttp
	 * @since  1.0
	 */
	protected $client;

	/**
	 * The package the object resides in
	 *
	 * @var    string
	 * @since  1.0
	 */
	protected $package = '';

	/**
	 * Constructor.
	 *
	 * @param   Registry  $options  Gitea options object.
	 * @param   BaseHttp  $client   The HTTP client object.
	 *
	 * @since   1.0
	 */
	public function __construct(Registry $options = null, BaseHttp $client = null)
	{
		$this->options = $options ?: new Registry;
		$this->client  = $client ?: (new HttpFactory)->getHttp($this->options);

		$this->package = \get_class($this);
		$this->package = substr($this->package, strrpos($this->package, '\\') + 1);
	}

	/**
	 * Method to build and return a full request URL for the request.  This method will
	 * add appropriate pagination details if necessary and also prepend the API url
	 * to have a complete URL for the request.
	 *
	 * @param   string   $path   URL to inflect
	 * @param   integer  $page   Page to request
	 * @param   integer  $limit  Number of results to return per page
	 *
	 * @return  Uri
	 *
	 * @since   1.0
	 */
	protected function fetchUrl($path, $page = 0, $limit = 0)
	{
		// Get a new Uri object focusing the api url and given path.
		$uri = new Uri($this->options->get('api.url') . $path);

		if ($this->options->get('access.token', false))
		{
			// Use oAuth authentication
			$headers = $this->client->getOption('headers', array());

			if (!isset($headers['Authorization']))
			{
				$headers['Authorization'] = 'token ' . $this->options->get('access.token');
				$this->client->setOption('headers', $headers);
			}
		}
		else
		{
			// Use basic authentication
			if ($this->options->get('api.username', false))
			{
				$uri->setUser($this->options->get('api.username'));
			}

			if ($this->options->get('api.password', false))
			{
				$uri->setPass($this->options->get('api.password'));
			}
		}

		// If we have a defined page number add it to the JUri object.
		if ($page > 0)
		{
			$uri->setVar('page', (int) $page);
		}

		// If we have a defined items per page add it to the JUri object.
		if ($limit > 0)
		{
			$uri->setVar('limit', (int) $limit);
		}

		return $uri;
	}

	/**
	 * Process the response and decode it.
	 *
	 * @param   Response  $response      The response.
	 * @param   integer   $expectedCode  The expected "good" code.
	 *
	 * @return  mixed
	 *
	 * @since   1.0
	 * @throws  RuntimeException
	 */
	protected function processResponse(Response $response, $expectedCode = 200)
	{
		// Validate the response code.
		if ($response->code != $expectedCode)
		{
			// Decode the error response and throw an exception.
			$error   = json_decode($response->body);
			$message = isset($error->message) ? $error->message : 'Invalid response received from Gitea.';

			throw new \DomainException($message, $response->code);
		}

		if (JsonHelper::check($response->body))
		{
			$body = json_decode($response->body);

			if (isset($body->content_base64))
			{
				$body->content = base64_decode($body->content_base64);
			}
		}
		else
		{
			$body = $response->body;
		}

		return $body;
	}

}

