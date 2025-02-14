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

namespace VDM\Joomla\Componentbuilder\Service;


use Joomla\DI\Container;
use Joomla\DI\ServiceProviderInterface;
use VDM\Joomla\Componentbuilder\Utilities\Uri;
use VDM\Joomla\Componentbuilder\Utilities\Http;
use VDM\Joomla\Componentbuilder\Utilities\Response;


/**
 * The Joomla Component Builder Utilities Service
 * 
 * @since 5.0.4
 */
class Utilities implements ServiceProviderInterface
{
	/**
	 * Registers the service provider with a DI container.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  void
	 * @since 5.0.4
	 */
	public function register(Container $container)
	{
		$container->alias(Uri::class, 'Utilities.Uri')
			->share('Utilities.Uri', [$this, 'getUri'], true);

		$container->alias(Http::class, 'Utilities.Http')
			->share('Utilities.Http', [$this, 'getHttp'], true);

		$container->alias(Response::class, 'Utilities.Response')
			->share('Utilities.Response', [$this, 'getResponse'], true);
	}

	/**
	 * Get The Uri Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Uri
	 * @since 5.0.4
	 */
	public function getUri(Container $container): Uri
	{
		return new Uri();
	}

	/**
	 * Get The Http Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Http
	 * @since 5.0.4
	 */
	public function getHttp(Container $container): Http
	{
		return new Http();
	}

	/**
	 * Get The Response Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Response
	 * @since 5.0.4
	 */
	public function getResponse(Container $container): Response
	{
		return new Response();
	}
}

