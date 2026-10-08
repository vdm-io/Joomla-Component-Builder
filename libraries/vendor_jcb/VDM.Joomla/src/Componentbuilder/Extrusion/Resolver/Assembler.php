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
use VDM\Joomla\Componentbuilder\Extrusion\Registry\Resolved;
use VDM\Joomla\Componentbuilder\Extrusion\Registry\Schema;
use VDM\Joomla\Componentbuilder\Extrusion\Registry\Source;
use VDM\Joomla\Componentbuilder\Extrusion\Registry\Table;


/**
 * Turns everything the readers gathered into one resolved definition set.
 * 
 * The assembler is the seam between reading and writing: it walks the tables the
 * schema and table-definition registries know about, asks the precedence engine
 * for each column, and then lets the role, tab, condition and relation resolvers
 * derive the structure around those fields. Writers read only what lands here, so
 * nothing downstream has to understand the source tree.
 * 
 * @since 6.1.6
 */
final class Assembler
{
	/**
	 * The Config Class.
	 *
	 * @var    Config
	 * @since  6.1.6
	 */
	protected Config $config;

	/**
	 * The Schema Registry.
	 *
	 * @var    Schema
	 * @since  6.1.6
	 */
	protected Schema $schema;

	/**
	 * The Table Registry.
	 *
	 * @var    Table
	 * @since  6.1.6
	 */
	protected Table $table;

	/**
	 * The Resolved Registry.
	 *
	 * @var    Resolved
	 * @since  6.1.6
	 */
	protected Resolved $resolved;

	/**
	 * The Source Registry.
	 *
	 * @var    Source
	 * @since  6.1.6
	 */
	protected Source $source;

	/**
	 * The Precedence Resolver.
	 *
	 * @var    Precedence
	 * @since  6.1.6
	 */
	protected Precedence $precedence;

	/**
	 * The ViewName Resolver.
	 *
	 * @var    ViewName
	 * @since  6.1.6
	 */
	protected ViewName $viewname;

	/**
	 * The Language Resolver.
	 *
	 * @var    Language
	 * @since  6.1.9
	 */
	protected Language $language;

	/**
	 * The Role Resolver.
	 *
	 * @var    Role
	 * @since  6.1.6
	 */
	protected Role $role;

	/**
	 * The Tab Resolver.
	 *
	 * @var    Tab
	 * @since  6.1.6
	 */
	protected Tab $tab;

	/**
	 * The Condition Resolver.
	 *
	 * @var    Condition
	 * @since  6.1.6
	 */
	protected Condition $condition;

	/**
	 * The Relation Resolver.
	 *
	 * @var    Relation
	 * @since  6.1.6
	 */
	protected Relation $relation;

	/**
	 * The Guid Resolver.
	 *
	 * @var    Guid
	 * @since  6.1.6
	 */
	protected Guid $guid;

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
	 * @param   Config      $config      The extrusion configuration.
	 * @param   Schema      $schema      The parsed schema registry.
	 * @param   Table       $table       The table definition registry.
	 * @param   Resolved    $resolved    The resolved definition registry.
	 * @param   Source      $source      The source identity registry.
	 * @param   Precedence  $precedence  The precedence engine.
	 * @param   ViewName    $viewname    The view name resolver.
	 * @param   Role        $role        The display role resolver.
	 * @param   Tab         $tab         The tab resolver.
	 * @param   Condition   $condition   The condition resolver.
	 * @param   Relation    $relation    The relationship resolver.
	 * @param   Guid        $guid        The identity resolver.
	 * @param   Report      $report      The run report registry.
	 *
	 * @since   6.1.6
	 */
	public function __construct(
		Config $config,
		Schema $schema,
		Table $table,
		Resolved $resolved,
		Source $source,
		Precedence $precedence,
		ViewName $viewname,
		Role $role,
		Tab $tab,
		Condition $condition,
		Relation $relation,
		Guid $guid,
		Report $report,
		Language $language
	)
	{
		$this->config = $config;
		$this->schema = $schema;
		$this->table = $table;
		$this->resolved = $resolved;
		$this->source = $source;
		$this->precedence = $precedence;
		$this->viewname = $viewname;
		$this->role = $role;
		$this->tab = $tab;
		$this->condition = $condition;
		$this->relation = $relation;
		$this->guid = $guid;
		$this->report = $report;
		$this->language = $language;
	}

