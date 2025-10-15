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
use VDM\Joomla\Componentbuilder\Compiler\Extension\JoomlaFour\InstallScript as J4InstallScript;
use VDM\Joomla\Componentbuilder\Compiler\Extension\JoomlaFive\InstallScript as J5InstallScript;
use VDM\Joomla\Componentbuilder\Compiler\Extension\JoomlaSix\InstallScript as J6InstallScript;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\MoveFieldsRulesInterface as MoveFieldsRules;
use VDM\Joomla\Componentbuilder\Compiler\Extension\JoomlaThree\MoveFieldsRules as J3MoveFieldsRules;
use VDM\Joomla\Componentbuilder\Compiler\Extension\JoomlaFour\MoveFieldsRules as J4MoveFieldsRules;
use VDM\Joomla\Componentbuilder\Compiler\Extension\JoomlaFive\MoveFieldsRules as J5MoveFieldsRules;
use VDM\Joomla\Componentbuilder\Compiler\Extension\JoomlaSix\MoveFieldsRules as J6MoveFieldsRules;
use VDM\Joomla\Componentbuilder\Compiler\Extension\Files\Updater;
use VDM\Joomla\Componentbuilder\Compiler\Extension\FileContent;
use VDM\Joomla\Componentbuilder\Compiler\Extension\Files\StaticFiles;
use VDM\Joomla\Componentbuilder\Compiler\Extension\Files\Dynamic;
use VDM\Joomla\Componentbuilder\Compiler\Extension\Files\Module;
use VDM\Joomla\Componentbuilder\Compiler\Extension\Files\Plugin;
use VDM\Joomla\Componentbuilder\Compiler\Extension\Files\Power;


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

		$container->alias(J4InstallScript::class, 'J4.Extension.InstallScript')
			->share('J4.Extension.InstallScript', [$this, 'getJ4ExtensionInstallScript'], true);

		$container->alias(J5InstallScript::class, 'J5.Extension.InstallScript')
			->share('J5.Extension.InstallScript', [$this, 'getJ5ExtensionInstallScript'], true);

		$container->alias(J6InstallScript::class, 'J6.Extension.InstallScript')
			->share('J6.Extension.InstallScript', [$this, 'getJ6ExtensionInstallScript'], true);

		$container->alias(MoveFieldsRules::class, 'Extension.MoveFieldsRules')
			->share('Extension.MoveFieldsRules', [$this, 'getMoveFieldsRules'], true);

		$container->alias(J3MoveFieldsRules::class, 'J3.Extension.MoveFieldsRules')
			->share('J3.Extension.MoveFieldsRules', [$this, 'getJ3MoveFieldsRules'], true);

		$container->alias(J4MoveFieldsRules::class, 'J4.Extension.MoveFieldsRules')
			->share('J4.Extension.MoveFieldsRules', [$this, 'getJ4MoveFieldsRules'], true);

		$container->alias(J5MoveFieldsRules::class, 'J5.Extension.MoveFieldsRules')
			->share('J5.Extension.MoveFieldsRules', [$this, 'getJ5MoveFieldsRules'], true);

		$container->alias(J6MoveFieldsRules::class, 'J6.Extension.MoveFieldsRules')
			->share('J6.Extension.MoveFieldsRules', [$this, 'getJ6MoveFieldsRules'], true);

		$container->alias(Updater::class, 'Extension.Files.Updater')
			->share('Extension.Files.Updater', [$this, 'getUpdater'], true);

		$container->alias(FileContent::class, 'Extension.File.Content')
			->share('Extension.File.Content', [$this, 'getFileContent'], true);

		$container->alias(StaticFiles::class, 'Extension.Files.Static')
			->share('Extension.Files.Static', [$this, 'getStaticFiles'], true);

		$container->alias(Dynamic::class, 'Extension.Files.Dynamic')
			->share('Extension.Files.Dynamic', [$this, 'getDynamic'], true);

		$container->alias(Module::class, 'Extension.Files.Module')
			->share('Extension.Files.Module', [$this, 'getModule'], true);

		$container->alias(Plugin::class, 'Extension.Files.Plugin')
			->share('Extension.Files.Plugin', [$this, 'getPlugin'], true);

		$container->alias(Power::class, 'Extension.Files.Power')
			->share('Extension.Files.Power', [$this, 'getPower'], true);
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
	 * Get the Joomla 4 Extension Install Script
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J4InstallScript
	 * @since 3.2.0
	 */
	public function getJ4ExtensionInstallScript(Container $container): J4InstallScript
	{
		return new J4InstallScript();
	}

	/**
	 * Get the Joomla 5 Extension Install Script
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J5InstallScript
	 * @since 3.2.0
	 */
	public function getJ5ExtensionInstallScript(Container $container): J5InstallScript
	{
		return new J5InstallScript();
	}

	/**
	 * Get the Joomla 6 Extension Install Script
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J6InstallScript
	 * @since   5.1.2
	 */
	public function getJ6ExtensionInstallScript(Container $container): J6InstallScript
	{
		return new J6InstallScript();
	}

	/**
	 * Get The Move Fields Rules Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  MoveFieldsRules
	 * @since   5.1.2
	 */
	public function getMoveFieldsRules(Container $container): MoveFieldsRules
	{
		if (empty($this->targetVersion))
		{
			$this->targetVersion = $container->get('Config')->joomla_version;
		}

		return $container->get('J' . $this->targetVersion . '.Extension.MoveFieldsRules');
	}

	/**
	 * Get The Move Fields Rules Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J3MoveFieldsRules
	 * @since   5.1.2
	 */
	public function getJ3MoveFieldsRules(Container $container): J3MoveFieldsRules
	{
		return new J3MoveFieldsRules(
			$container->get('Registry'),
			$container->get('Field'),
			$container->get('Compiler.Builder.Extension.Custom.Fields'),
			$container->get('Utilities.Paths')
		);
	}

	/**
	 * Get The Move Fields Rules Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J4MoveFieldsRules
	 * @since   5.1.2
	 */
	public function getJ4MoveFieldsRules(Container $container): J4MoveFieldsRules
	{
		return new J4MoveFieldsRules(
			$container->get('Registry'),
			$container->get('Field'),
			$container->get('Compiler.Builder.Extension.Custom.Fields'),
			$container->get('Utilities.Paths')
		);
	}

	/**
	 * Get The Move Fields Rules Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J5MoveFieldsRules
	 * @since   5.1.2
	 */
	public function getJ5MoveFieldsRules(Container $container): J5MoveFieldsRules
	{
		return new J5MoveFieldsRules(
			$container->get('Registry'),
			$container->get('Field'),
			$container->get('Compiler.Builder.Extension.Custom.Fields'),
			$container->get('Utilities.Paths')
		);
	}

	/**
	 * Get The Move Fields Rules Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J6MoveFieldsRules
	 * @since   5.1.2
	 */
	public function getJ6MoveFieldsRules(Container $container): J6MoveFieldsRules
	{
		return new J6MoveFieldsRules(
			$container->get('Registry'),
			$container->get('Field'),
			$container->get('Compiler.Builder.Extension.Custom.Fields'),
			$container->get('Utilities.Paths')
		);
	}

	/**
	 * Get The Updater Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Updater
	 * @since   5.1.2
	 */
	public function getUpdater(Container $container): Updater
	{
		return new Updater(
			$container->get('Config'),
			$container->get('Power'),
			$container->get('Power.Extractor'),
			$container->get('Power.Autoloader'),
			$container->get('Utilities.Files'),
			$container->get('Extension.Files.Static'),
			$container->get('Extension.Files.Dynamic'),
			$container->get('Extension.Files.Module'),
			$container->get('Extension.Files.Plugin'),
			$container->get('Extension.Files.Power')
		);
	}

	/**
	 * Get The FileContent Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  FileContent
	 * @since   5.1.2
	 */
	public function getFileContent(Container $container): FileContent
	{
		return new FileContent(
			$container->get('Registry'),
			$container->get('Placeholder'),
			$container->get('Customcode'),
			$container->get('Event'),
			$container->get('Power.Injector'),
			$container->get('Joomla.Power.Injector'),
			$container->get('Compiler.Builder.Content.One'),
			$container->get('Compiler.Builder.Content.Multi'),
			$container->get('Utilities.File'),
			$container->get('Utilities.Counter')
		);
	}

	/**
	 * Get The StaticFiles Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  StaticFiles
	 * @since   5.1.2
	 */
	public function getStaticFiles(Container $container): StaticFiles
	{
		return new StaticFiles(
			$container->get('Utilities.Files'),
			$container->get('Extension.File.Content')
		);
	}

	/**
	 * Get The Dynamic Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Dynamic
	 * @since   5.1.2
	 */
	public function getDynamic(Container $container): Dynamic
	{
		return new Dynamic(
			$container->get('Utilities.Files'),
			$container->get('Compiler.Builder.Content.Multi'),
			$container->get('Extension.File.Content')
		);
	}

	/**
	 * Get The Module Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Module
	 * @since   5.1.2
	 */
	public function getModule(Container $container): Module
	{
		return new Module(
			$container->get('Joomlamodule.Data'),
			$container->get('Extension.MoveFieldsRules'),
			$container->get('Extension.File.Content'),
			$container->get('Compiler.Builder.Content.Multi'),
			$container->get('Utilities.Files')
		);
	}

	/**
	 * Get The Plugin Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Plugin
	 * @since   5.1.2
	 */
	public function getPlugin(Container $container): Plugin
	{
		return new Plugin(
			$container->get('Joomlaplugin.Data'),
			$container->get('Extension.MoveFieldsRules'),
			$container->get('Extension.File.Content'),
			$container->get('Compiler.Builder.Content.Multi'),
			$container->get('Utilities.Files')
		);
	}

	/**
	 * Get The Power Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Power
	 * @since   5.1.2
	 */
	public function getPower(Container $container): Power
	{
		return new Power(
			$container->get('Power'),
			$container->get('Power.Extractor'),
			$container->get('Power.Structure'),
			$container->get('Power.Infusion'),
			$container->get('Extension.File.Content'),
			$container->get('Utilities.Files'),
			$container->get('Compiler.Builder.Content.Multi')
		);
	}
}

