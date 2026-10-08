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

namespace VDM\Joomla\Componentbuilder\Extrusion\Abstraction;


use VDM\Joomla\Componentbuilder\Extrusion\Discovery\Scanner;
use VDM\Joomla\Componentbuilder\Extrusion\Discovery\Selector;
use VDM\Joomla\Componentbuilder\Extrusion\Layout\Heuristic;
use VDM\Joomla\Componentbuilder\Extrusion\Registry\Report;
use VDM\Joomla\Componentbuilder\Extrusion\Registry\Source;
use VDM\Joomla\Componentbuilder\Extrusion\Interfaces\LocatorInterface;


/**
 * Shared three-tier location mechanics.
 * 
 * Tier one asks the selected layout where the artifact should be. Tier two takes
 * a bounded scan for the right extension. Tier three classifies what tier two
 * found by looking inside it. A miss at tier one is normal, not fatal, so the
 * tiers always run in order and each match records which tier produced it.
 * 
 * @since 6.1.6
 */
abstract class Locator implements LocatorInterface
{
	/**
	 * The Scanner Class.
	 *
	 * @var    Scanner
	 * @since  6.1.6
	 */
	protected Scanner $scanner;

	/**
	 * The Selector Class.
	 *
	 * @var    Selector
	 * @since  6.1.6
	 */
	protected Selector $selector;

	/**
	 * The Heuristic Class.
	 *
	 * @var    Heuristic
	 * @since  6.1.6
	 */
	protected Heuristic $heuristic;

	/**
	 * The Source Registry.
	 *
	 * @var    Source
	 * @since  6.1.6
	 */
	protected Source $source;

	/**
	 * The Report Registry.
	 *
	 * @var    Report
	 * @since  6.1.6
	 */
	protected Report $report;

	/**
	 * Constructor.
	 *
	 * @param   Scanner    $scanner    The bounded source scanner.
	 * @param   Selector   $selector   The layout selector.
	 * @param   Heuristic  $heuristic  The content-signature classifier.
	 * @param   Source     $source     The source identity registry.
	 * @param   Report     $report     The run report registry.
	 *
	 * @since   6.1.6
	 */
	public function __construct(
		Scanner $scanner,
		Selector $selector,
		Heuristic $heuristic,
		Source $source,
		Report $report
	)
	{
		$this->scanner = $scanner;
		$this->selector = $selector;
		$this->heuristic = $heuristic;
		$this->source = $source;
		$this->report = $report;
	}

	/**
	 * The file extensions this locator's artifact uses.
	 *
	 * @return  array<string>  Lower-case extensions without the dot.
	 * @since   6.1.6
	 */
	abstract protected function extensions(): array;

	/**
	 * The component option, when it is known.
	 *
	 * @return  string  The com_ prefixed option, or an empty string.
	 * @since   6.1.6
	 */
	protected function option(): string
	{
		return (string) $this->source->get('code_name', '');
	}

	/**
	 * The token set every layout pattern is expanded with.
	 *
	 * @param   array<string, string>  $extra  Additional tokens.
	 *
	 * @return  array<string, string>  The token set.
	 * @since   6.1.6
	 */
	protected function tokens(array $extra = []): array
	{
		return array_merge(
			[
				'option' => $this->option(),
				'tag' => 'en-GB'
			],
			$extra
		);
	}

	/**
	 * Tier one: resolve the layout's own candidate paths.
	 *
	 * @param   string                 $root    The resolved source root.
	 * @param   string                 $kind    The layout artifact kind.
	 * @param   array<string, string>  $tokens  Additional expansion tokens.
	 *
	 * @return  array<string>  Existing absolute paths.
	 * @since   6.1.6
	 */
	protected function mapped(string $root, string $kind, array $tokens = []): array
	{
		$found = [];
		$layout = $this->selector->layout();

		foreach ($layout->candidates($kind, $this->tokens($tokens)) as $relative)
		{
			$path = $this->scanner->resolve($root, $relative);

			if ($path !== null)
			{
				$found[$path] = true;
			}
		}

		return array_keys($found);
	}

	/**
	 * Tier two: a bounded scan for this locator's extensions.
	 *
	 * @param   string  $root  The resolved source root.
	 *
	 * @return  array<string>  Absolute candidate paths.
	 * @since   6.1.6
	 */
	protected function scanned(string $root): array
	{
		return $this->scanner->files($root, $this->extensions());
	}

	/**
	 * Build one located entry.
	 *
	 * @param   string       $path  The absolute artifact path.
	 * @param   string       $tier  The discovery tier that found it.
	 * @param   string|null  $name  The artifact name, when meaningful.
	 *
	 * @return  array{path: string, tier: string, name: string|null}  The located entry.
	 * @since   6.1.6
	 */
	protected function entry(string $path, string $tier, ?string $name = null): array
	{
		return ['path' => $path, 'tier' => $tier, 'name' => $name];
	}

	/**
	 * Record what this locator found, or that it found nothing.
	 *
	 * @param   array<int, array{path: string, tier: string, name: string|null}>  $found  Located artifacts.
	 *
	 * @return  array<int, array{path: string, tier: string, name: string|null}>  The same list.
	 * @since   6.1.6
	 */
	protected function recorded(array $found): array
	{
		if ($found === [])
		{
			$this->report->set('located.' . $this->kind() . '.missing', true);

			return $found;
		}

		foreach ($found as $index => $entry)
		{
			$this->report->set('located.' . $this->kind() . '.' . $index . '.path', $entry['path']);
			$this->report->set('located.' . $this->kind() . '.' . $index . '.tier', $entry['tier']);
		}

		return $found;
	}
}

