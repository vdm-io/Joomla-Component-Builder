<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    21st September, 2026
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Extrusion\Resolver;


use Joomla\Database\DatabaseInterface;
use VDM\Joomla\Componentbuilder\Extrusion\Discovery\Scanner;
use VDM\Joomla\Componentbuilder\Extrusion\Config;
use VDM\Joomla\Componentbuilder\Extrusion\Powers\Resolver\Identity;
use VDM\Joomla\Componentbuilder\Extrusion\Registry\Decision;
use VDM\Joomla\Componentbuilder\Extrusion\Registry\Harvest;
use VDM\Joomla\Componentbuilder\Extrusion\Registry\Plan;
use VDM\Joomla\Componentbuilder\Extrusion\Registry\Report;
use VDM\Joomla\Interfaces\Data\ItemInterface;


/**
 * Validate the complete operation, then commit its exact effective Data payloads.
 * 
 * A dependency may be referenced without permission to mutate it. Approval is
 * checked only for actual changed fields, and is bound to the plan fingerprint.
 * 
 * @since  6.2.0
 */
final class Commit
{
	/**
	 * Run configuration and supplied approvals.
	 *
	 * @var    Config
	 * @since  6.2.0
	 */
	protected Config $config;

	/**
	 * The complete private operation plan.
	 *
	 * @var    Plan
	 * @since  6.2.0
	 */
	protected Plan $plan;

	/**
	 * The raw-value Data reader/writer.
	 *
	 * @var    ItemInterface
	 * @since  6.2.0
	 */
	protected ItemInterface $item;

	/**
	 * The same Joomla database connection used by Data.
	 *
	 * @var    DatabaseInterface
	 * @since  6.2.0
	 */
	protected DatabaseInterface $db;

	/**
	 * Read-only scoped identity evidence.
	 *
	 * @var    Identity
	 * @since  6.2.0
	 */
	protected Identity $identity;

	/**
	 * All Power source and resolution records.
	 *
	 * @var    Harvest
	 * @since  6.2.0
	 */
	protected Harvest $harvest;

	/**
	 * Explicit pairing verdicts.
	 *
	 * @var    Decision
	 * @since  6.2.0
	 */
	protected Decision $decisions;

	/**
	 * Bounded operation diagnostics.
	 *
	 * @var    Report
	 * @since  6.2.0
	 */
	protected Report $report;

	/**
	 * The bounded source scanner used to revalidate the file selection.
	 *
	 * @var    Scanner
	 * @since  6.2.0
	 */
	protected Scanner $scanner;

	/**
	 * Constructor.
	 *
	 * @param   Config  $config  Run configuration and supplied approvals.
	 * @param   Plan  $plan  The complete private operation plan.
	 * @param   ItemInterface  $item  The raw-value Data reader/writer.
	 * @param   DatabaseInterface  $db  The same Joomla database connection used by Data.
	 * @param   Identity  $identity  Read-only scoped identity evidence.
	 * @param   Harvest  $harvest  All Power source and resolution records.
	 * @param   Decision  $decisions  Explicit pairing verdicts.
	 * @param   Report  $report  Bounded operation diagnostics.
	 * @param   Scanner  $scanner  The source selection used for revalidation.
	 *
	 * @since   6.2.0
	 */
	public function __construct(Config $config, Plan $plan, ItemInterface $item, DatabaseInterface $db, Identity $identity, Harvest $harvest, Decision $decisions, Report $report, Scanner $scanner)
	{
		$this->config = $config;
		$this->plan = $plan;
		$this->item = $item;
		$this->db = $db;
		$this->identity = $identity;
		$this->harvest = $harvest;
		$this->decisions = $decisions;
		$this->report = $report;
		$this->scanner = $scanner;
	}

	/**
	 * Capture read-only evidence after the engines have settled the final context.
	 *
	 * @return  void
	 * @since   6.2.0
	 */
	public function context(): void
	{
		$classes = (array) $this->harvest->get('classes', []);
		$sources = [];

		foreach ($classes as $key => $candidate)
		{
			$sources[$key] = array_intersect_key($candidate, array_flip([
				'source_key', 'source_unit', 'source_component_id', 'source_guid',
				'fqn', 'stored', 'type', 'location', 'binding', 'resolution', 'action'
			]));

			foreach ($candidate['occurrences'] ?? [] as $file)
			{
				$this->plan->file($file['file'], $file['snapshot']);
			}

			foreach ($candidate['metadata_files'] ?? [] as $file)
			{
				$this->plan->file($file['file'], $file['snapshot']);
			}

			if (!in_array($candidate['action'], ['ignored', 'filtered'], true))
			{
				foreach ($candidate['resolution']['blockers'] ?? [] as $number => $reason)
				{
					$this->plan->block('power.' . $key . '.' . $number, $reason);
				}
			}
		}

		$this->plan->set('sources', $sources);
		$this->plan->set('context', $this->identity->fingerprint());

		foreach ((array) $this->decisions->get('power', []) as $key => $decision)
		{
			if (!isset($classes[$key]))
			{
				$this->plan->block('decision.' . $key, 'A Power pairing no longer identifies a source in this operation.');
			}
		}

		foreach ((array) $this->report->get('failed.decision', []) as $kind => $errors)
		{
			if ($errors !== [])
			{
				$this->plan->block('decision.' . $kind, 'Malformed pairing verdicts must be corrected before import.');
			}
		}
	}

