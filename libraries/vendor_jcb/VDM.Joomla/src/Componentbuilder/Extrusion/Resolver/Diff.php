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


/**
 * Reads two texts line by line and says what changed between them.
 * 
 * The line is the unit a person reads a change in, so it is the unit here: how
 * many lines a change adds, how many it takes away, and where. What comes back
 * is the shape of a unified diff -- hunks of changed lines with a little of the
 * unchanged text around them -- because that is the shape every developer
 * already knows how to read.
 * 
 * Two bounds keep a very large text honest rather than expensive: the lines
 * both texts share at the start and the end are recognised before anything is
 * compared, which is the whole of a typical edit; and a middle too large to
 * line up exactly is reported as replaced rather than matched line by line,
 * which is true, just less precise.
 * 
 * @since 6.2.0
 */
final class Diff
{
	/**
	 * How many unchanged lines are shown around a change.
	 *
	 * @var    int
	 * @since  6.2.0
	 */
	private const CONTEXT = 3;

	/**
	 * The largest middle this will line up exactly, in lines.
	 *
	 * @var    int
	 * @since  6.2.0
	 */
	private const LIMIT = 1500;

	/**
	 * Compare two texts line by line.
	 *
	 * @param   string  $before  The text as it stands.
	 * @param   string  $after   The text as it would be.
	 *
	 * @return  array{additions: int, deletions: int, hunks: array<int, array<string, mixed>>}  What changed.
	 * @since   6.2.0
	 */
	public function compare(string $before, string $after): array
	{
		$operations = $this->operations($this->split($before), $this->split($after));
		$additions = 0;
		$deletions = 0;

		foreach ($operations as $operation)
		{
			if ($operation['op'] === 'add')
			{
				$additions++;
			}
			elseif ($operation['op'] === 'remove')
			{
				$deletions++;
			}
		}

		return [
			'additions' => $additions,
			'deletions' => $deletions,
			'hunks' => $additions === 0 && $deletions === 0 ? [] : $this->hunks($operations)
		];
	}

	/**
	 * Count what a comparison would add and take away, without the hunks.
	 *
	 * @param   string  $before  The text as it stands.
	 * @param   string  $after   The text as it would be.
	 *
	 * @return  array{additions: int, deletions: int}  The counts alone.
	 * @since   6.2.0
	 */
	public function counts(string $before, string $after): array
	{
		$compared = $this->compare($before, $after);

		unset($compared['hunks']);

		return $compared;
	}

	/**
	 * The lines of one text.
	 *
	 * An empty text is no lines at all, not one empty line: a value that was
	 * never set has nothing to show, and counting it as a line would report an
	 * addition where a person sees none.
	 *
	 * @param   string  $text  The text.
	 *
	 * @return  array<int, string>  The lines.
	 * @since   6.2.0
	 */
	protected function split(string $text): array
	{
		return $text === '' ? [] : explode("\n", str_replace("\r\n", "\n", $text));
	}

	/**
	 * Line up two sets of lines and say what happens to each.
	 *
	 * @param   array<int, string>  $old  The lines as they stand.
	 * @param   array<int, string>  $new  The lines as they would be.
	 *
	 * @return  array<int, array{op: string, old: int|null, new: int|null, text: string}>  The operations in order.
	 * @since   6.2.0
	 */
	protected function operations(array $old, array $new): array
	{
		$head = $this->head($old, $new);
		$tail = $this->tail($old, $new, $head);
		$operations = [];

		for ($index = 0; $index < $head; $index++)
		{
			$operations[] = $this->operation('keep', $index, $index, $old[$index]);
		}

		$middleOld = array_slice($old, $head, count($old) - $head - $tail);
		$middleNew = array_slice($new, $head, count($new) - $head - $tail);

		foreach ($this->middle($middleOld, $middleNew, $head) as $operation)
		{
			$operations[] = $operation;
		}

		for ($index = 0; $index < $tail; $index++)
		{
			$oldLine = count($old) - $tail + $index;
			$operations[] = $this->operation('keep', $oldLine, count($new) - $tail + $index, $old[$oldLine]);
		}

		return $operations;
	}

