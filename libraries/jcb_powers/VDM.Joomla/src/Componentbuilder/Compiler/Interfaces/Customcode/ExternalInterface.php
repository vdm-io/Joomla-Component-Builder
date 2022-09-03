<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler\Interfaces\Customcode;


/**
 * Customcode External Interface
 */
interface ExternalInterface
{
	/**
	 * Set the external code string & load it in to string
	 *
	 * @param   string  $string  The content to check
	 * @param   int     $debug   The switch to debug the update
	 *
	 * @return  string
	 * @since 3.2.0
	 */
	public function set(string $string, int $debug = 0): string;
}

