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

namespace VDM\Joomla\Gitea\Abstraction;


use VDM\Joomla\Gitea\Utilities\Http;
use VDM\Joomla\Gitea\Utilities\Uri;
use VDM\Joomla\Gitea\Utilities\Response;
use VDM\Joomla\Interfaces\Git\ApiInterface;


/**
 * The Gitea Api
 * 
 * @since 3.2.0
 */
abstract class Api implements ApiInterface
{
	/**
	 * The Http class
	 *
	 * @var    Http
	 * @since 3.2.0
	 */
	protected Http $http;

	/**
	 * The Uri class
	 *
	 * @var    Uri
	 * @since 3.2.0
	 */
	protected Uri $uri;

	/**
	 * The Response class
	 *
	 * @var    Response
	 * @since 3.2.0
	 */
	protected Response $response;

	/**
	 * The Url string
	 *
	 * @var    string|null
	 * @since 3.2.0
	 */
	protected ?string $url = null;

	/**
	 * The token string
	 *
	 * @var    string|null
	 * @since 3.2.0
	 */
	protected ?string $token = null;

	/**
	 * Constructor.
	 *
	 * @param   Http        $http       The http class.
	 * @param   Uri         $uri        The uri class.
	 * @param   Response    $response   The response class.
	 *
	 * @since   3.2.0
	 **/
	public function __construct(Http $http, Uri $uri, Response $response)
	{
		$this->http = $http;
		$this->uri = $uri;
		$this->response = $response;
	}

	/**
	 * Load/Reload API.
	 *
	 * @param   string|null     $url          The url.
	 * @param   token|null     $token      The token.
	 * @param   bool             $backup   The backup swapping switch.
	 *
	 * @return  void
	 * @since   3.2.0
	 **/
	public function load_(?string $url = null, ?string $token = null, bool $backup = true): void
	{
		// we keep the old values
		// so we can reset after our call
		// for the rest of the container
		if ($backup)
		{
			if ($url !== null)
			{
				$this->url = $this->uri->getUrl();
			}

			if ($token !== null)
			{
				$this->token = $this->http->getToken();
			}
		}

		if ($url !== null)
		{
			$this->uri->setUrl($url);
		}

		if ($token !== null)
		{
			$this->http->setToken($token);
		}
	}

	/**
	 * Reset to previous toke, url it set
	 *
	 * @return  void
	 * @since   3.2.0
	 **/
	public function reset_(): void
	{
		if ($this->url !== null)
		{
			$this->uri->setUrl($this->url);
			$this->url = null;
		}

		if ($this->token !== null)
		{
			$this->http->setToken($this->token);
			$this->token = null;
		}
	}

	/**
	 * Get the API url
	 *
	 * @return  string
	 * @since   3.2.0
	 **/
	public function api()
	{
		return $this->uri->api();
	}
}

