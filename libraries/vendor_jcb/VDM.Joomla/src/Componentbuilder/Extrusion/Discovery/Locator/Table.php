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
 * Finds a JCB table definition class purely by signature.
 * 
 * This artifact has no predictable location. A JCB-built component keeps its
 * table definition class wherever that project's power namespace resolves to, so
 * the compiler's placement map offers no shortcut and only the third discovery
 * tier applies. That is not a weakness: a file found by signature can still be
 * the highest-precedence source in the run, and this one is.
 * 
 * The signature is a class with an extends clause that also declares a tables
 * array property. Whether the map is actually usable is decided later by the
 * literal-only reader, which refuses anything it cannot parse safely.
 * 
 * @since 6.1.6
 */
final class Table extends Locator
{
	/**
	 * Marks a class that declares itself part of the table definition family.
	 *
	 * A file matching this is ranked ahead of a bare signature match, because the
	 * interface is a stronger statement of intent than the property alone.
	 *
	 * @var    string
	 * @since  6.1.6
	 */
	private const FAMILY = '/\bimplements\b[^{;]*\bTableInterface\b/';

	/**
	 * The artifact kind this locator is responsible for.
	 *
	 * @return  string  The artifact kind key.
	 * @since   6.1.6
	 */
	public function kind(): string
	{
		return 'table_class';
	}

	/**
	 * The file extensions this locator's artifact uses.
	 *
	 * @return  array<string>  Lower-case extensions without the dot.
	 * @since   6.1.6
	 */
	protected function extensions(): array
	{
		return ['php'];
	}

	/**
	 * Locate every table definition class below a source root.
	 *
	 * @param   string  $root  The resolved source root.
	 *
	 * @return  array<int, array{path: string, tier: string, name: string|null}>  Located artifacts.
	 * @since   6.1.6
	 */
	public function locate(string $root): array
	{
		$preferred = [];
		$candidates = [];

		foreach ($this->scanned($root) as $path)
		{
			$content = $this->scanner->read($path);

			if ($content === null || !$this->heuristic->isTableClass($content))
			{
				continue;
			}

			$entry = $this->entry($path, 'signature');

			if (preg_match(self::FAMILY, $content) === 1)
			{
				$preferred[] = $entry;

				continue;
			}

			$candidates[] = $entry;
		}

		return $this->recorded(array_merge($preferred, $candidates, $this->central($root)));
	}

	/**
	 * The central table definition class an installed site keeps for this component.
	 *
	 * A component folder holds its table definition class only while it
	 * travels as an install package. Once installed, the class lives where the
	 * project's power namespace resolves to -- a vendor library under the
	 * site's own libraries folder -- so a harvest aimed at an installed
	 * JCB-built component would otherwise never see the highest-precedence
	 * source it ships, and with it the stated identity of every field. The
	 * probes are bounded to the vendor layout the compiler itself writes, and
	 * only a folder named for this very component may answer, because another
	 * component's map read as this one's would poison every column it names.
	 *
	 * @param   string  $root  The resolved source root.
	 *
	 * @return  array<int, array{path: string, tier: string, name: string|null}>  Located artifacts.
	 * @since   6.1.9
	 */
	protected function central(string $root): array
	{
		$code = strtolower(trim(str_replace('com_', '', $this->option())));
		$parent = strtolower(basename(dirname($root)));

		if ($code === '' || $parent !== 'components')
		{
			return [];
		}

		$site = dirname($root, 2);

		if (strtolower(basename($site)) === 'administrator')
		{
			$site = dirname($site);
		}

		$found = [];

		foreach (['/libraries/*/*/src/*/Table.php', '/libraries/*/*/src/*/*/Table.php'] as $pattern)
		{
			foreach (glob($site . $pattern, GLOB_NOSORT) ?: [] as $path)
			{
				if (strtolower(basename(dirname($path))) !== $code)
				{
					continue;
				}

				$content = $this->scanner->read($path);

				if ($content === null || !$this->heuristic->isTableClass($content))
				{
					continue;
				}

				$found[$path] = $this->entry($path, 'central');
			}
		}

		return array_values($found);
	}
}

