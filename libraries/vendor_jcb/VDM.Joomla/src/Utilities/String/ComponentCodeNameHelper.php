<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    3rd September, 2020
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Utilities\String;


/**
 * Control the naming of a component code name
 * 
 * @since  3.2.1
 */
abstract class ComponentCodeNameHelper
{
	/**
	 * Making component code name safe for namespacing.
	 *
	 * This function processes a given string to format it according to PHP namespace naming conventions.
	 * ensures no spaces or underscores are present.
	 *
	 * @param  string   $string    The component code name string to make safe
	 *
	 * @return string   A namespace-safe string on success
	 * @since  3.2.1
	 */
	public static function safe(string $string): string
	{
		// Trim whitespace from both ends of the string
		$string = trim($string);

		// Replace any sequence of non-alphanumeric characters or underscores with a single underscore
		$string = preg_replace('/[^\p{L}\p{N}]+/u', '', $string);

		// Ensure the first character is uppercase (useful if the input string started with an invalid character)
		$string = ucfirst($string);

		// Return the namespace-safe component code name
		return $string;
	}
}

