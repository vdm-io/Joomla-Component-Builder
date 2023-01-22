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
 * The Placeholder Prefix and Suffix Factory
 * 
 * @since 3.2.0
 */
abstract class Placefix
{
	/**
	 * The hash prefix and suffix
	 *
	 * @var     string
	 * @since 3.2.0
	 **/
	private static string $hhh = '#' . '#' . '#';

	/**
	 * The open prefix
	 *
	 * @var     string
	 * @since 3.2.0
	 **/
	private static string $bbb = '[' . '[' . '[';

	/**
	 * The close suffix
	 *
	 * @var     string
	 * @since 3.2.0
	 **/
	private static string $ddd = ']' . ']' . ']';

	/**
	 * Get a prefix and suffix added to given string
	 *
	 * @param   string  $class  The class name
	 *
	 * @return  string
	 * @since 3.2.0
	 */
	public static function _(string $string): string
	{
		return self::b() . $string . self::d();
	}

	/**
	 * Get a open prefix
	 *
	 * @return  string
	 * @since 3.2.0
	 */
	public static function b(): string
	{
		return self::$bbb;
	}

	/**
	 * Get a close suffix
	 *
	 * @return  string
	 * @since 3.2.0
	 */
	public static function d(): string
	{
		return self::$ddd;
	}

	/**
	 * Get a hash prefix and suffix added to given string
	 *
	 * @param   string  $class  The class name
	 *
	 * @return  string
	 * @since 3.2.0
	 */
	public static function _h(string $string): string
	{
		return self::h() . $string . self::h();
	}

	/**
	 * Get a hash-fix
	 *
	 * @return  string
	 * @since 3.2.0
	 */
	public static function h(): string
	{
		return self::$hhh;
	}

}

