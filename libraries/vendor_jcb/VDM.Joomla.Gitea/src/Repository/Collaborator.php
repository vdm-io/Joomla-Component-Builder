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
 * The Gitea Repository Collaborator
 * 
 * @since 3.2.0
 */
class Collaborator extends Api
{
	/**
	 * List a repository's collaborators.
	 *
	 * @param   string  $owner      The owner name.
	 * @param   string  $repo       The repository name.
	 * @param   int     $page       The page number of results to return (1-based).
	 * @param   int     $limit      The page size of results.
	 *
	 * @return  array|null
	 * @since   3.2.0
	 **/
	public function list(string $owner, string $repo, int $page = 1, int $limit = 10): ?array
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/collaborators";

		// Get the URI object for the path.
		$uri = $this->uri->get($path);

		// Set the page and limit variables.
		$uri->setVar('page', $page);
		$uri->setVar('limit', $limit);

		// Send the get request.
		return $this->response->get(
			$this->http->get($uri)
		);
	}

	/**
	 * Check if a user is a collaborator of a repository.
	 *
	 * @param   string  $owner         The owner name.
	 * @param   string  $repo          The repository name.
	 * @param   string  $collaborator  The collaborator username.
	 *
	 * @return  string
	 * @since   3.2.0
	 **/
	public function check(
		string $owner,
		string $repo,
		string $collaborator
	): string
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/collaborators/{$collaborator}";

		// Get the URI object for the path.
		$uri = $this->uri->get($path);

		// Send the get request.
		return $this->response->get(
			$this->http->get($uri), 204, 'success'
		);
	}

	/**
	 * Add a collaborator to a repository.
	 *
	 * @param   string  $owner         The owner name.
	 * @param   string  $repo          The repository name.
	 * @param   string  $collaborator  The collaborator username.
	 * @param   string  $permission    The permission level for the collaborator (optional).
	 *
	 * @return  string
	 * @since   3.2.0
	 **/
	public function add(
		string $owner,
		string $repo,
		string $collaborator,
		string $permission = null
	): string
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/collaborators/{$collaborator}";

		// Get the URI object for the path.
		$uri = $this->uri->get($path);

		// Prepare the request body.
		$body = new stdClass();
		if ($permission !== null) {
			$body->permission = $permission;
		}
		$bodyJson = json_encode($body);

		// Send the put request.
		return $this->response->get(
			$this->http->put($uri, $bodyJson), 204, 'success'
		);
	}

	/**
	 * Delete a collaborator from a repository.
	 *
	 * @param   string  $owner         The owner name.
	 * @param   string  $repo          The repository name.
	 * @param   string  $collaborator  The collaborator username.
	 *
	 * @return  string
	 * @since   3.2.0
	 **/
	public function delete(
		string $owner,
		string $repo,
		string $collaborator
	): string
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/collaborators/{$collaborator}";

		// Send the delete request.
		return $this->response->get(
			$this->http->delete(
				$this->uri->get($path)
			), 204, 'success'
		);
	}

	/**
	 * Get repository permissions for a user.
	 *
	 * @param   string  $owner         The owner name.
	 * @param   string  $repo          The repository name.
	 * @param   string  $collaborator  The collaborator username.
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function permission(
		string $owner,
		string $repo,
		string $collaborator
	): ?object
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/collaborators/{$collaborator}/permission";

		// Get the URI object for the path.
		$uri = $this->uri->get($path);

		// Send the get request.
		return $this->response->get(
			$this->http->get($uri)
		);
	}

}

