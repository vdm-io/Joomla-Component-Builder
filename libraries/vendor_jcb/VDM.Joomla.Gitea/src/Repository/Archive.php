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
 * The Gitea Repository Archive
 * 
 * @since 3.2.0
 */
class Archive extends Api
{
	/**
	 * Get an archive of a repository.
	 *
	 * @param   string  $owner     The owner name.
	 * @param   string  $repo      The repository name.
	 * @param   string  $archive   The archive format, e.g., "zip" or "tar.gz".
	 *
	 * @return  string
	 * @since   3.2.0
	 **/
	public function get(
		string $owner,
		string $repo,
		string $archive
	): string
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/archive/{$archive}";

		// Set the required variables to the URI.
		$uri = $this->uri->get($path);
		$uri->setVar('owner', $owner);
		$uri->setVar('repo', $repo);
		$uri->setVar('archive', $archive);

		// Send the get request.
		return $this->response->get(
			$this->http->get($uri), 200, 'success'
		);
	}


}

