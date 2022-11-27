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
class Insert extends Database implements InsertInterface
{
	/**
	 * Switch to set the defaults
	 *
	 * @var    bool
	 * @since  1.2.0
	 **/
	public bool $defaults = true;

	/**
	 * Set rows to the database
	 *
	 * @param   array    $data      Dataset to store in database [array of arrays (key => value)]
	 * @param   string   $table     The table where the data is being added
	 *
	 * @return  bool
	 * @since   3.2.0
	 **/
	public function rows(array $data, string $table): bool
	{
		// get a query object
		$query = $this->db->getQuery(true);

		// get the first row
		$row = array_values($data)[0];

		// set the insert columns
		if (!ArrayHelper::check($row))
		{
			return false;
		}

		$columns = array_keys($row);

		// set joomla default columns
		$add_created = false;
		$add_version = false;
		$add_published = false;

		// check if we should load the defaults
		if ($this->defaults)
		{
			// get the date
			$date = (new Date())->toSql();

			if (!in_array('created', $columns))
			{
				$columns[] = 'created';
				$add_created = true;
			}
			if (!in_array('version', $columns))
			{
				$columns[] = 'version';
				$add_version = true;
			}
			if (!in_array('published', $columns))
			{
				$columns[] = 'published';
				$add_published = true;
			}
		}

		// set the query targets
		$query->insert($this->db->quoteName($table))->columns($this->db->quoteName($columns));

		// limiting factor on the amount of rows to insert before we reset the query
		$limit = 300;

		// set the insert values
		foreach ($data as $set)
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
				$query->insert($this->db->quoteName($table))->columns($this->db->quoteName($columns));
			}

			$row = [];
			foreach ($set as $value)
			{
				$row[] = $this->quote($value);
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
		}

		// execute the final query
		$this->db->setQuery($query);
		$this->db->execute();

		// always reset the default switch
		$this->defaults = true;

		return true;
	}

	/**
	 * Set items to the database
	 *
	 * @param   array    $data         Data to store in database (array of objects)
	 * @param   array    $columns   Data columns
	 * @param   string   $table         The table where the data is being added
	 *
	 * @return  bool
	 * @since   3.2.0
	 **/
	public function items(array $data, array $columns, string $table): bool
	{
		// get a query object
		$query = $this->db->getQuery(true);

		// set the query targets
		$query->insert($this->db->quoteName($table))->columns($this->db->quoteName(array_keys($columns)));

		// limiting factor on the amount of rows to insert before we reset the query
		$limit = 400;

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
				$limit = 400;

				// get a query object
				$query = $this->db->getQuery(true);

				// set the query targets
				$query->insert($this->db->quoteName($table))->columns($this->db->quoteName(array_keys($columns)));
			}

			$row = [];
			// load only what is part of the columns set
			foreach ($columns as $key)
			{
				if (isset($value->{$key}))
				{
					$row[] = $this->quote($value->{$key});
				}
				else
				{
					$row[] = '';
				}
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

		return true;
	}

	/**
	 * Set row to the database
	 *
	 * @param   array    $data      Dataset to store in database (key => value)
	 * @param   string   $table     The table where the data is being added
	 *
	 * @return  bool
	 * @since   3.2.0
	 **/
	public function row(array $data, string $table): bool
	{
		// get a query object
		$query = $this->db->getQuery(true);

		$columns = array_keys($data);

		// set joomla default columns
		$add_created = false;
		$add_version = false;
		$add_published = false;

		// check if we should load the defaults
		if ($this->defaults)
		{
			// get the date
			$date = (new Date())->toSql();

			if (!in_array('created', $columns))
			{
				$columns[] = 'created';
				$add_created = true;
			}
			if (!in_array('version', $columns))
			{
				$columns[] = 'version';
				$add_version = true;
			}
			if (!in_array('published', $columns))
			{
				$columns[] = 'published';
				$add_published = true;
			}
		}

		// set the query targets
		$query->insert($this->db->quoteName($table))->columns($this->db->quoteName($columns));

		// set the insert values
		$row = [];
		foreach ($data as $value)
		{
			$row[] = $this->quote($value);
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

		// execute the final query
		$this->db->setQuery($query);
		$this->db->execute();

		// always reset the default switch
		$this->defaults = true;

		return true;
	}

}

