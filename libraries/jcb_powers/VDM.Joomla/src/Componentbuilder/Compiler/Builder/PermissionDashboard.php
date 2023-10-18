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

namespace VDM\Joomla\Componentbuilder\Compiler\Builder;


use VDM\Joomla\Abstraction\Registry\Traits\VarExport;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;
use VDM\Joomla\Interfaces\Registryinterface;
use VDM\Joomla\Abstraction\Registry;


/**
 * Permission Dashboard Builder Class
 * 
 * @since 3.2.0
 */
final class PermissionDashboard extends Registry implements Registryinterface
{
	/**
	 * Constructor.
	 *
	 * @since 3.2.0
	 */
	public function __construct()
	{
		$this->setSeparator('|');
	}

	/**
	 * Var Export Values
	 *
	 * @since 3.2.0
	 */
	use VarExport;

	/**
	 * Get the build permission dashboard code
	 *
	 * @return  string
	 * @since 3.2.0
	 */
	public function build(): string
	{
		if ($this->isActive())
		{
			return PHP_EOL . Indent::_(2) . "//" . Line::_(__Line__, __Class__)
				. " view access array" . PHP_EOL . Indent::_(2)
				. "\$viewAccess = " . $this->varExport() . ';';
		}

		return '';
	}
}

