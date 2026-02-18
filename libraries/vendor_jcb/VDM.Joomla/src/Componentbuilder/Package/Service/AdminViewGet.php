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
use VDM\Joomla\Componentbuilder\Remote\Get;
use VDM\Joomla\Componentbuilder\Package\AdminView\Remote\Config;
use VDM\Joomla\Componentbuilder\Package\AdminFields\Remote\Config as AdminFields;
use VDM\Joomla\Componentbuilder\Package\AdminFieldsRelations\Remote\Config as AdminFieldsRelations;
use VDM\Joomla\Componentbuilder\Package\AdminFieldsConditions\Remote\Config as AdminFieldsConditions;
use VDM\Joomla\Componentbuilder\Package\AdminCustomTabs\Remote\Config as AdminCustomTabs;


/**
 * Admin View Service Get Provider
 * 
 * @since 5.1.1
 */
class AdminViewGet implements ServiceProviderInterface
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

		$container->share('AdminView.Grep', [$this, 'getGrep'], true);
		$container->share('AdminView.Remote.Get', [$this, 'getRemoteGet'], true);
		$container->share('AdminView.Remote.Config', [$this, 'getRemoteConfig'], true);

/// CHILDREN //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

		$container->share('AdminFields.Grep', [$this, 'getAdminFieldsGrep'], true);
		$container->share('AdminFields.Remote.Get', [$this, 'getAdminFieldsRemoteGet'], true);
		$container->share('AdminFields.Remote.Config', [$this, 'getAdminFieldsRemoteConfig'], true);

		$container->share('AdminFieldsRelations.Grep', [$this, 'getAdminFieldsRelationsGrep'], true);
		$container->share('AdminFieldsRelations.Remote.Get', [$this, 'getAdminFieldsRelationsRemoteGet'], true);
		$container->share('AdminFieldsRelations.Remote.Config', [$this, 'getAdminFieldsRelationsRemoteConfig'], true);

		$container->share('AdminFieldsConditions.Grep', [$this, 'getAdminFieldsConditionsGrep'], true);
		$container->share('AdminFieldsConditions.Remote.Get', [$this, 'getAdminFieldsConditionsRemoteGet'], true);
		$container->share('AdminFieldsConditions.Remote.Config', [$this, 'getAdminFieldsConditionsRemoteConfig'], true);

		$container->share('AdminCustomTabs.Grep', [$this, 'getAdminCustomTabsGrep'], true);
		$container->share('AdminCustomTabs.Remote.Get', [$this, 'getAdminCustomTabsRemoteGet'], true);
		$container->share('AdminCustomTabs.Remote.Config', [$this, 'getAdminCustomTabsRemoteConfig'], true);
	}

/// MAIN ENTITY ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

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
			$container->get('Package.Tracker'),
			$container->get('Config')->approved_package_paths
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
			$container->get('Package.Tracker'),
			$container->get('Package.Message')
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
			$container->get('Package.Tracker'),
			$container->get('Config')->approved_package_paths
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
			$container->get('Package.Tracker'),
			$container->get('Package.Message')
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
			$container->get('Package.Tracker'),
			$container->get('Config')->approved_package_paths
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
			$container->get('Package.Tracker'),
			$container->get('Package.Message')
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
			$container->get('Package.Tracker'),
			$container->get('Config')->approved_package_paths
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
			$container->get('Package.Tracker'),
			$container->get('Package.Message')
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
			$container->get('Package.Tracker'),
			$container->get('Config')->approved_package_paths
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
			$container->get('Package.Tracker'),
			$container->get('Package.Message')
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
}

