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
use VDM\Joomla\Componentbuilder\Extrusion\Registry\Source;
use VDM\Joomla\Componentbuilder\Extrusion\Resolver\Text;
use VDM\Joomla\Componentbuilder\Extrusion\Resolver\Delta;
use VDM\Joomla\Interfaces\Data\ItemInterface;
use VDM\Joomla\Interfaces\Database\LoadInterface;
use VDM\Joomla\Componentbuilder\Extrusion\Abstraction\Writer;


/**
 * Links every written admin view to the JCB component being built.
 * 
 * Without this the extruded views exist but belong to nothing, which is the state
 * the run must never be left in. An update run merges with the links the
 * component already has rather than replacing them.
 * 
 * @since 6.1.6
 */
final class ComponentAdminViews extends Writer
{
	/**
	 * The Source Registry.
	 *
	 * @var    Source
	 * @since  6.1.6
	 */
	protected Source $source;

	/**
	 * The database load boundary.
	 *
	 * @var    LoadInterface
	 * @since  6.1.7
	 */
	protected LoadInterface $load;

	/**
	 * Constructor.
	 *
	 * @param   Config         $config    The extrusion configuration.
	 * @param   Resolved       $resolved  The resolved definition registry.
	 * @param   ItemInterface  $item      The JCB data item writer.
	 * @param   Report         $report    The run report registry.
	 * @param   Delta          $delta     The change weigher.
	 * @param   Source         $source    The source identity registry.
	 *
	 * @since   6.1.6
	 */
	public function __construct(
		Config $config,
		Resolved $resolved,
		ItemInterface $item,
		Report $report,
		Delta $delta,
		Source $source,
		LoadInterface $load
	)
	{
		parent::__construct($config, $resolved, $item, $report, $delta);

		$this->source = $source;
		$this->load = $load;
	}

	/**
	 * The JCB table this writer persists into.
	 *
	 * @return  string  The table name without its prefix.
	 * @since   6.1.6
	 */
	protected function table(): string
	{
		return 'component_admin_views';
	}

	/**
	 * The column this writer's table is keyed by.
	 *
	 * @return  string  The key column of this writer's table.
	 * @since   6.1.7
	 */
	protected function linkKey(): string
	{
		return 'joomla_component';
	}

	/**
	 * Link every written view to the target component.
	 *
	 * @return  int  The number of definitions written.
	 * @since   6.1.6
	 */
	public function write(): int
	{
		$component = (int) $this->config->get('component', 0);

		// the link column holds the component's guid -- the Table class
		// defines it as the joomla_component entity's guid key. A component
		// this run created recorded its guid; a targeted one resolves its
		// configured id to the identity the link speaks
		$componentGuid = trim((string) $this->resolved->get('component.guid', ''));

		if ($componentGuid === '' && $component > 0)
		{
			$componentGuid = trim((string) ($this->load->value(
				['a.guid' => 'guid'],
				['a' => 'joomla_component'],
				['a.id' => $component]
			) ?? ''));
		}

		if ($componentGuid === '')
		{
			$this->report->set('failed.component_admin_views.no_component', true);

			return 0;
		}

		$subform = [];
		$number = 0;

		foreach ($this->views() as $view)
		{
			$viewGuid = (string) $this->resolved->get(
				$this->path($view) . '.written.view.guid',
				''
			);

			if ($viewGuid === '')
			{
				continue;
			}

			$subform['addadmin_views' . $number] = $this->settings(
				$view,
				$viewGuid,
				$number + 1
			);
			$number++;
		}

		if ($subform === [])
		{
			return 0;
		}

		$definition = new \stdClass();
		$definition->joomla_component = $componentGuid;
		$definition->addadmin_views = $this->merge($componentGuid, $subform);
		$definition->published = 1;

		$row = $this->componentRow((string) $this->source->get('code_name', ''));

		if (!$this->store($definition, [], null, $row))
		{
			return 0;
		}

		$this->report->set('counts.component_admin_views', $number);

		return $number;
	}

