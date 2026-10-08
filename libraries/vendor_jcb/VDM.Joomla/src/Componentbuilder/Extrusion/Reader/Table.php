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

namespace VDM\Joomla\Componentbuilder\Extrusion\Reader;


use VDM\Joomla\Componentbuilder\Extrusion\Reader\Php\Literal;
use VDM\Joomla\Componentbuilder\Extrusion\Registry\Report;
use VDM\Joomla\Componentbuilder\Extrusion\Registry\Table as TableRegistry;
use VDM\Joomla\Componentbuilder\Extrusion\Interfaces\ReaderInterface;


/**
 * Reads a JCB table definition class into the table registry.
 * 
 * This is precedence tier zero, the highest priority source a component can
 * offer. A component built by JCB carries a table definition class whose
 * $tables map is the source of truth for its whole infrastructure, and it holds
 * three things no other artifact records at all: the foreign key relationship
 * in link, the storage encoding in store, and the per-field guid that lets a
 * re-run line up exactly with the source project's own definitions.
 * 
 * The file is read as text and handed to the literal-only parser. It is never
 * included, required, or evaluated, because a source tree may be an unzipped
 * upload. When the parser refuses the map, the reason is recorded at
 * report.table.reason and the run drops to the next tier rather than trusting
 * part of what it saw.
 * 
 * @since 6.1.6
 */
final class Table implements ReaderInterface
{
	/**
	 * The table registry this reader fills.
	 *
	 * @var    TableRegistry
	 * @since  6.1.6
	 */
	protected TableRegistry $table;

	/**
	 * The literal-only array-literal parser.
	 *
	 * @var    Literal
	 * @since  6.1.6
	 */
	protected Literal $literal;

	/**
	 * The report registry.
	 *
	 * @var    Report
	 * @since  6.1.6
	 */
	protected Report $report;

	/**
	 * Constructor.
	 *
	 * @param   TableRegistry  $table    The table definition registry.
	 * @param   Literal        $literal  The literal-only PHP array parser.
	 * @param   Report         $report   The report registry.
	 *
	 * @since   6.1.6
	 */
	public function __construct(TableRegistry $table, Literal $literal, Report $report)
	{
		$this->table = $table;
		$this->literal = $literal;
		$this->report = $report;
	}

	/**
	 * Read one table definition class into the table registry.
	 *
	 * @param   string       $path  Absolute path to the table definition class.
	 * @param   string|null  $name  Optional artifact name, such as the class name.
	 *
	 * @return  bool  True when at least one table was extracted and stored.
	 * @since   6.1.6
	 */
	public function read(string $path, ?string $name = null): bool
	{
		$source = $this->contents($path);

		if ($source === null)
		{
			$this->report->set('table.reason', 'the table definition class could not be read as text');
			$this->report->set('table.unreadable.' . $this->key(basename($path)), $path);

			return false;
		}

		$tables = $this->literal->parse($source, 'tables');

		if ($tables === null)
		{
			$reason = $this->literal->reason();
			$this->report->set(
				'table.reason',
				$reason ?? 'the $tables property could not be read as a literal'
			);
			$this->report->set('table.refused', $path);

			return false;
		}

		return $this->stored($tables, $path, $name);
	}

	/**
	 * The registry path segment for one name.
	 *
	 * Registry paths are dot separated, so a name carrying a dot would corrupt
	 * the path it is addressed by. Every character outside the safe set becomes
	 * an underscore, and the true name is stored under the segment's name key.
	 * Other classes call this to address the same paths.
	 *
	 * @param   string  $segment  The true name.
	 *
	 * @return  string  The safe path segment.
	 * @since   6.1.6
	 */
	public function key(string $segment): string
	{
		$key = (string) preg_replace('/[^A-Za-z0-9_]/', '_', $segment);

		return $key === '' ? '_' : $key;
	}

	/**
	 * Store every table of one parsed map and note the run summary.
	 *
	 * @param   array        $tables  The parsed $tables map.
	 * @param   string       $path    The file the map came from.
	 * @param   string|null  $name    Optional artifact name.
	 *
	 * @return  bool  True when at least one table was stored.
	 * @since   6.1.6
	 */
	private function stored(array $tables, string $path, ?string $name): bool
	{
		$count = 0;
		$fields = 0;

		foreach ($tables as $table => $definition)
		{
			$table = (string) $table;

			if (!is_array($definition) || $definition === [])
			{
				$this->report->set(
					'table.skipped.' . $this->key($table),
					'no field definitions'
				);

				continue;
			}

			$fields += $this->definition($table, $definition, $path, $name);
			$count++;
		}

		$this->report->set('table.source', $path);
		$this->report->set('table.tables', $count);
		$this->report->set('table.fields', $fields);

		if ($name !== null)
		{
			$this->report->set('table.artifact', $name);
		}

		return $count > 0;
	}

