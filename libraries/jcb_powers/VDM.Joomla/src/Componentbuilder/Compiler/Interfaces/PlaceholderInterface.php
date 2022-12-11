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
 * Compiler Placeholder Interface
 * 
 * @since 3.2.0
 */
interface PlaceholderInterface
{
	/**
	 * Set content
	 *
	 * @param   string  $key      The main string key
	 * @param   mixed   $value    The values to set
	 * @param   bool    $hash     Add the hash around the key
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function set(string $key, $value, bool $hash = true);

	/**
	 * Get content by key
	 *
	 * @param   string  $key   The main string key
	 *
	 * @return  mixed
	 * @since 3.2.0
	 */
	public function get(string $key);

	/**
	 * Does key exist at all in any variation
	 *
	 * @param   string  $key   The main string key
	 *
	 * @return  bool
	 * @since 3.2.0
	 */
	public function exist(string $key): bool;

	/**
	 * Add content
	 *
	 * @param   string  $key       The main string key
	 * @param   mixed   $value     The values to set
	 * @param   bool    $hash      Add the hash around the key
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function add(string $key, $value, bool $hash = true);

	/**
	 * Remove content
	 *
	 * @param   string   $key   The main string key
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function remove(string $key);

	/**
	 * Set content with [ [ [ ... ] ] ] hash
	 *
	 * @param   string  $key    The main string key
	 * @param   mixed   $value  The values to set
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function set_(string $key, $value);

	/**
	 * Get content with [ [ [ ... ] ] ] hash
	 *
	 * @param   string  $key    The main string key
	 *
	 * @return  mixed
	 * @since 3.2.0
	 */
	public function get_(string $key);

	/**
	 * Does key exist with [ [ [ ... ] ] ] hash
	 *
	 * @param   string  $key    The main string key
	 *
	 * @return  bool
	 * @since 3.2.0
	 */
	public function exist_(string $key): bool;

	/**
	 * Add content with [ [ [ ... ] ] ] hash
	 *
	 * @param   string  $key    The main string key
	 * @param   mixed   $value  The values to set
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function add_(string $key, $value);

	/**
	 * Remove content with [ [ [ ... ] ] ] hash
	 *
	 * @param   string     $key     The main string key
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function remove_(string $key);

	/**
	 * Set content with # # # hash
	 *
	 * @param   string  $key    The main string key
	 * @param   mixed   $value  The values to set
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function set_h(string $key, $value);

	/**
	 * Get content with # # # hash
	 *
	 * @param   string  $key    The main string key
	 *
	 * @return  mixed
	 * @since 3.2.0
	 */
	public function get_h(string $key);

	/**
	 * Does key exist with # # # hash
	 *
	 * @param   string  $key    The main string key
	 *
	 * @return  bool
	 * @since 3.2.0
	 */
	public function exist_h(string $key): bool;

	/**
	 * Add content with # # # hash
	 *
	 * @param   string  $key    The main string key
	 * @param   mixed   $value  The values to set
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function add_h(string $key, $value);

	/**
	 * Remove content with # # # hash
	 *
	 * @param   string     $key     The main string key
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function remove_h(string $key);

	/**
	 * Set a type of placeholder with set of values
	 *
	 * @param   string  $key     The main string for placeholder key
	 * @param   array   $values  The values to add
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function setType(string $key, array $values);

	/**
	 * Remove a type of placeholder by main key
	 *
	 * @param   string  $key  The main string for placeholder key
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function clearType(string $key);

	/**
	 * Update the data with the placeholders
	 *
	 * @param   string  $data         The actual data
	 * @param   array   $placeholder  The placeholders
	 * @param   int     $action       The action to use
	 *
	 * THE ACTION OPTIONS ARE
	 * 1 -> Just replace (default)
	 * 2 -> Check if data string has placeholders
	 * 3 -> Remove placeholders not in data string
	 *
	 * @return  string
	 * @since 3.2.0
	 */
	public function update(string $data, array &$placeholder, int $action = 1): string;

	/**
	 * Update the data with the active placeholders
	 *
	 * @param   string  $data         The actual data
	 *
	 * @return  string
	 * @since 3.2.0
	 */
	public function update_(string $data): string;

	/**
	 * return the placeholders for inserted and replaced code
	 *
	 * @param   int         $type  The type of placement
	 * @param   int|null  $id    The code id in the system
	 *
	 * @return  array    with start and end keys
	 * @since 3.2.0
	 */
	public function keys(int $type, ?int $id = null): array;

}

