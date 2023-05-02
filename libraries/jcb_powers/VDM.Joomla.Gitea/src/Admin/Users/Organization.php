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

namespace VDM\Joomla\Gitea\Admin\Users;


use VDM\Joomla\Gitea\Abstraction\Api;


/**
 * The Gitea Admin Users Organization
 * 
 * @since 3.2.0
 */
class Organization extends Api
{
	/**
	 * Create an organization on behalf of a user.
	 *
	 * @param   string       $username                  The user's display name.
	 * @param   string       $fullName                  The organization full name.
	 * @param   string|null  $description               The organization description (optional).
	 * @param   string|null  $location                  The organization location (optional).
	 * @param   bool         $repoAdminChangeTeamAccess Whether repo admin can change team access (optional).
	 * @param   string       $visibility                The organization visibility (optional).
	 * @param   string|null  $website                   The organization website (optional).
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function create(
		string $username,
		string $fullName,
		?string $description = null,
		?string $location = null,
		bool $repoAdminChangeTeamAccess = false,
		string $visibility = 'public',
		?string $website = null
	): ?object
	{
		// Build the request path.
		$path = "/admin/users/{$username}/orgs";

		// Set the organization data.
		$data = new \stdClass();
		$data->full_name = $fullName;
		$data->description = $description;
		$data->location = $location;
		$data->repo_admin_change_team_access = $repoAdminChangeTeamAccess;
		$data->visibility = $visibility;
		$data->website = $website;

		// Send the post request.
		return $this->response->get(
			$this->http->post(
				$this->uri->get($path), json_encode($data)
			), 201
		);
	}

}

