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
 * The Gitea Repository Remote
 * 
 * @since 3.2.0
 */
class Remote extends Api
{
	/**
	 * Migrate a remote git repository.
	 *
	 * @param   string  $cloneAddr       The URL to clone the repository from.
	 * @param   string  $repoName        The desired name for the new repository.
	 * @param   string  $repoOwner       The name of the user or organization who will own the repo after migration.
	 * @param   string  $uid             The ID of the user that will own the new repository (deprecated).
	 * @param   string  $description     The description for the new repository (optional).
	 * @param   bool    $private         Set the repository to private (optional, default false).
	 * @param   string|null  $authToken  Authentication token (optional).
	 * @param   string|null  $authUsername  Authentication username (optional).
	 * @param   string|null  $authPassword  Authentication password (optional).
	 * @param   array   $options         Additional migration options (optional).
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function migrate(
		string $cloneAddr,
		string $repoName,
		string $repoOwner,
		string $uid,
		string $description = '',
		bool $private = false,
		?string $authToken = null,
		?string $authUsername = null,
		?string $authPassword = null,
		array $options = []
	): ?object
	{
		// Build the request path.
		$path = "/repos/migrate";

		// Set the repository migration data.
		$data = new \stdClass();
		$data->cloneAddr = $cloneAddr;
		$data->repoName = $repoName;
		$data->repoOwner = $repoOwner;
		$data->uid = $uid;
		$data->description = $description;
		$data->private = $private;

		if ($authToken !== null)
		{
			$data->authToken = $authToken;
		}

		if ($authUsername !== null)
		{
			$data->authUsername = $authUsername;
		}

		if ($authPassword !== null)
		{
			$data->authPassword = $authPassword;
		}

		foreach ($options as $key => $val)
		{
			$data->{$key} = $val;
		}

		// Send the post request.
		return $this->response->get(
			$this->http->post(
				$this->uri->get($path), json_encode($data)
			), 201
		);
	}

}

