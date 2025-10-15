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
use VDM\Joomla\Componentbuilder\Package\AdminView\Remote\Config;
use VDM\Joomla\Componentbuilder\Package\Dependency\Resolver;
use VDM\Joomla\Componentbuilder\Remote\Get;
use VDM\Joomla\Componentbuilder\Remote\Set;
use VDM\Joomla\Componentbuilder\Package\AdminView\Readme\Item as ItemReadme;
use VDM\Joomla\Componentbuilder\Package\AdminView\Readme\Main as MainReadme;
use VDM\Joomla\Componentbuilder\Package\AdminFields\Remote\Config as AdminFields;
use VDM\Joomla\Componentbuilder\Package\AdminFieldsRelations\Remote\Config as AdminFieldsRelations;
use VDM\Joomla\Componentbuilder\Package\AdminFieldsConditions\Remote\Config as AdminFieldsConditions;
use VDM\Joomla\Componentbuilder\Package\AdminCustomTabs\Remote\Config as AdminCustomTabs;


/**
 * Admin View Service Provider
 * 
 * @since 5.1.1
 */
class AdminView implements ServiceProviderInterface
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
		$container->share('AdminView.Grep', [$this, 'getGrep'], true);
		$container->share('AdminView.Remote.Config', [$this, 'getRemoteConfig'], true);
		$container->share('AdminView.Resolver', [$this, 'getResolver'], true);
		$container->share('AdminView.Remote.Get', [$this, 'getRemoteGet'], true);
		$container->share('AdminView.Remote.Set', [$this, 'getRemoteSet'], true);
		$container->share('AdminView.Readme.Item', [$this, 'getItemReadme'], true);
		$container->share('AdminView.Readme.Main', [$this, 'getMainReadme'], true);

