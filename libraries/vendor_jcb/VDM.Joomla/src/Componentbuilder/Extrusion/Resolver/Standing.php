<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    28th August, 2026
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Extrusion\Resolver;


use VDM\Joomla\Componentbuilder\Extrusion\Config;
use VDM\Joomla\Componentbuilder\Extrusion\Registry\Resolved;
use VDM\Joomla\Componentbuilder\Extrusion\Registry\Source;


/**
 * Answers what already stands in the paired component for one column.
 * 
 * An update run is aimed at a component that already holds records, and the
 * intelligence owed there is recognition: a standing field this very engine
 * wrote for this very column is that column's record, and a standing field
 * whose stored properties hash to exactly what this run would write is the
 * same field by the strongest proof the properties can give. Both are the
 * record to reuse -- never a reason to write another.
 * 
 * Recognition is bounded to the paired component: its own linked views and
 * the fields those views link. A name in common elsewhere stays a suggestion
 * on the board, because only a person may say a lookalike is the same thing.
 * 
 * @since 6.1.9
 */
final class Standing
{
	/**
	 * The Config Class.
	 *
	 * @var    Config
	 * @since  6.1.9
	 */
	protected Config $config;

	/**
	 * The Resolved Registry.
	 *
	 * @var    Resolved
	 * @since  6.1.9
	 */
	protected Resolved $resolved;

	/**
	 * The Source Registry.
	 *
	 * @var    Source
	 * @since  6.1.9
	 */
	protected Source $source;

	/**
	 * The Candidates Resolver.
	 *
	 * @var    Candidates
	 * @since  6.1.9
	 */
	protected Candidates $candidates;

	/**
	 * The Record Resolver.
	 *
	 * @var    Record
	 * @since  6.1.9
	 */
	protected Record $record;

	/**
	 * The Guid Resolver.
	 *
	 * @var    Guid
	 * @since  6.1.9
	 */
	protected Guid $guid;

	/**
	 * The standing fields of the paired component, lean rows.
	 *
	 * @var    array<int, array<string, mixed>>
	 * @since  6.1.9
	 */
	protected array $fields = [];

	/**
	 * The standing admin views of the paired component.
	 *
	 * @var    array<int, array<string, mixed>>
	 * @since  6.1.9
	 */
	protected array $views = [];

	/**
	 * The full rows of the standing fields read so far, keyed by guid.
	 *
	 * @var    array<string, array<string, mixed>|null>
	 * @since  6.1.9
	 */
	protected array $loaded = [];

	/**
	 * Constructor.
	 *
	 * @param   Config      $config      The extrusion configuration.
	 * @param   Resolved    $resolved    The resolved definition registry.
	 * @param   Source      $source      The source identity registry.
	 * @param   Candidates  $candidates  The candidates resolver.
	 * @param   Record      $record      The record resolver.
	 * @param   Guid        $guid        The identity resolver.
	 *
	 * @since   6.1.9
	 */
	public function __construct(
		Config $config,
		Resolved $resolved,
		Source $source,
		Candidates $candidates,
		Record $record,
		Guid $guid
	)
	{
		$this->config = $config;
		$this->resolved = $resolved;
		$this->source = $source;
		$this->candidates = $candidates;
		$this->record = $record;
		$this->guid = $guid;
	}

	/**
	 * Aim at the run's paired component, loading what it already holds.
	 *
	 * This is called at the start of every settle, so the sets can never
	 * carry over from an earlier run or an earlier component.
	 *
	 * @return  bool  True when a component is paired and its records loaded.
	 * @since   6.1.9
	 */
	public function aim(): bool
	{
		$this->fields = [];
		$this->views = [];
		$component = (int) $this->config->get('component', 0);

		if ($component <= 0)
		{
			return false;
		}

		$catalogue = $this->candidates->catalogue($component, '', false);
		$this->fields = (array) ($catalogue['fields'] ?? []);
		$this->views = (array) ($catalogue['admin_views'] ?? []);

		return true;
	}

	/**
	 * What already stands for one resolved column of one view.
	 *
	 * Three recognitions are identity and come back as stood, in order of
	 * proof: the record standing under this column's own derived identity;
	 * the record standing under the fresh identity a create verdict once
	 * salted for it; and the record the paired view links under this name
	 * whose stored properties hash to exactly what this run would write. A
	 * name in common whose hash differs is not identity -- it comes back as
	 * similar, for the report to name and a person to decide.
	 *
	 * @param   string                $view        The raw view name.
	 * @param   string                $column      The raw column name.
	 * @param   string                $derived     The column's derived identity.
	 * @param   array<string>         $names       The column's names, best first.
	 * @param   array<string, mixed>  $properties  The resolved properties.
	 *
	 * @return  array{stood: array<string>, similar: string|null}  The recognitions.
	 * @since   6.1.9
	 */
	public function member(
		string $view,
		string $column,
		string $derived,
		array $names,
		array $properties
	): array
	{
		$stood = [];
		$derived = strtolower(trim($derived));

		if ($this->fields === [] || $derived === '')
		{
			return ['stood' => $stood, 'similar' => null];
		}

		if ($this->held($derived))
		{
			$stood[] = $derived;
		}

		$forced = $this->guid->derive(['field', 'forced-new', $derived]);

		if ($this->held($forced))
		{
			$stood[] = $forced;
		}

		[$scoped, $similar] = $this->scoped($view, $column, $names, $properties);

		if ($scoped !== null && !in_array($scoped, $stood, true))
		{
			$stood[] = $scoped;
		}

		return ['stood' => $stood, 'similar' => $similar];
	}

