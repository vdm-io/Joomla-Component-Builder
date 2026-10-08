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

namespace VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\Controller;


/**
 * Controller Custom Admin Dynamic Button Interface.
 * 
 * @since 6.1.7
 */
interface CustomAdminDynamicButtonInterface
{
	/**
	 * Build the controller methods the dynamic buttons of a view call.
	 *
	 * @param   string  $nameListCode  The list view name.
	 *
	 * @return  string
	 *
	 * @since   6.1.7
	 */
	public function get($nameListCode): string;
}