	/**
	 * Assemble every selected table into the resolved registry.
	 *
	 * @return  int  The number of views assembled.
	 * @since   6.1.6
	 */
	public function assemble(): int
	{
		$views = [];

		foreach ($this->tables() as $canonical => $entry)
		{
			if (!$this->config->selected($entry['name']))
			{
				$this->report->set('skipped.filtered.' . $canonical, $entry['name']);

				continue;
			}

			$view = $this->viewname->single($entry['name']);

			if (in_array($view, $views, true))
			{
				$this->report->set('skipped.duplicate.' . $canonical, $entry['name']);

				continue;
			}

			if ($this->one($canonical, $entry, $view) !== null)
			{
				$views[] = $view;
			}
		}

		$this->resolved->set('views', $views);
		$this->reconcile($views);

		return count($views);
	}

	/**
	 * Every source table both registries know about.
	 *
	 * A schema names its tables in full while a table definition class is free to
	 * key the same table by the view it serves, which is what JCB itself does. The
	 * two therefore join on the canonical table identity where they can, and on
	 * the view name where they cannot, because a table that fails to join is not
	 * merely poorer: it becomes a second table competing for one view name.
	 *
	 * @return  array<string, array{name: string, schema: string, table: string}>  Canonical identity to its registry keys.
	 * @since   6.1.6
	 */
	public function tables(): array
	{
		$tables = [];

		foreach (['schema', 'table'] as $which)
		{
			$registry = $which === 'schema' ? $this->schema : $this->table;
			$block = $registry->get('table');

			if ($block === null)
			{
				continue;
			}

			foreach ((array) $block as $key => $entry)
			{
				$entry = (array) $entry;
				$name = (string) ($entry['name'] ?? $key);

				if ($name === '')
				{
					continue;
				}

				$canonical = $this->precedence->canonical($name);

				if ($canonical === '')
				{
					continue;
				}

				if ($which === 'table' && !isset($tables[$canonical]))
				{
					$canonical = $this->sameView($tables, $name) ?? $canonical;
				}

				if (!isset($tables[$canonical]))
				{
					$tables[$canonical] = ['name' => $name, 'schema' => '', 'table' => ''];
				}

				$tables[$canonical][$which] = (string) $key;

				if ($which === 'schema')
				{
					$tables[$canonical]['name'] = $name;
				}
			}
		}

		return $tables;
	}

	/**
	 * The single and list names a view is written with, and whether the source stated them.
	 *
	 * JCB keeps a view's names as the English a person reads -- "Address
	 * Type", "Address Types" -- and derives every code from them. A compiled
	 * component states those very names in its own language file, under the
	 * constants JCB itself writes them to, so where the language answers the
	 * names are the component's own. Where it does not, the table name is
	 * humanised the way a person would read it; that is a derivation, and
	 * the run says so, because a derived name must never overwrite the name
	 * a person gave a standing view.
	 *
	 * @param   array{name: string, schema: string, table: string}  $entry  The table's registry keys.
	 * @param   string                                             $view   The single view name.
	 *
	 * @return  array{0: string, 1: string, 2: bool}  The single name, the list name, and whether the language stated the single name.
	 * @since   6.1.9
	 */
	protected function names(array $entry, string $view): array
	{
		$listed = $this->listName($entry, $view);
		$prefix = $this->prefix();
		$single = $prefix === '' ? null : $this->language->stated($prefix . strtoupper($view));
		$list = $prefix === '' ? null : $this->language->stated($prefix . strtoupper($listed));

		return [
			$single ?? $this->viewname->title($view),
			$list ?? $this->viewname->title($listed),
			$single !== null
		];
	}

	/**
	 * The constant prefix the component's own language speaks.
	 *
	 * @return  string  The prefix, such as COM_EXAMPLE_, or an empty string when no component is named.
	 * @since   6.1.9
	 */
	protected function prefix(): string
	{
		$code = strtoupper(trim((string) preg_replace(
			'/^com_/i',
			'',
			trim((string) $this->source->get('code_name', ''))
		)));

		return $code === '' ? '' : 'COM_' . $code . '_';
	}

