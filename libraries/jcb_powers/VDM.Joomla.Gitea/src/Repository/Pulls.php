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
 * The Gitea Repository Pulls
 * 
 * @since 3.2.0
 */
class Pulls extends Api
{
	/**
	 * List a repository's pull requests.
	 *
	 * @param	string $owner			The owner name.
	 * @param	string $repo			The repository name.
	 * @param	string|null $state		State of pull request: open, closed, or all (optional).
	 * @param	string|null $sort		Type of sort (optional).
	 * @param	int|null $milestone		ID of the milestone (optional).
	 * @param	array|null $labels		Label IDs (optional).
	 * @param	int $page				Page number of results to return (1-based, default: 1).
	 * @param	int $limit				Page size of results (default: 10).
	 *
	 * @return array|null
	 * @since 3.2.0
	 */
	public function list(
		string $owner,
		string $repo,
		?string $state = null,
		?string $sort = null,
		?int $milestone = null,
		?array $labels = null,
		int $page = 1,
		int $limit = 10
	): ?array
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/pulls";

		// Set query parameters.
		$this->uri->setVar('page', $page);
		$this->uri->setVar('limit', $limit);

		if ($state !== null)
		{
			$this->uri->setVar('state', $state);
		}

		if ($sort !== null)
		{
			$this->uri->setVar('sort', $sort);
		}

		if ($milestone !== null)
		{
			$this->uri->setVar('milestone', $milestone);
		}

		if ($labels !== null)
		{
			$this->uri->setVar('labels', implode(',', $labels));
		}

