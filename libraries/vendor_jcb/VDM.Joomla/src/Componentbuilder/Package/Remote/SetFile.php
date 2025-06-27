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

namespace VDM\Joomla\Componentbuilder\Package\Remote;


use VDM\Joomla\Utilities\FileHelper;
use VDM\Joomla\Interfaces\Remote\SetInterface;
use VDM\Joomla\Componentbuilder\Package\Remote\SetContent;


/**
 * Set file on remote repository
 * 
 * @since 5.1.1
 */
class SetFile extends SetContent implements SetInterface
{
	/**
	 * Get the file content
	 *
	 * @param  string   $fullPath  The full path to the file
	 * @param  string   $guid        The folder key/guid
	 *
	 * @return string|null
	 * @since  5.1.1
	 */
	protected function getContent(string $fullPath, string $guid): ?string
	{
		return FileHelper::getContent($fullPath, null);
	}
}

