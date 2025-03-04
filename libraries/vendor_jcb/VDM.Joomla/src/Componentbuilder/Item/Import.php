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
namespace VDM\Joomla\Componentbuilder\Item;


use Joomla\CMS\Language\Text;
use VDM\Joomla\Componentbuilder\Interfaces\ImportStatusInterface as Status;
use VDM\Joomla\Componentbuilder\Interfaces\ImportMessageInterface as Message;
use VDM\Joomla\Componentbuilder\Interfaces\ImportMapperInterface as Mapper;
use VDM\Joomla\Componentbuilder\Import\Data;
use VDM\Joomla\Componentbuilder\Spreadsheet\Importer;
use VDM\Joomla\Componentbuilder\Spreadsheet\RowDataArray as RowData;
use VDM\Joomla\Componentbuilder\Interfaces\ImportRowInterface as Row;
use VDM\Joomla\Componentbuilder\Item\Import\ParentTable;
use VDM\Joomla\Componentbuilder\Item\Import\JoinTables;
use VDM\Joomla\Componentbuilder\Interfaces\ImportAssessorInterface as Assessor;
use VDM\Joomla\Interfaces\Data\ItemInterface as Item;
use VDM\Joomla\Componentbuilder\Interfaces\Spreadsheet\ImportCliInterface;


/**
 * Item Import Class
 * 
 * @since  5.0.2
 */
final class Import implements ImportCliInterface
{
	/**************************************************************************
	 * THESE VALUES BELOW SHOULD BE UPDATE FOR YOUR USE-CASE
	 */

	/**
	 * The starting row.
	 *
	 * @var   int
	 * @since 5.0.2
	 */
	protected int $startingRow = 2;

	/**
	 * The the parent table of each row
	 *
	 * @var   string
	 * @since 5.0.2
	 */
	protected string $parentTable = 'look';

	/**
	 * The the parent table key field
	 *
	 * @var   string
	 * @since 5.0.2
	 */
	protected string $parentKey = 'guid';

	/**
	 * The the parent join key field to other tables
	 *
	 * @var   string
	 * @since 5.0.2
	 */
	protected string $parentJoinKey = 'entity';

	/**
	 * The the parent table key field to link a row to existing data
	 *
	 * @var   string
	 * @since 5.0.2
	 */
	protected string $linkField = 'guid';

	/**
	 * The the import queue table
	 *
	 * @var   string
	 * @since 5.0.2
	 */
	protected string $importTable = 'item_import';

	/**
	 * THESE VALUES ABOVE SHOULD BE UPDATE FOR YOUR USE-CASE
	 **************************************************************************/

	/**
	 * The Import Status Class.
	 *
	 * @var   Status
	 * @since 5.0.2
	 */
	protected Status $status;

	/**
	 * The Import Message Class.
	 *
	 * @var   Message
	 * @since 5.0.2
	 */
	protected Message $message;

	/**
	 * The Import Mapper Class.
	 *
	 * @var   Mapper
	 * @since 5.0.2
	 */
	protected Mapper $mapper;

	/**
	 * The Data Class.
	 *
	 * @var   Data
	 * @since 5.0.2
	 */
	protected Data $data;

	/**
	 * The Importer Class.
	 *
	 * @var   Importer
	 * @since 5.0.2
	 */
	protected Importer $importer;

	/**
	 * The Row Data Array Class.
	 *
	 * @var   RowData
	 * @since 5.0.2
	 */
	protected RowData $rowdata;

	/**
	 * The Import Row Class.
	 *
	 * @var   Row
	 * @since 5.0.2
	 */
	protected Row $row;

	/**
	 * The Parent Table Class.
	 *
	 * @var   ParentTable
	 * @since 5.0.2
	 */
	protected ParentTable $parentTableClass;

	/**
	 * The Join Tables Class.
	 *
	 * @var   JoinTables
	 * @since 5.0.2
	 */
	protected JoinTables $joinTables;

	/**
	 * The Import Assessor Class.
	 *
	 * @var   Assessor
	 * @since 5.0.2
	 */
	protected Assessor $assessor;

	/**
	 * The Item Class.
	 *
	 * @var   Item
	 * @since 5.0.2
	 */
	protected Item $item;

