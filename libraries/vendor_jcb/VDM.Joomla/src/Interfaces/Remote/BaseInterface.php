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


use VDM\Joomla\Interfaces\Remote\ConfigInterface;


/**
 * Base remote interface
 * 
 * @since 5.1.1
 */
interface BaseInterface extends ConfigInterface
{
	/**
	 * Map a single item to its properties
	 *
	 * @param object $item The item to be mapped
	 *
	 * @return object
	 * @since 3.2.2
	 */
	public function mapItem(object $item): object;

	/**
	 * Get index values
	 *
	 * @param object  $item  The item
	 *
	 * @return array|null
	 * @since  3.2.2
	 */
	public function getIndexItem(object $item): ?array;
}

