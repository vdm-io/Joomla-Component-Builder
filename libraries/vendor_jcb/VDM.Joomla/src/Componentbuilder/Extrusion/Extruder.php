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

namespace VDM\Joomla\Componentbuilder\Extrusion;


use VDM\Joomla\Componentbuilder\Extrusion\Discovery\Collector;
use VDM\Joomla\Componentbuilder\Extrusion\Interfaces\PowersExtruderInterface;
use VDM\Joomla\Componentbuilder\Extrusion\Reader\Dispatcher as ReaderDispatcher;
use VDM\Joomla\Componentbuilder\Extrusion\Reader\Schema as SchemaReader;
use VDM\Joomla\Componentbuilder\Extrusion\Registry\Message;
use VDM\Joomla\Componentbuilder\Extrusion\Registry\Report;
use VDM\Joomla\Componentbuilder\Extrusion\Registry\Plan;
use VDM\Joomla\Componentbuilder\Extrusion\Resolver\Commit;
use VDM\Joomla\Componentbuilder\Extrusion\Registry\Scope;
use VDM\Joomla\Componentbuilder\Extrusion\Registry\Source;
use VDM\Joomla\Componentbuilder\Extrusion\Resolver\Assembler;
use VDM\Joomla\Componentbuilder\Extrusion\Resolver\Prefix;
use VDM\Joomla\Componentbuilder\Extrusion\Resolver\Candidates;
use VDM\Joomla\Componentbuilder\Extrusion\Resolver\Reuse;
use VDM\Joomla\Componentbuilder\Extrusion\Resolver\Sharing;
use VDM\Joomla\Componentbuilder\Extrusion\Writer\Dispatcher as WriterDispatcher;
use VDM\Joomla\Componentbuilder\Extrusion\Interfaces\ExtruderInterface;


/**
 * The single entry point that consumes a component source tree into JCB.
 * 
 * This is resolved from the container and configured by chaining, so a caller
 * never constructs a request object. Every setter validates and writes into the
 * shared configuration, which each downstream service already holds by injection.
 * 
 * The run is four ordered steps and nothing else: collect an inventory, read what
 * was found, assemble it into one resolved definition set, then write. Nothing
 * below this class enqueues a message; findings accumulate in the report and only
 * the caller decides how to present them.
 * 
 * @since 6.1.6
 */
final class Extruder implements ExtruderInterface
{
	/**
	 * The Config Class.
	 *
	 * @var    Config
	 * @since  6.1.6
	 */
	protected Config $config;

	/**
	 * The Scope Class.
	 *
	 * @var    Scope
	 * @since  6.1.6
	 */
	protected Scope $scope;

	/**
	 * The Collector Class.
	 *
	 * @var    Collector
	 * @since  6.1.6
	 */
	protected Collector $collector;

	/**
	 * The Reader Dispatcher.
	 *
	 * @var    ReaderDispatcher
	 * @since  6.1.6
	 */
	protected ReaderDispatcher $readers;

	/**
	 * The Assembler Class.
	 *
	 * @var    Assembler
	 * @since  6.1.6
	 */
	protected Assembler $assembler;

	/**
	 * The Writer Dispatcher.
	 *
	 * @var    WriterDispatcher
	 * @since  6.1.6
	 */
	protected WriterDispatcher $writers;

	/**
	 * The Report Registry.
	 *
	 * @var    Report
	 * @since  6.1.6
	 */
	protected Report $report;

	/**
	 * The Message Bus.
	 *
	 * @var    Message
	 * @since  6.1.6
	 */
	protected Message $message;

	/**
	 * The Schema Reader, for a dump supplied as text.
	 *
	 * @var    SchemaReader
	 * @since  6.1.6
	 */
	protected SchemaReader $schema;

	/**
	 * The Source Registry.
	 *
	 * @var    Source
	 * @since  6.1.6
	 */
	protected Source $source;

	/**
	 * The Prefix Resolver.
	 *
	 * @var    Prefix
	 * @since  6.1.6
	 */
	protected Prefix $prefix;

	/**
	 * The Reuse Resolver.
	 *
	 * @var    Reuse
	 * @since  6.1.8
	 */
	protected Reuse $reuse;

	/**
	 * The Candidates Resolver.
	 *
	 * @var    Candidates
	 * @since  6.1.8
	 */
	protected Candidates $candidates;