	/**
	 * Constructor.
	 *
	 * @param Status       $status            The Import Status Class.
	 * @param Message      $message           The Import Message Class.
	 * @param Mapper       $mapper            The Import Mapper Class.
	 * @param Data         $data              The Data Class.
	 * @param Importer     $importer          The Importer Class.
	 * @param RowData      $rowdata           The Row Data Array Class.
	 * @param Row          $row               The Import Row Class.
	 * @param ParentTable  $parentTableClass  The Parent Class.
	 * @param JoinTables   $join              The Join Class.
	 * @param Assessor     $assessor          The Import Assessor Class.
	 * @param Item         $item              The Item Class.
	 *
	 * @since 5.0.2
	 */
	public function __construct(Status $status, Message $message, Mapper $mapper,
		Data $data, Importer $importer, RowData $rowdata,
		Row $row, ParentTable $parentTableClass, JoinTables $joinTables,
		Assessor $assessor, Item $item)
	{
		$this->status = $status;
		$this->message = $message;
		$this->mapper = $mapper;
		$this->data = $data;
		$this->importer = $importer;
		$this->rowdata = $rowdata;
		$this->row = $row;
		$this->parentTableClass = $parentTableClass;
		$this->joinTables = $joinTables;
		$this->assessor = $assessor;
		$this->item = $item;

		// load the status target table and field
		$this->status->table($this->importTable)->field('import_status');
	}

	/**
	 * The trigger function called from the CLI to start the item import on a spreadsheet
	 *
	 * @param  object  $import  The spreadsheet data to import.
	 *
	 * @return  void
	 * @since  5.0.2
	 */
	public function data(object $import): void
	{
		// move spreadsheet into 2=processing
		$this->status->set(2, $import->guid);

		// load message
		$this->message->load($import->guid, $this->importTable, 'message_log');

		if (empty($import->file) || ($file = $this->getFile($import->file)) === null)
		{
			$this->prematureError($import->guid, Text::_('COM_COMPONENTBUILDER_FILE_DATA_COULD_NOT_BE_FOUND'));
			return;
		}

		// check file path
		if (!is_file($file->file_path))
		{
			$this->prematureError($import->guid, Text::sprintf('COM_COMPONENTBUILDER_FILE_NOT_FOUND_S', $file->file_path));
			return;
		}

		$this->mapper->set($import->maps, $this->parentTable);
		unset($import->maps);

		$this->data->set('import', (array) $import);

		$rowCounter = 0;
		$successCounter = 0;
		$errorCounter = 0;

		try
		{
			foreach ($this->importer->read($file->file_path, $this->startingRow, 100, $this->rowdata) as $row)
			{
				// ignore empty rows
				if ($row === null || empty($row['values']) || count((array) $row['values']) <= 3 || empty($row['index']))
				{
					continue;
				}

				$this->row->set($row['index'], $row['values']);

				$rowCounter++;
				if (($guid = $this->import()) !== null)
				{
					// TODO: we can add extra code here for more adaptation/calculation of import data
					$successCounter++;
				}
				else
				{
					$errorCounter++;
				}

				$this->row->clear();
			}

			// Check the success rate after processing all rows
			$this->assessor->evaluate($rowCounter, $successCounter, $errorCounter);
		}
		catch (\InvalidArgumentException $e)
		{
			// Handle invalid argument exception (e.g., file not found)
			$this->message->addError(Text::sprintf('COM_COMPONENTBUILDER_ERROR_INVALID_ARGUMENT_S', $e->getMessage()));
		}
		catch (\OutOfRangeException $e)
		{
			// Handle out of range exception (e.g., start row beyond highest row)
			$this->message->addError(Text::sprintf('COM_COMPONENTBUILDER_ERROR_OUT_OF_RANGE_S', $e->getMessage()));
		}
		catch (\Exception $e)
		{
			// Catch any other general exceptions
			$this->message->addError($e->getMessage());
		}
	}

	/**
	 * The message of the last import event
	 *
	 * @return  object
	 * @since  5.0.2
	 */
	public function message(): object
	{
		$messages = $this->message->archive()->set()->get();
		$this->message->reset();
		return $messages;
	}

	/**
	 * This is trigger on premature error
	 *
	 * @param string   $guid     The import guid.
	 * @param string   $message  The error message.
	 *
	 * @return  void
	 * @since  5.0.2
	 */
	private function prematureError(string $guid, string $message): void
	{
		$this->status->set(4, $guid);
		$this->message->addError($message);
	}

	/**
	 * Save the item calculated values
	 *
	 * @return  string|null
	 * @since  5.0.2
	 */
	private function import(): ?string
	{
		try {
			$parent_guid = $this->parentTableClass->set($this->linkField, $this->parentKey, $this->parentTable);

			if ($parent_guid === null)
			{
				return null;
			}

			$this->joinTables->set($this->parentJoinKey, $parent_guid);

			return $parent_guid;

		}
		catch (\Exception $e)
		{
			$this->message->addError($e->getMessage());
			return null;
		}
	}

	/**
	 * Get the file details
	 *
	 * @param string   $file    The file guid.
	 *
	 * @return  object|null
	 * @since  5.0.2
	 */
	private function getFile(string $file): ?object
	{
		return $this->item->table('file')->get($file);
	}
}

