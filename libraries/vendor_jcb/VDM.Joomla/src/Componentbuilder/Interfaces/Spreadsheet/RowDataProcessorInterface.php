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


use PhpOffice\PhpSpreadsheet\Worksheet\Row;


/**
 * Spreadsheet Row Data Processor Interface
 * 
 * @since 3.2.2
 */
interface RowDataProcessorInterface
{
	/**
	 * Processes the given spreadsheet row and returns it in a specific format.
	 *
	 * @param Row $row The row object from the spreadsheet to be processed.
	 * 
	 * @return mixed Processed row data, could be an array, cell object, or other structures.
	 */
	public function process(Row $row): mixed;
}

