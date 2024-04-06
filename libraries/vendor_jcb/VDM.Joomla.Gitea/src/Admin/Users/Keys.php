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

namespace VDM\Joomla\Gitea\Admin\Users;


use VDM\Joomla\Gitea\Abstraction\Api;


/**
 * The Gitea Admin Users Keys
 * 
 * @since 3.2.0
 */
class Keys extends Api
{
	/**
	 * Add a public key on behalf of a user.
	 *
	 * @param   string  $userName        The user's display name.
	 * @param   string  $publicKey       The public key to add.
	 * @param   string  $keyTitle        Title of the key to add.
	 * @param   bool    $readOnly        Whether the key has only read access or read/write (optional).
	 * @param   string|null  $description Description of the key (optional).
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function add(
		string $userName,
		string $publicKey,
		string $keyTitle,
		bool $readOnly = false,
		?string $description = null
	): ?object
	{
		// Build the request path.
		$path = "/admin/users/{$userName}/keys";

		// Set the key data.
		$data = new \stdClass();
		$data->key = $publicKey;
		$data->title = $keyTitle;
		$data->read_only = $readOnly;
		$data->description = $description;

		// Send the post request.
		return $this->response->get(
			$this->http->post(
				$this->uri->get($path), json_encode($data)
			), 201
		);
	}

	/**
	 * Delete a user's public key.
	 *
	 * @param   string  $username  The user's display name.
	 * @param   int     $id        The public key ID.
	 *
	 * @return  string
	 * @since   3.2.0
	 **/
	public function delete(string $username, int $id): string
	{
		// Build the request path.
		$path = "/admin/users/{$username}/keys/{$id}";

		// Send the delete request.
		return $this->response->get(
			$this->http->delete(
				$this->uri->get($path)
			), 204, 'success'
		);
	}

}

