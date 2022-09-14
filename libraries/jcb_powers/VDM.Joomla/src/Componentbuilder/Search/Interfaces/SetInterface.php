<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Search\Interfaces;


/**
 * Search Database Set Interface
 * 
 * @since 3.2.0
 */
interface SetInterface
{
	/**
	 * Set values to a given table
	 *          Example: $this->value(Value, 23, 'value_key', 'table_name');
	 *
	 * @param   mixed          $value     The field value
	 * @param   int            $id        The item ID
	 * @param   string         $field     The field key
	 * @param   string|null    $table     The table
	 *
	 * @return  bool
	 * @since 3.2.0
	 */
	public function value($value, int $id, string $field, ?string $table = null): bool;

	/**
	 * Set values to a given table
	 *          Example: $this->item(Object, 23, 'table_name');
	 *
	 * @param   object        $item    The item to save
	 * @param   string|null   $table   The table
	 *
	 * @return  bool
	 * @since 3.2.0
	 */
	public function item(object $item, ?string $table = null): bool;

	/**
	 * Set values to a given table
	 *          Example: $this->items(Array, 'table_name');
	 *
	 * @param   array          $items    The items being saved
	 * @param   string|null    $table    The table
	 *
	 * @return  bool
	 * @since 3.2.0
	 */
	public function items(array $items, string $table = null): bool;
}

