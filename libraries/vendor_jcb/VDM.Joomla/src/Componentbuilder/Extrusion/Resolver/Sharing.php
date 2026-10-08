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


use VDM\Joomla\Componentbuilder\Extrusion\Registry\Report;
use VDM\Joomla\Componentbuilder\Extrusion\Registry\Resolved;
use VDM\Joomla\Componentbuilder\Extrusion\Registry\Source;


/**
 * One field per stated identity, linked into every view that states it.
 * 
 * JCB holds a field once and every view that needs it links it by guid. A
 * component whose ten views each state the same name field therefore owes one
 * field record and ten links -- not ten records. What makes two columns the
 * same field is decided here, before anything is written, so the harvest a
 * person approves already shows one field and the views it serves.
 * 
 * Identity is settled in the order the rule runs:
 * 
 * - A stated Global Unique ID outranks everything. The same guid is the same
 *   field always, and two columns stating it are one field whatever else they
 *   say.
 * - Otherwise the sources' own statements decide: the code name, the label,
 *   the field type, the database shape, and every stated XML property must
 *   match exactly. Required true and required false are two different fields.
 *   Nothing is judged more or less important -- a statement is a statement.
 * 
 * A settled group then takes ONE written identity, chosen in rank:
 * 
 * - A person's verdict on the group, from the pairing board, outranks all.
 * - When a component is paired, what already stands in it is recognised: a
 *   record standing under a member's own derived identity, under the fresh
 *   identity a create verdict once salted, or under the paired view's own
 *   link whose stored properties hash to exactly what this run would write,
 *   IS this field already written -- so it is reused, never written beside.
 * - Otherwise the first view in table order owns a fresh record.
 * 
 * The owner's write is steered onto that identity through the same decision
 * registry a person's verdict lands in, and every later view carries a share
 * note the writer turns into a link. A person's verdict on any single column
 * still outranks its own note, so one view can be detached without touching
 * the rest. Standing records a member once answered to, now speaking for the
 * settled identity, are recorded as superseded: their links are consolidated
 * onto the one field and the newly unlinked records are named in the report,
 * never deleted.
 * 
 * Nothing here looks outside the component being extruded and the component
 * it is paired against. A resemblance elsewhere in the system stays a
 * suggestion on the board, never an identity this run acts on by itself.
 * 
 * @since 6.1.9
 */
final class Sharing
{
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
	 * The Pairing Resolver.
	 *
	 * @var    Pairing
	 * @since  6.1.9
	 */
	protected Pairing $pairing;

	/**
	 * The Guid Resolver.
	 *
	 * @var    Guid
	 * @since  6.1.9
	 */
	protected Guid $guid;

	/**
	 * The Field Xml Resolver.
	 *
	 * @var    FieldXml
	 * @since  6.1.9
	 */
	protected FieldXml $fieldxml;

	/**
	 * The Standing Resolver.
	 *
	 * @var    Standing
	 * @since  6.1.9
	 */
	protected Standing $standing;

	/**
	 * The Report Registry.
	 *
	 * @var    Report
	 * @since  6.1.9
	 */
	protected Report $report;

	/**
	 * Constructor.
	 *
	 * @param   Resolved  $resolved  The resolved definition registry.
	 * @param   Source    $source    The source identity registry.
	 * @param   Pairing   $pairing   The pairing resolver.
	 * @param   Guid      $guid      The identity resolver.
	 * @param   FieldXml  $fieldxml  The field xml resolver.
	 * @param   Standing  $standing  The standing recognition resolver.
	 * @param   Report    $report    The run report registry.
	 *
	 * @since   6.1.9
	 */
	public function __construct(
		Resolved $resolved,
		Source $source,
		Pairing $pairing,
		Guid $guid,
		FieldXml $fieldxml,
		Standing $standing,
		Report $report
	)
	{
		$this->resolved = $resolved;
		$this->source = $source;
		$this->pairing = $pairing;
		$this->guid = $guid;
		$this->fieldxml = $fieldxml;
		$this->standing = $standing;
		$this->report = $report;
	}

