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

namespace VDM\Joomla\Abstraction;


use Joomla\CMS\Factory;
use VDM\Joomla\Interfaces\Tableinterface as Table;
use VDM\Joomla\Interfaces\SchemaInterface;


/**
 * Schema Checking
 * 
 * @since 3.2.1
 */
abstract class Schema implements SchemaInterface
{
	/**
	 * The Table Class.
	 *
	 * @var   Table
	 * @since 3.2.1
	 */
	protected Table $table;

	/**
	 * The Database Class
	 *
	 * @since 3.2.1
	 */
	protected $db;

	/**
	 * The local tables
	 *
	 * @var   array
	 * @since 3.2.1
	 */
	private array $tables;

	/**
	 * The component table prefix
	 *
	 * @var   string
	 * @since 3.2.1
	 */
	private string $prefix;

	/**
	 * The field unique keys
	 *
	 * @var   array
	 * @since 3.2.1
	 */
	private array $uniqueKeys;

	/**
	 * The field keys
	 *
	 * @var   array
	 * @since 3.2.1
	 */
	private array $keys;

	/**
	 * The current table columns
	 *
	 * @var   array
	 * @since 3.2.1
	 */
	private array $columns;

	/**
	 * The success messages of the action
	 *
	 * @var   array
	 * @since 3.2.1
	 */
	private array $success;

	/**
	 * Constructor.
	 *
	 * @param Table   $table   The Table Class.
	 *
	 * @since 3.2.1
	 * @throws \Exception If the database fails
	 */
	public function __construct(Table $table)
	{
		$this->table = $table;

		try {
			// set the database object
			$this->db = Factory::getDbo();

			// get current component tables
			$this->tables = $this->db->getTableList();

			// set the component table
			$this->prefix = $this->db->getPrefix() . $this->getCode();
		} catch (\Exception $e) {
			throw new \Exception("Error: failed to initialize schema class due to a database error.", 0, $e);
		}
	}

	/**
	 * Check and update database schema for missing fields or tables.
	 *
	 * @return array   The array of successful updates/actions, if empty no update/action was taken.
	 * @since  3.2.1
	 * @throws \Exception If there is an error during the update process.
	 */
	public function update(): array
	{
		try {
			$this->success = [
				"Success: scan of the component tables started."
			];
			foreach ($this->table->tables() as $table)
			{
				$this->uniqueKeys = [];
				$this->keys = [];

				if ($this->tableExists($table))
				{
					$this->updateSchema($table);
				}
				else
				{
					$this->createTable($table);
				}
			}
		} catch (\Exception $e) {
			throw new \Exception("Error: updating database schema.", 0, $e);
		}

		if (count($this->success) == 1)
		{
			$this->success[] = "Success: scan of the component tables completed with no update needed.";
		}
		else
		{
			$this->success[] = "Success: scan of the component tables completed.";
		}

		return $this->success;
	}

	/**
	 * Create a table with all necessary fields.
	 *
	 * @param string $table The name of the table to create.
	 *
	 * @return void
	 * @since  3.2.1
	 * @throws \Exception If there is an error creating the table.
	 */
	public function createTable(string $table): void
	{
		try {
			$columns = [];
			$fields = $this->table->fields($table, true);
			$createTable = 'CREATE TABLE IF NOT EXISTS ' . $this->db->quoteName($this->getTable($table));

			foreach ($fields as $field)
			{
				if (($def = $this->getColumnDefinition($table, $field)) !== null)
				{
					$columns[] = $def;
				}
			}

			$columnDefinitions = implode(', ', $columns);

			$keys = $this->getTableKeys();

			$createTableSql = "$createTable ($columnDefinitions, $keys)";

			$this->db->setQuery($createTableSql);
			$this->db->execute();
		} catch (\Exception $e) {
			throw new \Exception("Error: failed to create missing $table table.", 0, $e);
		}

		$this->success[] = "Success: created missing  $table table.";
	}

