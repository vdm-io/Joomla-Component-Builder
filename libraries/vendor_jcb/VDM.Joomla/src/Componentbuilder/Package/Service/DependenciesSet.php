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
use VDM\Joomla\Componentbuilder\Remote\Set;
use VDM\Joomla\Componentbuilder\Package\Dependency\Resolver;
use VDM\Joomla\Componentbuilder\Package\Children\Readme\Item as ItemReadme;
use VDM\Joomla\Componentbuilder\Package\Children\Readme\Main as MainReadme;
use VDM\Joomla\Componentbuilder\Package\Remote\SetFile;
use VDM\Joomla\Componentbuilder\Package\Remote\SetFolder;


/**
 * Dependencies Service Set Provider
 * 
 * @since 5.1.1
 */
class DependenciesSet implements ServiceProviderInterface
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
		$container->share('Children.Readme.Item', [$this, 'getItemReadme'], true);
		$container->share('Children.Readme.Main', [$this, 'getMainReadme'], true);

		$container->share('ClassMethod.Resolver', [$this, 'getClassMethodResolver'], true);
		$container->share('ClassMethod.Remote.Set', [$this, 'getClassMethodRemoteSet'], true);

		$container->share('ClassProperty.Resolver', [$this, 'getClassPropertyResolver'], true);
		$container->share('ClassProperty.Remote.Set', [$this, 'getClassPropertyRemoteSet'], true);

		$container->share('ClassExtends.Resolver', [$this, 'getClassExtendsResolver'], true);
		$container->share('ClassExtends.Remote.Set', [$this, 'getClassExtendsRemoteSet'], true);

		$container->share('Placeholder.Resolver', [$this, 'getPlaceholderResolver'], true);
		$container->share('Placeholder.Remote.Set', [$this, 'getPlaceholderRemoteSet'], true);

		$container->share('File.Resolver', [$this, 'getFileResolver'], true);
		$container->share('File.Remote.Set', [$this, 'getFileRemoteSet'], true);

		$container->share('Folder.Resolver', [$this, 'getFolderResolver'], true);
		$container->share('Folder.Remote.Set', [$this, 'getFolderRemoteSet'], true);
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

	/**
	 * Get The Resolver Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Resolver
	 * @since 5.1.1
	 */
	public function getClassMethodResolver(Container $container): Resolver
	{
		return new Resolver(
			$container->get('ClassMethod.Remote.Config'),
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
	public function getClassMethodRemoteSet(Container $container): Set
	{
		return new Set(
			$container->get('Package.Tracker'),
			$container->get('Package.Message'),
			$container->get('ClassMethod.Grep'),
			$container->get('ClassMethod.Resolver'),
			$container->get('ClassMethod.Remote.Config'),
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
	public function getClassPropertyResolver(Container $container): Resolver
	{
		return new Resolver(
			$container->get('ClassProperty.Remote.Config'),
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
	public function getClassPropertyRemoteSet(Container $container): Set
	{
		return new Set(
			$container->get('Package.Tracker'),
			$container->get('Package.Message'),
			$container->get('ClassProperty.Grep'),
			$container->get('ClassProperty.Resolver'),
			$container->get('ClassProperty.Remote.Config'),
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
	public function getClassExtendsResolver(Container $container): Resolver
	{
		return new Resolver(
			$container->get('ClassExtends.Remote.Config'),
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
	public function getClassExtendsRemoteSet(Container $container): Set
	{
		return new Set(
			$container->get('Package.Tracker'),
			$container->get('Package.Message'),
			$container->get('ClassExtends.Grep'),
			$container->get('ClassExtends.Resolver'),
			$container->get('ClassExtends.Remote.Config'),
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
	public function getPlaceholderResolver(Container $container): Resolver
	{
		return new Resolver(
			$container->get('Placeholder.Remote.Config'),
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
	public function getPlaceholderRemoteSet(Container $container): Set
	{
		return new Set(
			$container->get('Package.Tracker'),
			$container->get('Package.Message'),
			$container->get('Placeholder.Grep'),
			$container->get('Placeholder.Resolver'),
			$container->get('Placeholder.Remote.Config'),
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
	 * @since   5.1.1
	 */
	public function getFileResolver(Container $container): Resolver
	{
		return new Resolver(
			$container->get('File.Remote.Config'),
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
	 * @return  SetFile
	 * @since   5.1.1
	 */
	public function getFileRemoteSet(Container $container): SetFile
	{
		return new SetFile(
			$container->get('Package.Tracker'),
			$container->get('Package.Message'),
			$container->get('File.Grep'),
			$container->get('File.Resolver'),
			$container->get('File.Remote.Config'),
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
	 * @since   5.1.1
	 */
	public function getFolderResolver(Container $container): Resolver
	{
		return new Resolver(
			$container->get('Folder.Remote.Config'),
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
	 * @return  SetFolder
	 * @since   5.1.1
	 */
	public function getFolderRemoteSet(Container $container): SetFolder
	{
		return new SetFolder(
			$container->get('Package.Tracker'),
			$container->get('Package.Message'),
			$container->get('Folder.Grep'),
			$container->get('Folder.Resolver'),
			$container->get('Folder.Remote.Config'),
			$container->get('Children.Readme.Item'),
			$container->get('Children.Readme.Main'),
			$container->get('Git.Repository.Contents'),
			$container->get('Data.Items'),
			$container->get('Config')->approved_package_paths
		);
	}
}

