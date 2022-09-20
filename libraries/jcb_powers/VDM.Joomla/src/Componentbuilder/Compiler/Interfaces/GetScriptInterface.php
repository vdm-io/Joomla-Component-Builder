<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    3rd September, 2022
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler\Interfaces;


/**
 * The functions a get script should have
 * 
 * @since 3.2.0
 */
interface GetScriptInterface
{
	/**
	 * get code to use
	 *
	 * @param   Object       $code     The code object
	 *
	 * @return  string
	 * @since 3.2.0
	 */
	public function get(object $extension): string;
}

