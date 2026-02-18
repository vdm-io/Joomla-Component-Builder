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
use VDM\Joomla\Componentbuilder\Package\JoomlaModule\Readme\Item as ItemReadme;
use VDM\Joomla\Componentbuilder\Package\JoomlaModule\Readme\Main as MainReadme;


/**
 * Joomla Module Service Set Provider
 * 
 * @since 5.1.1
 */
class JoomlaModuleSet implements ServiceProviderInterface
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

		$container->share('JoomlaModule.Resolver', [$this, 'getResolver'], true);
		$container->share('JoomlaModule.Remote.Set', [$this, 'getRemoteSet'], true);
		$container->share('JoomlaModule.Readme.Item', [$this, 'getItemReadme'], true);
		$container->share('JoomlaModule.Readme.Main', [$this, 'getMainReadme'], true);

/// CHILDREN //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

		$container->share('JoomlaModuleUpdates.Resolver', [$this, 'getJoomlaModuleUpdatesResolver'], true);
		$container->share('JoomlaModuleUpdates.Remote.Set', [$this, 'getJoomlaModuleUpdatesRemoteSet'], true);

		$container->share('JoomlaModuleFilesFoldersUrls.Resolver', [$this, 'getJoomlaModuleFilesFoldersUrlsResolver'], true);
		$container->share('JoomlaModuleFilesFoldersUrls.Remote.Set', [$this, 'getJoomlaModuleFilesFoldersUrlsRemoteSet'], true);
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
			$container->get('JoomlaModule.Remote.Config'),
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
			$container->get('JoomlaModule.Grep'),
			$container->get('JoomlaModule.Resolver'),
			$container->get('JoomlaModule.Remote.Config'),
			$container->get('JoomlaModule.Readme.Item'),
			$container->get('JoomlaModule.Readme.Main'),
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
	public function getJoomlaModuleUpdatesResolver(Container $container): Resolver
	{
		return new Resolver(
			$container->get('JoomlaModuleUpdates.Remote.Config'),
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
	public function getJoomlaModuleUpdatesRemoteSet(Container $container): Set
	{
		return new Set(
			$container->get('Package.Tracker'),
			$container->get('Package.Message'),
			$container->get('JoomlaModuleUpdates.Grep'),
			$container->get('JoomlaModuleUpdates.Resolver'),
			$container->get('JoomlaModuleUpdates.Remote.Config'),
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
	public function getJoomlaModuleFilesFoldersUrlsResolver(Container $container): Resolver
	{
		return new Resolver(
			$container->get('JoomlaModuleFilesFoldersUrls.Remote.Config'),
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
	public function getJoomlaModuleFilesFoldersUrlsRemoteSet(Container $container): Set
	{
		return new Set(
			$container->get('Package.Tracker'),
			$container->get('Package.Message'),
			$container->get('JoomlaModuleFilesFoldersUrls.Grep'),
			$container->get('JoomlaModuleFilesFoldersUrls.Resolver'),
			$container->get('JoomlaModuleFilesFoldersUrls.Remote.Config'),
			$container->get('Children.Readme.Item'),
			$container->get('Children.Readme.Main'),
			$container->get('Git.Repository.Contents'),
			$container->get('Data.Items'),
			$container->get('Config')->approved_package_paths
		);
	}
}

