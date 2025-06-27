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

namespace VDM\Joomla\Componentbuilder\Remote;


use Joomla\CMS\Language\Text;
use VDM\Joomla\Componentbuilder\Package\Dependency\Tracker;
use VDM\Joomla\Componentbuilder\Package\MessageBus as Messages;
use VDM\Joomla\Interfaces\GrepInterface as Grep;
use VDM\Joomla\Interfaces\Remote\Dependency\ResolverInterface as Resolver;
use VDM\Joomla\Interfaces\Remote\ConfigInterface as Config;
use VDM\Joomla\Interfaces\Readme\ItemInterface as ItemReadme;
use VDM\Joomla\Interfaces\Readme\MainInterface as MainReadme;
use VDM\Joomla\Interfaces\Git\Repository\ContentsInterface as Git;
use VDM\Joomla\Interfaces\Data\ItemsInterface as Items;
use VDM\Joomla\Interfaces\Remote\SetInterface;
use VDM\Joomla\Abstraction\Remote\Set as ExtendingSet;


/**
 * Set global unique ids to remote repository
 * 
 * @since 5.1.1
 */
class Set extends ExtendingSet implements SetInterface
{
	/**
	 * Constructor.
	 *
	 * @param Tracker      $tracker         The Tracker Class.
	 * @param Messages     $messages        The Message Bus Class.
	 * @param Grep         $grep            The Grep Class.
	 * @param Resolver     $resolver        The Resolver Class.
	 * @param Config       $config          The Config Class.
	 * @param ItemReadme   $itemreadme      The Item Readme Class.
	 * @param MainReadme   $mainreadme      The Main Readme Class.
	 * @param Git          $git             The Contents Git Class.
	 * @param Items        $items           The Items Class.
	 * @param string|null  $table           The table name.
	 * @param string|null  $settingsName    The settings file name.
	 * @param string|null  $indexPath       The index path.
	 *
	 * @since 5.1.1
	 */
	public function __construct(Tracker $tracker, Messages $messages, Grep $grep, Resolver $resolver,
		Config $config, ItemReadme $itemreadme, MainReadme $mainreadme,
		Git $git, Items $items, array $repos, ?string $table = null,
		?string $settingsName = null, ?string $indexPath = null)
	{
		parent::__construct($config, $grep, $items, $itemreadme, $mainreadme,
			$git, $tracker, $messages, $repos, $table, $settingsName, $indexPath);

		$this->resolver = $resolver;
	}

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
		$item_name = $this->index_map_IndexName($item) ?? $area;
		$repo_name = $this->getRepoName($repo);

		if ($sha === null || ($this->areObjectsEqual($item, $this->mapItem($existing)) && $this->dependenciesEqual($item, $existing)))
		{
			$this->messages->add('warning', Text::sprintf('COM_COMPONENTBUILDER_NO_CHANGE_S_ITEM_S_IN_REPO_S_IS_ALREADY_IN_SYNC', $area, $item_name, $repo_name));
			return false;
		}

		$result = $this->git->update(
			$repo->organisation, // The owner name.
			$repo->repository, // The repository name.
			$this->index_map_IndexSettingsPath($item), // The file path.
			json_encode($item, JSON_PRETTY_PRINT), // The file content.
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
			json_encode($item, JSON_PRETTY_PRINT), // The file content.
			'Create ' . ($this->index_map_IndexName($item) ?? $this->getArea()), // The commit message.
			$repo->write_branch, // The branch name.
			$repo->author_name, // The author name.
			$repo->author_email // The author email.
		);

		return is_object($result);
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
		if (!$this->hasItemReadme())
		{
			return;
		}

		// make sure there was a change
		$sha = $existing->params->source[$repo->guid . '-readme'] ?? null;
		if ($sha === null)
		{
			return;
		}

		$this->git->update(
			$repo->organisation, // The owner name.
			$repo->repository, // The repository name.
			$this->index_map_IndexReadmePath($item), // The file path.
			$this->itemReadme->get($item), // The file content.
			'Update ' . ($this->index_map_IndexName($item) ?? $this->getArea()) . ' readme file', // The commit message.
			$sha, // The blob SHA of the old file.
			$repo->write_branch, // The branch name.
			$repo->author_name, // The author name.
			$repo->author_email // The author email.
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
		if (!$this->hasItemReadme())
		{
			return;
		}

		$this->git->create(
			$repo->organisation, // The owner name.
			$repo->repository, // The repository name.
			$this->index_map_IndexReadmePath($item), // The file path.
			$this->itemReadme->get($item), // The file content.
			'Create ' . ($this->index_map_IndexName($item) ?? $this->getArea()) . ' readme file', // The commit message.
			$repo->write_branch, // The branch name.
			$repo->author_name, // The author name.
			$repo->author_email // The author email.
		);
	}

	/**
	 * Checks if two objects' @dependencies arrays are equal by comparing their values.
	 *
	 * This method ensures that each dependency object (key-value-entity-table structure)
	 * is present in both arrays, regardless of order. It treats dependencies as sets,
	 * meaning order is not significant, but exact match of all key-value pairs is required.
	 *
	 * @param object|null $obj1 The first object to compare.
	 * @param object|null $obj2 The second object to compare.
	 *
	 * @return bool True if the dependencies are equal, false otherwise.
	 * @since 5.0.2
	 */
	protected function dependenciesEqual(?object $obj1, ?object $obj2): bool
	{
		$deps1 = $obj1->{'@dependencies'} ?? [];
		$deps2 = $obj2->{'@dependencies'} ?? [];

		// If both are empty, they are equal
		if (empty($deps1) && empty($deps2))
		{
			return true;
		}

		// If counts differ, they are not equal
		if (count($deps1) !== count($deps2))
		{
			return false;
		}

		// Normalize the arrays (convert objects to sorted associative arrays)
		$normalize = static function (array $deps): array {
			$normalized = [];
			foreach ($deps as $dep)
			{
				$array = (array) $dep;
				ksort($array);
				$normalized[] = json_encode($array);
			}
			sort($normalized);
			return $normalized;
		};

		$norm1 = $normalize($deps1);
		$norm2 = $normalize($deps2);

		return $norm1 === $norm2;
	}
}

