<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    19th August, 2026
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaThree\Controller;


use VDM\Joomla\Componentbuilder\Compiler\Architecture\Controller\CustomAdminDynamicButton as SharedCustomAdminDynamicButton;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;


/**
 * Joomla 3 Controller Custom Admin Dynamic Button Class.
 * 
 * A Joomla 3 controller asks the factory for the user directly, there being no
 * application identity to read it from.
 * 
 * @since  6.1.7
 */
final class CustomAdminDynamicButton extends SharedCustomAdminDynamicButton
{
	/**
	 * The statement that reaches the user the button was pressed by.
	 *
	 * @return  string  The statement.
	 *
	 * @since   6.1.7
	 */
	protected function currentUser(): string
	{
		return Indent::_(2) . "\$user = Joomla__"."_39403062_84fb_46e0_bac4_0023f766e827___Power::getUser();";
	}
}

