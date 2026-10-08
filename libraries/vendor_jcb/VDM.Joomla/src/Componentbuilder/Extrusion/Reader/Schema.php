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


use VDM\Joomla\Componentbuilder\Extrusion\Reader\Sql\CreateTable;
use VDM\Joomla\Componentbuilder\Extrusion\Reader\Sql\Insert;
use VDM\Joomla\Componentbuilder\Extrusion\Reader\Sql\Splitter;
use VDM\Joomla\Componentbuilder\Extrusion\Registry\Report;
use VDM\Joomla\Componentbuilder\Extrusion\Registry\Schema as SchemaRegistry;
use VDM\Joomla\Componentbuilder\Extrusion\Interfaces\ReaderInterface;


/**
 * Reads one install schema file into the schema registry.
 * 
 * The file is read as text and never included, required, or evaluated: a source
 * tree may be an unzipped upload and is treated as untrusted throughout. Each
 * CREATE TABLE becomes table..name plus a path per parsed property of
 * every column, and each INSERT INTO becomes seed..sql. A per table
 * summary lands in the report registry so a run can explain what it understood
 * without anything downstream having to re-read the file.
 * 
 * @since 6.1.6
 */
final class Schema implements ReaderInterface
{
	/**
	 * The schema registry this reader fills.
	 *
	 * @var    SchemaRegistry
	 * @since  6.1.6
	 */
	protected SchemaRegistry $schema;

	/**
	 * The statement splitter.
	 *
	 * @var    Splitter
	 * @since  6.1.6
	 */
	protected Splitter $splitter;

	/**
	 * The CREATE TABLE parser.
	 *
	 * @var    CreateTable
	 * @since  6.1.6
	 */
	protected CreateTable $createTable;

	/**
	 * The INSERT INTO parser.
	 *
	 * @var    Insert
	 * @since  6.1.6
	 */
	protected Insert $insert;

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
	 * @param   SchemaRegistry  $schema       The schema registry.
	 * @param   Splitter        $splitter     The statement splitter.
	 * @param   CreateTable     $createTable  The CREATE TABLE parser.
	 * @param   Insert          $insert       The INSERT INTO parser.
	 * @param   Report          $report       The report registry.
	 *
	 * @since   6.1.6
	 */
	public function __construct(
		SchemaRegistry $schema,
		Splitter $splitter,
		CreateTable $createTable,
		Insert $insert,
		Report $report
	)
	{
		$this->schema = $schema;
		$this->splitter = $splitter;
		$this->createTable = $createTable;
		$this->insert = $insert;
		$this->report = $report;
	}

	/**
	 * Read one schema file into the schema registry.
	 *
	 * @param   string       $path  Absolute path to the schema file.
	 * @param   string|null  $name  Optional artifact name, such as a view name.
	 *
	 * @return  bool  True when at least one table was parsed and stored.
	 * @since   6.1.6
	 */
	public function read(string $path, ?string $name = null): bool
	{
		$sql = $this->contents($path);

		if ($sql === null)
		{
			$this->report->set('schema.unreadable.' . $this->key(basename($path)), $path);

			return false;
		}

		return $this->parse($sql, $path, $name);
	}

