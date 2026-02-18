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
use VDM\Joomla\Componentbuilder\Package\JoomlaPlugin\Remote\Config;
use VDM\Joomla\Componentbuilder\Package\JoomlaPluginUpdates\Remote\Config as JoomlaPluginUpdates;
use VDM\Joomla\Componentbuilder\Package\JoomlaPluginFilesFoldersUrls\Remote\Config as JoomlaPluginFilesFoldersUrls;
use VDM\Joomla\Componentbuilder\Package\JoomlaPluginGroup\Remote\Config as JoomlaPluginGroup;


/**
 * Joomla Plugin Service Get Provider
 * 
 * @since 5.1.1
 */
class JoomlaPluginGet implements ServiceProviderInterface
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

		$container->share('JoomlaPlugin.Grep', [$this, 'getGrep'], true);
		$container->share('JoomlaPlugin.Remote.Get', [$this, 'getRemoteGet'], true);
		$container->share('JoomlaPlugin.Remote.Config', [$this, 'getRemoteConfig'], true);

/// CHILDREN //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

		$container->share('JoomlaPluginUpdates.Grep', [$this, 'getJoomlaPluginUpdatesGrep'], true);
		$container->share('JoomlaPluginUpdates.Remote.Get', [$this, 'getJoomlaPluginUpdatesRemoteGet'], true);
		$container->share('JoomlaPluginUpdates.Remote.Config', [$this, 'getJoomlaPluginUpdatesRemoteConfig'], true);

		$container->share('JoomlaPluginFilesFoldersUrls.Grep', [$this, 'getJoomlaPluginFilesFoldersUrlsGrep'], true);
		$container->share('JoomlaPluginFilesFoldersUrls.Remote.Get', [$this, 'getJoomlaPluginFilesFoldersUrlsRemoteGet'], true);
		$container->share('JoomlaPluginFilesFoldersUrls.Remote.Config', [$this, 'getJoomlaPluginFilesFoldersUrlsRemoteConfig'], true);

		$container->share('JoomlaPluginGroup.Grep', [$this, 'getJoomlaPluginGroupGrep'], true);
		$container->share('JoomlaPluginGroup.Remote.Get', [$this, 'getJoomlaPluginGroupRemoteGet'], true);
		$container->share('JoomlaPluginGroup.Remote.Config', [$this, 'getJoomlaPluginGroupRemoteConfig'], true);
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
			$container->get('JoomlaPlugin.Remote.Config'),
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
			$container->get('JoomlaPlugin.Remote.Config'),
			$container->get('JoomlaPlugin.Grep'),
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
	public function getJoomlaPluginUpdatesGrep(Container $container): Grep
	{
		return new Grep(
			$container->get('JoomlaPluginUpdates.Remote.Config'),
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
	public function getJoomlaPluginUpdatesRemoteGet(Container $container): Get
	{
		return new Get(
			$container->get('JoomlaPluginUpdates.Remote.Config'),
			$container->get('JoomlaPluginUpdates.Grep'),
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
	public function getJoomlaPluginFilesFoldersUrlsRemoteGet(Container $container): Get
	{
		return new Get(
			$container->get('JoomlaPluginFilesFoldersUrls.Remote.Config'),
			$container->get('JoomlaPluginFilesFoldersUrls.Grep'),
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
	public function getJoomlaPluginGroupRemoteGet(Container $container): Get
	{
		return new Get(
			$container->get('JoomlaPluginGroup.Remote.Config'),
			$container->get('JoomlaPluginGroup.Grep'),
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
	 * @return  JoomlaPluginGroup
	 * @since   5.1.1
	 */
	public function getJoomlaPluginGroupRemoteConfig(Container $container): JoomlaPluginGroup
	{
		return new JoomlaPluginGroup(
			$container->get('Power.Table')
		);
	}
}

