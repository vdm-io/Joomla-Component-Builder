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

namespace VDM\Joomla\Interfaces\Git\Repository;


use VDM\Joomla\Interfaces\Git\ApiInterface;


/**
 * The Git Repository Tags Interface
 * 
 * @since 5.1.1
 */
interface TagsInterface extends ApiInterface
{
	/**
	 * List a repository's tags
	 *
	 * @param   string   $owner      The owner of the repo.
	 * @param   string   $repo       The name of the repo.
	 * @param   int|null $page       The page number of results to return (1-based).
	 * @param   int|null $limit      The page size of results, default maximum page size is 10.
	 *
	 * @return  array|null
	 * @since   3.2.0
	 **/
	public function list(
		string $owner,
		string $repo,
		?int $page = 1,
		?int $limit = 10
	): ?array;

	/**
	 * Get the tag of a repository by tag name.
	 *
	 * @param   string   $owner  The owner name.
	 * @param   string   $repo   The repository name.
	 * @param   string   $tag    The tag name.
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function get(string $owner, string $repo, string $tag): ?object;

	/**
	 * Get the tag object of an annotated tag (not lightweight tags).
	 *
	 * @param   string  $owner  The owner of the repo.
	 * @param   string  $repo   The name of the repo.
	 * @param   string  $sha    The sha of the tag. The Git tags API only supports annotated tag objects, not lightweight tags.
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function sha(
		string $owner,
		string $repo,
		string $sha
	): ?object;

	/**
	 * Create a new git tag in a repository.
	 *
	 * @param   string   $owner       The owner of the repo.
	 * @param   string   $repo        The name of the repo.
	 * @param   string   $tagName     The name of the tag.
	 * @param   string   $target      The SHA of the git object this is tagging.
	 * @param   string   $message     The tag message.
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function create(
		string $owner,
		string $repo,
		string $tagName,
		string $target,
		string $message
	): ?object;

	/**
	 * Delete a repository's tag by name.
	 *
	 * @param   string   $owner  The owner name.
	 * @param   string   $repo   The repository name.
	 * @param   string   $tag    The tag name.
	 *
	 * @return  string
	 * @since   3.2.0
	 **/
	public function delete(
		string $owner,
		string $repo,
		string $tag
	): string;
}