	/**
	 * The list view name for one table.
	 *
	 * The single name always comes from the table name with the component prefix
	 * removed, but the plural has no such source and is otherwise only ever an
	 * English guess. A JCB table definition class states the list name outright for
	 * every field it describes, so when that tier is present the guess is not needed
	 * and must not be preferred: a stated "people" would otherwise be overwritten
	 * with "persons". Which of the two answered is recorded, because a stated name
	 * that disagrees with the guess is the interesting case.
	 *
	 * @param   array{name: string, schema: string, table: string}  $entry  The table's registry keys.
	 * @param   string                                             $view   The single view name.
	 *
	 * @return  string  The plural view name.
	 * @since   6.1.6
	 */
	protected function listName(array $entry, string $view): string
	{
		$derived = $this->viewname->plural($view);
		$stated = $entry['table'] === ''
			? null
			: $this->table->get('table.' . $entry['table'] . '.listview');

		if (is_string($stated) && trim($stated) !== '')
		{
			$stated = strtolower(trim($stated));

			if ($stated !== $derived)
			{
				$this->report->set(
					'origin.name_list.' . $this->precedence->key($view),
					$stated . ' | ' . $derived
				);
			}

			return $stated;
		}

		// the access rules word every rule of a screen under the constant of
		// its list name, exactly as JCB writes them: a component compiled by
		// JCB states its list names there, table class or not
		$worded = $this->wordedList($view);

		if ($worded !== null)
		{
			if ($worded !== $derived)
			{
				$this->report->set(
					'origin.name_list.' . $this->precedence->key($view),
					$worded . ' | ' . $derived
				);
			}

			return $worded;
		}

		// nothing else states the plural, so the rule derives it -- but the
		// component's own administrator menu names the screens it offers, and a
		// list screen is one of them. A derived plural the menu never names is
		// a guess, and the run says so rather than settling it quietly
		$menu = array_map(
			'strtolower',
			array_keys((array) $this->source->get('menu', []))
		);

		if ($derived !== '' && $menu !== [] && !in_array($derived, $menu, true))
		{
			$this->report->set(
				'unconfirmed.name_list.' . $this->precedence->key($view),
				$derived
			);
		}

		return $derived;
	}

	/**
	 * The list name the access rules word a screen's rules under, when they do.
	 *
	 * JCB titles a screen's access rule `COM_<CODE>_<LIST>_ACCESS`, with the
	 * list name in the screen's own upper case: the rule is data the source
	 * states, and it names the list the screen has whatever a plural rule
	 * would have guessed.
	 *
	 * @param   string  $view  The screen's code name.
	 *
	 * @return  string|null  The list code the rules word, or null.
	 * @since   6.1.9
	 */
	protected function wordedList(string $view): ?string
	{
		$title = strtoupper(trim((string) $this->source->get(
			'access_titles.' . $this->precedence->key($view) . '.access',
			''
		)));
		$prefix = $this->prefix();

		if ($prefix === '' || $title === ''
			|| !str_starts_with($title, $prefix)
			|| !str_ends_with($title, '_ACCESS'))
		{
			return null;
		}

		$list = Text::code(substr($title, strlen($prefix), -strlen('_ACCESS')));

		return $list === '' ? null : $list;
	}

	/**
	 * The identity of an already collected table that serves the same view.
	 *
	 * @param   array<string, array{name: string, schema: string, table: string}>  $tables  The tables collected so far.
	 * @param   string                                                             $name    The raw table name to place.
	 *
	 * @return  string|null  The canonical identity to join, or null when none serves that view.
	 * @since   6.1.6
	 */
	protected function sameView(array $tables, string $name): ?string
	{
		$view = $this->viewname->single($name);

		if ($view === '')
		{
			return null;
		}

		foreach ($tables as $canonical => $entry)
		{
			if ($entry['table'] === '' && $this->viewname->single($entry['name']) === $view)
			{
				return $canonical;
			}
		}

		return null;
	}

