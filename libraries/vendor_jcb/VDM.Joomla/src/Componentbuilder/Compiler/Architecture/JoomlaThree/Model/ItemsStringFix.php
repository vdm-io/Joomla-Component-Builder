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

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaThree\Model;


use VDM\Joomla\Componentbuilder\Compiler\Architecture\Model\ItemsStringFix as ExtendingItemsStringFix;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\Model\ItemsStringFixInterface;


/**
 * Model Items String Fix Class for Joomla 3
 * 
 * Joomla 3 models have no getCurrentUser(), so the user comes from the
 * global factory instead.
 * 
 * @since 6.1.7
 */
final class ItemsStringFix extends ExtendingItemsStringFix implements ItemsStringFixInterface
{
	/**
	 * Get the statement that puts the current user in scope.
	 *
	 * @param   string  $tab  Extra indentation of the generated line.
	 *
	 * @return  string
	 * @since   6.1.7
	 */
	protected function getCurrentUser($tab): string
	{
		return PHP_EOL . Indent::_(1) . $tab . Indent::_(3)
			. "\$user = Joomla__"."_39403062_84fb_46e0_bac4_0023f766e827___Power::getUser();";
	}
}

