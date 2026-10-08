<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    18th August, 2026
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaThree\Controller;


use VDM\Joomla\Componentbuilder\Compiler\Architecture\Controller\EximportMethod as ExtendingEximportMethod;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\Controller\EximportMethodInterface;


/**
 * Controller Eximport Method Class for Joomla 3
 * 
 * Joomla 3 has no application identity to ask, so the current user comes from
 * the global factory.
 * 
 * @since 6.1.7
 */
final class EximportMethod extends ExtendingEximportMethod implements EximportMethodInterface
{
	/**
	 * Get the statement that puts the current user in scope.
	 *
	 * @return  string
	 * @since   6.1.7
	 */
	protected function getUserObject(): string
	{
		return Indent::_(2) . "\$user = Joomla__"."_39403062_84fb_46e0_bac4_0023f766e827___Power::getUser();";
	}
}

