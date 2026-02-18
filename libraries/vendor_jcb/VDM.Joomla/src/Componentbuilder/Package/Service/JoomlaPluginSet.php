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
use VDM\Joomla\Componentbuilder\Package\Dependency\Resolver;
use VDM\Joomla\Componentbuilder\Remote\Set;
use VDM\Joomla\Componentbuilder\Package\JoomlaPlugin\Readme\Item as ItemReadme;
use VDM\Joomla\Componentbuilder\Package\JoomlaPlugin\Readme\Main as MainReadme;


/**
 * Joomla Plugin Service Set Provider
 * 
 * @since 5.1.1
 */
class JoomlaPluginSet implements ServiceProviderInterface
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

/// MAIN ENTITY ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

		$container->share('JoomlaPlugin.Resolver', [$this, 'getResolver'], true);
		$container->share('JoomlaPlugin.Remote.Set', [$this, 'getRemoteSet'], true);
		$container->share('JoomlaPlugin.Readme.Item', [$this, 'getItemReadme'], true);
		$container->share('JoomlaPlugin.Readme.Main', [$this, 'getMainReadme'], true);

/// CHILDREN //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

		$container->share('JoomlaPluginUpdates.Resolver', [$this, 'getJoomlaPluginUpdatesResolver'], true);
		$container->share('JoomlaPluginUpdates.Remote.Set', [$this, 'getJoomlaPluginUpdatesRemoteSet'], true);

		$container->share('JoomlaPluginFilesFoldersUrls.Resolver', [$this, 'getJoomlaPluginFilesFoldersUrlsResolver'], true);
		$container->share('JoomlaPluginFilesFoldersUrls.Remote.Set', [$this, 'getJoomlaPluginFilesFoldersUrlsRemoteSet'], true);

		$container->share('JoomlaPluginGroup.Resolver', [$this, 'getJoomlaPluginGroupResolver'], true);
		$container->share('JoomlaPluginGroup.Remote.Set', [$this, 'getJoomlaPluginGroupRemoteSet'], true);
	}

/// MAIN ENTITY ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

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
			$container->get('Package.Tracker'),
			$container->get('Power.Table'),
			$container->get('Load'),
			$container->get('Data.Items')
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
			$container->get('Package.Tracker'),
			$container->get('Package.Message'),
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
			$container->get('Package.Tracker'),
			$container->get('Power.Table'),
			$container->get('Load'),
			$container->get('Data.Items')
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
			$container->get('Package.Tracker'),
			$container->get('Package.Message'),
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
			$container->get('Package.Tracker'),
			$container->get('Power.Table'),
			$container->get('Load'),
			$container->get('Data.Items')
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
			$container->get('Package.Tracker'),
			$container->get('Package.Message'),
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
			$container->get('Package.Tracker'),
			$container->get('Power.Table'),
			$container->get('Load'),
			$container->get('Data.Items')
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
			$container->get('Package.Tracker'),
			$container->get('Package.Message'),
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

