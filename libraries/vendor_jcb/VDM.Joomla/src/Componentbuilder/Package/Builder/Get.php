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
use VDM\Joomla\Componentbuilder\Package\Dependency\Tracker;
use VDM\Joomla\Componentbuilder\Factory;


/**
 * Get Remote entity orchestration and synchronization manager.
 * 
 * This class coordinates the retrieval, validation, categorization,
 *    dependency resolution, and optional synchronization of entities,
 *    files, and folders from remote repositories.
 * 
 * It acts as a **non-failing orchestration layer**:
 * - All remote handlers are optional.
 * - Missing services are silently ignored.
 * - The DI container is treated as a capability registry, not a hard dependency.
 * 
 * At no point will this class throw due to missing container services.
 * If a capability is unavailable, the operation is skipped and execution continues.
 * 
 * @since 5.1.1
 */
class Get
{
	/**
	 * The dependency tracker.
	 *
	 * Tracks deferred entity, file, and folder dependencies
	 * discovered during remote retrieval operations.
	 *
	 * @var   Tracker
	 * @since 5.1.1
	 */
	protected Tracker $tracker;

	/**
	 * The Joomla dependency injection container.
	 *
	 * Used as a **capability lookup mechanism**.
	 * All access is guarded with `has()` checks to prevent failures.
	 *
	 * @var   Container
	 * @since 5.1.1
	 */
	protected Container $container;

	/**
	 * Accumulated categorized results across recursive calls.
	 *
	 * Results are merged incrementally and preserved across:
	 * - entity recursion
	 * - dependency traversal
	 * - file and folder resolution
	 *
	 * Structure:
	 * - local     : Items already present locally
	 * - not_found : Items unavailable locally and remotely
	 * - added     : Items successfully retrieved and stored
	 *
	 * @var array<string, array<string, string>>
	 * @since 5.1.1
	 */
	protected array $results = [
		'local'     => [],
		'not_found' => [],
		'added'     => [],
	];

	/**
	 * Constructor.
	 *
	 * @param Tracker    $tracker    The dependency tracker.
	 * @param Container  $container  The Joomla DI container.
	 *
	 * @since 5.1.1
	 */
	public function __construct(Tracker $tracker, Container $container)
	{
		$this->tracker   = $tracker;
		$this->container = $container;
	}

	/**
	 * Initializes and categorizes entity items by checking their existence
	 * in the local database and optionally retrieving them from remote repositories.
	 *
	 * This method performs the following steps:
	 * - Resolves the entity area.
	 * - Executes the entity-specific remote handler if available.
	 * - Merges returned results.
	 * - Recursively processes tracked entity dependencies.
	 * - Processes queued file and folder retrievals.
	 *
	 * If the entity has no registered remote handler,
	 * this method becomes a no-op and simply returns the current results.
	 *
	 * @param string       $entity  The target entity.
	 * @param array        $items   An array of item identifiers (GUIDs).
	 * @param object|null  $repo    The repository object (optional).
	 * @param bool         $force   Force a local update if items exist.
	 *
	 * @return array{
	 *     local: array<string, string>,
	 *     not_found: array<string, string>,
	 *     added: array<string, string>
	 * }
	 *
	 * @since 5.1.1
	 */
	public function init(string $entity, array $items, ?object $repo = null, bool $force = false): array
	{
		if ($items === [] || ($area = Factory::getArea($entity)) === null)
		{
			return $this->results;
		}

		$service = "{$area}.Remote.Get";

		if ($this->container->has($service))
		{
			$this->mergeResults(
				$this->container->get($service)->init($items, $repo, $force)
			);
		}

		while (($dependencies = $this->tracker->get('get')) !== null)
		{
			$this->tracker->remove('get');

			foreach ($dependencies as $nextEntity => $nextItems)
			{
				$this->init($nextEntity, $this->getGuids($nextItems), $repo, $force);
			}
		}

		while (($files = $this->tracker->get('file.get')) !== null)
		{
			$this->tracker->remove('file.get');
			$this->file($files, $repo, $force);
		}

		while (($folders = $this->tracker->get('folder.get')) !== null)
		{
			$this->tracker->remove('folder.get');
			$this->folder($folders, $repo, $force);
		}

		return $this->results;
	}

	/**
	 * Validate any repository
	 *
	 * @param string  $entity       The target entity.
	 * @param object  $repository   The target repository object.
	 *
	 * @return bool   True if valid path
	 *
	 * @since 5.1.4
	 */
	public function validRepo(string $entity, object $repository): bool
	{
		if (($area = Factory::getArea($entity)) === null)
		{
			return false;
		}

		$service = "{$area}.Grep";

		if (!$this->container->has($service))
		{
			return false;
		}

		return $this->container->get($service)->validRepo($repository);
	}

	/**
	 * Resolve and normalize entity identifiers into valid GUIDs.
	 *
	 * Delegates identifier resolution to the entity-specific Grep service.
	 *
	 * If the Grep service is not available for the entity,
	 * an empty array is returned and no resolution occurs.
	 *
	 * @param string  $entity  The target entity.
	 * @param array   $items   Raw item identifiers.
	 *
	 * @return array<string>  Valid resolved identifiers.
	 *
	 * @since 5.1.4
	 */
	public function getValidGuids(string $entity, array $items): array
	{
		if ($items === [] || ($area = Factory::getArea($entity)) === null)
		{
			return [];
		}

		$service = "{$area}.Grep";

		if (!$this->container->has($service))
		{
			return [];
		}

		return $this->container->get($service)->getValidGuids($items);
	}

