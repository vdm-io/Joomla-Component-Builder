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

namespace VDM\Joomla\Gitea\Issue\Repository;


use VDM\Joomla\Gitea\Abstraction\Api;


/**
 * The Gitea Issue Repository Comments
 * 
 * @since 3.2.0
 */
class Comments extends Api
{
	/**
	 * List all comments in a repository.
	 *
	 * @param   string      $owner      The owner name.
	 * @param   string      $repo       The repo name.
	 * @param   int         $page       The page to get, defaults to 1.
	 * @param   int         $limit      The number of comments per page, defaults to 10.
	 * @param   string|null $since      The date-time string to filter updated comments since, defaults to null.
	 * @param   string|null $before     The date-time string to filter updated comments before, defaults to null.
	 *
	 * @return  array|null
	 * @since   3.2.0
	 **/
	public function list(string $owner, string $repo, int $page = 1, int $limit = 10, ?string $since = null, ?string $before = null): ?array
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/issues/comments";

		// Build the URI.
		$uri = $this->uri->get($path);

		// Set the URI variables.
		$uri->setVar('page', $page);
		$uri->setVar('limit', $limit);

		if ($since !== null)
		{
			$uri->setVar('since', $since);
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

