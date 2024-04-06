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
 * The Gitea Organization Members
 * 
 * @since 3.2.0
 */
class Members extends Api
{
	/**
	 * Get a list of members of an organization.
	 *
	 * @param string $orgName  The organization name.
	 * @param int    $page     The page number.
	 * @param int    $limit    The number of members per page.
	 *
	 * @return array|null The organization members.
	 * @since 3.2.0
	 */
	public function list(
		string $orgName,
		int $page = 1,
		int $limit = 10
	): ?array
	{
		// Build the request path.
		$path = "/orgs/{$orgName}/members";

		// Get the URI and set query parameters.
		$uri = $this->uri->get($path);
		$uri->setVar('page', $page);
		$uri->setVar('limit', $limit);

		// Send the request.
		return $this->response->get(
			$this->http->get($uri)
		);
	}

	/**
	 * Check if a user is a member of an organization.
	 *
	 * @param string $org The organization name.
	 * @param string $username The username.
	 *
	 * @return string   Whether the user is a member of the organization.
	 * @since 3.2.0
	 */
	public function check(string $org, string $username): string
	{
		// Build the request path.
		$path = "/orgs/{$org}/members/{$username}";

		// Send the request.
		return $this->response->get(
		    $this->http->get(
		        $this->uri->get($path)
		    ), 204, 'success'
		);
	}

	/**
	 * Remove a member from an organization.
	 *
	 * @param string $org The organization name.
	 * @param string $username The username of the user to remove.
	 *
	 * @return string  Whether the user was successfully removed from the organization.
	 * @since 3.2.0
	 */
	public function remove(string $org, string $username): string
	{
		// Build the request path.
		$path = "/orgs/{$org}/members/{$username}";

		// Send the request.
		return $this->response->get(
		    $this->http->delete(
		        $this->uri->get($path)
		    ), 204, 'success'
		);
	}

}

