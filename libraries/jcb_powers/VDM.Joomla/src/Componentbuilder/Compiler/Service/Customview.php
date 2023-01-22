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
use VDM\Joomla\Componentbuilder\Compiler\Customview\Data as CustomviewData;
use VDM\Joomla\Componentbuilder\Compiler\Dynamicget\Data as DynamicgetData;
use VDM\Joomla\Componentbuilder\Compiler\Dynamicget\Selection as DynamicgetSelection;


/**
 * Compiler Customview
 * 
 * @since 3.2.0
 */
class Customview implements ServiceProviderInterface
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
		$container->alias(CustomviewData::class, 'Customview.Data')
			->share('Customview.Data', [$this, 'getCustomviewData'], true);

		$container->alias(DynamicgetData::class, 'Dynamicget.Data')
			->share('Dynamicget.Data', [$this, 'getDynamicgetData'], true);

		$container->alias(DynamicgetSelection::class, 'Dynamicget.Selection')
			->share('Dynamicget.Selection', [$this, 'getDynamicgetSelection'], true);
	}

	/**
	 * Get the Compiler Customview Data
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  CustomviewData
	 * @since 3.2.0
	 */
	public function getCustomviewData(Container $container): CustomviewData
	{
		return new CustomviewData(
			$container->get('Config'),
			$container->get('Event'),
			$container->get('Customcode'),
			$container->get('Customcode.Gui'),
			$container->get('Model.Libraries'),
			$container->get('Templatelayout.Data'),
			$container->get('Dynamicget.Data'),
			$container->get('Model.Loader'),
			$container->get('Model.Javascriptcustomview'),
			$container->get('Model.Csscustomview'),
			$container->get('Model.Phpcustomview'),
			$container->get('Model.Ajaxcustomview'),
			$container->get('Model.Custombuttons')
		);
	}

	/**
	 * Get the Compiler Dynamicget Data
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  DynamicgetData
	 * @since 3.2.0
	 */
	public function getDynamicgetData(Container $container): DynamicgetData
	{
		return new DynamicgetData(
			$container->get('Config'),
			$container->get('Registry'),
			$container->get('Event'),
			$container->get('Customcode'),
			$container->get('Customcode.Dispenser'),
			$container->get('Customcode.Gui'),
			$container->get('Model.Dynamicget')
		);
	}

	/**
	 * Get the Compiler Dynamicget Selection
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  DynamicgetSelection
	 * @since 3.2.0
	 */
	public function getDynamicgetSelection(Container $container): DynamicgetSelection
	{
		return new DynamicgetSelection(
			$container->get('Config'),
			$container->get('Registry')
		);
	}

}

