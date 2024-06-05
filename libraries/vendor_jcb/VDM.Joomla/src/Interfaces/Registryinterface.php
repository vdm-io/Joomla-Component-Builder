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


use VDM\Joomla\Interfaces\Activeregistryinterface;


/**
 * The Registry Interface
 * 
 * @since 3.2.0
 */
interface Registryinterface extends Activeregistryinterface
{
	/**
	 * Sets a value into the registry using multiple keys.
	 *
	 * @param  string  $path      Registry path (e.g. vdm.content.builder)
	 * @param  mixed   $value     Value of entry
	 *
	 * @throws \InvalidArgumentException If any of the path values are not a number or string.
	 * @return $this
	 * @since 3.2.0
	 */
	public function set(string $path, $value): static;

	/**
	 * Adds content into the registry. If a key exists,
	 * it either appends or concatenates based on $asArray switch.
	 *
	 * @param  string      $path      Registry path (e.g. vdm.content.builder)
	 * @param  mixed       $value     Value of entry
	 * @param  bool|null   $asArray   Determines if the new value should be treated as an array.
	 *                                Default is $addAsArray = false (if null) in base class.
	 *                                Override in child class allowed set class property $addAsArray = true.
	 *
	 * @throws \InvalidArgumentException If any of the path values are not a number or string.
	 * @return $this
	 * @since 3.2.0
	 */
	public function add(string $path, $value, ?bool $asArray = null): static;

	/**
	 * Retrieves a value (or sub-array) from the registry using multiple keys.
	 *
	 * @param  string  $path     Registry path (e.g. vdm.content.builder)
	 * @param  mixed   $default  Optional default value, returned if the internal doesn't exist.
	 *
	 * @throws \InvalidArgumentException If any of the path values are not a number or string.
	 * @return mixed The value or sub-array from the storage. Null if the location doesn't exist.
	 * @since 3.2.0
	 */
	public function get(string $path, $default = null);

	/**
	 * Removes a value (or sub-array) from the registry using multiple keys.
	 *
	 * @param  string  $path  Registry path (e.g. vdm.content.builder)
	 *
	 * @throws \InvalidArgumentException If any of the path values are not a number or string.
	 * @return $this
	 * @since 3.2.0
	 */
	public function remove(string $path): static;

	/**
	 * Checks the existence of a particular location in the registry using multiple keys.
	 *
	 * @param  string  $path  Registry path (e.g. vdm.content.builder)
	 *
	 * @throws \InvalidArgumentException If any of the path values are not a number or string.
	 * @return bool True if the location exists, false otherwise.
	 * @since 3.2.0
	 */
	public function exists(string $path): bool;

	/**
	 * Sets a separator value
	 *
	 * @param string|null   $value     The value to set.
	 *
	 * @return $this
	 * @since 3.2.0
	 */
	public function setSeparator(?string $value): static;
}

