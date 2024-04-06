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

namespace VDM\Joomla\Abstraction\Registry\Traits;


/**
 * Check if a value is in an array
 * 
 * @since 3.2.0
 */
trait IsArray
{
	/**
	 * Check if a path is an array
	 *
	 * @param  string  $path    Registry path (e.g. joomla.content.showauthor)
	 *
	 * @return  bool
	 * @since 3.2.0
	 */
	public function isArray(string $path): bool
	{
		// Check base array if no path is given
		if (empty($path))
		{
			return false;
		}

		// get the value
		if (($node = $this->get($path)) !== null
			&& is_array($node))
		{
			return true;
		}

		return false;
	}
}

