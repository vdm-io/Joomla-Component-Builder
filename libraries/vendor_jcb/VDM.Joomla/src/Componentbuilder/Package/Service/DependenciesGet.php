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
use VDM\Joomla\Componentbuilder\Package\ClassMethod\Remote\Config as ClassMethod;
use VDM\Joomla\Componentbuilder\Package\ClassProperty\Remote\Config as ClassProperty;
use VDM\Joomla\Componentbuilder\Package\ClassExtends\Remote\Config as ClassExtends;
use VDM\Joomla\Componentbuilder\Package\Placeholder\Remote\Config as Placeholder;
use VDM\Joomla\Componentbuilder\Package\GrepContent;
use VDM\Joomla\Componentbuilder\Package\Remote\GetFile;
use VDM\Joomla\Componentbuilder\Package\File\Remote\Config as File;
use VDM\Joomla\Componentbuilder\Package\Remote\GetFolder;
use VDM\Joomla\Componentbuilder\Package\Folder\Remote\Config as Folder;


/**
 * Dependencies Service Get Provider
 * 
 * @since 5.1.1
 */
class DependenciesGet implements ServiceProviderInterface
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
		$container->share('ClassMethod.Grep', [$this, 'getClassMethodGrep'], true);
		$container->share('ClassMethod.Remote.Config', [$this, 'getClassMethodRemoteConfig'], true);
		$container->share('ClassMethod.Remote.Get', [$this, 'getClassMethodRemoteGet'], true);

		$container->share('ClassProperty.Grep', [$this, 'getClassPropertyGrep'], true);
		$container->share('ClassProperty.Remote.Config', [$this, 'getClassPropertyRemoteConfig'], true);
		$container->share('ClassProperty.Remote.Get', [$this, 'getClassPropertyRemoteGet'], true);

		$container->share('ClassExtends.Grep', [$this, 'getClassExtendsGrep'], true);
		$container->share('ClassExtends.Remote.Config', [$this, 'getClassExtendsRemoteConfig'], true);
		$container->share('ClassExtends.Remote.Get', [$this, 'getClassExtendsRemoteGet'], true);

		$container->share('Placeholder.Grep', [$this, 'getPlaceholderGrep'], true);
		$container->share('Placeholder.Remote.Config', [$this, 'getPlaceholderRemoteConfig'], true);
		$container->share('Placeholder.Remote.Get', [$this, 'getPlaceholderRemoteGet'], true);

		$container->share('File.Grep', [$this, 'getFileGrep'], true);
		$container->share('File.Remote.Config', [$this, 'getFileRemoteConfig'], true);
		$container->share('File.Remote.Get', [$this, 'getFileRemoteGet'], true);

		$container->share('Folder.Grep', [$this, 'getFolderGrep'], true);
		$container->share('Folder.Remote.Config', [$this, 'getFolderRemoteConfig'], true);
		$container->share('Folder.Remote.Get', [$this, 'getFolderRemoteGet'], true);
	}

	/**
	 * Get The Grep Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Grep
	 * @since   5.1.1
	 */
	public function getClassMethodGrep(Container $container): Grep
	{
		return new Grep(
			$container->get('ClassMethod.Remote.Config'),
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
	public function getClassMethodRemoteGet(Container $container): Get
	{
		return new Get(
			$container->get('ClassMethod.Remote.Config'),
			$container->get('ClassMethod.Grep'),
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
	 * @return  ClassMethod
	 * @since   5.1.1
	 */
	public function getClassMethodRemoteConfig(Container $container): ClassMethod
	{
		return new ClassMethod(
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
	public function getClassPropertyGrep(Container $container): Grep
	{
		return new Grep(
			$container->get('ClassProperty.Remote.Config'),
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
	public function getClassPropertyRemoteGet(Container $container): Get
	{
		return new Get(
			$container->get('ClassProperty.Remote.Config'),
			$container->get('ClassProperty.Grep'),
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
	 * @return  ClassProperty
	 * @since   5.1.1
	 */
	public function getClassPropertyRemoteConfig(Container $container): ClassProperty
	{
		return new ClassProperty(
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
	public function getClassExtendsGrep(Container $container): Grep
	{
		return new Grep(
			$container->get('ClassExtends.Remote.Config'),
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
	public function getClassExtendsRemoteGet(Container $container): Get
	{
		return new Get(
			$container->get('ClassExtends.Remote.Config'),
			$container->get('ClassExtends.Grep'),
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
	 * @return  ClassExtends
	 * @since   5.1.1
	 */
	public function getClassExtendsRemoteConfig(Container $container): ClassExtends
	{
		return new ClassExtends(
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
	public function getPlaceholderGrep(Container $container): Grep
	{
		return new Grep(
			$container->get('Placeholder.Remote.Config'),
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
	public function getPlaceholderRemoteGet(Container $container): Get
	{
		return new Get(
			$container->get('Placeholder.Remote.Config'),
			$container->get('Placeholder.Grep'),
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
	 * @return  Placeholder
	 * @since   5.1.1
	 */
	public function getPlaceholderRemoteConfig(Container $container): Placeholder
	{
		return new Placeholder(
			$container->get('Power.Table')
		);
	}

	/**
	 * Get The Grep Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  GrepContent
	 * @since   5.1.1
	 */
	public function getFileGrep(Container $container): GrepContent
	{
		return new GrepContent(
			$container->get('File.Remote.Config'),
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
	 * @return  GetFile
	 * @since   5.1.1
	 */
	public function getFileRemoteGet(Container $container): GetFile
	{
		return new GetFile(
			$container->get('File.Remote.Config'),
			$container->get('File.Grep'),
			$container->get('Data.Item'),
			$container->get('Utilities.Normalize'),
			$container->get('Package.Tracker'),
			$container->get('Package.Message')
		);
	}

	/**
	 * Get The Remote Config Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  File
	 * @since   5.1.1
	 */
	public function getFileRemoteConfig(Container $container): File
	{
		return new File(
			$container->get('Power.Table')
		);
	}

	/**
	 * Get The Grep Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  GrepContent
	 * @since   5.1.1
	 */
	public function getFolderGrep(Container $container): GrepContent
	{
		return new GrepContent(
			$container->get('Folder.Remote.Config'),
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
	 * @return  GetFolder
	 * @since   5.1.1
	 */
	public function getFolderRemoteGet(Container $container): GetFolder
	{
		return new GetFolder(
			$container->get('Folder.Remote.Config'),
			$container->get('Folder.Grep'),
			$container->get('Data.Item'),
			$container->get('Utilities.Normalize'),
			$container->get('Package.Tracker'),
			$container->get('Package.Message')
		);
	}

	/**
	 * Get The Remote Config Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Folder
	 * @since   5.1.1
	 */
	public function getFolderRemoteConfig(Container $container): Folder
	{
		return new Folder(
			$container->get('Power.Table')
		);
	}
}

