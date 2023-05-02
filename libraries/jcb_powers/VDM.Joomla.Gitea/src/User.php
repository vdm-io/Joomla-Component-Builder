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

namespace VDM\Joomla\Gitea;


use VDM\Joomla\Gitea\Abstraction\Api;


/**
 * The Gitea User
 * 
 * @since 3.2.0
 */
class User extends Api
{
	/**
	 * Get the authenticated user.
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function authenticate(): ?object
	{
		// Build the request path.
		$path = '/user';

		// Send the get request.
		return $this->response->get(
			$this->http->get(
				$this->uri->get($path)
			)
		);
	}

	/**
	 * Search for users.
	 *
	 * @param   string   $keyword   The search keyword.
	 * @param   int|null $uid       Optional. ID of the user to search for.
	 * @param   int      $page      Page number of results to return (1-based).
	 * @param   int      $limit     Page size of results.
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function search(
		string $keyword,
		?int $uid = null,
		int $page = 1,
		int $limit = 10
	): ?object
	{
		// Build the request path.
		$path = '/users/search';

		// Build the URI with query parameters.
		$uri = $this->uri->get($path);
		$uri->setVar('q', $keyword);

		if ($uid !== null)
		{
			$uri->setVar('uid', $uid);
		}

		$uri->setVar('page', $page);
		$uri->setVar('limit', $limit);

		// Send the get request.
		return $this->response->get(
			$this->http->get($uri)
		);
	}

	/**
	 * Get a user by their username.
	 *
	 * @param   string   $username  The username of the user to retrieve.
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function get(string $username): o?bject
	{
		// Build the request path.
		$path = "/users/{$username}";

		// Send the get request.
		return $this->response->get(
			$this->http->get(
				$this->uri->get($path)
			)
		);
	}

	/**
	 * List the given user's followers.
	 *
	 * @param   string   $userName  The username of the user to retrieve followers for.
	 * @param   int      $page      Page number of results to return (1-based).
	 * @param   int      $limit     Page size of results.
	 *
	 * @return  array|null
	 * @since   3.2.0
	 **/
	public function followers(
		string $userName,
		int $page = 1,
		int $limit = 10
	): ?array
	{
		// Build the request path.
		$path = "/users/{$userName}/followers";

		// Build the URI with query parameters.
		$uri = $this->uri->get($path);
		$uri->setVar('page', $page);
		$uri->setVar('limit', $limit);

		// Send the get request.
		return $this->response->get(
			$this->http->get($uri)
		);
	}

	/**
	 * List the users that the given user is following.
	 *
	 * @param   string   $userName  The username of the user to retrieve the following users for.
	 * @param   int      $page      Page number of results to return (1-based).
	 * @param   int      $limit     Page size of results.
	 *
	 * @return  array|null
	 * @since   3.2.0
	 **/
	public function following(
		string $userName,
		int $page = 1,
		int $limit = 10
	): ?array
	{
		// Build the request path.
		$path = "/users/{$userName}/following";

		// Build the URI with query parameters.
		$uri = $this->uri->get($path);
		$uri->setVar('page', $page);
		$uri->setVar('limit', $limit);

		// Send the get request.
		return $this->response->get(
			$this->http->get($uri)
		);
	}

	/**
	 * Check if one user is following another user.
	 *
	 * @param   string   $username  The username of the user to check.
	 * @param   string   $target    The username of the target user.
	 *
	 * @return  string
	 * @since   3.2.0
	 **/
	public function check(string $username, string $target): string
	{
		// Build the request path.
		$path = "/users/{$username}/following/{$target}";

		// Send the get request.
		return $this->response->get(
			$this->http->get(
				$this->uri->get($path)
			), 204, 'success'
		);
	}

	/**
	 * List the given user's GPG keys.
	 *
	 * @param   string   $userName  The username of the user to retrieve GPG keys for.
	 * @param   int      $page      The page number of results to return (1-based).
	 * @param   int      $limit     The page size of results.
	 *
	 * @return  array|null
	 * @since   3.2.0
	 **/
	public function gpg(
		string $userName,
		int $page = 1,
		int $limit = 10
	): ?array
	{
		// Build the request path.
		$path = "/users/{$userName}/gpg_keys";

		// Build the URI with query parameters.
		$uri = $this->uri->get($path);
		$uri->setVar('page', $page);
		$uri->setVar('limit', $limit);

		// Send the get request.
		return $this->response->get(
			$this->http->get($uri)
		);
	}

	/**
	 * Get a user's heatmap.
	 *
	 * @param   string   $username  The username of the user to retrieve heatmap for.
	 *
	 * @return  array|null
	 * @since   3.2.0
	 **/
	public function heatmap(string $username): ?array
	{
		// Build the request path.
		$path = "/users/{$username}/heatmap";

		// Send the get request.
		return $this->response->get(
			$this->http->get(
				$this->uri->get($path)
			)
		);
	}

	/**
	 * List the given user's public keys.
	 *
	 * @param   string      $userName      The username of the user to retrieve public keys for.
	 * @param   string|null $fingerprint   Optional. The fingerprint of the key.
	 * @param   int         $page          The page number of results to return (1-based).
	 * @param   int         $limit         The page size of results.
	 *
	 * @return  array|null
	 * @since   3.2.0
	 **/
	public function keys(
		string $userName,
		?string $fingerprint = null,
		int $page = 1,
		int $limit = 10
	): ?array
	{
		// Build the request path.
		$path = "/users/{$userName}/keys";

		// Build the URI with query parameters.
		$uri = $this->uri->get($path);
		$uri->setVar('page', $page);
		$uri->setVar('limit', $limit);

		if ($fingerprint !== null)
		{
			$uri->setVar('fingerprint', $fingerprint);
		}

		// Send the get request.
		return $this->response->get(
			$this->http->get($uri)
		);
	}

	/**
	 * List the repos that the given user has starred.
	 *
	 * @param   string   $userName  The username of the user to retrieve starred repos for.
	 * @param   int      $page      The page number of results to return (1-based).
	 * @param   int      $limit     The page size of results.
	 *
	 * @return  array|null
	 * @since   3.2.0
	 **/
	public function repos(
		string $userName,
		int $page = 1,
		int $limit = 10
	): ?array
	{
		// Build the request path.
		$path = "/users/{$userName}/starred";

		// Build the URI with query parameters.
		$uri = $this->uri->get($path);
		$uri->setVar('page', $page);
		$uri->setVar('limit', $limit);

		// Send the get request.
		return $this->response->get(
			$this->http->get($uri)
		);
	}

	/**
	 * List the repositories watched by a user.
	 *
	 * @param   string   $userName  The username of the user to retrieve watched repositories for.
	 * @param   int      $page      The page number of results to return (1-based).
	 * @param   int      $limit     The page size of results.
	 *
	 * @return  array|null
	 * @since   3.2.0
	 **/
	public function watched(
		string $userName,
		int $page = 1,
		int $limit = 10
	): ?array
	{
		// Build the request path.
		$path = "/users/{$userName}/subscriptions";

		// Build the URI with query parameters.
		$uri = $this->uri->get($path);
		$uri->setVar('page', $page);
		$uri->setVar('limit', $limit);

		// Send the get request.
		return $this->response->get(
			$this->http->get($uri)
		);
	}

}

