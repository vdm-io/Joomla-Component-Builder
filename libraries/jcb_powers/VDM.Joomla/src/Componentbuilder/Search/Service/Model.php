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
use VDM\Joomla\Componentbuilder\Search\Model\Get;
use VDM\Joomla\Componentbuilder\Search\Model\Set;


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
		$container->alias(Get::class, 'Get.Model')
			->share('Get.Model', [$this, 'getModelGet'], true);

		$container->alias(Set::class, 'Set.Model')
			->share('Set.Model', [$this, 'getModelSet'], true);
	}

	/**
	 * Get the Get Model
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Get
	 * @since 3.2.0
	 */
	public function getModelGet(Container $container): Get
	{
		return new Get(
			$container->get('Config'),
			$container->get('Table')
		);
	}

	/**
	 * Get the Set Model
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Set
	 * @since 3.2.0
	 */
	public function getModelSet(Container $container): Set
	{
		return new Set(
			$container->get('Config'),
			$container->get('Table')
		);
	}

}

