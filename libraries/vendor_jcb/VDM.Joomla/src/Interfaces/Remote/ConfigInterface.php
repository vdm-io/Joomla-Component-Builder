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

namespace VDM\Joomla\Interfaces\Remote;


/**
 * Configure  remote interface
 * 
 * @since 5.1.1
 */
interface ConfigInterface
{
	/**
	 * Get core placeholders
	 *
	 * @return  array
	 * @since   5.1.1
	 */
	public function getPlaceholders(): array;

	/**
	 * Set the current active table
	 *
	 * @param string $table The table that should be active
	 *
	 * @return self
	 * @since  3.2.2
	 */
	public function table(string $table): self;

	/**
	 * Get the current active table
	 *
	 * @return  string
	 * @since   3.2.2
	 */
	public function getTable(): string;

	/**
	 * Get the current active table list view code name
	 *
	 * @return  string|null
	 * @since   5.1.2
	 */
	public function getListViewCodeName(): ?string;

	/**
	 * Set the current active area
	 *
	 * @param string $area The area that should be active
	 *
	 * @return self
	 * @since 3.2.2
	 */
	public function area(string $area): self;

	/**
	 * Get the current active area
	 *
	 * @return  string|null
	 * @since 3.2.2
	 */
	public function getArea(): ?string;

	/**
	 * Set the settings file name
	 *
	 * @param string    $settingsName   The repository settings file name
	 *
	 * @return self
	 * @since 3.2.2
	 */
	public function setSettingsName(string $settingsName): self;

	/**
	 * Get the settings file name
	 *
	 * @return string
	 * @since 3.2.2
	 */
	public function getSettingsName(): string;

	/**
	 * Set the index path
	 *
	 * @param string    $indexPath    The repository index path
	 *
	 * @return void
	 * @since 3.2.2
	 */
	public function setIndexPath(string $indexPath): void;

	/**
	 * Get the index path
	 *
	 * @return string
	 * @since 3.2.2
	 */
	public function getIndexPath(): string;

	/**
	 * Get index map
	 *
	 * @return array
	 * @since  5.1.1
	 */
	public function getIndexMap(): array;

	/**
	 * Get index header
	 *
	 * @return array
	 * @since  5.1.1
	 */
	public function getIndexHeader(): array;

	/**
	 * Get src path
	 *
	 * @return string
	 * @since  5.1.1
	 */
	public function getSrcPath(): string;

	/**
	 * Get main readme path
	 *
	 * @return string
	 * @since  5.1.1
	 */
	public function getMainReadmePath(): string;

	/**
	 * Has main readme
	 *
	 * @return bool
	 * @since  5.1.1
	 */
	public function hasMainReadme(): bool;

	/**
	 * Get item readme path
	 *
	 * @return string
	 * @since  5.1.1
	 */
	public function getItemReadmeName(): string;

	/**
	 * Has item readme
	 *
	 * @return bool
	 * @since  5.1.1
	 */
	public function hasItemReadme(): bool;

	/**
	 * Get the field names of the files in the entity
	 *
	 * @return array
	 * @since  5.1.1
	 */
	public function getFiles(): array;

	/**
	 * Get the field names of the folders in the entity
	 *
	 * @return array
	 * @since  5.1.1
	 */
	public function getFolders(): array;

	/**
	 * Get map
	 *
	 * Builds (and caches) an associative map of the table’s field names,
	 * automatically removing any fields defined in $this->ignore.
	 *
	 * @return  array  Associative array in the form ['field' => 'field']
	 * @since   5.1.1
	 */
	public function getMap(): array;

	/**
	 * Get the direct entities/children of this entity
	 *
	 * @return array
	 * @since  5.1.1
	 */
	public function getChildren(): array;

	/**
	 * Get the table title name field
	 *
	 * @return string
	 * @since  5.1.1
	 */
	public function getTitleName(): string;

	/**
	 * Get GUID field
	 *
	 * @return string
	 * @since  5.1.1
	 */
	public function getGuidField(): string;

	/**
	 * Get Prefix Key
	 *
	 * @return string
	 * @since  5.1.1
	 */
	public function getPrefixKey(): string;

	/**
	 * Get Suffix Key
	 *
	 * @return string
	 * @since  5.1.1
	 */
	public function getSuffixKey(): string;
}

