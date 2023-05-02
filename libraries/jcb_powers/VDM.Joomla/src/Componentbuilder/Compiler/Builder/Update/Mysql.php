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

namespace VDM\Joomla\Componentbuilder\Compiler\Builder\Update;


use VDM\Joomla\Componentbuilder\Interfaces\Mappersingleinterface;
use VDM\Joomla\Componentbuilder\Abstraction\MapperSingle;


/**
 * Compiler Builder Update Mysql
 * 
 * @since 3.2.0
 */
class Mysql extends MapperSingle implements Mappersingleinterface
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
		return preg_replace('/\s+/', '', $key);
	}

}

