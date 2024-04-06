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
 * The Gitea Repository Times
 * 
 * @since 3.2.0
 */
class Times extends Api
{
	/**
	 * List a repo's tracked times.
	 *
	 * @param	string   $ownerName		The owner name.
	 * @param	string   $repoName		The repository name.
	 * @param	string   $user			Optional filter by user (available for issue managers).
	 * @param	string   $since			Only show times updated after the given time. This is a timestamp in RFC 3339 format.
	 * @param	string   $before		Only show times updated before the given time. This is a timestamp in RFC 3339 format.
	 * @param	int      $page			The page number of results to return (1-based).
	 * @param	int      $limit			The page size of results.
	 *
	 * @return  array|null
	 * @since   3.2.0
	 **/
	public function list(
		string $ownerName,
		string $repoName,
		string $user = null,
		string $since = null,
		string $before = null,
		int $page = 1,
		int $limit = 10
	): ?array
	{
		// Build the request path.
		$path = "/repos/{$ownerName}/{$repoName}/times";

		// Set the query parameters.
		$uri = $this->uri->get($path);

		if ($user !== null)
		{
			$uri->setVar('user', $user);
		}

		if ($since !== null)
		{
			$uri->setVar('since', $since);
		}

		if ($before !== null)
		{
			$uri->setVar('before', $before);
		}

		$uri->setVar('page', $page);
		$uri->setVar('limit', $limit);

		// Send the get request.
		return $this->response->get(
			$this->http->get($uri)
		);
	}

}

