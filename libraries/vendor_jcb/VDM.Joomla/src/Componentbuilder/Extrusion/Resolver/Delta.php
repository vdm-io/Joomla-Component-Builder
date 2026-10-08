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

namespace VDM\Joomla\Componentbuilder\Extrusion\Resolver;


use VDM\Joomla\Componentbuilder\Extrusion\Powers\Resolver\Placeholders;
use VDM\Joomla\Componentbuilder\Extrusion\Registry\Proposal;
use VDM\Joomla\Componentbuilder\Extrusion\Registry\Plan;
use VDM\Joomla\Componentbuilder\Extrusion\Registry\Report;
use VDM\Joomla\Interfaces\Data\ItemInterface;
use VDM\Joomla\Interfaces\TableInterface;


/**
 * Weighs the record a writer composed against the record that stands.
 * 
 * Only the columns a write would carry are weighed. A column the record holds
 * and the write never names is untouched by that write, so it is not a
 * difference -- the question this answers is "what would this write change",
 * never "how do these two records differ".
 * 
 * Two forms of every value are kept, and they are not the same form. Whether a
 * value changed is decided on what would land in the column, encoded as the
 * storage pipeline encodes it, because that is what a write compares against.
 * What a person is shown is the value read back out -- the text of a power,
 * the pretty print of a subform -- because that is what a person reads.
 * 
 * Both forms read a value the way a person does, never the way bytes do. A
 * line ends the same whichever way it was broken; a subform says the same
 * thing whichever order its keys were saved in, and whether a number was
 * posted as text through a form or composed as a number by a writer. A write
 * that differs only in those ways would change nothing anybody could see, so
 * it is not a change, and it is not made.
 * 
 * @since 6.2.0
 */
final class Delta
{
	/**
	 * The Data Item Class.
	 *
	 * @var    ItemInterface
	 * @since  6.2.0
	 */
	protected ItemInterface $item;

	/**
	 * The JCB Table Definitions.
	 *
	 * @var    TableInterface
	 * @since  6.2.0
	 */
	protected TableInterface $tables;

	/**
	 * The Diff Resolver.
	 *
	 * @var    Diff
	 * @since  6.2.0
	 */
	protected Diff $diff;

	/**
	 * The Proposal Registry.
	 *
	 * @var    Proposal
	 * @since  6.2.0
	 */
	protected Proposal $proposal;

	/**
	 * The Placeholders Resolver.
	 *
	 * @var    Placeholders
	 * @since  6.2.0
	 */
	protected Placeholders $placeholders;

	/**
	 * The Report Registry.
	 *
	 * @var    Report
	 * @since  6.2.0
	 */
	protected Report $report;

	/**
	 * The complete-operation write plan.
	 *
	 * @var    Plan
	 * @since  6.2.0
	 */
	protected Plan $plan;

	/**
	 * Constructor.
	 *
	 * @param   ItemInterface   $item          The JCB data item reader.
	 * @param   TableInterface  $tables        The JCB table definitions.
	 * @param   Diff            $diff          The line comparison.
	 * @param   Proposal        $proposal      The proposal registry.
	 * @param   Placeholders    $placeholders  The placeholder value resolver.
	 * @param   Report          $report        The run report registry.
	 *
	 * @since   6.2.0
	 */
	public function __construct(
		ItemInterface $item,
		TableInterface $tables,
		Diff $diff,
		Proposal $proposal,
		Placeholders $placeholders,
		Report $report,
		Plan $plan
	)
	{
		$this->item = $item;
		$this->tables = $tables;
		$this->diff = $diff;
		$this->proposal = $proposal;
		$this->placeholders = $placeholders;
		$this->report = $report;
		$this->plan = $plan;
	}

