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

namespace VDM\Joomla\Componentbuilder\Abstraction;


use VDM\Joomla\Componentbuilder\Interfaces\Mappersingleinterface;


/**
 * Compiler Mapper Single
 * 
 * @since 3.2.0
 */
abstract class MapperSingle implements Mappersingleinterface
{

	/**
	 * The Content
	 *
	 * @var    array
	 * @since 3.2.0
	 **/
	public array $active = [];

	/**
	 * Check if any values are set in the active array
	 *
	 * @return  bool  Returns true if the active array is not empty, false otherwise
	 * @since   3.2.0
	 */
	public function isActive(): bool
	{
		return !empty($this->active);
	}

	/**
	 * Set content
	 *
	 * @param   string  $key    The main string key
	 * @param   mixed   $value  The values to set
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function set(string $key, $value)
	{
		$this->active[$this->key($key)] = $value;
	}

	/**
	 * Get content
	 *
	 * @param   string  $key    The main string key
	 *
	 * @return  mixed
	 * @since 3.2.0
	 */
	public function get(string $key)
	{
		return $this->active[$this->key($key)] ?? null;
	}

	/**
	 * Does key exist
	 *
	 * @param   string  $key    The main string key
	 *
	 * @return  bool
	 * @since 3.2.0
	 */
	public function exist(string $key): bool
	{
		if (isset($this->active[$this->key($key)]))
		{
			return true;
		}
		return false;
	}

	/**
	 * Add content
	 *
	 * @param   string  $key    The main string key
	 * @param   mixed   $value  The values to set
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function add(string $key, $value)
	{
		if (isset($this->active[$this->key($key)]))
		{
			$this->active[$this->key($key)] .= $value;
		}
		else
		{
			$this->active[$this->key($key)] = $value;
		}
	}

	/**
	 * Remove content
	 *
	 * @param   string     $key     The main string key
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function remove(string $key)
	{
		unset($this->active[$this->key($key)]);
	}

	/**
	 * Model the key
	 *
	 * @param   string   $key  The key to model
	 *
	 * @return  string
	 * @since 3.2.0
	 */
	abstract protected function key(string $key): string;
}

