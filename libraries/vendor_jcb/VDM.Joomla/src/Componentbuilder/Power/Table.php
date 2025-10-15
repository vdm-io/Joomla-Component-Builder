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

namespace VDM\Joomla\Componentbuilder\Power;


use VDM\Joomla\Componentbuilder\Power\Interfaces\TableInterface;
use VDM\Joomla\Componentbuilder\Table as ExtendingTable;


/**
 * Package Table
 * 
 * @since 5.1.1
 */
final class Table extends ExtendingTable implements TableInterface
{
	/**
	 * Get all parents fields of an area/view/table
	 *
	 * @param   string  $table     The area
	 *
	 * @return  array  An array of fields
	 * @since   5.1.1
	 */
	public function parents(string $table): array
	{
		// Retrieve fields from the specified table
		$fields = $this->get($table);

		if ($fields === null)
		{
			return [];
		}

		$linked = [];

		foreach ($fields as $name => $field)
		{
			if ($this->isValidParent($field))
			{
				$linked[$name] = $field['link'];
			}

			if ($this->isSubform($field))
			{
				$this->traverseSubformParents($name, $field['fields'], $linked);
			}
		}

		return $linked;
	}

	/**
	 * Get direct children dependencies pointing to the given entity.
	 *
	 * This method returns a map of `$entity` field keys to an array of referencing tables and fields.
	 *
	 * @param   string       $entity  The target entity name being linked to (e.g., 'power').
	 * @param   array|null   $direct  The direct children.
	 *                                     empty-array: means return none
	 *                                     null: means return all
	 *
	 * @return  array  An associative array: [targetField => [['table' => string, 'name' => string], ...]]
	 * @since   5.1.1
	 */
	public function children(string $entity, ?array $direct = null): array
	{
		$result = [];

		if ($direct !== null && $direct === [])
		{
			return $result;
		}

		foreach ($this->tables as $table => $fields)
		{
			if ($direct !== null && !in_array($table, $direct, true))
			{
				continue;
			}

			foreach ($fields as $name => $field)
			{
				$link = $field['link'] ?? null;

				if ($this->isValidChild($link, $entity))
				{
					$entity_field = $link['key'];
					$result[$entity_field][] = [
						'table' => "#__componentbuilder_{$table}",
						'entity' => $table,
						'key'  => $name
					];
				}

				if ($this->isSubform($field))
				{
					$this->traverseSubformChildren($table, $name, $field['fields'], $entity, $result);
				}
			}
		}

		return $result;
	}

	/**
	 * Loops over the $table fields and builds a new array
	 *    that hold all the fields to be searched in a specific area of JCB
	 *
	 * @param string  $table  The target table to search
	 * @param string  $area   The target areas to search
	 *
	 * @return array The newly built array.
	 * @since  5.1.0
	 */
	public function search(string $table, string $area): array
	{
		$result = [];

		$fields = $this->get($table) ?? [];

		// Loop over each field in the current table.
		foreach ($fields as $fieldName => $fieldProperties)
		{
			// Check if the field type is one of the target types.
			if ($area === 'code')
			{
				if (isset($fieldProperties['type']) && isset($fieldProperties['db']['type']) &&
					in_array($fieldProperties['type'], ['text', 'textarea', 'editor'], true) &&
					in_array($fieldProperties['db']['type'], ['MEDIUMTEXT', 'TEXT'], true))
				{
					$result[$fieldName] = $fieldName;
				}
			}
			elseif ($area === 'customcode')
			{
				if (isset($fieldProperties['type']) && isset($fieldProperties['db']['type']) &&
					isset($fieldProperties['store']) && $fieldProperties['store'] === 'base64' &&
					in_array($fieldProperties['type'], ['textarea', 'editor'], true) &&
					in_array($fieldProperties['db']['type'], ['MEDIUMTEXT'], true))
				{
					$result[$fieldName] = $fieldName;
				}
			}
			elseif ($area === 'placeholders')
			{
				if (isset($fieldProperties['type']) &&
					in_array($fieldProperties['type'], ['text', 'textarea', 'editor'], true))
				{
					$result[$fieldName] = $fieldName;
				}
			}
		}

		return $result;
	}

