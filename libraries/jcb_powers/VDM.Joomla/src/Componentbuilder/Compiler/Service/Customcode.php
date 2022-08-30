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
use VDM\Joomla\Componentbuilder\Compiler\Customcode as CompilerCustomcode;
use VDM\Joomla\Componentbuilder\Compiler\Customcode\External;
use VDM\Joomla\Componentbuilder\Compiler\Customcode\Gui;


/**
 * Compiler Custom Code Service Provider
 * 
 * @since 3.2.0
 */
class Customcode implements ServiceProviderInterface
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
		$container->alias(CompilerCustomcode::class, 'Customcode')
			->share('Customcode', [$this, 'getCustomcode'], true);

		$container->alias(External::class, 'Customcode.External')
			->share('Customcode.External', [$this, 'getExternal'], true);

		$container->alias(Gui::class, 'Customcode.Gui')
			->share('Customcode.Gui', [$this, 'getGui'], true);
	}

	/**
	 * Get the Compiler Customcode
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  CompilerCustomcode
	 * @since 3.2.0
	 */
	public function getCustomcode(Container $container): CompilerCustomcode
	{
		return new CompilerCustomcode(
			$container->get('Config'),
			$container->get('Placeholder'),
			$container->get('Language.Extractor'),
			$container->get('Customcode.External')
		);
	}

	/**
	 * Get the Compiler Customcode External
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  External
	 * @since 3.2.0
	 */
	public function getExternal(Container $container): External
	{
		return new External(
			$container->get('Placeholder')
		);
	}

	/**
	 * Get the Compiler Customcode Gui
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Gui
	 * @since 3.2.0
	 */
	public function getGui(Container $container): Gui
	{
		return new Gui(
			$container->get('Config'),
			$container->get('Placeholder.Reverse')
		);
	}

}

