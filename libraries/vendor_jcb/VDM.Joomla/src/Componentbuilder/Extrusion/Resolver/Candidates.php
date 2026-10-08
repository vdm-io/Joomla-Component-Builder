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


use VDM\Joomla\Componentbuilder\Extrusion\Config;
use VDM\Joomla\Componentbuilder\Extrusion\Powers\Resolver\References;
use VDM\Joomla\Componentbuilder\Extrusion\Registry\Report;
use VDM\Joomla\Componentbuilder\Extrusion\Registry\Resolved;
use VDM\Joomla\Componentbuilder\Extrusion\Registry\Source;
use VDM\Joomla\Componentbuilder\Extrusion\Registry\View;
use VDM\Joomla\Interfaces\Database\LoadInterface;


/**
 * Turns one harvest into the candidate list a person approves.
 * 
 * Every resolved artifact becomes a candidate that carries exactly what the
 * pairing step needs: the key its verdict will be filed under, the identity
 * the writers would settle on when left alone, and the existing definition it
 * appears to match. The matching is by name against what the target component
 * already links, so a re-import of a known component arrives pre-paired as
 * updates and only what is genuinely new proposes itself as a creation.
 * 
 * The catalogue of existing definitions stands on its own, because the
 * interface asks for it again whenever the person points the run at another
 * component -- every proposed pairing then re-lines against that component's
 * own links.
 * 
 * @since 6.1.7
 */
final class Candidates
{
	/**
	 * The Config Class.
	 *
	 * @var    Config
	 * @since  6.1.7
	 */
	protected Config $config;

	/**
	 * The Resolved Registry.
	 *
	 * @var    Resolved
	 * @since  6.1.7
	 */
	protected Resolved $resolved;

	/**
	 * The Source Registry.
	 *
	 * @var    Source
	 * @since  6.1.7
	 */
	protected Source $source;

	/**
	 * The View Registry.
	 *
	 * @var    View
	 * @since  6.1.7
	 */
	protected View $view;

	/**
	 * The Database Loader.
	 *
	 * @var    LoadInterface
	 * @since  6.1.7
	 */
	protected LoadInterface $load;

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
	 * The selected-component Power graph used by the manual pairing pool.
	 *
	 * @var    References
	 * @since  6.2.0
	 */
	protected References $references;

	/**
	 * Constructor.
	 *
	 * @param   Config         $config    The extrusion configuration.
	 * @param   Resolved       $resolved  The resolved definition registry.
	 * @param   Source         $source    The source identity registry.
	 * @param   View           $view      The classified view registry.
	 * @param   LoadInterface  $load      The database loader.
	 * @param   Guid           $guid      The identity resolver.
	 * @param   Report         $report    The run report registry.
	 * @param   References     $references  The selected-component Power graph.
	 *
	 * @since   6.1.7
	 */
	public function __construct(
		Config $config,
		Resolved $resolved,
		Source $source,
		View $view,
		LoadInterface $load,
		Guid $guid,
		Report $report,
		References $references
	)
	{
		$this->config = $config;
		$this->resolved = $resolved;
		$this->source = $source;
		$this->view = $view;
		$this->load = $load;
		$this->guid = $guid;
		$this->report = $report;
		$this->references = $references;
	}

	/**
	 * Every candidate the harvest produced, paired against one component.
	 *
	 * @param   int         $componentId  The component whose links pair the candidates.
	 * @param   array|null  $catalogue    A catalogue already built for this component.
	 *
	 * @return  array<string, mixed>  Candidates by kind, each pre-paired by name.
	 * @since   6.1.7
	 */
	public function candidates(int $componentId, ?array $catalogue = null): array
	{
		$catalogue ??= $this->catalogue($componentId, '', false);

		return [
			'admin_view' => $this->adminViews($catalogue),
			'site_view' => $this->classified('site_view', $catalogue['site_views'], true),
			'custom_admin_view' => $this->customAdminViews(
				(array) $catalogue['custom_admin_views'],
				(array) $catalogue['admin_views']
			)
		];
	}

