<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    19th August, 2026
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\AdminViews;


use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\AdminViews\BatchOptionsInterface;


/**
 * Admin Views Batch Options Class.
 * 
 * Targets after Joomla 3 build their batch options from the list view itself
 * rather than from a helper, so there is nothing to build here.
 * 
 * @since 6.1.7
 */
final class BatchOptions implements BatchOptionsInterface
{
	/**
	 * Build nothing, which is what these targets ask for.
	 *
	 * @param   string  $nameSingleCode  The single view name.
	 * @param   string  $nameListCode    The list view name.
	 *
	 * @return  string  Nothing.
	 *
	 * @since   6.1.7
	 */
	public function get(&$nameSingleCode, &$nameListCode): string
	{
		return '';
	}
}

