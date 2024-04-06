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
 * The Gitea Issue Labels
 * 
 * @since 3.2.0
 */
class Labels extends Api
{
	/**
	 * Get all of a repository's labels.
	 *
	 * @param   string   $owner      The owner name.
	 * @param   string   $repo       The repo name.
	 * @param   int      $page       The page number of results to return (1-based).
	 * @param   int      $limit      The page size of results.
	 *
	 * @return  array|null
	 * @since   3.2.0
	 **/
	public function list(string $owner, string $repo, int $page = 1, int $limit = 10): ?array
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/labels";

		// Get the URI object with the request path.
		$uri = $this->uri->get($path);

		// Add the page and limit query parameters if provided.
		$uri->setVar('page', $page);
		$uri->setVar('limit', $limit);

		// Send the get request.
		return $this->response->get(
			$this->http->get($uri)
		);
	}

	/**
	 * Get an issue's labels.
	 *
	 * @param   string   $owner      The owner name.
	 * @param   string   $repo       The repo name.
	 * @param   int      $index      The issue index.
	 *
	 * @return  array|null
	 * @since   3.2.0
	 **/
	public function get(string $owner, string $repo, int $index): ?array
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/issues/{$index}/labels";

		// Send the get request.
		return $this->response->get(
			$this->http->get(
				$this->uri->get($path)
			)
		);
	}

	/**
	 * Replace an issue's labels.
	 *
	 * @param   string         $owner      The owner name.
	 * @param   string         $repo       The repo name.
	 * @param   int            $index      The issue index.
	 * @param   array          $labels     An array of labels to replace the current issue labels.
	 *
	 * @return  object
	 * @since   3.2.0
	 **/
	public function replace(string $owner, string $repo, int $index, array $labels): object
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/issues/{$index}/labels";

		// Build the request data.
		$data = new \stdClass();
		$data->labels = $labels;

		// Send the put request.
		return $this->response->get(
			$this->http->put(
				$this->uri->get($path), json_encode($data)
			)
		);
	}

	/**
	 * Add a label to an issue.
	 *
	 * @param   string   $owner      The owner name.
	 * @param   string   $repo       The repo name.
	 * @param   int      $index      The issue index.
	 * @param   array    $labels     An array of label IDs to add.
	 *
	 * @return  array|null
	 * @since   3.2.0
	 **/
	public function add(string $owner, string $repo, int $index, array $labels): ?array
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/issues/{$index}/labels";

		// Build the request data.
		$data = new \stdClass();
		$data->labels = $labels;

		// Send the post request.
		return $this->response->get(
			$this->http->post(
				$this->uri->get($path), json_encode($data)
			)
		);
	}

	/**
	 * Remove a label from an issue.
	 *
	 * @param   string   $owner      The owner name.
	 * @param   string   $repo       The repo name.
	 * @param   int      $index      The issue index.
	 * @param   int      $labelId    The ID of the label to remove.
	 *
	 * @return  string
	 * @since   3.2.0
	 **/
	public function remove(string $owner, string $repo, int $index, int $labelId): string
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/issues/{$index}/labels/{$labelId}";

		// Send the delete request.
		return $this->response->get(
			$this->http->delete(
				$this->uri->get($path)
			), 204, 'success'
		);
	}

	/**
	 * Remove all labels from an issue.
	 *
	 * @param   string   $owner      The owner name.
	 * @param   string   $repo       The repo name.
	 * @param   int      $index      The issue index.
	 *
	 * @return  string
	 * @since   3.2.0
	 **/
	public function clear(string $owner, string $repo, int $index): string
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/issues/{$index}/labels";

		// Send the delete request.
		return $this->response->get(
			$this->http->delete(
				$this->uri->get($path)
			), 204, 'success'
		);
	}

}

