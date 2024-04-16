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

namespace VDM\Joomla\Componentbuilder\Compiler\Interfaces\Power;


/**
 * Compiler Power Injector
 * @since 3.2.1
 */
interface InjectorInterface
{
	/**
	 * Inject the powers found in the code
	 *
	 * @param string   $code The class code
	 *
	 * @return string   The updated code
	 * @since 3.2.0
	 */
	public function power(string $code): string;
}

