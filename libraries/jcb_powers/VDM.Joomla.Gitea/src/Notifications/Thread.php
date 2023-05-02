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

namespace VDM\Joomla\Gitea\Notifications;


use VDM\Joomla\Gitea\Abstraction\Api;


/**
 * The Gitea Notifications Thread
 * 
 * @since 3.2.0
 */
class Thread extends Api
{
	/**
	 * Get notification thread by ID.
	 *
	 * @param   int   $id  The notification thread ID.
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function get(int $id): ?object
	{
		// Build the request path.
		$path = "/notifications/threads/{$id}";

		// Get the URI with the path.
		$uri = $this->uri->get($path);

		// Send the get request.
		return $this->response->get(
			$this->http->get($uri)
		);
	}

	/**
	 * Mark notification threads as read, pinned, or unread by ID.
	 *
	 * @param   int           $id          The notification thread ID.
	 * @param   string|null   $lastReadAt  Last point that notifications were checked (optional).
	 * @param   bool|null     $all         Mark all notifications on this repo (optional).
	 * @param   array|null    $statusTypes Mark notifications with the provided status types (optional).
	 * @param   string|null   $toStatus    Status to mark notifications as (optional).
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function mark(
		int $id,
		?string $lastReadAt = null,
		?bool $all = null,
		?array $statusTypes = null,
		?string $toStatus = null
	): ?object
	{
		// Build the request path.
		$path = "/notifications/threads/{$id}";

		// Configure the URI with query parameters.
		$uri = $this->uri->get($path);
		if ($lastReadAt !== null)
		{
			$uri->setVar('last_read_at', $lastReadAt);
		}
		if ($all !== null)
		{
			$uri->setVar('all', $all);
		}
		if ($statusTypes !== null)
		{
			$uri->setVar('status-types', implode(',', $statusTypes));
		}
		if ($toStatus !== null)
		{
			$uri->setVar('to-status', $toStatus);
		}

		// Send the put request.
		return $this->response->get(
			$this->http->put($uri, ''), 205
		);
	}

}

