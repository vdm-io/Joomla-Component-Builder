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

namespace VDM\Joomla\Github\Repository;


use VDM\Joomla\Interfaces\Git\Repository\WikiInterface;
use VDM\Joomla\Github\Abstraction\Api;
use Joomla\CMS\Uri\Uri;


/**
 * The Github Repository Wiki
 * 
 * @since 5.1.1
 */
class Wiki extends Api implements WikiInterface
{
	/**
	 * Create a new wiki page or update it if it already exists.
	 *
	 * @param  string       $owner           Repository owner (user or organization).
	 * @param  string       $repo            Repository name (without `.wiki`).
	 * @param  string       $title           Title of the wiki page.
	 * @param  string       $contentBase64   Base64-encoded Markdown content.
	 * @param  string|null  $message         Optional commit message.
	 *
	 * @return object|null  API response object or null on failure.
	 * @since  5.1.1
	 */
	public function create(
		string $owner,
		string $repo,
		string $title,
		string $contentBase64,
		?string $message = null
	): ?object
	{
		return null; // github does not support wiki over API
	}

	/**
	 * Retrieve the content of a specific wiki page.
	 *
	 * @param  string  $owner      Repository owner (user or organization).
	 * @param  string  $repo       Repository name (without `.wiki`).
	 * @param  string  $pageName   Name of the page (excluding `.md`).
	 *
	 * @return object|null  Page details including content and metadata, or null on failure.
	 * @since  5.1.1
	 */
	public function get(
		string $owner,
		string $repo,
		string $pageName
	): ?object
	{
		// Build the raw wiki URL
		$url = "https://raw.githubusercontent.com/wiki/{$owner}/{$repo}/{$pageName}.md";

		// Use a direct HTTP GET request (bypasses GitHub API)
		$body = $this->response->get(
			$this->http->get(new Uri($url), [])
		);

		return (object) [
			'name' => "{$pageName}.md",
			'content' => base64_encode($body),
		];
	}

	/**
	 * List all wiki pages in the repository.
	 *
	 * @param  string  $owner   Repository owner (user or organization).
	 * @param  string  $repo    Repository name (without `.wiki`).
	 * @param  int     $page    Pagination index (1-based).
	 * @param  int     $limit   Number of results per page.
	 *
	 * @return array|null  List of page metadata or null on failure.
	 * @since  5.1.1
	 */
	public function pages(
		string $owner,
		string $repo,
		int $page = 1,
		int $limit = 10
	): ?array
	{
		return null; // github does not support wiki over API
	}

	/**
	 * Delete a wiki page from the repository.
	 *
	 * @param  string  $owner      Repository owner (user or organization).
	 * @param  string  $repo       Repository name (without `.wiki`).
	 * @param  string  $pageName   Name of the page to delete (excluding `.md`).
	 *
	 * @return string  'success' on deletion, or error message if the page was not found.
	 * @since  5.1.1
	 */
	public function delete(
		string $owner,
		string $repo,
		string $pageName
	): string
	{
		return 'error'; // github does not support wiki over API
	}

	/**
	 * Edit an existing wiki page.
	 *
	 * @param  string       $owner      Repository owner (user or organization).
	 * @param  string       $repo       Repository name (without `.wiki`).
	 * @param  string       $pageName   Name of the page to edit (excluding `.md`).
	 * @param  string       $title      New title of the page (used to rename if applicable).
	 * @param  string       $content    Updated Markdown content.
	 * @param  string|null  $message    Optional commit message.
	 *
	 * @return object|null  API response object or null if the page doesn't exist.
	 * @since  5.1.1
	 */
	public function edit(
		string $owner,
		string $repo,
		string $pageName,
		string $title,
		string $content,
		?string $message = null
	): ?object
	{
		return null; // github does not support wiki over API
	}

	/**
	 * Get the commit history (revisions) for a specific wiki page.
	 *
	 * @param  string  $owner      Repository owner (user or organization).
	 * @param  string  $repo       Repository name (without `.wiki`).
	 * @param  string  $pageName   Name of the page to retrieve revisions for (excluding `.md`).
	 * @param  int     $page       Pagination index (1-based).
	 *
	 * @return object|null  API response object with commit history or null on failure.
	 * @since  5.1.1
	 */
	public function revisions(
		string $owner,
		string $repo,
		string $pageName,
		int $page = 1
	): ?object
	{
		return null; // github does not support wiki over API
	}
}

