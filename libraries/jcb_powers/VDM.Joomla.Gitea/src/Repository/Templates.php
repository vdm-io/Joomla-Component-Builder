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
 * The Gitea Repository Templates
 * 
 * @since 3.2.0
 */
class Templates extends Api
{
	/**
	 * Get available issue templates for a repository.
	 *
	 * @param   string   $owner  The owner name.
	 * @param   string   $repo   The repository name.
	 *
	 * @return  array|null
	 * @since   3.2.0
	 **/
	public function issue(string $owner, string $repo): ?array
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/issue_templates";

		// Get the URI.
		$uri = $this->uri->get($path);

		// Send the GET request.
		return $this->response->get(
			$this->http->get($uri)
		);
	}

	/**
	 * Create a repository using a template.
	 *
	 * @param   string   $templateOwner  The template owner's name.
	 * @param   string   $templateRepo   The template repository name.
	 * @param   string   $name           The name of the new repository.
	 * @param   array    $options        Optional. Additional options for the new repository.
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function repo(
		string $templateOwner,
		string $templateRepo,
		string $name,
		array $options = []
	): ?object
	{
		// Build the request path.
		$path = "/repos/{$templateOwner}/{$templateRepo}/generate";

		// Set the repo data.
		$data = new \stdClass();
		$data->name = $name;

		foreach ($options as $key => $value)
		{
			if ($value !== null)
			{
				$data->{$key} = $value;
			}
		}

		// Send the post request.
		return $this->response->get(
			$this->http->post(
				$this->uri->get($path),
				json_encode($data)
			), 201
		);
	}

}

