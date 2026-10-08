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

namespace VDM\Joomla\Componentbuilder\Extrusion\Discovery;


use VDM\Joomla\Componentbuilder\Extrusion\Config;
use VDM\Joomla\Componentbuilder\Extrusion\Registry\Report;
use VDM\Joomla\Componentbuilder\Extrusion\Registry\Source;


/**
 * Establishes the identity of the component being extruded.
 * 
 * The manifest supplies the component code name, which is what lets a view name
 * be recovered from a prefixed table name and what prefixes every language
 * constant. It also supplies the structural signals that choose a layout family.
 * 
 * @since 6.1.6
 */
final class Manifest
{
	/**
	 * How far below the root a real component manifest may sit.
	 *
	 * @var    int
	 * @since  6.1.6
	 */
	private const MAX_DEPTH = 2;

	/**
	 * Manifest file names that carry no identity of their own.
	 *
	 * A file with one of these names is usually a compiler template or a
	 * bundled example rather than the component's own manifest.
	 *
	 * @var    array<string>
	 * @since  6.1.6
	 */
	private const GENERIC = ['component', 'manifest', 'extension', 'install', 'template'];

	/**
	 * Structural markers that identify a modern component tree.
	 *
	 * @var    array<string>
	 * @since  6.1.6
	 */
	private const MODERN = [
		'admin/src', 'administrator/src', 'src/Model', 'src/Table',
		'admin/services/provider.php', 'services/provider.php', 'admin/tmpl', 'tmpl'
	];

	/**
	 * Structural markers that identify a Joomla 3 component tree.
	 *
	 * @var    array<string>
	 * @since  6.1.6
	 */
	private const LEGACY = [
		'admin/models/forms', 'models/forms', 'admin/tables', 'tables',
		'admin/views', 'views'
	];

	/**
	 * The Config Class.
	 *
	 * @var    Config
	 * @since  6.1.6
	 */
	protected Config $config;

	/**
	 * The Scanner Class.
	 *
	 * @var    Scanner
	 * @since  6.1.6
	 */
	protected Scanner $scanner;

	/**
	 * The Source Registry.
	 *
	 * @var    Source
	 * @since  6.1.6
	 */
	protected Source $source;

	/**
	 * The Report Registry.
	 *
	 * @var    Report
	 * @since  6.1.6
	 */
	protected Report $report;

	/**
	 * Constructor.
	 *
	 * @param   Config   $config   The extrusion configuration.
	 * @param   Scanner  $scanner  The bounded source scanner.
	 * @param   Source   $source   The source identity registry.
	 * @param   Report   $report   The run report registry.
	 *
	 * @since   6.1.6
	 */
	public function __construct(Config $config, Scanner $scanner, Source $source, Report $report)
	{
		$this->config = $config;
		$this->scanner = $scanner;
		$this->source = $source;
		$this->report = $report;
	}

	/**
	 * Establish the component identity below one source root.
	 *
	 * @param   string  $root  The resolved source root.
	 * @param   bool    $keep  Keep an identity an earlier root already established.
	 *
	 * @return  bool  True when a component code name was established.
	 * @since   6.1.6
	 */
	public function establish(string $root, bool $keep = false): bool
	{
		if (!$keep)
		{
			$this->source->set('path', $root);
		}

		$established = $keep && (string) $this->source->get('code_name', '') !== '';

		$supplied = $this->supplied();
		$manifest = $this->find($root) ?? $this->beside($root);

		if ($manifest !== null && !$established)
		{
			$this->source->set('manifest', $manifest['path']);
			$this->source->set('menu', (array) ($manifest['menu'] ?? []));
			$this->source->set('code_name', $manifest['option']);
			$this->source->set('name', $manifest['name']);
			$this->source->set('version', $manifest['version']);

			foreach ($manifest as $key => $value)
			{
				if (!in_array($key, ['path', 'option', 'name', 'version', 'typed'], true))
				{
					$this->source->set('manifest_data.' . $key, $value);
				}
			}

			$this->report->set('source.manifest_typed', (bool) ($manifest['typed'] ?? false));
		}
		elseif ($established)
		{
			$this->report->set(
				'source.root.' . md5($root),
				'collected under the identity an earlier root established'
			);
		}
		elseif ($supplied !== '')
		{
			$this->report->set('source.manifest', 'not found; the supplied code name was used');
		}
		elseif (($option = $this->guess($root)) !== null)
		{
			$this->source->set('code_name', $option);
			$this->report->set('source.manifest', 'not found; code name inferred from the tree');
		}
		else
		{
			$this->report->set('source.manifest', 'not found; no code name could be inferred');
		}

		if ($supplied !== '')
		{
			$this->source->set('code_name', $supplied);
		}

		if (!$established)
		{
			$this->source->set('layout', $this->family($root));
		}

		return $this->source->get('code_name', '') !== '';
	}

