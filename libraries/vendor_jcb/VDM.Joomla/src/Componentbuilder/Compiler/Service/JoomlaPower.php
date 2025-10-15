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
use VDM\Joomla\Componentbuilder\Compiler\JoomlaPower as Powers;
use VDM\Joomla\Componentbuilder\JoomlaPower\Grep;
use VDM\Joomla\Componentbuilder\JoomlaPower\Remote\Config;
use VDM\Joomla\Componentbuilder\Remote\Get;
use VDM\Joomla\Componentbuilder\Compiler\JoomlaPower\Extractor;
use VDM\Joomla\Componentbuilder\Compiler\JoomlaPower\Injector;


/**
 * Compiler Joomla Power Service Provider
 * 
 * @since 3.2.0
 */
class JoomlaPower implements ServiceProviderInterface
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
		$container->alias(Powers::class, 'Joomla.Power')
			->share('Joomla.Power', [$this, 'getPowers'], true);

		$container->alias(Config::class, 'Joomla.Power.Remote.Config')
			->share('Joomla.Power.Remote.Config', [$this, 'getRemoteConfig'], true);

		$container->alias(Get::class, 'Joomla.Power.Remote.Get')
			->share('Joomla.Power.Remote.Get', [$this, 'getRemoteGet'], true);

		$container->alias(Grep::class, 'Joomla.Power.Grep')
			->share('Joomla.Power.Grep', [$this, 'getGrep'], true);

		$container->alias(Extractor::class, 'Joomla.Power.Extractor')
			->share('Joomla.Power.Extractor', [$this, 'getExtractor'], true);

		$container->alias(Injector::class, 'Joomla.Power.Injector')
			->share('Joomla.Power.Injector', [$this, 'getInjector'], true);
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
			$container->get('Customcode.Gui'),
			$container->get('Joomla.Power.Remote.Get'),
			$container->get('Joomla.Database')
		);
	}

	/**
	 * Get The Remote Config Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Config
	 * @since  5.1.1
	 */
	public function getRemoteConfig(Container $container): Config
	{
		return new Config(
			$container->get('Power.Table')
		);
	}

	/**
	 * Get the Remote Get
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Get
	 * @since 3.2.0
	 */
	public function getRemoteGet(Container $container): Get
	{
		return new Get(
			$container->get('Joomla.Power.Remote.Config'),
			$container->get('Joomla.Power.Grep'),
			$container->get('Data.Item'),
			$container->get('Power.Tracker'),
			$container->get('Power.Message')
		);
	}

	/**
	 * Get the Grep
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Grep
	 * @since 3.2.0
	 */
	public function getGrep(Container $container): Grep
	{
		return new Grep(
			$container->get('Joomla.Power.Remote.Config'),
			$container->get('Git.Repository.Contents'),
			$container->get('Network.Resolve'),
			$container->get('Power.Tracker'),
			$container->get('Config')->approved_joomla_paths
		);
	}

	/**
	 * Get the Compiler Power Extractor
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Extractor
	 * @since 3.2.0
	 */
	public function getExtractor(Container $container): Extractor
	{
		return new Extractor(
			$container->get('Joomla.Database'),
			$container->get('Config')->joomla_version
		);
	}

	/**
	 * Get the Compiler Power Injector
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Injector
	 * @since 3.2.0
	 */
	public function getInjector(Container $container): Injector
	{
		return new Injector(
			$container->get('Joomla.Power'),
			$container->get('Joomla.Power.Extractor'),
			$container->get('Power.Parser'),
			$container->get('Placeholder')
		);
	}
}

