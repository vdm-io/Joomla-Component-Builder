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
use VDM\Joomla\Componentbuilder\Package\JoomlaModule\Remote\Config;
use VDM\Joomla\Componentbuilder\Package\JoomlaModuleUpdates\Remote\Config as JoomlaModuleUpdates;
use VDM\Joomla\Componentbuilder\Package\JoomlaModuleFilesFoldersUrls\Remote\Config as JoomlaModuleFilesFoldersUrls;


/**
 * Joomla Module Service Get Provider
 * 
 * @since 5.1.1
 */
class JoomlaModuleGet implements ServiceProviderInterface
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

		$container->share('JoomlaModule.Grep', [$this, 'getGrep'], true);
		$container->share('JoomlaModule.Remote.Get', [$this, 'getRemoteGet'], true);
		$container->share('JoomlaModule.Remote.Config', [$this, 'getRemoteConfig'], true);

/// CHILDREN //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

		$container->share('JoomlaModuleUpdates.Grep', [$this, 'getJoomlaModuleUpdatesGrep'], true);
		$container->share('JoomlaModuleUpdates.Remote.Get', [$this, 'getJoomlaModuleUpdatesRemoteGet'], true);
		$container->share('JoomlaModuleUpdates.Remote.Config', [$this, 'getJoomlaModuleUpdatesRemoteConfig'], true);

		$container->share('JoomlaModuleFilesFoldersUrls.Grep', [$this, 'getJoomlaModuleFilesFoldersUrlsGrep'], true);
		$container->share('JoomlaModuleFilesFoldersUrls.Remote.Get', [$this, 'getJoomlaModuleFilesFoldersUrlsRemoteGet'], true);
		$container->share('JoomlaModuleFilesFoldersUrls.Remote.Config', [$this, 'getJoomlaModuleFilesFoldersUrlsRemoteConfig'], true);
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
			$container->get('JoomlaModule.Remote.Config'),
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
			$container->get('JoomlaModule.Remote.Config'),
			$container->get('JoomlaModule.Grep'),
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
	public function getJoomlaModuleUpdatesGrep(Container $container): Grep
	{
		return new Grep(
			$container->get('JoomlaModuleUpdates.Remote.Config'),
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
	public function getJoomlaModuleUpdatesRemoteGet(Container $container): Get
	{
		return new Get(
			$container->get('JoomlaModuleUpdates.Remote.Config'),
			$container->get('JoomlaModuleUpdates.Grep'),
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
	 * @return  JoomlaModuleUpdates
	 * @since   5.1.1
	 */
	public function getJoomlaModuleUpdatesRemoteConfig(Container $container): JoomlaModuleUpdates
	{
		return new JoomlaModuleUpdates(
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
	public function getJoomlaModuleFilesFoldersUrlsGrep(Container $container): Grep
	{
		return new Grep(
			$container->get('JoomlaModuleFilesFoldersUrls.Remote.Config'),
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
	public function getJoomlaModuleFilesFoldersUrlsRemoteGet(Container $container): Get
	{
		return new Get(
			$container->get('JoomlaModuleFilesFoldersUrls.Remote.Config'),
			$container->get('JoomlaModuleFilesFoldersUrls.Grep'),
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
	 * @return  JoomlaModuleFilesFoldersUrls
	 * @since   5.1.1
	 */
	public function getJoomlaModuleFilesFoldersUrlsRemoteConfig(Container $container): JoomlaModuleFilesFoldersUrls
	{
		return new JoomlaModuleFilesFoldersUrls(
			$container->get('Power.Table')
		);
	}
}

