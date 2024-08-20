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

namespace VDM\Joomla\Componentbuilder\Power\Service;


use Joomla\DI\Container;
use Joomla\DI\ServiceProviderInterface;
use VDM\Joomla\Componentbuilder\Power\Config;
use VDM\Joomla\Componentbuilder\Table;
use VDM\Joomla\Componentbuilder\Power\Grep;
use VDM\Joomla\Componentbuilder\Power\Remote\Get;
use VDM\Joomla\Componentbuilder\Power\Remote\Set;
use VDM\Joomla\Componentbuilder\Power\Parser;
use VDM\Joomla\Componentbuilder\Power\Plantuml;
use VDM\Joomla\Componentbuilder\Power\Readme\Item as ItemReadme;
use VDM\Joomla\Componentbuilder\Power\Readme\Main as MainReadme;


/**
 * Power Service Provider
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
		$container->alias(Config::class, 'Config')
			->share('Config', [$this, 'getConfig'], true);

		$container->alias(Table::class, 'Table')
			->share('Table', [$this, 'getTable'], true);

		$container->alias(Grep::class, 'Power.Grep')
			->share('Power.Grep', [$this, 'getGrep'], true);

		$container->alias(Get::class, 'Power.Remote.Get')
			->share('Power.Remote.Get', [$this, 'getRemoteGet'], true);

		$container->alias(Set::class, 'Power.Remote.Set')
			->share('Power.Remote.Set', [$this, 'getRemoteSet'], true);

		$container->alias(Parser::class, 'Power.Parser')
			->share('Power.Parser', [$this, 'getParser'], true);

		$container->alias(Plantuml::class, 'Power.Plantuml')
			->share('Power.Plantuml', [$this, 'getPlantuml'], true);

		$container->alias(ItemReadme::class, 'Power.Readme.Item')
			->share('Power.Readme.Item', [$this, 'getItemReadme'], true);

		$container->alias(MainReadme::class, 'Power.Readme.Main')
			->share('Power.Readme.Main', [$this, 'getMainReadme'], true);
	}

	/**
	 * Get The Config Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Config
	 * @since 3.2.0
	 */
	public function getConfig(Container $container): Config
	{
		return new Config();
	}

	/**
	 * Get The Table Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Table
	 * @since 3.2.0
	 */
	public function getTable(Container $container): Table
	{
		return new Table();
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
	 * Get The Remote Set Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Set
	 * @since  5.0.3
	 */
	public function getRemoteSet(Container $container): Set
	{
		return new Set(
			$container->get('Config')->approved_paths,
			$container->get('Power.Grep'),
			$container->get('Data.Items'),
			$container->get('Power.Readme.Item'),
			$container->get('Power.Readme.Main'),
			$container->get('Gitea.Repository.Contents'), null, null, null,
			$container->get('Power.Parser')
		);
	}

	/**
	 * Get The Readme Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  ItemReadme
	 * @since   5.0.3
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
	 * @since   5.0.3
	 */
	public function getMainReadme(Container $container): MainReadme
	{
		return new MainReadme();
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
	 * @since   5.0.3
	 */
	public function getPlantuml(Container $container): Plantuml
	{
		return new Plantuml();
	}
}

