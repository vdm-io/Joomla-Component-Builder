<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler\Interfaces\Customcode;


/**
 * Customcode Gui Interface
 */
interface GuiInterface
{
	/**
	 * Set the JCB GUI code placeholder
	 *
	 * @param   string  $string  The code string
	 * @param   array   $config  The placeholder config values
	 *
	 * @return  string
	 * @since 3.2.0
	 */
	public function set(string $string, array $config): string;

	/**
	 * search a file for gui code blocks that were updated in the IDE
	 *
	 * @param   string  $file          The file path to search
	 * @param   array   $placeholders  The values to replace in the code being stored
	 * @param   string  $today         The date for today
	 * @param   string  $target        The target path type
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function search(string &$file, array &$placeholders, string &$today, string &$target);
}

