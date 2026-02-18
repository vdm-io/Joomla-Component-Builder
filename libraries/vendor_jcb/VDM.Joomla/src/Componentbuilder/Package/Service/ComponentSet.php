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
use VDM\Joomla\Componentbuilder\Package\Component\Readme\Item as ItemReadme;
use VDM\Joomla\Componentbuilder\Package\Component\Readme\Main as MainReadme;


/**
 * Component Service Set Provider
 * 
 * @since 5.1.1
 */
class ComponentSet implements ServiceProviderInterface
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

		$container->share('Component.Resolver', [$this, 'getResolver'], true);
		$container->share('Component.Remote.Set', [$this, 'getRemoteSet'], true);
		$container->share('Component.Readme.Item', [$this, 'getItemReadme'], true);
		$container->share('Component.Readme.Main', [$this, 'getMainReadme'], true);

/// CHILDREN //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

		$container->share('ComponentAdminViews.Resolver', [$this, 'getComponentAdminViewsResolver'], true);
		$container->share('ComponentAdminViews.Remote.Set', [$this, 'getComponentAdminViewsRemoteSet'], true);

		$container->share('ComponentCustomAdminViews.Resolver', [$this, 'getComponentCustomAdminViewsResolver'], true);
		$container->share('ComponentCustomAdminViews.Remote.Set', [$this, 'getComponentCustomAdminViewsRemoteSet'], true);

		$container->share('ComponentSiteViews.Resolver', [$this, 'getComponentSiteViewsResolver'], true);
		$container->share('ComponentSiteViews.Remote.Set', [$this, 'getComponentSiteViewsRemoteSet'], true);

		$container->share('ComponentRouter.Resolver', [$this, 'getComponentRouterResolver'], true);
		$container->share('ComponentRouter.Remote.Set', [$this, 'getComponentRouterRemoteSet'], true);

		$container->share('ComponentConfig.Resolver', [$this, 'getComponentConfigResolver'], true);
		$container->share('ComponentConfig.Remote.Set', [$this, 'getComponentConfigRemoteSet'], true);

		$container->share('ComponentPlaceholders.Resolver', [$this, 'getComponentPlaceholdersResolver'], true);
		$container->share('ComponentPlaceholders.Remote.Set', [$this, 'getComponentPlaceholdersRemoteSet'], true);

		$container->share('ComponentUpdates.Resolver', [$this, 'getComponentUpdatesResolver'], true);
		$container->share('ComponentUpdates.Remote.Set', [$this, 'getComponentUpdatesRemoteSet'], true);

		$container->share('ComponentFilesFolders.Resolver', [$this, 'getComponentFilesFoldersResolver'], true);
		$container->share('ComponentFilesFolders.Remote.Set', [$this, 'getComponentFilesFoldersRemoteSet'], true);

		$container->share('ComponentCustomAdminMenus.Resolver', [$this, 'getComponentCustomAdminMenusResolver'], true);
		$container->share('ComponentCustomAdminMenus.Remote.Set', [$this, 'getComponentCustomAdminMenusRemoteSet'], true);

		$container->share('ComponentDashboard.Resolver', [$this, 'getComponentDashboardResolver'], true);
		$container->share('ComponentDashboard.Remote.Set', [$this, 'getComponentDashboardRemoteSet'], true);

		$container->share('ComponentModules.Resolver', [$this, 'getComponentModulesResolver'], true);
		$container->share('ComponentModules.Remote.Set', [$this, 'getComponentModulesRemoteSet'], true);

		$container->share('ComponentPlugins.Resolver', [$this, 'getComponentPluginsResolver'], true);
		$container->share('ComponentPlugins.Remote.Set', [$this, 'getComponentPluginsRemoteSet'], true);
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
			$container->get('Component.Remote.Config'),
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
			$container->get('Component.Grep'),
			$container->get('Component.Resolver'),
			$container->get('Component.Remote.Config'),
			$container->get('Component.Readme.Item'),
			$container->get('Component.Readme.Main'),
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
	public function getComponentAdminViewsResolver(Container $container): Resolver
	{
		return new Resolver(
			$container->get('ComponentAdminViews.Remote.Config'),
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
	public function getComponentAdminViewsRemoteSet(Container $container): Set
	{
		return new Set(
			$container->get('Package.Tracker'),
			$container->get('Package.Message'),
			$container->get('ComponentAdminViews.Grep'),
			$container->get('ComponentAdminViews.Resolver'),
			$container->get('ComponentAdminViews.Remote.Config'),
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
	public function getComponentCustomAdminViewsResolver(Container $container): Resolver
	{
		return new Resolver(
			$container->get('ComponentCustomAdminViews.Remote.Config'),
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
	public function getComponentCustomAdminViewsRemoteSet(Container $container): Set
	{
		return new Set(
			$container->get('Package.Tracker'),
			$container->get('Package.Message'),
			$container->get('ComponentCustomAdminViews.Grep'),
			$container->get('ComponentCustomAdminViews.Resolver'),
			$container->get('ComponentCustomAdminViews.Remote.Config'),
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
	public function getComponentSiteViewsResolver(Container $container): Resolver
	{
		return new Resolver(
			$container->get('ComponentSiteViews.Remote.Config'),
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
	public function getComponentSiteViewsRemoteSet(Container $container): Set
	{
		return new Set(
			$container->get('Package.Tracker'),
			$container->get('Package.Message'),
			$container->get('ComponentSiteViews.Grep'),
			$container->get('ComponentSiteViews.Resolver'),
			$container->get('ComponentSiteViews.Remote.Config'),
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
	public function getComponentRouterResolver(Container $container): Resolver
	{
		return new Resolver(
			$container->get('ComponentRouter.Remote.Config'),
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
	public function getComponentRouterRemoteSet(Container $container): Set
	{
		return new Set(
			$container->get('Package.Tracker'),
			$container->get('Package.Message'),
			$container->get('ComponentRouter.Grep'),
			$container->get('ComponentRouter.Resolver'),
			$container->get('ComponentRouter.Remote.Config'),
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
	public function getComponentConfigResolver(Container $container): Resolver
	{
		return new Resolver(
			$container->get('ComponentConfig.Remote.Config'),
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
	public function getComponentConfigRemoteSet(Container $container): Set
	{
		return new Set(
			$container->get('Package.Tracker'),
			$container->get('Package.Message'),
			$container->get('ComponentConfig.Grep'),
			$container->get('ComponentConfig.Resolver'),
			$container->get('ComponentConfig.Remote.Config'),
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
	public function getComponentPlaceholdersResolver(Container $container): Resolver
	{
		return new Resolver(
			$container->get('ComponentPlaceholders.Remote.Config'),
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
	public function getComponentPlaceholdersRemoteSet(Container $container): Set
	{
		return new Set(
			$container->get('Package.Tracker'),
			$container->get('Package.Message'),
			$container->get('ComponentPlaceholders.Grep'),
			$container->get('ComponentPlaceholders.Resolver'),
			$container->get('ComponentPlaceholders.Remote.Config'),
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
	public function getComponentUpdatesResolver(Container $container): Resolver
	{
		return new Resolver(
			$container->get('ComponentUpdates.Remote.Config'),
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
	public function getComponentUpdatesRemoteSet(Container $container): Set
	{
		return new Set(
			$container->get('Package.Tracker'),
			$container->get('Package.Message'),
			$container->get('ComponentUpdates.Grep'),
			$container->get('ComponentUpdates.Resolver'),
			$container->get('ComponentUpdates.Remote.Config'),
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
	public function getComponentFilesFoldersResolver(Container $container): Resolver
	{
		return new Resolver(
			$container->get('ComponentFilesFolders.Remote.Config'),
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
	public function getComponentFilesFoldersRemoteSet(Container $container): Set
	{
		return new Set(
			$container->get('Package.Tracker'),
			$container->get('Package.Message'),
			$container->get('ComponentFilesFolders.Grep'),
			$container->get('ComponentFilesFolders.Resolver'),
			$container->get('ComponentFilesFolders.Remote.Config'),
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
	public function getComponentCustomAdminMenusResolver(Container $container): Resolver
	{
		return new Resolver(
			$container->get('ComponentCustomAdminMenus.Remote.Config'),
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
	public function getComponentCustomAdminMenusRemoteSet(Container $container): Set
	{
		return new Set(
			$container->get('Package.Tracker'),
			$container->get('Package.Message'),
			$container->get('ComponentCustomAdminMenus.Grep'),
			$container->get('ComponentCustomAdminMenus.Resolver'),
			$container->get('ComponentCustomAdminMenus.Remote.Config'),
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
	public function getComponentDashboardResolver(Container $container): Resolver
	{
		return new Resolver(
			$container->get('ComponentDashboard.Remote.Config'),
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
	public function getComponentDashboardRemoteSet(Container $container): Set
	{
		return new Set(
			$container->get('Package.Tracker'),
			$container->get('Package.Message'),
			$container->get('ComponentDashboard.Grep'),
			$container->get('ComponentDashboard.Resolver'),
			$container->get('ComponentDashboard.Remote.Config'),
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
	public function getComponentModulesResolver(Container $container): Resolver
	{
		return new Resolver(
			$container->get('ComponentModules.Remote.Config'),
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
	public function getComponentModulesRemoteSet(Container $container): Set
	{
		return new Set(
			$container->get('Package.Tracker'),
			$container->get('Package.Message'),
			$container->get('ComponentModules.Grep'),
			$container->get('ComponentModules.Resolver'),
			$container->get('ComponentModules.Remote.Config'),
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
	public function getComponentPluginsResolver(Container $container): Resolver
	{
		return new Resolver(
			$container->get('ComponentPlugins.Remote.Config'),
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
	public function getComponentPluginsRemoteSet(Container $container): Set
	{
		return new Set(
			$container->get('Package.Tracker'),
			$container->get('Package.Message'),
			$container->get('ComponentPlugins.Grep'),
			$container->get('ComponentPlugins.Resolver'),
			$container->get('ComponentPlugins.Remote.Config'),
			$container->get('Children.Readme.Item'),
			$container->get('Children.Readme.Main'),
			$container->get('Git.Repository.Contents'),
			$container->get('Data.Items'),
			$container->get('Config')->approved_package_paths
		);
	}
}

