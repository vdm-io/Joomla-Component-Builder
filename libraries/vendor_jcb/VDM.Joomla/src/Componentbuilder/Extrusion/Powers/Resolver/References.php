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


use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Power\ExtractorInterface;
use VDM\Joomla\Componentbuilder\Compiler\Power\Selection;
use VDM\Joomla\Componentbuilder\Extrusion\Config;
use VDM\Joomla\Componentbuilder\Power\Table;
use VDM\Joomla\Interfaces\Database\LoadInterface;
use VDM\Joomla\Utilities\GuidHelper;


/**
 * Reads component-to-Power references without compiling or evaluating code.
 * 
 * Table relationships and the Package configs define the traversable records.
 * Compiler Power tokens and relationship selections define the Power edges.
 * A consumer is evidence of usage, never exclusive namespace ownership.
 * 
 * @since  6.2.0
 */
final class References
{
	/**
	 * The raw, read-only database boundary.
	 *
	 * @var    LoadInterface
	 * @since  6.2.0
	 */
	protected LoadInterface $load;

	/**
	 * The authoritative relationship metadata.
	 *
	 * @var    Table
	 * @since  6.2.0
	 */
	protected Table $table;

	/**
	 * The compiler's token reader; only its pure get method is used.
	 *
	 * @var    ExtractorInterface
	 * @since  6.2.0
	 */
	protected ExtractorInterface $tokens;

	/**
	 * Pure selection rules shared with the ordinary compiler.
	 *
	 * @var    Selection
	 * @since  6.2.0
	 */
	protected Selection $selection;

	/**
	 * Effective generated-target options, when supplied by the operation.
	 *
	 * @var    Config|null
	 * @since  6.2.0
	 */
	protected ?Config $config;

	/**
	 * Direct child lists read from the existing Package configuration classes.
	 *
	 * @var    array<string, array>
	 * @since  6.2.0
	 */
	protected array $children;

	/**
	 * Raw query snapshots, private to one explicit run.
	 *
	 * @var    array<string, array>
	 * @since  6.2.0
	 */
	protected array $reads = [];

	/**
	 * Contexts keyed by component id, including their GUID and provenance.
	 *
	 * @var    array<int, array>
	 * @since  6.2.0
	 */
	protected array $contexts = [];

	/**
	 * Consumer observations indexed by Power GUID, limited to requested roots.
	 *
	 * @var    array<string, array<int, array>>
	 * @since  6.2.0
	 */
	protected array $consumers = [];

	/**
	 * Decoded records and extracted outgoing edges, shared across root visits.
	 *
	 * @var    array<string, array>
	 * @since  6.2.0
	 */
	protected array $nodes = [];

	/**
	 * Cached metadata shapes, independent of record snapshots.
	 *
	 * @var    array<string, array>
	 * @since  6.2.0
	 */
	protected array $shapes = [];

	/**
	 * Cached snapshot of the immutable per-run reference read set.
	 *
	 * @var    string|null
	 * @since  6.2.0
	 */
	protected ?string $snapshot = null;

	/**
	 * Context options for the currently cached read set.
	 *
	 * @var    string|null
	 * @since  6.2.0
	 */
	protected ?string $scope = null;

	/**
	 * Whether complete catalogue discovery was explicitly requested.
	 *
	 * @var    bool
	 * @since  6.2.0
	 */
	protected bool $audited = false;

	/**
	 * Whether every explicitly audited component had a valid identity.
	 *
	 * @var    bool
	 * @since  6.2.0
	 */
	protected bool $identified = true;

	/**
	 * Bounded query descriptors retained for non-mutating fresh validation.
	 *
	 * @var    array<string, array>
	 * @since  6.2.0
	 */
	protected array $requests = [];

	/**
	 * Nodes already expanded for explicitly selected existing Power bindings.
	 *
	 * @var    array<string, int>
	 * @since  6.2.0
	 */
	protected array $effectiveVisited = [];

	/**
	 * Effective dependency identities already delivered to the binding resolver.
	 *
	 * @var    array<string, bool>
	 * @since  6.2.0
	 */
	protected array $effectivePowers = [];

