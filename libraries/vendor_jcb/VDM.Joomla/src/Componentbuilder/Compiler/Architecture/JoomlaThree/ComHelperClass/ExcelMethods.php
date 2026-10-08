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

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaThree\ComHelperClass;


use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\ComHelperClass\ExcelMethods as ExtendingExcelMethods;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\ComHelperClass\ExcelMethodsInterface;


/**
 * Component Helper Class Excel Methods Class for Joomla 3.
 * 
 * @since  6.1.7
 */
final class ExcelMethods extends ExtendingExcelMethods implements ExcelMethodsInterface
{
	/**
	 * Get the generated user-lookup lines of the `xls()` method.
	 *
	 * Joomla 3 resolves the active user through the Joomla Factory.
	 *
	 * @return  array<int, string>  The generated user-lookup lines.
	 *
	 * @since   6.1.7
	 */
	protected function getUserLines(): array
	{
		return [
			Indent::_(2) . "\$user = Joomla__" . "_39403062_84fb_46e0_bac4_0023f766e827___Power::getUser();",
		];
	}
}

