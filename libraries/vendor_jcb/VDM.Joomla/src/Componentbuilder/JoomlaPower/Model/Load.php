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

namespace VDM\Joomla\Componentbuilder\JoomlaPower\Model;


use VDM\Joomla\Interfaces\ModelInterface;
use VDM\Joomla\Componentbuilder\Power\Model\Load as ExtendingLoad;


/**
 * Joomla Power Model Load
 * 
 * @since 3.2.0
 */
final class Load extends ExtendingLoad implements ModelInterface
{
	/**
	 * Get the current active table
	 *
	 * @return  string
	 * @since 3.2.0
	 */
	protected function getTable(): string
	{
		return 'joomla_power';
	}
}

