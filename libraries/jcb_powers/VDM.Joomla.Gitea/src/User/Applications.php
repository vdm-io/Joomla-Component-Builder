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
 * The Gitea User Applications
 * 
 * @since 3.2.0
 */
class Applications extends Api
{
	/**
	 * List the authenticated user's oauth2 applications.
	 *
	 * @param   int   $page	 Page number of results to return (1-based).
	 * @param   int   $limit	 Page size of results.
	 *
	 * @return  array|null
	 * @since   3.2.0
	 **/
	public function get(
		int $page = 1,
		int $limit = 10
	): ?array
	{
		// Build the request path.
		$path = '/user/applications/oauth2';

		// Build the URI with query parameters.
		$uri = $this->uri->get($path);
		$uri->setVar('page', $page);
		$uri->setVar('limit', $limit);

		// Send the get request.
		return $this->response->get(
			$this->http->get($uri)
		);
	}

	/**
	 * Get an OAuth2 application by ID.
	 *
	 * @param   int   $id   The OAuth2 application ID.
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function id(int $id): ?object
	{
		// Build the request path.
		$path = "/user/applications/oauth2/{$id}";

		// Send the get request.
		return $this->response->get(
			$this->http->get(
				$this->uri->get($path)
			)
		);
	}

	/**
	 * Creates a new OAuth2 application.
	 *
	 * @param   string	 $appName	 	 The application name.
	 * @param   array	 $redirectUris	 	 The application redirect URIs.
	 * @param   bool 	 $confidentialClient	 The confidentiality of the client (default: true).
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function create(
		string $appName,
		array $redirectUris,
		bool $confidentialClient = true
	): ?object
	{
		// Build the request path.
		$path = '/user/applications/oauth2';

		// Set the application data.
		$data = new \stdClass();
		$data->name = $appName;
		$data->redirect_uris = $redirectUris;
		$data->confidential_client = $confidentialClient;

		// Send the post request.
		return $this->response->get(
			$this->http->post(
				$this->uri->get($path),
				json_encode($data)
			), 201
		);
	}

	/**
	 * Delete an OAuth2 application by ID.
	 *
	 * @param   int   $id   The OAuth2 application ID.
	 *
	 * @return  string
	 * @since   3.2.0
	 **/
	public function delete(int $id): string
	{
		// Build the request path.
		$path = "/user/applications/oauth2/{$id}";

		// Send the delete request.
		return $this->response->get(
			$this->http->delete(
				$this->uri->get($path)
			), 204, 'success'
		);
	}

	/**
	 * Update an OAuth2 application by ID, this includes regenerating the client secret.
	 *
	 * @param   int	 $appId 	 	 	 The OAuth2 application ID.
	 * @param   string	 $appName 	 	 The application name.
	 * @param   array	 $redirectUris	 	 The application redirect URIs.
	 * @param   bool	 $confidentialClient	 The confidentiality of the client (default: true).
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function update(
		int $appId,
		string $appName,
		array $redirectUris,
		bool $confidentialClient = true
	): ?object
	{
		// Build the request path.
		$path = "/user/applications/oauth2/{$appId}";

		// Set the application data.
		$data = new \stdClass();
		$data->name = $appName;
		$data->redirect_uris = $redirectUris;
		$data->confidential_client = $confidentialClient;

		// Send the patch request.
		return $this->response->get(
			$this->http->patch(
				$this->uri->get($path),
				json_encode($data)
			)
		);
	}

}

