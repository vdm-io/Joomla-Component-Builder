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

namespace VDM\Joomla\Componentbuilder\Console;


use VDM\Joomla\Abstraction\Console\Import;


/**
 * Componentbuilder Item Import
 * 
 * @since  5.0.2
 */
class ItemImport extends Import
{
	/**
	 * The queue status field
	 *
	 * @var string
	 * @since  5.0.2
	 */
	protected string $queueStatusField = 'import_status';

	/**
	 * The queue awaiting status
	 *
	 * @var int
	 * @since  5.0.2
	 */
	protected int $queueWaitState = 1;

	/**
	 * The queue processing status
	 *
	 * @var int
	 * @since  5.0.2
	 */
	protected int $queueProcessingState = 2;

	/**
	 * The queue table name.
	 *
	 * @var string
	 * @since  5.0.2
	 */
	protected string $queueTable = 'item_import';

	/**
	 * The main import target name.
	 *
	 * @var string
	 * @since  5.0.2
	 */
	protected string $targetName = 'item';

	/**
	 * The target import class to be pulled from the Import Factory class.
	 *
	 * @var string
	 * @since  5.0.2
	 */
	protected string $targetImportClass = 'Item.Import';

	/**
	 * The default command name.
	 *
	 * @var string
	 * @since  5.0.2
	 */
	protected static $defaultName = 'componentbuilder:Item:import';
}

