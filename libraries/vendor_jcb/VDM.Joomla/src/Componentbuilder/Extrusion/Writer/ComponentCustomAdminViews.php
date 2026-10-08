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
use VDM\Joomla\Interfaces\Database\LoadInterface;
use VDM\Joomla\Componentbuilder\Extrusion\Resolver\Delta;
use VDM\Joomla\Interfaces\Data\ItemInterface;
use VDM\Joomla\Componentbuilder\Extrusion\Abstraction\Writer;


/**
 * Links every written custom admin view to the JCB component being built.
 * 
 * A custom admin view that belongs to no component is never compiled, so the
 * link is what puts the recovered screen back into the component's own
 * administrator. Every option the component_custom_admin_views form offers is
 * stated with its defaults, exactly as the admin and site links do.
 * 
 * @since 6.1.8
 */
final class ComponentCustomAdminViews extends Writer
{
	/**
	 * The Source Registry.
	 *
	 * @var    Source
	 * @since  6.1.8
	 */
	protected Source $source;

	/**
	 * The database load boundary.
	 *
	 * @var    LoadInterface
	 * @since  6.1.8
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
	 * @param   LoadInterface  $load      The database load boundary.
	 *
	 * @since   6.1.8
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
	 * @since   6.1.8
	 */
	protected function table(): string
	{
		return 'component_custom_admin_views';
	}

	/**
	 * The column this writer's table is keyed by.
	 *
	 * @return  string  The key column of this writer's table.
	 * @since   6.1.8
	 */
	protected function linkKey(): string
	{
		return 'joomla_component';
	}

	/**
	 * Link every written custom admin view to the target component.
	 *
	 * @return  int  The number of views linked.
	 * @since   6.1.8
	 */
	public function write(): int
	{
		$component = (int) $this->config->get('component', 0);
		$views = (array) $this->resolved->get('custom_admin_view', []);

		if ($views === [])
		{
			return 0;
		}

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
			$this->report->set('failed.component_custom_admin_views.no_component', true);

			return 0;
		}

		$subform = [];
		$number = 0;

		$menu = (array) $this->source->get('menu', []);

		foreach ($views as $key => $entry)
		{
			$entry = (array) $entry;
			$guid = (string) ($entry['guid'] ?? '');

			if ($guid === '')
			{
				continue;
			}

			$name = strtolower(trim((string) ($entry['name'] ?? $key)));
			$granted = (array) $this->source->get('access_screens_actions.' . $name, []);
			$rules = $granted !== [] || $menu !== [];

			// a checkbox this link does not carry is one that is off, which
			// is how JCB's own records hold them; the component's own menu
			// and access rules say which of these it switched on
			$row = ['customadminview' => $guid, 'icomoon' => '', 'before' => ''];

			foreach ([
				'mainmenu' => isset($menu[$name]),
				'dashboard_list' => isset($granted['dashboard_list']),
				'submenu' => isset($granted['submenu']),
				'access' => isset($granted['access'])
			] as $switch => $state)
			{
				if ($state || !$rules)
				{
					$row[$switch] = '1';
				}
			}

			$subform['addcustom_admin_views' . $number] = $row;
			$number++;
		}

		if ($subform === [])
		{
			return 0;
		}

		$definition = new \stdClass();
		$definition->joomla_component = $componentGuid;
		$definition->addcustom_admin_views = $this->merge($componentGuid, $subform);
		$definition->published = 1;

		$row = $this->componentRow((string) $this->source->get('code_name', ''));

		if (!$this->store($definition, [], null, $row))
		{
			return 0;
		}

		$this->report->set('counts.component_custom_admin_views', $number);

		return $number;
	}

	/**
	 * Merge the harvested view links into what the component already links.
	 *
	 * The existing rows are the person's own settings and are kept exactly as
	 * they stand; only screens the component does not yet link are appended.
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
			['a.addcustom_admin_views' => 'addcustom_admin_views'],
			['a' => 'component_custom_admin_views'],
			['a.joomla_component' => $componentGuid]
		);
		$existing = is_string($stored) ? json_decode($stored, true) : null;

		if (!is_array($existing) || $existing === [])
		{
			return $subform;
		}

		$linked = [];

		foreach ($existing as $row)
		{
			$view = strtolower(trim((string) (((array) $row)['customadminview'] ?? '')));

			if ($view !== '')
			{
				$linked[$view] = true;
			}
		}

		$merged = $existing;
		$number = 0;

		foreach ($subform as $row)
		{
			if (isset($linked[strtolower(trim((string) $row['customadminview']))]))
			{
				continue;
			}

			while (isset($merged['addcustom_admin_views' . $number]))
			{
				$number++;
			}

			$merged['addcustom_admin_views' . $number] = $row;
		}

		return $merged;
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