	/**
	 * Coverage gaps retained across incremental effective dependency visits.
	 *
	 * @var    array<string, string>
	 * @since  6.2.0
	 */
	protected array $effectiveGaps = [];

	/**
	 * Constructor.
	 *
	 * @param   LoadInterface       $load      The database read boundary.
	 * @param   Table               $table     The Power relationship metadata.
	 * @param   ExtractorInterface  $tokens    The pure compiler token reader.
	 * @param   array               $children  Package-owned direct child lists.
	 * @param   Selection|null      $selection Pure compiler selection rules.
	 * @param   Config|null         $config    Effective generated-target options.
	 *
	 * @since   6.2.0
	 */
	public function __construct(
		LoadInterface $load,
		Table $table,
		ExtractorInterface $tokens,
		array $children,
		?Selection $selection = null,
		?Config $config = null
	)
	{
		$this->load = $load;
		$this->table = $table;
		$this->tokens = $tokens;
		$this->children = $children;
		$this->selection = $selection ?? new Selection();
		$this->config = $config;
	}

	/**
	 * Discard record, reference and consumer snapshots at the run boundary.
	 *
	 * @return  void
	 * @since   6.2.0
	 */
	public function refresh(): void
	{
		$this->snapshot = null;
		$this->reads = [];
		$this->contexts = [];
		$this->consumers = [];
		$this->nodes = [];
		$this->scope = null;
		$this->audited = false;
		$this->identified = true;
		$this->requests = [];
		$this->effectiveVisited = [];
		$this->effectivePowers = [];
		$this->effectiveGaps = [];
	}

	/**
	 * Explicitly audit all components outside the selected-root operation.
	 *
	 * @return  array<int, array>  Contexts with direct/transitive usage and gaps.
	 * @since   6.2.0
	 */
	public function contexts(): array
	{
		if (!$this->audited)
		{
			foreach ($this->query('joomla_component', []) as $component)
			{
				$id = (int) ($component['id'] ?? 0);

				if ($id < 1 || !GuidHelper::valid((string) ($component['guid'] ?? '')))
				{
					$this->identified = false;

					continue;
				}

				$this->context($id);
			}

			$this->audited = true;
			$this->snapshot = null;
		}

		return $this->contexts;
	}

	/**
	 * Read observed roots without requesting additional component records.
	 *
	 * @return  array<int, array>  Contexts already requested in this operation.
	 * @since   6.2.0
	 */
	public function observed(): array
	{
		return $this->contexts;
	}

	/**
	 * Read one context without treating missing information as ownership proof.
	 *
	 * @param   int  $component  The selected component id.
	 *
	 * @return  array  The context, or an explicitly unestablished context.
	 * @since   6.2.0
	 */
	public function context(int $component): array
	{
		$scope = serialize([
			$this->config?->get('joomla_version'),
			$this->config?->get('layout'),
			$this->config?->get('powers'),
			$this->config?->get('add_power')
		]);

		if ($this->scope !== null && $this->scope !== $scope)
		{
			$this->refresh();
		}

		if ($this->scope !== $scope)
		{
			$this->snapshot = null;
			$this->scope = $scope;
		}

		if (isset($this->contexts[$component]))
		{
			return $this->contexts[$component];
		}

		$context = [
			'id' => $component, 'guid' => '', 'name' => '', 'powers' => [],
			'gaps' => [], 'complete' => $component === 0
		];

		if ($component > 0)
		{
			$rows = $this->query('joomla_component', ['a.id' => $component]);

			if (count($rows) === 1 && GuidHelper::valid((string) ($rows[0]['guid'] ?? '')))
			{
				$record = $rows[0];
				$context['guid'] = strtolower($record['guid']);
				$context['name'] = (string) ($record['name_code'] ?? '');
				$this->walk($record, $context);
				$context['complete'] = $context['gaps'] === [];
			}
			else
			{
				$context['gaps']['component:' . $component] = count($rows) > 1 ? 'duplicate' : 'missing or invalid identity';
			}
		}
		elseif ($component === 0)
		{
			$this->walk(null, $context);
			$context['complete'] = $context['gaps'] === [];
		}

		ksort($context['powers']);
		ksort($context['gaps']);
		$this->contexts[$component] = $context;
		ksort($this->contexts);

		foreach ($context['powers'] as $guid => $edge)
		{
			if ($component > 0)
			{
				$this->consumers[$guid][$component] = array_intersect_key($context, array_flip(['id', 'guid', 'name', 'complete'])) + $edge;
				ksort($this->consumers[$guid]);
			}
		}

		return $context;
	}

