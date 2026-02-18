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

namespace VDM\Joomla\Componentbuilder\Compiler\Alias;


use Joomla\Database\DatabaseInterface;
use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Registry;
use VDM\Joomla\Componentbuilder\Compiler\Customcode;
use VDM\Joomla\Componentbuilder\Compiler\Customcode\Gui;
use VDM\Joomla\Componentbuilder\Compiler\Model\Loader;
use VDM\Joomla\Componentbuilder\Compiler\Model\Libraries;
use VDM\Joomla\Componentbuilder\Package\Builder\Get as Superpower;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\StringHelper;


/**
 * Alias Data Class
 * 
 * @since 3.2.0
 */
class Data
{
	/**
	 * tracking GUID index
	 *
	 * @var    array
	 * @since  5.0.4
	 */
	protected array $index = [];

	/**
	 * The state of retry to loaded fields
	 *
	 * @var    array
	 * @since  5.1.4
	 **/
	protected array $retry = [];

	/**
	 * allowed tables
	 *
	 * @var    array
	 * @since  5.0.4
	 */
	protected array $allowedTables = ['template', 'layout'];

	/**
	 * Compiler Config
	 *
	 * @var    Config
	 * @since 3.2.0
	 */
	protected Config $config;

	/**
	 * The compiler registry
	 *
	 * @var    Registry
	 * @since 3.2.0
	 */
	protected Registry $registry;

	/**
	 * Compiler Customcode
	 *
	 * @var    Customcode
	 * @since 3.2.0
	 */
	protected Customcode $customcode;

	/**
	 * Compiler Customcode in Gui
	 *
	 * @var    Gui
	 * @since 3.2.0
	 **/
	protected Gui $gui;

	/**
	 * Compiler Auto Loader
	 *
	 * @var    Loader
	 * @since 3.2.0
	 */
	protected Loader $loader;

	/**
	 * Compiler Libraries Model
	 *
	 * @var    Libraries
	 * @since 3.2.0
	 */
	protected Libraries $libraries;

	/**
	 * Joomla Database Class.
	 *
	 * @var   DatabaseInterface
	 * @since 5.1.2
	 **/
	protected DatabaseInterface $db;

	/**
	 * The Super Class.
	 *
	 * @var   Superpower
	 * @since 5.1.4
	 */
	protected Superpower $superpower;

	/**
	 * Constructor.
	 *
	 * @param Config             $config       The Config Class.
	 * @param Registry           $registry     The Registry Class.
	 * @param Customcode         $customcode   The Customcode Class.
	 * @param Gui                $gui          The Gui Class.
	 * @param Loader             $loader       The Loader Class.
	 * @param Libraries          $libraries    The Libraries Class.
	 * @param DatabaseInterface  $db           The Joomla Database Class.
	 * @param Superpower         $superpower   A Superpower Class.
	 *
	 * @since 3.2.0
	 */
	public function __construct(Config $config, Registry $registry,
		Customcode $customcode, Gui $gui, Loader $loader,
		Libraries $libraries, DatabaseInterface $db,
		Superpower $superpower)
	{
		$this->config = $config;
		$this->registry = $registry;
		$this->customcode = $customcode;
		$this->gui = $gui;
		$this->loader = $loader;
		$this->libraries = $libraries;
		$this->db = $db;
		$this->superpower = $superpower;
	}

	/**
	 * Retrieve compiled view data by alias.
	 *
	 * This method resolves an alias to its corresponding database record, compiles
	 * the stored HTML and optional PHP view code, registers required libraries and
	 * loaders for all applicable targets, and returns the processed output.
	 *
	 * The alias resolution is delegated to the alias index system and may trigger
	 * a deferred reload if the alias is not yet available locally.
	 *
	 * If the alias cannot be resolved or the record does not exist, null is returned.
	 *
	 * @param   string  $alias  The alias identifier.
	 * @param   string  $table  The source table name (without prefix).
	 * @param   string  $view   The consuming view code name.
	 *
	 * @return  array|null  An associative array containing:
	 *                      - id       (int)    The resolved record ID
	 *                      - html     (string) Compiled HTML output
	 *                      - php_view (string) Compiled PHP view code (if any)
	 *
	 * @since   3.2.0
	 */
	public function get(string $alias, string $table, string $view): ?array
	{
		$id = $this->getAliasId($alias, $table);

		if ($id === null)
		{
			return null;
		}

		$item = $this->loadItemById($table, $id);

		if ($item === null)
		{
			return null;
		}

		$targets = $this->resolveTargets();

		$php_view = $this->compilePhpView($item, $table);
		$content = $this->compileHtml($item, $table);

		foreach ($targets as $target)
		{
			$this->libraries->set($view, $item, $target);

			$this->loader->set($view, $content, $target);
			$this->loader->set($view, $php_view, $target);
		}

		$this->loader->uikit($view, $content);
		$this->loader->uikit($view, $php_view);

		return [
			'id'       => $item->id,
			'html'     => $this->gui->set(
				$content,
				[
					'table' => $table,
					'field' => $table,
					'id'    => $item->id,
					'type'  => 'html'
				]
			),
			'php_view' => $this->gui->set(
				$php_view,
				[
					'table' => $table,
					'field' => 'php_view',
					'id'    => $item->id,
					'type'  => 'php'
				]
			)
		];
	}

