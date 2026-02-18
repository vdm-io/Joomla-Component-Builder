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
namespace VDM\Joomla\Componentbuilder\Import\Item;


use Joomla\CMS\Language\Text;
use VDM\Joomla\Interfaces\Import\MessageInterface as Message;
use VDM\Joomla\Interfaces\Import\MapperInterface as Mapper;
use VDM\Joomla\Interfaces\Registryinterface as Data;
use VDM\Joomla\Interfaces\Import\SpreadsheetReaderInterface as Importer;
use VDM\Joomla\Interfaces\Spreadsheet\RowDataInterface as RowData;
use VDM\Joomla\Interfaces\Import\RowInterface as Row;
use VDM\Joomla\Interfaces\Import\ParentTableInterface as ParentTable;
use VDM\Joomla\Interfaces\Import\JoinTablesInterface as JoinTables;
use VDM\Joomla\Interfaces\Import\AssessorInterface as Assessor;
use VDM\Joomla\Interfaces\Import\EntityInterface as Entity;
use VDM\Joomla\Interfaces\Import\ItemProcessInterface;


/**
 * Transient import item.
 * 
 * Executes import and returns the result without persistence.
 * 
 * @since  5.1.4
 */
class Transient implements ItemProcessInterface
{
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
	protected ParentTable $parenttable;

	/**
	 * The Join Tables Class.
	 *
	 * @var   JoinTables
	 * @since 5.0.2
	 */
	protected JoinTables $jointables;

	/**
	 * The Import Assessor Class.
	 *
	 * @var   Assessor
	 * @since 5.0.2
	 */
	protected Assessor $assessor;

	/**
	 * The Entity Class.
	 *
	 * @var   Entity
	 * @since 5.1.4
	 */
	protected Entity $entity;

	/**
	 * Constructor.
	 *
	 * @param Message       $message       The Message Class.
	 * @param Mapper        $mapper        The Mapper Class.
	 * @param Data          $data          The Data Class.
	 * @param Importer      $importer      The SpreadsheetReader Class.
	 * @param RowData       $rowdata       The RowData Class.
	 * @param Row           $row           The Row Class.
	 * @param ParentTable   $parenttable   The ParentTable Class.
	 * @param JoinTables    $jointables    The JoinTables Class.
	 * @param Assessor      $assessor      The Assessor Class.
	 * @param Entity        $entity        The Entity Class.
	 *
	 * @since 5.1.4
	 */
	public function __construct(Message $message, Mapper $mapper, Data $data,
		Importer $importer, RowData $rowdata, Row $row,
		ParentTable $parenttable, JoinTables $jointables,
		Assessor $assessor, Entity $entity)
	{
		$this->message = $message;
		$this->mapper = $mapper;
		$this->data = $data;
		$this->importer = $importer;
		$this->rowdata = $rowdata;
		$this->row = $row;
		$this->parenttable = $parenttable;
		$this->jointables = $jointables;
		$this->assessor = $assessor;
		$this->entity = $entity;
	}

	/**
	 * Execute the import process.
	 *
	 * Executes the import using the given payload and returns
	 * the current process instance for fluent interaction.
	 *
	 * @param  object  $payload  The import payload.
	 * @param  Entity  $entity   The entity config being targeted.
	 *
	 * @return  self
	 * @since   5.1.4
	 */
	public function execute(object $payload): self
	{
		// check file path
		if (!is_file($payload->file_path))
		{
			$this->message->addError(Text::sprintf('COM_COMPONENTBUILDER_FILE_NOT_FOUND_S', $payload->file_path));
			return $this;
		}

		$this->mapper->set($payload->maps, $this->entity->getParentTable());
		unset($payload->maps);

		$this->data->set($this->entity->getDataKey(), (array) $payload);

		$rowCounter = 0;
		$successCounter = 0;
		$errorCounter = 0;

		try
		{
			foreach ($this->importer->read($payload->file_path, $this->entity->getStartingRow(), 100, $this->rowdata) as $row)
			{
				// ignore empty rows
				if ($row === null || empty($row['values']) || count((array) $row['values']) < $this->entity->getMinimalColumns() || empty($row['index']))
				{
					continue;
				}

				$this->row->set($row['index'], $row['values']);

				$rowCounter++;
				if (($parent_key_value = $this->import()) !== null)
				{
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

		return $this;
	}

	/**
	 * Get the result of the last import execution.
	 *
	 * @return  object
	 * @since   5.1.4
	 */
	public function result(): object
	{
		$messages = $this->message->get();
		$this->message->reset();
		return $messages;
	}

	/**
	 * Save the item calculated values
	 *
	 * @return mixed
	 * @since  5.0.2
	 */
	private function import()
	{
		try {
			$parent_key_value = $this->parenttable->set($this->entity->getLinkField(), $this->entity->getParentKey(), $this->entity->getParentTable());

			if ($parent_key_value === null)
			{
				return null;
			}

			$this->jointables->set($this->entity->getParentJoinKey(), $parent_key_value, $this->entity->getJoinFields());

			return $parent_key_value;
		}
		catch (\Throwable $e)
		{
			$this->message->addError($e->getMessage());

			return null;
		}
	}
}

