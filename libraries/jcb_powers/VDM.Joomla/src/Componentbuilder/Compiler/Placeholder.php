<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    3rd September, 2022
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler;


use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Utilities\GetHelper;
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
				$this->active[Placefix::_($key . $number)]
					= $value;
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
		$key = Placefix::_($key);

		$this->active = array_filter(
			$this->active,
			function(string $k) use($key){
				return preg_replace('/\d/', '', $k) !== $key;
			},
			ARRAY_FILTER_USE_KEY
		);
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
			// This is an error, TODO actually we need to add a kind of log here to know that this happened
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
			foreach ($placeholder as $key => $val)
			{
				if (strpos($data, $key) !== false)
				{
					$replace = true;
					break;
				}
			}
			// only replace if the data has these placeholder values
			if ($replace === true)
			{

				return str_replace(
					array_keys($placeholder), array_values($placeholder), $data
				);
			}
		}
		elseif (3 == $action) // <-- remove placeholders not in data string
		{
			$replace = $placeholder;
			foreach ($replace as $key => $val)
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

