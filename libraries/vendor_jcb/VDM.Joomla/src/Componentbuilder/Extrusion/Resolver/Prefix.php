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

namespace VDM\Joomla\Componentbuilder\Extrusion\Resolver;


use VDM\Joomla\Componentbuilder\Extrusion\Registry\Report;
use VDM\Joomla\Componentbuilder\Extrusion\Registry\Schema;
use VDM\Joomla\Componentbuilder\Extrusion\Registry\Table;


/**
 * Recovers the component code name from the table names themselves.
 * 
 * A component that follows Joomla's own convention prefixes every one of its
 * tables with its own name, so a schema carrying two or more tables states its
 * component in the part they all share. That makes the code name recoverable from
 * a bare dump with no manifest, no folder and nothing the caller had to type,
 * which is the case the original dump-driven extruder could only handle because
 * the component form told it the name.
 * 
 * The shared part is taken at underscore boundaries rather than character by
 * character, because #__demo_widget and #__demo_widget_note share the characters
 * "demo_widget" while the component they belong to is "demo". Cutting anywhere
 * other than a boundary would invent a component name no component has.
 * 
 * A single table cannot testify to anything: its whole name is equally well one
 * prefix and one view, or no prefix and a compound view. Inference therefore
 * needs at least two tables that genuinely differ, and says so rather than
 * guessing from one.
 * 
 * @since 6.1.6
 */
final class Prefix
{
	/**
	 * The Schema Registry.
	 *
	 * @var    Schema
	 * @since  6.1.6
	 */
	protected Schema $schema;

	/**
	 * The Table Registry.
	 *
	 * @var    Table
	 * @since  6.1.6
	 */
	protected Table $table;

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
	 * @param   Schema  $schema  The parsed schema registry.
	 * @param   Table   $table   The table definition registry.
	 * @param   Report  $report  The run report registry.
	 *
	 * @since   6.1.6
	 */
	public function __construct(Schema $schema, Table $table, Report $report)
	{
		$this->schema = $schema;
		$this->table = $table;
		$this->report = $report;
	}

	/**
	 * The component option the known table names imply.
	 *
	 * @return  string  The com_ prefixed option, or an empty string when none is implied.
	 * @since   6.1.6
	 */
	public function option(): string
	{
		$prefix = $this->shared($this->names());

		if ($prefix === '')
		{
			return '';
		}

		$this->report->set('source.prefix', $prefix);

		return 'com_' . $prefix;
	}

	/**
	 * Whether the source looks like something JCB itself built.
	 *
	 * A table definition class settles it outright, because nothing but JCB writes
	 * one. Without that class the tell is the guid column: JCB gives every view it
	 * generates one, and a component built by hand almost never has a guid on every
	 * table. Both are recorded, because knowing which of the two answered says how
	 * much trust the answer deserves.
	 *
	 * @return  bool  True when the source carries JCB's own markers.
	 * @since   6.1.6
	 */
	public function jcb(): bool
	{
		if ((array) $this->table->get('table', []) !== [])
		{
			$this->report->set('source.jcb', 'a table definition class was found');

			return true;
		}

		$tables = (array) $this->schema->get('table', []);
		$guids = 0;

		foreach ($tables as $definition)
		{
			$columns = (array) (((array) $definition)['column'] ?? []);

			if (isset($columns['guid']))
			{
				$guids++;
			}
		}

		if ($tables !== [] && $guids === count($tables))
		{
			$this->report->set('source.jcb', 'every table carries a guid column');

			return true;
		}

		$this->report->set(
			'source.jcb',
			'no; ' . $guids . ' of ' . count($tables) . ' tables carry a guid column'
		);

		return false;
	}

	/**
	 * Every true table name the readers have established.
	 *
	 * @return  array<string>  The table names, without the Joomla prefix marker.
	 * @since   6.1.6
	 */
	public function names(): array
	{
		$names = [];

		foreach ([$this->schema, $this->table] as $registry)
		{
			foreach ((array) $registry->get('table', []) as $definition)
			{
				$name = ((array) $definition)['name'] ?? null;

				if (!is_string($name) || trim($name) === '')
				{
					continue;
				}

				$name = strtolower(trim($name));
				$name = preg_replace('/^#__/', '', $name) ?? $name;
				$names[$name] = true;
			}
		}

		return array_keys($names);
	}

	/**
	 * The longest whole-segment prefix every name shares.
	 *
	 * @param   array<string>  $names  The table names to compare.
	 *
	 * @return  string  The shared prefix without its trailing underscore.
	 * @since   6.1.6
	 */
	public function shared(array $names): string
	{
		$names = array_values(array_unique(array_filter($names, static fn ($name): bool => $name !== '')));

		if (count($names) < 2)
		{
			return '';
		}

		$shared = explode('_', $names[0]);

		foreach ($names as $name)
		{
			$shared = $this->common($shared, explode('_', $name));

			if ($shared === [])
			{
				return '';
			}
		}

		// Every segment shared means the names are identical, so nothing is left to
		// be a view name and the whole thing cannot be a prefix.
		if (count($shared) >= min(array_map(static fn (string $name): int => count(explode('_', $name)), $names)))
		{
			array_pop($shared);
		}

		return implode('_', $shared);
	}

	/**
	 * The leading segments two segment lists share.
	 *
	 * @param   array<string>  $left   The first segment list.
	 * @param   array<string>  $right  The second segment list.
	 *
	 * @return  array<string>  The shared leading segments.
	 * @since   6.1.6
	 */
	protected function common(array $left, array $right): array
	{
		$shared = [];
		$count = min(count($left), count($right));

		for ($index = 0; $index < $count; $index++)
		{
			if ($left[$index] !== $right[$index])
			{
				break;
			}

			$shared[] = $left[$index];
		}

		return $shared;
	}
}

