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


use VDM\Joomla\Componentbuilder\Extrusion\Config;
use VDM\Joomla\Componentbuilder\Extrusion\Registry\Report;


/**
 * Interprets the relationships a table definition class declares.
 * 
 * A link names a target table, component, entity, value field and key field. No
 * other artifact carries this, so it is the single reason the table definition
 * class is worth reading. Reconstructing it from column names would be guesswork.
 * 
 * How a relationship should finally be expressed inside JCB -- as a generated
 * custom field type querying the linked view, as a dynamic get, or as a stored
 * field relation -- is a product decision that is still open. Until it is
 * settled this resolver normalises the relationship and records it, so nothing is
 * lost and nothing is invented.
 * 
 * @since 6.1.6
 */
final class Relation
{
	/**
	 * The Config Class.
	 *
	 * @var    Config
	 * @since  6.1.6
	 */
	protected Config $config;

	/**
	 * The ViewName Resolver.
	 *
	 * @var    ViewName
	 * @since  6.1.6
	 */
	protected ViewName $viewname;

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
	 * @param   Config    $config    The extrusion configuration.
	 * @param   ViewName  $viewname  The view name resolver.
	 * @param   Report    $report    The run report registry.
	 *
	 * @since   6.1.6
	 */
	public function __construct(Config $config, ViewName $viewname, Report $report)
	{
		$this->config = $config;
		$this->viewname = $viewname;
		$this->report = $report;
	}

	/**
	 * Normalise the relationship declared on one resolved field.
	 *
	 * @param   string                                            $view        The JCB view name.
	 * @param   string                                            $column      The source column name.
	 * @param   array<string, array{value: mixed, origin: string}>  $properties  Resolved properties.
	 *
	 * @return  array{column: string, table: string, view: string, entity: string, value: string, key: string, component: string, local: bool}|null  The relationship.
	 * @since   6.1.6
	 */
	public function resolve(string $view, string $column, array $properties): ?array
	{
		if (!$this->config->get('relations', true))
		{
			return null;
		}

		$link = $properties['link']['value'] ?? null;

		if (!is_array($link) || $link === [])
		{
			return null;
		}

		$table = trim((string) ($link['table'] ?? ''));

		if ($table === '')
		{
			return null;
		}

		$entity = trim((string) ($link['entity'] ?? ''));
		$target = $entity !== '' ? $entity : $this->viewname->single($table);

		$relation = [
			'column' => $column,
			'table' => $table,
			'view' => $target,
			'views' => $this->viewname->plural($target),
			'entity' => $entity,
			'value' => trim((string) ($link['value'] ?? 'name')),
			'key' => trim((string) ($link['key'] ?? 'id')),
			'component' => trim((string) ($link['component'] ?? '')),
			'local' => true
		];

		$this->report->set(
			'relations.' . $this->key($view) . '.' . $this->key($column),
			$relation['table'] . ' via ' . $relation['key'] . ' showing ' . $relation['value']
		);

		return $relation;
	}

	/**
	 * Mark which relationships point outside the set being extruded.
	 *
	 * A relationship to a view that is not part of this run cannot be wired up
	 * yet, and pretending otherwise would produce a definition that references
	 * nothing. Those are flagged so the report can list them.
	 *
	 * @param   array<int, array<string, mixed>>  $relations  The normalised relationships.
	 * @param   array<string>                     $views      The view names in this run.
	 *
	 * @return  array<int, array<string, mixed>>  The relationships with local resolved.
	 * @since   6.1.6
	 */
	public function reconcile(array $relations, array $views): array
	{
		foreach ($relations as $index => $relation)
		{
			$target = (string) ($relation['view'] ?? '');
			$local = $target !== '' && in_array($target, $views, true);
			$relations[$index]['local'] = $local;

			if (!$local)
			{
				$this->report->set(
					'relations.external.' . $this->key($target === '' ? 'unknown' : $target),
					$relation['table'] ?? ''
				);
			}
		}

		return $relations;
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

