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


use VDM\Joomla\Interfaces\Remote\ConfigInterface as Config;
use VDM\Joomla\Interfaces\Remote\BaseInterface;


/**
 * Remote Base Shared by get and set methods
 * 
 * @since 5.1.1
 */
abstract class Base implements BaseInterface
{
	/**
	 * The Base Configure Class.
	 *
	 * @var   Config
	 * @since 5.1.1
	 */
	protected Config $config;

	/**
	 * Constructor.
	 *
	 * @param Config   $config   The configure class.
	 *
	 * @since 5.1.1
	 */
	public function __construct(Config $config)
	{
		$this->config = $config;
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
		$this->config->table($table);

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
		return $this->config->getTable();
	}

	/**
	 * Get the current active table list view code name
	 *
	 * @return  string|null
	 * @since   5.1.2
	 */
	public function getListViewCodeName(): ?string
	{
		return $this->config->getListViewCodeName();
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
		$this->config->area($area);

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
		return $this->config->getArea();
	}

	/**
	 * Set the settings file name
	 *
	 * @param string    $settingsName    The repository settings name
	 *
	 * @return self
	 * @since 3.2.2
	 */
	public function setSettingsName(string $settingsName): self
	{
		$this->config->setSettingsName($settingsName);

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
		return $this->config->getSettingsName();
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
		$this->config->setIndexPath($indexPath);
	}

	/**
	 * Get the index path
	 *
	 * @return string
	 * @since 3.2.2
	 */
	public function getIndexPath(): string
	{
		return $this->config->getIndexPath();
	}

	/**
	 * Get core placeholders
	 *
	 * @return  array
	 * @since   5.1.1
	 */
	public function getPlaceholders(): array
	{
		return $this->config->getPlaceholders();
	}

	/**
	 * Get index map
	 *
	 * @return array
	 * @since  5.1.1
	 */
	public function getIndexMap(): array
	{
		return $this->config->getIndexMap();
	}

	/**
	 * Get index header
	 *
	 * @return array
	 * @since  5.1.1
	 */
	public function getIndexHeader(): array
	{
		return $this->config->getIndexHeader();
	}

	/**
	 * Get src path
	 *
	 * @return string
	 * @since  5.1.1
	 */
	public function getSrcPath(): string
	{
		return $this->config->getSrcPath();
	}

	/**
	 * Get the field names of the files in the entity
	 *
	 * @return array
	 * @since  5.1.1
	 */
	public function getFiles(): array
	{
		return $this->config->getFiles();
	}

	/**
	 * Get the field names of the folders in the entity
	 *
	 * @return array
	 * @since  5.1.1
	 */
	public function getFolders(): array
	{
		return $this->config->getFolders();
	}

	/**
	 * Get map
	 *
	 * @return array
	 * @since  5.1.1
	 */
	public function getMap(): array
	{
		return $this->config->getMap();
	}

	/**
	 * Get the [direct] entities/children of this entity
	 *
	 * @return array
	 * @since  5.1.1
	 */
	public function getChildren(): array
	{
		return $this->config->getChildren();
	}

	/**
	 * Get the table title name field
	 *
	 * @return string
	 * @since  5.1.1
	 */
	public function getTitleName(): string
	{
		return $this->config->getTitleName();
	}

	/**
	 * Get GUID field
	 *
	 * @return string
	 * @since  5.1.1
	 */
	public function getGuidField(): string
	{
		return $this->config->getGuidField();
	}

	/**
	 * Get main readme path
	 *
	 * @return string
	 * @since  5.1.1
	 */
	public function getMainReadmePath(): string
	{
		return $this->config->getMainReadmePath();
	}

	/**
	 * Has main readme
	 *
	 * @return bool
	 * @since  5.1.1
	 */
	public function hasMainReadme(): bool
	{
		return $this->config->hasMainReadme();
	}

	/**
	 * Get item readme path
	 *
	 * @return string
	 * @since  5.1.1
	 */
	public function getItemReadmeName(): string
	{
		return $this->config->getItemReadmeName();
	}

	/**
	 * Has item readme
	 *
	 * @return bool
	 * @since  5.1.1
	 */
	public function hasItemReadme(): bool
	{
		return $this->config->hasItemReadme();
	}

