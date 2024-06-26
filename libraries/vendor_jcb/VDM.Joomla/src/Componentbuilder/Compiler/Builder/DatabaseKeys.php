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

namespace VDM\Joomla\Componentbuilder\Compiler\Builder;


use VDM\Joomla\Interfaces\Registryinterface;
use VDM\Joomla\Abstraction\Registry;


/**
 * Database Keys Builder Class
 * 
 * @since 3.2.0
 */
final class DatabaseKeys extends Registry implements Registryinterface
{
	/**
	 * Base switch to add values as string or array
	 *
	 * @var    boolean
	 * @since 3.2.0
	 **/
	protected bool $addAsArray = true;

	/**
	 * Base switch to keep array values unique
	 *
	 * @var    boolean
	 * @since 3.2.2
	 **/
	protected bool $uniqueArray = true;
}