	/**
	 * Expand a selected existing Power's effective dependencies once per run.
	 *
	 * The result is incremental: only newly observed Power identities are
	 * returned. Effective bindings never become stored consumer or ownership
	 * evidence. Missing records stay in the approval read set and are reported.
	 *
	 * @param   string  $guid  The explicitly selected existing Power GUID.
	 *
	 * @return  array{powers: array, gaps: array, complete: bool}  New dependencies.
	 * @since   6.2.0
	 */
	public function power(string $guid): array
	{
		$context = ['powers' => [], 'gaps' => []];
		$queue = [];
		$this->enqueue($queue, $context, 'power', $guid, 0, 'effective:' . strtolower($guid));
		$this->traverse(array_values($queue), $context, $this->effectiveVisited, true);
		$context['powers'] = array_diff_key($context['powers'], $this->effectivePowers);
		$this->effectivePowers += array_fill_keys(array_keys($context['powers']), true);
		$this->effectiveGaps += $context['gaps'];
		ksort($context['powers']);
		ksort($context['gaps']);
		$context['complete'] = $this->effectiveGaps === [];

		return $context;
	}

	/**
	 * Return known consumers without asserting exclusive ownership.
	 *
	 * @param   string  $guid  The Power GUID.
	 *
	 * @return  array<int, array>  Public component identities and edge provenance.
	 * @since   6.2.0
	 */
	public function consumers(string $guid): array
	{
		return $this->consumers[strtolower($guid)] ?? [];
	}

	/**
	 * Only an explicit complete audit establishes stored consumer coverage.
	 *
	 * @return  bool  False for ordinary selected-root discovery.
	 * @since   6.2.0
	 */
	public function complete(): bool
	{
		return $this->audited && $this->identified
			&& !in_array(false, array_column($this->contexts, 'complete'), true);
	}

	/**
	 * Fingerprint the exact read set, including empty relationship queries.
	 *
	 * @param   bool  $fresh  Whether to re-read the same bounded queries.
	 *
	 * @return  string  The private approval fingerprint, not record contents.
	 * @since   6.2.0
	 */
	public function fingerprint(bool $fresh = false): string
	{
		if (!$fresh && $this->snapshot !== null)
		{
			return $this->snapshot;
		}

		$reads = $this->reads;

		if ($fresh)
		{
			foreach ($this->requests as $key => [$entity, $where])
			{
				$reads[$key] = $this->read($entity, $where);
			}
		}

		ksort($reads);
		$fingerprint = hash('sha256', serialize([$this->scope, $reads, $this->audited, $this->identified]));

		return $fresh ? $fingerprint : ($this->snapshot = $fingerprint);
	}

	/**
	 * Expose bounded work counters without returning private record contents.
	 *
	 * @return  array<string, int>  The operation-local graph work.
	 * @since   6.2.0
	 */
	public function diagnostics(): array
	{
		return [
			'contexts' => count($this->contexts),
			'queries' => count($this->reads),
			'records' => count($this->nodes),
			'edges' => array_sum(array_map(static fn (array $node): int => count($node['edges']), $this->nodes))
		];
	}

