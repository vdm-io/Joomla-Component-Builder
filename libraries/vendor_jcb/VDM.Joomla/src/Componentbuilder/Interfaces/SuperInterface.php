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

namespace VDM\Joomla\Componentbuilder\Interfaces;


/**
 * Superpower of JCB
 * 
 * @since 3.2.0
 */
interface SuperInterface
{
	/**
	 * Init all power not found in database
	 *
	 * @return bool
	 * @since 3.2.0
	 */
	public function init(): bool;

	/**
	 * Reset the powers
	 *
	 * @param array   $powers    The global unique ids of the powers
	 *
	 * @return bool
	 * @since 3.2.0
	 */
	public function reset(array $powers): bool;

	/**
	 * Load a superpower
	 *
	 * @param string   $guid    The global unique id of the power
	 * @param array    $order   The search order
	 * @param string|null   $action  The action to load power
	 *
	 * @return bool
	 * @since 3.2.0
	 */
	public function load(string $guid, array $order = ['remote', 'local'], ?string $action = null): bool;
}

