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

namespace VDM\Joomla\Import;


use VDM\Joomla\Interfaces\Import\MessageInterface;


/**
 * Core Import Messages Class
 * 
 * @since  5.1.4
 */
class Message implements MessageInterface
{
	/**
	 * The success message bus.
	 *
	 * @var   array
	 * @since 5.1.4
	 */
	protected array $success = [];

	/**
	 * The info message bus.
	 *
	 * @var   array
	 * @since 5.1.4
	 */
	protected array $info = [];

	/**
	 * The error message bus.
	 *
	 * @var   array
	 * @since 5.1.4
	 */
	protected array $error = [];

	/**
	 * Get the messages of the last import event
	 *
	 * @return  object
	 * @since  5.1.4
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
	 * @since  5.1.4
	 */
	public function reset(): void
	{
		// clear the message bus
		$this->success = [];
		$this->info = [];
		$this->error = [];
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
	 * @since  5.1.4
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
	 * @since  5.1.4
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
	 * @since  5.1.4
	 */
	public function addError(string $message): self
	{
		$this->error[] = $message;

		return $this;
	}
}