	/**
	 * Settle which columns share one field, across the whole component.
	 *
	 * @return  int  The number of columns that link a field another view owns.
	 * @since   6.1.9
	 */
	public function settle(): int
	{
		$members = $this->members();

		if ($members === [])
		{
			return 0;
		}

		$groups = $this->group($members);
		$aimed = $this->standing->aim();
		$shared = 0;
		$consolidated = 0;

		foreach ($groups as $group)
		{
			// a column only one view states still has to meet the paired
			// component: the field its view already wires under that name is
			// this field, standing, and a fresh one beside it is a duplicate.
			// A group other verdicts shrank to one member likewise carries the
			// person's group verdict, which must be honored, not dropped
			if (count($group['members']) < 2
				&& !$aimed
				&& $this->pairing->verdict(
					'field_group',
					$group['members'][0]['view'] . '.' . $group['members'][0]['column']
				) === null)
			{
				continue;
			}

			$shared += $this->one($group, $aimed, $consolidated);
		}

		if ($shared > 0)
		{
			$this->report->set('counts.fields_shared', $shared);
		}

		if ($consolidated > 0)
		{
			$this->report->set('counts.fields_consolidated', $consolidated);
		}

		return $shared;
	}

	/**
	 * Settle one group onto one written identity.
	 *
	 * @param   array<string, mixed>  $group         The group in table order.
	 * @param   bool                  $aimed         Whether a paired component stands to recognise.
	 * @param   int                   $consolidated  Running count of consolidated standing records.
	 *
	 * @return  int  How many members share the owner's record.
	 * @since   6.1.9
	 */
	protected function one(array $group, bool $aimed, int &$consolidated): int
	{
		$owner = $group['members'][0];
		$ownerKey = $owner['view'] . '.' . $owner['column'];
		$verdict = $this->pairing->verdict('field_group', $ownerKey);
		$action = (string) ($verdict['action'] ?? '');

		if ($action === 'ignore')
		{
			// the person set the whole group aside, so no member may write
			foreach ($group['members'] as $member)
			{
				$this->pairing->decide(
					'field',
					$member['view'] . '.' . $member['column'],
					'ignore'
				);
			}

			$this->report->set(
				'skipped.field_group.' . $ownerKey,
				'set aside by the pairing board'
			);

			return 0;
		}

		$by = (string) $group['by'];
		$target = strtolower(trim((string) $group['guid']));
		$found = $aimed ? $this->recognitions($group) : [];

		if ($action === 'update' && trim((string) ($verdict['target'] ?? '')) !== '')
		{
			// the person pointed the whole group at one field, theirs to name
			$target = strtolower(trim((string) $verdict['target']));
			$by = 'choice';
		}
		elseif ($action === 'create')
		{
			// the person asked for a fresh shared field, salted off the owner
			$target = $this->guid->derive(['field', 'forced-new', $owner['derived']]);
			$by = 'choice';
		}
		elseif ($group['by'] === 'xml')
		{
			// a record already standing for any member is this field already
			// written, and the first recognition in table order is reused
			foreach ($found as $recognition)
			{
				if ($recognition['stood'] !== [])
				{
					$target = $recognition['stood'][0];
					$by = 'standing';

					$this->report->set('adopted.field.' . $ownerKey, $target);

					break;
				}
			}
		}

		// the writers write exactly the settled identity, so the owner is
		// steered through the same registry a person's verdict lands in --
		// which also stops any later default from pointing it elsewhere
		if ($action === 'create')
		{
			$this->pairing->decide('field', $ownerKey, 'create');
		}
		else
		{
			$this->pairing->decide('field', $ownerKey, 'update', $target);
		}

		// what the registry answers IS what the owner will write -- when the
		// steer was refused (a verdict already stood, or the target could not
		// be spoken for), the notes must follow the registry, never the plan
		$settled = $this->pairing->guid('field', $ownerKey, $owner['derived']);

		if ($settled === null)
		{
			// the registry holds an ignore for the owner: nobody writes this
			// field, so no member may be left linking it
			foreach (array_slice($group['members'], 1) as $member)
			{
				$this->pairing->decide(
					'field',
					$member['view'] . '.' . $member['column'],
					'ignore'
				);
			}

			return 0;
		}

		if ($settled !== $target)
		{
			$target = $settled;
			$by = 'choice';
		}

		$shared = 0;

		foreach ($group['members'] as $index => $member)
		{
			$memberKey = $member['view'] . '.' . $member['column'];

			// standing records this column once answered to now speak for the
			// settled identity: their links consolidate onto the one field,
			// and the newly unlinked records are named, never deleted
			foreach (($found[$index]['stood'] ?? []) as $stood)
			{
				if ($stood === $target)
				{
					continue;
				}

				$this->resolved->set(
					'view.' . $member['view'] . '.superseded.' . $stood,
					$target
				);
				$this->report->set(
					'consolidated.field.' . $memberKey . '.' . $stood,
					$target
				);
				$consolidated++;
			}

			$similar = $found[$index]['similar'] ?? null;

			if ($similar !== null && $similar !== $target)
			{
				// a lookalike whose stored properties differ is not this field:
				// its link stands untouched, and the resemblance is named for
				// a person to decide on the board
				$this->report->set('kept.similar.field.' . $memberKey, $similar);
			}

			if ($index === 0)
			{
				continue;
			}

			$this->resolved->set(
				'view.' . $member['view'] . '.field.' . $member['column'] . '.share',
				[
					'guid' => $target,
					'owner' => $ownerKey,
					'by' => $by
				]
			);
			$this->report->set(
				'shared.field.' . $member['view'] . '.' . $member['column'],
				$ownerKey . ' (' . $by . ')'
			);
			$shared++;
		}

		return $shared;
	}

