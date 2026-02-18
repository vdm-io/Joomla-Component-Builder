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

namespace VDM\Joomla\Interfaces\Import;


/**
 * Base import entity configuration interface.
 * 
 * Defines the shared configuration contract used to prime the import engine
 *    for a specific view and import context.
 * 
 * This interface is intentionally explicit: every configuration value has
 *    its own getter and setter.
 * 
 * @since  5.1.4
 */
interface EntityInterface
{
	/* ==========================================================================
	 * Starting Row
	 * ========================================================================== */

	/**
	 * Get the starting row number of the import.
	 *
	 * This determines from which row the import engine begins reading data
	 * (for example, skipping header rows in spreadsheets).
	 *
	 * @return int
	 * @since  5.1.4
	 */
	public function getStartingRow(): int;

	/**
	 * Get the minimal columns number.
	 *
	 * @return int
	 * @since  5.1.4
	 */
	public function getMinimalColumns(): int;

	/**
	 * Set the starting row number of the import.
	 *
	 * @param  int  $row  The starting row (must be >= 1).
	 *
	 * @return self
	 * @since  5.1.4
	 */
	public function setStartingRow(int $row): self;

	/**
	 * Set the minimal columns number.
	 *
	 * @param  int  $number  The minimal columns number (must be >= 1).
	 *
	 * @return self
	 * @since  5.1.4
	 */
	public function setMinimalColumns(int $number): self;

	/* ==========================================================================
	 * Parent Table Configuration
	 * ========================================================================== */

	/**
	 * Get the parent table name for each imported row.
	 *
	 * This represents the primary table the import is targeting.
	 *
	 * @return string
	 * @since  5.1.4
	 */
	public function getParentTable(): string;

	/**
	 * Set the parent table name for each imported row.
	 *
	 * @param  string  $table  The parent table name.
	 *
	 * @return self
	 * @since  5.1.4
	 */
	public function setParentTable(string $table): self;

	/**
	 * Get the parent table key field.
	 *
	 * This is the primary identifier used to uniquely identify records
	 * in the parent table (e.g. `id`, `guid`).
	 *
	 * @return string
	 * @since  5.1.4
	 */
	public function getParentKey(): string;

	/**
	 * Set the parent table key field.
	 *
	 * @param  string  $key  The parent key field name.
	 *
	 * @return self
	 * @since  5.1.4
	 */
	public function setParentKey(string $key): self;

	/**
	 * Get the parent join key field.
	 *
	 * This field is used to join the parent table to related tables
	 * during import processing.
	 *
	 * @return string
	 * @since  5.1.4
	 */
	public function getParentJoinKey(): string;

	/**
	 * Set the parent join key field.
	 *
	 * @param  string  $key  The join key field name.
	 *
	 * @return self
	 * @since  5.1.4
	 */
	public function setParentJoinKey(string $key): self;

	/**
	 * Get the link field used to associate imported rows with existing data.
	 *
	 * This field is typically used to detect updates vs inserts.
	 *
	 * @return string
	 * @since  5.1.4
	 */
	public function getLinkField(): string;

	/**
	 * Set the link field used to associate imported rows with existing data.
	 *
	 * @param  string  $field  The link field name.
	 *
	 * @return self
	 * @since  5.1.4
	 */
	public function setLinkField(string $field): self;

	/* ==========================================================================
	 * Data Mapping
	 * ========================================================================== */

	/**
	 * Get the data key used within the import payload.
	 *
	 * This key identifies the main data section inside the import structure.
	 *
	 * @return string
	 * @since  5.1.4
	 */
	public function getDataKey(): string;

	/**
	 * Set the data key used within the import payload.
	 *
	 * @param  string  $key  The data key.
	 *
	 * @return self
	 * @since  5.1.4
	 */
	public function setDataKey(string $key): self;

	/**
	 * Get the join tables key fields map.
	 *
	 * Defines how related tables link back to the parent entity
	 * during the import process.
	 *
	 * @return array
	 * @since  5.1.4
	 */
	public function getJoinFields(): array;

	/**
	 * Set the join tables key fields map.
	 *
	 * @param  array  $map  The join key fields configuration.
	 *
	 *  Example: [
	 *       'table' => ['link_fields' => ['field']]
	 *  ]
	 *
	 * @return self
	 * @since  5.1.4
	 */
	public function setJoinFields(array $map): self;
}

