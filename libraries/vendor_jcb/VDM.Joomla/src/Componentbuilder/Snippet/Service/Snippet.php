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

namespace VDM\Joomla\Componentbuilder\Snippet\Service;


use Joomla\DI\Container;
use Joomla\DI\ServiceProviderInterface;
use VDM\Joomla\Componentbuilder\Snippet\Config;
use VDM\Joomla\Componentbuilder\Snippet\Grep;
use VDM\Joomla\Componentbuilder\Snippet\Remote\Config as RemoteConfig;
use VDM\Joomla\Componentbuilder\Package\Dependency\Resolver;
use VDM\Joomla\Componentbuilder\Remote\Get;
use VDM\Joomla\Componentbuilder\Remote\Set;
use VDM\Joomla\Componentbuilder\Snippet\Builder\Entities;
use VDM\Joomla\Componentbuilder\Package\Builder\Set as BuilderSet;
use VDM\Joomla\Componentbuilder\Package\Builder\Get as BuilderGet;
use VDM\Joomla\Componentbuilder\Snippet\Readme\Item as ItemReadme;
use VDM\Joomla\Componentbuilder\Snippet\Readme\Main as MainReadme;
use VDM\Joomla\Componentbuilder\SnippetType\Remote\Config as SnippetType;


/**
 * Snippet Service Provider
 * 
 * @since  5.1.1
 */
class Snippet implements ServiceProviderInterface
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
		$container->alias(Config::class, 'Snippet.Config')->alias('Config', 'Snippet.Config')
			->share('Snippet.Config', [$this, 'getConfig'], true);

		$container->alias(Grep::class, 'Snippet.Grep')
			->share('Snippet.Grep', [$this, 'getGrep'], true);

		$container->alias(RemoteConfig::class, 'Snippet.Remote.Config')
			->share('Snippet.Remote.Config', [$this, 'getRemoteConfig'], true);

		$container->alias(Resolver::class, 'Snippet.Resolver')
			->share('Snippet.Resolver', [$this, 'getResolver'], true);

		$container->alias(Get::class, 'Snippet.Remote.Get')
			->share('Snippet.Remote.Get', [$this, 'getSnippetGet'], true);

		$container->alias(Set::class, 'Snippet.Remote.Set')
			->share('Snippet.Remote.Set', [$this, 'getSnippetSet'], true);

		$container->alias(Entities::class, 'Snippet.Entities')
			->share('Snippet.Entities', [$this, 'getSnippetEntities'], true);

		$container->alias(BuilderSet::class, 'Package.Builder.Set')
			->share('Package.Builder.Set', [$this, 'getBuilderSet'], true);

		$container->alias(BuilderGet::class, 'Package.Builder.Get')
			->share('Package.Builder.Get', [$this, 'getBuilderGet'], true);

		$container->alias(ItemReadme::class, 'Snippet.Readme.Item')
			->share('Snippet.Readme.Item', [$this, 'getItemReadme'], true);

		$container->alias(MainReadme::class, 'Snippet.Readme.Main')
			->share('Snippet.Readme.Main', [$this, 'getMainReadme'], true);

		$container->alias(Grep::class, 'SnippetType.Grep')
			->share('SnippetType.Grep', [$this, 'getSnippetTypeGrep'], true);

		$container->alias(SnippetType::class, 'SnippetType.Remote.Config')
			->share('SnippetType.Remote.Config', [$this, 'getSnippetTypeRemoteConfig'], true);

		$container->alias(Resolver::class, 'SnippetType.Resolver')
			->share('SnippetType.Resolver', [$this, 'getSnippetTypeResolver'], true);

		$container->alias(Get::class, 'SnippetType.Remote.Get')
			->share('SnippetType.Remote.Get', [$this, 'getSnippetTypeRemoteGet'], true);

		$container->alias(Set::class, 'SnippetType.Remote.Set')
			->share('SnippetType.Remote.Set', [$this, 'getSnippetTypeRemoteSet'], true);
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
			$container->get('Snippet.Remote.Config'),
			$container->get('Git.Repository.Contents'),
			$container->get('Network.Resolve'),
			$container->get('Power.Tracker'),
			$container->get('Snippet.Config')->approved_joomla_paths
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
			$container->get('Snippet.Remote.Config'),
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
	public function getSnippetGet(Container $container): Get
	{
		return new Get(
			$container->get('Snippet.Remote.Config'),
			$container->get('Snippet.Grep'),
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
	public function getSnippetSet(Container $container): Set
	{
		return new Set(
			$container->get('Power.Tracker'),
			$container->get('Power.Message'),
			$container->get('Snippet.Grep'),
			$container->get('Snippet.Resolver'),
			$container->get('Snippet.Remote.Config'),
			$container->get('Snippet.Readme.Item'),
			$container->get('Snippet.Readme.Main'),
			$container->get('Git.Repository.Contents'),
			$container->get('Data.Items'),
			$container->get('Snippet.Config')->approved_joomla_paths
		);
	}

	/**
	 * Get The Entities Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Entities
	 * @since   5.1.1
	 */
	public function getSnippetEntities(Container $container): Entities
	{
		return new Entities();
	}

	/**
	 * Get The Builder Set Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  BuilderSet
	 * @since   5.1.1
	 */
	public function getBuilderSet(Container $container): BuilderSet
	{
		return new BuilderSet(
			$container->get('Snippet.Entities'),
			$container->get('Power.Tracker'),
			$container,
		);
	}

	/**
	 * Get The Builder Get Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  BuilderGet
	 * @since   5.1.1
	 */
	public function getBuilderGet(Container $container): BuilderGet
	{
		return new BuilderGet(
			$container->get('Snippet.Entities'),
			$container->get('Power.Tracker'),
			$container,
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

	/**
	 * Get The Grep Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Grep
	 * @since   5.1.1
	 */
	public function getSnippetTypeGrep(Container $container): Grep
	{
		return new Grep(
			$container->get('SnippetType.Remote.Config'),
			$container->get('Git.Repository.Contents'),
			$container->get('Network.Resolve'),
			$container->get('Power.Tracker'),
			$container->get('Snippet.Config')->approved_joomla_paths
		);
	}

	/**
	 * Get The Remote Configure Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  SnippetType
	 * @since  5.1.1
	 */
	public function getSnippetTypeRemoteConfig(Container $container): SnippetType
	{
		return new SnippetType(
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
	public function getSnippetTypeResolver(Container $container): Resolver
	{
		return new Resolver(
			$container->get('SnippetType.Remote.Config'),
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
	public function getSnippetTypeRemoteGet(Container $container): Get
	{
		return new Get(
			$container->get('SnippetType.Remote.Config'),
			$container->get('SnippetType.Grep'),
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
	public function getSnippetTypeRemoteSet(Container $container): Set
	{
		return new Set(
			$container->get('Power.Tracker'),
			$container->get('Power.Message'),
			$container->get('SnippetType.Grep'),
			$container->get('SnippetType.Resolver'),
			$container->get('SnippetType.Remote.Config'),
			$container->get('Snippet.Readme.Item'),
			$container->get('Snippet.Readme.Main'),
			$container->get('Git.Repository.Contents'),
			$container->get('Data.Items'),
			$container->get('Snippet.Config')->approved_joomla_paths
		);
	}
}

