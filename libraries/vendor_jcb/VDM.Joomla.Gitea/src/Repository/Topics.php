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
 * The Gitea Repository Topics
 * 
 * @since 3.2.0
 */
class Topics extends Api
{
	/**
	 * Get the list of topics that a repository has.
	 *
	 * @param	string   $owner	The owner name.
	 * @param	string   $repo		The repository name.
	 * @param	int      $page		The page number of results to return (1-based).
	 * @param   	int      $limit		The page size of results.
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function get(
		string $owner,
		string $repo,
		int $page = 1,
		int $limit = 10
	): ?object
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/topics";

		// Set query parameters for pagination.
		$uri = $this->uri->get($path);
		$uri->setVar('page', $page);
		$uri->setVar('limit', $limit);

		// Send the get request.
		return $this->response->get(
			$this->http->get($uri)
		);
	}

	/**
	 * Replace the list of topics for a repository.
	 *
	 * @param	string   $ownerName	The owner name.
	 * @param	string   $repoName		The repository name.
	 * @param	array    $topicNames	The new list of topics.
	 *
	 * @return  string
	 * @since   3.2.0
	 **/
	public function replace(
		string $ownerName,
		string $repoName,
		array $topicNames
	): string
	{
		// Build the request path.
		$path = "/repos/{$ownerName}/{$repoName}/topics";

		// Set the topics data.
		$data = new \stdClass();
		$data->topics = $topicNames;

		// Send the put request.
		return $this->response->get(
			$this->http->put(
				$this->uri->get($path),
				json_encode($data)
			), 204, 'success'
		);
	}

	/**
	 * Add a topic to a repository.
	 *
	 * @param	string   $ownerName	The owner name.
	 * @param	string   $repoName		The repository name.
	 * @param	string   $topicName		The topic to add.
	 *
	 * @return  string
	 * @since   3.2.0
	 **/
	public function add(
		string $ownerName,
		string $repoName,
		string $topicName
	): string
	{
		// Build the request path.
		$path = "/repos/{$ownerName}/{$repoName}/topics/{$topicName}";

		// Send the put request.
		return $this->response->get(
			$this->http->put(
				$this->uri->get($path), ''
			), 204, 'success'
		);
	}

	/**
	 * Delete a topic from a repository.
	 *
	 * @param	string   $ownerName	The owner name.
	 * @param	string   $repoName		The repository name.
	 * @param	string   $topicName		The topic to delete.
	 *
	 * @return  string
	 * @since   3.2.0
	 **/
	public function delete(
		string $ownerName,
		string $repoName,
		string $topicName
	): string
	{
		// Build the request path.
		$path = "/repos/{$ownerName}/{$repoName}/topics/{$topicName}";

		// Send the delete request.
		return $this->response->get(
			$this->http->delete(
				$this->uri->get($path)
			), 204, 'success'
		);
	}

	/**
	 * Search topics via keyword.
	 *
	 * @param 	string   $searchKeyword	The keyword to search for.
	 * @param	int      $page			The page number of results to return (1-based).
	 * @param	int      $limit			The page size of results.
	 *
	 * @return  array|null
	 * @since   3.2.0
	 **/
	public function search(
		string $searchKeyword,
		int $page = 1,
		int $limit = 10
	): ?array
	{
		// Build the request path.
		$path = "/topics/search";

		// Set the query parameters.
		$uri = $this->uri->get($path);
		$uri->setVar('q', $searchKeyword);
		$uri->setVar('page', $page);
		$uri->setVar('limit', $limit);

		// Send the get request.
		return $this->response->get(
			$this->http->get($uri)
		);
	}

}

