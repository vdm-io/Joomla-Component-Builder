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
 * The Gitea Repository Media
 * 
 * @since 3.2.0
 */
class Media extends Api
{
	/**
	 * Get a file or its LFS object from a repository.
	 *
	 * @param	string      $owner	The owner name.
	 * @param	string      $repo	The repository name.
	 * @param	string      $filepath	The file path.
	 * @param	string|null $ref		The name of the commit/branch/tag. (Optional)
	 *
	 * @return string
	 * @since 3.2.0
	 */
	public function get(
		string $owner,
		string $repo,
		string $filepath,
		?string $ref = null
	): string
	{
		// Build the request path.
		$encodedFilepath = rawurlencode($filepath);
		$path = "/repos/{$owner}/{$repo}/media/{$encodedFilepath}";

		// Prepare the URI.
		$uri = $this->uri->get($path);

		// Add the 'ref' query parameter if provided.
		if ($ref !== null)
		{
			$uri->setVar('ref', $ref);
		}

		// Send the GET request.
		return $this->response->get(
			$this->http->get($uri), 200, 'success'
		);
	}

}

