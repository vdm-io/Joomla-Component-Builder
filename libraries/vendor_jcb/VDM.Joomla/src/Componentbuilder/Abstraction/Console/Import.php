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

namespace VDM\Joomla\Componentbuilder\Abstraction\Console;


use Joomla\CMS\Factory;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use VDM\Joomla\Componentbuilder\Import\Factory as ImportFactory;
use VDM\Joomla\Interfaces\Import\ItemProcessInterface as ImportEngine;
use VDM\Joomla\Interfaces\Import\PersistentEntityInterface as Entity;
use VDM\Joomla\Interfaces\Data\ItemsInterface as Items;
use VDM\Joomla\Utilities\Component\Helper;
use VDM\Joomla\Abstraction\Console;


/**
 * Console Import
 * 
 * @since  5.0.2
 */
abstract class Import extends Console
{
	/**
	 * The Items Class.
	 *
	 * @var   Items
	 * @since 5.0.2
	 */
	protected Items $items;

	/**
	 * The Import Class.
	 *
	 * @var   ImportEngine
	 * @since 5.0.2
	 */
	protected ImportEngine $import;

	/**
	 * The Entity Class.
	 *
	 * @var   Entity
	 * @since 5.1.4
	 */
	protected Entity $entity;

	/**
	 * The main import target name.
	 *
	 * @var string
	 * @since  5.0.2
	 */
	protected string $targetName;

	/**
	 * The default command name.
	 *
	 * @var string
	 * @since  5.0.2
	 */
	protected static $defaultName;

	/**
	 * The target import class.
	 *
	 * @var string
	 * @since  5.0.2
	 */
	protected string $targetImportClass;

	/**
	 * The target items class.
	 *
	 * @var string
	 * @since  5.1.4
	 */
	protected string $targetItemsClass;

	/**
	 * The target entity class.
	 *
	 * @var string
	 * @since  5.1.4
	 */
	protected string $targetEntityClass;

	/**
	 * Configures the CLI command, setting up the description and help text.
	 *
	 * This command parses the import queue and imports items that are still in the queue.
	 * It is useful for automatically processing pending item imports in the virtual warehouse.
	 *
	 * @return void
	 * @since  5.0.2
	 */
	protected function configure(): void
	{
		// make sure we know what component we are working with
		Helper::setOption('com_componentbuilder');

		// Load administrator language file for backend
		$lang = Factory::getLanguage();
		$lang->load('com_componentbuilder', JPATH_ADMINISTRATOR);

		$this->items = ImportFactory::_($this->targetItemsClass);
		$this->import = ImportFactory::_($this->targetImportClass);
		$this->entity = ImportFactory::_($this->targetEntityClass);

		$this->setDescription("Processes the import queue and {$this->targetName} imports all spreadsheets that are still in the queue.");
		$this->setHelp(
<<<EOF
The <info>%command.name%</info> command parses the import queue and processes all {$this->targetName} spreadsheets that are still pending import.
This is useful for keeping the system up-to-date with incoming data.

Usage:
<info>php joomla.php %command.name%</info>
EOF);
	}

	/**
	 * Executes the CLI command, processing each spreadsheet in the import queue.
	 *
	 * @param   InputInterface   $input   The input to inject into the command.
	 * @param   OutputInterface  $output  The output to inject into the command.
	 *
	 * @return  int  The command exit code (0 for success).
	 * @since   5.0.2
	 */
	protected function doExecute(InputInterface $input, OutputInterface $output): int
	{
		$io = new SymfonyStyle($input, $output);

		// Output the title for the task
		$io->title("Component Builder: {$this->targetName} import status");

		// Get all imports in the queue that are in waiting state
		if (($queue = $this->items->table($this->entity->getQueueTable())->get([$this->entity->getQueueWaitState()], $this->entity->getQueueStatusField())) === null)
		{
			// Get the current date and time
			$timestamp = date('Y-m-d H:i:s');

			// Output the notice of no imports to be done
			$io->info("No {$this->targetName} imports found in the queue. Idle at {$timestamp}.");

			return 0;
		}

		// take spreadsheets out of queue
		$this->items->table($this->entity->getQueueTable())->set(array_map(function($item) {
			return [
				'guid' => $item->guid,
				$this->entity->getQueueStatusField() => $this->entity->getQueueProcessingState()
			];
		}, $queue));

		// size of the queue
		$numberSteps = count((array) $queue);

		// Output initial task information
		$io->info("Initiating import for {$numberSteps} {$this->targetName} spreadsheet(s) in the queue.");
		$io->newLine(2);

		// Create a progress bar for the overall import process
		$progressBar = $io->createProgressBar($numberSteps);
		$progressBar->start();

		// Track success and failure counts
		$successCount = 0;
		$failureCount = 0;

		// Import one spreadsheet at a time
		foreach ($queue as $spreadsheet)
		{
			$io->newLine(2);

			// Output the current spreadsheet being processed
			$io->section("Processing spreadsheet #{$spreadsheet->guid}...");

			// Import the data found in the spreadsheet & Get the completion message
			$completion = $this->import->execute($spreadsheet)->result();

			// Track success based on completion message
			if ($completion->message_success)
			{
				$successCount++;

				// Output the success message for this spreadsheet
				$io->success($completion->message_success);
			}

			// Track failure based on completion message
			if ($completion->message_error)
			{
				$failureCount++;

				// Output the error message for this spreadsheet
				$io->error($completion->message_error);
			}

			// Advance the main progress bar by one step
			sleep(1);
			$progressBar->advance();
			$io->newLine(1);
		}

		// Finish the main progress bar
		$progressBar->finish();
		$io->newLine(2);

		// Calculate the success and failure percentages
		$totalProcessed = $successCount + $failureCount;
		$successRate = ($totalProcessed > 0) ? round(($successCount / $totalProcessed) * 100) : 0;
		$failureRate = ($totalProcessed > 0) ? round(($failureCount / $totalProcessed) * 100) : 0;

		// Get the current date and time
		$timestamp = date('Y-m-d H:i:s');

		// Output the success and failure summary with the timestamp
		$io->info("The {$this->targetName} import finished: {$successRate}% success, {$failureRate}% failure. Completed at {$timestamp}.");

		$io->newLine(1);

		return 0;
	}
}

