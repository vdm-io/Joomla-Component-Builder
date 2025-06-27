<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    4th September, 2022
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Github\Utilities;


use Joomla\Uri\Uri as JoomlaUri;


/**
 * The Github Uri
 * 
 * @since  5.1.1
 */
final class Uri
{
	/**
	 * The api endpoint
	 *
	 * @var      string
	 * @since 5.1.1
	 */
	private string $endpoint;

	/**
	 * The api version
	 *
	 * @var      string
	 * @since 5.1.1
	 */
	private string $version;

	/**
	 * The api URL
	 *
	 * @var      string
	 * @since 5.1.1
	 */
	private string $url;

	/**
	 * Constructor
	 *
	 * @param   string   $url        URL to the github system
	 *                                  example: https://api.github.com
	 * @param   string   $endpoint   Endpoint to the gitea system
	 * @param   string   $version    Version to the gitea system
	 *
	 * @since   5.1.1
	 **/
	public function __construct(
		string $url = 'https://api.github.com',
		string $endpoint =  '',
		string $version  =  'v3')
	{
		// set the API details
		$this->setUrl($url);
		//$this->setEndpoint($endpoint);
		//$this->setVersion($version);
	}

	/**
	 * Method to build and return a full request URL for the request.  This method will
	 * add appropriate pagination details if necessary and also prepend the API url
	 * to have a complete URL for the request.
	 *
	 * @param   string   $path   URL to inflect
	 *
	 * @return  JoomlaUri
	 * @since   5.1.1
	 **/
	public function get(string $path): JoomlaUri
	{
		// GitHub API does not use version in URL (normally passed in Accept headers)
		// But we maintain compatibility with existing interface
		$uri = new JoomlaUri($this->api() . ltrim($path, '/'));

		return $uri;
	}

	/**
	 * Get the full API URL
	 *
	 * @return  string
	 * @since   5.1.1
	 **/
	public function api(): string
	{
		// Ensure trailing slash on base URL
		return rtrim($this->url, '/') . '/';
		/**
			// GitHub typically does not use endpoint/version in URL
			// But to preserve interface, we include them conditionally
			$segments = [];

			if (!empty($this->endpoint))
			{
				$segments[] = trim($this->endpoint, '/');
			}

			if (!empty($this->version))
			{
				$segments[] = trim($this->version, '/');
			}

			return $base . (empty($segments) ? '' : implode('/', $segments) . '/');
		 **/
	}

	/**
	 * Set the URL of the API
	 *
	 * @param   string   $url   URL to your github system
	 *                             example: https://api.github.com
	 *
	 * @return  void
	 * @since   5.1.1
	 **/
	public function setUrl(string $url)
	{
		$this->url = $url;
	}

	/**
	 * Get the URL of the API
	 *
	 * @return  string|null
	 * @since   5.1.1
	 **/
	public function getUrl(): ?string
	{
		return $this->url ?? null;
	}

	/**
	 * Set the endpoint of the API
	 *
	 * @param   string   $endpoint   endpoint to your github API
	 *
	 * @return  void
	 * @since   5.1.1
	private function setEndpoint(string $endpoint)
	{
		$this->endpoint = $endpoint;
	}
	 **/

	/**
	 * Set the version of the API
	 *
	 * @param   string   $version   version to your github API
	 *
	 * @return  void
	 * @since   3.2.0
	private function setVersion($version)
	{
		$this->version = $version;
	}
	 **/
}

