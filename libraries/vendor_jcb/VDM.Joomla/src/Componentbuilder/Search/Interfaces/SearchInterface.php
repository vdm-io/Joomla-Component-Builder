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

namespace VDM\Joomla\Componentbuilder\Search\Interfaces;


/**
 * Search Interface
 * 
 * @since 3.2.0
 */
interface SearchInterface
{
	/**
	 * Get found values
	 *
	 * @param string     $table   The table being searched
	 *
	 * @return  array|null
	 * @since 3.2.0
	 */
	public function get(string $table): ?array;

	/**
	 * Search inside a value
	 *
	 * @param   mixed         $value     The field value
	 * @param   int               $id          The item ID
	 * @param   string          $field      The field key
	 * @param   string          $table     The table
	 *
	 * @return  bool
	 * @since 3.2.0
	 */
	public function value($value, int $id, string $field, string $table): bool;

	/**
	 * Empty the found values
	 *
	 * @param string     $table   The table being searched
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function reset(string $table);

}

