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

namespace VDM\Joomla\Componentbuilder\Import;


use VDM\Joomla\Interfaces\Data\ItemInterface as Item;
use VDM\Joomla\Interfaces\Import\StatusInterface;


/**
 * Import Status Class
 * 
 * @since  5.0.2
 */
final class Status implements StatusInterface
{
	/**
	 * The Item Class.
	 *
	 * @var   Item
	 * @since 5.0.2
	 */
	protected Item $item;

	/**
	 * Table Name
	 *
	 * @var    string
	 * @since 5.0.2
	 */
	protected string $table;

	/**
	 * Status Field Name
	 *
	 * @var    string
	 * @since 5.0.2
	 */
	protected string $fieldName;

	/**
	 * Constructor.
	 *
	 * @param Item   $item   The Item Class.
	 * @param string|null $table    The table name
	 * @param string|null $field    The field name.
	 *
	 * @since 5.0.2
	 */
	public function __construct(Item $item, ?string $table = null, ?string $field = null)
	{
		$this->item = $item;

		if ($table !== null)
		{
			$this->table = $table;
		}

		if ($field !== null)
		{
			$this->field = $field;
		}
	}

	/**
	 * Updates the status in the database.
	 *
	 * This method updates the import status in the database based on the result of the import process.
	 *
	 * @param int     $status  The status code to set for the import
	 * @param string  $value   The target status value
	 * @param string  $key     The target key [default: `guid`]
	 *
	 * @return void
	 * @since  5.0.2
	 */
	public function set(int $status, string $value, $key = 'guid'): void
	{
		$this->item->table($this->getTable())->set((object) [
			$key => $value,
			$this->getField() => $status
		]);
	}

	/**
	 * Set the current active table
	 *
	 * @param string  $table The table that should be active
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
	 * Set the current target status field name
	 *
	 * @param string  $fieldName The field name where the status is set
	 *
	 * @return self
	 * @since 3.2.2
	 */
	public function field(string $fieldName): self
	{
		$this->fieldName = $fieldName;

		return $this;
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

	/**
	 * Get the current target status field name
	 *
	 * @return string
	 * @since 3.2.2
	 */
	public function getField(): string
	{
		return $this->fieldName;
	}
}

