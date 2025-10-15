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
use VDM\Joomla\Componentbuilder\Package\Library\Remote\Config;
use VDM\Joomla\Componentbuilder\Package\Dependency\Resolver;
use VDM\Joomla\Componentbuilder\Remote\Get;
use VDM\Joomla\Componentbuilder\Remote\Set;
use VDM\Joomla\Componentbuilder\Package\Library\Readme\Item as ItemReadme;
use VDM\Joomla\Componentbuilder\Package\Library\Readme\Main as MainReadme;
use VDM\Joomla\Componentbuilder\Package\LibraryConfig\Remote\Config as LibraryConfig;
use VDM\Joomla\Componentbuilder\Package\LibraryFilesFoldersUrls\Remote\Config as LibraryFilesFoldersUrls;


/**
 * Library Service Provider
 * 
 * @since  5.1.1
 */
class Library implements ServiceProviderInterface
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
		$container->share('Library.Grep', [$this, 'getGrep'], true);
		$container->share('Library.Remote.Config', [$this, 'getRemoteConfig'], true);
		$container->share('Library.Resolver', [$this, 'getResolver'], true);
		$container->share('Library.Remote.Get', [$this, 'getRemoteGet'], true);
		$container->share('Library.Remote.Set', [$this, 'getRemoteSet'], true);
		$container->share('Library.Readme.Item', [$this, 'getItemReadme'], true);
		$container->share('Library.Readme.Main', [$this, 'getMainReadme'], true);

/// CHILDREN //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

		$container->share('LibraryConfig.Grep', [$this, 'getLibraryConfigGrep'], true);
		$container->share('LibraryConfig.Remote.Config', [$this, 'getLibraryConfigRemoteConfig'], true);
		$container->share('LibraryConfig.Resolver', [$this, 'getLibraryConfigResolver'], true);
		$container->share('LibraryConfig.Remote.Get', [$this, 'getLibraryConfigRemoteGet'], true);
		$container->share('LibraryConfig.Remote.Set', [$this, 'getLibraryConfigRemoteSet'], true);

		$container->share('LibraryFilesFoldersUrls.Grep', [$this, 'getLibraryFilesFoldersUrlsGrep'], true);
		$container->share('LibraryFilesFoldersUrls.Remote.Config', [$this, 'getLibraryFilesFoldersUrlsRemoteConfig'], true);
		$container->share('LibraryFilesFoldersUrls.Resolver', [$this, 'getLibraryFilesFoldersUrlsResolver'], true);
		$container->share('LibraryFilesFoldersUrls.Remote.Get', [$this, 'getLibraryFilesFoldersUrlsRemoteGet'], true);
		$container->share('LibraryFilesFoldersUrls.Remote.Set', [$this, 'getLibraryFilesFoldersUrlsRemoteSet'], true);
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
			$container->get('Library.Remote.Config'),
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
	 * @since  5.1.1
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
			$container->get('Library.Remote.Config'),
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
			$container->get('Library.Remote.Config'),
			$container->get('Library.Grep'),
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
			$container->get('Library.Grep'),
			$container->get('Library.Resolver'),
			$container->get('Library.Remote.Config'),
			$container->get('Library.Readme.Item'),
			$container->get('Library.Readme.Main'),
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
	public function getLibraryConfigGrep(Container $container): Grep
	{
		return new Grep(
			$container->get('LibraryConfig.Remote.Config'),
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
	 * Get The Resolver Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Resolver
	 * @since 5.1.1
	 */
	public function getLibraryConfigResolver(Container $container): Resolver
	{
		return new Resolver(
			$container->get('LibraryConfig.Remote.Config'),
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
	public function getLibraryConfigRemoteGet(Container $container): Get
	{
		return new Get(
			$container->get('LibraryConfig.Remote.Config'),
			$container->get('LibraryConfig.Grep'),
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
	public function getLibraryConfigRemoteSet(Container $container): Set
	{
		return new Set(
			$container->get('Power.Tracker'),
			$container->get('Power.Message'),
			$container->get('LibraryConfig.Grep'),
			$container->get('LibraryConfig.Resolver'),
			$container->get('LibraryConfig.Remote.Config'),
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
	public function getLibraryFilesFoldersUrlsGrep(Container $container): Grep
	{
		return new Grep(
			$container->get('LibraryFilesFoldersUrls.Remote.Config'),
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
	 * @return  LibraryFilesFoldersUrls
	 * @since   5.1.1
	 */
	public function getLibraryFilesFoldersUrlsRemoteConfig(Container $container): LibraryFilesFoldersUrls
	{
		return new LibraryFilesFoldersUrls(
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
	public function getLibraryFilesFoldersUrlsResolver(Container $container): Resolver
	{
		return new Resolver(
			$container->get('LibraryFilesFoldersUrls.Remote.Config'),
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
	public function getLibraryFilesFoldersUrlsRemoteGet(Container $container): Get
	{
		return new Get(
			$container->get('LibraryFilesFoldersUrls.Remote.Config'),
			$container->get('LibraryFilesFoldersUrls.Grep'),
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
	public function getLibraryFilesFoldersUrlsRemoteSet(Container $container): Set
	{
		return new Set(
			$container->get('Power.Tracker'),
			$container->get('Power.Message'),
			$container->get('LibraryFilesFoldersUrls.Grep'),
			$container->get('LibraryFilesFoldersUrls.Resolver'),
			$container->get('LibraryFilesFoldersUrls.Remote.Config'),
			$container->get('Children.Readme.Item'),
			$container->get('Children.Readme.Main'),
			$container->get('Git.Repository.Contents'),
			$container->get('Data.Items'),
			$container->get('Config')->approved_package_paths
		);
	}
}

