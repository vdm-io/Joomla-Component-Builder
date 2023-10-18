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
trait InArray
{
	/**
	 * Check if a value is found in an array
	 *
	 * @param  mixed $value  The value to check for
	 * @param  string|null  $path    Registry path (e.g. joomla.content.showauthor)
	 *
	 * @return  bool
	 * @since 3.2.0
	 */
	public function inArray($value, ?string $path = null): bool
	{
		// Check base array if no path is given
		if (empty($path))
		{
			return in_array($value, $this->active);
		}

		// get the value
		if (($node = $this->get($path)) !== null
			&& is_array($node)
			&& in_array($value, $node))
		{
			return true;
		}

		return false;
	}
}

