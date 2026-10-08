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
use VDM\Joomla\Componentbuilder\Extrusion\Powers\Resolver\Existing;
use VDM\Joomla\Componentbuilder\Extrusion\Powers\Resolver\Identity;
use VDM\Joomla\Componentbuilder\Extrusion\Powers\Resolver\Namespacer;
use VDM\Joomla\Componentbuilder\Extrusion\Registry\Harvest;
use VDM\Joomla\Componentbuilder\Extrusion\Registry\Report;
use VDM\Joomla\Componentbuilder\Extrusion\Resolver\Constants;
use VDM\Joomla\Componentbuilder\Extrusion\Resolver\Pairing;
use VDM\Joomla\Componentbuilder\Extrusion\Resolver\Placeholder;


/**
 * Assembles the approved harvest candidates into power definitions.
 * 
 * This is where a class's relationships become identities. Every parent,
 * interface and import is resolved to the class it names under PHP's own
 * rules, then to a power guid -- first among the candidates being assembled,
 * then among the powers that already exist -- so classes link by identity the
 * way the powers engine expects. What resolves to a power is dropped from the
 * head entirely, because the compiler reintroduces those imports itself; what
 * does not stays as written, in the head, so nothing a class needs is lost.
 * 
 * The two passes matter: every selected candidate claims its identity before
 * any relationship is resolved, so classes may reference each other in either
 * order and still link.
 * 
 * @since 6.1.7
 */
final class Assembler
{
	/**
	 * The Config Class.
	 *
	 * @var    Config
	 * @since  6.1.7
	 */
	protected Config $config;

	/**
	 * The Harvest Registry.
	 *
	 * @var    Harvest
	 * @since  6.1.7
	 */
	protected Harvest $harvest;

	/**
	 * The Existing Power Resolver.
	 *
	 * @var    Existing
	 * @since  6.1.7
	 */
	protected Existing $existing;

	/**
	 * The Pairing Resolver.
	 *
	 * @var    Pairing
	 * @since  6.1.7
	 */
	protected Pairing $pairing;

	/**
	 * The Report Registry.
	 *
	 * @var    Report
	 * @since  6.1.7
	 */
	protected Report $report;

	/**
	 * The Constants Resolver.
	 *
	 * @var    Constants
	 * @since  6.1.8
	 */
	protected Constants $constants;

	/**
	 * The Namespacer Resolver.
	 *
	 * @var    Namespacer
	 * @since  6.1.9
	 */
	protected Namespacer $namespacer;

	/**
	 * The Placeholder Resolver.
	 *
	 * @var    Placeholder
	 * @since  6.2.0
	 */
	protected Placeholder $placeholder;

	/**
	 * All local source candidates grouped by concrete class name.
	 *
	 * @var    array<string, array>
	 * @since  6.1.7
	 */
	protected array $local = [];

	/**
	 * The common source and dependency identity resolver.
	 *
	 * @var    Identity
	 * @since  6.2.0
	 */
	protected Identity $resolver;

	/**
	 * The source whose relationships are currently being assembled.
	 *
	 * @var    array
	 * @since  6.2.0
	 */
	protected array $active = [];

	/**
	 * Dependency results of the active source, keyed by concrete name.
	 *
	 * @var    array
	 * @since  6.2.0
	 */
	protected array $dependencies = [];

	/**
	 * Dependency evidence reused only within one assembled source/context map.
	 *
	 * @var    array<string, array<string, array>>
	 * @since  6.2.0
	 */
	protected array $resolvedDependencies = [];

	/**
	 * Constructor.
	 *
	 * @param   Config     $config     The extrusion configuration.
	 * @param   Harvest    $harvest    The harvest registry.
	 * @param   Existing   $existing   The existing power resolver.
	 * @param   Pairing    $pairing    The pairing resolver.
	 * @param   Report     $report     The run report registry.
	 * @param   Constants   $constants   The language constant resolver.
	 * @param   Namespacer  $namespacer  The namespace conversion resolver.
	 * @param   Placeholder $placeholder The code placeholder resolver.
	 * @param   Identity    $resolver    The scoped identity resolver.
	 *
	 * @since   6.1.7
	 */
	public function __construct(
		Config $config,
		Harvest $harvest,
		Existing $existing,
		Pairing $pairing,
		Report $report,
		Constants $constants,
		Namespacer $namespacer,
		Placeholder $placeholder,
		Identity $resolver
	)
	{
		$this->config = $config;
		$this->harvest = $harvest;
		$this->existing = $existing;
		$this->pairing = $pairing;
		$this->report = $report;
		$this->constants = $constants;
		$this->namespacer = $namespacer;
		$this->placeholder = $placeholder;
		$this->resolver = $resolver;
	}

