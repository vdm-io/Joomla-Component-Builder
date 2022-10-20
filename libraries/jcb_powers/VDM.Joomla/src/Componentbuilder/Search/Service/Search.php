<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    3rd September, 2022
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Search\Service;


use Joomla\DI\Container;
use Joomla\DI\ServiceProviderInterface;
use VDM\Joomla\Componentbuilder\Search\Config;
use VDM\Joomla\Componentbuilder\Search\Table;
use VDM\Joomla\Componentbuilder\Search\Interfaces\SearchTypeInterface as SearchEngine;
use VDM\Joomla\Componentbuilder\Search\Engine\Regex;
use VDM\Joomla\Componentbuilder\Search\Engine\Basic;


/**
 * Search Service Provider
 * 
 * @since 3.2.0
 */
class Search implements ServiceProviderInterface
{
	/**
	 * Selected search engine
	 *
	 * @var     int
	 * @since 3.2.0
	 **/
	protected $searchEngine = 101;

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

		$container->alias(Regex::class, 'Search.Regex')
			->share('Search.Regex', [$this, 'getRegex'], true);

		$container->alias(Basic::class, 'Search.Basic')
			->share('Search.Basic', [$this, 'getBasic'], true);

		$container->alias(SearchEngine::class, 'Search')
			->share('Search', [$this, 'getSearch'], true);
	}

	/**
	 * Get the Config
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
	 * Get the Table
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Table
	 * @since 3.2.0
	 */
	public function getTable(Container $container): Table
	{
		return new Table(
			$container->get('Config')
		);
	}

	/**
	 * Get the Regex Type Search Engine
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Regex
	 * @since 3.2.0
	 */
	public function getRegex(Container $container): Regex
	{
		return new Regex(
			$container->get('Config')
		);
	}

	/**
	 * Get the Basic Type Search Engine
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Basic
	 * @since 3.2.0
	 */
	public function getBasic(Container $container): Basic
	{
		return new Basic(
			$container->get('Config')
		);
	}

	/**
	 * Get the Search Engine
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  SearchEngine
	 * @since 3.2.0
	 */
	public function getSearch(Container $container): SearchEngine
	{
		// set the search engine to use for this container
		if ($this->searchEngine == 101)
		{
			$this->searchEngine = (int) $container->get('Config')->regex_search;
		}

		// get the correct type of search engine
		if ($this->searchEngine ==  1)
		{
			return $container->get('Search.Regex');
		}

		// the default is the basic
		return $container->get('Search.Basic');
	}


}

