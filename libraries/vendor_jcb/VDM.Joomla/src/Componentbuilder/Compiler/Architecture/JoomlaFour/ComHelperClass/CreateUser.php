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

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaFour\ComHelperClass;


use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\ComHelperClass\CreateUserInterface;


/**
 * Helper Class Create User Class for Joomla 4
 * 
 * @since 5.0.2
 */
final class CreateUser implements CreateUserInterface
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
	public function get($add): string
	{
		if ($add)
		{
			$method   = [];
			$method[] = PHP_EOL . PHP_EOL . Indent::_(1) . "/**";
			$method[] = Indent::_(1) . " * Save user details by either creating a new user or updating an existing user.";
			$method[] = Indent::_(1) . " *";
			$method[] = Indent::_(1)
				. " * @param   array  \$credentials  ['name' => string, 'username' => string, 'email' => string, 'password' => string, 'password2' => string]";
			$method[] = Indent::_(1) . " * @param   int    \$autologin";
			$method[] = Indent::_(1)
				. " * @param   array  \$params  ['useractivation' => int, 'sendpassword' => int, 'allowUserRegistration' => int]";
			$method[] = Indent::_(1)
				. " * @param   array  \$mode 1 = Site Registrations; 0 = Admin Registration; 2 = Custom Helper Method Called registerUser";
			$method[] = Indent::_(1) . " *";
			$method[] = Indent::_(1) . " * @return  int  User ID on success";
			$method[] = Indent::_(1) . " *";
			$method[] = Indent::_(1) . " * @throws  \InvalidArgumentException  If required credentials are missing.";
			$method[] = Indent::_(1) . " * @throws  \RuntimeException          If the user update or creation fails.";
			$method[] = Indent::_(1) . " * @throws  Super__"."_1c10a5f1_204d_4f17_ad9f_0e0684f2030d___Power     If the user is not found.";
			$method[] = Indent::_(1) . " *";
			$method[] = Indent::_(1) . " * @since   3.0.0";
			$method[] = Indent::_(1) . " * @deprecated 4.3 Use Super__"."_7832a726_87b6_4e95_887e_7b725d3fab8f___Power::create(\$credentials, \$autologin, \$params,  \$mode);";
			$method[] = Indent::_(1) . " */";
			$method[] = Indent::_(1)
				. "public static function createUser(\$credentials, \$autologin = 0,";
			$method[] = Indent::_(2) . "\$params = [";
			$method[] = Indent::_(3)
				. "'useractivation' => 0, 'sendpassword' => 1";
			$method[] = Indent::_(2) . "], \$mode = 1";
			$method[] = Indent::_(1) . ")";
			$method[] = Indent::_(1) . "{";
			$method[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
				. " Create a user with the UserHelper class";
			$method[] = Indent::_(2)
				. "return Super__"."_7832a726_87b6_4e95_887e_7b725d3fab8f___Power::create(\$credentials, \$autologin, \$params,  \$mode);";
			$method[] = Indent::_(1) . "}";

			$method[] = PHP_EOL . PHP_EOL . Indent::_(1) . "/**";
			$method[] = Indent::_(1) . " * Update the given component params.";
			$method[] = Indent::_(1) . " *";
			$method[] = Indent::_(1) . " * @param string|null \$option The optional extension element name.";
			$method[] = Indent::_(1) . " * @param string      \$target The parameter name to be updated.";
			$method[] = Indent::_(1) . " * @param mixed       \$value  The value to set for the parameter.";
			$method[] = Indent::_(1) . " *";
			$method[] = Indent::_(1) . " * @since   3.0.0";
			$method[] = Indent::_(1) . " * @deprecated 4.3 Use Super__"."_640b5352_fb09_425f_a26e_cd44eda03f15___Power::setParams(\$target, \$value, \$option);";
			$method[] = Indent::_(1) . " */";
			$method[] = PHP_EOL . Indent::_(1)
				. "public static function setParams(\$option, \$target, \$value)";
			$method[] = Indent::_(1) . "{";
			$method[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
				. " Sets a parameter value for the given target in the specified option's params";
			$method[] = Indent::_(2)
				. "return Super__"."_640b5352_fb09_425f_a26e_cd44eda03f15___Power::setParams(\$target, \$value, \$option);";
			$method[] = Indent::_(1) . "}";

			$method[] = PHP_EOL . Indent::_(1) . "/**";
			$method[] = Indent::_(1) . " * Update user details";
			$method[] = Indent::_(1) . " *";
			$method[] = Indent::_(1) . " * @param   array  \$userDetails  Array containing user details to be updated";
			$method[] = Indent::_(1) . " *";
			$method[] = Indent::_(1) . " * @return  int   Updated user ID on success.";
			$method[] = Indent::_(1) . " *";
			$method[] = Indent::_(1) . " * @throws  \RuntimeException  If user update fails.";
			$method[] = Indent::_(1) . " *";
			$method[] = Indent::_(1) . " * @since   3.0.0";
			$method[] = Indent::_(1) . " * @deprecated 4.3 Use Super__"."_7832a726_87b6_4e95_887e_7b725d3fab8f___Power::update(\$userDetails);";
			$method[] = Indent::_(1) . " */";
			$method[] = Indent::_(1)
				. "public static function updateUser(\$userDetails): int";
			$method[] = Indent::_(1) . "{";
			$method[] = Indent::_(2)
				. "//" . Line::_(__Line__, __Class__)
				. " Update user details with the UserHelper class";
			$method[] = Indent::_(2) . "return Super__"."_7832a726_87b6_4e95_887e_7b725d3fab8f___Power::update(\$userDetails);";
			$method[] = Indent::_(1) . "}";

			// return the help method
			return implode(PHP_EOL, $method);
		}

		return '';
	}
}

