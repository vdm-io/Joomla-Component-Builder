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
use VDM\Joomla\Componentbuilder\Remote\Set;
use VDM\Joomla\Componentbuilder\Package\Dependency\Resolver;
use VDM\Joomla\Componentbuilder\Package\Children\Readme\Item as ItemReadme;
use VDM\Joomla\Componentbuilder\Package\Children\Readme\Main as MainReadme;
use VDM\Joomla\Componentbuilder\Package\ClassMethod\Remote\Config as ClassMethod;
use VDM\Joomla\Componentbuilder\Package\ClassProperty\Remote\Config as ClassProperty;
use VDM\Joomla\Componentbuilder\Package\ClassExtends\Remote\Config as ClassExtends;
use VDM\Joomla\Componentbuilder\Package\Placeholder\Remote\Config as Placeholder;
use VDM\Joomla\Componentbuilder\Package\GrepContent;
use VDM\Joomla\Componentbuilder\Package\File\Remote\Config as File;
use VDM\Joomla\Componentbuilder\Package\Remote\GetFile;
use VDM\Joomla\Componentbuilder\Package\Remote\SetFile;
use VDM\Joomla\Componentbuilder\Package\Folder\Remote\Config as Folder;
use VDM\Joomla\Componentbuilder\Package\Remote\GetFolder;
use VDM\Joomla\Componentbuilder\Package\Remote\SetFolder;


/**
 * Dependencies Service Provider
 * 
 * @since 5.1.1
 */
class Dependencies implements ServiceProviderInterface
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

		$container->share('ClassMethod.Grep', [$this, 'getClassMethodGrep'], true);
		$container->share('ClassMethod.Remote.Config', [$this, 'getClassMethodRemoteConfig'], true);
		$container->share('ClassMethod.Resolver', [$this, 'getClassMethodResolver'], true);
		$container->share('ClassMethod.Remote.Get', [$this, 'getClassMethodRemoteGet'], true);
		$container->share('ClassMethod.Remote.Set', [$this, 'getClassMethodRemoteSet'], true);

		$container->share('ClassProperty.Grep', [$this, 'getClassPropertyGrep'], true);
		$container->share('ClassProperty.Remote.Config', [$this, 'getClassPropertyRemoteConfig'], true);
		$container->share('ClassProperty.Resolver', [$this, 'getClassPropertyResolver'], true);
		$container->share('ClassProperty.Remote.Get', [$this, 'getClassPropertyRemoteGet'], true);
		$container->share('ClassProperty.Remote.Set', [$this, 'getClassPropertyRemoteSet'], true);

		$container->share('ClassExtends.Grep', [$this, 'getClassExtendsGrep'], true);
		$container->share('ClassExtends.Remote.Config', [$this, 'getClassExtendsRemoteConfig'], true);
		$container->share('ClassExtends.Resolver', [$this, 'getClassExtendsResolver'], true);
		$container->share('ClassExtends.Remote.Get', [$this, 'getClassExtendsRemoteGet'], true);
		$container->share('ClassExtends.Remote.Set', [$this, 'getClassExtendsRemoteSet'], true);

		$container->share('Placeholder.Grep', [$this, 'getPlaceholderGrep'], true);
		$container->share('Placeholder.Remote.Config', [$this, 'getPlaceholderRemoteConfig'], true);
		$container->share('Placeholder.Resolver', [$this, 'getPlaceholderResolver'], true);
		$container->share('Placeholder.Remote.Get', [$this, 'getPlaceholderRemoteGet'], true);
		$container->share('Placeholder.Remote.Set', [$this, 'getPlaceholderRemoteSet'], true);

		$container->share('File.Grep', [$this, 'getFileGrep'], true);
		$container->share('File.Remote.Config', [$this, 'getFileRemoteConfig'], true);
		$container->share('File.Resolver', [$this, 'getFileResolver'], true);
		$container->share('File.Remote.Get', [$this, 'getFileRemoteGet'], true);
		$container->share('File.Remote.Set', [$this, 'getFileRemoteSet'], true);

		$container->share('Folder.Grep', [$this, 'getFolderGrep'], true);
		$container->share('Folder.Remote.Config', [$this, 'getFolderRemoteConfig'], true);
		$container->share('Folder.Resolver', [$this, 'getFolderResolver'], true);
		$container->share('Folder.Remote.Get', [$this, 'getFolderRemoteGet'], true);
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
			$container->get('Power.Tracker'),
			$container->get('Config')->approved_package_paths
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
	public function getClassMethodRemoteGet(Container $container): Get
	{
		return new Get(
			$container->get('ClassMethod.Remote.Config'),
			$container->get('ClassMethod.Grep'),
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
	public function getClassMethodRemoteSet(Container $container): Set
	{
		return new Set(
			$container->get('Power.Tracker'),
			$container->get('Power.Message'),
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
			$container->get('Power.Tracker'),
			$container->get('Config')->approved_package_paths
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
	public function getClassPropertyRemoteGet(Container $container): Get
	{
		return new Get(
			$container->get('ClassProperty.Remote.Config'),
			$container->get('ClassProperty.Grep'),
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
	public function getClassPropertyRemoteSet(Container $container): Set
	{
		return new Set(
			$container->get('Power.Tracker'),
			$container->get('Power.Message'),
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
			$container->get('Power.Tracker'),
			$container->get('Config')->approved_package_paths
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
	public function getClassExtendsRemoteGet(Container $container): Get
	{
		return new Get(
			$container->get('ClassExtends.Remote.Config'),
			$container->get('ClassExtends.Grep'),
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
	public function getClassExtendsRemoteSet(Container $container): Set
	{
		return new Set(
			$container->get('Power.Tracker'),
			$container->get('Power.Message'),
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
			$container->get('Power.Tracker'),
			$container->get('Config')->approved_package_paths
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
	public function getPlaceholderRemoteGet(Container $container): Get
	{
		return new Get(
			$container->get('Placeholder.Remote.Config'),
			$container->get('Placeholder.Grep'),
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
	public function getPlaceholderRemoteSet(Container $container): Set
	{
		return new Set(
			$container->get('Power.Tracker'),
			$container->get('Power.Message'),
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
			$container->get('Power.Tracker'),
			$container->get('Config')->approved_package_paths
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
			$container->get('Power.Tracker'),
			$container->get('Power.Message')
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
			$container->get('Power.Tracker'),
			$container->get('Power.Message'),
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
			$container->get('Power.Tracker'),
			$container->get('Config')->approved_package_paths
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
			$container->get('Power.Tracker'),
			$container->get('Power.Message')
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
			$container->get('Power.Tracker'),
			$container->get('Power.Message'),
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

