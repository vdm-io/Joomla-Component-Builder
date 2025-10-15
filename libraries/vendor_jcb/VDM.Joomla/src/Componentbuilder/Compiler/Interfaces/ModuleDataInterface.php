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
 * Module Data Interface
 * 
 * @since 5.1.2
 */
interface ModuleDataInterface
{
	/**
	 * Get the Joomla Module/s
	 *
	 * @param   int|string|null   $module   The module id/guid
	 *
	 * @return  object|array|null    if ID|GUID found it returns object, if no ID|GUID given it returns all set
	 * @since 3.2.0
	 */
	public function get($module = null);

	/**
	 * Check if the Joomla Module/s exists
	 *
	 * @param   int|string|null   $module   The module id|guid
	 *
	 * @return  bool    if ID|GUID found it returns true, if no ID|GUID given it returns true if any are set
	 * @since 3.2.0
	 */
	public function exists($module = null): bool;

	/**
	 * Set the module
	 *
	 * @param   mixed  $module  The module ID/GUID
	 *
	 * @return  bool    true on success
	 * @since   5.0.4
	 */
	public function set($module): bool;
}

