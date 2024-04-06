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


use VDM\Joomla\Utilities\StringHelper;


/**
 * Control the naming of a class and function
 * 
 * @since  3.0.9
 */
abstract class ClassfunctionHelper
{
	/**
	 * Making class or function name safe
	 *
	 * @input	string       The name you would like to make safe
	 *
	 * @returns string on success
	 * 
	 * @since  3.0.9
	 */
	public static function safe($name): string
	{
		// remove numbers if the first character is a number
		if (is_numeric(substr((string) $name, 0, 1)))
		{
			$name = StringHelper::numbers($name);
		}

		// remove all spaces and strange characters
		return trim(preg_replace("/[^A-Za-z0-9_-]/", '', (string) $name));
	}

}

