<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    15th August, 2026
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\ComHelperClass;


/**
 * Component Helper Class Excel Methods Interface
 * 
 * @since  6.1.7
 */
interface ExcelMethodsInterface
{
	/**
	 * Get the helper spreadsheet method code.
	 *
	 * @return  string  The generated helper methods, or an empty string.
	 *
	 * @since   6.1.7
	 */
	public function get(): string;
}

