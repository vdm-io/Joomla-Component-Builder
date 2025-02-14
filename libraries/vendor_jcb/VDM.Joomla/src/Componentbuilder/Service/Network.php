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
use VDM\Joomla\Componentbuilder\Network\Resolve;
use VDM\Joomla\Componentbuilder\Network\Status;
use VDM\Joomla\Componentbuilder\Network\Url;
use VDM\Joomla\Componentbuilder\Network\Core;
use VDM\Joomla\Componentbuilder\Network\ParsedUrls;


/**
 * The Joomla Component Builder Network Service
 * 
 * @since 5.0.4
 */
class Network implements ServiceProviderInterface
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
		$container->alias(Resolve::class, 'Network.Resolve')
			->share('Network.Resolve', [$this, 'getResolve'], true);

		$container->alias(Status::class, 'Network.Status')
			->share('Network.Status', [$this, 'getStatus'], true);

		$container->alias(Url::class, 'Network.Url')
			->share('Network.Url', [$this, 'getUrl'], true);

		$container->alias(Core::class, 'Network.Core')
			->share('Network.Core', [$this, 'getCore'], true);

		$container->alias(ParsedUrls::class, 'Network.Parsed.Urls')
			->share('Network.Parsed.Urls', [$this, 'getParsedUrls'], true);
	}

	/**
	 * Get The Resolve Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Resolve
	 * @since 5.0.4
	 */
	public function getResolve(Container $container): Resolve
	{
		return new Resolve(
			$container->get('Network.Url'),
			$container->get('Network.Status')
		);
	}

	/**
	 * Get The Status Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Status
	 * @since 5.0.4
	 */
	public function getStatus(Container $container): Status
	{
		return new Status(
			$container->get('Api.Network'),
			$container->get('Network.Core'),
			$container->get('Network.Url')
		);
	}

	/**
	 * Get The Url Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Url
	 * @since 5.0.4
	 */
	public function getUrl(Container $container): Url
	{
		return new Url(
			$container->get('Network.Parsed.Urls')
		);
	}

	/**
	 * Get The Core Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Core
	 * @since 5.0.4
	 */
	public function getCore(Container $container): Core
	{
		return new Core();
	}

	/**
	 * Get The ParsedUrls Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  ParsedUrls
	 * @since 5.0.4
	 */
	public function getParsedUrls(Container $container): ParsedUrls
	{
		return new ParsedUrls();
	}
}

