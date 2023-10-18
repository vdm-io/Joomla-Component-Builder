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

namespace VDM\Joomla\Openai\Utilities;


use Joomla\Uri\Uri as JoomlaUri;


/**
 * The Openai Uri
 * 
 * @since 3.2.0
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
	 * @param   string   $url        URL to the openai system
	 *                                  example: https://api.openai.com
	 * @param   string   $version    Version to the openai system
	 *
	 * @since   3.2.0
	 **/
	public function __construct(
		string $url = 'https://api.openai.com',
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
	 * @param   string   $url   URL to your openai system
	 *                              example: https://api.openai.com
	 *
	 * @return  void
	 * @since   3.2.0
	 **/
	private function setUrl(string $url)
	{
		return $this->url = $url;
	}

	/**
	 * Set the version of the API
	 *
	 * @param   string   $version   version to your openai API
	 *
	 * @return  void
	 * @since   3.2.0
	 **/
	private function setVersion($version)
	{
		return $this->version = $version;
	}
}