	/**
	 * Store one table's fields and note its summary.
	 *
	 * The title field and the list view are taken from the first field that
	 * declares them, because that is what JCB's own BaseTable::title does when it
	 * walks a table's fields. A second field claiming the title is a defect in the
	 * source component rather than an override, so it is recorded as a collision
	 * in the report and the first claim stands.
	 *
	 * @param   string                $table       The true table name.
	 * @param   array<string, mixed>  $definition  The table's field definitions.
	 * @param   string                $path        The file the map came from.
	 * @param   string|null           $name        Optional artifact name.
	 *
	 * @return  int  How many fields were stored.
	 * @since   6.1.6
	 */
	private function definition(string $table, array $definition, string $path, ?string $name): int
	{
		$key = $this->key($table);
		$stored = $this->table->get('table.' . $key . '.name');

		if (is_string($stored) && $stored !== $table)
		{
			$this->report->set(
				'table.definition.' . $key . '.collision',
				$stored . ' | ' . $table
			);
		}

		$this->table->set('table.' . $key . '.name', $table);

		$titles = [];
		$lists = [];
		$count = 0;
		$links = 0;
		$subfields = 0;

		foreach ($definition as $field => $properties)
		{
			$field = (string) $field;

			if (!is_array($properties))
			{
				$this->report->set(
					'table.definition.' . $key . '.unusable.' . $this->key($field),
					'the field definition is not an array'
				);

				continue;
			}

			$base = 'table.' . $key . '.field.' . $this->key($field);
			$counts = $this->field($base, $field, $properties);
			$count++;
			$links += $counts['links'];
			$subfields += $counts['subfields'];

			if (!empty($properties['title']))
			{
				if ($titles === [])
				{
					$this->table->set('table.' . $key . '.title', $field);
				}

				$titles[] = $field;
			}

			$list = $properties['list'] ?? null;

			if (is_string($list) && $list !== '')
			{
				$this->table->set('table.' . $key . '.list.' . $this->key($field), $list);

				if ($lists === [])
				{
					$this->table->set('table.' . $key . '.listview', $list);
				}

				$lists[$list] = true;
			}
		}

		$this->summary($key, $table, $path, $name, $titles, $lists, $count, $links, $subfields);

		return $count;
	}

	/**
	 * Store one field definition, whether it is a field or a subfield.
	 *
	 * Every scalar property lands on its own path, the db and link maps land one
	 * level deeper, and a subform's own fields recurse under subfield.<n>. A
	 * null link is kept as null so the absence of a relationship is recorded
	 * rather than merely missing.
	 *
	 * @param   string                $base        The registry path of this field.
	 * @param   string                $field       The true field name.
	 * @param   array<string, mixed>  $properties  The field's declared properties.
	 *
	 * @return  array{links: int, subfields: int}  What was found below this field.
	 * @since   6.1.6
	 */
	private function field(string $base, string $field, array $properties): array
	{
		$counts = ['links' => 0, 'subfields' => 0];
		$this->table->set($base . '.name', $field);

		foreach ($properties as $property => $value)
		{
			$property = (string) $property;
			$segment = $this->key($property);

			if ($property === 'fields' && is_array($value))
			{
				$counts['subfields'] += $this->subfields($base, $value);

				continue;
			}

			if (($property === 'db' || $property === 'link') && is_array($value))
			{
				$this->map($base . '.' . $segment, $value);

				if ($property === 'link')
				{
					$counts['links']++;
				}

				continue;
			}

			if (is_scalar($value) || $value === null)
			{
				$this->table->set($base . '.' . $segment, $value);
			}
		}

		return $counts;
	}

	/**
	 * Store one flat map, such as the db or link definition.
	 *
	 * @param   string                $base  The registry path of the map.
	 * @param   array<string, mixed>  $map   The map's entries.
	 *
	 * @return  void
	 * @since   6.1.6
	 */
	private function map(string $base, array $map): void
	{
		foreach ($map as $property => $value)
		{
			if (is_scalar($value) || $value === null)
			{
				$this->table->set($base . '.' . $this->key((string) $property), $value);
			}
		}
	}

	/**
	 * Store one subform's subfields, in declaration order.
	 *
	 * @param   string                $base    The registry path of the owning field.
	 * @param   array<string, mixed>  $fields  The subform's field definitions.
	 *
	 * @return  int  How many subfields were stored, including nested ones.
	 * @since   6.1.6
	 */
	private function subfields(string $base, array $fields): int
	{
		$position = 0;
		$count = 0;

		foreach ($fields as $field => $properties)
		{
			if (!is_array($properties))
			{
				continue;
			}

			$target = $base . '.subfield.' . $position;
			$position++;
			$count++;
			$counts = $this->field($target, (string) $field, $properties);
			$count += $counts['subfields'];
		}

		return $count;
	}

	/**
	 * Note one table's summary in the report registry.
	 *
	 * @param   string                $key        The table's path segment.
	 * @param   string                $table      The true table name.
	 * @param   string                $path       The file the map came from.
	 * @param   string|null           $name       Optional artifact name.
	 * @param   array<string>         $titles     Fields declaring themselves the title.
	 * @param   array<string, bool>   $lists      List views the fields belong to.
	 * @param   int                   $count      How many fields were stored.
	 * @param   int                   $links      How many relationships were stored.
	 * @param   int                   $subfields  How many subfields were stored.
	 *
	 * @return  void
	 * @since   6.1.6
	 */
	private function summary(
		string $key,
		string $table,
		string $path,
		?string $name,
		array $titles,
		array $lists,
		int $count,
		int $links,
		int $subfields
	): void
	{
		$target = 'table.definition.' . $key;
		$this->report->set($target . '.name', $table);
		$this->report->set($target . '.source', $path);
		$this->report->set($target . '.fields', $count);
		$this->report->set($target . '.links', $links);
		$this->report->set($target . '.subfields', $subfields);
		$this->report->set($target . '.title', implode(', ', $titles));
		$this->report->set($target . '.list', implode(', ', array_keys($lists)));

		if (count($titles) > 1)
		{
			$this->report->set($target . '.title_collision', implode(', ', $titles));
		}

		if ($name !== null)
		{
			$this->report->set($target . '.artifact', $name);
		}
	}

	/**
	 * Read one file as text.
	 *
	 * @param   string  $path  Absolute path to the file.
	 *
	 * @return  string|null  The file contents, or null when it cannot be read.
	 * @since   6.1.6
	 */
	private function contents(string $path): ?string
	{
		if ($path === '' || !is_file($path) || !is_readable($path))
		{
			return null;
		}

		$contents = file_get_contents($path);

		return $contents === false ? null : $contents;
	}
}

