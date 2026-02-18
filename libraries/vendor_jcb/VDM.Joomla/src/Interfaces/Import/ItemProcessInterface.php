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
 * Item import process contract.
 * 
 * Represents an executable import unit for a single item.
 * Implementations control how the import is executed and how
 * its outcome is managed (e.g. transient or persistent).
 * 
 * @since 5.1.4
 */
interface ItemProcessInterface
{
	/**
	 * Execute the import process.
	 *
	 * Executes the import using the given payload and returns
	 * the current process instance for fluent interaction.
	 *
	 * @param  object  $payload  The import payload.
	 *
	 * @return  self
	 * @since   5.1.4
	 */
	public function execute(object $payload): self;

	/**
	 * Get the result of the last import execution.
	 *
	 * @return  object
	 * @since   5.1.4
	 */
	public function result(): object;
}

