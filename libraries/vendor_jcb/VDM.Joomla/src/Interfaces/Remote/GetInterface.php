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


use VDM\Joomla\Interfaces\Remote\BaseInterface;


/**
 * Load data based on global unique ids from remote system
 * 
 * @since 3.2.2
 */
interface GetInterface extends BaseInterface
{
	/**
	 * Initializes and categorizes items by checking their existence in the local database
	 * and optionally retrieving them from a remote repository if not found locally.
	 *
	 * This method processes an array of unique identifiers (`$items`) and checks each item:
	 * - If found in the local database: categorized under 'local'.
	 * - If not found locally and not available remotely: categorized under 'not_found'.
	 * - If retrieved from the remote repository: categorized under 'added' and stored locally.
	 *
	 * @param array        $items   An array of item identifiers (GUIDs) to initialize and validate.
	 * @param object|null  $repo    The repository object to search. If null, all repos will be searched.
	 *
	 * @return array{
	 *     local: array<string, string>,
	 *     not_found: array<string, string>,
	 *     added: array<string, string>
	 * } Associative arrays indexed by GUIDs indicating the status of each item:
	 * - 'local': Items already present in the local database.
	 * - 'not_found': Items not found locally or remotely.
	 * - 'added': Items successfully retrieved from the remote repository and stored.
	 *
	 * @since  5.1.1
	 */
	public function init(array $items, ?object $repo = null): array;

	/**
	 * Get the path/repo object
	 *
	 * @param string   $guid  The target repository guid.
	 *
	 * @return object|null
	 * @since  5.1.1
	 */
	public function path(string $guid): ?object;

	/**
	 * get all the available paths for this area
	 *
	 * @return array|null
	 * @since  5.1.1
	 */
	public function paths(): ?array;

	/**
	 * Get all available items for the given repository, or all repositories if none specified.
	 *
	 * @param string|null $repo The target repository to list (optional).
	 *
	 * @return array|null An array of indexed path objects or null if not found.
	 * @since 5.1.1
	 */
	public function list(?string $repo = null): ?array;

	/**
	 * Reset the items
	 *
	 * @param array   $items    The global unique ids of the items
	 *
	 * @return bool
	 * @since  3.2.0
	 */
	public function reset(array $items): bool;

	/**
	 * Load an item
	 *
	 * @param string       $guid    The global unique id of the item
	 * @param array        $order   The search order
	 * @param object|null  $repo    The repository object to search. If null, all repos will be searched.
	 *
	 * @return bool
	 * @since  3.2.0
	 * @since  5.1.1  We added the repo object
	 */
	public function item(string $guid, array $order = ['remote', 'local'], ?object $repo = null): bool;
}