	/**
	 * Assemble every selected candidate into a power definition.
	 *
	 * @return  int  The number of definitions assembled.
	 * @since   6.1.7
	 */
	public function assemble(): int
	{
		$this->harvest->remove('resolved');
		$this->harvest->remove('rows');
		$this->report->remove('powers.blocked');
		$this->local = [];
		$this->resolvedDependencies = [];
		$this->report->set('counts.powers.dependency_lookups', 0);
		$this->report->set('counts.powers.dependency_reused', 0);
		$candidates = (array) $this->harvest->get('classes', []);
		ksort($candidates);
		$decisions = [];

		foreach (array_keys($candidates) as $key)
		{
			$decision = $this->pairing->verdict('power', (string) $key);

			if ($decision !== null)
			{
				$decisions[$key] = $decision;
			}
		}

		// A changed manual selection must drop dependency closures introduced
		// by the previous verdict before any current source is resolved.
		$this->resolver->prepareDecisions($decisions);
		$revision = $this->resolver->effectiveRevision();

		foreach ($candidates as $key => &$candidate)
		{
			$candidate = (array) $candidate;
			// Bindings inferred or supplied during an earlier assembly do not
			// survive a changed decision or removal of an explicit binding.
			unset($candidate['binding']);
			$decision = $decisions[$key] ?? null;
			$binding = $this->config->get('sourceBindings', [])[$candidate['source_unit']] ?? null;

			if (is_array($binding))
			{
				$candidate['binding'] = $binding + ['source_unit' => $candidate['source_unit']];
			}

			$this->resolve($candidate, $decision);
		}
		unset($candidate);

		// Each selected root contributes its entire transitive closure. A
		// second pass gives earlier sources the same union as later sources.
		if ($this->resolver->effectiveRevision() !== $revision)
		{
			$revision = $this->resolver->effectiveRevision();

			foreach ($candidates as $key => &$candidate)
			{
				$this->resolve($candidate, $decisions[$key] ?? null);
			}
			unset($candidate);
		}

		$unstable = $this->resolver->effectiveRevision() !== $revision;

		foreach ($candidates as $key => &$candidate)
		{
			if ($unstable)
			{
				$this->block($candidate, 'The selected Power dependency graph did not settle under the reviewed source identities.');
			}

			if (!$this->selected($candidate))
			{
				$candidate['action'] = 'filtered';
				$this->report->set('powers.skipped.filtered.' . $key, true);
			}

			$observations = (array) ($candidate['occurrences'] ?? []);
			$contents = array_unique(array_column($observations, 'snapshot'));

			if (count($observations) > 1 && (count($contents) !== 1 || !$candidate['exists']))
			{
				$this->block($candidate, 'Multiple physical declarations claim this source identity without one consistent existing definition.');
			}
		}
		unset($candidate);

		$this->bindings($candidates);

		// The complete map is built before any relationship is assembled. A
		// skipped existing record stays here; ignoring a new one cannot invent
		// a dependency identity that will never be persisted.
		foreach ($candidates as $key => $candidate)
		{
			$this->local[strtolower(trim($candidate['fqn'], '\\'))][$key] = $candidate;
		}

		$resolved = [];

		// Referenced unlinked Powers may add another complete closure. Delay
		// blockers until all definitions have seen that same dependency union.
		for ($pass = 0; $pass < 2; $pass++)
		{
			$revision = $this->resolver->effectiveRevision();
			$resolved = [];

			foreach ($candidates as $key => &$candidate)
			{
				if (!$this->writable($candidate))
				{
					continue;
				}

				$this->active = $candidate;
				$this->dependencies = [];
				$resolved[$key] = $this->definition($candidate);
				$candidate['resolution']['dependencies'] = $this->dependencies;
			}
			unset($candidate);

			if ($this->resolver->effectiveRevision() === $revision)
			{
				break;
			}
		}

		$unstable = $this->resolver->effectiveRevision() !== $revision;

		foreach ($candidates as $key => &$candidate)
		{
			if (!isset($resolved[$key]))
			{
				continue;
			}

			if ($unstable)
			{
				$this->block($candidate, 'The Power dependency graph did not settle while resolving source relationships.');
			}

			foreach ($candidate['resolution']['dependencies'] as $dependency)
			{
				if (!in_array($dependency['status'], ['matched', 'new', 'external'], true))
				{
					$this->block($candidate, 'Unresolved Power dependency: ' . $dependency['fqn']);
				}
			}
		}
		unset($candidate);

		$this->conflicts($candidates, $resolved);

		$this->propagate($candidates);

		$states = [];
		$skipped = 0;

		foreach ($candidates as $key => $candidate)
		{
			$status = $candidate['resolution']['status'];
			$states[$status] = ($states[$status] ?? 0) + 1;

			if ($candidate['action'] === 'skip')
			{
				$skipped++;
				$this->report->set('skipped.existing.power.' . $candidate['matched_guid'], true);
			}

			if (!in_array($candidate['action'], ['ignore', 'ignored', 'filtered'], true)
				&& $candidate['resolution']['blockers'] !== [])
			{
				$this->report->set('powers.blocked.' . $key, $candidate['resolution']['blockers']);
			}

			if ($this->writable($candidate) && isset($resolved[$key]))
			{
				$this->harvest->set('resolved.' . $key, $resolved[$key]);
				$this->harvest->set('rows.' . $key, $key);
			}
		}

		$this->harvest->set('classes', $candidates);
		$this->active = [];
		$this->report->set('counts.powers.states', $states);
		$this->report->set('counts.powers.new', $states['new'] ?? 0);
		$this->report->set('counts.powers.existing', $states['matched'] ?? 0);
		$this->report->set('counts.powers.skipped', $skipped);
		$count = count((array) $this->harvest->get('resolved', []));
		$this->report->set('counts.powers.assembled', $count);

		return $count;
	}

