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

namespace VDM\Joomla\Import;


use VDM\Joomla\Interfaces\Import\EntityInterface;


/**
 * Base import entity configuration.
 * 
 * Shared between transient and persistent import configurations.
 * 
 * @since  5.1.4
 */
class Entity implements EntityInterface
{
	/**
	 * The starting row.
	 *
	 * @var   int
	 * @since 5.1.4
	 */
	protected int $startingRow = 2;

	/**
	 * The minimal column number
	 *
	 * @var   int
	 * @since 5.1.4
	 */
	protected int $minimalColumns = 2;

	/**
	 * The parent table of each row.
	 *
	 * @var   string
	 * @since 5.1.4
	 */
	protected string $parentTable = '';

	/**
	 * The parent table key field.
	 *
	 * @var   string
	 * @since 5.1.4
	 */
	protected string $parentKey = '';

	/**
	 * The parent join key field to other tables.
	 *
	 * @var   string
	 * @since 5.1.4
	 */
	protected string $parentJoinKey = '';

	/**
	 * The parent table key field used to link rows to existing data.
	 *
	 * @var   string
	 * @since 5.1.4
	 */
	protected string $linkField = 'guid';

	/**
	 * The data key used inside the import payload.
	 *
	 * @var   string
	 * @since 5.1.4
	 */
	protected string $dataKey = 'import';

	/**
	 * Join tables key field map.
	 * That links an item to the existing item
	 *
	 * @var   array
	 * @since 5.1.4
	 */
	protected array $joinFields = [];

	/* ==========================================================================
	 * Getters
	 * ========================================================================== */

	/**
	 * Get the starting row.
	 *
	 * @return int
	 * @since  5.1.4
	 */
	public function getStartingRow(): int
	{
		return $this->startingRow;
	}

	/**
	 * Get the minimal columns number.
	 *
	 * @return int
	 * @since  5.1.4
	 */
	public function getMinimalColumns(): int
	{
		return $this->minimalColumns;
	}

	/**
	 * Get the parent table.
	 *
	 * @return string
	 * @since  5.1.4
	 */
	public function getParentTable(): string
	{
		return $this->parentTable;
	}

	/**
	 * Get the parent key field.
	 *
	 * @return string
	 * @since  5.1.4
	 */
	public function getParentKey(): string
	{
		return $this->parentKey;
	}

	/**
	 * Get the parent join key field.
	 *
	 * @return string
	 * @since  5.1.4
	 */
	public function getParentJoinKey(): string
	{
		return $this->parentJoinKey;
	}

	/**
	 * Get the link field.
	 *
	 * @return string
	 * @since  5.1.4
	 */
	public function getLinkField(): string
	{
		return $this->linkField;
	}

	/**
	 * Get the data key.
	 *
	 * @return string
	 * @since  5.1.4
	 */
	public function getDataKey(): string
	{
		return $this->dataKey;
	}

	/**
	 * Get the join tables key fields map.
	 *
	 * Defines how related tables link back to the parent entity
	 * during the import process.
	 *
	 * @return array
	 * @since  5.1.4
	 */
	public function getJoinFields(): array
	{
		return $this->joinFields;
	}

	/* ==========================================================================
	 * Setters
	 * ========================================================================== */

	/**
	 * Set the starting row.
	 *
	 * @param  int  $row
	 *
	 * @return self
	 * @since  5.1.4
	 *
	 * @throws  \InvalidArgumentException
	 */
	public function setStartingRow(int $row): self
	{
		if ($row < 1)
		{
			throw new \InvalidArgumentException('Starting row must be >= 1.');
		}

		$this->startingRow = $row;

		return $this;
	}

	/**
	 * Set the minimal columns number.
	 *
	 * @param  int  $number  The minimal columns number (must be >= 1).
	 *
	 * @return self
	 * @since  5.1.4
	 */
	public function setMinimalColumns(int $number): self
	{
		if ($number < 1)
		{
			throw new \InvalidArgumentException('Minimal columns must be >= 1.');
		}

		$this->minimalColumns = $number;

		return $this;
	}

	/**
	 * Set the parent table.
	 *
	 * @param  string  $table
	 *
	 * @return self
	 * @since  5.1.4
	 *
	 * @throws  \InvalidArgumentException
	 */
	public function setParentTable(string $table): self
	{
		if ($table === '')
		{
			throw new \InvalidArgumentException('Parent table cannot be empty.');
		}

		$this->parentTable = $table;

		return $this;
	}

	/**
	 * Set the parent key field.
	 *
	 * @param  string  $key
	 *
	 * @return self
	 * @since  5.1.4
	 *
	 * @throws  \InvalidArgumentException
	 */
	public function setParentKey(string $key): self
	{
		if ($key === '')
		{
			throw new \InvalidArgumentException('Parent key cannot be empty.');
		}

		$this->parentKey = $key;

		return $this;
	}

	/**
	 * Set the parent join key field.
	 *
	 * @param  string  $key
	 *
	 * @return self
	 * @since  5.1.4
	 *
	 * @throws  \InvalidArgumentException
	 */
	public function setParentJoinKey(string $key): self
	{
		if ($key === '')
		{
			throw new \InvalidArgumentException('Parent join key cannot be empty.');
		}

		$this->parentJoinKey = $key;

		return $this;
	}

	/**
	 * Set the link field.
	 *
	 * @param  string  $field
	 *
	 * @return self
	 * @since  5.1.4
	 *
	 * @throws  \InvalidArgumentException
	 */
	public function setLinkField(string $field): self
	{
		if ($field === '')
		{
			throw new \InvalidArgumentException('Link field cannot be empty.');
		}

		$this->linkField = $field;

		return $this;
	}

	/**
	 * Set the data key.
	 *
	 * @param  string  $key
	 *
	 * @return self
	 * @since  5.1.4
	 *
	 * @throws  \InvalidArgumentException
	 */
	public function setDataKey(string $key): self
	{
		if ($key === '')
		{
			throw new \InvalidArgumentException('Data key cannot be empty.');
		}

		$this->dataKey = $key;

		return $this;
	}

	/**
	 * Set the key join fields map.
	 *
	 * @param  array  $map
	 *
	 *  Example: [
	 *       'table' => ['link_fields' => ['field']]
	 *  ]
	 *
	 * @return self
	 * @since  5.1.4
	 */
	public function setJoinFields(array $map): self
	{
		$this->joinFields = $map;

		return $this;
	}
}

