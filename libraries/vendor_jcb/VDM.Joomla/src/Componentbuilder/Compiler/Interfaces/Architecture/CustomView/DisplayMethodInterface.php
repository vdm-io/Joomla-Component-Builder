<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    16th August, 2026
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\CustomView;


/**
 * Custom View Display Method Interface
 * 
 * @since  6.1.7
 */
interface DisplayMethodInterface
{
	/**
	 * Get the site or custom admin view display method code.
	 *
	 * @param   array  $view  The view definition, mutated when custom display
	 *                        PHP is exploded into lines.
	 *
	 * @return  string  The PHP to place in the view display method.
	 *
	 * @since   6.1.7
	 */
	public function get(array &$view): string;
}

