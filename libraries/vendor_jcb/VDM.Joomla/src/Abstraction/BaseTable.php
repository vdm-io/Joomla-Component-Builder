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


use VDM\Joomla\Interfaces\Tableinterface;


/**
 * Base Table
 * 
 * @since 3.2.0
 */
abstract class BaseTable implements Tableinterface
{
	/**
	 * All areas/views/tables with their field details
	 *
	 * @var     array
	 * @since 3.2.0
	 **/
	protected array $tables;

	/**
	 * All default fields
	 *
	 * @var     array
	 * @since 3.2.0
	 **/
	protected array $defaults = [
		'id' => [
			'order' => -1,
			'name' => 'id',
			'label' => 'ID',
			'type' => 'text',
			'title' => false,
			'list' => NULL,
			'store' => NULL,
			'tab_name' => NULL
		],
		'ordering' => [
			'name' => 'ordering',
			'label' => 'Ordering',
			'type' => 'number',
			'title' => false,
			'list' => NULL,
			'store' => NULL,
			'tab_name' => NULL
		],
		'published' => [
			'name' => 'published',
			'label' => 'Status',
			'type' => 'list',
			'title' => false,
			'list' => NULL,
			'store' => NULL,
			'tab_name' => NULL
		],
		'modified_by' => [
			'name' => 'modified_by',
			'label' => 'Modified by',
			'type' => 'user',
			'title' => false,
			'list' => NULL,
			'store' => NULL,
			'tab_name' => NULL
		],
		'modified' => [
			'name' => 'modified',
			'label' => 'Modified',
			'type' => 'calendar',
			'title' => false,
			'list' => NULL,
			'store' => NULL,
			'tab_name' => NULL
		],
		'created_by' => [
			'name' => 'created_by',
			'label' => 'Created by',
			'type' => 'user',
			'title' => false,
			'list' => NULL,
			'store' => NULL,
			'tab_name' => NULL
		],
		'created' => [
			'name' => 'created',
			'label' => 'Created',
			'type' => 'calendar',
			'title' => false,
			'list' => NULL,
			'store' => NULL,
			'tab_name' => NULL
		],
		'hits' => [
			'name' => 'hits',
			'label' => 'Hits',
			'type' => 'number',
			'title' => false,
			'list' => NULL,
			'store' => NULL,
			'tab_name' => NULL
		],
		'version' => [
			'name' => 'version',
			'label' => 'Version',
			'type' => 'text',
			'title' => false,
			'list' => NULL,
			'store' => NULL,
			'tab_name' => NULL
		]
	];

	/**
	 * Get any value from a item/field/column of an area/view/table
	 *          Example: $this->get('table_name', 'field_name', 'value_key');
	 * Get an item/field/column of an area/view/table
	 *          Example: $this->get('table_name', 'field_name');
	 * Get all items/fields/columns of an area/view/table
	 *          Example: $this->get('table_name');
	 * Get all areas/views/tables with all their item/field/column details
	 *          Example: $this->get('All');
	 *
	 * @param   string       $table  The table
	 * @param   string|null  $field  The field
	 * @param   string|null  $key    The value key
	 *
	 * @return  mixed
	 * @since 3.2.0
	 */
	public function get(string $table, ?string $field = null, ?string $key = null)
	{
		// return the item/field/column of an area/view/table 
		if (is_string($field) && is_string($key))
		{
			// return the value of a item/field/column of an area/view/table 
			if (isset($this->tables[$table][$field][$key]))
			{
				return $this->tables[$table][$field][$key];
			}

			return $this->getDefaultKey($field, $key);
		}
		// return the item/field/column of an area/view/table 
		elseif (is_string($field))
		{
			if (isset($this->tables[$table][$field]))
			{
				return $this->tables[$table][$field];
			}

			return  $this->getDefault($field);
		}
		// return an area/view/table
		elseif ($table !== 'All')
		{
			if (isset($this->tables[$table]))
			{
				return $this->tables[$table];
			}
			return null;
		}

		// return all
		return $this->tables;
	}

	/**
	 * Get title field from an area/view/table
	 *
	 * @param   string   $table  The area
	 *
	 * @return  ?array
	 * @since 3.2.0
	 */
	public function title(string $table): ?array
	{
		// return the title item/field/column of an area/view/table 
		if (($table = $this->get($table)) !== null)
		{
			foreach ($table as $item)
			{
				if ($item['title'])
				{
					return $item;
				}
			}
		}

		// none found
		return null;
	}

	/**
	 * Get title field name
	 *
	 * @param   string   $table  The area
	 *
	 * @return  string
	 * @since 3.2.0
	 */
	public function titleName(string $table): string
	{
		// return the title name of an area/view/table
		if (($field = $this->title($table)) !== null)
		{
			return $field['name'];
		}

		// none found default to ID
		return 'id';
	}

	/**
	 * Get all tables
	 *
	 * @return  array
	 * @since 3.2.0
	 */
	public function tables(): array
	{
		// return all areas/views/tables
		return array_keys($this->tables);
	}

	/**
	 * Check if a table (and field) exist
	 *
	 * @param   string       $table  The area
	 * @param   string|null  $field  The area
	 *
	 * @return  bool
	 * @since 3.2.0
	 */
	public function exist(string $table, ?string $field = null): bool
	{
		if (isset($this->tables[$table]))
		{
			// if we have a field
			if (is_string($field))
			{
				if (isset($this->tables[$table][$field]))
				{
					return true;
				}
			}
			else
			{
				return true;
			}
		}

		return $this->isDefault($field);
	}

	/**
	 * Get all fields of an area/view/table
	 *
	 * @param   string  $table     The area
	 * @param   bool    $default   Add the default fields
	 *
	 * @return  array|null   On success an array of fields
	 * @since 3.2.0
	 */
	public function fields(string $table, bool $default = false): ?array
	{
		// return all fields of an area/view/table
		if (($table = $this->get($table)) !== null)
		{
			if ($default)
			{
				return $this->addDefault(array_keys($table));
			}
			else
			{
				return array_keys($table);
			}
		}

		// none found
		return null;
	}

	/**
	 * Add the default fields
	 *
	 * @param   array  $fields   The table dynamic fields
	 *
	 * @return  array   Fields (with defaults added)
	 * @since 3.2.0
	 */
	protected function addDefault(array $fields): array
	{
		// add default fields
		foreach ($this->defaults as $default)
		{
			// used just for loading the fields
			$order = $default['order'] ?? 1;
			unset($default['order']);

			if ($order < 0)
			{
				array_unshift($fields, $default['name']);
			}
			else
			{
				$fields[] = $default['name'];
			}
		}

		return $fields;
	}

	/**
	 * Check if the field is a default field
	 *
	 * @param   string  $field  The field to check
	 *
	 * @return  bool   True if a default field
	 * @since 3.2.0
	 */
	protected function isDefault(string $field): bool
	{
		return isset($this->defaults[$field]);
	}

	/**
	 * Get a default field
	 *
	 * @param   string  $field  The field to check
	 *
	 * @return  array|null   True if a default field
	 * @since 3.2.0
	 */
	protected function getDefault(string $field): ?array
	{
		return $this->defaults[$field] ?? null;
	}

	/**
	 * Get a default field property
	 *
	 * @param   string  $field   The field to check
	 * @param   string  $key     The field key/property to check
	 *
	 * @return  string|null   String value if a default field property exist
	 * @since 3.2.0
	 */
	protected function getDefaultKey(string $field, string $key): ?string
	{
		return $this->defaults[$field][$key] ?? null;
	}
}

