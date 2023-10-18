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


/**
 * The Gitea Api
 * 
 * @since 3.2.0
 */
abstract class Api
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
	 * @param   string|null        $url          The url.
	 * @param   token|null        $token      The token.
	 *
	 * @return  void
	 * @since   3.2.0
	 **/
	public function load_(?string $url = null, ?string $token = null)
	{
		if ($url !== null)
		{
			$this->uri->setUrl($url);
		}

		if ($token !== null)
		{
			$this->http->setToken($token);
		}
	}

}

