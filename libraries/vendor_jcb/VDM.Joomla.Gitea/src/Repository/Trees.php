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
 * The Gitea Repository Trees
 * 
 * @since 3.2.0
 */
class Trees extends Api
{
	/**
	 * Get the tree of a repository.
	 *
	 * @param   string  $owner      The owner name.
	 * @param   string  $repo       The repository name.
	 * @param   string  $sha        The commit SHA.
	 * @param   bool    $recursive  Show all directories and files.
	 * @param   int     $page       Page number.
	 * @param   int     $perPage    Number of items per page.
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function get(
		string $owner,
		string $repo,
		string $sha,
		bool $recursive = false,
		int $page = 1,
		int $perPage = 30
	): ?object
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/git/trees/{$sha}";

		// Set URI variables.
		$uri = $this->uri->get($path);
		$uri->setVar('recursive', $recursive);
		$uri->setVar('page', $page);
		$uri->setVar('per_page', $perPage);

		// Send the get request.
		return $this->response->get(
			$this->http->get($uri)
		);
	}

}