	/**
	 * Update the schema of an existing table.
	 *
	 * @param string $table  The table to update.
	 *
	 * @return void
	 * @since  3.2.1
	 * @throws \Exception If there is an error while updating the schema.
	 */
	public function updateSchema(string $table): void
	{
		try {
			$existingColumns = $this->getExistingColumns($table);
			$expectedColumns = $this->table->fields($table, true);

			$missingColumns = array_diff($expectedColumns, $existingColumns);

			if (!empty($missingColumns))
			{
				$this->addMissingColumns($table, $missingColumns);
			}

			$this->checkColumnsDataType($table, $expectedColumns);

		} catch (\Exception $e) {
			throw new \Exception("Error: updating schema for $table table.", 0, $e);
		}

		if (!empty($missingColumns))
		{
			$column_s = (count($missingColumns) == 1) ? 'column' : 'columns';
			$missingColumns = implode(', ', $missingColumns);
			$this->success[] = "Success: added missing ($missingColumns) $column_s to $table table.";
		}
	}

	/**
	 * Get the targeted component code
	 *
	 * @return  string
	 * @since 3.2.1
	 */
	abstract protected function getCode(): string;

	/**
	 * Add missing columns to a table.
	 *
	 * @param string $table   The table to update.
	 * @param array  $columns List of missing columns/fields.
	 *
	 * @return void
	 * @since  3.2.1
	 * @throws \Exception If there is an error adding columns.
	 */
	protected function addMissingColumns(string $table, array $columns): void
	{
		try {
			$query = $this->db->getQuery(true);
			$alterTable = 'ALTER TABLE ' . $this->db->quoteName($this->getTable($table)) . ' ';

			// Start an ALTER TABLE query
			$alterQueries = [];
			foreach ($columns as $column)
			{
				if (($def = $this->getColumnDefinition($table, $column)) !== null)
				{
					$alterQueries[] = " ADD " . $def;
				}
			}

			$this->db->setQuery($alterTable . implode(', ', $alterQueries));
			$this->db->execute();
		} catch (\Exception $e) {
			$column_s = (count($columns) == 1) ? 'column' : 'columns';
			$columns = implode(', ', $columns);
			throw new \Exception("Error: failed to add ($columns) $column_s to $table table.", 0, $e);
		}
	}

	/**
	 * Validate and update the data type of existing fields/columns
	 *
	 * @param string $table    The table to update.
	 * @param array  $columns  List of columns/fields to check.
	 *
	 * @return void
	 * @since  3.2.1
	 */
	protected function checkColumnsDataType(string $table, array $columns): void
	{
		$requireUpdate = [];
		foreach ($columns as $column)
		{
			$current = $this->columns[$column] ?? null;
			if ($current === null || ($expected = $this->table->get($table, $column, 'db')) === null)
			{
				// this field is no longer part of the component and can be ignored
				continue;
			}

			// check if the data type and size match
			if (strcasecmp($current->Type, $expected['type']) != 0)
			{
				$requireUpdate[$column] = [
					'column' => $column,
					'current' => $current->Type,
					'expected' => $expected['type']
				];
			}
		}

		if (!empty($requireUpdate))
		{
			$this->updateColumnsDataType($table, $requireUpdate);
		}
	}

	/**
	 * Update the data type of the given fields.
	 *
	 * @param string $table   The table to update.
	 * @param array  $columns List of columns/fields that must be updated.
	 *
	 * @return void
	 * @since  3.2.1
	 */
	protected function updateColumnsDataType(string $table, array $columns): void
	{
		$alterTable = 'ALTER TABLE ' . $this->db->quoteName($this->getTable($table));
		foreach ($columns as $column => $types)
		{
			if (($def = $this->getColumnDefinition($table, $column)) === null)
			{
				continue;
			}

			$dbField = $this->db->quoteName($column);
			$alterQuery = "$alterTable CHANGE $dbField ". $def;

			if ($this->updateColumnDataType($alterQuery, $table, $column))
			{
				$current = (string) $types['current'] ?? 'error';
				$expected = (string) $types['expected'] ?? 'error';
				$this->success[] = "Success: updated ($column) column datatype $current to $expected in $table table.";
			}
		}
	}
	
	/**
	 * Update the data type of the given field.
	 *
	 * @param string $updateString  The SQL command to update the column data type
	 * @param string $table         The table to update.
	 * @param string $field         Column/field that must be updated.
	 *
	 * @return bool  true on succes
	 * @since  3.2.1
	 * @throws \Exception If there is an error adding columns.
	 */
	protected function updateColumnDataType(string $updateString, string $table, string $field): bool
	{
		try {
			$this->db->setQuery($updateString);
			return $this->db->execute();
		} catch (\Exception $e) {
			throw new \Exception("Error: failed to update the datatype of ($field) column in $table table.", 0, $e);
		}
	}

