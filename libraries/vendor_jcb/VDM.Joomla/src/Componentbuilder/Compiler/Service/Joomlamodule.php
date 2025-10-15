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
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\ModuleDataInterface as Data;
use VDM\Joomla\Componentbuilder\Compiler\Joomlamodule\JoomlaThree\Data as J3Data;
use VDM\Joomla\Componentbuilder\Compiler\Joomlamodule\JoomlaFour\Data as J4Data;
use VDM\Joomla\Componentbuilder\Compiler\Joomlamodule\JoomlaFive\Data as J5Data;
use VDM\Joomla\Componentbuilder\Compiler\Joomlamodule\JoomlaSix\Data as J6Data;
use VDM\Joomla\Componentbuilder\Interfaces\Module\StructureInterface as Structure;
use VDM\Joomla\Componentbuilder\Compiler\Joomlamodule\JoomlaThree\Structure as J3Structure;
use VDM\Joomla\Componentbuilder\Compiler\Joomlamodule\JoomlaFour\Structure as J4Structure;
use VDM\Joomla\Componentbuilder\Compiler\Joomlamodule\JoomlaFive\Structure as J5Structure;
use VDM\Joomla\Componentbuilder\Compiler\Joomlamodule\JoomlaSix\Structure as J6Structure;
use VDM\Joomla\Componentbuilder\Interfaces\Module\InfusionInterface as Infusion;
use VDM\Joomla\Componentbuilder\Compiler\Joomlamodule\JoomlaThree\Infusion as J3Infusion;
use VDM\Joomla\Componentbuilder\Compiler\Joomlamodule\JoomlaFour\Infusion as J4Infusion;
use VDM\Joomla\Componentbuilder\Compiler\Joomlamodule\JoomlaFive\Infusion as J5Infusion;
use VDM\Joomla\Componentbuilder\Compiler\Joomlamodule\JoomlaSix\Infusion as J6Infusion;


/**
 * Joomla Module Service Provider
 * 
 * @since 5.1.2
 */
class Joomlamodule implements ServiceProviderInterface
{
	/**
	 * Current Joomla Version Being Build
	 *
	 * @var     int
	 * @since  5.1.2
	 **/
	protected $targetVersion;

	/**
	 * Registers the service provider with a DI container.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  void
	 * @since   5.1.2
	 */
	public function register(Container $container)
	{
		$container->alias(Data::class, 'Joomlamodule.Data')
			->share('Joomlamodule.Data', [$this, 'getData'], true);

		$container->alias(J3Data::class, 'Joomlamodule.J3.Data')
			->share('Joomlamodule.J3.Data', [$this, 'getJ3Data'], true);

		$container->alias(J4Data::class, 'Joomlamodule.J4.Data')
			->share('Joomlamodule.J4.Data', [$this, 'getJ4Data'], true);

		$container->alias(J5Data::class, 'Joomlamodule.J5.Data')
			->share('Joomlamodule.J5.Data', [$this, 'getJ5Data'], true);

		$container->alias(J6Data::class, 'Joomlamodule.J6.Data')
			->share('Joomlamodule.J6.Data', [$this, 'getJ6Data'], true);

		$container->alias(Structure::class, 'Joomlamodule.Structure')
			->share('Joomlamodule.Structure', [$this, 'getStructure'], true);

		$container->alias(J3Structure::class, 'Joomlamodule.J3.Structure')
			->share('Joomlamodule.J3.Structure', [$this, 'getJ3Structure'], true);

		$container->alias(J4Structure::class, 'Joomlamodule.J4.Structure')
			->share('Joomlamodule.J4.Structure', [$this, 'getJ4Structure'], true);

		$container->alias(J5Structure::class, 'Joomlamodule.J5.Structure')
			->share('Joomlamodule.J5.Structure', [$this, 'getJ5Structure'], true);

		$container->alias(J6Structure::class, 'Joomlamodule.J6.Structure')
			->share('Joomlamodule.J6.Structure', [$this, 'getJ6Structure'], true);

		$container->alias(Infusion::class, 'Joomlamodule.Infusion')
			->share('Joomlamodule.Infusion', [$this, 'getInfusion'], true);

		$container->alias(J3Infusion::class, 'Joomlamodule.J3.Infusion')
			->share('Joomlamodule.J3.Infusion', [$this, 'getJ3Infusion'], true);

		$container->alias(J4Infusion::class, 'Joomlamodule.J4.Infusion')
			->share('Joomlamodule.J4.Infusion', [$this, 'getJ4Infusion'], true);

		$container->alias(J5Infusion::class, 'Joomlamodule.J5.Infusion')
			->share('Joomlamodule.J5.Infusion', [$this, 'getJ5Infusion'], true);

		$container->alias(J6Infusion::class, 'Joomlamodule.J6.Infusion')
			->share('Joomlamodule.J6.Infusion', [$this, 'getJ6Infusion'], true);
	}