	/**
	 * The Sharing Resolver.
	 *
	 * @var    Sharing
	 * @since  6.1.9
	 */
	protected Sharing $sharing;

	/**
	 * The complete-operation plan.
	 *
	 * @var    Plan
	 * @since  6.2.0
	 */
	protected Plan $plan;

	/**
	 * The operation validation and commit boundary.
	 *
	 * @var    Commit
	 * @since  6.2.0
	 */
	protected Commit $commit;

	/**
	 * The library engine participating in the same operation.
	 *
	 * @var    PowersExtruderInterface
	 * @since  6.2.0
	 */
	protected PowersExtruderInterface $powers;

	/**
	 * Constructor.
	 *
	 * @param   Config            $config     The extrusion configuration.
	 * @param   Scope             $scope      The run state boundary.
	 * @param   Collector         $collector  The discovery collector.
	 * @param   ReaderDispatcher  $readers    The reader dispatcher.
	 * @param   Assembler         $assembler  The resolution assembler.
	 * @param   WriterDispatcher  $writers    The writer dispatcher.
	 * @param   Report            $report     The run report registry.
	 * @param   Message           $message    The message bus.
	 * @param   SchemaReader      $schema     The schema reader.
	 * @param   Source            $source     The source identity registry.
	 * @param   Prefix            $prefix     The table-name prefix resolver.
	 * @param   Reuse             $reuse      The matched-candidate reuse resolver.
	 *
	 * @since   6.1.6
	 */
	public function __construct(
		Config $config,
		Scope $scope,
		Collector $collector,
		ReaderDispatcher $readers,
		Assembler $assembler,
		WriterDispatcher $writers,
		Report $report,
		Message $message,
		SchemaReader $schema,
		Source $source,
		Prefix $prefix,
		Reuse $reuse,
		Candidates $candidates,
		Sharing $sharing,
		Plan $plan,
		Commit $commit,
		PowersExtruderInterface $powers
	)
	{
		$this->config = $config;
		$this->plan = $plan;
		$this->commit = $commit;
		$this->powers = $powers;
		$this->scope = $scope;
		$this->collector = $collector;
		$this->readers = $readers;
		$this->assembler = $assembler;
		$this->writers = $writers;
		$this->report = $report;
		$this->message = $message;
		$this->schema = $schema;
		$this->source = $source;
		$this->prefix = $prefix;
		$this->reuse = $reuse;
		$this->candidates = $candidates;
		$this->sharing = $sharing;
	}

	/**
	 * Clear the configuration and every registry, starting a fresh run.
	 *
	 * @return  self  For method chaining.
	 * @since   6.1.6
	 */
	public function reset(): self
	{
		$this->scope->reset();

		return $this;
	}

	/**
	 * Set the component source root to consume.
	 *
	 * @param   string  $path  Absolute path to the component source root.
	 *
	 * @return  self  For method chaining.
	 * @since   6.1.6
	 */
	public function path(string $path): self
	{
		return $this->option('path', $path);
	}

	/**
	 * Set the administrator folder to consume.
	 *
	 * A component is two trees and someone may have either, both, or the directory
	 * that contains them. Naming the administrator half outright is not only a
	 * convenience: it is what tells a view's own default.php apart from a site view
	 * when the folder given is itself one half and its shape cannot say which.
	 *
	 * @param   string  $path  Absolute path to the administrator folder.
	 *
	 * @return  self  For method chaining.
	 * @since   6.1.6
	 */
	public function adminPath(string $path): self
	{
		return $this->option('adminPath', $path);
	}

	/**
	 * Set the site folder to consume.
	 *
	 * @param   string  $path  Absolute path to the site folder.
	 *
	 * @return  self  For method chaining.
	 * @since   6.1.6
	 */
	public function sitePath(string $path): self
	{
		return $this->option('sitePath', $path);
	}

	/**
	 * Every source root this run was given, each with the half it represents.
	 *
	 * @return  array<int, array{path: string, scope: string}>  The requested roots.
	 * @since   6.1.6
	 */
	public function roots(): array
	{
		$roots = [];

		foreach (['path' => '', 'adminPath' => 'admin', 'sitePath' => 'site'] as $option => $scope)
		{
			$path = trim((string) $this->config->get($option, ''));

			if ($path !== '')
			{
				$roots[] = ['path' => $path, 'scope' => $scope];
			}
		}

		return $roots;
	}

