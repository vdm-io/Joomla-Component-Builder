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

namespace VDM\Joomla\Componentbuilder\Package\Database;


use VDM\Joomla\Componentbuilder\Package\Factory;
use VDM\Joomla\Componentbuilder\Table;
use VDM\Joomla\Database\Load as Database;


/**
 * Package Database Load
 * 
 * @since 3.2.0
 */
class Load
{
	/**
	 * Search Table
	 *
	 * @var    Table
	 * @since 3.2.0
	 */
	protected Table $table;

	/**
	 * Database Load
	 *
	 * @var    Database
	 * @since 3.2.0
	 */
	protected Database $load;

	/**
	 * Constructor
	 *
	 * @param Table|null        $table      The core table object.
	 * @param Database|null     $load       The database object.
	 *
	 * @since 3.2.0
	 */
	public function __construct(?Table $table = null, ?Database $load = null)
	{
		$this->table = $table ?: Factory::_('Table');
		$this->load = $load ?: Factory::_('Load');
	}

	/**
	 * Get a value from a given table
	 *          Example: $this->value(23, 'value_key', 'table_name');
	 *
	 * @param   int         $id        The item ID
	 * @param   string      $field     The field key
	 * @param   string      $table     The table
	 *
	 * @return  mixed
	 * @since 3.2.0
	 */
	public function value(int $id, string $field, string $table)
	{
		// check if this is a valid table
		if ($id > 0 && $this->table->exist($table, $field))
		{
			return $this->load->value(
				["a.${field}" => $field], ['a' => $table], ['a.id' => $id]
			);
		}

		return null;
	}

	/**
	 * Get values from a given table
	 *          Example: $this->item(23, 'table_name');
	 *
	 * @param   int      $id        The item ID
	 * @param   string   $table     The table
	 *
	 * @return  object|null
	 * @since 3.2.0
	 */
	public function item(int $id, ?string $table): ?object
	{
		// check if this is a valid table
		if ($id > 0 && $this->table->exist($table))
		{
			return $this->load->item(
				['all' => 'a.*'], ['a' => $table], ['a.id' => $id]
			);
		}

		return null;
	}

	/**
	 * Get values from a given table
	 *          Example: $this->items($ids, 'table_name');
	 *
	 * @param   array    $ids     The item ids
	 * @param   string   $table   The table
	 *
	 * @return  array|null
	 * @since 3.2.0
	 */
	public function items(array $ids, string $table): ?array
	{
		// check if this is a valid table
		if ($this->table->exist($table))
		{
			return $this->load->items(
					['all' => 'a.*'], ['a' => $table], ['a.id' => $ids]
				);
		}

		return null;
	}
}

