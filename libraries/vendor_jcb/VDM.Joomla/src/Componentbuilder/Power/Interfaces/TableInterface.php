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

namespace VDM\Joomla\Componentbuilder\Power\Interfaces;


use VDM\Joomla\Interfaces\TableInterface as ExtendingTableInterface;


/**
 * The JCB Package Table Interface
 * 
 * @since   5.1.1
 */
interface TableInterface extends ExtendingTableInterface
{
	/**
	 * Get all parents fields of an area/view/table
	 *
	 * @param   string  $table     The area
	 *
	 * @return  array  An array of fields
	 * @since   5.1.1
	 */
	public function parents(string $table): array;

	/**
	 * Get direct children dependencies pointing to the given entity.
	 *
	 * This method returns a map of `$entity` field keys to an array of referencing tables and fields.
	 *
	 * @param   string       $entity  The target entity name being linked to (e.g., 'power').
	 * @param   array|null   $direct  The direct children.
	 *                                     empty-array: means return none
	 *                                     null: means return all
	 *
	 * @return  array  An associative array: [targetField => [['table' => string, 'name' => string], ...]]
	 * @since   5.1.1
	 */
	public function children(string $entity, ?array $direct = null): array;

	/**
	 * Loops over the $table fields and builds a new array
	 *    that hold all the fields to be searched in a specific area of JCB
	 *
	 * @param string  $table  The target table to search
	 * @param string  $area   The target areas to search
	 *
	 * @return array The newly built array.
	 * @since  5.1.0
	 */
	public function search(string $table, string $area): array;

	/**
	 * Get the list view code name from a table's fields.
	 *
	 * This method returns the first field where the 'list' key is a non-empty string.
	 *
	 * @param   string  $table  The table name to retrieve fields for.
	 *
	 * @return  string|null  The list view code name, or null if not found.
	 * @since   5.1.2
	 */
	public function listViewCodeName(string $table): ?string;
}

