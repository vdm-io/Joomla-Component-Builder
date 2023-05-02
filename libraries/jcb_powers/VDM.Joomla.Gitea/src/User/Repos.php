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
 * The Gitea User Repos
 * 
 * @since 3.2.0
 */
class Repos extends Api
{
	/**
	 * Create a repository for the authenticated user.
	 *
	 * @param   string      $name                 The name of the repository.
	 * @param   string|null $description          Optional. The description of the repository.
	 * @param   bool        $private              Optional. Indicates whether the repository should be private or not.
	 * @param   bool        $autoInit             Optional. Indicates whether the repository should be auto-initialized.
	 * @param   string|null $defaultBranch        Optional. The default branch of the repository.
	 * @param   string|null $gitignores           Optional. Gitignores to use.
	 * @param   string|null $issueLabels          Optional. Label-Set to use.
	 * @param   string|null $license              Optional. License to use.
	 * @param   string|null $readme               Optional. Readme of the repository to create.
	 * @param   bool|null   $template             Optional. Whether the repository is a template.
	 * @param   string|null $trustModel           Optional. TrustModel of the repository.
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function create(
		string $name,
		?string $description = null,
		bool $private = false,
		bool $autoInit = false,
		?string $defaultBranch = null,
		?string $gitignores = null,
		?string $issueLabels = null,
		?string $license = null,
		?string $readme = null,
		?bool $template = null,
		?string $trustModel = null
	): ?object {
		// Build the request path.
		$path = '/user/repos';

		// Set the repository data.
		$data = new \stdClass();
		$data->name = $name;

		if ($description !== null)
		{
			$data->description = $description;
		}

		$data->private = $private;
		$data->auto_init = $autoInit;

		if ($defaultBranch !== null)
		{
			$data->default_branch = $defaultBranch;
		}

		if ($gitignores !== null)
		{
			$data->gitignores = $gitignores;
		}

		if ($issueLabels !== null)
		{
			$data->issue_labels = $issueLabels;
		}

		if ($license !== null)
		{
			$data->license = $license;
		}

		if ($readme !== null)
		{
			$data->readme = $readme;
		}

		if ($template !== null)
		{
			$data->template = $template;
		}

		if ($trustModel !== null)
		{
			$data->trust_model = $trustModel;
		}

		// Send the post request.
		return $this->response->get(
			$this->http->post(
				$this->uri->get($path),
				json_encode($data)
			), 201
		);
	}

	/**
	 * List the repos that the authenticated user owns.
	 *
	 * @param   int $page   Page number of results to return (1-based).
	 * @param   int $limit  Page size of results.
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
		$path = '/user/repos';

		// Build the URI with query parameters.
		$uri = $this->uri->get($path);
		$uri->setVar('page', $page);
		$uri->setVar('limit', $limit);

		// Send the get request.
		return $this->response->get(
			$this->http->get($uri)
		);
	}

	/**
	 * Star the given repo for the authenticated user.
	 *
	 * @param   string   $owner  The owner name.
	 * @param   string   $repo   The repository name.
	 *
	 * @return  string
	 * @since   3.2.0
	 **/
	public function star(string $owner, string $repo): string
	{
		// Build the request path.
		$path = "/user/starred/{$owner}/{$repo}";

		// Send the put request.
		return $this->response->get(
			$this->http->put(
				$this->uri->get($path), ''
			), 204, 'success'
		);
	}

	/**
	 * Unstar the given repo for the authenticated user.
	 *
	 * @param   string   $owner  The owner name.
	 * @param   string   $repo   The repository name.
	 *
	 * @return  string
	 * @since   3.2.0
	 **/
	public function unstar(string $owner, string $repo): string
	{
		// Build the request path.
		$path = "/user/starred/{$owner}/{$repo}";

		// Send the delete request.
		return $this->response->get(
			$this->http->delete(
				$this->uri->get($path)
			), 204, 'success'
		);
	}

}

