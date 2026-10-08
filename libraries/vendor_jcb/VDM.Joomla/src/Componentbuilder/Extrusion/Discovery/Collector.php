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
use VDM\Joomla\Componentbuilder\Extrusion\Interfaces\LocatorInterface;
use VDM\Joomla\Componentbuilder\Extrusion\Registry\Inventory;
use VDM\Joomla\Componentbuilder\Extrusion\Registry\Message;
use VDM\Joomla\Componentbuilder\Extrusion\Registry\Report;
use VDM\Joomla\Componentbuilder\Extrusion\Registry\Source;


/**
 * Establishes identity, then runs every locator into the inventory.
 * 
 * Collection stops before interpretation: nothing here parses a file or writes a
 * definition. That separation is what makes the whole discovery layer testable
 * against a fixture tree with no database and no Joomla application.
 * 
 * @since 6.1.6
 */
final class Collector
{
	/**
	 * The artifacts only an administrator folder ever holds.
	 *
	 * @var    array<string>
	 * @since  6.1.6
	 */
	private const ADMIN_ONLY = ['sql', 'access.xml', 'config.xml'];

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
	 * The Manifest Class.
	 *
	 * @var    Manifest
	 * @since  6.1.6
	 */
	protected Manifest $manifest;

	/**
	 * The Inventory Registry.
	 *
	 * @var    Inventory
	 * @since  6.1.6
	 */
	protected Inventory $inventory;

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
	 * The Message Bus.
	 *
	 * @var    Message
	 * @since  6.1.6
	 */
	protected Message $message;

	/**
	 * The Schema Locator.
	 *
	 * @var    LocatorInterface
	 * @since  6.1.6
	 */
	protected LocatorInterface $schema;

	/**
	 * The Form Locator.
	 *
	 * @var    LocatorInterface
	 * @since  6.1.6
	 */
	protected LocatorInterface $form;

	/**
	 * The Language Locator.
	 *
	 * @var    LocatorInterface
	 * @since  6.1.6
	 */
	protected LocatorInterface $language;

	/**
	 * The Table Class Locator.
	 *
	 * @var    LocatorInterface
	 * @since  6.1.6
	 */
	protected LocatorInterface $table;

	/**
	 * The View Locator.
	 *
	 * @var    LocatorInterface
	 * @since  6.1.6
	 */
	protected LocatorInterface $view;

	/**
	 * The Access Discovery Class.
	 *
	 * @var    Access
	 * @since  6.1.8
	 */
	protected Access $access;

	/**
	 * Constructor.
	 *
	 * @param   Config            $config     The extrusion configuration.
	 * @param   Scanner           $scanner    The bounded source scanner.
	 * @param   Manifest          $manifest   The component identity resolver.
	 * @param   Inventory         $inventory  The located artifact registry.
	 * @param   Source            $source     The source identity registry.
	 * @param   Report            $report     The run report registry.
	 * @param   Message           $message    The message bus.
	 * @param   LocatorInterface  $schema     The schema locator.
	 * @param   LocatorInterface  $form       The form locator.
	 * @param   LocatorInterface  $language   The language locator.
	 * @param   LocatorInterface  $table      The table class locator.
	 * @param   LocatorInterface  $view       The view locator.
	 * @param   Access            $access     The access rules reader.
	 *
	 * @since   6.1.6
	 */
	public function __construct(
		Config $config,
		Scanner $scanner,
		Manifest $manifest,
		Inventory $inventory,
		Source $source,
		Report $report,
		Message $message,
		LocatorInterface $schema,
		LocatorInterface $form,
		LocatorInterface $language,
		LocatorInterface $table,
		LocatorInterface $view,
		Access $access
	)
	{
		$this->config = $config;
		$this->scanner = $scanner;
		$this->manifest = $manifest;
		$this->inventory = $inventory;
		$this->source = $source;
		$this->report = $report;
		$this->message = $message;
		$this->schema = $schema;
		$this->form = $form;
		$this->language = $language;
		$this->table = $table;
		$this->view = $view;
		$this->access = $access;
	}

	/**
	 * Collect the inventory of one source root.
	 *
	 * @param   string  $path  The requested source root.
	 *
	 * @return  bool  True when the root was usable and at least a schema was found.
	 * @since   6.1.6
	 */
	public function collect(string $path): bool
	{
		return $this->gather([['path' => $path, 'scope' => '']]);
	}

