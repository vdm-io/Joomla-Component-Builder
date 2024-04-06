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
 * The Gitea Notifications
 * 
 * @since 3.2.0
 */
class Notifications extends Api
{
	/**
	 * List user's notification threads.
	 *
	 * @param   bool|null	$all			Show notifications marked as read (optional).
	 * @param   array|null	$statusTypes	Show notifications with the provided status types (optional).
	 * @param   array|null	$subjectType	Filter notifications by subject type (optional).
	 * @param   string|null	$since		Show notifications updated after the given time (optional).
	 * @param   string|null	$before		Show notifications updated before the given time (optional).
	 * @param   int		$page		Page number of results to return (optional).
	 * @param   int		$limit		Page size of results (optional).
	 *
	 * @return  array|null
	 * @since   3.2.0
	 **/
	public function list(
		?bool $all = null,
		?array $statusTypes = null,
		?array $subjectType = null,
		?string $since = null,
		?string $before = null,
		int $page = 1,
		int $limit = 10
	): ?array
	{
		// Build the request path.
		$path = "/notifications";

		// Configure the URI with query parameters.
		$uri = $this->uri->get($path);
		if ($all !== null)
		{
			$uri->setVar('all', $all);
		}
		if ($statusTypes !== null)
		{
			$uri->setVar('status-types', implode(',', $statusTypes));
		}
		if ($subjectType !== null)
		{
			$uri->setVar('subject-type', implode(',', $subjectType));
		}
		if ($since !== null)
		{
			$uri->setVar('since', $since);
		}
		if ($before !== null)
		{
			$uri->setVar('before', $before);
		}
		$uri->setVar('page', $page);
		$uri->setVar('limit', $limit);

		// Send the get request.
		return $this->response->get(
			$this->http->get($uri)
		);
	}

	/**
	 * Mark notification threads as read, pinned, or unread.
	 *
	 * @param   string|null      $lastReadAt   Describes the last point that notifications were checked (optional).
	 * @param   bool|null        $all          If true, mark all notifications on this repo (optional).
	 * @param   array|null       $statusTypes  Mark notifications with the provided status types (optional).
	 * @param   string|null      $toStatus     Status to mark notifications as (optional).
	 *
	 * @return  array|null
	 * @since   3.2.0
	 **/
	public function update(
		?string $lastReadAt = null,
		?bool $all = null,
		?array $statusTypes = null,
		?string $toStatus = null
	): ?array
	{
		// Build the request path.
		$path = "/notifications";

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

	/**
	 * Check if unread notifications exist.
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function check(): ?object
	{
		// Build the request path.
		$path = "/notifications/new";

		// Send the get request.
		return $this->response->get(
			$this->http->get(
				$this->uri->get($path)
			)
		);
	}

}

