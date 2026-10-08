<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    17th August, 2026
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\AdminView;


/**
 * Admin Edit View Body Interface
 * 
 * @since  6.1.7
 */
interface EditBodyInterface
{
	/**
	 * Get the edit view body of an admin view.
	 *
	 * @param   array  $view  The view definition with its settings object.
	 *
	 * @return  string  The generated edit body, empty when the view has no layout.
	 *
	 * @since   6.1.7
	 */
	public function get(array &$view): string;
}

