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


use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Componentbuilder\Compiler\Factory as Compiler;
use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Placefix;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\PlaceholderInterface;


/**
 * Compiler Placeholder
 * 
 * @since 3.2.0
 */
class Placeholder implements PlaceholderInterface
{
	/**
	 * The active placeholders
	 *
	 * @var    array
	 * @since 3.2.0
	 **/
	public array $active = [];

	/**
	 * Compiler Config
	 *
	 * @var    Config
	 * @since 3.2.0
	 **/
	protected Config $config;

	/**
	 * Constructor.
	 *
	 * @param Config|null   $config    The compiler config object.
	 *
	 * @since 3.2.0
	 */
	public function __construct(?Config $config = null)
	{
		$this->config = $config ?: Compiler::_('Config');
	}

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
	public function set(string $key, $value, bool $hash = true)
	{
		if ($hash)
		{
			$this->set_($key, $value);
			$this->set_h($key, $value);
		}
		else
		{
			$this->active[$key] = $value;
		}
	}

	/**
	 * Get content by key
	 *
	 * @param   string  $key   The main string key
	 *
	 * @return  mixed
	 * @since 3.2.0
	 */
	public function get(string $key)
	{
		return $this->active[$key] ?? $this->get_($key) ?? $this->get_h($key) ?? null;
	}

	/**
	 * Does key exist at all in any variation
	 *
	 * @param   string  $key   The main string key
	 *
	 * @return  bool
	 * @since 3.2.0
	 */
	public function exist(string $key): bool
	{
		return isset($this->active[$key]) || $this->exist_($key) || $this->exist_h($key);
	}

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
	public function add(string $key, $value, bool $hash = true)
	{
		if ($hash)
		{
			$this->add_($key, $value);
			$this->add_h($key, $value);
		}
		elseif (isset($this->active[$key]))
		{
			$this->active[$key] .= $value;
		}
		else
		{
			$this->active[$key] = $value;
		}
	}

	/**
	 * Remove content
	 *
	 * @param   string   $key   The main string key
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function remove(string $key)
	{
		if (isset($this->active[$key]))
		{
			unset($this->active[$key]);
		}
		else
		{
			$this->remove_($key);
			$this->remove_h($key);
		}
	}

	/**
	 * Set content with [ [ [ ... ] ] ] hash
	 *
	 * @param   string  $key    The main string key
	 * @param   mixed   $value  The values to set
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function set_(string $key, $value)
	{
		$this->active[Placefix::_($key)] = $value;
	}

	/**
	 * Get content with [ [ [ ... ] ] ] hash
	 *
	 * @param   string  $key    The main string key
	 *
	 * @return  mixed
	 * @since 3.2.0
	 */
	public function get_(string $key)
	{
		return $this->active[Placefix::_($key)] ?? null;
	}

	/**
	 * Does key exist with [ [ [ ... ] ] ] hash
	 *
	 * @param   string  $key    The main string key
	 *
	 * @return  bool
	 * @since 3.2.0
	 */
	public function exist_(string $key): bool
	{
		return isset($this->active[Placefix::_($key)]);
	}

	/**
	 * Add content with [ [ [ ... ] ] ] hash
	 *
	 * @param   string  $key    The main string key
	 * @param   mixed   $value  The values to set
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function add_(string $key, $value)
	{
		if (isset($this->active[Placefix::_($key)]))
		{
			$this->active[Placefix::_($key)] .= $value;
		}
		else
		{
			$this->active[Placefix::_($key)] = $value;
		}
	}

	/**
	 * Remove content with [ [ [ ... ] ] ] hash
	 *
	 * @param   string     $key     The main string key
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function remove_(string $key)
	{
		if ($this->exist_($key))
		{
			unset($this->active[Placefix::_($key)]);
		}
	}

	/**
	 * Set content with # # # hash
	 *
	 * @param   string  $key    The main string key
	 * @param   mixed   $value  The values to set
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function set_h(string $key, $value)
	{
		$this->active[Placefix::_h($key)] = $value;
	}

	/**
	 * Get content with # # # hash
	 *
	 * @param   string  $key    The main string key
	 *
	 * @return  mixed
	 * @since 3.2.0
	 */
	public function get_h(string $key)
	{
		return $this->active[Placefix::_h($key)] ?? null;
	}

	/**
	 * Does key exist with # # # hash
	 *
	 * @param   string  $key    The main string key
	 *
	 * @return  bool
	 * @since 3.2.0
	 */
	public function exist_h(string $key): bool
	{
		return isset($this->active[Placefix::_h($key)]);
	}

