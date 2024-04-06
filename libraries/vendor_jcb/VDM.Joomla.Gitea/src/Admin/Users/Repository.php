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
 * The Gitea Admin Users Repository
 * 
 * @since 3.2.0
 */
class Repository extends Api
{
	/**
	 * Create a repository on behalf of a user.
	 *
	 * @param   string  $username         The user's display name.
	 * @param   string  $repoName         The repository name.
	 * @param   string|null  $description     The repository description (optional).
	 * @param   bool   $auto_init        Whether the repository should be auto-initialized? (optional).
	 * @param   string|null  $default_branch  Default branch of the repository (optional).
	 * @param   string|null  $gitignores      Gitignores to use (optional).
	 * @param   string|null  $issue_labels    Label-Set to use (optional).
	 * @param   string|null  $license         License to use (optional).
	 * @param   bool   $private          Whether the repository is private (optional).
	 * @param   string|null  $readme          Readme of the repository to create (optional).
	 * @param   bool   $template         Whether the repository is template (optional).
	 * @param   string|null  $trust_model    TrustModel of the repository (optional).
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function create(
		string $username,
		string $repoName,
		?string $description = null,
		bool $auto_init = false,
		?string $default_branch = null,
		?string $gitignores = null,
		?string $issue_labels = null,
		?string $license = null,
		bool $private = false,
		?string $readme = null,
		bool $template = false,
		?string $trust_model = null
	): ?object
	{
		// Build the request path.
		$path = "/admin/users/{$username}/repos";

		// Set the repository data.
		$data = new \stdClass();
		$data->name = $repoName;
		$data->description = $description;
		$data->auto_init = $auto_init;
		$data->default_branch = $default_branch;
		$data->gitignores = $gitignores;
		$data->issue_labels = $issue_labels;
		$data->license = $license;
		$data->private = $private;
		$data->readme = $readme;
		$data->template = $template;
		$data->trust_model = $trust_model;

		// Send the post request.
		return $this->response->get(
			$this->http->post(
				$this->uri->get($path), json_encode($data)
			), 201
		);
	}

}