	/**
	 * The component code name the caller supplied, if any.
	 *
	 * A caller extruding into a known JCB component already knows the code name,
	 * and knows it better than any file in the source tree does. A bare schema
	 * dump carries no manifest at all, so without this the table prefix cannot be
	 * stripped and every view keeps it -- which is the one thing the original
	 * dump-driven extruder never got wrong, because the component form told it.
	 *
	 * @return  string  The com_ prefixed option, or an empty string.
	 * @since   6.1.6
	 */
	public function supplied(): string
	{
		$name = strtolower(trim((string) $this->config->get('codeName', '')));

		if ($name === '')
		{
			return '';
		}

		$name = preg_replace('/[^a-z0-9_]/', '', $name) ?? '';

		if ($name === '')
		{
			return '';
		}

		return str_starts_with($name, 'com_') ? $name : 'com_' . $name;
	}

	/**
	 * Find and read the component manifest.
	 *
	 * @param   string  $root  The resolved source root.
	 *
	 * @return  array<string, mixed>|null  The manifest facts, or null when none was found.
	 * @since   6.1.6
	 */
	public function find(string $root): ?array
	{
		$candidates = [];

		foreach ($this->scanner->files($root, ['xml']) as $path)
		{
			if (!str_contains($this->scanner->head($path, 4096), '<extension'))
			{
				continue;
			}

			$depth = substr_count(substr($path, strlen($root)), '/') - 1;

			if ($depth > self::MAX_DEPTH)
			{
				continue;
			}

			$facts = $this->parse($path);

			if ($facts !== null)
			{
				// A manifest that says type="component" outright is the component's own,
				// and that beats any name or depth guess: it is the single line that
				// separates the real manifest from a bundled module, plugin or template.
				$rank = $this->rank($root, $path, $depth)
					- (($facts['typed'] ?? false) ? 100 : 0);
				$candidates[] = ['facts' => $facts, 'rank' => $rank];
			}
		}

		if ($candidates === [])
		{
			return null;
		}

		usort(
			$candidates,
			static fn (array $left, array $right): int => $left['rank'] <=> $right['rank']
		);

		return $candidates[0]['facts'];
	}

	/**
	 * Look for the manifest in the directory the source root sits in.
	 *
	 * A component's manifest lives beside its administrator folder, not inside it.
	 * Once installed the two are in the same directory, but in a repository the
	 * layout is admin/, site/ and the manifest as siblings -- so aiming the run at
	 * the administrator folder alone, which is exactly what someone extruding only
	 * the back end would do, leaves the manifest one level up and out of reach.
	 *
	 * Only the containing directory's own files are considered, and only when
	 * nothing was found inside the root. Nothing is read from any deeper part of the
	 * tree above the root, so the scan the run performs stays bounded by the root it
	 * was given; this reads one directory listing beside it and no more.
	 *
	 * @param   string  $root  The resolved source root.
	 *
	 * @return  array<string, mixed>|null  The manifest facts, or null when there are none.
	 * @since   6.1.6
	 */
	protected function beside(string $root): ?array
	{
		$parent = dirname($root);

		if ($parent === $root || !is_dir($parent) || !is_readable($parent))
		{
			return null;
		}

		$candidates = [];

		foreach ((array) @glob($parent . '/*.xml') as $path)
		{
			if (!is_string($path) || !is_file($path))
			{
				continue;
			}

			$facts = $this->parse($path);

			if ($facts !== null && ($facts['typed'] ?? false))
			{
				$candidates[] = ['facts' => $facts, 'rank' => $this->rank($parent, $path, 0)];
			}
		}

		if ($candidates === [])
		{
			return null;
		}

		usort(
			$candidates,
			static fn (array $left, array $right): int => $left['rank'] <=> $right['rank']
		);

		$this->report->set('source.manifest_beside', $parent);

		return $candidates[0]['facts'];
	}

	/**
	 * Rank one manifest candidate, lower being a better match.
	 *
	 * A component's real manifest sits at or very near its root and is named
	 * after the component. A deeply nested one is far more likely to be a
	 * template or an unrelated bundled extension, which is exactly the mistake
	 * that silently ruins every view name downstream.
	 *
	 * @param   string  $root   The resolved source root.
	 * @param   string  $path   Absolute path to the candidate.
	 * @param   int     $depth  How many directories below the root it sits.
	 *
	 * @return  int  The rank, lower being better.
	 * @since   6.1.6
	 */
	protected function rank(string $root, string $path, int $depth): int
	{
		$base = strtolower(pathinfo($path, PATHINFO_FILENAME));
		$rank = max(0, $depth) * 10;

		if (str_starts_with($base, 'com_'))
		{
			return $rank;
		}

		if ($base === strtolower(basename($root)))
		{
			return $rank + 1;
		}

		if (in_array($base, self::GENERIC, true))
		{
			return $rank + 8;
		}

		return $rank + 4;
	}

