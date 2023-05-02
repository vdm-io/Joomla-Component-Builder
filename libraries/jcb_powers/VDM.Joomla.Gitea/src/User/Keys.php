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

namespace VDM\Joomla\Gitea\User;


use VDM\Joomla\Gitea\Abstraction\Api;


/**
 * The Gitea User Keys
 * 
 * @since 3.2.0
 */
class Keys extends Api
{
	/**
	 * Create a public key for the authenticated user.
	 *
	 * @param   string	 $title	 	 The title of the public key.
	 * @param   string	 $key 	 	 The content of the public key.
	 * @param   bool	 $readOnly	 Optional. True if the key has only read access, false for read/write access.
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function create(
		string $title,
		string $key,
		bool $readOnly = false
	): ?object
	{
		// Build the request path.
		$path = '/user/keys';

		// Set the public key data.
		$data = new \stdClass();
		$data->title = $title;
		$data->key = $key;
		$data->read_only = $readOnly;

		// Send the post request.
		return $this->response->get(
			$this->http->post(
				$this->uri->get($path),
				json_encode($data)
			), 201
		);
	}

	/**
	 * List the authenticated user's public keys.
	 *
	 * @param   string|null 	 $fingerprint	 Optional. The fingerprint of the key.
	 * @param   int	 	 $page	 	 Page number of results to return (1-based).
	 * @param   int	 	 $limit	 	 Page size of results.
	 *
	 * @return  array|null
	 * @since   3.2.0
	 **/
	public function list(
		?string $fingerprint = null,
		int $page = 1,
		int $limit = 10
	): ?array
	{
		// Build the request path.
		$path = '/user/keys';

		// Build the URI with query parameters.
		$uri = $this->uri->get($path);
		if ($fingerprint !== null) {
			$uri->setVar('fingerprint', $fingerprint);
		}
		$uri->setVar('page', $page);
		$uri->setVar('limit', $limit);

		// Send the get request.
		return $this->response->get(
			$this->http->get($uri)
		);
	}

	/**
	 * Get a public key for the authenticated user.
	 *
	 * @param   int   $id   The public key ID.
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function get(int $id): ?object
	{
		// Build the request path.
		$path = "/user/keys/{$id}";

		// Send the get request.
		return $this->response->get(
			$this->http->get(
				$this->uri->get($path)
			)
		);
	}

	/**
	 * Delete a public key for the authenticated user.
	 *
	 * @param   int   $id   The public key ID.
	 *
	 * @return  string
	 * @since   3.2.0
	 **/
	public function delete(int $id): string
	{
		// Build the request path.
		$path = "/user/keys/{$id}";

		// Send the delete request.
		return $this->response->get(
			$this->http->delete(
				$this->uri->get($path)
			), 204, 'success'
		);
	}

}

