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
 * The Gitea Repository Watchers
 * 
 * @since 3.2.0
 */
class Watchers extends Api
{
	/**
	 * List a repo's watchers.
	 *
	 * @param	string   $ownerName	The owner name.
	 * @param	string   $repoName		The repository name.
	 * @param	int      $page			Page number of results to return (1-based).
	 * @param	int      $limit			Page size of results.
	 *
	 * @return  array|null
	 * @since   3.2.0
	 **/
	public function list(
		string $ownerName,
		string $repoName,
		int $page = 1,
		int $limit = 10
	): ?array
	{
		// Build the request path.
		$path = "/repos/{$ownerName}/{$repoName}/subscribers";

		// Prepare the URI with the path.
		$uri = $this->uri->get($path);

		// Set the page and limit query parameters.
		$uri->setVar('page', $page);
		$uri->setVar('limit', $limit);

		// Send the get request.
		return $this->response->get(
			$this->http->get($uri)
		);
	}

	/**
	 * Check if the current user is watching a repo.
	 *
	 * @param	string   $ownerName	The owner name.
	 * @param	string   $repoName		The repository name.
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function check(string $ownerName, string $repoName): ?object
	{
		// Build the request path.
		$path = "/repos/{$ownerName}/{$repoName}/subscription";

		// Prepare the URI with the path.
		$uri = $this->uri->get($path);

		// Send the get request.
		return $this->response->get(
			$this->http->get($uri)
		);
	}

	/**
	 * Watch a repo.
	 *
	 * @param	string   $ownerName	The owner name.
	 * @param	string   $repoName		The repository name.
	 * @param	bool     $subscribed	Determine if notifications should be received from this repository.
	 * @param	bool     $ignored		Determine if all notifications should be blocked from this repository.
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function watch(
		string $ownerName,
		string $repoName,
		bool $subscribed = true,
		bool $ignored = false
	): ?object
	{
		// Build the request path.
		$path = "/repos/{$ownerName}/{$repoName}/subscription";

		// Set the subscription data
		$data = new \stdClass();
		$data->subscribed = $subscribed;
		$data->ignored = $ignored;

		// Send the put request.
		return $this->response->get(
			$this->http->put(
				$this->uri->get($path), json_encode($data)
			)
		);
	}

	/**
	 * Unwatch a repo.
	 *
	 * @param	string   $ownerName	The owner name.
	 * @param	string   $repoName		The repository name.
	 *
	 * @return  string
	 * @since   3.2.0
	 **/
	public function unwatch(string $ownerName, string $repoName): string
	{
		// Build the request path.
		$path = "/repos/{$ownerName}/{$repoName}/subscription";

		// Prepare the URI with the path.
		$uri = $this->uri->get($path);

		// Send the delete request.
		return $this->response->get(
			$this->http->delete($uri), 204, 'success'
		);
	}

}

