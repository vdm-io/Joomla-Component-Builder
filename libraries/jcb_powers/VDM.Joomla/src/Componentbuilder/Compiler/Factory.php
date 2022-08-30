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

namespace VDM\Joomla\Componentbuilder\Compiler;


use Joomla\DI\Container;


/**
 * Compiler Factory
 * 
 * @since 3.2.0
 */
abstract class Factory
{
	/**
	 * Global Compiler Container
	 *
	 * @var     Container
	 * @since 3.2.0
	 **/
	protected static $container = null;

	/**
	 * Current Joomla Version Being Build
	 *
	 * @var     int
	 * @since 3.2.0
	 **/
	protected static $JoomlaVersion;

	/**
	 * Get any class from the compiler container
	 *
	 * @param   string  $key  The container class key
	 *
	 * @return  Mixed
	 * @since 3.2.0
	 */
	public static function _($key)
	{
		return self::getContainer()->get($key);
	}

	/**
	 * Get version specific class from the compiler container
	 *
	 * @param   string  $key  The container class key
	 *
	 * @return  Mixed
	 * @since 3.2.0
	 */
	public static function _J($key)
	{
		if (empty(self::$JoomlaVersion))
		{
			self::$JoomlaVersion = self::getContainer()->get('Config')->joomla_version;
		}

		return self::getContainer()->get('J' . self::$JoomlaVersion . '.' . $key);
	}

	/**
	 * Get a the global compiler container
	 *
	 * @return  Container
	 * @since 3.2.0
	 */
	public static function getContainer(): Container
	{
		if (!self::$container)
		{
			self::$container = self::createContainer();
		}

		return self::$container;
	}

	/**
	 * Create a container object
	 *
	 * @return  Container
	 * @since 3.2.0
	 */
	protected static function createContainer(): Container
	{
		$container = (new Container())
			->registerServiceProvider(new \VDM\Joomla\Componentbuilder\Compiler\Service\Config())
			->registerServiceProvider(new \VDM\Joomla\Componentbuilder\Compiler\Service\Event())
			->registerServiceProvider(new \VDM\Joomla\Componentbuilder\Compiler\Service\Language())
			->registerServiceProvider(new \VDM\Joomla\Componentbuilder\Compiler\Service\Placeholder())
			->registerServiceProvider(new \VDM\Joomla\Componentbuilder\Compiler\Service\Customcode())
			->registerServiceProvider(new \VDM\Joomla\Componentbuilder\Compiler\Service\Power())
			->registerServiceProvider(new \VDM\Joomla\Componentbuilder\Compiler\Service\Component())
			->registerServiceProvider(new \VDM\Joomla\Componentbuilder\Compiler\Service\Extension());

		return $container;
	}


}

