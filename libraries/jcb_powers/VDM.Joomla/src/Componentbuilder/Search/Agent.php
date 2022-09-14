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

namespace VDM\Joomla\Componentbuilder\Search;


use VDM\Joomla\Componentbuilder\Search\Factory;
use VDM\Joomla\Componentbuilder\Search\Config;
use VDM\Joomla\Componentbuilder\Search\Database\Get;
use VDM\Joomla\Componentbuilder\Search\Database\Set;
use VDM\Joomla\Componentbuilder\Search\Agent\Find;
use VDM\Joomla\Componentbuilder\Search\Agent\Replace;
use VDM\Joomla\Componentbuilder\Search\Agent\Search;


/**
 * Search Agent
 * 
 * @since 3.2.0
 */
class Agent
{
	/**
	 * Search Config
	 *
	 * @var    Config
	 * @since 3.2.0
	 */
	protected Config $config;

	/**
	 * Search Get Database
	 *
	 * @var    Get
	 * @since 3.2.0
	 */
	protected Get $get;

	/**
	 * Search Set Database
	 *
	 * @var    Set
	 * @since 3.2.0
	 */
	protected Set $set;

	/**
	 * Search Find
	 *
	 * @var    Find
	 * @since 3.2.0
	 */
	protected Find $find;

	/**
	 * Search Replace
	 *
	 * @var    Replace
	 * @since 3.2.0
	 */
	protected Replace $replace;

	/**
	 * Search
	 *
	 * @var    Search
	 * @since 3.2.0
	 */
	protected Search $search;

	/**
	 * Constructor
	 *
	 * @param Config|null         $config         The search config object.
	 * @param Get|null            $get            The search get database object.
	 * @param Set|null            $set            The search get database object.
	 * @param Find|null           $find           The search find object.
	 * @param Replace|null        $replace        The search replace object.
	 * @param Search|null         $search         The search object.
	 *
	 * @since 3.2.0
	 */
	public function __construct(?Config $config = null, ?Get $get = null,
		?Set$set = null, ?Find $find = null, ?Replace $replace = null,
		?Search $search = null)
	{
		$this->config = $config ?: Factory::_('Config');
		$this->get = $get ?: Factory::_('Get.Database');
		$this->set = $set ?: Factory::_('Set.Database');
		$this->find = $find ?: Factory::_('Agent.Find');
		$this->replace = $replace ?: Factory::_('Agent.Replace');
		$this->search = $search ?: Factory::_('Agent.Search');
	}

	/**
	 * Search the posted table for the search value and return all
	 *
	 * @param string|null     $table    The table being searched
	 *
	 * @return  array|null
	 * @since 3.2.0
	 */
	public function find(?string $table = null): ?array
	{
		// set the table name
		if (empty($table))
		{
			$table = $this->config->table_name;
		}

		$set = 1;

		// continue loading items until all are searched
		while(($items = $this->get->items($table, $set)) !== null)
		{
			$this->find->items($items, $table);
			$set++;
		}

		return $this->search->found($table);
	}

	/**
	 * Search the posted table for the search value, and replace all
	 *
	 * @param string|null     $table    The table being searched
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function replace(?string $table = null)
	{
		// set the table name
		if (empty($table))
		{
			$table = $this->config->table_name;
		}

		$set = 1;

		// continue loading items until all was loaded
		while(($items = $this->get->items($table, $set)) !== null)
		{
			// search for items
			$this->find->items($items, $table);

			// update those found
			$this->replace->items($this->find->get($table), $table);

			// update the database
			$this->set->items($this->replace->get($table), $table);

			// reset found items
			$this->find->reset($table);
			$this->replace->reset($table);

			$set++;
		}
	}

}

