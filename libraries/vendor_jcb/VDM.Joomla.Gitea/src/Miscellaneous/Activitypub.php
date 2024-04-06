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

namespace VDM\Joomla\Gitea\Miscellaneous;


use VDM\Joomla\Gitea\Abstraction\Api;


/**
 * The Gitea Miscellaneous Activitypub
 * 
 * @since 3.2.0
 */
class Activitypub extends Api
{
	/**
	 * Returns the Person actor for a user.
	 *
	 * @param   string  $username  The user's username.
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function get(string $username): ?object
	{
		// Build the request path.
		$path = "/activitypub/user/{$username}";

		// Send the GET request.
		return $this->response->get(
			$this->http->get(
				$this->uri->get($path)
			)
		);
	}

	/**
	 * Send to the user's inbox.
	 *
	 * @param   string  $username   The user's username.
	 * @param   object  $postData   The post data.
	 *
	 * @return  string
	 * @since   3.2.0
	 **/
	public function send(string $username, object $postData): string
	{
		// Build the request path.
		$path = "/activitypub/user/{$username}/inbox";

		// Send the POST request.
		return $this->response->get(
			$this->http->post(
				$this->uri->get($path), json_encode($postData)
			), 204, 'success'
		);
	}

}

