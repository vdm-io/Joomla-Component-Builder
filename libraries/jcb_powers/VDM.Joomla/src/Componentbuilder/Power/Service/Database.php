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

namespace VDM\Joomla\Componentbuilder\Power\Service;


use Joomla\DI\Container;
use Joomla\DI\ServiceProviderInterface;
use VDM\Joomla\Componentbuilder\Power\Model\Load as ModelLoad;
use VDM\Joomla\Componentbuilder\Power\Model\Upsert as ModelUpsert;
use VDM\Joomla\Componentbuilder\Power\Database\Load as LoadDatabase;
use VDM\Joomla\Componentbuilder\Power\Database\Insert as InsertDatabase;
use VDM\Joomla\Componentbuilder\Power\Database\Update as UpdateDatabase;


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
		$container->alias(ModelLoad::class, 'Power.Model.Load')
			->share('Power.Model.Load', [$this, 'getModelLoad'], true);

		$container->alias(ModelUpsert::class, 'Power.Model.Upsert')
			->share('Power.Model.Upsert', [$this, 'getModelUpsert'], true);

		$container->alias(LoadDatabase::class, 'Power.Database.Load')
			->share('Power.Database.Load', [$this, 'getLoadDatabase'], true);

		$container->alias(InsertDatabase::class, 'Power.Database.Insert')
			->share('Power.Database.Insert', [$this, 'getInsertDatabase'], true);

		$container->alias(UpdateDatabase::class, 'Power.Database.Update')
			->share('Power.Database.Update', [$this, 'getUpdateDatabase'], true);
	}

	/**
	 * Get the Power Model Load
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  ModelLoad
	 * @since 3.2.0
	 */
	public function getModelLoad(Container $container): ModelLoad
	{
		return new ModelLoad(
			$container->get('Table')
		);
	}

	/**
	 * Get the Power Model Update or Insert
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  ModelUpsert
	 * @since 3.2.0
	 */
	public function getModelUpsert(Container $container): ModelUpsert
	{
		return new ModelUpsert(
			$container->get('Table')
		);
	}

	/**
	 * Get the Load Database
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  LoadDatabase
	 * @since 3.2.0
	 */
	public function getLoadDatabase(Container $container): LoadDatabase
	{
		return new LoadDatabase(
			$container->get('Power.Model.Load'),
			$container->get('Load')
		);
	}

	/**
	 * Get the Insert Database
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  InsertDatabase
	 * @since 3.2.0
	 */
	public function getInsertDatabase(Container $container): InsertDatabase
	{
		return new InsertDatabase(
			$container->get('Power.Model.Upsert'),
			$container->get('Insert')
		);
	}

	/**
	 * Get the Update Database
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  UpdateDatabase
	 * @since 3.2.0
	 */
	public function getUpdateDatabase(Container $container): UpdateDatabase
	{
		return new UpdateDatabase(
			$container->get('Power.Model.Upsert'),
			$container->get('Update')
		);
	}
}

