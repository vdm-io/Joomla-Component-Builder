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


use VDM\Joomla\Abstraction\Registry;


/**
 * Compiler Builder Update Mysql
 * 
 * @since 3.2.0
 */
class UpdateMysql extends Registry
{
	/**
	 * Get that the active keys from a path
	 *
	 * @param string  $path   The path to determine the location.
	 *
	 * @return array|null      The valid array of keys
	 * @since 3.2.0
	 */
	protected function getActiveKeys(string $path): ?array
	{
		if (!empty($path))
		{
			return [preg_replace('/\s+/', '', $path)];
		}

		return null;
	}
}

