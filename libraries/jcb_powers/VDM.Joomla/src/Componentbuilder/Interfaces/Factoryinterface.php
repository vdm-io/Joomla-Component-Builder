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

namespace VDM\Joomla\Componentbuilder\Interfaces;


use Joomla\DI\Container;


/**
 * The Basic Factory Interface
 */
interface Factoryinterface
{
	/**
	 * Get any class from the compiler container
	 *
	 * @param   string  $key  The container class key
	 *
	 * @return  Mixed
	 * @since 3.2.0
	 */
	public static function _(string $key);

	/**
	 * Get a the global compiler container
	 *
	 * @return  Container
	 * @since 3.2.0
	 */
	public static function getContainer(): Container;

}