	/**
	 * Traverse one root with compact direct/transitive state and incoming edges.
	 *
	 * @param   array|null  $component  The selected raw component, or first import.
	 * @param   array  $context    The accumulated root-specific evidence.
	 *
	 * @return  void
	 * @since   6.2.0
	 */
	protected function walk(?array $component, array &$context): void
	{
		$override = (int) $this->config?->get('add_power', $this->config?->get('powers', 2));
		$enabled = $this->selection->enabled($override > 1 || $this->config === null
			? (bool) ($component['add_powers'] ?? true) : $override);
		$queue = $component === null ? [] : [['joomla_component', $component, 0, 'component:' . $context['guid']]];
		$visited = [];

		foreach ($this->selection->utilityPowers() as $guid => $force)
		{
			if ($this->selection->enabled($enabled, $force))
			{
				$this->enqueue($queue, $context, 'power', $guid, 0, 'compiler:utility');
			}
		}

		if ($component === null && $enabled)
		{
			foreach ($this->selection->lateUtilityPowers($this->target()) as $guid => $force)
			{
				$this->enqueue($queue, $context, 'power', $guid, 0, 'compiler-generated:component');
			}
		}

		$this->traverse(array_values($queue), $context, $visited, $enabled);
	}

	/**
	 * Expand bounded edges while retaining minimum direct/transitive evidence.
	 *
	 * @param   array  $queue    Initial bounded root records.
	 * @param   array  $context  Root-specific Power and gap observations.
	 * @param   array  $visited  Minimum expansion depth, shared for effective roots.
	 * @param   bool   $enabled Whether unforced code-token loads are enabled.
	 *
	 * @return  void
	 * @since   6.2.0
	 */
	protected function traverse(array $queue, array &$context, array &$visited, bool $enabled): void
	{
		for ($cursor = 0; $cursor < count($queue); $cursor++)
		{
			[$entity, $record, $depth, $via] = $queue[$cursor];
			$guid = (string) ($record['guid'] ?? '');
			$identity = GuidHelper::valid($guid) ? strtolower($guid) : 'id:' . (int) $record['id'];
			$key = $entity . ':' . $identity;

			if ($entity === 'power')
			{
				$context['powers'][$identity]['direct'] = ($context['powers'][$identity]['direct'] ?? false) || $depth === 1;
				$context['powers'][$identity]['via'][$via] = true;
			}

			if (isset($visited[$key]) && $visited[$key] <= $depth)
			{
				continue;
			}

			// Depth 2 represents every transitive route. A shorter route can
			// improve directness at most twice, without reparsing the node.
			$visited[$key] = $depth;
			$node = $this->node($entity, $record, $key, $enabled);
			$context['gaps'] += $node['gaps'];

			foreach ($node['edges'] as [$target, $destination, $cost, $reason])
			{
				$queue[] = [$target, $destination, min(2, $depth + $cost), $reason];
			}
		}

		foreach ($context['powers'] as &$power)
		{
			ksort($power['via']);
		}
		unset($power);
	}