	/**
	 * What already stands in the paired component, member for member.
	 *
	 * @param   array<string, mixed>  $group  The group in table order.
	 *
	 * @return  array<int, array{stood: array<string>, similar: string|null}>  The recognitions by member index.
	 * @since   6.1.9
	 */
	protected function recognitions(array $group): array
	{
		$found = [];

		foreach ($group['members'] as $index => $member)
		{
			$found[$index] = $this->standing->member(
				$member['source'],
				$member['name'],
				$member['derived'],
				[$member['label'], $member['name']],
				$member['properties']
			);
		}

		return $found;
	}

	/**
	 * Every resolved column that may take part in sharing, in table order.
	 *
	 * A column a person has already decided by verdict stands outside the
	 * grouping entirely: pointed at another field it is that field's, and
	 * ignored it is nobody's -- either way no share note may speak for it.
	 * Only a person's verdicts exist when this runs -- the engine's own
	 * defaults are recorded later, by the reuse step, and never detach a
	 * member from its group.
	 *
	 * @return  array<int, array<string, mixed>>  The members.
	 * @since   6.1.9
	 */
	protected function members(): array
	{
		$members = [];

		foreach ((array) $this->resolved->get('views', []) as $view)
		{
			if (!is_string($view) || $view === '')
			{
				continue;
			}

			$key = $this->key($view);
			$fields = (array) $this->resolved->get('view.' . $key . '.field', []);

			foreach ($fields as $name => $properties)
			{
				$properties = (array) $properties;
				$column = (string) ($properties['name']['value'] ?? $name);

				if ($column === '')
				{
					continue;
				}

				// a stated guid that is not a guid states nothing: carrying it
				// as an identity would group columns onto a string no writer
				// can write, and link every member to a record that never is
				$stated = strtolower(trim(
					(string) ($properties['guid']['value'] ?? '')
				));
				$stated = $this->guid->valid($stated) ? $stated : '';

				// the seed is the writer's own, term for term, so the identity
				// settled here is the identity the writer would derive alone
				$derived = $this->guid->prefer(
					$stated === '' ? null : $stated,
					[$this->option(), 'field', $view, $column]
				);

				if ($this->pairing->verdict(
					'field',
					$this->key($view) . '.' . $this->key($column)
				) !== null)
				{
					// a person spoke for this column -- pointed it at another
					// field, set it aside, forced it fresh, or confirmed its
					// own identity -- and a spoken-for column stands alone,
					// whatever the verdict says
					continue;
				}

				$members[] = [
					'view' => $key,
					'column' => $this->key($column),
					'source' => $view,
					'name' => $column,
					'label' => (string) ($properties['label']['value'] ?? $column),
					'properties' => $properties,
					'stated' => $stated,
					'identity' => $this->identity($column, $properties),
					'derived' => $derived
				];
			}
		}

		return $members;
	}

