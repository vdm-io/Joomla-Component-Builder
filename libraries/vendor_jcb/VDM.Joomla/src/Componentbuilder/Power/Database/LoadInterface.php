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

namespace VDM\Joomla\Componentbuilder\Power\Database;


/**
 * Power Database Load
 * 
 * @since 2.0.1
 */
interface LoadInterface
{
	/**
	 * Get a value from a given table
	 *          Example: $this->value(
	 *                        [
	 *                           'guid' => 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx'
	 *                        ], 'value_key'
	 *                    );
	 *
	 * @param   array      $keys      The item keys
	 * @param   string     $field     The field key
	 * @param   string     $table     The table
	 *
	 * @return  mixed
	 * @since 2.0.1
	 */
	public function value(array $keys, string $field);

	/**
	 * Get values from a given table
	 *          Example: $this->item(
	 *                        [
	 *                           'guid' => 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx'
	 *                        ]
	 *                    );
	 *
	 * @param   array    $keys      The item keys
	 * @param   string   $table     The table
	 *
	 * @return  object|null
	 * @since 2.0.1
	 */
	public function item(array $keys): ?object;
 
	/**
	 * Get values from a given table
	 *          Example: $this->items(
	 *                        [
	 *                           'guid' => [
	 *                              'operator' => 'IN',
	 *                              'value' => [''xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx'', ''xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx'']
	 *                           ]
	 *                        ]
	 *                    );
	 *          Example: $this->items($ids, 'table_name');
	 *
	 * @param   array    $keys    The item keys
	 * @param   string   $table   The table
	 *
	 * @return  array|null
	 * @since 2.0.1
	 */
	public function items(array $keys): ?array;
}

