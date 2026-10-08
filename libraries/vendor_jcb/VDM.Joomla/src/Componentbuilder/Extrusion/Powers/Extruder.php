<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    22nd August, 2026
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Extrusion\Powers;


use VDM\Joomla\Componentbuilder\Extrusion\Config;
use VDM\Joomla\Componentbuilder\Extrusion\Powers\Writer\Power as PowerWriter;
use VDM\Joomla\Componentbuilder\Extrusion\Powers\Writer\Vendor as VendorWriter;
use VDM\Joomla\Componentbuilder\Extrusion\Registry\Harvest;
use VDM\Joomla\Componentbuilder\Extrusion\Registry\Message;
use VDM\Joomla\Componentbuilder\Extrusion\Registry\Report;
use VDM\Joomla\Componentbuilder\Extrusion\Registry\Plan;
use VDM\Joomla\Componentbuilder\Extrusion\Resolver\Commit;
use VDM\Joomla\Componentbuilder\Extrusion\Registry\Scope;
use VDM\Joomla\Componentbuilder\Extrusion\Interfaces\PowersExtruderInterface;


/**
 * The entry point that consumes PHP library classes into JCB powers.
 * 
 * This is the powers branch of the extrusion engine: aim it at one or more
 * library folders anywhere on the installed system, and every class,
 * interface and trait below them becomes a power candidate. The run is two
 * deliberate steps rather than one: harvest gathers and identifies everything
 * without writing, so a caller can present the candidate tree and collect
 * approval; extrude then assembles and writes what was approved -- narrowed by
 * the include and exclude filters when the caller passes an approval back.
 * 
 * Identity is the namespace: a candidate whose class an existing power already
 * resolves to updates that power, anything else is created, and the skip
 * policy turns updates into mentions. As everywhere in this engine, findings
 * accumulate in the report, and only this class turns them into messages.
 * 
 * @since 6.1.7
 */
final class Extruder implements PowersExtruderInterface
{
	/**
	 * The Config Class.
	 *
	 * @var    Config
	 * @since  6.1.7
	 */
	protected Config $config;

	/**
	 * The Scope Class.
	 *
	 * @var    Scope
	 * @since  6.1.7
	 */
	protected Scope $scope;

	/**
	 * The Harvester Class.
	 *
	 * @var    Harvester
	 * @since  6.1.7
	 */
	protected Harvester $harvester;

	/**
	 * The Assembler Class.
	 *
	 * @var    Assembler
	 * @since  6.1.7
	 */
	protected Assembler $assembler;

	/**
	 * The Power Writer.
	 *
	 * @var    PowerWriter
	 * @since  6.1.7
	 */
	protected PowerWriter $writer;

	/**
	 * The Vendor Writer.
	 *
	 * @var    VendorWriter
	 * @since  6.1.9
	 */
	protected VendorWriter $vendor;

	/**
	 * The Harvest Registry.
	 *
	 * @var    Harvest
	 * @since  6.1.7
	 */
	protected Harvest $harvest;

	/**
	 * The Report Registry.
	 *
	 * @var    Report
	 * @since  6.1.7
	 */
	protected Report $report;

	/**
	 * The Message Bus.
	 *
	 * @var    Message
	 * @since  6.1.7
	 */
	protected Message $message;

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
	 * Constructor.
	 *
	 * @param   Config       $config     The extrusion configuration.
	 * @param   Scope        $scope      The run state boundary.
	 * @param   Harvester    $harvester  The library harvester.
	 * @param   Assembler    $assembler  The definition assembler.
	 * @param   PowerWriter  $writer     The power writer.
	 * @param   VendorWriter  $vendor     The vendor placeholder writer.
	 * @param   Harvest      $harvest    The harvest registry.
	 * @param   Report       $report     The run report registry.
	 * @param   Message      $message    The message bus.
	 *
	 * @since   6.1.7
	 */
	public function __construct(
		Config $config,
		Scope $scope,
		Harvester $harvester,
		Assembler $assembler,
		PowerWriter $writer,
		VendorWriter $vendor,
		Harvest $harvest,
		Report $report,
		Message $message,
		Plan $plan,
		Commit $commit
	)
	{
		$this->config = $config;
		$this->plan = $plan;
		$this->commit = $commit;
		$this->scope = $scope;
		$this->harvester = $harvester;
		$this->assembler = $assembler;
		$this->writer = $writer;
		$this->vendor = $vendor;
		$this->harvest = $harvest;
		$this->report = $report;
		$this->message = $message;
	}

