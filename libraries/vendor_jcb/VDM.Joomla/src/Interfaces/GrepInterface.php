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

namespace VDM\Joomla\Interfaces;


/**
 * Global Resource Empowerment Platform
 * 
 * @since 3.2.1
 */
interface GrepInterface
{
	/**
	 * Get all remote powers GUID's
	 *
	 * @return array|null
	 * @since 3.2.0
	 */
	public function getRemotePowersGuid(): ?array;

	/**
	 * Get a power
	 *
	 * @param string   $guid    The global unique id of the power
	 * @param array    $order   The search order
	 *
	 * @return object|null
	 * @since 3.2.0
	 */
	public function get(string $guid, array $order = ['local', 'remote']): ?object;
}

