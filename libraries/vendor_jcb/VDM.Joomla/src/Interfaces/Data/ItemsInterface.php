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

namespace VDM\Joomla\Interfaces\Data;


/**
 * Data Items Interface
 * 
 * @since 3.2.2
 */
interface ItemsInterface
{
	/**
	 * Set the current active table
	 *
	 * @param string $table The table that should be active
	 *
	 * @return self
	 * @since 3.2.2
	 */
	public function table(string $table): self;

	/**
	 * Get list of items
	 *
	 * @param array     $values    The ids of the items
	 * @param string    $key       The key of the values
	 *
	 * @return array|null The item object or null
	 * @since 3.2.2
	 */
	public function get(array $values, string $key = 'guid'): ?array;

	/**
	 * Get the values
	 *
	 * @param array   $values    The list of values (to search by).
	 * @param string  $key       The key on which the values being searched.
	 * @param string  $get       The key of the values we want back
	 *
	 * @return array|null The array of found values.
	 * @since 3.2.2
	 */
	public function values(array $values, string $key = 'guid', string $get = 'id'): ?array;

	/**
	 * Set items
	 *
	 * @param array     $items  The list of items
	 * @param string    $key    The key on which the items should be set
	 *
	 * @return bool
	 * @since 3.2.2
	 */
	public function set(array $items, string $key = 'guid'): bool;

	/**
	 * Delete items
	 *
	 * @param array    $values  The item key value
	 * @param string   $key     The item key
	 *
	 * @return bool
	 * @since 3.2.2
	 */
	public function delete(array $values, string $key = 'guid'): bool;

	/**
	 * Get the current active table
	 *
	 * @return  string
	 * @since 3.2.2
	 */
	public function getTable(): string;
}