	/**
	 * Clear the configuration and every registry, starting a fresh run.
	 *
	 * @return  self  For method chaining.
	 * @since   6.1.7
	 */
	public function reset(): self
	{
		$this->scope->reset();

		return $this;
	}

	/**
	 * Add one library folder to harvest classes from.
	 *
	 * @param   string  $path  Absolute path to the library folder.
	 *
	 * @return  self  For method chaining.
	 * @since   6.1.7
	 */
	public function library(string $path): self
	{
		$path = trim($path);

		if ($path === '')
		{
			return $this;
		}

		$libraries = (array) $this->config->get('libraries', []);

		if (!in_array($path, $libraries, true))
		{
			$libraries[] = $path;
			$this->config->set('libraries', $libraries);
		}

		return $this;
	}

	/**
	 * Set every library folder to harvest classes from.
	 *
	 * @param   array<string>  $paths  Absolute paths to the library folders.
	 *
	 * @return  self  For method chaining.
	 * @since   6.1.7
	 */
	public function libraries(array $paths): self
	{
		$this->config->set('libraries', []);

		foreach ($paths as $path)
		{
			$this->library((string) $path);
		}

		return $this;
	}

	/**
	 * Set the JCB component whose namespace placeholders apply.
	 *
	 * @param   int  $id  The component id, or zero for none.
	 *
	 * @return  self  For method chaining.
	 * @since   6.1.7
	 */
	public function component(int $id): self
	{
		$this->config->set('component', max(0, $id));

		return $this;
	}

	/**
	 * Set the component code name whose namespace segment applies.
	 *
	 * A run harvesting the library of a component that has no JCB row yet still
	 * knows what that component is called, and the component segment of every
	 * namespace is derived from exactly that. Without it the segment stays
	 * concrete, and a class the component owns is stored as belonging to that
	 * one component alone.
	 *
	 * @param   string  $codeName  The component's code name, or an empty string.
	 *
	 * @return  self  For method chaining.
	 * @since   6.1.8
	 */
	public function componentCode(string $codeName): self
	{
		// the segment is derived from the code name alone, exactly as the
		// compiler does it -- the com_ prefix is Joomla's, never the name's
		$this->config->set(
			'componentCode',
			(string) preg_replace('/^com_/i', '', trim($codeName))
		);

		return $this;
	}

	/**
	 * Set what happens when a harvested class already exists as a power.
	 *
	 * @param   string  $policy  Either skip, update, or replace.
	 *
	 * @return  self  For method chaining.
	 * @since   6.1.7
	 */
	public function onExisting(string $policy): self
	{
		return $this->option('onExisting', strtolower(trim($policy)));
	}

	/**
	 * Restrict the operation to namespace repairs of identified existing Powers.
	 *
	 * @param   bool  $repair  Whether to enable namespace-only repair.
	 *
	 * @return  self  For method chaining.
	 * @since   6.2.2
	 */
	public function repairNamespaces(bool $repair = true): self
	{
		$this->config->set('repairNamespaces', $repair);

		return $this;
	}

	/**
	 * Restrict the run to the named candidates.
	 *
	 * A candidate answers to its guid, class name, real or stored namespace,
	 * and its file below the library, so the list may use any of them.
	 *
	 * @param   array<string>  $names  The names to include.
	 *
	 * @return  self  For method chaining.
	 * @since   6.1.7
	 */
	public function include(array $names): self
	{
		$this->config->set('include', array_values(array_map('strval', $names)));

		return $this;
	}