	/**
	 * Whether one identity stands in the paired component's field pool.
	 *
	 * @param   string  $guid  The identity to look for.
	 *
	 * @return  bool  True when a standing field carries it.
	 * @since   6.1.9
	 */
	protected function held(string $guid): bool
	{
		foreach ($this->fields as $row)
		{
			if (strtolower(trim((string) (((array) $row)['guid'] ?? ''))) === $guid)
			{
				return true;
			}
		}

		return false;
	}

	/**
	 * The field the paired view links under this name, hash-verified.
	 *
	 * @param   string                $view        The raw view name.
	 * @param   string                $column      The raw column name.
	 * @param   array<string>         $names       The column's names, best first.
	 * @param   array<string, mixed>  $properties  The resolved properties.
	 *
	 * @return  array{0: string|null, 1: string|null}  The proven identity, and the unproven lookalike.
	 * @since   6.1.9
	 */
	protected function scoped(
		string $view,
		string $column,
		array $names,
		array $properties
	): array
	{
		$viewGuid = $this->viewGuid($view);

		if ($viewGuid === null)
		{
			return [null, null];
		}

		$wanted = array_values(array_filter(array_map(
			static fn ($name): string => strtolower(trim((string) $name)),
			$names
		), 'strlen'));
		$hash = null;
		$similar = null;

		$wired = strtolower(trim($column));

		foreach ($this->fields as $row)
		{
			$row = (array) $row;
			$homes = array_map(
				'strval',
				(array) ($row['views'] ?? [$row['view'] ?? ''])
			);

			if (!in_array($viewGuid, $homes, true))
			{
				continue;
			}

			$found = strtolower(trim((string) ($row['guid'] ?? '')));

			if ($found === '')
			{
				continue;
			}

			// the paired view's own wiring is the strongest statement there is:
			// the field the person linked into this very view whose XML names
			// this very column IS the column's field, whatever else about it
			// they have since changed -- its record name, its properties. A
			// hash cannot outrank the person's own wiring, it can only find
			// duplicates elsewhere
			$standing = $this->loaded($found);

			if ($standing !== null && $wired !== '' && $this->xmlName($standing) === $wired)
			{
				return [$found, null];
			}

			if (!in_array(strtolower(trim((string) ($row['name'] ?? ''))), $wanted, true))
			{
				continue;
			}

			// a lookalike by record name is identity only when its stored
			// properties hash to exactly what this run would write
			$hash ??= $this->record->hash($column, $properties);
			$proof = $standing === null ? null : $this->record->standing($standing);

			if ($hash !== null && $proof !== null && $hash === $proof)
			{
				return [$found, null];
			}

			$similar ??= $found;
		}

		return [null, $similar];
	}

	/**
	 * One standing field's full row, read once.
	 *
	 * @param   string  $guid  The field identity.
	 *
	 * @return  array<string, mixed>|null  The row, or null when none stands.
	 * @since   6.1.9
	 */
	protected function loaded(string $guid): ?array
	{
		if (!array_key_exists($guid, $this->loaded))
		{
			$this->loaded[$guid] = $this->candidates->field($guid);
		}

		return $this->loaded[$guid];
	}

	/**
	 * The column one standing field's XML names.
	 *
	 * @param   array<string, mixed>  $standing  The field row.
	 *
	 * @return  string  The lower-cased name attribute, or an empty string.
	 * @since   6.1.9
	 */
	protected function xmlName(array $standing): string
	{
		$xml = $standing['xml'] ?? '';
		$decoded = is_string($xml) ? json_decode($xml, true) : null;
		$xml = is_string($decoded) ? $decoded : (string) $xml;

		if (preg_match('/\bname="([^"]*)"/', $xml, $match) !== 1)
		{
			return '';
		}

		return strtolower(trim($match[1]));
	}

	/**
	 * The standing identity of one resolved view inside the paired component.
	 *
	 * @param   string  $view  The raw view name.
	 *
	 * @return  string|null  The standing admin view guid, or null when none answers.
	 * @since   6.1.9
	 */
	protected function viewGuid(string $view): ?string
	{
		$path = 'view.' . $this->key($view);
		$single = (string) $this->resolved->get($path . '.name_single', $view);
		$code = (string) $this->resolved->get($path . '.name_single_code', $view);
		$system = (string) $this->resolved->get($path . '.system_name', $single);
		$derived = strtolower(trim((string) $this->resolved->get(
			$path . '.guid',
			$this->guid->derive([$this->option(), 'admin_view', $code])
		)));
		$names = array_values(array_filter([
			strtolower(trim($single)),
			strtolower(trim($code)),
			strtolower(trim($system))
		], 'strlen'));

		foreach ($this->views as $row)
		{
			$row = (array) $row;
			$guid = strtolower(trim((string) ($row['guid'] ?? '')));

			if ($guid === '')
			{
				continue;
			}

			if ($guid === $derived)
			{
				return $guid;
			}

			foreach (['name', 'system'] as $field)
			{
				$value = strtolower(trim((string) ($row[$field] ?? '')));

				if ($value !== '' && in_array($value, $names, true))
				{
					return $guid;
				}
			}
		}

		return null;
	}

	/**
	 * The component option, when it is known.
	 *
	 * @return  string  The com_ prefixed option, or an empty string.
	 * @since   6.1.9
	 */
	protected function option(): string
	{
		return (string) $this->source->get('code_name', '');
	}

	/**
	 * Sanitise one registry path segment.
	 *
	 * @param   string  $segment  The raw segment.
	 *
	 * @return  string  A segment safe to use in a dotted registry path.
	 * @since   6.1.9
	 */
	protected function key(string $segment): string
	{
		return preg_replace('/[^A-Za-z0-9_]/', '_', $segment) ?? $segment;
	}
}

