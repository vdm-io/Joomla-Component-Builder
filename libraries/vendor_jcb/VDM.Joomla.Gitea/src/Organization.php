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
 * The Gitea Organization
 * 
 * @since 3.2.0
 */
class Organization extends Api
{
	/**
	 * Create an organization.
	 *
	 * @param   string   $login      Required. The organization's username.
	 * @param   string   $fullName   Required. The full name of the organization.
	 * @param   string   $email      Required. The email of the organization.
	 * @param   string   $description Optional. The description of the organization.
	 * @param   bool     $repoAdmin  Optional. Whether the user has repository admin access.
	 * @param   bool     $teamAdmin  Optional. Whether the user has team admin access.
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function create(
		string $login,
		string $fullName,
		string $email,
		string $description = '',
		bool $repoAdmin = false,
		bool $teamAdmin = false
	): ?object
	{
		// Set the lines data
		$data = new \stdClass();
		$data->username = $login;
		$data->full_name = $fullName;
		$data->email = $email;
		$data->description = $description;
		$data->repo_admin_change_team_access = $repoAdmin;
		$data->team_admin_change_team_access = $teamAdmin;

		// Build the request path.
		$path = '/orgs';

		// Send the post request.
		return $this->response->get(
			$this->http->post(
				$this->uri->get($path),
				json_encode($data)
			), 201
		);
	}

	/**
	 * Get an organization.
	 *
	 * @param   string   $org        The organization name.
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function get(string $org): ?object
	{
		// Build the request path.
		$path = "/orgs/{$org}";

		// Send the get request.
		return $this->response->get(
			$this->http->get(
				$this->uri->get($path)
			)
		);
	}

	/**
	 * Get a list of organizations.
	 *
	 * @param   int   $page   Page number of results to return (1-based).
	 * @param   int   $limit  Page size of results.
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
		$path = '/orgs';

		// Get the URI and set query parameters.
		$uri = $this->uri->get($path);
		$uri->setVar('page', $page);
		$uri->setVar('limit', $limit);

		// Send the get request.
		return $this->response->get(
			$this->http->get($uri)
		);
	}

	/**
	 * Delete an organization.
	 *
	 * @param   string   $org   The organization name.
	 *
	 * @return  string
	 * @since   3.2.0
	 **/
	public function delete(string $org): string
	{
		// Build the request path.
		$path = "/orgs/{$org}";

		// Send the delete request.
		return $this->response->get(
			$this->http->delete(
				$this->uri->get($path)
			), 204, 'success'
		);
	}

	/**
	 * Edit an organization.
	 *
	 * @param   string   $org          The organization name.
	 * @param   string   $fullName     Optional. The full name of the organization.
	 * @param   string   $location     Optional. The location of the organization.
	 * @param   string   $description  Optional. The description of the organization.
	 * @param   bool     $repoAdmin    Optional. Whether the user has repository admin access.
	 * @param   string   $visibility   Optional. The visibility of the organization (public, limited, or private).
	 * @param   string   $website      Optional. The website of the organization.
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function edit(
		string $org,
		?string $fullName = null,
		?string $email = null,
		?string $location = null,
		?string $description = null,
		?bool $repoAdmin = null,
		?string $visibility = null,
		?string $website = null
	): ?object
	{
		// Set the lines data
		$data = new \stdClass();

		if ($fullName !== null) 
		{
			$data->full_name = $fullName;
		}

		if ($location !== null) 
		{
			$data->location = $location;
		}

		if ($description !== null) 
		{
			$data->description = $description;
		}

		if ($repoAdmin !== null) 
		{
			$data->repo_admin_change_team_access = $repoAdmin;
		}

		if ($visibility !== null) 
		{
			$data->visibility = $visibility;
		}

		if ($website !== null) 
		{
			$data->website = $website;
		}

		// Build the request path.
		$path = "/orgs/{$org}";

		// Send the patch request.
		return $this->response->get(
			$this->http->patch(
				$this->uri->get($path),
				json_encode($data)
			)
		);
	}

}

