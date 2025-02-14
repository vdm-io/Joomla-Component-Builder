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

namespace VDM\Joomla\Abstraction;


use Joomla\CMS\Factory as JoomlaFactory;
use VDM\Joomla\Utilities\Component\Helper;


/**
 * Database
 * 
 * @since 3.2.0
 */
abstract class Database
{
	/**
	 * Database object to query local DB
	 *
	 * @since 3.2.0
	 */
	protected $db;

	/**
	 * Core Component Table Name
	 *
	 * @var   string
	 * @since 3.2.0
	 */
	protected string $table;

	/**
	 * Date format to return
	 *
	 * @var   string
	 * @since 5.0.2
	 */
	protected string $dateFormat = 'Y-m-d H:i:s';

	/**
	 * Constructor
	 *
	 * @throws \Exception
	 * @since 3.2.0
	 */
	public function __construct()
	{
		$this->db = JoomlaFactory::getDbo();

		// set the component table
		$this->table = '#__' . Helper::getCode();
	}

	/**
	 * Set a value based on data type
	 *
	 * @param   mixed  $value   The value to set
	 *
	 * @return  mixed
	 * @since   3.2.0
	 **/
	protected function quote($value)
	{
		if ($value === null)
		{
			return 'NULL';
		}

		if (is_numeric($value))
		{
			// If the value is a numeric string (e.g., "0123"), treat it as a string to preserve the format
			if (is_string($value) && ltrim($value, '0') !== $value)
			{
				return $this->db->quote($value);
			}

			if (filter_var($value, FILTER_VALIDATE_INT))
			{
				return (int) $value;
			}

			if (filter_var($value, FILTER_VALIDATE_FLOAT))
			{
				return (float) $value;
			}
		}

		// Handle boolean values
		if (is_bool($value))
		{
			return $value ? 'TRUE' : 'FALSE';
		}

		// For date and datetime values
		if ($value instanceof \DateTime)
		{
			return $this->db->quote($value->format($this->getDateFormat()));
		}

		// For other types of values, quote as string
		return $this->db->quote($value);
	}

	/**
	 * Set a table name, adding the
	 *     core component as needed
	 *
	 * @param   string  $table   The table string
	 *
	 * @return  string
	 * @since   3.2.0
	 **/
	protected function getTable(string $table): string
	{
		if (strpos($table, '#__') === false)
		{
			return $this->table . '_' . $table;
		}

		return $table;
	}

	/**
	 * Get the date format to return in the quote
	 *
	 * @return  string
	 * @since   5.0.2
	 **/
	protected function getDateFormat(): string
	{
		return $this->dateFormat;
	}
}

