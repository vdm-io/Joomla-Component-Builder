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

namespace VDM\Joomla\Gitea\Repository;


use VDM\Joomla\Gitea\Abstraction\Api;


/**
 * The Gitea Repository Tags
 * 
 * @since 3.2.0
 */
class Tags extends Api
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
	): ?array
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/tags";

		// Get the URI with the path.
		$uri = $this->uri->get($path);

		// Add query parameters if they are provided.
		if ($page !== null)
		{
			$uri->setVar('page', $page);
		}

		if ($limit !== null)
		{
			$uri->setVar('limit', $limit);
		}

		// Send the get request.
		return $this->response->get(
			$this->http->get($uri)
		);
	}

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
	public function get(string $owner, string $repo, string $tag): ?object
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/tags/{$tag}";

		// Send the get request.
		return $this->response->get(
			$this->http->get(
				$this->uri->get($path)
			)
		);
	}

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
	): ?object
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/git/tags/{$sha}";

		// Get the URI with the path.
		$uri = $this->uri->get($path);

		// Send the get request.
		return $this->response->get(
			$this->http->get($uri)
		);
	}

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
	): ?object
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/tags";

		// Set the tag data
		$data = new \stdClass();
		$data->tag_name = $tagName;
		$data->target = $target;
		$data->message = $message;

		// Send the post request.
		return $this->response->get(
			$this->http->post(
				$this->uri->get($path), json_encode($data)
			)
		);
	}

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
	): string
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/tags/{$tag}";

		// Send the delete request.
		return $this->response->get(
			$this->http->delete(
				$this->uri->get($path)
			), 204, 'succes'
		);
	}

}

