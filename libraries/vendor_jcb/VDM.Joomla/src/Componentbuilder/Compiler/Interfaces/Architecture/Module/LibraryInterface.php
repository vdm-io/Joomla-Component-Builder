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
 * Module Library Interface
 * 
 * @since 5.1.2
 */
interface LibraryInterface
{
	/**
	 * Get the module's library loading code.
	 *
	 * @param   object  $module  The module object
	 *
	 * @return  string The generated code to load libraries into the document.
	 * @since   5.1.2
	 */
	public function get(object $module): string;
}

