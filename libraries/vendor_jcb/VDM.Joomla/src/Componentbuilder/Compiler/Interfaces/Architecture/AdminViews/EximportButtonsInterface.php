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

namespace VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\AdminViews;


/**
 * Admin Views Eximport Buttons Interface.
 * 
 * @since 6.1.7
 */
interface EximportButtonsInterface
{
	/**
	 * Build the export button of a list view that allows export.
	 *
	 * @param   string  $nameSingleCode  The single view name.
	 * @param   string  $nameListCode    The list view name.
	 *
	 * @return  string
	 *
	 * @since   6.1.7
	 */
	public function export($nameSingleCode, $nameListCode): string;

	/**
	 * Build the import button of a list view that allows import.
	 *
	 * @param   string  $nameSingleCode  The single view name.
	 * @param   string  $nameListCode    The list view name.
	 *
	 * @return  string
	 *
	 * @since   6.1.7
	 */
	public function import($nameSingleCode, $nameListCode): string;
}

