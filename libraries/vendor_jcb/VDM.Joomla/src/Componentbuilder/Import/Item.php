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


use VDM\Joomla\Interfaces\TableValidatorInterface as Validator;
use VDM\Joomla\Interfaces\Data\ItemInterface as DataItem;
use VDM\Joomla\Componentbuilder\Interfaces\ImportRowInterface as Row;
use VDM\Joomla\Utilities\GuidHelper;
use VDM\Joomla\Componentbuilder\Interfaces\ImportItemInterface;


/**
 * Import Item Class
 * 
 * @since  4.0.3
 */
final class Item implements ImportItemInterface
{
	/**
	 * The Table Validator Class.
	 *
	 * @var   Validator
	 * @since 4.0.3
	 */
	protected Validator $validator;

	/**
	 * The Item Class.
	 *
	 * @var   Item
	 * @since 4.0.3
	 */
	protected DataItem $item;

	/**
	 * The Import Row Class.
	 *
	 * @var   Row
	 * @since 4.0.3
	 */
	protected Row $row;

	/**
	 * Constructor.
	 *
	 * @param Validator   $validator   The Table Validator Class.
	 * @param DataItem    $item        The Item Class.
	 * @param Row         $row         The Import Row Class.
	 *
	 * @since 4.0.3
	 */
	public function __construct(Validator $validator, DataItem $item, Row $row)
	{
		$this->validator = $validator;
		$this->item = $item;
		$this->row = $row;
	}

	/**
	 * Get the item from the import row values and ensure it is valid
	 *
	 * @param   string  $table    The table these columns belongs to.
	 * @param   array   $columns  The columns to extract.
	 *
	 * @return  array|null
	 * @since  4.0.3
	 */
	public function get(string $table, array $columns): ?array
	{
		$item = [];
		foreach ($columns as $column => $map)
		{
			if (($value = $this->row->getValue($column)) !== null && !isset($item[$map['name']]))
			{
				// get the valid importable value
				$item[$map['name']] = $this->getImportValue($value, $map['name'], $table, $map['link'] ?? null);

				// remove value from global row values set
				$this->row->unsetValue($column);
			}
		}

		return $item ?? null;
	}

	/**
	 * Get the correct value needed for the import of the related row (item).
	 *
	 * @param   mixed   $value   The value from the row.
	 * @param   string  $field   The field name where the value is being stored.
	 * @param   string  $table   The table this field belongs to.
	 * @param   array   $link    The field link values.
	 *
	 * @return  mixed
	 * @since   4.0.3
	 */
	private function getImportValue($value, string $field, string $table, ?array $link)
	{
		// Validate the link array and return the original value if invalid
		if (empty($link) || $link['type'] !== 1 || empty($link['table']) || empty($link['key']) || empty($link['value']))
		{
			return $this->validImportValue($value, $field, $table);
		}

		// Handle GUID key with validation via GuidHelper
		if ($link['key'] === 'guid' && GuidHelper::item($value, $link['table']))
		{
			return $value;
		}

		// Handle numeric ID with validation
		if ($link['key'] === 'id' && is_numeric($value) && $this->isValueExists($value, $link))
		{
			return (int) $value;
		}

		// Attempt to retrieve the local value
		$local_value = $this->getLocalValue($value, $link);

		// If no local value exists, create it if necessary
		if ($local_value === null)
		{
			$local_value = $this->setLocalValue($value, $link);
		}

		return $this->validImportValue($local_value, $field, $table);
	}

	/**
	 * Make sure we have a valid import value
	 *
	 * @param   mixed   $value   The value.
	 * @param   string  $field   The field name where the value is being stored.
	 * @param   string  $table   The table this field belongs to.
	 *
	 * @return  mixed
	 * @since   4.0.3
	 */
	private function validImportValue($value, string $field, string $table)
	{
		// make sure our value will fit in the database table datatype
		return $this->validator->getValid($value, $field, $table);
	}

	/**
	 * Helper function to get the local value from the database table.
	 *
	 * @param   mixed  $value  The value to search for.
	 * @param   array   $link   The field link details.
	 *
	 * @return  mixed|null  The local value or null if not found.
	 * @since   4.0.3
	 */
	private function getLocalValue($value, array $link)
	{
		// Attempt to retrieve the value based on the link['value'] and link['key']
		$local_value = $this->item->table($link['table'])->value($value, $link['value'], $link['key']);

		// If not found, try retrieving by link['key'] and link['key']
		if ($local_value === null && $this->isValueExists($value, $link))
		{
			return $value;
		}

		return $local_value;
	}

	/**
	 * Check if the value exists in the table for the given link.
	 *
	 * @param   mixed  $value  The value to check.
	 * @param   array   $link   The field link details.
	 *
	 * @return  bool  True if the value exists, false otherwise.
	 * @since   4.0.3
	 */
	private function isValueExists($value, array $link): bool
	{
		return $this->item->table($link['table'])->value($value, $link['key'], $link['key']) !== null;
	}

	/**
	 * Create a new value in the database table if it doesn't already exist.
	 *
	 * @param   mixed  $value  The value to create.
	 * @param   array   $link   The field link details.
	 *
	 * @return  mixed|null  The newly created value or null if creation failed.
	 * @since   4.0.3
	 */
	private function setLocalValue($value, array $link)
	{
		// Handle GUID creation if the provided value is not valid
		if ($link['key'] === 'guid')
		{
			if (!GuidHelper::valid($value))
			{
				return $this->insertItemWithGuid($value, $link);
			}
			return null;
		}

		// Handle ID creation
		if ($link['key'] === 'id')
		{
			if (!is_numeric($value))
			{
				return $this->insertItemWithId($value, $link);
			}
			return null;
		}

		// could not create local item (we don't have enough details)
		return null;
	}

	/**
	 * Insert a new item with a GUID.
	 *
	 * @param   mixed  $value  The value to insert.
	 * @param   array   $link   The field link details.
	 *
	 * @return  string|null  The new GUID or null if insertion failed.
	 * @since   4.0.3
	 */
	private function insertItemWithGuid($value, array $link): ?string
	{
		$guid = GuidHelper::get();
		$item = (object) [$link['value'] => $value, $link['key'] => $guid];

		if ($this->item->table($link['table'])->set($item, $link['key'], 'insert'))
		{
			return $guid;
		}

		return null;
	}

	/**
	 * Insert a new item with a non-numeric ID.
	 *
	 * @param   mixed  $value  The value to insert.
	 * @param   array   $link   The field link details.
	 *
	 * @return  mixed|null  The new ID or null if insertion failed.
	 * @since   4.0.3
	 */
	private function insertItemWithId($value, array $link)
	{
		$item = (object) [$link['key'] => 0, $link['value'] => $value];

		if ($this->item->table($link['table'])->set($item, $link['key'], 'insert'))
		{
			return $this->item->table($link['table'])->value($value, $link['value'], $link['key']);
		}

		return null;
	}
}