	/**
	 * Linked definitions and a selected-root or explicitly searched Power pool.
	 *
	 * @param   int     $componentId   The component id, or zero for none.
	 * @param   string  $powerSearch   An exact Power GUID, name or namespace search.
	 * @param   bool    $includePowers  Whether the caller consumes the Power pool.
	 *
	 * @return  array<string, mixed>  The catalogue of existing definitions.
	 * @since   6.1.7
	 */
	public function catalogue(int $componentId, string $powerSearch = '', bool $includePowers = true): array
	{
		$component = $componentId > 0 ? $this->component($componentId) : null;
		$guid = trim((string) ($component->guid ?? ''));
		$views = $guid !== ''
			? $this->linked('component_admin_views', 'addadmin_views', 'adminview', $guid)
			: [];
		$siteViews = $guid !== ''
			? $this->linked('component_site_views', 'addsite_views', 'siteview', $guid)
			: [];
		$customViews = $guid !== ''
			? $this->linked(
				'component_custom_admin_views',
				'addcustom_admin_views',
				'customadminview',
				$guid
			)
			: [];
		$powers = $includePowers ? $this->powerPool($componentId, $powerSearch)
			: ['items' => [], 'limit' => null, 'truncated' => false];

		return [
			'component' => $component,
			'admin_views' => $this->rows(
				'admin_view',
				[
					'a.guid' => 'guid',
					'a.name_single' => 'name',
					'a.name_list' => 'list',
					'a.system_name' => 'system'
				],
				$views
			),
			'fields' => $this->fields($views),
			'site_views' => $this->rows(
				'site_view',
				['a.guid' => 'guid', 'a.name' => 'name', 'a.system_name' => 'system'],
				$siteViews
			),
			'custom_admin_views' => $this->rows(
				'custom_admin_view',
				['a.guid' => 'guid', 'a.name' => 'name', 'a.system_name' => 'system'],
				$customViews
			),
			'powers' => $powers['items'],
			'power_search' => ['exact' => true, 'limit' => $powers['limit'], 'truncated' => $powers['truncated']]
		];
	}

	/**
	 * Read linked Powers or bounded indexed matches requested by the person.
	 *
	 * Empty input never enumerates the global Power table. Exact search remains
	 * available across component boundaries; selecting a row still goes through
	 * the identity resolver and the existing mutation-scope review rules.
	 *
	 * @param   int     $componentId  The selected component id.
	 * @param   string  $search       An exact GUID, class/system name or namespace.
	 *
	 * @return  array{items: array, limit: int|null, truncated: bool}  The display pool and its bounds.
	 * @since   6.2.0
	 */
	protected function powerPool(int $componentId, string $search): array
	{
		$select = ['a.id' => 'id', 'a.guid' => 'guid', 'a.system_name' => 'name', 'a.namespace' => 'namespace'];
		$search = trim($search);

		if ($search === '')
		{
			$guids = array_keys($this->references->context($componentId)['powers']);
			$items = [];

			foreach (array_chunk($guids, 200) as $batch)
			{
				array_push($items, ...$this->rows('power', $select, $batch));
			}

			return ['items' => $items, 'limit' => null, 'truncated' => false];
		}

		if (strlen($search) > 1020 || mb_strlen($search, 'UTF-8') > 255)
		{
			return ['items' => [], 'limit' => 100, 'truncated' => false];
		}

		$columns = $this->guid->valid(strtolower($search)) ? ['guid'] : ['name', 'namespace', 'system_name'];
		$items = [];
		$truncated = false;

		foreach ($columns as $column)
		{
			$rows = (array) $this->load->items($select, ['a' => 'power'],
				['a.' . $column => $column === 'guid' ? strtolower($search) : $search], ['a.id' => 'ASC'], 101);
			$truncated = $truncated || count($rows) > 100;

			foreach ($rows as $row)
			{
				$row = (array) $row;
				$items[(string) $row['id']] = $row;
			}
		}

		ksort($items, SORT_NUMERIC);

		return ['items' => array_slice(array_values($items), 0, 100), 'limit' => 100,
			'truncated' => $truncated || count($items) > 100];
	}

	/**
	 * The component the harvested source appears to be, by its code name.
	 *
	 * @return  object|null  The component row, or null when none answers.
	 * @since   6.1.7
	 */
	public function detect(): ?object
	{
		$code = trim((string) $this->source->get('code_name', ''));

		if ($code === '')
		{
			return null;
		}

		return $this->load->item(
			['a.id' => 'id', 'a.guid' => 'guid', 'a.system_name' => 'name', 'a.name_code' => 'code'],
			['a' => 'joomla_component'],
			['a.name_code' => str_replace('com_', '', strtolower($code))]
		);
	}

