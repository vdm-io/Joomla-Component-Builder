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

namespace VDM\Joomla\Componentbuilder\Compiler;


use VDM\Joomla\Componentbuilder\Compiler\Utilities\Placefix;
use VDM\Joomla\Componentbuilder\Interfaces\Mapperdoubleinterface;
use VDM\Joomla\Componentbuilder\Interfaces\Mappersingleinterface;
use VDM\Joomla\Componentbuilder\Abstraction\Mapper;


/**
 * Compiler Content
 * 
 * @since 3.2.0
 */
class Content extends Mapper implements Mapperdoubleinterface, Mappersingleinterface
{
	/**
	 * Model the key
	 *
	 * @param   string   $key  The key to model
	 *
	 * @return  string
	 * @since 3.2.0
	 */
	protected function key(string $key): string
	{
		return Placefix::_h($key);
	}

	/**
	 * Model the first key
	 *
	 * @param   string   $key  The first key to model
	 *
	 * @return  string
	 * @since 3.2.0
	 */
	protected function firstKey(string $key): string
	{
		return $key;
	}

	/**
	 * Model the second key
	 *
	 * @param   string   $key  The second key to model
	 *
	 * @return  string
	 * @since 3.2.0
	 */
	protected function secondKey(string $key): string
	{
		return Placefix::_h($key);
	}
}

