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


use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Interfaces\LoadInterface;
use VDM\Joomla\Abstraction\Database;


/**
 * Database Load
 * 
 * @since 3.2.0
 */
final class Load extends Database implements LoadInterface
{
	/**
	 * Load data rows as an array of associated arrays
	 *
	 * @param   array        $select   Array of selection keys
	 * @param   array        $tables   Array of tables to search
	 * @param   array|null   $where    Array of where key=>value match exist
	 * @param   array|null   $order    Array of how to order the data
	 * @param   int|null     $limit    Limit the number of values returned
	 *
	 * @return  array|null
	 * @since   3.2.0
	 **/
	public function rows(array $select, array $tables, ?array $where = null,
		?array $order = null, ?int $limit = null): ?array
	{
		// set key if found
		$key = '';
		if (isset($select['key']))
		{
			if (is_string($select['key']))
			{
				$key = $select['key'];
			}
			unset($select['key']);
		}

		// check if we can get many rows
		if ($this->many($select, $tables, $where, $order, $limit))
		{
			// return associated arrays from the table records
			return $this->db->loadAssocList($key);
		}

		// data does not exist
		return null;
	}

	/**
	 * Load data rows as an array of objects
	 *
	 * @param   array        $select   Array of selection keys
	 * @param   array        $tables   Array of tables to search
	 * @param   array|null   $where    Array of where key=>value match exist
	 * @param   array|null   $order    Array of how to order the data
	 * @param   int|null     $limit    Limit the number of values returned
	 *
	 * @return  array|null
	 * @since   3.2.0
	 **/
	public function items(array $select, array $tables, ?array $where = null,
		?array $order = null, ?int $limit = null): ?array
	{
		// set key if found
		$key = '';
		if (isset($select['key']))
		{
			if (is_string($select['key']))
			{
				$key = $select['key'];
			}
			unset($select['key']);
		}

		// check if we can get many rows
		if ($this->many($select, $tables, $where, $order, $limit))
		{
			// return associated arrays from the table records
			return $this->db->loadObjectList($key);
		}

		// data does not exist
		return null;
	}

	/**
	 * Load data row as an associated array
	 *
	 * @param   array        $select   Array of selection keys
	 * @param   array       $tables  Array of tables to search
	 * @param   array|null  $where   Array of where key=>value match exist
	 * @param   array|null  $order    Array of how to order the data
	 *
	 * @return  array|null
	 * @since   3.2.0
	 **/
	public function row(array $select, array $tables, ?array $where = null, ?array $order = null): ?array
	{
		// check if we can get one row
		if ($this->one($select, $tables, $where, $order))
		{
			return $this->db->loadAssoc();
		}

		// data does not exist
		return null;
	}

	/**
	 * Load data row as an object
	 *
	 * @param   array        $select   Array of selection keys
	 * @param   array       $tables  Array of tables to search
	 * @param   array|null  $where   Array of where key=>value match exist
	 * @param   array|null  $order    Array of how to order the data
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function item(array $select, array $tables, ?array $where = null, ?array $order = null): ?object
	{
		// check if we can get one row
		if ($this->one($select, $tables, $where, $order))
		{
			return $this->db->loadObject();
		}

		// data does not exist
		return null;
	}

	/**
	 * Get the max value based on a filtered result from a given table
	 *
	 * @param   string     $field     The field key
	 * @param   string     $tables    The tables
	 * @param   array      $filter    The filter keys
	 *
	 * @return  int|null
	 * @since   3.2.0
	 **/
	public function max($field, array $tables, array $filter): ?int
	{
		// only do check if we have the table set
		if (isset($tables['a']))
		{
			// get the query
			$query = $this->query(["all" => "MAX(`$field`)"], $tables, $filter);

			// Load the max number
			$this->db->setQuery($query);
			$this->db->execute();

			// check if we have values
			if ($this->db->getNumRows())
			{
				return (int) $this->db->loadResult();
			}
		}

		// data does not exist
		return null;
	}

	/**
	 * Count the number of items based on filter result from a given table
	 *
	 * @param   string     $tables    The table
	 * @param   array      $filter    The filter keys
	 *
	 * @return  int|null
	 * @since   3.2.0
	 **/
	public function count(array $tables, array $filter): ?int
	{
		// only do check if we have the table set
		if (isset($tables['a']))
		{
			// get the query
			$query = $this->query(["all" => 'COUNT(*)'], $tables, $filter);

			// Load the max number
			$this->db->setQuery($query);
			$this->db->execute();

			// check if we have values
			if ($this->db->getNumRows())
			{
				return (int) $this->db->loadResult();
			}
		}

		// data does not exist
		return null;
	}

	/**
	 * Load one value from a row
	 *
	 * @param   array        $select   Array of selection keys
	 * @param   array       $tables  Array of tables to search
	 * @param   array|null  $where   Array of where key=>value match exist
	 * @param   array|null  $order    Array of how to order the data
	 *
	 * @return  mixed
	 * @since   3.2.0
	 **/
	public function value(array $select, array $tables, ?array $where = null, ?array $order = null)
	{
		// check if we can get one value
		if ($this->one($select, $tables, $where, $order))
		{
			return $this->db->loadResult();
		}

		// data does not exist
		return null;
	}

