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

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaThree\AdminViews;


use VDM\Joomla\Componentbuilder\Compiler\Architecture\AdminViews\FilterFieldHelper as ExtendingFilterFieldHelper;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\AdminViews\FilterFieldHelperInterface;


/**
 * Admin View Filter Field Helper Class for Joomla 3
 * 
 * Joomla 3 has no database driver or user factory in the container, so both
 * are taken from the global factory.
 * 
 * @since 6.1.7
 */
final class FilterFieldHelper extends ExtendingFilterFieldHelper implements FilterFieldHelperInterface
{
	/**
	 * Get the statement that opens a database connection.
	 *
	 * @return  string
	 * @since   6.1.7
	 */
	protected function getDatabaseObject(): string
	{
		return Indent::_(2) . "\$db = Joomla__"."_39403062_84fb_46e0_bac4_0023f766e827___Power::getDbo();";
	}

	/**
	 * Get the lines that add one user filter option and its name.
	 *
	 * @param   string  $code  The filter field code name.
	 *
	 * @return  array<string>
	 * @since   6.1.7
	 */
	protected function getUserNameOption(string $code): array
	{
		return [
			Indent::_(4)
				. "\$_filter[] = Html::_('select.option', \$"
				. $code . ", Joomla__"."_39403062_84fb_46e0_bac4_0023f766e827___Power::getUser(\$"
				. $code . ")->name);",
		];
	}
}

