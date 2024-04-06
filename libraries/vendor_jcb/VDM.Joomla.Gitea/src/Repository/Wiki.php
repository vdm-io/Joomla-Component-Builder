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
 * The Gitea Repository Wiki
 * 
 * @since 3.2.0
 */
class Wiki extends Api
{
	/**
	 * Create a wiki page.
	 *
	 * @param	string   $owner			The owner name.
	 * @param	string   $repo				The repository name.
	 * @param	string   $title				The title of the wiki page.
	 * @param	string   $contentBase64		The base64 encoded content of the wiki page.
	 * @param	string|null   $message		Optional commit message summarizing the change.
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function create(
		string $owner,
		string $repo,
		string $title,
		string $contentBase64,
		?string $message = null
	): ?object
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/wiki/new";

		// Set the wiki data.
		$data = new \stdClass();
		$data->title = $title;
		$data->content_base64 = $contentBase64;

		if ($message !== null)
		{
			$data->message = $message;
		}

		// Send the post request.
		return $this->response->get(
			$this->http->post(
				$this->uri->get($path),
				json_encode($data)
			), 201
		);
	}

	/**
	 * Get a wiki page.
	 *
	 * @param	string   $owner		The owner name.
	 * @param	string   $repo			The repository name.
	 * @param	string   $pageName	The name of the wiki page.
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function get(
		string $owner,
		string $repo,
		string $pageName
	): ?object
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/wiki/page/{$pageName}";

		// Set the URI.
		$uri = $this->uri->get($path);

		// Send the get request.
		return $this->response->get(
			$this->http->get($uri)
		);
	}

	/**
	 * Get all wiki pages.
	 *
	 * @param	string   $owner	The owner name.
	 * @param	string   $repo		The repository name.
	 * @param	int      $page		Page number of results to return (1-based).
	 * @param	int      $limit		Page size of results.
	 *
	 * @return  array|null
	 * @since   3.2.0
	 **/
	public function pages(
		string $owner,
		string $repo,
		int $page = 1,
		int $limit = 10
	): ?array
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/wiki/pages";

		// Set the URI.
		$uri = $this->uri->get($path);
		$uri->setVar('page', $page);
		$uri->setVar('limit', $limit);

		// Send the get request.
		return $this->response->get(
			$this->http->get($uri)
		);
	}

	/**
	 * Delete a wiki page.
	 *
	 * @param	string   $owner		The owner name.
	 * @param	string   $repo			The repository name.
	 * @param	string   $pageName	The name of the wiki page.
	 *
	 * @return  string
	 * @since   3.2.0
	 **/
	public function delete(
		string $owner,
		string $repo,
		string $pageName
	): string
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/wiki/page/{$pageName}";

		// Get the URI.
		$uri = $this->uri->get($path);

		// Send the delete request.
		return $this->response->get(
			$this->http->delete($uri), 204, 'success'
		);
	}

	/**
	 * Edit a wiki page.
	 *
	 * @param	string   $owner		The owner name.
	 * @param	string   $repo			The repository name.
	 * @param	string   $pageName	The name of the wiki page.
	 * @param	string   $title 			The new title of the wiki page.
	 * @param	string   $content		The new content of the wiki page.
	 * @param	string   $message		The optional commit message summarizing the change.
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function edit(
		string $owner,
		string $repo,
		string $pageName,
		string $title,
		string $content,
		string $message = null
	): ?object
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/wiki/page/{$pageName}";

		// Set the wiki data.
		$data = new \stdClass();
		$data->title = $title;
		$data->content_base64 = base64_encode($content);

		if ($message !== null)
		{
			$data->message = $message;
		}

		// Send the patch request.
		return $this->response->get(
			$this->http->patch(
				$this->uri->get($path),
				json_encode($data)
			)
		);
	}

	/**
	 * Get revisions of a wiki page.
	 *
	 * @param	string   $owner		The owner name.
	 * @param	string   $repo			The repository name.
	 * @param	string   $pageName	The name of the wiki page.
	 * @param	int      $page			The page number of results to return (1-based).
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function revisions(
		string $owner,
		string $repo,
		string $pageName,
		int $page = 1
	): ?object
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/wiki/revisions/{$pageName}";

		// Set the page number.
		$this->uri->setVar('page', $page);

		// Send the get request.
		return $this->response->get(
			$this->http->get(
				$this->uri->get($path)
			)
		);
	}

}

