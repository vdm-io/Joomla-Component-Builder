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


use Joomla\CMS\Language\Text;
use VDM\Joomla\Interfaces\Remote\ConfigInterface as Config;
use VDM\Joomla\Interfaces\GrepInterface as Grep;
use VDM\Joomla\Interfaces\Data\ItemsInterface as Items;
use VDM\Joomla\Interfaces\Readme\ItemInterface as ItemReadme;
use VDM\Joomla\Interfaces\Readme\MainInterface as MainReadme;
use VDM\Joomla\Interfaces\Git\Repository\ContentsInterface as Git;
use VDM\Joomla\Componentbuilder\Package\Dependency\Tracker;
use VDM\Joomla\Componentbuilder\Package\MessageBus;
use VDM\Joomla\Interfaces\Remote\Dependency\ResolverInterface as Resolver;
use VDM\Joomla\Utilities\ObjectHelper;
use VDM\Joomla\Interfaces\Remote\SetInterface;
use VDM\Joomla\Abstraction\Remote\Base;


/**
 * Set data based on global unique ids to remote repository
 * 
 * @since 3.2.2
 */
abstract class Set extends Base implements SetInterface
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
	 * The Tracker Class.
	 *
	 * @var   Tracker
	 * @since 5.1.1
	 */
	protected Tracker $tracker;

	/**
	 * The Message Bus Class.
	 *
	 * @var   MessageBus
	 * @since 5.1.1
	 */
	protected MessageBus $messages;

	/**
	 * The Resolver Class
	 *
	 *   Only set in some child classes
	 *      that has dependencies
	 *
	 * @var   Resolver
	 * @since 5.1.1
	 */
	protected ?Resolver $resolver = null;

	/**
	 * All active repos
	 *
	 * @var   array
	 * @since 3.2.2
	 **/
	public array $repos;

	/**
	 * The repo main settings
	 *
	 * @var   array
	 * @since 3.2.2
	 */
	protected array $settings = [];

	/**
	 * Repo Placeholders
	 *
	 * @var    array
	 * @since  5.0.3
	 */
	protected array $repoPlaceholders = [];

	/**
	 * Constructor.
	 *
	 * @param Config       $config              The Config Class.
	 * @param Grep         $grep                The Grep Class.
	 * @param Items        $items               The Items Class.
	 * @param ItemReadme   $itemReadme          The Item Readme Class.
	 * @param MainReadme   $mainReadme          The Main Readme Class.
	 * @param Git          $git                 The Contents Class.
	 * @param Tracker      $tracker             The Tracker Class.
	 * @param MessageBus   $messages            The MessageBus Class.
	 * @param array        $repos               The active repos.
	 * @param string|null  $table               The table name.
	 * @param string|null  $settingsName        The settings name.
	 * @param string|null  $indexPath           The index path.
	 *
	 * @since 3.2.2
	 */
	public function __construct(Config $config, Grep $grep, Items $items, ItemReadme $itemReadme,
		MainReadme $mainReadme, Git $git, Tracker $tracker, MessageBus $messages,
		array $repos, ?string $table = null, ?string $settingsName = null, ?string $indexPath = null)
	{
		parent::__construct($config);

		$this->grep = $grep;
		$this->items = $items;
		$this->itemReadme = $itemReadme;
		$this->mainReadme = $mainReadme;
		$this->git = $git;
		$this->tracker = $tracker;
		$this->messages = $messages;
		$this->repos = $repos;

		if ($table !== null)
		{
			$this->table($table);
		}

		if ($settingsName !== null)
		{
			$this->setSettingsName($settingsName);
		}

		if ($indexPath !== null)
		{
			$this->setIndexPath($indexPath);
		}

		if ($this->getArea() === null)
		{
			$this->area(ucfirst(str_replace('_', ' ', $this->getTable())));
		}

		$this->grep->setBranchField('write_branch');
	}

	/**
	 * Save items remotely
	 *
	 * @param array   $guids    The global unique id of the item
	 *
	 * @return bool
	 * @since 3.2.2
	 */
	public function items(array $guids): bool
	{
		if (empty($guids))
		{
			return false;
		}

		$this->grep->setBranchField('write_branch');
		$area = $this->getArea();
		$table = $this->getTable();

		if (!$this->canWrite())
		{
			$target_network = $this->grep->getNetworkTarget() ?? $this->getArea();
			$this->messages->add('error', Text::sprintf('COM_COMPONENTBUILDER_AT_LEAST_ONE_S_CONTENT_REPOSITORY_MUST_BE_CONFIGURED_WITH_A_WRITE_BRANCH_VALUE_IN_THE_REPOSITORIES_AREA_FOR_THE_PUSH_FUNCTION_TO_OPERATE_CORRECTLY', $target_network));
			return false;
		}

		if (($items = $this->getLocalItems($guids)) === null)
		{
			$this->messages->add('warning', Text::sprintf('COM_COMPONENTBUILDER_THE_S_ITEMS_COULD_NOT_BE_FOUND', strtolower($area)));
			return false;
		}

		$counter = 0;
		foreach ($items as $item)
		{
			if ($this->save($item))
			{
				$counter++;
			}
		}

		// update the repos main readme and index settings
		if ($this->settings !== [])
		{
			foreach ($this->settings as $repo)
			{
				$this->saveRepoMainSettings($repo);
			}
		}

		// add a message per area once
		if ($counter > 0 && !$this->tracker->exists("message.{$table}"))
		{
			$this->tracker->set("message.{$table}", true);
			$item_name = $counter == 1 ? 'item has' : 'items have';
			$this->messages->add('success', Text::sprintf('COM_COMPONENTBUILDER_S_S_BEEN_PUSHED_SUCCESSFULLY', $area, $item_name));
		}

		return $counter === count($items);
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
	 * @return bool
	 * @since 3.2.2
	 */
	abstract protected function createItem(object $item, object $repo): bool;

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
		$json_settings = trim(json_encode($settings, JSON_PRETTY_PRINT));
		if (empty($json_settings))
		{
			return;
		}

		// set the target system
		$target = $repo->target ?? 'gitea';
		$this->git->setTarget($target);

		// load the base and token if set
		$this->grep->loadApi(
			$this->git,
			$repo->base ?? null,
			$repo->token ?? null
		);

		try {
			$area = $this->getArea();
			$indexPath = $this->getIndexPath();
			if (!empty($indexPath))
			{
				$this->setMainRepoFile(
					$repo,
					$indexPath,
					$json_settings,
					"Update {$area} main index file", "Create {$area} main index file"
				);
			}
			if ($this->hasMainReadme())
			{
				$this->setMainRepoFile(
					$repo,
					$this->getMainReadmePath(),
					$this->mainReadme->get($settings),
					"Update {$area} main readme file", "Create {$area} main readme file"
				);
			}
		} catch (\Throwable $e) {
			$this->messages->add('error',  $e->getMessage());
		} finally {
			$this->git->reset_();
		}
	}

	/**
	 * Validate repository and settings.
	 *
	 * Repo must be an object and not empty.
	 * Settings must be an object or an array and not empty.
	 *
	 * @param  mixed  $repo      The repository value to validate.
	 * @param  mixed  $settings  The settings value to validate.
	 *
	 * @return bool  True if invalid, false if valid.
	 * @since  3.2.2
	 */
	protected function isInvalidIndexRepo($repo, $settings): bool
	{
		// Validate repo: must be an object and not empty
		if (!is_object($repo) || empty((array) $repo))
		{
			return true;
		}

		// Validate settings: must be an object or array and not empty
		if ((!is_object($settings) && !is_array($settings)) || empty((array) $settings))
		{
			return true;
		}

		return false;
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
		$mergedSettings = [];
		$current_settings = $this->grep->getRemoteIndex($repoGuid, true);
		$this->grep->resetEntityIndex();

		if ($current_settings !== null  && (array) $current_settings !== [])
		{
			foreach ($current_settings as $guid_current => $current_setting)
			{
				$mergedSettings[$guid_current] = (array) $current_setting;
			}
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
	 * @param string $updateMessage
	 * @param string $createMessage
	 * 
	 * @return void
	 * @since 3.2.2
	 */
	protected function setMainRepoFile(object $repo, string $path,
		string $content, string $updateMessage, string $createMessage): void
	{
		try {
			$meta = $this->git->metadata(
				$repo->organisation,
				$repo->repository,
				$path,
				$repo->write_branch
			);
		} catch (\Throwable $e) {
			$meta = null;
		}

		if ($meta !== null && isset($meta->sha))
		{
			// Calculate the new SHA from the current content
			$newSha = sha1("blob " . strlen($content) . "\0" . $content);

			// Check if the new SHA matches the existing SHA
			if ($meta->sha === $newSha)
			{
				return;
			}

			try {
				$this->git->update(
					$repo->organisation, // The owner name.
					$repo->repository, // The repository name.
					$path, // The file path.
					$content, // The file content.
					$updateMessage, // The commit message.
					$meta->sha, // The previous sha value.
					$repo->write_branch, // The branch name.
					$repo->author_name, // The author name.
					$repo->author_email // The author name.
				);
			} catch (\Throwable $e) {
				$this->messages->add('error',  $e->getMessage());
			}
		}
		else
		{
			try {
				$this->git->create(
					$repo->organisation, // The owner name.
					$repo->repository, // The repository name.
					$path, // The file path.
					$content, // The file content.
					$createMessage, // The commit message.
					$repo->write_branch, // The branch name.
					$repo->author_name, // The author name.
					$repo->author_email // The author name.
				);
			} catch (\Throwable $e) {
				$this->messages->add('error',  $e->getMessage());
			}
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
		$guid_field = $this->getGuidField();
		return $this->items->table($this->getTable())->get($guids, $guid_field);
	}

	/**
	 * Save an item remotely
	 *
	 * @param  object   $rawItem    The item to save
	 *
	 * @return bool
	 * @since 3.2.2
	 */
	protected function save(object $rawItem): bool
	{
		$index_item = null;
		$item = $this->mapItem($rawItem);
		$area = $this->getArea();
		$item_id = $rawItem->id ?? '_no_id_found_';
		$item_name = $this->index_map_IndexName($item);

		$guid_field = $this->getGuidField();
		if (empty($item->{$guid_field}))
		{
			$this->messages->add('error', Text::sprintf('COM_COMPONENTBUILDER_S_ITEM_S_ID_S_MISSING_THE_S_KEY_VALUE', $area, $item_name, $item_id, $guid_field));
			return false;
		}
		$table = $this->getTable();
		$guid = $item->{$guid_field};

		// check if we have saved this entity already
		if ($this->tracker->exists("save.{$table}.{$guid_field}|{$guid}"))
		{
			return $this->tracker->get("save.{$table}.{$guid_field}|{$guid}");
		}

		// pass item to the inspector/resolver to get all dependencies
		$dependencies = $this->getDependencies($item);
		if ($dependencies !== null)
		{
			foreach ($dependencies as $key => $dependency)
			{
				$item->{$key} = $dependency;
			}
		}

		$at_least_once = false;
		$not_approved = true;
		foreach ($this->repos as $key => $repo)
		{
			if (empty($repo->write_branch) || $repo->write_branch === 'default' || !$this->targetRepo($rawItem, $repo))
			{
				continue;
			}
			$not_approved = false;

			$this->setRepoPlaceholders($repo);

			// set the target system
			$target_system = $repo->target ?? 'gitea';
			$this->git->setTarget($target_system);

			// load the base and token if set
			$this->grep->loadApi(
				$this->git,
				$repo->base ?? null,
				$repo->token ?? null
			);

			try {
				if (($existing = $this->grep->get($guid, ['remote'], $repo)) !== null)
				{
					if ($this->updateItem($item, $existing, $repo))
					{
						$this->updateItemReadme($item, $existing, $repo);
						$at_least_once = true;
					}
				}
				elseif ($this->createItem($item, $repo))
				{
					$this->createItemReadme($item, $repo);

					$index_item ??= $this->getIndexItem($item);

					$at_least_once = true;

					if (!isset($this->settings[$key]))
					{
						$this->settings[$key] = ['repo' => $repo, 'items' => [$guid => $index_item]];
					}
					else
					{
						$this->settings[$key]['items'][$guid] = $index_item;
						$this->settings[$key]['repo'] = $repo;
					}
				}
				else
				{
					$repo_name = $this->getRepoName($repo);
					$this->messages->add('error',
						Text::sprintf('COM_COMPONENTBUILDER_S_ITEM_S_ID_S_COULD_NOT_BE_CREATED_OR_FOUND_IN_REPOS',
							$area, $item_name, $item_id, $repo_name));
				}
			} catch (\Throwable $e) {
				$repo_name = $this->getRepoName($repo);
				$this->messages->add('error',
					Text::sprintf('COM_COMPONENTBUILDER_S_ITEM_S_ID_S_ENCOUNTERED_AN_ERROR_IN_REPOSBRERROR_MESSAGEBRS',
						$area, $item_name, $item_id, $repo_name, $e->getMessage()));
			} finally {
				$this->git->reset_();
			}
		}

		if (!$at_least_once && $not_approved)
		{
			$this->messages->add('warning', Text::sprintf('COM_COMPONENTBUILDER_S_ITEM_S_ID_S_IS_NOT_APPROVED_AND_THEREFORE_NOT_LINKED_TO_ANY_REPOSITORY', $area, $item_name, $item_id));
		}

		$this->tracker->set("save.{$table}.{$guid_field}|{$guid}", $at_least_once);

		return $at_least_once;
	}

	/**
	 * Set the Repo Placeholders
	 *
	 * @param object  $repo  The repo
	 *
	 * @return void
	 * @since  5.0.3
	 */
	protected function setRepoPlaceholders(object $repo): void
	{
		$this->repoPlaceholders = $this->getPlaceholders();
		if (!empty($repo->placeholders) && is_array($repo->placeholders))
		{
			foreach ($repo->placeholders as $key => $value)
			{
				$this->repoPlaceholders[$key] = $value;
			}
		}
	}

	/**
	 * Get the dependencies of this item
	 *
	 * @param  object   $item    The item to resolve the dependencies
	 *
	 * @return array|null  The array of relationships or null for none
	 * @since 3.2.2
	 */
	protected function getDependencies($item): ?array
	{
		if ($this->resolver instanceof Resolver)
		{
			return $this->resolver->extract($item);
		}
		return null;
	}

	/**
	 * Update Placeholders in String
	 *
	 * @param string  $string  The value to update
	 *
	 * @return string
	 * @since  5.0.3
	 */
	protected function updatePlaceholders(string $string): string
	{
		return str_replace(
			array_keys($this->repoPlaceholders),
			array_values($this->repoPlaceholders), 
			$string
		);
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
	 * check that we have a target repo of this item
	 *
	 * @param object  $item  The item
	 * @param object  $repo  The current repo
	 *
	 * @return bool
	 * @since  5.0.3
	 */
	protected function targetRepo(object $item, object $repo): bool
	{
		return true; // for more control in children classes
	}

	/**
	 * get the name of the repo
	 *
	 * @param object  $repo  The current repo
	 *
	 * @return string
	 * @since  5.1.1
	 */
	protected function getRepoName(object $repo): string
	{
		$base = $repo->base ?? '[core]';
		$organisation = $repo->organisation ?? '[organisation]';
		$repository = $repo->repository ?? '[repository]';

		return "{$base}/{$organisation}/{$repository}";
	}

	/**
	 * Checks if two objects are equal by comparing their properties and values.
	 *
	 *  This method converts both input objects to associative arrays, sorts the arrays by keys,
	 *  and compares these sorted arrays.
	 *
	 *  If the arrays are identical, the objects are considered equal.
	 *
	 * @param object|null  $obj1  The first object to compare.
	 * @param object|null  $obj2  The second object to compare.
	 *
	 * @return bool   True if the objects are equal, false otherwise.
	 * @since  5.0.2
	 */
	protected function areObjectsEqual(?object $obj1, ?object $obj2): bool
	{
		return ObjectHelper::equal($obj1, $obj2, ['@dependencies']); // basic comparison
	}
}

