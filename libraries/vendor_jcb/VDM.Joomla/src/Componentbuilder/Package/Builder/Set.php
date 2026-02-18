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
 * Set Remote entity persistence orchestrator.
 * 
 * Coordinates saving entities, files, and folders to remote systems
 * while resolving dependencies via the Tracker.
 * 
 * This class treats the DI container as a capability registry:
 * - If a remote handler does not exist, the operation is skipped.
 * - No exceptions are thrown due to missing services.
 * 
 * @since 5.1.1
 */
class Set
{
	/**
	 * The Tracker Class.
	 *
	 * Tracks deferred entity, file, and folder save operations
	 * discovered during remote persistence.
	 *
	 * @var   Tracker
	 * @since 5.1.1
	 */
	protected Tracker $tracker;

	/**
	 * The DI Container Class.
	 *
	 * Used strictly as a service capability registry.
	 * All access is guarded via `has()` to prevent runtime failures.
	 *
	 * @var   Container
	 * @since 5.1.1
	 */
	protected Container $container;

	/**
	 * Constructor.
	 *
	 * @param Tracker    $tracker    The Tracker Class.
	 * @param Container  $container  The DI container.
	 *
	 * @since 5.1.1
	 */
	public function __construct(Tracker $tracker, Container $container)
	{
		$this->tracker   = $tracker;
		$this->container = $container;
	}

	/**
	 * Save items remotely.
	 *
	 * This method performs the following steps:
	 * - Resolves the entity class via the Entities registry.
	 * - Executes the entity-specific remote save handler if available.
	 * - Recursively processes tracked entity dependencies.
	 * - Processes queued file and folder save operations.
	 *
	 * If a required remote handler is not registered in the container,
	 * the operation is silently skipped and execution continues.
	 *
	 * @param string  $entity  The target entity.
	 * @param array   $guids   The global unique identifiers of the items.
	 *
	 * @return void
	 * @since  5.1.1
	 */
	public function items(string $entity, array $guids): void
	{
		if ($guids === [] || ($area = Factory::getArea($entity)) === null)
		{
			return;
		}

		$service = "{$area}.Remote.Set";

		if ($this->container->has($service))
		{
			$this->container->get($service)->items($guids);
		}

		while (($dependencies = $this->tracker->get('set')) !== null)
		{
			$this->tracker->remove('set');

			foreach ($dependencies as $nextEntity => $nextItems)
			{
				$this->items($nextEntity, $this->getGuids($nextItems));
			}
		}

		while (($files = $this->tracker->get('file.set')) !== null)
		{
			$this->tracker->remove('file.set');

			if ($this->container->has('File.Remote.Set'))
			{
				$this->container->get('File.Remote.Set')->items($files);
			}
		}

		while (($folders = $this->tracker->get('folder.set')) !== null)
		{
			$this->tracker->remove('folder.set');

			if ($this->container->has('Folder.Remote.Set'))
			{
				$this->container->get('Folder.Remote.Set')->items($folders);
			}
		}
	}

	/**
	 * Extract only the `value` property from an array of arrays or objects.
	 *
	 * This method safely supports mixed input types (arrays or objects)
	 * and extracts the `value` field when present and non-empty.
	 *
	 * Invalid or unsupported structures are ignored.
	 *
	 * @param array $entities  The entities keyed by GUID.
	 *
	 * @return array  An indexed array of extracted GUID strings.
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

