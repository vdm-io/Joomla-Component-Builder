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

namespace VDM\Joomla\Componentbuilder\Import\Service;


use Joomla\DI\Container;
use Joomla\DI\ServiceProviderInterface;
use VDM\Joomla\Componentbuilder\Import\Data;
use VDM\Joomla\Componentbuilder\Import\Mapper;
use VDM\Joomla\Componentbuilder\Import\Row;
use VDM\Joomla\Componentbuilder\Import\Item;
use VDM\Joomla\Componentbuilder\Import\Message;
use VDM\Joomla\Componentbuilder\Import\Status;
use VDM\Joomla\Componentbuilder\Import\Assessor;


/**
 * Import Service Provider
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
		$container->alias(Data::class, 'Import.Data')
			->share('Import.Data', [$this, 'getData'], true);

		$container->alias(Mapper::class, 'Import.Mapper')
			->share('Import.Mapper', [$this, 'getMapper'], true);

		$container->alias(Row::class, 'Import.Row')
			->share('Import.Row', [$this, 'getRow'], true);

		$container->alias(Item::class, 'Import.Item')
			->share('Import.Item', [$this, 'getItem'], true);

		$container->alias(Message::class, 'Import.Message')
			->share('Import.Message', [$this, 'getMessage'], true);

		$container->alias(Status::class, 'Import.Status')
			->share('Import.Status', [$this, 'getStatus'], true);

		$container->alias(Assessor::class, 'Import.Assessor')
			->share('Import.Assessor', [$this, 'getAssessor'], true);
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

	/**
	 * Get The Item Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Item
	 * @since 5.0.3
	 */
	public function getItem(Container $container): Item
	{
		return new Item(
			$container->get('Table.Validator'),
			$container->get('Data.Item'),
			$container->get('Import.Row')
		);
	}

	/**
	 * Get The Message Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Message
	 * @since 5.0.3
	 */
	public function getMessage(Container $container): Message
	{
		return new Message(
			$container->get('Data.Update'),
			$container->get('Data.Insert')
		);
	}

	/**
	 * Get The Status Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Status
	 * @since 5.0.3
	 */
	public function getStatus(Container $container): Status
	{
		return new Status(
			$container->get('Data.Item')
		);
	}

	/**
	 * Get The Assessor Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Assessor
	 * @since 5.0.3
	 */
	public function getAssessor(Container $container): Assessor
	{
		return new Assessor(
			$container->get('Import.Data'),
			$container->get('Import.Status'),
			$container->get('Import.Message')
		);
	}
}

