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

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaThree\LinkedView;


use VDM\Joomla\Componentbuilder\Compiler\Architecture\LinkedView\ListQuery as ExtendingListQuery;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\LinkedView\ListQueryInterface;


/**
 * Linked View List Query Class for Joomla 3
 * 
 * Joomla 3 has no application identity and no model database accessor, so
 * both the user and the database come from the global factory.
 * 
 * @since 6.1.7
 */
final class ListQuery extends ExtendingListQuery implements ListQueryInterface
{
	/**
	 * Get the statement that puts the user object in scope.
	 *
	 * @return  string
	 * @since   6.1.7
	 */
	protected function getUserObject(): string
	{
		return PHP_EOL . Indent::_(2)
			. "\$user = Joomla__"."_39403062_84fb_46e0_bac4_0023f766e827___Power::getUser();";
	}

	/**
	 * Get the statement that puts the database object in scope.
	 *
	 * @return  string
	 * @since   6.1.7
	 */
	protected function getDatabaseObject(): string
	{
		return PHP_EOL . Indent::_(2)
			. "\$db = Joomla__"."_39403062_84fb_46e0_bac4_0023f766e827___Power::getDBO();";
	}
}