	/**
	 * Every published component, for the interface to offer as targets.
	 *
	 * @return  array<int, object>  The components, newest first.
	 * @since   6.1.7
	 */
	public function components(): array
	{
		$rows = $this->load->items(
			['a.id' => 'id', 'a.guid' => 'guid', 'a.system_name' => 'name', 'a.name_code' => 'code'],
			['a' => 'joomla_component'],
			['a.published' => 1],
			['a.modified' => 'DESC']
		);

		return is_array($rows) ? array_values($rows) : [];
	}

	/**
	 * One component row by id.
	 *
	 * @param   int  $componentId  The component id.
	 *
	 * @return  object|null  The component row, or null.
	 * @since   6.1.7
	 */
	protected function component(int $componentId): ?object
	{
		return $this->load->item(
			['a.id' => 'id', 'a.guid' => 'guid', 'a.system_name' => 'name', 'a.name_code' => 'code'],
			['a' => 'joomla_component'],
			['a.id' => $componentId]
		);
	}

	/**
	 * The admin view candidates, each carrying its field candidates.
	 *
	 * @param   array<string, mixed>  $catalogue  The existing definition catalogue.
	 *
	 * @return  array<int, array<string, mixed>>  The admin view candidates.
	 * @since   6.1.7
	 */
	protected function adminViews(array $catalogue): array
	{
		$candidates = [];
		$views = $this->resolved->get('views', []);

		foreach ((array) $views as $view)
		{
			if (!is_string($view) || $view === '')
			{
				continue;
			}

			$key = $this->key($view);
			$path = 'view.' . $key;
			$single = (string) $this->resolved->get($path . '.name_single', $view);
			$system = (string) $this->resolved->get($path . '.system_name', $single);
			// the identity derives from the view's code, which is what the
			// table states and what every earlier run derived from
			$derived = (string) $this->resolved->get(
				$path . '.guid',
				$this->guid->derive([
					$this->option(), 'admin_view',
					(string) $this->resolved->get($path . '.name_single_code', $view)
				])
			);
			// the component's link table is its own declaration of which views
			// belong to it, so a view answering to one of them by name is that
			// view rediscovered -- the record to update, never one to create
			$match = $this->matchByGuid($derived, (array) $catalogue['admin_views'])
				?? $this->scopedMatch([$single, $system], (array) $catalogue['admin_views']);

			$candidates[] = [
				'kind' => 'admin_view',
				'key' => $key,
				'label' => $single,
				'detail' => $system,
				'guid' => $derived,
				'match' => $match,
				'fields' => $this->fieldCandidates($view, $key, $path, $match, $catalogue)
			];
		}

		return $this->grouped($candidates);
	}

	/**
	 * Mark every owner row with the members that share its field.
	 *
	 * A shared member names its owner, and the board renders the group on the
	 * owner's row -- one field, and the views it serves -- so the owner has to
	 * know its members without the page re-deriving the grouping.
	 *
	 * @param   array<int, array<string, mixed>>  $candidates  The admin view candidates.
	 *
	 * @return  array<int, array<string, mixed>>  The candidates, owners marked.
	 * @since   6.1.9
	 */
	protected function grouped(array $candidates): array
	{
		$owners = [];

		foreach ($candidates as $viewIndex => $view)
		{
			foreach ((array) ($view['fields'] ?? []) as $fieldIndex => $field)
			{
				$owners[(string) ($field['key'] ?? '')] = [$viewIndex, $fieldIndex];
			}
		}

		foreach ($candidates as $view)
		{
			foreach ((array) ($view['fields'] ?? []) as $field)
			{
				$owner = (string) ($field['shared']['owner'] ?? '');

				if ($owner === '' || !isset($owners[$owner]))
				{
					continue;
				}

				[$viewIndex, $fieldIndex] = $owners[$owner];
				$candidates[$viewIndex]['fields'][$fieldIndex]['shared_by'][] = [
					'key' => (string) ($field['key'] ?? ''),
					'label' => (string) ($field['label'] ?? '')
				];
			}
		}

		return $candidates;
	}

