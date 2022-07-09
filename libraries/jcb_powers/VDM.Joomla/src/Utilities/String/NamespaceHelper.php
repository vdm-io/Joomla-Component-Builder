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

namespace VDM\Joomla\Utilities\String;


use VDM\Joomla\Utilities\StringHelper;


/**
 * Control the naming of a namespace helper
 * 
 * @since  3.0.9
 */
abstract class NamespaceHelper
{
	/**
	 * Making namespace safe
	 *
	 * @input	string       The you would like to make safe
	 *
	 * @returns string on success
	 * 
	 * @since  3.0.9
	 */
	public static function safe($string)
	{
		// 0nly continue if we have a string
		if (StringHelper::check($string))
		{
			// make sure it has not numbers
			$string = StringHelper::numbers($string);

			// Transliterate string TODO: look again as this make it lowercase
			// $string = StringHelper::transliterate($string);

			// first remove all [\] backslashes
			$string = str_replace('\\', '1', $string);

			// remove all and keep only characters and [\] backslashes inside of the string
			$string = trim( preg_replace("/[^A-Za-z1]/", '', $string), '1');

			// place the [\] backslashes back
			return trim( preg_replace("/1+/", '\\', $string));
		}
		// not a string
		return '';
	}

}

