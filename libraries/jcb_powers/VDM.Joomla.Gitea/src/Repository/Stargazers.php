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
 * The Gitea Repository Stargazers
 * 
 * @since 3.2.0
 */
class Stargazers extends Api
{
	/**
	 * List a repo's stargazers.
	 *
	 * @param	string   $ownerName	The owner name.
	 * @param	string   $repoName		The repository name.
	 * @param	int      $page			The page number of results to return (1-based).
	 * @param	int      $limit			The page size of results.
	 *
	 * @return  array|null
	 * @since   3.2.0
	 **/
	public function list(
		string $ownerName,
		string $repoName,
		int $page = 1,
		int $limit = 10
	): ?array
	{
		// Build the request path.
		$path = "/repos/{$ownerName}/{$repoName}/stargazers";

		// Set the page and limit values.
		$this->uri->setVar('page', $page);
		$this->uri->setVar('limit', $limit);

		// Send the get request.
		return $this->response->get(
			$this->http->get(
				$this->uri->get($path)
			)
		);
	}

}

