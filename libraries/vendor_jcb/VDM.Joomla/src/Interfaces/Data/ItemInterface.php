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
 * Data Item Interface
 * 
 * @since 3.2.2
 */
interface ItemInterface
{
	/**
	 * Set the current active table
	 *
	 * @param string  $table The table that should be active
	 *
	 * @return self
	 * @since 3.2.2
	 */
	public function table(string $table): self;

	/**
	 * Get an item
	 *
	 * @param string       $value   The item key value
	 * @param string       $key     The item key
	 *
	 * @return object|null The item object or null
	 * @since 3.2.2
	 */
	public function get(string $value, string $key = 'guid'): ?object;

	/**
	 * Get the value
	 *
	 * @param string   $value   The item key value
	 * @param string   $key     The item key
	 * @param string   $get     The key of the values we want back
	 *
	 * @return mixed
	 * @since 3.2.2
	 */
	public function value(string $value, string $key = 'guid', string $get = 'id');

	/**
	 * Set an item
	 *
	 * @param object       $item    The item
	 * @param string       $key     The item key
	 * @param string|null  $action  The action to load power
	 *
	 * @return bool
	 * @since 3.2.2
	 */
	public function set(object $item, string $key = 'guid', ?string $action = null): bool;

	/**
	 * Delete an item
	 *
	 * @param string    $value   The item key value
	 * @param string    $key     The item key
	 *
	 * @return bool
	 * @since 3.2.2
	 */
	public function delete(string $value, string $key = 'guid'): bool;

	/**
	 * Get the current active table
	 *
	 * @return  string
	 * @since 3.2.2
	 */
	public function getTable(): string;
}

