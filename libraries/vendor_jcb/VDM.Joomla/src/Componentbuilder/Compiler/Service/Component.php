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
use VDM\Joomla\Componentbuilder\Compiler\Component as CompilerComponent;
use VDM\Joomla\Componentbuilder\Compiler\Component\JoomlaThree\Settings as J3Settings;
use VDM\Joomla\Componentbuilder\Compiler\Component\JoomlaFour\Settings as J4Settings;
use VDM\Joomla\Componentbuilder\Compiler\Component\JoomlaFive\Settings as J5Settings;
use VDM\Joomla\Componentbuilder\Compiler\Component\Dashboard;
use VDM\Joomla\Componentbuilder\Compiler\Component\Placeholder;
use VDM\Joomla\Componentbuilder\Compiler\Component\Data;
use VDM\Joomla\Componentbuilder\Compiler\Component\Structure;
use VDM\Joomla\Componentbuilder\Compiler\Component\Structuresingle;
use VDM\Joomla\Componentbuilder\Compiler\Component\Structuremultiple;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Component\SettingsInterface as Settings;


/**
 * Component Service Provider
 * 
 * @since 3.2.0
 */
class Component implements ServiceProviderInterface
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
		$container->alias(CompilerComponent::class, 'Component')
			->share('Component', [$this, 'getCompilerComponent'], true);

		$container->alias(J3Settings::class, 'Component.J3.Settings')
			->share('Component.J3.Settings', [$this, 'getJ3Settings'], true);

		$container->alias(J4Settings::class, 'Component.J4.Settings')
			->share('Component.J4.Settings', [$this, 'getJ4Settings'], true);

		$container->alias(J5Settings::class, 'Component.J5.Settings')
			->share('Component.J5.Settings', [$this, 'getJ5Settings'], true);

		$container->alias(Dashboard::class, 'Component.Dashboard')
			->share('Component.Dashboard', [$this, 'getDashboard'], true);

		$container->alias(Placeholder::class, 'Component.Placeholder')
			->share('Component.Placeholder', [$this, 'getPlaceholder'], true);

		$container->alias(Data::class, 'Component.Data')
			->share('Component.Data', [$this, 'getData'], true);

		$container->alias(Structure::class, 'Component.Structure')
			->share('Component.Structure', [$this, 'getStructure'], true);

		$container->alias(Structuresingle::class, 'Component.Structure.Single')
			->share('Component.Structure.Single', [$this, 'getStructuresingle'], true);

		$container->alias(Structuremultiple::class, 'Component.Structure.Multiple')
			->share('Component.Structure.Multiple', [$this, 'getStructuremultiple'], true);

		$container->alias(Settings::class, 'Component.Settings')
			->share('Component.Settings', [$this, 'getSettings'], true);
	}

	/**
	 * Get The Component Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  CompilerComponent
	 * @since 3.2.0
	 */
	public function getCompilerComponent(Container $container): CompilerComponent
	{
		return new CompilerComponent(
			$container->get('Component.Data')
		);
	}

	/**
	 * Get The Settings Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J3Settings
	 * @since 3.2.0
	 */
	public function getJ3Settings(Container $container): J3Settings
	{
		return new J3Settings(
			$container->get('Config'),
			$container->get('Registry'),
			$container->get('Event'),
			$container->get('Placeholder'),
			$container->get('Component'),
			$container->get('Utilities.Paths'),
			$container->get('Utilities.Dynamicpath'),
			$container->get('Utilities.Pathfix')
		);
	}

	/**
	 * Get The Settings Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J4Settings
	 * @since 3.2.0
	 */
	public function getJ4Settings(Container $container): J4Settings
	{
		return new J4Settings(
			$container->get('Config'),
			$container->get('Registry'),
			$container->get('Event'),
			$container->get('Placeholder'),
			$container->get('Component'),
			$container->get('Utilities.Paths'),
			$container->get('Utilities.Dynamicpath'),
			$container->get('Utilities.Pathfix')
		);
	}

	/**
	 * Get The Settings Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J5Settings
	 * @since 3.2.0
	 */
	public function getJ5Settings(Container $container): J5Settings
	{
		return new J5Settings(
			$container->get('Config'),
			$container->get('Registry'),
			$container->get('Event'),
			$container->get('Placeholder'),
			$container->get('Component'),
			$container->get('Utilities.Paths'),
			$container->get('Utilities.Dynamicpath'),
			$container->get('Utilities.Pathfix')
		);
	}

	/**
	 * Get The Dashboard Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Dashboard
	 * @since 3.2.0
	 */
	public function getDashboard(Container $container): Dashboard
	{
		return new Dashboard(
			$container->get('Registry'),
			$container->get('Component')
		);
	}

	/**
	 * Get The Placeholder Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Placeholder
	 * @since 3.2.0
	 */
	public function getPlaceholder(Container $container): Placeholder
	{
		return new Placeholder(
			$container->get('Config')
		);
	}

	/**
	 * Get The Data Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Data
	 * @since 3.2.0
	 */
	public function getData(Container $container): Data
	{
		return new Data(
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
			$container->get('Model.Updateserver'),
			$container->get('Model.Joomlamodules'),
			$container->get('Model.Joomlaplugins'),
			$container->get('Model.Router')
		);
	}

	/**
	 * Get The Structure Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Structure
	 * @since 3.2.0
	 */
	public function getStructure(Container $container): Structure
	{
		return new Structure(
			$container->get('Component.Settings'),
			$container->get('Utilities.Paths'),
			$container->get('Utilities.Folder')
		);
	}

	/**
	 * Get The Structuresingle Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Structuresingle
	 * @since 3.2.0
	 */
	public function getStructuresingle(Container $container): Structuresingle
	{
		return new Structuresingle(
			$container->get('Config'),
			$container->get('Registry'),
			$container->get('Placeholder'),
			$container->get('Component.Settings'),
			$container->get('Component'),
			$container->get('Compiler.Builder.Content.One'),
			$container->get('Utilities.Counter'),
			$container->get('Utilities.Paths'),
			$container->get('Utilities.Files')
		);
	}

	/**
	 * Get The Structuremultiple Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Structuremultiple
	 * @since 3.2.0
	 */
	public function getStructuremultiple(Container $container): Structuremultiple
	{
		return new Structuremultiple(
			$container->get('Config'),
			$container->get('Registry'),
			$container->get('Component.Settings'),
			$container->get('Component'),
			$container->get('Model.Createdate'),
			$container->get('Model.Modifieddate'),
			$container->get('Utilities.Structure')
		);
	}

	/**
	 * Get The Settings Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Settings
	 * @since 3.2.0
	 */
	public function getSettings(Container $container): Settings
	{
		if (empty($this->targetVersion))
		{
			$this->targetVersion = $container->get('Config')->joomla_version;
		}

		return $container->get('Component.J' . $this->targetVersion . '.Settings');
	}
}

