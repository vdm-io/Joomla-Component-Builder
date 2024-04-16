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

namespace VDM\Joomla\Componentbuilder\JoomlaPower\Database;


use VDM\Joomla\Componentbuilder\Interfaces\Database\UpdateInterface;
use VDM\Joomla\Componentbuilder\Power\Database\Update as ExtendingUpdate;


/**
 * Joomla Power Database Update
 * 
 * @since 3.2.0
 */
final class Update extends ExtendingUpdate implements UpdateInterface
{
	/**
	 * Table Name
	 *
	 * @var    string
	 * @since 3.2.1
	 */
	protected string $table = 'joomla_power';
}

