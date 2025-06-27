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

namespace VDM\Joomla\Interfaces\Remote\Dependency;


/**
 * Package Dependency Resolver Interfaces
 * 
 * @since 5.1.1
 */
interface ResolverInterface
{
	/**
	 * Inspect an item and extract all the dependencies
	 *
	 * This method inspects the item and loads all dependencies
	 *
	 * @param   object  $item  The data item to inspect.
	 *
	 * @return  array|null  The extracted relationships.
	 * @since   5.1.1
	 */
	public function extract(object $item): ?array;
}

