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
 * To String Values
 * 
 * @since 3.2.0
 */
trait ToString
{
	/**
	 * Convert an array of values to a string (or return string)
	 *
	 * @param  string  $path       Registry path (e.g. joomla.content.showauthor)
	 * @param  string  $seperator  Return string separator
	 *
	 * @return  string
	 * @since 3.2.0
	 */
	public function toString(string $path, string $separator = ''): string
	{
		// Return default value if path is empty
		if (empty($path))
		{
			return '';
		}

		// get the value
		if (($node = $this->get($path)) !== null)
		{
			if (is_array($node) && $node !== [])
			{
				return implode($separator, $node);
			}
			elseif (is_string($node) && strlen((string) $node) > 0)
			{
				return $node;
			}
		}

		return '';
	}
}