	/**
	 * Validate approvals and current evidence, then atomically apply the plan.
	 *
	 * @return  bool  True for a verified dry run, no-op or committed operation.
	 * @since   6.2.0
	 */
	public function apply(): bool
	{
		$transaction = false;
		$written = [];

		try
		{
			$this->context();
			$this->namespaceRepair();
			$required = $this->scopes();
			$fingerprint = $this->plan->fingerprint();
			$approved = (string) $this->config->get('approvedPlan', '');
			$dryRun = (bool) $this->config->get('dryRun', false);
			$this->report->set('plan', [
				'fingerprint' => $fingerprint, 'required_approvals' => $required,
				'changes' => count($this->plan->writes()), 'status' => 'prepared',
				'blockers' => $this->plan->blockers(), 'writes' => []
			]);

			if (!$dryRun && $approved !== '' && !hash_equals($fingerprint, $approved))
			{
				$this->plan->block('approval.stale', 'The source, targets or effective changes changed since review. Review the new plan before importing.');
			}

			if (!$dryRun)
			{
				foreach ($required as $scope)
				{
					if ($approved === '' || $this->config->get('acknowledge' . ucfirst($scope), false) !== true)
					{
						$this->plan->block('approval.' . $scope, 'This changed ' . $scope . ' scope requires explicit acknowledgement of the reviewed plan.');
					}
				}
			}

			$this->failedProposals();

			if ($this->plan->blockers() !== [])
			{
				return $this->blocked();
			}

			if ($dryRun)
			{
				foreach ($this->plan->writes() as $entry)
				{
					$this->report->set('dryrun.' . $entry['table'] . '.' . $entry['identity'], true);
				}

				$this->report->set('plan.status', 'preview');

				return true;
			}

			// No transaction is needed for a true no-op. A real write enters the
			// same connection used by Data, and all preflight re-reads occur before
			// its first mutation. Savepoints preserve an outer caller transaction.
			if ($this->plan->writes() !== [])
			{
				$this->db->transactionStart(true);
				$transaction = true;
			}

			$this->revalidate();

			if ($this->plan->blockers() !== [])
			{
				if ($transaction)
				{
					$this->db->transactionRollback(true);
					$transaction = false;
				}

				return $this->blocked();
			}

			foreach ($this->plan->writes() as $entry)
			{
				if (!$this->item->table($entry['table'])->set((object) $entry['payload'], $entry['key']))
				{
					throw new \RuntimeException('The Data pipeline refused ' . $entry['table'] . ' ' . $entry['identity'] . '.');
				}

				$written[] = ['table' => $entry['table'], 'identity' => $entry['identity'], 'columns' => array_keys($entry['payload'])];
			}

			if ($transaction)
			{
				$this->db->transactionCommit(true);
				$transaction = false;
			}

			foreach ($written as $entry)
			{
				$this->report->set('written.' . $entry['table'] . '.' . $entry['identity'], true);
			}

			$this->report->set('plan.status', $written === [] ? 'unchanged' : 'committed');
			$this->report->set('plan.writes', $written);

			return true;
		}
		catch (\Throwable $error)
		{
			$rolledBack = false;

			if ($transaction)
			{
				try
				{
					$this->db->transactionRollback(true);
					$rolledBack = true;
				}
				catch (\Throwable $rollback)
				{
					$this->report->set('plan.rollback_error', $rollback->getMessage());
				}
			}

			$this->report->set('plan.status', $rolledBack ? 'rolled-back' : 'failed');
			$this->report->set('plan.error', $error->getMessage());
			$this->report->set('plan.attempted_writes', $written);
			$this->report->set('plan.writes', $rolledBack ? [] : $written);
			$this->report->set('failed.plan', true);

			return false;
		}
		finally
		{
			$this->plan->finish();
		}
	}