	/**
	 * Key all needed keys for this table
	 *
	 * @return string of keys
	 * @since  3.2.1
	 */
	protected function getTableKeys(): string
	{
		$keys = [];
		$keys[] = 'PRIMARY KEY  (`id`)'; // TODO (we may want this to be dynamicly set)

		if (!empty($this->uniqueKeys))
		{
			$keys[] = implode(', ', $this->uniqueKeys);
		}

		if (!empty($this->keys))
		{
			$keys[] = implode(', ', $this->keys);
		}

		return implode(', ', $keys);
	}

	/**
	 * Function to set the unique key
	 *
	 * @param string $column The field column database array values
	 *
	 * @return void
	 * @since  3.2.1
	 */
	protected function setUniqueKey(array $column): void
	{
		if (isset($column['unique_key']) && $column['unique_key'])
		{
			$key = $column['unique_key_name'] ?? $column['name'];
			$this->uniqueKeys[] = "UNIQUE KEY `idx_" . $key . "` (`" . $column['name'] . "`)";
		}
	}

	/**
	 * Function to set the key
	 *
	 * @param string $column The field column database array values
	 *
	 * @return void
	 * @since  3.2.1
	 */
	protected function setKey(array $column): void
	{
		if (isset($column['key']) && $column['key'])
		{
			$key = $column['key_name'] ?? $column['name'];
			$this->keys[] = "KEY `idx_" . $key . "` (`" . $column['name'] . "`)";
		}
	}

	/**
	 * Add the component name to get the full table name.
	 *
	 * @param string $table The table name.
	 *
	 * @return void
	 * @since  3.2.1
	 */
	protected function getTable(string $table): string
	{
		return $this->prefix . '_' . $table;
	}

	/**
	 * Check if a table exists in the database.
	 *
	 * @param string $table The name of the table to check.
	 *
	 * @return bool True if table exists, False otherwise.
	 * @since  3.2.1
	 */
	private function tableExists(string $table): bool
	{
		return in_array($this->getTable($table), $this->tables);
	}

	/**
	 * Fetch existing columns from a database table.
	 *
	 * @param string $table The name of the table.
	 *
	 * @return array An array of column names.
	 * @since  3.2.1
	 */
	private function getExistingColumns(string $table): array
	{
		$this->columns = $this->db->getTableColumns($this->getTable($table), false);

		return array_keys($this->columns);
	}

	/**
	 * Generates a SQL snippet for defining a table column, incorporating column type,
	 *    default value, nullability, and auto-increment properties.
	 *
	 * @param string $table The table name to be used.
	 * @param string $field The field name in the table to generate SQL for.
	 *
	 * @return string|null The SQL snippet for the column definition.
	 * @since 3.2.1
	 * @throws \Exception If the schema details cannot be retrieved or the SQL statement cannot be constructed properly.
	 */
	private function getColumnDefinition(string $table, string $field): ?string
	{
		try {
			// Retrieve the database schema details for the specified table and field
			if (($db = $this->table->get($table, $field, 'db')) === null)
			{
				return null;
			}

			// Prepare the column name
			$column_name = $this->db->quoteName($field);
			$db['name'] = $field;

			// Prepare the default value SQL, null switch, and auto increment statement
			$default = !empty($db['default']) ? " DEFAULT " . $this->db->quote($db['default']) : '';
			$null_switch = !empty($db['null_switch']) ? " " . $db['null_switch'] : '';
			$auto_increment = !empty($db['auto_increment']) ? " AUTO_INCREMENT" : '';
			$type = !empty($db['type']) ? $db['type'] : 'TEXT';

			$this->setKeys($db);

			// Assemble the SQL snippet for the column definition
			return "{$column_name} {$type}{$default}{$null_switch}{$auto_increment}";
		} catch (\Exception $e) {
			throw new \Exception("Error: failed to generate column definition for $table.$field", 0, $e);
		}
	}

	/**
	 * Function to set the view keys
	 *
	 * @param string $column The field column database array values
	 *
	 * @return void
	 * @since  3.2.1
	 */
	private function setKeys(array $column): void
	{
		$this->setUniqueKey($column);
		$this->setKey($column);
	}
}

