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

namespace VDM\Joomla\Github\Service;


use Joomla\DI\Container;
use Joomla\DI\ServiceProviderInterface;
use VDM\Joomla\Utilities\Component\Helper;
use VDM\Joomla\Github\Utilities\Http;
use VDM\Joomla\Github\Utilities\Uri;
use VDM\Joomla\Github\Utilities\Response;


/**
 * The Github Utilities Service
 * 
 * @since  5.1.1
 */
class Utilities implements ServiceProviderInterface
{
	/**
	 * Registers the service provider with a DI container.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  void
	 * @since  5.1.1
	 */
	public function register(Container $container)
	{
		$container->alias(Http::class, 'Github.Utilities.Http')
			->share('Github.Utilities.Http', [$this, 'getHttp'], true);

		$container->alias(Uri::class, 'Github.Utilities.Uri')
			->share('Github.Utilities.Uri', [$this, 'getUri'], true);

		$container->alias(Response::class, 'Github.Utilities.Response')
			->share('Github.Utilities.Response', [$this, 'getResponse'], true);
	}

	/**
	 * Get the Http class
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Http
	 * @since  5.1.1
	 */
	public function getHttp(Container $container): Http
	{
		return new Http(
			Helper::getParams('com_componentbuilder')->get('github_access_token') ?? null
		);
	}

	/**
	 * Get the Uri class
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Uri
	 * @since  5.1.1
	 */
	public function getUri(Container $container): Uri
	{
		return new Uri();
	}

	/**
	 * Get the Response class
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Response
	 * @since  5.1.1
	 */
	public function getResponse(Container $container): Response
	{
		return new Response();
	}
}

