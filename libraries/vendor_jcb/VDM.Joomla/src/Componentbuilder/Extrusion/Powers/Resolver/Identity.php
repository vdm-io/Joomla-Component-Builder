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

namespace VDM\Joomla\Componentbuilder\Extrusion\Powers\Resolver;


use VDM\Joomla\Componentbuilder\Extrusion\Config;
use VDM\Joomla\Componentbuilder\Extrusion\Resolver\Guid;


/**
 * One source-to-Power decision for harvest, relationships, preview and writes.
 * 
 * Lookup candidates are gathered before any decision. Usage can disambiguate a
 * definition, but never turns all of its namespace words into component roles.
 * 
 * @since  6.2.0
 */
final class Identity
{
	/**
	 * The run configuration.
	 *
	 * @var    Config
	 * @since  6.2.0
	 */
	protected Config $config;

	/**
	 * The bounded GUID and indexed fallback reader.
	 *
	 * @var    Existing
	 * @since  6.2.0
	 */
	protected Existing $existing;

	/**
	 * The namespace and placement validator.
	 *
	 * @var    Namespacer
	 * @since  6.2.0
	 */
	protected Namespacer $names;

	/**
	 * Read-only component reference evidence.
	 *
	 * @var    References
	 * @since  6.2.0
	 */
	protected References $references;

	/**
	 * Stable creation identity derivation.
	 *
	 * @var    Guid
	 * @since  6.2.0
	 */
	protected Guid $guid;

	/**
	 * Applicable placeholder maps, private to this run and never sent to the UI.
	 *
	 * @var    array<int, array>
	 * @since  6.2.0
	 */
	protected array $contexts = [];

	/**
	 * Context-specific FQN and destination buckets, retaining all candidate GUIDs.
	 *
	 * @var    array<string, array>
	 * @since  6.2.0
	 */
	protected array $indexes = [];

	/**
	 * Semantic resolution results within the current evidence snapshot.
	 *
	 * @var    array<string, array>
	 * @since  6.2.0
	 */
	protected array $resolved = [];

	/**
	 * Bounded requests replayed before persistence, including negative lookups.
	 *
	 * @var    array<string, array>
	 * @since  6.2.0
	 */
	protected array $requests = [];

	/**
	 * Output requests whose occupant evidence also participates in review.
	 *
	 * @var    array<string, array>
	 * @since  6.2.0
	 */
	protected array $placements = [];

	/**
	 * Deterministic work counters for operation diagnostics and scale contracts.
	 *
	 * @var    array<string, int>
	 * @since  6.2.0
	 */
	protected array $counters = ['indexed_records' => 0, 'candidate_evaluations' => 0, 'resolution_cache_hits' => 0, 'index_steps' => 0];

	/**
	 * Independent operation inputs, including runs which contain no Power files.
	 *
	 * @var    string|null
	 * @since  6.2.0
	 */
	protected ?string $operation = null;

	/**
	 * Effective dependencies introduced by actually selected unlinked Powers.
	 *
	 * @var    array<string, array>
	 * @since  6.2.0
	 */
	protected array $effective = [];

	/**
	 * Append-only dependency identities for incremental per-context indexing.
	 *
	 * @var    array<string>
	 * @since  6.2.0
	 */
	protected array $effectiveOrder = [];

	/**
	 * Current active source pairing decisions, independent of source bindings.
	 *
	 * @var    array<string, array>
	 * @since  6.2.0
	 */
	protected array $decisions = [];

	/**
	 * Constructor.
	 *
	 * @param   Config      $config      The run configuration.
	 * @param   Existing    $existing    The bounded definition reader.
	 * @param   Namespacer  $names       The namespace and placement validator.
	 * @param   References  $references  The reference graph.
	 * @param   Guid        $guid        The stable identity derivation service.
	 *
	 * @since   6.2.0
	 */
	public function __construct(Config $config, Existing $existing, Namespacer $names, References $references, Guid $guid)
	{
		$this->config = $config;
		$this->existing = $existing;
		$this->names = $names;
		$this->references = $references;
		$this->guid = $guid;
	}

	/**
	 * Start an explicit fresh record, context and namespace-evidence snapshot.
	 *
	 * @return  void
	 * @since   6.2.0
	 */
	public function refresh(): void
	{
		$this->contexts = [];
		$this->indexes = [];
		$this->resolved = [];
		$this->requests = [];
		$this->placements = [];
		$this->operation = null;
		$this->effective = [];
		$this->effectiveOrder = [];
		$this->decisions = [];
		$this->counters = ['indexed_records' => 0, 'candidate_evaluations' => 0, 'resolution_cache_hits' => 0, 'index_steps' => 0];
		$this->names->forget();
		$this->existing->refresh();
		$this->references->refresh();
	}

