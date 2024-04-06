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
 * Search Type Interface
 * 
 * @since 3.2.0
 */
interface SearchTypeInterface
{
	/**
	 * Search inside a string
	 *
	 * @param   string    $value   The string value
	 *
	 * @return  string|null    The marked string if found, else null
	 * @since 3.2.0
	 */
	public function string(string $value): ?string;

	/**
	 * Replace found instances inside string value
	 *
	 * @param   string     $value      The string value to update
	 *
	 * @return  string      The updated string
	 * @since 3.2.0
	 */
	public function replace(string $value): string;

}

