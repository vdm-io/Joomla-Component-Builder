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
use VDM\Joomla\Componentbuilder\Package\Remote\DynamicGet\Set;
use VDM\Joomla\Componentbuilder\Package\DynamicGet\Readme\Item as ItemReadme;
use VDM\Joomla\Componentbuilder\Package\DynamicGet\Readme\Main as MainReadme;


/**
 * Dynamic Get (Set) Service Provider
 * 
 * @since 5.1.1
 */
class DynamicSet implements ServiceProviderInterface
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
		$container->share('DynamicGet.Resolver', [$this, 'getResolver'], true);
		$container->share('DynamicGet.Remote.Set', [$this, 'getRemoteSet'], true);
		$container->share('DynamicGet.Readme.Item', [$this, 'getItemReadme'], true);
		$container->share('DynamicGet.Readme.Main', [$this, 'getMainReadme'], true);
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
			$container->get('DynamicGet.Remote.Config'),
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
			$container->get('DynamicGet.Grep'),
			$container->get('DynamicGet.Resolver'),
			$container->get('DynamicGet.Remote.Config'),
			$container->get('DynamicGet.Readme.Item'),
			$container->get('DynamicGet.Readme.Main'),
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
}

