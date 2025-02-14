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

namespace VDM\Joomla\Abstraction;


use VDM\Joomla\Utilities\String\ClassfunctionHelper;
use VDM\Joomla\Abstraction\Registry;


/**
 * A Dynamic Function Registry
 * 
 * @since 5.0.4
 */
abstract class FunctionRegistry extends Registry
{
	/**
	 * getting any valid value
	 *
	 * @param   string    $key   The value's key/path name
	 *
	 * @since 3.2.0
	 * @throws  \InvalidArgumentException If $key is not a valid function name.
	 */
	public function __get($key)
	{
		// check if it has been set
		if (($value = $this->get($key, '__N0T_S3T_Y3T_')) !== '__N0T_S3T_Y3T_')
		{
			return $value;
		}

		throw new \InvalidArgumentException(sprintf('Argument %s could not be found as function or path.', $key));
	}

	/**
	 * Get a config value.
	 *
	 * @param  string  $path     Registry path (e.g. joomla_content_showauthor)
	 * @param  mixed   $default  Optional default value, returned if the internal value is null.
	 *
	 * @return  mixed  Value of entry or null
	 *
	 * @since 3.2.0
	 */
	public function get(string $path, $default = null): mixed
	{
		// function name with no underscores
		$method = 'get' . ucfirst((string) ClassfunctionHelper::safe(str_replace('_', '', $path)));

		// check if it has been set
		if (($value = parent::get($path, '__N0T_S3T_Y3T_')) !== '__N0T_S3T_Y3T_')
		{
			return $value;
		}
		// Use the method if it's callable and not excluded
		elseif ($this->isCallableMethod($method))
		{
			$value = $this->{$method}($default);

			$this->set($path, $value);

			return $value;
		}

		return $default;
	}

	/**
	 * Append value to a path in registry of an array
	 *
	 * @param  string  $path   Parent registry Path (e.g. joomla.content.showauthor)
	 * @param  mixed   $value  Value of entry
	 *
	 * @return  mixed  The values of the path that has been set.
	 *
	 * @since 3.2.0
	 */
	public function appendArray(string $path, $value)
	{
		return $this->add($path, $value, true)->get($path);
	}

	/**
	 * Determines if a method is callable on this object, excluding certain methods.
	 *
	 * This method checks if a method exists on this object and is callable, but excludes
	 * certain methods to prevent unintended access or recursion. It helps to safely determine
	 * if a dynamic getter method can be invoked without interfering with core methods.
	 *
	 * @param string $method The method name to check.
	 *
	 * @return bool True if the method is callable and not excluded, false otherwise.
	 * @since  5.0.4
	 */
	protected function isCallableMethod(string $method): bool
	{
		// List of methods to exclude from dynamic access
		$excludedMethods = [
			'getActive',
			'get',
			'getSeparator',
			'getIterator',
			'getName',
			'getActiveKeys'
		];

		// Check if the method exists and is not excluded
		if (method_exists($this, $method) && !in_array($method, $excludedMethods, true))
		{
			return true;
		}

		return false;
	}
}

