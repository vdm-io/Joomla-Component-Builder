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
 * The Gitea Repository Commit
 * 
 * @since 3.2.0
 */
class Commits extends Api
{
	/**
	 * Get a list of all commits from a repository.
	 *
	 * @param string $owner The owner of the repo.
	 * @param string $repo The name of the repo.
	 * @param string|null $sha SHA or branch to start listing commits from (usually 'master').
	 * @param string|null $path Filepath of a file/dir.
	 * @param bool|null $stat Include diff stats for every commit (disable for speedup, default 'true').
	 * @param int|null $page Page number of results to return (1-based).
	 * @param int|null $limit Page size of results (ignored if used with 'path').
	 *
	 * @return array|null
	 * @since 3.2.0
	 */
	public function getList(
		string $owner,
		string $repo,
		?string $sha = null,
		?string $path = null,
		?bool $stat = true,
		?int $page = 1,
		?int $limit = 10
	): ?object
	{
		// Build the request path.
		$uriPath = "/repos/{$owner}/{$repo}/commits";

		// Set query parameters.
		$uri = $this->uri->get($uriPath);
	    
		if ($sha !== null) 
		{
			$uri->setVar('sha', $sha);
		}
	    
		if ($path !== null) 
		{
			$uri->setVar('path', $path);
		}
	    
		if ($stat !== null) 
		{
			$uri->setVar('stat', $stat ? 'true' : 'false');
		}
	    
		if ($page !== null) 
		{
			$uri->setVar('page', $page);
		}
	    
		if ($limit !== null) 
		{
			$uri->setVar('limit', $limit);
		}

		// Send the GET request.
		return $this->response->get(
			$this->http->get($uri)
		);
	}

	/**
	 * Get a single commit from a repository.
	 *
	 * @param string $owner The owner of the repo.
	 * @param string $repo The name of the repo.
	 * @param string $sha A git ref or commit sha.
	 *
	 * @return object|null
	 * @since 3.2.0
	 */
	public function getCommit(string $owner, string $repo, string $sha): ?object
	{
		// Build the request path.
		$uriPath = "/repos/{$owner}/{$repo}/git/commits/{$sha}";

		// Send the GET request.
		return $this->response->get(
			$this->http->get(
				$this->uri->get($uriPath)
			)
		);
	}

	/**
	 * Get a commit's combined status, by branch/tag/commit reference.
	 *
	 * @param   string  $owner   The owner name.
	 * @param   string  $repo    The repository name.
	 * @param   string  $ref     The branch, tag, or commit reference.
	 * @param   int     $page    Page number of results to return (1-based).
	 * @param   int     $limit   Page size of results.
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function status(
		string $owner,
		string $repo,
		string $ref,
		int $page = 1,
		int $limit = 10
	): ?object
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/commits/{$ref}/status";

		// Set up the URI with the required parameters.
		$uri = $this->uri->get($path);
		$uri->setVar('page', $page);
		$uri->setVar('limit', $limit);

		// Send the get request.
		return $this->response->get(
			$this->http->get($uri)
		);
	}

	/**
	 * Get a commit's statuses, by branch/tag/commit reference.
	 *
	 * @param string $owner The owner of the repository.
	 * @param string $repo The name of the repository.
	 * @param string $ref The branch, tag, or commit reference.
	 * @param string $sort The type of sort. Available values: oldest, recentupdate, leastupdate, leastindex, highestindex.
	 * @param string $state The type of state. Available values: pending, success, error, failure, warning.
	 * @param int $page The page number of results to return (1-based). Default value: 1.
	 * @param int $limit The page size of results. Default value: 10.
	 *
	 * @return array|null
	 * @since 3.2.0
	 */
	public function statuses(
		string $owner,
		string $repo,
		string $ref,
		string $sort = null,
		string $state = null,
		int $page = 1,
		int $limit = 10
	): ?array
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/commits/{$ref}/statuses";
		
		// Add query parameters to the URI.
		$uri = $this->uri->get($path);
	    
		if ($sort !== null) 
		{
			$uri->setVar('sort', $sort);
		}
	    
		if ($state !== null) 
		{
			$uri->setVar('state', $state);
		}
	    
		$uri->setVar('page', $page);
		$uri->setVar('limit', $limit);

		// Send the GET request.
		$response = $this->http->get($uri);
		return $this->response->get($response);
	}

	/**
	 * Get a commit's diff or patch.
	 *
	 * @param   string   $owner     The owner name.
	 * @param   string   $repo      The repository name.
	 * @param   string   $sha       The SHA hash of the commit.
	 * @param   string   $diffType  The diff type, either 'diff' or 'patch'.
	 *
	 * @return  string
	 * @since   3.2.0
	 **/
	public function diff(
		string $owner,
		string $repo,
		string $sha,
		string $diffType
	): string
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/git/commits/{$sha}";

		// Set the diffType as a variable in the URI.
		$this->uri->setVar('diffType', $diffType);

		// Send the get request.
		return $this->response->get(
			$this->http->get(
				$this->uri->get($path)
			)
		);
	}


}

