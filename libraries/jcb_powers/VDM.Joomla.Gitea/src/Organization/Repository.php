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
 * The Gitea Organization Repository
 * 
 * @since 3.2.0
 */
class Repository extends Api
{
	/**
	 * List an organization's repos.
	 *
	 * @param   string   $org          The organization name.
	 * @param   int      $pageNumber   The page number.
	 * @param   int      $pageSize     The page size of results.
	 *
	 * @return  array|null
	 * @since   3.2.0
	 **/
	public function list(
		string $org,
		int $pageNumber = 1,
		int $pageSize = 10
	): ?array
	{
		// Build the request path.
		$path = "/orgs/{$org}/repos";

		// Configure the request URI.
		$uri = $this->uri->get($path);
		$uri->setVar('page', $pageNumber);
		$uri->setVar('limit', $pageSize);

		// Send the get request.
		return $this->response->get(
			$this->http->get($uri)
		);
	}

	/**
	 * Create a repository in an organization.
	 *
	 * @param   string   $org                   The organization name.
	 * @param   string   $repoName              The name of the repository.
	 * @param   string|null   $description      The description of the repository (optional).
	 * @param   bool|null   $autoInit           Whether the repository should be auto-initialized (optional).
	 * @param   string|null   $defaultBranch    Default branch of the repository (optional).
	 * @param   string|null   $gitignores       Gitignores to use (optional).
	 * @param   string|null   $issueLabels      Label-set to use (optional).
	 * @param   string|null   $license          License to use (optional).
	 * @param   bool|null   $private            Whether the repository is private (optional).
	 * @param   string|null   $readme           Readme of the repository to create (optional).
	 * @param   bool|null   $template           Whether the repository is a template (optional).
	 * @param   string|null   $trustModel       Trust model of the repository (optional).
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function create(
		string $org,
		string $repoName,
		?string $description = null,
		?bool $autoInit = null,
		?string $defaultBranch = null,
		?string $gitignores = null,
		?string $issueLabels = null,
		?string $license = null,
		?bool $private = null,
		?string $readme = null,
		?bool $template = null,
		?string $trustModel = null
	): ?object
	{
		// Build the request path.
		$path = "/orgs/{$org}/repos";

		// Set the repository data.
		$data = new \stdClass();
		$data->name = $repoName;
		if ($description !== null)
		{
			$data->description = $description;
		}
		if ($autoInit !== null)
		{
			$data->auto_init = $autoInit;
		}
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
		if ($private !== null)
		{
			$data->private = $private;
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
				$this->uri->get($path), json_encode($data)
			)
		);
	}

}

