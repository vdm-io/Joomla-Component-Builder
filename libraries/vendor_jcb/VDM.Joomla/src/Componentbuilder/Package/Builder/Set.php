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
 * Package Builder Set
 * 
 * @since 5.1.1
 */
class Set
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
	 * Save items remotely
	 *
	 * @param string  $entity   The target entity
	 * @param array   $guids    The global unique id of the item
	 *
	 * @return void
	 * @since  5.1.1
	 */
	public function items(string $entity, array $guids): void
	{
		if (($class = $this->entities->get($entity)) === null)
		{
			return;
		}

		$this->container->get("{$class}.Remote.Set")->items($guids);

		if (($dependencies = $this->tracker->get('set')) !== null)
		{
			$this->tracker->remove('set');
			foreach ($dependencies as $next_entity => $next_items)
			{
				$this->items($next_entity, $this->getGuids($next_items));
			}
		}

		if (($files = $this->tracker->get('file.set')) !== null)
		{
			$this->tracker->remove('file.set');
			$this->container->get("File.Remote.Set")->items($files);
		}

		if (($folders = $this->tracker->get('folder.set')) !== null)
		{
			$this->tracker->remove('folder.set');
			$this->container->get("Folder.Remote.Set")->items($folders);
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

