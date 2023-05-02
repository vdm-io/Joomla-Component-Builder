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
 * The Gitea Repository Attachments
 * 
 * @since 3.2.0
 */
class Attachments extends Api
{
	/**
	 * List release's attachments.
	 *
	 * @param	string   $ownerName	The owner name.
	 * @param	string   $repoName		The repository name.
	 * @param	int      $releaseId		The release ID.
	 *
	 * @return  array|null
	 * @since   3.2.0
	 **/
	public function list(
		string $ownerName,
		string $repoName,
		int $releaseId
	): ?array
	{
		// Build the request path.
		$path = "/repos/{$ownerName}/{$repoName}/releases/{$releaseId}/assets";

		// Retrieve the URI object with the path.
		$uri = $this->uri->get($path);

		// Send the get request.
		return $this->response->get(
			$this->http->get($uri)
		);
	}

	/**
	 * Create a release attachment.
	 *
	 * @param	string   $ownerName		The owner name.
	 * @param	string   $repoName			The repository name.
	 * @param	int      $releaseId			The release ID.
	 * @param	string   $attachmentFile		The attachment file content.
	 * @param	string   $attachmentName	The attachment file name.
	 * @param	string   $contentType		The attachment content type.
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function create(
		string $ownerName,
		string $repoName,
		int $releaseId,
		string $attachmentFile,
		string $attachmentName,
		string $contentType
	): ?object
	{
		// Build the request path.
		$path = "/repos/{$ownerName}/{$repoName}/releases/{$releaseId}/assets";

		// Retrieve the URI object with the path.
		$uri = $this->uri->get($path);

		// Add the attachment name as a query parameter.
		$uri->setVar('name', $attachmentName);

		// Set the request headers.
		$headers = [
			"Content-Type: {$contentType}",
			"Content-Disposition: attachment; filename={$attachmentName}"
		];

		// Send the post request.
		return $this->response->get(
			$this->http->post(
				$uri, $attachmentFile, $headers
			), 201
		);
	}

	/**
	 * Get a release attachment.
	 *
	 * @param	string   $owner		The owner name.
	 * @param	string   $repo			The repository name.
	 * @param	int      $id				The release ID.
	 * @param	int      $attachmentId	The attachment ID.
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function get(
		string $owner,
		string $repo,
		int $id,
		int $attachmentId
	): ?object
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/releases/{$id}/assets/{$attachmentId}";

		// Send the get request.
		return $this->response->get(
			$this->http->get(
				$this->uri->get($path)
			)
		);
	}

	/**
	 * Delete a release attachment.
	 *
	 * @param	string   $owner		The owner name.
	 * @param	string   $repo			The repository name.
	 * @param	int      $id				The release ID.
	 * @param	int      $attachmentId	The attachment ID.
	 *
	 * @return  string
	 * @since   3.2.0
	 **/
	public function delete(
		string $owner,
		string $repo,
		int $id,
		int $attachmentId
	): string
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/releases/{$id}/assets/{$attachmentId}";

		// Send the delete request.
		return $this->response->get(
			$this->http->delete(
				$this->uri->get($path)
			), 204, 'success'
		);
	}

	/**
	 * Edit a release attachment.
	 *
	 * @param	string       $owner		The owner name.
	 * @param	string       $repo		The repository name.
	 * @param	int          $id			The release ID.
	 * @param	int          $attachmentId	The attachment ID.
	 * @param	string|null  $name		The new name of the attachment (optional).
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function edit(
		string $owner,
		string $repo,
		int $id,
		int $attachmentId,
		?string $name = null
	): ?object
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/releases/{$id}/assets/{$attachmentId}";

		// Set the attachment data
		$data = new \stdClass();

		if ($name !== null)
		{
			$data->name = $name;
		}

		// Send the patch request.
		return $this->response->get(
			$this->http->patch(
				$this->uri->get($path), json_encode($data)
			)
		);
	}

}

