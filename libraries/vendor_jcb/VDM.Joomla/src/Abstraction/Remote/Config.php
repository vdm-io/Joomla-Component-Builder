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


use VDM\Joomla\Componentbuilder\Power\Interfaces\TableInterface as Table;
use VDM\Joomla\Interfaces\Remote\ConfigInterface;


/**
 * Remote Base Config Shared by get and set methods
 * 
 * @since 5.1.1
 */
abstract class Config implements ConfigInterface
{
	/**
	 * The Table Class.
	 *
	 * @var   Table
	 * @since 5.1.1
	 */
	protected Table $core;

	/**
	 * Table Name
	 *
	 * @var    string
	 * @since  3.2.1
	 */
	protected string $table;

	/**
	 * Area Name
	 *
	 * @var   string|null
	 * @since 3.2.2
	 */
	protected ?string $area = null;

	/**
	 * Prefix Key
	 *
	 * @var    string
	 * @since 3.2.2
	 */
	protected string $prefix_key = '';

	/**
	 * Suffix Key
	 *
	 * @var    string
	 * @since 3.2.2
	 */
	protected string $suffix_key = '';

	/**
	 * The main readme file path
	 *
	 * @var    string
	 * @since  5.1.1
	 */
	protected string $main_readme_path = 'README.md';

	/**
	 * The item readme file name
	 *
	 * @var    string
	 * @since  5.1.1
	 */
	protected string $item_readme_name = 'README.md';

	/**
	 * The index file path (index of all items)
	 *
	 * @var    string
	 * @since 3.2.2
	 */
	protected string $index_path = 'index.json';

	/**
	 * The item (files) source path
	 *
	 * @var    string
	 * @since  5.1.1
	 */
	protected string $src_path = 'src';

	/**
	 * The item settings file name (item data)
	 *
	 * @var   string
	 * @since 3.2.2
	 */
	protected string $settings_name = 'item.json';

	/**
	 * The item guid=unique field
	 *
	 * @var    string
	 * @since  5.1.1
	 */
	protected string $guid_field = 'guid';

	/**
	 * The ignore fields
	 *
	 * @var   array
	 * @since  5.1.1
	 */
	protected array $ignore = ['access'];

	/**
	 * The files (to map target files to move in an entity)
	 *
	 *   Use a pipe in the name to denote
	 *   subform location of the value
	 *      format: [field_name, field_name|subfrom_key]
	 *
	 * @var   array
	 * @since  5.1.1
	 */
	protected array $files = [];

	/**
	 * The folders (to map target folders to move in an entity)
	 *
	 *   Use a pipe in the name to denote
	 *   subform location of the value
	 *      format: [field_name, field_name|subfrom_key]
	 *
	 * @var   array
	 * @since  5.1.1
	 */
	protected array $folders = [];

	/**
	 * The item map
	 *
	 * @var   array
	 * @since 3.2.2
	 */
	protected array $map = [];

	/**
	 * The direct entities/children of this entity
	 *
	 * @var    array
	 * @since  5.1.1
	 */
	protected array $children = [];

	/**
	 * The index map
	 *    must always have: [name,path,settings,guid]
	 *    you can add more
	 *
	 * @var    array
	 * @since  5.0.3
	 */
	protected array $index_map = [
		'name' => 'index_map_IndexName',
		'path' => 'index_map_IndexPath',
		'settings' => 'index_map_IndexSettingsPath',
		'guid' => 'index_map_IndexGUID'
	];

	/**
	 * The index header
	 *    mapping the index map to a table
	 *    must always have: [name,path,settings,guid,local]
	 *    with [name] always first
	 *    with [path,settings,guid,local] always last
	 *    you can add more in between
	 *
	 * @var    array
	 * @since  5.1.1
	 */
	protected array $index_header = [
		'name',
		// from here you can add more
		'path',
		'settings',
		'guid',
		'local'
	];

	/**
	 * Core Placeholders
	 *
	 * @var    array
	 * @since  5.0.3
	 */
	protected array $placeholders = [];

	/**
	 * Constructor.
	 *
	 * @param Table   $core   The Core Table Class.
	 *
	 * @since 5.1.1
	 */
	public function __construct(Table $core)
	{
		$this->core = $core;
	}

	/**
	 * Get core placeholders
	 *
	 * @return  array
	 * @since   5.1.1
	 */
	public function getPlaceholders(): array
	{
		return $this->placeholders;
	}

	/**
	 * Set the current active table
	 *
	 * @param string $table The table that should be active
	 *
	 * @return self
	 * @since  3.2.2
	 */
	public function table(string $table): self
	{
		$this->table = $table;

		return $this;
	}

	/**
	 * Get the current active table
	 *
	 * @return  string
	 * @since   3.2.2
	 */
	public function getTable(): string
	{
		return $this->table;
	}

