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

namespace VDM\Joomla\Componentbuilder\Import;


use VDM\Joomla\Interfaces\TableInterface as Table;
use VDM\Joomla\Componentbuilder\Interfaces\ImportMapperInterface;


/**
 * Import Mapper Class
 * 
 * @since  4.0.3
 */
final class Mapper implements ImportMapperInterface
{
	/**
	 * The Table Class.
	 *
	 * @var   Table
	 * @since 4.0.3
	 */
	protected Table $table;

	/**
	 * The current parent table map.
	 *
	 * @var   array
	 * @since 4.0.3
	 */
	private array $parent = [];

	/**
	 * The current join tables map.
	 *
	 * @var   array
	 * @since 4.0.3
	 */
	private array $join = [];

	/**
	 * Constructor.
	 *
	 * @param Table   $table   The Table Class.
	 *
	 * @since 4.0.3
	 */
	public function __construct(Table $table)
	{
		$this->table = $table;
	}

	/**
	 * Set the tables mapper
	 *
	 * @param   object  $map          The import file map.
	 * @param   string  $parentTable  The parent table name.
	 *
	 * @return  void
	 * @since  4.0.3
	 */
	public function set(object $map, string $parentTable): void
	{
		// always reset these
		$this->parent = [];
		$this->join = [];

		foreach ($map as $row)
		{
			$target = $row->target ?? null;

			if (empty($target))
			{
				continue;
			}

			if (($tm = $this->getTableField($target)) !== null)
			{
				$field = $this->table->get($tm->table, $tm->field);
				if ($tm->table === $parentTable)
				{
					$this->parent[$row->column] = $field;
				}
				else
				{
					$this->join[$tm->table][$row->column] = $field;
				}
			}
		}
	}

	/**
	 * Get the parent table keys
	 *
	 * @return  array
	 * @since  4.0.3
	 */
	public function getParent(): array
	{
		return $this->parent;
	}

	/**
	 * Get the join tables keys
	 *
	 * @return  array
	 * @since  4.0.3
	 */
	public function getJoin(): array
	{
		return $this->join;
	}

	/**
	 * Get the table and field name
	 *
	 * @param   string  $key  The import file key.
	 *
	 * @return  object|null
	 * @since  4.0.3
	 */
	private function getTableField(string $key): ?object
	{
		// Find the position of the first dot
		$dotPosition = strpos($key, '.');

		// If no dot is found, return the whole string
		if ($dotPosition === false)
		{
			return null;
		}

		// Extract the table (before the dot) and the field (after the dot)
		$table = substr($key, 0, $dotPosition);
		$field = substr($key, $dotPosition + 1);

		if ($this->table->exist($table ?? '_error', $field))
		{
			return (object) ['table' => $table, 'field' => $field];
		}

		return null;
	}
}

