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
 * Model Items Method Interface.
 * 
 * @since 6.1.7
 */
interface ItemsMethodInterface
{
	/**
	 * Build the getItems or getExportData method of a list model.
	 *
	 * @param   string  $nameSingleCode  The single view code name.
	 * @param   string  $nameListCode    The list view code name.
	 * @param   array   $config          The details that adapt the method being built.
	 *
	 * @return  string
	 *
	 * @since   6.1.7
	 */
	public function get(&$nameSingleCode, &$nameListCode, $config = array());
}

