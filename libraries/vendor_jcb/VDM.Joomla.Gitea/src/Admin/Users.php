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

namespace VDM\Joomla\Gitea\Admin;


use VDM\Joomla\Gitea\Abstraction\Api;


/**
 * The Gitea Admin Users
 * 
 * @since 3.2.0
 */
class Users extends Api
{
	/**
	 * List all users.
	 *
	 * @param   int  $page   Page number of results to return (1-based).
	 * @param   int  $limit  Page size of results.
	 *
	 * @return  array|null
	 * @since   3.2.0
	 **/
	public function list(int $page = 1, int $limit = 10): ?array
	{
		// Build the request path.
		$path = "/admin/users";

		// build the URL
		$url = $this->uri->get($path);
		$url->setVar('page', $page);
		$url->setVar('limit', $limit);

		// Send the get request.
		return $this->response->get(
			$this->http->get($url)
		);
	}

	/**
	 * Create a user with extended options.
	 *
	 * @param   string       $loginName           The user's login name.
	 * @param   string       $email               The user's email address.
	 * @param   string       $password            The user's password.
	 * @param   string|null  $username            The username.
	 * @param   string|null  $fullName            The user's full name (optional).
	 * @param   bool|null    $mustChangePassword  User must change password on next login (optional).
	 * @param   bool|null    $restricted          Restrict the user (optional).
	 * @param   bool|null    $sendNotify          Send a notification email to the user (optional).
	 * @param   int|null     $sourceId            Source ID (optional).
	 * @param   string|null  $visibility          The user's visibility (optional).
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function create(
		string $loginName,
		string $email,
		string $password,
		string $username,
		?string $fullName = null,
		?bool $mustChangePassword = null,
		?bool $restricted = null,
		?bool $sendNotify = null,
		?int $sourceId = null,
		?string $visibility = null
	): ?object
	{
		// Build the request path.
		$path = "/admin/users";

		// Set the user data.
		$data = new \stdClass();
		$data->login_name = $loginName;
		$data->email = $email;
		$data->password = $password;
		$data->username = $username;
		$data->full_name = $fullName;
		$data->must_change_password = $mustChangePassword;
		$data->restricted = $restricted;
		$data->send_notify = $sendNotify;
		$data->source_id = $sourceId;
		$data->visibility = $visibility;

		// Send the post request.
		return $this->response->get(
			$this->http->post(
				$this->uri->get($path), json_encode($data)
			), 201
		);
	}

	/**
	 * Delete a user.
	 *
	 * @param   string  $username  The user's display name.
	 *
	 * @return  string
	 * @since   3.2.0
	 **/
	public function delete(string $username): string
	{
		// Build the request path.
		$path = "/admin/users/{$username}";

		// Send the delete request.
		return $this->response->get(
			$this->http->delete(
				$this->uri->get($path)
			), 204, 'success'
		);
	}

	/**
	 * Edit an existing user.
	 *
	 * @param   string  $username                   The user's display name.
	 * @param   string  $loginName                  The user's login name.
	 * @param   int     $sourceId                   The user's source ID.
	 * @param   bool    $active                     Optional. Is the user active? Default: false.
	 * @param   bool    $admin                      Optional. Is the user an admin? Default: false.
	 * @param   bool    $allowCreateOrganization    Optional. Can the user create an organization? Default: false.
	 * @param   bool    $allowGitHook               Optional. Can the user create Git hooks? Default: false.
	 * @param   bool    $allowImportLocal           Optional. Can the user import local repositories? Default: false.
	 * @param   string  $description                Optional. The user's description. Default: ''.
	 * @param   string  $email                      Optional. The user's email address. Default: ''.
	 * @param   string  $fullName                   Optional. The user's full name. Default: ''.
	 * @param   string  $location                   Optional. The user's location. Default: ''.
	 * @param   int     $maxRepoCreation            Optional. Maximum repositories the user can create. Default: 0.
	 * @param   bool    $mustChangePassword         Optional. Must the user change their password? Default: false.
	 * @param   string  $password                   Optional. The user's password. Default: ''.
	 * @param   bool    $prohibitLogin              Optional. Is the user's login prohibited? Default: false.
	 * @param   bool    $restricted                 Optional. Is the user restricted? Default: false.
	 * @param   string  $visibility                 Optional. The user's visibility setting. Default: ''.
	 * @param   string  $website                    Optional. The user's website. Default: ''.
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function edit(
		string $username,
		string $loginName,
		int $sourceId,
		bool $active = false,
		bool $admin = false,
		bool $allowCreateOrganization = false,
		bool $allowGitHook = false,
		bool $allowImportLocal = false,
		string $description = '',
		string $email = '',
		string $fullName = '',
		string $location = '',
		int $maxRepoCreation = 0,
		bool $mustChangePassword = false,
		string $password = '',
		bool $prohibitLogin = false,
		bool $restricted = false,
		string $visibility = '',
		string $website = ''
	): ?object
	{
		// Build the request path.
		$path = "/admin/users/{$username}";

		// Set the data.
		$data = [
			'login_name' => $loginName,
			'source_id' => $sourceId,
			'active' => $active,
			'admin' => $admin,
			'allow_create_organization' => $allowCreateOrganization,
			'allow_git_hook' => $allowGitHook,
			'allow_import_local' => $allowImportLocal,
			'description' => $description,
			'email' => $email,
			'full_name' => $fullName,
			'location' => $location,
			'max_repo_creation' => $maxRepoCreation,
			'must_change_password' => $mustChangePassword,
			'password' => $password,
			'prohibit_login' => $prohibitLogin,
			'restricted' => $restricted,
			'visibility' => $visibility,
			'website' => $website
		];

		// Send the patch request.
		return $this->response->get(
			$this->http->patch(
				$this->uri->get($path), json_encode($data)
			)
		);
	}

}

