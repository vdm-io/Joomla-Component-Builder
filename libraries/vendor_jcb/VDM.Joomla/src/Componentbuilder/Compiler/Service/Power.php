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
use VDM\Joomla\Componentbuilder\Compiler\Power as Powers;
use VDM\Joomla\Componentbuilder\Power\Remote\Get;
use VDM\Joomla\Componentbuilder\Power\Grep;
use VDM\Joomla\Componentbuilder\Compiler\Power\Autoloader;
use VDM\Joomla\Componentbuilder\Compiler\Power\Infusion;
use VDM\Joomla\Componentbuilder\Compiler\Power\Structure;
use VDM\Joomla\Componentbuilder\Power\Parser;
use VDM\Joomla\Componentbuilder\Power\Plantuml;
use VDM\Joomla\Componentbuilder\Power\Readme\Item as ItemReadme;
use VDM\Joomla\Componentbuilder\Power\Readme\Main as MainReadme;
use VDM\Joomla\Componentbuilder\Compiler\Power\Extractor;
use VDM\Joomla\Componentbuilder\Compiler\Power\Injector;


/**
 * Compiler Power Service Provider
 * 
 * @since 3.2.0
 */
class Power implements ServiceProviderInterface
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
		$container->alias(Powers::class, 'Power')
			->share('Power', [$this, 'getPowers'], true);

		$container->alias(Get::class, 'Power.Remote.Get')
			->share('Power.Remote.Get', [$this, 'getRemoteGet'], true);

		$container->alias(Grep::class, 'Power.Grep')
			->share('Power.Grep', [$this, 'getGrep'], true);

		$container->alias(Autoloader::class, 'Power.Autoloader')
			->share('Power.Autoloader', [$this, 'getAutoloader'], true);

		$container->alias(Infusion::class, 'Power.Infusion')
			->share('Power.Infusion', [$this, 'getInfusion'], true);

		$container->alias(Structure::class, 'Power.Structure')
			->share('Power.Structure', [$this, 'getStructure'], true);

		$container->alias(Parser::class, 'Power.Parser')
			->share('Power.Parser', [$this, 'getParser'], true);

		$container->alias(Plantuml::class, 'Power.Plantuml')
			->share('Power.Plantuml', [$this, 'getPlantuml'], true);

		$container->alias(ItemReadme::class, 'Power.Readme.Item')
			->share('Power.Readme.Item', [$this, 'getItemReadme'], true);

		$container->alias(MainReadme::class, 'Power.Readme.Main')
			->share('Power.Readme.Main', [$this, 'getMainReadme'], true);

		$container->alias(Extractor::class, 'Power.Extractor')
			->share('Power.Extractor', [$this, 'getExtractor'], true);

		$container->alias(Injector::class, 'Power.Injector')
			->share('Power.Injector', [$this, 'getInjector'], true);
	}

	/**
	 * Get The Power Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Powers
	 * @since 3.2.0
	 */
	public function getPowers(Container $container): Powers
	{
		return new Powers(
			$container->get('Config'),
			$container->get('Placeholder'),
			$container->get('Customcode'),
			$container->get('Customcode.Gui'),
			$container->get('Power.Remote.Get')
		);
	}

	/**
	 * Get The Remote Get Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Get
	 * @since 3.2.0
	 */
	public function getRemoteGet(Container $container): Get
	{
		return new Get(
			$container->get('Power.Grep'),
			$container->get('Data.Item')
		);
	}

	/**
	 * Get The Grep Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Grep
	 * @since 3.2.0
	 */
	public function getGrep(Container $container): Grep
	{
		return new Grep(
			$container->get('Gitea.Repository.Contents'),
			$container->get('Config')->approved_paths,
			$container->get('Config')->local_powers_repository_path
		);
	}

	/**
	 * Get The Autoloader Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Autoloader
	 * @since 3.2.0
	 */
	public function getAutoloader(Container $container): Autoloader
	{
		return new Autoloader(
			$container->get('Power'),
			$container->get('Config'),
			$container->get('Compiler.Builder.Content.One')
		);
	}

	/**
	 * Get The Infusion Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Infusion
	 * @since 3.2.0
	 */
	public function getInfusion(Container $container): Infusion
	{
		return new Infusion(
			$container->get('Config'),
			$container->get('Power'),
			$container->get('Compiler.Builder.Content.One'),
			$container->get('Compiler.Builder.Content.Multi'),
			$container->get('Power.Parser'),
			$container->get('Power.Readme.Item'),
			$container->get('Power.Readme.Main'),
			$container->get('Placeholder'),
			$container->get('Event')
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
			$container->get('Power'),
			$container->get('Config'),
			$container->get('Registry'),
			$container->get('Event'),
			$container->get('Utilities.Counter'),
			$container->get('Utilities.Paths'),
			$container->get('Utilities.Folder'),
			$container->get('Utilities.File'),
			$container->get('Utilities.Files')
		);
	}

	/**
	 * Get The Parser Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Parser
	 * @since 3.2.0
	 */
	public function getParser(Container $container): Parser
	{
		return new Parser();
	}

	/**
	 * Get The Plantuml Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Plantuml
	 * @since 3.2.0
	 */
	public function getPlantuml(Container $container): Plantuml
	{
		return new Plantuml();
	}

	/**
	 * Get The Readme Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  ItemReadme
	 * @since 3.2.0
	 */
	public function getItemReadme(Container $container): ItemReadme
	{
		return new ItemReadme(
			$container->get('Power.Plantuml')
		);
	}

	/**
	 * Get The Readme Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  MainReadme
	 * @since 3.2.0
	 */
	public function getMainReadme(Container $container): MainReadme
	{
		return new MainReadme();
	}

	/**
	 * Get The Extractor Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Extractor
	 * @since 3.2.0
	 */
	public function getExtractor(Container $container): Extractor
	{
		return new Extractor();
	}

	/**
	 * Get The Injector Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Injector
	 * @since 3.2.0
	 */
	public function getInjector(Container $container): Injector
	{
		return new Injector(
			$container->get('Power'),
			$container->get('Power.Extractor'),
			$container->get('Power.Parser'),
			$container->get('Placeholder')
		);
	}
}

