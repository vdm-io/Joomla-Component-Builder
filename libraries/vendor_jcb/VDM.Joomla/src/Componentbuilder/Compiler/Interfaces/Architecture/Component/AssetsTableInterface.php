<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    18th August, 2026
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\Component;


/**
 * Component Assets Table Intelligent Fix Interface
 * 
 * @since  6.1.7
 */
interface AssetsTableInterface
{
	/**
	 * Get the script.php code for the assets table intelligent fix.
	 *
	 * @return  string  The php to place in script.php, or an empty string.
	 *
	 * @since   6.1.7
	 */
	public function install(): string;

	/**
	 * Get the script.php code for the assets table intelligent reversal.
	 *
	 * @return  string  The php to place in script.php, or an empty string.
	 *
	 * @since   6.1.7
	 */
	public function uninstall(): string;
}

