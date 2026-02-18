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


use VDM\Joomla\Interfaces\Import\MessageInterface;


/**
 * Import Database Message Interface
 * 
 * @since  3.0.2
 */
interface DatabaseMessageInterface extends MessageInterface
{
	/**
	 * Load an entity that these message belong to
	 *
	 * @param string $guid   The entity guid these messages must be linked to.
	 * @param string $entity The entity type these messages must be linked to.
	 * @param string $table  The messages table where these message must be stored.
	 *
	 * @return  self
	 * @throws \InvalidArgumentException if any of the parameters are null or empty.
	 * @since  3.0.2
	 */
	public function load(string $guid, string $entity, string $table): self;

	/**
	 * Archive the messages in the DB of the last import event
	 *
	 * @return  self
	 * @throws \InvalidArgumentException if GUID, entity, or table is null.
	 * @since  3.0.2
	 */
	public function archive(): self;

	/**
	 * Set the messages in the DB of the last import event
	 *
	 * @return  self
	 * @throws \InvalidArgumentException if GUID, entity, or table is null.
	 * @since  3.0.2
	 */
	public function set(): self;
}

