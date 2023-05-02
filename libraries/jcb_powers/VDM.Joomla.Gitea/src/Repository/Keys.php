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
 * The Gitea Repository Keys
 * 
 * @since 3.2.0
 */
class Keys extends Api
{
	/**
	 * List a repository's keys.
	 *
	 * @param	string      $owner		The owner name.
	 * @param	string      $repo		The repository name.
	 * @param	int|null    $keyId		The key_id to search for. (Optional)
	 * @param	string|null $fingerprint	The fingerprint of the key. (Optional)
	 * @param	int         $page			The page number of results to return. (Default: 1)
	 * @param	int         $limit			The page size of results. (Default: 10)
	 *
	 * @return array|null
	 * @since 3.2.0
	 */
	public function list(string $owner, string $repo, ?int $keyId = null, ?string $fingerprint = null, int $page = 1, int $limit = 10): ?array
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/keys";

		// Prepare the URI.
		$uri = $this->uri->get($path);

		// Add the optional query parameters.
		if ($keyId !== null)
		{
			$uri->setVar('key_id', $keyId);
		}

		if ($fingerprint !== null)
		{
			$uri->setVar('fingerprint', $fingerprint);
		}

		$uri->setVar('page', $page);
		$uri->setVar('limit', $limit);

		// Send the GET request.
		return $this->response->get(
			$this->http->get($uri)
		);
	}

	/**
	 * Add a key to a repository.
	 *
	 * @param   string   $owner         The owner name.
	 * @param   string   $repo          The repository name.
	 * @param   string   $key           The public key.
	 * @param   string   $title         The title of the key.
	 * @param   bool     $readOnly      Whether the key is read-only.
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function add(
		string $owner,
		string $repo,
		string $key,
		string $title,
		bool $readOnly
	): ?object
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/keys";

		// Set the key data.
		$data = new \stdClass();
		$data->key = $key;
		$data->title = $title;
		$data->read_only = $readOnly;

		// Send the POST request.
		return $this->response->get(
			$this->http->post(
				$this->uri->get($path),
				json_encode($data)
			), 201
		);
	}

	/**
	 * Get a repository's key by id.
	 *
	 * @param	string $owner	The owner name.
	 * @param	string $repo	The repository name.
	 * @param	int    $id		The key ID.
	 *
	 * @return object|null
	 * @since 3.2.0
	 */
	public function id(
		string $owner,
		string $repo,
		int $id
	): ?object
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/keys/{$id}";

		// Send the GET request.
		return $this->response->get(
			$this->http->get(
				$this->uri->get($path)
			)
		);
	}

	/**
	 * Delete a key from a repository.
	 *
	 * @param   string   $owner  The owner name.
	 * @param   string   $repo   The repository name.
	 * @param   int      $id     The key ID.
	 *
	 * @return  string
	 * @since   3.2.0
	 **/
	public function delete(
		string $owner,
		string $repo,
		int $id
	): string
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/keys/{$id}";

		// Send the DELETE request.
		return $this->response->get(
			$this->http->delete(
				$this->uri->get($path)
			), 204, 'success'
		);
	}

}

