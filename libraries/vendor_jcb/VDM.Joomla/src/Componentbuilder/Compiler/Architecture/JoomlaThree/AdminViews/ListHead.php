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


use VDM\Joomla\Componentbuilder\Compiler\Architecture\AdminViews\ListHead as ExtendingListHead;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\AdminViews\ListHeadInterface;


/**
 * Admin List View Head Class for Joomla 3.
 * 
 * @since  6.1.7
 */
final class ListHead extends ExtendingListHead implements ListHeadInterface
{
	/**
	 * Get the generated guard around the sorting and check-all controls.
	 *
	 * Joomla 3 has no modal-layout switch on the list view.
	 *
	 * @return  string  The generated guard.
	 *
	 * @since   6.1.7
	 */
	protected function getSortingGuard(): string
	{
		return "<?php if (\$this->canEdit && \$this->canState): ?>";
	}
}

