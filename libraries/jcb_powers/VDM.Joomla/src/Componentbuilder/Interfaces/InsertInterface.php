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
 * Database Insert Interface
 * 
 * @since 3.2.0
 */
interface InsertInterface
{
	/**
	 * Set rows to the database
	 *
	 * @param   array    $data      Dataset to store in database [array of arrays (key => value)]
	 * @param   string   $table     The table where the data is being added
	 *
	 * @return  bool
	 * @since   3.2.0
	 **/
	public function rows(array $data, string $table): bool;

	/**
	 * Set items to the database
	 *
	 * @param   array    $data         Data to store in database (array of objects)
	 * @param   array    $columns   Data columns
	 * @param   string   $table         The table where the data is being added
	 *
	 * @return  bool
	 * @since   3.2.0
	 **/
	public function items(array $data, array $columns, string $table): bool;

	/**
	 * Set row to the database
	 *
	 * @param   array    $data      Dataset to store in database (key => value)
	 * @param   string   $table     The table where the data is being added
	 *
	 * @return  bool
	 * @since   3.2.0
	 **/
	public function row(array $data, string $table): bool;

}

