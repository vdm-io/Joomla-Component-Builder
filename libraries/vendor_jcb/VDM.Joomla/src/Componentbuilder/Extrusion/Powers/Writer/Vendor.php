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

namespace VDM\Joomla\Componentbuilder\Extrusion\Powers\Writer;


use VDM\Joomla\Componentbuilder\Extrusion\Config;
use VDM\Joomla\Componentbuilder\Extrusion\Powers\Resolver\Identity;
use VDM\Joomla\Componentbuilder\Extrusion\Powers\Resolver\Namespacer;
use VDM\Joomla\Componentbuilder\Extrusion\Powers\Resolver\Placeholders;
use VDM\Joomla\Componentbuilder\Extrusion\Registry\Harvest;
use VDM\Joomla\Componentbuilder\Extrusion\Registry\Plan;
use VDM\Joomla\Componentbuilder\Extrusion\Registry\Report;
use VDM\Joomla\Componentbuilder\Extrusion\Resolver\Delta;
use VDM\Joomla\Interfaces\Database\LoadInterface;
use VDM\Joomla\Interfaces\Data\ItemInterface;


/**
 * Propose component-local namespace values from validated, approved source roles.
 * 
 * A word match or an informal witness never grants a configuration write.
 * Shared, skipped, ignored and unresolved definitions do not supply ownership
 * evidence, conflicting values do not vote, and no global placeholder is written.
 * 
 * @since  6.1.9
 */
final class Vendor
{
	/**
	 * The active operation configuration.
	 *
	 * @var    Config
	 * @since  6.2.0
	 */
	protected Config $config;

	/**
	 * The read-only raw database boundary.
	 *
	 * @var    LoadInterface
	 * @since  6.2.0
	 */
	protected LoadInterface $load;

	/**
	 * The existing Data value reader.
	 *
	 * @var    ItemInterface
	 * @since  6.2.0
	 */
	protected ItemInterface $item;

	/**
	 * Compiler-compatible placeholder values.
	 *
	 * @var    Placeholders
	 * @since  6.2.0
	 */
	protected Placeholders $placeholders;

	/**
	 * The operation diagnostics.
	 *
	 * @var    Report
	 * @since  6.2.0
	 */
	protected Report $report;

	/**
	 * Validated source-to-target decisions.
	 *
	 * @var    Harvest
	 * @since  6.2.0
	 */
	protected Harvest $harvest;

	/**
	 * The complete operation write plan.
	 *
	 * @var    Plan
	 * @since  6.2.0
	 */
	protected Plan $plan;

	/**
	 * The common effective change weigher.
	 *
	 * @var    Delta
	 * @since  6.2.0
	 */
	protected Delta $delta;

	/**
	 * Source role and namespace validation.
	 *
	 * @var    Namespacer
	 * @since  6.2.0
	 */
	protected Namespacer $names;

	/**
	 * The source context resolver.
	 *
	 * @var    Identity
	 * @since  6.2.0
	 */
	protected Identity $identity;

	/**
	 * Constructor.
	 *
	 * @param   Config  $config  The active operation configuration.
	 * @param   LoadInterface  $load  The read-only raw database boundary.
	 * @param   ItemInterface  $item  The existing Data value reader.
	 * @param   Placeholders  $placeholders  Compiler-compatible placeholder values.
	 * @param   Report  $report  The operation diagnostics.
	 * @param   Harvest  $harvest  Validated source-to-target decisions.
	 * @param   Plan  $plan  The complete operation write plan.
	 * @param   Delta  $delta  The common effective change weigher.
	 * @param   Namespacer  $names  Source role and namespace validation.
	 * @param   Identity  $identity  The source context resolver.
	 *
	 * @since   6.2.0
	 */
	public function __construct(Config $config, LoadInterface $load, ItemInterface $item, Placeholders $placeholders, Report $report, Harvest $harvest, Plan $plan, Delta $delta, Namespacer $names, Identity $identity)
	{
		$this->config = $config;
		$this->load = $load;
		$this->item = $item;
		$this->placeholders = $placeholders;
		$this->report = $report;
		$this->harvest = $harvest;
		$this->plan = $plan;
		$this->delta = $delta;
		$this->names = $names;
		$this->identity = $identity;
	}

