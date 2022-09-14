<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Search\Service;


use Joomla\DI\Container;
use Joomla\DI\ServiceProviderInterface;
use VDM\Joomla\Componentbuilder\Search\Database\Get as GetDatabase;
use VDM\Joomla\Componentbuilder\Search\Database\Set as SetDatabase;


/**
 * Database Service Provider
 * 
 * @since 3.2.0
 */
class Database implements ServiceProviderInterface
{
	/**
	 * Registers the service provider with a DI container.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function register(Container $container)
	{
		$container->alias(GetDatabase::class, 'Get.Database')
			->share('Get.Database', [$this, 'getDatabaseGet'], true);

		$container->alias(SetDatabase::class, 'Set.Database')
			->share('Set.Database', [$this, 'getDatabaseSet'], true);
	}

	/**
	 * Get the Get Database
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  GetDatabase
	 * @since 3.2.0
	 */
	public function getDatabaseGet(Container $container): GetDatabase
	{
		return new GetDatabase(
			$container->get('Config'),
			$container->get('Table'),
			$container->get('Get.Model')
		);
	}

	/**
	 * Get the Set Database
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  SetDatabase
	 * @since 3.2.0
	 */
	public function getDatabaseSet(Container $container): SetDatabase
	{
		return new SetDatabase(
			$container->get('Config'),
			$container->get('Table'),
			$container->get('Set.Model')
		);
	}

}

