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
 * Admin View Footable Scripts Interface
 * 
 * @since  6.1.7
 */
interface FootableScriptsInterface
{
	/**
	 * Get the Footable assets of a view.
	 *
	 * @param   bool  $init  Whether to also emit the initialisation script.
	 *
	 * @return  string  The generated asset loader.
	 *
	 * @since   6.1.7
	 */
	public function get(bool $init = true): string;
}

