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

namespace VDM\Joomla\Componentbuilder\Package;


use VDM\Joomla\Interfaces\Registryinterface;
use VDM\Joomla\Abstraction\Registry;


/**
 * Remote Message Bus
 * 
 * @since 5.1.1
 */
final class MessageBus extends Registry implements Registryinterface
{
	/**
	 * Base switch to add values as string or array
	 *
	 * @var    boolean
	 * @since 5.1.1
	 **/
	protected bool $addAsArray = true;
}

