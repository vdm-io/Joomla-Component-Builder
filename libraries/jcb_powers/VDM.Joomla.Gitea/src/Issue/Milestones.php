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

namespace VDM\Joomla\Gitea\Issue;


use VDM\Joomla\Gitea\Abstraction\Api;


/**
 * The Gitea Issue Milestones
 * 
 * @since 3.2.0
 */
class Milestones extends Api
{
	/**
	 * Create a milestone.
	 *
	 * @param   string       $owner          The owner name.
	 * @param   string       $repo           The repo name.
	 * @param   string       $title          The title of the milestone.
	 * @param   string|null  $description    Optional. The description of the milestone.
	 * @param   string|null  $dueOn          Optional. The due date of the milestone.
	 * @param   string|null  $state          Optional. The state of the milestone. Default is 'open'.
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function create(
		string $owner,
		string $repo,
		string $title,
		?string $description = null,
		?string $dueOn = null,
		?string $state = 'open'
	): ?object
	{
		// Set the lines data
		$data = new \stdClass();

		// Set all the required data.
		$data->title = $title;

		// Set all the optional data that has been provided.
		if ($description !== null)
		{
			$data->description = $description;
		}
		if ($dueOn  !== null)
		{
			$data->due_on = $dueOn;
		}
		if ($state !== null)
		{
			$data->state = $state;
		}

		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/milestones";

		// Send the post request.
		return $this->response->get(
			$this->http->post(
				$this->uri->get($path),
				json_encode($data)
			), 201
		);
	}

	/**
	 * Get all of a repository's opened milestones.
	 *
	 * @param   string       $owner       The owner name.
	 * @param   string       $repo        The repo name.
	 * @param   string|null  $state       Optional. Milestone state. Recognized values are open, closed, and all. Defaults to "open".
	 * @param   string|null  $name        Optional. Filter by milestone name.
	 * @param   int|null     $page        Optional. Page number of results to return (1-based).
	 * @param   int|null     $limit       Optional. Page size of results.
	 *
	 * @return  array|null
	 * @since   3.2.0
	 **/
	public function list(
		string $owner,
		string $repo,
		?string $state = 'open',
		?string $name = null,
		?int $page = null,
		?int $limit = null
	): ?array
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/milestones";

		// Build the URI.
		$uri = $this->uri->get($path);
		$uri->setVar('state', $state);
		if ($name !== null)
		{
			$uri->setVar('name', $name);
		}
		if ($page !== null)
		{
			$uri->setVar('page', $page);
		}
		if ($limit !== null)
		{
			$uri->setVar('limit', $limit);
		}

		// Send the get request.
		return $this->response->get(
			$this->http->get($uri)
		);
	}

	/**
	 * Get a milestone.
	 *
	 * @param   string   $owner       The owner name.
	 * @param   string   $repo        The repo name.
	 * @param   string   $milestoneId The ID of the milestone.
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function get(string $owner, string $repo, string $milestoneId): ?object
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/milestones/{$milestoneId}";

		// Send the get request.
		return $this->response->get(
			$this->http->get(
				$this->uri->get($path)
			)
		);
	}

	/**
	 * Delete a milestone.
	 *
	 * @param   string   $owner       The owner name.
	 * @param   string   $repo        The repo name.
	 * @param   string   $milestoneId The ID of the milestone to delete.
	 *
	 * @return  string
	 * @since   3.2.0
	 **/
	public function delete(string $owner, string $repo, string $milestoneId): string
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/milestones/{$milestoneId}";

		// Send the delete request.
		return $this->response->get(
			$this->http->delete(
				$this->uri->get($path)
			), 204, 'success'
		);
	}

	/**
	 * Update a milestone.
	 *
	 * @param   string   $owner          The owner name.
	 * @param   string   $repo           The repo name.
	 * @param   string   $milestoneId    The ID of the milestone to update.
	 * @param   string   $title          Optional. The new title of the milestone.
	 * @param   string   $description    Optional. The new description of the milestone.
	 * @param   string   $dueOn          Optional. The new due date of the milestone.
	 * @param   string   $state          Optional. The new state of the milestone.
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function update(
		string $owner,
		string $repo,
		string $milestoneId,
		string $title = null,
		string $description = null,
		string $dueOn = null,
		string $state = null
	): ?object
	{
		// Set the lines data
		$data = new \stdClass();

		// Set all the optional data that has been provided.
		if ($title !== null)
		{
			$data->title = $title;
		}
		if ($description !== null)
		{
			$data->description = $description;
		}
		if ($dueOn !== null)
		{
			$data->due_on = $dueOn;
		}
		if ($state !== null)
		{
			$data->state = $state;
		}

		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/milestones/{$milestoneId}";

		// Send the patch request.
		return $this->response->get(
			$this->http->patch(
				$this->uri->get($path),
				json_encode($data)
			)
		);
	}

}

