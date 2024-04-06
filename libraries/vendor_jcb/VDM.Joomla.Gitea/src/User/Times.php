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
 * The Gitea User Times
 * 
 * @since 3.2.0
 */
class Times extends Api
{
	/**
	 * List the current user's tracked times.
	 *
	 * @param   int    $page    Page number of results to return (1-based).
	 * @param   int    $limit   Page size of results.
	 * @param   string|null $since   Optional. Only show times updated after the given time (RFC 3339 format).
	 * @param   string|null $before  Optional. Only show times updated before the given time (RFC 3339 format).
	 *
	 * @return  array|null
	 * @since   3.2.0
	 **/
	public function list(
		int $page = 1,
		int $limit = 10,
		?string $since = null,
		?string $before = null
	): ?array
	{
		// Build the request path.
		$path = '/user/times';

		// Build the URL
		$url = $this->uri->get($path);
		$url->setVar('page', $page);
		$url->setVar('limit', $limit);
		
		if ($since !== null) 
		{
			$url->setVar('since', $since);
		}
		
		if ($before !== null) 
		{
			$url->setVar('before', $before);
		}

		// Send the get request.
		return $this->response->get(
			$this->http->get($url)
		);
	}

	/**
	 * Get list of all existing stopwatches for the authenticated user.
	 *
	 * @param   int    $page    Page number of results to return (1-based).
	 * @param   int    $limit   Page size of results.
	 *
	 * @return  array|null
	 * @since   3.2.0
	 **/
	public function stopwatches(
		int $page = 1,
		int $limit = 10
	): ?array
	{
		// Build the request path.
		$path = '/user/stopwatches';

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

