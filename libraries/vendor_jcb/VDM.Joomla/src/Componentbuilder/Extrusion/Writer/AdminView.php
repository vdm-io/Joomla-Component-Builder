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

namespace VDM\Joomla\Componentbuilder\Extrusion\Writer;


use VDM\Joomla\Componentbuilder\Extrusion\Config;
use VDM\Joomla\Componentbuilder\Extrusion\Registry\Report;
use VDM\Joomla\Componentbuilder\Extrusion\Registry\Resolved;
use VDM\Joomla\Componentbuilder\Extrusion\Powers\Resolver\Placeholders;
use VDM\Joomla\Componentbuilder\Extrusion\Registry\Source;
use VDM\Joomla\Componentbuilder\Extrusion\Resolver\Actions;
use VDM\Joomla\Componentbuilder\Extrusion\Resolver\Guid;
use VDM\Joomla\Componentbuilder\Extrusion\Resolver\Pairing;
use VDM\Joomla\Componentbuilder\Extrusion\Resolver\Delta;
use VDM\Joomla\Componentbuilder\Extrusion\Resolver\Placeholder;
use VDM\Joomla\Interfaces\Data\ItemInterface;
use VDM\Joomla\Componentbuilder\Extrusion\Abstraction\Writer;


/**
 * Writes one JCB admin view definition per resolved table.
 * 
 * The seed data a source schema carried in its INSERT statements is passed
 * through raw, because the admin view's sql column declares base64 storage and
 * the Data pipeline applies it. Encoding here is exactly the mistake the legacy
 * extrusion helper makes.
 * 
 * @since 6.1.6
 */
final class AdminView extends Writer
{
	/**
	 * The permission actions a generated view is given.
	 *
	 * Each becomes one subform row of action and implementation, which is the
	 * only shape the admin_view form renders -- and 3 implements the action
	 * on both the record and the whole view, as JCB's own demo data does.
	 *
	 * @var    array<int, string>
	 * @since  6.1.6
	 */
	private const PERMISSIONS = [
		'view.edit', 'view.edit.own', 'view.edit.state', 'view.edit.access',
		'view.edit.created_by', 'view.edit.created', 'view.create',
		'view.delete', 'view.access'
	];

	/**
	 * The Guid Resolver.
	 *
	 * @var    Guid
	 * @since  6.1.6
	 */
	protected Guid $guid;

	/**
	 * The Permission Actions Resolver.
	 *
	 * @var    Actions
	 * @since  6.1.8
	 */
	protected Actions $actions;

	/**
	 * The Source Registry.
	 *
	 * @var    Source
	 * @since  6.1.6
	 */
	protected Source $source;

	/**
	 * The Pairing Resolver.
	 *
	 * @var    Pairing
	 * @since  6.1.7
	 */
	protected Pairing $pairing;

	/**
	 * The Placeholders Resolver.
	 *
	 * @var    Placeholders
	 * @since  6.1.9
	 */
	protected Placeholders $placeholders;

	/**
	 * The Placeholder Resolver.
	 *
	 * @var    Placeholder
	 * @since  6.2.0
	 */
	protected Placeholder $placeholder;

	/**
	 * Constructor.
	 *
	 * @param   Config         $config       The extrusion configuration.
	 * @param   Resolved       $resolved     The resolved definition registry.
	 * @param   ItemInterface  $item         The JCB data item writer.
	 * @param   Report         $report       The run report registry.
	 * @param   Delta          $delta        The change weigher.
	 * @param   Guid           $guid         The identity resolver.
	 * @param   Source         $source       The source identity registry.
	 * @param   Pairing        $pairing      The pairing resolver.
	 * @param   Actions        $actions      The permission actions resolver.
	 * @param   Placeholder    $placeholder  The placeholder expresser.
	 *
	 * @since   6.1.6
	 */
	public function __construct(
		Config $config,
		Resolved $resolved,
		ItemInterface $item,
		Report $report,
		Delta $delta,
		Guid $guid,
		Source $source,
		Pairing $pairing,
		Actions $actions,
		Placeholders $placeholders,
		Placeholder $placeholder
	)
	{
		parent::__construct($config, $resolved, $item, $report, $delta);

		$this->guid = $guid;
		$this->source = $source;
		$this->placeholders = $placeholders;
		$this->pairing = $pairing;
		$this->actions = $actions;
		$this->placeholder = $placeholder;
	}

	/**
	 * The JCB table this writer persists into.
	 *
	 * @return  string  The table name without its prefix.
	 * @since   6.1.6
	 */
	protected function table(): string
	{
		return 'admin_view';
	}

	/**
	 * Write every resolved admin view.
	 *
	 * @return  int  The number of definitions written.
	 * @since   6.1.6
	 */
	public function write(): int
	{
		$written = 0;

		foreach ($this->views() as $view)
		{
			if ($this->one($view))
			{
				$written++;
			}
		}

		$this->report->set('counts.admin_view', $written);

		return $written;
	}

