<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    19th August, 2026
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\Router;


/**
 * Router Route Helper Interface
 * 
 * @since  6.1.7
 */
interface RouteHelperInterface
{
	/**
	 * Build the route method one site view offers.
	 *
	 * @param   string  $nameSingleCode  The single view code name.
	 * @param   string  $nameListCode    The list view code name.
	 * @param   bool    $front           Whether this is a front item view, which always gets one.
	 *
	 * @return  string  The method, or nothing when the view needs none or already has one.
	 *
	 * @since   6.1.7
	 */
	public function get(string $nameSingleCode, string $nameListCode, bool $front = false): string;
}

