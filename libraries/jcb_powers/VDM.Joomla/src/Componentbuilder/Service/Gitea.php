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
use VDM\Joomla\Gitea\Utilities\Uri;
use VDM\Joomla\Gitea\Utilities\Http;


/**
 * The Gitea Utilities Service
 * 
 * @since 3.2.0
 */
class Gitea implements ServiceProviderInterface
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
		$container->alias(Uri::class, 'Gitea.Dynamic.Uri')
			->share('Gitea.Dynamic.Uri', [$this, 'getUri'], true);

		$container->alias(Http::class, 'Gitea.Utilities.Http')
			->share('Gitea.Utilities.Http', [$this, 'getHttp'], true);
	}

	/**
	 * Get the Dynamic Uri class
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Uri
	 * @since 3.2.0
	 */
	public function getUri(Container $container): Uri
	{
		// get the global gitea URL
		$add_gitea_url = $container->get('Config')->get('add_custom_gitea_url', 1);
		$gitea_url = $container->get('Config')->get('custom_gitea_url');

		// only load this if we have a custom URL set
		if ($add_gitea_url == 2 && is_string($gitea_url) && strpos($gitea_url, 'http') !== false)
		{
			return new Uri($gitea_url);
		}

		return $container->get('Gitea.Utilities.Uri');
	}

	/**
	 * Get the Http class
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Http
	 * @since 3.2.0
	 */
	public function getHttp(Container $container): Http
	{
		return new Http(
			$container->get('Config')->get('gitea_token')
		);
	}

}

