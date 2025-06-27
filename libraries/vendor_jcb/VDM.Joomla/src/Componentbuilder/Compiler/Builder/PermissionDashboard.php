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
	 * Get the build permission dashboard code.
	 *
	 * @return string
	 * @since  3.2.0
	 * @since  5.1.1 Changed to class property.
	 */
	public function build(): string
	{
		$indent = Indent::_(1);
		$docBlock = PHP_EOL . $indent . '/**'
			. PHP_EOL . $indent . ' *' . Line::_(__LINE__, __CLASS__) . ' View access array.'
			. PHP_EOL . $indent . ' *'
			. PHP_EOL . $indent . ' * @var   array<string, string>'
			. PHP_EOL . $indent . ' * @since 5.1.1'
			. PHP_EOL . $indent . ' */';

		$value = $this->isActive() ? $this->varExport(null, 1) : '[]';

		return $docBlock . PHP_EOL . $indent . 'protected array $viewAccess = ' . $value . ';' . PHP_EOL;
	}
}

