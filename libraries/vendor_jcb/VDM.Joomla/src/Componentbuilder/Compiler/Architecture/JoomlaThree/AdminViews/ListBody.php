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


use VDM\Joomla\Componentbuilder\Compiler\Architecture\AdminViews\ListBody as ExtendingListBody;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\AdminViews\ListBodyInterface;


/**
 * Admin View List Body Class for Joomla 3
 * 
 * Joomla 3 has no user factory in the container, so the user who has an item
 * checked out is loaded from the global factory by id. It also has no modal
 * admin list view, so the permission tests carry no modal guard.
 * 
 * @since 6.1.7
 */
final class ListBody extends ExtendingListBody implements ListBodyInterface
{
	/**
	 * Get the lookup of the user who has an item checked out.
	 *
	 * @return  string
	 * @since   6.1.7
	 */
	protected function getCheckedOutUser(): string
	{
		return PHP_EOL . Indent::_(2)
			. "\$userChkOut = Joomla__"."_39403062_84fb_46e0_bac4_0023f766e827___Power::getUser(\$item->checked_out);";
	}

	/**
	 * Get the guard the permission tests carry ahead of the action check.
	 *
	 * @return  string
	 * @since   6.1.7
	 */
	protected function getModalGuard(): string
	{
		return '';
	}
}