	/**
	 * Parse one candidate manifest file.
	 *
	 * @param   string  $path  Absolute path to the candidate.
	 *
	 * @return  array{path: string, option: string, name: string, version: string}|null  The manifest facts.
	 * @since   6.1.6
	 */
	public function parse(string $path): ?array
	{
		$content = $this->scanner->read($path);

		if ($content === null || $content === '')
		{
			return null;
		}

		$previous = libxml_use_internal_errors(true);
		$xml = simplexml_load_string($content);
		libxml_clear_errors();
		libxml_use_internal_errors($previous);

		if ($xml === false || $xml->getName() !== 'extension')
		{
			return null;
		}

		$type = strtolower((string) ($xml['type'] ?? ''));

		if ($type !== '' && $type !== 'component')
		{
			return null;
		}

		$name = trim((string) $xml->name);
		$option = $this->option($name, $path);

		if ($option === '')
		{
			return null;
		}

		return [
			'path' => $path,
			'option' => $option,
			'name' => $name,
			'typed' => $type === 'component',
			'version' => trim((string) $xml->version),
			'menu' => $this->menu($xml)
		] + $this->metadata($xml);
	}

	/**
	 * The administrator menu the manifest itself declares.
	 *
	 * A component's manifest states its own administrator menu: the entry the
	 * component carries, and a submenu entry per view it puts there, each
	 * naming the view it opens and the icon it wears. That is the component's
	 * own account of which views belong in the menu and how -- evidence for
	 * exactly the settings a link row carries, in place of a guess.
	 *
	 * @param   \SimpleXMLElement  $xml  The parsed manifest.
	 *
	 * @return  array<string, array<string, string>>  The menu entries by view name.
	 * @since   6.1.8
	 */
	protected function menu(\SimpleXMLElement $xml): array
	{
		$administration = $xml->administration ?? null;

		if (!$administration instanceof \SimpleXMLElement)
		{
			return [];
		}

		$entries = [];

		// reading a child that is not there answers with an empty element
		// rather than nothing, so the text itself is what says a menu is
		// stated at all
		$label = trim((string) $administration->menu);

		if ($label !== '')
		{
			$entries['*'] = [
				'label' => $label,
				'icon' => trim((string) ($administration->menu['img'] ?? ''))
			];
		}

		$submenu = $administration->submenu ?? null;

		if ($submenu instanceof \SimpleXMLElement)
		{
			foreach ($submenu->menu as $entry)
			{
				$view = strtolower(trim((string) ($entry['view'] ?? '')));

				if ($view === '')
				{
					// a submenu entry may name its target in a link instead
					$link = (string) ($entry['link'] ?? '');

					if ($link !== '' && preg_match('/view=([a-z0-9_]+)/i', $link, $found) === 1)
					{
						$view = strtolower($found[1]);
					}
				}

				if ($view !== '')
				{
					$entries[$view] = [
						'label' => trim((string) $entry),
						'icon' => trim((string) ($entry['img'] ?? ''))
					];
				}
			}
		}

		return $entries;
	}

	/**
	 * Everything else the manifest states about the component.
	 *
	 * A manifest is the component's own account of itself: who wrote it, under what
	 * licence, at what version, in which namespace, and what it is for. Every one of
	 * those has a column waiting for it in #__componentbuilder_joomla_component, so
	 * reading only the name would be throwing away the richest description of the
	 * component that exists anywhere in its tree -- and the one part of a component
	 * that is always present, whether or not JCB built it and whether or not it
	 * carries a single line of SQL.
	 *
	 * A name element is very often a language constant rather than text; resolving
	 * that is the language resolver's job, so the raw value is carried through
	 * unchanged and the caller decides.
	 *
	 * @param   \SimpleXMLElement  $xml  The parsed manifest.
	 *
	 * @return  array<string, string>  The stated metadata, empty values dropped.
	 * @since   6.1.6
	 */
	protected function metadata(\SimpleXMLElement $xml): array
	{
		$stated = [
			'description' => trim((string) $xml->description),
			'author' => trim((string) $xml->author),
			'email' => trim((string) $xml->authorEmail),
			'website' => trim((string) $xml->authorUrl),
			'copyright' => trim((string) $xml->copyright),
			'license' => trim((string) $xml->license),
			'created' => trim((string) $xml->creationDate),
			'namespace' => trim((string) $xml->namespace),
			'target' => trim((string) ($xml['version'] ?? '')),
			'method' => strtolower(trim((string) ($xml['method'] ?? '')))
		];

		foreach ($this->files($xml) as $key => $value)
		{
			$stated[$key] = $value;
		}

		return array_filter($stated, static fn (string $value): bool => $value !== '');
	}