	/**
	 * Apply one authoritative decision while keeping source identity stable.
	 *
	 * @param   array       $candidate  The source candidate to update.
	 * @param   array|null  $decision   Its explicit pairing verdict.
	 *
	 * @return  void
	 * @since   6.2.0
	 */
	protected function resolve(array &$candidate, ?array $decision): void
	{
		$result = $this->resolver->resolve($candidate, $decision);
		$candidate['resolution'] = $result;
		$candidate['guid'] = $result['write_guid'];
		$candidate['matched_guid'] = $result['matched_guid'];
		$candidate['exists'] = $result['status'] === 'matched';
		$candidate['placeholder'] = $result['namespace']['value'] ?? $candidate['stored'];
		$candidate['standing'] = $result['target']['namespace'] ?? '';
		$candidate['id'] = $result['target']['id'] ?? 0;
		$candidate['action'] = $result['status'] === 'new' ? 'create'
			: ($result['status'] === 'matched' ? 'update' : $result['status']);

		if ($decision === null && $result['status'] === 'matched'
			&& $this->config->get('onExisting', 'update') === 'skip')
		{
			$candidate['action'] = 'skip';
		}
	}

	/**
	 * Recover reusable root roles only from already identified, consistent sources.
	 *
	 * @param   array  $candidates  All distinct source declarations.
	 *
	 * @return  void
	 * @since   6.2.0
	 */
	protected function bindings(array &$candidates): void
	{
		$bindings = [];
		$standing = [];
		$contexts = [];
		$canonical = [];
		$checks = 0;
		$applied = 0;

		foreach ($candidates as $key => $candidate)
		{
			if ($candidate['exists'])
			{
				$contexts[$key] = $this->resolver->sourceContext($candidate);
				$canonical[$key] = $this->namespacer->canonical($candidate['standing'], $contexts[$key]);

				foreach ($this->roots($candidate['fqn']) as $root)
				{
					$standing[$candidate['source_unit']][$root][$key] = true;
				}
			}

			if ($candidate['resolution']['status'] !== 'matched'
				|| in_array($candidate['action'], ['ignored', 'filtered'], true))
			{
				continue;
			}

			$binding = $this->namespacer->binding($candidate, $candidate['standing'],
				$contexts[$key], $candidate['matched_guid']);

			if ($binding !== null)
			{
				// Different proving GUIDs can establish one identical root role.
				// Keep a deterministic witness and validate that role just once.
				$root = strtolower(trim($binding['root'], '\\'));
				$identity = hash('sha256', serialize([$binding['template'], $binding['component']]));
				$bindings[$candidate['source_unit']][$root][$identity] ??= $binding;
			}
		}

		foreach ($bindings as $unit => &$roots)
		{
			foreach ($roots as $root => &$roles)
			{
				foreach ($roles as $identity => $binding)
				{
					foreach ($standing[$unit][$root] ?? [] as $key => $_)
					{
						$checks++;
						$check = $this->namespacer->bind($candidates[$key], $binding, $contexts[$key]);

						if ($check !== null && $this->namespacer->canonical($check, $contexts[$key]) !== $canonical[$key])
						{
							unset($roles[$identity]);

							break;
						}
					}
				}
			}
			unset($roles);
		}
		unset($roots);

		foreach ($candidates as $key => &$candidate)
		{
			if ($candidate['resolution']['status'] !== 'new' || isset($candidate['binding'])
				|| $candidate['action'] === 'filtered'
				|| ($candidate['resolution']['namespace']['provenance'] ?? '') === 'component-code-name')
			{
				continue;
			}

			$possible = [];
			$context = $this->resolver->sourceContext($candidate);

			foreach ($this->roots($candidate['fqn']) as $root)
			{
				foreach ($bindings[$candidate['source_unit']][$root] ?? [] as $binding)
				{
					$applied++;
					$bound = $this->namespacer->bind($candidate, $binding, $context);

					if ($bound !== null)
					{
						$possible[$bound] = $binding;
					}
				}
			}

			if (count($possible) === 1)
			{
				$candidate['binding'] = reset($possible);
				$this->resolve($candidate, $this->pairing->verdict('power', (string) $key));
			}
			elseif (count($possible) > 1)
			{
				$this->report->set('powers.namespace.unresolved.' . $key, 'Competing root roles were retained literally.');
			}
		}
		unset($candidate);
		$this->report->set('counts.powers.binding_checks', $checks);
		$this->report->set('counts.powers.binding_applications', $applied);
	}

