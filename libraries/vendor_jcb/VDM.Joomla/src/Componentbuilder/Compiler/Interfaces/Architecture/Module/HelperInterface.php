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

namespace VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\Module;


/**
 * Module Helper Code Interface
 * 
 * @since 5.1.2
 */
interface HelperInterface
{
	/**
	 * Get Module Helper Class code
	 *
	 * @param  object  $module  The module object
	 *
	 * @return string  The helper class code
	 * @since  5.1.2
	 */
	public function get(object $module): string;

	/**
	 * Get Module Helper Header code
	 *
	 * @param  object  $module  The module object
	 *
	 * @return string  The helper header code
	 * @since  5.1.2
	 */
	public function header(object $module): string;
}

