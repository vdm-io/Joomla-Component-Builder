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
 * The Gitea Repository Languages
 * 
 * @since 3.2.0
 */
class Languages extends Api
{
	/**
	 * Get languages and number of bytes of code written in a repository.
	 *
	 * @param   string  $owner  The owner name.
	 * @param   string  $repo   The repository name.
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function getLanguages(string $owner, string $repo): ?object
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/languages";

		// Build the URI.
		$uri = $this->uri->get($path);

		// Send the GET request.
		return $this->response->get(
			$this->http->get($uri)
		);
	}

}

