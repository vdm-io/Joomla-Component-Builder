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
 * The Gitea Repository Forks
 * 
 * @since 3.2.0
 */
class Forks extends Api
{
	/**
	 * List a repository's forks.
	 *
	 * @param string $owner The owner of the repo.
	 * @param string $repo The name of the repo.
	 * @param int $page The page number of results to return (1-based).
	 * @param int $limit The page size of results.
	 *
	 * @return array|null
	 * @since 3.2.0
	 */
	public function listForks(
		string $owner,
		string $repo,
		int $page = 1,
		int $limit = 10
	): ?array
	{
		// Build the request path.
		$uriPath = "/repos/{$owner}/{$repo}/forks";

		// Set the query parameters.
		$uri = $this->uri->get($uriPath);
		$uri->setVar('page', $page);
		$uri->setVar('limit', $limit);

		// Send the get request.
		return $this->response->get(
			$this->http->get($uri)
		);
	}

	/**
	 * Fork a repository.
	 *
	 * @param   string  $owner          The owner name.
	 * @param   string  $repo           The repository name.
	 * @param   string  $forkName       The name of the forked repository (optional).
	 * @param   string  $organization   The organization name (optional).
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function repo(
		string $owner,
		string $repo,
		string $forkName = '',
		string $organization = ''
	): ?object
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/forks";

		// Set the fork data.
		$data = new \stdClass();

		if (!empty($forkName))
		{
			$data->name = $forkName;
		}

		if (!empty($organization))
		{
			$data->organization = $organization;
		}

		// Send the post request.
		return $this->response->get(
			$this->http->post(
				$this->uri->get($path),
				json_encode($data)
			), 202
		);
	}


}

