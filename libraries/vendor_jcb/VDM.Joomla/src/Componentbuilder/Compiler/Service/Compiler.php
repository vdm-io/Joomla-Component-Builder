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
use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Registry;
use VDM\Joomla\Componentbuilder\Compiler\FilePaths;
use VDM\Joomla\Componentbuilder\Table;
use VDM\Joomla\Componentbuilder\Compiler\Initializer;
use VDM\Joomla\Componentbuilder\Compiler as JCBCompiler;


/**
 * Compiler Service Provider
 * 
 * @since 3.2.0
 */
class Compiler implements ServiceProviderInterface
{
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
		$container->alias(Config::class, 'Config')
			->share('Config', [$this, 'getConfig'], true);

		$container->alias(Registry::class, 'Registry')
			->share('Registry', [$this, 'getRegistry'], true);

		$container->alias(Table::class, 'Table')
			->share('Table', [$this, 'getTable'], true);

		$container->alias(FilePaths::class, 'FilePaths')
			->share('FilePaths', [$this, 'getFilePaths'], true);

		$container->alias(Initializer::class, 'Initializer')
			->share('Initializer', [$this, 'getInitializer'], true);

		$container->alias(JCBCompiler::class, 'Compiler')
			->share('Compiler', [$this, 'getJCBCompiler'], true);
	}

	/**
	 * Get the Compiler Configurations
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Config
	 * @since   3.2.0
	 */
	public function getConfig(Container $container): Config
	{
		return new Config();
	}

	/**
	 * Get the Compiler Registry
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Registry
	 * @since   3.2.0
	 */
	public function getRegistry(Container $container): Registry
	{
		return new Registry();
	}

	/**
	 * Get the Table
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Table
	 * @since   3.2.0
	 */
	public function getTable(Container $container): Table
	{
		return new Table();
	}

	/**
	 * Get The FilePaths Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  FilePaths
	 * @since   5.1.4
	 */
	public function getFilePaths(Container $container): FilePaths
	{
		return new FilePaths();
	}

	/**
	 * Get The Initializer Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Initializer
	 * @since   5.1.4
	 */
	public function getInitializer(Container $container): Initializer
	{
		return new Initializer(
			$container->get('Config'),
			$container->get('Event'),
			$container->get('Customcode.Extractor'),
			$container->get('Component'),
			$container->get('Registry'),
			$container->get('Power'),
			$container->get('Compiler.Builder.Content.One'),
			$container->get('Component.Structure'),
			$container->get('Component.Structure.Single'),
			$container->get('Component.Structure.Multiple'),
			$container->get('Component.Dashboard'),
			$container->get('Library.Structure'),
			$container->get('Power.Structure'),
			$container->get('Joomlamodule.Structure'),
			$container->get('Joomlaplugin.Structure'),
			$container->get('Utilities.Folder'),
			$container->get('Utilities.Paths')
		);
	}

	/**
	 * Get The Compiler Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  JCBCompiler
	 * @since   5.1.4
	 */
	public function getJCBCompiler(Container $container): JCBCompiler
	{
		return new JCBCompiler(
			$container->get('Initializer'),
			$container->get('Config'),
			$container->get('Event'),
			$container->get('Placeholder'),
			$container->get('Server'),
			$container->get('Component'),
			$container->get('FilePaths'),
			$container->get('Compiler.Builder.Content.One'),
			$container->get('Joomlamodule.Data'),
			$container->get('Joomlaplugin.Data'),
			$container->get('Customcode'),
			$container->get('Customcode.External'),
			$container->get('Language.Extractor'),
			$container->get('Extension.Files.Updater'),
			$container->get('Utilities.Paths'),
			$container->get('Utilities.File'),
			$container->get('Utilities.Files'),
			$container->get('Utilities.Folder'),
			$container->get('Utilities.FileInjector'),
			$container->get('Utilities.Counter'),
			$container->get('Compiler.Builder.Language.Messages')
		);
	}
}