	/**
	 * Get Prefix Key
	 *
	 * @return string
	 * @since  5.1.1
	 */
	public function getPrefixKey(): string
	{
		return $this->config->getPrefixKey();
	}

	/**
	 * Get Suffix Key
	 *
	 * @return string
	 * @since  5.1.1
	 */
	public function getSuffixKey(): string
	{
		return $this->config->getSuffixKey();
	}

	/**
	 * Map a single item to its properties
	 *
	 * @param object $item The item to be mapped
	 *
	 * @return object
	 * @since 3.2.2
	 */
	public function mapItem(object $item): object
	{
		$power = [];
		$mapper = $this->getMap();
		foreach ($mapper as $key => $map)
		{
			$methodName = "mapItemValue_{$key}";
			if (method_exists($this, $methodName))
			{
				$this->{$methodName}($item, $power);
			}
			elseif (!isset($power[$key]))
			{
				$power[$key] = $item->{$map} ?? null;
			}
		}

		return (object) $power;
	}

	/**
	 * Get index values
	 *
	 * @param object  $item  The item
	 *
	 * @return array|null
	 * @since  3.2.2
	 */
	public function getIndexItem(object $item): ?array
	{
		$index_map = $this->getIndexMap();
		if (empty($index_map))
		{
			return null;
		}

		$index_item = [];
		foreach ($index_map as $key => $function_name)
		{
			if (method_exists($this, $function_name))
			{
				$index_item[$key] = $this->{$function_name}($item);
			}
		}

		return $index_item ?? null;
	}

	//// index_map_ (area) /////////////////////////////////////////////

	/**
	 * Get the item name for the index values
	 *
	 * @param object $item
	 *
	 * @return string|null
	 * @since 3.2.2
	 */
	protected function index_map_IndexName(object $item): ?string
	{
		$field = $this->getTitleName();
		return $item->{$field} ?? null;
	}

	/**
	 * Get the item Short Description for the index values
	 *
	 * @param object $item
	 *
	 * @return string|null
	 * @since  5.0.3
	 */
	protected function index_map_ShortDescription(object $item): ?string
	{
		return $item->short_description ?? $item->description ?? null;
	}

	/**
	 * Get the item settings path for the index values
	 *
	 * @param object $item
	 *
	 * @return string
	 * @since 3.2.2
	 */
	protected function index_map_IndexSettingsPath(object $item): string
	{
		$index_path = $this->index_map_IndexPath($item);
		$settings_name = $this->getSettingsName();

		return !empty($settings_name)
			? "{$index_path}/{$settings_name}"
			: $index_path;
	}

	/**
	 * Get the item path for the index values
	 *
	 * @param object $item
	 *
	 * @return string
	 * @since 3.2.2
	 */
	protected function index_map_IndexPath(object $item): string
	{
		$src_path = $this->getSrcPath();
		$key = $this->index_map_IndexGUID($item);
		return "{$src_path}/{$key}";
	}

	/**
	 * Get the item readme path for the index values
	 *
	 * @param object $item
	 *
	 * @return string
	 * @since  5.1.1
	 */
	protected function index_map_IndexReadmePath(object $item): string
	{
		$index_path = $this->index_map_IndexPath($item);
		$readme = $this->getItemReadmeName();

		return !empty($readme)
			? "{$index_path}/{$readme}"
			: "{$index_path}.md";
	}

	/**
	 * Get the item [POWER KEY] for the index values
	 *
	 * @param object $item
	 *
	 * @return string
	 * @since 3.2.2
	 */
	protected function index_map_IndexKey(object $item): string
	{
		$prefix_key = $this->getPrefixKey();
		$suffix_key = $this->getSuffixKey();
		$key = $this->index_map_IndexGUID($item);
		$key = str_replace('-', '_', $key);

		return "{$prefix_key}{$key}{$suffix_key}";
	}

	/**
	 * Get the item GUID for the index values
	 *
	 * @param object $item
	 *
	 * @return string
	 * @since 3.2.2
	 */
	protected function index_map_IndexGUID(object $item): string
	{
		$guid_field = $this->getGuidField();

		return  $item->{$guid_field} ?? $item->guid ?? 'missing-guid';
	}
}

