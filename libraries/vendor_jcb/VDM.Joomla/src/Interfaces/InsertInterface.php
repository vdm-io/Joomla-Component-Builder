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
 * Database Insert Interface
 * 
 * @since 3.2.0
 */
interface InsertInterface
{
	/**
	 * Switch to prevent/allow defaults from being added.
	 *
	 * @param   bool    $trigger      toggle the defaults
	 *
	 * @return  void
	 * @since   3.2.0
	 **/
	public function defaults(bool $trigger = true);

	/**
	 * Insert rows to the database (with remapping and filtering columns option)
	 *
	 * @param   array    $data      Dataset to store in database [array of arrays (key => value)]
	 * @param   string   $table     The table where the data is being added
	 * @param   array    $columns   Data columns for remapping and filtering
	 *
	 * @return  bool
	 * @since   3.2.0
	 **/
	public function rows(array $data, string $table, array $columns = []): bool;

	/**
	 * Insert items to the database (with remapping and filtering columns option)
	 *
	 * @param   array    $data         Data to store in database (array of objects)
	 * @param   string   $table        The table where the data is being added
	 * @param   array    $columns      Data columns for remapping and filtering
	 *
	 * @return  bool
	 * @since   3.2.0
	 **/
	public function items(array $data, string $table, array $columns = []): bool;

	/**
	 * Insert row to the database
	 *
	 * @param   array    $data      Dataset to store in database (key => value)
	 * @param   string   $table     The table where the data is being added
	 *
	 * @return  bool
	 * @since   3.2.0
	 **/
	public function row(array $data, string $table): bool;

	/**
	 * Insert item to the database
	 *
	 * @param   object    $data     Dataset to store in database (key => value)
	 * @param   string   $table     The table where the data is being added
	 *
	 * @return  bool
	 * @since   3.2.0
	 **/
	public function item(object $data, string $table): bool;
}

