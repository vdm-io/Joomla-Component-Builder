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
 * Is String Values
 * 
 * @since 3.2.0
 */
trait IsString
{
	/**
	 * Check if a registry path exists and is a string
	 *
	 * @param  string  $path  Registry path (e.g. joomla.content.showauthor)
	 *
	 * @return  boolean
	 * @since 3.2.0
	 */
	public function isString(string $path): bool
	{
		// Return default value if path is empty
		if (empty($path)) {
			return false;
		}

		// get the value
		if (($node = $this->get($path)) !== null
			&& is_string($node)
			&& strlen((string) $node) > 0)
		{
			return true;
		}

		return false;
	}
}

