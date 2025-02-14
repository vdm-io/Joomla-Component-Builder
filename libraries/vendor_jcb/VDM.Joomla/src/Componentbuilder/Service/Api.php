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

namespace VDM\Joomla\Componentbuilder\Service;


use Joomla\DI\Container;
use Joomla\DI\ServiceProviderInterface;
use VDM\Joomla\Componentbuilder\Api\Network;


/**
 * The Joomla Component Builder Api Service
 * 
 * @since 5.0.4
 */
class Api implements ServiceProviderInterface
{
	/**
	 * Registers the service provider with a DI container.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  void
	 * @since   5.0.4
	 */
	public function register(Container $container)
	{
		$container->alias(Network::class, 'Api.Network')
			->share('Api.Network', [$this, 'getNetwork'], true);
	}

	/**
	 * Get The Network Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Network
	 * @since   5.0.4
	 */
	public function getNetwork(Container $container): Network
	{
		return new Network(
			$container->get('Utilities.Http'),
			$container->get('Utilities.Uri'),
			$container->get('Utilities.Response')
		);
	}
}

