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
 * The Gitea Repository Refs
 * 
 * @since 3.2.0
 */
class Refs extends Api
{
	/**
	 * Get specified ref or filtered repository's refs.
	 *
	 * @param   string  $owner  The owner name.
	 * @param   string  $repo   The repository name.
	 *
	 * @return  array|null
	 * @since   3.2.0
	 **/
	public function list(string $owner, string $repo): ?array
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/git/refs";

		// Build the URI.
		$uri = $this->uri->get($path);

		// Send the get request.
		return $this->response->get(
			$this->http->get($uri)
		);
	}

	/**
	 * Get specified ref.
	 *
	 * @param   string  $owner  The owner name.
	 * @param   string  $repo   The repository name.
	 * @param   string  $ref    The ref name.
	 *
	 * @return  array|null
	 * @since   3.2.0
	 **/
	public function get(
		string $owner,
		string $repo,
		string $ref
	): ?array
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/git/refs/{$ref}";

		// Build the URI.
		$uri = $this->uri->get($path);

		// Send the get request.
		return $this->response->get(
			$this->http->get($uri)
		);
	}

}

