<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    19th August, 2026
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaThree\Component;


use VDM\Joomla\Componentbuilder\Compiler\Architecture\Component\MoveFolderMethod as SharedMoveFolderMethod;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;


/**
 * Joomla 3 Component Move Folder Method Class.
 * 
 * A Joomla 3 install script is handed the application and the parent installer
 * rather than the adapter, and reports through the application it was given.
 * 
 * @since  6.1.7
 */
final class MoveFolderMethod extends SharedMoveFolderMethod
{
	/**
	 * The lines the generated method opens with.
	 *
	 * @return  array  The lines.
	 *
	 * @since   6.1.7
	 */
	protected function opening(): array
	{
		$lines = [];
$lines[] = Indent::_(1) . "/**";
$lines[] = Indent::_(1)
	. " * Method to set/copy dynamic folders into place (use with caution)";
$lines[] = Indent::_(1) . " *";
$lines[] = Indent::_(1) . " * @return void";
$lines[] = Indent::_(1) . " */";
$lines[] = Indent::_(1)
	. "protected function setDynamicF0ld3rs(\$app, \$parent)";
$lines[] = Indent::_(1) . "{";
$lines[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
	. " get the installation path";
$lines[] = Indent::_(2) . "\$installer = \$parent->getParent();";

		return $lines;
	}

	/**
	 * The line the generated method reports a failed copy with.
	 *
	 * @return  string  The line.
	 *
	 * @since   6.1.7
	 */
	protected function failureMessage(): string
	{
		return Indent::_(6)
	. "\$app->enqueueMessage('Could not copy '.\$folder.' folder into place, please make sure destination is writable!', 'error');";
	}
}

