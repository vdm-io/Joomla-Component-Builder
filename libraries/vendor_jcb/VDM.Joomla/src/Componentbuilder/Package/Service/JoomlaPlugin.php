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
use VDM\Joomla\Componentbuilder\Package\Grep;
use VDM\Joomla\Componentbuilder\Package\JoomlaPlugin\Remote\Config;
use VDM\Joomla\Componentbuilder\Package\Dependency\Resolver;
use VDM\Joomla\Componentbuilder\Remote\Get;
use VDM\Joomla\Componentbuilder\Remote\Set;
use VDM\Joomla\Componentbuilder\Package\JoomlaPlugin\Readme\Item as ItemReadme;
use VDM\Joomla\Componentbuilder\Package\JoomlaPlugin\Readme\Main as MainReadme;
use VDM\Joomla\Componentbuilder\Package\JoomlaPluginUpdates\Remote\Config as JoomlaPluginUpdates;
use VDM\Joomla\Componentbuilder\Package\JoomlaPluginFilesFoldersUrls\Remote\Config as JoomlaPluginFilesFoldersUrls;
use VDM\Joomla\Componentbuilder\Package\JoomlaPluginGroup\Remote\Config as JoomlaPluginGroup;


/**
 * Joomla Plugin Service Provider
 * 
 * @since 5.1.1
 */
class JoomlaPlugin implements ServiceProviderInterface
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
		$container->share('JoomlaPlugin.Grep', [$this, 'getGrep'], true);
		$container->share('JoomlaPlugin.Remote.Config', [$this, 'getRemoteConfig'], true);
		$container->share('JoomlaPlugin.Resolver', [$this, 'getResolver'], true);
		$container->share('JoomlaPlugin.Remote.Get', [$this, 'getRemoteGet'], true);
		$container->share('JoomlaPlugin.Remote.Set', [$this, 'getRemoteSet'], true);
		$container->share('JoomlaPlugin.Readme.Item', [$this, 'getItemReadme'], true);
		$container->share('JoomlaPlugin.Readme.Main', [$this, 'getMainReadme'], true);

