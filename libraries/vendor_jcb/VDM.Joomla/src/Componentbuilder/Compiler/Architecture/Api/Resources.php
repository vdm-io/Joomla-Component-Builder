<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    2nd September, 2026
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\Api;


use VDM\Joomla\Componentbuilder\Compiler\Config;


/**
 * The API resources of a component and their names
 * 
 * Every admin view with the API option is a resource named by its list
 * code, and every custom admin view and site view of a component that
 * has such an admin API is a read-only resource named by its code. The
 * names are resolved in that order: an admin view reserves both of its
 * codes, a custom admin view that hits a reserved name is skipped with a
 * warning, and a site view that hits one takes the site_ prefix.
 * 
 * @since 6.1.7
 */
class Resources
{
	/**
	 * The admin view area.
	 *
	 * @var   string
	 * @since 6.1.7
	 */
	public const AREA_ADMIN = 'admin';

	/**
	 * The custom admin view area.
	 *
	 * @var   string
	 * @since 6.1.7
	 */
	public const AREA_CUSTOM_ADMIN = 'custom_admin';

	/**
	 * The site view area.
	 *
	 * @var   string
	 * @since 6.1.7
	 */
	public const AREA_SITE = 'site';

	/**
	 * The prefix a site view takes when its code is already an API name.
	 *
	 * @var   string
	 * @since 6.1.7
	 */
	public const SITE_PREFIX = 'site_';

	/**
	 * The Config Class.
	 *
	 * @var   Config
	 * @since 6.1.7
	 */
	protected Config $config;

	/**
	 * The resources of the last map, by area and view code.
	 *
	 * @var   array
	 * @since 6.1.7
	 */
	private array $map = [];

	/**
	 * The resources of the last map, in order.
	 *
	 * @var   array
	 * @since 6.1.7
	 */
	private array $entries = [];

	/**
	 * The warnings of the last map.
	 *
	 * @var   array
	 * @since 6.1.7
	 */
	private array $warnings = [];

	/**
	 * Whether a map was made.
	 *
	 * @var   bool
	 * @since 6.1.7
	 */
	private bool $mapped = false;

	/**
	 * Constructor.
	 *
	 * @param Config  $config  The Config Class.
	 *
	 * @since 6.1.7
	 */
	public function __construct(Config $config)
	{
		$this->config = $config;
	}

	/**
	 * Map the API resources of a component from its view links.
	 *
	 * Each entry carries: area, code (the view code), single (the admin
	 * single code, else null), name (the API name, also the JSON:API type
	 * and the path segment), item and list (which resources exist), public
	 * (token-free reads), access (the link asks for its access permission)
	 * and settings (the view settings object).
	 *
	 * @param   array  $adminViews        The admin view links.
	 * @param   array  $customAdminViews  The custom admin view links.
	 * @param   array  $siteViews         The site view links.
	 *
	 * @return  array  The resources in order.
	 * @since   6.1.7
	 */
	public function map(array $adminViews, array $customAdminViews = [], array $siteViews = []): array
	{
		$this->map = [];
		$this->entries = [];
		$this->warnings = [];
		$this->mapped = true;

		$reserved = [];
		$adminApi = false;

		foreach ($adminViews as $view)
		{
			$entry = $this->admin($view, $reserved);

			if ($entry === null)
			{
				continue;
			}

			$adminApi = true;
			$this->add($entry);
		}

		if (!$this->enabled($adminApi))
		{
			return $this->entries;
		}

		foreach ($customAdminViews as $view)
		{
			$entry = $this->dynamic($view, self::AREA_CUSTOM_ADMIN);

			if ($entry === null)
			{
				continue;
			}

			if (isset($reserved[$entry['name']]))
			{
				$this->warnings[] = sprintf(
					'<hr /><p>The custom admin view <b>%s</b> has the same name as the %s, so no API resource was built for it. Rename one of them; this is a serious collision.</p>',
					$entry['code'], $reserved[$entry['name']]
				);
				continue;
			}

			$reserved[$entry['name']] = 'custom admin view ' . $entry['code'];
			$this->add($entry);
		}

		foreach ($siteViews as $view)
		{
			$entry = $this->dynamic($view, self::AREA_SITE);

			if ($entry === null)
			{
				continue;
			}

			if (isset($reserved[$entry['name']]))
			{
				$entry['name'] = self::SITE_PREFIX . $entry['name'];
			}

			if (isset($reserved[$entry['name']]))
			{
				$this->warnings[] = sprintf(
					'<hr /><p>The site view <b>%s</b> could not get an API name: <b>%s</b> is taken by the %s. Rename one of them.</p>',
					$entry['code'], $entry['name'], $reserved[$entry['name']]
				);
				continue;
			}

			$reserved[$entry['name']] = 'site view ' . $entry['code'];
			$this->add($entry);
		}

		return $this->entries;
	}

	/**
	 * Get the resources of the last map, in order.
	 *
	 * @return  array
	 * @since   6.1.7
	 */
	public function all(): array
	{
		return $this->entries;
	}

	/**
	 * Get one resource of the last map.
	 *
	 * @param   string  $area  The area of the view.
	 * @param   string  $code  The view code.
	 *
	 * @return  array|null  The resource, null when the view has none.
	 * @since   6.1.7
	 */
	public function get(string $area, string $code): ?array
	{
		return $this->map[$area][$code] ?? null;
	}

