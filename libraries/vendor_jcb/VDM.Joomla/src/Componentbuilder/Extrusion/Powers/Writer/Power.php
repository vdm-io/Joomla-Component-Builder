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

namespace VDM\Joomla\Componentbuilder\Extrusion\Powers\Writer;


use VDM\Joomla\Componentbuilder\Extrusion\Config;
use VDM\Joomla\Componentbuilder\Extrusion\Registry\Harvest;
use VDM\Joomla\Componentbuilder\Extrusion\Registry\Report;
use VDM\Joomla\Componentbuilder\Extrusion\Registry\Resolved;
use VDM\Joomla\Componentbuilder\Extrusion\Resolver\Delta;
use VDM\Joomla\Interfaces\Data\ItemInterface;
use VDM\Joomla\Componentbuilder\Extrusion\Abstraction\Writer;


/**
 * Persists every assembled power definition into JCB.
 * 
 * All the shared writing mechanics apply unchanged: the Data pipeline resolves
 * insert against update from the guid and applies the storage encoding the
 * power table declares, a dry run stops before anything is touched, and the
 * skip policy leaves an existing power exactly as it stands while the report
 * still names it -- which is the whole "mention it, do not touch it" switch.
 * 
 * @since 6.1.7
 */
final class Power extends Writer
{
	/**
	 * What a power that does not yet exist is given, and a standing one keeps.
	 *
	 * A class file cannot state what somebody called this power in their own
	 * list, which version they are at, or whether they published it. Its
	 * docblock is a different matter: the file does state that, so a
	 * description is refreshed like any other thing the file says.
	 *
	 * @var    array<string>
	 * @since  6.2.0
	 */
	private const SCAFFOLDING = [
		'system_name', 'power_version', 'published'
	];

	/**
	 * What the class file states about itself, and nothing else.
	 *
	 * Everything a class file cannot state -- how a power is linked to the
	 * others, which licence it carries, what a person wrote above it -- belongs
	 * to whoever curated the record, and is offered only into a gap.
	 *
	 * @var    array<string>
	 * @since  6.2.0
	 */
	private const STATED = [
		'guid', 'name', 'namespace', 'type', 'main_class_code'
	];

	/**
	 * The columns a person decides, which no class file can state.
	 *
	 * @var    array<string>
	 * @since  6.2.0
	 */
	private const DECIDED = ['licensing_template', 'add_licensing_template'];

	/**
	 * The setting that says a power takes the licence from the global template.
	 *
	 * @var    int
	 * @since  6.2.0
	 */
	private const LICENCE_GLOBAL = 1;

	/**
	 * The Harvest Registry.
	 *
	 * @var    Harvest
	 * @since  6.1.7
	 */
	protected Harvest $harvest;

	/**
	 * Constructor.
	 *
	 * @param   Config         $config    The extrusion configuration.
	 * @param   Resolved       $resolved  The resolved definition registry.
	 * @param   ItemInterface  $item      The JCB data item writer.
	 * @param   Report         $report    The run report registry.
	 * @param   Delta          $delta     The change weigher.
	 * @param   Harvest        $harvest   The harvest registry.
	 *
	 * @since   6.1.7
	 */
	public function __construct(
		Config $config,
		Resolved $resolved,
		ItemInterface $item,
		Report $report,
		Delta $delta,
		Harvest $harvest
	)
	{
		parent::__construct($config, $resolved, $item, $report, $delta);

		$this->harvest = $harvest;
	}

	/**
	 * The JCB table this writer persists into.
	 *
	 * @return  string  The table name without its prefix.
	 * @since   6.1.7
	 */
	protected function table(): string
	{
		return 'power';
	}

	/**
	 * Write every assembled power definition.
	 *
	 * @return  int  The number of definitions written.
	 * @since   6.1.7
	 */
	public function write(): int
	{
		$written = 0;

		foreach ((array) $this->harvest->get('resolved', []) as $sourceKey => $definition)
		{
			if (!is_object($definition))
			{
				$definition = (object) $definition;
			}

			$guid = (string) ($definition->guid ?? '');
			$candidate = $this->harvest->get('classes.' . $sourceKey);

			if (!$this->delta->staging() || !is_array($candidate)
				|| ($candidate['resolution']['write_guid'] ?? null) !== $guid
				|| !in_array($candidate['resolution']['status'] ?? '', ['matched', 'new'], true)
				|| ($candidate['resolution']['write_eligibility'] ?? 'blocked') === 'blocked')
			{
				$this->report->set('failed.power.' . $sourceKey, 'A Power write requires the complete validated operation plan.');

				continue;
			}

			$row = 'power|' . $sourceKey;

			if ((bool) $this->config->get('repairNamespaces', false))
			{
				if (($candidate['resolution']['status'] ?? '') !== 'matched'
					|| (int) $this->item->table($this->table())->value($guid, 'guid', 'id') < 1)
				{
					$this->report->set('failed.power.' . $sourceKey, 'Namespace repair requires the identified Power to still exist.');

					continue;
				}

				$definition = (object) [
					'guid' => $guid,
					'namespace' => (string) ($candidate['resolution']['namespace']['value'] ?? ''),
				];
			}
			else
			{
				$this->settle($definition, $guid);
			}

			if ($this->store($definition, self::SCAFFOLDING, null, $row))
			{
				$written++;
			}
		}

		$this->report->set('counts.power', $written);

		return $written;
	}

