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

namespace VDM\Joomla\Componentbuilder\Console\Package;


use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use VDM\Joomla\Utilities\GuidHelper;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Componentbuilder\Abstraction\Console\Package\Set;


/**
 * Push Command.
 * 
 * Pushes local entities and their dependencies to a remote repository.
 * 
 * This command:
 * - Uses the Package.Builder.Set endpoint
 * - Pushes items synchronously
 * - Collects messages from the MessageBus
 * - Outputs warnings, errors, and success messages to the CLI
 * 
 * @since 5.1.4
 */
final class Push extends Set
{
	/**
	 * Configure the push command.
	 *
	 * @return void
	 * @since  5.1.4
	 */
	protected function configure(): void
	{
		$entity = StringHelper::safe($this->getEntity(), 'w');
		$this->setDescription(
			"Push {$entity} entities to a remote package repository."
		);

		$this->setHelp(
<<<EOF
Push {$entity} and all detected dependencies to a remote package repository.

Items may be provided via:
  --items        CSV, newline-separated, or JSON array
  --items-file   File containing items (CSV, newline, or JSON)
  ENV            JCB_GET_ITEMS / JCB_GET_ITEMS_FILE

Notes:
  - Items must be valid global unique IDs (GUIDs).
  - The command blocks until the push operation completes.
  - Dependency resolution is handled automatically.
EOF
		);

		// Push only needs items
		$this->addSharedOptions();
	}

	/**
	 * Execute the push action.
	 *
	 * @param   InputInterface   $input   The input to inject into the command.
	 * @param   OutputInterface  $output  The output to inject into the command.
	 *
	 * @return  int
	 * @since   5.1.4
	 */
	protected function doExecuteAction(InputInterface $input, OutputInterface $output): int
	{
		// Resolve and validate items
		$items = $this->resolveItems($input);

		if ($items === [])
		{
			throw new \InvalidArgumentException(
				'No items provided. Use --items, --items-file, or environment variables.'
			);
		}

		// Announce intent
		$this->io->section('Push Request');
		$this->io->definitionList(
			['Entity' => $this->getEntity()],
			['Items'  => count($items)]
		);

		// Perform push (synchronous)
		$this->set()->items($this->getEntity(), $items);

		return 0;
	}
}

