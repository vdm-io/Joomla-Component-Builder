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


use VDM\Joomla\Interfaces\Remote\GetInterface;
use VDM\Joomla\Componentbuilder\Package\Remote\GetContent;


/**
 * Get Remote File for JCB
 * 
 * @since 5.1.1
 */
final class GetFile extends GetContent implements GetInterface
{
	/**
	 * Check if an file is found locally
	 *
	 * @param  string   $fullPath  The full path to the file
	 *
	 * @return bool
	 * @since  5.1.1
	 */
	protected function isLocal(string $fullPath): bool
	{
		return is_file($fullPath);
	}

	/**
	 * Store the found file locally
	 *
	 * @param  object       $item      The file to store
	 * @param  string|null  $fullPath  The full path to the file
	 *
	 * @return bool
	 * @since  5.1.1
	 */
	protected function store(object $item, ?string $fullPath = null): bool
	{
		return false;
	}
}