	/**
	 * Load many
	 *
	 * @param   array        $select   Array of selection keys
	 * @param   array        $tables   Array of tables to search
	 * @param   array|null   $where    Array of where key=>value match exist
	 * @param   array|null   $order    Array of how to order the data
	 * @param   int|null     $limit    Limit the number of values returned
	 *
	 * @return  bool
	 * @since   3.2.0
	 **/
	protected function many(array $select, array $tables, ?array $where = null,
		?array $order = null, ?int $limit = null): bool
	{
		// only do check if we have the table set
		if (isset($tables['a']))
		{
			// get the query
			$query = $this->query($select, $tables, $where, $order, $limit);

			// Load the items
			$this->db->setQuery($query);
			$this->db->execute();

			// check if we have values
			if ($this->db->getNumRows())
			{
				return true;
			}
		}

		// data does not exist
		return false;
	}

	/**
	 * Load one
	 *
	 * @param   array       $select  Array of selection keys
	 * @param   array       $tables  Array of tables to search
	 * @param   array|null  $where   Array of where key=>value match exist
	 * @param   array|null  $order   Array of how to order the data
	 *
	 * @return  bool
	 * @since   3.2.0
	 **/
	protected function one(array $select, array $tables, ?array $where = null, ?array $order = null): bool
	{
		// only do check if we have the table set
		if (isset($tables['a']))
		{
			// get the query
			$query = $this->query($select, $tables, $where, $order);

			// Load the item
			$this->db->setQuery($query, 0, 1);
			$this->db->execute();

			// check if we have values
			if ($this->db->getNumRows())
			{
				return true;
			}
		}

		// data does not exist
		return false;
	}

	/**
	 * Get the query object
	 *
	 * @param   array        $select   Array of selection keys
	 * @param   array        $tables   Array of tables to search
	 * @param   array|null   $where    Array of where key=>value match exist
	 * @param   array|null   $order    Array of how to order the data
	 * @param   int|null     $limit    Limit the number of values returned
	 *
	 * @return  object|null   The query object  (DatabaseQuery)
	 * @since   3.2.0
	 **/
	protected function query(array $select, array $tables, ?array $where = null,
		?array $order = null, ?int $limit = null): ?object
	{
		$query = $this->db->getQuery(true);

		// check if we have an all selection set
		if (isset($select['all']))
		{
			// all selection example array: ['all' => ['a.*', 'b.*']]
			if (ArrayHelper::check($select['all']))
			{
				foreach ($select['all'] as $select_all)
				{
					// set target selection
					$query->select(
						$select_all
					);
				}
			}
			// all selection example string: ['all' =>'a.*']
			elseif (is_string($select['all']))
			{
				// set target selection
				$query->select(
					$select['all']
				);
			}
			unset($select['all']);
		}

		// load the table where join
		if (ArrayHelper::check($select))
		{
			// set target selection
			$query->select(
				$this->db->quoteName(
					array_keys($select),
					array_values($select)
				)
			);
		}

		// set main table
		$query->from($this->db->quoteName($this->getTable($tables['a']), 'a'));

		// remove main table
		unset($tables['a']);

		// load the table where join
		if (ArrayHelper::check($tables))
		{
			foreach ($tables as $as => $table)
			{
				$query->join(
					'LEFT', $this->db->quoteName(
						$this->getTable($table['name']), $as
					) . ' ON (' . $this->db->quoteName($table['join_on'])
					. ' = ' . $this->db->quoteName($table['as_on']) . ')'
				);
			}
		}

		// load the table where getters
		if (ArrayHelper::check($where))
		{
			foreach ($where as $key => $value)
			{
				if (ArrayHelper::check($value))
				{
					if (isset($value['value']) && isset($value['operator']))
					{
						// check if value needs to be quoted
						$quote = $value['quote'] ?? true;
						if (!$quote)
						{
							if (ArrayHelper::check($value['value']))
							{
								// add the where by array
								$query->where($this->db->quoteName($key) . ' ' .
									$value['operator'] . ' (' .
										implode(',', $value['value'])
									. ')'
								);
							}
							else
							{
								// add the where
								$query->where($this->db->quoteName($key) . ' ' .
									$value['operator'] . ' ' . $value['value']);
							}
						}
						else
						{
							if (ArrayHelper::check($value['value']))
							{
								// add the where by array
								$query->where($this->db->quoteName($key) . ' ' .
									$value['operator'] . ' (' .
										implode(',',
											array_map(
												fn($val) => $this->quote($val),
												$value['value']
											)
										)
									. ')'
								);
							}
							else
							{
								// add the where
								$query->where($this->db->quoteName($key) . ' ' .
									$value['operator'] . ' ' . $this->quote($value['value']));
							}
						}
					}
					else
					{
						// we should through an exception
						// for security we just return nothing for now
						return null;
					}
				}
				else
				{
					// add the where
					$query->where($this->db->quoteName($key) .
						' = ' . $this->quote($value));
				}
			}
		}

		// load the row ordering
		if (ArrayHelper::check($order))
		{
			foreach ($order as $key => $direction)
			{
				// add the ordering
				$query->order($this->db->quoteName($key) .
					' ' . $direction);
			}
		}

		// only return a limited number
		if (is_numeric($limit))
		{
			$query->setLimit($limit);
		}

		return $query;
	}

}

