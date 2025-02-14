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

namespace VDM\Joomla\Interfaces;


use VDM\Joomla\Interfaces\Git\ApiInterface as Api;


/**
 * Global Resource Empowerment Platform
 * 
 * @since 3.2.1
 */
interface GrepInterface
{
	/**
	 * Get an item
	 *
	 * @param string       $guid    The global unique id of the item
	 * @param array|null   $order   The search order
	 * @param object|null  $repo    The repository object to search. If null, all repos will be searched.
	 *
	 * @return object|null
	 * @since 3.2.2
	 */
	public function get(string $guid, ?array $order = null, ?object $repo = null): ?object;

	/**
	 * Get all remote GUID's
	 *
	 * @return array|null
	 * @since 3.2.0
	 */
	public function getRemoteGuid(): ?array;

	/**
	 * Set the branch field
	 *
	 * @param string    $field   The field to use to get the branch name from the data set
	 *
	 * @return void
	 * @since 3.2.2
	 */
	public function setBranchField(string $field): void;

	/**
	 * Set the DEFAULT branch name (only used if branch field is not found)
	 *
	 * @param string|null    $name   The default branch to use if no name could be found
	 *
	 * @return void
	 * @since 3.2.2
	 */
	public function setBranchDefaultName(?string $name): void;

	/**
	 * Set the index path
	 *
	 * @param string    $indexPath    The repository index path
	 *
	 * @return void
	 * @since 3.2.2
	 */
	public function setIndexPath(string $indexPath): void;

	/**
	 * Get the index of a repo
	 *
	 * @param string $guid The unique identifier for the repo.
	 *
	 * @return object|null
	 * @since 3.2.2
	 */
	public function getRemoteIndex(string $guid): ?object;

	/**
	 * Loads API config using the provided base URL and token.
	 *
	 * This method checks if the base URL contains 'https://git.vdm.dev/'.
	 * If it does, it uses the token as is (which may be null).
	 * If not, it ensures the token is not null by defaulting to an empty string.
	 *
	 * @param Api          $api    The api object with a load_ method.
	 * @param string|null  $base   The base URL path.
	 * @param string|null  $token  The token for authentication (can be null).
	 *
	 * @return void
	 * @since 5.0.4
	 */
	public function loadApi(Api $api, ?string $base, ?string $token): void;
}

