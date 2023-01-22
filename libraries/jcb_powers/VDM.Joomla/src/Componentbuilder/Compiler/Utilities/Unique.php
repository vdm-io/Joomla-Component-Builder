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

namespace VDM\Joomla\Componentbuilder\Compiler\Utilities;


/**
 * Compiler Creating an Unique Code/String
 * 
 * @since 3.2.0
 */
abstract class Unique
{
	/**
	 * Unique Code/Strings
	 *
	 * @var array
	 * @since 3.2.0
	 */
	protected static array $unique = [];

	/**
	 * Unique Areas Code/Strings
	 *
	 * @var array
	 * @since 3.2.0
	 */
	protected static array $areas = [];

	/**
	 * Creating an unique local key
	 *
	 * @param   int       $size    The key size
	 *
	 * @return  string  The unique local key
	 *
	 */
	public static function get($size): string
	{
		$unique = end(self::$unique[$size]);

		if(!$unique)
		{
			$unique = substr("vvvvvvvvvvvvvvvvvvvvvvvvvvvvvv", 0, $size);
		}

		while(in_array($unique, self::$unique[$size]))
		{
			$unique++;
		}

		self::$unique[$size][] = $unique;

		return $unique;
	}

	/**
	 * Creating an Unique Code
	 * 
	 * @param   string  $code
	 * @param   string  $target
	 *
	 * @return  string
	 * @since 3.2.0
	 */
	public static function code(string $code, string $target = 'both'): string
	{
		if (!isset(self::$areas[$target])
			|| !in_array(
				$code, self::$areas[$target]
			))
		{
			self::$areas[$target][] = $code;

			return $code;
		}

		// make sure it is unique
		return self::code($code . self::get(1));
	}

}

