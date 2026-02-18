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

namespace VDM\Joomla\Componentbuilder\Compiler\Service;


use Joomla\DI\Container;
use Joomla\DI\ServiceProviderInterface;
use VDM\Joomla\Componentbuilder\Package\Dependency\Tracker;
use VDM\Joomla\Componentbuilder\Package\MessageBus;
use VDM\Joomla\Componentbuilder\Package\Builder\Get;


/**
 * Compiler Package Service Provider
 * 
 * @since 5.1.4
 */
class Package implements ServiceProviderInterface
{
	/**
	 * Registers the service provider with a DI container.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  void
	 * @since   5.1.4
	 */
	public function register(Container $container)
	{
		$container->alias(Tracker::class, 'Package.Tracker')
			->share('Package.Tracker', [$this, 'getTracker'], true);

		$container->alias(MessageBus::class, 'Package.Message')
			->share('Package.Message', [$this, 'getMessageBus'], true);

		$container->alias(Get::class, 'Package.Get')
			->share('Package.Get', [$this, 'getPackageGet'], true);
	}

	/**
	 * Get The Tracker Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Tracker
	 * @since   5.1.4
	 */
	public function getTracker(Container $container): Tracker
	{
		return new Tracker();
	}

	/**
	 * Get The MessageBus Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  MessageBus
	 * @since   5.1.4
	 */
	public function getMessageBus(Container $container): MessageBus
	{
		return new MessageBus();
	}

	/**
	 * Get The POWER Get Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Get
	 * @since   5.1.4
	 */
	public function getPackageGet(Container $container): Get
	{
		return new Get(
			$container->get('Package.Tracker'),
			$container
		);
	}
}

