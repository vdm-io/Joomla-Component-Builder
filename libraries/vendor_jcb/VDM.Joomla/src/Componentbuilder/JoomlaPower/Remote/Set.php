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

namespace VDM\Joomla\Componentbuilder\JoomlaPower\Remote;


use VDM\Joomla\Interfaces\Remote\SetInterface;
use VDM\Joomla\Abstraction\Remote\Set as ExtendingSet;


/**
 * Set JoomlaPower based on global unique ids to remote repository
 * 
 * @since 3.2.2
 */
final class Set extends ExtendingSet implements SetInterface
{
	/**
	 * Table Name
	 *
	 * @var    string
	 * @since 3.2.2
	 */
	protected string $table = 'joomla_power';

	/**
	 * Area Name
	 *
	 * @var    string
	 * @since 3.2.2
	 */
	protected string $area = 'Joomla Power';

	/**
	 * Prefix Key
	 *
	 * @var    string
	 * @since 3.2.2
	 */
	protected string $prefix_key = 'Joomla---';

	/**
	 * The item map
	 *
	 * @var    array
	 * @since 3.2.2
	 */
	protected array $map = [
		'system_name' => 'system_name',
		'settings' => 'settings',
		'guid' => 'guid',
		'description' => 'description'
	];

	/**
	 * The index map
	 *
	 * @var    array
	 * @since 3.2.2
	 */
	protected array $index_map = [
		'name' => 'index_map_IndexName',
		'settings' => 'index_map_IndexSettingsPath',
		'path' => 'index_map_IndexPath',
		'jpk' => 'index_map_IndexKey',
		'guid' => 'index_map_IndexGUID'
	];

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
	protected function updateItem(object $item, object $existing, object $repo): bool
	{
		// make sure there was a change
		$sha = $existing->params->source[$repo->guid . '-settings'] ?? null;
		$existing = $this->mapItem($existing);
		if ($sha === null || $this->areObjectsEqual($item, $existing))
		{
			return false;
		}

		$this->git->update(
			$repo->organisation, // The owner name.
			$repo->repository, // The repository name.
			'src/' . $item->guid . '/' . $this->getSettingsPath(), // The file path.
			json_encode($item, JSON_PRETTY_PRINT), // The file content.
			'Update ' . $item->system_name, // The commit message.
			$sha, // The blob SHA of the old file.
			$repo->write_branch // The branch name.
		);

		return true;
	}

	/**
	 * create a new item
	 *
	 * @param object  $item
	 * @param object  $repo
	 *
	 * @return void
	 * @since 3.2.2
	 */
	protected function createItem(object $item, object $repo): void
	{
		$this->git->create(
			$repo->organisation, // The owner name.
			$repo->repository, // The repository name.
			'src/' . $item->guid . '/' . $this->getSettingsPath(), // The file path.
			json_encode($item, JSON_PRETTY_PRINT), // The file content.
			'Create ' . $item->system_name, // The commit message.
			$repo->write_branch // The branch name.
		);
	}

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
	protected function updateItemReadme(object $item, object $existing, object $repo): void
	{
		// make sure there was a change
		$sha = $existing->params->source[$repo->guid . '-readme'] ?? null;
		if ($sha === null)
		{
			return;
		}

		$this->git->update(
			$repo->organisation, // The owner name.
			$repo->repository, // The repository name.
			'src/' . $item->guid . '/README.md', // The file path.
			$this->itemReadme->get($item), // The file content.
			'Update ' . $item->system_name . ' readme file', // The commit message.
			$sha, // The blob SHA of the old file.
			$repo->write_branch // The branch name.
		);
	}

	/**
	 * create a new item readme
	 *
	 * @param object  $item
	 * @param object  $repo
	 *
	 * @return void
	 * @since 3.2.2
	 */
	protected function createItemReadme(object $item, object $repo): void
	{
		$this->git->create(
			$repo->organisation, // The owner name.
			$repo->repository, // The repository name.
			'src/' . $item->guid . '/README.md', // The file path.
			$this->itemReadme->get($item), // The file content.
			'Create ' . $item->system_name . ' readme file', // The commit message.
			$repo->write_branch // The branch name.
		);
	}
}