	/**
	 * Load, decode and extract each reached record's outgoing edges only once.
	 *
	 * @param   string  $entity  The metadata-selected entity.
	 * @param   array   $record  The raw record from a bounded read.
	 * @param   string  $key     The stable entity and record identity.
	 * @param   bool    $enabled Whether this root enables unforced Power loads.
	 *
	 * @return  array  Outgoing edges and explicit coverage gaps.
	 * @since   6.2.0
	 */
	protected function node(string $entity, array $record, string $key, bool $enabled): array
	{
		$cache = $key . ':' . (int) $enabled;

		if (isset($this->nodes[$cache]))
		{
			return $this->nodes[$cache];
		}

		$record = $this->decode($entity, $record);
		$shape = $this->shape($entity);
		$edges = [];
		$evidence = ['gaps' => []];

		foreach ($record['_reference_errors'] ?? [] as $field)
		{
			$evidence['gaps'][$key . '.' . $field] = 'invalid storage';
		}

		foreach ($shape['parents'] as $path => $link)
		{
			$target = $link['entity'];

			// Component ownership is a root boundary; Joomla Powers have a
			// separate catalogue and compiler token contract.
			if ($target === 'joomla_component' || $target === 'joomla_power')
			{
				continue;
			}

			if ($target === 'power' && !$enabled && $entity !== 'power')
			{
				continue;
			}

			if ($entity === 'power' && in_array($path, ['extends', 'extendsinterfaces'], true)
				&& $path !== $this->selection->inheritanceField((string) ($record['type'] ?? 'class')))
			{
				continue;
			}

			foreach ($this->values($record, explode('|', $path)) as $value)
			{
				$this->enqueue($edges, $evidence, $target, $value, 0, $key . '.' . $path);
			}
		}

		foreach ($shape['code'] as $field)
		{
			if (!is_string($record[$field] ?? null) || $record[$field] === '')
			{
				continue;
			}

			if ($entity === 'power' && !$this->selection->codeEnabled($record, $field))
			{
				continue;
			}

			if ($entity !== 'power' && array_key_exists('add_' . $field, $record)
				&& (int) $record['add_' . $field] !== 1)
			{
				continue;
			}

			foreach ($enabled ? (array) $this->tokens->get($record[$field]) : [] as $power)
			{
				$this->enqueue($edges, $evidence, 'power', $power, 0, $key . '.' . $field);
			}

			$this->code($record[$field], $edges, $evidence, $key . '.' . $field);
		}

		if ($entity === 'joomla_component')
		{
			$this->injected($record, $edges, $evidence, $key);
		}

		if ($enabled && in_array($entity, ['joomla_component', 'admin_view'], true))
		{
			// These are emitted by the compiler itself, after stored definition
			// loading. Keep their real unforced load semantics and provenance.
			foreach ($this->selection->lateUtilityPowers($this->target(), $entity === 'admin_view') as $guid => $force)
			{
				$this->enqueue($edges, $evidence, 'power', $guid, 0, $key . ':compiler-generated');
			}
		}

		$owned = [];

		foreach ($shape['children'] as $links)
		{
			foreach ($links as $link)
			{
				if (!str_contains($link['key'], '|'))
				{
					$owned[$link['entity']] = true;
				}
			}
		}

		foreach ($shape['children'] as $field => $links)
		{
			$value = $record[$field] ?? null;

			if (!is_scalar($value) || (string) $value === '')
			{
				continue;
			}

			foreach ($links as $link)
			{
				$path = explode('|', $link['key']);
				$reason = $key . '->' . $link['entity'] . '.' . $link['key'];

				if (count($path) !== 1)
				{
					// A direct owner column selects this child's complete local
					// row set. Nested references describe its content, not
					// additional ownership across unrelated components.
					if (!isset($owned[$link['entity']]))
					{
						$evidence['gaps'][$reason] = 'reverse relationship index unavailable';
					}

					continue;
				}

				foreach ($this->query($link['entity'], ['a.' . $path[0] => $value]) as $child)
				{
					$edges[] = [$link['entity'], $child, 0, $reason];
				}
			}
		}

		return $this->nodes[$cache] = ['edges' => $edges, 'gaps' => $evidence['gaps']];
	}

	/**
	 * Follow the compiler's nested stored-code selectors through bounded reads.
	 *
	 * @param   string  $code      The enabled, decoded code field.
	 * @param   array   $edges     The outgoing record edges.
	 * @param   array   $evidence  Accumulated unresolved route evidence.
	 * @param   string  $via       The record and code field provenance.
	 *
	 * @return  void
	 * @since   6.2.0
	 */
	protected function code(string $code, array &$edges, array &$evidence, string $via): void
	{
		foreach ($this->selection->codeReferences($code) as $entity => $selectors)
		{
			foreach (array_unique($selectors) as $selector)
			{
				if ($entity === 'custom_code')
				{
					$selector = trim(explode('+', $selector, 2)[0]);
					$where = [is_numeric($selector) ? 'a.id' : 'a.function_name' => is_numeric($selector) ? (int) $selector : $selector];
					$where['a.target'] = 2;
				}
				else
				{
					$where = ['a.alias' => $selector];
					// The compiler's aliases also include historical normalized
					// spellings. Exact local evidence cannot prove that broader
					// index complete and must never trigger a hidden table scan.
					$evidence['gaps'][$via . '->' . $entity . ':' . $selector . ':aliases'] = 'normalized alias index unavailable';
				}

				$rows = $this->query($entity, $where);
				$reason = $via . '->' . $entity . ':' . $selector;

				if (count($rows) !== 1)
				{
					$evidence['gaps'][$reason] = $rows === [] ? 'missing' : 'duplicate';

					continue;
				}

				if ($entity === 'custom_code' && (int) ($rows[0]['published'] ?? 0) < 1)
				{
					continue;
				}

				$edges[$reason] = [$entity, $rows[0], 0, $reason];
			}
		}

		// Keep this runtime detector out of the compiler's external-code pass.
		if (str_contains($code, '[EXTERNA' . 'LCODE='))
		{
			$evidence['gaps'][$via . ':external'] = 'external code unavailable during read-only discovery';
		}
	}

