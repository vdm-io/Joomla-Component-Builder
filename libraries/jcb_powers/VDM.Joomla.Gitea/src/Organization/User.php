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

namespace VDM\Joomla\Gitea\Organization;


use VDM\Joomla\Gitea\Abstraction\Api;


/**
 * The Gitea Organization User
 * 
 * @since 3.2.0
 */
class User extends Api
{
	/**
	 * List the current user's organizations.
	 *
	 * @param   int   $pageNumber  The page number of results to return (1-based).
	 * @param   int   $pageSize  The page size of results.
	 *
	 * @return  array|null
	 * @since   3.2.0
	 **/
	public function list(
		int $pageNumber = 1,
		int $pageSize = 10
	): ?array
	{
		// Build the request path.
		$path = "/user/orgs";

		// Get the URI object.
		$uri = $this->uri->get($path);

		// Add the query parameters for page number and page size.
		$uri->setVar('page', $pageNumber);
		$uri->setVar('limit', $pageSize);

		// Send the get request.
		return $this->response->get(
			$this->http->get($uri)
		);
	}

	/**
	 * List a user's organizations.
	 *
	 * @param   string   $username    The user's username.
	 * @param   int      $pageNumber  The page number of results to return (1-based).
	 * @param   int      $pageSize    The page size of results.
	 *
	 * @return  array|null
	 * @since   3.2.0
	 **/
	public function get(
		string $username,
		int $pageNumber = 1,
		int $pageSize = 10
	): ?array
	{
		// Build the request path.
		$path = "/users/{$username}/orgs";

		// Get the URI object.
		$uri = $this->uri->get($path);

		// Add the query parameters for page number and page size.
		$uri->setVar('page', $pageNumber);
		$uri->setVar('limit', $pageSize);

		// Send the get request.
		return $this->response->get(
			$this->http->get($uri)
		);
	}

	/**
	 * Get user permissions in an organization.
	 *
	 * @param   string   $username  The user's username.
	 * @param   string   $org       The organization name.
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function permissions(string $username, string $org): ?object
	{
		// Build the request path.
		$path = "/users/{$username}/orgs/{$org}/permissions";

		// Send the get request.
		return $this->response->get(
			$this->http->get(
				$this->uri->get($path)
			)
		);
	}


}

