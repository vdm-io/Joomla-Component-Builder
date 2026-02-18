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

namespace VDM\Joomla\Import\Spreadsheet;


use PhpOffice\PhpSpreadsheet\Reader\Exception as ReaderException;
use PhpOffice\PhpSpreadsheet\Exception as SpreadsheetException;
use VDM\Joomla\Interfaces\Import\FileReaderInterface as FileReader;
use VDM\Joomla\Interfaces\Spreadsheet\RowDataInterface as RowData;
use VDM\Joomla\Interfaces\Import\SpreadsheetReaderInterface;


/**
 * Spreadsheet Reader Class
 * 
 * @since 3.2.0
 */
final class Reader implements SpreadsheetReaderInterface
{
	/**
	 * The File Reader Class.
	 *
	 * @var   FileReader
	 * @since 3.0.8
	 */
	protected FileReader $filereader;

	/**
	 * Constructor.
	 *
	 * @param FileReader   $filereader   The File Reader Class.
	 *
	 * @since 3.0.8
	 */
	public function __construct(FileReader $filereader)
	{
		$this->filereader = $filereader;
	}

	/**
	 * Stream rows from a CSV or Excel file one by one using yield.
	 *
	 * @param string    $filePath     The path to the file.
	 * @param int       $startRow     The starting row index.
	 * @param int       $chunkSize    The number of rows to read per chunk.
	 * @param RowData   $processor   The processor used to transform the row data into the desired format.
	 * @param int       $activeSheet  The index of the active worksheet 0=default.
	 *
	 * @return \Generator    A generator that yields each row as an array.
	 * @throws \InvalidArgumentException If the file does not exist.
	 * @throws \OutOfRangeException If the start row is beyond the highest row, no rows can be processed.
	 * @throws ReaderException If there is an error identifying or reading the file.
	 * @throws SpreadsheetException If there is an error working with the spreadsheet.
	 * @since 3.2.0
	 */
	public function read(string $filePath, int $startRow, int $chunkSize, RowData $processor, int $activeSheet = 0): \Generator
	{
		foreach ($this->filereader->read($filePath, $startRow, $chunkSize, $activeSheet) as $row)
		{
			yield $processor->process($row);
		}
	}
}