	/**
	 * Exclude the named candidates from the run.
	 *
	 * @param   array<string>  $names  The names to exclude.
	 *
	 * @return  self  For method chaining.
	 * @since   6.1.7
	 */
	public function exclude(array $names): self
	{
		$this->config->set('exclude', array_values(array_map('strval', $names)));

		return $this;
	}

	/**
	 * Produce the report without writing anything.
	 *
	 * @param   bool  $dryRun  Whether to suppress every write.
	 *
	 * @return  self  For method chaining.
	 * @since   6.1.7
	 */
	public function dryRun(bool $dryRun = true): self
	{
		$this->config->set('dryRun', $dryRun);

		return $this;
	}

	/**
	 * Set the bounded scan caps.
	 *
	 * @param   int  $depth     The maximum directory depth.
	 * @param   int  $maxFiles  The maximum number of files to consider.
	 *
	 * @return  self  For method chaining.
	 * @since   6.1.7
	 */
	public function limits(int $depth, int $maxFiles): self
	{
		$this->config->set('depth', max(1, $depth));
		$this->config->set('maxFiles', max(1, $maxFiles));

		return $this;
	}

	/**
	 * Harvest every class the library folders hold, without writing anything.
	 *
	 * @return  Report  What was found, and what each candidate would become.
	 * @since   6.1.7
	 */
	public function harvest(): Report
	{
		if ((array) $this->config->get('libraries', []) === [])
		{
			$this->message->error('No library folder was given to harvest powers from.');

			return $this->finish(false);
		}

		$found = $this->harvester->harvest();

		if ($found === 0)
		{
			$this->message->error(
				'No class was found in the given library folder(s), so there is '
				. 'nothing to extrude.'
			);
			$this->shortfalls();

			return $this->finish(false);
		}

		$this->assembler->assemble();

		$this->message->success(
			'Harvested ' . $found . ' class(es): '
			. (int) $this->report->get('counts.powers.new', 0) . ' new, '
			. (int) $this->report->get('counts.powers.existing', 0)
			. ' already a power.'
		);
		$this->shortfalls();

		return $this->finish(true);
	}

	/**
	 * Extrude the harvested classes into JCB powers.
	 *
	 * @return  Report  What was found, resolved, written, and skipped.
	 * @since   6.1.7
	 */
	public function extrude(): Report
	{
		$owner = $this->plan->begin();

		try
		{
			if ((array) $this->config->get('libraries', []) === [] || $this->harvester->harvest() === 0)
			{
				$this->plan->block('powers.empty', 'No usable class was found in the supplied library folders.');
			}

			$assembled = $this->assembler->assemble();
			$this->writer->write();
			$this->vendor->write();
			$completed = $owner ? $this->commit->apply() : $this->plan->blockers() === [];

			if ($owner && $completed)
			{
				$this->achieved($assembled);
			}
			elseif ($owner)
			{
				$this->message->error('The complete import was not committed. Review its write-plan blockers or failure report.');
			}

			return $this->finish($completed && $owner);
		}
		catch (\Throwable $error)
		{
			$this->plan->block('powers.prepare', $error->getMessage());

			if ($owner)
			{
				$this->commit->apply();
			}

			return $this->finish(false);
		}
	}

	/**
	 * Everything the run has to say, ready for a caller to present.
	 *
	 * @return  array<string, array<int, array{message: string, subject?: string}>>  The messages by level.
	 * @since   6.1.7
	 */
	public function messages(): array
	{
		return $this->message->all();
	}

	/**
	 * The whole candidate tree the harvest built.
	 *
	 * Libraries, their sub-folder bundles, and every class candidate with its
	 * derived identity -- the structure a caller presents for approval, whose
	 * ticks come back through the include filter.
	 *
	 * @return  array<string, mixed>  The harvest tree.
	 * @since   6.1.7
	 */
	public function harvested(): array
	{
		return (array) $this->harvest->toArray();
	}

