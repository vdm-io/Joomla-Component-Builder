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


use VDM\Joomla\Interfaces\GrepInterface as Grep;
use VDM\Joomla\Interfaces\Data\ItemInterface as Item;
use VDM\Joomla\Interfaces\Remote\GetInterface;


/**
 * Get data based on global unique ids from remote system
 * 
 * @since 3.2.0
 */
abstract class Get implements GetInterface
{
	/**
	 * The Grep Class.
	 *
	 * @var   Grep
	 * @since 3.2.0
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
	 * Table Name
	 *
	 * @var    string
	 * @since 3.2.1
	 */
	protected string $table;

	/**
	 * Constructor.
	 *
	 * @param Grep   $grep   The GrepInterface Class.
	 * @param Item   $item   The ItemInterface Class.
	 * @param string|null $table      The table name.
	 *
	 * @since 3.2.0
	 */
	public function __construct(Grep $grep, Item $item, ?string $table = null)
	{
		$this->grep = $grep;
		$this->item = $item;
		if ($table !== null)
		{
			$this->table = $table;
		}
	}

	/**
	 * Set the current active table
	 *
	 * @param string $table The table that should be active
	 *
	 * @return self
	 * @since 3.2.2
	 */
	public function table(string $table): self
	{
		$this->table = $table;

		return $this;
	}

	/**
	 * Init all items not found in database
	 *
	 * @return bool
	 * @since 3.2.0
	 */
	public function init(): bool
	{
		if (($items = $this->grep->getRemoteGuid()) !== null)
		{
			foreach($items as $guid)
			{
				if ($this->item->table($this->getTable())->value($guid) === null &&
					($item = $this->grep->get($guid, ['remote'])) !== null)
				{
					$this->item->set($item);
				}
			}

			return true;
		}

		return false;
	}

	/**
	 * Reset the items
	 *
	 * @param array   $items    The global unique ids of the items
	 *
	 * @return bool
	 * @since 3.2.0
	 */
	public function reset(array $items): bool
	{
		if ($items === [])
		{
			return false;
		}

		$success = true;

		foreach($items as $guid)
		{
			if (!$this->item($guid, ['remote']))
			{
				$success = false;
			}
		}

		return $success;
	}

	/**
	 * Load an item
	 *
	 * @param string   $guid    The global unique id of the item
	 * @param array    $order   The search order
	 * @param string|null   $action  The action to load power
	 *
	 * @return bool
	 * @since 3.2.0
	 */
	public function item(string $guid, array $order = ['remote', 'local'], ?string $action = null): bool
	{
		if (($item = $this->grep->get($guid, $order)) !== null)
		{
			return $this->item->table($this->getTable())->set($item);
		}

		return false;
	}

	/**
	 * Get the current active table
	 *
	 * @return  string
	 * @since 3.2.2
	 */
	public function getTable(): string
	{
		return $this->table;
	}
}

