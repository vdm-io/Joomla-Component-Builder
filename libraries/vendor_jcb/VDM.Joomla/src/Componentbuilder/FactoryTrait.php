<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder;


use VDM\Joomla\Componentbuilder\Factory as PowerfulFactory;
use VDM\Joomla\Interfaces\FactoryInterface as ContainerFactory;


/**
 * The methods that help to easily use the powerful factory in your classes.
 * 
 * @since 5.1.4
 */
trait FactoryTrait
{
	/**
	 * The main entity for this instance.
	 *
	 * @var   string
	 * @since 5.1.4
	 */
	protected string $entity;

	/**
	 * The Containers Entities Factories.
	 *
	 * @var   array<class-string<ContainerFactory>|null>
	 * @since 5.1.4
	 */
	protected array $entityFactory = [];

	/**
	 * Set the main entity name.
	 *
	 * @param   string   $entity   The main entity for which a factory container is requested.
	 *
	 * @return self
	 * @since  5.1.4
	 */
	protected function setEntity(string $entity): self
	{
		$this->entity = $entity;

		return $this;
	}

	/**
	 * Get the main entity name.
	 *
	 * @return string  The main entity name.
	 * @since  5.1.4
	 */
	protected function getEntity(): string
	{
		return $this->entity;
	}

	/**
	 * Resolve and return the entity-specific container factory.
	 *
	 * This method lazily resolves the {@see ContainerFactory} associated with the
	 * current entity and caches it for subsequent calls.
	 *
	 * Responsibilities:
	 * - Validate that a target entity is available.
	 * - Resolve the corresponding entity factory via the global Factory resolver.
	 * - Guarantee a non-null, fully initialized factory instance.
	 *
	 * The returned factory is expected to act as the primary entry point for
	 * resolving entity-scoped services (e.g. message bus, builders, repositories).
	 *
	 * @return class-string<ContainerFactory>
	 *
	 * @throws \InvalidArgumentException If no entity is defined or the factory cannot be resolved.
	 * @throws \RuntimeException         If an unexpected error occurs during factory resolution.
	 *
	 * @since  5.1.4
	 */
	protected function getFactory(): string
	{
		$entity = $this->getEntity();

		if (empty($entity))
		{
			throw new \InvalidArgumentException(
				'Unable to resolve entity factory: no entity was provided.'
			);
		}

		return $this->getEntityFactory($entity);
	}

	/**
	 * Resolve and return (any) entity-specific container factory.
	 *
	 * This method lazily resolves the {@see ContainerFactory} associated with the
	 * current entity and caches it for subsequent calls.
	 *
	 * Responsibilities:
	 * - Validate that a target entity is available.
	 * - Resolve the corresponding entity factory via the global Factory resolver.
	 * - Guarantee a non-null, fully initialized factory instance.
	 *
	 * The returned factory is expected to act as the primary entry point for
	 * resolving entity-scoped services (e.g. message bus, builders, repositories).
	 *
	 * @param   string   $entity   The entity for which a factory container is requested.
	 *
	 * @return class-string<ContainerFactory>
	 *
	 * @throws \InvalidArgumentException If no entity is defined or the factory cannot be resolved.
	 * @throws \RuntimeException         If an unexpected error occurs during factory resolution.
	 *
	 * @since  5.1.4
	 */
	protected function getEntityFactory(string $entity): string
	{
		if (!empty($this->entityFactory[$entity]))
		{
			return $this->entityFactory[$entity];
		}

		try
		{
			$this->entityFactory[$entity] = PowerfulFactory::getEntityFactory($entity);
		}
		catch (\Throwable $e)
		{
			throw new \RuntimeException(
				sprintf('An error occurred while resolving the factory for entity "%s".', $entity), 0, $e
			);
		}

		if ($this->entityFactory[$entity] === null)
		{
			throw new \InvalidArgumentException(
				sprintf('No factory is registered for entity "%s".', $entity)
			);
		}

		return $this->entityFactory[$entity];
	}

	/**
	 * Get any class from the entity container
	 *
	 * @param   string        $class    The class alias in the entity container.
	 * @param   string|null   $entity   The entity for which a factory container is requested.
	 *
	 * @return mixed  can be any class in the (any) entity container
	 *
	 * @throws \RuntimeException     If required services cannot be created from the factory.
	 *
	 * @since  5.1.4
	 */
	protected function getEntityClass(string $alias, ?string $entity = null): mixed
	{
		if ($entity === null)
		{
			$factory = $this->getFactory();
		}
		else
		{
			$factory = $this->getEntityFactory($entity);
		}

		$entity ??= $this->getEntity();

		try
		{
			return $factory::_($alias);
		}
		catch (\Throwable $e)
		{
			throw new \RuntimeException(
				sprintf('Failed to initialize [%s] class for the [%s] container.', $alias, $entity), 0, $e
			);
		}
	}

	/**
	 * Resolve and return (any) entity-specific area.
	 *
	 * @param   string   $entity   The entity for which a area is requested.
	 *
	 * @return string|null   The area name
	 *
	 * @since  5.1.4
	 */
	protected function getEntityArea(string $entity): ?string
	{
		return PowerfulFactory::getArea($entity);
	}
}

