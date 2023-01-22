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
 * Basic Math Helper
 * 
 * @since  3.0.9
 */
abstract class MathHelper
{
	/**
	 * bc math wrapper (very basic not for accounting)
	 *
	 * @param   string   $type    The type bc math
	 * @param   int      $val1    The first value
	 * @param   int      $val2    The second value
	 * @param   int      $scale   The scale value
	 *
	 * @return int
	 * 
	 * @since  3.0.9
	 */
	public static function bc($type, $val1, $val2, $scale = 0)
	{
		// build function name
		$function = 'bc' . $type;
		// use the bcmath function if available
		if (function_exists($function))
		{
			return $function($val1, $val2, $scale);
		}
		// if function does not exist we use +-*/ operators (fallback - not ideal)
		switch ($type)
		{
			// Multiply two numbers
			case 'mul':
				return (string) round($val1 * $val2, $scale);
				break;
			// Divide of two numbers
			case 'div':
				return (string) round($val1 / $val2, $scale);
				break;
			// Adding two numbers
			case 'add':
				return (string) round($val1 + $val2, $scale);
				break;
			// Subtract one number from the other
			case 'sub':
				return (string) round($val1 - $val2, $scale);
				break;
			// Raise an arbitrary precision number to another
			case 'pow':
				return (string) round(pow($val1, $val2), $scale);
				break;
			// Compare two arbitrary precision numbers
			case 'comp':
				return (round($val1,2) == round($val2,2));
				break;
		}
		return false;
	}

	/**
	 * Basic sum of an array with more precision
	 *
	 * @param   array   $array    The values to sum
	 * @param   int      $scale   The scale value
	 *
	 * @return float
	 * 
	 * @since  3.0.9
	 */
	public static function sum($array, $scale = 4)
	{
		// use the bcadd function if available
		if (function_exists('bcadd'))
		{
			// set the start value
			$value = 0.0;
			// loop the values and run bcadd
			foreach($array as $val)
			{
				$value = bcadd($value, (string) $val, $scale);
			}
			return $value;
		}
		// fall back on array sum
		return array_sum($array);
	}

}

