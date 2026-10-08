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
 * Finds the component's form XML, one per view.
 * 
 * The located name is the view name, taken from the file name, because that is
 * what ties a form to its database table.
 * 
 * @since 6.1.6
 */
final class Form extends Locator
{
	/**
	 * The artifact kind this locator is responsible for.
	 *
	 * @return  string  The artifact kind key.
	 * @since   6.1.6
	 */
	public function kind(): string
	{
		return 'form';
	}

	/**
	 * The file extensions this locator's artifact uses.
	 *
	 * @return  array<string>  Lower-case extensions without the dot.
	 * @since   6.1.6
	 */
	protected function extensions(): array
	{
		return ['xml'];
	}

	/**
	 * Locate every form file below a source root.
	 *
	 * @param   string  $root  The resolved source root.
	 *
	 * @return  array<int, array{path: string, tier: string, name: string|null}>  Located artifacts.
	 * @since   6.1.6
	 */
	public function locate(string $root): array
	{
		$found = [];

		foreach (['form_dir', 'site_form_dir'] as $kind)
		{
			foreach ($this->mapped($root, $kind) as $directory)
			{
				foreach ((array) @glob($directory . '/*.xml') as $path)
				{
					$contained = is_string($path) ? $this->scanner->contain($root, $path) : null;

					if ($contained === null)
					{
						continue;
					}

					if ($this->heuristic->isForm($this->scanner->read($contained) ?? ''))
					{
						$found[$contained] = $this->entry($contained, 'map', $this->name($contained));
					}
				}
			}
		}

		if ($found === [])
		{
			foreach ($this->scanned($root) as $path)
			{
				if ($this->heuristic->isForm($this->scanner->read($path) ?? ''))
				{
					$found[$path] = $this->entry($path, 'signature', $this->name($path));
				}
			}
		}

		return $this->recorded(array_values($found));
	}

	/**
	 * The view name a form file belongs to.
	 *
	 * @param   string  $path  Absolute path to the form file.
	 *
	 * @return  string  The lower-case view name.
	 * @since   6.1.6
	 */
	public function name(string $path): string
	{
		return strtolower(pathinfo($path, PATHINFO_FILENAME));
	}
}

