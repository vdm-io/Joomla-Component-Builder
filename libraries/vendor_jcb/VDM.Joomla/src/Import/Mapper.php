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

namespace VDM\Joomla\Import;


use VDM\Joomla\Interfaces\TableInterface as Table;
use VDM\Joomla\Interfaces\Import\MapperInterface;


/**
 * Import Mapper Class
 * 
 * @since  4.0.3
 */
final class Mapper implements MapperInterface
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
	 * Build the table-to-field mapping for import processing.
	 *
	 * Parent table fields are stored directly, while foreign table fields
	 * are grouped under their respective join table names.
	 *
	 * @param   object  $map          The import file map.
	 * @param   string  $parentTable  The parent table name.
	 *
	 * @return  void
	 * @since   4.0.3
	 */
	public function set(object $map, string $parentTable): void
	{
		// Always reset state
		$this->parent = [];
		$this->join   = [];

		foreach ($map as $row)
		{
			if (empty($row->target) || empty($row->column))
			{
				continue;
			}

			$mapping = $this->getTableField($row->target);

			if ($mapping === null)
			{
				continue;
			}

			$field = $this->table->get($mapping->table, $mapping->field);

			if (!empty($mapping->column_value))
			{
				$field['subform_2'] = $mapping;
			}

			if ($mapping->table === $parentTable)
			{
				$this->parent[$row->column] = $field;
				continue;
			}

			$this->join[$mapping->table][$row->column] = $field;
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
	 * Get the table and field name from an import key.
	 *
	 * Expected format:
	 *   table.field
	 *   table.field.subfield.another
	 *
	 * Only the first dot separates table and field.
	 *
	 * @param   string  $key  The import file key.
	 *
	 * @return  object|null  Object with table and field properties, or null if invalid.
	 * @since   4.0.3
	 */
	private function getTableField(string $key): ?object
	{
		// Split only on the first dot
		$parts = explode('.', $key, 2);

		// Must contain a table and a field
		if (count($parts) !== 2 || $parts[0] === '' || $parts[1] === '')
		{
			return null;
		}

		[$table, $field] = $parts;

		// Sub-from support (ONLY two values in subform)
		if (strpos($field, '|') !== false)
		{
			$parts_ = array_map('trim', explode('|', $field));

			if (count($parts_) === 4)
			{
				[$field, $value, $column, $columnValue] = $parts_;
			}
		}

		// Validate table/field existence
		if (!$this->table->exist($table, $field))
		{
			return null;
		}

		// ONLY two value sub-from mapping supported [table.field|value|column|column_value]
		if (!empty($value) && !empty($column) && !empty($columnValue))
		{
			return (object) [
				'table' => $table,
				'field' => $field,
				'value' => $value,
				'column' => $column,
				'column_value' => $columnValue
			];
		}

		return (object) [
			'table' => $table,
			'field' => $field,
		];
	}
}

