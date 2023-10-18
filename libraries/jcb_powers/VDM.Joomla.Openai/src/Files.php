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

namespace VDM\Joomla\Openai;


use VDM\Joomla\Openai\Abstraction\Api;


/**
 * The Openai Files
 * 
 * @since 3.2.0
 */
class Files extends Api
{
	/**
	 * Fetches a list of files belonging to the user's organization.
	 *  API Ref: https://platform.openai.com/docs/api-reference/files/list
	 *
	 * @return  object|null  The response from the OpenAI API, or null if an error occurred.
	 * @since   3.2.0
	 */
	public function list(): ?object
	{
		// Build the request path.
		$path = "/files";
		
		// Prepare the URI.
		$uri = $this->uri->get($path);

		// Send the GET request.
		return $this->response->get(
			$this->http->get($uri)
		);
	}

	/**
	 * Upload a file that contains document(s) to be used across various endpoints/features.
	 *  API Ref: https://platform.openai.com/docs/api-reference/files/upload
	 *
	 * @param   string     $file          The file to upload.
	 * @param   string     $purpose       The intended purpose of the uploaded documents.
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function upload(string $file, string $purpose): ?object
	{
		// Build the request path.
		$path = "/files";

		// Set the request data.
		$data = new \stdClass();
		$data->file = $file;
		$data->purpose = $purpose;

		// Send the post request.
		return $this->response->get(
			$this->http->post(
				$this->uri->get($path), json_encode($data)
			)
		);
	}

	/**
	 * Returns information about a specific file.
	 *  API Ref: https://platform.openai.com/docs/api-reference/files/retrieve
	 *
	 * @param   string     $fileID     The file id to retrieve info
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function info(string $fileID): ?object
	{
		// Build the request path.
		$path = "/files/{$fileID}";

		// Send the post request.
		return $this->response->get(
			$this->http->get(
				$this->uri->get($path)
			)
		);
	}

	/**
	 * Retrieve a specific file content.
	 *  API Ref: https://platform.openai.com/docs/api-reference/files/retrieve-content
	 *
	 * @param   string     $fileID     The file id to retrieve content
	 *
	 * @return  mixed
	 * @since   3.2.0
	 **/
	public function content(string $fileID)
	{
		// Build the request path.
		$path = "/files/{$fileID}/content";

		// Send the post request.
		return $this->response->get(
			$this->http->get(
				$this->uri->get($path)
			)
		);
	}

	/**
	 * Delete a file.
	 *  API Ref: https://platform.openai.com/docs/api-reference/files/delete
	 *
	 * @param   string     $fileID        The file id to delete
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function delete(string $fileID): ?object
	{
		// Build the request path.
		$path = "/files/{$fileID}";

		// Send the post request.
		return $this->response->get(
			$this->http->delete(
				$this->uri->get($path)
			)
		);
	}
}

