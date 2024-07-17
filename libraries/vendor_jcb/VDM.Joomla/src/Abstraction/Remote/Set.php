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
use VDM\Joomla\Interfaces\Data\ItemsInterface as Items;
use VDM\Joomla\Interfaces\Readme\ItemInterface as ItemReadme;
use VDM\Joomla\Interfaces\Readme\MainInterface as MainReadme;
use VDM\Joomla\Interfaces\Git\Repository\ContentsInterface as Git;
use VDM\Joomla\Interfaces\Remote\SetInterface;


/**
 * Set data based on global unique ids to remote repository
 * 
 * @since 3.2.2
 */
abstract class Set implements SetInterface
{
	/**
	 * The Grep Class.
	 *
	 * @var   Grep
	 * @since 3.2.2
	 */
	protected Grep $grep;

	/**
	 * The Items Class.
	 *
	 * @var   Items
	 * @since 3.2.2
	 */
	protected Items $items;

	/**
	 * The Item Readme Class.
	 *
	 * @var   ItemReadme
	 * @since 3.2.2
	 */
	protected ItemReadme $itemReadme;

	/**
	 * The Main Readme Class.
	 *
	 * @var   MainReadme
	 * @since 3.2.2
	 */
	protected MainReadme $mainReadme;

	/**
	 * The Contents Class.
	 *
	 * @var   Git
	 * @since 3.2.2
	 */
	protected Git $git;

	/**
	 * All active repos
	 *
	 * @var   array
	 * @since 3.2.2
	 **/
	public array $repos;

	/**
	 * Table Name
	 *
	 * @var   string
	 * @since 3.2.2
	 */
	protected string $table;

	/**
	 * Area Name
	 *
	 * @var   string
	 * @since 3.2.2
	 */
	protected string $area;

	/**
	 * The item map
	 *
	 * @var   array
	 * @since 3.2.2
	 */
	protected array $map;

	/**
	 * The index map
	 *
	 * @var   array
	 * @since 3.2.2
	 */
	protected array $index_map;

	/**
	 * The repo main settings
	 *
	 * @var   array
	 * @since 3.2.2
	 */
	protected array $settings;

	/**
	 * Prefix Key
	 *
	 * @var    string
	 * @since 3.2.2
	 */
	protected string $prefix_key = 'Super---';

	/**
	 * Suffix Key
	 *
	 * @var    string
	 * @since 3.2.2
	 */
	protected string $suffix_key = '---Power';

	/**
	 * The item settings file path
	 *
	 * @var   string
	 * @since 3.2.2
	 */
	protected string $settings_path = 'item.json';

	/**
	 * The index settings file path
	 *
	 * @var    string
	 * @since 3.2.2
	 */
	protected string $index_settings_path = 'index.json';

