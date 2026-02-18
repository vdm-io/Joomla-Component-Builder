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

namespace VDM\Joomla\Interfaces\Import;


/**
 * Import Status Interface
 * 
 * @since  3.2.2
 */
interface StatusInterface
{
	/**
	 * Updates the status in the database.
	 *
	 * This method updates the import status in the database based on the result of the import process.
	 *
	 * @param int     $status  The status code to set for the import
	 * @param string  $value   The target status value
	 * @param string  $key     The target key [default: `guid`]
	 *
	 * @return void
	 * @since  5.0.2
	 */
	public function set(int $status, string $value, $key = 'guid'): void;

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
	 * Set the current target status field name
	 *
	 * @param string  $fieldName The field name where the status is set
	 *
	 * @return self
	 * @since 3.2.2
	 */
	public function field(string $fieldName): self;

	/**
	 * Get the current active table
	 *
	 * @return  string
	 * @since 3.2.2
	 */
	public function getTable(): string;

	/**
	 * Get the current target status field name
	 *
	 * @return string
	 * @since 3.2.2
	 */
	public function getField(): string;
}

