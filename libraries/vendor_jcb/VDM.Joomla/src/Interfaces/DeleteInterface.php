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

namespace VDM\Joomla\Interfaces;


/**
 * Database Delete Interface
 * 
 * @since 3.2.0
 */
interface DeleteInterface
{
	/**
	 * Delete all rows in the database that match these conditions
	 *
	 * @param   array    $conditions    Conditions by which to delete the data in database [array of arrays (key => value)]
	 * @param   string   $table         The table where the data is being deleted
	 *
	 * @return  bool
	 * @since   3.2.0
	 **/
	public function items(array $conditions, string $table): bool;

	/**
	 * Truncate a table
	 *
	 * @param   string   $table    The table that should be truncated
	 *
	 * @return  void
	 * @since   3.2.2
	 **/
	public function truncate(string $table): void;
}