	/**
	 * Collect the inventory of every source root the caller supplied.
	 *
	 * A component is two trees, and which of them someone has is not our business to
	 * assume: an administrator folder alone, a site folder alone, both, or the one
	 * directory that contains both. Each is collected in turn into one inventory, so
	 * a run given both sees exactly what a run given their common parent would see.
	 *
	 * Each root may declare which half of the component it is. That declaration is
	 * what tells a view's own default.php apart from a site view when the root is
	 * itself one of the two folders and the tree cannot say.
	 *
	 * @param   array<int, array{path: string, scope: string}>  $roots  The requested source roots.
	 *
	 * @return  bool  True when at least one root was usable and yielded something.
	 * @since   6.1.6
	 */
	public function gather(array $roots): bool
	{
		$usable = [];

		foreach ($roots as $requested)
		{
			$path = trim((string) ($requested['path'] ?? ''));

			if ($path === '')
			{
				continue;
			}

			$root = $this->scanner->root($path);

			if ($root === null)
			{
				$this->report->set('failed.root.' . md5($path), 'not a readable directory: ' . $path);
				$this->message->error(
					'The given component source is not a readable directory, so nothing '
					. 'could be read from it.',
					$path
				);

				continue;
			}

			$scope = (string) ($requested['scope'] ?? '');
			$usable[] = ['root' => $root, 'scope' => $scope === '' ? $this->half($root) : $scope];
		}

		if ($usable === [])
		{
			return false;
		}

		$this->identify();

		foreach ($usable as $index => $entry)
		{
			$this->source->set('scope', $entry['scope']);
			$this->manifest->establish($entry['root'], $index > 0);

			// what the component states about itself in files every Joomla
			// component has: which permissions it offers, and at which level
			$this->access->establish($entry['root']);

			foreach ($this->locators() as $locator)
			{
				$this->store($locator, $entry['root']);
			}
		}

		$this->source->set('scope', '');
		$this->report->set('source.roots', array_column($usable, 'root'));

		return $this->assess();
	}

	/**
	 * Which half of a component one root is, when it is only one half.
	 *
	 * A root holding admin or site directories is the whole component and needs no
	 * answer -- the two halves are separate directories there and cannot be confused.
	 * A root holding neither is itself one of them, and then it has to be named,
	 * because both placement families match such a root directly and the tree alone
	 * cannot say which it is.
	 *
	 * The tell has to be something only an administrator folder ever has. Forms are
	 * not it -- a site folder carries forms too, and treating them as the marker read
	 * getbible's site folder as its administrator half. The install schema, the
	 * access rules and the component configuration are administrator only.
	 *
	 * @param   string  $root  The resolved source root.
	 *
	 * @return  string  Either admin, site, or an empty string for a whole component.
	 * @since   6.1.6
	 */
	public function half(string $root): string
	{
		foreach (['admin', 'administrator', 'site'] as $directory)
		{
			if ($this->scanner->resolve($root, $directory) !== null)
			{
				return '';
			}
		}

		foreach (self::ADMIN_ONLY as $marker)
		{
			if ($this->scanner->resolve($root, $marker) !== null)
			{
				$this->report->set('source.half.' . md5($root), 'admin, by its ' . $marker);

				return 'admin';
			}
		}

		$this->report->set('source.half.' . md5($root), 'site, by having no administrator part');

		return 'site';
	}

	/**
	 * Establish the identity that needs no source tree.
	 *
	 * A pasted schema dump has no root to search and no manifest to read, but the
	 * caller supplying it already knows the component it belongs to. Stripping the
	 * table prefix depends entirely on knowing that name, so a dump-only run has to
	 * be able to establish this much without a folder — it is the one thing the
	 * original dump-driven extruder never got wrong, because the component form
	 * told it.
	 *
	 * @return  bool  True when a component code name is known.
	 * @since   6.1.6
	 */
	public function identify(): bool
	{
		$this->source->set('tag', (string) $this->config->get('languageTag', 'en-GB'));

		$supplied = $this->manifest->supplied();

		if ($supplied !== '')
		{
			$this->source->set('code_name', $supplied);
		}

		return $supplied !== '';
	}

