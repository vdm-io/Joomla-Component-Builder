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


use Joomla\CMS\Factory;
use Joomla\CMS\User\User;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Writer\Exception;
use VDM\Joomla\Utilities\ArrayHelper;


/**
 * Spreadsheet Exporter Class
 * 
 * @since 3.2.0
 */
final class Exporter
{
	/**
	 * The current active user.
	 *
	 * @var User $user
	 * @since 3.2.0
	 */
	private User $user;

	/**
	 * The PhpSpreadsheet object used to create and manage the spreadsheet.
	 *
	 * @var Spreadsheet $spreadsheet
	 * @since 3.2.0
	 */
	private Spreadsheet $spreadsheet;

	/**
	 * The name of the file to be exported, including the date if not provided.
	 *
	 * @var string $fileName
	 * @since 3.2.0
	 */
	private string $fileName;

	/**
	 * The format of the exported file, typically 'Xls' or 'Csv'.
	 *
	 * @var string $fileType
	 * @since 3.2.0
	 */
	private string $fileType;

	/**
	 * The name of the worksheet tab in the exported spreadsheet.
	 *
	 * @var string $subjectTab
	 * @since 3.2.0
	 */
	private string $subjectTab;

	/**
	 * The styles applied to the header row, including font size, color, and bold formatting.
	 *
	 * @var array $headerStyles
	 * @since 3.2.0
	 */
	private array $headerStyles;

	/**
	 * The styles applied to the first column (side) of the spreadsheet, usually for labeling rows.
	 *
	 * @var array $sideStyles
	 * @since 3.2.0
	 */
	private array $sideStyles;

	/**
	 * The styles applied to normal cells in the spreadsheet, such as font color and size.
	 *
	 * @var array $normalStyles
	 * @since 3.2.0
	 */
	private array $normalStyles;

	/**
	 * SpreadsheetExporter constructor.
	 * Initializes styles and the Spreadsheet object.
	 *
	 * @since 3.2.0
	 */
	public function __construct()
	{
		$this->user = Factory::getUser();
		$this->spreadsheet = new Spreadsheet();
		$this->headerStyles = [
			'font' => [
				'bold' => true,
				'color' => ['rgb' => '1171A3'],
				'size' => 13,
				'name' => 'Verdana'
			]
		];
		$this->sideStyles = [
			'font' => [
				'bold' => true,
				'color' => ['rgb' => '444444'],
				'size' => 11,
				'name' => 'Verdana'
			]
		];
		$this->normalStyles = [
			'font' => [
				'color' => ['rgb' => '444444'],
				'size' => 11,
				'name' => 'Verdana'
			]
		];
	}

	/**
	 * Prepares the spreadsheet with data.
	 *
	 * @param array       $rows
	 * @param string|null $fileName
	 * @param string|null $title
	 * @param string|null $subjectTab
	 * @param string      $creator
	 * @param string|null $description
	 * @param string|null $category
	 * @param string|null $keywords
	 * @param string|null $modified
	 *
	 * @return void
	 * @throws Exception
	 * @since 3.2.0
	 */
	public function export(
		array $rows,
		?string $fileName = null,
		?string $title = null,
		?string $subjectTab = null,
		string $creator = 'Vast Development Method',
		?string $description = null,
		?string $category = null,
		?string $keywords = null,
		?string $modified = null
	): void {
		$this->fileName = $fileName ?? 'exported_' . Factory::getDate()->format('jS_F_Y');
		$this->fileType = 'Xls';
		$this->subjectTab = $subjectTab ?? 'Sheet1';

		$this->setDocumentProperties($creator, $title, $description, $category, $keywords, $modified);
		$this->populateSpreadsheet($rows);

		// Output the spreadsheet
		$this->outputSpreadsheet();
	}