	/**
	 * The field candidates of one resolved view.
	 *
	 * @param   string                     $view       The view name.
	 * @param   string                     $viewKey    The view's sanitised key.
	 * @param   string                     $path       The view's resolved registry path.
	 * @param   array<string, mixed>|null  $viewMatch  The view's own pairing, when found.
	 * @param   array<string, mixed>       $catalogue  The existing definition catalogue.
	 *
	 * @return  array<int, array<string, mixed>>  The field candidates.
	 * @since   6.1.7
	 */
	protected function fieldCandidates(
		string $view,
		string $viewKey,
		string $path,
		?array $viewMatch,
		array $catalogue
	): array
	{
		$candidates = [];
		$fields = (array) $this->resolved->get($path . '.field', []);

		// a field pairs first against the fields its paired view already
		// links, and then against every field JCB holds -- fields are shared
		// across components, so a name field that already stands anywhere in
		// the system is a match, never a field to create again
		$pool = (array) $catalogue['fields'];
		$scoped = $viewMatch !== null
			? array_values(array_filter(
				$pool,
				static fn ($row): bool => ((array) $row)['view'] === $viewMatch['guid']
			))
			: [];

		foreach ($fields as $key => $properties)
		{
			$properties = (array) $properties;
			$column = (string) $this->value($properties, 'name', (string) $key);

			if ($column === '')
			{
				continue;
			}

			$label = (string) $this->value($properties, 'label', $column);
			$derived = $this->guid->prefer(
				$this->value($properties, 'guid'),
				[$this->option(), 'field', $view, $column]
			);

			$candidate = [
				'kind' => 'field',
				'key' => $viewKey . '.' . $this->key($column),
				'label' => $label,
				'detail' => $column,
				'guid' => $derived
			];

			// a column whose stated identity another view already carries is
			// one field linked twice: the board shows it under its owner, so
			// this row carries the group instead of a pairing of its own --
			// a match here would only invite a verdict that detaches it
			$share = $this->resolved->get(
				$path . '.field.' . $this->key($column) . '.share'
			);

			if (is_array($share) && trim((string) ($share['guid'] ?? '')) !== '')
			{
				$candidate['match'] = null;
				$candidate['shared'] = [
					'guid' => trim((string) $share['guid']),
					'owner' => (string) ($share['owner'] ?? ''),
					'by' => (string) ($share['by'] ?? '')
				];
			}
			else
			{
				$candidate['match'] = $this->matchByGuid($derived, $pool)
					?? $this->scopedMatch([$label, $column], $scoped)
					?? $this->matchByName([$label, $column], $pool);
			}

			$candidates[] = $candidate;
		}

		return $candidates;
	}

	/**
	 * The custom admin view candidates, without the table views' own output.
	 *
	 * The code itself says which administrator folders belong to table views:
	 * an editor beside the template, or a resolved view whose name the folder
	 * answers to. Neither may appear as a custom admin view candidate -- a
	 * custom admin view with a table view's code name is a contradiction the
	 * board must never offer.
	 *
	 * @param   array<int, object|array>  $pool      The existing custom admin views.
	 * @param   array<int, object|array>  $existing  The component's own admin views.
	 *
	 * @return  array<int, array<string, mixed>>  The candidates.
	 * @since   6.1.8
	 */
	protected function customAdminViews(array $pool, array $existing): array
	{
		$candidates = [];

		foreach ((array) $this->view->get('custom_admin_view', []) as $key => $entry)
		{
			$entry = (array) $entry;
			$name = (string) ($entry['name'] ?? $key);

			if ($name === '' || !empty($entry['crud']) || $this->answered($name)
				|| $this->dashboard($name)
				|| $this->existingAnswers($name, $existing))
			{
				continue;
			}

			$derived = $this->guid->derive(
				[$this->option(), 'custom_admin_view', $name]
			);

			$candidates[] = [
				'kind' => 'custom_admin_view',
				'key' => $this->key($name),
				'label' => $name,
				'detail' => (string) ($entry['system_name'] ?? ''),
				'guid' => $derived,
				'match' => $this->matchByGuid($derived, $pool)
					?? $this->scopedMatch([$name], $pool)
			];
		}

		return $candidates;
	}

	/**
	 * Whether one screen is the component's own dashboard.
	 *
	 * The compiler writes the default dashboard into a folder named for the
	 * component itself, and JCB keeps that screen on the component record --
	 * its dashboard type and its dashboard -- never as a custom admin view.
	 *
	 * @param   string  $name  The folder's code name.
	 *
	 * @return  bool  True when the folder is the component's dashboard.
	 * @since   6.1.8
	 */
	protected function dashboard(string $name): bool
	{
		$code = strtolower(trim(str_replace('com_', '', $this->option())));

		return $code !== '' && strtolower(trim($name)) === $code;
	}

