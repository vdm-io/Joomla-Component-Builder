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

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\Api\Plugin;


use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Placeholder;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\Api\Resources;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\Api\Controller\RecordId;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;


/**
 * The JSON:API route registration of the linked web services plugin
 * 
 * The compiler does not generate a plugin. A plugin of the webservices
 * group that the JCB user creates and links to the component carries one
 * of these placeholders, which the compiler fills for every resource of
 * the component (the admin views with an API, and the custom admin views
 * and site views the resources map names):
 * 
 *   [[API_ROUTES]]         the body of the route method, indented two
 *                            tabs after its first line, and
 *   [[API_ROUTES_METHOD]]  the whole onBeforeApiRoute() method, indented
 *                            one tab after its first line;
 * 
 * both are also accepted in their ##API_ROUTES## and
 * ##API_ROUTES_METHOD## form.
 * 
 * @since 6.1.7
 */
class Routes
{
	/**
	 * The Config Class.
	 *
	 * @var   Config
	 * @since 6.1.7
	 */
	protected Config $config;

	/**
	 * The Placeholder Class.
	 *
	 * @var   Placeholder
	 * @since 6.1.7
	 */
	protected Placeholder $placeholder;

	/**
	 * The Api Resources Class.
	 *
	 * @var   Resources
	 * @since 6.1.7
	 */
	protected Resources $resources;

	/**
	 * The Api Controller RecordId Class.
	 *
	 * @var   RecordId
	 * @since 6.1.7
	 */
	protected RecordId $recordid;

	/**
	 * Constructor.
	 *
	 * @param Config       $config       The Config Class.
	 * @param Placeholder  $placeholder  The Placeholder Class.
	 * @param Resources    $resources    The Api Resources Class.
	 * @param RecordId     $recordid     The Api Controller RecordId Class.
	 *
	 * @since 6.1.7
	 */
	public function __construct(Config $config, Placeholder $placeholder,
		Resources $resources, RecordId $recordid)
	{
		$this->config = $config;
		$this->placeholder = $placeholder;
		$this->resources = $resources;
		$this->recordid = $recordid;
	}

	/**
	 * Register the route placeholders the linked plugins may carry.
	 *
	 * @param   array  $views             The admin view links of the component, each an
	 *                                    array with its settings and the add_api option.
	 * @param   array  $customAdminViews  The custom admin view links of the component.
	 * @param   array  $siteViews         The site view links of the component.
	 *
	 * @return  void
	 * @since   6.1.7
	 */
	public function set(array $views, array $customAdminViews = [], array $siteViews = []): void
	{
		$this->placeholder->set('API_ROUTES', $this->get($views, $customAdminViews, $siteViews));
		$this->placeholder->set('API_ROUTES_METHOD', $this->getMethod($views, $customAdminViews, $siteViews));
	}

	/**
	 * Get the body of the route method.
	 *
	 * The first line carries no indentation, so the placeholder sits where
	 * the body starts; every following line is indented as a method body.
	 *
	 * @param   array  $views             The admin view links of the component.
	 * @param   array  $customAdminViews  The custom admin view links of the component.
	 * @param   array  $siteViews         The site view links of the component.
	 *
	 * @return  string  The route registration code.
	 * @since   6.1.7
	 */
	public function get(array $views, array $customAdminViews = [], array $siteViews = []): string
	{
		return $this->render($this->body($views, $customAdminViews, $siteViews), 2);
	}