	/**
	 * Resolve all available identity evidence without a first-match fallback.
	 *
	 * @param   array       $source     Stable source identity and raw observations.
	 * @param   array|null  $decision   An explicit, source-keyed pairing verdict.
	 * @param   bool        $reference  Resolve a dependency without granting write scope.
	 *
	 * @return  array  The common resolution contract, including any blockers.
	 * @since   6.2.0
	 */
	public function resolve(array $source, ?array $decision = null, bool $reference = false): array
	{
		$this->scope();
		// Do not include assembler output such as action/guid/resolution in a
		// source key. Include every observed input used by identity and placement.
		$source = array_intersect_key($source, array_flip([
			'source_key', 'source_unit', 'source_component_id', 'source_guid',
			'fqn', 'stored', 'type', 'source_error', 'binding', 'placement_valid', 'placement_evidence'
		]));
		$target = $this->names->context();
		$this->contexts[(int) $target['id']] = $target;
		$context = $this->sourceContext($source);
		$this->references->context((int) $target['id']);

		if ((int) $context['id'] > 0 && $context['id'] !== $target['id'])
		{
			$this->references->context((int) $context['id']);
		}
		$request = [$source, $decision, $reference];
		$key = hash('sha256', serialize([$request, $target, $context, $this->references->fingerprint()]));
		$this->requests[hash('sha256', serialize($request))] = $request;

		if (isset($this->resolved[$key]))
		{
			$this->counters['resolution_cache_hits']++;

			return $this->resolved[$key];
		}

		$result = $this->evaluate($source, $decision, $reference);
		$usage = $this->references->context((int) $target['id']);

		if ($result['status'] === 'matched' && !isset($usage['powers'][$result['matched_guid']]))
		{
			$revision = $this->effectiveRevision();
			$closure = $this->references->power($result['matched_guid']);

			foreach ($closure['powers'] as $guid => $provenance)
			{
				if (!isset($this->effective[$guid]))
				{
					$this->effective[$guid] = $provenance;
					$this->effectiveOrder[] = $guid;
				}
			}

			if ($revision !== $this->effectiveRevision())
			{
				// The complete transitive closure can reveal a conflicting class
				// for this very source. Evaluate that bucket before caching it.
				$result = $this->evaluate($source, $decision, $reference);
			}

			$result['dependency_coverage_complete'] = $closure['complete'];
			$result['dependency_gaps'] = $closure['gaps'];
		}

		$result['context_fingerprint'] = hash('sha256', serialize([$context, $target, $this->references->fingerprint()]));
		// A selected unlinked root may expand the effective graph. Cache under
		// that resulting revision so an unchanged repeat remains a true cache hit.
		$key = hash('sha256', serialize([$request, $target, $context, $this->references->fingerprint()]));

		return $this->resolved[$key] = $result;
	}

	/**
	 * Start a new effective selection snapshot when reviewed pairings change.
	 *
	 * @param   array<string, array>  $decisions  Current source-keyed pairing verdicts.
	 *
	 * @return  void
	 * @since   6.2.0
	 */
	public function prepareDecisions(array $decisions): void
	{
		ksort($decisions);

		if ($this->decisions !== $decisions)
		{
			$this->refresh();
			$this->decisions = $decisions;
		}
	}

	/**
	 * Observe whether one source-selection pass added dependency evidence.
	 *
	 * @return  int  The number of effective dependency identities reached.
	 * @since   6.2.0
	 */
	public function effectiveRevision(): int
	{
		return count($this->effective);
	}

	/**
	 * Rebuild the same bounded evidence queries immediately before persistence.
	 *
	 * Replaying negative name/GUID lookups detects new competing rows without a
	 * catalogue scan. Fresh graph traversal detects newly linked dependencies.
	 *
	 * @return  string  The freshly revalidated semantic fingerprint.
	 * @since   6.2.0
	 */
	public function revalidateFingerprint(): string
	{
		$requests = $this->requests;
		$placements = $this->placements;
		$roots = array_keys($this->references->observed());
		$this->refresh();

		foreach ($roots as $component)
		{
			$this->references->context((int) $component);
		}

		foreach ($requests as [$source, $decision, $reference])
		{
			$this->resolve($source, $decision, $reference);
		}

		foreach ($placements as $output)
		{
			$this->occupants($output);
		}

		return $this->fingerprint();
	}

