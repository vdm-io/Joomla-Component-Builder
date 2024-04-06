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
 * The Gitea Repository Statuses
 * 
 * @since 3.2.0
 */
class Statuses extends Api
{
	/**
	 * Get a commit's statuses.
	 *
	 * @param	string   $ownerName	The owner name.
	 * @param	string   $repoName		The repository name.
	 * @param	string   $commitSha	The commit SHA.
	 * @param	string   $sort			The type of sort.
	 * @param	string   $state			The type of state.
	 * @param	int      $page			The page number of results to return (1-based).
	 * @param	int      $limit			The page size of results.
	 *
	 * @return  array|null
	 * @since   3.2.0
	 **/
	public function get(
		string $ownerName,
		string $repoName,
		string $commitSha,
		string $sort = 'recentupdate',
		string $state = 'pending',
		int $page = 1,
		int $limit = 10
	): ?array
	{
		// Build the request path.
		$path = "/repos/{$ownerName}/{$repoName}/statuses/{$commitSha}";

		// Prepare the URI with the path.
		$uri = $this->uri->get($path);

		// Set the query parameters.
		$uri->setVar('sort', $sort);
		$uri->setVar('state', $state);
		$uri->setVar('page', $page);
		$uri->setVar('limit', $limit);

		// Send the get request.
		return $this->response->get(
			$this->http->get($uri)
		);
	}

	/**
	 * Create a commit status.
	 *
	 * @param	string        $ownerName			The owner name.
	 * @param	string        $repoName			The repository name.
	 * @param	string        $commitSha			The commit SHA.
	 * @param	string        $state				The commit status state (error, failure, pending, success, or warning).
	 * @param	string|null   $context			The context of the status (optional).
	 * @param	string|null   $statusDescription	The status description (optional).
	 * @param	string|null   $targetUrl			The URL of the associated build status (optional).
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function create(
		string $ownerName,
		string $repoName,
		string $commitSha,
		string $state,
		?string $context = null,
		?string $statusDescription = null,
		?string $targetUrl = null
	): ?object
	{
		// Build the request path.
		$path = "/repos/{$ownerName}/{$repoName}/statuses/{$commitSha}";

		// Set the commit status data
		$data = new \stdClass();
		$data->state = $state;

		if ($context !== null) 
		{
			$data->context = $context;
		}

		if ($statusDescription !== null) 
		{
			$data->description = $statusDescription;
		}

		if ($targetUrl !== null) 
		{
			$data->target_url = $targetUrl;
		}

		// Send the post request.
		return $this->response->get(
			$this->http->post(
				$this->uri->get($path), json_encode($data)
			), 201
		);
	}

}

