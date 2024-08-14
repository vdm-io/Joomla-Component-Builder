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
use VDM\Joomla\Componentbuilder\Compiler\Joomlaplugin\JoomlaThree\Data as J3PluginData;
use VDM\Joomla\Componentbuilder\Compiler\Joomlaplugin\JoomlaFour\Data as J4PluginData;
use VDM\Joomla\Componentbuilder\Compiler\Joomlaplugin\JoomlaFive\Data as J5PluginData;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\PluginDataInterface as PluginData;
use VDM\Joomla\Componentbuilder\Compiler\Joomlaplugin\JoomlaThree\Structure as J3Structure;
use VDM\Joomla\Componentbuilder\Compiler\Joomlaplugin\JoomlaFour\Structure as J4Structure;
use VDM\Joomla\Componentbuilder\Compiler\Joomlaplugin\JoomlaFive\Structure as J5Structure;
use VDM\Joomla\Componentbuilder\Interfaces\Plugin\StructureInterface as Structure;
use VDM\Joomla\Componentbuilder\Compiler\Joomlaplugin\JoomlaThree\Infusion as J3Infusion;
use VDM\Joomla\Componentbuilder\Compiler\Joomlaplugin\JoomlaFour\Infusion as J4Infusion;
use VDM\Joomla\Componentbuilder\Compiler\Joomlaplugin\JoomlaFive\Infusion as J5Infusion;
use VDM\Joomla\Componentbuilder\Interfaces\Plugin\InfusionInterface as Infusion;


/**
 * Joomla Plugin Service Provider
 * 
 * @since 3.2.0
 */
class Joomlaplugin implements ServiceProviderInterface
{
	/**
	 * Current Joomla Version Being Build
	 *
	 * @var     int
	 * @since  5.0.2
	 **/
	protected $targetVersion;

	/**
	 * Registers the service provider with a DI container.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  void
	 * @since   3.2.0
	 */
	public function register(Container $container)
	{
		$container->alias(J3PluginData::class, 'Joomlaplugin.J3.Data')
			->share('Joomlaplugin.J3.Data', [$this, 'getJ3PluginData'], true);

		$container->alias(J4PluginData::class, 'Joomlaplugin.J4.Data')
			->share('Joomlaplugin.J4.Data', [$this, 'getJ4PluginData'], true);

		$container->alias(J5PluginData::class, 'Joomlaplugin.J5.Data')
			->share('Joomlaplugin.J5.Data', [$this, 'getJ5PluginData'], true);

		$container->alias(PluginData::class, 'Joomlaplugin.Data')
			->share('Joomlaplugin.Data', [$this, 'getPluginData'], true);

		$container->alias(J3Structure::class, 'Joomlaplugin.J3.Structure')
			->share('Joomlaplugin.J3.Structure', [$this, 'getJ3Structure'], true);

		$container->alias(J4Structure::class, 'Joomlaplugin.J4.Structure')
			->share('Joomlaplugin.J4.Structure', [$this, 'getJ4Structure'], true);

		$container->alias(J5Structure::class, 'Joomlaplugin.J5.Structure')
			->share('Joomlaplugin.J5.Structure', [$this, 'getJ5Structure'], true);

		$container->alias(Structure::class, 'Joomlaplugin.Structure')
			->share('Joomlaplugin.Structure', [$this, 'getStructure'], true);

		$container->alias(J3Infusion::class, 'Joomlaplugin.J3.Infusion')
			->share('Joomlaplugin.J3.Infusion', [$this, 'getJ3Infusion'], true);

		$container->alias(J4Infusion::class, 'Joomlaplugin.J4.Infusion')
			->share('Joomlaplugin.J4.Infusion', [$this, 'getJ4Infusion'], true);

		$container->alias(J5Infusion::class, 'Joomlaplugin.J5.Infusion')
			->share('Joomlaplugin.J5.Infusion', [$this, 'getJ5Infusion'], true);

		$container->alias(Infusion::class, 'Joomlaplugin.Infusion')
			->share('Joomlaplugin.Infusion', [$this, 'getInfusion'], true);
	}

	/**
	 * Get The Plug-in Data Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  PluginData
	 * @since   5.0.2
	 */
	public function getPluginData(Container $container): PluginData
	{
		if (empty($this->targetVersion))
		{
			$this->targetVersion = $container->get('Config')->joomla_version;
		}

		return $container->get('Joomlaplugin.J' . $this->targetVersion . '.Data');
	}

	/**
	 * Get The PluginData Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J3PluginData
	 * @since   5.0.2
	 */
	public function getJ3PluginData(Container $container): J3PluginData
	{
		return new J3PluginData(
			$container->get('Config'),
			$container->get('Customcode'),
			$container->get('Customcode.Gui'),
			$container->get('Placeholder'),
			$container->get('Language'),
			$container->get('Field'),
			$container->get('Field.Name'),
			$container->get('Model.Filesfolders')
		);
	}

	/**
	 * Get The PluginData Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J4PluginData
	 * @since   5.0.2
	 */
	public function getJ4PluginData(Container $container): J4PluginData
	{
		return new J4PluginData(
			$container->get('Config'),
			$container->get('Customcode'),
			$container->get('Customcode.Gui'),
			$container->get('Placeholder'),
			$container->get('Language'),
			$container->get('Field'),
			$container->get('Field.Name'),
			$container->get('Model.Filesfolders')
		);
	}

