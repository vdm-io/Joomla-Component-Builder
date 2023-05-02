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
 * The Gitea User Gpg
 * 
 * @since 3.2.0
 */
class Gpg extends Api
{
	/**
	 * Create a GPG key for the authenticated user.
	 *
	 * @param   string      $armoredPublicKey    The armored public GPG key.
	 * @param   string|null $armoredSignature    The armored signature (optional).
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function createGPGKey(
		string $armoredPublicKey,
		?string $armoredSignature = null
	): ?object
	{
		// Build the request path.
		$path = '/user/gpg_keys';

		// Set the GPG key data.
		$data = array_filter([
			'armored_public_key' => $armoredPublicKey,
			'armored_signature' => $armoredSignature
		]);

		// Send the post request.
		return $this->response->get(
			$this->http->post(
				$this->uri->get($path),
				json_encode($data)
			), 201
		);
	}

	/**
	 * Get a GPG key for the authenticated user.
	 *
	 * @param   int   $id   The GPG key ID.
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function get(int $id): ?object
	{
		// Build the request path.
		$path = "/user/gpg_keys/{$id}";

		// Send the get request.
		return $this->response->get(
			$this->http->get(
				$this->uri->get($path)
			)
		);
	}

	/**
	 * Get a token to verify.
	 *
	 * @return  string|null
	 * @since   3.2.0
	 **/
	public function token(): ?string
	{
		// Build the request path.
		$path = '/user/gpg_key_token';

		// Send the get request.
		return $this->response->get(
			$this->http->get(
				$this->uri->get($path)
			)
		);
	}

	/**
	 * Verify a GPG key.
	 *
	 * @param   string   $armoredPublicKey   The armored public GPG key.
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function verify(string $armoredPublicKey): ?object
	{
		// Build the request path.
		$path = '/user/gpg_key_verify';

		// Set the GPG key data.
		$data = new \stdClass();
		$data->armoredPublicKey = $armoredPublicKey;

		// Send the post request.
		return $this->response->get(
			$this->http->post(
				$this->uri->get($path),
				json_encode($data)
			), 201
		);
	}

	/**
	 * List the authenticated user's GPG keys.
	 *
	 * @param   int    $page   Page number of results to return (1-based).
	 * @param   int    $limit  Page size of results.
	 *
	 * @return  array|null
	 * @since   3.2.0
	 **/
	public function list(
		int $page = 1,
		int $limit = 10
	): ?array
	{
		// Build the request path.
		$path = '/user/gpg_keys';

		// Build the URL
		$url = $this->uri->get($path);
		$url->setVar('page', $page);
		$url->setVar('limit', $limit);

		// Send the get request.
		return $this->response->get(
			$this->http->get($url)
		);
	}

	/**
	 * Remove a GPG key for the authenticated user.
	 *
	 * @param   int   $id   The GPG key ID.
	 *
	 * @return  string
	 * @since   3.2.0
	 **/
	public function remove(int $id): string
	{
		// Build the request path.
		$path = "/user/gpg_keys/{$id}";

		// Send the delete request.
		return $this->response->get(
			$this->http->delete(
				$this->uri->get($path)
			), 204, 'success'
		);
	}

}

