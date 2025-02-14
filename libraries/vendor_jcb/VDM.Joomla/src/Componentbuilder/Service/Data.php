<?php
/**
 * @package    GetBible
 *
 * @created    30th May, 2023
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        GetBible <https://git.vdm.dev/getBible>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Service;


use Joomla\DI\Container;
use Joomla\DI\ServiceProviderInterface;
use VDM\Joomla\Componentbuilder\Data\Migrator\Guid;


/**
 * The Componentbuilder Data Service
 * 
 * @since 5.0.4
 */
class Data implements ServiceProviderInterface
{
	/**
	 * Registers the service provider with a DI container.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  void
	 * @since 5.0.4
	 */
	public function register(Container $container)
	{
		$container->alias(Guid::class, 'Component.Data.Migrator.Guid')
			->share('Component.Data.Migrator.Guid', [$this, 'getMigratorGuid'], true);
	}

	/**
	 * Get The Migrator to Guid Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Guid
	 * @since 5.0.4
	 */
	public function getMigratorGuid(Container $container): Guid
	{
		return new Guid(
			$container->get('Data.Migrator.Guid')
		);
	}
}