	/**
	 * Get The PluginData Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J5PluginData
	 * @since   5.0.2
	 */
	public function getJ5PluginData(Container $container): J5PluginData
	{
		return new J5PluginData(
			$container->get('Config'),
			$container->get('Customcode'),
			$container->get('Customcode.Gui'),
			$container->get('Placeholder'),
			$container->get('Language'),
			$container->get('Field'),
			$container->get('Field.Name'),
			$container->get('Model.Filesfolders')
		);
	}

	/**
	 * Get the Joomla Plugin Structure Builder
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Structure
	 * @since   3.2.0
	 */
	public function getStructure(Container $container): Structure
	{
		if (empty($this->targetVersion))
		{
			$this->targetVersion = $container->get('Config')->joomla_version;
		}

		return $container->get('Joomlaplugin.J' . $this->targetVersion . '.Structure');
	}

	/**
	 * Get the Joomla 3 Plugin Structure Builder
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Structure
	 * @since   5.0.2
	 */
	public function getJ3Structure(Container $container): J3Structure
	{
		return new J3Structure(
			$container->get('Joomlaplugin.Data'),
			$container->get('Component'),
			$container->get('Config'),
			$container->get('Registry'),
			$container->get('Customcode.Dispenser'),
			$container->get('Event'),
			$container->get('Utilities.Counter'),
			$container->get('Utilities.Folder'),
			$container->get('Utilities.File'),
			$container->get('Utilities.Files')
		);
	}

	/**
	 * Get the Joomla 4 Plugin Structure Builder
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Structure
	 * @since   5.0.2
	 */
	public function getJ4Structure(Container $container): J4Structure
	{
		return new J4Structure(
			$container->get('Joomlaplugin.Data'),
			$container->get('Component'),
			$container->get('Config'),
			$container->get('Registry'),
			$container->get('Customcode.Dispenser'),
			$container->get('Event'),
			$container->get('Utilities.Counter'),
			$container->get('Utilities.Folder'),
			$container->get('Utilities.File'),
			$container->get('Utilities.Files'),
			$container->get('Placeholder')
		);
	}

	/**
	 * Get the Joomla 5 Plugin Structure Builder
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Structure
	 * @since   5.0.2
	 */
	public function getJ5Structure(Container $container): J5Structure
	{
		return new J5Structure(
			$container->get('Joomlaplugin.Data'),
			$container->get('Component'),
			$container->get('Config'),
			$container->get('Registry'),
			$container->get('Customcode.Dispenser'),
			$container->get('Event'),
			$container->get('Utilities.Counter'),
			$container->get('Utilities.Folder'),
			$container->get('Utilities.File'),
			$container->get('Utilities.Files'),
			$container->get('Placeholder')
		);
	}

	/**
	 * Get The InfusionInterface Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Infusion
	 * @since   5.0.2
	 */
	public function getInfusion(Container $container): Infusion
	{
		if (empty($this->targetVersion))
		{
			$this->targetVersion = $container->get('Config')->joomla_version;
		}

		return $container->get('Joomlaplugin.J' . $this->targetVersion . '.Infusion');
	}

	/**
	 * Get The Infusion Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J3Infusion
	 * @since   5.0.2
	 */
	public function getJ3Infusion(Container $container): J3Infusion
	{
		return new J3Infusion(
			$container->get('Config'),
			$container->get('Placeholder'),
			$container->get('Header'),
			$container->get('Event'),
			$container->get('Joomlaplugin.Data'),
			$container->get('Extension.InstallScript'),
			$container->get('Architecture.Plugin.Extension'),
			$container->get('Architecture.Plugin.MainXML'),
			$container->get('Compiler.Builder.Content.Multi'),
			$container->get('Compiler.Creator.Fieldset.Extension')
		);
	}

	/**
	 * Get The Infusion Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J4Infusion
	 * @since   5.0.2
	 */
	public function getJ4Infusion(Container $container): J4Infusion
	{
		return new J4Infusion(
			$container->get('Config'),
			$container->get('Placeholder'),
			$container->get('Header'),
			$container->get('Event'),
			$container->get('Joomlaplugin.Data'),
			$container->get('Extension.InstallScript'),
			$container->get('Architecture.Plugin.Extension'),
			$container->get('Architecture.Plugin.Provider'),
			$container->get('Architecture.Plugin.MainXML'),
			$container->get('Compiler.Builder.Content.Multi'),
			$container->get('Compiler.Builder.Content.One'),
			$container->get('Compiler.Creator.Fieldset.Extension')
		);
	}

	/**
	 * Get The Infusion Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J5Infusion
	 * @since   5.0.2
	 */
	public function getJ5Infusion(Container $container): J5Infusion
	{
		return new J5Infusion(
			$container->get('Config'),
			$container->get('Placeholder'),
			$container->get('Header'),
			$container->get('Event'),
			$container->get('Joomlaplugin.Data'),
			$container->get('Extension.InstallScript'),
			$container->get('Architecture.Plugin.Extension'),
			$container->get('Architecture.Plugin.Provider'),
			$container->get('Architecture.Plugin.MainXML'),
			$container->get('Compiler.Builder.Content.Multi'),
			$container->get('Compiler.Builder.Content.One'),
			$container->get('Compiler.Creator.Fieldset.Extension')
		);
	}
}

