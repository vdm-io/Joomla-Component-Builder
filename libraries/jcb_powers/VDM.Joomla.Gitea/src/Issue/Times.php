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

namespace VDM\Joomla\Gitea\Issue;


use VDM\Joomla\Gitea\Abstraction\Api;


/**
 * The Gitea Issue Times
 * 
 * @since 3.2.0
 */
class Times extends Api
{
	/**
	 * List an issue's tracked times.
	 *
	 * @param   string   $owner      The owner name.
	 * @param   string   $repo       The repo name.
	 * @param   int      $index      The issue index.
	 * @param   string   $user       Optional. Filter by user.
	 * @param   string   $since      Optional. Show times updated after the given time.
	 * @param   string   $before     Optional. Show times updated before the given time.
	 * @param   int      $page       Optional. Page number of results to return (1-based).
	 * @param   int      $limit      Optional. Page size of results.
	 *
	 * @return  array|null
	 * @since   3.2.0
	 **/
	public function list(
		string $owner,
		string $repo,
		int $index,
		string $user = null,
		string $since = null,
		string $before = null,
		int $page = null,
		int $limit = null
	): ?array
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/issues/{$index}/times";

		// Prepare the query parameters.
		$uri = $this->uri->get($path);
		if ($user !== null)
		{
			$uri->setVar('user', $user);
		}
		if ($since !== null)
		{
			$uri->setVar('since', $since);
		}
		if ($before !== null)
		{
			$uri->setVar('before', $before);
		}
		if ($page !== null)
		{
			$uri->setVar('page', $page);
		}
		if ($limit !== null)
		{
			$uri->setVar('limit', $limit);
		}

		// Send the get request with the query parameters.
		return $this->response->get(
			$this->http->get($uri)
		);
	}

	/**
	 * Add tracked time to an issue.
	 *
	 * @param   string   $owner       The owner name.
	 * @param   string   $repo        The repo name.
	 * @param   int      $index       The issue index.
	 * @param   int      $time        The tracked time in seconds.
	 * @param   string   $created     Optional. The date and time of the tracked time in RFC 3339 format.
	 * @param   string   $userName    Optional. User who spent the time.
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function add(
		string $owner,
		string $repo,
		int $index,
		int $time,
		string $created = null,
		string $userName = null
	): ?object
	{
		// Set the lines data
		$data = new \stdClass();

		// Set all the needed data.
		$data->time = $time;
		if ($created !== null)
		{
			$data->created = $created;
		}
		if ($userName !== null)
		{
			$data->user_name = $userName;
		}

		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/issues/{$index}/times";

		// Send the post request.
		return $this->response->get(
			$this->http->post(
				$this->uri->get($path),
				json_encode($data)
			)
		);
	}

	/**
	 * Reset a tracked time of an issue.
	 *
	 * @param   string   $owner      The owner name.
	 * @param   string   $repo       The repo name.
	 * @param   int      $index      The issue index.
	 *
	 * @return  string
	 * @since   3.2.0
	 **/
	public function reset(string $owner, string $repo, int $index): string
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/issues/{$index}/times";

		// Send the delete request.
		return $this->response->get(
			$this->http->delete(
				$this->uri->get($path)
			), 204, 'success'
		);
	}

	/**
	 * Delete specific tracked time.
	 *
	 * @param   string   $owner      The owner name.
	 * @param   string   $repo       The repo name.
	 * @param   int      $index      The issue index.
	 * @param   int      $id         The ID of the tracked time to delete.
	 *
	 * @return  string
	 * @since   3.2.0
	 **/
	public function delete(string $owner, string $repo, int $index, int $id): string
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/issues/{$index}/times/{$id}";

		// Send the delete request.
		return $this->response->get(
			$this->http->delete(
				$this->uri->get($path)
			), 204, 'success'
		);
	}

}

