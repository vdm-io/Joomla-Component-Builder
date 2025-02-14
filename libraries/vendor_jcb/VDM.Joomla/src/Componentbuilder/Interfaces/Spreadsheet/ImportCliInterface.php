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

namespace VDM\Joomla\Componentbuilder\Interfaces\Spreadsheet;


/**
 * Spreadsheet Import Cli Interface
 * 
 * @since 3.2.2
 */
interface ImportCliInterface
{
	/**
	 * The trigger function called from the CLI to start the import on a spreadsheet
	 *
	 * @param  object  $import  The spreadsheet data to import.
	 *
	 * @return  void
	 * @since  5.0.2
	 */
	public function data(object $import): void;

	/**
	 * The message of the last import event
	 *
	 * @return  object
	 * @since  5.0.2
	 */
	public function message(): object;
}

