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

namespace VDM\Joomla\Abstraction\Remote;


use Joomla\CMS\Language\Text;
use VDM\Joomla\Interfaces\Remote\ConfigInterface as Config;
use VDM\Joomla\Interfaces\GrepInterface as Grep;
use VDM\Joomla\Interfaces\Data\ItemInterface as Item;
use VDM\Joomla\Componentbuilder\Package\Dependency\Tracker;
use VDM\Joomla\Componentbuilder\Package\MessageBus;
use VDM\Joomla\Interfaces\Remote\GetInterface;
use VDM\Joomla\Abstraction\Remote\Base;


/**
 * Get data based on global unique ids from remote system
 * 
 * @since 3.2.0
 */
abstract class Get extends Base implements GetInterface
{
	/**
	 * The Grep Class.
	 *
	 * @var   Grep
	 * @since 3.2.2
	 */
	protected Grep $grep;

	/**
	 * The Item Class.
	 *
	 * @var   Item
	 * @since 3.2.0
	 */
	protected Item $item;

	/**
	 * The Tracker Class.
	 *
	 * @var   Tracker
	 * @since 5.1.1
	 */
	protected Tracker $tracker;

	/**
	 * The MessageBus Class.
	 *
	 * @var   MessageBus
	 * @since 5.1.1
	 */
	protected MessageBus $messages;

	/**
	 * Constructor.
	 *
	 * @param Config      $config   The Config Class.
	 * @param Grep        $grep     The Grep Class.
	 * @param Item        $item     The ItemInterface Class.
	 * @param Tracker     $tracker  The Tracker Class.
	 * @param MessageBus  $messages The MessageBus Class.
	 * @param string|null $table    The table name.
	 *
	 * @since 3.2.0
	 */
	public function __construct(Config $config, Grep $grep, Item $item,
		Tracker $tracker, MessageBus $messages, ?string $table = null)
	{
		parent::__construct($config);

		$this->grep = $grep;
		$this->item = $item;
		$this->tracker = $tracker;
		$this->messages = $messages;

		if ($table !== null)
		{
			$this->table($table);
		}
	}

	/**
	 * Initializes and categorizes items by checking their existence in the local database
	 * and optionally retrieving them from a remote repository if not found locally.
	 *
	 * This method processes an array of unique identifiers (`$items`) and checks each item:
	 * - If found in the local database: categorized under 'local'.
	 * - If not found locally and not available remotely: categorized under 'not_found'.
	 * - If retrieved from the remote repository: categorized under 'added' and stored locally.
	 *
	 * @param array        $items   An array of item identifiers (GUIDs) to initialize and validate.
	 * @param object|null  $repo    The repository object to search. If null, all repos will be searched.
	 * @param bool         $force   Force a local update (if item exist locally).
	 *
	 * @return array{
	 *     local: array<string, string>,
	 *     not_found: array<string, string>,
	 *     added: array<string, string>
	 * } Associative arrays indexed by GUIDs indicating the status of each item:
	 * - 'local': Items already present in the local database.
	 * - 'not_found': Items not found locally or remotely.
	 * - 'added': Items successfully retrieved from the remote repository and stored.
	 *
	 * @since  5.1.1
	 */
	public function init(array $items, ?object $repo = null, bool $force = false): array
	{
		$logger = [
			'local'     => [],
			'not_found' => [],
			'added'     => []
		];

		$guid_field = $this->getGuidField();
		$table = $this->getTable();
		$this->grep->setBranchField('read_branch');

		foreach ($items as $guid)
		{
			if ($this->tracker->exists("save.{$table}.{$guid_field}|{$guid}"))
			{
				continue;
			}
			$this->tracker->set("save.{$table}.{$guid_field}|{$guid}", true);

			// Check if item exists in the local database
			if ($force === false && $this->item->table($table)->value($guid, $guid_field) !== null)
			{
				$logger['local'][$guid] = $guid;
				continue;
			}

			// Attempt to fetch the item from the remote repository
			$item = $this->grep->get($guid, ['remote'], $repo);

			if ($item === null)
			{
				$logger['not_found'][$guid] = $guid;
				continue;
			}

			// Store the retrieved remote item into the local structure
			$this->item->table($table)->set($item, $guid_field);

			$logger['added'][$guid] = $guid;
		}

		return $logger;
	}

	/**
	 * Get the path/repo object
	 *
	 * @param string   $guid  The target repository guid.
	 *
	 * @return object|null
	 * @since  5.1.1
	 */
	public function path(string $guid): ?object
	{
		$this->grep->setBranchField('read_branch');
		return $this->grep->getPath($guid);
	}

