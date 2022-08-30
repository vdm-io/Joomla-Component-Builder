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
 * The Indentation Factory
 * 
 * @since 3.2.0
 */
abstract class Indent
{
	/**
	 * Spacer bucket (to speed-up the build)
	 * 
	 * @var   array
	 * @since 3.2.0
	 */
	private static array $bucket = [];

	/**
	 * The indentation string
	 * 
	 * @var   string
	 * @since 3.2.0
	 */
	private static string $indent;

	/**
	 * Set the space
	 * 
	 * @param   int   $nr  The number of spaces
	 * 
	 * @return  string
	 * @since 3.2.0
	 */
	public function _(int $nr): string
	{
		// check if we already have the string
		if (!isset(self::$bucket[$nr]))
		{
			// get the string
			self::$bucket[$nr] = str_repeat(self::indent(), (int) $nr);
		}
		// return stored indentation
		return self::$bucket[$nr];
	}

	/**
	 * Get the indentation string
	 *
	 * @return  string
	 * @since 3.2.0
	 */
	private static function indent(): string
	{
		if (empty(self::$indent))
		{
			self::init();
		}

		return self::$indent;
	}

	/**
	 * The constructor for indent
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	private static function init()
	{
		// the default is TAB
		self::$indent = Compiler::_('Config')->indentation_value;
	}

}