	/**
	 * The install and uninstall schema files the manifest points at.
	 *
	 * These are worth having even though the schema locator finds the install file
	 * on its own, because the manifest names it exactly and so settles which of
	 * several candidates the component actually runs -- and because nothing else in
	 * the tree names the uninstall file at all.
	 *
	 * @param   \SimpleXMLElement  $xml  The parsed manifest.
	 *
	 * @return  array<string, string>  The stated relative paths.
	 * @since   6.1.6
	 */
	protected function files(\SimpleXMLElement $xml): array
	{
		$found = [];

		foreach (['install' => 'sql_install', 'uninstall' => 'sql_uninstall'] as $element => $key)
		{
			$file = trim((string) ($xml->{$element}->sql->file[0] ?? ''));

			if ($file !== '')
			{
				$found[$key] = $file;
			}
		}

		return $found;
	}

	/**
	 * Derive the component option from a manifest name or file name.
	 *
	 * @param   string  $name  The manifest name element.
	 * @param   string  $path  Absolute path to the manifest.
	 *
	 * @return  string  The com_ prefixed option, or an empty string.
	 * @since   6.1.6
	 */
	public function option(string $name, string $path): string
	{
		$base = strtolower(pathinfo($path, PATHINFO_FILENAME));

		if (str_starts_with($base, 'com_'))
		{
			return $base;
		}

		$name = strtolower(trim($name));

		if (str_starts_with($name, 'com_'))
		{
			return preg_replace('/[^a-z0-9_]/', '', $name) ?? '';
		}

		if ($name !== '')
		{
			$clean = preg_replace('/[^a-z0-9]/', '', $name) ?? '';

			if ($clean !== '')
			{
				return 'com_' . $clean;
			}
		}

		return '';
	}

	/**
	 * Infer a component option from the tree when no manifest was found.
	 *
	 * @param   string  $root  The resolved source root.
	 *
	 * @return  string|null  The inferred option, or null.
	 * @since   6.1.6
	 */
	public function guess(string $root): ?string
	{
		$base = strtolower(basename($root));

		if (str_starts_with($base, 'com_'))
		{
			return $base;
		}

		foreach (['administrator/components', 'components'] as $relative)
		{
			$directory = $this->scanner->resolve($root, $relative);

			if ($directory === null)
			{
				continue;
			}

			foreach ((array) @scandir($directory) as $entry)
			{
				if (is_string($entry) && str_starts_with(strtolower($entry), 'com_'))
				{
					return strtolower($entry);
				}
			}
		}

		return null;
	}

	/**
	 * Decide which layout family the tree follows.
	 *
	 * @param   string  $root  The resolved source root.
	 *
	 * @return  string  A version identity such as J3 or J4.
	 * @since   6.1.6
	 */
	public function family(string $root): string
	{
		$option = (string) $this->source->get('code_name', '');
		$modern = $this->markers($root, self::MODERN, $option);
		$legacy = $this->markers($root, self::LEGACY, $option);

		$this->report->set('source.markers.modern', $modern);
		$this->report->set('source.markers.legacy', $legacy);

		if ($modern === 0 && $legacy === 0)
		{
			return '';
		}

		return $modern >= $legacy ? 'J4' : 'J3';
	}

	/**
	 * Count how many structural markers exist below a root.
	 *
	 * @param   string         $root     The resolved source root.
	 * @param   array<string>  $markers  Relative marker paths.
	 * @param   string         $option   The component option, when known.
	 *
	 * @return  int  The number of markers found.
	 * @since   6.1.6
	 */
	protected function markers(string $root, array $markers, string $option): int
	{
		$found = 0;

		foreach ($markers as $marker)
		{
			$candidates = [$marker];

			if ($option !== '')
			{
				$candidates[] = 'administrator/components/' . $option . '/' . $marker;
				$candidates[] = 'components/' . $option . '/' . $marker;
			}

			foreach ($candidates as $candidate)
			{
				if ($this->scanner->resolve($root, $candidate) !== null)
				{
					$found++;

					break;
				}
			}
		}

		return $found;
	}
}

