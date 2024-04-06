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
 * The Gitea Repository Mirrors
 * 
 * @since 3.2.0
 */
class Mirrors extends Api
{
	/**
	 * Get all push mirrors of the repository.
	 *
	 * @param	string $owner	The owner name.
	 * @param	string $repo	The repository name.
	 * @param	int $page		The page number of results to return (1-based).
	 * @param	int $limit		The page size of results.
	 *
	 * @return array|null
	 * @since 3.2.0
	 */
	public function get(
		string $owner,
		string $repo,
		int $page = 1,
		int $limit = 10
	): ?array
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/push_mirrors";

		// Set query parameters.
		$uri = $this->uri->get($path);
		$uri->setVar('page', $page);
		$uri->setVar('limit', $limit);

		// Send the request.
		return $this->response->get(
		    $this->http->get($uri)
		);
	}

	/**
	 * Add a push mirror to the repository.
	 *
	 * @param	string      $owner			The owner name.
	 * @param	string      $repo			The repository name.
	 * @param	string      $remoteAddress	The push mirror address.
	 * @param	string|null $remoteUsername	The push mirror user. (Optional)
	 * @param	string|null $remotePassword	The push mirror password. (Optional)
	 * @param	string      $interval			The interval for the push mirror.
	 * @param	bool        $syncOnCommit	Sync on commit option.
	 *
	 * @return object|null
	 * @since 3.2.0
	 */
	public function add(
		string $owner,
		string $repo,
		string $remoteAddress,
		?string $remoteUsername = null,
		?string $remotePassword = null,
		string $interval,
		bool $syncOnCommit
	): ?object
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/push_mirrors";

		// Set the mirror data.
		$data = new \stdClass();
		$data->remote_address = $remoteAddress;
		$data->interval = $interval;
		$data->sync_on_commit = $syncOnCommit;

		if ($remoteUsername !== null)
		{
			$data->remote_username = $remoteUsername;
		}

		if ($remotePassword !== null)
		{
			$data->remote_password = $remotePassword;
		}

		// Send the request.
		return $this->response->get(
		    $this->http->post(
		        $this->uri->get($path), json_encode($data)
		    ), 201
		);
	}

	/**
	 * Sync all push mirrored repositories.
	 *
	 * @param	string $owner	The owner name.
	 * @param	string $repo	The repository name.
	 *
	 * @return string
	 * @since 3.2.0
	 */
	public function sync(
		string $owner,
		string $repo
	): string
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/push_mirrors-sync";

		// Send the request.
		return $this->response->get(
		    $this->http->post(
		        $this->uri->get($path)
		    ), 200, 'success'
		);
	}

	/**
	 * Get push mirror of the repository by remoteName.
	 *
	 * @param	string $owner	The owner name.
	 * @param	string $repo	The repository name.
	 * @param	string $name	The remote name.
	 *
	 * @return object|null
	 * @since 3.2.0
	 */
	public function name(
		string $owner,
		string $repo,
		string $name
	): ?object
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/push_mirrors/{$name}";

		// Get the URI with the path.
		$uri = $this->uri->get($path);

		// Send the request.
		return $this->response->get(
		    $this->http->get($uri)
		);
	}

	/**
	 * Delete a push mirror from a repository by remoteName.
	 *
	 * @param	string $owner	The owner name.
	 * @param	string $repo	The repository name.
	 * @param	string $name	The remote name.
	 *
	 * @return string
	 * @since 3.2.0
	 */
	public function delete(
		string $owner,
		string $repo,
		string $name
	): string
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/push_mirrors/{$name}";

		// Get the URI with the path.
		$uri = $this->uri->get($path);

		// Send the request.
		return $this->response->get(
		    $this->http->delete($uri), 204, 'success'
		);
	}

}

