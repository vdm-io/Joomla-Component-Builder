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

namespace VDM\Joomla\Componentbuilder\Compiler\Interfaces;


/**
 * The properties an extension should have to be passed to the InstallScript class
 */
interface InstallInterface
{
	/**
	 * The extension official name
	 *
	 * @return     string
	 * @since 3.2.0
	 */
	public function getOfficialName(): string;

	/**
	 * The extension class name
	 *
	 * @return     string
	 * @since 3.2.0
	 */
	public function getClassName(): string;

	/**
	 * The extension installer class name
	 *
	 * @return     string
	 * @since 3.2.0
	 */
	public function getInstallerClassName(): string;
}

