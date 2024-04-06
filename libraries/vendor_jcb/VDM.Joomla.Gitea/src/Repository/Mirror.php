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
 * The Gitea Repository Mirror
 * 
 * @since 3.2.0
 */
class Mirror extends Api
{
	/**
	 * Sync a mirrored repository.
	 *
	 * @param	string $owner	The owner name.
	 * @param	string $repo	The repository name.
	 *
	 * @return string
	 * @since 3.2.0
	 */
	public function sync(string $owner, string $repo): string
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/mirror-sync";

		// Send the POST request.
		return $this->response->get(
			$this->http->post(
				$this->uri->get($path)
			), 200, 'success'
		);
	}

}

