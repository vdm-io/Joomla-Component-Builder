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

namespace VDM\Joomla\Gitea\Repository\Branch;


use VDM\Joomla\Gitea\Abstraction\Api;


/**
 * The Gitea Repository Branch Protection
 * 
 * @since 3.2.0
 */
class Protection extends Api
{
	/**
	 * List branch protections for a repository.
	 *
	 * @param	string  $ownerName	The owner name.
	 * @param	string  $repositoryName	The repository name.
	 *
	 * @return  array|null
	 * @since   3.2.0
	 **/
	public function list(string $ownerName, string $repositoryName): ?array
	{
		// Build the request path.
		$path = "/repos/{$ownerName}/{$repositoryName}/branch_protections";

		// Get the URI with the path.
		$uri = $this->uri->get($path);

		// Send the get request.
		return $this->response->get(
			$this->http->get($uri)
		);
	}

	/**
	 * Create a branch protection for a repository.
	 *
	 * @param	string  $owner 						The owner name.
	 * @param	string  $repo							The repository name.
	 * @param	string  $branchName					The name of the branch to protect.
	 * @param	array   $approvalsWhitelistUsernames		An array of usernames that can approve.
	 * @param	array   $approvalsWhitelistTeams			An array of team names that can approve.
	 * @param	bool    $blockOnOfficialReviewRequests	Enable/disable blocking on official review requests (optional, default false).
	 * @param	bool    $blockOnOutdatedBranch			Enable/disable blocking on outdated branch (optional, default false).
	 * @param	bool    $blockOnRejectedReviews			Enable/disable blocking on rejected reviews (optional, default false).
	 * @param	bool    $dismissStaleApprovals 			Enable/disable dismissing stale approvals (optional, default false).
	 * @param 	bool    $enableApprovalsWhitelist			Enable/disable approvals whitelist (optional, default false).
	 * @param	bool    $enableMergeWhitelist			Enable/disable merge whitelist (optional, default false).
	 * @param 	bool    $enablePush 					Enable/disable push (optional, default true).
	 * @param	bool    $enablePushWhitelist				Enable/disable push whitelist (optional, default false).
	 * @param	bool    $enableStatusCheck				Enable/disable status check (optional, default false).
	 * @param	array   $mergeWhitelistUsernames		An array of usernames that can merge (optional).
	 * @param	array   $mergeWhitelistTeams			An array of team names that can merge (optional).
	 * @param	string  $protectedFilePatterns				Protected file patterns (optional).
	 * @param	bool    $pushWhitelistDeployKeys			Enable/disable push whitelist deploy keys (optional, default false).
	 * @param	array   $pushWhitelistUsernames			An array of usernames that can push (optional).
	 * @param	array   $pushWhitelistTeams				An array of team names that can push (optional).
	 * @param	bool    $requireSignedCommits			Enable/disable requiring signed commits (optional, default false).
	 * @param	int     $requiredApprovals				Number of required approvals (optional, default 0).
	 * @param	array   $statusCheckContexts				An array of status check contexts (optional).
	 * @param	string  $unprotectedFilePatterns			Unprotected file patterns (optional).
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function create(
		string $owner,
		string $repo,
		string $branchName,
		array $approvalsWhitelistUsernames,
		array $approvalsWhitelistTeams,
		bool $blockOnOfficialReviewRequests = false,
		bool $blockOnOutdatedBranch = false,
		bool $blockOnRejectedReviews = false,
		bool $dismissStaleApprovals = false,
		bool $enableApprovalsWhitelist = false,
		bool $enableMergeWhitelist = false,
		bool $enablePush = true,
		bool $enablePushWhitelist = false,
		bool $enableStatusCheck = false,
		array $mergeWhitelistUsernames = [],
		array $mergeWhitelistTeams = [],
		string $protectedFilePatterns = '',
		bool $pushWhitelistDeployKeys = false,
		array $pushWhitelistUsernames = [],
		array $pushWhitelistTeams = [],
		bool $requireSignedCommits = false,
		int $requiredApprovals = 0,
		array $statusCheckContexts = [],
		string $unprotectedFilePatterns = ''
	): ?object
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/branch_protections";

		// Set the branch protection data.
		$data = new \stdClass();
		$data->branch_name = $branchName;
		$data->approvals_whitelist_usernames = $approvalsWhitelistUsernames;
		$data->approvals_whitelist_teams = $approvalsWhitelistTeams;
		$data->block_on_official_review_requests = $blockOnOfficialReviewRequests;
		$data->block_on_outdated_branch = $blockOnOutdatedBranch;
		$data->block_on_rejected_reviews = $blockOnRejectedReviews;
		$data->dismiss_stale_approvals = $dismissStaleApprovals;
		$data->enable_approvals_whitelist = $enableApprovalsWhitelist;
		$data->enable_merge_whitelist = $enableMergeWhitelist;
		$data->enable_push = $enablePush;
		$data->enable_push_whitelist = $enablePushWhitelist;
		$data->enable_status_check = $enableStatusCheck;
		$data->merge_whitelist_usernames = $mergeWhitelistUsernames;
		$data->merge_whitelist_teams = $mergeWhitelistTeams;
		$data->protected_file_patterns = $protectedFilePatterns;
		$data->push_whitelist_deploy_keys = $pushWhitelistDeployKeys;
		$data->push_whitelist_usernames = $pushWhitelistUsernames;
		$data->push_whitelist_teams = $pushWhitelistTeams;
		$data->require_signed_commits = $requireSignedCommits;
		$data->required_approvals = $requiredApprovals;
		$data->status_check_contexts = $statusCheckContexts;
		$data->unprotected_file_patterns = $unprotectedFilePatterns;

		// Send the post request.
		return $this->response->get(
			$this->http->post(
				$this->uri->get($path), json_encode($data)
			), 201
		);
	}

	/**
	 * Get a specific branch protection for the repository.
	 *
	 * @param 	string  $owner			The owner name.
	 * @param	string  $repo 			The repository name.
	 * @param	string  $branchName	The branch protection name.
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function get(
		string $owner,
		string $repo,
		string $branchName
	): ?object
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/branch_protections/{$branchName}";

		// Get the URI object with the given path.
		$uri = $this->uri->get($path);

		// Send the get request.
		return $this->response->get(
			$this->http->get($uri)
		);
	}

	/**
	 * Delete a specific branch protection for the repository.
	 *
	 * @param	string  $ownerName	The owner name.
	 * @param	string  $repoName		The repository name.
	 * @param	string  $branchName	The branch protection name.
	 *
	 * @return  string
	 * @since   3.2.0
	 **/
	public function delete(
		string $ownerName,
		string $repoName,
		string $branchName
	): string
	{
		// Build the request path.
		$path = "/repos/{$ownerName}/{$repoName}/branch_protections/{$branchName}";

		// Set the required variables in the URI.
		$this->uri->setVar('owner', $ownerName);
		$this->uri->setVar('repo', $repoName);
		$this->uri->setVar('name', $branchName);

		// Send the delete request.
		return $this->response->get(
			$this->http->delete(
				$this->uri->get($path)
			), 204, 'success'
		);
	}

