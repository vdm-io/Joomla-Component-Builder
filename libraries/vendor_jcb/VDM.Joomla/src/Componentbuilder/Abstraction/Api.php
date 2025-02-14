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

namespace VDM\Joomla\Componentbuilder\Abstraction;


use VDM\Joomla\Componentbuilder\Utilities\Http;
use VDM\Joomla\Componentbuilder\Utilities\Uri;
use VDM\Joomla\Componentbuilder\Utilities\Response;


/**
 * The Joomla Component Builder Api
 * 
 * @since 5.0.4
 */
abstract class Api
{
	/**
	 * The Http Class.
	 *
	 * @var   Http
	 * @since 5.0.4
	 */
	protected Http $http;

	/**
	 * The Uri Class.
	 *
	 * @var   Uri
	 * @since 5.0.4
	 */
	protected Uri $uri;

	/**
	 * The Response Class.
	 *
	 * @var   Response
	 * @since 5.0.4
	 */
	protected Response $response;

	/**
	 * Constructor.
	 *
	 * @param Http       $http       The Http Class.
	 * @param Uri        $uri        The Uri Class.
	 * @param Response   $response   The Response Class.
	 *
	 * @since 5.0.4
	 */
	public function __construct(Http $http, Uri $uri, Response $response)
	{
		$this->http = $http;
		$this->uri = $uri;
		$this->response = $response;
	}
}