	/**
	 * Read bounded occupants of a compiled class or physical destination.
	 *
	 * Selected dependencies are indexed once, including ignored source files.
	 * The indexed name fallback retains unlinked conventional occupants as well.
	 *
	 * @param   array{fqn: string, path: string}  $output  The proposed destination.
	 *
	 * @return  array<string, array{guid: string, fqn: string, path: string}>  Occupants.
	 * @since   6.2.0
	 */
	public function occupants(array $output): array
	{
		$this->scope();
		$this->placements[hash('sha256', serialize($output))] = $output;
		$context = $this->names->context();
		$usage = $this->references->context((int) $context['id']);
		$source = ['fqn' => $output['fqn'], 'stored' => $output['fqn']];
		$key = $this->index($source, $context, $usage);
		$index = $this->indexes[$key];

		return ($index['outputs'][$this->names->key($output['fqn'])] ?? [])
			+ ($index['paths'][strtolower($output['path'])] ?? []);
	}

	/**
	 * Expose work counts without source code or private placeholder values.
	 *
	 * @return  array<string, int>  Counts within the current operation.
	 * @since   6.2.0
	 */
	public function work(): array
	{
		return $this->counters;
	}

	/**
	 * Evaluate one uncached semantic source identity.
	 *
	 * @param   array       $source     Stable source identity and raw observations.
	 * @param   array|null  $decision   An explicit pairing verdict.
	 * @param   bool        $reference  Resolve without granting write scope.
	 *
	 * @return  array  The common resolution and blocker contract.
	 * @since   6.2.0
	 */
	protected function evaluate(array $source, ?array $decision, bool $reference): array
	{
		$target = $this->names->context();
		$sourceId = (int) ($source['source_component_id'] ?? $this->config->get('sourceComponent', $target['id']));
		$sourceContext = $sourceId === $target['id'] ? $target : $this->context($sourceId);
		$usage = $this->references->context((int) $target['id']);
		$result = [
			'source_key' => (string) ($source['source_key'] ?? ''),
			'source_unit' => (string) ($source['source_unit'] ?? ''),
			'status' => 'unresolved', 'matched_guid' => null, 'write_guid' => null,
			'source_component' => array_intersect_key($sourceContext, array_flip(['id', 'guid', 'code'])),
			'target_component' => array_intersect_key($target, array_flip(['id', 'guid', 'code'])),
			'candidates' => [], 'namespace' => null, 'target' => null,
			'write_eligibility' => 'blocked', 'write_scope' => 'unestablished',
			'dependencies' => [], 'blockers' => [], 'explicit' => $decision !== null,
			'context_fingerprint' => hash('sha256', serialize([$sourceContext, $target, $this->references->fingerprint()]))
		];

		if (($decision['action'] ?? '') === 'ignore')
		{
			$result['status'] = 'ignored';

			return $result;
		}

		if ($result['source_key'] === '' || empty($source['fqn']) || empty($source['stored'])
			|| ($target['id'] > 0 && $target['guid'] === '')
			|| ($sourceId > 0 && $sourceContext['guid'] === ''))
		{
			$result['blockers'][] = 'The source identity or component context is not established.';

			return $result;
		}

		if (!empty($source['source_error']))
		{
			return $this->block($result, 'conflict', (string) $source['source_error']);
		}

		$repair = !$reference && (bool) $this->config->get('repairNamespaces', false);

		if ($repair && ((int) $target['id'] < 1 || $target['guid'] === ''
			|| $target['code'] === '' || $sourceContext['code'] === ''))
		{
			return $this->block($result, 'unresolved', 'Namespace repair requires a selected component with an established code name.');
		}

		if ($repair && ($decision['action'] ?? '') === 'create')
		{
			return $this->block($result, 'conflict', 'Namespace repair can only update an identified existing Power.');
		}

		$derived = $this->guid->derive([
			'power', 'scoped-source-v2', $target['guid'] ?: (string) $this->config->get('targetComponentGuid', $result['source_unit']), $result['source_key']
		]);
		$supplied = strtolower((string) ($source['source_guid'] ?? ''));
		$explicit = strtolower((string) ($decision['target'] ?? ''));
		$compatible = [];

		$index = $this->index($source, $sourceContext, $usage);
		$records = $this->indexedCandidates($index, (string) $source['fqn']);

		foreach (array_unique([$supplied, $explicit, $derived]) as $guid)
		{
			if (($record = $this->existing->power($guid)) !== null)
			{
				$records[$guid] = $record;
			}
		}

		ksort($records);

		foreach ($records as $guid => $record)
		{
			$this->counters['candidate_evaluations']++;
			$evidence = $this->candidate($source, $record, $sourceContext, $usage,
				($decision['action'] ?? '') === 'update' && $explicit === $guid);

			if (!$evidence['plausible'] && !in_array($guid, [$supplied, $explicit, $derived], true))
			{
				continue;
			}

			$result['candidates'][$guid] = $evidence;

			if ($evidence['compatible'] && $record['selectable'])
			{
				$compatible[$guid] = $evidence;
			}
		}

		$scoped = array_filter($compatible, static fn (array $entry): bool => $entry['in_target'] || $entry['in_effective']);
		$literal = array_filter($compatible, static fn (array $entry): bool => $entry['literal']);
		$chosen = null;
		$reason = '';
		$action = $decision['action'] ?? '';

		if ($action === 'update')
		{
			if (!isset($compatible[$explicit]))
			{
				return $this->block($result, 'conflict', 'The explicitly selected target is missing or structurally incompatible.');
			}

			$chosen = $explicit;
			$reason = 'explicit-pairing';
		}
		elseif ($supplied !== '' && ($this->existing->power($supplied) !== null || $result['candidates'] !== [] || !$this->guid->valid($supplied)))
		{
			if (!$this->guid->valid($supplied) || !isset($compatible[$supplied])
				|| ($scoped !== [] && !isset($scoped[$supplied])))
			{
				return $this->block($result, 'conflict', 'Source GUID evidence conflicts with the source structure or component references.');
			}

			$chosen = $supplied;
			$reason = 'validated-source-guid';
		}
		elseif ($action === 'create')
		{
			if (isset($compatible[$derived]))
			{
				$chosen = $derived;
				$reason = 'idempotent-explicit-create';
			}
			elseif ($this->existing->power($derived) !== null)
			{
				return $this->block($result, 'conflict', 'The stable creation GUID is already used by an incompatible definition.');
			}
		}
		elseif (isset($compatible[$derived]) && ($scoped === [] || isset($scoped[$derived])))
		{
			$chosen = $derived;
			$reason = 'stable-source-identity';
		}
		elseif (count($scoped) === 1)
		{
			$chosen = (string) array_key_first($scoped);
			$reason = $compatible[$chosen]['in_target'] ? 'component-reference' : 'effective-reference';
		}
		elseif (count($scoped) > 1)
		{
			return $this->block($result, 'ambiguous', 'More than one source-compatible Power is referenced by the selected component.');
		}
		elseif (count($literal) === 1 && count($compatible) === 1)
		{
			$chosen = (string) array_key_first($literal);
			$reason = 'literal-source-identity';
		}
		elseif ($reference && count($compatible) === 1 && reset($compatible)['concrete'])
		{
			$chosen = (string) array_key_first($compatible);
			$reason = 'concrete-reference';
		}
		elseif ($result['candidates'] !== [])
		{
			return $this->block($result, $compatible === [] ? 'conflict' : 'ambiguous', 'Existing candidates have no unique, compatible source-and-component identity.');
		}

		if ($chosen === null)
		{
			if ($reference)
			{
				$result['status'] = 'external';

				return $result;
			}

			if ($repair)
			{
				$result['status'] = 'ignored';
				$result['reason'] = 'namespace-repair-unmatched';

				return $result;
			}

			$namespace = $this->names->proposal($source, null, $sourceContext);

			if (isset($source['binding']))
			{
				$bound = $this->names->bind($source, (array) $source['binding'], $sourceContext);

				if ($bound === null)
				{
					return $this->block($result, 'conflict', 'The supplied source-root binding does not reconstruct this declaration.');
				}

				$namespace = $this->names->proposal($source, $this->names->express($bound, $sourceContext), $sourceContext);
				$namespace['preserved'] = false;
				$namespace['provenance'] = $source['binding']['provenance'] ?? 'explicit-source-root';
			}

			$result['namespace'] = $namespace;

			if (!$namespace['round_trip'])
			{
				return $this->block($result, 'unresolved', 'The source namespace or file placement cannot be safely reconstructed.');
			}

			$result['status'] = 'new';
			$result['write_guid'] = $supplied !== '' && $this->guid->valid($supplied) ? $supplied : $derived;
			// Equality fallbacks cannot prove the absence of arbitrary unlinked
			// custom-name/alias definitions. Preserve creation, but bind the
			// acknowledged uncertainty to the reviewed plan before writing.
			$result['write_eligibility'] = $action === 'create' ? 'automatic' : 'approval';
			$result['write_scope'] = $action === 'create' ? 'new' : 'unestablished';
			$result['candidate_coverage'] = 'selected-context-and-indexed-fallback';

			return $this->remapping($result, $sourceId, $target['id']);
		}

		$record = $this->existing->power($chosen);
		$entry = $compatible[$chosen];
		$result['status'] = 'matched';
		$result['matched_guid'] = $chosen;
		$result['write_guid'] = $chosen;
		$result['target'] = $record;
		$result['reason'] = $reason;
		$result['consumers'] = $entry['consumers'];
		$result['consumer_coverage_complete'] = $this->references->complete();
		$result['write_scope'] = $entry['scope'];
		$result['write_eligibility'] = $entry['scope'] === 'component' ? 'automatic' : 'approval';
		$result['namespace'] = $this->names->proposal($source, $record['namespace'], $sourceContext);

		if ($reference)
		{
			// A dependency lookup cannot authorise mutation, auxiliary writes or
			// namespace relocation on the referenced definition.
			$result['write_guid'] = null;
			$result['write_eligibility'] = 'reference-only';

			return $result;
		}

		if ($repair)
		{
			$result['namespace'] = $this->names->repair($source, $record['namespace'], $sourceContext);
		}

		if (!$result['namespace']['round_trip'])
		{
			return $this->block($result, 'conflict', $result['namespace']['repair_error']
				?? 'The identified definition does not reconstruct the source namespace and placement in its applicable context.');
		}

		if ($entry['scope'] === 'foreign' && $action !== 'update')
		{
			return $this->block($result, 'conflict', 'An automatic write to a foreign component-specific definition is not permitted.');
		}

		return $this->remapping($result, $sourceId, $target['id']);
	}

