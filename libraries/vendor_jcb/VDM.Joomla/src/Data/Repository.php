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

namespace VDM\Joomla\Data;


use VDM\Joomla\Interfaces\GrepInterface as Grep;
use VDM\Joomla\Interfaces\Data\ItemsInterface as Items;
use VDM\Joomla\Gitea\Repository\Contents as Git;


/**
 * Set data based on global unique ids to remote repository
 * 
 * @since 3.2.2
 */
class Repository
{
	/**
	 * The GrepInterface Class.
	 *
	 * @var   Grep
	 * @since 3.2.2
	 */
	protected Grep $grep;

	/**
	 * The ItemsInterface Class.
	 *
	 * @var   Items
	 * @since 3.2.2
	 */
	protected Items $items;

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
	 * @var    array
	 * @since 3.2.0
	 **/
	public array $repos;

	/**
	 * Table Name
	 *
	 * @var    string
	 * @since 3.2.1
	 */
	protected string $table;

	/**
	 * The item map
	 *
	 * @var    array
	 * @since 3.2.2
	 */
	protected array $map;

	/**
	 * Constructor.
	 *
	 * @param array        $repos      The active repos
	 * @param Grep         $grep       The GrepInterface Class.
	 * @param Items        $items      The ItemsInterface Class.
	 * @param Git          $git        The Contents Class.
	 * @param string|null  $table      The table name.
	 *
	 * @since 3.2.2
	 */
	public function __construct(array $repos, Grep $grep, Items $items, Git $git, ?string $table = null)
	{
		$this->repos = $repos;
		$this->grep = $grep;
		$this->items = $items;
		$this->git = $git;
		if ($table !== null)
		{
			$this->table = $table;
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
	 * Set items
	 *
	 * @param array   $guids    The global unique id of the item
	 *
	 * @return bool
	 * @throws \Exception
	 * @since 3.2.0
	 */
	public function set(array $guids): bool
	{
		if (($items = $this->getLocalItems($guids)) === null)
		{
			throw new \Exception("At least one valid local [Joomla Power] must exist for the push function to operate correctly.");
		}

		if (!$this->canWrite())
		{
			throw new \Exception("At least one [Joomla Power] content repository must be configured with a [Write Branch] value in the repositories area for the push function to operate correctly.");
		}

		// update the existing found
		if (($existing_items = $this->getRepoItems($guids)) !== [])
		{
			foreach ($existing_items as $e_guid => $item)
			{
				if (isset($items[$e_guid]))
				{
					$this->updateItem($items[$e_guid], $item);
					unset($items[$e_guid]);
				}
			}
		}

		// create the new items
		foreach ($items as $item)
		{
			$this->createItem($item);
		}

		return true;
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
	 * Get items
	 *
	 * @param array $guids The global unique id of the item
	 *
	 * @return array|null
	 * @since 3.2.2
	 */
	public function getLocalItems(array $guids): ?array
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
	 * @param array $guids The global unique id of the item
	 *
	 * @return array|null
	 * @since 3.2.2
	 */
	protected function fetchLocalItems(array $guids): ?array
	{
		return $this->items->table($this->table)->get($guids);
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
	 * get existing items
	 *
	 * @param array   $guids    The global unique id of the item
	 *
	 * @return array|null
	 * @since 3.2.2
	 */
	protected function getRepoItems(array $guids): ?array
	{
		$bucket = [];
		foreach ($guids as $guid)
		{
			if (($item = $this->grep->get($guid)) !== null)
			{
				$bucket[$guid] = (object) $item;
			}
		}

		return $bucket ?? null;
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
	 * update an existing item (if changed)
	 *
	 * @param object $item
	 * @param object $existing
	 *
	 * @return void
	 * @since 3.2.2
	 */
	protected function updateItem(object $item, object $existing): void
	{
		if (isset($existing->params->source) && is_array($existing->params->source))
		{
			// get the source values
			$source = $existing->params->source;

			// make sure there was a change
			$existing = $this->mapItem($existing);
			if ($this->areObjectsEqual($item, $existing))
			{
				return;
			}

			foreach ($this->repos as $repo)
			{
				if (isset($source[$repo->guid]))
				{
					$this->git->load_($repo->base ?? null, $repo->token ?? null);
					$this->git->update(
						$repo->organisation, // The owner name.
						$repo->repository, // The repository name.
						'src/' . $item->guid . '/item.json', // The file path.
						json_encode($item, JSON_PRETTY_PRINT), // The file content.
						'Update ' . $item->system_name, // The commit message.
						$source[$repo->guid], // The blob SHA of the old file.
						$repo->write_branch // The branch name.
					);
					$this->git->reset_();

					// only update in the first found repo
					return;
				}
			}
		}
	}

	/**
	 * create a new item
	 *
	 * @param object $item
	 *
	 * @return void
	 * @since 3.2.2
	 */
	protected function createItem(object $item): void
	{
		foreach ($this->repos as $repo)
		{
			if (!empty($repo->write_branch) && $repo->write_branch !== 'default')
			{
				$this->git->load_($repo->base ?? null, $repo->token ?? null);
				$this->git->create(
					$repo->organisation, // The owner name.
					$repo->repository, // The repository name.
					'src/' . $item->guid . '/item.json', // The file path.
					json_encode($item, JSON_PRETTY_PRINT), // The file content.
					'Create ' . $item->system_name, // The commit message.
					$repo->write_branch // The branch name.
				);
				$this->git->reset_();
				// only create in the first found repo
				return;
			}
		}
	}
}

