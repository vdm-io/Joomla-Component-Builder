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

namespace VDM\Joomla\Componentbuilder\Compiler\Interfaces;


/**
 * Extension Files Update Interface
 * 
 * @since 5.1.2
 */
interface ExtensionFilesUpdateInterface
{
	/**
	 * Update all files
	 *
	 * @param string   $bom   The header details [BOM] of the file
	 *
	 * @return  void
	 * @since 5.1.2
	 */
	public function update(string $bom): void;
}