	/**
	 * Return source context without publishing its arbitrary placeholder values.
	 *
	 * @param   array  $source  The source descriptor.
	 *
	 * @return  array  The private source placeholder context.
	 * @since   6.2.0
	 */
	public function sourceContext(array $source): array
	{
		$this->scope();
		$id = (int) ($source['source_component_id'] ?? $this->config->get('sourceComponent', $this->config->get('component', 0)));

		return $id === (int) $this->config->get('component', 0) ? $this->names->context() : $this->context($id);
	}

	/**
	 * Read the current reference fingerprint for plan revalidation.
	 *
	 * @param   bool  $fresh  Revalidate without replacing this approved snapshot.
	 *
	 * @return  string  The read-set fingerprint.
	 * @since   6.2.0
	 */
	public function fingerprint(bool $fresh = false): string
	{
		if ($fresh)
		{
			$check = clone $this;
			$check->names = clone $this->names;
			$check->existing = clone $this->existing;
			$check->references = clone $this->references;

			return $check->revalidateFingerprint();
		}

		$this->scope();
		$target = $this->names->context();
		$this->contexts[(int) $target['id']] = $target;
		$this->references->context((int) $target['id']);
		$contexts = $this->contexts;
		ksort($contexts);

		return hash('sha256', serialize([$contexts, $this->config->get('targetComponentGuid')])
			. $this->references->fingerprint() . $this->existing->fingerprint());
	}

