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

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaFive\Model;


use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Creator\Permission;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\Model\CanDeleteInterface;


/**
 * Model Can Delete Class for Joomla 5
 * 
 * @since 3.2.0
 */
final class CanDelete implements CanDeleteInterface
{
	/**
	 * The Component code name.
	 *
	 * @var   String
	 * @since 3.2.0
	 */
	protected String $component;

	/**
	 * The Permission Class.
	 *
	 * @var   Permission
	 * @since 3.2.0
	 */
	protected Permission $permission;

	/**
	 * Constructor.
	 *
	 * @param Config       $config       The Config Class.
	 * @param Permission   $permission   The Permission Class.
	 *
	 * @since 3.2.0
	 */
	public function __construct(Config $config, Permission $permission)
	{
		$this->component = $config->component_code_name;
		$this->permission = $permission;
	}

	/**
	 * Get Can Delete Function Code
	 *
	 * @param string   $nameSingleCode  The single code name of the view.
	 *
	 * @since 3.2.0
	 * @return  string   The can delete method code
	 */
	public function get(string $nameSingleCode): string
	{
		$allow = [];

		// setup the default script
		$allow[] = PHP_EOL . Indent::_(2) . "if (empty(\$record->id) || (\$record->published != -2))";
		$allow[] = Indent::_(2) . "{";
		$allow[] = Indent::_(3) . "return false;";
		$allow[] = Indent::_(2) . "}" . PHP_EOL;

		// check if the item has permissions.
		$allow[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
			. " The record has been set. Check the record permissions.";
		$allow[] = Indent::_(2) . "return \$this->getCurrentUser()->authorise('"
			. $this->permission->getAction($nameSingleCode, 'core.delete') . "', 'com_" . $this->component . "."
			. $nameSingleCode . ".' . (int) \$record->id);";

		return implode(PHP_EOL, $allow);
	}
}

