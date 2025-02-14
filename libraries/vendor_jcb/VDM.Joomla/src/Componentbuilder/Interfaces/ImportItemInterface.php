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
 * Import Item Interface
 * 
 * @since  3.0.3
 */
interface ImportItemInterface
{
	/**
	 * Get the item from the import row values and ensure it is valid
	 *
	 * @param   string  $table    The table these columns belongs to.
	 * @param   array   $columns  The columns to extract.
	 *
	 * @return  array|null
	 * @since  4.0.3
	 */
	public function get(string $table, array $columns): ?array;
}