	/**
	 * Keep cached contexts out of subsequent runs which skip Power harvesting.
	 *
	 * @return  void
	 * @since   6.2.0
	 */
	protected function scope(): void
	{
		$inputs = [];

		foreach (['component', 'sourceComponent', 'componentCode', 'targetComponentGuid', 'path', 'libraries', 'layout', 'joomla_version', 'repairNamespaces'] as $key)
		{
			$inputs[$key] = $this->config->get($key);
		}

		$signature = hash('sha256', serialize($inputs));

		if ($this->operation !== null && $this->operation !== $signature)
		{
			$this->refresh();
		}

		$this->operation = $signature;
	}

	/**
	 * Index relevant records once per component context and name bucket.
	 *
	 * The database predicates use existing GUID/name/namespace indexes. Namespace
	 * compatibility is evaluated only after a direct FQN bucket has been found.
	 *
	 * @param   array  $source   The concrete source identity.
	 * @param   array  $context  Its component context.
	 * @param   array  $usage    The selected component's reachable Power set.
	 *
	 * @return  string  The effective context index key.
	 * @since   6.2.0
	 */
	protected function index(array $source, array $context, array $usage): string
	{
		// Source vendors are query values, never index partitions. Only the
		// actual component's aliases and core values establish a namespace map.
		$key = hash('sha256', serialize([$context, $usage['id'] ?? $this->config->get('component', 0), count($this->references->observed())]));

		if (!isset($this->indexes[$key]))
		{
			$this->indexes[$key] = ['classes' => [], 'patterns' => [[]], 'outputs' => [], 'paths' => [], 'records' => [], 'names' => [], 'stored' => [], 'effective_cursor' => 0];

			foreach ($this->references->observed() as $observed)
			{
				foreach (array_keys($observed['powers']) as $guid)
				{
					if (($record = $this->existing->power($guid)) !== null)
					{
						$this->indexRecord($key, $record, $context);
					}
				}
			}
		}

		for ($cursor = $this->indexes[$key]['effective_cursor']; $cursor < count($this->effectiveOrder); $cursor++)
		{
			if (($record = $this->existing->power($this->effectiveOrder[$cursor])) !== null)
			{
				$this->indexRecord($key, $record, $context);
				// A fallback candidate may already have been indexed before a
				// reviewed root established that it is an effective occupant.
				$this->indexOutput($key, $record);
			}
		}

		$this->indexes[$key]['effective_cursor'] = count($this->effectiveOrder);

		$parts = explode('\\', trim((string) $source['fqn'], '\\'));
		$name = (string) array_pop($parts);

		if (!isset($this->indexes[$key]['names'][$name]))
		{
			$this->indexes[$key]['names'][$name] = true;

			foreach ($this->existing->named($name) as $record)
			{
				$this->indexRecord($key, $record, $context);
			}
		}

		// Exact written representations also recover legacy records whose name
		// metadata is not the concrete declaration name. No suffix/LIKE scan.
		$sourceMap = $this->names->sourceContext((string) $source['stored'], $context);
		$forms = [(string) $source['stored'], $this->names->express((string) $source['stored'], $sourceMap)];

		foreach (array_unique($forms) as $form)
		{
			if (isset($this->indexes[$key]['stored'][$form]))
			{
				continue;
			}

			$this->indexes[$key]['stored'][$form] = true;

			foreach ($this->existing->stored($form) as $record)
			{
				$this->indexRecord($key, $record, $context);
			}
		}

		return $key;
	}