	/**
	 * Group the members into the fields they jointly state.
	 *
	 * The stated guid claims first: every column stating one guid is one
	 * group, whatever else it says. The rest group by their full stated
	 * identity -- and a statement group one guid-stating column also belongs
	 * to is that guid's group, because a matching statement is the rule's own
	 * proof that the guid speaks for all of them.
	 *
	 * @param   array<int, array<string, mixed>>  $members  The members in table order.
	 *
	 * @return  array<int, array{guid: string, by: string, members: array}>  The groups, each in table order.
	 * @since   6.1.9
	 */
	protected function group(array $members): array
	{
		$byGuid = [];
		$byIdentity = [];

		foreach ($members as $member)
		{
			if ($member['stated'] !== '')
			{
				$byGuid[$member['stated']][] = $member;

				continue;
			}

			$byIdentity[$member['identity']][] = $member;
		}

		$groups = [];

		foreach ($byGuid as $stated => $grouped)
		{
			// a column stating no guid but stating the same everything else
			// belongs with the columns that do state it -- whichever of the
			// guid-stating members its statement matches
			foreach (array_column($grouped, 'identity') as $identity)
			{
				if (isset($byIdentity[$identity]))
				{
					$grouped = $this->merge($grouped, $byIdentity[$identity]);
					unset($byIdentity[$identity]);
				}
			}

			$groups[] = [
				'guid' => $stated,
				'by' => 'guid',
				'members' => $grouped
			];
		}

		foreach ($byIdentity as $grouped)
		{
			$groups[] = [
				'guid' => $grouped[0]['derived'],
				'by' => 'xml',
				'members' => $grouped
			];
		}

		return $groups;
	}

	/**
	 * Merge two member lists back into table order.
	 *
	 * @param   array  $left   Members in table order.
	 * @param   array  $right  Members in table order.
	 *
	 * @return  array  One list, in table order.
	 * @since   6.1.9
	 */
	protected function merge(array $left, array $right): array
	{
		$merged = array_merge($left, $right);

		usort(
			$merged,
			static fn (array $one, array $two): int =>
				[$one['view'], $one['column']] <=> [$two['view'], $two['column']]
		);

		return $merged;
	}

	/**
	 * The whole stated identity of one column, as one canonical string.
	 *
	 * The XML statement carries the code name, the label, the type and every
	 * stated property; the database shape carries what the column is in the
	 * table. Together they are everything the source said, and everything the
	 * source said has to match for two columns to be one field.
	 *
	 * @param   string                $column      The source column name.
	 * @param   array<string, mixed>  $properties  The resolved properties.
	 *
	 * @return  string  The canonical identity.
	 * @since   6.1.9
	 */
	protected function identity(string $column, array $properties): string
	{
		$shape = [];

		foreach (['datatype', 'size', 'db_default', 'null', 'key', 'store'] as $property)
		{
			$value = $properties[$property]['value'] ?? null;
			$shape[] = $property . '=' . (is_scalar($value) ? (string) $value : '');
		}

		return $this->fieldxml->essence($column, $properties)
			. ' :: ' . implode(' ', $shape);
	}

	/**
	 * The component's code name, which seeds every derived identity.
	 *
	 * @return  string  The code name.
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

