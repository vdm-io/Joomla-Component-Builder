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
	 * Current Joomla Version Being Build
	 *
	 * @var     int
	 * @since 3.2.0
	 **/
	protected $targetVersion;

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
		$container->alias(GetScriptInterface::class, 'Extension.InstallScript')
			->share('Extension.InstallScript', [$this, 'getExtensionInstallScript'], true);

		$container->alias(J3InstallScript::class, 'J3.Extension.InstallScript')
			->share('J3.Extension.InstallScript', [$this, 'getJ3ExtensionInstallScript'], true);
	}

	/**
	 * Get the Joomla 3 Extension Install Script
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J3InstallScript
	 * @since 3.2.0
	 */
	public function getJ3ExtensionInstallScript(Container $container): J3InstallScript
	{
		return new J3InstallScript();
	}

	/**
	 * Get the Joomla Extension Install Script
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  GetScriptInterface
	 * @since 3.2.0
	 */
	public function getExtensionInstallScript(Container $container): GetScriptInterface
	{
		if (empty($this->targetVersion))
		{
			$this->targetVersion = $container->get('Config')->joomla_version;
		}

		return $container->get('J' . $this->targetVersion . '.Extension.InstallScript');
	}

}

