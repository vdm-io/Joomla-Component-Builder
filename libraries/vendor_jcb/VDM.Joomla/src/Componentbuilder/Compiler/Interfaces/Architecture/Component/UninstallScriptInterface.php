<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    18th August, 2026
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\Component;


/**
 * Component Uninstall Script Interface
 * 
 * @since  6.1.7
 */
interface UninstallScriptInterface
{
	/**
	 * Get the generated uninstall method body of the script.php.
	 *
	 * @param   array  $uninstallScriptBuilder  The views to remove, keyed by view code name.
	 * @param   array  $uninstallScriptFields   The views that have field relations.
	 *
	 * @return  string  The generated uninstall script.
	 *
	 * @since   6.1.7
	 */
	public function get(array $uninstallScriptBuilder = [], array $uninstallScriptFields = []): string;
}

