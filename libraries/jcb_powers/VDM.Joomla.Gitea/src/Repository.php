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
 * The Gitea Repository
 * 
 * @since 3.2.0
 */
class Repository extends Api
{
	/**
	 * Search for repositories.
	 *
	 * @param   string   $q                    The search query.
	 * @param   array    $options              Additional search options (optional).
	 * @param   int      $page                 The page number (optional).
	 * @param   int      $limit                The number of items per page (optional).
	 * @param   string   $sort                 The sort order (optional).
	 * @param   string   $order                The order direction (optional).
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function search(
		string $q,
		array $options = [],
		int $page = 1,
		int $limit = 10,
		string $sort = 'alpha',
		string $order = 'asc'
	): ?object
	{
		// Build the request path.
		$path = '/repos/search';

		// Create the URI object and set URL values.
		$uri = $this->uri->get($path);
		$uri->setVar('q', $q);
		$uri->setVar('page', $page);
		$uri->setVar('limit', $limit);
		$uri->setVar('sort', $sort);
		$uri->setVar('order', $order);

		foreach ($options as $key => $val)
		{
			$uri->setVar($key, $val);
		}

		// Send the get request.
		return $this->response->get(
			$this->http->get($uri)
		);
	}

	/**
	 * Get a repository.
	 *
	 * @param   string   $owner  The owner name.
	 * @param   string   $repo   The repository name.
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function get(string $owner, string $repo): ?object
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}";

		// Send the get request.
		return $this->response->get(
			$this->http->get(
				$this->uri->get($path)
			)
		);
	}

	/**
	 * Get a repository by owner and repo name.
	 *
	 * @param   string   $owner  The owner name.
	 * @param   string   $repo   The repository name.
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function id(string $owner, string $repo): ?object
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}";

		// Send the get request.
		return $this->response->get(
			$this->http->get(
				$this->uri->get($path)
			)
		);
	}

	/**
	 * Delete a repository.
	 *
	 * @param   string   $owner  The owner name.
	 * @param   string   $repo   The repository name.
	 *
	 * @return  string
	 * @since   3.2.0
	 **/
	public function delete(string $owner, string $repo): string
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}";

		// Send the delete request.
		return $this->response->get(
			$this->http->delete(
				$this->uri->get($path)
			), 204, 'success'
		);
	}

	/**
	 * Edit a repository's properties.
	 *
	 * @param   string      $owner                              The owner name.
	 * @param   string      $repo                               The repository name.
	 * @param   string|null $description                        The repository description (optional).
	 * @param   string|null $website                            The repository website (optional).
	 * @param   bool|null   $private                            Set the repository to private (optional).
	 * @param   bool|null   $hasIssues                          Set the repository to have issues (optional).
	 * @param   bool|null   $hasWiki                            Set the repository to have a wiki (optional).
	 * @param   bool|null   $hasProjects                        Set the repository to have projects (optional).
	 * @param   bool|null   $allowManualMerge                   Allow manual merge of pull requests (optional).
	 * @param   bool|null   $allowMergeCommits                  Allow merge commits for pull requests (optional).
	 * @param   bool|null   $allowRebase                        Allow rebase-merging pull requests (optional).
	 * @param   bool|null   $allowRebaseExplicit                Allow rebase with explicit merge commits (optional).
	 * @param   bool|null   $allowRebaseUpdate                  Allow updating pull request branch by rebase (optional).
	 * @param   bool|null   $allowSquashMerge                   Allow squash-merging pull requests (optional).
	 * @param   bool|null   $archived                          
	 * @param   bool|null   $archived                           Set to true to archive this repository (optional).
	 * @param   bool|null   $autodetectManualMerge              Enable AutodetectManualMerge (optional).
	 * @param   string|null $defaultBranch                      Sets the default branch for this repository (optional).
	 * @param   bool|null   $defaultDeleteBranchAfterMerge      Set to true to delete pr branch after merge by default (optional).
	 * @param   string|null $defaultMergeStyle                  Set to a merge style to be used by this repository (optional).
	 * @param   bool|null   $enablePrune                        Enable prune - remove obsolete remote-tracking references (optional).
	 * @param   object|null $externalTracker                    External tracker settings (optional).
	 * @param   object|null $externalWiki                       External wiki settings (optional).
	 * @param   bool|null   $hasPullRequests                    Set the repository to have pull requests (optional).
	 * @param   bool|null   $ignoreWhitespaceConflicts          Ignore whitespace for conflicts (optional).
	 * @param   object|null $internalTracker                    Internal tracker settings (optional).
	 * @param   string|null $mirrorInterval                     Set the mirror interval time (optional).
	 * @param   bool|null   $template                           Set to true to make this repository a template (optional).
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function edit(
		string $owner, 
		string $repo, 
		?string $description = null, 
		?string $website = null, 
		?bool $private = null, 
		?bool $hasIssues = null, 
		?bool $hasWiki = null,
		?bool $hasProjects = null,
		?bool $allowManualMerge = null,
		?bool $allowMergeCommits = null,
		?bool $allowRebase = null,
		?bool $allowRebaseExplicit = null,
		?bool $allowRebaseUpdate = null,
		?bool $allowSquashMerge = null,
		?bool $archived = null,
		?bool $autodetectManualMerge = null,
		?string $defaultBranch = null,
		?bool $defaultDeleteBranchAfterMerge = null,
		?string $defaultMergeStyle = null,
		?bool $enablePrune = null,
		?object $externalTracker = null,
		?object $externalWiki = null,
		?bool $hasPullRequests = null,
		?bool $ignoreWhitespaceConflicts = null,
		?object $internalTracker = null,
		?string $mirrorInterval = null,
		?bool $template = null
	): ?object
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}";

		// Set the repository properties to update.
		$data = new \stdClass();

		if ($description !== null)
		{
			$data->description = $description;
		}

		if ($website !== null)
		{
			$data->website = $website;
		}

		if ($private !== null)
		{
			$data->private = $private;
		}

		if ($hasIssues !== null)
		{
			$data->has_issues = $hasIssues;
		}

		if ($hasWiki !== null)
		{
			$data->has_wiki = $hasWiki;
		}

		if ($hasProjects !== null)
		{
			$data->has_projects = $hasProjects;
		}

		// Add the additional properties to update.
		if ($allowManualMerge !== null)
		{
			$data->allow_manual_merge = $allowManualMerge;
		}

		if ($allowMergeCommits !== null)
		{
			$data->allow_merge_commits = $allowMergeCommits;
		}

		if ($allowRebase !== null)
		{
			$data->allow_rebase = $allowRebase;
		}

		if ($allowRebaseExplicit !== null)
		{
			$data->allow_rebase_explicit = $allowRebaseExplicit;
		}

		if ($allowRebaseUpdate !== null)
		{
			$data->allow_rebase_update = $allowRebaseUpdate;
		}

		if ($allowSquashMerge !== null)
		{
			$data->allow_squash_merge = $allowSquashMerge;
		}

		if ($archived !== null)
		{
			$data->archived = $archived;
		}

		if ($autodetectManualMerge !== null)
		{
			$data->autodetect_manual_merge = $autodetectManualMerge;
		}

		if ($defaultBranch !== null)
		{
			$data->default_branch = $defaultBranch;
		}

		if ($defaultDeleteBranchAfterMerge !== null)
		{
			$data->default_delete_branch_after_merge = $defaultDeleteBranchAfterMerge;
		}

		if ($defaultMergeStyle !==
		null)
		{
			$data->default_merge_style = $defaultMergeStyle;
		}

		if ($enablePrune !== null)
		{
			$data->enable_prune = $enablePrune;
		}

		if ($externalTracker !== null)
		{
			$data->external_tracker = $externalTracker;
		}

		if ($externalWiki !== null)
		{
			$data->external_wiki = $externalWiki;
		}

		if ($hasPullRequests !== null)
		{
			$data->has_pull_requests = $hasPullRequests;
		}

		if ($ignoreWhitespaceConflicts !== null)
		{
			$data->ignore_whitespace_conflicts = $ignoreWhitespaceConflicts;
		}

		if ($internalTracker !== null)
		{
			$data->internal_tracker = $internalTracker;
		}

		if ($mirrorInterval !== null)
		{
			$data->mirror_interval = $mirrorInterval;
		}

		if ($template !== null)
		{
			$data->template = $template;
		}

		// Send the patch request.
		return $this->response->get(
			$this->http->patch(
				$this->uri->get($path), json_encode($data)
			)
		);
	}

	/**
	 * Create a repository.
	 *
	 * @param   string   $name               The name of the new repository.
	 * @param   string|null $description     Optional. The description of the new repository.
	 * @param   bool|null $private           Optional. Set to true if the new repository should be private.
	 * @param   bool|null $autoInit          Optional. Set to true to initialize the repository with a README.
	 * @param   string|null $defaultBranch   Optional. Default branch of the repository (used when initializes and in template).
	 * @param   string|null $gitignores      Optional. The desired .gitignore templates to apply.
	 * @param   string|null $issueLabels     Optional. Label-Set to use.
	 * @param   string|null $license         Optional. The desired license for the repository.
	 * @param   string|null $readme          Optional. Readme of the repository to create.
	 * @param   bool|null $template          Optional. Set to true if the repository is a template.
	 * @param   string|null $trustModel      Optional. TrustModel of the repository.
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function create(
		string $name,
		?string $description = null,
		?bool $private = null,
		?bool $autoInit = null,
		?string $defaultBranch = null,
		?string $gitignores = null,
		?string $issueLabels = null,
		?string $license = null,
		?string $readme = null,
		?bool $template = null,
		?string $trustModel = null
	): ?object {
		// Build the request path.
		$path = "/user/repos";

		// Set the repo data.
		$data = new \stdClass();
		$data->name = $name;
		
		if ($description !== null)
		{
		$data->description = $description;
		}

		if ($private !== null)
		{
			$data->private = $private;
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

}