	/**
	 * get all the available paths for this area
	 *
	 * @return array|null
	 * @since  5.1.1
	 */
	public function paths(): ?array
	{
		$this->grep->setBranchField('read_branch');
		return $this->grep->getPaths();
	}

	/**
	 * Get all available items for the given repository, or all repositories if none specified.
	 *
	 * @param string|null $repo The target repository to list (optional).
	 *
	 * @return array|null An array of indexed path objects or null if not found.
	 * @since 5.1.1
	 */
	public function list(?string $repo = null): ?array
	{
		$guid_field = $this->getGuidField();
		$entity = $this->getTable();
		$table = $this->item->table($entity);
		$this->grep->setBranchField('read_branch');

		if ($repo === null)
		{
			$paths = $this->grep->getPathsIndexes();
		}
		else
		{
			$singlePath = $this->grep->getPathIndexes($repo);
			$paths = $singlePath !== null ? [$singlePath] : null;
		}

		if ($paths === null)
		{
			return null;
		}

		$list = [];
		foreach ($paths as $path)
		{
			if (!is_object($path->index[$entity] ?? null))
			{
				continue;
			}

			$repo = clone $path;
			$repo->index = $path->index[$entity];

			foreach ($repo->index as $key => $item)
			{
				$guid = $item->guid ?? $item->{$guid_field} ?? null;
				if (!isset($guid))
				{
					unset($repo->index->{$key});
					continue;
				}
				$item->local = $table->value($guid, $guid_field) !== null;
			}

			$this->normalizeObjectIndexHeader($repo->index);

			$list[] = $repo;
		}

		return $list ?? null;
	}

	/**
	 * Reset the items
	 *
	 * @param array   $items    The global unique ids of the items
	 *
	 * @return bool
	 * @since  3.2.0
	 */
	public function reset(array $items): bool
	{
		if ($items === [])
		{
			return false;
		}

		$success = true;
		$area = $this->getArea();

		foreach($items as $guid)
		{
			if (!$this->item($guid, ['remote']))
			{
				$success = false;
				$this->messages->add('warning', Text::sprintf('COM_COMPONENTBUILDER_THE_S_ITEMS_DID_NOT_RESET', strtolower($area), $guid));
			}
		}

		if ($success)
		{
			$this->messages->add('success', Text::sprintf('COM_COMPONENTBUILDER_THE_S_ITEMS_WAS_RESET', strtolower($area)));
		}

		return $success;
	}

	/**
	 * Load an item
	 *
	 * @param string       $guid    The global unique id of the item
	 * @param array        $order   The search order
	 * @param object|null  $repo    The repository object to search. If null, all repos will be searched.
	 *
	 * @return bool
	 * @since  3.2.0
	 * @since  5.1.1  We added the repo object
	 */
	public function item(string $guid, array $order = ['remote', 'local'], ?object $repo = null): bool
	{
		$guid_field = $this->getGuidField();
		$table = $this->getTable();
		$this->grep->setBranchField('read_branch');
		$result = false;

		if ($this->tracker->exists("save.{$table}.{$guid_field}|{$guid}"))
		{
			return $this->tracker->get("save.{$table}.{$guid_field}|{$guid}");
		}

		if (($item = $this->grep->get($guid, $order, $repo)) !== null)
		{
			// pass item to the model to set the direct children
			$result = $this->item->table($table)->set($item, $guid_field);
		}

		$this->tracker->set("save.{$table}.{$guid_field}|{$guid}", $result);

		return $result;
	}

	/**
	 * Normalize an object of objects (indexed by GUID):
	 * - Each sub-object is normalized to have all keys in the order from getIndexHeader().
	 * - Missing keys are filled with an empty string.
	 * - The outer GUID keys are preserved.
	 *
	 * @param  object  &$items  Object of stdClass sub-objects, passed by reference
	 *
	 * @return void
	 * @since  5.1.1
	 */
	public function normalizeObjectIndexHeader(object &$items): void
	{
		$canonicalKeys = $this->getIndexHeader();

		$expectedCount = count($canonicalKeys);
		$template = array_fill_keys($canonicalKeys, '');

		foreach ($items as $guid => &$subObject)
		{
			if (!is_object($subObject))
			{
				continue; // skip if not an object
			}

			$vars = get_object_vars($subObject);

			// Skip normalization if already compliant
			if (count($vars) === $expectedCount && array_keys($vars) === $canonicalKeys)
			{
				continue;
			}

			// Normalize: enforce key order and fill missing values
			$subObject = (object) array_merge($template, $vars);
		}

		unset($subObject); // break reference
	}
}

