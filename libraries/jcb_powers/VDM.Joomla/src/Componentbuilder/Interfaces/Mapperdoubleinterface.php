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
 * The Double Mapper Interface
 */
interface Mapperdoubleinterface
{
	/**
	 * Check if any values are set in the active array.
	 *
	 * @param   string|null  $firstKey  Optional. The first key to check for values.
	 *
	 * @return  bool  True if the active array or the specified subarray is not empty, false otherwise.
	 * @since   3.2.0
	 */
	public function isActive_(string $firstKey = null): bool;

	/**
	 * Set dynamic content
	 *
	 * @param   string    $firstKey    The first key
	 * @param   string    $secondKey   The second key
	 * @param   mixed     $value       The values to set
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function set_(string $firstKey, string $secondKey, $value);

	/**
	 * Get dynamic content
	 *
	 * @param   string    $firstKey     The first key
	 * @param   string    $secondKey    The second key
	 *
	 * @return  mixed
	 * @since 3.2.0
	 */
	public function get_(string $firstKey, ?string $secondKey = null);

	/**
	 * Does keys exist
	 *
	 * @param   string        $firstKey     The first key
	 * @param   string|null   $secondKey    The second key
	 *
	 * @return  bool
	 * @since 3.2.0
	 */
	public function exist_(string $firstKey, ?string $secondKey = null): bool;

	/**
	 * Add dynamic content
	 *
	 * @param   string    $firstKey     The first key
	 * @param   string    $secondKey    The second key
	 * @param   mixed     $value        The values to set
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function add_(string $firstKey, string $secondKey, $value);

	/**
	 * Remove dynamic content
	 *
	 * @param   string         $firstKey     The first key
	 * @param   string|null    $secondKey    The second key
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function remove_(string $firstKey, ?string $secondKey = null);

}

