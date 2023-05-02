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

namespace VDM\Joomla\Gitea\User;


use VDM\Joomla\Gitea\Abstraction\Api;


/**
 * The Gitea User Teams
 * 
 * @since 3.2.0
 */
class Teams extends Api
{
	/**
	 * List all the teams a user belongs to.
	 *
	 * @param   int    $page    Page number of results to return (1-based).
	 * @param   int    $limit   Page size of results.
	 *
	 * @return  array|null
	 * @since   3.2.0
	 **/
	public function list(
		int $page = 1,
		int $limit = 10
	): ?array
	{
		// Build the request path.
		$path = '/user/teams';

		// Build the URL
		$url = $this->uri->get($path);
		$url->setVar('page', $page);
		$url->setVar('limit', $limit);

		// Send the get request.
		return $this->response->get(
			$this->http->get($url)
		);
	}

}