	/**
	 * Supply a schema dump as text instead of pointing at a folder.
	 *
	 * This is the original extrusion: paste a dump, get views and fields, with the
	 * JSON note in a column comment still the author's explicit instruction. It runs
	 * through the same readers, resolvers and writers as a folder does, so the two
	 * entry points cannot drift apart.
	 *
	 * A dump and a folder can be given together, in which case the folder's own
	 * artifacts refine what the dump described.
	 *
	 * @param   string  $sql  The schema text.
	 *
	 * @return  self  For method chaining.
	 * @since   6.1.6
	 */
	public function dump(string $sql): self
	{
		return $this->option('dump', $sql);
	}

	/**
	 * Set the JCB component the extruded definitions belong to.
	 *
	 * @param   int  $id  The component id.
	 *
	 * @return  self  For method chaining.
	 * @since   6.1.6
	 */
	public function component(int $id): self
	{
		return $this->option('component', max(0, $id));
	}

	/**
	 * Set the component code name the source tables are prefixed with.
	 *
	 * Supplying this outranks anything inferred from the tree, and it is what
	 * lets a bare schema dump -- which carries no manifest -- still have its
	 * table prefix stripped from every view name.
	 *
	 * @param   string  $name  The component code name, with or without com_.
	 *
	 * @return  self  For method chaining.
	 * @since   6.1.6
	 */
	public function codeName(string $name): self
	{
		return $this->option('codeName', trim($name));
	}

	/**
	 * Set whether this run creates a fresh set or merges into an existing one.
	 *
	 * @param   string  $mode  Either create or update.
	 *
	 * @return  self  For method chaining.
	 * @since   6.1.6
	 */
	public function mode(string $mode): self
	{
		return $this->option('mode', strtolower(trim($mode)));
	}

	/**
	 * Set what happens when a derived identity already exists.
	 *
	 * @param   string  $policy  Either skip, update, or replace.
	 *
	 * @return  self  For method chaining.
	 * @since   6.1.6
	 */
	public function onExisting(string $policy): self
	{
		return $this->option('onExisting', strtolower(trim($policy)));
	}

	/**
	 * Force a target layout instead of detecting one.
	 *
	 * @param   string  $layout  One of auto, j3, j4, j5, or j6.
	 *
	 * @return  self  For method chaining.
	 * @since   6.1.6
	 */
	public function layout(string $layout): self
	{
		return $this->option('layout', strtolower(trim($layout)));
	}

	/**
	 * Set which translation supplies the readable strings.
	 *
	 * @param   string  $tag  The language tag, such as en-GB.
	 *
	 * @return  self  For method chaining.
	 * @since   6.1.6
	 */
	public function languageTag(string $tag): self
	{
		return $this->option('languageTag', trim($tag));
	}

	/**
	 * Reorder the precedence tiers.
	 *
	 * @param   array<string>  $order  The tier names, strongest first.
	 *
	 * @return  self  For method chaining.
	 * @since   6.1.6
	 */
	public function precedence(array $order): self
	{
		$clean = [];

		foreach ($order as $tier)
		{
			$tier = strtolower(trim((string) $tier));

			if (in_array($tier, Config::TIERS, true) && !in_array($tier, $clean, true))
			{
				$clean[] = $tier;
			}
		}

		foreach (Config::TIERS as $tier)
		{
			if (!in_array($tier, $clean, true))
			{
				$clean[] = $tier;
			}
		}

		return $this->option('precedence', $clean);
	}

	/**
	 * Set how the table definition class is treated.
	 *
	 * @param   string  $mode  Either auto or off.
	 *
	 * @return  self  For method chaining.
	 * @since   6.1.6
	 */
	public function tableClass(string $mode): self
	{
		return $this->option('tableClass', strtolower(trim($mode)));
	}

	/**
	 * Restrict the run to the named source tables or views.
	 *
	 * @param   array<string>  $names  The names to include.
	 *
	 * @return  self  For method chaining.
	 * @since   6.1.6
	 */
	public function include(array $names): self
	{
		return $this->option('include', array_values(array_map('strval', $names)));
	}

	/**
	 * Exclude the named source tables or views from the run.
	 *
	 * @param   array<string>  $names  The names to exclude.
	 *
	 * @return  self  For method chaining.
	 * @since   6.1.6
	 */
	public function exclude(array $names): self
	{
		return $this->option('exclude', array_values(array_map('strval', $names)));
	}

