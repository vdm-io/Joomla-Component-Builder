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

namespace VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\Model;


/**
 * Check In Now Interface
 * 
 * @since 5.1.2
 */
interface CheckInNowInterface
{
	/**
	 * Get the generated call snippet that invokes the check-in method.
	 *
	 * @return string  The code that calls the generated method.
	 * @since  5.1.2
	 */
	public function getCall(): string;

	/**
	 * Build the full `checkInNow()` method code for the given view/table.
	 *
	 * @param  string  $view       The view/table suffix (e.g. 'items').
	 * @param  string  $component  The component name (without 'com_').
	 *
	 * @return string  The full method code as a string.
	 * @since  5.1.2
	 */
	public function getMethod($view, $component): string;
}

