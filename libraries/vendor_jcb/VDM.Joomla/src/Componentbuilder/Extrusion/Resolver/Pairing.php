<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    23rd August, 2026
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Extrusion\Resolver;


use VDM\Joomla\Componentbuilder\Extrusion\Registry\Decision;
use VDM\Joomla\Componentbuilder\Extrusion\Registry\Report;


/**
 * Applies the caller's pairing verdicts to every settled identity.
 * 
 * The harvest derives an identity for every candidate, and left alone that
 * identity is what the writers use -- an existing definition updates, a new
 * one is created. The pairing step lets a person overrule any of it: ignore a
 * candidate outright, force a fresh definition even though a match exists, or
 * point the candidate at a different existing definition entirely.
 * 
 * A verdict is three parts: an action (create, update, ignore), an optional
 * target identity for updates, and the candidate key it applies to. Anything
 * without a verdict keeps the harvest's own answer, so the whole layer is
 * invisible until the interface hands verdicts back.
 * 
 * @since 6.1.7
 */
final class Pairing
{
	/**
	 * The verdict actions a caller may hand back.
	 *
	 * @var    array<string>
	 * @since  6.1.7
	 */
	public const ACTIONS = ['create', 'update', 'ignore'];

	/**
	 * The Decision Registry.
	 *
	 * @var    Decision
	 * @since  6.1.7
	 */
	protected Decision $decision;

	/**
	 * The Guid Resolver.
	 *
	 * @var    Guid
	 * @since  6.1.7
	 */
	protected Guid $guid;

	/**
	 * The Report Registry.
	 *
	 * @var    Report
	 * @since  6.1.7
	 */
	protected Report $report;

	/**
	 * Constructor.
	 *
	 * @param   Decision  $decision  The decision registry.
	 * @param   Guid      $guid      The identity resolver.
	 * @param   Report    $report    The run report registry.
	 *
	 * @since   6.1.7
	 */
	public function __construct(Decision $decision, Guid $guid, Report $report)
	{
		$this->decision = $decision;
		$this->guid = $guid;
		$this->report = $report;
	}

	/**
	 * Load a batch of verdicts, as the interface hands them back.
	 *
	 * The shape is kind, then candidate key, then a verdict of action and
	 * optional target. Anything malformed is reported and dropped rather than
	 * silently trusted, because these verdicts decide what is written where.
	 *
	 * @param   array<string, array<string, mixed>>  $decisions  The verdicts by kind and key.
	 *
	 * @return  int  How many verdicts were loaded.
	 * @since   6.1.7
	 */
	public function load(array $decisions): int
	{
		$loaded = 0;

		foreach ($decisions as $kind => $verdicts)
		{
			$kind = $this->key((string) $kind);

			if ($kind === '' || !is_array($verdicts))
			{
				continue;
			}

			foreach ($verdicts as $key => $verdict)
			{
				$key = $this->key((string) $key);
				$verdict = (array) $verdict;
				$action = strtolower(trim((string) ($verdict['action'] ?? '')));
				$target = trim((string) ($verdict['target'] ?? ''));

				if ($key === '' || !in_array($action, self::ACTIONS, true))
				{
					$this->report->set(
						'failed.decision.' . $kind . '.' . ($key ?: 'unnamed'),
						'malformed verdict'
					);

					continue;
				}

				if ($action === 'update' && !$this->guid->valid($target))
				{
					$this->report->set(
						'failed.decision.' . $kind . '.' . $key,
						'update verdict without a valid target'
					);

					continue;
				}

				$this->decision->set($kind . '.' . $key, [
					'action' => $action,
					'target' => $action === 'update' ? strtolower($target) : ''
				]);
				$loaded++;
			}
		}

		return $loaded;
	}

	/**
	 * The verdict one candidate carries, when the caller gave one.
	 *
	 * @param   string  $kind  The candidate kind, such as admin_view or power.
	 * @param   string  $key   The candidate key within its kind.
	 *
	 * @return  array{action: string, target: string}|null  The verdict, or null.
	 * @since   6.1.7
	 */
	public function verdict(string $kind, string $key): ?array
	{
		$verdict = $this->decision->get(
			$this->key($kind) . '.' . $this->key($key)
		);

		return is_array($verdict) ? $verdict : null;
	}