	/**
	 * Judge what the source gave us and say so.
	 *
	 * An extrusion works with whatever it finds. A missing artifact makes the
	 * outcome thinner, not impossible, so only the complete absence of anything
	 * describing fields is fatal. Everything else is a warning the caller can show,
	 * which is how a run explains a modest result instead of appearing to succeed
	 * completely.
	 *
	 * @return  bool  True when at least one field-bearing source was found.
	 * @since   6.1.6
	 */
	protected function assess(): bool
	{
		$found = [];

		foreach (['schema', 'table_class', 'form', 'language', 'view'] as $kind)
		{
			$count = (int) $this->inventory->get($kind . '_count', 0);
			$found[$kind] = $count;
			$this->report->set('found.' . $kind, $count);
		}

		$fields = $found['schema'] > 0 || $found['table_class'] > 0 || $found['form'] > 0;

		if (!$fields && $found['view'] === 0)
		{
			$this->message->error(
				'Nothing was found to extrude: no schema, table definition class or form '
				. 'XML to describe a field with, and no layouts or templates either.',
				(string) $this->source->get('path', '')
			);

			return false;
		}

		if (!$fields)
		{
			// A component's site folder legitimately has no schema and no forms -- its
			// content is layouts and templates, and those are worth having on their own.
			// Refusing the run because no field could be described would throw away
			// everything the caller actually pointed at.
			$this->message->notice(
				'Nothing here describes a field, so no view was built; the '
				. $found['view'] . ' layout(s) and template(s) found were extruded on '
				. 'their own.',
				(string) $this->source->get('path', '')
			);

			return true;
		}

		if ($found['schema'] === 0)
		{
			$this->message->warning(
				'No install schema was found, so column types, sizes and defaults '
				. 'cannot be recovered and will be derived from the form instead.'
			);
		}

		if ($found['table_class'] === 0)
		{
			$this->message->notice(
				'No JCB table definition class was found, which is normal for a '
				. 'component JCB did not build. Relationships, storage encodings and '
				. 'stated field roles cannot be recovered from anything else.'
			);
		}

		if ($found['form'] === 0)
		{
			$this->message->warning(
				'No form XML was found, so field types, options and dependencies '
				. 'cannot be recovered and will be derived from the column types.'
			);
		}

		if ($found['language'] === 0)
		{
			$this->message->warning(
				'No language file was found, so labels will be derived from column '
				. 'names rather than read as real text.'
			);
		}

		if ($found['view'] === 0)
		{
			$this->message->notice(
				'No templates or layouts were found, so only the administrator data '
				. 'structure will be extruded.'
			);
		}

		return true;
	}

	/**
	 * Every locator, in the order the inventory should be filled.
	 *
	 * @return  array<int, LocatorInterface>  The locators.
	 * @since   6.1.6
	 */
	public function locators(): array
	{
		$locators = [$this->schema, $this->form, $this->language];

		if ((string) $this->config->get('tableClass', 'auto') !== 'off')
		{
			$locators[] = $this->table;
		}

		if ($this->config->get('code', false) || $this->config->get('admin', true))
		{
			$locators[] = $this->view;
		}

		return $locators;
	}

	/**
	 * Run one locator and record what it found.
	 *
	 * @param   LocatorInterface  $locator  The locator to run.
	 *
	 * @return  void
	 * @since   6.1.6
	 */
	protected function store(LocatorInterface $locator, string $root): void
	{
		if ($root === '')
		{
			return;
		}

		$kind = $locator->kind();
		$index = (int) $this->inventory->get($kind . '_count', 0);
		$seen = $this->seen($kind, $index);

		foreach ($locator->locate($root) as $entry)
		{
			if (!is_array($entry) || !isset($entry['path']) || isset($seen[$entry['path']]))
			{
				continue;
			}

			$seen[$entry['path']] = true;
			$path = $kind . '.' . $index;
			$this->inventory->set($path . '.path', (string) $entry['path']);
			$this->inventory->set($path . '.tier', (string) ($entry['tier'] ?? 'scan'));
			$this->inventory->set($path . '.name', $entry['name'] ?? null);

			foreach (['role', 'scope', 'view'] as $extra)
			{
				if (isset($entry[$extra]))
				{
					$this->inventory->set($path . '.' . $extra, (string) $entry[$extra]);
				}
			}

			$index++;
		}

		$this->inventory->set($kind . '_count', $index);
	}

	/**
	 * The artifact paths of one kind already in the inventory.
	 *
	 * Two roots can overlap -- a component root and its own administrator folder
	 * name the same files -- so a second pass must add what is new without listing
	 * anything twice.
	 *
	 * @param   string  $kind   The artifact kind.
	 * @param   int     $count  How many are already recorded.
	 *
	 * @return  array<string, bool>  Absolute path keyed to true.
	 * @since   6.1.6
	 */
	protected function seen(string $kind, int $count): array
	{
		$seen = [];

		for ($index = 0; $index < $count; $index++)
		{
			$path = $this->inventory->get($kind . '.' . $index . '.path');

			if (is_string($path) && $path !== '')
			{
				$seen[$path] = true;
			}
		}

		return $seen;
	}
}