	/**
	 * Set the current active area
	 *
	 * @param string $area The area that should be active
	 *
	 * @return self
	 * @since 3.2.2
	 */
	public function area(string $area): self
	{
		$this->area = ucfirst(str_replace('_', ' ', $area));

		return $this;
	}

	/**
	 * Get the current active area
	 *
	 * @return  string|null
	 * @since 3.2.2
	 */
	public function getArea(): ?string
	{
		return $this->area;
	}

	/**
	 * Set the settings file name
	 *
	 * @param string    $settingsName    The repository settings path
	 *
	 * @return self
	 * @since 3.2.2
	 */
	public function setSettingsName(string $settingsName): self
	{
		$this->settings_name = $settingsName;

		return $this;
	}

	/**
	 * Get the settings file name
	 *
	 * @return string
	 * @since 3.2.2
	 */
	public function getSettingsName(): string
	{
		return $this->settings_name;
	}

	/**
	 * Set the index path
	 *
	 * @param string    $indexPath    The repository index path
	 *
	 * @return void
	 * @since 3.2.2
	 */
	public function setIndexPath(string $indexPath): void
	{
		$this->index_path = $indexPath;
	}

	/**
	 * Get the index path
	 *
	 * @return string
	 * @since 3.2.2
	 */
	public function getIndexPath(): string
	{
		return $this->index_path;
	}

	/**
	 * Get index map
	 *
	 * @return array
	 * @since  5.1.1
	 */
	public function getIndexMap(): array
	{
		return $this->index_map;
	}

	/**
	 * Get index header
	 *
	 * @return array
	 * @since  5.1.1
	 */
	public function getIndexHeader(): array
	{
		return $this->index_header;
	}

	/**
	 * Get src path
	 *
	 * @return string
	 * @since  5.1.1
	 */
	public function getSrcPath(): string
	{
		return $this->src_path;
	}

	/**
	 * Get main readme path
	 *
	 * @return string
	 * @since  5.1.1
	 */
	public function getMainReadmePath(): string
	{
		return $this->main_readme_path;
	}

	/**
	 * Has main readme
	 *
	 * @return bool
	 * @since  5.1.1
	 */
	public function hasMainReadme(): bool
	{
		return !empty($this->main_readme_path);
	}

	/**
	 * Get item readme path
	 *
	 * @return string
	 * @since  5.1.1
	 */
	public function getItemReadmeName(): string
	{
		return $this->item_readme_name;
	}

	/**
	 * Has item readme
	 *
	 * @return bool
	 * @since  5.1.1
	 */
	public function hasItemReadme(): bool
	{
		return !empty($this->item_readme_name);
	}

	/**
	 * Get the field names of the files in the entity
	 *
	 * @return array
	 * @since  5.1.1
	 */
	public function getFiles(): array
	{
		return $this->files;
	}

	/**
	 * Get the field names of the folders in the entity
	 *
	 * @return array
	 * @since  5.1.1
	 */
	public function getFolders(): array
	{
		return $this->folders;
	}

	/**
	 * Get map
	 *
	 * Builds (and caches) an associative map of the table’s field names,
	 * automatically removing any fields defined in $this->ignore.
	 *
	 * @return  array  Associative array in the form ['field' => 'field']
	 * @since   5.1.1
	 */
	public function getMap(): array
	{
		// Only build once – cached in $this->map.
		if (empty($this->map))
		{
			// Fetch raw field list from the core service.
			$map = $this->core->fields($this->getTable());

			if ($map)
			{
				// Ensure $this->ignore is an array; default to empty otherwise.
				$ignore = is_array($this->ignore ?? null) ? $this->ignore : [];

				// Remove ignored fields, preserving the original order.
				$map = array_values(array_diff($map, $ignore));

				// Convert to the required ['field' => 'field'] structure.
				$this->map = array_combine($map, $map);
			}
			else
			{
				$this->map = [];
			}
		}

		return $this->map;
	}

	/**
	 * Get the direct entities/children of this entity
	 *
	 * @return array
	 * @since  5.1.1
	 */
	public function getChildren(): array
	{
		return $this->children;
	}

	/**
	 * Get the table title name field
	 *
	 * @return string
	 * @since  5.1.1
	 */
	public function getTitleName(): string
	{
		return $this->core->titleName($this->getTable());
	}

	/**
	 * Get GUID field
	 *
	 * @return string
	 * @since  5.1.1
	 */
	public function getGuidField(): string
	{
		return $this->guid_field;
	}

	/**
	 * Get Prefix Key
	 *
	 * @return string
	 * @since  5.1.1
	 */
	public function getPrefixKey(): string
	{
		return $this->prefix_key;
	}

	/**
	 * Get Suffix Key
	 *
	 * @return string
	 * @since  5.1.1
	 */
	public function getSuffixKey(): string
	{
		return $this->suffix_key;
	}
}