	/**
	 * Get The ModuleDataInterface Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Data
	 * @since   5.1.2
	 */
	public function getData(Container $container): Data
	{
		if (empty($this->targetVersion))
		{
			$this->targetVersion = $container->get('Config')->joomla_version;
		}

		return $container->get('Joomlamodule.J' . $this->targetVersion . '.Data');
	}

	/**
	 * Get The Data Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J3Data
	 * @since   5.1.2
	 */
	public function getJ3Data(Container $container): J3Data
	{
		return new J3Data(
			$container->get('Config'),
			$container->get('Customcode'),
			$container->get('Customcode.Gui'),
			$container->get('Placeholder'),
			$container->get('Language'),
			$container->get('Field'),
			$container->get('Field.Name'),
			$container->get('Model.Filesfolders'),
			$container->get('Model.Libraries'),
			$container->get('Dynamicget.Data'),
			$container->get('Templatelayout.Data'),
			$container->get('Joomla.Database')
		);
	}

	/**
	 * Get The Data Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J4Data
	 * @since   5.1.2
	 */
	public function getJ4Data(Container $container): J4Data
	{
		return new J4Data(
			$container->get('Config'),
			$container->get('Customcode'),
			$container->get('Customcode.Gui'),
			$container->get('Placeholder'),
			$container->get('Language'),
			$container->get('Field'),
			$container->get('Field.Name'),
			$container->get('Model.Filesfolders'),
			$container->get('Model.Libraries'),
			$container->get('Dynamicget.Data'),
			$container->get('Templatelayout.Data'),
			$container->get('Joomla.Database')
		);
	}

	/**
	 * Get The Data Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J5Data
	 * @since   5.1.2
	 */
	public function getJ5Data(Container $container): J5Data
	{
		return new J5Data(
			$container->get('Config'),
			$container->get('Customcode'),
			$container->get('Customcode.Gui'),
			$container->get('Placeholder'),
			$container->get('Language'),
			$container->get('Field'),
			$container->get('Field.Name'),
			$container->get('Model.Filesfolders'),
			$container->get('Model.Libraries'),
			$container->get('Dynamicget.Data'),
			$container->get('Templatelayout.Data'),
			$container->get('Joomla.Database')
		);
	}

	/**
	 * Get The Data Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J6Data
	 * @since   5.1.2
	 */
	public function getJ6Data(Container $container): J6Data
	{
		return new J6Data(
			$container->get('Config'),
			$container->get('Customcode'),
			$container->get('Customcode.Gui'),
			$container->get('Placeholder'),
			$container->get('Language'),
			$container->get('Field'),
			$container->get('Field.Name'),
			$container->get('Model.Filesfolders'),
			$container->get('Model.Libraries'),
			$container->get('Dynamicget.Data'),
			$container->get('Templatelayout.Data'),
			$container->get('Joomla.Database')
		);
	}

	/**
	 * Get The StructureInterface Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Structure
	 * @since   5.1.2
	 */
	public function getStructure(Container $container): Structure
	{
		if (empty($this->targetVersion))
		{
			$this->targetVersion = $container->get('Config')->joomla_version;
		}

		return $container->get('Joomlamodule.J' . $this->targetVersion . '.Structure');
	}

	/**
	 * Get The Structure Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J3Structure
	 * @since   5.1.2
	 */
	public function getJ3Structure(Container $container): J3Structure
	{
		return new J3Structure(
			$container->get('Joomlamodule.Data'),
			$container->get('Component'),
			$container->get('Config'),
			$container->get('Registry'),
			$container->get('Customcode.Dispenser'),
			$container->get('Event'),
			$container->get('Utilities.Counter'),
			$container->get('Utilities.Folder'),
			$container->get('Utilities.File'),
			$container->get('Utilities.Files'),
			$container->get('Compiler.Builder.Template.Data')
		);
	}

	/**
	 * Get The Structure Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J4Structure
	 * @since   5.1.2
	 */
	public function getJ4Structure(Container $container): J4Structure
	{
		return new J4Structure(
			$container->get('Joomlamodule.Data'),
			$container->get('Component'),
			$container->get('Config'),
			$container->get('Registry'),
			$container->get('Customcode.Dispenser'),
			$container->get('Event'),
			$container->get('Utilities.Counter'),
			$container->get('Utilities.Folder'),
			$container->get('Utilities.File'),
			$container->get('Utilities.Files'),
			$container->get('Compiler.Builder.Template.Data'),
			$container->get('Placeholder')
		);
	}