	/**
	 * Produce the report without writing anything.
	 *
	 * @param   bool  $dryRun  Whether to suppress every write.
	 *
	 * @return  self  For method chaining.
	 * @since   6.1.6
	 */
	public function dryRun(bool $dryRun = true): self
	{
		return $this->option('dryRun', $dryRun);
	}

	/**
	 * Fail instead of degrading when something cannot be resolved.
	 *
	 * @param   bool  $strict  Whether to run strictly.
	 *
	 * @return  self  For method chaining.
	 * @since   6.1.6
	 */
	public function strict(bool $strict = true): self
	{
		return $this->option('strict', $strict);
	}

	/**
	 * Toggle one of the boolean scope options.
	 *
	 * @param   string  $name   The scope option name.
	 * @param   bool    $value  Whether the scope is included.
	 *
	 * @return  self  For method chaining.
	 * @since   6.1.6
	 */
	public function scope(string $name, bool $value = true): self
	{
		return $this->option($name, $value);
	}

	/**
	 * Restrict the operation to namespace repairs of identified existing Powers.
	 *
	 * Component source, schema and writer settings remain available for a later
	 * ordinary run; this operation delegates exclusively to the Powers pipeline.
	 *
	 * @param   bool  $repair  Whether to enable namespace-only repair.
	 *
	 * @return  self  For method chaining.
	 * @since   6.2.2
	 */
	public function repairNamespaces(bool $repair = true): self
	{
		return $this->option('repairNamespaces', $repair);
	}

	/**
	 * Set the bounded scan caps.
	 *
	 * @param   int  $depth     The maximum directory depth.
	 * @param   int  $maxFiles  The maximum number of files to consider.
	 *
	 * @return  self  For method chaining.
	 * @since   6.1.6
	 */
	public function limits(int $depth, int $maxFiles): self
	{
		return $this->option('depth', max(1, $depth))
			->option('maxFiles', max(1, $maxFiles));
	}

	/**
	 * Gather, read and assemble the source, without writing anything.
	 *
	 * This is the first half of a run, split out so a caller can present what
	 * was found -- and collect pairing approval -- before anything is written.
	 *
	 * @return  Report  What was found and resolved.
	 * @since   6.1.7
	 */
	public function harvest(): Report
	{
		if ((bool) $this->config->get('repairNamespaces', false))
		{
			$this->powers->harvest();

			return $this->finish((bool) $this->report->get('powers.completed', false));
		}

		$views = $this->assembleSource();

		if ($views === null)
		{
			return $this->finish(false);
		}

		return $this->finish(true);
	}

	/**
	 * Everything the harvest found, as the list a person approves.
	 *
	 * The second half of a run writes only what it was told to. This is what a
	 * caller shows in between: every artifact the harvest resolved, grouped by
	 * kind, each already lined up against what the target component links --
	 * so a component seen before arrives proposed as updates and only what is
	 * genuinely new proposes itself as a creation. Nothing here writes, and
	 * the verdicts a caller collects go back through the pairing resolver.
	 *
	 * @param   int  $componentId  The component the candidates pair against, or zero.
	 *
	 * @return  array<string, mixed>  Candidates by kind.
	 * @since   6.1.8
	 */
	public function candidates(int $componentId = 0): array
	{
		return $this->candidates->candidates(
			$componentId > 0 ? $componentId : (int) $this->config->get('component', 0)
		);
	}

	/**
	 * Run the extrusion and return its report.
	 *
	 * @return  Report  What was found, resolved, written, and skipped.
	 * @since   6.1.6
	 */
	public function extrude(): Report
	{
		if ((bool) $this->config->get('repairNamespaces', false))
		{
			$this->powers->extrude();

			return $this->finish((bool) $this->report->get('powers.completed', false));
		}

		$owner = $this->plan->begin();

		try
		{
			$views = $this->assembleSource();

			if ($views === null)
			{
				$this->plan->block('component.empty', 'No usable component source or schema was supplied.');
			}
			else
			{
				$this->reuse->apply();
				$written = $this->writers->dispatch();

				if ($views === 0 && $written === 0)
				{
					$this->plan->block('component.empty', 'No component definition was recoverable.');
				}

				if ((array) $this->config->get('libraries', []) !== [])
				{
					$this->powers->extrude();
				}
			}

			$completed = $owner ? $this->commit->apply() : $this->plan->blockers() === [];

			if ($completed && $owner)
			{
				$this->achieved((int) $views);
			}

			if ((array) $this->config->get('libraries', []) !== [])
			{
				$this->report->set('powers.completed', $completed && $owner);
			}

			return $this->finish($completed && $owner);
		}
		catch (\Throwable $error)
		{
			$this->plan->block('component.prepare', $error->getMessage());

			if ($owner)
			{
				$this->commit->apply();
			}

			return $this->finish(false);
		}
	}

