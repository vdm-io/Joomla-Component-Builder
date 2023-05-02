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

namespace VDM\Joomla\Componentbuilder\Database;


use Joomla\CMS\Date\Date;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Componentbuilder\Interfaces\InsertInterface;
use VDM\Joomla\Componentbuilder\Abstraction\Database;


/**
 * Database Insert Class
 * 
 * @since 3.2.0
 */
final class Insert extends Database implements InsertInterface
{
	/**
	 * Switch to set the defaults
	 *
	 * @var    bool
	 * @since  1.2.0
	 **/
	protected bool $defaults = true;

	/**
	 * Switch to prevent/allow defaults from being added.
	 *
	 * @param   bool    $trigger      toggle the defaults
	 *
	 * @return  void
	 * @since   3.2.0
	 **/
	public function defaults(bool $trigger = true)
	{
		$this->defaults = $trigger;
	}

	/**
	 * Insert rows to the database (with remapping and filtering columns option)
	 *
	 * @param   array    $data      Dataset to store in database [array of arrays (key => value)]
	 * @param   string   $table     The table where the data is being added
	 * @param   array    $columns   Data columns for remapping and filtering
	 *
	 * @return  bool
	 * @since   3.2.0
	 **/
	public function rows(array $data, string $table, array $columns = []): bool
	{
		if (!ArrayHelper::check($data))
		{
			return false;
		}

		if ($columns === [])
		{
			$columns = $this->getArrayColumns($data);
		}

		return ($columns === []) ? false : $this->insert($data, $table, $columns, true);
	}

	/**
	 * Insert items to the database (with remapping and filtering columns option)
	 *
	 * @param   array    $data         Data to store in database (array of objects)
	 * @param   string   $table        The table where the data is being added
	 * @param   array    $columns      Data columns for remapping and filtering
	 *
	 * @return  bool
	 * @since   3.2.0
	 **/
	public function items(array $data, string $table, array $columns = []): bool
	{
		if (!ArrayHelper::check($data))
		{
			return false;
		}

		if ($columns === [])
		{
			$columns = $this->getObjectsColumns($data);
		}

		return ($columns === []) ? false : $this->insert($data, $table, $columns, false);
	}

	/**
	 * Insert row to the database
	 *
	 * @param   array    $data      Dataset to store in database (key => value)
	 * @param   string   $table     The table where the data is being added
	 *
	 * @return  bool
	 * @since   3.2.0
	 **/
	public function row(array $data, string $table): bool
	{
		return $this->rows([$data], $table);
	}

	/**
	 * Insert item to the database
	 *
	 * @param   object    $data     Dataset to store in database (key => value)
	 * @param   string   $table     The table where the data is being added
	 *
	 * @return  bool
	 * @since   3.2.0
	 **/
	public function item(object $data, string $table): bool
	{
		return $this->items([$data], $table);
	}

	/**
	 * Get columns from data array
	 *
	 * @param   array   $data   Data array
	 *
	 * @return  array
	 * @since   3.2.0
	 **/
	protected function getArrayColumns(array &$data): array
	{
		$row = array_values($data)[0];

		if (!ArrayHelper::check($row))
		{
			return [];
		}

		$columns = array_keys($row);

		return array_combine($columns, $columns);
	}

	/**
	 * Get columns from data objects
	 *
	 * @param   array   $data   Data objects
	 *
	 * @return  array
	 * @since   3.2.0
	 **/
	protected function getObjectsColumns(array &$data): array
	{
		$row = array_values($data)[0];

		if (!is_object($row))
		{
			return [];
		}

		$columns = get_object_vars($row);

		return array_combine(array_keys($columns), array_keys($columns));
	}

	/**
	 * Insert data into the database
	 *
	 * @param   array   $data      Data to store in database
	 * @param   string  $table     The table where the data is being added
	 * @param   array   $columns   Data columns for remapping and filtering
	 * @param   bool    $isArray   Whether the data is an array of arrays or an array of objects
	 *
	 * @return  bool
	 * @since   3.2.0
	 **/
	protected function insert(array &$data, string $table, array $columns, bool $isArray): bool
	{
		// set joomla default columns
		$add_created = false;
		$add_version = false;
		$add_published = false;

		// check if we should load the defaults
		if ($this->defaults)
		{
			// get the date
			$date = (new Date())->toSql();

			if (!isset($columns['created']))
			{
				$columns['created'] = ' (o_O) ';
				$add_created = true;
			}

			if (!isset($columns['version']))
			{
				$columns['version'] = ' (o_O) ';
				$add_version = true;
			}

			if (!isset($columns['version']))
			{
				$columns['published'] = ' (o_O) ';
				$add_published = true;
			}
			// the (o_O) prevents an empty value from being loaded
		}

		// get a query object
		$query = $this->db->getQuery(true);

		// set the query targets
		$query->insert($this->db->quoteName($this->getTable($table)))->columns($this->db->quoteName(array_keys($columns)));

		// limiting factor on the amount of rows to insert before we reset the query
		$limit = 300;

		// set the insert values
		foreach ($data as $nr => $value)
		{
			// check the limit
			if ($limit <= 1)
			{
				// execute and reset the query
				$this->db->setQuery($query);
				$this->db->execute();

				// reset limit
				$limit = 300;

				// get a query object
				$query = $this->db->getQuery(true);

				// set the query targets
				$query->insert($this->db->quoteName($this->getTable($table)))->columns($this->db->quoteName(array_keys($columns)));
			}

			$row = [];
			foreach ($columns as $column => $key)
			{
				if (' (o_O) ' !== $key)
				{
					$row[] = ($isArray && isset($value[$key])) ? $this->quote($value[$key])
						: ((!$isArray && isset($value->{$key})) ? $this->quote($value->{$key}) : '');
				}
			}

			// set joomla default columns
			if ($add_created)
			{
				$row[] = $this->db->quote($date);
			}

			if ($add_version)
			{
				$row[] = 1;
			}

			if ($add_published)
			{
				$row[] = 1;
			}

			// add to query
			$query->values(implode(',', $row));

			// decrement the limiter
			$limit--;

			// clear the data from memory
			unset($data[$nr]);
		}

		// execute the final query
		$this->db->setQuery($query);
		$this->db->execute();

		// always reset the default switch
		$this->defaults();

		return true;
	}
}

