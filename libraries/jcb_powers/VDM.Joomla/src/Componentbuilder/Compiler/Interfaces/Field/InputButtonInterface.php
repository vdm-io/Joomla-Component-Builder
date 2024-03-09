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

namespace VDM\Joomla\Componentbuilder\Compiler\Interfaces\Field;


/**
 * Compiler Field Input Button
 * 
 * @since 3.2.0
 */
interface InputButtonInterface
{
	/**
	 * get Add Button To List Field Input (getInput tweak)
	 *
	 * @param   array  $fieldData  The field custom data
	 *
	 * @return  string of getInput class on success empty string otherwise
	 * @since 3.2.0
	 */
	public function get(array $fieldData): string;
}

