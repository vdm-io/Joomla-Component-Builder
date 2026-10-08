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


use VDM\Joomla\Componentbuilder\Compiler\Architecture\Model\ItemSave as ExtendingItemSave;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\Model\ItemSaveInterface;


/**
 * Model Item Save Class for Joomla 3
 * 
 * Joomla 3 has no application identity, so a permission check reaches the
 * current user through the global factory.
 * 
 * @since 6.1.7
 */
final class ItemSave extends ExtendingItemSave implements ItemSaveInterface
{
	/**
	 * Get the permission check of one guarded json item.
	 *
	 * @param   string  $view               The single view code name.
	 * @param   string  $permission_option  The permission action.
	 * @param   string  $jsonItem           The guarded item.
	 * @param   string  $component          The component code name.
	 *
	 * @return  string
	 * @since   6.1.7
	 */
	protected function getAuthoriseCheck($view, $permission_option, $jsonItem, $component): string
	{
		return PHP_EOL . Indent::_(3)
			. "&& Joomla__"."_39403062_84fb_46e0_bac4_0023f766e827___Power::getUser()->authorise('" . $view
			. "." . $permission_option . "." . $jsonItem
			. "', 'com_" . $component . "')";
	}
}