	/**
	 * Whether the component itself names one screen.
	 *
	 * A component names every screen it guards, in its access rules, and every
	 * screen it puts in a menu, in its manifest. A folder neither speaks for
	 * is generated output or something left behind, never a screen to offer.
	 *
	 * @param   string  $name  The folder's code name.
	 *
	 * @return  bool  True when the component names it.
	 * @since   6.1.8
	 */
	protected function named(string $name): bool
	{
		$name = strtolower(trim($name));
		$menu = (array) $this->source->get('menu', []);
		$screens = (array) $this->source->get('access_screens', []);

		if (isset($menu[$name]) || !empty($screens[$name]))
		{
			return true;
		}

		return $menu === [] && $screens === [];
	}

	/**
	 * Whether one of the component's own admin views answers for a folder name.
	 *
	 * The database is the ground truth for what the component already has: its
	 * linked admin views carry their real single and list names, exactly as
	 * the person named them. A folder that answers to either is that view's
	 * own territory, never a custom admin view -- no plural guessing, only
	 * the names the component itself gave.
	 *
	 * @param   string                    $name      The folder's code name.
	 * @param   array<int, object|array>  $existing  The component's own admin views.
	 *
	 * @return  bool  True when an existing admin view answers for it.
	 * @since   6.1.8
	 */
	protected function existingAnswers(string $name, array $existing): bool
	{
		$name = strtolower(trim($name));

		foreach ($existing as $row)
		{
			$row = (array) $row;

			foreach (['name', 'list'] as $field)
			{
				if ($name === strtolower(trim((string) ($row[$field] ?? ''))))
				{
					return true;
				}
			}
		}

		return false;
	}

	/**
	 * Whether a resolved table view answers for one administrator folder name.
	 *
	 * @param   string  $name  The folder's code name.
	 *
	 * @return  bool  True when an admin view of this run answers for it.
	 * @since   6.1.8
	 */
	protected function answered(string $name): bool
	{
		$name = strtolower(trim($name));

		foreach ((array) $this->resolved->get('views', []) as $view)
		{
			if (!is_string($view) || $view === '')
			{
				continue;
			}

			$path = 'view.' . $this->key($view);
			$single = Text::code((string) $this->resolved->get($path . '.name_single_code', $view));
			$list = Text::code((string) $this->resolved->get($path . '.name_list_code', $single . 's'));

			if ($name === $single || $name === $list || $name === Text::code($view))
			{
				return true;
			}
		}

		return false;
	}

	/**
	 * The candidates one classified view kind holds.
	 *
	 * @param   string                    $kind    The kind: site_view, layout, or template.
	 * @param   array<int, object|array>  $pool    The existing definitions to pair against.
	 * @param   bool                      $scoped  Whether the pool is the component's own links.
	 *
	 * @return  array<int, array<string, mixed>>  The candidates.
	 * @since   6.1.7
	 */
	protected function classified(string $kind, array $pool, bool $scoped = false): array
	{
		$candidates = [];
		$entries = (array) $this->view->get($kind, []);

		foreach ($entries as $key => $entry)
		{
			$entry = (array) $entry;
			$name = (string) ($entry['name'] ?? $key);

			if ($name === '')
			{
				continue;
			}

			$derived = $this->guid->derive([$this->option(), $kind, $name]);

			$candidates[] = [
				'kind' => $kind,
				'key' => $this->key($name),
				'label' => $name,
				'detail' => (string) ($entry['view'] ?? ''),
				'guid' => $derived,
				'match' => $this->matchByGuid($derived, $pool)
					?? ($scoped
						? $this->scopedMatch([$name], $pool)
						: $this->matchByName([$name], $pool))
			];
		}

		return $candidates;
	}

	/**
	 * A match inside what the component itself links is discovered identity.
	 *
	 * JCB's link tables are the component's own account of what belongs to
	 * it: the views its component_admin_views subform names, the site and
	 * custom views its own subforms name, the fields a view's admin_fields
	 * subform names. A candidate answering by name inside one of those sets
	 * IS that record rediscovered -- the thing to update. Creating a twin
	 * beside it would sever the component from its own definition.
	 *
	 * @param   array<string>             $names   The candidate's names, best first.
	 * @param   array<int, object|array>  $scoped  What the component itself links.
	 *
	 * @return  array{guid: string, label: string, by: string}|null  The pairing, or null.
	 * @since   6.1.8
	 */
	protected function scopedMatch(array $names, array $scoped): ?array
	{
		$match = $this->matchByName($names, $scoped);

		if ($match !== null)
		{
			$match['by'] = 'scoped';
		}

		return $match;
	}