	/**
	 * Get the ID associated with an alias in a given table.
	 *
	 * The method attempts a local lookup first using both the raw alias and a
	 * normalized alpha-only variant. If not found locally, it performs a single
	 * remote fetch attempt and retries the lookup once.
	 *
	 * @param   string  $alias  The alias name.
	 * @param   string  $table  The table to search in.
	 *
	 * @return  int|null  The resolved ID, or null if not found.
	 * @since   5.0.4
	 */
	protected function getAliasId(string $alias, string $table): ?int
	{
		$retryKey = $table . '.' . $alias;

		// Attempt local resolution first
		if ($this->isTableAllowed($table) && $this->set($table))
		{
			$id = $this->resolveAliasFromIndex($alias, $table);

			if ($id !== null)
			{
				return $id;
			}
		}

		// Prevent infinite retry loops
		if (!empty($this->retry[$retryKey]))
		{
			return null;
		}

		$this->retry[$retryKey] = true;

		// Fetch remotely and retry once
		$this->superpower->get($table, [$alias]);

		unset($this->index[$table]);

		return $this->getAliasId($alias, $table);
	}

	/**
	 * Resolve an alias ID from the local index.
	 *
	 * @param   string  $alias
	 * @param   string  $table
	 *
	 * @return  int|null
	 * @since   5.1.4
	 */
	protected function resolveAliasFromIndex(string $alias, string $table): ?int
	{
		if (empty($this->index[$table]))
		{
			return null;
		}

		$normalized = preg_replace('/[^A-Za-z]/', '', $alias);

		return $this->index[$table][$normalized]
			?? $this->index[$table][$alias]
			?? null;
	}

	/**
	 * Check whether a table is allowed for alias resolution.
	 *
	 * @param   string  $table
	 *
	 * @return  bool
	 * @since   5.1.4
	 */
	protected function isTableAllowed(string $table): bool
	{
		return in_array($table, $this->allowedTables, true);
	}

	/**
	 * Load all alias-to-ID mappings for a table into the local index.
	 *
	 * If the table loads empty, the index is intentionally left reloadable
	 * to allow later population (e.g. after a remote fetch).
	 *
	 * @param   string  $table  The table name (without prefix).
	 *
	 * @return  bool  True if aliases exist, false otherwise.
	 * @since   3.2.0
	 */
	protected function set(string $table): bool
	{
		// If index exists and has data -> success
		if (!empty($this->index[$table]))
		{
			return true;
		}

		// Load from DB
		$items = $this->loadAliasItems($table);

		// If no data, do NOT lock the index
		if (!ArrayHelper::check($items))
		{
			unset($this->index[$table]);

			return false;
		}

		// Build index
		$this->index[$table] = [];

		foreach ($items as $item)
		{
			$this->indexAlias($table, (string) $item->alias, (int) $item->id);
		}

		return true;
	}

	/**
	 * Load alias records for a given table from the database.
	 *
	 * This method performs a raw database query to retrieve the `id` and `alias`
	 * columns for the requested table. It does not perform any normalization,
	 * indexing, or caching logic. The returned result represents the current
	 * persisted state of the table only.
	 *
	 * A `null` or empty result indicates that no alias records currently exist.
	 * This does not imply a permanent failure - the caller may choose to retry
	 * loading at a later stage (for example, after a remote sync).
	 *
	 * @param   string  $table  The table name (without prefix).
	 *
	 * @return  array|null  An array of objects containing `id` and `alias` values,
	 *                      or null if no records were found.
	 * @since   5.1.4
	 */
	protected function loadAliasItems(string $table): ?array
	{
		$query = $this->db->getQuery(true)
			->select(['a.id', 'a.alias'])
			->from($this->db->quoteName('#__componentbuilder_' . $table, 'a'));

		$this->db->setQuery($query);

		return $this->db->loadObjectList();
	}

