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


use Joomla\CMS\Component\ComponentHelper;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Utilities\Component\Helper;


/**
 * Control the naming of a field
 * 
 * @since  3.0.9
 */
abstract class FieldHelper
{
	/**
	 * The field builder switch
	 * 
	 * @since  3.0.9
	 */
	protected static $builder = false;

	/**
	 * Making field names safe
	 *
	 * @input	string       The string you would like to make safe
	 * @input	boolean      The switch to return an ALL UPPER CASE string
	 * @input	string       The string to use in white space
	 *
	 * @returns string on success
	 * 
	 * @since  3.0.9
	 */
	public static function safe($string, $allcap = false, $spacer = '_')
	{
		// get global value
		if (self::$builder === false)
		{
			self::$builder = Helper::getParams()->get('field_name_builder', 1);
		}

		// use the new convention
		if (2 == self::$builder)
		{
			// 0nly continue if we have a string
			if (StringHelper::check($string))
			{
				// check that the first character is not a number
				if (is_numeric(substr((string)$string, 0, 1)))
				{
					$string = StringHelper::numbers($string);
				}

				// remove all other strange characters
				$string = trim((string) $string);
				$string = preg_replace('/'.$spacer.'+/', ' ', $string);
				$string = preg_replace('/\s+/', ' ', $string);

				// Transliterate string
				$string = StringHelper::transliterate($string);

				// remove all and keep only characters and numbers
				$string = preg_replace("/[^A-Za-z0-9 ]/", '', (string) $string);

				// replace white space with underscore (SAFEST OPTION)
				$string = preg_replace('/\s+/', (string) $spacer, $string);

				// return all caps
				if ($allcap)
				{
					return strtoupper($string);
				}

				// default is to return lower
				return strtolower($string);
			}
			// not a string
			return '';
		}

		// return all caps
		if ($allcap)
		{
			return StringHelper::safe($string, 'U');
		}

		// use the default (original behavior/convention)
		return StringHelper::safe($string);
	}

}

