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

namespace VDM\Joomla\Componentbuilder\Fieldtype\Remote;


use VDM\Joomla\Interfaces\Remote\SetInterface;
use VDM\Joomla\Abstraction\Remote\Set as ExtendingSet;


/**
 * Set Field Type based on global unique ids to remote repository
 * 
 * @since 5.0.3
 */
final class Set extends ExtendingSet implements SetInterface
{
	/**
	 * Table Name
	 *
	 * @var    string
	 * @since 5.0.3
	 */
	protected string $table = 'fieldtype';

	/**
	 * Area Name
	 *
	 * @var    string
	 * @since 5.0.3
	 */
	protected string $area = 'Joomla Field Type';

	/**
	 * Prefix Key
	 *
	 * @var    string
	 * @since 5.0.3
	 */
	protected string $prefix_key = '';

	/**
	 * The item map
	 *
	 * @var    array
	 * @since 5.0.3
	 */
	protected array $map = [
		'name' => 'name',
		'short_description' => 'short_description',
		'description' => 'description',
		'properties' => 'properties',
		'has_defaults' => 'has_defaults',
		'datatype' => 'datatype',
		'datalenght' => 'datalenght',
		'datalenght_other' => 'datalenght_other',
		'datadefault' => 'datadefault',
		'datadefault_other' => 'datadefault_other',
		'indexes' => 'indexes',
		'null_switch' => 'null_switch',
		'store' => 'store',
		'guid' => 'guid'
	];

	/**
	 * The index map
	 *
	 * @var    array
	 * @since 5.0.3
	 */
	protected array $index_map = [
		'name' => 'index_map_IndexName',
		'desc' => 'index_map_ShortDescription',
		'settings' => 'index_map_IndexSettingsPath',
		'path' => 'index_map_IndexPath',
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
	 * @since  5.0.3
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
			'Update ' . $item->name, // The commit message.
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
	 * @since  5.0.3
	 */
	protected function createItem(object $item, object $repo): void
	{
		$this->git->create(
			$repo->organisation, // The owner name.
			$repo->repository, // The repository name.
			'src/' . $item->guid . '/' . $this->getSettingsPath(), // The file path.
			json_encode($item, JSON_PRETTY_PRINT), // The file content.
			'Create ' . $item->name, // The commit message.
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
	 * @since  5.0.3
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
			'Update ' . $item->name . ' readme file', // The commit message.
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
	 * @since  5.0.3
	 */
	protected function createItemReadme(object $item, object $repo): void
	{
		$this->git->create(
			$repo->organisation, // The owner name.
			$repo->repository, // The repository name.
			'src/' . $item->guid . '/README.md', // The file path.
			$this->itemReadme->get($item), // The file content.
			'Create ' . $item->name . ' readme file', // The commit message.
			$repo->write_branch // The branch name.
		);
	}

	/**
	 * Get the item name for the index values
	 *
	 * @param object $item
	 *
	 * @return string|null
	 * @since  5.0.3
	 */
	protected function index_map_IndexName(object $item): ?string
	{
		return $item->name ?? null;
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
		return $item->short_description ?? null;
	}
}

