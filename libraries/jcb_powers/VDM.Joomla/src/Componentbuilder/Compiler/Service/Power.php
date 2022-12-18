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
use VDM\Joomla\Componentbuilder\Compiler\Power as Powers;
use VDM\Joomla\Componentbuilder\Compiler\Power\Infusion;
use VDM\Joomla\Componentbuilder\Compiler\Power\Autoloader;


/**
 * Compiler Power Service Provider
 * 
 * @since 3.2.0
 */
class Power implements ServiceProviderInterface
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
		$container->alias(Powers::class, 'Power')
			->share('Power', [$this, 'getPowers'], true);

		$container->alias(Autoloader::class, 'Power.Autoloader')
			->share('Power.Autoloader', [$this, 'getAutoloader'], true);

		$container->alias(Infusion::class, 'Power.Infusion')
			->share('Power.Infusion', [$this, 'getInfusion'], true);
	}

	/**
	 * Get the Powers
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Powers
	 * @since 3.2.0
	 */
	public function getPowers(Container $container): Powers
	{
		return new Powers(
			$container->get('Config'),
			$container->get('Placeholder'),
			$container->get('Customcode'),
			$container->get('Customcode.Gui')
		);
	}

	/**
	 * Get the Compiler Autoloader
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Autoloader
	 * @since 3.2.0
	 */
	public function getAutoloader(Container $container): Autoloader
	{
		return new Autoloader(
			$container->get('Power'),
			$container->get('Config'),
			$container->get('Content')
		);
	}

	/**
	 * Get the Compiler Power Infusion
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Infusion
	 * @since 3.2.0
	 */
	public function getInfusion(Container $container): Infusion
	{
		return new Infusion(
			$container->get('Config'),
			$container->get('Power'),
			$container->get('Content'),
			$container->get('Power.Autoloader'),
			$container->get('Placeholder'),
			$container->get('Event')
		);
	}

}

