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

namespace VDM\Joomla\Componentbuilder;


/**
 * Add line comment
 * 
 * @since 3.1.5
 */
trait Line
{
	/**
	 * Set the line number in comments
	 *
	 * @param   int  $nr  The line number
	 *
	 * @return  string
	 * @since 3.1.5
	 */
	private function setLine(int $nr): string
	{
		if ($this->debug)
		{
			return ' [' . get_called_class() . ' ' . $nr . ']';
		}

		return '';
	}
}

