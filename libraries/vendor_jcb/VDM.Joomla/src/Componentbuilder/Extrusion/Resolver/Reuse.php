<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    24th August, 2026
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Extrusion\Resolver;


use VDM\Joomla\Componentbuilder\Extrusion\Config;
use VDM\Joomla\Componentbuilder\Extrusion\Registry\Report;
use VDM\Joomla\Componentbuilder\Extrusion\Registry\Resolved;


/**
 * Makes every matched candidate reuse what JCB already holds.
 * 
 * Everything in JCB is linked by guid, so a guid in common says two
 * definitions are the same thing -- and a field the paired view already
 * links is that view's own wiring rediscovered, which weighs the same.
 * This step turns those matches into standing verdicts before anything is
 * written: left undecided they update what already stands, and the identity
 * is recorded so the view links it even when the field itself is left
 * untouched. A candidate that merely shares a name with something elsewhere
 * in the system stays a fresh creation -- the resemblance is offered on the
 * board, never acted on, because linking a lookalike would misstate identity.
 * 
 * An explicit verdict from the pairing board always outranks these defaults;
 * this layer only speaks where the caller stayed silent.
 * 
 * @since 6.1.8
 */
final class Reuse
{
	/**
	 * The Candidates Resolver.
	 *
	 * @var    Candidates
	 * @since  6.1.8
	 */
	protected Candidates $candidates;

	/**
	 * The Pairing Resolver.
	 *
	 * @var    Pairing
	 * @since  6.1.8
	 */
	protected Pairing $pairing;

	/**
	 * The Resolved Registry.
	 *
	 * @var    Resolved
	 * @since  6.1.8
	 */
	protected Resolved $resolved;

	/**
	 * The Report Registry.
	 *
	 * @var    Report
	 * @since  6.1.8
	 */
	protected Report $report;

	/**
	 * The Config.
	 *
	 * @var    Config
	 * @since  6.1.8
	 */
	protected Config $config;

	/**
	 * Constructor.
	 *
	 * @param   Candidates  $candidates  The candidates resolver.
	 * @param   Pairing     $pairing     The pairing resolver.
	 * @param   Resolved    $resolved    The resolved definition registry.
	 * @param   Report      $report      The run report registry.
	 * @param   Config      $config      The extrusion configuration.
	 *
	 * @since   6.1.8
	 */
	public function __construct(
		Candidates $candidates,
		Pairing $pairing,
		Resolved $resolved,
		Report $report,
		Config $config
	)
	{
		$this->candidates = $candidates;
		$this->pairing = $pairing;
		$this->resolved = $resolved;
		$this->report = $report;
		$this->config = $config;
	}

	/**
	 * Record reuse verdicts for every matched candidate of this run.
	 *
	 * @return  int  How many matched candidates were set to reuse their match.
	 * @since   6.1.8
	 */
	public function apply(): int
	{
		$component = (int) $this->config->get('component', 0);
		$catalogue = $this->candidates->catalogue($component, '', false);
		$reused = 0;

		// the database is the ground truth for what the component already
		// has: its admin views' real single and list names are recorded so
		// every writer can tell a table view's territory from a custom screen
		$this->existing((array) ($catalogue['admin_views'] ?? []));

		foreach ($this->candidates->candidates($component, $catalogue) as $entries)
		{
			foreach ((array) $entries as $entry)
			{
				$reused += $this->one((array) $entry);
			}
		}

		if ($reused > 0)
		{
			$this->report->set('counts.reused', $reused);
		}

		return $reused;
	}

	/**
	 * Record the component's own admin view names for the writers to consult.
	 *
	 * @param   array<int, object|array>  $views  The component's admin views.
	 *
	 * @return  void
	 * @since   6.1.8
	 */
	protected function existing(array $views): void
	{
		$names = [];

		foreach ($views as $row)
		{
			$row = (array) $row;

			foreach (['name', 'list'] as $field)
			{
				// a view's stored name is the English a person reads; the
				// folders and forms the compiler writes speak its code
				$name = Text::code((string) ($row[$field] ?? ''));

				if ($name !== '')
				{
					$names[$name] = true;
				}
			}
		}

		if ($names !== [])
		{
			$this->resolved->set('existing.admin_view_names', array_keys($names));
		}
	}

	/**
	 * Record one candidate's reuse, and walk into its field candidates.
	 *
	 * @param   array<string, mixed>  $entry  The candidate entry.
	 *
	 * @return  int  How many reuse verdicts this entry and its fields yielded.
	 * @since   6.1.8
	 */
	protected function one(array $entry): int
	{
		$kind = (string) ($entry['kind'] ?? '');
		$key = (string) ($entry['key'] ?? '');
		$match = $entry['match'] ?? null;
		$reused = 0;

		if ($kind === 'field' && $this->shared($key))
		{
			// a column carrying a share note already has its identity: the
			// sharing resolver settled the whole group onto one field, and a
			// default recorded here would detach this member from it -- the
			// exact quiet duplication this layer must never cause
			return 0;
		}

		if ($kind !== '' && $key !== '' && is_array($match)
			&& in_array($match['by'] ?? '', ['guid', 'scoped'], true))
		{
			$target = (string) ($match['guid'] ?? '');

			if ($this->pairing->reuse($kind, $key, $target))
			{
				$reused++;
			}

			// a matched field records the identity it matched, so the view
			// that relates to it links the field that already stands -- the
			// link is owed whether or not the field itself is rewritten
			if ($kind === 'field' && $target !== ''
				&& ($dot = strpos($key, '.')) !== false)
			{
				$this->resolved->set(
					'view.' . substr($key, 0, $dot) . '.linked.'
					. substr($key, $dot + 1) . '.guid',
					strtolower($target)
				);
			}
		}

		foreach ((array) ($entry['fields'] ?? []) as $field)
		{
			$reused += $this->one((array) $field);
		}

		return $reused;
	}

	/**
	 * Whether one field candidate's column carries a share note.
	 *
	 * @param   string  $key  The candidate key, view dot column.
	 *
	 * @return  bool  True when the sharing resolver settled this column.
	 * @since   6.1.9
	 */
	protected function shared(string $key): bool
	{
		$dot = strpos($key, '.');

		if ($dot === false)
		{
			return false;
		}

		return is_array($this->resolved->get(
			'view.' . substr($key, 0, $dot) . '.field.' . substr($key, $dot + 1) . '.share'
		));
	}
}