	/**
	 * Add all contextual FQNs and target destinations of one relevant record.
	 *
	 * @param   string  $key      The effective source context index key.
	 * @param   array   $record   One retained Power definition.
	 * @param   array   $context  The effective source namespace context.
	 *
	 * @return  void
	 * @since   6.2.0
	 */
	protected function indexRecord(string $key, array $record, array $context): void
	{
		$guid = $record['guid'];

		if (isset($this->indexes[$key]['records'][$guid]))
		{
			return;
		}

		// A name bucket can contain only one of several corrupt duplicate-GUID
		// rows. Validate the full GUID bucket before allowing it to be selected.
		$record = $this->existing->power($guid) ?? $record;
		$this->indexes[$key]['records'][$guid] = true;

		foreach (array_merge([$record], $record['duplicates'] ?? []) as $variant)
		{
			$this->indexDefinition($key, $variant, $context);
		}
	}

	/**
	 * Keep duplicate-GUID namespace variants visible as unselectable evidence.
	 *
	 * @param   string  $key      The effective source context index key.
	 * @param   array   $record   One physical database row.
	 * @param   array   $context  The effective source namespace context.
	 *
	 * @return  void
	 * @since   6.2.0
	 */
	protected function indexDefinition(string $key, array $record, array $context): void
	{
		$guid = $record['guid'];
		$this->counters['indexed_records']++;
		$consumers = $this->references->consumers($guid);
		$scopes = $consumers === [] ? [$context] : [];

		foreach ($consumers as $id => $consumer)
		{
			$scopes[] = $this->context((int) $id);
		}

		foreach ($scopes as $scope)
		{
			$canonical = $this->names->canonical($record['namespace'], $scope);

			$this->indexPattern($key, $record, $canonical, $context);

			foreach ([$this->names->resolve($canonical, $context), $this->names->resolve($record['namespace'], $scope)] as $fqn)
			{
				if ($fqn !== '')
				{
					$this->indexes[$key]['classes'][$this->names->key($fqn)][$guid] = $record;
				}
			}
		}

		$this->indexOutput($key, $record);
	}

