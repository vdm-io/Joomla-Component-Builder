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


use VDM\Joomla\Componentbuilder\Compiler\Architecture\Model\ItemsMethod as ExtendingItemsMethod;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\Model\ItemsMethodInterface;


/**
 * Model Items Method Class for Joomla 3
 * 
 * Joomla 3 models have no getCurrentUser() and no getDatabase(), so both the
 * user and the database are taken from the global factory.
 * 
 * @since 6.1.7
 */
final class ItemsMethod extends ExtendingItemsMethod implements ItemsMethodInterface
{
	/**
	 * Get the statement that puts the current user in scope.
	 *
	 * @param   int  $indent  The indentation of the generated line.
	 *
	 * @return  string
	 * @since   6.1.7
	 */
	protected function getUserObject(int $indent): string
	{
		return PHP_EOL . Indent::_($indent)
			. "\$user = Joomla__"."_39403062_84fb_46e0_bac4_0023f766e827___Power::getUser();";
	}

	/**
	 * Get the statement that puts the database in scope.
	 *
	 * @param   int  $indent  The indentation of the generated line.
	 *
	 * @return  string
	 * @since   6.1.7
	 */
	protected function getDatabaseObject(int $indent): string
	{
		return PHP_EOL . Indent::_($indent)
			. "\$db = Joomla__"."_39403062_84fb_46e0_bac4_0023f766e827___Power::getDBO();";
	}
}

