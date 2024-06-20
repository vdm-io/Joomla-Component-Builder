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
use VDM\Joomla\Componentbuilder\Power\Super as Superpower;
use VDM\Joomla\Componentbuilder\Compiler\Power\Parser;


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

		$container->alias(Superpower::class, 'Superpower')
			->share('Superpower', [$this, 'getSuperpower'], true);

		$container->alias(Parser::class, 'Power.Parser')
			->share('Power.Parser', [$this, 'getParser'], true);
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
	 * Get The Super Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Superpower
	 * @since 3.2.0
	 */
	public function getSuperpower(Container $container): Superpower
	{
		return new Superpower(
			$container->get('Power.Grep'),
			$container->get('Data.Item')
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
}

