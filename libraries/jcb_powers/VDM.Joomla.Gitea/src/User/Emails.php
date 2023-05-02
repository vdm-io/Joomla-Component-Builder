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
 * The Gitea User Emails
 * 
 * @since 3.2.0
 */
class Emails extends Api
{
	/**
	 * List the authenticated user's email addresses.
	 *
	 * @return  array|null
	 * @since   3.2.0
	 **/
	public function list(): ?array
	{
		// Build the request path.
		$path = '/user/emails';

		// Send the get request.
		return $this->response->get(
			$this->http->get(
				$this->uri->get($path)
			)
		);
	}

	/**
	 * Add email addresses for the authenticated user.
	 *
	 * @param   array   $emails   An array of email addresses to add.
	 *
	 * @return  array|null
	 * @since   3.2.0
	 **/
	public function add(array $emails): ?array
	{
		// Build the request path.
		$path = '/user/emails';

		// Create the request body.
		$body = new \stdClass();
		$body->emails = $emails;

		// Send the post request.
		return $this->response->get(
			$this->http->post(
				$this->uri->get($path),
				json_encode($body)
			), 201
		);
	}

	/**
	 * Delete email addresses for the authenticated user.
	 *
	 * @param   array   $$emails   An array of email addresses to delete.
	 *
	 * @return  string
	 * @since   3.2.0
	 **/
	public function delete(array $emails): string
	{
		// Build the request path.
		$path = '/user/emails';

		// Build the URI.
		$uri = $this->uri->get($path);
		$uri->setVar('emails', json_encode($emails));

		// Send the delete request.
		return $this->response->get(
			$this->http->delete($uri), 204, 'success'
		);
	}

}

