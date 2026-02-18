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

namespace VDM\Joomla\Service;


use Joomla\DI\Container;
use Joomla\DI\ServiceProviderInterface;
use VDM\Joomla\Import\Entity;
use VDM\Joomla\Import\Persistent\Entity as PersistentEntity;
use VDM\Joomla\Import\ParentTable;
use VDM\Joomla\Import\JoinTables;
use VDM\Joomla\Import\Message;
use VDM\Joomla\Import\Data;
use VDM\Joomla\Import\Mapper;
use VDM\Joomla\Import\Row;


/**
 * Core Import Service Provider
 * 
 * @since  5.0.3
 */
class Import implements ServiceProviderInterface
{
	/**
	 * Registers the service provider with a DI container.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  void
	 * @since 5.0.3
	 */
	public function register(Container $container)
	{
		$container->alias(Entity::class, 'Import.Entity')
			->share('Import.Entity', [$this, 'getEntity'], true);

		$container->alias(PersistentEntity::class, 'Import.Persistent.Entity')
			->share('Import.Persistent.Entity', [$this, 'getPersistentEntity'], true);

		$container->alias(ParentTable::class, 'Import.ParentTable')
			->share('Import.ParentTable', [$this, 'getParentTable'], true);

		$container->alias(JoinTables::class, 'Import.JoinTables')
			->share('Import.JoinTables', [$this, 'getJoinTables'], true);

		$container->alias(Message::class, 'Import.Message')
			->share('Import.Message', [$this, 'getMessage'], true);

		$container->alias(Data::class, 'Import.Data')
			->share('Import.Data', [$this, 'getData'], true);

		$container->alias(Mapper::class, 'Import.Mapper')
			->share('Import.Mapper', [$this, 'getMapper'], true);

		$container->alias(Row::class, 'Import.Row')
			->share('Import.Row', [$this, 'getRow'], true);
	}

	/**
	 * Get The Entity Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Entity
	 * @since   5.1.4
	 */
	public function getEntity(Container $container): Entity
	{
		return new Entity();
	}

	/**
	 * Get The Persistent Entity Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  PersistentEntity
	 * @since   5.1.4
	 */
	public function getPersistentEntity(Container $container): PersistentEntity
	{
		return new PersistentEntity();
	}

	/**
	 * Get The Parent Table Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  ParentTable
	 * @since 5.0.3
	 */
	public function getParentTable(Container $container): ParentTable
	{
		return new ParentTable(
			$container->get('Import.Row'),
			$container->get('Import.Item'),
			$container->get('Import.Mapper'),
			$container->get('Import.Data'),
			$container->get('Data.Item'),
			$container->get('Load')
		);
	}

	/**
	 * Get The Join Tables Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  JoinTables
	 * @since 5.0.3
	 */
	public function getJoinTables(Container $container): JoinTables
	{
		return new JoinTables(
			$container->get('Import.Mapper'),
			$container->get('Import.Item'),
			$container->get('Import.Data'),
			$container->get('Data.Item'),
			$container->get('Load')
		);
	}

	/**
	 * Get The Message Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Message
	 * @since 5.1.4
	 */
	public function getMessage(Container $container): Message
	{
		return new Message();
	}

	/**
	 * Get The Data Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Data
	 * @since 5.0.3
	 */
	public function getData(Container $container): Data
	{
		return new Data();
	}

	/**
	 * Get The Mapper Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Mapper
	 * @since 5.0.3
	 */
	public function getMapper(Container $container): Mapper
	{
		return new Mapper(
			$container->get('Table')
		);
	}

	/**
	 * Get The Row Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Row
	 * @since 5.0.3
	 */
	public function getRow(Container $container): Row
	{
		return new Row();
	}
}

