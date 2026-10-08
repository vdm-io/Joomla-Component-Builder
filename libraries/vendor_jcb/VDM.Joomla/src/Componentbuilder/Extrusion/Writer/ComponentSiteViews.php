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
use VDM\Joomla\Interfaces\Database\LoadInterface;
use VDM\Joomla\Componentbuilder\Extrusion\Resolver\Delta;
use VDM\Joomla\Interfaces\Data\ItemInterface;
use VDM\Joomla\Componentbuilder\Extrusion\Abstraction\Writer;


/**
 * Links every written site view to the JCB component being built.
 * 
 * A site view that belongs to no component exists but is compiled into nothing, so
 * this is what makes the front end half of the run mean anything. It mirrors the
 * admin link exactly, because the two tables differ only in which view they name.
 * 
 * @since 6.1.6
 */
final class ComponentSiteViews extends Writer
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
		return 'component_site_views';
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
	 * Link every written site view to the target component.
	 *
	 * @return  int  The number of views linked.
	 * @since   6.1.6
	 */
	public function write(): int
	{
		$component = (int) $this->config->get('component', 0);
		$views = (array) $this->resolved->get('site_view', []);

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
			$this->report->set('failed.component_site_views.no_component', true);

			return 0;
		}

		$subform = [];
		$number = 0;

		foreach ($views as $entry)
		{
			$guid = (string) (((array) $entry)['guid'] ?? '');

			if ($guid === '')
			{
				continue;
			}

			// The first view found is offered as the component's default, because a
			// component with no default front end view has no reachable front end at
			// all. Which one it should really be is a decision only the author can
			// make, so it is recorded rather than left implicit.
			// the form's own declared defaults for a link a person adds by
			// hand: the view is in the menu, carries metadata and an access
			// level. A checkbox this link does not carry is one that is off,
			// which is how JCB's own records hold them
			$row = [
				'siteview' => $guid,
				'menu' => '1',
				'metadata' => '1',
				'access' => '1'
			];

			// a checkbox this link does not carry is one that is off, which
			// is how JCB's own records hold them
			if ($number === 0)
			{
				$row['default_view'] = '1';
			}

			$subform['addsite_views' . $number] = $row;
			$number++;
		}

		if ($subform === [])
		{
			return 0;
		}

		$definition = new \stdClass();
		$definition->joomla_component = $componentGuid;
		$definition->addsite_views = $this->merge($componentGuid, $subform);
		$definition->published = 1;

		$row = $this->componentRow((string) $this->source->get('code_name', ''));

		if (!$this->store($definition, [], null, $row))
		{
			return 0;
		}

		$this->report->set('counts.component_site_views', $number);
		$this->report->set(
			'site_view.default',
			(string) (((array) reset($views))['name'] ?? '')
		);

		return $number;
	}

	/**
	 * Merge the harvested view links into what the component already links.
	 *
	 * The existing rows are the person's own settings and are kept exactly as
	 * they stand -- the default front end view among them, so an appended view
	 * never claims a default the component already gave to another.
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
			['a.addsite_views' => 'addsite_views'],
			['a' => 'component_site_views'],
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
			$view = strtolower(trim((string) (((array) $row)['siteview'] ?? '')));

			if ($view !== '')
			{
				$linked[$view] = true;
			}
		}

		$merged = $existing;
		$number = 0;

		foreach ($subform as $row)
		{
			if (isset($linked[strtolower(trim((string) $row['siteview']))]))
			{
				continue;
			}

			$row['default_view'] = '';

			while (isset($merged['addsite_views' . $number]))
			{
				$number++;
			}

			$merged['addsite_views' . $number] = $row;
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

