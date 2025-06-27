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


use Joomla\CMS\Date\Date;
use VDM\Joomla\Database\DefaultTrait;
use VDM\Joomla\Interfaces\Database\UpdateInterface;
use VDM\Joomla\Abstraction\Versioning;


/**
 * Database Update Class
 * 
 * @since 3.2.0
 */
final class Update extends Versioning implements UpdateInterface
{
	/**
	 * Default Switch
	 *
	 * @since 5.1.1
	 */
	use DefaultTrait;

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

		// set joomla default columns
		$add_modified = false;
		$add_modified_by = false;

		// check if we should load the defaults
		if ($this->defaults)
		{
			if (!isset($data['modified']))
			{
				$add_modified = true;
			}

			if (!isset($data['modified_by']))
			{
				$add_modified_by = true;
			}
		}

		// set history vars
		$this->entity = $this->getTableEntityName($table);
		$table = $this->getTable($table);

		// get a query object
		$query = $this->db->getQuery(true);

		// set the query targets
		$query->update($this->db->quoteName($table));

		// set the update values
		$key_ = null;
		$guid = null;
		$id = null;
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

			if (!empty($this->entity) && $this->history && !empty($value))
			{
				if ($column === 'guid')
				{
					$guid = $value;
				}
				elseif ($column === 'id')
				{
					$id = (int) $value;
				}
			}
		}

		// add the key condition
		if ($key_ !== null)
		{
			if ($add_modified)
			{
				$query->set($this->db->quoteName('modified') . ' = ' . $this->quote((new Date())->toSql()));
			}

			if ($add_modified_by)
			{
				$query->set($this->db->quoteName('modified_by') . ' = ' . $this->userId);
			}

			$query->where($this->db->quoteName($key) . ' = ' . $this->quote($key_));

			// execute the final query
			$this->db->setQuery($query);

			$result = $this->db->execute();

			// tract history
			if ($result && $this->history && !empty($this->entity) && (!empty($id) || !empty($guid)))
			{
				$this->trackHistory($id, $guid, $table);
			}

			// always reset the switch's
			$this->defaults()->history();

			return $result;
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

	/**
	 * Update a single column value for all rows in the table
	 *
	 * @param   mixed   $value   The value to assign to the column
	 * @param   string  $key     Dataset key column to use in updating the values in the Database
	 * @param   string  $table   The table where the update should be applied
	 *
	 * @return  bool  True on success, false on failure
	 * @since   5.1.1
	 */
	public function column(mixed $value, string $key, string $table): bool
	{
		// Ensure valid input
		if ($key === '' || $table === '')
		{
			return false;
		}

		// Get a query object
		$query = $this->db->getQuery(true);

		// Prepare the update statement
		$query->update($this->db->quoteName($this->getTable($table)))
		      ->set($this->db->quoteName($key) . ' = ' . $this->quote($value));

		// Apply the query
		$this->db->setQuery($query);

		return $this->db->execute();
	}

	/**
	 * Attempt to set history records for the specified entity.
	 *
	 * Any exceptions during this process are silently caught and ignored.
	 *
	 * @param  int     $id      The entity id.
	 * @param  string  $guid    The entity GUID.
	 * @param  string  $table   The full table name.
	 *
	 * @return void
	 * @since  5.1.1
	 */
	protected function trackHistory(?int $id, ?string $guid, $table): void
	{
		if ($id !== null)
		{
			try
			{
				$this->setHistory($id);
			}
			catch (\Throwable $e)
			{
				// Silently ignore all errors
			}
			return;
		}

		if ($guid === null)
		{
			// should never happen
			return;
		}

		try
		{
			$query = $this->db->getQuery(true)
				->select($this->db->quoteName('id'))
				->from($this->db->quoteName($table))
				->where($this->db->quoteName('guid') . ' = ' . $this->quote($guid));

			$this->db->setQuery($query);
			$this->db->execute();

			if ($this->db->getNumRows())
			{
				$this->setHistory(
					$this->db->loadResult()
				);
			}
		}
		catch (\Throwable $e)
		{
			// Silently ignore all errors
		}
	}
}

