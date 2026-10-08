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
use VDM\Joomla\Componentbuilder\Extrusion\Registry\Resolved;


/**
 * Decides which fields are the title, alias, description and list columns.
 * 
 * When the source is a JCB-built component the table definition class states
 * these outright, and that answer is used. Otherwise they are inferred from the
 * column names, which is a guess and is recorded as one.
 * 
 * @since 6.1.6
 */
final class Role
{
	/**
	 * Column names that must never take a display role.
	 *
	 * @var    array<string>
	 * @since  6.1.6
	 */
	private const AVOID = ['not_required', 'id', 'asset_id', 'params', 'guid'];

	/**
	 * How many list columns a view is given when they must be inferred.
	 *
	 * @var    int
	 * @since  6.1.6
	 */
	private const LIST_LIMIT = 5;

	/**
	 * The Resolved Registry.
	 *
	 * @var    Resolved
	 * @since  6.1.6
	 */
	protected Resolved $resolved;

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
	 * @param   Resolved  $resolved  The resolved field registry.
	 * @param   Report    $report    The run report registry.
	 *
	 * @since   6.1.6
	 */
	public function __construct(Resolved $resolved, Report $report)
	{
		$this->resolved = $resolved;
		$this->report = $report;
	}

	/**
	 * Assign the display roles for one view.
	 *
	 * @param   string                                                  $view    The JCB view name.
	 * @param   array<string, array<string, array{value: mixed, origin: string}>>  $fields  Resolved fields in order.
	 *
	 * @return  array<string, array{title: bool, alias: bool, description: bool, list: bool, order: int}>  The roles per column.
	 * @since   6.1.6
	 */
	public function assign(string $view, array $fields): array
	{
		$roles = [];
		$order = 0;

		foreach (array_keys($fields) as $column)
		{
			$roles[$column] = [
				'title' => false,
				'alias' => false,
				'description' => false,
				'list' => false,
				'order' => $order++
			];
		}

		$stated = $this->stated($fields);

		if ($stated !== [])
		{
			$this->report->set('roles.' . $this->key($view) . '.origin', 'table');

			return $this->merge($roles, $stated);
		}

		$this->report->set('roles.' . $this->key($view) . '.origin', 'derived');

		return $this->merge($roles, $this->inferred($fields));
	}

	/**
	 * The roles the table definition class stated outright.
	 *
	 * @param   array<string, array<string, array{value: mixed, origin: string}>>  $fields  Resolved fields.
	 *
	 * @return  array<string, array<string, bool>>  Stated roles per column.
	 * @since   6.1.6
	 */
	protected function stated(array $fields): array
	{
		$roles = [];

		foreach ($fields as $column => $properties)
		{
			$title = $properties['title'] ?? null;
			$list = $properties['list'] ?? null;

			if ($title !== null && ($title['origin'] ?? '') === 'table' && !empty($title['value']))
			{
				$roles[$column]['title'] = true;
			}

			if ($list !== null && ($list['origin'] ?? '') === 'table' && !empty($list['value']))
			{
				$roles[$column]['list'] = true;
			}
		}

		return $roles;
	}

	/**
	 * The roles inferred from column names when nothing stated them.
	 *
	 * @param   array<string, array<string, array{value: mixed, origin: string}>>  $fields  Resolved fields.
	 *
	 * @return  array<string, array<string, bool>>  Inferred roles per column.
	 * @since   6.1.6
	 */
	protected function inferred(array $fields): array
	{
		$roles = [];
		$hasTitle = false;
		$hasAlias = false;
		$hasDescription = false;
		$listed = 0;

		foreach ($fields as $column => $properties)
		{
			if (in_array($column, self::AVOID, true))
			{
				continue;
			}

			if (!$hasTitle && $this->looksLike($column, ['name', 'title']))
			{
				$roles[$column]['title'] = true;
				$roles[$column]['list'] = true;
				$hasTitle = true;
				$listed++;

				continue;
			}

			// the alias is the column JCB itself names alias: a view's alias
			// field becomes that column when the component is built, so a
			// column merely named after one -- alias_builder, alias_type --
			// would be renamed and the table would lose a column of its own
			if (!$hasAlias && strtolower(trim($column)) === 'alias')
			{
				$roles[$column]['alias'] = true;
				$hasAlias = true;

				continue;
			}

			if (!$hasDescription && $this->looksLike($column, ['desc']))
			{
				$roles[$column]['description'] = true;
				$roles[$column]['list'] = true;
				$hasDescription = true;
				$listed++;

				continue;
			}

			if ($listed < self::LIST_LIMIT && $this->isTextual($properties))
			{
				$roles[$column]['list'] = true;
				$listed++;
			}
		}

		return $roles;
	}

	/**
	 * Whether a column name contains one of the given hints.
	 *
	 * @param   string         $column  The column name.
	 * @param   array<string>  $hints   The hints to look for.
	 *
	 * @return  bool  True when a hint is present.
	 * @since   6.1.6
	 */
	protected function looksLike(string $column, array $hints): bool
	{
		foreach ($hints as $hint)
		{
			if (stripos($column, $hint) !== false)
			{
				return true;
			}
		}

		return false;
	}

	/**
	 * Whether a resolved field is short text worth listing.
	 *
	 * @param   array<string, array{value: mixed, origin: string}>  $properties  Resolved properties.
	 *
	 * @return  bool  True when the field is textual.
	 * @since   6.1.6
	 */
	protected function isTextual(array $properties): bool
	{
		$type = strtolower((string) ($properties['xml_type']['value'] ?? ''));

		if ($type !== '')
		{
			return in_array($type, ['text', 'email', 'url', 'tel', 'number', 'integer'], true);
		}

		$datatype = strtoupper((string) ($properties['datatype']['value'] ?? ''));

		return in_array($datatype, ['VARCHAR', 'CHAR'], true);
	}

	/**
	 * Merge assigned roles over the ordered baseline.
	 *
	 * @param   array<string, array<string, mixed>>  $roles     The baseline roles.
	 * @param   array<string, array<string, bool>>   $assigned  The assigned roles.
	 *
	 * @return  array<string, array<string, mixed>>  The merged roles.
	 * @since   6.1.6
	 */
	protected function merge(array $roles, array $assigned): array
	{
		foreach ($assigned as $column => $flags)
		{
			if (!isset($roles[$column]))
			{
				continue;
			}

			foreach ($flags as $flag => $value)
			{
				$roles[$column][$flag] = $value;
			}
		}

		return $roles;
	}

	/**
	 * Sanitise one registry path segment.
	 *
	 * @param   string  $segment  The raw segment.
	 *
	 * @return  string  A segment safe to use in a dotted registry path.
	 * @since   6.1.6
	 */
	public function key(string $segment): string
	{
		return preg_replace('/[^A-Za-z0-9_]/', '_', $segment) ?? $segment;
	}
}

