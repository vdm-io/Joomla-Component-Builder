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
 * The Gitea Admin Unadopted
 * 
 * @since 3.2.0
 */
class Unadopted extends Api
{
	/**
	 * List unadopted repositories.
	 *
	 * @param   int    $page     Page number of results to return (1-based).
	 * @param   int    $limit    Page size of results.
	 * @param   string $pattern  Pattern of repositories to search for.
	 *
	 * @return  array|null
	 * @since   3.2.0
	 **/
	public function list(int $page = 1, int $limit = 10, string $pattern = ''): ?array
	{
		// Build the request path.
		$path = "/admin/unadopted";

		// Set the query parameters.
		$uri = $this->uri->get($path);
		$uri->setVar('page', $page);
		$uri->setVar('limit', $limit);

		if (!empty($pattern)) 
		{
			$uri->setVar('pattern', $pattern);
		}

		// Send the get request.
		return $this->response->get(
			$this->http->get($uri)
		);
	}

	/**
	 * Adopt unadopted files as a repository.
	 *
	 * @param   string  $owner  The owner name.
	 * @param   string  $repo   The repository name.
	 *
	 * @return  string
	 * @since   3.2.0
	 **/
	public function adopt(string $owner, string $repo): string
	{
		// Build the request path.
		$path = "/admin/unadopted/{$owner}/{$repo}";

		// Send the post request.
		return $this->response->get(
			$this->http->post(
				$this->uri->get($path), ''
			), 204, 'success'
		);
	}

	/**
	 * Delete unadopted files.
	 *
	 * @param   string  $owner  The owner name.
	 * @param   string  $repo   The repository name.
	 *
	 * @return  string
	 * @since   3.2.0
	 **/
	public function delete(string $owner, string $repo): string
	{
		// Build the request path.
		$path = "/admin/unadopted/{$owner}/{$repo}";

		// Send the delete request.
		return $this->response->get(
			$this->http->delete(
				$this->uri->get($path)
			), 204, 'success'
		);
	}

}

