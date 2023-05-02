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

namespace VDM\Joomla\Gitea\Issue;


use VDM\Joomla\Gitea\Abstraction\Api;


/**
 * The Gitea Issue Timeline
 * 
 * @since 3.2.0
 */
class Timeline extends Api
{
	/**
	 * List all comments and events on an issue.
	 *
	 * @param   string        $owner      The owner name.
	 * @param   string        $repo       The repo name.
	 * @param   int           $index      The issue index.
	 * @param   string|null   $since      Optional. If provided, only comments updated since the specified time are returned.
	 * @param   int|null      $page       Optional. Page number of results to return (1-based).
	 * @param   int|null      $limit      Optional. Page size of results.
	 * @param   string|null   $before     Optional. If provided, only comments updated before the provided time are returned.
	 *
	 * @return  array|null
	 * @since   3.2.0
	 **/
	public function get(
		string $owner,
		string $repo,
		int $index,
		?string $since = null,
		?int $page = null,
		?int $limit = null,
		?string $before = null
	): ?array
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/issues/{$index}/timeline";

		// Set the query parameters.
		$uri = $this->uri->get($path);
		if ($since !== null)
		{
			$uri->setVar('since', $since);
		}
		if ($page !== null)
		{
			$uri->setVar('page', $page);
		}
		if ($limit !== null)
		{
			$uri->setVar('limit', $limit);
		}
		if ($before !== null)
		{
			$uri->setVar('before', $before);
		}

		// Send the get request.
		return $this->response->get(
			$this->http->get($uri)
		);
	}

}

