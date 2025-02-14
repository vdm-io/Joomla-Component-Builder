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

namespace VDM\Joomla\Componentbuilder\Spreadsheet;


use VDM\Joomla\Componentbuilder\Interfaces\Spreadsheet\FileReaderInterface as FileReader;
use VDM\Joomla\Componentbuilder\Interfaces\Spreadsheet\RowDataProcessorInterface as RowDataProcessor;


/**
 * Spreadsheet Importer Class
 * 
 * @since 3.2.0
 */
final class Importer
{
	/**
	 * The FileReader Class.
	 *
	 * @var   FileReader
	 * @since 3.0.8
	 */
	protected FileReader $filereader;

	/**
	 * Constructor.
	 *
	 * @param FileReader   $filereader   The FileReader Class.
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
	 * @param string             $filePath    The path to the file.
	 * @param int                $startRow    The starting row index.
	 * @param int                $chunkSize   The number of rows to read per chunk.
	 * @param RowDataProcessor   $processor   The processor used to transform the row data into the desired format.
	 *
	 * @return \Generator    A generator that yields each row as an array.
	 * @throws \InvalidArgumentException If the file does not exist.
	 * @throws \OutOfRangeException If the start row is beyond the highest row, no rows can be processed.
	 * @throws ReaderException If there is an error identifying or reading the file.
	 * @throws SpreadsheetException If there is an error working with the spreadsheet.
	 * @since 3.2.0
	 */
	public function read(string $filePath, int $startRow, int $chunkSize, RowDataProcessor $processor): \Generator
	{
		foreach ($this->filereader->read($filePath, $startRow, $chunkSize) as $row)
		{
			yield $processor->process($row);
		}
	}
}