	/**
	 * Retrieve entities without repository or force options.
	 *
	 * This is a simplified retrieval pathway that:
	 * - Resolves valid GUIDs
	 * - Executes the remote handler if available
	 * - Recursively processes dependencies
	 *
	 * @param string  $entity  The target entity.
	 * @param array   $items   Item identifiers.
	 *
	 * @return array{
	 *     local: array<string, string>,
	 *     not_found: array<string, string>,
	 *     added: array<string, string>
	 * }
	 *
	 * @since 5.1.4
	 */
	public function get(string $entity, array $items): array
	{
		$items = $this->getValidGuids($entity, $items);

		if ($items === [] || ($area = Factory::getArea($entity)) === null)
		{
			return $this->results;
		}

		$service = "{$area}.Remote.Get";

		if ($this->container->has($service))
		{
			$this->mergeResults(
				$this->container->get($service)->init($items)
			);
		}

		while (($dependencies = $this->tracker->get('get')) !== null)
		{
			$this->tracker->remove('get');

			foreach ($dependencies as $nextEntity => $nextItems)
			{
				$this->get($nextEntity, $this->getGuids($nextItems));
			}
		}

		while (($files = $this->tracker->get('file.get')) !== null)
		{
			$this->tracker->remove('file.get');
			$this->file($files);
		}

		while (($folders = $this->tracker->get('folder.get')) !== null)
		{
			$this->tracker->remove('folder.get');
			$this->folder($folders);
		}

		return $this->results;
	}

	/**
	 * Reset entities and their direct dependencies.
	 *
	 * Only direct child entities are reset.
	 * File and folder resets are executed if the respective services exist.
	 *
	 * @param string  $entity  The target entity.
	 * @param array   $items   Entity GUIDs.
	 *
	 * @return void
	 * @since 5.1.1
	 */
	public function reset(string $entity, array $items): void
	{
		if ($items === [] || ($area = Factory::getArea($entity)) === null)
		{
			return;
		}

		$service = "{$area}.Remote.Get";

		if ($this->container->has($service))
		{
			$this->container->get($service)->reset($items);
		}

		while (($dependencies = $this->tracker->get('get')) !== null)
		{
			$this->tracker->remove('get');

			foreach ($dependencies as $nextEntity => $nextItems)
			{
				$active = $this->getDirectChildrenGuids($nextItems);

				if ($active !== [])
				{
					$this->reset($nextEntity, $active);
				}
			}
		}

		$this->resetAssets('File.Remote.Get', 'file.get');
		$this->resetAssets('Folder.Remote.Get', 'folder.get');
	}

	/**
	 * Fetch files from remote repositories.
	 *
	 * If the file handler is not registered,
	 * the method silently returns without side effects.
	 *
	 * @param array        $files
	 * @param object|null  $repo
	 * @param bool         $force
	 *
	 * @return void
	 * @since 5.1.1
	 */
	protected function file(array $files, ?object $repo = null, bool $force = false): void
	{
		$this->fetchAssets('File.Remote.Get', $files, $repo, $force);
	}

	/**
	 * Fetch folders from remote repositories.
	 *
	 * If the folder handler is not registered,
	 * the method silently returns without side effects.
	 *
	 * @param array        $folders
	 * @param object|null  $repo
	 * @param bool         $force
	 *
	 * @return void
	 * @since 5.1.1
	 */
	protected function folder(array $folders, ?object $repo = null, bool $force = false): void
	{
		$this->fetchAssets('Folder.Remote.Get', $folders, $repo, $force);
	}

	/**
	 * Shared asset fetch implementation for files and folders.
	 *
	 * @param string       $service
	 * @param array        $items
	 * @param object|null  $repo
	 * @param bool         $force
	 *
	 * @return void
	 * @since  5.1.4
	 */
	private function fetchAssets(string $service, array $items, ?object $repo, bool $force): void
	{
		if (!$this->container->has($service))
		{
			return;
		}

		$this->mergeResults(
			$this->container->get($service)->init($items, $repo, $force)
		);
	}

	/**
	 * Reset asset handlers (files or folders).
	 *
	 * @param string  $service
	 * @param string  $trackerKey
	 *
	 * @return void
	 * @since  5.1.4
	 */
	private function resetAssets(string $service, string $trackerKey): void
	{
		if (!$this->container->has($service))
		{
			return;
		}

		while (($items = $this->tracker->get($trackerKey)) !== null)
		{
			$this->tracker->remove($trackerKey);
			$this->container->get($service)->reset($items);
		}
	}

	/**
	 * Merge categorized results into the internal result set.
	 *
	 * @param array  $result
	 *
	 * @return void
	 * @since  5.1.4
	 */
	private function mergeResults(array $result): void
	{
		foreach (['local', 'not_found', 'added'] as $key)
		{
			if (!empty($result[$key]))
			{
				$this->results[$key] += $result[$key];
			}
		}
	}

	/**
	 * Extract inbound (child) GUIDs from dependency metadata.
	 *
	 * @param array  $entities
	 *
	 * @return array
	 * @since  5.1.1
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
	 * Extract GUID values from mixed entity structures.
	 *
	 * @param array  $entities
	 *
	 * @return array
	 * @since  5.1.1
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

