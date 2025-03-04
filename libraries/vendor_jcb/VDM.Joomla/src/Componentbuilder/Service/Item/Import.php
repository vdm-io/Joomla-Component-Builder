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
namespace VDM\Joomla\Componentbuilder\Service\Item;


use Joomla\DI\Container;
use Joomla\DI\ServiceProviderInterface;
use VDM\Joomla\Componentbuilder\Item\Import as ItemImport;
use VDM\Joomla\Componentbuilder\Item\Import\ParentTable;
use VDM\Joomla\Componentbuilder\Item\Import\JoinTables;
use VDM\Joomla\Componentbuilder\Spreadsheet\RowDataArray;


/**
 * Item Service Provider
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
		$container->alias(ItemImport::class, 'Item.Import')
			->share('Item.Import', [$this, 'getItemImport'], true);

		$container->alias(ParentTable::class, 'Import.ParentTable')
			->share('Import.ParentTable', [$this, 'getParentTable'], true);

		$container->alias(JoinTables::class, 'Import.JoinTables')
			->share('Import.JoinTables', [$this, 'getJoinTables'], true);

		$container->alias(RowDataArray::class, 'Item.RowDataArray')
			->share('Item.RowDataArray', [$this, 'getRowDataArray'], true);
	}

	/**
	 * Get The Import Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  ItemImport
	 * @since 5.0.2
	 */
	public function getItemImport(Container $container): ItemImport
	{
		return new ItemImport(
			$container->get('Import.Status'),
			$container->get('Import.Message'),
			$container->get('Import.Mapper'),
			$container->get('Import.Data'),
			$container->get('Spreadsheet.Importer'),
			$container->get('Item.RowDataArray'),
			$container->get('Import.Row'),
			$container->get('Import.ParentTable'),
			$container->get('Import.JoinTables'),
			$container->get('Import.Assessor'),
			$container->get('Data.Item')
		);
	}

	/**
	 * Get The ParentTable Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  ParentTable
	 * @since 5.0.2
	 */
	public function getParentTable(Container $container): ParentTable
	{
		return new ParentTable(
			$container->get('Import.Row'),
			$container->get('Import.Item'),
			$container->get('Import.Mapper'),
			$container->get('Import.Message'),
			$container->get('Import.Data'),
			$container->get('Data.Item'),
			$container->get('Load')
		);
	}

	/**
	 * Get The JoinTables Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  JoinTables
	 * @since 5.0.2
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
	 * Get The RowDataArray Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  RowDataArray
	 * @since 5.0.2
	 */
	public function getRowDataArray(Container $container): RowDataArray
	{
		return new RowDataArray();
	}
}

