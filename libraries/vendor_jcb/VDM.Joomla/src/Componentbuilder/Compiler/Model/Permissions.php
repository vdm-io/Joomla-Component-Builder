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

namespace VDM\Joomla\Componentbuilder\Compiler\Model;


use VDM\Joomla\Utilities\JsonHelper;
use VDM\Joomla\Utilities\ArrayHelper;


/**
 * Model Permissions Class
 * 
 * @since 3.2.0
 */
class Permissions
{
	/**
	 * Set the local tabs
	 *
	 * @param   object  $item  The view data
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function set(object &$item)
	{
		$item->addpermissions = (isset($item->addpermissions)
			&& JsonHelper::check($item->addpermissions))
			? json_decode((string) $item->addpermissions, true) : null;

		if (ArrayHelper::check($item->addpermissions))
		{
			$item->permissions = array_values($item->addpermissions);
		}

		unset($item->addpermissions);
	}

}