	/**
	 * Write one resolved admin view.
	 *
	 * @param   string  $view  The view name.
	 *
	 * @return  bool  True when the definition was written.
	 * @since   6.1.6
	 */
	protected function one(string $view): bool
	{
		$path = $this->path($view);
		$single = (string) $this->resolved->get($path . '.name_single', $view);
		$system = (string) $this->resolved->get($path . '.system_name', $single);
		// the identity derives from the view's code, which is what the table
		// states and what every earlier run derived from
		$guid = (string) $this->resolved->get(
			$path . '.guid',
			$this->guid->derive([
				$this->option(), 'admin_view',
				(string) $this->resolved->get($path . '.name_single_code', $view)
			])
		);

		// the caller's pairing verdict outranks the derived identity
		$guid = $this->pairing->guid('admin_view', $this->key($view), $guid);

		if ($guid === null)
		{
			return false;
		}

		$seed = $this->resolved->get($path . '.seed');

		$definition = new \stdClass();
		$definition->guid = $guid;
		$definition->system_name = $system;
		$definition->name_single = $single;
		$definition->name_list = (string) $this->resolved->get($path . '.name_list', $single . 's');
		$definition->short_description = $system . ' (extruded)';
		$definition->description = $system . ' (extruded)';
		$definition->type = 1;
		$definition->add_fadein = 1;
		$definition->addpermissions = $this->permissions($single);
		$definition->addtabs = $this->tabs($path);
		$definition->published = 1;

		// the engine, character set, collation and row format a table runs on
		// are stated by the table itself; without them JCB falls back to its
		// own defaults and quietly rebuilds a modern table as MyISAM and utf8
		$options = (array) $this->resolved->get($path . '.table_options', []);

		foreach ($options as $option => $value)
		{
			$value = trim((string) $value);

			if ($value !== '')
			{
				$definition->{'mysql_table_' . $option} = $value;
			}
		}

		// a table stating its character set and no collation means, by MySQL's
		// own rule, that charset's default collation. Left unsaid here, JCB
		// pairs the stated charset with its own utf8 default instead, and
		// MySQL refuses the table outright (1253) -- so what the statement
		// means is written out
		if (trim((string) ($options['charset'] ?? '')) !== ''
			&& trim((string) ($options['collate'] ?? '')) === '')
		{
			$definition->mysql_table_collate =
				trim((string) $options['charset']) . '_general_ci';
		}

		if (is_string($seed) && $seed !== '')
		{
			$seed = $this->seed($guid, $seed);
		}

		if (is_string($seed) && $seed !== '')
		{
			$definition->add_sql = 1;
			$definition->source = 2;
			$definition->sql = $seed;
		}

		// the source states the view's seed data, and its names when its own
		// language states them; the rest is scaffolding a new view needs.
		// Someone who has since curated their tabs, permissions, description
		// or names keeps them: a re-run refreshes what the source says and
		// undoes none of their work -- a name the run merely derived from a
		// table name is a guess, and a guess never overwrites a person's name
		$kept = [
			'short_description', 'description', 'type', 'add_fadein',
			'addpermissions', 'addtabs', 'published'
		];

		if (!(bool) $this->resolved->get($path . '.names_stated', false))
		{
			$kept = array_merge($kept, ['system_name', 'name_single', 'name_list']);
		}

		if (!$this->store($definition, $kept, null, $this->row('admin_view', $view)))
		{
			return false;
		}

		$this->resolved->set($path . '.written.view.guid', $guid);

		return true;
	}

	/**
	 * The seed data to write for a view, or null when the standing view states it already.
	 *
	 * The source's seed data was compiled from the record's own, so the two
	 * differ only in what the compiler did to it: the whitespace a dump lays
	 * out, and the placeholders it resolved. A record that already states
	 * the same rows keeps its own text, line endings and placeholders and
	 * all; rows that changed are restated, naming the tables the way the
	 * person names them.
	 *
	 * @param   string  $guid  The view's identity.
	 * @param   string  $seed  The seed data the source states.
	 *
	 * @return  string|null  The seed data to write, or null to keep what stands.
	 * @since   6.1.9
	 */
	protected function seed(string $guid, string $seed): ?string
	{
		$standing = $this->item->table($this->table())->get($guid, 'guid');
		$held = is_object($standing) ? (string) ($standing->sql ?? '') : '';

		if (trim($held) === '')
		{
			return $this->express($guid, $seed);
		}

		$core = $this->placeholders->core();
		$resolved = $this->placeholders->substitute($held, $core + $this->placeholders->map());

		if (preg_replace('/\s+/', ' ', trim($resolved)) === preg_replace('/\s+/', ' ', trim($seed)))
		{
			$this->report->set('kept.seed.' . $guid, true);

			return null;
		}

		return $this->express($guid, $seed);
	}

