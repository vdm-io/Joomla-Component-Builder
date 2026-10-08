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

namespace VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\LinkedView;


/**
 * Linked View List Body Interface
 * 
 * @since  6.1.7
 */
interface ListBodyInterface
{
	/**
	 * Get the table body of a linked admin view.
	 *
	 * @param   string  $nameSingleCode  The single view name.
	 * @param   string  $nameListCode    The list view name.
	 * @param   string  $refview         The referring view.
	 *
	 * @return  string  The generated table body.
	 *
	 * @since   6.1.7
	 */
	public function get(string $nameSingleCode, string $nameListCode,
		string $refview): string;
}