	/**
	 * Parse a schema straight from its text.
	 *
	 * This is what lets a pasted dump be a complete source in its own right. The
	 * dump-driven extrusion the component form offers and the folder-driven
	 * extrusion both land here, so there is one parser and one set of results
	 * rather than two engines that agree only by coincidence.
	 *
	 * @param   string       $sql     The schema text.
	 * @param   string       $origin  Where the text came from, used in the report.
	 * @param   string|null  $name    Optional artifact name.
	 *
	 * @return  bool  True when at least one table was understood.
	 * @since   6.1.6
	 */
	public function parse(string $sql, string $origin = 'dump', ?string $name = null): bool
	{
		if (trim($sql) === '')
		{
			$this->report->set('schema.empty.' . $this->key($origin), true);

			return false;
		}

		$tables = 0;

		foreach ($this->splitter->split($sql) as $statement)
		{
			$table = $this->createTable->parse($statement);

			if ($table !== null)
			{
				$this->table($table, $origin, $name);
				$tables++;

				continue;
			}

			$seed = $this->insert->parse($statement);

			if ($seed !== null)
			{
				$this->seed($seed);
			}
		}

		return $tables > 0;
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
	 * Store one parsed table and note its summary.
	 *
	 * @param   array        $table  The parsed table and its columns.
	 * @param   string       $path   The schema file the table came from.
	 * @param   string|null  $name   Optional artifact name.
	 *
	 * @return  void
	 * @since   6.1.6
	 */
	private function table(array $table, string $path, ?string $name): void
	{
		$key = $this->key($table['table']);
		$stored = $this->schema->get('table.' . $key . '.name');

		if (is_string($stored) && $stored !== $table['table'])
		{
			$this->report->set(
				'schema.' . $key . '.collision',
				$stored . ' | ' . $table['table']
			);
		}

		$this->schema->set('table.' . $key . '.name', $table['table']);

		// the engine, character set and row format are the table's own, stated
		// where only the table states them
		foreach ((array) ($table['options'] ?? []) as $option => $value)
		{
			$this->schema->set('table.' . $key . '.option.' . $this->key($option), $value);
		}

		$primary = [];
		$unique = [];

		foreach ($table['columns'] as $column)
		{
			$target = 'table.' . $key . '.column.' . $this->key($column['name']);

			foreach ($column as $property => $value)
			{
				$this->schema->set($target . '.' . $property, $value);
			}

			if ($column['key'] === 3)
			{
				$primary[] = $column['name'];
			}
			elseif ($column['key'] === 2)
			{
				$unique[] = $column['name'];
			}
		}

		$this->summary($key, $table, $path, $name, $primary, $unique);
	}

	/**
	 * Note the per table summary in the report registry.
	 *
	 * @param   string         $key      The table's path segment.
	 * @param   array          $table    The parsed table and its columns.
	 * @param   string         $path     The schema file the table came from.
	 * @param   string|null    $name     Optional artifact name.
	 * @param   array<string>  $primary  Columns holding primary key status.
	 * @param   array<string>  $unique   Columns holding unique key status.
	 *
	 * @return  void
	 * @since   6.1.6
	 */
	private function summary(
		string $key,
		array $table,
		string $path,
		?string $name,
		array $primary,
		array $unique
	): void
	{
		$this->report->set('schema.' . $key . '.name', $table['table']);
		$this->report->set('schema.' . $key . '.source', $path);
		$this->report->set('schema.' . $key . '.columns', count($table['columns']));
		$this->report->set('schema.' . $key . '.primary', implode(', ', $primary));
		$this->report->set('schema.' . $key . '.unique', implode(', ', $unique));

		if ($name !== null)
		{
			$this->report->set('schema.' . $key . '.artifact', $name);
		}
	}

	/**
	 * Store one seed statement verbatim.
	 *
	 * A table seeded by several statements keeps them all, so a batched dump
	 * is not reduced to its last batch. Every statement is stored terminated
	 * and separated the way JCB's own dump writes them: the splitter cut the
	 * terminators off to find the statements, and the compiler places what is
	 * stored into the install file verbatim, where the installer cuts on
	 * those very terminators again.
	 *
	 * @param   array  $seed  The seeded table and its statement.
	 *
	 * @return  void
	 * @since   6.1.6
	 */
	private function seed(array $seed): void
	{
		$key = $this->key($seed['table']);
		$stored = $this->schema->get('seed.' . $key . '.sql');
		$statement = rtrim((string) $seed['sql'], "; \t\r\n") . ';';
		// the first statement opens with the heading JCB's own dump writes --
		// line breaks and all -- so an extruded install file reads exactly
		// like a compiled one
		$sql = is_string($stored) && $stored !== ''
			? $stored . "\n\n" . $statement
			: "--\r\n-- Dumping data for table `" . $seed['table'] . "`\r\n--\r\n\r\n" . $statement;

		$this->schema->set('seed.' . $key . '.name', $seed['table']);
		$this->schema->set('seed.' . $key . '.sql', $sql);
		$this->report->set(
			'schema.' . $key . '.seed',
			((int) $this->report->get('schema.' . $key . '.seed', 0)) + 1
		);
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

