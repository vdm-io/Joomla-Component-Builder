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
 * The Gitea Issue Comments
 * 
 * @since 3.2.0
 */
class Comments extends Api
{
	/**
	 * List all comments on an issue.
	 *
	 * @param   string         $owner      The owner name.
	 * @param   string         $repo       The repo name.
	 * @param   int            $index      The issue index.
	 * @param   int            $page       The page number to get, defaults to 1.
	 * @param   int            $limit      The number of comments per page, defaults to 10.
	 * @param   string|null    $since      The date-time since when to get comments, defaults to null.
	 * @param   string|null    $before     The date-time before when to get comments, defaults to null.
	 *
	 * @return  array|null
	 * @since   3.2.0
	 **/
	public function list(
		string $owner,
		string $repo,
		int $index,
		int $page = 1,
		int $limit = 10,
		?string $since = null,
		?string $before = null
	): ?array
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/issues/{$index}/comments";

		// Build the URI.
		$uri = $this->uri->get($path);
		$uri->setVar('page', $page);
		$uri->setVar('limit', $limit);

		// Set the 'since' and 'before' parameters if not null.
		if ($since !== null)
		{
			$uri->setVar('since', $since);
		}
		if ($before !== null)
		{
			$uri->setVar('before', $before);
		}

		// Send the get request.
		return $this->response->get(
			$this->http->get($uri)
		);
	}

	/**
	 * Get a comment.
	 *
	 * @param   string   $owner      The owner name.
	 * @param   string   $repo       The repo name.
	 * @param   int      $commentId  The comment ID.
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function get(string $owner, string $repo, int $commentId): ?object
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/issues/comments/{$commentId}";

		// Send the get request.
		return $this->response->get(
			$this->http->get(
				$this->uri->get($path)
			)
		);
	}

	/**
	 * Delete a comment.
	 *
	 * @param   string   $owner      The owner name.
	 * @param   string   $repo       The repo name.
	 * @param   int      $commentId  The comment ID.
	 *
	 * @return  string
	 * @since   3.2.0
	 **/
	public function delete(string $owner, string $repo, int $commentId): string
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/issues/comments/{$commentId}";

		// Send the delete request.
		return $this->response->get(
			$this->http->delete(
				$this->uri->get($path)
			), 204, 'success'
		);
	}

	/**
	 * Edit a comment.
	 *
	 * @param   string   $owner      The owner name.
	 * @param   string   $repo       The repo name.
	 * @param   int      $commentId  The comment ID.
	 * @param   string   $commentBody The new comment body.
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function edit(string $owner, string $repo, int $commentId, string $commentBody): ?object
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/issues/comments/{$commentId}";

		// Build the request data.
		$data = new \stdClass();
		$data->body = $commentBody;

		// Send the patch request.
		return $this->response->get(
			$this->http->patch(
				$this->uri->get($path), json_encode($data)
			)
		);
	}

	/**
	 * Add a comment to an issue.
	 *
	 * @param   string   $owner      The owner name.
	 * @param   string   $repo       The repo name.
	 * @param   int      $issueIndex The issue index.
	 * @param   string   $commentBody The comment body.
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function add(string $owner, string $repo, int $issueIndex, string $commentBody): ?object
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/issues/{$issueIndex}/comments";

		// Build the request data.
		$data = new \stdClass();
		$data->body = $commentBody;

		// Send the post request.
		return $this->response->get(
			$this->http->post(
				$this->uri->get($path), json_encode($data)
			), 201
		);
	}

}