	/**
	 * Collect, read and assemble the configured source into resolved views.
	 *
	 * @return  int|null  How many views were assembled, or null when nothing
	 *                    usable was given.
	 * @since   6.1.7
	 */
	protected function assembleSource(): ?int
	{
		$roots = $this->roots();
		$dump = (string) $this->config->get('dump', '');

		if ($roots === [] && $dump === '')
		{
			$this->message->error('No component source folder and no schema dump were given.');

			return null;
		}

		$parsed = $dump !== '' && $this->schema->parse($dump);

		if ($dump !== '' && !$parsed)
		{
			$this->message->error('The supplied schema dump declared no table.');
		}

		$located = $roots !== [] && $this->collector->gather($roots);

		if (!$located && !$parsed)
		{
			return null;
		}

		if ($roots === [])
		{
			$this->collector->identify();
		}

		$this->report->set('counts.artifacts', $this->readers->dispatch());
		$this->identity();
		$views = $this->assembler->assemble();
		$this->report->set('counts.views', $views);

		// ten views stating the same field are stating one field, and the
		// decision is settled here so the list a person approves already
		// shows one field and the views it serves
		$this->sharing->settle();

		return $views;
	}

	/**
	 * Settle the component identity once every table name is known.
	 *
	 * A manifest or a caller who names the component outranks everything, and this
	 * runs after them so it can never overrule either. What it covers is the case
	 * neither can: a bare dump, or a folder with no readable manifest. Joomla's own
	 * convention has a component prefix every table it owns, so the tables state
	 * their component in the part they all share, and a name recovered that way is
	 * a great deal better than leaving the prefix in every view name.
	 *
	 * Whether the source came out of JCB is recorded here too. It changes nothing
	 * about how the run proceeds — every tier degrades on its own terms — but it is
	 * the single most useful thing to know when reading a report, because a JCB
	 * source has a table definition class to be found and a hand-built one never
	 * will.
	 *
	 * @return  void
	 * @since   6.1.6
	 */
	protected function identity(): void
	{
		$this->report->set('source.jcb_built', $this->prefix->jcb());

		if ((string) $this->source->get('code_name', '') !== '')
		{
			return;
		}

		$option = $this->prefix->option();

		if ($option === '')
		{
			$this->message->warning(
				'The component name could not be established, and the table names do '
				. 'not share a prefix that would imply it, so every view name keeps '
				. 'whatever prefix its table had.'
			);

			return;
		}

		$this->source->set('code_name', $option);
		$this->report->set('source.manifest', 'not found; code name inferred from the table names');
		$this->message->notice(
			'No component name was given, so it was taken from the part every table '
			. 'name shares: ' . $option . '.'
		);
	}

	/**
	 * Say plainly what the run achieved.
	 *
	 * @param   int  $views    How many views were assembled.
	 * @param   int  $written  How many definitions were written.
	 *
	 * @return  void
	 * @since   6.1.6
	 */
	protected function achieved(int $views): void
	{
		// sharing and consolidation are the run understanding identity, and a
		// person must be able to see that on the page rather than deduce it
		// from a smaller written count
		$shared = (int) $this->report->get('counts.fields_shared', 0);
		$consolidated = (int) $this->report->get('counts.fields_consolidated', 0);

		if ($shared > 0)
		{
			$this->message->notice(
				$shared . ' column(s) stated a field another view also states, so '
				. 'each links that one shared field instead of creating a copy.',
				'shared.field'
			);
		}

		if ($consolidated > 0)
		{
			$this->message->notice(
				$consolidated . ' standing duplicate field link(s) were consolidated '
				. 'onto one field; the records no longer linked are named in the report.',
				'consolidated.field'
			);
		}

		// what the run announces is read from the report, where every writer
		// set down what it did: a record already saying what the source says
		// is accounted for, but it was not written, and the number must not
		// say it was
		$unchanged = $this->records('unchanged');

		if ($this->config->get('dryRun', false))
		{
			$this->message->success(
				'Reviewed ' . $views . ' view(s) and prepared ' . $this->records('dryrun')
				. ' definition(s)' . ($unchanged > 0
					? ', leaving ' . $unchanged . ' as they stand because they already say what the source says'
					: '')
				. '. Nothing was written, because this was a dry run.'
			);

			return;
		}

		$this->message->success(
			'Extruded ' . $views . ' view(s) into ' . $this->records('written') . ' JCB definition(s)'
			. ($unchanged > 0
				? ' (' . $unchanged . ' left as they stand, already saying what the source says)'
				: '')
			. '.'
		);
		$this->shortfalls();
	}

