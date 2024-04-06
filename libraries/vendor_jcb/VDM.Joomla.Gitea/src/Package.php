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
 * The Gitea Package
 * 
 * @since 3.2.0
 */
class Package extends Api
{
	/**
	 * Gets a package.
	 *
	 * @param   string   $owner    The owner of the package.
	 * @param   string   $type     The type of the package.
	 * @param   string   $name     The name of the package.
	 * @param   string   $version  The version of the package.
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function get(
		string $owner,
		string $type,
		string $name,
		string $version
	): ?object
	{
		// Build the request path.
		$path = "/packages/{$owner}/{$type}/{$name}/{$version}";

		// Send the get request.
		return $this->response->get(
			$this->http->get(
				$this->uri->get($path)
			)
		);
	}

	/**
	 * Delete a package.
	 *
	 * @param   string   $owner    The owner of the package.
	 * @param   string   $type     The type of the package.
	 * @param   string   $name     The name of the package.
	 * @param   string   $version  The version of the package.
	 *
	 * @return  string
	 * @since   3.2.0
	 **/
	public function delete(
		string $owner,
		string $type,
		string $name,
		string $version
	): string
	{
		// Build the request path.
		$path = "/packages/{$owner}/{$type}/{$name}/{$version}";

		// Send the delete request.
		return $this->response->get(
			$this->http->delete(
				$this->uri->get($path)
			), 204, 'success'
		);
	}

}

