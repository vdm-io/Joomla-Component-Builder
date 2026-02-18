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


/**
 * Import Message Interface
 * 
 * @since  5.1.4
 */
interface MessageInterface
{
	/**
	 * Get the messages of the last import event
	 *
	 * @return  object
	 * @since  3.0.2
	 */
	public function get(): object;

	/**
	 * Reset the messages of the last import event
	 *
	 * @return  void
	 * @since  3.0.2
	 */
	public function reset(): void;

	/**
	 * Adds a success message to the log.
	 *
	 * This method records a success message for the import process. The message provides 
	 * relevant information, such as the number of rows processed and the success rate.
	 *
	 * @param string $message The success message to log.
	 *
	 * @return self
	 * @since  3.0.2
	 */
	public function addSuccess(string $message): self;

	/**
	 * Adds a info message to the log.
	 *
	 * This method records a info message for the import process. The message provides 
	 * relevant information, such as the number of rows processed and the info rate.
	 *
	 * @param string $message The info message to log.
	 *
	 * @return self
	 * @since  3.0.2
	 */
	public function addInfo(string $message): self;

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
	 * @since  3.0.2
	 */
	public function addError(string $message): self;
}

