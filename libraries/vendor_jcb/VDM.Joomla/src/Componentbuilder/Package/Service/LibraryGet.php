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
use VDM\Joomla\Componentbuilder\Package\Library\Remote\Config;
use VDM\Joomla\Componentbuilder\Package\LibraryConfig\Remote\Config as LibraryConfig;
use VDM\Joomla\Componentbuilder\Package\LibraryFilesFoldersUrls\Remote\Config as LibraryFilesFoldersUrls;


/**
 * Library Service Get Provider
 * 
 * @since  5.1.1
 */
class LibraryGet implements ServiceProviderInterface
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

/// MAIN ENTITY //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

		$container->share('Library.Grep', [$this, 'getGrep'], true);
		$container->share('Library.Remote.Get', [$this, 'getRemoteGet'], true);
		$container->share('Library.Remote.Config', [$this, 'getRemoteConfig'], true);

/// CHILDREN //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

		$container->share('LibraryConfig.Grep', [$this, 'getLibraryConfigGrep'], true);
		$container->share('LibraryConfig.Remote.Get', [$this, 'getLibraryConfigRemoteGet'], true);
		$container->share('LibraryConfig.Remote.Config', [$this, 'getLibraryConfigRemoteConfig'], true);

		$container->share('LibraryFilesFoldersUrls.Grep', [$this, 'getLibraryFilesFoldersUrlsGrep'], true);
		$container->share('LibraryFilesFoldersUrls.Remote.Get', [$this, 'getLibraryFilesFoldersUrlsRemoteGet'], true);
		$container->share('LibraryFilesFoldersUrls.Remote.Config', [$this, 'getLibraryFilesFoldersUrlsRemoteConfig'], true);
	}

/// MAIN ENTITY //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

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
			$container->get('Library.Remote.Config'),
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
			$container->get('Library.Remote.Config'),
			$container->get('Library.Grep'),
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
	 * @since  5.1.1
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
	public function getLibraryConfigGrep(Container $container): Grep
	{
		return new Grep(
			$container->get('LibraryConfig.Remote.Config'),
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
	public function getLibraryConfigRemoteGet(Container $container): Get
	{
		return new Get(
			$container->get('LibraryConfig.Remote.Config'),
			$container->get('LibraryConfig.Grep'),
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
	 * @return  LibraryConfig
	 * @since   5.1.1
	 */
	public function getLibraryConfigRemoteConfig(Container $container): LibraryConfig
	{
		return new LibraryConfig(
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
	public function getLibraryFilesFoldersUrlsGrep(Container $container): Grep
	{
		return new Grep(
			$container->get('LibraryFilesFoldersUrls.Remote.Config'),
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
	public function getLibraryFilesFoldersUrlsRemoteGet(Container $container): Get
	{
		return new Get(
			$container->get('LibraryFilesFoldersUrls.Remote.Config'),
			$container->get('LibraryFilesFoldersUrls.Grep'),
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
	 * @return  LibraryFilesFoldersUrls
	 * @since   5.1.1
	 */
	public function getLibraryFilesFoldersUrlsRemoteConfig(Container $container): LibraryFilesFoldersUrls
	{
		return new LibraryFilesFoldersUrls(
			$container->get('Power.Table')
		);
	}
}

