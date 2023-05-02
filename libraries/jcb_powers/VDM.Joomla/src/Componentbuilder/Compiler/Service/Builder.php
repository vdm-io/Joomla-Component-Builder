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

namespace VDM\Joomla\Componentbuilder\Compiler\Service;


use Joomla\DI\Container;
use Joomla\DI\ServiceProviderInterface;
use VDM\Joomla\Componentbuilder\Compiler\Builder\Update\Mysql;


/**
 * Builder Service Provider
 * 
 * @since 3.2.0
 */
class Builder implements ServiceProviderInterface
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
		$container->alias(Mysql::class, 'Builder.Update.Mysql')
			->share('Builder.Update.Mysql', [$this, 'getMysql'], true);
	}

	/**
	 * Get the Compiler Builder Mysql
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Mysql
	 * @since 3.2.0
	 */
	public function getMysql(Container $container): Mysql
	{
		return new Mysql();
	}

}

