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

namespace VDM\Joomla\Interfaces\Import;


use VDM\Joomla\Interfaces\Import\EntityInterface;


/**
 * Persistent import entity configuration interface.
 * 
 * Extends the base import configuration with persistence-related
 *    concerns such as queue tables, status tracking, logging,
 *    and file associations.
 * 
 * @since  5.1.4
 */
interface PersistentEntityInterface extends EntityInterface
{
	/* ==========================================================================
	 * Import Queue
	 * ========================================================================== */

	/**
	 * Get the import queue table name.
	 *
	 * @return string
	 * @since  5.1.4
	 */
	public function getQueueTable(): string;

	/**
	 * Set the import queue table name.
	 *
	 * @param  string  $table  The import queue table.
	 *
	 * @return self
	 * @since  5.1.4
	 *
	 * @throws  \InvalidArgumentException
	 */
	public function setQueueTable(string $table): self;

	/**
	 * Get the status field name used for import state tracking.
	 *
	 * @return string
	 * @since  5.1.4
	 */
	public function getQueueStatusField(): string;

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
	public function setQueueStatusField(string $field): self;

	/**
	 * Get the status value representing a wait state.
	 *
	 * @return int
	 * @since  5.1.4
	 */
	public function getQueueWaitState(): int;

	/**
	 * Set the status value representing a wait state.
	 *
	 * @param  int  $status  Processing status value.
	 *
	 * @return self
	 * @since  5.1.4
	 */
	public function setQueueWaitState(int $status): self;

	/**
	 * Get the status value representing a processing import.
	 *
	 * @return int
	 * @since  5.1.4
	 */
	public function getQueueProcessingState(): int;

	/**
	 * Set the status value representing a processing import.
	 *
	 * @param  int  $status  Processing status value.
	 *
	 * @return self
	 * @since  5.1.4
	 *
	 * @throws  \InvalidArgumentException
	 */
	public function setQueueProcessingState(int $status): self;

	/**
	 * Get the status value representing an success state.
	 *
	 * @return int
	 * @since  5.1.4
	 */
	public function getQueueSuccessState(): int;

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
	public function setQueueSuccessState(int $status): self;

	/**
	 * Get the status value representing an error state.
	 *
	 * @return int
	 * @since  5.1.4
	 */
	public function getQueueErrorState(): int;

	/**
	 * Set the status value representing an error state.
	 *
	 * @param  int  $status  Error status value.
	 *
	 * @return self
	 * @since  5.1.4
	 */
	public function setQueueErrorState(int $status): self;

	/* ==========================================================================
	 * Logging & Files
	 * ========================================================================== */

	/**
	 * Get the message log table name.
	 *
	 * @return string
	 * @since  5.1.4
	 */
	public function getMessageLogTable(): string;

	/**
	 * Set the message log table name.
	 *
	 * @param  string  $table  The message log table.
	 *
	 * @return self
	 * @since  5.1.4
	 *
	 * @throws  \InvalidArgumentException
	 */
	public function setMessageLogTable(string $table): self;

	/**
	 * Get the file table name.
	 *
	 * @return string
	 * @since  5.1.4
	 */
	public function getFileTable(): string;

	/**
	 * Set the file table name.
	 *
	 * @param  string  $table  The file table.
	 *
	 * @return self
	 * @since  5.1.4
	 *
	 * @throws  \InvalidArgumentException
	 */
	public function setFileTable(string $table): self;
}

