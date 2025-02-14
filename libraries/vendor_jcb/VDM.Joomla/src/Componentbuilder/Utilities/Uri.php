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

namespace VDM\Joomla\Componentbuilder\Utilities;


use Joomla\Uri\Uri as JoomlaUri;


/**
 * The Joomla Component Builder Uri
 * 
 * @since 5.0.4
 */
final class Uri
{
	/**
	 * The api version
	 *
	 * @var      string
	 * @since 3.2.0
	 */
	private string $version;

	/**
	 * The api URL
	 *
	 * @var      string
	 * @since 3.2.0
	 */
	private string $url;

	/**
	 * Constructor
	 *
	 * @param   string   $url        URL to the api system
	 *                                  example: https://api.joomlacomponentbuilder.com
	 * @param   string   $endpoint   Endpoint to the gitea system
	 * @param   string   $version    Version to the gitea system
	 *
	 * @since   3.2.0
	 **/
	public function __construct(
		string $url = 'https://api.joomlacomponentbuilder.com',
		string $version  =  'v1')
	{
		// set the API details
		$this->setUrl($url);
		$this->setVersion($version);
	}

	/**
	 * Method to build and return a full request URL for the request.  This method will
	 * add appropriate pagination details if necessary and also prepend the API url
	 * to have a complete URL for the request.
	 *
	 * @param   string   $path   URL to inflect
	 *
	 * @return  JoomlaUri
	 * @since   3.2.0
	 **/
	public function get(string $path): JoomlaUri
	{
		// Get a new Uri object focusing the api url and given path.
		$uri = new JoomlaUri($this->api() . $path);

		return $uri;
	}

	/**
	 * Get the full API URL
	 *
	 * @return  string
	 * @since   3.2.0
	 **/
	public function api(): string
	{
		return $this->url . '/' . $this->version;
	}

	/**
	 * Set the URL of the API
	 *
	 * @param   string   $url   URL to your gitea system
	 *                              example: https://api.joomlacomponentbuilder.com
	 *
	 * @return  void
	 * @since   3.2.0
	 **/
	public function setUrl(string $url)
	{
		$this->url = $url;
	}

	/**
	 * Get the URL of the API
	 *
	 * @return  string|null
	 * @since   3.2.0
	 **/
	public function getUrl(): ?string
	{
		return $this->url ?? null;
	}

	/**
	 * Set the version of the API
	 *
	 * @param   string   $version   version to your gitea API
	 *
	 * @return  void
	 * @since   3.2.0
	 **/
	private function setVersion($version)
	{
		$this->version = $version;
	}
}

