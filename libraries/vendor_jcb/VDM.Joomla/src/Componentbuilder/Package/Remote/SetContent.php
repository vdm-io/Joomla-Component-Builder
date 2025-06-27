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

namespace VDM\Joomla\Componentbuilder\Package\Remote;


use Joomla\CMS\Language\Text;
use VDM\Joomla\Interfaces\Remote\SetInterface;
use VDM\Joomla\Componentbuilder\Remote\Set;


/**
 * Set content on remote repository
 * 
 * @since 5.1.1
 */
abstract class SetContent extends Set implements SetInterface
{
	/**
	 * Save content remotely
	 *
	 * @param array   $items    The file array
	 *
	 * @return bool
	 * @since 3.2.2
	 */
	public function items(array $items): bool
	{
		if (empty($items))
		{
			return false;
		}

		$this->grep->setBranchField('write_branch');
		$table = $this->getTable();
		$area = $this->getArea();

		if (!$this->canWrite())
		{
			$target_network = $this->grep->getNetworkTarget() ?? $area;
			$this->messages->add('error', Text::sprintf('COM_COMPONENTBUILDER_AT_LEAST_ONE_S_CONTENT_REPOSITORY_MUST_BE_CONFIGURED_WITH_A_WRITE_BRANCH_VALUE_IN_THE_REPOSITORIES_AREA_FOR_THE_PUSH_FUNCTION_TO_OPERATE_CORRECTLY', $target_network));
			return false;
		}

		$counter = 0;
		foreach ($items as $item)
		{
			if ($this->save((object) $item))
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
		if ($counter > 0 && !$this->tracker->exists("message.{$table}{$area}"))
		{
			$this->tracker->set("message.{$table}{$area}", true);
			$item_name = $counter == 1 ? 'item has' : 'items have';
			$this->messages->add('success', Text::sprintf('COM_COMPONENTBUILDER_S_S_BEEN_PUSHED_SUCCESSFULLY', $area, $item_name));
		}

		return $counter === count($items);
	}

	/**
	 * Save an item remotely
	 *
	 * @param  object   $item   The item to save
	 *
	 * @return bool
	 * @since  5.1.1
	 */
	protected function save(object $item): bool
	{
		$area = $this->getArea();
		$guid = $item->key ?? null;
		$pointer = $item->pointer ?? null;
		$value = $item->value ?? null;
		$entity = $item->entity ?? null;
		$target = $item->target ?? null;
		$full_path = $item->full ?? null;

		if (empty($guid) || empty($value) || empty($entity) || empty($target) || empty($pointer))
		{
			$this->messages->add('error',
				Text::sprintf('COM_COMPONENTBUILDER_S_HAD_MISSING_VALUES_GUIDS_POINTER_S_VALUES_ENTITYS_TARGETS',
					$area,
					$guid ?? 'missing',
					$pointer ?? 'missing',
					$value ?? 'missing',
					$entity ?? 'missing',
					$target ?? 'missing'
				)
			);
			return false;
		}

		if (empty($full_path) || (!is_file($full_path) && !is_dir($full_path)))
		{
			$this->messages->add('error',
				Text::sprintf('COM_COMPONENTBUILDER_SS_S_COULD_NOT_BE_FOUND_AT_FULL_PATHS',
					$area, $target, $value, $full_path ?? 'missing'));
			return false;
		}

		// check if we have saved this entity already
		if ($this->tracker->exists("{$entity}.save.{$pointer}"))
		{
			return $this->tracker->get("{$entity}.save.{$pointer}");
		}

		$item->content = $this->getContent($full_path, $guid);

		if (empty($item->content))
		{
			$this->messages->add('error',
				Text::sprintf('COM_COMPONENTBUILDER_SS_S_COULD_NOT_BE_LOADED_FROM_FULL_PATHS',
					$area, $target, $value, $full_path ?? 'missing'));
			return false;
		}

		$item->sha = sha1("blob " . strlen($item->content) . "\0" . $item->content);

		$at_least_once = false;
		$not_approved = true;
		foreach ($this->repos as $key => $repo)
		{
			if (empty($repo->write_branch) || $repo->write_branch === 'default' || !$this->targetRepo($item, $repo))
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
						$at_least_once = true;
					}
				}
				elseif ($this->createItem($item, $repo))
				{
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
					$this->messages->add('error', Text::sprintf('COM_COMPONENTBUILDER_SS_COULD_NOT_BE_CREATED_OR_FOUND_IN_REPOS', $area, $value, $repo_name));
				}
			} catch (\Throwable $e) {
				$repo_name = $this->getRepoName($repo);
				$this->messages->add('error',
					Text::sprintf('COM_COMPONENTBUILDER_SS_ENCOUNTERED_AN_ERROR_IN_REPOSBRBRBERROR_MESSAGEBBRS',
						$area, $value, $repo_name, $e->getMessage()));
			} finally {
				$this->git->reset_();
			}
		}

		if (!$at_least_once && $not_approved)
		{
			$this->messages->add('warning', Text::sprintf('COM_COMPONENTBUILDER_SS_IS_NOT_APPROVED_AND_THEREFORE_NOT_LINKED_TO_ANY_REPOSITORY', $area, $value));
		}

		$this->tracker->set("{$entity}.save.{$pointer}", $at_least_once);

		return $at_least_once;
	}

	/**
	 * Get the content
	 *
	 * @param  string   $fullPath  The full path to the content
	 * @param  string   $guid        The content key/guid
	 *
	 * @return string|null
	 * @since  5.1.1
	 */
	abstract protected function getContent(string $fullPath, string $guid): ?string;

	/**
	 * update an existing item (if changed)
	 *
	 * @param object $item
	 * @param object $existing
	 * @param object $repo
	 *
	 * @return bool
	 * @since  5.0.3
	 */
	protected function updateItem(object $item, object $existing, object $repo): bool
	{
		$sha = $existing->params->source[$repo->guid . '-settings'] ?? null;
		$area = $this->getArea();
		$item_name = $this->index_map_IndexName($item);
		$repo_name = $this->getRepoName($repo);

		if ($sha === null || $item->sha === $sha)
		{
			$this->messages->add('warning', Text::sprintf('COM_COMPONENTBUILDER_NO_CHANGE_S_ITEM_S_IN_REPO_S_IS_ALREADY_IN_SYNC', $area, $item_name, $repo_name));
			return false;
		}

		$result = $this->git->update(
			$repo->organisation, // The owner name.
			$repo->repository, // The repository name.
			$this->index_map_IndexSettingsPath($item), // The file path.
			$item->content, // The file content.
			'Update ' . $item_name, // The commit message.
			$sha, // The blob SHA of the old file.
			$repo->write_branch, // The branch name.
			$repo->author_name, // The author name.
			$repo->author_email // The author email.
		);

		$success = is_object($result);

		if (!$success)
		{
			$this->messages->add('warning', Text::sprintf('COM_COMPONENTBUILDER_S_ITEM_S_DETAILS_IN_REPOS_FAILED_TO_UPDATE', $area, $item_name, $repo_name));
		}

		return $success;
	}

	/**
	 * create a new item
	 *
	 * @param object  $item
	 * @param object  $repo
	 *
	 * @return bool
	 * @since  5.0.3
	 */
	protected function createItem(object $item, object $repo): bool
	{
		$result = $this->git->create(
			$repo->organisation, // The owner name.
			$repo->repository, // The repository name.
			$this->index_map_IndexSettingsPath($item), // The file path.
			$item->content, // The file content.
			'Create ' . $this->index_map_IndexName($item), // The commit message.
			$repo->write_branch, // The branch name.
			$repo->author_name, // The author name.
			$repo->author_email // The author email.
		);

		return is_object($result);
	}
}

