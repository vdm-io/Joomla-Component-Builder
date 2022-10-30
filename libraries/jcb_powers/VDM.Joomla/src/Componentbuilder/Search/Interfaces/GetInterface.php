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

namespace VDM\Joomla\Componentbuilder\Search\Interfaces;


/**
 * Search Database Get Interface
 * 
 * @since 3.2.0
 */
interface GetInterface
{
	/**
	 * Get a value from a given table
	 *          Example: $this->value(23, 'value_key', 'table_name');
	 *
	 * @param   int              $id        The item ID
	 * @param   string           $field     The field key
	 * @param   string|null      $table     The table
	 *
	 * @return  mixed
	 * @since 3.2.0
	 */
	public function value(int $id, string $field, string $table = null);

	/**
	 * Get values from a given table
	 *          Example: $this->item(23, 'table_name');
	 *
	 * @param   int           $id        The item ID
	 * @param   string| null  $table     The table
	 *
	 * @return  object|null
	 * @since 3.2.0
	 */
	public function item(int $id, string $table = null): ?object;

	/**
	 * Get values from a given table
	 *          Example: $this->items('table_name');
	 *
	 * @param   string|null   $table   The table
	 * @param   int           $bundle  The bundle to return (0 = all)
	 *
	 * @return  array|null
	 * @since 3.2.0
	 */
	public function items(string $table = null, int $bundle = 0): ?array;

}

