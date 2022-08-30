<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler\Service;


use Joomla\DI\Container;
use Joomla\DI\ServiceProviderInterface;
use VDM\Joomla\Componentbuilder\Compiler\Component\Placeholder as ComponentPlaceholder;


/**
 * Component Service Provider
 * 
 * @since 3.2.0
 */
class Component implements ServiceProviderInterface
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
		$container->alias(ComponentPlaceholder::class, 'Component.Placeholder')
			->share('Component.Placeholder', [$this, 'getComponentPlaceholder'], true);
	}

	/**
	 * Get the Component Placeholders
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  ComponentPlaceholder
	 * @since 3.2.0
	 */
	public function getComponentPlaceholder(Container $container): ComponentPlaceholder
	{
		return new ComponentPlaceholder(
			$container->get('Config')
		);
	}
}