	/**
	 * Index only namespace ancestors that could bind one concrete declaration.
	 *
	 * @param   string  $fqn  The concrete class name.
	 *
	 * @return  array<string>  Case-normalized strict ancestor names.
	 * @since   6.2.0
	 */
	protected function roots(string $fqn): array
	{
		$parts = explode('\\', strtolower(trim($fqn, '\\')));
		array_pop($parts);
		$roots = [];
		$prefix = '';

		foreach ($parts as $part)
		{
			$prefix .= ($prefix === '' ? '' : '\\') . $part;
			$roots[] = $prefix;
		}

		return $roots;
	}

	/**
	 * Propagate blocked sources through reverse dependency edges exactly once.
	 *
	 * @param   array  $candidates  Source candidates updated with transitive blockers.
	 *
	 * @return  void
	 * @since   6.2.0
	 */
	protected function propagate(array &$candidates): void
	{
		$dependants = [];
		$queue = [];
		$queued = [];
		$edges = 0;

		foreach ($candidates as $key => $candidate)
		{
			if ($candidate['resolution']['blockers'] !== [])
			{
				$queue[] = $key;
				$queued[$key] = true;
			}

			foreach ($candidate['resolution']['dependencies'] as $dependency)
			{
				foreach ($dependency['source_keys'] ?? [] as $source)
				{
					$dependants[$source][$key] = true;
				}
			}
		}

		for ($cursor = 0; $cursor < count($queue); $cursor++)
		{
			$source = $queue[$cursor];

			foreach ($dependants[$source] ?? [] as $key => $_)
			{
				$edges++;

				if (!$this->writable($candidates[$key]))
				{
					continue;
				}

				$this->block($candidates[$key], 'Dependency source is blocked: ' . $source);

				if (!isset($queued[$key]))
				{
					$queue[] = $key;
					$queued[$key] = true;
				}
			}
		}

		$this->report->set('counts.powers.blocked_dependency_edges', $edges);
	}

	/**
	 * Detect incompatible identities and generated outputs before persistence.
	 *
	 * @param   array  $candidates  The resolved source candidates.
	 * @param   array  $definitions Effective source definitions, before write policies.
	 *
	 * @return  void
	 * @since   6.2.0
	 */
	protected function conflicts(array &$candidates, array $definitions): void
	{
		$targets = [];
		$outputs = [];
		$paths = [];

		foreach ($candidates as $key => $candidate)
		{
			if (!in_array($candidate['resolution']['status'], ['matched', 'new'], true)
				|| !in_array($candidate['action'], ['update', 'create', 'skip'], true))
			{
				continue;
			}

			$guid = $candidate['guid'];
			$output = $this->namespacer->output($candidate['resolution']['namespace']['value']);

			if ($output === null)
			{
				$this->block($candidates[$key], 'The target namespace and compiler file path cannot be resolved.');

				continue;
			}

			// Preserve spelling in diagnostics; comparison also protects targets
			// compiled on case-insensitive filesystems. Skipped existing sources
			// still occupy an output location even though they propose no write.
			$candidates[$key]['resolution']['namespace']['target_path'] = $output['path'];
			$fqn = strtolower($output['fqn']);
			$path = strtolower($output['path']);

			foreach ($this->resolver->occupants($output) as $occupant)
			{
				if ($occupant['guid'] !== $guid)
				{
					$this->block($candidates[$key], 'An existing Power occupies the compiled class or file path: ' . $occupant['guid']);
				}
			}

			if (isset($targets[$guid], $definitions[$key], $definitions[$targets[$guid]])
				&& $definitions[$key] != $definitions[$targets[$guid]])
			{
				$this->block($candidates[$key], 'Incompatible source definitions target one Power GUID.');
				$this->block($candidates[$targets[$guid]], 'Incompatible source definitions target one Power GUID.');
			}

			if (isset($outputs[$fqn]) && $candidates[$outputs[$fqn]]['guid'] !== $guid)
			{
				$this->block($candidates[$key], 'Distinct Power definitions produce the same compiled class.');
				$this->block($candidates[$outputs[$fqn]], 'Distinct Power definitions produce the same compiled class.');
			}

			if (isset($paths[$path]) && $candidates[$paths[$path]]['guid'] !== $guid)
			{
				$this->block($candidates[$key], 'Distinct Power definitions produce the same compiler file path.');
				$this->block($candidates[$paths[$path]], 'Distinct Power definitions produce the same compiler file path.');
			}

			if (isset($definitions[$key]))
			{
				$targets[$guid] = $key;
			}

			$outputs[$fqn] = $key;
			$paths[$path] = $key;
		}
	}