	/**
	 * What happens between the shared start and the shared end.
	 *
	 * @param   array<int, string>  $old   The differing lines as they stand.
	 * @param   array<int, string>  $new   The differing lines as they would be.
	 * @param   int                 $head  How many shared lines came first.
	 *
	 * @return  array<int, array{op: string, old: int|null, new: int|null, text: string}>  The operations in order.
	 * @since   6.2.0
	 */
	protected function middle(array $old, array $new, int $head): array
	{
		if ($old === [] && $new === [])
		{
			return [];
		}

		// a middle this large is reported as replaced rather than lined up: the
		// answer stays true, and the work stays bounded
		if (count($old) > self::LIMIT || count($new) > self::LIMIT)
		{
			return array_merge(
				$this->all('remove', $old, $head, true),
				$this->all('add', $new, $head, false)
			);
		}

		return $this->aligned($old, $new, $head);
	}

	/**
	 * Every line of one side as one kind of operation.
	 *
	 * @param   string              $op      The operation.
	 * @param   array<int, string>  $lines   The lines.
	 * @param   int                 $head    How many shared lines came first.
	 * @param   bool                $isOld   Whether these are the standing lines.
	 *
	 * @return  array<int, array{op: string, old: int|null, new: int|null, text: string}>  The operations.
	 * @since   6.2.0
	 */
	protected function all(string $op, array $lines, int $head, bool $isOld): array
	{
		$operations = [];

		foreach ($lines as $index => $line)
		{
			$operations[] = $this->operation(
				$op,
				$isOld ? $head + $index : null,
				$isOld ? null : $head + $index,
				$line
			);
		}

		return $operations;
	}

	/**
	 * Line up two middles by their longest common run of lines.
	 *
	 * @param   array<int, string>  $old   The differing lines as they stand.
	 * @param   array<int, string>  $new   The differing lines as they would be.
	 * @param   int                 $head  How many shared lines came first.
	 *
	 * @return  array<int, array{op: string, old: int|null, new: int|null, text: string}>  The operations in order.
	 * @since   6.2.0
	 */
	protected function aligned(array $old, array $new, int $head): array
	{
		$lengths = $this->lengths($old, $new);
		$operations = [];
		$oldIndex = 0;
		$newIndex = 0;
		$oldCount = count($old);
		$newCount = count($new);

		while ($oldIndex < $oldCount && $newIndex < $newCount)
		{
			if ($old[$oldIndex] === $new[$newIndex])
			{
				$operations[] = $this->operation(
					'keep', $head + $oldIndex, $head + $newIndex, $old[$oldIndex]
				);
				$oldIndex++;
				$newIndex++;

				continue;
			}

			// where the two runs are equally long the removal is shown first,
			// which is the order every diff a person has read puts them in
			if ($lengths[$oldIndex + 1][$newIndex] >= $lengths[$oldIndex][$newIndex + 1])
			{
				$operations[] = $this->operation('remove', $head + $oldIndex, null, $old[$oldIndex]);
				$oldIndex++;

				continue;
			}

			$operations[] = $this->operation('add', null, $head + $newIndex, $new[$newIndex]);
			$newIndex++;
		}

		while ($oldIndex < $oldCount)
		{
			$operations[] = $this->operation('remove', $head + $oldIndex, null, $old[$oldIndex]);
			$oldIndex++;
		}

		while ($newIndex < $newCount)
		{
			$operations[] = $this->operation('add', null, $head + $newIndex, $new[$newIndex]);
			$newIndex++;
		}

		return $operations;
	}

	/**
	 * The longest common run of lines from every position onward.
	 *
	 * @param   array<int, string>  $old  The differing lines as they stand.
	 * @param   array<int, string>  $new  The differing lines as they would be.
	 *
	 * @return  array<int, array<int, int>>  The run lengths.
	 * @since   6.2.0
	 */
	protected function lengths(array $old, array $new): array
	{
		$oldCount = count($old);
		$newCount = count($new);
		$lengths = array_fill(0, $oldCount + 1, array_fill(0, $newCount + 1, 0));

		for ($oldIndex = $oldCount - 1; $oldIndex >= 0; $oldIndex--)
		{
			for ($newIndex = $newCount - 1; $newIndex >= 0; $newIndex--)
			{
				$lengths[$oldIndex][$newIndex] = $old[$oldIndex] === $new[$newIndex]
					? $lengths[$oldIndex + 1][$newIndex + 1] + 1
					: max($lengths[$oldIndex + 1][$newIndex], $lengths[$oldIndex][$newIndex + 1]);
			}
		}

		return $lengths;
	}

