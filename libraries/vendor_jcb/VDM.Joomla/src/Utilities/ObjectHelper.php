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
 * Some object tricks
 * 
 * @since  3.0.9
 */
abstract class ObjectHelper
{
	/**
	 * Check if have an object with a length
	 *
	 * @input	object   The object to check
	 *
	 * @returns bool true on success
	 * 
	 * @since  3.0.9
	 */
	public static function check($object)
	{
		if (is_object($object))
		{
			return count((array) $object) > 0;
		}

		return false;
	}

	/**
	 * Checks if two objects are equal by comparing their properties and values.
	 *
	 *  This method converts both input objects to
	 *  associative arrays, sorts the arrays by keys,
	 *  and compares these sorted arrays.
	 *
	 *  If the arrays are identical, the objects are considered equal.
	 *
	 * @param object|null  $obj1  The first object to compare.
	 * @param object|null  $obj2  The second object to compare.
	 *
	 * @return bool  True if the objects are equal, false otherwise.
	 * @since  5.0.2
	 */
	public static function equal(?object $obj1, ?object $obj2): bool
	{
		// if any is null we return false as that means there is a none object
		// we are not comparing null but objects
		// but we allow null as some objects while
		// not instantiate are still null
		if (is_null($obj1) || is_null($obj2))
		{
			return false;
		}

		// Convert both objects to associative arrays
		$array1 = json_decode(json_encode($obj1), true);
		$array2 = json_decode(json_encode($obj2), true);

		// Sort the arrays by keys
		self::recursiveKsort($array1);
		self::recursiveKsort($array2);

		// Compare the sorted arrays
		return $array1 === $array2;
	}

	/**
	 * Recursively sorts an associative array by keys.
	 *
	 * This method will sort an associative array by its keys at all levels.
	 *
	 * @param array &$array The array to sort.
	 *
	 * @return void
	 * @since  5.0.2
	 */
	protected static function recursiveKsort(array &$array): void
	{
		// Sort the array by its keys
		ksort($array);

		// Recursively sort nested arrays
		foreach ($array as &$value)
		{
			if (is_array($value))
			{
				self::recursiveKsort($value);
			}
		}
	}
}

