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
 * The Single Mapper Interface
 */
interface Mappersingleinterface
{
	/**
	 * Set content
	 *
	 * @param   string  $key    The main string key
	 * @param   mixed   $value  The values to set
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function set(string $key, $value);

	/**
	 * Get content
	 *
	 * @param   string  $key    The main string key
	 * @param   mixed   $value  The values to set
	 *
	 * @return  mixed
	 * @since 3.2.0
	 */
	public function get(string $key);

	/**
	 * Does key exist
	 *
	 * @param   string  $key    The main string key
	 *
	 * @return  bool
	 * @since 3.2.0
	 */
	public function exist(string $key): bool;

	/**
	 * Add content
	 *
	 * @param   string  $key    The main string key
	 * @param   mixed   $value  The values to set
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function add(string $key, $value);

	/**
	 * Remove content
	 *
	 * @param   string     $key     The main string key
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function remove(string $key);

}