	/**
	 * Get the list view code name from a table's fields.
	 *
	 * This method returns the first field where the 'list' key is a non-empty string.
	 *
	 * @param   string  $table  The table name to retrieve fields for.
	 *
	 * @return  string|null  The list view code name, or null if not found.
	 * @since   5.1.2
	 */
	public function listViewCodeName(string $table): ?string
	{
		$fields = $this->get($table);

		if (!is_array($fields))
		{
			return null;
		}

		foreach ($fields as $field)
		{
			if (
				array_key_exists('list', $field)
				&& is_string($field['list'])
				&& strlen($field['list']) > 0
			)
			{
				return $field['list'];
			}
		}

		return null;
	}

	/**
	 * Recursively traverses subform fields to collect valid parent fields
	 *
	 * @param   string $name    The current field name
	 * @param   array  $fields  The current set of subform fields
	 * @param   array  &$linked The reference bucket to collect linked fields
	 *
	 * @return  void
	 * @since   5.1.1
	 */
	private function traverseSubformParents(string $name, array $fields, array &$linked): void
	{
		foreach ($fields as $sub_name => $field)
		{
			$key_name = $name . '|' . $sub_name;
			if ($this->isValidParent($field))
			{
				$linked[$key_name] = $field['link'];
			}

			if ($this->isSubform($field))
			{
				$this->traverseSubformParents($key_name, $field['fields'], $linked);
			}
		}
	}

	/**
	 * Recursively traverses subform fields to collect valid Children dependencies
	 *
	 * @param   string $table         The current table name
	 * @param   string $name          The current field name
	 * @param   array  $fields        The current set of subform fields
	 * @param   array  &$result       The reference bucket to collect linked fields
	 *
	 * @return  void
	 * @since   5.1.1
	 */
	private function traverseSubformChildren(string $table, string $name, array $fields,
		string $entity, array &$result): void
	{
		foreach ($fields as $sub_name => $field)
		{
			$link = $field['link'] ?? null;
			$key_name = $name . '|' . $sub_name;

			if ($this->isValidChild($link, $entity))
			{
				$entity_field = $link['key'];
				$result[$entity_field][] = [
					'table' => "#__componentbuilder_{$table}",
					'entity' => $table,
					'key'  => $key_name
				];
			}

			if ($this->isSubform($field))
			{
				$this->traverseSubformChildren($table, $key_name, $field['fields'], $entity, $result);
			}
		}
	}

	/**
	 * Validates that the given field represents a well-formed subform.
	 *
	 * @param   array  $field  The field metadata array from the table map.
	 *
	 * @return  bool  True if the field has a valid subform; false otherwise.
	 * @since   5.1.1
	 */
	private function isSubform(array $field): bool
	{
		$type = $field['type'] ?? null;
		$fields = $field['fields'] ?? null;

		return $type === 'subform' && !empty($fields);
	}

	/**
	 * Validates that the given field represents a well-formed outgoing/parent link.
	 *
	 * @param   array  $field  The field metadata array from the table map.
	 *
	 * @return  bool  True if the field has a valid outgoing/parent link; false otherwise.
	 * @since   5.1.1
	 */
	private function isValidParent(array $field): bool
	{
		$link = $field['link'] ?? null;

		return is_array($link)
			&& ($link['type'] ?? 0) === 1
			&& !empty($link['entity'])
			&& !empty($link['table'])
			&& !empty($link['key'])
			&& $link['key'] === 'guid';
	}

	/**
	 * Validates that the provided link config represents a valid child dependency on the given entity.
	 *
	 * @param   array|null  $link     The 'link' metadata from a field definition.
	 * @param   string      $entity   The entity to which the field must link.
	 *
	 * @return  bool  True if the field represents a valid child dependency to the entity.
	 * @since   5.1.1
	 */
	private function isValidChild(?array $link, string $entity): bool
	{
		return is_array($link)
			&& ($link['type'] ?? 0) === 1
			&& !empty($link['entity'])
			&& !empty($link['table'])
			&& !empty($link['key'])
			&& $link['entity'] === $entity;
	}
}

