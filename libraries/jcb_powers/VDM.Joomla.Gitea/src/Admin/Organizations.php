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
 * The Gitea Admin Organizations
 * 
 * @since 3.2.0
 */
class Organizations extends Api
{
	/**
	 * List all organizations.
	 *
	 * @param   int  $page   Page number of results to return (1-based).
	 * @param   int  $limit  Page size of results.
	 *
	 * @return  array|null
	 * @since   3.2.0
	 **/
	public function list(int $page = 1, int $limit = 10): ?array
	{
		// Build the request path.
		$path = "/admin/orgs";

		// Set the query parameters.
		$uri = $this->uri->get($path);
		$uri->setVar('page', $page);
		$uri->setVar('limit', $limit);

		// Send the get request.
		return $this->response->get(
			$this->http->get($uri)
		);
	}

}

