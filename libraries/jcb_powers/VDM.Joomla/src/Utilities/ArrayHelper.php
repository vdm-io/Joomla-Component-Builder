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

namespace VDM\Joomla\Utilities;


/**
 * Some array tricks helper
 * 
 * @since  3.0.9
 */
abstract class ArrayHelper
{
	/**
	 * Check if have an array with a length
	 *
	 * @input	array   The array to check
	 *
	 * @returns bool/int  number of items in array on success
	 * 
	 * @since  3.0.9
	 */
	public static function check($array, $removeEmptyString = false)
	{
		if (is_array($array) && ($nr = count((array)$array)) > 0)
		{
			// also make sure the empty strings are removed
			if ($removeEmptyString)
			{
				foreach ($array as $key => $string)
				{
					if (empty($string))
					{
						unset($array[$key]);
					}
				}
				return self::check($array, false);
			}
			return $nr;
		}
		return false;
	}

	/**
	 * Merge an array of array's
	 *
	 * @input	array   The arrays you would like to merge
	 *
	 * @returns array on success
	 * 
	 * @since  3.0.9
	 */
	public static function merge($arrays)
	{
		if(self::check($arrays))
		{
			$arrayBuket = array();
			foreach ($arrays as $array)
			{
				if (self::check($array))
				{
					$arrayBuket = array_merge($arrayBuket, $array);
				}
			}
			return $arrayBuket;
		}
		return false;
	}

	/**
	 * Check if arrays intersect
	 *
	 * @input	array   The first array
	 * @input	array   The second array
	 *
	 * @returns bool  true if intersect else false
	 * 
	 * @since  3.1.1
	 */
	public static function intersect($a_array, $b_array): bool
	{
		// flip the second array
		$b_array = array_flip($b_array);

		// loop the first array
		foreach ($a_array as $v)
		{
			if (isset($b_array[$v]))
			{
				return true;
			}
		}
		return false;
	}

}

