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

namespace VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\Controller;


/**
 * Controller Allow Edit Interface
 * 
 * @since 3.2.0
 */
interface AllowEditInterface
{
	/**
	 * Get Allow Edit Function Code
	 *
	 * @param string   $nameSingleCode  The single code name of the view.
	 * @param string   $nameListCode    The list code name of the view.
	 *
	 * @since 3.2.0
	 * @return  string   The allow edit method code
	 */
	public function get(string $nameSingleCode, string $nameListCode): string;
}

