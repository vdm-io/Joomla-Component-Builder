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


use Joomla\Registry\Registry as JoomlaRegistry;
use VDM\Joomla\Utilities\String\ClassfunctionHelper;


/**
 * Config
 * 
 * @since 3.2.0
 */
abstract class BaseConfig extends JoomlaRegistry
{
	/**
	 * Constructor
	 *
	 * @since 3.2.0
	 */
	public function __construct()
	{
		// Instantiate the internal data object.
		$this->data = new \stdClass();
	}

	/**
	 * setting any config value
	 *
	 * @param   string  $key    The value's key/path name
	 * @param  mixed    $value  Optional default value, returned if the internal value is null.
	 *
	 * @since 3.2.0
	 */
	public function __set(string $key, $value)
	{
		$this->set($key, $value);
	}

	/**
	 * getting any valid value
	 *
	 * @param   string       $key     The value's key/path name
	 *
	 * @since 3.2.0
	 * @throws  \InvalidArgumentException If $key is not a valid function name.
	 */
	public function __get(string $key)
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
	public function get($path, $default = null)
	{
		// function name with no underscores
		$method = 'get' . ucfirst((string) ClassfunctionHelper::safe(str_replace('_', '', $path)));

		// check if it has been set
		if (($value = parent::get($path, '__N0T_S3T_Y3T_')) !== '__N0T_S3T_Y3T_')
		{
			return $value;
		}
		elseif (method_exists($this, $method))
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
	 * @return  mixed  The value of the that has been set.
	 *
	 * @since 3.2.0
	 */
	public function appendArray(string $path, $value)
	{
		// check if it does not exist
		if (!$this->exists($path))
		{
			$this->set($path, []);
		}

		return $this->append($path, $value);
	}
}