		// Send the GET request.
		return $this->response->get(
			$this->http->get(
				$this->uri->get($path)
			)
		);
	}

	/**
	 * Create a pull request.
	 *
	 * @param	string $owner			The owner name.
	 * @param	string $repo			The repository name.
	 * @param	string $title			The title of the pull request.
	 * @param	string $head			The head branch.
	 * @param	string $base			The base branch.
	 * @param	string|null $body		The description of the pull request (optional).
	 * @param	string|null $assignee	The assignee of the pull request (optional).
	 * @param	array|null $assignees	Additional assignees (optional).
	 * @param	array|null $labels		Label IDs (optional).
	 * @param	int|null $milestone		ID of the milestone (optional).
	 * @param	string|null $dueDate	Due date of the pull request (optional).
	 *
	 * @return object|null
	 * @since 3.2.0
	 */
	public function create(
		string $owner,
		string $repo,
		string $title,
		string $head,
		string $base,
		?string $body = null,
		?string $assignee = null,
		?array $assignees = null,
		?array $labels = null,
		?int $milestone = null,
		?string $dueDate = null
	): ?object
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/pulls";

		// Set the pull request data.
		$data = new \stdClass();
		$data->title = $title;
		$data->head = $head;
		$data->base = $base;

		if ($body !== null)
		{
			$data->body = $body;
		}

		if ($assignee !== null)
		{
			$data->assignee = $assignee;
		}

		if ($assignees !== null)
		{
			$data->assignees = $assignees;
		}

		if ($labels !== null)
		{
			$data->labels = $labels;
		}

		if ($milestone !== null)
		{
			$data->milestone = $milestone;
		}

		if ($dueDate !== null)
		{
			$data->due_date = $dueDate;
		}

		// Send the post request.
		return $this->response->get(
			$this->http->post(
				$this->uri->get($path), json_encode($data)
			), 201
		);
	}

	/**
	 * Get a pull request.
	 *
	 * @param   string  $owner  The owner name.
	 * @param   string  $repo   The repository name.
	 * @param   int     $index  The pull request index.
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function get(string $owner, string $repo, int $index): ?object
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/pulls/{$index}";

		// Send the get request.
		return $this->response->get(
			$this->http->get(
				$this->uri->get($path)
			)
		);
	}

	/**
	 * Update a pull request.
	 *
	 * @param	string $owner					The owner name.
	 * @param	string $repo					The repository name.
	 * @param	int $index					The pull request index.
	 * @param	string|null $title				The title of the pull request (optional).
	 * @param	string|null $body				The description of the pull request (optional).
	 * @param	string|null $assignee			The assignee of the pull request (optional).
	 * @param	array|null $assignees			Additional assignees (optional).
	 * @param	string|null $base				The base branch (optional).
	 * @param	string|null $state				The state of the pull request (optional).
	 * @param	array|null $labels				Label IDs (optional).
	 * @param	int|null $milestone				ID of the milestone (optional).
	 * @param	string|null $dueDate			Due date of the pull request (optional).
	 * @param	bool|null $unsetDueDate 		Whether to unset the due date (optional).
	 * @param	bool|null $allowMaintainerEdit 	Allow maintainer to edit the pull request (optional).
	 *
	 * @return object|null
	 * @since 3.2.0
	 */
	public function update(
		string $owner,
		string $repo,
		int $index,
		?string $title = null,
		?string $body = null,
		?string $assignee = null,
		?array $assignees = null,
		?string $base = null,
		?string $state = null,
		?array $labels = null,
		?int $milestone = null,
		?string $dueDate = null,
		?bool $unsetDueDate = null,
		?bool $allowMaintainerEdit = null
	): ?object
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/pulls/{$index}";

		// Set the pull request data.
		$data = new \stdClass();

		if ($title !== null)
		{
			$data->title = $title;
		}

		if ($body !== null)
		{
			$data->body = $body;
		}

		if ($assignee !== null)
		{
			$data->assignee = $assignee;
		}

		if ($assignees !== null)
		{
			$data->assignees = $assignees;
		}

		if ($base !== null)
		{
			$data->base = $base;
		}

		if ($state !== null)
		{
			$data->state = $state;
		}

		if ($labels !== null)
		{
			$data->labels = $labels;
		}

		if ($milestone !== null)
		{
			$data->milestone = $milestone;
		}

		if ($dueDate !== null)
		{
			$data->due_date = $dueDate;
		}

		if ($unsetDueDate !== null)
		{
			$data->unset_due_date = $unsetDueDate;
		}

		if ($allowMaintainerEdit !== null)
		{
			$data->allow_maintainer_edit = $allowMaintainerEdit;
		}

		// Send the patch request.
		return $this->response->get(
			$this->http->patch(
				$this->uri->get($path), json_encode($data)
			), 201
		);
	}

	/**
	 * Get a pull request diff or patch.
	 *
	 * @param	string  $owner		The owner name.
	 * @param	string  $repo		The repository name.
	 * @param	int     $index		The pull request index.
	 * @param	string  $diffType	The type of the requested data, either "diff" or "patch".
	 * @param	bool    $binary		Whether to include binary file changes. If true, the diff is applicable with git apply.
	 *
	 * @return  string
	 * @since   3.2.0
	 **/
	public function diff(
		string $owner,
		string $repo,
		int $index,
		string $diffType,
		bool $binary = false
	): string
	{
		// Validate the diff type.
		if (!in_array($diffType, ['diff', 'patch']))
		{
			throw new \InvalidArgumentException('Invalid diff type. Allowed types are "diff" and "patch".');
		}

		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/pulls/{$index}.{$diffType}";

		// Get the URI with the path.
		$uri = $this->uri->get($path);

		// Set the binary query parameter if required.
		if ($binary)
		{
			$uri->setVar('binary', 'true');
		}

		// Send the get request.
		return $this->response->get(
			$this->http->get($uri)
		);
	}

	/**
	 * Get commits for a pull request.
	 *
	 * @param	string  $owner		The owner name.
	 * @param	string  $repo		The repository name.
	 * @param	int     $index		The pull request index.
	 * @param	int     $page		Page number of results to return (1-based).
	 * @param	int     $limit		Page size of results.
	 *
	 * @return  array|null
	 * @since   3.2.0
	 **/
	public function commits(
		string $owner,
		string $repo,
		int $index,
		int $page = 1,
		int $limit = 10
	): ?array
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/pulls/{$index}/commits";

		// Get the URI with the path.
		$uri = $this->uri->get($path);

		// Set the page and limit query parameters.
		$uri->setVar('page', $page);
		$uri->setVar('limit', $limit);

		// Send the get request.
		return $this->response->get(
			$this->http->get($uri)
		);
	}

	/**
	 * Get changed files for a pull request.
	 *
	 * @param	string  $owner			The owner name.
	 * @param	string  $repo			The repository name.
	 * @param	int     $index			The pull request index.
	 * @param	string  $skipTo		Skip to the given file.
	 * @param	string  $whitespace		Whitespace behavior.
	 * @param	int     $page			Page number of results to return (1-based).
	 * @param	int     $limit			Page size of results.
	 *
	 * @return  array|null
	 * @since   3.2.0
	 **/
	public function files(
		string $owner,
		string $repo,
		int $index,
		?string $skipTo = null,
		?string $whitespace = null,
		int $page = 1,
		int $limit = 10
	): ?array
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/pulls/{$index}/files";

		// Get the URI with the path.
		$uri = $this->uri->get($path);

		// Set the skip-to, whitespace, page, and limit query parameters if needed.
		if ($skipTo !== null)
		{
			$uri->setVar('skip-to', $skipTo);
		}
		if ($whitespace !== null)
		{
			$uri->setVar('whitespace', $whitespace);
		}
		$uri->setVar('page', $page);
		$uri->setVar('limit', $limit);

		// Send the get request.
		return $this->response->get(
			$this->http->get($uri)
		);
	}

	/**
	 * Merge a pull request.
	 *
	 * @param	string       $owner						The owner name.
	 * @param	string       $repo						The repository name.
	 * @param	int          $index 						The pull request index.
	 * @param	string|null  $do						Merge method.
	 * @param	string|null  $mergeCommitId				Merge commit ID.
	 * @param	string|null  $mergeMessageField			Merge message field.
	 * @param	string|null  $mergeTitleField				Merge title field.
	 * @param	bool|null    $deleteBranchAfterMerge		Whether to delete the branch after merge.
	 * @param	bool|null    $forceMerge					Whether to force merge.
	 * @param	string|null  $headCommitId				Head commit ID.
	 * @param	bool|null    $mergeWhenChecksSucceed	Whether to merge when checks succeed.
	 *
	 * @return  string
	 * @since   3.2.0
	 **/
	public function merge(
		string $owner,
		string $repo,
		int $index,
		?string $do = null,
		?string $mergeCommitId = null,
		?string $mergeMessageField = null,
		?string $mergeTitleField = null,
		?bool $deleteBranchAfterMerge = null,
		?bool $forceMerge = null,
		?string $headCommitId = null,
		?bool $mergeWhenChecksSucceed = null
	): string
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/pulls/{$index}/merge";

		// Set the merge data.
		$data = new \stdClass();

		if ($do !== null)
		{
			$data->do = $do;
		}

		if ($mergeCommitId !== null)
		{
			$data->merge_commit_id = $mergeCommitId;
		}

		if ($mergeMessageField !== null)
		{
			$data->merge_message_field = $mergeMessageField;
		}

		if ($mergeTitleField !== null)
		{
			$data->merge_title_field = $mergeTitleField;
		}

		if ($deleteBranchAfterMerge !== null)
		{
			$data->delete_branch_after_merge = $deleteBranchAfterMerge;
		}

		if ($forceMerge !== null)
		{
			$data->force_merge = $forceMerge;
		}

		if ($headCommitId !== null)
		{
			$data->head_commit_id = $headCommitId;
		}

		if ($mergeWhenChecksSucceed !== null)
		{
			$data->merge_when_checks_succeed = $mergeWhenChecksSucceed;
		}

		// Send the post request.
		return $this->response->get(
			$this->http->post(
				$this->uri->get($path), json_encode($data)
			), 200, 'success'
		);
	}

	/**
	 * Merge PR's baseBranch into headBranch.
	 *
	 * @param	string $owner		The owner name.
	 * @param	string $repo		The repository name.
	 * @param	int $index		The pull request index.
	 * @param	string|null $style	How to update the pull request. (Optional)
	 *
	 * @return string
	 * @since 3.2.0
	 */
	public function update(
		string $owner,
		string $repo,
		int $index,
		?string $style = null
	): string
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/pulls/{$index}/update";

		// Set the merge data.
		$data = new \stdClass();

		if ($style !== null)
		{
			$data->style = $style;
		}

		// Send the request.
		return $this->response->get(
			$this->http->post(
				$this->uri->get($path), json_encode($data)
			), 200, 'success'
		);
	}

}

