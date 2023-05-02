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
 * The Gitea Repository Gpg
 * 
 * @since 3.2.0
 */
class Gpg extends Api
{
	/**
	 * Get signing-key.gpg for a given repository.
	 *
	 * @param	string   $ownerName	The owner name.
	 * @param	string   $repoName		The repository name.
	 *
	 * @return  string
	 * @since   3.2.0
	 **/
	public function get(string $ownerName, string $repoName): string
	{
		// Build the request path.
		$path = "/repos/{$ownerName}/{$repoName}/signing-key.gpg";

		// Send the get request.
		return $this->response->get(
			$this->http->get(
				$this->uri->get($path)
			)
		);
	}

}

