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

namespace VDM\Joomla\Componentbuilder\Abstraction;


use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Componentbuilder\Table;


/**
 * Our base Model
 * 
 * @since 3.2.0
 */
abstract class Model
{
	/**
	 * Last ID
	 *
	 * @var    array
	 * @since 3.2.0
	 */
	protected array $last;

	/**
	 * Search Table
	 *
	 * @var    Table
	 * @since 3.2.0
	 */
	protected Table $table;

	/**
	 * Constructor
	 *
	 * @param Table         $table            The search table object.
	 *
	 * @since 3.2.0
	 */
	public function __construct(Table $table)
	{
		$this->table = $table;
	}

	/**
	 * Model the value
	 *          Example: $this->value(value, 'value_key', 'table_name');
	 *
	 * @param   mixed          $value    The value to model
	 * @param   string         $field    The field key
	 * @param   string|null    $table    The table
	 *
	 * @return  mixed
	 * @since 3.2.0
	 */
	abstract public function value($value, string $field, ?string $table = null);

	/**
	 * Model the values of an item
	 *          Example: $this->item('table_name', Object);
	 *
	 * @param   object         $item      The item object
	 * @param   string|null    $table     The table
	 *
	 * @return  object|null
	 * @since 3.2.0
	 */
	public function item(object $item, ?string $table = null): ?object
	{
		// set the table name
		if (empty($table))
		{
			$table = $this->getTable();
		}

		// field counter
		$field_number = 0;

		// check if this is a valid table
		if (($fields = $this->getTableFields($table)) !== null)
		{
			foreach ($fields as $field)
			{
				// model a value if it exists
				if(isset($item->{$field}))
				{
					$item->{$field} = $this->value($item->{$field}, $field, $table);

					if ($this->validate($item->{$field}))
					{
						$field_number++;
					}
					else
					{
						unset($item->{$field});
					}
				}
			}
		}

		// all items must have more than one field or its empty (1 = id)
		if ($field_number > 1)
		{
			return $item;
		}

		return null;
	}

	/**
	 * Model the values of multiple items
	 *          Example: $this->items(Array, 'table_name');
	 *
	 * @param   array|null    $items    The array of item objects
	 * @param   string|null    $table     The table
	 *
	 * @return  array|null
	 * @since 3.2.0
	 */
	public function items(?array $items = null, ?string $table = null): ?array
	{
		// check if this is a valid table
		if (ArrayHelper::check($items))
		{
			// set the table name
			if (empty($table))
			{
				$table = $this->getTable();
			}

			foreach ($items as $id => &$item)
			{
				// model the item
				if (($item = $this->item($item, $table)) !== null)
				{
					// add the last ID
					$this->last[$table] = $item->id;
				}
				else
				{
					unset($items[$id]);
				}
			}

			if (ArrayHelper::check($items))
			{
				return $items;
			}
		}

		return null;
	}

	/**
	 * Get last modeled ID
	 *          Example: $this->last('table_name');
	 *
	 * @param   string|null     $table     The table
	 *
	 * @return  int|null
	 * @since 3.2.0
	 */
	public function last(?string $table = null): ?int
	{
		// set the table name
		if (empty($table))
		{
			$table = $this->getTable();
		}

		// check if this is a valid table
		if ($table && isset($this->last[$table]))
		{
			return $this->last[$table];
		}

		return null;
	}

	/**
	 * Validate the values (basic, override in child class)
	 *
	 * @param   mixed         $value   The field value
	 * @param   string|null   $field     The field key
	 * @param   string|null   $table   The table
	 *
	 * @return  bool
	 * @since 3.2.0
	 */
	protected function validate(&$value, ?string $field = null, ?string $table = null): bool
	{
		// check values
		if (StringHelper::check($value) || ArrayHelper::check($value, true))
		{
			return true;
		}
		// remove empty values
		return false;
	}

	/**
	 * Get the current active table's fields
	 *
	 * @param   string     $table     The table
	 *
	 * @return  array
	 * @since 3.2.0
	 */
	protected function getTableFields(string $table): ?array
	{
		return $this->table->fields($table);
	}

	/**
	 * Get the current active table
	 *
	 * @return  string
	 * @since 3.2.0
	 */
	abstract protected function getTable(): string;

}

