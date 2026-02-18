<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    4th September, 2020
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
namespace VDM\Joomla\Componentbuilder\Spreadsheet;


use PhpOffice\PhpSpreadsheet\Worksheet\Row;
use VDM\Joomla\Interfaces\Spreadsheet\RowDataInterface;


/**
 * Spreadsheet Row Data Array
 * 
 * @since 5.0.2
 */
final class RowDataArray implements RowDataInterface
{
	/**
	 * Processes a given spreadsheet row and returns an associative array containing the row index and cell values indexed by column letters.
	 *
	 * This method iterates over each cell in the provided row, retrieves the cell values, and creates
	 * an associative array where 'index' holds the row index and 'value' contains an associative array
	 * of column letters as keys and cell values as the corresponding values.
	 *
	 * @param Row $row The row object from the spreadsheet to be processed.
	 *
	 * @return null|array<string, string> An associative array with the following structure:
	 *                             - 'index' (int): The row index.
	 *                             - 'values' (array<string, string>): An associative array where keys are the column letters
	 *                               (string), and values are the corresponding cell values (string).
	 * @since 5.0.2
	 */
	public function process(Row $row): ?array
	{
		if ($row->isEmpty())
		{
			return null;
		}

		$rowData = ['index' => $row->getRowIndex(), 'values' => []];
		$cellIterator = $row->getCellIterator();
		$cellIterator->setIterateOnlyExistingCells(true);

		foreach ($cellIterator as $cell)
		{
			$rowData['values'][$cell->getColumn()] = (string) $cell->getValue();
		}

		return $rowData;
	}
}

