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
 * Schema Checker Interface
 * 
 * @since 3.2.2
 */
interface SchemaCheckerInterface
{
	/**
	 * Make sure that the database schema is up-to-date.
	 *
	 * @return void
	 * @since 3.2.2
	 */
	public function run(): void;
}

