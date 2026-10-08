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

namespace VDM\Joomla\Componentbuilder\Extrusion\Discovery\Locator;


use VDM\Joomla\Componentbuilder\Extrusion\Abstraction\Locator;


/**
 * Finds and classifies the component's templates and layouts.
 * 
 * The placement map decides what a file is: a layouts folder holds layouts, a
 * view's template folder holds templates, and the main default file is the
 * view's own template rather than a reusable one. Two things the map cannot
 * settle -- list against edit, and admin against custom admin -- are left to the
 * resolver, so this locator only reports what it can prove.
 * 
 * @since 6.1.6
 */
final class View extends Locator
{
	/**
	 * The artifact kind this locator is responsible for.
	 *
	 * @return  string  The artifact kind key.
	 * @since   6.1.6
	 */
	public function kind(): string
	{
		return 'view';
	}

	/**
	 * The file extensions this locator's artifact uses.
	 *
	 * @return  array<string>  Lower-case extensions without the dot.
	 * @since   6.1.6
	 */
	protected function extensions(): array
	{
		return ['php'];
	}

	/**
	 * Locate every template and layout below a source root.
	 *
	 * @param   string  $root  The resolved source root.
	 *
	 * @return  array<int, array{path: string, tier: string, name: string|null}>  Located artifacts.
	 * @since   6.1.6
	 */
	public function locate(string $root): array
	{
		$found = [];
		$only = $this->scope();

		foreach ($this->kinds('layouts', 'site_layouts', $only) as $kind => $scope)
		{
			foreach ($this->mapped($root, $kind) as $directory)
			{
				foreach ($this->php($root, $directory) as $path)
				{
					if (isset($found[$path]))
					{
						continue;
					}

					$found[$path] = $this->entry($path, 'map', $this->name($path));
					$found[$path]['role'] = 'layout';
					$found[$path]['scope'] = $scope;
				}
			}
		}

		foreach ($this->kinds('tmpl_dir', 'site_tmpl_dir', $only) as $kind => $scope)
		{
			foreach ($this->mapped($root, $kind) as $directory)
			{
				foreach ($this->templates($root, $directory) as $path => $says)
				{
					if (isset($found[$path]))
					{
						continue;
					}

					$found[$path] = $this->entry($path, 'map', $this->name($path));
					$found[$path]['role'] = $says['role'];
					$found[$path]['scope'] = $scope;
					$found[$path]['view'] = $says['view'];
				}
			}
		}

		// a screen its component states with a class of its own is a screen,
		// whether or not a template was laid out for it
		foreach ($this->kinds('view_dir', 'site_view_dir', $only) as $kind => $scope)
		{
			foreach ($this->mapped($root, $kind) as $directory)
			{
				foreach ($this->classes($root, $directory) as $path => $says)
				{
					if (isset($found[$path]))
					{
						continue;
					}

					$found[$path] = $this->entry($path, 'map', $this->name($path));
					$found[$path]['role'] = $says['role'];
					$found[$path]['scope'] = $scope;
					$found[$path]['view'] = $says['view'];
				}
			}
		}

		return $this->recorded(array_values($found));
	}

	/**
	 * The artifact name a view file is stored under.
	 *
	 * @param   string  $path  Absolute path to the file.
	 *
	 * @return  string  The lower-case artifact name.
	 * @since   6.1.6
	 */
	public function name(string $path): string
	{
		return strtolower(pathinfo($path, PATHINFO_FILENAME));
	}

	/**
	 * The scope this pass is confined to, when the caller declared one.
	 *
	 * @return  string  Either admin, site, or an empty string for both.
	 * @since   6.1.6
	 */
	protected function scope(): string
	{
		$scope = strtolower(trim((string) $this->source->get('scope', '')));

		return in_array($scope, ['admin', 'site'], true) ? $scope : '';
	}

	/**
	 * The placement kinds to search, and the scope each one's findings carry.
	 *
	 * Both families are always searched, because a layout and a template are the
	 * same thing to JCB wherever they came from -- there is one layout table and one
	 * template table, with no administrator or site distinction in either.
	 *
	 * The scope is carried anyway, because exactly one decision depends on it: a
	 * view's own default.php is the site view itself on the site side and generated
	 * output on the administrator side. When the root is itself one of the two
	 * folders, both families resolve to the same directory and the tree cannot say
	 * which it is; a declared scope settles it, and without one the administrator
	 * reading stands, because that merely passes the file over instead of inventing
	 * a front end view that does not exist.
	 *
	 * @param   string  $admin  The administrator placement kind.
	 * @param   string  $site   The site placement kind.
	 * @param   string  $only   The declared scope, or an empty string.
	 *
	 * @return  array<string, string>  Placement kind keyed to the scope its findings carry.
	 * @since   6.1.6
	 */
	protected function kinds(string $admin, string $site, string $only): array
	{
		if ($only !== '')
		{
			return [$admin => $only, $site => $only];
		}

		return [$admin => 'admin', $site => 'site'];
	}

