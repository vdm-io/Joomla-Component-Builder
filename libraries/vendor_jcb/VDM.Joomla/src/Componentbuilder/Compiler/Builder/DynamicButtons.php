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


use VDM\Joomla\Abstraction\Registry\Traits\IsArray;
use VDM\Joomla\Interfaces\Registryinterface;
use VDM\Joomla\Abstraction\Registry;


/**
 * Dynamic Buttons Builder Class
 * 
 * @since 5.1.4
 */
final class DynamicButtons extends Registry implements Registryinterface
{
	/**
	 * Is an Array
	 *
	 * @since 5.1.4
	 */
	use IsArray;

	/**
	 * Base switch to add values as string or array
	 *
	 * @var    boolean
	 * @since  5.1.4
	 **/
	protected bool $addAsArray = true;
}