/// CHILDREN //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

		$container->share('AdminFields.Grep', [$this, 'getAdminFieldsGrep'], true);
		$container->share('AdminFields.Remote.Config', [$this, 'getAdminFieldsRemoteConfig'], true);
		$container->share('AdminFields.Resolver', [$this, 'getAdminFieldsResolver'], true);
		$container->share('AdminFields.Remote.Get', [$this, 'getAdminFieldsRemoteGet'], true);
		$container->share('AdminFields.Remote.Set', [$this, 'getAdminFieldsRemoteSet'], true);

		$container->share('AdminFieldsRelations.Grep', [$this, 'getAdminFieldsRelationsGrep'], true);
		$container->share('AdminFieldsRelations.Remote.Config', [$this, 'getAdminFieldsRelationsRemoteConfig'], true);
		$container->share('AdminFieldsRelations.Resolver', [$this, 'getAdminFieldsRelationsResolver'], true);
		$container->share('AdminFieldsRelations.Remote.Get', [$this, 'getAdminFieldsRelationsRemoteGet'], true);
		$container->share('AdminFieldsRelations.Remote.Set', [$this, 'getAdminFieldsRelationsRemoteSet'], true);

		$container->share('AdminFieldsConditions.Grep', [$this, 'getAdminFieldsConditionsGrep'], true);
		$container->share('AdminFieldsConditions.Remote.Config', [$this, 'getAdminFieldsConditionsRemoteConfig'], true);
		$container->share('AdminFieldsConditions.Resolver', [$this, 'getAdminFieldsConditionsResolver'], true);
		$container->share('AdminFieldsConditions.Remote.Get', [$this, 'getAdminFieldsConditionsRemoteGet'], true);
		$container->share('AdminFieldsConditions.Remote.Set', [$this, 'getAdminFieldsConditionsRemoteSet'], true);

		$container->share('AdminCustomTabs.Grep', [$this, 'getAdminCustomTabsGrep'], true);
		$container->share('AdminCustomTabs.Remote.Config', [$this, 'getAdminCustomTabsRemoteConfig'], true);
		$container->share('AdminCustomTabs.Resolver', [$this, 'getAdminCustomTabsResolver'], true);
		$container->share('AdminCustomTabs.Remote.Get', [$this, 'getAdminCustomTabsRemoteGet'], true);
		$container->share('AdminCustomTabs.Remote.Set', [$this, 'getAdminCustomTabsRemoteSet'], true);
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
			$container->get('AdminView.Remote.Config'),
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
			$container->get('AdminView.Remote.Config'),
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
			$container->get('AdminView.Remote.Config'),
			$container->get('AdminView.Grep'),
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
			$container->get('AdminView.Grep'),
			$container->get('AdminView.Resolver'),
			$container->get('AdminView.Remote.Config'),
			$container->get('AdminView.Readme.Item'),
			$container->get('AdminView.Readme.Main'),
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
	public function getAdminFieldsGrep(Container $container): Grep
	{
		return new Grep(
			$container->get('AdminFields.Remote.Config'),
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
	 * @return  AdminFields
	 * @since   5.1.1
	 */
	public function getAdminFieldsRemoteConfig(Container $container): AdminFields
	{
		return new AdminFields(
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
	public function getAdminFieldsResolver(Container $container): Resolver
	{
		return new Resolver(
			$container->get('AdminFields.Remote.Config'),
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
	public function getAdminFieldsRemoteGet(Container $container): Get
	{
		return new Get(
			$container->get('AdminFields.Remote.Config'),
			$container->get('AdminFields.Grep'),
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
	public function getAdminFieldsRemoteSet(Container $container): Set
	{
		return new Set(
			$container->get('Power.Tracker'),
			$container->get('Power.Message'),
			$container->get('AdminFields.Grep'),
			$container->get('AdminFields.Resolver'),
			$container->get('AdminFields.Remote.Config'),
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
	public function getAdminFieldsRelationsGrep(Container $container): Grep
	{
		return new Grep(
			$container->get('AdminFieldsRelations.Remote.Config'),
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
	 * @return  AdminFieldsRelations
	 * @since   5.1.1
	 */
	public function getAdminFieldsRelationsRemoteConfig(Container $container): AdminFieldsRelations
	{
		return new AdminFieldsRelations(
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
	public function getAdminFieldsRelationsResolver(Container $container): Resolver
	{
		return new Resolver(
			$container->get('AdminFieldsRelations.Remote.Config'),
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
	public function getAdminFieldsRelationsRemoteGet(Container $container): Get
	{
		return new Get(
			$container->get('AdminFieldsRelations.Remote.Config'),
			$container->get('AdminFieldsRelations.Grep'),
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
	public function getAdminFieldsRelationsRemoteSet(Container $container): Set
	{
		return new Set(
			$container->get('Power.Tracker'),
			$container->get('Power.Message'),
			$container->get('AdminFieldsRelations.Grep'),
			$container->get('AdminFieldsRelations.Resolver'),
			$container->get('AdminFieldsRelations.Remote.Config'),
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
	public function getAdminFieldsConditionsGrep(Container $container): Grep
	{
		return new Grep(
			$container->get('AdminFieldsConditions.Remote.Config'),
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
	 * @return  AdminFieldsConditions
	 * @since   5.1.1
	 */
	public function getAdminFieldsConditionsRemoteConfig(Container $container): AdminFieldsConditions
	{
		return new AdminFieldsConditions(
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
	public function getAdminFieldsConditionsResolver(Container $container): Resolver
	{
		return new Resolver(
			$container->get('AdminFieldsConditions.Remote.Config'),
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
	public function getAdminFieldsConditionsRemoteGet(Container $container): Get
	{
		return new Get(
			$container->get('AdminFieldsConditions.Remote.Config'),
			$container->get('AdminFieldsConditions.Grep'),
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
	public function getAdminFieldsConditionsRemoteSet(Container $container): Set
	{
		return new Set(
			$container->get('Power.Tracker'),
			$container->get('Power.Message'),
			$container->get('AdminFieldsConditions.Grep'),
			$container->get('AdminFieldsConditions.Resolver'),
			$container->get('AdminFieldsConditions.Remote.Config'),
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
	public function getAdminCustomTabsGrep(Container $container): Grep
	{
		return new Grep(
			$container->get('AdminCustomTabs.Remote.Config'),
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
	 * @return  AdminCustomTabs
	 * @since   5.1.1
	 */
	public function getAdminCustomTabsRemoteConfig(Container $container): AdminCustomTabs
	{
		return new AdminCustomTabs(
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
	public function getAdminCustomTabsResolver(Container $container): Resolver
	{
		return new Resolver(
			$container->get('AdminCustomTabs.Remote.Config'),
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
	public function getAdminCustomTabsRemoteGet(Container $container): Get
	{
		return new Get(
			$container->get('AdminCustomTabs.Remote.Config'),
			$container->get('AdminCustomTabs.Grep'),
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
	public function getAdminCustomTabsRemoteSet(Container $container): Set
	{
		return new Set(
			$container->get('Power.Tracker'),
			$container->get('Power.Message'),
			$container->get('AdminCustomTabs.Grep'),
			$container->get('AdminCustomTabs.Resolver'),
			$container->get('AdminCustomTabs.Remote.Config'),
			$container->get('Children.Readme.Item'),
			$container->get('Children.Readme.Main'),
			$container->get('Git.Repository.Contents'),
			$container->get('Data.Items'),
			$container->get('Config')->approved_package_paths
		);
	}
}

