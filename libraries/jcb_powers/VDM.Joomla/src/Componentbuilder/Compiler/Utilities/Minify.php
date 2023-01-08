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


use VDM\Minify\Css;
use VDM\Minify\JavaScript;


/**
 * Compiler Minifier
 * 
 * @since 3.2.0
 */
abstract class Minify
{
	/**
	 * Minify JavaScript Class
	 *
	 * @var JavaScript
	 * @since 3.2.0
	 */
	public static JavaScript $js;

	/**
	 * Minify Css Class
	 *
	 * @var Css
	 * @since 3.2.0
	 */
	public static Css $css;

	/**
	 * Minify JavaScript
	 * 
	 * @param   string  $data
	 *
	 * @return  string
	 * @since 3.2.0
	 */
	public static function js(string $data): string
	{
		// check if instance already set
		if (empty(self::$js))
		{
			// set instanceof on JavaScript
			self::$js = new JavaScript;
		}

		// add the data
		self::$js->add($data);

		// return minified
		return self::$js->minify();
	}

	/**
	 * Minify Css
	 * 
	 * @param   string  $data
	 *
	 * @return  string
	 * @since 3.2.0
	 */
	public static function css(string $data): string
	{
		// check if instance already set
		if (empty(self::$css))
		{
			// set instanceof on Css
			self::$css = new Css;
		}

		// add the data
		self::$css->add($data);

		// return minified
		return self::$css->minify();
	}

}

