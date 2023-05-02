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

namespace VDM\Joomla\Gitea\Organization\Teams;


use VDM\Joomla\Gitea\Abstraction\Api;


/**
 * The Gitea Organization Teams Repository
 * 
 * @since 3.2.0
 */
class Repository extends Api
{
	/**
	 * List a team's repos.
	 *
	 * @param   int   $teamId  The team ID.
	 * @param   int   $pageNumber  The page number of results to return (1-based).
	 * @param   int   $pageSize  The page size of results.
	 *
	 * @return  array|null
	 * @since   3.2.0
	 **/
	public function list(
		int $teamId,
		int $pageNumber = 1,
		int $pageSize = 10
	): ?array
	{
		// Build the request path.
		$path = "/teams/{$teamId}/repos";

		// Get the URI object.
		$uri = $this->uri->get($path);

		// Add the query parameters for page number and page size.
		$uri->setVar('page', $pageNumber);
		$uri->setVar('limit', $pageSize);

		// Send the get request.
		return $this->response->get(
			$this->http->get($uri)
		);
	}

	/**
	 * List a particular repo of the team.
	 *
	 * @param   int      $teamId     The team ID.
	 * @param   string   $organization   The organization name.
	 * @param   string   $repository   The repository name.
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function get(
		int $teamId,
		string $organization,
		string $repository
	): ?object
	{
		// Build the request path.
		$path = "/teams/{$teamId}/repos/{$organization}/{$repository}";

		// Send the get request.
		return $this->response->get(
			$this->http->get(
				$this->uri->get($path)
			)
		);
	}

	/**
	 * Add a repository to a team.
	 *
	 * @param   int      $id     The team ID.
	 * @param   string   $org    The organization name.
	 * @param   string   $repo   The repository name.
	 *
	 * @return  string
	 * @since   3.2.0
	 **/
	public function add(
		int $id,
		string $org,
		string $repo
	): string
	{
		// Build the request path.
		$path = "/teams/{$id}/repos/{$org}/{$repo}";

		// Send the put request.
		return $this->response->get(
			$this->http->put(
				$this->uri->get($path), ''
			),204, 'success'
		);
	}

	/**
	 * Remove a repository from a team.
	 *
	 * @param   int      $id     The team ID.
	 * @param   string   $org    The organization name.
	 * @param   string   $repo   The repository name.
	 *
	 * @return  string
	 * @since   3.2.0
	 **/
	public function remove(int $id, string $org, string $repo): string
	{
		// Build the request path.
		$path = "/teams/{$id}/repos/{$org}/{$repo}";

		// Send the delete request.
		return $this->response->get(
			$this->http->delete(
				$this->uri->get($path)
			), 204, 'success'
		);
	}

}

