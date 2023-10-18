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

namespace VDM\Joomla\Componentbuilder\Service;


use Joomla\DI\Container;
use Joomla\DI\ServiceProviderInterface;
use VDM\Joomla\Database\Load;
use VDM\Joomla\Database\Insert;
use VDM\Joomla\Database\Update;


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
		$container->alias(Load::class, 'Load')
			->share('Load', [$this, 'getLoad'], true);

		$container->alias(Insert::class, 'Insert')
			->share('Insert', [$this, 'getInsert'], true);

		$container->alias(Update::class, 'Update')
			->share('Update', [$this, 'getUpdate'], true);
	}

	/**
	 * Get the Core Load Database
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Load
	 * @since 3.2.0
	 */
	public function getLoad(Container $container): Load
	{
		return new Load();
	}

	/**
	 * Get the Core Insert Database
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Insert
	 * @since 3.2.0
	 */
	public function getInsert(Container $container): Insert
	{
		return new Insert();
	}

	/**
	 * Get the Core Update Database
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Update
	 * @since 3.2.0
	 */
	public function getUpdate(Container $container): Update
	{
		return new Update();
	}
}

