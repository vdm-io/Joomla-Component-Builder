<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    24th August, 2026
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
use VDM\Joomla\Componentbuilder\Extrusion\Registry\View;
use VDM\Joomla\Componentbuilder\Extrusion\Resolver\Guid;
use VDM\Joomla\Componentbuilder\Extrusion\Resolver\Text;
use VDM\Joomla\Componentbuilder\Extrusion\Resolver\Delta;
use VDM\Joomla\Interfaces\Data\ItemInterface;
use VDM\Joomla\Componentbuilder\Extrusion\Abstraction\Writer;


/**
 * Writes the dynamic get every recovered front end and custom view feeds from.
 * 
 * In JCB a view without a dynamic get displays nothing: the main_get column is
 * the view's whole data source. A recovered view named after an admin view of
 * this same run gets the real relationship -- a back end source aimed at that
 * admin view, an item get for the single name and a list query for the plural.
 * A view no admin view answers for still gets its dynamic get, as a custom-get
 * scaffold that names the method the author completes; what it can never get
 * is nothing, because a view left without a source is a view left unrelated.
 * 
 * @since 6.1.8
 */
final class DynamicGet extends Writer
{
	/**
	 * The View Registry.
	 *
	 * @var    View
	 * @since  6.1.8
	 */
	protected View $view;

	/**
	 * The Guid Resolver.
	 *
	 * @var    Guid
	 * @since  6.1.8
	 */
	protected Guid $guid;

	/**
	 * The Source Registry.
	 *
	 * @var    Source
	 * @since  6.1.8
	 */
	protected Source $source;

	/**
	 * Constructor.
	 *
	 * @param   Config         $config     The extrusion configuration.
	 * @param   Resolved       $resolved   The resolved definition registry.
	 * @param   ItemInterface  $item       The JCB data item writer.
	 * @param   Report         $report     The run report registry.
	 * @param   Delta          $delta     The change weigher.
	 * @param   View           $view       The classified view registry.
	 * @param   Guid           $guid       The identity resolver.
	 * @param   Source         $source     The source identity registry.
	 *
	 * @since   6.1.8
	 */
	public function __construct(
		Config $config,
		Resolved $resolved,
		ItemInterface $item,
		Report $report,
		Delta $delta,
		View $view,
		Guid $guid,
		Source $source
	)
	{
		parent::__construct($config, $resolved, $item, $report, $delta);

		$this->view = $view;
		$this->guid = $guid;
		$this->source = $source;
	}

	/**
	 * The JCB table this writer persists into.
	 *
	 * @return  string  The table name without its prefix.
	 * @since   6.1.8
	 */
	protected function table(): string
	{
		return 'dynamic_get';
	}

	/**
	 * Write one dynamic get for every recovered view that needs a source.
	 *
	 * @return  int  The number of definitions written.
	 * @since   6.1.8
	 */
	public function write(): int
	{
		$written = 0;

		foreach (['site_view', 'custom_admin_view'] as $kind)
		{
			foreach ((array) $this->view->get($kind) as $key => $entry)
			{
				$entry = (array) $entry;
				$name = (string) ($entry['name'] ?? $key);

				if ($name === '')
				{
					continue;
				}

				$answered = $this->answered($name);

				// a custom candidate a table view answers for -- by a resolved
				// view's own single or list name, or by one of the component's
				// admin views already in the database -- is that view's own
				// generated output: no custom view and no get is owed
				if ($kind === 'custom_admin_view'
					&& ($answered !== null || !empty($entry['crud'])
						|| $this->dashboard($name)
						|| !$this->named($name)
						|| in_array(
							Text::code($name),
							(array) $this->resolved->get('existing.admin_view_names', []),
							true
						)))
				{
					continue;
				}

				if ($this->one($kind, (string) $key, $name, $answered))
				{
					$written++;
				}
			}
		}

		if ($written > 0)
		{
			$this->report->set('counts.dynamic_get', $written);
		}

		return $written;
	}

