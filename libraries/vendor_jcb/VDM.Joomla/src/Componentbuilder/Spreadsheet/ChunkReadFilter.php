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


use PhpOffice\PhpSpreadsheet\Reader\IReadFilter;


/**
 * Chunk Read Filter Class
 * 
 * @since 3.2.0
 */
final class ChunkReadFilter implements IReadFilter
{
	/**
	 * The first row to read in the current chunk.
	 *
	 * @var int
	 */
	private int $startRow;

	/**
	 * The last row to read in the current chunk.
	 * This is calculated as $startRow + $chunkSize - 1.
	 *
	 * @var int
	 */
	private int $endRow;

	/**
	 * Constructor to initialize the chunk filter.
	 *
	 * @param int $startRow The starting row to read.
	 * @param int $chunkSize The number of rows to read in each chunk.
	 */
	public function __construct(int $startRow, int $chunkSize)
	{
		$this->startRow = $startRow;
		$this->endRow = $startRow + $chunkSize - 1;
	}

	/**
	 * Determines whether a cell should be read based on its row and column.
	 *
	 * @param string $column The column index (e.g., 'A', 'B', 'C').
	 * @param int $row The row index.
	 * @param string|null $worksheetName The worksheet name (not used in this case).
	 *
	 * @return bool Whether the cell should be read.
	 */
	public function readCell(string $columnAddress, int $row, string $worksheetName = ''): bool
	{
		// Only read rows that fall within the chunk range
		if ($row >= $this->startRow && $row <= $this->endRow)
		{
			return true;
		}

		return false;
	}
}

