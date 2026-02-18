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
 * Abstract Reset Command (base for all reset:* entity commands).
 * 
 * Calls: Get::reset(string $entity, array $items): void
 * 
 * Notes:
 * - reset is destructive-ish (it changes local state), so it is strict:
 *   - Items are REQUIRED
 *   - Items MUST be valid GUIDs, unless --resolve is set to filter
 * 
 * @since 5.1.4
 */
final class Reset extends Get
{
	/**
	 * Configure the reset command.
	 *
	 * @return void
	 * @since  5.1.4
	 */
	protected function configure(): void
	{
		$entity = StringHelper::safe($this->getEntity(), 'w');
		$this->setDescription("Reset local tracking/state for {$entity} items (GUIDs required).");

		$this->setHelp(
<<<EOF
Reset local tracking/state for specific {$entity} items.

Inputs:
  --items / -i       CSV, newline-separated, or JSON array. Supports @/path/to/file
  --items-file       Path to file containing items (CSV/newlines/JSON)
  --resolve          Non-GUID values are resolved using the entity's configured helper key

Environment fallbacks:
  JCB_GET_ITEMS
  JCB_GET_ITEMS_FILE
  JCB_GET_RESOLVE

Safety:
  Reset requires explicit item GUIDs. It will not run with an empty item set.
EOF
		);

		$this->addSharedOptions(['repo', 'repo-file', 'force']);
	}

	/**
	 * Execute reset.
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
		$resolve = $this->resolveValidate($input);

		if ($items === [])
		{
			throw new \InvalidArgumentException('Reset requires explicit items. Use --items, --items-file, or environment variables.');
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

		$this->io->section('Reset Request');
		$this->io->definitionList(
			['Entity' => $this->getEntity()],
			['Items' => count($items)],
			['Resolve' => $resolve ? 'yes' : 'no']
		);

		$this->get()->reset($this->getEntity(), $items);

		$timestamp = date('Y-m-d H:i:s');
		$this->io->success('Reset completed at ' . $timestamp . '.');

		return 0;
	}
}

