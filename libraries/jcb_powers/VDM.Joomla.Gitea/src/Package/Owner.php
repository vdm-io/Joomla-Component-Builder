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

namespace VDM\Joomla\Gitea\Package;


use VDM\Joomla\Gitea\Abstraction\Api;


/**
 * The Gitea Package Owner
 * 
 * @since 3.2.0
 */
class Owner extends Api
{
	/**
	 * Gets all packages of an owner.
	 *
	 * @param   string   $owner		The owner of the packages.
	 * @param   int      $page		Page number of results to return (1-based).
	 * @param   int      $limit			Page size of results.
	 * @param   string|null $type		Package type filter (optional).
	 * @param   string|null $name	Filter Name filter (optional).
	 *
	 * @return  array|null
	 * @since   3.2.0
	 **/
	public function get(
		string $owner,
		int $page = 1,
		int $limit = 10,
		?string $type = null,
		?string $nameFilter = null
	): ?array
	{
		// Build the request path.
		$path = "/packages/{$owner}";

		// Configure the URI with query parameters.
		$uri = $this->uri->get($path);
		$uri->setVar('page', $page);
		$uri->setVar('limit', $limit);
		if ($type !== null)
		{
			$uri->setVar('type', $type);
		}
		if ($nameFilter !== null)
		{
			$uri->setVar('q', $nameFilter);
		}

		// Send the get request.
		return $this->response->get(
			$this->http->get($uri)
		);
	}

}