/// CHILDREN //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

		$container->share('JoomlaPluginUpdates.Grep', [$this, 'getJoomlaPluginUpdatesGrep'], true);
		$container->share('JoomlaPluginUpdates.Remote.Config', [$this, 'getJoomlaPluginUpdatesRemoteConfig'], true);
		$container->share('JoomlaPluginUpdates.Resolver', [$this, 'getJoomlaPluginUpdatesResolver'], true);
		$container->share('JoomlaPluginUpdates.Remote.Get', [$this, 'getJoomlaPluginUpdatesRemoteGet'], true);
		$container->share('JoomlaPluginUpdates.Remote.Set', [$this, 'getJoomlaPluginUpdatesRemoteSet'], true);

		$container->share('JoomlaPluginFilesFoldersUrls.Grep', [$this, 'getJoomlaPluginFilesFoldersUrlsGrep'], true);
		$container->share('JoomlaPluginFilesFoldersUrls.Remote.Config', [$this, 'getJoomlaPluginFilesFoldersUrlsRemoteConfig'], true);
		$container->share('JoomlaPluginFilesFoldersUrls.Resolver', [$this, 'getJoomlaPluginFilesFoldersUrlsResolver'], true);
		$container->share('JoomlaPluginFilesFoldersUrls.Remote.Get', [$this, 'getJoomlaPluginFilesFoldersUrlsRemoteGet'], true);
		$container->share('JoomlaPluginFilesFoldersUrls.Remote.Set', [$this, 'getJoomlaPluginFilesFoldersUrlsRemoteSet'], true);

		$container->share('JoomlaPluginGroup.Grep', [$this, 'getJoomlaPluginGroupGrep'], true);
		$container->share('JoomlaPluginGroup.Remote.Config', [$this, 'getJoomlaPluginGroupRemoteConfig'], true);
		$container->share('JoomlaPluginGroup.Resolver', [$this, 'getJoomlaPluginGroupResolver'], true);
		$container->share('JoomlaPluginGroup.Remote.Get', [$this, 'getJoomlaPluginGroupRemoteGet'], true);
		$container->share('JoomlaPluginGroup.Remote.Set', [$this, 'getJoomlaPluginGroupRemoteSet'], true);
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
			$container->get('JoomlaPlugin.Remote.Config'),
			$container->get('Git.Repository.Contents'),
			$container->get('Network.Resolve'),
			$container->get('Power.Tracker'),
			$container->get('Config')->approved_package_paths
		);
	}

	/**
	 * Get The Remote Config Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Config
	 * @since   5.1.1
	 */
	public function getRemoteConfig(Container $container): Config
	{
		return new Config(
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
			$container->get('JoomlaPlugin.Remote.Config'),
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
	public function getRemoteGet(Container $container): Get
	{
		return new Get(
			$container->get('JoomlaPlugin.Remote.Config'),
			$container->get('JoomlaPlugin.Grep'),
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
	public function getRemoteSet(Container $container): Set
	{
		return new Set(
			$container->get('Power.Tracker'),
			$container->get('Power.Message'),
			$container->get('JoomlaPlugin.Grep'),
			$container->get('JoomlaPlugin.Resolver'),
			$container->get('JoomlaPlugin.Remote.Config'),
			$container->get('JoomlaPlugin.Readme.Item'),
			$container->get('JoomlaPlugin.Readme.Main'),
			$container->get('Git.Repository.Contents'),
			$container->get('Data.Items'),
			$container->get('Config')->approved_package_paths
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

/// CHILDREN //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	/**
	 * Get The Grep Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Grep
	 * @since   5.1.1
	 */
	public function getJoomlaPluginUpdatesGrep(Container $container): Grep
	{
		return new Grep(
			$container->get('JoomlaPluginUpdates.Remote.Config'),
			$container->get('Git.Repository.Contents'),
			$container->get('Network.Resolve'),
			$container->get('Power.Tracker'),
			$container->get('Config')->approved_package_paths
		);
	}

	/**
	 * Get The Remote Config Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  JoomlaPluginUpdates
	 * @since   5.1.1
	 */
	public function getJoomlaPluginUpdatesRemoteConfig(Container $container): JoomlaPluginUpdates
	{
		return new JoomlaPluginUpdates(
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
	public function getJoomlaPluginUpdatesResolver(Container $container): Resolver
	{
		return new Resolver(
			$container->get('JoomlaPluginUpdates.Remote.Config'),
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
	public function getJoomlaPluginUpdatesRemoteGet(Container $container): Get
	{
		return new Get(
			$container->get('JoomlaPluginUpdates.Remote.Config'),
			$container->get('JoomlaPluginUpdates.Grep'),
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
	public function getJoomlaPluginUpdatesRemoteSet(Container $container): Set
	{
		return new Set(
			$container->get('Power.Tracker'),
			$container->get('Power.Message'),
			$container->get('JoomlaPluginUpdates.Grep'),
			$container->get('JoomlaPluginUpdates.Resolver'),
			$container->get('JoomlaPluginUpdates.Remote.Config'),
			$container->get('Children.Readme.Item'),
			$container->get('Children.Readme.Main'),
			$container->get('Git.Repository.Contents'),
			$container->get('Data.Items'),
			$container->get('Config')->approved_package_paths
		);
	}

	/**
	 * Get The Grep Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Grep
	 * @since   5.1.1
	 */
	public function getJoomlaPluginFilesFoldersUrlsGrep(Container $container): Grep
	{
		return new Grep(
			$container->get('JoomlaPluginFilesFoldersUrls.Remote.Config'),
			$container->get('Git.Repository.Contents'),
			$container->get('Network.Resolve'),
			$container->get('Power.Tracker'),
			$container->get('Config')->approved_package_paths
		);
	}

	/**
	 * Get The Remote Config Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  JoomlaPluginFilesFoldersUrls
	 * @since   5.1.1
	 */
	public function getJoomlaPluginFilesFoldersUrlsRemoteConfig(Container $container): JoomlaPluginFilesFoldersUrls
	{
		return new JoomlaPluginFilesFoldersUrls(
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
	public function getJoomlaPluginFilesFoldersUrlsResolver(Container $container): Resolver
	{
		return new Resolver(
			$container->get('JoomlaPluginFilesFoldersUrls.Remote.Config'),
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
	public function getJoomlaPluginFilesFoldersUrlsRemoteGet(Container $container): Get
	{
		return new Get(
			$container->get('JoomlaPluginFilesFoldersUrls.Remote.Config'),
			$container->get('JoomlaPluginFilesFoldersUrls.Grep'),
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
	public function getJoomlaPluginFilesFoldersUrlsRemoteSet(Container $container): Set
	{
		return new Set(
			$container->get('Power.Tracker'),
			$container->get('Power.Message'),
			$container->get('JoomlaPluginFilesFoldersUrls.Grep'),
			$container->get('JoomlaPluginFilesFoldersUrls.Resolver'),
			$container->get('JoomlaPluginFilesFoldersUrls.Remote.Config'),
			$container->get('Children.Readme.Item'),
			$container->get('Children.Readme.Main'),
			$container->get('Git.Repository.Contents'),
			$container->get('Data.Items'),
			$container->get('Config')->approved_package_paths
		);
	}

	/**
	 * Get The Grep Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Grep
	 * @since   5.1.1
	 */
	public function getJoomlaPluginGroupGrep(Container $container): Grep
	{
		return new Grep(
			$container->get('JoomlaPluginGroup.Remote.Config'),
			$container->get('Git.Repository.Contents'),
			$container->get('Network.Resolve'),
			$container->get('Power.Tracker'),
			$container->get('Config')->approved_package_paths
		);
	}

	/**
	 * Get The Remote Config Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  JoomlaPluginGroup
	 * @since   5.1.1
	 */
	public function getJoomlaPluginGroupRemoteConfig(Container $container): JoomlaPluginGroup
	{
		return new JoomlaPluginGroup(
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
	public function getJoomlaPluginGroupResolver(Container $container): Resolver
	{
		return new Resolver(
			$container->get('JoomlaPluginGroup.Remote.Config'),
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
	public function getJoomlaPluginGroupRemoteGet(Container $container): Get
	{
		return new Get(
			$container->get('JoomlaPluginGroup.Remote.Config'),
			$container->get('JoomlaPluginGroup.Grep'),
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
	public function getJoomlaPluginGroupRemoteSet(Container $container): Set
	{
		return new Set(
			$container->get('Power.Tracker'),
			$container->get('Power.Message'),
			$container->get('JoomlaPluginGroup.Grep'),
			$container->get('JoomlaPluginGroup.Resolver'),
			$container->get('JoomlaPluginGroup.Remote.Config'),
			$container->get('Children.Readme.Item'),
			$container->get('Children.Readme.Main'),
			$container->get('Git.Repository.Contents'),
			$container->get('Data.Items'),
			$container->get('Config')->approved_package_paths
		);
	}
}

