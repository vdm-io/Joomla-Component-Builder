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

namespace VDM\Joomla\Gitea;


use VDM\Joomla\Gitea\Abstraction\Api;


/**
 * The Gitea Labels
 * 
 * @since 3.2.0
 */
class Labels extends Api
{
	/**
	 * Create a label.
	 *
	 * @param   string   $owner            The owner name.
	 * @param   string   $repo             The repo name.
	 * @param   string   $labelName        The name of the label.
	 * @param   string   $labelColor       The color of the label, in hexadecimal format with the leading '#'.
	 * @param   string   $labelDescription Optional. The description of the label.
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function create(string $owner, string $repo, string $labelName, string $labelColor, string $labelDescription = ''): ?object
	{
		// Set the lines data
		$data = new \stdClass();

		// Set all the needed data.
		$data->name = $labelName;
		$data->color = $labelColor;
		if (!empty($labelDescription))
		{
			$data->description = $labelDescription;
		}

		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/labels";

		// Send the post request.
		return $this->response->get(
			$this->http->post(
				$this->uri->get($path),
				json_encode($data)
			), 201
		);
	}

	/**
	 * Get a single label.
	 *
	 * @param   string   $owner      The owner name.
	 * @param   string   $repo       The repo name.
	 * @param   string   $id         The ID of the label to retrieve.
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function get(string $owner, string $repo, string $id): ?object
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/labels/{$id}";

		// Send the get request.
		return $this->response->get(
			$this->http->get(
				$this->uri->get($path)
			)
		);
	}

	/**
	 * Delete a label.
	 *
	 * @param   string   $owner      The owner name.
	 * @param   string   $repo       The repo name.
	 * @param   string   $id         The ID of the label to delete.
	 *
	 * @return  string
	 * @since   3.2.0
	 **/
	public function delete(string $owner, string $repo, string $id): string
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/labels/{$id}";

		// Send the delete request.
		return $this->response->get(
			$this->http->delete(
				$this->uri->get($path)
			), 204, 'success'
		);
	}

	/**
	 * Update a label.
	 *
	 * @param   string   $owner              The owner name.
	 * @param   string   $repo               The repo name.
	 * @param   string   $id                 The ID of the label to update.
	 * @param   string   $labelName          Optional. The new name of the label.
	 * @param   string   $labelColor         Optional. The new color of the label, in hexadecimal format without the leading '#'.
	 * @param   string   $labelDescription   Optional. The new description of the label.
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function update(
		string $owner,
		string $repo,
		string $id,
		string $labelName = '',
		string $labelColor = '',
		string $labelDescription = ''
	): ?object
	{
		// Set the lines data
		$data = new \stdClass();

		// Set all the optional data that has been provided.
		if (!empty($labelName))
		{
			$data->name = $labelName;
		}

		if (!empty($labelColor))
		{
			$data->color = $labelColor;
		}

		if (!empty($labelDescription))
		{
			$data->description = $labelDescription;
		}

		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/labels/{$id}";

		// Send the patch request.
		return $this->response->get(
			$this->http->patch(
				$this->uri->get($path),
				json_encode($data)
			)
		);
	}

}

