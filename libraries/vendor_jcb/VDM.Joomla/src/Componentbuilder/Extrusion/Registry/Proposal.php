<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    3rd September, 2026
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Extrusion\Registry;


use VDM\Joomla\Interfaces\Registryinterface;
use VDM\Joomla\Abstraction\Registry;


/**
 * What a run would write, weighed against what already stands.
 * 
 * Every record that reaches the write boundary is proposed here first, changed
 * or not, and each proposal carries the row of the pairing board it belongs to.
 * That is what lets a person see the whole change before any of it is made: the
 * board asks this registry how much each of its rows would add and take away,
 * and asks again for one record's text when somebody opens it.
 * 
 * A proposal is not a plan the writers follow -- the writers are what produced
 * it. It is the same composition, weighed and set down before the write.
 * 
 * @since 6.2.0
 */
final class Proposal extends Registry implements Registryinterface
{
	/**
	 * Set down what one record would change.
	 *
	 * A record two rows both compose is proposed once for each row, because
	 * each row must answer for its own write: what one row would put there is
	 * not what the other would, and neither is allowed to hide the other.
	 *
	 * @param   string                $table     The table the record belongs to.
	 * @param   string                $identity  The record's identity.
	 * @param   array<string, mixed>  $delta     What the write would change.
	 *
	 * @return  void
	 * @since   6.2.0
	 */
	public function propose(string $table, string $identity, array $delta): void
	{
		$origin = trim((string) ($delta['origin'] ?? ''));

		$this->set(
			'records.' . $table . '.' . $this->key($identity) . '.'
			. ($origin === '' ? 'run' : $this->key($origin)),
			$delta
		);
	}

	/**
	 * One record's proposal, when the run made one.
	 *
	 * When more than one row composed the record, the proposal of the row
	 * that composed it last is the one answered, because that is the write
	 * that would stand.
	 *
	 * @param   string  $table     The table the record belongs to.
	 * @param   string  $identity  The record's identity.
	 *
	 * @return  array<string, mixed>|null  The proposal, or null when the run proposed none.
	 * @since   6.2.0
	 */
	public function record(string $table, string $identity): ?array
	{
		$proposals = $this->get('records.' . $table . '.' . $this->key($identity));

		if (!is_array($proposals) || $proposals === [])
		{
			return null;
		}

		$record = end($proposals);

		return is_array($record) ? $record : null;
	}

	/**
	 * Every proposal the run made, in one flat list.
	 *
	 * @return  array<int, array<string, mixed>>  The proposals.
	 * @since   6.2.0
	 */
	public function records(): array
	{
		$records = [];

		foreach ((array) $this->get('records', []) as $table)
		{
			foreach ((array) $table as $proposals)
			{
				foreach ((array) $proposals as $record)
				{
					if (is_array($record))
					{
						$records[] = $record;
					}
				}
			}
		}

		return $records;
	}

	/**
	 * What each row of the pairing board would add and take away.
	 *
	 * A row owns more than one record -- an admin view owns its own record, the
	 * fields it links and the conditions it carries -- so a row's weight is the
	 * weight of everything written under it. A row whose records all match what
	 * stands is reported with nothing changed, which is how the board can say
	 * "no change" rather than leaving a person to guess.
	 *
	 * @return  array<string, array<string, mixed>>  The weight of each row, keyed by row.
	 * @since   6.2.0
	 */
	public function summary(): array
	{
		$rows = [];

		foreach ($this->records() as $record)
		{
			$origin = trim((string) ($record['origin'] ?? ''));

			if ($origin === '')
			{
				continue;
			}

			$row = $rows[$origin] ?? [
				'action' => 'create',
				'changed' => false,
				'additions' => 0,
				'deletions' => 0,
				'records' => 0
			];

			// a row that updates anything is an update: what a person needs to
			// know first is whether their own work is being written over
			if ((string) ($record['action'] ?? '') === 'update')
			{
				$row['action'] = 'update';
			}

			$row['changed'] = $row['changed'] || !empty($record['changed']);
			$row['additions'] += (int) ($record['additions'] ?? 0);
			$row['deletions'] += (int) ($record['deletions'] ?? 0);
			$row['records']++;

			$rows[$origin] = $row;
		}

		return $rows;
	}

	/**
	 * Sanitise one registry path segment.
	 *
	 * @param   string  $segment  The raw segment.
	 *
	 * @return  string  A segment safe to use in a dotted registry path.
	 * @since   6.2.0
	 */
	protected function key(string $segment): string
	{
		return preg_replace('/[^A-Za-z0-9_-]/', '_', $segment) ?? $segment;
	}
}

