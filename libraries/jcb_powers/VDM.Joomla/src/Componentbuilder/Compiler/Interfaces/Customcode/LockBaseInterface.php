<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler\Interfaces\Customcode;


/**
 * Customcode LockBase Interface
 */
interface LockBaseInterface
{
	/**
	 * Set a string as bsae64 (basic)
	 *
	 * @param   string  $script  The code string
	 *
	 * @return  string
	 * @since 3.2.0
	 */
	public function set(string $script): string;
}

