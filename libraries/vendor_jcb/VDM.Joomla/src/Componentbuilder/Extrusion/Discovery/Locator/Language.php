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
 * Finds the component's language catalogue.
 * 
 * The main file is ordered before the system file, because the reader lets the
 * first value for a constant win and the main catalogue is the better source.
 * 
 * @since 6.1.6
 */
final class Language extends Locator
{
	/**
	 * The artifact kind this locator is responsible for.
	 *
	 * @return  string  The artifact kind key.
	 * @since   6.1.6
	 */
	public function kind(): string
	{
		return 'language';
	}

	/**
	 * The file extensions this locator's artifact uses.
	 *
	 * @return  array<string>  Lower-case extensions without the dot.
	 * @since   6.1.6
	 */
	protected function extensions(): array
	{
		return ['ini'];
	}

	/**
	 * Locate every language file below a source root.
	 *
	 * @param   string  $root  The resolved source root.
	 *
	 * @return  array<int, array{path: string, tier: string, name: string|null}>  Located artifacts.
	 * @since   6.1.6
	 */
	public function locate(string $root): array
	{
		$tag = (string) $this->source->get('tag', 'en-GB');
		$found = [];

		foreach (['language_file', 'language_sys'] as $kind)
		{
			foreach ($this->mapped($root, $kind, ['tag' => $tag]) as $path)
			{
				$found[$path] = $this->entry($path, 'map', $tag);
			}
		}

		if ($found === [])
		{
			$option = $this->option();
			$main = [];
			$system = [];

			foreach ($this->scanned($root) as $path)
			{
				if (!$this->heuristic->isLanguage($this->scanner->read($path) ?? '', $option))
				{
					continue;
				}

				if (str_contains(strtolower(basename($path)), '.sys.'))
				{
					$system[$path] = $this->entry($path, 'signature', $tag);

					continue;
				}

				$main[$path] = $this->entry($path, 'signature', $tag);
			}

			$found = $main + $system;
		}

		// an installed component keeps its catalogue in the site's central
		// language folders, outside the component's own folder entirely
		$found += $this->central($root);

		return $this->recorded(array_values($found));
	}

	/**
	 * The central language files an installed site keeps for this component.
	 *
	 * A component folder holds its own language files only while it travels as
	 * an install package. Once installed, Joomla moves the catalogue to
	 * administrator/language/<tag>/ and language/<tag>/ under the site root --
	 * so a harvest aimed at an installed component would otherwise never see
	 * a single constant resolved. The probes are exact file names for exactly
	 * this component, never a scan of the site.
	 *
	 * @param   string  $root  The resolved source root.
	 *
	 * @return  array<string, array{path: string, tier: string, name: string|null}>  Located artifacts by path.
	 * @since   6.1.8
	 */
	protected function central(string $root): array
	{
		$option = strtolower(trim((string) $this->option()));
		$parent = strtolower(basename(dirname($root)));

		if ($option === '' || $parent !== 'components')
		{
			return [];
		}

		$tag = (string) $this->source->get('tag', 'en-GB');
		$site = dirname($root, 2);

		if (strtolower(basename($site)) === 'administrator')
		{
			$site = dirname($site);
		}

		$folders = [
			$site . '/administrator/language/' . $tag,
			$site . '/language/' . $tag
		];
		$names = [
			$option . '.ini',
			$tag . '.' . $option . '.ini',
			$option . '.sys.ini',
			$tag . '.' . $option . '.sys.ini'
		];
		$found = [];

		foreach ($folders as $folder)
		{
			foreach ($names as $name)
			{
				$path = $folder . '/' . $name;

				if (is_file($path))
				{
					$found[$path] = $this->entry($path, 'central', $tag);
				}
			}
		}

		return $found;
	}
}

