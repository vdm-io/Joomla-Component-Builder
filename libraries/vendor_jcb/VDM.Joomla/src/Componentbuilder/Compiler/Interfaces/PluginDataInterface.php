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

namespace VDM\Joomla\Componentbuilder\Compiler\Interfaces;


/**
 * Plug-in Data Interface
 * 
 * @since 5.0.2
 */
interface PluginDataInterface
{
	/**
	 * Get the Joomla Plugin/s
	 *
	 * @param   int|null   $id   the plugin id
	 *
	 * @return  object|array|null    if ID found it returns object, if no ID given it returns all set
	 * @since 3.2.0
	 */
	public function get(int $id = null);

	/**
	 * Check if the Joomla Plugin/s exists
	 *
	 * @param   int|null   $id   the plugin id
	 *
	 * @return  bool    if ID found it returns true, if no ID given it returns true if any are set
	 * @since 3.2.0
	 */
	public function exists(int $id = null): bool;

	/**
	 * Set the Joomla Plugin
	 *
	 * @param   int      $id   the plugin id
	 *
	 * @return  bool    true on success
	 * @since 3.2.0
	 */
	public function set(int $id): bool;
}