	/**
	 * Write one view's dynamic get and record it for the view to link.
	 *
	 * @param   string      $kind      The view kind the get belongs to.
	 * @param   string      $key       The view's registry key.
	 * @param   string      $name      The view's code name.
	 * @param   array|null  $answered  The admin view that answers, when one does.
	 *
	 * @return  bool  True when the definition was written.
	 * @since   6.1.8
	 */
	protected function one(string $kind, string $key, string $name, ?array $answered): bool
	{
		$guid = $this->guid->derive([$this->option(), 'dynamic_get', $name]);
		$readable = ucwords(str_replace(['_', '-'], ' ', $name));

		// a get that already stands is a person's own source, arranged and
		// pointed the way their screen needs it: a re-run only records where
		// it is, so the view keeps linking it, and rewrites none of it
		$id = $this->item->table($this->table())->value($guid, 'guid', 'id');

		if ($id !== null && (int) $id > 0)
		{
			$this->report->set('kept.dynamic_get.' . $guid, true);
			$this->resolved->set('dynamic_get.' . $kind . '.' . $this->key($key) . '.guid', $guid);

			return false;
		}

		$definition = new \stdClass();
		$definition->guid = $guid;
		$definition->name = $readable . ' Data';
		$definition->pagination = '1';
		$definition->published = 1;

		// every get JCB holds carries its containers, empty or not: the
		// compiler reads each of them and a record without them is a record
		// the interface cannot open on
		$definition->join_view_table = [];
		$definition->join_db_table = [];
		$definition->filter = [];
		$definition->where = [];
		$definition->order = [];
		$definition->group = [];
		$definition->global = [];

		if ($answered !== null)
		{
			// the real relationship: this view feeds from the admin view the
			// run itself wrote, item get for the single name, list query for
			// the plural -- exactly how JCB wires a front end to its table
			$definition->main_source = '1';
			$definition->gettype = (string) $answered['gettype'];
			$definition->view_table_main = (string) $answered['guid'];
			$definition->select_all = '1';
			$definition->view_selection = 'a.*';

			// an item get without this filter has no where clause at all, and
			// the generated getItem then answers with the first row of the
			// table for every id (Compiler\Dynamicget\QueryFilter writes the
			// clause from filter_type 1, and nothing else does)
			if ((int) $answered['gettype'] === 1)
			{
				$definition->filter = [
					'filter0' => [
						'filter_type' => '1',
						'state_key' => 'id',
						'operator' => '1',
						'table_key' => 'a.id'
					]
				];
			}

		}
		else
		{
			// nothing this component states can say what a screen without a
			// table of its own reads. Its model holds a query, but that query
			// is the author's code, not a record, and storing it would be
			// storing code -- so the get is created, connected and left for a
			// person to answer, which is the bare shape the screen needs
			$definition->main_source = '3';
			$definition->gettype = '1';

			$this->report->set(
				'dynamic_get.awaiting.' . $this->key($name),
				'no admin view answers for this view, so its get was created '
				. 'empty and awaits a query'
			);
		}

		// the get feeds one screen, so what it would change belongs on that screen's row
		if (!$this->store($definition, [], null, $this->row($kind, $name)))
		{
			return false;
		}

		$this->resolved->set('dynamic_get.' . $kind . '.' . $this->key($key) . '.guid', $guid);

		return true;
	}

	/**
	 * Whether a folder is the component's own dashboard rather than a screen.
	 *
	 * A component's dashboard lives in a folder named after the component
	 * itself. It is the component's front door, not a screen someone built, so
	 * it owes no custom view and no get -- and the writer that makes the views
	 * and the writer that makes their gets have to agree on that, or one of
	 * them leaves a get behind with nothing to belong to.
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
	 * The resolved admin view that answers for one view name, when one does.
	 *
	 * @param   string  $name  The recovered view's code name.
	 *
	 * @return  array{guid: string, gettype: int}|null  The source, or null.
	 * @since   6.1.8
	 */
	protected function answered(string $name): ?array
	{
		$name = Text::code($name);

		foreach ($this->views() as $view)
		{
			$path = $this->path($view);
			$single = Text::code((string) $this->resolved->get($path . '.name_single_code', $view));
			$list = Text::code((string) $this->resolved->get($path . '.name_list_code', $single . 's'));
			$written = (string) $this->resolved->get($path . '.written.view.guid', '');

			if ($written === '')
			{
				continue;
			}

			if ($name === $single || $name === strtolower($view))
			{
				return ['guid' => $written, 'gettype' => 1];
			}

			if ($name === $list)
			{
				return ['guid' => $written, 'gettype' => 2];
			}
		}

		return null;
	}

	/**
	 * The component option, when it is known.
	 *
	 * @return  string  The com_ prefixed option, or an empty string.
	 * @since   6.1.8
	 */
	protected function option(): string
	{
		return (string) $this->source->get('code_name', '');
	}
}

