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

namespace VDM\Joomla\Gitea\Issue;


use VDM\Joomla\Gitea\Abstraction\Api;


/**
 * The Gitea Issue Deadline
 * 
 * @since 3.2.0
 */
class Deadline extends Api
{
	/**
	 * Set an issue deadline.
	 *
	 * @param   string         $owner      The owner name.
	 * @param   string         $repo       The repo name.
	 * @param   int            $index      The issue index.
	 * @param   string|null    $dueDate    The deadline date string in the format YYYY-MM-DD or null to delete the deadline.
	 *
	 * @return  object
	 * @since   3.2.0
	 **/
	public function set(string $owner, string $repo, int $index, ?string $dueDate): object
	{
		// Build the request path.
		$path = "/repos/{$owner}/{$repo}/issues/{$index}/deadline";

		// Build the request data.
		$data = new \stdClass();
		$data->due_date = $dueDate;

		// Send the post request.
		return $this->response->get(
			$this->http->post(
				$this->uri->get($path), json_encode($data)
			)
		);
	}

}

