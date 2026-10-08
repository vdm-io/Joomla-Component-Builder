<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    17th August, 2026
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\Model;


/**
 * Model Items String Fix Interface
 * 
 * @since  6.1.7
 */
interface ItemsStringFixInterface
{
	/**
	 * Get the item fixes of a list model.
	 *
	 * @param   string  $nameSingleCode  The single view code name.
	 * @param   string  $nameListCode    The list view code name.
	 * @param   string  $Component       The component code name.
	 * @param   string  $tab             Extra indentation of the generated lines.
	 * @param   bool    $export          Build for an export rather than a list.
	 * @param   bool    $all             Include every field, not only listed ones.
	 *
	 * @return  string  The generated fixes.
	 *
	 * @since   6.1.7
	 */
	public function get($nameSingleCode, $nameListCode,
		$Component, $tab = '', $export = false, $all = false);
}

