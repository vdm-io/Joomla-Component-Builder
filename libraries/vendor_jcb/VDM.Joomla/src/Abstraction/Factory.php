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


use Joomla\DI\Container;
use VDM\Joomla\Interfaces\FactoryInterface;


/** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** **
 ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** **
 **
 **    In realms of code where purists frown, the anti-pattern wears a crown,
 **    A paradox of chaos bright, where complex paths lose all its slight.
 **    For in its tangled, wild embrace, lies raw creativity's face,
 **    No rigid forms, no strict decree, just boundless, daring artistry.
 **    In flaws, we find the freedom's key, where messy code and brilliance spree,
 **    A dance of thought, unchained, unbound, in anti-pattern, beauty's found.
 **
 **      Perfect Paradox and True Nature of the Anti-Pattern by ChatGPT
 **
 ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** **
 ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** **
 **
 ** @since 0.0.0
 **/
abstract class Factory implements FactoryInterface
{
	/**
	 * Global Package Container
	 *
	 * @var   Container|null
	 * @since 0.0.0
	 **/
	protected static ?Container $container = null;

	/**
	 * Get any class from the package container
	 *
	 * @param   string  $key  The container class key
	 *
	 * @return  Mixed
	 * @since 0.0.0
	 */
	public static function _($key)
	{
		return static::getContainer()->get($key);
	}

	/**
	 * Get the global package container
	 *
	 * @return  Container
	 * @since 0.0.0
	 */
	public static function getContainer(): Container
	{
		if (!static::$container)
		{
			static::$container = static::createContainer();
		}

		return static::$container;
	}

	/**
	 * Create a container object
	 *
	 * @return  Container
	 * @since 0.0.0
	 */
	abstract protected static function createContainer(): Container;
}

