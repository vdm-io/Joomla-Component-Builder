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
 * The Gitea Repository Branch
 * 
 * @since 3.2.0
 */
class Branch extends Api
{
	/**
	 * List a repository's branches.
	 *
	 * @param   string  $owner  The owner name.
	 * @param   string  $repo   The repository name.
	 * @param   int     $page   Page number of results to return (1-based).
	 * @param   int     $limit  Page size of results.
	 *
	 * @return  array|null
	 * @since   3.2.0
	 **/
	public function list(
		string $owner,
		string $repo,
		int $page = 1,
		int $limit = 10
	): ?array
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/branches";

		// Set the required variables to the URI.
		$uri = $this->uri->get($path);
		$uri->setVar('owner', $owner);
		$uri->setVar('repo', $repo);
		$uri->setVar('page', $page);
		$uri->setVar('limit', $limit);

		// Send the get request.
		return $this->response->get(
			$this->http->get($uri)
		);
	}

	/**
	 * Create a branch.
	 *
	 * @param   string  $owner         The owner name.
	 * @param   string  $repo          The repository name.
	 * @param   string  $branch_name   The name of the new branch.
	 * @param   string  $old_branch    The name of the existing branch from which to create the new branch.
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function create(
		string $owner,
		string $repo,
		string $branch_name,
		string $old_branch
	): ?object
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/branches";

		// Set the branch data.
		$data = new \stdClass();
		$data->branch_name = $branch_name;
		$data->old_branch = $old_branch;

		// Send the post request.
		return $this->response->get(
			$this->http->post(
				$this->uri->get($path), json_encode($data)
			), 201
		);
	}

	/**
	 * Retrieve a specific branch from a repository, including its effective branch protection.
	 *
	 * @param   string  $owner    The owner name.
	 * @param   string  $repo     The repository name.
	 * @param   string  $branch   The branch name.
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function get(string $owner, string $repo, string $branch): ?object
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/branches/{$branch}";

		// Set the required variables to the URI.
		$uri = $this->uri->get($path);
		$uri->setVar('owner', $owner);
		$uri->setVar('repo', $repo);
		$uri->setVar('branch', $branch);

		// Send the get request.
		return $this->response->get(
			$this->http->get($uri)
		);
	}

	/**
	 * Delete a specific branch from a repository.
	 *
	 * @param   string  $owner    The owner name.
	 * @param   string  $repo     The repository name.
	 * @param   string  $branch   The branch name.
	 *
	 * @return  string
	 * @since   3.2.0
	 **/
	public function delete(
		string $owner,
		string $repo,
		string $branch
	): string
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/branches/{$branch}";

		// Send the delete request.
		return $this->response->get(
			$this->http->delete(
				$this->uri->get($path)
			), 204, 'success'
		);
	}

}

