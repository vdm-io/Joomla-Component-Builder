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


use VDM\Joomla\Componentbuilder\Interfaces\Mapperdoubleinterface;
use VDM\Joomla\Componentbuilder\Interfaces\Mappersingleinterface;


/**
 * Compiler Mapper
 * 
 * @since 3.2.0
 */
abstract class Mapper implements Mapperdoubleinterface, Mappersingleinterface
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

	/**
	 * The Dynamic Content
	 *
	 * @var    array
	 * @since 3.2.0
	 **/
	public array $_active = [];

	/**
	 * Check if any values are set in the active array.
	 *
	 * @param   string|null  $firstKey  Optional. The first key to check for values.
	 *
	 * @return  bool  True if the active array or the specified subarray is not empty, false otherwise.
	 * @since   3.2.0
	 */
	public function isActive_(string $firstKey = null): bool
	{
		// If a firstKey is provided, check if it has any values.
		if (is_string($firstKey))
		{
			// Get the first key from the input parameter and check if it exists in the active array.
			$firstKey = $this->firstKey($firstKey);
			if (isset($this->_active[$firstKey]))
			{
				return !empty($this->_active[$firstKey]);
			}
			return false;
		}

		// If no firstKey is provided, check if the entire active array has any values.
		return !empty($this->_active);
	}

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
	public function set_(string $firstKey, string $secondKey, $value)
	{
		$this->_active[$this->firstKey($firstKey)]
			[$this->secondKey($secondKey)] = $value;
	}

	/**
	 * Get dynamic content
	 *
	 * @param   string        $firstKey     The first key
	 * @param   string|null   $secondKey    The second key
	 *
	 * @return  mixed
	 * @since 3.2.0
	 */
	public function get_(string $firstKey, ?string $secondKey = null)
	{
		if (is_string($secondKey))
		{
			return $this->_active[$this->firstKey($firstKey)]
				[$this->secondKey($secondKey)]  ?? null;
		}
		return $this->_active[$this->firstKey($firstKey)] ?? null;
	}

	/**
	 * Does keys exist
	 *
	 * @param   string        $firstKey     The first key
	 * @param   string|null   $secondKey    The second key
	 *
	 * @return  bool
	 * @since 3.2.0
	 */
	public function exist_(string $firstKey, ?string $secondKey = null): bool
	{
		if (is_string($secondKey) && isset($this->_active[$this->firstKey($firstKey)]) &&
			isset($this->_active[$this->firstKey($firstKey)]
				[$this->secondKey($secondKey)]))
		{
			return true;
		}
		elseif (is_null($secondKey) && isset($this->_active[$this->firstKey($firstKey)]))
		{
			return true;
		}
		return false;
	}

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
	public function add_(string $firstKey, string $secondKey, $value)
	{
		if (isset($this->_active[$this->firstKey($firstKey)]) &&
			isset($this->_active[$this->firstKey($firstKey)]
				[$this->secondKey($secondKey)]))
		{
			$this->_active[$this->firstKey($firstKey)]
				[$this->secondKey($secondKey)] .= $value;
		}
		else
		{
			$this->_active[$this->firstKey($firstKey)]
				[$this->secondKey($secondKey)] = $value;
		}
	}

	/**
	 * Remove dynamic content
	 *
	 * @param   string         $firstKey     The first key
	 * @param   string|null    $secondKey    The second key
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function remove_(string $firstKey, ?string $secondKey = null)
	{
		if (is_string($secondKey))
		{
			unset($this->_active[$this->firstKey($firstKey)]
				[$this->secondKey($secondKey)]);
		}
		else
		{
			unset($this->_active[$this->firstKey($firstKey)]);
		}
	}

	/**
	 * Model the first key
	 *
	 * @param   string   $key  The first key to model
	 *
	 * @return  string
	 * @since 3.2.0
	 */
	abstract protected function firstKey(string $key): string;

	/**
	 * Model the second key
	 *
	 * @param   string   $key  The second key to model
	 *
	 * @return  string
	 * @since 3.2.0
	 */
	abstract protected function secondKey(string $key): string;
}

