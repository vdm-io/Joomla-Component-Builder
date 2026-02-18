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
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Componentbuilder\Abstraction\Console\Package\Get as ExtendingGet;


/**
 * Get Command (base for all get:* entity commands).
 * 
 * Calls: Get::get(string $entity, array $items): array
 * 
 * Notes:
 * - get may accept aliases and does its own GUID resolution (entity-specific).
 * - Therefore, this command DOES NOT strictly require GuidHelper::valid() on items.
 * - If results are completely empty, a warning is shown (often means inputs were invalid/unresolvable).
 * 
 * @since 5.1.4
 */
final class Get extends ExtendingGet
{
	/**
	 * Configure the get command.
	 *
	 * @return void
	 * @since  5.1.4
	 */
	protected function configure(): void
	{
		$entity = StringHelper::safe($this->getEntity(), 'w');
		$this->setDescription("Get and synchronize {$entity} (supports alias resolution where applicable).");

		$this->setHelp(
<<<EOF
Get and synchronize {$entity} items from remote repositories.

Inputs:
  --items / -i       CSV, newline-separated, or JSON array. Supports @/path/to/file
  --items-file       Path to file containing items (CSV/newlines/JSON)

Environment fallbacks:
  JCB_GET_ITEMS
  JCB_GET_ITEMS_FILE

Notes:
  This command intentionally does not enforce GUID-only items because some entities
  support alias-to-GUID resolution internally.
EOF
		);

		$this->addSharedOptions(['repo', 'repo-file', 'force', 'resolve']);
	}

	/**
	 * Execute get.
	 *
	 * @param   InputInterface   $input   The input to inject into the command.
	 * @param   OutputInterface  $output  The output to inject into the command.
	 *
	 * @return  int
	 * @since   5.1.4
	 */
	protected function doExecuteAction(InputInterface $input, OutputInterface $output): int
	{
		$items = $this->resolveItems($input);

		if ($items === [])
		{
			throw new \InvalidArgumentException('No items were provided. Use --items, --items-file, or environment variables.');
		}

		$this->io->section('Get Request');
		$this->io->definitionList(
			['Entity' => $this->getEntity()],
			['Items' => count($items)]
		);

		$results = $this->get()->get($this->getEntity(), $items);

		$this->renderCategorizedResults('Get Results', $results);

		$local    = (array) ($results['local'] ?? []);
		$notFound = (array) ($results['not_found'] ?? []);
		$added    = (array) ($results['added'] ?? []);

		if ($local === [] && $notFound === [] && $added === [])
		{
			$this->io->warning(
				'No results were returned. This often indicates invalid or unresolvable identifiers for this entity.'
			);
		}

		$timestamp = date('Y-m-d H:i:s');
		$this->io->success('Get completed at ' . $timestamp . '.');

		return 0;
	}
}