	/**
	 * Get the whole route method of the plugin.
	 *
	 * The first line carries no indentation, so the placeholder sits where
	 * the method starts; every following line is indented as a class member.
	 * Joomla 4 gets the legacy router argument, Joomla 5 and up the event.
	 *
	 * @param   array  $views             The admin view links of the component.
	 * @param   array  $customAdminViews  The custom admin view links of the component.
	 * @param   array  $siteViews         The site view links of the component.
	 *
	 * @return  string  The route method code.
	 * @since   6.1.7
	 */
	public function getMethod(array $views, array $customAdminViews = [], array $siteViews = []): string
	{
		$component = 'com_' . $this->config->component_code_name;
		$legacy = $this->config->get('joomla_version', 3) < 5;

		$rows = [];
		$rows[] = [0, "/**"];
		$rows[] = [0, " * Register the JSON:API routes of {$component}."];
		$rows[] = [0, " *"];

		if ($legacy)
		{
			$rows[] = [0, " * @param   \\Joomla\\CMS\\Router\\ApiRouter  &\$router  The API router."];
		}
		else
		{
			$rows[] = [0, " * @param   \\Joomla\\CMS\\Event\\Application\\BeforeApiRouteEvent  \$event  The event."];
		}

		$rows[] = [0, " *"];
		$rows[] = [0, " * @return  void"];
		$rows[] = [0, " *"];
		$rows[] = [0, " * @since   " . ($legacy ? '4.0.0' : '5.0.0')];
		$rows[] = [0, " */"];

		if ($legacy)
		{
			$rows[] = [0, "public function onBeforeApiRoute(&\$router): void"];
			$rows[] = [0, "{"];
		}
		else
		{
			$rows[] = [0, "public function onBeforeApiRoute(\\Joomla\\CMS\\Event\\Application\\BeforeApiRouteEvent \$event): void"];
			$rows[] = [0, "{"];
			$rows[] = [1, "//" . Line::_(__LINE__, __CLASS__)
				. " Take the API router from the event."];
			$rows[] = [1, "\$router = \$event->getRouter();"];
			$rows[] = null;
		}

		foreach ($this->body($views, $customAdminViews, $siteViews) as $row)
		{
			$rows[] = ($row === null) ? null : [$row[0] + 1, $row[1]];
		}

		$rows[] = [0, "}"];

		return $this->render($rows, 1);
	}

	/**
	 * The rows of the route method body.
	 *
	 * @param   array  $views             The admin view links of the component.
	 * @param   array  $customAdminViews  The custom admin view links of the component.
	 * @param   array  $siteViews         The site view links of the component.
	 *
	 * @return  array  The rows, each an indentation level and a line, a
	 *                 blank line being null.
	 * @since   6.1.7
	 */
	private function body(array $views, array $customAdminViews, array $siteViews): array
	{
		$component = 'com_' . $this->config->component_code_name;
		$resources = [];
		$public = false;

		foreach ($this->resources->map($views, $customAdminViews, $siteViews) as $resource)
		{
			$rows = $this->resource($resource);

			if ($rows !== [])
			{
				$resources[] = $rows;
				$public = $public || $resource['public'];
			}
		}

		if ($resources === [])
		{
			return [[0, "//" . Line::_(__LINE__, __CLASS__)
				. " No view of {$component} has an API."]];
		}

		$rows = [];
		$rows[] = [0, "//" . Line::_(__LINE__, __CLASS__)
			. " Register the JSON:API routes of {$component}."];
		$rows[] = [0, "\$defaults = ['component' => '{$component}'];"];
		$rows[] = [0, "\$getDefaults = ['public' => false, 'component' => '{$component}'];"];

		if ($public)
		{
			$rows[] = [0, "\$publicDefaults = ['public' => true, 'component' => '{$component}'];"];
		}

		foreach ($resources as $resource)
		{
			$rows[] = null;

			foreach ($resource as $row)
			{
				$rows[] = $row;
			}
		}

		return $rows;
	}

