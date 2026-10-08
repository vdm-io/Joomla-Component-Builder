<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    17th August, 2026
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Extrusion\Resolver;


use VDM\Joomla\Componentbuilder\Extrusion\Registry\Report;


/**
 * Turns a form field's showon attribute into a JCB field condition.
 * 
 * Joomla expresses a dependency as showon="a:1[AND]b:2", which JCB models as a
 * condition with a match field, the values that trigger it, and the fields the
 * condition governs. This is information the schema cannot carry, so it comes
 * from the form XML or not at all.
 * 
 * @since 6.1.6
 */
final class Condition
{
	/**
	 * The Report Registry.
	 *
	 * @var    Report
	 * @since  6.1.6
	 */
	protected Report $report;

	/**
	 * Constructor.
	 *
	 * @param   Report  $report  The run report registry.
	 *
	 * @since   6.1.6
	 */
	public function __construct(Report $report)
	{
		$this->report = $report;
	}

	/**
	 * Parse one showon expression.
	 *
	 * @param   string  $showon  The raw showon attribute value.
	 *
	 * @return  array<int, array{field: string, values: array<string>, negate: bool, join: string}>  Parsed clauses.
	 * @since   6.1.6
	 */
	public function parse(string $showon): array
	{
		$showon = trim($showon);

		if ($showon === '')
		{
			return [];
		}

		$parts = preg_split('/\[(AND|OR)\]/i', $showon, -1, PREG_SPLIT_DELIM_CAPTURE);

		if ($parts === false)
		{
			return [];
		}

		$clauses = [];
		$join = 'AND';

		foreach ($parts as $part)
		{
			$part = trim((string) $part);

			if ($part === '')
			{
				continue;
			}

			if (strcasecmp($part, 'AND') === 0 || strcasecmp($part, 'OR') === 0)
			{
				$join = strtoupper($part);

				continue;
			}

			$clause = $this->clause($part, $join);

			if ($clause !== null)
			{
				$clauses[] = $clause;
			}
		}

		return $clauses;
	}

	/**
	 * Parse one clause of a showon expression.
	 *
	 * @param   string  $part  The clause text, such as published!:0.
	 * @param   string  $join  The join that precedes this clause.
	 *
	 * @return  array{field: string, values: array<string>, negate: bool, join: string}|null  The clause.
	 * @since   6.1.6
	 */
	protected function clause(string $part, string $join): ?array
	{
		if (!str_contains($part, ':'))
		{
			return null;
		}

		[$field, $values] = explode(':', $part, 2);
		$negate = str_ends_with($field, '!');
		$field = rtrim($field, '!');
		$field = trim($field);

		if ($field === '')
		{
			return null;
		}

		$list = array_values(array_filter(
			array_map('trim', explode(',', $values)),
			static fn (string $value): bool => $value !== ''
		));

		return [
			'field' => $field,
			'values' => $list,
			'negate' => $negate,
			'join' => $join
		];
	}

	/**
	 * Build the JCB conditions for one view from its resolved fields.
	 *
	 * @param   string                                                  $view    The JCB view name.
	 * @param   array<string, array<string, array{value: mixed, origin: string}>>  $fields  Resolved fields.
	 *
	 * @return  array<string, array{match: string, values: array<string>, targets: array<string>, negate: bool}>  Conditions by match field.
	 * @since   6.1.6
	 */
	public function build(string $view, array $fields): array
	{
		$conditions = [];

		foreach ($fields as $column => $properties)
		{
			$showon = $properties['showon']['value'] ?? null;

			if (!is_string($showon) || trim($showon) === '')
			{
				continue;
			}

			foreach ($this->parse($showon) as $clause)
			{
				$signature = $clause['field'] . '|' . implode(',', $clause['values'])
					. '|' . ($clause['negate'] ? '1' : '0');

				if (!isset($conditions[$signature]))
				{
					$conditions[$signature] = [
						'match' => $clause['field'],
						'values' => $clause['values'],
						'targets' => [],
						'negate' => $clause['negate']
					];
				}

				if (!in_array($column, $conditions[$signature]['targets'], true))
				{
					$conditions[$signature]['targets'][] = $column;
				}
			}
		}

		if ($conditions !== [])
		{
			$this->report->set(
				'conditions.' . preg_replace('/[^A-Za-z0-9_]/', '_', $view),
				count($conditions)
			);
		}

		return $conditions;
	}
}

