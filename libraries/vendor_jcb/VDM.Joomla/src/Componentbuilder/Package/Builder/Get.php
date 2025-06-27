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

namespace VDM\Joomla\Componentbuilder\Package\Builder;


use Joomla\DI\Container;
use VDM\Joomla\Interfaces\Registryinterface as Entities;
use VDM\Joomla\Componentbuilder\Package\Dependency\Tracker;


/**
 * Package Builder Get
 * 
 * @since 5.1.1
 */
class Get
{
	/**
	 * The Entities Class.
	 *
	 * @var   Entities
	 * @since 5.1.1
	 */
	protected Entities $entities;

	/**
	 * The Tracker Class.
	 *
	 * @var   Tracker
	 * @since 5.1.1
	 */
	protected Tracker $tracker;

	/**
	 * The DI Container Class.
	 *
	 * @var   Container
	 * @since 5.1.1
	 */
	protected Container $container;

	/**
	 * Accumulated categorized results across recursive init calls.
	 *
	 * @var array<string, array<string, string>>
	 * @since 5.1.1
	 */
	protected array $initResults = [
		'local' => [],
		'not_found' => [],
		'added' => [],
	];

	/**
	 * Constructor.
	 *
	 * @param Entities   $entities   The Entities Class.
	 * @param Tracker    $tracker    The Tracker Class.
	 * @param Container  $container  The container Class.
	 *
	 * @since 5.1.1
	 */
	public function __construct(Entities $entities, Tracker $tracker, Container $container)
	{
		$this->entities = $entities;
		$this->tracker = $tracker;
		$this->container = $container;
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
	 * @param string       $entity  The target entity
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
	public function init(string $entity, array $items, ?object $repo = null, bool $force = false): array
	{
		if (($class = $this->entities->get($entity)) === null)
		{
			return $this->initResults;
		}

		$result = $this->container->get("{$class}.Remote.Get")->init($items, $repo, $force);

		foreach (['local', 'not_found', 'added'] as $key)
		{
			if (!empty($result[$key]))
			{
				$this->initResults[$key] += $result[$key];
			}
		}

		if (($dependencies = $this->tracker->get('get')) !== null)
		{
			$this->tracker->remove('get');
			foreach ($dependencies as $next_entity => $next_items)
			{
				$this->init($next_entity, $this->getGuids($next_items), $repo, $force);
			}
		}

		if (($files = $this->tracker->get('file.get')) !== null)
		{
			$this->tracker->remove('file.get');
			$this->file($files, $repo, $force);
		}

		if (($folders = $this->tracker->get('folder.get')) !== null)
		{
			$this->tracker->remove('folder.get');
			$this->folder($folders, $repo, $force);
		}

		return $this->initResults;
	}

	/**
	 * Reset the items
	 *
	 * @param string  $entity   The target entity
	 * @param array   $items    The global unique ids of the items
	 *
	 * @return void
	 * @since  5.1.1
	 */
	public function reset(string $entity, array $items): void
	{
		if (($class = $this->entities->get($entity)) === null)
		{
			return;
		}

		$this->container->get("{$class}.Remote.Get")->reset($items);

		if (($dependencies = $this->tracker->get('get')) !== null)
		{
			$this->tracker->remove('get');
			foreach ($dependencies as $next_entity => $next_items)
			{
				// we only reset direct children entities (in reset)
				$active = $this->getDirectChildrenGuids($next_items);
				if ($active !== [])
				{
					$this->reset($next_entity, $active);
				}
			}
		}

		if (($files = $this->tracker->get('file.get')) !== null)
		{
			$this->tracker->remove('file.get');
			$this->container->get("File.Remote.Get")->reset($files);
		}

		if (($folders = $this->tracker->get('folder.get')) !== null)
		{
			$this->tracker->remove('folder.get');
			$this->container->get("Folder.Remote.Get")->reset($folders);
		}
	}

	/**
	 * Fetch the files from the remote system.
	 *
	 * @param array        $files   The files.
	 * @param object|null  $repo    The repository object to search. If null, all repos will be searched.
	 * @param bool         $force   Force a local update (if item exist locally).
	 *
	 * @return void
	 * @since  5.1.1
	 */
	protected function file(array $files, ?object $repo = null, bool $force = false): void
	{
		$result = $this->container->get("File.Remote.Get")->init($files, $repo, $force);

		foreach (['local', 'not_found', 'added'] as $key)
		{
			if (!empty($result[$key]))
			{
				$this->initResults[$key] += $result[$key];
			}
		}
	}

	/**
	 * Fetch the folders from the remote system.
	 *
	 * @param array        $folders The folders.
	 * @param object|null  $repo    The repository object to search. If null, all repos will be searched.
	 * @param bool         $force   Force a local update (if item exist locally).
	 *
	 * @return void
	 * @since  5.1.1
	 */
	protected function folder(array $folders, ?object $repo = null, bool $force = false): void
	{
		$result = $this->container->get("Folder.Remote.Get")->init($folders, $repo, $force);

		foreach (['local', 'not_found', 'added'] as $key)
		{
			if (!empty($result[$key]))
			{
				$this->initResults[$key] += $result[$key];
			}
		}
	}

	/**
	 * Extract only the `value` property from an array of arrays or objects.
	 *
	 * This method supports mixed input types (arrays or objects)
	 * and will extract the `value` from each entity as long as it is not empty.
	 *
	 * @param array $entities  The entities keyed by GUID.
	 *
	 * @return array  An indexed array of extracted `value` strings.
	 * @since 5.1.1
	 */
	protected function getDirectChildrenGuids(array $entities): array
	{
		$values = [];

		foreach ($entities as $entity)
		{
			$value = null;

			if (is_array($entity) && $entity['direction'] === 'in')
			{
				$value = $entity['value'] ?? null;
			}
			elseif (is_object($entity) && $entity->direction === 'in')
			{
				$value = $entity->value ?? null;
			}

			if (!empty($value))
			{
				$values[] = $value;
			}
		}

		return $values;
	}

	/**
	 * Extract only the `value` property from an array of arrays or objects.
	 *
	 * This method supports mixed input types (arrays or objects)
	 * and will extract the `value` from each entity as long as it is not empty.
	 *
	 * @param array $entities  The entities keyed by GUID.
	 *
	 * @return array  An indexed array of extracted `value` strings.
	 * @since 5.1.1
	 */
	protected function getGuids(array $entities): array
	{
		$values = [];

		foreach ($entities as $entity)
		{
			$value = null;

			if (is_array($entity))
			{
				$value = $entity['value'] ?? null;
			}
			elseif (is_object($entity))
			{
				$value = $entity->value ?? null;
			}

			if (!empty($value))
			{
				$values[] = $value;
			}
		}

		return $values;
	}
}

