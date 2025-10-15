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
use VDM\Joomla\Componentbuilder\Package\Component\Remote\Config;
use VDM\Joomla\Componentbuilder\Package\Dependency\Resolver;
use VDM\Joomla\Componentbuilder\Remote\Get;
use VDM\Joomla\Componentbuilder\Remote\Set;
use VDM\Joomla\Componentbuilder\Package\Component\Readme\Item as ItemReadme;
use VDM\Joomla\Componentbuilder\Package\Component\Readme\Main as MainReadme;
use VDM\Joomla\Componentbuilder\Package\ComponentAdminViews\Remote\Config as ComponentAdminViews;
use VDM\Joomla\Componentbuilder\Package\ComponentCustomAdminViews\Remote\Config as ComponentCustomAdminViews;
use VDM\Joomla\Componentbuilder\Package\ComponentSiteViews\Remote\Config as ComponentSiteViews;
use VDM\Joomla\Componentbuilder\Package\ComponentRouter\Remote\Config as ComponentRouter;
use VDM\Joomla\Componentbuilder\Package\ComponentConfig\Remote\Config as ComponentConfig;
use VDM\Joomla\Componentbuilder\Package\ComponentPlaceholders\Remote\Config as ComponentPlaceholders;
use VDM\Joomla\Componentbuilder\Package\ComponentUpdates\Remote\Config as ComponentUpdates;
use VDM\Joomla\Componentbuilder\Package\ComponentFilesFolders\Remote\Config as ComponentFilesFolders;
use VDM\Joomla\Componentbuilder\Package\ComponentCustomAdminMenus\Remote\Config as ComponentCustomAdminMenus;
use VDM\Joomla\Componentbuilder\Package\ComponentDashboard\Remote\Config as ComponentDashboard;
use VDM\Joomla\Componentbuilder\Package\ComponentModules\Remote\Config as ComponentModules;
use VDM\Joomla\Componentbuilder\Package\ComponentPlugins\Remote\Config as ComponentPlugins;


/**
 * Component Service Provider
 * 
 * @since 5.1.1
 */
class Component implements ServiceProviderInterface
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
		$container->share('Component.Grep', [$this, 'getGrep'], true);
		$container->share('Component.Remote.Config', [$this, 'getRemoteConfig'], true);
		$container->share('Component.Resolver', [$this, 'getResolver'], true);
		$container->share('Component.Remote.Get', [$this, 'getRemoteGet'], true);
		$container->share('Component.Remote.Set', [$this, 'getRemoteSet'], true);
		$container->share('Component.Readme.Item', [$this, 'getItemReadme'], true);
		$container->share('Component.Readme.Main', [$this, 'getMainReadme'], true);