	/**
	 * Weigh one composed definition against what stands, and propose it.
	 *
	 * A record nothing stands under comes into being, which is a change even
	 * when everything it carries is empty; what it shows is only what it fills
	 * in, because a column it leaves empty adds nothing a person could read. A
	 * record that stands is weighed column by column, and only what would move
	 * is kept.
	 *
	 * @param   string       $table       The table the record belongs to.
	 * @param   string       $key         The column the table is keyed by.
	 * @param   string       $identity    The record's identity.
	 * @param   object       $definition  The definition a write would carry.
	 * @param   bool         $exists      Whether a record already stands under that identity.
	 * @param   string|null  $origin      The pairing board row this record belongs to.
	 *
	 * @return  array<string, mixed>  What the write would change.
	 * @since   6.2.0
	 */
	public function weigh(
		string $table,
		string $key,
		string $identity,
		object $definition,
		bool $exists,
		?string $origin = null
	): array
	{
		$standing = $exists ? $this->item->table($table)->get($identity, $key) : null;
		$columns = [];

		foreach (get_object_vars($definition) as $column => $after)
		{
			// the identity is how the record is found, never something the
			// write changes about it
			if ($column === $key)
			{
				continue;
			}

			$before = is_object($standing) ? ($standing->{$column} ?? null) : null;

			if ($standing !== null
				&& $this->same($table, $column, $before, $after, $identity))
			{
				continue;
			}

			// a record coming into being adds only what it fills in
			if ($standing === null && $this->nothing($after))
			{
				continue;
			}

			$columns[$column] = $this->change($before, $after);
		}

		$delta = [
			'table' => $table,
			'identity' => $identity,
			'origin' => $origin,
			// the writer has already asked whether the record stands, and that
			// answer is the action, whatever the read of the record brought back
			'action' => $exists ? 'update' : 'create',
			'changed' => !$exists || $columns !== [],
			'additions' => 0,
			'deletions' => 0,
			'columns' => $columns
		];

		foreach ($columns as $change)
		{
			$delta['additions'] += $change['additions'];
			$delta['deletions'] += $change['deletions'];
		}

		if ($this->plan->active())
		{
			$effective = clone $definition;

			if ($exists)
			{
				foreach (get_object_vars($effective) as $column => $value)
				{
					if ($column !== $key && !array_key_exists($column, $columns))
					{
						unset($effective->{$column});
					}
				}
			}

			$id = $this->item->table($table)->value($identity, $key, 'id');
			$this->plan->stage($table, $key, $identity, $effective, $delta, $standing, $id);
		}

		$this->proposal->propose($table, $identity, $delta);

		return $delta;
	}

	/**
	 * Whether the complete operation defers all persistence to preflight.
	 *
	 * @return  bool  True while all writers are staging.
	 * @since   6.2.0
	 */
	public function staging(): bool
	{
		return $this->plan->active();
	}

	/**
	 * Whether two values would land in the column as the same thing.
	 *
	 * @param   string  $table   The table the column belongs to.
	 * @param   string  $column  The column.
	 * @param   mixed   $before  The value as it stands.
	 * @param   mixed   $after   The value the write would carry.
	 *
	 * @return  bool  True when the write would change nothing.
	 * @since   6.2.0
	 */
	protected function same(
		string $table,
		string $column,
		$before,
		$after,
		string $identity = ''
	): bool
	{
		// a record may defer to something only the compiler can produce -- a
		// whole generated array, say. This run cannot resolve it, so it cannot
		// weigh it either, and the one answer that is certainly wrong is to
		// write what the compiler produced over the deferral that produced it
		$beyond = array_diff(
			$this->unresolved($before), $this->deferred($after)
		);

		if ($beyond !== [])
		{
			$this->report->set(
				'kept.deferred.' . $table . '.' . $this->path($identity) . '.' . $column,
				array_values($beyond)
			);

			return true;
		}

		$stands = $this->stored($table, $column, $this->wrappers($this->meant($before)));
		$writes = $this->stored($table, $column, $this->wrappers($this->meant($after)));

		if ($stands !== $writes)
		{
			return false;
		}

		// the two compile to the same thing, so the only reason to write is
		// that the write defers something the record spells out
		return array_diff($this->deferred($after), $this->deferred($before)) === [];
	}

	/**
	 * Every placeholder one value still names once this run has resolved it.
	 *
	 * @param   mixed  $value  The value, or a structure of them.
	 *
	 * @return  array<string>  The bare targets nothing here can stand for.
	 * @since   6.2.0
	 */
	protected function unresolved($value): array
	{
		return $this->deferred($this->meant($value));
	}

