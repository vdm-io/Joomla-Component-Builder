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
 * Module Dispatcher Interface
 * 
 * @since 5.1.2
 */
interface DispatcherInterface
{
	/**
	 * Get the updated placeholder content for the given module.
	 *
	 * @param  object  $module   The module object containing the necessary data.
	 *
	 * @return string  The updated placeholder content.
	 * @since 5.1.2
	 */
	public function get(object $module): string;
}

