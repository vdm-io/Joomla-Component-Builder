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

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaThree\AdminViews;


use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\AdminViews\DisplayMethod as ExtendingDisplayMethod;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\AdminViews\DisplayMethodInterface;


/**
 * Admin List View Display Method Class for Joomla 3.
 * 
 * @since  6.1.7
 */
final class DisplayMethod extends ExtendingDisplayMethod implements DisplayMethodInterface
{
	/**
	 * Get the generated filter-form retrieval lines.
	 *
	 * Joomla 3 reads the filter form and active filters through the view's
	 * own get() proxy rather than the search-tools model methods.
	 *
	 * @return  string  The generated filter-form lines.
	 *
	 * @since   6.1.7
	 */
	protected function getFilterForm(): string
	{
		$script = PHP_EOL . Indent::_(2) . "//"
			. Line::_(
				__LINE__,__CLASS__
			) . " Load the filter form from xml.";
		$script .= PHP_EOL . Indent::_(2) . "\$this->filterForm "
			. "= \$this->get('FilterForm');";
		$script .= PHP_EOL . Indent::_(2) . "//"
			. Line::_(
				__LINE__,__CLASS__
			) . " Load the active filters.";
		$script .= PHP_EOL . Indent::_(2) . "\$this->activeFilters "
			. "= \$this->get('ActiveFilters');";

		return $script;
	}
}