	/**
	 * The link settings one view's own source states.
	 *
	 * Each switch on this link decides real structure, so each is read from
	 * the component itself rather than assumed. Joomla's own columns say what
	 * a view supports -- a table carrying checked_out and checked_out_time
	 * checks its records in, one carrying version keeps their history, one
	 * carrying metakey and metadesc has metadata, one carrying access has an
	 * access level -- and the manifest's administration menu says which views
	 * the component puts in its menu, and under what icon. Where the source
	 * says nothing, the form's own declared default stands, which is exactly
	 * what a person adding the link by hand would get.
	 *
	 * @param   string  $view      The view name.
	 * @param   string  $viewGuid  The written view's identity.
	 * @param   int     $order     The order this link takes.
	 *
	 * @return  array<string, mixed>  The link row.
	 * @since   6.1.8
	 */
	protected function settings(string $view, string $viewGuid, int $order): array
	{
		$columns = array_map(
			'strtolower',
			(array) $this->resolved->get($this->path($view) . '.columns', [])
		);
		$menu = (array) $this->source->get('menu', []);
		$single = Text::code((string) $this->resolved->get(
			$this->path($view) . '.name_single_code',
			$view
		));
		$list = Text::code((string) $this->resolved->get(
			$this->path($view) . '.name_list_code',
			$single . 's'
		));
		$entry = $menu[$list] ?? ($menu[$single] ?? null);
		$has = static fn (string ...$wanted): bool
			=> array_intersect($wanted, $columns) === $wanted;

		// the component's own access rules name a permission for every switch
		// that builds one -- the compiler writes view.version with history,
		// view.export and view.import with port, and the menu and dashboard
		// actions with their switches -- so the rules say which were on
		$granted = $this->granted($single);
		$rules = $granted !== [];

		$row = [
			'adminview' => $viewGuid,
			'icomoon' => (string) (($entry['icon'] ?? '') !== ''
				? $this->icon((string) $entry['icon']) : ''),
			'add_api' => '0',
			'filter' => '2',
			'edit_create_site_view' => '',
			'order' => (string) $order
		];

		// a switch this link does not carry is a switch that is off: JCB's
		// own records hold the checked ones only, and the compiler reads the
		// value as an integer, so an empty string in their place is refused
		return $row + $this->switches([
			// the manifest's own menu says which views it lists
			'mainmenu' => $entry !== null,
			'dashboard_list' => $rules
				? isset($granted['dashboard_list'])
				: $entry !== null,
			'dashboard_add' => $rules && isset($granted['dashboard_add']),
			'submenu' => $rules ? isset($granted['submenu']) : true,
			'checkin' => $has('checked_out', 'checked_out_time'),
			'history' => $has('version') || isset($granted['version']),
			'metadata' => $has('metakey', 'metadesc'),
			// the access rules name an access action for every view, whether or
			// not the view has an access level, so the column is the evidence
			'access' => $has('access'),
			// the port switch writes both halves of the pair
			// (Compiler\Creator\Permission::initPort), so one of them alone is
			// a button someone added, not import and export being switched on
			'port' => isset($granted['export']) && isset($granted['import'])
		]);
	}

	/**
	 * The permissions the component's access rules grant one view.
	 *
	 * Every action is returned under the part that follows the view's name,
	 * so a caller asks for the switch it is interested in rather than for the
	 * whole action.
	 *
	 * @param   string  $view  The view's single name.
	 *
	 * @return  array<string, bool>  The granted actions, keyed by their tail.
	 * @since   6.1.8
	 */
	protected function granted(string $view): array
	{
		$view = strtolower(trim($view));
		$granted = [];

		foreach (['component', $view] as $section)
		{
			foreach ((array) $this->source->get('access.' . $section, []) as $action)
			{
				$action = strtolower(trim((string) $action));

				if (str_starts_with($action, $view . '.'))
				{
					$granted[substr($action, strlen($view) + 1)] = true;
				}
			}
		}

		return $granted;
	}

	/**
	 * The checkbox switches of one link row, holding only those that are on.
	 *
	 * @param   array<string, bool>  $switches  Every switch and its state.
	 *
	 * @return  array<string, string>  The switches that are on.
	 * @since   6.1.8
	 */
	protected function switches(array $switches): array
	{
		$on = [];

		foreach ($switches as $name => $state)
		{
			if ($state)
			{
				$on[$name] = '1';
			}
		}

		return $on;
	}

	/**
	 * The icon slug a manifest menu entry names, when it names one plainly.
	 *
	 * A manifest states its icon as a Joomla image reference, which is not
	 * the icon set this link chooses from. Only the trailing token is worth
	 * carrying, and only when it reads as a plain slug; anything else is left
	 * for the person to choose, rather than written as a guess.
	 *
	 * @param   string  $icon  The manifest's stated icon.
	 *
	 * @return  string  The slug, or an empty string.
	 * @since   6.1.8
	 */
	protected function icon(string $icon): string
	{
		$slug = strtolower(trim((string) strrchr('/' . str_replace(
			['class:', '\\'],
			['', '/'],
			$icon
		), '/'), '/'));

		return preg_match('/^[a-z][a-z0-9\-]{1,30}$/', $slug) === 1 ? $slug : '';
	}

	/**
	 * Merge the harvested view links into what the component already links.
	 *
	 * The existing rows are the person's own settings -- the icons, dashboard
	 * and menu switches they chose per view -- and are kept exactly as they
	 * stand. A view already linked adds nothing; one the component does not
	 * yet link is appended, its order counted on from what already stands.
	 *
	 * @param   string                               $componentGuid  The component the links belong to.
	 * @param   array<string, array<string, mixed>>  $subform        The harvested view links.
	 *
	 * @return  array<string, array<string, mixed>>  The merged subform.
	 * @since   6.1.8
	 */
	protected function merge(string $componentGuid, array $subform): array
	{
		$stored = $this->load->value(
			['a.addadmin_views' => 'addadmin_views'],
			['a' => 'component_admin_views'],
			['a.joomla_component' => $componentGuid]
		);
		$existing = is_string($stored) ? json_decode($stored, true) : null;

		if (!is_array($existing) || $existing === [])
		{
			return $subform;
		}

		$linked = [];
		$order = 0;

		foreach ($existing as $row)
		{
			$row = (array) $row;
			$view = strtolower(trim((string) ($row['adminview'] ?? '')));

			if ($view !== '')
			{
				$linked[$view] = true;
			}

			$order = max($order, (int) ($row['order'] ?? 0));
		}

		$merged = $existing;
		$number = 0;

		foreach ($subform as $row)
		{
			if (isset($linked[strtolower(trim((string) $row['adminview']))]))
			{
				continue;
			}

			$row['order'] = (string) (++$order);

			while (isset($merged['addadmin_views' . $number]))
			{
				$number++;
			}

			$merged['addadmin_views' . $number] = $row;
		}

		return $merged;
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

