<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    4th September, 2020
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Utilities;


use Joomla\CMS\Factory;
use Joomla\CMS\Session\Session;


/**
 * Simple Session
 * 
 * @since  5.0.2
 */
abstract class SessionHelper
{
	/**
	 * The active session
	 *
	 * @var Session|null
	 * @since 5.0.2
	 */
	private static ?Session $session = null;

	/**
	 * Get the active session
	 *
	 * @return Session
	 * @throws \RuntimeException if the session cannot be loaded
	 * @since 5.0.2
	 */
	public static function session(): Session
	{
		if (static::$session === null)
		{
			try {
				static::$session = Factory::getApplication()->getSession();
			} catch (\Exception $e) {
				// Rethrow the exception as a RuntimeException to propagate it downstream
				throw new \RuntimeException('Unable to load the session.', 0, $e);
			}
		}

		return static::$session;
	}

	/**
	 * Get data from the session store
	 *
	 * @param string $name     Name of a variable
	 * @param mixed  $default  Default value of a variable if not set
	 *
	 * @return mixed Value of the variable from the session
	 * @since 5.0.2
	 */
	public static function get(string $name, $default = null)
	{
		$value = static::session()->get($name, $default);

		// Ensure the value is set in the session even if it was default
		static::set($name, $value);

		return $value;
	}

	/**
	 * Set data into the session store
	 *
	 * @param string $name   Name of a variable
	 * @param mixed  $value  Value of a variable
	 *
	 * @return mixed Old value of the variable
	 * @since 5.0.2
	 */
	public static function set(string $name, $value = null)
	{
		return static::session()->set($name, $value);
	}
}

