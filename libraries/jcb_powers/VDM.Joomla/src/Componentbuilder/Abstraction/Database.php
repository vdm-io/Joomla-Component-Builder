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
	 * @var   \JDatabaseDriver
	 * @since 3.2.0
	 */
	protected \JDatabaseDriver $db;

	/**
	 * Core Component Table Name
	 *
	 * @var   string
	 * @since 3.2.0
	 */
	protected string $table;

	/**
	 * Constructor
	 *
	 * @param \JDatabaseDriver|null   $db  The database driver
	 *
	 * @throws \Exception
	 * @since 3.2.0
	 */
	public function __construct(?\JDatabaseDriver $db = null)
	{
		$this->db = $db ?: JoomlaFactory::getDbo();

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
		if (is_numeric($value))
		{
			if (filter_var($value, FILTER_VALIDATE_INT))
			{
				return (int) $value;
			}
			elseif (filter_var($value, FILTER_VALIDATE_FLOAT))
			{
				return (float) $value;
			}
		}
		elseif (is_bool($value))
		{
			return (int) $value;
		}

		// default just escape it
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

}