	/**
	 * Assemble one table into a view definition.
	 *
	 * @param   string                                            $canonical  The canonical table identity.
	 * @param   array{name: string, schema: string, table: string}  $entry      The table's registry keys.
	 * @param   string                                            $view       The view name this table carries.
	 *
	 * @return  string|null  The view name, or null when nothing usable was found.
	 * @since   6.1.6
	 */
	protected function one(string $canonical, array $entry, string $view): ?string
	{
		$name = $entry['name'];
		$fields = [];
		$columns = [];

		foreach ($this->columns($entry) as $column)
		{
			// every column the table holds is remembered, the boilerplate
			// included: Joomla's own columns are the evidence for what a
			// view supports -- a table carrying checked_out checks in, one
			// carrying metakey has metadata -- and the component links say
			// exactly that about each view
			$columns[] = $column;

			if (!$this->config->extrudable($column))
			{
				continue;
			}

			$properties = $this->precedence->resolve($view, $entry, $column);

			if ($properties !== null)
			{
				$fields[$column] = $properties;
			}
		}

		if ($fields === [])
		{
			$this->report->set('skipped.empty.' . $canonical, $name);

			return null;
		}

		// every view JCB builds keeps its records by an id of their own, so a
		// table the schema declares without one is not a view's table: making
		// it one would give the component a screen it never had and add a
		// dozen columns to a table that carries none of them. A table only a
		// definition class describes says nothing either way -- such a class
		// names the view's own fields and never Joomla's columns
		if ($entry['schema'] !== ''
			&& !in_array('id', array_map('strtolower', $columns), true))
		{
			$this->report->set(
				'skipped.no_identity.' . $canonical,
				$name . ' has no id column, so it is not an admin view\'s table'
			);

			return null;
		}

		$path = 'view.' . $this->precedence->key($view);
		$this->resolved->set($path . '.columns', $columns);
		$tabs = $this->tab->names($view, $fields);
		$roles = $this->role->assign($view, $fields);
		$relations = [];

		foreach ($fields as $column => $properties)
		{
			$relation = $this->relation->resolve($view, $column, $properties);

			if ($relation !== null)
			{
				$relations[] = $relation;

				// The field carries the resolved relationship, not the raw table-map
				// link, so the writer that turns it into a custom field type sees the
				// target view name this run settled on rather than deriving its own.
				$properties['link'] = ['value' => $relation, 'origin' => 'table'];
			}

			$this->resolved->set(
				$path . '.field.' . $this->precedence->key($column),
				$properties
			);

			// a field sits on the tab its own form fieldset names, and stands
			// where the form lists it. Nothing else about the placement is
			// stated anywhere a component is obliged to state it, so the rest
			// is JCB's default and a person arranges it afterwards
			$this->resolved->set(
				$path . '.field.' . $this->precedence->key($column) . '.tab_index',
				$this->tab->index($this->tab->nameFor($view, $properties), $tabs)
			);
		}

		[$single, $list, $stated] = $this->names($entry, $view);
		$this->resolved->set($path . '.name_single', $single);
		$this->resolved->set($path . '.name_list', $list);
		$this->resolved->set($path . '.names_stated', $stated);
		// the codes every folder, form and constant speak, which the names
		// derive from -- kept beside the names so nothing has to guess them
		$this->resolved->set($path . '.name_single_code', $view);
		$this->resolved->set($path . '.name_list_code', $this->listName($entry, $view));
		$this->resolved->set($path . '.system_name', $this->viewname->title($view));
		$this->resolved->set($path . '.table', $name);
		$this->resolved->set($path . '.key', $canonical);
		$this->resolved->set(
			$path . '.table_options',
			(array) $this->schema->get(
				'table.' . (string) ($entry['schema'] ?? '') . '.option',
				[]
			)
		);
		$this->resolved->set($path . '.tabs', $tabs);
		$this->resolved->set($path . '.roles', $roles);
		$this->resolved->set($path . '.relations', $relations);
		$this->resolved->set(
			$path . '.conditions',
			array_values($this->condition->build($view, $fields))
		);
		$this->resolved->set(
			$path . '.guid',
			$this->guid->derive([$this->option(), 'admin_view', $name])
		);

		$seed = $entry['schema'] === ''
			? null
			: $this->schema->get('seed.' . $entry['schema'] . '.sql');

		if (is_string($seed) && $seed !== '')
		{
			$this->resolved->set($path . '.seed', $seed);
		}

		return $view;
	}

	/**
	 * Every column of one table, in declaration order where it is known.
	 *
	 * @param   array{name: string, schema: string, table: string}  $entry  The table's registry keys.
	 *
	 * @return  array<string>  The true column names, in declaration order.
	 * @since   6.1.6
	 */
	public function columns(array $entry): array
	{
		$columns = [];

		if ($entry['schema'] !== '')
		{
			$block = $this->schema->get('table.' . $entry['schema'] . '.column');

			foreach ((array) $block as $columnKey => $column)
			{
				$column = (array) $column;
				$columns[(string) ($column['name'] ?? $columnKey)] = (int) ($column['ordinal'] ?? 0);
			}
		}

		if ($entry['table'] !== '')
		{
			$fields = $this->table->get('table.' . $entry['table'] . '.field');
			$next = count($columns);

			foreach ((array) $fields as $fieldKey => $field)
			{
				$field = (array) $field;
				$name = (string) ($field['name'] ?? $fieldKey);

				if ($name !== '' && !isset($columns[$name]))
				{
					$columns[$name] = $next++;
				}
			}
		}

		asort($columns, SORT_NUMERIC);

		return array_keys($columns);
	}

	/**
	 * Mark which relationships point outside the assembled set.
	 *
	 * @param   array<string>  $views  Every assembled view name.
	 *
	 * @return  void
	 * @since   6.1.6
	 */
	protected function reconcile(array $views): void
	{
		foreach ($views as $view)
		{
			$path = 'view.' . $this->precedence->key($view) . '.relations';
			$relations = $this->resolved->get($path);

			if (!is_array($relations) || $relations === [])
			{
				continue;
			}

			$this->resolved->set($path, $this->relation->reconcile($relations, $views));
		}
	}

	/**
	 * The component option, when it is known.
	 *
	 * @return  string  The com_ prefixed option, or an empty string.
	 * @since   6.1.6
	 */
	protected function option(): string
	{
		return (string) $this->source->get('code_name', '');
	}
}

