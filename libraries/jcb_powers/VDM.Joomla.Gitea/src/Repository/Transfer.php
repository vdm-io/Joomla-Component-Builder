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
 * The Gitea Repository Transfer
 * 
 * @since 3.2.0
 */
class Transfer extends Api
{
	/**
	 * Transfer a repo ownership.
	 *
	 * @param	string   $owner		The current owner name.
	 * @param	string   $repo			The repository name.
	 * @param	string   $newOwner		The new owner's name.
	 * @param	array|null $teamIDs		Optional. The IDs of the teams that will be granted access.
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function create(
		string $owner,
		string $repo,
		string $newOwner,
		?array $teamIDs = null
	): ?object
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/transfer";

		// Set the transfer data.
		$data = new \stdClass();
		$data->new_owner = $newOwner;
		if ($teamIDs !== null)
		{
			$data->team_ids = $teamIDs;
		}

		// Send the post request.
		return $this->response->get(
			$this->http->post(
				$this->uri->get($path),
				json_encode($data)
			), 202
		);
	}

	/**
	 * Accept a repo transfer.
	 *
	 * @param	string   $owner	The owner name.
	 * @param	string   $repo		The repository name.
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function accept(string $owner, string $repo): ?object
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/transfer/accept";

		// Send the post request.
		return $this->response->get(
			$this->http->post(
				$this->uri->get($path)
			), 202
		);
	}

	/**
	 * Reject a repo transfer.
	 *
	 * @param	string   $owner	The owner name.
	 * @param	string   $repo		The repository name.
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function reject(string $owner, string $repo): ?object
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/transfer/reject";

		// Send the post request.
		return $this->response->get(
			$this->http->post(
				$this->uri->get($path)
			)
		);
	}

}

