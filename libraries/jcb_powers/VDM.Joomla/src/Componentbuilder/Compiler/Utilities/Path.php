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

namespace VDM\Joomla\Componentbuilder\Compiler\Utilities;


use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\StringHelper;


/**
 * Compiler Path Fix
 * 
 * @since 3.2.0
 */
abstract class Path
{
	/**
	 * Fix the path to work in the JCB script <-- (main issue here)
	 *	Since we need / slash in all paths, for the JCB script even if it is Windows
	 *	and since MS works with both forward and back slashes
	 *	we just convert all slashes to forward slashes
	 * 
	 * THIS is just my hack (fix) if you know a better way! speak-up!
	 * 
	 * @param   mixed  $values   the array of paths or the path as a string
	 * @param   array  $targets  paths to target
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public static function fix(&$values, $targets = array())
	{
		// if multiple to gets searched and fixed
		if (ArrayHelper::check($values) && ArrayHelper::check($targets))
		{
			foreach ($targets as $target)
			{
				if (isset($values[$target]) && strpos($values[$target], '\\') !== false)
				{
					$values[$target] = str_replace('\\', '/', $values[$target]);
				}
			}
		}
		// if just a string
		elseif (StringHelper::check($values) && strpos($values, '\\') !== false)
		{
			$values = str_replace('\\', '/', $values);
		}
	}

}

