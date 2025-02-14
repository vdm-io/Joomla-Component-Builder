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

namespace VDM\Joomla\Componentbuilder\Interfaces;


/**
 * Import Status Interface
 * 
 * @since  3.2.2
 */
interface ImportStatusInterface
{
	/**
	 * Updates the status in the database.
	 *
	 * This method updates the import status in the database based on the result of the import process.
	 * Status codes:
	 *  - 2: Being Processed.
	 *  - 3: Import completed successfully.
	 *  - 4: Import completed with errors.
	 *
	 * @param int     $status  The status code to set for the import (2 => processing, 3 => success, 4 => errors).
	 * @param string  $guid    The target import GUID
	 *
	 * @return void
	 * @since  3.2.2
	 */
	public function set(int $status, string $guid): void;

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