	/**
	 * Say plainly what the run achieved.
	 *
	 * @param   int  $assembled  How many definitions were assembled.
	 *
	 * @return  void
	 * @since   6.1.7
	 */
	protected function achieved(int $assembled): void
	{
		if ((bool) $this->config->get('repairNamespaces', false))
		{
			$dryRun = (bool) $this->config->get('dryRun', false);
			$count = $this->tally($dryRun ? 'dryrun.power' : 'written.power');
			$this->message->success(
				($dryRun ? 'Prepared ' : 'Applied ') . $count . ' existing Power namespace repair(s).'
			);
			$this->shortfalls();

			return;
		}

		if ((bool) $this->config->get('dryRun', false))
		{
			$this->message->success(
				'Reviewed ' . $assembled . ' class(es) and prepared '
				. $this->tally('dryrun.power') . ' power definition(s). Nothing '
				. 'was written, because this was a dry run.'
			);
			$this->shortfalls();

			return;
		}

		$written = $this->tally('written.power');
		$skipped = $this->tally('skipped.existing.power');
		$parts = [];

		if ($skipped > 0)
		{
			$parts[] = $skipped . ' left untouched because they already exist';
		}

		if (($failed = $this->tally('failed.power')) > 0)
		{
			$parts[] = $failed . ' failed to write';
		}

		$this->message->success(
			'Extruded ' . $written . ' class(es) into JCB powers'
			. ($parts === [] ? '' : ' (' . implode(', ', $parts) . ')') . '.'
		);
		$this->shortfalls();
	}

	/**
	 * Name what the run could not carry over.
	 *
	 * @return  void
	 * @since   6.1.7
	 */
	protected function shortfalls(): void
	{
		$counts = [
			'powers.skipped.unsupported' => 'file(s) declared an enum, which has no '
				. 'power type, and were left out',
			'powers.skipped.nonamespace' => 'file(s) declared no namespace, so no '
				. 'power identity could be derived, and were left out',
			'powers.skipped.noclass' => 'file(s) declared no class at all and were '
				. 'passed over',
			'powers.skipped.unreadable' => 'file(s) could not be read',
			'powers.skipped.duplicate' => 'file(s) declared a class another file '
				. 'already claimed and were left out',
			'powers.failed.library' => 'library folder(s) could not be resolved to '
				. 'a real directory',
			'powers.derived.convention' => 'class(es) sat in a folder that does not '
				. 'mirror their namespace, so their source layout was derived by '
				. 'convention',
			'powers.mismatch.filename' => 'file(s) are named differently than the '
				. 'class they declare',
			'powers.namespace.restated' => 'existing power(s) were recognised by '
				. 'the class they compile to, and had their stored namespace '
				. 'restated from where the class really sits',
			'powers.undecodable.placeholder' => 'system-wide placeholder row(s) do '
				. 'not decode to text and were left out of the namespace resolution'
		];

		foreach ($counts as $key => $tail)
		{
			$found = $this->tally($key);

			if ($found > 0)
			{
				$this->message->notice($found . ' ' . $tail . '.', $key);
			}
		}

		$unmatched = 0;

		foreach ((array) $this->report->get('powers.unmatched.use', []) as $statements)
		{
			$unmatched += count((array) $statements);
		}

		if ($unmatched > 0)
		{
			$this->message->notice(
				$unmatched . ' use statement(s) referenced classes that are not '
				. 'powers, so they were kept verbatim in the class head.',
				'powers.unmatched.use'
			);
		}
	}

	/**
	 * How many entries one report branch holds.
	 *
	 * @param   string  $key  The report path.
	 *
	 * @return  int  The number of entries.
	 * @since   6.1.7
	 */
	protected function tally(string $key): int
	{
		return count((array) $this->report->get($key, []));
	}

	/**
	 * Validate and store one option.
	 *
	 * @param   string  $name   The option name.
	 * @param   mixed   $value  The option value.
	 *
	 * @return  self  For method chaining.
	 * @since   6.1.7
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
	 * @param   bool  $completed  Whether the run reached its goal.
	 *
	 * @return  Report  The run report.
	 * @since   6.1.7
	 */
	protected function finish(bool $completed): Report
	{
		$this->report->set('powers.completed', $completed);
		$this->report->set('dry_run', (bool) $this->config->get('dryRun', false));

		return $this->report;
	}
}

