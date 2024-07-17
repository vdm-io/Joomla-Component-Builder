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

namespace VDM\Joomla\Componentbuilder\JoomlaPower\Service;


use Joomla\DI\Container;
use Joomla\DI\ServiceProviderInterface;
use VDM\Joomla\Componentbuilder\JoomlaPower\Config;
use VDM\Joomla\Componentbuilder\Table;
use VDM\Joomla\Componentbuilder\JoomlaPower\Grep;
use VDM\Joomla\Componentbuilder\JoomlaPower\Remote\Get;
use VDM\Joomla\Componentbuilder\JoomlaPower\Remote\Set;
use VDM\Joomla\Componentbuilder\JoomlaPower\Readme\Item as ItemReadme;
use VDM\Joomla\Componentbuilder\JoomlaPower\Readme\Main as MainReadme;


/**
 * Joomla Power Service Provider
 * 
 * @since 3.2.1
 */
class JoomlaPower implements ServiceProviderInterface
{
	/**
	 * Registers the service provider with a DI container.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  void
	 * @since 3.2.1
	 */
	public function register(Container $container)
	{
		$container->alias(Config::class, 'Config')
			->share('Config', [$this, 'getConfig'], true);

		$container->alias(Table::class, 'Table')
			->share('Table', [$this, 'getTable'], true);

		$container->alias(Grep::class, 'Joomla.Power.Grep')
			->share('Joomla.Power.Grep', [$this, 'getGrep'], true);

		$container->alias(Get::class, 'Joomla.Power.Remote.Get')
			->share('Joomla.Power.Remote.Get', [$this, 'getRemoteGet'], true);

		$container->alias(Set::class, 'Joomla.Power.Remote.Set')
			->share('Joomla.Power.Remote.Set', [$this, 'getRemoteSet'], true);

		$container->alias(ItemReadme::class, 'Joomla.Power.Readme.Item')
			->share('Joomla.Power.Readme.Item', [$this, 'getItemReadme'], true);

		$container->alias(MainReadme::class, 'Joomla.Power.Readme.Main')
			->share('Joomla.Power.Readme.Main', [$this, 'getMainReadme'], true);
	}

	/**
	 * Get The Config Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Config
	 * @since 3.2.1
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
	 * @since 3.2.1
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
	 * @since 3.2.1
	 */
	public function getGrep(Container $container): Grep
	{
		return new Grep(
			$container->get('Gitea.Repository.Contents'),
			$container->get('Config')->approved_joomla_paths
		);
	}

	/**
	 * Get The Remote Get Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Get
	 * @since 3.2.1
	 */
	public function getRemoteGet(Container $container): Get
	{
		return new Get(
			$container->get('Joomla.Power.Grep'),
			$container->get('Data.Item')
		);
	}

	/**
	 * Get The Remote Set Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Set
	 * @since 3.2.2
	 */
	public function getRemoteSet(Container $container): Set
	{
		return new Set(
			$container->get('Config')->approved_joomla_paths,
			$container->get('Joomla.Power.Grep'),
			$container->get('Data.Items'),
			$container->get('Joomla.Power.Readme.Item'),
			$container->get('Joomla.Power.Readme.Main'),
			$container->get('Gitea.Repository.Contents')
		);
	}

	/**
	 * Get The Item Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  ItemReadme
	 * @since 3.2.1
	 */
	public function getItemReadme(Container $container): ItemReadme
	{
		return new ItemReadme();
	}

	/**
	 * Get The Main Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  MainReadme
	 * @since 3.2.1
	 */
	public function getMainReadme(Container $container): MainReadme
	{
		return new MainReadme();
	}
}

