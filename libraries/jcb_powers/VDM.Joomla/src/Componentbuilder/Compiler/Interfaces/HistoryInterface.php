<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    3rd September, 2022
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler\Interfaces;


/**
 * Compiler History Interface
 * 
 * @since 3.2.0
 */
interface HistoryInterface
{
	/**
	 * Get Item History object
	 *
	 * @param   string  $type  The type of item
	 * @param   int     $id    The item ID
	 *
	 * @return  ?object    The history item object
	 * @since 3.2.0
	 */
	public function get(string $type, int $id): ?object;

}

