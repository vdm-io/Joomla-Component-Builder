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

namespace VDM\Joomla\Gitea\Issue\Reactions;


use VDM\Joomla\Gitea\Abstraction\Api;


/**
 * The Gitea Issue Reactions Comment
 * 
 * @since 3.2.0
 */
class Comment extends Api
{
	/**
	 * Get a list of reactions from a comment of an issue.
	 *
	 * @param   string   $owner      The owner name.
	 * @param   string   $repo       The repo name.
	 * @param   int      $commentId  The comment ID.
	 *
	 * @return  array|null
	 * @since   3.2.0
	 **/
	public function list(string $owner, string $repo, int $commentId): ?array
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/issues/comments/{$commentId}/reactions";

		// Send the get request.
		return $this->response->get(
			$this->http->get(
				$this->uri->get($path)
			)
		);
	}

	/**
	 * Add a reaction to a comment of an issue.
	 *
	 * @param   string   $owner      The owner name.
	 * @param   string   $repo       The repo name.
	 * @param   int      $commentId  The comment ID.
	 * @param   string   $content    The reaction to add, e.g. "+1".
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function add(string $owner, string $repo, int $commentId, string $content): ?object
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/issues/comments/{$commentId}/reactions";

		// Build the request data.
		$data = new \stdClass();
		$data->content = $content;

		// Send the post request.
		return $this->response->get(
			$this->http->post(
				$this->uri->get($path), json_encode($data)
			)
		);
	}

	/**
	 * Remove a reaction from a comment of an issue.
	 *
	 * @param   string   $owner      The owner name.
	 * @param   string   $repo       The repo name.
	 * @param   int      $commentId  The comment ID.
	 * @param   string   $content    The reaction to remove, e.g. "+1".
	 *
	 * @return  string
	 * @since   3.2.0
	 **/
	public function remove(string $owner, string $repo, int $commentId, string $content): string
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/issues/comments/{$commentId}/reactions";

		// Build the URI.
		$uri = $this->uri->get($path);
		$uri->setVar('content', $content);

		// Send the delete request.
		return $this->response->get(
			$this->http->delete($uri), 200, 'success'
		);
	}

}

