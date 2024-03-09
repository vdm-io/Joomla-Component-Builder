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

namespace VDM\Joomla\Componentbuilder\Compiler\Interfaces\Field;


/**
 * Field Joomla Core Field Interface
 * 
 * @since 3.2.0
 */
interface CoreFieldInterface
{
	/**
	 * Get the Array of Existing Core Field Names
	 *
	 * @param bool      $lowercase Switch to set field lowercase
	 *
	 * @return array
	 * @since 3.2.0
	 */
	public function get(bool $lowercase = false): array;
}

