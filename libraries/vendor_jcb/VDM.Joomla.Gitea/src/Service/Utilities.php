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

namespace VDM\Joomla\Gitea\Service;


use Joomla\DI\Container;
use Joomla\DI\ServiceProviderInterface;
use VDM\Joomla\Gitea\Utilities\Uri;
use VDM\Joomla\Gitea\Utilities\Response;


/**
 * The Gitea Utilities Service
 * 
 * @since 3.2.0
 */
class Utilities implements ServiceProviderInterface
{
	/**
	 * Registers the service provider with a DI container.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function register(Container $container)
	{
		$container->alias(Uri::class, 'Gitea.Utilities.Uri')
			->share('Gitea.Utilities.Uri', [$this, 'getUri'], true);

		$container->alias(Response::class, 'Gitea.Utilities.Response')
			->share('Gitea.Utilities.Response', [$this, 'getResponse'], true);
	}

	/**
	 * Get the Uri class
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Uri
	 * @since 3.2.0
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
	 * @since 3.2.0
	 */
	public function getResponse(Container $container): Response
	{
		return new Response();
	}
}

