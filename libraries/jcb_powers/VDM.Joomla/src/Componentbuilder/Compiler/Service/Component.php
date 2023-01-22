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
use VDM\Joomla\Componentbuilder\Compiler\Component as ComponentObject;
use VDM\Joomla\Componentbuilder\Compiler\Component\Placeholder as ComponentPlaceholder;
use VDM\Joomla\Componentbuilder\Compiler\Component\Data as ComponentData;


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
		$container->alias(ComponentObject::class, 'Component')
			->share('Component', [$this, 'getComponent'], true);

		$container->alias(ComponentPlaceholder::class, 'Component.Placeholder')
			->share('Component.Placeholder', [$this, 'getComponentPlaceholder'], true);

		$container->alias(ComponentData::class, 'Component.Data')
			->share('Component.Data', [$this, 'getComponentData'], true);
	}

	/**
	 * Get the Component
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  ComponentObject
	 * @since 3.2.0
	 */
	public function getComponent(Container $container): ComponentObject
	{
		return new ComponentObject(
			$container->get('Component.Data')
		);
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

	/**
	 * Get the Component Data
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  ComponentData
	 * @since 3.2.0
	 */
	public function getComponentData(Container $container): ComponentData
	{
		return new ComponentData(
			$container->get('Config'),
			$container->get('Event'),
			$container->get('Placeholder'),
			$container->get('Component.Placeholder'),
			$container->get('Customcode.Dispenser'),
			$container->get('Customcode'),
			$container->get('Customcode.Gui'),
			$container->get('Field'),
			$container->get('Field.Name'),
			$container->get('Field.Unique.Name'),
			$container->get('Model.Filesfolders'),
			$container->get('Model.Historycomponent'),
			$container->get('Model.Whmcs'),
			$container->get('Model.Sqltweaking'),
			$container->get('Model.Adminviews'),
			$container->get('Model.Siteviews'),
			$container->get('Model.Customadminviews'),
			$container->get('Model.Joomlamodules'),
			$container->get('Model.Joomlaplugins')
		);
	}
}

