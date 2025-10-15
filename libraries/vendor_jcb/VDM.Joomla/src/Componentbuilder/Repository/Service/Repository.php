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

namespace VDM\Joomla\Componentbuilder\Repository\Service;


use Joomla\DI\Container;
use Joomla\DI\ServiceProviderInterface;
use VDM\Joomla\Componentbuilder\Repository\Config;
use VDM\Joomla\Componentbuilder\Repository\Grep;
use VDM\Joomla\Componentbuilder\Repository\Remote\Config as RemoteConfig;
use VDM\Joomla\Componentbuilder\Package\Dependency\Resolver;
use VDM\Joomla\Componentbuilder\Remote\Get;
use VDM\Joomla\Componentbuilder\Remote\Set;
use VDM\Joomla\Componentbuilder\Repository\Readme\Item as ItemReadme;
use VDM\Joomla\Componentbuilder\Repository\Readme\Main as MainReadme;


/**
 * Repository Service Provider
 * 
 * @since  5.1.1
 */
class Repository implements ServiceProviderInterface
{
	/**
	 * Registers the service provider with a DI container.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  void
	 * @since   5.1.1
	 */
	public function register(Container $container)
	{
		$container->alias(Config::class, 'Repository.Config')->alias('Config', 'Repository.Config')
			->share('Repository.Config', [$this, 'getConfig'], true);

		$container->alias(Grep::class, 'Repository.Grep')
			->share('Repository.Grep', [$this, 'getGrep'], true);

		$container->alias(RemoteConfig::class, 'Repository.Remote.Config')
			->share('Repository.Remote.Config', [$this, 'getRemoteConfig'], true);

		$container->alias(Resolver::class, 'Repository.Resolver')
			->share('Repository.Resolver', [$this, 'getResolver'], true);

		$container->alias(Get::class, 'Repository.Remote.Get')
			->share('Repository.Remote.Get', [$this, 'getRepositoryGet'], true);

		$container->alias(Set::class, 'Repository.Remote.Set')
			->share('Repository.Remote.Set', [$this, 'getRepositorySet'], true);

		$container->alias(ItemReadme::class, 'Repository.Readme.Item')
			->share('Repository.Readme.Item', [$this, 'getItemReadme'], true);

		$container->alias(MainReadme::class, 'Repository.Readme.Main')
			->share('Repository.Readme.Main', [$this, 'getMainReadme'], true);
	}

	/**
	 * Get The Config Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Config
	 * @since   5.1.1
	 */
	public function getConfig(Container $container): Config
	{
		return new Config();
	}

	/**
	 * Get The Grep Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Grep
	 * @since   5.1.1
	 */
	public function getGrep(Container $container): Grep
	{
		return new Grep(
			$container->get('Repository.Remote.Config'),
			$container->get('Git.Repository.Contents'),
			$container->get('Network.Resolve'),
			$container->get('Power.Tracker'),
			$container->get('Repository.Config')->approved_joomla_paths
		);
	}

	/**
	 * Get The Remote Configure Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  RemoteConfig
	 * @since  5.1.1
	 */
	public function getRemoteConfig(Container $container): RemoteConfig
	{
		return new RemoteConfig(
			$container->get('Power.Table')
		);
	}

	/**
	 * Get The Resolver Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Resolver
	 * @since 5.1.1
	 */
	public function getResolver(Container $container): Resolver
	{
		return new Resolver(
			$container->get('Repository.Remote.Config'),
			$container->get('Utilities.Normalize'),
			$container->get('Power.Tracker'),
			$container->get('Power.Table'),
			$container->get('Load'),
			$container->get('Data.Items')
		);
	}

	/**
	 * Get The Remote Get Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Get
	 * @since   5.1.1
	 */
	public function getRepositoryGet(Container $container): Get
	{
		return new Get(
			$container->get('Repository.Remote.Config'),
			$container->get('Repository.Grep'),
			$container->get('Data.Item'),
			$container->get('Power.Tracker'),
			$container->get('Power.Message')
		);
	}

	/**
	 * Get The Remote Set Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Set
	 * @since   5.1.1
	 */
	public function getRepositorySet(Container $container): Set
	{
		return new Set(
			$container->get('Power.Tracker'),
			$container->get('Power.Message'),
			$container->get('Repository.Grep'),
			$container->get('Repository.Resolver'),
			$container->get('Repository.Remote.Config'),
			$container->get('Repository.Readme.Item'),
			$container->get('Repository.Readme.Main'),
			$container->get('Git.Repository.Contents'),
			$container->get('Data.Items'),
			$container->get('Repository.Config')->approved_joomla_paths
		);
	}

	/**
	 * Get The Item Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  ItemReadme
	 * @since   5.1.1
	 */
	public function getItemReadme(Container $container): ItemReadme
	{
		return new ItemReadme();
	}

	/**
	 * Get The Main Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  MainReadme
	 * @since   5.1.1
	 */
	public function getMainReadme(Container $container): MainReadme
	{
		return new MainReadme();
	}
}

