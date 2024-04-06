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
 * The Gitea User Tokens
 * 
 * @since 3.2.0
 */
class Tokens extends Api
{
	/**
	 * List the authenticated user's access tokens.
	 *
	 * @param   string   $username  The username of the authenticated user to retrieve access tokens for.
	 * @param   int|null $page      Optional. Page number of results to return (1-based).
	 * @param   int|null $limit     Optional. Page size of results.
	 *
	 * @return  array|null
	 * @since   3.2.0
	 **/
	public function list(
		string $username,
		?int $page = null,
		?int $limit = null
	): ?array
	{
		// Build the request path.
		$path = "/users/{$username}/tokens";

		// Build the URL
		$url = $this->uri->get($path);
		if ($page !== null) 
		{
			$url->setVar('page', $page);
		}
		if ($limit !== null) 
		{
			$url->setVar('limit', $limit);
		}

		// Send the get request.
		return $this->response->get(
			$this->http->get($url)
		);
	}

	/**
	 * Create an access token for a user.
	 *
	 * @param   string   $username  The username of the user to create the access token for.
	 * @param   string   $name      The name of the access token.
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function create(string $username, string $name): ?object
	{
		// Build the request path.
		$path = "/users/{$username}/tokens";

		// Set the token data
		$data = new \stdClass();
		$data->name = $name;

		// Send the post request.
		return $this->response->get(
			$this->http->post(
				$this->uri->get($path),
				json_encode($data)
			), 201
		);
	}

	/**
	 * Delete an access token for a user.
	 *
	 * @param   string   $username  The username of the user to delete the access token for.
	 * @param   string   $token     The token to delete.
	 *
	 * @return  string
	 * @since   3.2.0
	 **/
	public function delete(string $username, string $token): string
	{
		// Build the request path.
		$path = "/users/{$username}/tokens/{$token}";

		// Send the delete request.
		return $this->response->get(
			$this->http->delete(
				$this->uri->get($path)
			), 204, 'success'
		);
	}

}

