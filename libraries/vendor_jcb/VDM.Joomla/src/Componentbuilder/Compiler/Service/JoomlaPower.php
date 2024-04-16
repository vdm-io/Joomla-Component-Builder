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
use VDM\Joomla\Componentbuilder\JoomlaPower\Super as Superpower;
use VDM\Joomla\Componentbuilder\Compiler\JoomlaPower\Extractor;
use VDM\Joomla\Componentbuilder\Compiler\JoomlaPower\Injector;
use VDM\Joomla\Componentbuilder\JoomlaPower\Model\Upsert;
use VDM\Joomla\Componentbuilder\JoomlaPower\Database\Insert;
use VDM\Joomla\Componentbuilder\JoomlaPower\Database\Update;


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

		$container->alias(Superpower::class, 'Joomlapower')
			->share('Joomlapower', [$this, 'getSuperpower'], true);

		$container->alias(Grep::class, 'Joomla.Power.Grep')
			->share('Joomla.Power.Grep', [$this, 'getGrep'], true);

		$container->alias(Extractor::class, 'Joomla.Power.Extractor')
			->share('Joomla.Power.Extractor', [$this, 'getExtractor'], true);

		$container->alias(Injector::class, 'Joomla.Power.Injector')
			->share('Joomla.Power.Injector', [$this, 'getInjector'], true);

		$container->alias(Upsert::class, 'Joomla.Power.Model.Upsert')
			->share('Joomla.Power.Model.Upsert', [$this, 'getModelUpsert'], true);

		$container->alias(Insert::class, 'Joomla.Power.Insert')
			->share('Joomla.Power.Insert', [$this, 'getInsert'], true);

		$container->alias(Update::class, 'Joomla.Power.Update')
			->share('Joomla.Power.Update', [$this, 'getUpdate'], true);
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
			$container->get('Joomlapower')
		);
	}

	/**
	 * Get the Superpower
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Superpower
	 * @since 3.2.0
	 */
	public function getSuperpower(Container $container): Superpower
	{
		return new Superpower(
			$container->get('Joomla.Power.Grep'),
			$container->get('Joomla.Power.Insert'),
			$container->get('Joomla.Power.Update')
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
			$container->get('Config')->local_joomla_powers_repository_path,
			$container->get('Config')->approved_joomla_paths,
			$container->get('Gitea.Repository.Contents')
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

	/**
	 * Get the Power Model Upsert
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Upsert
	 * @since 3.2.0
	 */
	public function getModelUpsert(Container $container): Upsert
	{
		return new Upsert(
			$container->get('Table')
		);
	}

	/**
	 * Get the Power Insert
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Insert
	 * @since 3.2.0
	 */
	public function getInsert(Container $container): Insert
	{
		return new Insert(
			$container->get('Joomla.Power.Model.Upsert'),
			$container->get('Insert')
		);
	}

	/**
	 * Get the Power Update
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Update
	 * @since 3.2.0
	 */
	public function getUpdate(Container $container): Update
	{
		return new Update(
			$container->get('Joomla.Power.Model.Upsert'),
			$container->get('Update')
		);
	}
}