	/**
	 * Read component-scoped late code injection without loading other roots.
	 *
	 * @param   array   $component  The selected raw component.
	 * @param   array   $edges      The outgoing code edges.
	 * @param   array   $evidence   Missing target-context evidence.
	 * @param   string  $via        Component identity provenance.
	 *
	 * @return  void
	 * @since   6.2.0
	 */
	protected function injected(array $component, array &$edges, array &$evidence, string $via): void
	{
		$target = $this->target();
		$rows = $this->query('custom_code', ['a.component' => $component['guid'], 'a.target' => 1]);

		foreach ($rows as $record)
		{
			if ((int) ($record['published'] ?? 0) < 1)
			{
				continue;
			}

			if (!in_array($target, [3, 4, 5, 6], true))
			{
				$evidence['gaps'][$via . ':injected-target'] = 'generated Joomla target unavailable';

				continue;
			}

			if ((int) ($record['joomla_version'] ?? 0) === $target)
			{
				$edges[] = ['custom_code', $record, 0, $via . ':injected'];
			}
		}
	}

	/**
	 * Read the generated Joomla target without substituting the host version.
	 *
	 * @return  int  The explicit target major, or zero when not established.
	 * @since   6.2.0
	 */
	protected function target(): int
	{
		$target = (int) $this->config?->get('joomla_version', 0);
		$layout = (string) $this->config?->get('layout', 'auto');

		if ($target === 0 && in_array($layout, ['j3', 'j4', 'j5', 'j6'], true))
		{
			$target = (int) substr($layout, 1);
		}

		return $target;
	}

	/**
	 * Add one validated forward reference and record unavailable destinations.
	 *
	 * @param   array   $queue    The pending records.
	 * @param   array   $context  The component provenance.
	 * @param   string  $entity   The metadata-selected entity.
	 * @param   mixed   $value    The referenced GUID or legacy numeric id.
	 * @param   int     $depth    Number of Power edges already crossed.
	 * @param   string  $via      The referring entity and field.
	 *
	 * @return  void
	 * @since   6.2.0
	 */
	protected function enqueue(array &$queue, array &$context, string $entity, $value, int $depth, string $via): void
	{
		if (!$this->table->exist($entity) || !is_scalar($value))
		{
			return;
		}

		$value = (string) $value;
		$key = GuidHelper::valid($value) ? 'guid' : (ctype_digit($value) && (int) $value > 0 ? 'id' : null);

		if ($key === 'guid')
		{
			$value = strtolower($value);
		}

		if ($key === null)
		{
			// Zero/empty selectors mean none, and -1 is the custom relationship
			// sentinel. Any other unresolvable Power selector leaves usage
			// unknown; silently dropping it could authorise an exclusive write.
			if ($entity === 'power' && !in_array($value, ['', '0', '-1'], true))
			{
				$context['gaps'][$via . '->power'] = 'invalid reference';
			}

			return;
		}

		$rows = $this->query($entity, ['a.' . $key => $value]);

		if (count($rows) !== 1)
		{
			$context['gaps'][$via . '->' . $entity . ':' . $value] = count($rows) === 0 ? 'missing' : 'duplicate';

			return;
		}

		if ($entity === 'power' && !GuidHelper::valid((string) ($rows[0]['guid'] ?? '')))
		{
			$context['gaps'][$via . '->power:' . $value] = 'invalid identity';

			return;
		}

		$queue[$entity . ':' . $value . ':' . $via] = [$entity, reset($rows), $depth + ($entity === 'power' ? 1 : 0), $via];
	}

