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

namespace VDM\Joomla\Gitea\User;


use VDM\Joomla\Gitea\Abstraction\Api;


/**
 * The Gitea User Following
 * 
 * @since 3.2.0
 */
class Following extends Api
{
	/**
	 * List the users that the authenticated user is following.
	 *
	 * @param   int    $page   Page number of results to return (1-based).
	 * @param   int    $limit  Page size of results.
	 *
	 * @return  array|null
	 * @since   3.2.0
	 **/
	public function list(
		int $page = 1,
		int $limit = 10
	): ?array
	{
		// Build the request path.
		$path = '/user/following';

		// Build the URL
		$url = $this->uri->get($path);
		$url->setVar('page', $page);
		$url->setVar('limit', $limit);

		// Send the get request.
		return $this->response->get(
			$this->http->get($url)
		);
	}

	/**
	 * Check whether a user is followed by the authenticated user.
	 *
	 * @param   string   $username   The username to check.
	 *
	 * @return  bool
	 * @since   3.2.0
	 **/
	public function check(string $username): bool
	{
		// Build the request path.
		$path = "/user/following/{$username}";

		// Send the get request.
		$response = $this->http->get(
			$this->uri->get($path)
		);

		// Check if the user is followed by the authenticated user.
		if ($response->code === 204)
        {
			return true;
		}
		return false;
	}

	/**
	 * Follow a user.
	 *
	 * @param   string   $username   The username to follow.
	 *
	 * @return  string
	 * @since   3.2.0
	 **/
	public function follow(string $username): string
	{
		// Build the request path.
		$path = "/user/following/{$username}";

		// Send the put request.
		return $this->response->get(
			$this->http->put(
				$this->uri->get($path), ''
			), 204, 'success'
		);
	}

	/**
	 * Unfollow a user.
	 *
	 * @param   string   $username   The username to unfollow.
	 *
	 * @return  string
	 * @since   3.2.0
	 **/
	public function unfollow(string $username): string
	{
		// Build the request path.
		$path = "/user/following/{$username}";

		// Send the delete request.
		return $this->response->get(
			$this->http->delete(
				$this->uri->get($path)
			), 204, 'success'
		);
	}

}

