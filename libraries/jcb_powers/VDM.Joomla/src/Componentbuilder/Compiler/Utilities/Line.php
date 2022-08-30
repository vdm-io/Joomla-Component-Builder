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

namespace VDM\Joomla\Componentbuilder\Compiler\Utilities;


use VDM\Joomla\Componentbuilder\Compiler\Factory as Compiler;


/**
 * The Debug Line Number Factory
 * 
 * @since 3.2.0
 */
abstract class Line
{
	/**
	 * Should we add debug lines
	 *
	 * @since 3.2.0
	 **/
	private static $add = 'check';

	/**
	 * Set the line number in comments
	 *
	 * @param   int     $nr     The line number
	 * @param   string  $class  The class name
	 *
	 * @return  string
	 * @since 3.2.0
	 */
	public static function _(int $nr, string $class): string
	{
		if (self::add())
		{
			return ' [' . $class . ' ' . $nr . ']';
		}

		return '';
	}

	/**
	 * Check if we should add the line number
	 *
	 * @return  bool
	 * @since 3.2.0
	 */
	private static function add(): bool
	{
		if (!is_bool(self::$add))
		{
			self::init();
		}

		return self::$add;
	}

	/**
	 * The constructor for add
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	private static function init()
	{
		self::$add = Compiler::_('Config')->debug_line_nr;
	}

}

