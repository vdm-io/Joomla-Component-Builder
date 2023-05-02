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
 * The Gitea Notifications Repository
 * 
 * @since 3.2.0
 */
class Repository extends Api
{
	/**
	 * List user's notification threads on a specific repo.
	 *
	 * @param   string   $owner           The owner name.
	 * @param   string   $repo            The repository name.
	 * @param   bool     $all             Show notifications marked as read.
	 * @param   array    $statusTypes     Show notifications with the provided status types.
	 * @param   array    $subjectTypes    Filter notifications by subject type.
	 * @param   string   $since           Show notifications updated after the given time.
	 * @param   string   $before          Show notifications updated before the given time.
	 * @param   int      $page            Page number of results to return (1-based).
	 * @param   int      $limit           Page size of results.
	 *
	 * @return  array|null
	 * @since   3.2.0
	 **/
	public function get(
		string $owner,
		string $repo,
		bool $all = false,
		array $statusTypes = [],
		array $subjectTypes = [],
		string $since = '',
		string $before = '',
		int $page = 1,
		int $limit = 10
	): ?array
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/notifications";

		// Configure the URI with query parameters.
		$uri = $this->uri->get($path);
		
		if ($all)
		{
			$uri->setVar('all', $all);
		}
		
		if (!empty($statusTypes))
		{
			$uri->setVar('status-types', implode(',', $statusTypes));
		}
		
		if (!empty($subjectTypes))
		{
			$uri->setVar('subject-type', implode(',', $subjectTypes));
		}
		
		if (!empty($since))
		{
			$uri->setVar('since', $since);
		}
		
		if (!empty($before))
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
	 * Mark notification threads as read, pinned, or unread on a specific repo.
	 *
	 * @param   string		$owner		The owner name.
	 * @param   string		$repo		The repository name.
	 * @param   bool|null	$all 			Mark all notifications on this repo (optional).
	 * @param   array|null	$statusTypes 	Mark notifications with the provided status types (optional).
	 * @param   string|null	$toStatus	Status to mark notifications as (optional).
	 * @param   string|null	$lastReadAt	Last point that notifications were checked (optional).
	 *
	 * @return  array|null
	 * @since   3.2.0
	 **/
	public function update(
		string $owner,
		string $repo,
		?bool $all = null,
		?array $statusTypes = null,
		?string $toStatus = null,
		?string $lastReadAt = null
	): ?array
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/notifications";

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
		if ($toStatus !== null)
		{
			$uri->setVar('to-status', $toStatus);
		}
		if ($lastReadAt !== null)
		{
			$uri->setVar('last_read_at', $lastReadAt);
		}

		// Send the put request.
		return $this->response->get(
			$this->http->put($uri, ''), 205
		);
	}

}

