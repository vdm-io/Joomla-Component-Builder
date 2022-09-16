<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Search\Service;


use Joomla\DI\Container;
use Joomla\DI\ServiceProviderInterface;
use VDM\Joomla\Componentbuilder\Search\Agent as SearchAgent;
use VDM\Joomla\Componentbuilder\Search\Agent\Find;
use VDM\Joomla\Componentbuilder\Search\Agent\Replace;
use VDM\Joomla\Componentbuilder\Search\Agent\Search;
use VDM\Joomla\Componentbuilder\Search\Agent\Update;


/**
 * Agent Service Provider
 * 
 * @since 3.2.0
 */
class Agent implements ServiceProviderInterface
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
		$container->alias(SearchAgent::class, 'Agent')
			->share('Agent', [$this, 'getAgent'], true);

		$container->alias(Find::class, 'Agent.Find')
			->share('Agent.Find', [$this, 'getFind'], true);

		$container->alias(Replace::class, 'Agent.Replace')
			->share('Agent.Replace', [$this, 'getReplace'], true);

		$container->alias(Search::class, 'Agent.Search')
			->share('Agent.Search', [$this, 'getSearch'], true);

		$container->alias(Update::class, 'Agent.Update')
			->share('Agent.Update', [$this, 'getUpdate'], true);
	}

	/**
	 * Get the Search Agent
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  SearchAgent
	 * @since 3.2.0
	 */
	public function getAgent(Container $container): SearchAgent
	{
		return new SearchAgent(
			$container->get('Config'),
			$container->get('Get.Database'),
			$container->get('Set.Database'),
			$container->get('Agent.Find'),
			$container->get('Agent.Replace'),
			$container->get('Agent.Search')
		);
	}

	/**
	 * Get the Search Agent Find
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Find
	 * @since 3.2.0
	 */
	public function getFind(Container $container): Find
	{
		return new Find(
			$container->get('Config'),
			$container->get('Agent.Search')
		);
	}

	/**
	 * Get the Search Agent Replace
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Replace
	 * @since 3.2.0
	 */
	public function getReplace(Container $container): Replace
	{
		return new Replace(
			$container->get('Config'),
			$container->get('Agent.Update')
		);
	}

	/**
	 * Get the Search Agent Search
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Search
	 * @since 3.2.0
	 */
	public function getSearch(Container $container): Search
	{
		return new Search(
			$container->get('Search')
		);
	}

	/**
	 * Get the Search Agent Update
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Update
	 * @since 3.2.0
	 */
	public function getUpdate(Container $container): Update
	{
		return new Update(
			$container->get('Search')
		);
	}

}

