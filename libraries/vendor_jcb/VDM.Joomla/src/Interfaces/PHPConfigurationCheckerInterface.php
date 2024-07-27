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

namespace VDM\Joomla\Interfaces;


/**
 * PHP Configuration Checker
 * 
 * @since 5.0.2
 */
interface PHPConfigurationCheckerInterface
{
	/**
	 * Check that the required configurations are set for PHP
	 *
	 * @return void
	 * @since  5.0.2
	 **/
	public function run(): void;
}