	/**
	 * Edit a branch protection for a repository.
	 *
	 * @param	string        $owner							The owner name.
	 * @param	string        $repo							The repository name.
	 * @param	string        $name							The branch protection name.
	 * @param	array|null    $approvalsWhitelistTeams			An array of team names that are allowed to approve (optional).
	 * @param	array|null    $approvalsWhitelistUsernames		An array of usernames that are allowed to approve (optional).
	 * @param	bool|null     $blockOnOfficialReviewRequests	Block when official review requests are pending (optional).
	 * @param	bool|null     $blockOnOutdatedBranch			Block when the branch is outdated (optional).
	 * @param	bool|null     $blockOnRejectedReviews			Block when reviews are rejected (optional).
	 * @param	bool|null     $dismissStaleApprovals			Dismiss stale approvals when new commits are pushed (optional).
	 * @param	bool|null     $enableApprovalsWhitelist			Enable/disable approvals whitelist (optional).
	 * @param	bool|null     $enableMergeWhitelist				Enable/disable merge whitelist (optional).
	 * @param	bool|null     $enablePush					Enable/disable push (optional).
	 * @param	bool|null     $enablePushWhitelist				Enable/disable push whitelist (optional).
	 * @param	bool|null     $enableStatusCheck				Enable/disable status check (optional).
	 * @param	array|null    $mergeWhitelistTeams				An array of team names that are allowed to merge (optional).
	 * @param	array|null    $mergeWhitelistUsernames			An array of usernames that are allowed to merge (optional).
	 * @param	string|null   $protectedFilePatterns			A string pattern for protected files (optional).
	 * @param	bool|null     $pushWhitelistDeployKeys			Enable/disable push whitelist for deploy keys (optional).
	 * @param	array|null    $pushWhitelistTeams				An array of team names that are allowed to push (optional).
	 * @param	array|null    $pushWhitelistUsernames			An array of usernames that are allowed to push (optional).
	 * @param	bool|null     $requireSignedCommits				Require signed commits (optional).
	 * @param	int|null      $requiredApprovals				Number of required approvals (optional).
	 * @param	array|null    $statusCheckContexts				An array of status check contexts (optional).
	 * @param	string|null   $unprotectedFilePatterns			A string pattern for unprotected files (optional).
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function edit(
		string $owner,
		string $repo,
		string $name,
		?array $approvalsWhitelistTeams = null,
		?array $approvalsWhitelistUsernames = null,
		?bool $blockOnOfficialReviewRequests = null,
		?bool $blockOnOutdatedBranch = null,
		?bool $blockOnRejectedReviews = null,
		?bool $dismissStaleApprovals = null,
		?bool $enableApprovalsWhitelist = null,
		?bool $enableMergeWhitelist = null,
		?bool $enablePush = null,
		?bool $enablePushWhitelist = null,
		?bool $enableStatusCheck = null,
		?array $mergeWhitelistTeams = null,
		?array $mergeWhitelistUsernames = null,
		?string $protectedFilePatterns = null,
		?bool $pushWhitelistDeployKeys = null,
		?array $pushWhitelistTeams = null,
		?array $pushWhitelistUsernames = null,
		?bool $requireSignedCommits = null,
		?int $requiredApprovals = null,
		?array $statusCheckContexts = null,
		?string $unprotectedFilePatterns = null
	): ?object
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/branch_protections/{$name}";

		// Set the branch protection data.
		$data = new \stdClass();

		if ($approvalsWhitelistTeams !== null)
		{
		    $data->approvals_whitelist_teams = $approvalsWhitelistTeams;
		}

		if ($approvalsWhitelistUsernames !== null)
		{
		    $data->approvals_whitelist_usernames = $approvalsWhitelistUsernames;
		}

		if ($blockOnOfficialReviewRequests !== null)
		{
			$data->block_on_official_review_requests = $blockOnOfficialReviewRequests;
		}

		if ($blockOnOutdatedBranch !== null)
		{
			$data->block_on_outdated_branch = $blockOnOutdatedBranch;
		}

		if ($blockOnRejectedReviews !== null)
		{
			$data->block_on_rejected_reviews = $blockOnRejectedReviews;
		}

		if ($dismissStaleApprovals !== null)
		{
			$data->dismiss_stale_approvals = $dismissStaleApprovals;
		}

		if ($enableApprovalsWhitelist !== null)
		{
			$data->enable_approvals_whitelist = $enableApprovalsWhitelist;
		}

		if ($enableMergeWhitelist !== null)
		{
			$data->enable_merge_whitelist = $enableMergeWhitelist;
		}

		if ($enablePush !== null)
		{
			$data->enable_push = $enablePush;
		}

		if ($enablePushWhitelist !== null)
		{
			$data->enable_push_whitelist = $enablePushWhitelist;
		}

		if ($enableStatusCheck !== null)
		{
			$data->enable_status_check = $enableStatusCheck;
		}

		if ($mergeWhitelistTeams !== null)
		{
			$data->merge_whitelist_teams = $mergeWhitelistTeams;
		}

		if ($mergeWhitelistUsernames !== null)
		{
			$data->merge_whitelist_usernames = $mergeWhitelistUsernames;
		}

		if ($protectedFilePatterns !== null)
		{
			$data->protected_file_patterns = $protectedFilePatterns;
		}

		if ($pushWhitelistDeployKeys !== null)
		{
			$data->push_whitelist_deploy_keys = $pushWhitelistDeployKeys;
		}

		if ($pushWhitelistTeams !== null)
		{
			$data->push_whitelist_teams = $pushWhitelistTeams;
		}

		if ($pushWhitelistUsernames !== null)
		{
			$data->push_whitelist_usernames = $pushWhitelistUsernames;
		}

		if ($requireSignedCommits !== null)
		{
			$data->require_signed_commits = $requireSignedCommits;
		}

		if ($requiredApprovals !== null)
		{
			$data->required_approvals = $requiredApprovals;
		}

		if ($statusCheckContexts !== null)
		{
			$data->status_check_contexts = $statusCheckContexts;
		}

		if ($unprotectedFilePatterns !== null)
		{
			$data->unprotected_file_patterns = $unprotectedFilePatterns;
		}

		// Send the patch request.
		return $this->response->get(
		    $this->http->patch(
		        $this->uri->get($path), json_encode($data)
		    )
		);
	}

}

