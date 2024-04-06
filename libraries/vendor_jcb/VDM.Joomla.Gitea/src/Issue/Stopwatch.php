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
 * The Gitea Issue Stopwatch
 * 
 * @since 3.2.0
 */
class Stopwatch extends Api
{
	/**
	 * Start stopwatch on an issue.
	 *
	 * @param   string   $owner      The owner name.
	 * @param   string   $repo       The repo name.
	 * @param   int      $index      The issue index.
	 *
	 * @return  string
	 * @since   3.2.0
	 **/
	public function start(string $owner, string $repo, int $index): string
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/issues/{$index}/stopwatch/start";

		// Send the post request.
		return $this->response->get(
			$this->http->post(
				$this->uri->get($path), ''
			), 201, 'success'
		);
	}

	/**
	 * Stop an issue's existing stopwatch.
	 *
	 * @param   string   $owner      The owner name.
	 * @param   string   $repo       The repo name.
	 * @param   int      $index      The issue index.
	 *
	 * @return  string
	 * @since   3.2.0
	 **/
	public function stop(string $owner, string $repo, int $index): string
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/issues/{$index}/stopwatch/stop";

		// Send the post request.
		return $this->response->get(
			$this->http->post(
				$this->uri->get($path), ''
			), 201, 'success'
		);
	}

	/**
	 * Delete an issue's existing stopwatch.
	 *
	 * @param   string   $owner      The owner name.
	 * @param   string   $repo       The repo name.
	 * @param   int      $index      The issue index.
	 *
	 * @return  string
	 * @since   3.2.0
	 **/
	public function delete(string $owner, string $repo, int $index): string
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/issues/{$index}/stopwatch/delete";

		// Send the delete request.
		return $this->response->get(
			$this->http->delete(
				$this->uri->get($path)
			), 204, 'success'
		);
	}

}

