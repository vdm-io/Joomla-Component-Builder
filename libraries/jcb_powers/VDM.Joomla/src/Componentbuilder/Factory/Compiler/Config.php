<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Factory\Compiler;


use Joomla\CMS\Factory;
use Joomla\Registry\Registry;
use VDM\Joomla\Componentbuilder\Compiler\Config as CompilerConfig;
use VDM\Joomla\Utilities\ArrayHelper;


/**
 * Factory to load the compiler config
 */
abstract class Config
{
	/**
	 * Global Config object
	 *
	 * @var     CompilerConfig
	 * @since   3.1.6
	 **/
	protected static $CompilerConfig = null;

	/**
	 * Get a value.
	 *
	 * @param   string  $path     Registry path (e.g. version)
	 * @param   mixed   $default  Optional default value, returned if the internal value is null.
	 *
	 * @return  mixed  Value of entry or null
	 *
	 * @since   3.1.6
	 */
	public static function get(string $path, $default = null)
	{
		// check that if we already have config registry set
		if (!self::$CompilerConfig)
		{
			// create config registry
			self::$CompilerConfig = self::create();
		}

		// return the value or default if none is found
		return self::$CompilerConfig->get($path, $default);
	}

	/**
	 * Check if a registry path exists.
	 *
	 * @param   string  $path  Registry path (e.g. guid.main.0.path)
	 *
	 * @return  boolean
	 *
	 * @since   3.1.6
	 */
	public static function exists($path)
	{
		// check that if we already have config registry set
		if (!self::$CompilerConfig)
		{
			// create config registry
			self::$CompilerConfig = self::create();
		}

		// check if exists
		return self::$CompilerConfig->exists($path);
	}

	/**
	 * Method to extract a sub-registry from path
	 *
	 * @param   string  $path  Registry path (e.g. guid.main)
	 *
	 * @return  Registry  Registry object (empty if no data is present)
	 *
	 * @since   3.1.6
	 */
	public function extract($path)
	{
		if (!self::exists($path))
		{
			// create config registry
			return new Registry();
		}

		return self::$CompilerConfig->extract($path);
	}

	/**
	 * Gets this object represented as an ArrayIterator.
	 *
	 * This allows the data properties to be accessed via a foreach statement.
	 *
	 * @return  \ArrayIterator  This object represented as an ArrayIterator.
	 *
	 * @see     IteratorAggregate::getIterator()
	 * @since   3.1.6
	 */
	#[\ReturnTypeWillChange]
	public static function getIterator()
	{
		// check that if we already have config registry set
		if (!self::$CompilerConfig)
		{
			// create config registry
			self::$CompilerConfig = self::create();
		}

		return self::$CompilerConfig->getIterator();
	}

	/**
	 * Set a registry value.
	 *
	 * @param   string  $path       Registry Path (e.g. guid.main.0.url)
	 * @param   mixed   $value      Value of entry
	 * @param   string  $separator  The key separator
	 *
	 * @return  mixed  The value of the that has been set.
	 *
	 * @since   3.1.6
	 */
	public static function set($path, $value, $separator = null)
	{
		// check that if we already have config registry set
		if (!self::$CompilerConfig)
		{
			// create config registry
			self::$CompilerConfig = self::create();
		}

		self::$CompilerConfig->set($path, $value, $separator);
	}

	/**
	 * Delete a registry value
	 *
	 * @param   string  $path  Registry Path (e.g. guid.main.0.url)
	 *
	 * @return  mixed  The value of the removed node or null if not set
	 *
	 * @since   3.1.6
	 */
	public static function remove($path)
	{
		// check that if we already have config registry set
		if (!self::$CompilerConfig)
		{
			// create config registry
			self::$CompilerConfig = self::create();
		}

		// remove the actual value
		return self::$CompilerConfig->remove($path);
	}

	/**
	 * Transforms a namespace to an array
	 *
	 * @return  array  An associative array holding the namespace data
	 *
	 * @since   3.1.6
	 */
	public static function toArray()
	{
		// check that if we already have config registry set
		if (!self::$CompilerConfig)
		{
			// create config registry
			self::$CompilerConfig = self::create();
		}

		return self::$CompilerConfig->toArray();
	}

	/**
	 * Transforms a namespace to an object
	 *
	 * @return  object   An an object holding the namespace data
	 *
	 * @since   3.1.6
	 */
	public static function toObject()
	{
		// check that if we already have config registry set
		if (!self::$CompilerConfig)
		{
			// create config registry
			self::$CompilerConfig = self::create();
		}

		return self::$CompilerConfig->toObject();
	}

	/**
	 * Initialize a CompilerConfig object if id does not exist.
	 *
	 * Returns the global {@link CompilerConfig} object, only creating it if it doesn't already exist.
	 *
	 * @param   array    $config     The data to bind to the new Config object.
	 *
	 *
	 * @return  CompilerConfig object
	 *
	 * @see     Session
	 * @since   3.1.6
	 **/
	public static function init($config = null): CompilerConfig
	{
		if (!self::$CompilerConfig)
		{
			self::$CompilerConfig = self::create($config);
		}

		return self::$CompilerConfig;
	}

	/**
	 * Create a CompilerConfig object
	 *
	 * @param   array    $config     The data to bind to the new Config object.
	 *
	 * @return  CompilerConfig object
	 * @since   3.1.6
	 * @throws  \Exception
	 **/
	protected static function create($config = null): CompilerConfig
	{
		// get the session
		$session = Factory::getSession();

		// check if we have config
		if (ArrayHelper::check($config))
		{
			// save for later should we call this out of scope
			$session->set('Componentbuilder.Compiler.Config', $config);
		}
		// if not found try loading it from the session
		elseif (($config = $session->get('Componentbuilder.Compiler.Config', false)) === false)
		{
			throw new \Exception('Compiler configuration not found.');
		}

		return new CompilerConfig($config);
	}
}

