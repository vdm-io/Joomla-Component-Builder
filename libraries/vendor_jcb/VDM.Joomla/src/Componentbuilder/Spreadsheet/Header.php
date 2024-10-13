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
use VDM\Joomla\Componentbuilder\Spreadsheet\ChunkReadFilter;


/**
 * Spreadsheet Header Class
 * 
 * @since 3.2.0
 */
final class Header
{
	/**
	 * Get CSV or Excel headers from the provided file path.
	 *
	 * @param string  $filePath
	 * @param int     $targetRow
	 *
	 * @return array|null
	 * @since 3.2.0
	 */
	public function get(string $filePath, int $targetRow = 1): ?array
	{
		if (!is_file($filePath))
		{
			return null;
		}

		try {
			$chunkFilter = new ChunkReadFilter(1, 20);
			$inputFileType = IOFactory::identify($filePath);
			$reader = IOFactory::createReader($inputFileType);
			$reader->setReadFilter($chunkFilter);
			$reader->setReadDataOnly(true);

			$spreadsheet = $reader->load($filePath);
			$headers = [];

			foreach ($spreadsheet->getActiveSheet()->getRowIterator() as $row)
			{
				if ($row->getRowIndex() === $targetRow)
				{
					$cellIterator = $row->getCellIterator();
					$cellIterator->setIterateOnlyExistingCells(false);
					foreach ($cellIterator as $cell)
					{
						$headers[$cell->getColumn()] = $cell->getValue();
					}
					break;
				}
			}

			$spreadsheet->disconnectWorksheets();

			return $headers;
		} catch (\Exception $e) {
			// Log or handle exceptions as necessary
			return null;
		}
	}
}