	/**
	 * Read a metadata-bounded table through the existing loader and cache it.
	 *
	 * @param   string  $entity  The known entity.
	 * @param   array   $where   The parameterised equality conditions.
	 *
	 * @return  array<int, array>  Deterministically ordered raw records.
	 * @since   6.2.0
	 */
	protected function query(string $entity, array $where): array
	{
		$key = $entity . ':' . serialize($where);

		if (!array_key_exists($key, $this->reads))
		{
			$this->snapshot = null;
			$this->reads[$key] = $this->read($entity, $where);
			$this->requests[$key] = [$entity, $where];
		}

		return $this->reads[$key];
	}

	/**
	 * Execute one recorded read without replacing the reviewed snapshot.
	 *
	 * @param   string  $entity  The known entity.
	 * @param   array   $where   Parameterized equality conditions.
	 *
	 * @return  array<int, array>  Deterministically ordered raw records.
	 * @since   6.2.0
	 */
	protected function read(string $entity, array $where): array
	{
		$rows = array_map(static fn ($row): array => (array) $row,
			(array) $this->load->items(['all' => 'a.*'], ['a' => $entity], $where ?: null));
		usort($rows, static fn (array $a, array $b): int => strcmp(serialize($a), serialize($b)));

		return $rows;
	}

	/**
	 * Cache only immutable relationship and storage metadata.
	 *
	 * @param   string  $entity  The entity name.
	 *
	 * @return  array  Parent paths, approved children, code fields and storage.
	 * @since   6.2.0
	 */
	protected function shape(string $entity): array
	{
		return $this->shapes[$entity] ??= [
			'parents' => $entity === 'power'
				? array_intersect_key($this->table->parents($entity), array_flip($this->selection->relationshipFields()))
				: $this->table->parents($entity),
			'children' => $this->table->children($entity, $this->children[$entity] ?? []),
			'code' => $entity === 'power' ? $this->selection->codeFields() : $this->table->search($entity, 'code'),
			'fields' => $this->table->get($entity) ?? []
		];
	}

	/**
	 * Decode declared storage without executing expressions or stored PHP.
	 *
	 * @param   string  $entity  The known entity.
	 * @param   array   $record  The raw record.
	 *
	 * @return  array  The decoded copy.
	 * @since   6.2.0
	 */
	protected function decode(string $entity, array $record): array
	{
		foreach ($this->shape($entity)['fields'] as $name => $field)
		{
			if (!is_string($record[$name] ?? null))
			{
				continue;
			}

			if (($field['store'] ?? '') === 'base64')
			{
				$decoded = base64_decode($record[$name], true);
				if ($decoded === false)
				{
					$record['_reference_errors'][] = $name;
				}

				$record[$name] = $decoded === false ? '' : $decoded;
			}
			elseif (($field['store'] ?? '') === 'json')
			{
				$raw = $record[$name];
				$record[$name] = json_decode($raw, true);

				if ($raw !== '' && json_last_error() !== JSON_ERROR_NONE)
				{
					$record['_reference_errors'][] = $name;
				}
			}
		}

		return $record;
	}

	/**
	 * Read declared nested/list fields, including numeric legacy references.
	 *
	 * @param   mixed  $value  The decoded node.
	 * @param   array  $path   The remaining metadata path.
	 *
	 * @return  array  Scalar leaf values at that path.
	 * @since   6.2.0
	 */
	protected function values($value, array $path): array
	{
		if ($path === [] && !is_array($value))
		{
			return is_scalar($value) ? [$value] : [];
		}

		if (!is_array($value))
		{
			return [];
		}

		if ($path !== [] && array_key_exists($path[0], $value))
		{
			return $this->values($value[$path[0]], array_slice($path, 1));
		}

		$result = [];

		foreach ($value as $item)
		{
			array_push($result, ...$this->values($item, $path));
		}

		return $result;
	}
}

