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

namespace VDM\Joomla\Interfaces\Remote;


use VDM\Joomla\Interfaces\Remote\BaseInterface;


/**
 * Set data based on global unique ids to remote system
 * 
 * @since 3.2.2
 */
interface SetInterface extends BaseInterface
{
	/**
	 * Save items remotely
	 *
	 * @param array   $guids    The global unique id of the item
	 *
	 * @return bool
	 * @throws \Exception
	 * @since 3.2.2
	 */
	public function items(array $guids): bool;
}

