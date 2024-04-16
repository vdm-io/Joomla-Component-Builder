<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    4th September, 2022
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler\Model;


use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Customcode\Dispenser;
use VDM\Joomla\Componentbuilder\Compiler\Builder\Router as Builder;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Utilities\JsonHelper;


/**
 * Model Component Site Router Class
 * 
 * @since 3.2.0
 */
class Router
{
	/**
	 * The Config Class.
	 *
	 * @var   Config
	 * @since 3.2.0
	 */
	protected Config $config;

	/**
	 * The Dispenser Class.
	 *
	 * @var   Dispenser
	 * @since 3.2.0
	 */
	protected Dispenser $dispenser;

	/**
	 * The Router Class.
	 *
	 * @var   Builder
	 * @since 3.2.0
	 */
	protected Builder $builder;

	/**
	 * The gui mapper array
	 *
	 * @var    array
	 * @since  3.2.0
	 */
	protected array $guiMapper = [
		'table' => 'component_router',
		'id' => null,
		'field' => null,
		'type'  => 'php'
	];

	/**
	 * The field targets
	 *
	 * @var    array
	 * @since  3.2.0
	 */
	protected array $targets = [
		'before' => 'constructor_before_parent',
		'after' => 'constructor_after_parent',
		'method' => 'methods'
	];

	/**
	 * Constructor.
	 *
	 * @param Config      $config      The Config Class.
	 * @param Dispenser   $dispenser   The Dispenser Class.
	 * @param Builder     $builder     The Router Class.
	 *
	 * @since 3.2.0
	 */
	public function __construct(Config $config, Dispenser $dispenser, Builder $builder)
	{
		$this->config = $config;
		$this->dispenser = $dispenser;
		$this->builder = $builder;
	}

	/**
	 * Set Router
	 *
	 * @param   object    $item   The item data
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function set(object &$item)
	{
		$this->config->lang_target = 'site';
		foreach ($this->targets  as $target)
		{
			// add the code
			if ($item->{"router_mode_{$target}"} == 3
				&& StringHelper::check($item->{"router_{$target}_code"}))
			{
				// update GUI mapper field
				$this->guiMapper['field'] = "{$target}_code";
				$this->dispenser->set(
					$item->{"router_{$target}_code"},
					"_site_router_",
					$target,
					null,
					$this->guiMapper
				);
			}
			unset($item->{"router_{$target}_code"});
		}

		// get the site views
		$views = $this->getSiteViews($item->site_views ?? [], $item->admin_views ?? []);
		$edit_views = $this->getSiteEditViews($item->admin_views);

		// get the edit site views
		$this->builder->set('views',
			ArrayHelper::merge([$views, $edit_views])
		);

		if ($item->router_mode_constructor_before_parent == 2
			&& JsonHelper::check($item->router_constructor_before_parent_manual))
		{
			// build and validate the constructor before parent call code
			$this->builder->set('manual',
				json_decode($item->router_constructor_before_parent_manual)
			);
		}

		// clear the data from the item
		foreach ($this->targets  as $key => $target)
		{
			// set the modes
			$this->builder->set("mode_{$key}",
				(int) $item->{"router_mode_{$target}"}
			);

			unset($item->{"router_mode_{$target}"});
		}

		unset($item->router_constructor_before_parent_manual);
	}

	/**
	 * Get the array of site views with additional details.
	 *
	 * This method processes each site view to enrich it with additional details such as the associated table,
	 * alias keys, and other relevant information. The enrichment is based on the view's settings and the admin views.
	 *
	 * @param array $siteViews   The site views to be processed.
	 * @param array $adminViews  The admin views used for fetching additional data.
	 *
	 * @return array An array of objects, each representing a site view with enriched details.
	 * @since 3.2.0
	 */
	protected function getSiteViews(array $siteViews, array $adminViews): array
	{
		return array_map(function ($view) use ($adminViews) {
			// Attempt to get the main selection details from the view's settings.
			$selection = $this->getMainSelection($view['settings']->main_get->main_get ?? null);

			// We can only work with ID if the [main get]  is a [getItem] dynamicGet for this site view.
			$key = ($view['settings']->main_get->gettype == 1) ? 'id' : null;
			$view_selected = $selection['view'] ?? null;
			$name_selected = $selection['name'] ?? null;

			// Construct the enriched view object.
			return (object) [
				'view' => $view['settings']->code,
				'View'  => $view['settings']->Code,
				'stable' => ($view_selected === $view['settings']->code), // sanity check
				'target_view' => $view_selected,
				'table' => $selection['table'] ?? null,
				'table_name' => $name_selected,
				'alias' => $this->getSiteViewAliasKey($name_selected, $adminViews),
				'key' => $key,
				'form' => false
			];
		}, $siteViews);
	}

