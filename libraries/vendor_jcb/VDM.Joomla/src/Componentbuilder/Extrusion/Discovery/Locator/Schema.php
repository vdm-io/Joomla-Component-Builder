<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    17th August, 2026
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Extrusion\Discovery\Locator;


use VDM\Joomla\Componentbuilder\Extrusion\Abstraction\Locator;


/**
 * Finds the component's install schema, the single most important artifact.
 * 
 * @since 6.1.6
 */
final class Schema extends Locator
{
	/**
	 * The artifact kind this locator is responsible for.
	 *
	 * @return  string  The artifact kind key.
	 * @since   6.1.6
	 */
	public function kind(): string
	{
		return 'schema';
	}

	/**
	 * The file extensions this locator's artifact uses.
	 *
	 * @return  array<string>  Lower-case extensions without the dot.
	 * @since   6.1.6
	 */
	protected function extensions(): array
	{
		return ['sql'];
	}

	/**
	 * Locate every schema file below a source root.
	 *
	 * @param   string  $root  The resolved source root.
	 *
	 * @return  array<int, array{path: string, tier: string, name: string|null}>  Located artifacts.
	 * @since   6.1.6
	 */
	public function locate(string $root): array
	{
		$found = [];

		foreach ($this->mapped($root, 'schema') as $path)
		{
			$found[$path] = $this->entry($path, 'map');
		}

		if ($found === [])
		{
			foreach ($this->scanned($root) as $path)
			{
				if ($this->heuristic->isSchema($this->scanner->read($path) ?? ''))
				{
					$tier = str_contains($path, '/sql/') ? 'scan' : 'signature';
					$found[$path] = $this->entry($path, $tier);
				}
			}
		}

		return $this->recorded(array_values($found));
	}
}

