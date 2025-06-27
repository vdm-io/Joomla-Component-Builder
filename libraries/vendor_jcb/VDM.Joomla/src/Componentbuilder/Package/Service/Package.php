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

namespace VDM\Joomla\Componentbuilder\Package\Service;


use Joomla\DI\Container;
use Joomla\DI\ServiceProviderInterface;
use VDM\Joomla\Componentbuilder\Package\Config;
use VDM\Joomla\Componentbuilder\Package\Builder\Entities;
use VDM\Joomla\Componentbuilder\Package\Builder\Get;
use VDM\Joomla\Componentbuilder\Package\Builder\Set;


/**
 * Package Service Provider
 * 
 * @since 5.1.1
 */
class Package implements ServiceProviderInterface
{
	/**
	 * Registers the service provider with a DI container.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  void
	 * @since 5.1.1
	 */
	public function register(Container $container)
	{
		$container->alias(Config::class, 'Package.Config')->alias('Config', 'Package.Config')
			->share('Package.Config', [$this, 'getConfig'], true);

		$container->alias(Entities::class, 'Package.Entities')
			->share('Package.Entities', [$this, 'getBuilderEntities'], true);

		$container->alias(Set::class, 'Package.Builder.Set')
			->share('Package.Builder.Set', [$this, 'getBuilderSet'], true);

		$container->alias(Set::class, 'Package.Builder.Get')
			->share('Package.Builder.Get', [$this, 'getBuilderGet'], true);
	}

	/**
	 * Get The Config Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Config
	 * @since 5.1.1
	 */
	public function getConfig(Container $container): Config
	{
		return new Config();
	}

	/**
	 * Get The Entities Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Entities
	 * @since   5.1.1
	 */
	public function getBuilderEntities(Container $container): Entities
	{
		return new Entities();
	}

	/**
	 * Get The Builder Set Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Set
	 * @since   5.1.1
	 */
	public function getBuilderSet(Container $container): Set
	{
		return new Set(
			$container->get('Package.Entities'),
			$container->get('Power.Tracker'),
			$container,
		);
	}

	/**
	 * Get The Builder Get Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Get
	 * @since   5.1.1
	 */
	public function getBuilderGet(Container $container): Get
	{
		return new Get(
			$container->get('Package.Entities'),
			$container->get('Power.Tracker'),
			$container,
		);
	}
}

