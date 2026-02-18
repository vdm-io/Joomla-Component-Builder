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

namespace VDM\Joomla\Import\Persistent;


use VDM\Joomla\Interfaces\Import\PersistentEntityInterface;
use VDM\Joomla\Import\Entity as ExtendingEntity;


/**
 * Base persistent import configuration.
 * 
 * Adds persistence-specific entity configuration required for queued imports,
 *    status tracking, logging, and file linking.
 * 
 * @since  5.1.4
 */
class Entity extends ExtendingEntity implements PersistentEntityInterface
{
	/**
	 * The import queue table.
	 *
	 * @var   string
	 * @since 5.1.4
	 */
	protected string $queueTable = 'item_import';

	/**
	 * The status field.
	 *
	 * @var   string
	 * @since 5.1.4
	 */
	protected string $queueStatusField = 'import_status';

	/**
	 * The queue awaiting status value.
	 *
	 * @var    int
	 * @since  5.1.4
	 */
	protected int $queueWaitState = 1;

	/**
	 * The queue processing status value.
	 *
	 * @var   int
	 * @since 5.1.4
	 */
	protected int $queueProcessingState = 2;

	/**
	 * The queue success status value.
	 *
	 * @var   int
	 * @since 5.1.4
	 */
	protected int $queueSuccessState = 3;

	/**
	 * The error status value.
	 *
	 * @var   int
	 * @since 5.1.4
	 */
	protected int $queueErrorState = 4;

	/**
	 * The message log table.
	 *
	 * @var   string
	 * @since 5.1.4
	 */
	protected string $messageLogTable = 'message_log';

	/**
	 * The file table.
	 *
	 * @var   string
	 * @since 5.1.4
	 */
	protected string $fileTable = 'file';

	/* ==========================================================================
	 * Getters
	 * ========================================================================== */

	/**
	 * Get the import queue table.
	 *
	 * @return string
	 * @since  5.1.4
	 */
	public function getQueueTable(): string
	{
		return $this->queueTable;
	}

	/**
	 * Get the status field.
	 *
	 * @return string
	 * @since  5.1.4
	 */
	public function getQueueStatusField(): string
	{
		return $this->queueStatusField;
	}


	/**
	 * Get the status value representing a wait state.
	 *
	 * @return int
	 * @since  5.1.4
	 */
	public function getQueueWaitState(): int
	{
		return $this->queueWaitState;
	}

	/**
	 * Get the status value representing a processing import.
	 *
	 * @return int
	 * @since  5.1.4
	 */
	public function getQueueProcessingState(): int
	{
		return $this->queueProcessingState;
	}

	/**
	 * Get the status value representing an success state.
	 *
	 * @return int
	 * @since  5.1.4
	 */
	public function getQueueSuccessState(): int
	{
		return $this->queueSuccessState;
	}

	/**
	 * Get the status value representing an error state.
	 *
	 * @return int
	 * @since  5.1.4
	 */
	public function getQueueErrorState(): int
	{
		return $this->queueErrorState;
	}

	/**
	 * Get the message log table.
	 *
	 * @return string
	 * @since  5.1.4
	 */
	public function getMessageLogTable(): string
	{
		return $this->messageLogTable;
	}

	/**
	 * Get the file table.
	 *
	 * @return string
	 * @since  5.1.4
	 */
	public function getFileTable(): string
	{
		return $this->fileTable;
	}

	/* ==========================================================================
	 * Setters
	 * ========================================================================== */

	/**
	 * Set the import queue table.
	 *
	 * @param  string  $table
	 *
	 * @return self
	 * @since  5.1.4
	 *
	 * @throws  \InvalidArgumentException
	 */
	public function setQueueTable(string $table): self
	{
		if ($table === '')
		{
			throw new \InvalidArgumentException('Import table cannot be empty.');
		}

		$this->queueTable = $table;

		return $this;
	}

	/**
	 * Set the status field.
	 *
	 * @param  string  $field
	 *
	 * @return self
	 * @since  5.1.4
	 *
	 * @throws  \InvalidArgumentException
	 */
	public function setQueueStatusField(string $field): self
	{
		if ($field === '')
		{
			throw new \InvalidArgumentException('Status field cannot be empty.');
		}

		$this->queueStatusField = $field;

		return $this;
	}

	/**
	 * Set the status value representing a wait state.
	 *
	 * @param  int  $status  Processing status value.
	 *
	 * @return self
	 * @since  5.1.4
	 */
	public function setQueueWaitState(int $status): self
	{
		$this->queueWaitState = $status;

		return $this;
	}

	/**
	 * Set the processing status value.
	 *
	 * @param  int  $status
	 *
	 * @return self
	 * @since  5.1.4
	 *
	 * @throws  \InvalidArgumentException
	 */
	public function setQueueProcessingState(int $status): self
	{
		if ($status < 1)
		{
			throw new \InvalidArgumentException('Processing status must be >= 1.');
		}

		$this->queueProcessingState = $status;

		return $this;
	}

	/**
	 * Set the success status value.
	 *
	 * @param  int  $status
	 *
	 * @return self
	 * @since  5.1.4
	 *
	 * @throws  \InvalidArgumentException
	 */
	public function setQueueSuccessState(int $status): self
	{
		if ($status < 1)
		{
			throw new \InvalidArgumentException('Success status must be >= 1.');
		}

		$this->queueSuccessState = $status;

		return $this;
	}

	/**
	 * Set the status value representing an error state.
	 *
	 * @param  int  $status  Error status value.
	 *
	 * @return self
	 * @since  5.1.4
	 */
	public function setQueueErrorState(int $status): self
	{
		$this->queueErrorState = $status;

		return $this;
	}

	/**
	 * Set the message log table.
	 *
	 * @param  string  $table
	 *
	 * @return self
	 * @since  5.1.4
	 *
	 * @throws  \InvalidArgumentException
	 */
	public function setMessageLogTable(string $table): self
	{
		if ($table === '')
		{
			throw new \InvalidArgumentException('Message log table cannot be empty.');
		}

		$this->messageLogTable = $table;

		return $this;
	}

	/**
	 * Set the file table.
	 *
	 * @param  string  $table
	 *
	 * @return self
	 * @since  5.1.4
	 *
	 * @throws  \InvalidArgumentException
	 */
	public function setFileTable(string $table): self
	{
		if ($table === '')
		{
			throw new \InvalidArgumentException('File table cannot be empty.');
		}

		$this->fileTable = $table;

		return $this;
	}
}

