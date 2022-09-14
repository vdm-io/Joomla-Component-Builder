<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Search\Interfaces;


/**
 * Search Find Interface
 * 
 * @since 3.2.0
 */
interface FindInterface
{
	/**
	 * Get found values
	 *
	 * @param string|null    $table   The table being searched
	 *
	 * @return  array|null
	 * @since 3.2.0
	 */
	public function get(?string $table = null): ?array;

	/**
	 * Search over an item fields
	 *
	 * @param object          $item    The item object of fields to search through
	 * @param int|null        $id      The item id
	 * @param string|null     $table   The table being searched
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function item(object $item, ?int $id =null, ?string $table = null);

	/**
	 * Search over an array of items
	 *
	 * @param array|null     $items    The array of items to search through
	 * @param string|null    $table    The table being searched
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function items(?array $items = null, ?string $table = null);

	/**
	 * Reset all found values of a table
	 *
	 * @param string|null    $table   The table being searched
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function reset(?string $table = null);
}