	/**
	 * Whether a candidate can produce a write proposal, subject to approval.
	 *
	 * @param   array  $candidate  One source candidate.
	 *
	 * @return  bool  True for an included, fully resolved source.
	 * @since   6.2.0
	 */
	protected function writable(array $candidate): bool
	{
		return in_array($candidate['resolution']['status'], ['matched', 'new'], true)
			&& in_array($candidate['action'], ['update', 'create'], true);
	}

	/**
	 * Record a blocker without losing the source or the intended target label.
	 *
	 * @param   array   $candidate  The candidate to block.
	 * @param   string  $reason     The bounded diagnostic.
	 *
	 * @return  void
	 * @since   6.2.0
	 */
	protected function block(array &$candidate, string $reason): void
	{
		$candidate['resolution']['status'] = 'conflict';
		$candidate['resolution']['write_eligibility'] = 'blocked';
		$candidate['resolution']['blockers'][] = $reason;
		$candidate['resolution']['blockers'] = array_values(array_unique($candidate['resolution']['blockers']));
	}

	/**
	 * Whether one candidate passes the include and exclude filters.
	 *
	 * A candidate answers to several names -- its guid, its class, its real
	 * and stored namespaces, and its file below the library -- and a caller's
	 * list may use any of them.
	 *
	 * @param   array<string, mixed>  $candidate  The harvest candidate.
	 *
	 * @return  bool  True when the candidate should be assembled.
	 * @since   6.1.7
	 */
	protected function selected(array $candidate): bool
	{
		$include = (array) $this->config->get('include', []);
		$exclude = (array) $this->config->get('exclude', []);
		$names = array_filter([
			(string) ($candidate['source_key'] ?? ''),
			(string) ($candidate['guid'] ?? ''),
			(string) ($candidate['class'] ?? ''),
			(string) ($candidate['fqn'] ?? ''),
			(string) ($candidate['stored'] ?? ''),
			(string) ($candidate['placeholder'] ?? ''),
			(string) ($candidate['relative'] ?? '')
		], 'strlen');

		foreach ($names as $name)
		{
			if (in_array($name, $exclude, true))
			{
				return false;
			}
		}

		return $include === [] || array_intersect($names, $include) !== [];
	}

	/**
	 * One piece of a class, saying the component's name through its placeholder.
	 *
	 * @param   string  $text  The text the class file stated.
	 *
	 * @return  string  The text as a power holds it.
	 * @since   6.2.0
	 */
	protected function say(string $text): string
	{
		return $this->placeholder->reverse($text);
	}

	/**
	 * Build the definition one candidate is written as.
	 *
	 * @param   array<string, mixed>  $candidate  The harvest candidate.
	 *
	 * @return  object  The power definition, carrying its guid.
	 * @since   6.1.7
	 */
	protected function definition(array $candidate): object
	{
		if ((bool) $this->config->get('repairNamespaces', false))
		{
			return (object) [
				'guid' => (string) $candidate['guid'],
				'namespace' => (string) $candidate['placeholder'],
			];
		}

		$guid = (string) $candidate['guid'];
		$type = (string) $candidate['type'];
		$namespace = (string) $candidate['namespace'];
		$imports = $this->imports((array) ($candidate['uses'] ?? []), $namespace);

		$definition = new \stdClass();
		$definition->guid = $guid;
		$definition->name = (string) $candidate['class'];
		$definition->type = $type;
		$this->placement($definition, $candidate);
		// JCB stores code speaking text and lets its compiler make the
		// constant, so a class harvested out of a compiled component has to
		// speak text again -- otherwise the compiler builds a key from a key
		// and the component shows a constant to its users. It defers the
		// component's own name to a placeholder for the same reason: the
		// compiler wrote that name in, and a class that reads it back is
		// bound to the one component it was lifted out of
		$definition->main_class_code = $this->say(
			$this->constants->reverse((string) $candidate['body'])
		);
		$definition->description = $this->say(
			$this->constants->reverse((string) $candidate['docblock'])
		);

		if (!(bool) ($candidate['exists'] ?? false))
		{
			$definition->system_name = $this->systemName((string) $candidate['stored']);
			$definition->power_version = '1.0.0';
			$definition->published = 1;
		}

		// every derived column is stated, empty included, so an update also
		// clears what the class no longer has instead of keeping stale links
		$definition->extends = '';
		$definition->extends_custom = '';
		$definition->implements = [];
		$definition->implements_custom = '';
		$definition->extendsinterfaces = [];
		$definition->extendsinterfaces_custom = '';
		$definition->use_selection = [];
		$definition->head = '';
		$definition->add_head = 0;
		$definition->licensing_template = '';
		$definition->add_licensing_template = 1;

		$license = (string) ($candidate['license'] ?? '');

		if ($license !== '')
		{
			// the licence is left exactly as the file states it: what stands
			// where a component's name stands in a licence is as likely to be
			// the company that wrote it, and the compiler fills that in from
			// a placeholder of its own that no reading of the file can tell
			// apart from this one
			$definition->licensing_template = $license;
			$definition->add_licensing_template = 2;
		}

		$this->relations($definition, $candidate, $imports);
		$this->selections($definition, $guid, $imports);

		return $definition;
	}

