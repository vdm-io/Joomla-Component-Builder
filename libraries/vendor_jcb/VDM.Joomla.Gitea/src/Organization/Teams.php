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
 * The Gitea Organization Teams
 * 
 * @since 3.2.0
 */
class Teams extends Api
{
	/**
	 * List an organization's teams.
	 *
	 * @param   string   $organization  The organization name.
	 * @param   int      $pageNumber    The page number of results to return (1-based).
	 * @param   int      $pageSize      The page size of results.
	 *
	 * @return  array|null
	 * @since   3.2.0
	 **/
	public function list(
		string $organization,
		int $pageNumber = 1,
		int $pageSize = 10
	): ?array
	{
		// Build the request path.
		$path = "/orgs/{$organization}/teams";

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
	 * Get a team.
	 *
	 * @param   int   $id  The team ID.
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function get(int $id): ?object
	{
		// Build the request path.
		$path = "/teams/{$id}";

		// Send the get request.
		return $this->response->get(
			$this->http->get(
				$this->uri->get($path)
			)
		);
	}

	/**
	 * Create a team.
	 *
	 * @param   string   $organization          The organization name.
	 * @param   string   $name                  The name of the team.
	 * @param   string   $description           The description of the team.
	 * @param   array    $repoNames             An array of repository names for the team (optional).
	 * @param   string   $permission            The team's permission level (optional).
	 * @param   array    $units                 Units for the team (optional).
	 * @param   array    $unitsMap              Units map for the team (optional).
	 * @param   bool     $canCreateOrgRepo      Can create organization repository flag (optional).
	 * @param   bool     $includesAllRepositories Includes all repositories flag (optional).
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function create(
		string $organization,
		string $name,
		string $description,
		array $repoNames = [],
		string $permission = 'read',
		array $units = [],
		array $unitsMap = [],
		bool $canCreateOrgRepo = null,
		bool $includesAllRepositories = null
	): ?object
	{
		// Build the request path.
		$path = "/orgs/{$organization}/teams";

		// Set the team data.
		$data = new \stdClass();
		$data->name = $name;
		$data->description = $description;
		$data->permission = $permission;

		if (!empty($repoNames))
		{
			$data->repo_names = $repoNames;
		}

		if (!empty($units))
		{
			$data->units = $units;
		}

		if (!empty($unitsMap))
		{
			$data->units_map = (object)$unitsMap;
		}

		if ($canCreateOrgRepo !== null)
		{
			$data->can_create_org_repo = $canCreateOrgRepo;
		}

		if ($includesAllRepositories !== null)
		{
			$data->includes_all_repositories = $includesAllRepositories;
		}

		// Send the post request.
		return $this->response->get(
			$this->http->post(
				$this->uri->get($path), json_encode($data)
			), 201
		);
	}

	/**
	 * Search for teams within an organization.
	 *
	 * @param   string   $organization     The organization name.
	 * @param   string   $keywords         The search keywords.
	 * @param   bool     $includeDesc      Include search within team description (defaults to true).
	 * @param   int      $page             The page number.
	 * @param   int      $limit            The number of results per page.
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function search(
		string $organization,
		string $keywords,
		bool $includeDesc = true,
		int $page = 1,
		int $limit = 10
	): ?object
	{
		// Build the request path.
		$path = "/orgs/{$organization}/teams/search";

		// Configure the request URI.
		$uri = $this->uri->get($path);
		$uri->setVar('q', $keywords);
		$uri->setVar('include_desc', $includeDesc);
		$uri->setVar('page', $page);
		$uri->setVar('limit', $limit);

		// Send the get request.
		return $this->response->get(
			$this->http->get($uri)
		);
	}

	/**
	 * Delete a team.
	 *
	 * @param   int   $id  The team ID.
	 *
	 * @return  string
	 * @since   3.2.0
	 **/
	public function delete(int $id): string
	{
		// Build the request path.
		$path = "/teams/{$id}";

		// Send the delete request.
		return $this->response->get(
			$this->http->delete(
				$this->uri->get($path)
			), 204, 'success'
		);
	}

	/**
	 * Edit a team.
	 *
	 * @param   int          $teamId                    The team ID.
	 * @param   string|null  $teamName                  The team name (optional).
	 * @param   string|null  $teamDescription           The team description (optional).
	 * @param   string|null  $teamPermission            The team's permission level (optional).
	 * @param   bool|null    $canCreateOrgRepo          Can team create organization repositories (optional).
	 * @param   bool|null    $includesAllRepositories   Include all repositories (optional).
	 * @param   array|null   $units                     List of units (optional).
	 * @param   array|null   $unitsMap                  Units map (optional).
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function edit(
		int $teamId,
		?string $teamName = null,
		?string $teamDescription = null,
		?string $teamPermission = null,
		?bool $canCreateOrgRepo = null,
		?bool $includesAllRepositories = null,
		?array $units = null,
		?array $unitsMap = null
	): ?object
	{
		// Build the request path.
		$path = "/teams/{$teamId}";

		// Set the team data.
		$data = new \stdClass();
		if ($teamName !== null) 
		{
			$data->name = $teamName;
		}
		if ($teamDescription !== null) 
		{
			$data->description = $teamDescription;
		}
		if ($teamPermission !== null) 
		{
			$data->permission = $teamPermission;
		}
		if ($canCreateOrgRepo !== null) 
		{
			$data->can_create_org_repo = $canCreateOrgRepo;
		}
		if ($includesAllRepositories !== null) 
		{
			$data->includes_all_repositories = $includesAllRepositories;
		}
		if ($units !== null) 
		{
			$data->units = $units;
		}
		if ($unitsMap !== null) 
		{
			$data->units_map = $unitsMap;
		}

		// Send the patch request.
		return $this->response->get(
			$this->http->patch(
				$this->uri->get($path), json_encode($data)
			)
		);
	}

}

