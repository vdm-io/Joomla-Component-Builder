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


use VDM\Joomla\Componentbuilder\Compiler\Architecture\Component\MoveFolderScript as SharedMoveFolderScript;


/**
 * Joomla 3 Component Move Folder Script Class.
 * 
 * A Joomla 3 install script copies its folders through the method it was given
 * the application and the parent installer for.
 * 
 * @since 6.1.7
 */
final class MoveFolderScript extends SharedMoveFolderScript
{
	/**
	 * The method the generated install script calls, and what it is handed.
	 *
	 * @return  string  The call.
	 *
	 * @since   6.1.7
	 */
	protected function call(): string
	{
		return 'setDynamicF0ld3rs($app, $parent)';
	}
}

