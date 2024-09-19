<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    4th September, 2020
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Utilities;


use VDM\Joomla\Utilities\GetHelper;


/**
 * Some easy get...
 * 
 * @since  3.2.0
 */
abstract class GetHelperExtrusion extends GetHelper
{
	/**
	 * get all strings between two other strings
	 * 
	 * @param  string       $content    The content to search
	 * @param  string       $start      The starting value
	 * @param  string       $end        The ending value
	 *
	 * @return  array|null          On success
	 * @since  3.0.9
	 */
	public static function allBetween(string $content, string $start, string $end): ?array
	{
		// reset bucket
		$bucket = [];
		for ($i = 0; ; $i++)
		{
			// search for string
			$found = self::between($content, $start, $end);

			if (StringHelper::check($found))
			{
				// add to bucket
				$bucket[] = $found;

				// build removal string
				$remove = $start . $found . $end;

				// remove from content
				$content = str_replace($remove, '', $content);
			}
			else
			{
				break;
			}

			// safety catch
			if ($i == 500)
			{
				break;
			}
		}

		// only return unique array of values
		if (ArrayHelper::check($bucket))
		{
			return  array_unique($bucket);
		}

		return null;
	}

	/**
	 * get a string between two other strings
	 * 
	 * @param  string       $content    The content to search
	 * @param  string       $start      The starting value
	 * @param  string       $end        The ending value
	 * @param  string       $default    The default value if none found
	 *
	 * @return  string          On success / empty string on failure
	 * @since  3.0.9
	 */
	public static function between(string $content, string $start, string $end, string $default = ''): string
	{
		$array = explode($start, $content);
		if (isset($array[1]) && strpos($array[1], $end) !== false)
		{
			$array = explode($end, $array[1]);

			// return string found between
			return $array[0];
		}

		return $default;
	}

}