	/**
	 * Let a power that already stands keep what a run has nothing to say about.
	 *
	 * A class file states a great deal about its class -- the code, the
	 * docblock it carries, what it extends, what it uses -- and a re-run is
	 * right to refresh all of it. What it must never do is take something
	 * away because this run worked out less than the last one did. A run that
	 * could not resolve `extends Model` has not learnt that the class extends
	 * nothing; it has only failed to say. So an empty answer is silence, and
	 * silence never overwrites what a person has.
	 *
	 * @param   object  $definition  The definition the assembler composed.
	 * @param   string  $guid        The identity it is written under.
	 *
	 * @return  void
	 * @since   6.2.0
	 */
	protected function settle(object $definition, string $guid): void
	{
		$standing = $guid === ''
			? null
			: $this->item->table($this->table())->get($guid, 'guid');

		if (!is_object($standing))
		{
			// a power that does not exist yet is recorded as the file has it,
			// licence and all: there is no setting of anybody's to respect
			return;
		}

		$kept = [];

		// a run that could not work out what a class extends has not learnt
		// that it extends nothing -- and writing the fallback would compile
		// the parent's name with no import behind it
		foreach ([
			'extends' => 'extends_custom',
			'implements' => 'implements_custom',
			'extendsinterfaces' => 'extendsinterfaces_custom'
		] as $column => $custom)
		{
			if ($this->lowers($definition, $standing, $column))
			{
				unset($definition->{$column}, $definition->{$custom});
				$kept[] = $column;
			}
		}

		foreach (get_object_vars($definition) as $column => $value)
		{
			if (in_array($column, self::STATED, true)
				|| in_array($column, self::DECIDED, true))
			{
				continue;
			}

			if (!$this->empty($value) || $this->empty($standing->{$column} ?? null))
			{
				continue;
			}

			// the run has nothing to put here and the record does
			unset($definition->{$column});
			$kept[] = $column;
		}

		$this->licence($definition, $standing);

		if ($kept !== [])
		{
			$this->report->set('kept.power.' . $guid, array_values(array_unique($kept)));
		}
	}

	/**
	 * Whether this run would put a written-out name where a real link stands.
	 *
	 * JCB compiles a link and a written-out name differently: a link brings the
	 * parent's import with it, and a name is emitted exactly as it reads, with
	 * nothing to resolve it. So lowering one to the other does not merely lose
	 * a reference -- it leaves a class that cannot find its parent.
	 *
	 * A run may always raise the other way, from a name it has now resolved to
	 * the link it resolved it to.
	 *
	 * @param   object  $definition  The definition the assembler composed.
	 * @param   object  $standing    The record that stands.
	 * @param   string  $column      The linkage column.
	 *
	 * @return  bool  True when the record names a power and this run does not.
	 * @since   6.2.0
	 */
	protected function lowers(object $definition, object $standing, string $column): bool
	{
		if (!property_exists($definition, $column))
		{
			return false;
		}

		return $this->names($standing->{$column} ?? null)
			&& !$this->names($definition->{$column});
	}

	/**
	 * Whether a linkage value names at least one power JCB can find.
	 *
	 * @param   mixed  $value  The value.
	 *
	 * @return  bool  True when something in it is a link rather than a name.
	 * @since   6.2.0
	 */
	protected function names($value): bool
	{
		if (is_string($value))
		{
			return trim($value) !== '' && trim($value) !== '-1';
		}

		if (!is_array($value) && !is_object($value))
		{
			return false;
		}

		foreach ((array) $value as $entry)
		{
			if (is_string($entry) && trim($entry) !== '' && trim($entry) !== '-1')
			{
				return true;
			}
		}

		return false;
	}

	/**
	 * Leave a licence alone unless the person asked this power to carry its own.
	 *
	 * A power set to the global template stays on it: changing that would put a
	 * copy of the global licence on this one power and quietly take it out of
	 * the global's reach, and only the person can decide to do that. A power
	 * that carries its own licence gets whatever the file now says.
	 *
	 * @param   object  $definition  The definition the assembler composed.
	 * @param   object  $standing    The record that stands.
	 *
	 * @return  void
	 * @since   6.2.0
	 */
	protected function licence(object $definition, object $standing): void
	{
		$licence = (string) ($definition->licensing_template ?? '');

		if ((int) ($standing->add_licensing_template ?? self::LICENCE_GLOBAL) === self::LICENCE_GLOBAL)
		{
			unset($definition->licensing_template, $definition->add_licensing_template);

			if ($licence !== '')
			{
				$this->report->set(
					'kept.licence.' . (string) ($definition->guid ?? ''),
					'the power takes the global licence, so the one in the file was left where it is'
				);
			}

			return;
		}

		// the power carries its own licence, so the file's is what it says now
		unset($definition->add_licensing_template);

		if ($licence === '')
		{
			unset($definition->licensing_template);
		}
	}

	/**
	 * Whether a value says nothing at all.
	 *
	 * @param   mixed  $value  The value.
	 *
	 * @return  bool  True when it holds nothing.
	 * @since   6.2.0
	 */
	protected function empty($value): bool
	{
		if ($value === null || $value === '' || $value === [] || $value === '-1')
		{
			return true;
		}

		if (is_object($value))
		{
			return get_object_vars($value) === [];
		}

		return is_string($value) && in_array(trim($value), ['[]', '{}', '0'], true);
	}
}