	/**
	 * How many lines both texts share at the start.
	 *
	 * @param   array<int, string>  $old  The lines as they stand.
	 * @param   array<int, string>  $new  The lines as they would be.
	 *
	 * @return  int  The shared count.
	 * @since   6.2.0
	 */
	protected function head(array $old, array $new): int
	{
		$shared = 0;
		$shortest = min(count($old), count($new));

		while ($shared < $shortest && $old[$shared] === $new[$shared])
		{
			$shared++;
		}

		return $shared;
	}

	/**
	 * How many lines both texts share at the end, beyond the shared start.
	 *
	 * @param   array<int, string>  $old   The lines as they stand.
	 * @param   array<int, string>  $new   The lines as they would be.
	 * @param   int                 $head  How many lines they share at the start.
	 *
	 * @return  int  The shared count.
	 * @since   6.2.0
	 */
	protected function tail(array $old, array $new, int $head): int
	{
		$shared = 0;
		$shortest = min(count($old), count($new)) - $head;

		while ($shared < $shortest
			&& $old[count($old) - $shared - 1] === $new[count($new) - $shared - 1])
		{
			$shared++;
		}

		return $shared;
	}

	/**
	 * One operation on one line.
	 *
	 * @param   string    $op    The operation.
	 * @param   int|null  $old   The line number as it stands, when it has one.
	 * @param   int|null  $new   The line number as it would be, when it has one.
	 * @param   string    $text  The line.
	 *
	 * @return  array{op: string, old: int|null, new: int|null, text: string}  The operation.
	 * @since   6.2.0
	 */
	protected function operation(string $op, ?int $old, ?int $new, string $text): array
	{
		return [
			'op' => $op,
			'old' => $old === null ? null : $old + 1,
			'new' => $new === null ? null : $new + 1,
			'text' => $text
		];
	}

	/**
	 * Gather the operations into hunks of changed lines with their context.
	 *
	 * Two changes close enough that the unchanged lines between them would all
	 * be shown as context anyway are read together, in one hunk; only a gap
	 * wider than that is left out and marked as left out.
	 *
	 * @param   array<int, array{op: string, old: int|null, new: int|null, text: string}>  $operations  The operations in order.
	 *
	 * @return  array<int, array<string, mixed>>  The hunks.
	 * @since   6.2.0
	 */
	protected function hunks(array $operations): array
	{
		$groups = [];
		$group = [];
		$previous = null;

		foreach ($operations as $index => $operation)
		{
			if ($operation['op'] === 'keep')
			{
				continue;
			}

			if ($previous !== null && $index - $previous - 1 > 2 * self::CONTEXT)
			{
				$groups[] = $group;
				$group = [];
			}

			$group[] = $index;
			$previous = $index;
		}

		if ($group !== [])
		{
			$groups[] = $group;
		}

		$hunks = [];
		$last = count($operations) - 1;

		foreach ($groups as $changes)
		{
			$first = max(0, $changes[0] - self::CONTEXT);
			$final = min($last, end($changes) + self::CONTEXT);

			$hunks[] = $this->hunk(array_slice($operations, $first, $final - $first + 1));
		}

		return $hunks;
	}

	/**
	 * One hunk, told where it starts on each side.
	 *
	 * @param   array<int, array{op: string, old: int|null, new: int|null, text: string}>  $lines  The hunk's lines.
	 *
	 * @return  array<string, mixed>  The hunk.
	 * @since   6.2.0
	 */
	protected function hunk(array $lines): array
	{
		$old = null;
		$new = null;

		foreach ($lines as $line)
		{
			$old = $old ?? $line['old'];
			$new = $new ?? $line['new'];
		}

		return [
			'old' => $old ?? 0,
			'new' => $new ?? 0,
			'lines' => array_values($lines)
		];
	}
}

