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

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaThree\Model;


use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Creator\Permission;
use VDM\Joomla\Componentbuilder\Compiler\Customcode\Dispenser;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\Model\AllowEditInterface;


/**
 * Model Allow Edit Class for Joomla 3
 * 
 * @since 5.1.4
 */
final class AllowEdit implements AllowEditInterface
{
	/**
	 * The Config Class.
	 *
	 * @var   Config
	 * @since 5.1.4
	 */
	protected Config $config;

	/**
	 * The Permission Class.
	 *
	 * @var   Permission
	 * @since 5.1.4
	 */
	protected Permission $permission;

	/**
	 * The Dispenser Class.
	 *
	 * @var   Dispenser
	 * @since 5.1.4
	 */
	protected Dispenser $dispenser;

	/**
	 * Constructor.
	 *
	 * @param Config       $config       The Config Class.
	 * @param Permission   $permission   The Permission Class.
	 * @param Dispenser    $dispenser    The Dispenser Class.
	 *
	 * @since 5.1.4
	 */
	public function __construct(Config $config, Permission $permission,
		Dispenser $dispenser)
	{
		$this->config = $config;
		$this->permission = $permission;
		$this->dispenser = $dispenser;
	}

	/**
	 * Get Allow Edit Function Code
	 *
	 * @param string   $nameSingleCode  The single code name of the view.
	 * @param string   $nameListCode  The list code name of the view.
	 *
	 * @since   5.1.4
	 * @return  string   The can edit state method code
	 */
	public function get(string $nameSingleCode, string $nameListCode): string
	{
		$allow = [];

		// set component name
		$component = $this->config->component_code_name;

		// prepare custom permission script
		$customAllow = $this->dispenser->get(
			'php_allowedit', $nameSingleCode, Indent::_(2)
			. "\$recordId = (int) isset(\$data[\$key]) ? \$data[\$key] : 0;"
			. PHP_EOL
		);

		// check if the item has permissions.
		if ($this->permission->actionExist($nameSingleCode, 'core.edit'))
		{
			$allow[] = PHP_EOL . Indent::_(2) . "//" . Line::_(__Line__, __Class__)
				. " Check specific edit permission then general edit permission.";
			$allow[] = Indent::_(2) . "\$user = Joomla__"."_39403062_84fb_46e0_bac4_0023f766e827___Power::getUser();";

			// load custom permission script
			$allow[] = $customAllow;
			$allow[] = Indent::_(2) . "return \$user->authorise('"
				. $this->permission->getAction($nameSingleCode, 'core.edit') . "', 'com_" . $component . "." . $nameSingleCode
				. ".'. ((int) isset(\$data[\$key]) ? \$data[\$key] : 0)) or \$user->authorise('"
				. $this->permission->getAction($nameSingleCode, 'core.edit') . "',  'com_" . $component . "');";
		}
		else
		{
			$allow[] = PHP_EOL . Indent::_(2) . "//" . Line::_(__Line__, __Class__)
				. " Check specific edit permission then general edit permission.";
			$allow[] = Indent::_(2) . "\$user = Joomla__"."_39403062_84fb_46e0_bac4_0023f766e827___Power::getUser();";

			// load custom permission script
			$allow[] = $customAllow;
			$allow[] = Indent::_(2)
				. "return \$user->authorise('core.edit', 'com_"
				. $component . "." . $nameSingleCode
				. ".'. ((int) isset(\$data[\$key]) ? \$data[\$key] : 0));";
		}

		return implode(PHP_EOL, $allow);
	}
}

