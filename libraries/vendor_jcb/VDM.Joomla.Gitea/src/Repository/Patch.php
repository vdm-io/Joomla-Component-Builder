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
 * The Gitea Repository Patch
 * 
 * @since 3.2.0
 */
class Patch extends Api
{
	/**
	 * Apply a diff patch to a repository.
	 *
	 * @param string $owner The owner of the repo.
	 * @param string $repo The name of the repo.
	 * @param array $options Options for updating files.
	 *   $options = [
	 *      'description' => 'UpdateFileOptions',
	 *      'body' => [
	 *          'content' => 'string', // Content must be base64 encoded.
	 *          'sha' => 'string', // The SHA for the file that already exists.
	 *          'branch' => 'string', // Branch (optional) to base this file from. If not given, the default branch is used.
	 *          'new_branch' => 'string', // New branch (optional) will make a new branch from branch before creating the file.
	 *          'from_path' => 'string', // From_path (optional) is the path of the original file which will be moved/renamed to the path in the URL.
	 *          'message' => 'string', // Message (optional) for the commit of this file. If not supplied, a default message will be used.
	 *          'author' => [ // Identity for a person's identity like an author or committer.
	 *              'name' => 'string',
	 *              'email' => 'string($email)'
	 *          ],
	 *          'committer' => [ // Identity for a person's identity like an author or committer.
	 *              'name' => 'string',
	 *              'email' => 'string($email)'
	 *          ],
	 *          'dates' => [ // Store dates for GIT_AUTHOR_DATE and GIT_COMMITTER_DATE.
	 *              'author' => 'string($date-time)',
	 *              'committer' => 'string($date-time)'
	 *          ],
	 *          'signoff' => 'boolean' // Add a Signed-off-by trailer by the committer at the end of the commit log message.
	 *      ]
	 * ]
	 *
	 * @return object|null
	 * @since 3.2.0
	 */
	public function applyDiffPatch(
		string $owner,
		string $repo,
		array $option
	): ?object
	{
		// Build the request path.
		$uriPath = "/repos/{$owner}/{$repo}/diffpatch";

		// Send the post request.
		return $this->response->get(
			$this->http->post(
				$this->uri->get($uriPath),
				json_encode($options)
			)
		);
	}

}

