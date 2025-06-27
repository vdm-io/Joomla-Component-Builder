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
use VDM\Joomla\Componentbuilder\Power\Table;
use VDM\Joomla\Componentbuilder\Package\Dependency\Tracker;
use VDM\Joomla\Componentbuilder\Package\MessageBus;
use VDM\Joomla\Componentbuilder\Utilities\Normalize;


/**
 * Package Power Service Provider
 * 
 * @since 5.1.1
 */
class Power implements ServiceProviderInterface
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
		$container->alias(Table::class, 'Power.Table')->alias('Table', 'Power.Table')
			->share('Power.Table', [$this, 'getPowerTable'], true);

		$container->alias(Tracker::class, 'Power.Tracker')
			->share('Power.Tracker', [$this, 'getPowerTracker'], true);

		$container->alias(MessageBus::class, 'Power.Message')
			->share('Power.Message', [$this, 'getMessageBus'], true);

		$container->alias(Normalize::class, 'Utilities.Normalize')
			->share('Utilities.Normalize', [$this, 'getNormalize'], true);
	}

	/**
	 * Get The Power Table Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Table
	 * @since  5.1.1
	 */
	public function getPowerTable(Container $container): Table
	{
		return new Table();
	}

	/**
	 * Get The Tracker Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Tracker
	 * @since 5.1.1
	 */
	public function getPowerTracker(Container $container): Tracker
	{
		return new Tracker();
	}

	/**
	 * Get The Message Bus Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  MessageBus
	 * @since 5.1.1
	 */
	public function getMessageBus(Container $container): MessageBus
	{
		return new MessageBus();
	}

	/**
	 * Get The Normalize Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Normalize
	 * @since   5.1.1
	 */
	public function getNormalize(Container $container): Normalize
	{
		return new Normalize();
	}
}