	/**
	 * Constructor.
	 *
	 * @param array        $repos               The active repos
	 * @param Grep         $grep                The Grep Class.
	 * @param Items        $items               The Items Class.
	 * @param ItemReadme   $itemReadme          The Item Readme Class.
	 * @param MainReadme   $mainReadme          The Main Readme Class.
	 * @param Git          $git                 The Contents Class.
	 * @param string|null  $table               The table name.
	 * @param string|null  $settingsPath        The settings path.
	 * @param string|null  $settingsIndexPath   The index settings path.
	 *
	 * @since 3.2.2
	 */
	public function __construct(array $repos, Grep $grep, Items $items,
		ItemReadme $itemReadme, MainReadme $mainReadme, Git $git,
		?string $table = null, ?string $settingsPath = null, ?string $settingsIndexPath = null)
	{
		$this->repos = $repos;
		$this->grep = $grep;
		$this->items = $items;
		$this->itemReadme = $itemReadme;
		$this->mainReadme = $mainReadme;
		$this->git = $git;

		if ($table !== null)
		{
			$this->table = $table;
		}

		if ($settingsPath !== null)
		{
			$this->settings_path = $settingsPath;
		}

		if ($settingsIndexPath !== null)
		{
			$this->setIndexSettingsPath($settingsIndexPath);
		}

		if (empty($this->area))
		{
			$this->area = ucfirst(str_replace('_', ' ', $this->table));
		}

		// set the branch to writing
		$this->grep->setBranchField('write_branch');
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
	 * Set the settings path
	 *
	 * @param string    $settingsPath    The repository settings path
	 *
	 * @return self
	 * @since 3.2.2
	 */
	public function setSettingsPath(string $settingsPath): self
	{
		$this->settings_path = $settingsPath;

		return $this;
	}

	/**
	 * Set the index settings path
	 *
	 * @param string    $settingsIndexPath    The repository index settings path
	 *
	 * @return self
	 * @since 3.2.2
	 */
	public function setIndexSettingsPath(string $settingsIndexPath): self
	{
		$this->index_settings_path = $settingsIndexPath;

		$this->grep->setIndexPath($settingsIndexPath);

		return $this;
	}

	/**
	 * Save items remotely
	 *
	 * @param array   $guids    The global unique id of the item
	 *
	 * @return bool
	 * @throws \Exception
	 * @since 3.2.2
	 */
	public function items(array $guids): bool
	{
		if (!$this->canWrite())
		{
			throw new \Exception("At least one [{$this->getArea()}] content repository must be configured with a [Write Branch] value in the repositories area for the push function to operate correctly.");
		}

		// we reset the index settings
		$this->settings = [];

		if (($items = $this->getLocalItems($guids)) === null)
		{
			throw new \Exception("At least one valid local [{$this->getArea()}] must exist for the push function to operate correctly.");
		}

		foreach ($items as $item)
		{
			$this->save($item);
		}

		// update the repos main readme and index settings
		if ($this->settings !== [])
		{
			foreach ($this->settings as $repo)
			{
				$this->saveRepoMainSettings($repo);
			}
		}

		return true;
	}

	/**
	 * update an existing item (if changed)
	 *
	 * @param object $item
	 * @param object $existing
	 * @param object $repo
	 *
	 * @return bool
	 * @since 3.2.2
	 */
	abstract protected function updateItem(object $item, object $existing, object $repo): bool;

	/**
	 * create a new item
	 *
	 * @param object  $item
	 * @param object  $repo
	 *
	 * @return void
	 * @since 3.2.2
	 */
	abstract protected function createItem(object $item, object $repo): void;

	/**
	 * update an existing item readme
	 *
	 * @param object $item
	 * @param object $existing
	 * @param object $repo
	 *
	 * @return void
	 * @since 3.2.2
	 */
	abstract protected function updateItemReadme(object $item, object $existing, object $repo): void;

	/**
	 * create a new item readme
	 *
	 * @param object  $item
	 * @param object  $repo
	 *
	 * @return void
	 * @since 3.2.2
	 */
	abstract protected function createItemReadme(object $item, object $repo): void;

	/**
	 * Get the current active table
	 *
	 * @return  string
	 * @since 3.2.2
	 */
	protected function getTable(): string
	{
		return $this->table;
	}

	/**
	 * Get the current active area
	 *
	 * @return  string
	 * @since 3.2.2
	 */
	protected function getArea(): string
	{
		return $this->area;
	}

	/**
	 * Update/Create the repo main readme and index
	 *
	 * @param array $repoBucket
	 * 
	 * @return void
	 * @since 3.2.2
	 */
	protected function saveRepoMainSettings(array $repoBucket): void
	{
		$repo = $repoBucket['repo'] ?? null;
		$settings = $repoBucket['items'] ?? null;

		if ($this->isInvalidIndexRepo($repo, $settings))
		{
			return;
		}

		$repoGuid = $repo->guid ?? null;
		if (empty($repoGuid))
		{
			return;
		}

		$settings = $this->mergeIndexSettings($repoGuid, $settings);

		$this->updateIndexMainFile(
			$repo,
			$this->getIndexSettingsPath(),
			json_encode($settings, JSON_PRETTY_PRINT),
			'Update main index file'
		);

		$this->updateIndexMainFile(
			$repo,
			'README.md',
			$this->mainReadme->get($settings),
			'Update main readme file'
		);
	}

	/**
	 * Validate repository and settings
	 *
	 * @param mixed $repo
	 * @param mixed $settings
	 * 
	 * @return bool
	 * @since 3.2.2
	 */
	protected function isInvalidIndexRepo($repo, $settings): bool
	{
		return empty($repo) || empty($settings);
	}

	/**
	 * Merge current settings with new settings
	 *
	 * @param string $repoGuid
	 * @param array $settings
	 * 
	 * @return array
	 * @since 3.2.2
	 */
	protected function mergeIndexSettings(string $repoGuid, array $settings): array
	{
		$current_settings = $this->grep->getRemoteIndex($repoGuid);

		if ($current_settings === null || (array) $current_settings === [])
		{
			return $settings;
		}

		$mergedSettings = [];
		foreach ($current_settings as $guid => $setting)
		{
			$mergedSettings[$guid] = (array) $setting;
		}

		foreach ($settings as $guid => $setting)
		{
			$mergedSettings[$guid] = (array) $setting;
		}

		return $mergedSettings;
	}

	/**
	 * Update a file in the repository
	 *
	 * @param object $repo
	 * @param string $path
	 * @param string $content
	 * @param string $message
	 * 
	 * @return void
	 * @since 3.2.2
	 */
	protected function updateIndexMainFile(object $repo, string $path,
		string $content, string $message): void
	{
		$meta = $this->git->metadata(
			$repo->organisation,
			$repo->repository,
			$path,
			$repo->write_branch
		);

		if ($meta !== null && isset($meta->sha))
		{
			$this->git->update(
				$repo->organisation,
				$repo->repository,
				$path,
				$content,
				$message,
				$meta->sha,
				$repo->write_branch
			);
		}
	}

	/**
	 * Get items
	 *
	 * @param array $guids The global unique id of the item
	 *
	 * @return array|null
	 * @since 3.2.2
	 */
	protected function getLocalItems(array $guids): ?array
	{
		$items = $this->fetchLocalItems($guids);

		if ($items === null)
		{
			return null;
		}

		return $this->mapItems($items);
	}

	/**
	 * Fetch items from the database
	 *
	 * @param array $guids The global unique ids of the items
	 *
	 * @return array|null
	 * @since 3.2.2
	 */
	protected function fetchLocalItems(array $guids): ?array
	{
		return $this->items->table($this->getTable())->get($guids);
	}

	/**
	 * Map items to their properties
	 *
	 * @param array $items The items fetched from the database
	 *
	 * @return array
	 * @since 3.2.2
	 */
	protected function mapItems(array $items): array
	{
		$bucket = [];

		foreach ($items as $item)
		{
			if (!isset($item->guid))
			{
				continue;
			}

			$bucket[$item->guid] = $this->mapItem($item);
		}

		return $bucket;
	}

	/**
	 * Map a single item to its properties
	 *
	 * @param object $item The item to be mapped
	 *
	 * @return object
	 * @since 3.2.2
	 */
	protected function mapItem(object $item): object
	{
		$power = [];

		foreach ($this->map as $key => $map)
		{
			$power[$key] = $item->{$map} ?? null;
		}

		return (object) $power;
	}

	/**
	 * Save an item remotely
	 *
	 * @param  object   $item    The item to save
	 *
	 * @return void
	 * @since 3.2.2
	 */
	protected function save(object $item): void
	{
		if (empty($item->guid))
		{
			return;
		}

		$index_item = null;
		foreach ($this->repos as $key => $repo)
		{
			if (empty($repo->write_branch) || $repo->write_branch === 'default')
			{
				continue;
			}

			$this->git->load_($repo->base ?? null, $repo->token ?? null);

			if (($existing = $this->grep->get($item->guid, ['remote'], $repo)) !== null)
			{
				if ($this->updateItem($item, $existing, $repo))
				{
					$this->updateItemReadme($item, $existing, $repo);
				}
			}
			else
			{
				$this->createItem($item, $repo);

				$this->createItemReadme($item, $repo);

				$index_item ??= $this->getIndexItem($item);

				if (!isset($this->settings[$key]))
				{
					$this->settings[$key] = ['repo' => $repo, 'items' => [$item->guid => $index_item]];
				}
				else
				{
					$this->settings[$key]['items'][$item->guid] = $index_item;
				}
			}

			$this->git->reset_();
		}
	}

	/**
	 * Get index values
	 *
	 * @param object  $item  The item
	 *
	 * @return array|null
	 * @since 3.2.2
	 */
	protected function getIndexItem(object $item): ?array
	{
		if (empty($this->index_map))
		{
			return null;
		}

		$index_item = [];
		foreach ($this->index_map as $key => $function_name)
		{
			if (method_exists($this, $function_name))
			{
				$index_item[$key] = $this->{$function_name}($item);
			}
		}

		return $index_item ?? null;
	}

	/**
	 * check that we have an active repo towards which we can write data
	 *
	 * @return bool
	 * @since 3.2.2
	 */
	protected function canWrite(): bool
	{
		foreach ($this->repos as $repo)
		{
			if (!empty($repo->write_branch) && $repo->write_branch !== 'default')
			{
				return true;
			}
		}

		return false;
	}

	/**
	 * Checks if two objects are equal by comparing their JSON representations.
	 *
	 * This method converts both input objects to JSON strings and compares these strings.
	 * If the JSON strings are identical, the objects are considered equal.
	 *
	 * @param object $obj1 The first object to compare.
	 * @param object $obj2 The second object to compare.
	 *
	 * @return bool True if the objects are equal, false otherwise.
	 * @since 3.2.2
	 */
	protected function areObjectsEqual(object $obj1, object $obj2): bool
	{
		// Convert both objects to JSON strings
		$json1 = json_encode($obj1);
		$json2 = json_encode($obj2);

		// Compare the JSON strings
		return $json1 === $json2;
	}

	/**
	 * Get the settings path
	 *
	 * @return string
	 * @since 3.2.2
	 */
	protected function getSettingsPath(): string
	{
		return $this->settings_path;
	}

	/**
	 * Get the index settings path
	 *
	 * @return string
	 * @since 3.2.2
	 */
	protected function getIndexSettingsPath(): string
	{
		return $this->index_settings_path;
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
		return $item->system_name ?? null;
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
		return "src/{$item->guid}/" . $this->getSettingsPath();
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
		return "src/{$item->guid}";
	}

	/**
	 * Get the item JPK for the index values
	 *
	 * @param object $item
	 *
	 * @return string
	 * @since 3.2.2
	 */
	protected function index_map_IndexKey(object $item): string
	{
		return $this->prefix_key . str_replace('-', '_', $item->guid) . $this->suffix_key;
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
		return $item->guid;
	}
}

