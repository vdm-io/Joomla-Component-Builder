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
 * Control the naming of a namespace helper
 * 
 * @since  3.0.9
 */
abstract class NamespaceHelper
{
	/**
	 * Making namespace safe
	 *
	 * @input    string   $string           The you would like to make safe
	 * @input    bool     $removeNumbers    The switch to remove numbers
	 *
	 * @returns string on success
	 * 
	 * @since  3.0.9
	 */
	public static function safe(string $string, bool $removeNumbers = true): string
	{
		// 0nly continue if we have a string with length
		if (StringHelper::check($string))
		{
			// make sure it has not numbers
			if ($removeNumbers)
			{
				$string = StringHelper::numbers($string);
			}

			// Transliterate string TODO: look again as this makes it lowercase
			// $string = StringHelper::transliterate($string);

			// first remove all [\] backslashes
			$string = str_replace('\\', '+', (string) $string);

			// remove all and keep only characters and [\] backslashes inside of the string
			if ($removeNumbers)
			{
				$string = trim( preg_replace("/[^A-Za-z\+]/", '', $string), '+');
			}
			else
			{
				$string = trim( preg_replace("/[^A-Za-z0-9\+]/", '', $string), '+');
			}

			// place the [\] backslashes back
			return trim( preg_replace("/\++/", '\\', $string));
		}

		// not a string
		return '';
	}

}

