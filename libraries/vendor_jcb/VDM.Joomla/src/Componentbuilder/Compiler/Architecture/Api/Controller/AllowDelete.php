<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    1st September, 2026
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\Api\Controller;


use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Creator\Permission;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;


/**
 * Api Controller Allow Delete Class.
 * 
 * Builds the allowDelete method of the item API controller the way the
 * admin allowAdd is built: the component level delete permission of the
 * view, behind its access permission when it has one. The record level
 * delete permission stays in the model's canDelete.
 * 
 * @since 6.1.7
 */
final class AllowDelete
{
	/**
	 * The Component code name.
	 *
	 * @var   string
	 * @since 6.1.7
	 */
	protected string $component;

	/**
	 * The Permission Class.
	 *
	 * @var   Permission
	 * @since 6.1.7
	 */
	protected Permission $permission;

	/**
	 * Constructor.
	 *
	 * @param Config       $config       The Config Class.
	 * @param Permission   $permission   The Permission Class.
	 *
	 * @since 6.1.7
	 */
	public function __construct(Config $config, Permission $permission)
	{
		$this->component = $config->component_code_name;
		$this->permission = $permission;
	}

	/**
	 * Get the allow delete code of the item API controller.
	 *
	 * @param   string  $nameSingleCode  The single code name of the view.
	 *
	 * @return  string  The allow delete method body.
	 * @since   6.1.7
	 */
	public function get(string $nameSingleCode): string
	{
		$allow = [];

		$allow[] = PHP_EOL . Indent::_(2) . "//" . Line::_(__LINE__, __CLASS__)
			. " Get user object.";
		$allow[] = Indent::_(2) . "\$user = \$this->app->getIdentity();";

		// check if the item has permissions.
		if ($this->permission->globalExist($nameSingleCode, 'core.access'))
		{
			$allow[] = Indent::_(2) . "//" . Line::_(__LINE__, __CLASS__)
				. " Access check.";
			$allow[] = Indent::_(2) . "\$access = \$user->authorise('"
				. $this->permission->getGlobal($nameSingleCode, 'core.access')
				. "', 'com_" . $this->component . "');";
			$allow[] = Indent::_(2) . "if (!\$access)";
			$allow[] = Indent::_(2) . "{";
			$allow[] = Indent::_(3) . "return false;";
			$allow[] = Indent::_(2) . "}";
		}

		$allow[] = Indent::_(2) . "//" . Line::_(__LINE__, __CLASS__)
			. " In the absence of better information, revert to the component permissions.";
		$allow[] = Indent::_(2) . "return \$user->authorise('"
			. $this->permission->getGlobal($nameSingleCode, 'core.delete')
			. "', \$this->option);";

		return implode(PHP_EOL, $allow);
	}
}

