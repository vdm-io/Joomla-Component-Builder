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

namespace VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\ComHelperClass;


/**
 * Component Helper Class Create User Interface
 * 
 * @since 5.0.2
 */
interface CreateUserInterface
{
	/**
	 * Generates the method definition for creating or updating a user based on the provided parameters.
	 *
	 * This method returns a string representation of a PHP function that includes various 
	 * steps for handling user creation and updates, depending on the mode (site registration or admin registration).
	 * 
	 * @param   $add    Determines whether to generate the user creation method or not.
	 *                      If true, the method will be generated and returned as a string.
	 *
	 * @return  string  The generated method code as a string if $add is true. 
	 *                  Returns an empty string if $add is false.
	 */
	public function get($add): string;
}

