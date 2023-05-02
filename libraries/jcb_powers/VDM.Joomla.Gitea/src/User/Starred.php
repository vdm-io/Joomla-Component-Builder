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

namespace VDM\Joomla\Gitea\User;


use VDM\Joomla\Gitea\Abstraction\Api;


/**
 * The Gitea User Starred
 * 
 * @since 3.2.0
 */
class Starred extends Api
{
	/**
	 * List the repos that the authenticated user has starred.
	 *
	 * @param   int    $page   Page number of results to return (1-based).
	 * @param   int    $limit  Page size of results.
	 *
	 * @return  array|null
	 * @since   3.2.0
	 **/
	public function list(
		int $page = 1,
		int $limit = 10
	): ?array
	{
		// Build the request path.
		$path = '/user/starred';

		// Build the URL
		$url = $this->uri->get($path);
		$url->setVar('page', $page);
		$url->setVar('limit', $limit);

		// Send the get request.
		return $this->response->get(
			$this->http->get($url)
		);
	}

	/**
	 * Check whether the authenticated user is starring the repo.
	 *
	 * @param   string   $owner  The owner name.
	 * @param   string   $repo   The repository name.
	 *
	 * @return  string
	 * @since   3.2.0
	 **/
	public function check(string $owner, string $repo): string
	{
		// Build the request path.
		$path = "/user/starred/{$owner}/{$repo}";

		// Send the get request.
		return $this->response->get(
			$this->http->get(
				$this->uri->get($path)
			), 204, 'success'
		);
	}

}