	/**
	 * The existing definition that carries this very identity, when one does.
	 *
	 * Everything in JCB is linked by guid, so a guid in common IS the same
	 * definition -- the one certain ground for reuse.
	 *
	 * @param   string                    $guid  The candidate's identity.
	 * @param   array<int, object|array>  $pool  The existing definitions.
	 *
	 * @return  array{guid: string, label: string, by: string}|null  The pairing, or null.
	 * @since   6.1.8
	 */
	protected function matchByGuid(string $guid, array $pool): ?array
	{
		$guid = strtolower(trim($guid));

		if ($guid === '')
		{
			return null;
		}

		foreach ($pool as $row)
		{
			$row = (array) $row;

			if (strtolower(trim((string) ($row['guid'] ?? ''))) === $guid)
			{
				return [
					'guid' => $guid,
					'label' => (string) ($row['name'] ?? ($row['system'] ?? $guid)),
					'by' => 'guid'
				];
			}
		}

		return null;
	}

	/**
	 * The first existing definition one of the given names answers to.
	 *
	 * @param   array<string>             $names  The candidate's names, best first.
	 * @param   array<int, object|array>  $pool   The existing definitions.
	 *
	 * @return  array{guid: string, label: string, by: string}|null  The pairing, or null.
	 * @since   6.1.8
	 */
	protected function matchByName(array $names, array $pool): ?array
	{
		$names = array_values(array_filter(array_map(
			static fn ($name): string => strtolower(trim((string) $name)),
			$names
		), 'strlen'));

		if ($names === [])
		{
			return null;
		}

		foreach ($pool as $row)
		{
			$row = (array) $row;

			foreach (['name', 'system'] as $field)
			{
				$value = strtolower(trim((string) ($row[$field] ?? '')));

				if ($value !== '' && in_array($value, $names, true))
				{
					// a name in common is a suggestion, never an identity:
					// only a guid says two definitions are the same thing
					return [
						'guid' => (string) ($row['guid'] ?? ''),
						'label' => (string) ($row['name'] ?? ''),
						'by' => 'name'
					];
				}
			}
		}

		return null;
	}

	/**
	 * The guids one component-link subform holds.
	 *
	 * @param   string  $table   The linker table without its prefix.
	 * @param   string  $column  The subform column.
	 * @param   string  $field   The subform field carrying the guid.
	 * @param   string  $guid    The component identity.
	 *
	 * @return  array<string>  The linked guids.
	 * @since   6.1.7
	 */
	protected function linked(string $table, string $column, string $field, string $guid): array
	{
		$stored = $this->load->value(
			['a.' . $column => $column],
			['a' => $table],
			['a.joomla_component' => $guid]
		);

		if (!is_string($stored) || trim($stored) === '')
		{
			return [];
		}

		$rows = json_decode($stored, true);

		if (!is_array($rows))
		{
			return [];
		}

		$guids = [];

		foreach ($rows as $row)
		{
			$value = trim((string) (((array) $row)[$field] ?? ''));

			if ($this->guid->valid($value))
			{
				$guids[] = strtolower($value);
			}
		}

		return array_values(array_unique($guids));
	}

	/**
	 * One standing field, with every column its properties hash speaks for.
	 *
	 * The lean pool answers who stands where; this answers what one of them
	 * actually is, so a lookalike can be proven the same field -- or not --
	 * by its stored properties rather than by its name.
	 *
	 * @param   string  $guid  The field's identity.
	 *
	 * @return  array<string, mixed>|null  The full row, or null when none stands.
	 * @since   6.1.9
	 */
	public function field(string $guid): ?array
	{
		$guid = strtolower(trim($guid));

		if (!$this->guid->valid($guid))
		{
			return null;
		}

		$row = $this->load->item(
			[
				'a.guid' => 'guid',
				'a.name' => 'name',
				'a.fieldtype' => 'fieldtype',
				'a.datatype' => 'datatype',
				'a.datalenght' => 'datalenght',
				'a.datalenght_other' => 'datalenght_other',
				'a.datadefault' => 'datadefault',
				'a.datadefault_other' => 'datadefault_other',
				'a.indexes' => 'indexes',
				'a.null_switch' => 'null_switch',
				'a.store' => 'store',
				'a.xml' => 'xml'
			],
			['a' => 'field'],
			['a.guid' => $guid]
		);

		return $row === null ? null : (array) $row;
	}

