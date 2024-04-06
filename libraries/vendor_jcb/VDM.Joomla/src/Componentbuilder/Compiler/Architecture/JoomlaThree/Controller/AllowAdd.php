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

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaThree\Controller;


use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Creator\Permission;
use VDM\Joomla\Componentbuilder\Compiler\Customcode\Dispenser;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\Controller\AllowAddInterface;


/**
 * Controller Allow Add Class for Joomla 3
 * 
 * @since 3.2.0
 */
final class AllowAdd implements AllowAddInterface
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
	 * The Dispenser Class.
	 *
	 * @var   Dispenser
	 * @since 3.2.0
	 */
	protected Dispenser $dispenser;

	/**
	 * Constructor.
	 *
	 * @param Config       $config       The Config Class.
	 * @param Permission   $permission   The Permission Class.
	 * @param Dispenser    $dispenser    The Dispenser Class.
	 *
	 * @since 3.2.0
	 */
	public function __construct(Config $config, Permission $permission,
		Dispenser $dispenser)
	{
		$this->component = $config->component_code_name;
		$this->permission = $permission;
		$this->dispenser = $dispenser;
	}

	/**
	 * Get Allow Add Function Code
	 *
	 * @param string   $nameSingleCode  The single code name of the view.
	 *
	 * @since 3.2.0
	 * @return  string   The allow add method code
	 */
	public function get(string $nameSingleCode): string
	{
		$allow = [];

		// prepare custom permission script
		$custom_allow = $this->dispenser->get(
			'php_allowadd', $nameSingleCode, '', null, true
		);

		$allow[] = PHP_EOL . Indent::_(2) . "//" . Line::_(__Line__, __Class__)
			. " Get user object.";
		$allow[] = Indent::_(2) . "\$user = Factory::getUser();";
		// check if the item has permissions.
		if ($this->permission->globalExist($nameSingleCode, 'core.access'))
		{
			$allow[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
				. " Access check.";
			$allow[] = Indent::_(2) . "\$access = \$user->authorise('"
				. $this->permission->getGlobal($nameSingleCode, 'core.access')
				. "', 'com_" . $this->component . "');";
			$allow[] = Indent::_(2) . "if (!\$access)";
			$allow[] = Indent::_(2) . "{";
			$allow[] = Indent::_(3) . "return false;";
			$allow[] = Indent::_(2) . "}";
		}

		// load custom permission script
		$allow[] = $custom_allow;

		// check if the item has permissions.
		if ($this->permission->globalExist($nameSingleCode, 'core.create'))
		{
			// setup the default script
			$allow[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
				. " In the absence of better information, revert to the component permissions.";
			$allow[] = Indent::_(2) . "return \$user->authorise('"
				. $this->permission->getGlobal($nameSingleCode, 'core.create')
				. "', \$this->option);";
		}
		else
		{
			// setup the default script
			$allow[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
				. " In the absence of better information, revert to the component permissions.";
			$allow[] = Indent::_(2) . "return parent::allowAdd(\$data);";
		}

		return implode(PHP_EOL, $allow);
	}
}

