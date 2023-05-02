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
 * The Gitea Repository Organization Hooks
 * 
 * @since 3.2.0
 */
class Hooks extends Api
{
	/**
	 * List an organization's webhooks.
	 *
	 * @param   string   $orgName  The organization name.
	 * @param   int      $page     Page number of results to return (1-based).
	 * @param   int      $limit    Page size of results.
	 *
	 * @return  array|null
	 * @since   3.2.0
	 **/
	public function list(
		string $orgName,
		int $page = 1,
		int $limit = 10
	): ?array
	{
		// Build the request path.
		$path = "/orgs/{$orgName}/hooks";

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
	 * Create a hook for an organization.
	 *
	 * @param   string   $org       The organization name.
	 * @param   string   $type      The type of hook (e.g. "gitea", "slack", "discord", etc.).
	 * @param   string   $url       The URL of the hook.
	 * @param   string   $secret    Optional. The secret for the hook.
	 * @param   bool     $events    Optional. The events that trigger the hook.
	 * @param   bool     $active    Optional. Whether the hook is active.
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function create(
		string $org,
		string $type,
		string $url,
		string $secret = '',
		bool $events = true,
		bool $active = true
	): ?object
	{
		// Set the lines data
		$data = new \stdClass();
		$data->type = $type;
		$data->config = new \stdClass();
		$data->config->url = $url;
		$data->config->secret = $secret;
		$data->events = [];
		$data->active = $active;

		// Build the request path.
		$path = "/orgs/{$org}/hooks";

		// Send the post request.
		return $this->response->get(
			$this->http->post(
				$this->uri->get($path),
				json_encode($data)
			), 201
		);
	}

	/**
	 * Get a hook for an organization.
	 *
	 * @param   string   $org   The organization name.
	 * @param   int      $id    The ID of the hook.
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function get(string $org, int $id): ?object
	{
		// Build the request path.
		$path = "/orgs/{$org}/hooks/{$id}";

		// Send the get request.
		return $this->response->get(
			$this->http->get(
				$this->uri->get($path)
			)
		);
	}

	/**
	 * Delete a hook for an organization.
	 *
	 * @param   string   $org  The organization name.
	 * @param   int      $id   The hook ID.
	 *
	 * @return  string
	 * @since   3.2.0
	 **/
	public function delete(string $org, int $id): string
	{
		// Build the request path.
		$path = "/orgs/{$org}/hooks/{$id}";

		// Send the DELETE request.
		return $this->response->get(
			$this->http->delete(
				$this->uri->get($path)
			), 204, 'success'
		);
	}

	/**
	 * Update a hook for an organization.
	 *
	 * @param   string   $orgName       The organization name.
	 * @param   int      $hookId        The ID of the hook.
	 * @param   bool|null     $active    Optional. Whether the hook is active.
	 * @param   string|null   $branchFilter   Optional. Branch filter for the hook.
	 * @param   array|null    $config    Optional. Configuration for the hook.
	 * @param   array|null    $events    Optional. Events for the hook.
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function update(
		string $orgName,
		int $hookId,
		?bool $active = null,
		?string $branchFilter = null,
		?array $config = null,
		?array $events = null
	): ?object
	{
		// Set the lines data
		$data = new \stdClass();

		if ($active !== null) 
		{
			$data->active = $active;
		}

		if ($branchFilter !== null) 
		{
			$data->branch_filter = $branchFilter;
		}

		if ($config !== null) 
		{
			$data->config = (object) $config;
		}

		if ($events !== null) 
		{
			$data->events = $events;
		}

		// Build the request path.
		$path = "/orgs/{$orgName}/hooks/{$hookId}";

		// Send the patch request.
		return $this->response->get(
			$this->http->patch(
				$this->uri->get($path),
				json_encode($data)
			)
		);
	}

}

