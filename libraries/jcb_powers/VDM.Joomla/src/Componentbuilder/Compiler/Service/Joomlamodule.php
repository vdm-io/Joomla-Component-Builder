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
use VDM\Joomla\Componentbuilder\Compiler\Joomlamodule\Data as JoomlaModuleData;


/**
 * Joomla Module Service Provider
 * 
 * @since 3.2.0
 */
class Joomlamodule implements ServiceProviderInterface
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
		$container->alias(JoomlaModuleData::class, 'Joomlamodule.Data')
			->share('Joomlamodule.Data', [$this, 'getJoomlaModuleData'], true);
	}

	/**
	 * Get the Joomla Module Data
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  JoomlaModuleData
	 * @since 3.2.0
	 */
	public function getJoomlaModuleData(Container $container): JoomlaModuleData
	{
		return new JoomlaModuleData(
			$container->get('Config'),
			$container->get('Customcode'),
			$container->get('Customcode.Gui'),
			$container->get('Placeholder'),
			$container->get('Language'),
			$container->get('Field'),
			$container->get('Field.Name'),
			$container->get('Model.Filesfolders'),
			$container->get('Model.Libraries'),
			$container->get('Dynamicget.Data')
		);
	}

}

