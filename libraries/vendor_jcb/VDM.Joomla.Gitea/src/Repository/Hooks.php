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

namespace VDM\Joomla\Gitea\Repository;


use VDM\Joomla\Gitea\Abstraction\Api;


/**
 * The Gitea Repository Hooks
 * 
 * @since 3.2.0
 */
class Hooks extends Api
{
	/**
	 * List the hooks in a repository.
	 *
	 * @param   string  $owner          The owner name.
	 * @param   string  $repo           The repository name.
	 * @param   int     $page           The page number of results to return (1-based).
	 * @param   int     $limit          The page size of results.
	 *
	 * @return  array|null
	 * @since   3.2.0
	 **/
	public function list(
		string $owner,
		string $repo,
		int $page = 1,
		int $limit = 10
	): ?array
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/hooks";

		// Set up the URI with query parameters.
		$uri = $this->uri->get($path);
		$uri->setVar('page', $page);
		$uri->setVar('limit', $limit);

		// Send the get request.
		return $this->response->get(
			$this->http->get($uri)
		);
	}

	/**
	 * Create a hook in a repository.
	 *
	 * @param   string  $owner           The owner name.
	 * @param   string  $repo            The repository name.
	 * @param   string  $type            The hook type.
	 * @param   array   $config          The hook configuration.
	 * @param   bool    $active          The hook's active status (optional, default: false).
	 * @param   array|null $events       The events for the hook (optional).
	 * @param   string  $branchFilter    The branch filter (optional).
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function create(
		string $owner,
		string $repo,
		string $type,
		array $config,
		string $type,
		array $config,
		bool $active = false,
		?array $events = null,
		string $branchFilter = ''
	): ?object
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/hooks";

		// Set the hook data.
		$data = new \stdClass();
		$data->type = $type;
		$data->config = (object) $config;
		$data->active = $active;

		if ($events !== null)
		{
			$data->events = $events;
		}

		if (!empty($branchFilter))
		{
			$data->branch_filter = $branchFilter;
		}

		// Send the request.
		return $this->response->get(
			$this->http->post(
				$this->uri->get($path), json_encode($data)
			), 201
		);
	}

	/**
	 * Get a hook.
	 *
	 * @param   string  $owner          The owner name.
	 * @param   string  $repo           The repository name.
	 * @param   int     $hookId         The hook ID.
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function get(
		string $owner,
		string $repo,
		int $hookId
	): ?object
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/hooks/{$hookId}";

		// Get the URI for the request path.
		$uri = $this->uri->get($path);

		// Send the get request.
		return $this->response->get(
			$this->http->get($uri)
		);
	}

	/**
	 * Edit a hook in a repository.
	 *
	 * @param   string   $owner       The owner name.
	 * @param   string   $repo        The repository name.
	 * @param   int      $id          The hook ID.
	 * @param   array    $config      The hook configuration.
	 * @param   array    $events      The events to trigger the hook.
	 * @param   bool     $active      Whether the hook is active.
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function edit(
		string $owner,
		string $repo,
		int $id,
		array $config,
		array $events,
		bool $active
	): ?object
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/hooks/{$id}";

		// Set the hook data.
		$data = new \stdClass();
		$data->config = $config;
		$data->events = $events;
		$data->active = $active;

		// Send the PATCH request.
		return $this->response->get(
			$this->http->patch(
				$this->uri->get($path),
				json_encode($data)
			)
		);
	}

	/**
	 * Test a push webhook.
	 *
	 * @param   string   $owner  The owner name.
	 * @param   string   $repo   The repository name.
	 * @param   int      $hookId The hook ID.
	 * @param   string   $ref    The name of the commit/branch/tag (optional).
	 *
	 * @return  string
	 * @since   3.2.0
	 **/
	public function test(
		string $owner,
		string $repo,
		int $hookId,
		string $ref = ''
	): string
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/hooks/{$hookId}/tests";

		// Get the URI for the request path.
		$uri = $this->uri->get($path);

		if (!empty($ref))
		{
			$uri->setVar('ref', $ref);
		}

		// Send the POST request.
		return $this->response->get(
			$this->http->post($uri), 204, 'success'
		);
	}

}

