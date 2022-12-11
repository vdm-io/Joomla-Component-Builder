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

namespace VDM\Joomla\Componentbuilder\Compiler;


use VDM\Joomla\Componentbuilder\Compiler\Utilities\Placefix;


/**
 * Compiler Content
 * 
 * @since 3.2.0
 */
class Content
{
	/**
	 * The Content
	 *
	 * @var    array
	 * @since 3.2.0
	 **/
	public array $active = [];

	/**
	 * The Dynamic Content
	 *
	 * @var    array
	 * @since 3.2.0
	 **/
	public array $_active = [];

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
		$this->active[Placefix::_h($key)] = $value;
	}

	/**
	 * Get content
	 *
	 * @param   string  $key    The main string key
	 * @param   mixed   $value  The values to set
	 *
	 * @return  mixed
	 * @since 3.2.0
	 */
	public function get(string $key)
	{
		return $this->active[Placefix::_h($key)] ?? null;
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
		if (isset($this->active[Placefix::_h($key)]))
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
		if (isset($this->active[Placefix::_h($key)]))
		{
			$this->active[Placefix::_h($key)] .= $value;
		}
		else
		{
			$this->active[Placefix::_h($key)] = $value;
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
		unset($this->active[Placefix::_h($key)]);
	}

	/**
	 * Set dynamic content
	 *
	 * @param   string    $view    The view key
	 * @param   string    $key     The main string key
	 * @param   mixed     $value   The values to set
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function set_(string $view, string $key, $value)
	{
		$this->_active[$view][Placefix::_h($key)] = $value;
	}

	/**
	 * Get dynamic content
	 *
	 * @param   string         $view  The view key
	 * @param   string|null    $key   The main string key
	 *
	 * @return  mixed
	 * @since 3.2.0
	 */
	public function get_(string $view, ?string $key = null)
	{
		if (is_string($key))
		{
			return $this->_active[$view][Placefix::_h($key)] ?? null;
		}
		return $this->_active[$view] ?? null;
	}

	/**
	 * Does view key exist
	 *
	 * @param   string         $view    The view key
	 * @param   string|null    $key     The main string key
	 *
	 * @return  bool
	 * @since 3.2.0
	 */
	public function exist_(string $view, ?string $key = null): bool
	{
		if (is_string($key) && isset($this->_active[$view]) &&
			isset($this->_active[$view][Placefix::_h($key)]))
		{
			return true;
		}
		elseif (is_null($key) && isset($this->_active[$view]))
		{
			return true;
		}
		return false;
	}

	/**
	 * Add dynamic content
	 *
	 * @param   string    $view    The view key
	 * @param   string    $key     The main string key
	 * @param   mixed     $value   The values to set
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function add_(string $view, string $key, $value)
	{
		if (isset($this->_active[$view]) &&
			isset($this->_active[$view][Placefix::_h($key)]))
		{
			$this->_active[$view][Placefix::_h($key)] .= $value;
		}
		else
		{
			$this->_active[$view][Placefix::_h($key)] = $value;
		}
	}

	/**
	 * Remove dynamic content
	 *
	 * @param   string         $view    The view key
	 * @param   string|null    $key     The main string key
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function remove_(string $view, ?string $key = null)
	{
		if (is_string($key))
		{
			unset($this->_active[$view][Placefix::_h($key)]);
		}
		else
		{
			unset($this->_active[$view]);
		}
	}

}

