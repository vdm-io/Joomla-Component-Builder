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

namespace VDM\Joomla\Componentbuilder\Search\Agent;


use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\ObjectHelper;
use VDM\Joomla\Componentbuilder\Search\Factory;
use VDM\Joomla\Componentbuilder\Search\Config;
use VDM\Joomla\Componentbuilder\Search\Agent\Search;
use VDM\Joomla\Componentbuilder\Search\Interfaces\FindInterface;


/**
 * Search Agent Find
 * 
 * @since 3.2.0
 */
class Find implements FindInterface
{
	/**
	 * Found Values
	 *
	 * @var    array
	 * @since 3.2.0
	 */
	protected array $found = [];

	/**
	 * Search Config
	 *
	 * @var    Config
	 * @since 3.2.0
	 */
	protected Config $config;

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
	 * @param Config|null      $config      The search config object.
	 * @param Search|null      $search      The search object.
	 *
	 * @since 3.2.0
	 */
	public function __construct(?Config $config = null, ?Search $search = null)
	{
		$this->config = $config ?: Factory::_('Config');
		$this->search = $search ?: Factory::_('Agent.Search');
	}

	/**
	 * Get found values
	 *
	 * @param string|null    $table   The table being searched
	 *
	 * @return  array|null
	 * @since 3.2.0
	 */
	public function get(?string $table = null): ?array
	{
		// set the table name
		if (empty($table))
		{
			$table = $this->config->table_name;
		}

		if (isset($this->found[$table]))
		{
			return $this->found[$table];
		}

		return null;
	}

	/**
	 * Search over an item fields
	 *
	 * @param object          $item    The item object of fields to search through
	 * @param int|null        $id      The item id
	 * @param string|null     $table   The table being searched
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function item(object $item, ?int $id =null, ?string $table = null)
	{
		// set the table name
		if (empty($table))
		{
			$table = $this->config->table_name;
		}

		// set the item id
		if (empty($id))
		{
			$id = $item->id;
		}

		if (ObjectHelper::check($item))
		{
			foreach ($item as $field => $value)
			{
				if ($field !== 'id' && $this->search->value($value, $id, $field, $table))
				{
					if (empty($this->found[$table][$id]))
					{
						$this->found[$table][$id] = new \stdClass();
						$this->found[$table][$id]->id = $id;
					}
					$this->found[$table][$id]->{$field} = $value;
				}
			}
		}
	}

	/**
	 * Search over an array of items
	 *
	 * @param array|null     $items    The array of items to search through
	 * @param string|null    $table    The table being searched
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function items(?array $items = null, ?string $table = null)
	{
		// set the table name
		if (empty($table))
		{
			$table = $this->config->table_name;
		}

		if (ArrayHelper::check($items))
		{
			foreach ($items as $id => $item)
			{
				$this->item($item, $id, $table);
			}
		}
	}

	/**
	 * Reset all found values of a table
	 *
	 * @param string|null    $table   The table being searched
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function reset(?string $table = null)
	{
		// set the table name
		if (empty($table))
		{
			$table = $this->config->table_name;
		}

		// empty or unset the table active values
		unset($this->found[$table]);
	}

}

