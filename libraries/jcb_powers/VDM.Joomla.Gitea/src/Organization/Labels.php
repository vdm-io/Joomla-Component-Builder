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

namespace VDM\Joomla\Gitea\Organization;


use VDM\Joomla\Gitea\Abstraction\Api;


/**
 * The Gitea Organization Labels
 * 
 * @since 3.2.0
 */
class Labels extends Api
{
	/**
	 * List an organization's labels.
	 *
	 * @param   string  $orgName   The organization name.
	 * @param   int     $pageNum    Page number of results to return (1-based).
	 * @param   int     $pageSize   Page size of results.
	 *
	 * @return  array|null
	 * @since   3.2.0
	 **/
	public function list(
		string $orgName,
		int $pageNum = 1,
		int $pageSize = 10
	): ?array
	{
		// Build the request path.
		$path = "/orgs/{$orgName}/labels";

		// Build the URL
		$url = $this->uri->get($path);
		$url->setVar('page', $pageNum);
		$url->setVar('limit', $pageSize);

		// Send the get request.
		return $this->response->get(
			$this->http->get($url)
		);
	}

	/**
	 * Create a label for an organization.
	 *
	 * @param   string   $org       The organization name.
	 * @param   string   $name      The name of the label.
	 * @param   string   $color     The color of the label.
	 * @param   string   $description Optional. The description of the label.
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function create(
		string $org,
		string $name,
		string $color,
		string $description = ''
	): ?object
	{
		// Set the lines data
		$data = new \stdClass();
		$data->name = $name;
		$data->color = $color;
		$data->description = $description;

		// Build the request path.
		$path = "/orgs/{$org}/labels";

		// Send the post request.
		return $this->response->get(
			$this->http->post(
				$this->uri->get($path),
				json_encode($data)
			), 201
		);
	}

	/**
	 * Get a single label for an organization.
	 *
	 * @param   string   $org   The organization name.
	 * @param   int      $id    The ID of the label.
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function get(string $org, int $id): ?object
	{
		// Build the request path.
		$path = "/orgs/{$org}/labels/{$id}";

		// Send the get request.
		return $this->response->get(
			$this->http->get(
				$this->uri->get($path)
			)
		);
	}

	/**
	 * Delete a label for an organization.
	 *
	 * @param   string   $org   The organization name.
	 * @param   int      $id    The ID of the label.
	 *
	 * @return  string
	 * @since   3.2.0
	 **/
	public function delete(string $org, int $id): string
	{
		// Build the request path.
		$path = "/orgs/{$org}/labels/{$id}";

		// Send the delete request.
		return $this->response->get(
			$this->http->delete(
				$this->uri->get($path)
			), 204, 'success'
		);
	}

	/**
	 * Update a label for an organization.
	 *
	 * @param   string   $org           The organization name.
	 * @param   int      $id            The ID of the label.
	 * @param   string   $name          Optional. The name of the label.
	 * @param   string   $color         Optional. The color of the label.
	 * @param   string   $description   Optional. The description of the label.
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function update(
		string $org,
		int $id,
		string $name = '',
		string $color = '',
		string $description = ''
	): ?object
	{
		// Set the lines data
		$data = new \stdClass();

		if ($name) {
			$data->name = $name;
		}

		if ($color) {
			$data->color = $color;
		}

		if ($description) {
			$data->description = $description;
		}

		// Build the request path.
		$path = "/orgs/{$org}/labels/{$id}";

		// Send the patch request.
		return $this->response->get(
			$this->http->patch(
				$this->uri->get($path),
				json_encode($data)
			)
		);
	}

}

