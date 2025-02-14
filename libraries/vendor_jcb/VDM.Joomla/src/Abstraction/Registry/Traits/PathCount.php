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
 * Count Values in a Path
 * 
 * @since 3.2.0
 * @since 5.0.2 name changed to PathCount to avoid collusion in core registry class
 */
trait PathCount
{
	/**
	 * Retrieves number of values (or sub-array) from the storage using multiple keys.
	 *
	 * @param  string  $path     Storage path (e.g. vdm.content.builder)
	 *
	 * @throws \InvalidArgumentException If any of the path values are not a number or string.
	 * @return int    The number of values
	 * @since 3.2.0
	 */
	public function pathCount(string $path): int
	{
		if (($values = $this->get($path)) === null)
		{
			return 0;
		}

		if (is_array($values))
		{
			return count($values);
		}

		if (is_object($values))
		{
			return count((array) $values);
		}

		return 1;
	}
}

