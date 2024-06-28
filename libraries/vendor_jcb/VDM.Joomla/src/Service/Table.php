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
use VDM\Joomla\Componentbuilder\Table as DataTable;
use VDM\Joomla\Componentbuilder\Table\Schema;


/**
 * Table Service Provider
 * 
 * @since 3.2.2
 */
class Table implements ServiceProviderInterface
{
	/**
	 * Registers the service provider with a DI container.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  void
	 * @since 3.2.2
	 */
	public function register(Container $container)
	{
		$container->alias(DataTable::class, 'Table')
			->share('Table', [$this, 'getTable'], true);

		$container->alias(Schema::class, 'Table.Schema')
			->share('Table.Schema', [$this, 'getSchema'], true);
	}

	/**
	 * Get The Componentbuilder Data Table Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  DataTable
	 * @since 3.2.2
	 */
	public function getTable(Container $container): DataTable
	{
		return new DataTable();
	}

	/**
	 * Get The Schema Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Schema
	 * @since 3.2.2
	 */
	public function getSchema(Container $container): Schema
	{
		return new Schema(
			$container->get('Table')
		);
	}
}