	/**
	 * State the namespace a definition is written with, or leave the standing one.
	 *
	 * The identity resolver has already checked the source context, symbolic
	 * roles and placement. A class-name match alone does not permit rewriting
	 * an established representation. Relocations have their own evidence.
	 *
	 * @param   object                $definition  The definition being built.
	 * @param   array<string, mixed>  $candidate   The harvest candidate.
	 *
	 * @return  void
	 * @since   6.1.9
	 */
	protected function placement(object $definition, array $candidate): void
	{
		$proposal = $candidate['resolution']['namespace'] ?? null;

		if ($proposal === null || !$proposal['round_trip'])
		{
			throw new \LogicException('A Power requires a validated namespace and file-placement proposal.');
		}

		if ($candidate['exists'] && $proposal['preserved'])
		{
			$this->report->set('powers.namespace.kept.' . $candidate['source_key'], $proposal['value']);

			return;
		}

		$definition->namespace = $proposal['value'];

		if ($proposal['relocation'])
		{
			$this->report->set('powers.namespace.restated.' . $candidate['source_key'], [
				'from' => $candidate['standing'], 'to' => $proposal['value']
			]);
		}
	}

	/**
	 * Resolve the parent and interface relationships into identities.
	 *
	 * @param   object                $definition  The definition being built.
	 * @param   array<string, mixed>  $candidate   The harvest candidate.
	 * @param   array<string, mixed>  $imports     The resolved import table.
	 *
	 * @return  void
	 * @since   6.1.7
	 */
	protected function relations(object $definition, array $candidate, array &$imports): void
	{
		$type = (string) $candidate['type'];
		$namespace = (string) $candidate['namespace'];
		$guid = (string) $candidate['guid'];
		$extends = (array) ($candidate['extends'] ?? []);
		$implements = (array) ($candidate['implements'] ?? []);

		if ($type === 'interface')
		{
			// an interface extends interfaces, and implements nothing
			[$linked, $custom] = $this->identities($extends, $namespace, $imports);

			if ($custom !== [])
			{
				$linked[] = '-1';
				$definition->extendsinterfaces_custom = implode(', ', $custom);
				$this->report->set('powers.custom.extendsinterfaces.' . $this->key($guid), $custom);
			}

			if ($linked !== [])
			{
				$definition->extendsinterfaces = $linked;
			}

			return;
		}

		if ($type === 'trait')
		{
			return;
		}

		if ($extends !== [])
		{
			$parent = (string) $extends[0];
			$identity = $this->identity($parent, $namespace, $imports);

			if ($identity !== null)
			{
				$definition->extends = $identity;
			}
			else
			{
				$definition->extends = '-1';
				$definition->extends_custom = $this->written($parent);
				$this->report->set('powers.custom.extends.' . $this->key($guid), $parent);

				// the column holds 64 characters, and silence would corrupt
				if (strlen($definition->extends_custom) > 64)
				{
					$this->report->set('powers.overflow.extends_custom.' . $this->key($guid), $parent);
				}
			}
		}

		if ($implements === [])
		{
			return;
		}

		[$linked, $custom] = $this->identities($implements, $namespace, $imports);

		if ($custom !== [])
		{
			$linked[] = '-1';
			$definition->implements_custom = implode(', ', $custom);
			$this->report->set('powers.custom.implements.' . $this->key($guid), $custom);
		}

		if ($linked !== [])
		{
			$definition->implements = $linked;
		}
	}

