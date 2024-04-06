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
 * The Gitea Repository Merge
 * 
 * @since 3.2.0
 */
class Merge extends Api
{
	/**
	 * Check if a pull request has been merged.
	 *
	 * @param	string  $owner	The owner name.
	 * @param	string  $repo	The repository name.
	 * @param	int     $index	The pull request index.
	 *
	 * @return  string
	 * @since   3.2.0
	 **/
	public function check(
		string $owner,
		string $repo,
		int $index
	): string
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/pulls/{$index}/merge";

		// Send the get request.
		return $this->response->get(
			$this->http->get(
				$this->uri->get($path)
			), 204, 'success'
		);
	}

	/**
	 * Merge a pull request.
	 *
	 * @param	string       $owner						The owner name.
	 * @param	string       $repo						The repository name.
	 * @param	int          $index						The pull request index.
	 * @param	string|null  $mergeMethod				Merge method to use (optional).
	 * @param	string|null  $mergeCommitId				Merge commit ID (optional).
	 * @param	string|null  $mergeMessageField			Merge message field (optional).
	 * @param	string|null  $mergeTitleField				Merge title field (optional).
	 * @param	bool|null    $deleteBranchAfterMerge		Delete branch after merge (optional).
	 * @param	bool|null    $forceMerge					Force merge (optional).
	 * @param	string|null  $headCommitId				Head commit ID (optional).
	 * @param	bool|null    $mergeWhenChecksSucceed	Merge when checks succeed (optional).
	 *
	 * @return  string
	 * @since   3.2.0
	 **/
	public function pull(
		string $owner,
		string $repo,
		int $index,
		?string $mergeMethod = null,
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

		if ($mergeMethod !== null)
		{
			$data->do = $mergeMethod;
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
	 * Cancel the scheduled auto merge for a pull request.
	 *
	 * @param	string  $owner		The owner name.
	 * @param	string  $repo		The repository name.
	 * @param	int     $index		The pull request index.
	 *
	 * @return  string
	 * @since   3.2.0
	 **/
	public function cancel(
		string $owner,
		string $repo,
		int $index
	): string
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/pulls/{$index}/merge";

		// Get the URI with the path.
		$uri = $this->uri->get($path);

		// Send the delete request.
		return $this->response->get(
			$this->http->delete($uri), 204, 'success'
		);
	}

}