	/**
	 * Index the variable vendor axis without materialising each source vendor.
	 *
	 * Custom aliases have already been expanded in their owning component. A
	 * unique alphabetic marker survives the compiler's namespace sanitizers;
	 * only substitutions introduced by the Prefix value become trie slots.
	 * Reverse paths start with declaration and namespace suffixes, so a lookup
	 * reaches relevant templates without visiting unrelated selected Powers.
	 *
	 * @param   string  $key        The component context index key.
	 * @param   array   $record     One physical Power definition.
	 * @param   string  $canonical  Its owner-expanded namespace representation.
	 * @param   array   $context    The verified source component context.
	 *
	 * @return  void
	 * @since   6.2.0
	 */
	protected function indexPattern(string $key, array $record, string $canonical, array $context): void
	{
		$marker = 'JcbExtrusionVendor';
		$literal = $context;
		$literal['map'][Placeholders::PREFIX] = '';
		$occupied = strtolower($this->names->expand($canonical, $literal)
			. $this->names->resolve($canonical, $literal)
			. $this->names->resolve($canonical . '\\Probe', $literal));

		while (str_contains($occupied, strtolower($marker)))
		{
			$marker .= 'Slot';
		}

		$symbolic = $context;
		$symbolic['map'][Placeholders::PREFIX] = $marker;
		$fqn = $this->names->key($this->names->resolve($canonical, $symbolic));

		if (!str_contains($fqn, strtolower($marker)))
		{
			return;
		}

		// A Prefix containing namespace separators can change a preceding
		// class fragment into a namespace segment (notably its underscores).
		// Both structural forms share this trie; candidate() checks the exact
		// source value and repeated-variable equality before selection.
		$symbolic['map'][Placeholders::PREFIX] = $marker . '\\' . $marker;
		$forms = [$fqn, $this->names->key($this->names->resolve($canonical, $symbolic))];

		foreach (array_unique($forms) as $form)
		{
			$pattern = strrev(str_replace(strtolower($marker), "\0", $form));
			$node = 0;

			for ($offset = 0, $length = strlen($pattern); $offset < $length; $offset++)
			{
				$part = $pattern[$offset];

				if (!isset($this->indexes[$key]['patterns'][$node]['next'][$part]))
				{
					$next = count($this->indexes[$key]['patterns']);
					$this->indexes[$key]['patterns'][] = [];
					$this->indexes[$key]['patterns'][$node]['next'][$part] = $next;
				}

				$node = $this->indexes[$key]['patterns'][$node]['next'][$part];
			}

			$this->indexes[$key]['patterns'][$node]['records'][$record['guid']] = $record;
		}
	}

	/**
	 * Query concrete and symbolic class buckets without a selected-record scan.
	 *
	 * Vendor slots are conservative structural evidence: sanitizer effects,
	 * embedded or repeated Prefix values are validated by candidate(). Each
	 * trie node/input position is visited at most once for this source FQN.
	 *
	 * @param   string  $key  The component context index key.
	 * @param   string  $fqn  The concrete declared source class.
	 *
	 * @return  array<string, array>  All structurally relevant Power records.
	 * @since   6.2.0
	 */
	protected function indexedCandidates(string $key, string $fqn): array
	{
		$class = $this->names->key($fqn);
		$records = $this->indexes[$key]['classes'][$class] ?? [];
		$input = strrev($class);
		$length = strlen($input);
		$pending = [[0, 0]];
		$visited = [];

		while ($pending !== [])
		{
			[$node, $offset] = array_pop($pending);

			if (isset($visited[$node][$offset]))
			{
				continue;
			}

			$visited[$node][$offset] = true;
			$this->counters['index_steps']++;
			$entry = $this->indexes[$key]['patterns'][$node];

			if ($offset === $length)
			{
				$records += $entry['records'] ?? [];
			}
			elseif (isset($entry['next'][$input[$offset]]))
			{
				$pending[] = [$entry['next'][$input[$offset]], $offset + 1];
			}

			if (isset($entry['next']["\0"]))
			{
				for ($end = $offset; $end <= $length; $end++)
				{
					$pending[] = [$entry['next']["\0"], $end];
				}
			}
		}

		return $records;
	}

	/**
	 * Retain the target placement once usage or a selected root establishes it.
	 *
	 * @param   string  $key     The effective source context index key.
	 * @param   array   $record  One relevant Power row.
	 *
	 * @return  void
	 * @since   6.2.0
	 */
	protected function indexOutput(string $key, array $record): void
	{
		$guid = $record['guid'];
		$target = $this->names->context();
		$usage = $this->references->context((int) $target['id']);
		$canonical = $this->names->canonical($record['namespace'], $target);
		$output = isset($usage['powers'][$guid]) || isset($this->effective[$guid])
			|| (!$this->names->componentVariable($canonical, $target) && !$this->customAlias($record['namespace']))
			? $this->names->output($record['namespace']) : null;

		if ($output !== null)
		{
			$output['guid'] = $guid;
			$this->indexes[$key]['outputs'][$this->names->key($output['fqn'])][$guid] = $output;
			$this->indexes[$key]['paths'][strtolower($output['path'])][$guid] = $output;
		}
	}