	/**
	 * Add content with # # # hash
	 *
	 * @param   string  $key    The main string key
	 * @param   mixed   $value  The values to set
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function add_h(string $key, $value)
	{
		if ($this->exist_h($key))
		{
			$this->active[Placefix::_h($key)] .= $value;
		}
		else
		{
			$this->active[Placefix::_h($key)] = $value;
		}
	}

	/**
	 * Remove content with # # # hash
	 *
	 * @param   string     $key     The main string key
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function remove_h(string $key)
	{
		if ($this->exist_h($key))
		{
			unset($this->active[Placefix::_h($key)]);
		}
	}

	/**
	 * Set a type of placeholder with set of values
	 *
	 * @param   string  $key     The main string for placeholder key
	 * @param   array   $values  The values to add
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function setType(string $key, array $values)
	{
		// always fist reset the type
		$this->clearType($key);

		// only add if there are values
		if (ArrayHelper::check($values))
		{
			$number = 0;
			foreach ($values as $value)
			{
				$this->set($key . $number, $value);
				$number++;
			}
		}
	}

	/**
	 * Remove a type of placeholder by main key
	 *
	 * @param   string  $key  The main string for placeholder key
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function clearType(string $key)
	{
		$keys = [Placefix::_($key), Placefix::_h($key), $key];

		foreach ($keys as $_key)
		{
			$this->active = array_filter(
				$this->active,
				function (string $k) use ($_key) {
					return preg_replace('/\d/', '', $k) !== $_key;
				},
				ARRAY_FILTER_USE_KEY
			);
		}
	}

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
	public function update(string $data, array &$placeholder, int $action = 1): string
	{
		// make sure the placeholders is an array
		if (!ArrayHelper::check($placeholder))
		{
			return $data;
		}

		// continue with the work of replacement
		if (1 == $action) // <-- just replace (default)
		{
			return str_replace(
				array_keys($placeholder), array_values($placeholder), $data
			);
		}
		elseif (2 == $action) // <-- check if data string has placeholders
		{
			$replace = false;
			foreach (array_keys($placeholder) as $key)
			{
				if (strpos($data, $key) !== false)
				{
					$replace = true;
					break;
				}
			}
			// only replace if the data has these placeholder values
			if ($replace)
			{
				return str_replace(
					array_keys($placeholder), array_values($placeholder), $data
				);
			}
		}
		elseif (3 == $action) // <-- remove placeholders not in data string
		{
			$replace = $placeholder;
			foreach (array_keys($replace) as $key)
			{
				if (strpos($data, $key) === false)
				{
					unset($replace[$key]);
				}
			}
			// only replace if the data has these placeholder values
			if (ArrayHelper::check($replace))
			{
				return str_replace(
					array_keys($replace), array_values($replace), $data
				);
			}
		}

		return $data;
	}

	/**
	 * Update the data with the active placeholders
	 *
	 * @param   string  $data         The actual data
	 *
	 * @return  string
	 * @since 3.2.0
	 */
	public function update_(string $data): string
	{
		// just replace the placeholders in data
		return str_replace(
			array_keys($this->active), array_values($this->active), $data
		);
	}

	/**
	 * return the placeholders for inserted and replaced code
	 *
	 * @param   int         $type  The type of placement
	 * @param   int|null  $id    The code id in the system
	 *
	 * @return  array    with start and end keys
	 * @since 3.2.0
	 */
	public function keys(int $type, ?int $id = null): array
	{
		switch ($type)
		{
			case 11:
				//***[REPLACED$$$$]***//**1**/
				if ($this->config->get('add_placeholders', false) === true)
				{
					return [
						'start' => '/***[REPLACED$$$$]***//**' . $id . '**/',
						'end'   => '/***[/REPLACED$$$$]***/'
					];
				}
				break;
			case 12:
				//***[INSERTED$$$$]***//**1**/
				if ($this->config->get('add_placeholders', false) === true)
				{
					return [
						'start' => '/***[INSERTED$$$$]***//**' . $id . '**/',
						'end'   => '/***[/INSERTED$$$$]***/'
					];
				}
				break;
			case 21:
				//<!--[REPLACED$$$$]--><!--1-->
				if ($this->config->get('add_placeholders', false) === true)
				{
					return [
						'start' => '<!--[REPLACED$$$$]--><!--' . $id . '-->',
						'end'   => '<!--[/REPLACED$$$$]-->'
					];
				}
				break;
			case 22:
				//<!--[INSERTED$$$$]--><!--1-->
				if ($this->config->get('add_placeholders', false) === true)
				{
					return [
						'start' => '<!--[INSERTED$$$$]--><!--' . $id . '-->',
						'end'   => '<!--[/INSERTED$$$$]-->'
					];
				}
				break;
			case 33:
				return ['start' => Placefix::h(), 'end'   => Placefix::h()];
				break;
			case 66:
				return ['start' => Placefix::b(), 'end'   => Placefix::d()];
				break;
		}

		return [ 'start' => "", 'end' => ""];
	}

}

