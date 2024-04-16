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

namespace VDM\Joomla\Componentbuilder\Power\Database;


use VDM\Joomla\Interfaces\ModelInterface as Model;
use VDM\Joomla\Database\Update as Database;
use VDM\Joomla\Componentbuilder\Interfaces\Database\UpdateInterface;


/**
 * Power Database Update
 * 
 * @since 3.2.0
 */
class Update implements UpdateInterface
{
	/**
	 * Model
	 *
	 * @var    Model
	 * @since 3.2.0
	 */
	protected Model $model;

	/**
	 * Database
	 *
	 * @var    Database
	 * @since 3.2.0
	 */
	protected Database $database;

	/**
	 * Table Name
	 *
	 * @var    string
	 * @since 3.2.1
	 */
	protected string $table = 'power';

	/**
	 * Constructor
	 *
	 * @param Model       $model       The set model object.
	 * @param Database    $database    The update database object.
	 *
	 * @since 3.2.0
	 */
	public function __construct(Model $model, Database $database)
	{
		$this->model = $model;
		$this->database = $database;
	}

	/**
	 * Update a value to a given table
	 *          Example: $this->value(Value, 'value_key', 'GUID');
	 *
	 * @param   mixed     $value      The field value
	 * @param   string    $field      The field key
	 * @param   string    $keyValue   The key value
	 * @param   string    $key        The key name
	 *
	 * @return  bool
	 * @since 3.2.0
	 */
	public function value($value, string $field, string $keyValue, string $key = 'guid'): bool
	{
		// build the array
		$item = [];
		$item[$key] = $keyValue;
		$item[$field] = $value;

		// Update the column of this table using guid as the primary key.
		return $this->row($item);
	}

	/**
	 * Update single row with multiple values to a given table
	 *          Example: $this->item(Array);
	 *
	 * @param   array    $item   The item to save
	 *
	 * @return  bool
	 * @since 3.2.0
	 */
	public function row(array $item): bool
	{
		// check if object could be modelled
		if (($item = $this->model->row($item, $this->table)) !== null)
		{
			// Update the column of this table using guid as the primary key.
			return $this->database->row($item, 'guid', $this->table);
		}
		return false;
	}

	/**
	 * Update multiple rows to a given table
	 *          Example: $this->items(Array);
	 *
	 * @param   array|null   $items  The items updated in database (array of arrays)
	 *
	 * @return  bool
	 * @since 3.2.0
	 */
	public function rows(?array $items): bool
	{
		// check if object could be modelled
		if (($items = $this->model->rows($items, $this->table)) !== null)
		{
			// Update the column of this table using guid as the primary key.
			return $this->database->rows($items, 'guid', $this->table);
		}
		return false;
	}

	/**
	 * Update single item with multiple values to a given table
	 *          Example: $this->item(Object);
	 *
	 * @param   object    $item   The item to save
	 *
	 * @return  bool
	 * @since 3.2.0
	 */
	public function item(object $item): bool
	{
		// check if object could be modelled
		if (($item = $this->model->item($item, $this->table)) !== null)
		{
			// Update the column of this table using guid as the primary key.
			return $this->database->item($item, 'guid', $this->table);
		}
		return false;
	}

	/**
	 * Update multiple items to a given table
	 *          Example: $this->items(Array);
	 *
	 * @param   array|null   $items  The items updated in database (array of objects)
	 *
	 * @return  bool
	 * @since 3.2.0
	 */
	public function items(?array $items): bool
	{
		// check if object could be modelled
		if (($items = $this->model->items($items, $this->table)) !== null)
		{
			// Update the column of this table using guid as the primary key.
			return $this->database->items($items, 'guid', $this->table);
		}
		return false;
	}
}

