<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    4th September, 2020
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
namespace VDM\Joomla\Componentbuilder\Service;


use Joomla\DI\Container;
use Joomla\DI\ServiceProviderInterface;
use VDM\Joomla\Componentbuilder\Import\Item\Persistent;
use VDM\Joomla\Componentbuilder\Import\Status;
use VDM\Joomla\Componentbuilder\Import\Persistent\Message;
use VDM\Joomla\Componentbuilder\Import\Persistent\Assessor as PersistentAssessor;
use VDM\Joomla\Componentbuilder\Import\Item\Transient;
use VDM\Joomla\Componentbuilder\Import\Assessor;
use VDM\Joomla\Componentbuilder\Import\Item;


/**
 * Componentbuilder Import Service Provider
 * 
 * @since  5.0.2
 */
class Import implements ServiceProviderInterface
{
	/**
	 * Registers the service provider with a DI container.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  void
	 * @since 5.0.2
	 */
	public function register(Container $container)
	{
		$container->alias(Persistent::class, 'Import.Persistent')
			->share('Import.Persistent', [$this, 'getPersistent'], true);

		$container->alias(Status::class, 'Import.Status')
			->share('Import.Status', [$this, 'getStatus'], true);

		$container->alias(Message::class, 'Import.Persistent.Message')
			->share('Import.Persistent.Message', [$this, 'getMessage'], true);

		$container->alias(PersistentAssessor::class, 'Import.Persistent.Assessor')
			->share('Import.Persistent.Assessor', [$this, 'getPersistentAssessor'], true);

		$container->alias(Transient::class, 'Import.Transient')
			->share('Import.Transient', [$this, 'getTransient'], true);

		$container->alias(Assessor::class, 'Import.Assessor')
			->share('Import.Assessor', [$this, 'getAssessor'], true);

		$container->alias(Item::class, 'Import.Item')
			->share('Import.Item', [$this, 'getItem'], true);
	}

	/**
	 * Get The Persistent Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Persistent
	 * @since 5.0.2
	 */
	public function getPersistent(Container $container): Persistent
	{
		return new Persistent(
			$container->get('Import.Status'),
			$container->get('Import.Persistent.Message'),
			$container->get('Import.Mapper'),
			$container->get('Import.Data'),
			$container->get('Spreadsheet.Reader'),
			$container->get('Spreadsheet.RowDataArray'),
			$container->get('Import.Row'),
			$container->get('Import.ParentTable'),
			$container->get('Import.JoinTables'),
			$container->get('Import.Persistent.Assessor'),
			$container->get('Data.Item'),
			$container->get('Import.Persistent.Entity')
		);
	}

	/**
	 * Get The Status Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Status
	 * @since 5.0.2
	 */
	public function getStatus(Container $container): Status
	{
		return new Status(
			$container->get('Data.Item')
		);
	}

	/**
	 * Get The Message Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Message
	 * @since 5.0.2
	 */
	public function getMessage(Container $container): Message
	{
		return new Message(
			$container->get('Data.Update'),
			$container->get('Data.Insert')
		);
	}

	/**
	 * Get The Assessor Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Assessor
	 * @since 5.1.4
	 */
	public function getAssessor(Container $container): Assessor
	{
		return new Assessor(
			$container->get('Import.Message')
		);
	}

	/**
	 * Get The PersistentAssessor Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  PersistentAssessor
	 * @since 5.0.2
	 */
	public function getPersistentAssessor(Container $container): PersistentAssessor
	{
		return new PersistentAssessor(
			$container->get('Import.Data'),
			$container->get('Import.Status'),
			$container->get('Import.Persistent.Message')
		);
	}

	/**
	 * Get The Transient Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Transient
	 * @since 5.0.2
	 */
	public function getTransient(Container $container): Transient
	{
		return new Transient(
			$container->get('Import.Message'),
			$container->get('Import.Mapper'),
			$container->get('Import.Data'),
			$container->get('Spreadsheet.Reader'),
			$container->get('Spreadsheet.RowDataArray'),
			$container->get('Import.Row'),
			$container->get('Import.ParentTable'),
			$container->get('Import.JoinTables'),
			$container->get('Import.Assessor'),
			$container->get('Import.Entity')
		);
	}

	/**
	 * Get The Item Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Item
	 * @since 5.0.2
	 */
	public function getItem(Container $container): Item
	{
		return new Item(
			$container->get('Table.Validator'),
			$container->get('Data.Item'),
			$container->get('Import.Row')
		);
	}
}