	/**
	 * Get the array of site edit views
	 *
	 * This method processes the provided admin views to extract and return an array of site edit views.
	 * Each site edit view is constructed based on specific conditions from the admin view's settings.
	 *
	 * @param array|null $views The admin views to process.
	 *
	 * @return array An array of site edit views, each as an object with view, table, alias, key, and form properties.
	 * @since 3.2.0
	 */
	protected function getSiteEditViews(?array $views): array
	{
		$siteEditViews = [];

		// Return early if no views are provided.
		if (empty($views))
		{
			return $siteEditViews;
		}

		foreach ($views as $view)
		{
			// Check if the view is marked for edit/create on the site.
			if (!empty($view['edit_create_site_view']))
			{
				$siteEditViews[] = (object) [
					'view'  => $view['settings']->name_single_code,
					'View'  => StringHelper::safe($view['settings']->name_single_code, 'F'),
					'stable' => true,
					'target_view' => $view['settings']->name_single_code,
					'table' => '#__' . $this->config->component_code_name . '_' . $view['settings']->name_single_code,
					'alias' => $this->getSiteEditViewAliasKey($view['settings']->fields ?? null),
					'key'   => 'id',
					'form'  => true
				];
			}
		}

		return $siteEditViews;
	}

	/**
	 * Get the site edit view alias key value
	 *
	 * This method fetches the alias keys for a given site edit view by matching the view name
	 * against a list of admin views. It processes the admin views to find a match and then
	 * retrieves the alias keys from the matched view's settings.
	 *
	 * @param string|null $viewName   The view name to match.
	 * @param array       $adminViews The admin views to search within.
	 *
	 * @return string|null  The alias key for the site edit view, or null if not found.
	 * @since 3.2.0
	 */
	protected function getSiteViewAliasKey(?string $viewName, array $adminViews): ?string
	{
		// Return early if no view name is provided or admin views are empty.
		if ($viewName === null || empty($adminViews))
		{
			return null;
		}

		foreach ($adminViews as $view)
		{
			// Check if the current view matches the specified view name and has fields defined.
			if ($view['settings']->name_single_code === $viewName && is_array($view['settings']->fields ?? null))
			{
				// If a match is found, retrieve and return the site edit view alias keys.
				return $this->getSiteEditViewAliasKey($view['settings']->fields);
			}
		}

		// Return an empty array if no matching view is found.
		return null;
	}

	/**
	 * Get the site view alias key value
	 *
	 * @param   array|null    $fields   The main get object
	 *
	 * @return  string|null
	 * @since 3.2.0
	 */
	protected function getSiteEditViewAliasKey(?array $fields): ?string
	{
		if ($fields !== null)
		{
			foreach ($fields as $field)
			{
				if (isset($field['alias']) && $field['alias'] && $field['type_name'] === 'text')
				{
					return $field['base_name'];
				}
			}
		}

		return null;
	}

	/**
	 * Get the view (main selection) table and view name value
	 *   from the main get object
	 *
	 * @param   array|null    $gets   The main get objects
	 *
	 * @return  array
	 * @since 3.2.0
	 */
	protected function getMainSelection(?array $gets): array
	{
		if ($gets !== null)
		{
			foreach ($gets as $get)
			{
				// get the main table
				if (isset($get['as'])
					&& $get['as'] === 'a'
					&& isset($get['selection'])
					&& ArrayHelper::check($get['selection'])
					&& isset($get['selection']['select_gets'])
					&& ArrayHelper::check($get['selection']['select_gets'])
					&& isset($get['selection']['name']) && isset($get['selection']['table']))
				{
					$name = $get['selection']['name'];
					$view = $get['selection']['view'];
					$table = $get['selection']['table'];

					return ['table' => $table, 'view' => $view, 'name' => $name];
				}
			}
		}

		return [];
	}
}

