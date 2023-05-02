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
 * The Gitea Repository Teams
 * 
 * @since 3.2.0
 */
class Teams extends Api
{
	/**
	 * List a repository's teams.
	 *
	 * @param	string   $ownerOfRepo	The owner name.
	 * @param	string   $nameOfRepo	The repository name.
	 *
	 * @return  array|null
	 * @since   3.2.0
	 **/
	public function list(string $ownerOfRepo, string $nameOfRepo): ?array
	{
		// Build the request path.
		$path = "/repos/{$ownerOfRepo}/{$nameOfRepo}/teams";

		// Get the URI with the path.
		$uri = $this->uri->get($path);

		// Send the get request.
		return $this->response->get(
			$this->http->get($uri)
		);
	}

	/**
	 * Check if a team is assigned to a repository.
	 *
	 * @param	string   $ownerOfRepo	The owner name.
	 * @param	string   $nameOfRepo	The repository name.
	 * @param	string   $teamName	The team name.
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function check(
		string $ownerOfRepo,
		string $nameOfRepo,
		string $teamName
	): ?object
	{
		// Build the request path.
		$path = "/repos/{$ownerOfRepo}/{$nameOfRepo}/teams/{$teamName}";

		// Get the URI with the path.
		$uri = $this->uri->get($path);

		// Send the get request.
		return $this->response->get(
			$this->http->get($uri)
		);
	}

	/**
	 * Add a team to a repository.
	 *
	 * @param	string   $ownerName	The owner name.
	 * @param	string   $repoName		The repository name.
	 * @param	string   $teamName	The team name.
	 *
	 * @return  string
	 * @since   3.2.0
	 **/
	public function add(
		string $ownerName,
		string $repoName,
		string $teamName
	): string
	{
		// Build the request path.
		$path = "/repos/{$ownerName}/{$repoName}/teams/{$teamName}";

		// Send the put request.
		return $this->response->get(
			$this->http->put(
				$this->uri->get($path), ''
			), 204, 'success'
		);
	}

	/**
	 * Delete a team from a repository.
	 *
	 * @param	string   $ownerName	The owner name.
	 * @param	string   $repoName		The repository name.
	 * @param	string   $teamName	The team name.
	 *
	 * @return  string
	 * @since   3.2.0
	 **/
	public function delete(
		string $ownerName,
		string $repoName,
		string $teamName
	): string
	{
		// Build the request path.
		$path = "/repos/{$ownerName}/{$repoName}/teams/{$teamName}";

		// Prepare the URI with the path.
		$uri = $this->uri->get($path);

		// Send the delete request.
		return $this->response->get(
			$this->http->delete($uri),
			204, 'success'
		);
	}

}

