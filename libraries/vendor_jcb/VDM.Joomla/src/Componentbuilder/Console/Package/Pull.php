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
use VDM\Joomla\Componentbuilder\Abstraction\Console\Package\Get;


/**
 * Pull Command (base for all pull:* entity commands).
 * 
 * Pull is a forced init:
 * - Always uses Get::init()
 * - Always passes $force = true
 * - Does NOT expose a --force option
 * 
 * This command is intended for:
 * - Explicit synchronization
 * - Overwriting local state unconditionally
 * 
 * @since 5.1.4
 */
final class Pull extends Get
{
	/**
	 * Configure the pull command.
	 *
	 * @return void
	 * @since  5.1.4
	 */
	protected function configure(): void
	{
		$entity = StringHelper::safe($this->getEntity(), 'w');
		$this->setDescription(
			"Pull and forcibly synchronize {$entity} from a remote package repository."
		);

		$this->setHelp(
<<<EOF
Pull and forcibly synchronize {$entity} items from remote repositories.

This command is equivalent to init with force enabled.
The force behaviour cannot be disabled.

Inputs:
  --items / -i       CSV, newline-separated, or JSON array. Supports @/path/to/file
  --items-file       Path to file containing items (CSV/newlines/JSON)
  --repo / -r        Repository JSON object. Supports @/path/to/file
  --repo-file        Path to file containing repository JSON
  --resolve          Non-GUID values are resolved using the entity's configured helper key

Environment fallbacks:
  JCB_GET_ITEMS
  JCB_GET_ITEMS_FILE
  JCB_GET_REPO
  JCB_GET_REPO_FILE
  JCB_GET_RESOLVE

Notes:
  - Force is always enabled.
  - Invalid GUIDs will fail unless --validate is used.
EOF
		);

		$this->addSharedOptions(['force']);
	}

	/**
	 * Execute pull (forced init).
	 *
	 * @param   InputInterface   $input
	 * @param   OutputInterface  $output
	 *
	 * @return  int
	 * @since   5.1.4
	 */
	protected function doExecuteAction(InputInterface $input, OutputInterface $output): int
	{
		$items    = $this->resolveItems($input);
		$repo     = $this->resolveRepo($input);
		$resolve = $this->resolveValidate($input);

		if ($items === [])
		{
			throw new \InvalidArgumentException(
				'No items were provided. Use --items, --items-file, or environment variables.'
			);
		}

		if ($resolve)
		{
			$filtered = $this->get()->getValidGuids($this->getEntity(), $items);

			if ($filtered === [])
			{
				throw new \InvalidArgumentException(
					'All provided items were invalid GUIDs after resolution.'
				);
			}

			if (count($filtered) !== count($items))
			{
				$this->io->warning('Some invalid GUIDs were removed during resolution.');
			}

			$items = $filtered;
		}

		$this->io->section('Pull Request');
		$this->io->definitionList(
			['Entity' => $this->getEntity()],
			['Items' => count($items)],
			['Force' => 'yes (implicit)'],
			['Repository' => $repo ? 'custom' : 'default'],
			['Resolve' => $resolve ? 'yes' : 'no']
		);

		$results = $this->get()->init(
			$this->getEntity(),
			$items,
			$repo,
			true // <- force is ALWAYS true
		);

		$this->renderCategorizedResults('Pull Results', $results);

		$timestamp = date('Y-m-d H:i:s');
		$this->io->success('Pull completed at ' . $timestamp . '.');

		return 0;
	}
}

