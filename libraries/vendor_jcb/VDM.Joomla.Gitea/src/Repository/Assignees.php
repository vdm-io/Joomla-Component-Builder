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
 * The Gitea Repository Assignees
 * 
 * @since 3.2.0
 */
class Assignees extends Api
{
	/**
	 * Return all users that have write access and can be assigned to issues.
	 *
	 * @param   string  $owner  The owner name.
	 * @param   string  $repo   The repository name.
	 *
	 * @return  array|null
	 * @since   3.2.0
	 **/
	public function get(string $owner, string $repo): ?array
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/assignees";

		// Set the required variables to the URI.
		$uri = $this->uri->get($path);
		$uri->setVar('owner', $owner);
		$uri->setVar('repo', $repo);

		// Send the get request.
		return $this->response->get(
			$this->http->get($uri)
		);
	}

}

