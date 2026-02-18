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
 * Init Command (base for all init:* entity commands).
 * 
 * Calls: Get::init(string $entity, array $items, ?object $repo, bool $force): array
 * 
 * Notes:
 *  - init expects GUIDs (strict by default).
 *  - Use --resolve (or ENV JCB_GET_RESOLVE=1) to resolve invalid GUIDs instead of failing.
 * 
 * @since  5.1.4
 */
final class Init extends Get
{
	/**
	 * Configure the init command.
	 *
	 * @return void
	 * @since  5.1.4
	 */
	protected function configure(): void
	{
		$entity = StringHelper::safe($this->getEntity(), 'w');
		$this->setDescription("Initialize and synchronize {$entity} from a remote package repository.");

		$this->setHelp(
<<<EOF
Initialize and synchronize {$entity} items from remote repositories.

Inputs:
  --items / -i       CSV, newline-separated, or JSON array. Supports @/path/to/file
  --items-file       Path to file containing items (CSV/newlines/JSON)
  --repo / -r        Repository JSON object. Supports @/path/to/file
  --repo-file        Path to file containing repository JSON
  --force / -f       Force overwrite/re-fetch
  --resolve          Non-GUID values are resolved using the entity's configured helper key

Environment fallbacks:
  JCB_GET_ITEMS
  JCB_GET_ITEMS_FILE
  JCB_GET_REPO
  JCB_GET_REPO_FILE
  JCB_GET_FORCE
  JCB_GET_RESOLVE
EOF
		);

		$this->addSharedOptions();
	}

	/**
	 * Execute init.
	 *
	 * @param   InputInterface   $input   The input to inject into the command.
	 * @param   OutputInterface  $output  The output to inject into the command.
	 *
	 * @return  int
	 * @since   5.1.4
	 */
	protected function doExecuteAction(InputInterface $input, OutputInterface $output): int
	{
		$items    = $this->resolveItems($input);
		$repo     = $this->resolveRepo($input);
		$force    = $this->resolveForce($input);
		$resolve = $this->resolveValidate($input);

		if ($items === [])
		{
			throw new \InvalidArgumentException('No items were provided. Use --items, --items-file, or environment variables.');
		}

		if ($resolve)
		{
			$filtered = $this->get()->getValidGuids($this->getEntity(), $items);

			if ($filtered === [])
			{
				throw new \InvalidArgumentException('All provided items were invalid GUIDs after resolution.');
			}

			if (count($filtered) !== count($items))
			{
				$this->io->warning('Some invalid GUIDs were removed during resolution.');
			}

			$items = $filtered;
		}

		$this->io->section('Init Request');
		$this->io->definitionList(
			['Entity' => $this->getEntity()],
			['Items' => count($items)],
			['Force' => $force ? 'yes' : 'no'],
			['Repository' => $repo ? 'custom' : 'default'],
			['Resolve' => $resolve ? 'yes' : 'no']
		);

		$results = $this->get()->init($this->getEntity(), $items, $repo, $force);

		$this->renderCategorizedResults('Init Results', $results);

		$timestamp = date('Y-m-d H:i:s');
		$this->io->success('Init completed at ' . $timestamp . '.');

		return 0;
	}
}