	/**
	 * Evaluate a record in its own applicable custom-placeholder contexts.
	 *
	 * @param   array  $source    The source descriptor.
	 * @param   array  $record    One existing Power.
	 * @param   array  $context   Verified source component context.
	 * @param   array  $usage     Selected component usage.
	 * @param   bool   $reviewed  Explicit pairing acknowledges an unknown alias context.
	 *
	 * @return  array  Bounded candidate evidence, not stored code or placeholder maps.
	 * @since   6.2.0
	 */
	protected function candidate(array $source, array $record, array $context, array $usage, bool $reviewed = false): array
	{
		$consumers = $this->references->consumers($record['guid']);
		$inEffective = isset($this->effective[$record['guid']]);
		$unknownAlias = $consumers === [] && !$inEffective && $this->customAlias($record['namespace']);
		$inTarget = isset($usage['powers'][$record['guid']]);
		$scopes = $consumers === [] ? [$context] : [];

		foreach ($consumers as $id => $consumer)
		{
			$scopes[] = $this->context($id);
		}

		$compatible = false;
		$literal = false;
		$concrete = false;
		$generic = false;
		$kind = static fn (string $type): string => str_ends_with($type, 'class') ? 'class' : $type;
		$type = (string) ($source['type'] ?? '');
		$kindFits = $type === '' || $record['type'] === '' || $kind($type) === $kind($record['type']);

		foreach ($scopes as $scope)
		{
			// Expand a component's custom aliases there, then evaluate the
			// remaining reusable core template against the source. Never read
			// A's locally named alias as though B defined it.
			$canonical = $this->names->canonical($record['namespace'], $scope);
			$isGeneric = $this->names->componentVariable($canonical, $scope);
			$sourceMap = $this->names->sourceContext($source['stored'], $context);
			$fits = $this->names->key($this->names->resolve($canonical, $sourceMap)) === $this->names->key($source['fqn']);
			$actual = $this->names->key($this->names->resolve($record['namespace'], $scope)) === $this->names->key($source['fqn']);
			$generic = $generic || $isGeneric;
			$concrete = $concrete || $actual;
			$compatible = $compatible || $fits || $actual;
			$literal = $literal || (!$isGeneric && $fits);
		}

		$scope = $inTarget && count($consumers) === 1 && $usage['complete'] && $this->references->complete() ? 'component'
			: (count($consumers) > 1 || ($literal && $consumers !== [] && $this->references->complete()) ? 'shared'
				: (!$inTarget && $generic && $consumers !== [] ? 'foreign' : 'unestablished'));

		return [
			'guid' => $record['guid'], 'id' => $record['id'],
			'system_name' => $record['system_name'], 'namespace' => $record['namespace'], 'type' => $record['type'],
			'plausible' => $compatible,
			'compatible' => $kindFits && $compatible && $record['selectable'] && (!$unknownAlias || $reviewed),
			'in_target' => $inTarget, 'literal' => $literal && !$unknownAlias, 'concrete' => $concrete && !$unknownAlias,
			'in_effective' => $inEffective,
			'generic' => $generic, 'scope' => $scope, 'consumers' => $consumers,
			'provenance' => $usage['powers'][$record['guid']] ?? [],
			'reason' => $unknownAlias ? 'custom-alias-context-not-established' : (!$kindFits ? 'declaration-kind-conflict'
				: ($inTarget ? 'referenced-by-target' : ($consumers !== [] ? 'other-known-consumers' : 'usage-not-established'))
			)
		];
	}

	/**
	 * Whether a representation needs a custom alias's owning component context.
	 *
	 * @param   string  $namespace  The unchanged stored namespace representation.
	 *
	 * @return  bool  True for a placeholder outside the compiler's core set.
	 * @since   6.2.0
	 */
	protected function customAlias(string $namespace): bool
	{
		preg_match_all('/(?:\[\[\[|###)([A-Za-z0-9_]+)(?:\]\]\]|###)/', $namespace, $matches);

		return array_diff($matches[1], Placeholders::CORE) !== [];
	}

	/**
	 * Read a private, per-component namespace map once in this run.
	 *
	 * @param   int  $component  The component id.
	 *
	 * @return  array  The independent context.
	 * @since   6.2.0
	 */
	protected function context(int $component): array
	{
		return $this->contexts[$component] ??= $this->names->context($component);
	}

	/**
	 * Reject silent source-to-target component remapping.
	 *
	 * @param   array  $result  The resolved result.
	 * @param   int    $source  The source component id.
	 * @param   int    $target  The target component id.
	 *
	 * @return  array  The result with remapping approval requirements.
	 * @since   6.2.0
	 */
	protected function remapping(array $result, int $source, int $target): array
	{
		if ($source !== $target && $source > 0 && $target > 0)
		{
			$result['remapping'] = true;
			$result['write_eligibility'] = 'approval';
		}

		return $result;
	}

	/**
	 * Represent an unresolved decision without fabricating a write target.
	 *
	 * @param   array   $result  The collected evidence.
	 * @param   string  $status  The blocked status.
	 * @param   string  $reason  The bounded diagnostic reason.
	 *
	 * @return  array  The blocked result.
	 * @since   6.2.0
	 */
	protected function block(array $result, string $status, string $reason): array
	{
		$result['status'] = $status;
		$result['write_guid'] = null;
		$result['write_eligibility'] = 'blocked';
		$result['blockers'][] = $reason;

		return $result;
	}
}