	/**
	 * What one template file is to the screen it belongs to.
	 *
	 * @param   string  $file  The file name.
	 *
	 * @return  string  The role.
	 * @since   6.2.0
	 */
	protected function role(string $file): string
	{
		$base = strtolower($file);

		if ($base === 'edit.php')
		{
			return 'edit';
		}

		if ($base === 'default.php')
		{
			return 'main';
		}

		return str_starts_with($base, 'default_') ? 'template' : 'view';
	}

	/**
	 * Every screen a folder of view classes names.
	 *
	 * A screen is not made by its template. A component states a screen in
	 * several places at once -- a view class, a model, a controller, a
	 * template -- and any one of them names it. Reading only the templates is
	 * what loses a screen whose template is laid out some other way, or which
	 * has none yet, and it is why a component that follows the ordinary layout
	 * but does not keep a template folder for every screen came back short.
	 *
	 * @param   string  $root       The resolved source root.
	 * @param   string  $directory  The folder of view classes.
	 *
	 * @return  array<string, array{role: string, view: string}>  Path keyed to what it says.
	 * @since   6.2.0
	 */
	protected function classes(string $root, string $directory): array
	{
		$found = [];

		foreach ((array) @glob($directory . '/*', GLOB_ONLYDIR) as $viewDirectory)
		{
			if (!is_string($viewDirectory))
			{
				continue;
			}

			$named = strtolower(basename($viewDirectory));

			foreach ($this->php($root, $viewDirectory) as $path)
			{
				$found[$path] = ['role' => 'class', 'view' => $named];
			}
		}

		return $found;
	}

	/**
	 * The view a template file belongs to.
	 *
	 * A template sits in the folder of the view that renders it, so the folder name
	 * is the view name. On the legacy layout a view keeps its templates in a nested
	 * tmpl folder, so that level is stepped over rather than mistaken for the view.
	 *
	 * @param   string  $path  Absolute path to the file.
	 *
	 * @return  string  The lower-case view name.
	 * @since   6.1.6
	 */
	public function view(string $path): string
	{
		$directory = strtolower(basename(dirname($path)));

		if ($directory === 'tmpl')
		{
			$directory = strtolower(basename(dirname($path, 2)));
		}

		return $directory;
	}

	/**
	 * Every contained PHP file directly inside one directory.
	 *
	 * @param   string  $root       The resolved source root.
	 * @param   string  $directory  The directory to list.
	 *
	 * @return  array<string>  Absolute contained paths.
	 * @since   6.1.6
	 */
	protected function php(string $root, string $directory): array
	{
		$found = [];

		foreach ((array) @glob($directory . '/*.php') as $path)
		{
			$contained = is_string($path) ? $this->scanner->contain($root, $path) : null;

			if ($contained !== null)
			{
				$found[] = $contained;
			}
		}

		return $found;
	}

	/**
	 * Classify the template files below a templates root.
	 *
	 * A default_<x>.php file beside a view's default.php is a reusable JCB
	 * template; default.php itself is the view's own main template.
	 *
	 * An edit.php marks the folder as a view that edits a record rather than
	 * displays one. In the front end such a view is an administrator view moved
	 * there, and it carries no default.php at all -- so it is named here rather than
	 * inferred later from what its markup contains. That distinction cannot be drawn
	 * from the content: a front end list view renders an adminForm with a token for
	 * its own filters, exactly as an edit view does.
	 *
	 * @param   string  $root       The resolved source root.
	 * @param   string  $directory  The templates root.
	 *
	 * @return  array<string, array{role: string, view: string}>  Path keyed to what it says.
	 * @since   6.1.6
	 */
	protected function templates(string $root, string $directory): array
	{
		$found = [];

		// a screen whose whole template is one file beside its neighbours is
		// as much a screen as one with a folder of its own, and the file names it
		foreach ((array) @glob($directory . '/*.php') as $flat)
		{
			$contained = is_string($flat) ? $this->scanner->contain($root, $flat) : null;
			$named = $contained === null
				? ''
				: strtolower(pathinfo($contained, PATHINFO_FILENAME));

			if ($named === '' || $named === 'index')
			{
				continue;
			}

			$found[$contained] = [
				'role' => str_starts_with($named, 'default_') ? 'template' : 'main',
				'view' => $named
			];
		}

		foreach ((array) @glob($directory . '/*', GLOB_ONLYDIR) as $viewDirectory)
		{
			if (!is_string($viewDirectory))
			{
				continue;
			}

			$named = strtolower(basename($viewDirectory));

			foreach ($this->php($root, $viewDirectory) as $path)
			{
				$found[$path] = ['role' => $this->role(basename($path)), 'view' => $named];
			}

			foreach ((array) @glob($viewDirectory . '/tmpl/*.php') as $nested)
			{
				$contained = is_string($nested) ? $this->scanner->contain($root, $nested) : null;

				if ($contained === null)
				{
					continue;
				}

				$found[$contained] = [
					'role' => $this->role(basename($contained)),
					'view' => $named
				];
			}
		}

		return $found;
	}
}