	/**
	 * Stage only component-local values justified by changed approved definitions.
	 *
	 * @return  int  Number of effective auxiliary record proposals.
	 * @since   6.1.9
	 */
	public function write(): int
	{
		if (!$this->plan->active() || (bool) $this->config->get('repairNamespaces', false))
		{
			return 0;
		}

		$pairs = [];

		foreach ($this->plan->writes() as $write)
		{
			if ($write['table'] !== 'power')
			{
				continue;
			}

			foreach (array_keys($write['origins']) as $origin)
			{
				$key = str_starts_with($origin, 'power|') ? substr($origin, 6) : '';
				$source = $this->harvest->get('classes.' . $key);
				$result = $source['resolution'] ?? [];
				// Selected-root evidence proves which namespace roles this
				// component uses, without proving exclusive global ownership.
				// The unknown-scope acknowledgement still protects the complete
				// changed plan, including these component-local proposals.
				$selected = ($result['status'] ?? '') === 'matched'
					&& ($result['write_scope'] ?? '') === 'unestablished'
					&& !empty($result['candidates'][$result['matched_guid']]['in_target']);

				if (!in_array($result['status'] ?? '', ['matched', 'new'], true)
					|| (!$selected && !in_array($result['write_scope'] ?? '', ['component', 'new'], true))
					|| in_array($source['action'] ?? '', ['ignored', 'filtered', 'skip'], true)
					|| !empty($result['remapping']) || empty($result['namespace']['round_trip']))
				{
					continue;
				}

				$pair = $this->names->variables($source, $result['namespace']['value'], $this->identity->sourceContext($source));

				if ($pair !== null && ($result['status'] === 'matched' || isset($source['binding'])))
				{
					$pairs[Plan::digest($pair)] = $pair;
				}
			}
		}

		$projected = $this->names->context();
		$count = 0;

		if (count($pairs) > 1)
		{
			$this->plan->block('namespace.values', 'Approved component-variable bindings disagree about their source values. No namespace configuration can be selected by a vote.');
		}
		elseif (count($pairs) === 1)
		{
			$pair = reset($pairs);
			$id = (int) $this->config->get('component', 0);
			$row = $id > 0 ? $this->load->item(['all' => 'a.*'], ['a' => 'joomla_component'], ['a.id' => $id]) : null;

			if ($row === null && $id === 0)
			{
				foreach ($this->plan->writes() as $write)
				{
					if ($write['table'] === 'joomla_component' && $write['action'] === 'create')
					{
						$row = (object) $write['payload'];
						break;
					}
				}
			}

			if ($row !== null && !empty($row->guid))
			{
				$count += $this->prefix($row, $pair['prefix'], $projected);
				$count += $this->override($row, $pair['component'], $projected);
			}
			else
			{
				$this->report->set('powers.vendor.unplaced', 'No selected or newly staged component exists; no global namespace value was written.');
			}
		}

		$this->project($projected);

		return $count;
	}

	/**
	 * Propose a vendor prefix only where the component has not explicitly set one.
	 *
	 * @param   object  $row      The selected or newly staged component row.
	 * @param   string  $prefix   The validated source prefix value.
	 * @param   array   $context  The projected target context for this plan.
	 *
	 * @return  int  One for a changed auxiliary proposal.
	 * @since   6.2.0
	 */
	protected function prefix(object $row, string $prefix, array &$context): int
	{
		if ($prefix === '' || ((int) ($row->add_namespace_prefix ?? 0) === 1 && trim((string) ($row->namespace_prefix ?? '')) !== ''))
		{
			return 0;
		}

		$definition = (object) ['guid' => $row->guid, 'add_namespace_prefix' => 1, 'namespace_prefix' => $prefix];
		$exists = (int) $this->item->table('joomla_component')->value($row->guid, 'guid', 'id') > 0;
		$delta = $this->delta->weigh('joomla_component', 'guid', $row->guid, $definition, $exists, 'namespace|' . $row->guid);
		$context['map'][Placeholders::PREFIX] = $prefix;
		// Keep this runtime map key out of the compiler's host placeholder pass.
		$context['map']['###' . 'NamespacePrefix' . '###'] = $prefix;

		return $delta['changed'] ? 1 : 0;
	}

