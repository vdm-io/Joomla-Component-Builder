<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Utilities;


/**
 * Some object tricks
 * 
 * @since  3.0.9
 */
abstract class ObjectHelper
{
	/**
	 * Check if have an object with a length
	 *
	 * @input	object   The object to check
	 *
	 * @returns bool true on success
	 * 
	 * @since  3.0.9
	 */
	public static function check($object)
	{
		if (is_object($object))
		{
			return count((array) $object) > 0;
		}

		return false;
	}

}

