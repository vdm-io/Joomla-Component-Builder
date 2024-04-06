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

namespace VDM\Joomla\Database;


use VDM\Joomla\Interfaces\UpdateInterface;
use VDM\Joomla\Abstraction\Database;


/**
 * Database Update Class
 * 
 * @since 3.2.0
 */
final class Update extends Database implements UpdateInterface
{
	/**
	 * Update rows in the database (with remapping and filtering columns option)
	 *
	 * @param   array    $data      Dataset to update in database [array of arrays (key => value)]
	 * @param   string   $key       Dataset key column to use in updating the values in the Database
	 * @param   string   $table     The table where the data is being updated
	 * @param   array    $columns   Data columns for remapping and filtering
	 *
	 * @return  bool
	 * @since   3.2.0
	 **/
	public function rows(array $data, string $key, string $table, array $columns = []): bool
	{
		// set the update columns
		if ($data === [] || strlen($key) == 0)
		{
			return false;
		}

		// set the update values
		foreach ($data as $values)
		{
			if ($columns !== [])
			{
				// load only what is part of the columns set
				$row = [];
				foreach ($columns as $column => $key_)
				{
					if (isset($values[$key_]))
					{
						$row[$column] = $values[$key_];
					}
				}

				// update the row
				$this->row($row, $key, $table);
			}
			else
			{
				// update the row
				$this->row((array) $values, $key, $table);
			}
		}

		return true;
	}

	/**
	 * Update items in the database (with remapping and filtering columns option)
	 *
	 * @param   array    $data      Data to updated in database (array of objects)
	 * @param   string   $key       Dataset key column to use in updating the values in the Database
	 * @param   string   $table     The table where the data is being update
	 * @param   array    $columns   Data columns for remapping and filtering
	 *
	 * @return  bool
	 * @since   3.2.0
	 **/
	public function items(array $data, string $key, string $table, array $columns = []): bool
	{
		// set the update columns
		if ($data === [] || strlen($key) == 0)
		{
			return false;
		}

		// set the update values
		foreach ($data as $nr => $values)
		{
			if ($columns !== [])
			{
				// load only what is part of the columns set
				$row = [];
				foreach ($columns as $column => $key_)
				{
					if (isset($values->{$key_}))
					{
						$row[$column] = $values->{$key_};
					}
				}

				// update the row
				$this->row($row, $key, $table);
			}
			else
			{
				// update the row
				$this->row((array) $values, $key, $table);
			}
		}

		return true;
	}

	/**
	 * Update row in the database
	 *
	 * @param   array    $data      Dataset to update in database (key => value)
	 * @param   string   $key       Dataset key column to use in updating the values in the Database
	 * @param   string   $table     The table where the data is being updated
	 *
	 * @return  bool
	 * @since   3.2.0
	 **/
	public function row(array $data, string $key, string $table): bool
	{
		// set the update columns
		if ($data === [] || strlen($key) == 0)
		{
			return false;
		}

		// get a query object
		$query = $this->db->getQuery(true);

		// set the query targets
		$query->update($this->db->quoteName($this->getTable($table)));

		// set the update values
		$key_ = null;
		foreach ($data as $column => $value)
		{
			if ($column === $key)
			{
				$key_ = $value;
			}
			else
			{
				$query->set($this->db->quoteName($column) . ' = ' . $this->quote($value));
			}
		}

		// add the key condition
		if ($key_ !== null)
		{
			$query->where($this->db->quoteName($key) . ' = ' . $this->quote($key_));

			// execute the final query
			$this->db->setQuery($query);

			return $this->db->execute();
		}

		return false;
	}

	/**
	 * Update item in the database
	 *
	 * @param   object   $data      Dataset to update in database (key => value)
	 * @param   string   $key       Dataset key column to use in updating the values in the Database
	 * @param   string   $table     The table where the data is being updated
	 *
	 * @return  bool
	 * @since   3.2.0
	 **/
	public function item(object $data, string $key, string $table): bool
	{
		// convert to an array
		return $this->row((array) get_object_vars($data), $key, $table);
	}
}