/// CHILDREN //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

		$container->share('ComponentAdminViews.Grep', [$this, 'getComponentAdminViewsGrep'], true);
		$container->share('ComponentAdminViews.Remote.Config', [$this, 'getComponentAdminViewsRemoteConfig'], true);
		$container->share('ComponentAdminViews.Resolver', [$this, 'getComponentAdminViewsResolver'], true);
		$container->share('ComponentAdminViews.Remote.Get', [$this, 'getComponentAdminViewsRemoteGet'], true);
		$container->share('ComponentAdminViews.Remote.Set', [$this, 'getComponentAdminViewsRemoteSet'], true);

		$container->share('ComponentCustomAdminViews.Grep', [$this, 'getComponentCustomAdminViewsGrep'], true);
		$container->share('ComponentCustomAdminViews.Remote.Config', [$this, 'getComponentCustomAdminViewsRemoteConfig'], true);
		$container->share('ComponentCustomAdminViews.Resolver', [$this, 'getComponentCustomAdminViewsResolver'], true);
		$container->share('ComponentCustomAdminViews.Remote.Get', [$this, 'getComponentCustomAdminViewsRemoteGet'], true);
		$container->share('ComponentCustomAdminViews.Remote.Set', [$this, 'getComponentCustomAdminViewsRemoteSet'], true);

		$container->share('ComponentSiteViews.Grep', [$this, 'getComponentSiteViewsGrep'], true);
		$container->share('ComponentSiteViews.Remote.Config', [$this, 'getComponentSiteViewsRemoteConfig'], true);
		$container->share('ComponentSiteViews.Resolver', [$this, 'getComponentSiteViewsResolver'], true);
		$container->share('ComponentSiteViews.Remote.Get', [$this, 'getComponentSiteViewsRemoteGet'], true);
		$container->share('ComponentSiteViews.Remote.Set', [$this, 'getComponentSiteViewsRemoteSet'], true);

		$container->share('ComponentRouter.Grep', [$this, 'getComponentRouterGrep'], true);
		$container->share('ComponentRouter.Remote.Config', [$this, 'getComponentRouterRemoteConfig'], true);
		$container->share('ComponentRouter.Resolver', [$this, 'getComponentRouterResolver'], true);
		$container->share('ComponentRouter.Remote.Get', [$this, 'getComponentRouterRemoteGet'], true);
		$container->share('ComponentRouter.Remote.Set', [$this, 'getComponentRouterRemoteSet'], true);

		$container->share('ComponentConfig.Grep', [$this, 'getComponentConfigGrep'], true);
		$container->share('ComponentConfig.Remote.Config', [$this, 'getComponentConfigRemoteConfig'], true);
		$container->share('ComponentConfig.Resolver', [$this, 'getComponentConfigResolver'], true);
		$container->share('ComponentConfig.Remote.Get', [$this, 'getComponentConfigRemoteGet'], true);
		$container->share('ComponentConfig.Remote.Set', [$this, 'getComponentConfigRemoteSet'], true);

		$container->share('ComponentPlaceholders.Grep', [$this, 'getComponentPlaceholdersGrep'], true);
		$container->share('ComponentPlaceholders.Remote.Config', [$this, 'getComponentPlaceholdersRemoteConfig'], true);
		$container->share('ComponentPlaceholders.Resolver', [$this, 'getComponentPlaceholdersResolver'], true);
		$container->share('ComponentPlaceholders.Remote.Get', [$this, 'getComponentPlaceholdersRemoteGet'], true);
		$container->share('ComponentPlaceholders.Remote.Set', [$this, 'getComponentPlaceholdersRemoteSet'], true);

		$container->share('ComponentUpdates.Grep', [$this, 'getComponentUpdatesGrep'], true);
		$container->share('ComponentUpdates.Remote.Config', [$this, 'getComponentUpdatesRemoteConfig'], true);
		$container->share('ComponentUpdates.Resolver', [$this, 'getComponentUpdatesResolver'], true);
		$container->share('ComponentUpdates.Remote.Get', [$this, 'getComponentUpdatesRemoteGet'], true);
		$container->share('ComponentUpdates.Remote.Set', [$this, 'getComponentUpdatesRemoteSet'], true);

		$container->share('ComponentFilesFolders.Grep', [$this, 'getComponentFilesFoldersGrep'], true);
		$container->share('ComponentFilesFolders.Remote.Config', [$this, 'getComponentFilesFoldersRemoteConfig'], true);
		$container->share('ComponentFilesFolders.Resolver', [$this, 'getComponentFilesFoldersResolver'], true);
		$container->share('ComponentFilesFolders.Remote.Get', [$this, 'getComponentFilesFoldersRemoteGet'], true);
		$container->share('ComponentFilesFolders.Remote.Set', [$this, 'getComponentFilesFoldersRemoteSet'], true);

		$container->share('ComponentCustomAdminMenus.Grep', [$this, 'getComponentCustomAdminMenusGrep'], true);
		$container->share('ComponentCustomAdminMenus.Remote.Config', [$this, 'getComponentCustomAdminMenusRemoteConfig'], true);
		$container->share('ComponentCustomAdminMenus.Resolver', [$this, 'getComponentCustomAdminMenusResolver'], true);
		$container->share('ComponentCustomAdminMenus.Remote.Get', [$this, 'getComponentCustomAdminMenusRemoteGet'], true);
		$container->share('ComponentCustomAdminMenus.Remote.Set', [$this, 'getComponentCustomAdminMenusRemoteSet'], true);

		$container->share('ComponentDashboard.Grep', [$this, 'getComponentDashboardGrep'], true);
		$container->share('ComponentDashboard.Remote.Config', [$this, 'getComponentDashboardRemoteConfig'], true);
		$container->share('ComponentDashboard.Resolver', [$this, 'getComponentDashboardResolver'], true);
		$container->share('ComponentDashboard.Remote.Get', [$this, 'getComponentDashboardRemoteGet'], true);
		$container->share('ComponentDashboard.Remote.Set', [$this, 'getComponentDashboardRemoteSet'], true);

		$container->share('ComponentModules.Grep', [$this, 'getComponentModulesGrep'], true);
		$container->share('ComponentModules.Remote.Config', [$this, 'getComponentModulesRemoteConfig'], true);
		$container->share('ComponentModules.Resolver', [$this, 'getComponentModulesResolver'], true);
		$container->share('ComponentModules.Remote.Get', [$this, 'getComponentModulesRemoteGet'], true);
		$container->share('ComponentModules.Remote.Set', [$this, 'getComponentModulesRemoteSet'], true);

		$container->share('ComponentPlugins.Grep', [$this, 'getComponentPluginsGrep'], true);
		$container->share('ComponentPlugins.Remote.Config', [$this, 'getComponentPluginsRemoteConfig'], true);
		$container->share('ComponentPlugins.Resolver', [$this, 'getComponentPluginsResolver'], true);
		$container->share('ComponentPlugins.Remote.Get', [$this, 'getComponentPluginsRemoteGet'], true);
		$container->share('ComponentPlugins.Remote.Set', [$this, 'getComponentPluginsRemoteSet'], true);
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
			$container->get('Component.Remote.Config'),
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
			$container->get('Component.Remote.Config'),
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
			$container->get('Component.Remote.Config'),
			$container->get('Component.Grep'),
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
	 * Get The Grep Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Grep
	 * @since   5.1.1
	 */
	public function getComponentAdminViewsGrep(Container $container): Grep
	{
		return new Grep(
			$container->get('ComponentAdminViews.Remote.Config'),
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
	 * @return  ComponentAdminViews
	 * @since   5.1.1
	 */
	public function getComponentAdminViewsRemoteConfig(Container $container): ComponentAdminViews
	{
		return new ComponentAdminViews(
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
	public function getComponentAdminViewsResolver(Container $container): Resolver
	{
		return new Resolver(
			$container->get('ComponentAdminViews.Remote.Config'),
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
	public function getComponentAdminViewsRemoteGet(Container $container): Get
	{
		return new Get(
			$container->get('ComponentAdminViews.Remote.Config'),
			$container->get('ComponentAdminViews.Grep'),
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
	public function getComponentAdminViewsRemoteSet(Container $container): Set
	{
		return new Set(
			$container->get('Power.Tracker'),
			$container->get('Power.Message'),
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
	 * Get The Grep Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Grep
	 * @since   5.1.1
	 */
	public function getComponentCustomAdminViewsGrep(Container $container): Grep
	{
		return new Grep(
			$container->get('ComponentCustomAdminViews.Remote.Config'),
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
	 * @return  ComponentCustomAdminViews
	 * @since   5.1.1
	 */
	public function getComponentCustomAdminViewsRemoteConfig(Container $container): ComponentCustomAdminViews
	{
		return new ComponentCustomAdminViews(
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
	public function getComponentCustomAdminViewsResolver(Container $container): Resolver
	{
		return new Resolver(
			$container->get('ComponentCustomAdminViews.Remote.Config'),
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
	public function getComponentCustomAdminViewsRemoteGet(Container $container): Get
	{
		return new Get(
			$container->get('ComponentCustomAdminViews.Remote.Config'),
			$container->get('ComponentCustomAdminViews.Grep'),
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
	public function getComponentCustomAdminViewsRemoteSet(Container $container): Set
	{
		return new Set(
			$container->get('Power.Tracker'),
			$container->get('Power.Message'),
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
	 * Get The Grep Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Grep
	 * @since   5.1.1
	 */
	public function getComponentSiteViewsGrep(Container $container): Grep
	{
		return new Grep(
			$container->get('ComponentSiteViews.Remote.Config'),
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
	 * @return  ComponentSiteViews
	 * @since   5.1.1
	 */
	public function getComponentSiteViewsRemoteConfig(Container $container): ComponentSiteViews
	{
		return new ComponentSiteViews(
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
	public function getComponentSiteViewsResolver(Container $container): Resolver
	{
		return new Resolver(
			$container->get('ComponentSiteViews.Remote.Config'),
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
	public function getComponentSiteViewsRemoteGet(Container $container): Get
	{
		return new Get(
			$container->get('ComponentSiteViews.Remote.Config'),
			$container->get('ComponentSiteViews.Grep'),
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
	public function getComponentSiteViewsRemoteSet(Container $container): Set
	{
		return new Set(
			$container->get('Power.Tracker'),
			$container->get('Power.Message'),
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
	 * Get The Grep Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Grep
	 * @since   5.1.1
	 */
	public function getComponentRouterGrep(Container $container): Grep
	{
		return new Grep(
			$container->get('ComponentRouter.Remote.Config'),
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
	 * @return  ComponentRouter
	 * @since   5.1.1
	 */
	public function getComponentRouterRemoteConfig(Container $container): ComponentRouter
	{
		return new ComponentRouter(
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
	public function getComponentRouterResolver(Container $container): Resolver
	{
		return new Resolver(
			$container->get('ComponentRouter.Remote.Config'),
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
	public function getComponentRouterRemoteGet(Container $container): Get
	{
		return new Get(
			$container->get('ComponentRouter.Remote.Config'),
			$container->get('ComponentRouter.Grep'),
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
	public function getComponentRouterRemoteSet(Container $container): Set
	{
		return new Set(
			$container->get('Power.Tracker'),
			$container->get('Power.Message'),
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
	 * Get The Grep Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Grep
	 * @since   5.1.1
	 */
	public function getComponentConfigGrep(Container $container): Grep
	{
		return new Grep(
			$container->get('ComponentConfig.Remote.Config'),
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
	 * @return  ComponentConfig
	 * @since   5.1.1
	 */
	public function getComponentConfigRemoteConfig(Container $container): ComponentConfig
	{
		return new ComponentConfig(
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
	public function getComponentConfigResolver(Container $container): Resolver
	{
		return new Resolver(
			$container->get('ComponentConfig.Remote.Config'),
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
	public function getComponentConfigRemoteGet(Container $container): Get
	{
		return new Get(
			$container->get('ComponentConfig.Remote.Config'),
			$container->get('ComponentConfig.Grep'),
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
	public function getComponentConfigRemoteSet(Container $container): Set
	{
		return new Set(
			$container->get('Power.Tracker'),
			$container->get('Power.Message'),
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
	 * Get The Grep Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Grep
	 * @since   5.1.1
	 */
	public function getComponentPlaceholdersGrep(Container $container): Grep
	{
		return new Grep(
			$container->get('ComponentPlaceholders.Remote.Config'),
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
	 * @return  ComponentPlaceholders
	 * @since   5.1.1
	 */
	public function getComponentPlaceholdersRemoteConfig(Container $container): ComponentPlaceholders
	{
		return new ComponentPlaceholders(
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
	public function getComponentPlaceholdersResolver(Container $container): Resolver
	{
		return new Resolver(
			$container->get('ComponentPlaceholders.Remote.Config'),
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
	public function getComponentPlaceholdersRemoteGet(Container $container): Get
	{
		return new Get(
			$container->get('ComponentPlaceholders.Remote.Config'),
			$container->get('ComponentPlaceholders.Grep'),
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
	public function getComponentPlaceholdersRemoteSet(Container $container): Set
	{
		return new Set(
			$container->get('Power.Tracker'),
			$container->get('Power.Message'),
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
	 * Get The Grep Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Grep
	 * @since   5.1.1
	 */
	public function getComponentUpdatesGrep(Container $container): Grep
	{
		return new Grep(
			$container->get('ComponentUpdates.Remote.Config'),
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
	 * @return  ComponentUpdates
	 * @since   5.1.1
	 */
	public function getComponentUpdatesRemoteConfig(Container $container): ComponentUpdates
	{
		return new ComponentUpdates(
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
	public function getComponentUpdatesResolver(Container $container): Resolver
	{
		return new Resolver(
			$container->get('ComponentUpdates.Remote.Config'),
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
	public function getComponentUpdatesRemoteGet(Container $container): Get
	{
		return new Get(
			$container->get('ComponentUpdates.Remote.Config'),
			$container->get('ComponentUpdates.Grep'),
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
	public function getComponentUpdatesRemoteSet(Container $container): Set
	{
		return new Set(
			$container->get('Power.Tracker'),
			$container->get('Power.Message'),
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
	 * Get The Grep Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Grep
	 * @since   5.1.1
	 */
	public function getComponentFilesFoldersGrep(Container $container): Grep
	{
		return new Grep(
			$container->get('ComponentFilesFolders.Remote.Config'),
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
	 * @return  ComponentFilesFolders
	 * @since   5.1.1
	 */
	public function getComponentFilesFoldersRemoteConfig(Container $container): ComponentFilesFolders
	{
		return new ComponentFilesFolders(
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
	public function getComponentFilesFoldersResolver(Container $container): Resolver
	{
		return new Resolver(
			$container->get('ComponentFilesFolders.Remote.Config'),
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
	public function getComponentFilesFoldersRemoteGet(Container $container): Get
	{
		return new Get(
			$container->get('ComponentFilesFolders.Remote.Config'),
			$container->get('ComponentFilesFolders.Grep'),
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
	public function getComponentFilesFoldersRemoteSet(Container $container): Set
	{
		return new Set(
			$container->get('Power.Tracker'),
			$container->get('Power.Message'),
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
	 * Get The Grep Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Grep
	 * @since   5.1.1
	 */
	public function getComponentCustomAdminMenusGrep(Container $container): Grep
	{
		return new Grep(
			$container->get('ComponentCustomAdminMenus.Remote.Config'),
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
	 * @return  ComponentCustomAdminMenus
	 * @since   5.1.1
	 */
	public function getComponentCustomAdminMenusRemoteConfig(Container $container): ComponentCustomAdminMenus
	{
		return new ComponentCustomAdminMenus(
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
	public function getComponentCustomAdminMenusResolver(Container $container): Resolver
	{
		return new Resolver(
			$container->get('ComponentCustomAdminMenus.Remote.Config'),
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
	public function getComponentCustomAdminMenusRemoteGet(Container $container): Get
	{
		return new Get(
			$container->get('ComponentCustomAdminMenus.Remote.Config'),
			$container->get('ComponentCustomAdminMenus.Grep'),
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
	public function getComponentCustomAdminMenusRemoteSet(Container $container): Set
	{
		return new Set(
			$container->get('Power.Tracker'),
			$container->get('Power.Message'),
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
	 * Get The Grep Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Grep
	 * @since   5.1.1
	 */
	public function getComponentDashboardGrep(Container $container): Grep
	{
		return new Grep(
			$container->get('ComponentDashboard.Remote.Config'),
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
	 * @return  ComponentDashboard
	 * @since   5.1.1
	 */
	public function getComponentDashboardRemoteConfig(Container $container): ComponentDashboard
	{
		return new ComponentDashboard(
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
	public function getComponentDashboardResolver(Container $container): Resolver
	{
		return new Resolver(
			$container->get('ComponentDashboard.Remote.Config'),
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
	public function getComponentDashboardRemoteGet(Container $container): Get
	{
		return new Get(
			$container->get('ComponentDashboard.Remote.Config'),
			$container->get('ComponentDashboard.Grep'),
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
	public function getComponentDashboardRemoteSet(Container $container): Set
	{
		return new Set(
			$container->get('Power.Tracker'),
			$container->get('Power.Message'),
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
	 * Get The Grep Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Grep
	 * @since   5.1.1
	 */
	public function getComponentModulesGrep(Container $container): Grep
	{
		return new Grep(
			$container->get('ComponentModules.Remote.Config'),
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
	 * @return  ComponentModules
	 * @since   5.1.1
	 */
	public function getComponentModulesRemoteConfig(Container $container): ComponentModules
	{
		return new ComponentModules(
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
	public function getComponentModulesResolver(Container $container): Resolver
	{
		return new Resolver(
			$container->get('ComponentModules.Remote.Config'),
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
	public function getComponentModulesRemoteGet(Container $container): Get
	{
		return new Get(
			$container->get('ComponentModules.Remote.Config'),
			$container->get('ComponentModules.Grep'),
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
	public function getComponentModulesRemoteSet(Container $container): Set
	{
		return new Set(
			$container->get('Power.Tracker'),
			$container->get('Power.Message'),
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
	 * Get The Grep Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Grep
	 * @since   5.1.1
	 */
	public function getComponentPluginsGrep(Container $container): Grep
	{
		return new Grep(
			$container->get('ComponentPlugins.Remote.Config'),
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
	 * @return  ComponentPlugins
	 * @since   5.1.1
	 */
	public function getComponentPluginsRemoteConfig(Container $container): ComponentPlugins
	{
		return new ComponentPlugins(
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
	public function getComponentPluginsResolver(Container $container): Resolver
	{
		return new Resolver(
			$container->get('ComponentPlugins.Remote.Config'),
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
	public function getComponentPluginsRemoteGet(Container $container): Get
	{
		return new Get(
			$container->get('ComponentPlugins.Remote.Config'),
			$container->get('ComponentPlugins.Grep'),
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
	public function getComponentPluginsRemoteSet(Container $container): Set
	{
		return new Set(
			$container->get('Power.Tracker'),
			$container->get('Power.Message'),
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

