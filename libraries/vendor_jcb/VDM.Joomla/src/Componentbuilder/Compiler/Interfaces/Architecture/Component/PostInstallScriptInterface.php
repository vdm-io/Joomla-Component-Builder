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

namespace VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\Component;


/**
 * Component Post Install Script Interface.
 * 
 * @since 6.1.7
 */
interface PostInstallScriptInterface
{
	/**
	 * Build the post install script of the component.
	 *
	 * @return  string
	 *
	 * @since   6.1.7
	 */
	public function get(): string;
}

