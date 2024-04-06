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
 * The Gitea Organization Public Members
 * 
 * @since 3.2.0
 */
class PublicMembers extends Api
{
	/**
	 * List an organization's public members.
	 *
	 * @param   string   $orgName         The organization name.
	 * @param   int      $page            Page number of results to return (1-based).
	 * @param   int      $limit           Page size of results.
	 *
	 * @return  array|null
	 * @since   3.2.0
	 **/
	public function list(string $orgName, int $page = 1, int $limit = 10): ?array
	{
		// Build the request path.
		$path = "/orgs/{$orgName}/public_members";

		// Configure the request URI.
		$uri = $this->uri->get($path);
		$uri->setVar('page', $page);
		$uri->setVar('limit', $limit);

		// Send the get request.
		return $this->response->get(
			$this->http->get($uri)
		);
	}


	/**
	 * Check if a user is a public member of an organization.
	 *
	 * @param   string   $org      The organization name.
	 * @param   string   $username The user's username.
	 *
	 * @return  string|null
	 * @since   3.2.0
	 **/
	public function check(string $org, string $username): ?string
	{
		// Build the request path.
		$path = "/orgs/{$org}/public_members/{$username}";

		// Send the get request.
		return $this->response->get(
			$this->http->get(
				$this->uri->get($path)
			), 204
		);
	}

	/**
	 * Publicize a user's membership.
	 *
	 * @param   string   $org      The organization name.
	 * @param   string   $username The user's username.
	 *
	 * @return  string|null
	 * @since   3.2.0
	 **/
	public function publicize(string $org, string $username): ?string
	{
		// Build the request path.
		$path = "/orgs/{$org}/public_members/{$username}";

		// Send the put request.
		return $this->response->get(
			$this->http->put(
				$this->uri->get($path), ''
			), 204
		);
	}

	/**
	 * Conceal a user's membership.
	 *
	 * @param   string   $org      The organization name.
	 * @param   string   $username The user's username.
	 *
	 * @return  string
	 * @since   3.2.0
	 **/
	public function conceal(string $org, string $username): string
	{
		// Build the request path.
		$path = "/orgs/{$org}/public_members/{$username}";

		// Send the delete request.
		return $this->response->get(
			$this->http->delete(
				$this->uri->get($path)
			), 204, 'success'
		);
	}

}

