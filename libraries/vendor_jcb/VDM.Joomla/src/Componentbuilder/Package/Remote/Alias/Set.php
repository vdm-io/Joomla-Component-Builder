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

namespace VDM\Joomla\Componentbuilder\Package\Remote\Alias;


use VDM\Joomla\Interfaces\Remote\SetInterface;
use VDM\Joomla\Componentbuilder\Remote\Set as ExtendingSet;


/**
 * Set Layout/Template based on function names to remote repository
 * 
 * @since 5.1.4
 */
final class Set extends ExtendingSet implements SetInterface
{
	/**
	 * Get the item alias for the index values
	 *
	 * @param object $item
	 *
	 * @return string
	 * @since  5.1.4
	 */
	protected function index_map_Alias(object $item): string
	{
		return $item->alias ?? 'error';
	}
}

