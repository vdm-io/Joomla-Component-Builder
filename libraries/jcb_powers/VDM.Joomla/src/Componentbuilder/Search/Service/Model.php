<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    3rd September, 2022
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Search\Service;


use Joomla\DI\Container;
use Joomla\DI\ServiceProviderInterface;
use VDM\Joomla\Componentbuilder\Search\Model\Load;
use VDM\Joomla\Componentbuilder\Search\Model\Insert;


/**
 * Model Service Provider
 * 
 * @since 3.2.0
 */
class Model implements ServiceProviderInterface
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
		$container->alias(Load::class, 'Load.Model')
			->share('Load.Model', [$this, 'getModelLoad'], true);

		$container->alias(Insert::class, 'Insert.Model')
			->share('Insert.Model', [$this, 'getModelInsert'], true);
	}

	/**
	 * Get the Load Model
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Load
	 * @since 3.2.0
	 */
	public function getModelLoad(Container $container): Load
	{
		return new Load(
			$container->get('Config'),
			$container->get('Table')
		);
	}

	/**
	 * Get the Insert Model
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Insert
	 * @since 3.2.0
	 */
	public function getModelInsert(Container $container): Insert
	{
		return new Insert(
			$container->get('Config'),
			$container->get('Table')
		);
	}

}