	/**
	 * Evaluate mutation scope only for effective changed Power definitions.
	 *
	 * @return  array  The distinct approval categories required by this plan.
	 * @since   6.2.0
	 */
	protected function scopes(): array
	{
		$required = [];
		$scopes = [];

		foreach ($this->plan->writes() as $entry)
		{
			if ($entry['table'] !== 'power')
			{
				continue;
			}

			foreach (array_keys($entry['origins']) as $origin)
			{
				$key = str_starts_with($origin, 'power|') ? substr($origin, 6) : '';
				$source = $key === '' ? null : $this->harvest->get('classes.' . $key);
				$result = $source['resolution'] ?? [];

				if ($source === null || !in_array($result['status'] ?? '', ['matched', 'new'], true)
					|| ($result['write_guid'] ?? '') !== $entry['identity']
					|| ($result['write_eligibility'] ?? 'blocked') === 'blocked')
				{
					$this->plan->block('write.power.' . $key, 'A Power write has no validated source-to-target decision.');

					continue;
				}

				$scope = $result['write_scope'];
				$scopes[$key] = ['guid' => $entry['identity'], 'scope' => $scope, 'remapping' => $result['remapping'] ?? false];

				if (!empty($result['remapping']))
				{
					$required['remapping'] = true;
				}

				if ($result['write_eligibility'] === 'approval' && !in_array($scope, ['new', 'component'], true))
				{
					$required[$scope === 'unestablished' ? 'unknown' : $scope] = true;
				}

				if ($scope === 'foreign' && !($result['explicit'] ?? false))
				{
					$this->plan->block('write.foreign.' . $key, 'A foreign Power requires an explicit compatible target pairing.');
				}
			}
		}

		$this->plan->set('scopes', $scopes);
		ksort($required);

		return array_keys($required);
	}

	/**
	 * Enforce the namespace-only boundary on the complete repair operation.
	 *
	 * @return  void
	 * @since   6.2.2
	 */
	protected function namespaceRepair(): void
	{
		if (!(bool) $this->config->get('repairNamespaces', false))
		{
			return;
		}

		if ((int) $this->config->get('component', 0) < 1)
		{
			$this->plan->block('repair.component', 'Namespace repair requires a selected existing component.');
		}

		foreach ($this->plan->writes() as $entry)
		{
			if ($entry['table'] !== 'power' || $entry['key'] !== 'guid'
				|| $entry['action'] !== 'update' || $entry['origins'] === []
				|| ($entry['payload']['guid'] ?? '') !== $entry['identity']
				|| array_diff(array_keys($entry['payload']), ['guid', 'namespace']) !== []
				|| !isset($entry['payload']['namespace']))
			{
				$this->plan->block('repair.write.' . $entry['identity'], 'Namespace repair may only update the namespace of an existing Power.');

				continue;
			}

			foreach (array_keys($entry['origins']) as $origin)
			{
				$key = str_starts_with($origin, 'power|') ? substr($origin, 6) : '';
				$source = $this->harvest->get('classes.' . $key);
				$result = $source['resolution'] ?? [];

				if (($result['status'] ?? '') !== 'matched'
					|| ($result['matched_guid'] ?? '') !== $entry['identity']
					|| ($result['namespace']['value'] ?? null) !== $entry['payload']['namespace']
					|| empty($result['namespace']['round_trip']))
				{
					$this->plan->block('repair.source.' . $key, 'A namespace repair requires one validated existing Power and its reviewed namespace.');
				}
			}
		}
	}

	/**
	 * Re-read every relevant file, record and component-reference snapshot.
	 *
	 * @return  void
	 * @since   6.2.0
	 */
	protected function revalidate(): void
	{
		foreach ((array) $this->plan->get('directories', []) as $directory)
		{
			$this->scanner->files($directory['root'], $directory['extensions']);
		}

		foreach ((array) $this->plan->get('files', []) as $file)
		{
			if (!is_file($file['file']) || !hash_equals($file['snapshot'], (string) hash_file('sha256', $file['file'])))
			{
				$this->plan->block('stale.file.' . hash('sha256', $file['file']), 'A source file changed after this plan was assembled.');
			}
		}

		foreach ((array) $this->plan->get('reads', []) as $slot => $read)
		{
			$id = $this->item->table($read['table'])->value($read['identity'], $read['key'], 'id');
			$row = $this->item->table($read['table'])->get($read['identity'], $read['key']);

			if ($id !== $read['id'] || !hash_equals($read['snapshot'], Plan::digest($row)))
			{
				$this->plan->block('stale.record.' . $slot, 'An affected record changed after this plan was assembled.');
			}
		}

		$context = (string) $this->plan->get('context');

		if (!hash_equals($context, $this->identity->revalidateFingerprint()))
		{
			$this->plan->block('stale.context', 'Component references or namespace configuration changed after review.');
		}
	}

	/**
	 * An unsuccessful proposed definition cannot permit partial operation writes.
	 *
	 * @return  void
	 * @since   6.2.0
	 */
	protected function failedProposals(): void
	{
		foreach ((array) $this->report->get('failed', []) as $kind => $failed)
		{
			if (!in_array($kind, ['option', 'decision'], true) && $failed !== [] && $failed !== false)
			{
				$this->plan->block('preflight.' . $kind, 'A required definition could not be prepared: ' . $kind . '.');
			}
		}
	}

	/**
	 * Return a blocked result with no write-success claims.
	 *
	 * @return  bool  Always false.
	 * @since   6.2.0
	 */
	protected function blocked(): bool
	{
		$this->report->set('plan.status', 'blocked');
		$this->report->set('plan.blockers', $this->plan->blockers());
		$this->report->set('plan.writes', []);

		return false;
	}
}

