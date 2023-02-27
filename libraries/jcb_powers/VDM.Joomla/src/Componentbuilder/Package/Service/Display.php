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

namespace VDM\Joomla\Componentbuilder\Package\Service;


use Joomla\DI\Container;
use Joomla\DI\ServiceProviderInterface;
use VDM\Joomla\Componentbuilder\Package\Display\Details;


/**
 * Display Service Provider
 * 
 * @since 3.2.0
 */
class Display implements ServiceProviderInterface
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
		$container->alias(Details::class, 'Display.Details')
			->share('Display.Details', [$this, 'getDetails'], true);
	}

	/**
	 * Get the Display Details
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Details
	 * @since 3.2.0
	 */
	public function getDetails(Container $container): Details
	{
		return new Details();
	}

}