	/**
	 * Set the document properties for the spreadsheet.
	 *
	 * @param string        $creator
	 * @param string|null   $title
	 * @param string|null   $description
	 * @param string|null   $category
	 * @param string|null   $keywords
	 * @param string|null   $modified
	 * @since 3.2.0
	 */
	private function setDocumentProperties(
		string $creator,
		?string $title = null,
		?string $description = null,
		?string $category = null,
		?string $keywords = null,
		?string $modified = null
	): void
	{
		$modifiedBy = $modified ?? $this->user->name;

		$this->spreadsheet->getProperties()
			->setCreator($creator)
			->setCompany('Vast Development Method')
			->setLastModifiedBy($modifiedBy)
			->setTitle($title ?? 'Book1')
			->setSubject($this->subjectTab);

		if ($description)
		{
			$this->spreadsheet->getProperties()->setDescription($description);
		}

		if ($category)
		{
			$this->spreadsheet->getProperties()->setCategory($category);
		}

		if ($keywords)
		{
			$this->spreadsheet->getProperties()->setKeywords($keywords);
		}
	}

	/**
	 * Populate the spreadsheet with the provided rows.
	 *
	 * @param array $rows
	 *
	 * @since 3.2.0
	 */
	private function populateSpreadsheet(array $rows): void
	{
		if (($size = ArrayHelper::check($rows)) === false)
		{
			return;
		}

		$xlsMode = $this->determineXlsMode($size);
		$activeSheet = $this->spreadsheet->setActiveSheetIndex(0);
		$rowIndex = 1;

		foreach ($rows as $array)
		{
			$columnIndex = 'A';
			foreach ($array as $value)
			{
				$activeSheet->setCellValue($columnIndex . $rowIndex, $value);
				$this->applyStyles($activeSheet, $rowIndex, $columnIndex, $xlsMode);
				$columnIndex++;
			}
			$rowIndex++;
		}

		$activeSheet->setTitle($this->subjectTab);
	}

	/**
	 * Determine the XLS mode based on the number of rows.
	 *
	 * @param int $size
	 * @return int
	 *
	 * @since 3.2.0
	 */
	private function determineXlsMode(int $size): int
	{
		if ($size > 3000)
		{
			$this->fileType = 'Csv';
			return 3;
		}

		if ($size > 2000)
		{
			return 2;
		}

		return 1;
	}

	/**
	 * Apply styles to the cells based on the row and column index.
	 *
	 * @param Worksheet $sheet
	 * @param int       $rowIndex
	 * @param string    $columnIndex
	 * @param int       $xlsMode
	 *
	 * @since 3.2.0
	 */
	private function applyStyles(Worksheet $sheet, int $rowIndex, string $columnIndex, int $xlsMode): void
	{
		if ($xlsMode === 3)
		{
			return;
		}

		if ($rowIndex === 1)
		{
			$sheet->getColumnDimension($columnIndex)->setAutoSize(true);
			$sheet->getStyle($columnIndex . $rowIndex)->applyFromArray($this->headerStyles);
			$sheet->getStyle($columnIndex . $rowIndex)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
			$row_height = ($this->headerStyles['font']['size'] ?? 13) + 5;
			$sheet->getRowDimension($rowIndex)->setRowHeight($row_height);
		}
		elseif ($columnIndex === 'A')
		{
			$sheet->getStyle($columnIndex . $rowIndex)->applyFromArray($this->sideStyles);
		}
		else
		{
			$sheet->getStyle($columnIndex . $rowIndex)->applyFromArray($this->normalStyles);
		}
	}

	/**
	 * Output the spreadsheet as an Excel or CSV file.
	 *
	 * @return void
	 * @throws Exception
	 * @since 3.2.0
	 */
	private function outputSpreadsheet(): void
	{
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $this->fileName . '.' . strtolower($this->fileType) . '"');
		header('Cache-Control: max-age=0');
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
		header('Cache-Control: cache, must-revalidate');
		header('Pragma: public');

		$writer = IOFactory::createWriter($this->spreadsheet, $this->fileType);
		$writer->save('php://output');
		exit;
	}
}

