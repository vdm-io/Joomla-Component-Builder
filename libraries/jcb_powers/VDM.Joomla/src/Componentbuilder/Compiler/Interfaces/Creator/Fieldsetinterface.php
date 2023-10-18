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

namespace VDM\Joomla\Componentbuilder\Compiler\Interfaces\Creator;


/**
 * Fieldset Creator Interface (needed for the container)
 * 
 * @since 3.2.0
 */
interface Fieldsetinterface
{
	/**
	 * Get a fieldset
	 *
	 * @param   array   $view            The view data
	 * @param   string  $component       The component name
	 * @param   string  $nameSingleCode  The single view name
	 * @param   string  $nameListCode    The list view name
	 *
	 * @return  string The fields set as a string
	 * @since 3.2.0
	 */
	public function get(array $view, string $component, string $nameSingleCode, string $nameListCode): string;
}

