<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Gitea\Package;


use Joomla\CMS\Http\Http;
use Joomla\Registry\Registry;
use VDM\Gitea\AbstractPackage;

class Repo extends AbstractPackage
{
	/**
	 * List your repositories.
	 *
	 * List repositories for the authenticated user.
	 *
	 * @return  object
	 *
	 * @since   1.0
	 */
	public function getListOwn()
	{
		// Build the request path.
		$uri = $this->fetchUrl('/user/repos');

		// Send the request.
		return $this->processResponse($this->client->get($uri));
	}

	/**
	 * List user repositories.
	 *
	 * List public repositories for the specified user.
	 *
	 * @param   string  $user       The user name.
	 *
	 * @return  object
	 *
	 * @since   1.0
	 */
	public function getListUser($user)
	{
		// Build the request path.
		$uri = $this->fetchUrl('/users/' . $user . '/repos');

		// Send the request.
		return $this->processResponse($this->client->get($uri));
	}

	/**
	 * List organization repositories.
	 *
	 * List repositories for the specified org.
	 *
	 * @param   string  $org   The name of the organization.
	 *
	 * @return  object
	 *
	 * @since   1.0
	 */
	public function getListOrg($org)
	{
		// Build the request path.
		$uri = $this->fetchUrl('/orgs/' . $org . '/repos');

		// Send the request.
		return $this->processResponse($this->client->get($uri));
	}

	/**
	 * Create.
	 *
	 * Create a new repository for the authenticated user or an organization. OAuth users must supply repo scope.
	 *
	 * @param   string   $name               The repository name.
	 * @param   string   $org                The organization name (if needed).
	 * @param   string   $description        The repository description.
	 * @param   string   $readme             Readme of the repository to create.
	 * @param   boolean  $private            Set true to create a private repository, false to create a public one.
	 * @param   string   $defaultBranch      DefaultBranch of the repository (used when initializes and in template).
	 * @param   string   $license            License to use.
	 * @param   boolean  $autoInit           Whether the repository should auto init.
	 * @param   boolean  $template           Whether the repository is template.
	 * @param   string   $gitignores         Gitignores to use.
	 *                                         options: [ Joomla, JetBrains ] and much more...
	 * @param   string   $issueLabels        Label-Set to use.
	 * @param   string   $trustModel         TrustModel of the repository.
	 *                                         options: [ default, collaborator, committer, collaboratorcommitter ]
	 *
	 * @return  object
	 *
	 * @since   1.0
	 */
	public function create($name, $org = '', $description = '', $readme = 'Default', $private = false, $defaultBranch = 'master',
		$license = 'GPL-2.0-or-later', $autoInit = true, $template = false, $trustModel = 'default', $gitignores = '', $issueLabels = ''
	)
	{
		$path = ($org)
			// Create a repository for an organization
			? '/orgs/' . $org . '/repos'
			// Create a repository for a user
			: '/user/repos';

		$data = [
			'name'               => $name,
			'description'        => $description,
			'readme'             => $readme,
			'private'            => $private,
			'auto_init'          => $autoInit,
			'default_branch'     => $defaultBranch,
			'issue_labels'       => $issueLabels,
			'license'            => $license,
			'template'           => $template,
			'gitignores'         => $gitignores,
			'trust_model'        => $trustModel
		];

		// Send the request.
		return $this->processResponse(
			$this->client->post($this->fetchUrl($path), json_encode($data)),
			201
		);
	}

	/**
	 * Get.
	 *
	 * @param   string  $owner  Repository owner.
	 * @param   string  $repo   Repository name.
	 *
	 * @return  object
	 *
	 * @since   1.0
	 */
	public function get($owner, $repo)
	{
		// Build the request path.
		$path = '/repos/' . $owner . '/' . $repo;

		// Send the request.
		return $this->processResponse(
			$this->client->get($this->fetchUrl($path))
		);
	}

	/**
	 * List contributors.
	 *
	 * @param   string   $owner  Repository owner.
	 * @param   string   $repo   Repository name.
	 *
	 * @return  object
	 *
	 * @since   1.0
	 */
	public function getListContributors($owner, $repo)
	{
		// Build the request path.
		$uri = $this->fetchUrl('/repos/' . $owner . '/' . $repo . '/contributors');

		// Send the request.
		return $this->processResponse($this->client->get($uri));
	}

	/**
	 * List languages.
	 *
	 * List languages for the specified repository. The value on the right of a language is the number of bytes of code
	 * written in that language.
	 *
	 * @param   string  $owner  Repository owner.
	 * @param   string  $repo   Repository name.
	 *
	 * @return  object
	 *
	 * @since   1.0
	 */
	public function getListLanguages($owner, $repo)
	{
		// Build the request path.
		$path = '/repos/' . $owner . '/' . $repo . '/languages';

		// Send the request.
		return $this->processResponse(
			$this->client->get($this->fetchUrl($path))
		);
	}

	/**
	 * List Teams
	 *
	 * @param   string  $owner  Repository owner.
	 * @param   string  $repo   Repository name.
	 *
	 * @return  object
	 *
	 * @since   1.0
	 */
	public function getListTeams($owner, $repo)
	{
		// Build the request path.
		$path = '/repos/' . $owner . '/' . $repo . '/teams';

		// Send the request.
		return $this->processResponse(
			$this->client->get($this->fetchUrl($path))
		);
	}

	/**
	 * List Tags.
	 *
	 * @param   string   $owner  Repository owner.
	 * @param   string   $repo   Repository name.
	 * @param   integer  $page   Page to request
	 * @param   integer  $limit  Number of results to return per page
	 *
	 * @return  object
	 *
	 * @since   1.0
	 */
	public function getListTags($owner, $repo, $page = 0, $limit = 0)
	{
		// Build the request path.
		$path = '/repos/' . $owner . '/' . $repo . '/tags';

		// Send the request.
		return $this->processResponse(
			$this->client->get($this->fetchUrl($path, $page, $limit))
		);
	}

	/**
	 * Delete a Repository.
	 *
	 * Deleting a repository requires admin access. If OAuth is used, the delete_repo scope is required.
	 *
	 * @param   string  $owner  Repository owner.
	 * @param   string  $repo   Repository name.
	 *
	 * @return  object
	 *
	 * @since   1.0
	 */
	public function delete($owner, $repo)
	{
		// Build the request path.
		$path = '/repos/' . $owner . '/' . $repo;

		// Send the request.
		return $this->processResponse(
			$this->client->delete($this->fetchUrl($path))
		);
	}

}

