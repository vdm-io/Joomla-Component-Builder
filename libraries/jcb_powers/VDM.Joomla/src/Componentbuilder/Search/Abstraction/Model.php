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

namespace VDM\Joomla\Componentbuilder\Search\Abstraction;


use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Componentbuilder\Search\Factory;
use VDM\Joomla\Componentbuilder\Search\Config;
use VDM\Joomla\Componentbuilder\Table;


/**
 * Search Model
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
	 * Search Config
	 *
	 * @var    Config
	 * @since 3.2.0
	 */
	protected Config $config;

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
	 * @param Config|null       $config           The search config object.
	 * @param Table|null         $table            The search table object.
	 *
	 * @since 3.2.0
	 */
	public function __construct(?Config $config = null, ?Table $table = null)
	{
		$this->config = $config ?: Factory::_('Config');
		$this->table = $table ?: Factory::_('Table');
	}

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
			$table = $this->config->table_name;
		}

		// field counter
		$field_number = 0;

		// check if this is a valid table
		if (($fields = $this->table->fields($table)) !== null)
		{
			foreach ($fields as $field)
			{
				// model a value if it exists
				if(isset($item->{$field}))
				{
					$item->{$field} = $this->value($item->{$field}, $field, $table);

					// remove empty values
					if (!StringHelper::check($item->{$field}) && !ArrayHelper::check($item->{$field}, true))
					{
						unset($item->{$field});
					}
					else
					{
						$field_number++;
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
				$table = $this->config->table_name;
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
			$table = $this->config->table_name;
		}

		// check if this is a valid table
		if ($table && isset($this->last[$table]))
		{
			return $this->last[$table];
		}

		return null;
	}

}