	/**
	 * Preserve explicit component overrides; stage only a missing required value.
	 *
	 * @param   object  $row        The selected or newly staged component.
	 * @param   string  $component  The validated source component segment.
	 * @param   array   $context    The projected target context.
	 *
	 * @return  int  One for a changed auxiliary proposal.
	 * @since   6.2.0
	 */
	protected function override(object $row, string $component, array &$context): int
	{
		if ($component === '' || ($context['map'][Placeholders::COMPONENT] ?? '') === $component)
		{
			return 0;
		}

		$stored = $this->load->value(['a.addplaceholders' => 'addplaceholders'],
			['a' => 'component_placeholders'], ['a.joomla_component' => $row->guid]);
		$rows = $stored === null || $stored === '' ? [] : (is_string($stored) ? json_decode($stored, true) : null);

		if (!is_array($rows))
		{
			$this->plan->block('namespace.overrides', 'Existing component placeholder data is malformed and cannot be safely extended.');

			return 0;
		}

		foreach ($rows as $entry)
		{
			if ($this->placeholders->target((string) ($entry['target'] ?? '')) === 'ComponentNamespace')
			{
				return 0;
			}
		}

		$number = 0;

		while (isset($rows['addplaceholders' . $number]))
		{
			$number++;
		}

		$rows['addplaceholders' . $number] = ['target' => Placeholders::COMPONENT, 'value' => $component];
		$exists = (int) $this->item->table('component_placeholders')->value($row->guid, 'joomla_component', 'id') > 0;
		$definition = (object) ['joomla_component' => $row->guid, 'addplaceholders' => $rows];

		if (!$exists)
		{
			$definition->published = 1;
		}

		$delta = $this->delta->weigh('component_placeholders', 'joomla_component', $row->guid, $definition, $exists, 'namespace|' . $row->guid);
		$context['map'][Placeholders::COMPONENT] = $component;
		// Keep this runtime map key out of the compiler's host placeholder pass.
		$context['map']['###' . 'ComponentNamespace' . '###'] = $component;

		return $delta['changed'] ? 1 : 0;
	}

	/**
	 * Expose final projected outputs, including the auxiliary values in this plan.
	 *
	 * @param   array  $context  The private projected target placeholder map.
	 *
	 * @return  void
	 * @since   6.2.0
	 */
	protected function project(array $context): void
	{
		$outputs = [];

		foreach ((array) $this->harvest->get('classes', []) as $key => $source)
		{
			$result = $source['resolution'];

			if (!in_array($result['status'], ['matched', 'new'], true) || in_array($source['action'], ['ignored', 'filtered'], true))
			{
				continue;
			}

			$fqn = $this->names->resolve($result['namespace']['value'], $context);
			$result['namespace']['target_fqn'] = $fqn;
			$result['remapping'] = !empty($result['remapping']) || $fqn !== $result['namespace']['source_fqn'];
			$index = strtolower($fqn);

			if ($fqn === '')
			{
				$this->plan->block('namespace.target.' . $key, 'The projected target namespace has unresolved placeholders.');
			}
			elseif (isset($outputs[$index]) && $outputs[$index]['guid'] !== $result['write_guid'])
			{
				$this->plan->block('namespace.output.' . $key, 'Distinct approved definitions produce one class in the projected target context.');
			}

			$outputs[$index] = ['key' => $key, 'guid' => $result['write_guid']];
			$source['resolution'] = $result;
			$this->harvest->set('classes.' . $key, $source);
		}
	}
}

