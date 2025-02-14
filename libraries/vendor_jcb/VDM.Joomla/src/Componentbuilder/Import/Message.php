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

namespace VDM\Joomla\Componentbuilder\Import;


use VDM\Joomla\Interfaces\Data\UpdateInterface as Update;
use VDM\Joomla\Interfaces\Data\InsertInterface as Insert;
use VDM\Joomla\Utilities\GuidHelper;
use VDM\Joomla\Componentbuilder\Interfaces\ImportMessageInterface;


/**
 * Import Messages Class
 * 
 * @since  5.0.2
 */
final class Message implements ImportMessageInterface
{
	/**
	 * The Update Class.
	 *
	 * @var   Update
	 * @since 5.0.2
	 */
	protected Update $update;

	/**
	 * The Insert Class.
	 *
	 * @var   Insert
	 * @since 5.0.2
	 */
	protected Insert $insert;

	/**
	 * The success message bus.
	 *
	 * @var   array
	 * @since 5.0.2
	 */
	private array $success = [];

	/**
	 * The info message bus.
	 *
	 * @var   array
	 * @since 5.0.2
	 */
	private array $info = [];

	/**
	 * The error message bus.
	 *
	 * @var   array
	 * @since 5.0.2
	 */
	private array $error = [];

	/**
	 * The entity GUID value.
	 *
	 * @var   string
	 * @since 5.0.2
	 */
	private ?string $guid = null;

	/**
	 * The entity type value.
	 *
	 * @var   string|null
	 * @since 5.0.2
	 */
	private ?string $entity = null;

	/**
	 * The entity table value.
	 *
	 * @var   string|null
	 * @since 5.0.2
	 */
	private ?string $table = null;

	/**
	 * Constructor.
	 *
	 * @param Update   $update   The Update Class.
	 * @param Insert   $insert   The Insert Class.
	 *
	 * @since 5.0.2
	 */
	public function __construct(Update $update, Insert $insert)
	{
		$this->update = $update;
		$this->insert = $insert;
	}

	/**
	 * Load an entity that these message belong to
	 *
	 * @param string $guid   The entity guid these messages must be linked to.
	 * @param string $entity The entity type these messages must be linked to.
	 * @param string $table  The messages table where these message must be stored.
	 *
	 * @return  self
	 * @throws \InvalidArgumentException if any of the parameters are null or empty.
	 * @since  5.0.2
	 */
	public function load(string $guid, string $entity, string $table): self
	{
		if (empty($guid) || empty($entity) || empty($table))
		{
			throw new \InvalidArgumentException('GUID, entity, and table must not be null or empty.');
		}

		// set entity details
		$this->guid = $guid;
		$this->entity = $entity;
		$this->table = $table;

		return $this;
	}

	/**
	 * Get the messages of the last import event
	 *
	 * @return  object
	 * @since  5.0.2
	 */
	public function get(): object
	{
		return  (object) [
			'message_success' => $this->success ?? null,
			'message_info' => $this->info ?? null,
			'message_error' => $this->error ?? null
		];
	}

	/**
	 * Reset the messages of the last import event
	 *
	 * @return  void
	 * @since  5.0.2
	 */
	public function reset(): void
	{
		// clear the message bus
		$this->success = [];
		$this->info = [];
		$this->error = [];

		$this->guid = null;
		$this->entity = null;
		$this->table = null;
	}

	/**
	 * Archive the messages in the DB of the last import event
	 *
	 * @return  self
	 * @throws \InvalidArgumentException if GUID, entity, or table is null.
	 * @since  5.0.2
	 */
	public function archive(): self
	{
		if (empty($this->guid) || empty($this->entity) || empty($this->table))
		{
			throw new \InvalidArgumentException('GUID, entity, and table must not be null or empty.');
		}

		// trash all messages from the past
		$this->update->table($this->table)->rows([['entity' => $this->guid, 'published' => -2]], 'entity');

		return $this;
	}

	/**
	 * Set the messages in the DB of the last import event
	 *
	 * @return  self
	 * @throws \InvalidArgumentException if GUID, entity, or table is null.
	 * @since  5.0.2
	 */
	public function set(): self
	{
		if (empty($this->guid) || empty($this->entity) || empty($this->table))
		{
			throw new \InvalidArgumentException('GUID, entity, and table must not be null or empty.');
		}

		// start message bucket
		$messages = [];

		// set the success messages
		if (!empty($this->success))
		{
			foreach ($this->success as $message)
			{
				$messages[] = [
					'guid' => GuidHelper::get(),
					'entity' => $this->guid,
					'entity_type' => $this->entity,
					'message' => $message,
					'message_status' => 1
				];
			}
		}

		// set the info messages
		if (!empty($this->info))
		{
			foreach ($this->info as $message)
			{
				$messages[] = [
					'guid' => GuidHelper::get(),
					'entity' => $this->guid,
					'entity_type' => $this->entity,
					'message' => $message,
					'message_status' => 2
				];
			}
		}

		// set the error messages
		if (!empty($this->error))
		{
			foreach ($this->error as $message)
			{
				$messages[] = [
					'guid' => GuidHelper::get(),
					'entity' => $this->guid,
					'entity_type' => $this->entity,
					'message' => $message,
					'message_status' => 3
				];
			}
		}

		$this->insert->table($this->table)->rows($messages);

		return $this;
	}

	/**
	 * Adds a success message to the log.
	 *
	 * This method records a success message for the import process. The message provides 
	 * relevant information, such as the number of rows processed and the success rate.
	 *
	 * @param string $message The success message to log.
	 *
	 * @return self
	 * @since  5.0.2
	 */
	public function addSuccess(string $message): self
	{
		$this->success[] = $message;

		return $this;
	}

	/**
	 * Adds a info message to the log.
	 *
	 * This method records a info message for the import process. The message provides 
	 * relevant information, such as the number of rows processed and the info rate.
	 *
	 * @param string $message The info message to log.
	 *
	 * @return self
	 * @since  5.0.2
	 */
	public function addInfo(string $message): self
	{
		$this->info[] = $message;

		return $this;
	}

	/**
	 * Adds an error message to the log.
	 *
	 * This method records an error message when the import process encounters issues. 
	 * The message includes details about the failures, such as the number of failed rows 
	 * and the corresponding error rate.
	 *
	 * @param string $message The error message to log.
	 *
	 * @return self
	 * @since  5.0.2
	 */
	public function addError(string $message): self
	{
		$this->error[] = $message;

		return $this;
	}
}