	/**
	 * Record a reuse verdict for one candidate, unless the caller already spoke.
	 *
	 * A candidate that matches a definition JCB already holds must not be
	 * created again: left undecided, it defaults to updating the match. An
	 * explicit verdict from the caller always outranks this default.
	 *
	 * @param   string  $kind    The candidate kind, such as admin_view or field.
	 * @param   string  $key     The candidate key within its kind.
	 * @param   string  $target  The matched identity to reuse.
	 *
	 * @return  bool  True when the default verdict was recorded.
	 * @since   6.1.8
	 */
	public function reuse(string $kind, string $key, string $target): bool
	{
		$kind = $this->key($kind);
		$key = $this->key($key);
		$target = strtolower(trim($target));

		if ($kind === '' || $key === '' || !$this->guid->valid($target)
			|| $this->decision->get($kind . '.' . $key) !== null)
		{
			return false;
		}

		$this->decision->set($kind . '.' . $key, [
			'action' => 'update',
			'target' => $target
		]);
		$this->report->set('reuse.' . $kind . '.' . $key, $target);

		return true;
	}

	/**
	 * Record a settled verdict for one candidate, unless the caller already spoke.
	 *
	 * The sharing resolver settles one identity for a whole group of columns,
	 * and the writers must then write exactly that identity -- so the group's
	 * steering lands here, in the same registry a person's verdict lands in,
	 * where every writer already looks. A verdict that already stands always
	 * outranks this: a person spoke, or the group was settled once already,
	 * and neither is overwritten.
	 *
	 * @param   string  $kind    The candidate kind, such as field.
	 * @param   string  $key     The candidate key within its kind.
	 * @param   string  $action  The verdict action: create, update, or ignore.
	 * @param   string  $target  The identity an update verdict points at.
	 *
	 * @return  bool  True when the verdict was recorded.
	 * @since   6.1.9
	 */
	public function decide(string $kind, string $key, string $action, string $target = ''): bool
	{
		$kind = $this->key($kind);
		$key = $this->key($key);
		$action = strtolower(trim($action));
		$target = strtolower(trim($target));

		if ($kind === '' || $key === '' || !in_array($action, self::ACTIONS, true)
			|| ($action === 'update' && !$this->guid->valid($target))
			|| $this->decision->get($kind . '.' . $key) !== null)
		{
			return false;
		}

		$this->decision->set($kind . '.' . $key, [
			'action' => $action,
			'target' => $action === 'update' ? $target : ''
		]);
		$this->report->set(
			'settled.' . $kind . '.' . $key,
			$action . ($target !== '' ? ' ' . $target : '')
		);

		return true;
	}

	/**
	 * The identity one candidate is written under, after its verdict.
	 *
	 * Without a verdict the derived identity stands. An ignore verdict answers
	 * null, which tells the writer to leave the candidate out and say so. An
	 * update verdict answers its target, so the candidate updates the
	 * definition the person pointed at. A create verdict answers a fresh
	 * identity salted off the derived one -- stable across re-runs, but never
	 * the identity an existing definition already holds.
	 *
	 * @param   string  $kind     The candidate kind, such as admin_view or power.
	 * @param   string  $key      The candidate key within its kind.
	 * @param   string  $derived  The identity the harvest derived.
	 *
	 * @return  string|null  The identity to write under, or null to leave it out.
	 * @since   6.1.7
	 */
	public function guid(string $kind, string $key, string $derived): ?string
	{
		$verdict = $this->verdict($kind, $key);

		if ($verdict === null)
		{
			return $derived;
		}

		if ($verdict['action'] === 'ignore')
		{
			$this->report->set(
				'skipped.decision.' . $this->key($kind) . '.' . $this->key($key),
				true
			);

			return null;
		}

		if ($verdict['action'] === 'update' && $verdict['target'] !== '')
		{
			return $verdict['target'];
		}

		return $this->guid->derive([$kind, 'forced-new', $derived]);
	}

	/**
	 * Sanitise one decision key.
	 *
	 * The dot is kept, because it is the seam between a key's own segments --
	 * a field key is view dot column, each segment already sanitised by its
	 * caller. Collapsing the dot would fold distinct keys together: the view
	 * invoice with column line_total and the view invoice_line with column
	 * total are two different columns, and folding their decisions into one
	 * slot writes one field's verdict onto the other.
	 *
	 * @param   string  $segment  The raw segment.
	 *
	 * @return  string  A key safe to use in a dotted registry path.
	 * @since   6.1.7
	 */
	public function key(string $segment): string
	{
		return preg_replace('/[^A-Za-z0-9_.]/', '_', trim($segment)) ?? $segment;
	}
}