	/**
	 * Sanitise one registry path segment.
	 *
	 * @param   string  $segment  The raw segment.
	 *
	 * @return  string  A segment safe to use in a dotted registry path.
	 * @since   6.2.0
	 */
	protected function path(string $segment): string
	{
		return preg_replace('/[^A-Za-z0-9_]/', '_', $segment) ?? $segment;
	}

	/**
	 * Every placeholder one value names, under either wrapper.
	 *
	 * @param   mixed  $value  The value, or a structure of them.
	 *
	 * @return  array<string>  The bare targets named.
	 * @since   6.2.0
	 */
	protected function deferred($value): array
	{
		if (is_object($value))
		{
			$value = get_object_vars($value);
		}

		if (is_array($value))
		{
			$named = [];

			foreach ($value as $entry)
			{
				$named = array_merge($named, $this->deferred($entry));
			}

			return array_values(array_unique($named));
		}

		if (!is_string($value))
		{
			return [];
		}

		$found = [];
		preg_match_all(
			'/(?:\[\[\[|#' . '#' . '#)([A-Za-z0-9_]+)(?:\]\]\]|#' . '#' . '#)/',
			$value,
			$found
		);

		return array_values(array_unique($found[1]));
	}

	/**
	 * What a standing value means, once its placeholders stand for their values.
	 *
	 * A record may say something through a placeholder the compiler resolves,
	 * and the source it is weighed against was compiled from that very record
	 * -- so the source states the resolved form and the record the deferred
	 * one, and the two say the same thing. Weighing them as text would call
	 * that a change and write the resolved form over what a person deferred,
	 * unsaying a placeholder they chose. Only the standing side is resolved:
	 * the record is allowed to say the same thing more carefully than the
	 * source can.
	 *
	 * @param   mixed  $value  The standing value, or a structure of them.
	 *
	 * @return  mixed  The value, saying what it means.
	 * @since   6.2.0
	 */
	protected function meant($value)
	{
		if (is_string($value))
		{
			if (!str_contains($value, '[' . '[[') && !str_contains($value, '#' . '##'))
			{
				return $value;
			}

			return $this->placeholders->substitute(
				$value,
				$this->placeholders->core() + $this->placeholders->map()
			);
		}

		if (is_object($value))
		{
			$value = get_object_vars($value);
		}

		if (!is_array($value))
		{
			return $value;
		}

		$meant = [];

		foreach ($value as $key => $entry)
		{
			$meant[$key] = $this->meant($entry);
		}

		return $meant;
	}

	/**
	 * One value with both ways of writing a placeholder written the one way.
	 *
	 * The compiler registers every placeholder under both wrappers and
	 * substitutes them with the same bare replacement, so a value naming one
	 * and a value naming the other say the very same thing to it. JCB writes
	 * both itself -- a person types the bracketed form into a form, while the
	 * compiler's own custom code extractor stores the hashed one -- and a
	 * write that only swapped one for the other would change nothing while
	 * rewriting what a person curated. This is only ever said for the
	 * comparison; what the record holds is what a person is shown.
	 *
	 * @param   mixed  $value  The value, or a structure of them.
	 *
	 * @return  mixed  The value, saying one wrapper.
	 * @since   6.2.0
	 */
	protected function wrappers($value)
	{
		if (is_string($value))
		{
			return preg_replace(
				'/#' . '#' . '#([A-Za-z0-9_]+)#' . '#' . '#/', '[[[$1]]]', $value
			) ?? $value;
		}

		if (is_object($value))
		{
			$value = get_object_vars($value);
		}

		if (!is_array($value))
		{
			return $value;
		}

		$said = [];

		foreach ($value as $key => $entry)
		{
			$said[$key] = $this->wrappers($entry);
		}

		return $said;
	}

