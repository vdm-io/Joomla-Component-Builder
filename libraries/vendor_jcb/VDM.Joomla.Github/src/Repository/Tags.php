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


use VDM\Joomla\Interfaces\Git\Repository\TagsInterface;
use VDM\Joomla\Github\Abstraction\Api;


/**
 * The Github Repository Tags
 * 
 * @since 5.1.1
 */
final class Tags extends Api implements TagsInterface
{
	/**
	 * List a repository's tags
	 *
	 * @param   string   $owner  The owner of the repo.
	 * @param   string   $repo   The name of the repo.
	 * @param   int|null $page   The page number of results to return (1-based).
	 * @param   int|null $limit  The page size of results. GitHub default is 30, max 100. Here we fix it to 10.
	 *
	 * @return  array|null
	 * @since   3.2.0
	 */
	public function list(
		string $owner,
		string $repo,
		?int $page = 1,
		?int $limit = 10
	): ?array {
		$path = "/repos/{$owner}/{$repo}/tags";
		$uri = $this->uri->get($path);

		$uri->setVar('page', $page ?? 1);
		$uri->setVar('per_page', $limit ?? 10);

		return $this->response->get(
			$this->http->get($uri)
		);
	}

	/**
	 * Get the tag object by tag name (loop until found or exhausted).
	 *
	 * @param   string  $owner  The owner name.
	 * @param   string  $repo   The repository name.
	 * @param   string  $tag    The tag name to find.
	 *
	 * @return  object|null
	 * @since   3.2.0
	 */
	public function get(string $owner, string $repo, string $tag): ?object
	{
		$page = 1;
		$limit = 10;

		do {
			$tags = $this->list($owner, $repo, $page, $limit);

			if (empty($tags))
			{
				return null;
			}

			foreach ($tags as $entry)
			{
				if (isset($entry->name) && $entry->name === $tag)
				{
					return $entry;
				}
			}

			$page++;
		} while (count($tags) === $limit);

		return null;
	}

	/**
	 * Get the annotated tag object by SHA.
	 *
	 * @param   string  $owner  The owner of the repo.
	 * @param   string  $repo   The repository name.
	 * @param   string  $sha    The tag object SHA.
	 *
	 * @return  object|null
	 * @since   3.2.0
	 */
	public function sha(string $owner, string $repo, string $sha): ?object
	{
		$path = "/repos/{$owner}/{$repo}/git/tags/{$sha}";
		return $this->response->get(
			$this->http->get($this->uri->get($path))
		);
	}

	/**
	 * Create a new annotated tag and attach it to the repository.
	 *
	 * GitHub requires two steps to create a tag:
	 * 1. Create an annotated tag object.
	 * 2. Create a reference to the tag under `refs/tags/*`.
	 *
	 * @param   string  $owner      The owner of the repo.
	 * @param   string  $repo       The repository name.
	 * @param   string  $tagName    The name of the tag.
	 * @param   string  $target     The SHA the tag points to (usually a commit SHA).
	 * @param   string  $message    The tag message.
	 *
	 * @return  object|null
	 * @since   3.2.0
	 */
	public function create(string $owner, string $repo, string $tagName, string $target, string $message): ?object
	{
		// Step 1: Create the tag object
		$tagObject = (object) [
			'tag' => $tagName,
			'message' => $message,
			'object' => $target,
			'type' => 'commit'
		];

		$tagResponse = $this->response->get(
			$this->http->post(
				$this->uri->get("/repos/{$owner}/{$repo}/git/tags"),
				json_encode($tagObject)
			)
		);

		if (!isset($tagResponse->sha))
		{
			return null;
		}

		// Step 2: Create the ref pointing to the tag object
		$refData = (object) [
			'ref' => "refs/tags/{$tagName}",
			'sha' => $tagResponse->sha
		];

		return $this->response->get(
			$this->http->post(
				$this->uri->get("/repos/{$owner}/{$repo}/git/refs"),
				json_encode($refData)
			)
		);
	}

	/**
	 * Delete a tag reference by tag name.
	 *
	 * GitHub deletes tags via refs.
	 *
	 * @param   string  $owner  The owner name.
	 * @param   string  $repo   The repository name.
	 * @param   string  $tag    The tag name to delete.
	 *
	 * @return  string  Returns 'success' on successful deletion.
	 * @since   3.2.0
	 */
	public function delete(string $owner, string $repo, string $tag): string
	{
		$path = "/repos/{$owner}/{$repo}/git/refs/tags/{$tag}";

		return $this->response->get(
			$this->http->delete(
				$this->uri->get($path)
			),
			204,
			'success'
		);
	}
}