	/**
	 * Turn the import table into the use selection and the head.
	 *
	 * @param   object                $definition  The definition being built.
	 * @param   string                $guid        The candidate's identity.
	 * @param   array<string, mixed>  $imports     The resolved import table.
	 *
	 * @return  void
	 * @since   6.1.7
	 */
	protected function selections(object $definition, string $guid, array $imports): void
	{
		$selection = [];
		$head = [];
		$number = 0;

		foreach ($imports as $import)
		{
			if ($import['claimed'])
			{
				// the compiler reintroduces this import from the relationship
				continue;
			}

			if ($import['guid'] !== null)
			{
				$selection['use_selection' . $number++] = [
					'use' => $import['guid'],
					'as' => $import['alias'] ?? 'default'
				];

				continue;
			}

			$head[] = $import['raw'];
			$this->report->set(
				'powers.unmatched.use.' . $this->key($guid) . '.' . md5($import['raw']),
				$import['name']
			);
		}

		if ($selection !== [])
		{
			$definition->use_selection = $selection;
		}

		if ($head !== [])
		{
			$definition->head = implode("\n", $head);
			$definition->add_head = 1;
		}
	}

	/**
	 * The system name one stored namespace derives.
	 *
	 * JCB's own powers speak this convention -- VDM.Data.Action.Load for the
	 * class stored as VDM\Joomla\Data.Action.Load -- the
	 * vendor prefix, then the dotted tail with the class, and none of the
	 * connecting head between them.
	 *
	 * @param   string  $stored  The stored form with concrete values.
	 *
	 * @return  string  The system name.
	 * @since   6.1.9
	 */
	protected function systemName(string $stored): string
	{
		$sections = explode('\\', trim($stored, '\\'));

		if (count($sections) < 2)
		{
			return str_replace('\\', '.', $stored);
		}

		return $sections[0] . '.' . end($sections);
	}

	/**
	 * Resolve every import into the identity it refers to, when it has one.
	 *
	 * @param   array<int, mixed>  $uses       The candidate's imports as read.
	 * @param   string             $namespace  The candidate's own namespace.
	 *
	 * @return  array<string, array{raw: string, name: string, alias: string|null, guid: string|null, claimed: bool}>  The import table, keyed by bound name.
	 * @since   6.1.7
	 */
	protected function imports(array $uses, string $namespace): array
	{
		$imports = [];

		foreach ($uses as $use)
		{
			$use = (array) $use;
			$name = trim((string) ($use['name'] ?? ''), '\\');

			if ($name === '')
			{
				continue;
			}

			$alias = $use['alias'] ?? null;
			$kind = (string) ($use['kind'] ?? 'class');
			$guid = null;

			if ($kind === 'class')
			{
				$guid = $this->find($name);
			}

			// class, function and const imports live in separate symbol
			// spaces, so only a class import binds under the bare name
			$bound = $alias ?? $this->short($name);

			if ($kind !== 'class')
			{
				$bound = $kind . ' ' . $bound;
			}

			$imports[$bound] = [
				'raw' => (string) ($use['raw'] ?? ''),
				'name' => $name,
				'alias' => $alias,
				'guid' => $guid,
				'claimed' => false
			];
		}

		return $imports;
	}

	/**
	 * Resolve a list of written names into identities and leftovers.
	 *
	 * @param   array<int, mixed>     $names      The names as written.
	 * @param   string                $namespace  The referencing class's namespace.
	 * @param   array<string, mixed>  $imports    The resolved import table.
	 *
	 * @return  array{0: array<string>, 1: array<string>}  The linked identities, and the unresolved names.
	 * @since   6.1.7
	 */
	protected function identities(array $names, string $namespace, array &$imports): array
	{
		$linked = [];
		$custom = [];

		foreach ($names as $name)
		{
			$identity = $this->identity((string) $name, $namespace, $imports);

			if ($identity !== null)
			{
				$linked[] = $identity;
			}
			else
			{
				$custom[] = $this->written((string) $name);
			}
		}

		return [$linked, $custom];
	}

	/**
	 * Resolve one written name into the identity it refers to.
	 *
	 * The name resolves as PHP resolves it: a leading backslash is absolute,
	 * a first segment bound by an import continues from that import, and
	 * anything else sits in the referencing class's own namespace. An import
	 * that supplied the identity is claimed, so it is never also emitted as a
	 * use selection the compiler would then duplicate.
	 *
	 * @param   string                $name       The name as written.
	 * @param   string                $namespace  The referencing class's namespace.
	 * @param   array<string, mixed>  $imports    The resolved import table.
	 *
	 * @return  string|null  The identity, or null when no power answers to the name.
	 * @since   6.1.7
	 */
	protected function identity(string $name, string $namespace, array &$imports): ?string
	{
		$name = trim($name);

		if ($name === '')
		{
			return null;
		}

		if (str_starts_with($name, '\\'))
		{
			return $this->find(ltrim($name, '\\'));
		}

		if (str_starts_with(strtolower($name), 'namespace\\'))
		{
			return $this->find($namespace . substr($name, 9));
		}

		$segments = explode('\\', $name);
		$first = $segments[0];

		if (isset($imports[$first]))
		{
			// an aliased import stays a use selection, because the class body
			// may lean on the alias -- the power still links through the
			// selection, and the declaration keeps the alias as its custom name
			if (count($segments) === 1 && $imports[$first]['alias'] !== null)
			{
				return null;
			}

			$resolved = count($segments) === 1
				? $imports[$first]['name']
				: $imports[$first]['name'] . '\\' . implode('\\', array_slice($segments, 1));
			$guid = $this->find($resolved);

			if ($guid !== null && count($segments) === 1)
			{
				$imports[$first]['claimed'] = true;
			}

			return $guid;
		}

		return $this->find($namespace . '\\' . $name);
	}