	/**
	 * Get The Structure Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J5Structure
	 * @since   5.1.2
	 */
	public function getJ5Structure(Container $container): J5Structure
	{
		return new J5Structure(
			$container->get('Joomlamodule.Data'),
			$container->get('Component'),
			$container->get('Config'),
			$container->get('Registry'),
			$container->get('Customcode.Dispenser'),
			$container->get('Event'),
			$container->get('Utilities.Counter'),
			$container->get('Utilities.Folder'),
			$container->get('Utilities.File'),
			$container->get('Utilities.Files'),
			$container->get('Compiler.Builder.Template.Data'),
			$container->get('Placeholder')
		);
	}

	/**
	 * Get The Structure Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J6Structure
	 * @since   5.1.2
	 */
	public function getJ6Structure(Container $container): J6Structure
	{
		return new J6Structure(
			$container->get('Joomlamodule.Data'),
			$container->get('Component'),
			$container->get('Config'),
			$container->get('Registry'),
			$container->get('Customcode.Dispenser'),
			$container->get('Event'),
			$container->get('Utilities.Counter'),
			$container->get('Utilities.Folder'),
			$container->get('Utilities.File'),
			$container->get('Utilities.Files'),
			$container->get('Compiler.Builder.Template.Data'),
			$container->get('Placeholder')
		);
	}

	/**
	 * Get The InfusionInterface Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Infusion
	 * @since   5.1.2
	 */
	public function getInfusion(Container $container): Infusion
	{
		if (empty($this->targetVersion))
		{
			$this->targetVersion = $container->get('Config')->joomla_version;
		}

		return $container->get('Joomlamodule.J' . $this->targetVersion . '.Infusion');
	}

	/**
	 * Get The Infusion Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J3Infusion
	 * @since   5.1.2
	 */
	public function getJ3Infusion(Container $container): J3Infusion
	{
		return new J3Infusion(
			$container->get('Config'),
			$container->get('Architecture.Module.Dispatcher'),
			$container->get('Architecture.Module.Template'),
			$container->get('Architecture.Module.Helper'),
			$container->get('Architecture.Module.MainXML'),
			$container->get('Joomlamodule.Data'),
			$container->get('Header'),
			$container->get('Event'),
			$container->get('Extension.InstallScript'),
			$container->get('Compiler.Builder.Content.Multi'),
			$container->get('Compiler.Creator.Fieldset.Extension'),
			$container->get('Dynamicget.Methods')
		);
	}

	/**
	 * Get The Infusion Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J4Infusion
	 * @since   5.1.2
	 */
	public function getJ4Infusion(Container $container): J4Infusion
	{
		return new J4Infusion(
			$container->get('Config'),
			$container->get('Architecture.Module.Provider'),
			$container->get('Architecture.Module.Dispatcher'),
			$container->get('Architecture.Module.Template'),
			$container->get('Architecture.Module.Helper'),
			$container->get('Architecture.Module.MainXML'),
			$container->get('Joomlamodule.Data'),
			$container->get('Header'),
			$container->get('Event'),
			$container->get('Extension.InstallScript'),
			$container->get('Compiler.Builder.Content.Multi'),
			$container->get('Compiler.Creator.Fieldset.Extension'),
			$container->get('Dynamicget.Methods')
		);
	}

	/**
	 * Get The Infusion Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J5Infusion
	 * @since   5.1.2
	 */
	public function getJ5Infusion(Container $container): J5Infusion
	{
		return new J5Infusion(
			$container->get('Config'),
			$container->get('Architecture.Module.Provider'),
			$container->get('Architecture.Module.Dispatcher'),
			$container->get('Architecture.Module.Template'),
			$container->get('Architecture.Module.Helper'),
			$container->get('Architecture.Module.MainXML'),
			$container->get('Joomlamodule.Data'),
			$container->get('Header'),
			$container->get('Event'),
			$container->get('Extension.InstallScript'),
			$container->get('Compiler.Builder.Content.Multi'),
			$container->get('Compiler.Creator.Fieldset.Extension'),
			$container->get('Dynamicget.Methods')
		);
	}

	/**
	 * Get The Infusion Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J6Infusion
	 * @since   5.1.2
	 */
	public function getJ6Infusion(Container $container): J6Infusion
	{
		return new J6Infusion(
			$container->get('Config'),
			$container->get('Architecture.Module.Provider'),
			$container->get('Architecture.Module.Dispatcher'),
			$container->get('Architecture.Module.Template'),
			$container->get('Architecture.Module.Helper'),
			$container->get('Architecture.Module.MainXML'),
			$container->get('Joomlamodule.Data'),
			$container->get('Header'),
			$container->get('Event'),
			$container->get('Extension.InstallScript'),
			$container->get('Compiler.Builder.Content.Multi'),
			$container->get('Compiler.Creator.Fieldset.Extension'),
			$container->get('Dynamicget.Methods')
		);
	}
}

