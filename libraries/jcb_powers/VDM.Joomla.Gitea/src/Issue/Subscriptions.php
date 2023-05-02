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
 * The Gitea Issue Subscriptions
 * 
 * @since 3.2.0
 */
class Subscriptions extends Api
{
	/**
	 * Get users who subscribed on an issue.
	 *
	 * @param   string      $owner      The owner name.
	 * @param   string      $repo       The repo name.
	 * @param   int         $index      The issue index.
	 * @param   int|null    $page       Optional. Page number of results to return (1-based).
	 * @param   int|null    $limit      Optional. Page size of results.
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function get(
		string $owner,
		string $repo,
		int $index,
		?int $page = null,
		?int $limit = null
	): ?object
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/issues/{$index}/subscriptions";

		// Set the query parameters.
		$uri = $this->uri->get($path);
		if ($page !== null)
		{
			$uri->setVar('page', $page);
		}
		if ($limit !== null)
		{
			$uri->setVar('limit', $limit);
		}

		// Send the get request.
		return $this->response->get(
			$this->http->get($uri)
		);
	}

	/**
	 * Check if user is subscribed to an issue.
	 *
	 * @param   string   $owner      The owner name.
	 * @param   string   $repo       The repo name.
	 * @param   int      $index      The issue index.
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function check(string $owner, string $repo, int $index): ?object
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/issues/{$index}/subscriptions/check";

		// Send the get request.
		return $this->response->get(
			$this->http->get(
				$this->uri->get($path)
			)
		);
	}

	/**
	 * Subscribe user to issue.
	 *
	 * @param   string   $owner      The owner name.
	 * @param   string   $repo       The repo name.
	 * @param   int      $index      The issue index.
	 * @param   string   $user       The username to subscribe.
	 *
	 * @return  string
	 * @since   3.2.0
	 **/
	public function subscribe(string $owner, string $repo, int $index, string $user): string
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/issues/{$index}/subscriptions/{$user}";

		// Send the put request.
		return $this->response->get_(
			$this->http->put(
				$this->uri->get($path), ''
			), [200 => 'already subscribed', 201 => 'success']
		);
	}

	/**
	 * Unsubscribe user from issue.
	 *
	 * @param   string   $owner      The owner name.
	 * @param   string   $repo       The repo name.
	 * @param   int      $index      The issue index.
	 * @param   string   $user       The username to unsubscribe.
	 *
	 * @return  string
	 * @since   3.2.0
	 **/
	public function unsubscribe(string $owner, string $repo, int $index, string $user): string
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/issues/{$index}/subscriptions/{$user}";

		// Send the delete request.
		return $this->response->get_(
			$this->http->delete(
				$this->uri->get($path)
			), [200 => 'already unsubscribed', 201 => 'success']
		);
	}

}

