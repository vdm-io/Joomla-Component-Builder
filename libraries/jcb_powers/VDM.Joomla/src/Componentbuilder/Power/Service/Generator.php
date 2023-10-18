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

namespace VDM\Joomla\Componentbuilder\Power\Service;


use Joomla\DI\Container;
use Joomla\DI\ServiceProviderInterface;
use VDM\Joomla\Componentbuilder\Power\Generator as PowerGenerator;
use VDM\Joomla\Componentbuilder\Power\Generator\ClassInjectorBuilder;
use VDM\Joomla\Componentbuilder\Power\Generator\ServiceProviderBuilder;
use VDM\Joomla\Componentbuilder\Power\Generator\Search;
use VDM\Joomla\Componentbuilder\Power\Generator\ClassInjector;
use VDM\Joomla\Componentbuilder\Power\Generator\ServiceProvider;
use VDM\Joomla\Componentbuilder\Power\Generator\Bucket;


/**
 * Generator Service Provider
 * 
 * @since 3.2.0
 */
class Generator implements ServiceProviderInterface
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
		$container->alias(PowerGenerator::class, 'Power.Generator')
			->share('Power.Generator', [$this, 'getGenerator'], true);

		$container->alias(ClassInjectorBuilder::class, 'Power.Generator.Class.Injector.Builder')
			->share('Power.Generator.Class.Injector.Builder', [$this, 'getClassInjectorBuilder'], true);

		$container->alias(ServiceProviderBuilder::class, 'Power.Generator.Service.Provider.Builder')
			->share('Power.Generator.Service.Provider.Builder', [$this, 'getServiceProviderBuilder'], true);

		$container->alias(Search::class, 'Power.Generator.Search')
			->share('Power.Generator.Search', [$this, 'getSearch'], true);

		$container->alias(ClassInjector::class, 'Power.Generator.Class.Injector')
			->share('Power.Generator.Class.Injector', [$this, 'getClassInjector'], true);

		$container->alias(ServiceProvider::class, 'Power.Generator.Service.Provider')
			->share('Power.Generator.Service.Provider', [$this, 'getServiceProvider'], true);

		$container->alias(Bucket::class, 'Power.Generator.Bucket')
			->share('Power.Generator.Bucket', [$this, 'getBucket'], true);
	}

	/**
	 * Get the Generator
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  PowerGenerator
	 * @since 3.2.0
	 */
	public function getGenerator(Container $container): PowerGenerator
	{
		return new PowerGenerator(
			$container->get('Power.Generator.Class.Injector.Builder'),
			$container->get('Power.Generator.Service.Provider.Builder')
		);
	}

	/**
	 * Get the Generator Class Injector Builder
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  ClassInjectorBuilder
	 * @since 3.2.0
	 */
	public function getClassInjectorBuilder(Container $container): ClassInjectorBuilder
	{
		return new ClassInjectorBuilder(
			$container->get('Power.Generator.Search'),
			$container->get('Power.Generator.Class.Injector')
		);
	}

	/**
	 * Get the Generator Service Provider Builder
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  ServiceProviderBuilder
	 * @since 3.2.0
	 */
	public function getServiceProviderBuilder(Container $container): ServiceProviderBuilder
	{
		return new ServiceProviderBuilder(
			$container->get('Power.Generator.Search'),
			$container->get('Power.Generator.Service.Provider')
		);
	}

	/**
	 * Get the Generator Search
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Search
	 * @since 3.2.0
	 */
	public function getSearch(Container $container): Search
	{
		return new Search(
			$container->get('Power.Database.Load'),
			$container->get('Power.Parser'),
			$container->get('Power.Generator.Bucket')
		);
	}

	/**
	 * Get the Generator Class Injector
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  ClassInjector
	 * @since 3.2.0
	 */
	public function getClassInjector(Container $container): ClassInjector
	{
		return new ClassInjector();
	}

	/**
	 * Get the Generator Service Provider
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  ServiceProvider
	 * @since 3.2.0
	 */
	public function getServiceProvider(Container $container): ServiceProvider
	{
		return new ServiceProvider();
	}

	/**
	 * Get the Generator Bucket
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Bucket
	 * @since 3.2.0
	 */
	public function getBucket(Container $container): Bucket
	{
		return new Bucket();
	}
}

