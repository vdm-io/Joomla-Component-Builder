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

namespace VDM\Joomla\Componentbuilder\Package\Remote;


use Joomla\CMS\Language\Text;
use VDM\Joomla\Interfaces\Remote\ConfigInterface as Config;
use VDM\Joomla\Interfaces\GrepInterface as Grep;
use VDM\Joomla\Interfaces\Data\ItemInterface as Item;
use VDM\Joomla\Componentbuilder\Utilities\Normalize;
use VDM\Joomla\Componentbuilder\Package\Dependency\Tracker;
use VDM\Joomla\Componentbuilder\Package\MessageBus;
use VDM\Joomla\Interfaces\Remote\GetInterface;
use VDM\Joomla\Abstraction\Remote\Get;


/**
 * Get Remote Content for JCB
 * 
 * @since 5.1.1
 */
abstract class GetContent extends Get implements GetInterface
{
	/**
	 * The Normalize Class.
	 *
	 * @var   Normalize
	 * @since 5.1.1
	 */
	protected Normalize $normalize;

	/**
	 * Constructor.
	 *
	 * @param Config      $config    The Config Class.
	 * @param Grep        $grep      The Grep Class.
	 * @param Item        $item      The ItemInterface Class.
	 * @param Normalize   $normalize The Normalize Class.
	 * @param Tracker     $tracker   The Tracker Class.
	 * @param MessageBus  $messages  The MessageBus Class.
	 * @param string|null $table     The table name.
	 *
	 * @since 5.1.1
	 */
	public function __construct(Config $config, Grep $grep, Item $item, Normalize $normalize,
		Tracker $tracker, MessageBus $messages, ?string $table = null)
	{
		parent::__construct($config, $grep, $item, $tracker, $messages, $table);

		$this->normalize = $normalize;
	}

	/**
	 * Initializes and categorizes items by checking their existence in the local file system
	 * and optionally retrieving them from a remote repository if not found locally.
	 *
	 * This method processes an array of $items and checks each item:
	 * - If found in the local file system: categorized under 'local'.
	 * - If not found locally and not available remotely: categorized under 'not_found'.
	 * - If retrieved from the remote repository: categorized under 'added' and stored locally.
	 *
	 * @param array        $items   An array of items to initialize and validate.
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
		$this->grep->setBranchField('read_branch');

		foreach ($items as $item)
		{
			// Support both object and array types
			$guid    = $this->extractItemValue($item, 'key');
			$value   = $this->extractItemValue($item, 'value');
			$entity  = $this->extractItemValue($item, 'entity');
			$target  = $this->extractItemValue($item, 'target');
			$pointer = $this->extractItemValue($item, 'pointer');

			if (empty($guid) || empty($value) || empty($entity) || empty($target) || empty($pointer) || $this->tracker->exists("{$entity}.save.{$pointer}"))
			{
				continue;
			}
			$this->tracker->set("{$entity}.save.{$pointer}", true);

			$full_path = $this->normalize->full($value, $target);
			if (empty($full_path))
			{
				continue;
			}

			// Check if item exists in the local file system
			if ($force === false && $this->isLocal($full_path))
			{
				$logger['local'][$guid] = $value;
				continue;
			}

			// Attempt to fetch the item from the remote repository
			$found = $this->grep->get($guid, ['remote'], $repo);
			$content = $this->extractItemValue($found, 'content');

			if ($found === null || empty($content))
			{
				$logger['not_found'][$guid] = $value;
				continue;
			}

			// Store the retrieved content
			$result = $this->store($content, $full_path);

			if (!$result)
			{
				$this->messages->add('warning',
					Text::sprintf('COM_COMPONENTBUILDER_THE_S_ITEMS_S_COULD_NOT_BE_STORED_LOCALLY',
						$entity, $guid, $value));
			}
			else
			{
				$logger['added'][$guid] = $value;
			}
		}

		return $logger;
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

		$success = false;
		$counter = 0;
		$entity = strtolower($this->getArea());

		foreach($items as $item)
		{
			// Support both string, object and array types
			$guid = is_string($item) ? $item
				: (is_array($item) ? ($item['key'] ?? null)
				: (is_object($item) ? ($item->key ?? null)
				: null));

			if ($guid === null || !$this->item($guid, ['remote']))
			{
				$this->messages->add('warning', Text::sprintf('COM_COMPONENTBUILDER_THE_S_ITEMS_DID_NOT_RESET', $entity, $guid ?? 'no_guid_found'));
			}
			else
			{
				$success = true;
				$counter++;
			}
		}

		if ($success && !$this->tracker->exists("message.reset.{$entity}"))
		{
			$this->tracker->set("message.reset.{$entity}", true);
			$name = $counter == 1 ? 'item was' : "({$counter}) items were";
			$this->messages->add('success', Text::sprintf('COM_COMPONENTBUILDER_THE_S_S_RESET', $entity, $name));
		}

		return $success;
	}

	/**
	 * Load an item using its GUID from the given repository or across all repositories.
	 *
	 * @param string       $guid   The globally unique ID of the item.
	 * @param array        $order  The search order: typically ['remote', 'local'].
	 * @param object|null  $repo   The repository to search in, or null to search all.
	 *
	 * @return bool  True if the item was successfully stored; false otherwise.
	 *
	 * @since 3.2.0
	 * @since 5.1.1  Added support for optional repository object.
	 */
	public function item(string $guid, array $order = ['remote', 'local'], ?object $repo = null): bool
	{
		$this->grep->setBranchField('read_branch');

		$entity   = strtolower($this->getArea());
		$pointer  = str_replace('.', '--', $guid);
		$trackerKey = "{$entity}.save.{$pointer}";

		// Return cached result if previously processed
		if ($this->tracker->exists($trackerKey))
		{
			return $this->tracker->get($trackerKey);
		}

		$item = $this->grep->get($guid, $order, $repo);
		$result = false;

		if ($item !== null)
		{
			// Support both array and object formats
			$value   = $this->extractItemValue($item, 'value');
			$target  = $this->extractItemValue($item, 'target');
			$content = $this->extractItemValue($item, 'content');

			if (!empty($value) && !empty($target) && !empty($content))
			{
				$fullPath = $this->normalize->full($value, $target);

				if (!empty($fullPath))
				{
					$result = $this->store($content, $fullPath);
				}
			}
		}

		// Cache the result for future calls
		$this->tracker->set($trackerKey, $result);

		return $result;
	}

	/**
	 * Extract a value from an array or object safely.
	 *
	 * @param array|object $item The item to extract from.
	 * @param string       $key  The key or property name to extract.
	 *
	 * @return mixed|null  The extracted value or null if not found.
	 * @since 5.1.2
	 */
	protected function extractItemValue($item, string $key)
	{
		if (is_array($item))
		{
			return $item[$key] ?? null;
		}

		if (is_object($item))
		{
			return $item->$key ?? null;
		}

		return null;
	}

	/**
	 * Check if an content is found locally
	 *
	 * @param  string   $fullPath  The full path to the content
	 *
	 * @return bool
	 * @since  5.1.1
	 */
	abstract protected function isLocal(string $fullPath): bool;

	/**
	 * Store the found content locally
	 *
	 * @param  string   $content   The content to store
	 * @param  string   $fullPath  The full path where the file should be restored
	 *
	 * @return bool  True on success, false on failure
	 * @since  5.1.1
	 */
	abstract protected function store(string $content, string $fullPath): bool;
}

