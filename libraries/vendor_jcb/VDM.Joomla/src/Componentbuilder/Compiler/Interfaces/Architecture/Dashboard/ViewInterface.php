<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    4th September, 2022
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\Dashboard;


/**
 * Dashboard View Interface
 * 
 * @since 5.1.5
 */
interface ViewInterface
{
	/**
	 * Build the admin dashboard display markup.
	 *
	 * @return string  The compiled dashboard display markup.
	 * @since  5.1.5
	 */
	public function get(): string;
}

