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

namespace VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\AdminViews;


/**
 * Admin List View Link Interface
 * 
 * @since  6.1.7
 */
interface ListLinkInterface
{
	/**
	 * Get the custom admin view buttons of a list view.
	 *
	 * @param   string  $nameListCode  The list view code name.
	 * @param   string  $ref           The link referral string.
	 *
	 * @return  string  The generated buttons.
	 *
	 * @since   6.1.7
	 */
	public function getButtons(string $nameListCode, string $ref = ''): string;
}

