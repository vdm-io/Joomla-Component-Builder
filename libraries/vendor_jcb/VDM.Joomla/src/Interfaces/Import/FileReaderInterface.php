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

namespace VDM\Joomla\Interfaces\Import;


use PhpOffice\PhpSpreadsheet\Reader\Exception as ReaderException;
use PhpOffice\PhpSpreadsheet\Exception as SpreadsheetException;


/**
 * File Reader Interface
 * 
 * @since 3.2.2
 * 
 * 
 */
interface FileReaderInterface
{
	/**
	 * Stream rows from a CSV or Excel file one by one using yield.
	 *
	 * @param string  $filePath     The path to the file.
	 * @param int     $startRow     The starting row index.
	 * @param int     $chunkSize    The number of rows to read per chunk.
	 * @param int     $activeSheet  The index of the active worksheet 0=default.
	 *
	 * @return \Generator    A generator that yields each row as an array.
	 * @throws \InvalidArgumentException If the file does not exist.
	 * @throws \OutOfRangeException If the start row is beyond the highest row, no rows can be processed.
	 * @throws ReaderException If there is an error identifying or reading the file.
	 * @throws SpreadsheetException If there is an error working with the spreadsheet.
	 * @since 3.2.0
	 */
	public function read(string $filePath, int $startRow, int $chunkSize, int $activeSheet = 0): \Generator;
}

