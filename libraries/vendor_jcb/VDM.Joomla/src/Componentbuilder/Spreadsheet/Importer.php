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


use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Exception as ReaderException;
use PhpOffice\PhpSpreadsheet\Exception as SpreadsheetException;
use VDM\Joomla\Componentbuilder\Spreadsheet\ChunkReadFilter;


/**
 * Spreadsheet Importer Class
 * 
 * @since 3.2.0
 */
final class Importer
{
	/**
	 * Stream rows from a CSV or Excel file one by one using yield.
	 *
	 * @param string  $filePath    The path to the file.
	 * @param int     $startRow    The starting row index (default is 1).
	 * @param int     $chunkSize   The number of rows to read per chunk (default is 100).
	 *
	 * @return \Generator    A generator that yields each row as an array.
	 * @throws \InvalidArgumentException If the file does not exist.
	 * @throws \OutOfRangeException If the start row is beyond the highest row, no rows can be processed.
	 * @throws ReaderException If there is an error identifying or reading the file.
	 * @throws SpreadsheetException If there is an error working with the spreadsheet.
	 * @since 3.2.0
	 */
	public function get(string $filePath, int $startRow = 1, int $chunkSize = 100): \Generator
	{
		// Check if the file exists
		if (!is_file($filePath))
		{
			throw new \InvalidArgumentException("File not found: $filePath");
		}

		try {
			// Identify file type and create reader
			$inputFileType = IOFactory::identify($filePath);
			$reader = IOFactory::createReader($inputFileType);
			$reader->setReadDataOnly(true);

			// Load the entire spreadsheet to determine the highest row
			$spreadsheet = $reader->load($filePath);
			$worksheet = $spreadsheet->getActiveSheet();
			$highestRow = $worksheet->getHighestRow(); // Get the highest row number in the sheet

			// Disconnect and free memory after fetching the highest row
			$spreadsheet->disconnectWorksheets();
			unset($spreadsheet);

			// If the start row is beyond the highest row, no rows can be processed
			if ($startRow > $highestRow)
			{
				throw new \OutOfRangeException("Start row ($startRow) is beyond highest row ($highestRow)");
			}

			// Initialize variables for row processing
			$totalRows = $startRow;

			do {
				// Calculate the last row in the current chunk
				$endRow = min($totalRows + $chunkSize - 1, $highestRow);

				// Set up a new chunk filter for the current chunk
				$chunkFilter = new ChunkReadFilter($totalRows, $endRow);
				$reader->setReadFilter($chunkFilter);

				// Reload the chunk into the spreadsheet
				$spreadsheet = $reader->load($filePath);
				$worksheet = $spreadsheet->getActiveSheet();

				// Iterate through the rows in the current chunk
				foreach ($worksheet->getRowIterator($totalRows, $endRow) as $row)
				{
					$rowIndex = $row->getRowIndex();
					$rowData = [];

					$cellIterator = $row->getCellIterator();
					$cellIterator->setIterateOnlyExistingCells(false); // Include empty cells

					// Collect all cell data in the row
					foreach ($cellIterator as $cell)
					{
						$rowData[$cell->getColumn()] = $cell->getValue();
					}

					yield $rowData;

					// Update the row index for the next chunk
					$totalRows = $rowIndex + 1;
				}

				// Disconnect the spreadsheet to free memory
				$spreadsheet->disconnectWorksheets();
				unset($spreadsheet);

			} while ($totalRows <= $highestRow); // Continue reading while within the row limit

		} catch (ReaderException $e) {
			throw new ReaderException("Error reading the file: " . $e->getMessage(), $e->getCode(), $e);
		} catch (SpreadsheetException $e) {
			throw new SpreadsheetException("Error with the spreadsheet: " . $e->getMessage(), $e->getCode(), $e);
		}
	}
}