	/**
	 * The identity one fully qualified class name resolves to.
	 *
	 * @param   string  $fqn  The fully qualified class name.
	 *
	 * @return  string|null  The identity, or null when no power answers to it.
	 * @since   6.1.7
	 */
	protected function find(string $fqn): ?string
	{
		$key = strtolower(trim($fqn, '\\'));
		$scope = $this->active['source_unit'] . ':' . (string) ($this->active['source_component_id'] ?? '')
			. ':' . $this->resolver->effectiveRevision();

		if (isset($this->resolvedDependencies[$scope][$key]))
		{
			$this->dependencies[$key] = ['fqn' => $fqn] + $this->resolvedDependencies[$scope][$key];
			$this->report->set('counts.powers.dependency_reused', (int) $this->report->get('counts.powers.dependency_reused', 0) + 1);

			return $this->dependencies[$key]['guid'];
		}

		$this->report->set('counts.powers.dependency_lookups', (int) $this->report->get('counts.powers.dependency_lookups', 0) + 1);
		$local = $this->local[$key] ?? [];

		if ($local !== [])
		{
			$within = array_filter($local, fn (array $source): bool => $source['source_unit'] === $this->active['source_unit']);
			$local = $within !== [] ? $within : $local;
			$guids = [];
			$bad = false;

			foreach ($local as $source)
			{
				$result = $source['resolution'];

				if (in_array($result['status'], ['matched', 'new'], true)
					&& ($result['status'] === 'matched' || $this->writable($source)))
				{
					$guids[$result['write_guid']] = true;
				}
				else
				{
					$bad = true;
				}
			}

			$guid = !$bad && count($guids) === 1 ? (string) array_key_first($guids) : null;
			$this->dependencies[$key] = [
				'fqn' => $fqn, 'status' => $guid !== null ? 'matched' : 'ambiguous',
				'guid' => $guid, 'source_keys' => array_keys($local)
			];
			$this->resolvedDependencies[$scope][$key] = $this->dependencies[$key];

			return $guid;
		}

		$parts = explode('\\', trim($fqn, '\\'));
		$class = (string) array_pop($parts);
		$result = $this->resolver->resolve([
			'source_key' => 'reference_' . hash('sha256', $key),
			'source_unit' => $this->active['source_unit'],
			'source_component_id' => $this->active['source_component_id'] ?? null,
			'fqn' => $fqn, 'type' => '',
			'stored' => $this->namespacer->conventional(implode('\\', $parts), $class),
			'placement_valid' => true
		], null, true);
		$this->dependencies[$key] = [
			'fqn' => $fqn, 'status' => $result['status'], 'guid' => $result['matched_guid'],
			'candidates' => array_keys($result['candidates']), 'source_keys' => []
		];
		$this->resolvedDependencies[$scope][$key] = $this->dependencies[$key];

		return $result['matched_guid'];
	}

	/**
	 * The short class name of one written name.
	 *
	 * @param   string  $name  The name as written.
	 *
	 * @return  string  The final segment.
	 * @since   6.1.7
	 */
	protected function short(string $name): string
	{
		$segments = explode('\\', trim($name, '\\'));

		return (string) end($segments);
	}

	/**
	 * The custom name an unresolved reference is stored under.
	 *
	 * A qualified name stays exactly as written, because the compiler emits
	 * the custom name verbatim into the declaration -- truncating
	 * \Exception to Exception would make the built class extend a class in
	 * its own namespace instead.
	 *
	 * @param   string  $name  The name as written.
	 *
	 * @return  string  The name to store.
	 * @since   6.1.7
	 */
	protected function written(string $name): string
	{
		return trim($name);
	}

	/**
	 * Sanitise one registry path segment.
	 *
	 * @param   string  $segment  The raw segment.
	 *
	 * @return  string  A segment safe to use in a dotted registry path.
	 * @since   6.1.7
	 */
	protected function key(string $segment): string
	{
		return preg_replace('/[^A-Za-z0-9_]/', '_', $segment) ?? $segment;
	}
}