	/**
	 * One value as the column would hold it.
	 *
	 * @param   string  $table   The table the column belongs to.
	 * @param   string  $column  The column.
	 * @param   mixed   $value   The value.
	 *
	 * @return  string  The value as it would be stored.
	 * @since   6.2.0
	 */
	protected function stored(string $table, string $column, $value): string
	{
		// a column that was never set, one set to nothing, and one holding an
		// empty list are the same nothing. They read back differently -- null,
		// an empty string, an empty list, an empty object -- and a write that
		// puts one where another stands changes nothing a person would see
		if ($this->nothing($value))
		{
			return '';
		}

		// the same encoding the storage pipeline applies, so a value read back
		// out of the column and a value on its way in are compared as equals
		switch ((string) $this->tables->get($table, $column, 'store'))
		{
			case 'base64':
				return base64_encode($this->text($value));

			case 'json':
				return (string) json_encode($this->canonical($value), JSON_FORCE_OBJECT);
		}

		if (is_array($value) || is_object($value))
		{
			return (string) json_encode($this->canonical($value));
		}

		return $this->text($value);
	}

	/**
	 * Whether a value says nothing at all.
	 *
	 * @param   mixed  $value  The value.
	 *
	 * @return  bool  True when the value holds nothing.
	 * @since   6.2.0
	 */
	protected function nothing($value): bool
	{
		if ($value === null || $value === '' || $value === [])
		{
			return true;
		}

		if (is_object($value))
		{
			return get_object_vars($value) === [];
		}

		// the stored forms of an empty list, read back out of the column as
		// the text they were written as
		return is_string($value) && in_array(trim($value), ['[]', '{}'], true);
	}

	/**
	 * One scalar as a person reads it.
	 *
	 * A switch is on or off whichever way it was written, and a line ends the
	 * same whichever way it was broken: the readers already fold every line
	 * ending of a source file to one, and what a form saved may carry the
	 * other, so neither is a difference.
	 *
	 * @param   mixed  $value  The scalar.
	 *
	 * @return  string  The text it reads as.
	 * @since   6.2.0
	 */
	protected function text($value): string
	{
		if (is_bool($value))
		{
			return $value ? '1' : '0';
		}

		return str_replace(["\r\n", "\r"], "\n", (string) $value);
	}

	/**
	 * One structure as a person reads it, whichever way it was saved.
	 *
	 * A subform saved through a form arrives with its keys in the form's order
	 * and every value as text; the same subform composed by a writer carries
	 * the writer's order and numbers where the form had text. A person reads
	 * both as the same subform, so both are laid out the same way: named keys
	 * in one order, and every scalar as the text it reads as. A list keeps its
	 * order, because there the position is the meaning.
	 *
	 * @param   mixed  $value  The structure, or a scalar inside one.
	 *
	 * @return  mixed  The structure laid out one way.
	 * @since   6.2.0
	 */
	protected function canonical($value)
	{
		if (is_object($value))
		{
			$value = get_object_vars($value);
		}

		if (!is_array($value))
		{
			return $value === null ? '' : $this->text($value);
		}

		$canonical = [];

		foreach ($value as $key => $entry)
		{
			$canonical[$key] = $this->canonical($entry);
		}

		if (!array_is_list($canonical))
		{
			ksort($canonical, SORT_STRING);
		}

		return $canonical;
	}

	/**
	 * One column's change, in the form a person reads and weighed by line.
	 *
	 * @param   mixed  $before  The value as it stands.
	 * @param   mixed  $after   The value the write would carry.
	 *
	 * @return  array<string, mixed>  The change.
	 * @since   6.2.0
	 */
	protected function change($before, $after): array
	{
		$old = $this->readable($before);
		$new = $this->readable($after);
		$counts = $this->diff->counts($old, $new);

		return [
			'before' => $old,
			'after' => $new,
			'shape' => str_contains($old, "\n") || str_contains($new, "\n") ? 'text' : 'value',
			'additions' => $counts['additions'],
			'deletions' => $counts['deletions']
		];
	}

	/**
	 * One value as a person reads it.
	 *
	 * It is laid out exactly as it is weighed, so the lines a person is shown
	 * are the lines that moved and nothing else.
	 *
	 * @param   mixed  $value  The value.
	 *
	 * @return  string  The readable value.
	 * @since   6.2.0
	 */
	protected function readable($value): string
	{
		if ($this->nothing($value))
		{
			return '';
		}

		if (is_array($value) || is_object($value))
		{
			// a subform read as one long line is a subform nobody can read: the
			// entries are laid out so a change lands on the line it belongs to
			return (string) json_encode(
				$this->canonical($value),
				JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
			);
		}

		return $this->text($value);
	}
}

