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
use VDM\Joomla\Componentbuilder\Compiler\Templatelayout\Data as TemplatelayoutData;
use VDM\Joomla\Componentbuilder\Compiler\Alias\Data as AliasData;


/**
 * Compiler Templatelayout
 * 
 * @since 3.2.0
 */
class Templatelayout implements ServiceProviderInterface
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
		$container->alias(TemplatelayoutData::class, 'Templatelayout.Data')
			->share('Templatelayout.Data', [$this, 'getTemplatelayoutData'], true);

		$container->alias(AliasData::class, 'Alias.Data')
			->share('Alias.Data', [$this, 'getAliasData'], true);
	}

	/**
	 * Get The Data Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  TemplatelayoutData
	 * @since 3.2.0
	 */
	public function getTemplatelayoutData(Container $container): TemplatelayoutData
	{
		return new TemplatelayoutData(
			$container->get('Config'),
			$container->get('Compiler.Builder.Layout.Data'),
			$container->get('Compiler.Builder.Template.Data'),
			$container->get('Alias.Data')
		);
	}

	/**
	 * Get The Data Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  AliasData
	 * @since 3.2.0
	 */
	public function getAliasData(Container $container): AliasData
	{
		return new AliasData(
			$container->get('Config'),
			$container->get('Registry'),
			$container->get('Customcode'),
			$container->get('Customcode.Gui'),
			$container->get('Model.Loader'),
			$container->get('Model.Libraries')
		);
	}
}