	/**
	 * The fields the given admin views already link, each carrying its view.
	 *
	 * @param   array<string>  $views  The admin view guids.
	 *
	 * @return  array<int, array{guid: string, name: string, view: string}>  The fields.
	 * @since   6.1.7
	 */
	protected function fields(array $views): array
	{
		// JCB fields are shared across components, so the whole field table is
		// the pool a harvested field can match in -- a name field that already
		// stands in JCB must be found whether or not any view matched. The
		// view marks below only say which matches the paired view already links.
		$pool = $this->rows('field', ['a.guid' => 'guid', 'a.name' => 'name']);

		foreach ($pool as &$row)
		{
			$row['view'] = '';
		}

		unset($row);

		if ($views === [])
		{
			return $pool;
		}

		$links = $this->load->items(
			['a.admin_view' => 'view', 'a.addfields' => 'fields'],
			['a' => 'admin_fields'],
			['a.admin_view' => ['operator' => 'IN', 'value' => $views]]
		);

		if (!is_array($links))
		{
			return $pool;
		}

		$byField = [];

		foreach ($links as $link)
		{
			$link = (array) $link;
			$view = strtolower(trim((string) ($link['view'] ?? '')));
			$rows = json_decode((string) ($link['fields'] ?? ''), true);

			if ($view === '' || !is_array($rows))
			{
				continue;
			}

			foreach ($rows as $row)
			{
				$field = trim((string) (((array) $row)['field'] ?? ''));

				if ($this->guid->valid($field))
				{
					$byField[strtolower($field)][$view] = true;
				}
			}
		}

		if ($byField === [])
		{
			return $pool;
		}

		foreach ($pool as &$row)
		{
			// a shared field is linked by several views, and every one of
			// them is its home -- the single mark stays for the board, the
			// full list is what recognition walks
			$views = array_keys($byField[strtolower((string) $row['guid'])] ?? []);
			$row['view'] = $views === [] ? '' : end($views);
			$row['views'] = $views;
		}

		unset($row);

		return $pool;
	}

	/**
	 * Rows of one definition table, optionally narrowed to given guids.
	 *
	 * @param   string                 $table   The table without its prefix.
	 * @param   array<string, string>  $select  The columns to select.
	 * @param   array<string>|null     $guids   The guids to narrow to, or null for all.
	 *
	 * @return  array<int, array<string, mixed>>  The rows.
	 * @since   6.1.7
	 */
	protected function rows(string $table, array $select, ?array $guids = null): array
	{
		if ($guids !== null && $guids === [])
		{
			return [];
		}

		$where = $guids === null
			? null
			: ['a.guid' => ['operator' => 'IN', 'value' => $guids]];
		$rows = $this->load->items($select, ['a' => $table], $where);

		if (!is_array($rows))
		{
			return [];
		}

		return array_map(
			static fn ($row): array => (array) $row,
			array_values($rows)
		);
	}

	/**
	 * The value of one resolved field property.
	 *
	 * @param   array<string, mixed>  $properties  The resolved properties.
	 * @param   string                $property    The property name.
	 * @param   mixed                 $default     A value to use when unresolved.
	 *
	 * @return  mixed  The resolved value, or the default.
	 * @since   6.1.7
	 */
	protected function value(array $properties, string $property, $default = null)
	{
		$entry = $properties[$property] ?? null;

		if (!is_array($entry) && !is_object($entry))
		{
			return $default;
		}

		$entry = (array) $entry;
		$value = $entry['value'] ?? null;

		return $value === null || $value === '' ? $default : $value;
	}

	/**
	 * The component option, when it is known.
	 *
	 * @return  string  The com_ prefixed option, or an empty string.
	 * @since   6.1.7
	 */
	protected function option(): string
	{
		return (string) $this->source->get('code_name', '');
	}

	/**
	 * Sanitise one registry path segment.
	 *
	 * @param   string  $segment  The raw segment.
	 *
	 * @return  string  A segment safe to use in a dotted registry path.
	 * @since   6.1.7
	 */
	protected function key(string $segment): string
	{
		return preg_replace('/[^A-Za-z0-9_]/', '_', $segment) ?? $segment;
	}
}

