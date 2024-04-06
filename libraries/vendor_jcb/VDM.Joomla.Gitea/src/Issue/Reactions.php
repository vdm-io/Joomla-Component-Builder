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

namespace VDM\Joomla\Gitea\Issue;


use VDM\Joomla\Gitea\Abstraction\Api;


/**
 * The Gitea Issue Reactions
 * 
 * @since 3.2.0
 */
class Reactions extends Api
{
	/**
	 * Get a list reactions of an issue.
	 *
	 * @param   string      $owner      The owner name.
	 * @param   string      $repo       The repo name.
	 * @param   int         $index      The issue index.
	 * @param   int         $page       The page to get, defaults to 1.
	 * @param   int         $limit      The number of reactions per page, defaults to 10.
	 *
	 * @return  array|null
	 * @since   3.2.0
	 **/
	public function list(string $owner, string $repo, int $index, int $page = 1, int $limit = 10): ?array
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/issues/{$index}/reactions";

		// Build the URI.
		$uri = $this->uri->get($path);

		// Set the URI variables.
		$uri->setVar('page', $page);
		$uri->setVar('limit', $limit);

		// Send the get request.
		return $this->response->get(
			$this->http->get($uri)
		);
	}

	/**
	 * Add a reaction to an issue.
	 *
	 * @param   string   $owner      The owner name.
	 * @param   string   $repo       The repo name.
	 * @param   int      $index      The issue index.
	 * @param   string   $content    The name of the reaction to add.
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function add(string $owner, string $repo, int $index, string $content): ?object
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/issues/{$index}/reactions";

		// Build the request data.
		$data = new \stdClass();
		$data->content = $content;

		// Send the post request.
		return $this->response->get(
			$this->http->post(
				$this->uri->get($path), json_encode($data)
			)
		);
	}

	/**
	 * Remove a reaction from an issue.
	 *
	 * @param   string   $owner      The owner name.
	 * @param   string   $repo       The repo name.
	 * @param   int      $index      The issue index.
	 * @param   string   $content    The name of the reaction to remove.
	 *
	 * @return  string
	 * @since   3.2.0
	 **/
	public function remove(string $owner, string $repo, int $index, string $content): string
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/issues/{$index}/reactions";

		// Build the URI.
		$uri = $this->uri->get($path);
		$uri->setVar('content', $content);

		// Send the delete request.
		return $this->response->get(
			$this->http->delete($uri), 200, 'success'
		);
	}

}

