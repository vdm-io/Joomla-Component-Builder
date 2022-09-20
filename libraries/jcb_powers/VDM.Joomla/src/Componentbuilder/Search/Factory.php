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

namespace VDM\Joomla\Componentbuilder\Search;


use Joomla\DI\Container;


/**
 * Search Factory
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
			->registerServiceProvider(new \VDM\Joomla\Componentbuilder\Search\Service\Search())
			->registerServiceProvider(new \VDM\Joomla\Componentbuilder\Search\Service\Model())
			->registerServiceProvider(new \VDM\Joomla\Componentbuilder\Search\Service\Database())
			->registerServiceProvider(new \VDM\Joomla\Componentbuilder\Search\Service\Agent());

		return $container;
	}

}

