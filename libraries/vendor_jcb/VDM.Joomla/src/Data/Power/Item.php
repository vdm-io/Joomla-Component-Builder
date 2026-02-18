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

namespace VDM\Joomla\Data\Power;


use VDM\Joomla\Componentbuilder\FactoryTrait;
use VDM\Joomla\Interfaces\Data\ItemInterface as Data;
use VDM\Joomla\Componentbuilder\Package\Builder\Get;
use VDM\Joomla\Componentbuilder\Package\Builder\Set;


/**
 * Power Data Item
 * 
 * @since 5.1.4
 */
final class Item implements Data
{
	/**
	 * The factory trait methods
	 * @since 5.1.4
	 */
	use FactoryTrait;

	/**
	 * The state of retry to loaded stuff
	 *
	 * @var    array
	 * @since  5.1.4
	 **/
	protected array $retry = [];

	/**
	 * Get the first ID of the most recent action.
	 *
	 * This method returns the first resolved entity ID from the most recent
	 * INSERT or UPDATE action. If no IDs are available or the active action
	 * is not supported, 0 is returned.
	 *
	 * Behaviour notes:
	 * - Only INSERT and UPDATE actions are supported.
	 * - The internal ID bucket of the active action is reset after retrieval.
	 * - The returned ID represents the first affected entity in the batch.
	 *
	 * @return  int  The entity ID, or 0 if unavailable.
	 *
	 * @since   5.1.4
	 */
	public function id(): int
	{
		return $this->data()->id();
	}

	/**
	 * Set the current active table
	 *
	 * @param string  $table The table that should be active
	 *
	 * @return self
	 * @since  5.1.4
	 */
	public function table(string $table): self
	{
		$this->setEntity($table)->data()->table($table);

		return $this;
	}

	/**
	 * Get an item
	 *
	 * @param string   $value   The item key value
	 * @param string   $key     The item key
	 *
	 * @return object|null The item object or null
	 * @since  5.1.4
	 */
	public function get(string $value, string $key = 'guid'): ?object
	{
		$entity = $this->getEntity();

		$object = $this->data()->table($entity)->get($value, $key);

		if ($object === null && $this->getRemote($value, $key))
		{
			return $this->get($value, $key);
		}

		return $object;
	}

	/**
	 * Get the value
	 *
	 * @param string   $value   The item key value
	 * @param string   $key     The item key
	 * @param string   $get     The key of the values we want back
	 *
	 * @return mixed
	 * @since  5.1.4
	 */
	public function value(string $value, string $key = 'guid', string $get = 'id')
	{
		$entity = $this->getEntity();

		$returnValue = $this->data()->table($entity)->value($value, $key, $get);

		if ($returnValue === null && $this->getRemote($value, $key))
		{
			return $this->value($value, $key, $get);
		}

		return $returnValue;
	}

	/**
	 * Set an item
	 *
	 * @param object       $item    The item
	 * @param string       $key     The item key
	 * @param string|null  $action  The action to load power
	 *
	 * @return bool
	 * @since  5.1.4
	 */
	public function set(object $item, string $key = 'guid', ?string $action = null): bool
	{
		$entity = $this->getEntity();

		$local = $this->data()->table($entity)->set($item, $key, $action);

		if ($local)
		{
			$this->setRemote($item->$key);

			return true;
		}

		return false;
	}

	/**
	 * Delete an item
	 *
	 * @param string   $value   The item key value
	 * @param string   $key     The item key
	 *
	 * @return bool
	 * @since   5.1.4
	 */
	public function delete(string $value, string $key = 'guid'): bool
	{
		$entity = $this->getEntity();

		// we only delete locally
		return $this->data()->table($entity)->delete($value, $key);
	}

	/**
	 * Get the current active table (entity)
	 *
	 * @return  string
	 * @since   5.1.4
	 */
	public function getTable(): string
	{
		return $this->getEntity();
	}

	/**
	 * Get an item remotely
	 *
	 * @param string   $value   The item key value
	 * @param string   $key     The item key
	 *
	 * @return bool   TRUE When a remote get was performed
	 * @since  5.1.4
	 */
	private function getRemote(string $value, string $key = 'guid'): bool
	{
		$entity = $this->getEntity();
		$retryKey = "{$entity}.{$key}.{$value}";

		if (empty($this->retry[$retryKey]))
		{
			$this->getPower()->get($entity, [$value]);
			$this->retry[$retryKey] = 1;
			return true;
		}
		return false;
	}

	/**
	 * Set an item remotely
	 *
	 * @param string   $value   The item key value
	 *
	 * @return void
	 * @since  5.1.4
	 */
	private function setRemote(string $value): void
	{
		$entity = $this->getEntity();

		$this->setPower()->items($entity, [$value]);
	}

	/**
	 * Get the item (data) class for any entity.
	 *
	 * @return Data
	 *
	 * @since  5.1.4
	 */
	protected function data(): Data
	{
		return $this->getEntityClass('Data.Item');
	}

	/**
	 * Set the builder get class for any entity.
	 *
	 * @return Set
	 *
	 * @since  5.1.4
	 */
	protected function setPower(): Set
	{
		return $this->getEntityClass('Package.Builder.Set');
	}

	/**
	 * Get the builder get class for any entity.
	 *
	 * @return Get
	 *
	 * @since  5.1.4
	 */
	protected function getPower(): Get
	{
		return $this->getEntityClass('Package.Builder.Get');
	}
}

