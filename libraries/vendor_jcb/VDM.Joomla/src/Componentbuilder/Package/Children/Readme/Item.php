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

namespace VDM\Joomla\Componentbuilder\Package\Children\Readme;


use VDM\Joomla\Interfaces\Readme\ItemInterface;


/**
 * Children Item Readme
 * 
 * @since  5.1.1
 */
final class Item implements ItemInterface
{
	/**
	 * Get an item readme
	 *
	 * @param object  $item  An item details.
	 *
	 * @return string
	 * @since 3.2.2
	 */
	public function get(object $item): string
	{
		return ''; // no readme for children
	}
}

