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
 * Load data based on global unique ids from remote system
 * 
 * @since 3.2.2
 */
interface RemoteInterface
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
	 * Init all items not found in database
	 *
	 * @return bool
	 * @since 3.2.0
	 */
	public function init(): bool;

	/**
	 * Reset the items
	 *
	 * @param array   $items    The global unique ids of the items
	 *
	 * @return bool
	 * @since 3.2.0
	 */
	public function reset(array $items): bool;

	/**
	 * Load a item
	 *
	 * @param string   $guid    The global unique id of the item
	 * @param array    $order   The search order
	 *
	 * @return bool
	 * @since 3.2.2
	 */
	public function load(string $guid, array $order = ['remote', 'local']): bool;

	/**
	 * Get the current active table
	 *
	 * @return  string
	 * @since 3.2.2
	 */
	public function getTable(): string;
}