	/**
	 * The rows registering the routes of one resource.
	 *
	 * An admin view answers on its list code, the list resource on the list
	 * controller and the item resource on the single controller by id and by
	 * every unique key. A custom admin view or site view answers on its API
	 * name, with the item resource by id and without one.
	 *
	 * @param   array  $resource  The resource, as the resources map names it.
	 *
	 * @return  array  The rows, none when the resource has no route.
	 * @since   6.1.7
	 */
	private function resource(array $resource): array
	{
		$name = $resource['name'];
		$path = 'v1/' . $this->config->component_code_name . '/' . $name;
		$reads = $resource['public'] ? '$publicDefaults' : '$getDefaults';
		$routes = [];

		if ($resource['area'] === Resources::AREA_ADMIN)
		{
			$single = (string) $resource['single'];

			if ($resource['list'])
			{
				$routes[] = $this->route('GET', $path, $name . '.displayList', null, $reads);
			}

			if ($resource['item'] && $single !== '')
			{
				// the field builders have not run yet, so the keys come from the view's fields
				$fields = $resource['settings']->fields ?? null;
				$keys = $this->recordid->keysOfFields(is_array($fields) ? $fields : []);

				$routes[] = $this->route('GET', $path . '/:id', $single . '.displayItem', 'id', $reads);

				foreach ($keys as $key)
				{
					$routes[] = $this->route('GET', $path . '/' . $key . '/:' . $key,
						$single . '.displayItem', $key, $reads);
				}

				$routes[] = $this->route('POST', $path, $single . '.add', null, '$defaults');
				$routes[] = $this->route('PATCH', $path . '/:id', $single . '.edit', 'id', '$defaults');

				foreach ($keys as $key)
				{
					$routes[] = $this->route('PATCH', $path . '/' . $key . '/:' . $key,
						$single . '.edit', $key, '$defaults');
				}

				$routes[] = $this->route('DELETE', $path . '/:id', $single . '.delete', 'id', '$defaults');

				foreach ($keys as $key)
				{
					$routes[] = $this->route('DELETE', $path . '/' . $key . '/:' . $key,
						$single . '.delete', $key, '$defaults');
				}
			}
		}
		else
		{
			if ($resource['list'])
			{
				$routes[] = $this->route('GET', $path, $name . '.displayList', null, $reads);
			}

			if ($resource['item'])
			{
				$routes[] = $this->route('GET', $path, $name . '.displayItem', null, $reads);
				$routes[] = $this->route('GET', $path . '/:id', $name . '.displayItem', 'id', $reads);
			}
		}

		if ($routes === [])
		{
			return [];
		}

		$rows = [];
		$rows[] = [0, "//" . Line::_(__LINE__, __CLASS__)
			. " The routes of the {$name} resource."];
		$rows[] = [0, "\$router->addRoutes(["];

		foreach ($routes as $route)
		{
			$rows[] = [1, $route];
		}

		$rows[] = [0, "]);"];

		return $rows;
	}

	/**
	 * One route construction.
	 *
	 * @param   string       $method    The HTTP method.
	 * @param   string       $path      The route pattern.
	 * @param   string       $task      The controller and task.
	 * @param   string|null  $key       The route variable, when the pattern has one.
	 * @param   string       $defaults  The variable carrying the route defaults.
	 *
	 * @return  string  The route construction code.
	 * @since   6.1.7
	 */
	private function route(string $method, string $path, string $task,
		?string $key, string $defaults): string
	{
		$rules = '[]';

		if ($key !== null)
		{
			$rules = "['{$key}' => '" . $this->rule($key) . "']";
		}

		return "new \\Joomla\\Router\\Route(['{$method}'], '{$path}', '{$task}', "
			. $rules . ", " . $defaults . "),";
	}

	/**
	 * The pattern of a route variable.
	 *
	 * The primary key is digits as in the core CRUD routes, the guid takes
	 * its 36 characters, any other unique key one path segment.
	 *
	 * @param   string  $key  The route variable.
	 *
	 * @return  string  The pattern.
	 * @since   6.1.7
	 */
	private function rule(string $key): string
	{
		if ($key === 'id')
		{
			return '(\\d+)';
		}

		if ($key === 'guid')
		{
			return '([0-9a-fA-F-]{36})';
		}

		return '([^/]+)';
	}

	/**
	 * Render rows as code whose first line carries no indentation.
	 *
	 * @param   array  $rows  The rows, each an indentation level and a line,
	 *                        a blank line being null.
	 * @param   int    $base  The indentation of the rows at level zero.
	 *
	 * @return  string  The code.
	 * @since   6.1.7
	 */
	private function render(array $rows, int $base): string
	{
		$code = '';
		$first = true;

		foreach ($rows as $row)
		{
			if ($row === null)
			{
				$code .= PHP_EOL;
				continue;
			}

			$code .= ($first ? '' : PHP_EOL . Indent::_($base + $row[0])) . $row[1];
			$first = false;
		}

		return $code;
	}
}

