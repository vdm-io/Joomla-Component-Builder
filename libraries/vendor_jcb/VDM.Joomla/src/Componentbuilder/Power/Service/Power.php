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
use VDM\Joomla\Componentbuilder\Power\Parser;


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

