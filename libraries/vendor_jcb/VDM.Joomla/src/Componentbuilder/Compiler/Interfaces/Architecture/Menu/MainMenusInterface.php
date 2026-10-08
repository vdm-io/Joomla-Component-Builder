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

namespace VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\Menu;


/**
 * Menu Main Menus Interface
 * 
 * @since  6.1.7
 */
interface MainMenusInterface
{
	/**
	 * Build the component's administrator main menu.
	 *
	 * @return  string  The menu, or nothing when the component declares no admin views.
	 *
	 * @since   6.1.7
	 */
	public function get(): string;
}