	/**
	 * How many records one branch of the report names, across every table.
	 *
	 * @param   string  $branch  The report branch: written, unchanged, dryrun.
	 *
	 * @return  int  The number of records named under it.
	 * @since   6.2.0
	 */
	protected function records(string $branch): int
	{
		$total = 0;

		foreach ((array) $this->report->get($branch, []) as $table)
		{
			$total += count((array) $table);
		}

		return $total;
	}

	/**
	 * Name what the run could not carry over.
	 *
	 * Every reader, resolver and writer records the facts it could not use, but a
	 * fact sitting in the report is not the same as the caller knowing about it. A
	 * run that quietly loses a custom field type or a field dependency looks like a
	 * complete success, which is exactly the impression this engine must never
	 * leave. The report stays the detailed record; this is the one place that turns
	 * the notable parts of it into something a caller can show, so no writer has to
	 * carry a message of its own.
	 *
	 * @return  void
	 * @since   6.1.6
	 */
	protected function shortfalls(): void
	{
		$counts = [
			'unmapped.fieldtype' => 'field type(s) had no JCB equivalent and were extruded '
				. 'as a custom field, so their options have to be set by hand',
			'failed.field.unresolved_type' => 'field(s) could not be given a type at all and '
				. 'were not written',
			'unresolved.language' => 'language constant(s) had no translation, so their label '
				. 'was derived from the column name',
			'skipped.empty' => 'table(s) described no extrudable field and became no view',
			'skipped.duplicate' => 'table(s) claimed a view name another table already held '
				. 'and were left out'
		];

		foreach ($counts as $key => $tail)
		{
			$found = $this->tally($key);

			if ($found > 0)
			{
				$this->message->notice($found . ' ' . $tail . '.', $key);
			}
		}

		$dropped = 0;

		foreach ((array) $this->report->get('dropped.condition', []) as $clauses)
		{
			$dropped += count((array) $clauses);
		}

		if ($dropped > 0)
		{
			$this->message->notice(
				$dropped . ' field dependency(s) pointed at a field JCB manages itself, so '
				. 'the showon rule could not be rebuilt.',
				'dropped.condition'
			);
		}
	}

	/**
	 * How many entries one report branch holds.
	 *
	 * @param   string  $key  The report path.
	 *
	 * @return  int  The number of entries.
	 * @since   6.1.6
	 */
	protected function tally(string $key): int
	{
		return count((array) $this->report->get($key, []));
	}

	/**
	 * Everything the run has to say, ready for a caller to present.
	 *
	 * @return  array<string, array<int, array{message: string, subject?: string}>>  The messages by level.
	 * @since   6.1.6
	 */
	public function messages(): array
	{
		return $this->message->all();
	}

	/**
	 * Validate and store one option.
	 *
	 * @param   string  $name   The option name.
	 * @param   mixed   $value  The option value.
	 *
	 * @return  self  For method chaining.
	 * @since   6.1.6
	 */
	protected function option(string $name, $value): self
	{
		if (is_string($value) && !$this->config->permitted($name, $value))
		{
			$this->report->set(
				'failed.option.' . $name,
				'rejected "' . $value . '"; allowed: ' . implode(', ', $this->config->allowed($name))
			);

			return $this;
		}

		$this->config->set($name, $value);

		return $this;
	}

	/**
	 * Stamp the run outcome onto the report.
	 *
	 * @param   bool  $completed  Whether the run reached the writing step.
	 *
	 * @return  Report  The run report.
	 * @since   6.1.6
	 */
	protected function finish(bool $completed): Report
	{
		$this->report->set('completed', $completed);
		$this->report->set('dry_run', (bool) $this->config->get('dryRun', false));
		$this->report->set('mode', (string) $this->config->get('mode', 'create'));

		return $this->report;
	}
}

