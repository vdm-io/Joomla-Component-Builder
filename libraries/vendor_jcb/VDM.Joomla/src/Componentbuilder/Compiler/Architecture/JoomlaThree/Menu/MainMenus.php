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

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaThree\Menu;


use VDM\Joomla\Componentbuilder\Compiler\Architecture\Menu\MainMenus as SharedMainMenus;


/**
 * Joomla 3 Main Menus Class.
 * 
 * Joomla 3 has no default dashboard for a component to reach, so a component
 * that builds none of its own is given no entry to one.
 * 
 * @since  6.1.7
 */
final class MainMenus extends SharedMainMenus
{
	/**
	 * Build the entry that reaches the default dashboard.
	 *
	 * @param   string  $codeName  The component code name.
	 * @param   string  $lang      The menu language prefix.
	 *
	 * @return  string  Nothing, since there is no default dashboard to reach.
	 *
	 * @since   6.1.7
	 */
	protected function dashboardEntry(string $codeName, string $lang): string
	{
		return '';
	}
}