	/**
	 * Seed data, naming the tables the way a person names them.
	 *
	 * The compiler wrote the component's own name into every table the seed
	 * touches, so seed data read back unchanged would carry that component's
	 * tables into whatever the view is used for next.
	 *
	 * @param   string  $guid  The view's identity.
	 * @param   string  $seed  The seed data the source states.
	 *
	 * @return  string  The seed data to write.
	 * @since   6.2.0
	 */
	protected function express(string $guid, string $seed): string
	{
		$expressed = $this->placeholder->reverse($seed);

		if ($expressed !== $seed)
		{
			$this->report->set('expressed.seed.' . $guid, true);
		}

		return $expressed;
	}

	/**
	 * The permission rows one view is given.
	 *
	 * A component states its permissions in access.xml, and states the level
	 * of each by where it puts it: the component section sets an action once
	 * for the whole component, a view's own section sets it per record, and an
	 * action in both is offered at both levels -- which is exactly what JCB
	 * stores. Only a source that ships no access rules falls back to the set a
	 * new view is given, because then nothing states anything else.
	 *
	 * @param   string  $view  The view's single name.
	 *
	 * @return  array<string, array<string, mixed>>  The permission subform.
	 * @since   6.1.8
	 */
	protected function permissions(string $view): array
	{
		$stated = $this->stated($view);
		$subform = [];
		$number = 0;

		foreach ($stated === [] ? $this->scaffold() : $stated as $action => $implementation)
		{
			$subform['addpermissions' . $number] = [
				'action' => $action,
				'implementation' => $implementation
			];
			$number++;
		}

		return $subform;
	}

	/**
	 * The permissions the component's own access rules state for one view.
	 *
	 * @param   string  $view  The view's single name.
	 *
	 * @return  array<string, int>  Action keyed to its implementation.
	 * @since   6.1.8
	 */
	protected function stated(string $view): array
	{
		$view = strtolower(trim($view));
		$own = $this->actions((array) $this->source->get('access.' . $view, []), $view, true);
		$component = $this->actions(
			(array) $this->source->get('access.component', []),
			$view,
			false
		);
		$stated = [];

		foreach ($component as $action)
		{
			$stated[$action] = 2;
		}

		foreach ($own as $action)
		{
			// an action the component sets globally and the view sets per
			// record is offered at both levels, which is what 3 means -- but
			// a core action is view level whatever else is stated, because
			// that is what the compiler makes of it
			$stated[$action] = str_starts_with($action, 'core.')
				? 1
				: (isset($stated[$action]) ? 3 : 1);
		}

		// a permission row names an action from the list JCB's own form offers.
		// Everything else the access rules carry -- batch, version, export and
		// import, the menu and dashboard actions -- the compiler writes from
		// the view's switches, and storing it here would leave a row nobody
		// can read, showing the first option in its place
		foreach (array_keys($stated) as $action)
		{
			if (!$this->actions->offers((string) $action))
			{
				unset($stated[$action]);
				$this->report->set(
					'permissions.generated.' . $this->key($view) . '.' . $this->key((string) $action),
					'the compiler writes this action from the view\'s own switches'
				);
			}
		}

		if ($stated !== [])
		{
			$this->report->set('permissions.' . $this->key($view), $stated);
		}

		return $stated;
	}

	/**
	 * The actions of one access section that belong to one view.
	 *
	 * An action named for the view is that view's own, and JCB stores it under
	 * the view prefix its compiler writes back. A core action is only a view's
	 * where the view's own section states it. Everything else in a section
	 * belongs to another view or to the component itself.
	 *
	 * @param   array<int, mixed>  $actions  The section's actions.
	 * @param   string             $view     The view's single name.
	 * @param   bool               $core     Whether core actions belong to this view.
	 *
	 * @return  array<int, string>  The actions, in the order they are stated.
	 * @since   6.1.8
	 */
	protected function actions(array $actions, string $view, bool $core): array
	{
		$found = [];

		foreach ($actions as $action)
		{
			$action = strtolower(trim((string) $action));

			if ($action === '')
			{
				continue;
			}

			if (str_starts_with($action, $view . '.'))
			{
				$found[] = 'view.' . substr($action, strlen($view) + 1);

				continue;
			}

			if ($core && str_starts_with($action, 'core.'))
			{
				$found[] = $action;
			}
		}

		return array_values(array_unique($found));
	}

	/**
	 * The permission rows a view is given where the source states none.
	 *
	 * @return  array<string, int>  Action keyed to its implementation.
	 * @since   6.1.8
	 */
	protected function scaffold(): array
	{
		$scaffold = [];

		foreach (self::PERMISSIONS as $action)
		{
			$scaffold[$action] = 3;
		}

		return $scaffold;
	}

	/**
	 * The tab subform a view's resolved tabs describe.
	 *
	 * @param   string  $path  The resolved registry path of the view.
	 *
	 * @return  array<string, array<string, mixed>>  The tab subform.
	 * @since   6.1.6
	 */
	protected function tabs(string $path): array
	{
		$tabs = $this->resolved->get($path . '.tabs', []);
		$subform = [];
		$number = 0;

		foreach ((array) $tabs as $name)
		{
			$subform['addtabs' . $number] = ['name' => (string) $name];
			$number++;
		}

		return $subform;
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