	/**
	 * Get the API name of a view of the last map.
	 *
	 * @param   string  $area  The area of the view.
	 * @param   string  $code  The view code.
	 *
	 * @return  string|null  The name, null when the view has no resource.
	 * @since   6.1.7
	 */
	public function name(string $area, string $code): ?string
	{
		return $this->map[$area][$code]['name'] ?? null;
	}

	/**
	 * Whether a map was made.
	 *
	 * @return  bool
	 * @since   6.1.7
	 */
	public function mapped(): bool
	{
		return $this->mapped;
	}

	/**
	 * Get the warnings of the last map.
	 *
	 * @return  array
	 * @since   6.1.7
	 */
	public function warnings(): array
	{
		return $this->warnings;
	}

	/**
	 * Whether the custom admin views and site views get resources.
	 *
	 * The rule for now: whenever any admin view asks for an API. When the
	 * component links of the site views and custom admin views carry their
	 * own API option, the check moves to each link (see dynamic()) and this
	 * component-wide rule falls away.
	 *
	 * @param   bool  $adminApi  Whether any admin view asks for an API.
	 *
	 * @return  bool
	 * @since   6.1.7
	 */
	public function enabled(bool $adminApi): bool
	{
		return $adminApi;
	}

	/**
	 * The resource of an admin view link, reserving both of its codes.
	 *
	 * @param   mixed  $view      The admin view link.
	 * @param   array  $reserved  The reserved names, by name.
	 *
	 * @return  array|null  The resource, null when the view has no API.
	 * @since   6.1.7
	 */
	private function admin($view, array &$reserved): ?array
	{
		$settings = $this->settings($view);

		if ($settings === null)
		{
			return null;
		}

		$single = (string) ($settings->name_single_code ?? '');
		$list = (string) ($settings->name_list_code ?? '');

		foreach ([$single, $list] as $name)
		{
			if ($name !== '' && !isset($reserved[$name]))
			{
				$reserved[$name] = 'admin view ' . $name;
			}
		}

		$option = $this->option($view);

		if ($option === 0 || $list === '')
		{
			return null;
		}

		return [
			'area' => self::AREA_ADMIN,
			'code' => $single !== '' ? $single : $list,
			'single' => $single !== '' ? $single : null,
			'name' => $list,
			'item' => $option !== 1 && $single !== '' && ($settings->name_single ?? 'null') != 'null',
			'list' => $option !== 3 && ($settings->name_list ?? 'null') != 'null',
			'public' => false,
			'access' => false,
			'settings' => $settings,
		];
	}

	/**
	 * The resource of a custom admin view or site view link.
	 *
	 * @param   mixed   $view  The view link.
	 * @param   string  $area  The area of the view.
	 *
	 * @return  array|null  The resource, null when the view can have none.
	 * @since   6.1.7
	 */
	private function dynamic($view, string $area): ?array
	{
		$settings = $this->settings($view);

		if ($settings === null || !isset($settings->main_get) || !is_object($settings->main_get))
		{
			return null;
		}

		$get = $settings->main_get;
		$type = (int) ($get->gettype ?? 0);
		$code = (string) ($settings->code ?? '');

		// a custom SQL main get cannot be described, so it gets no resource
		if ($code === '' || !in_array($type, [1, 2], true) || (int) ($get->main_source ?? 0) === 3)
		{
			return null;
		}

		// the future per-link API option is checked here once the GUI carries it:
		// if (isset($view['add_api']) && (int) $view['add_api'] === 0) { return null; }

		return [
			'area' => $area,
			'code' => $code,
			'single' => null,
			'name' => $code,
			'item' => $type === 1,
			'list' => $type === 2,
			'public' => $area === self::AREA_SITE && (int) ($view['public_access'] ?? 0) === 1,
			'access' => (int) ($view['access'] ?? 0) === 1,
			'settings' => $settings,
		];
	}

	/**
	 * Keep a resource in the map.
	 *
	 * @param   array  $entry  The resource.
	 *
	 * @return  void
	 * @since   6.1.7
	 */
	private function add(array $entry): void
	{
		$this->entries[] = $entry;
		$this->map[$entry['area']][$entry['code']] = $entry;
	}

	/**
	 * The settings object of a view link.
	 *
	 * @param   mixed  $view  The view link.
	 *
	 * @return  object|null
	 * @since   6.1.7
	 */
	private function settings($view): ?object
	{
		if (!is_array($view) || !isset($view['settings']) || !is_object($view['settings']))
		{
			return null;
		}

		return $view['settings'];
	}

	/**
	 * The API option of an admin view link.
	 *
	 * @param   array  $view  The admin view link.
	 *
	 * @return  int  0 none, 1 list, 2 both, 3 item; 0 below Joomla 4.
	 * @since   6.1.7
	 */
	private function option(array $view): int
	{
		if ($this->config->get('joomla_version', 3) < 4 || !isset($view['add_api']))
		{
			return 0;
		}

		$option = (int) $view['add_api'];

		return in_array($option, [1, 2, 3], true) ? $option : 0;
	}
}

