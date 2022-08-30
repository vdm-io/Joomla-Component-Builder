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
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\GetScriptInterface;
use VDM\Joomla\Componentbuilder\Compiler\Extension\JoomlaThree\InstallScript as J3InstallScript;


/**
 * Extension Script Service Provider
 * 
 * @since 3.2.0
 */
class Extension implements ServiceProviderInterface
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
		$container->alias(J3InstallScript::class, 'J3.Extension.InstallScript')
			->share('J3.Extension.InstallScript', [$this, 'getJ3ExtensionInstallScript'], true);
	}

	/**
	 * Get the Joomla 3 Extension Install Script
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  GetScriptInterface
	 * @since 3.2.0
	 */
	public function getJ3ExtensionInstallScript(Container $container): GetScriptInterface
	{
		return new J3InstallScript();
	}
}