	/**
	 * Load a single database record by its numeric ID.
	 *
	 * This method performs a direct database lookup against the given table
	 * using the resolved primary ID. It does not apply any alias logic,
	 * caching, or post-processing and represents the raw persisted state
	 * of the record.
	 *
	 * If no matching record is found, `null` is returned.
	 *
	 * @param   string  $table  The source table name (without prefix).
	 * @param   int     $id     The numeric primary ID of the record.
	 *
	 * @return  object|null  The loaded database record, or null if not found.
	 * @since   5.1.4
	 */
	protected function loadItemById(string $table, int $id): ?object
	{
		$query = $this->db->getQuery(true)
			->select('a.*')
			->from('#__componentbuilder_' . $table . ' AS a')
			->where('a.id = ' . (int) $id);

		$this->db->setQuery($query);

		return $this->db->loadObject() ?: null;
	}

	/**
	 * Index an alias and its normalized variants for fast lookup.
	 *
	 * This method registers multiple lookup keys for a single alias value
	 * to ensure robust resolution across different input formats.
	 *
	 * The following keys are indexed and mapped to the same ID:
	 * - The original alias value
	 * - A "safe" alias variant (using StringHelper::safe)
	 * - An alpha-only variant (letters A-Z only)
	 *
	 * The index is stored per table and is assumed to have been initialized
	 * by the caller prior to invoking this method.
	 *
	 * @param   string  $table  The table name the alias belongs to.
	 * @param   string  $alias  The original alias value.
	 * @param   int     $id     The resolved database ID for the alias.
	 *
	 * @return  void
	 * @since   5.1.4
	 */
	protected function indexAlias(string $table, string $alias, int $id): void
	{
		$safe  = StringHelper::safe($alias);
		$alpha = preg_replace('/[^A-Za-z]/', '', $safe);

		$this->index[$table][$alias] = $id;
		$this->index[$table][$safe]  = $id;
		$this->index[$table][$alpha] = $id;
	}

	/**
	 * Resolve the build targets for the current configuration.
	 *
	 * This method determines which application targets should receive
	 * compiled output based on the language target configuration.
	 *
	 * Possible outcomes:
	 * - A single target (e.g. `site` or `admin`)
	 * - Both targets (`site` and `admin`) when language syncing is enabled
	 *
	 * The returned targets are used to register libraries, loaders, and
	 * UI dependencies for each applicable application context.
	 *
	 * @return  array  A list of target identifiers.
	 * @since   5.1.4
	 */
	protected function resolveTargets(): array
	{
		if ($this->config->lang_target === 'both')
		{
			return ['site', 'admin'];
		}

		return [$this->config->build_target];
	}

	/**
	 * Compile and prepare the PHP view code for a record.
	 *
	 * This method conditionally decodes, processes, and registers the PHP
	 * view code associated with a record. Compilation occurs only when:
	 * - The record explicitly enables PHP view output
	 * - The PHP view content is present and valid
	 *
	 * The compiled result is passed through the custom code updater and
	 * GUI processor to ensure placeholders and dynamic code are resolved
	 * correctly before use.
	 *
	 * If no PHP view is defined or enabled, an empty string is returned.
	 *
	 * @param   object  $item   The database record containing the PHP view data.
	 * @param   string  $table  The source table name.
	 *
	 * @return  string  The compiled PHP view code, or an empty string.
	 * @since   5.1.4
	 */
	protected function compilePhpView(object $item, string $table): string
	{
		if ((int) $item->add_php_view !== 1 || !StringHelper::check($item->php_view))
		{
			return '';
		}

		return $this->gui->set(
			$this->customcode->update(base64_decode((string) $item->php_view)),
			[
				'table' => $table,
				'field' => 'php_view',
				'id'    => (int) $item->id,
				'type'  => 'php',
			]
		);
	}

	/**
	 * Compile and prepare the HTML content for a record.
	 *
	 * This method decodes and processes the stored HTML layout content
	 * associated with a record. The content is passed through the custom
	 * code updater and GUI processor to resolve placeholders, injected
	 * code, and dynamic elements.
	 *
	 * The returned HTML is suitable for loader registration and final
	 * output rendering.
	 *
	 * @param   object  $item   The database record containing the HTML content.
	 * @param   string  $table  The source table name.
	 *
	 * @return  string  The compiled HTML content.
	 * @since   5.1.4
	 */
	protected function compileHtml(object $item, string $table): string
	{
		return $this->gui->set(
			$this->customcode->update(base64_decode((string) $item->{$table})),
			[
				'table' => $table,
				'field' => $table,
				'id'    => (int) $item->id,
				'type'  => 'html',
			]
		);
	}
}

