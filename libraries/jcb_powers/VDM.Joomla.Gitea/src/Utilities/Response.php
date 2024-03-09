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

namespace VDM\Joomla\Gitea\Utilities;


use Joomla\Http\Response as JoomlaResponse;
use VDM\Joomla\Utilities\JsonHelper;
use VDM\Joomla\Utilities\StringHelper;


/**
 * The Gitea Response
 * 
 * @since 3.2.0
 */
final class Response
{
	/**
	 * Process the response and decode it.
	 *
	 * @param   JoomlaResponse  $response      The response.
	 * @param   integer         $expectedCode  The expected "good" code.
	 * @param   mixed           $default       The default if body not have length
	 *
	 * @return  mixed
	 *
	 * @since   3.2.0
	 * @throws  \DomainException
	 **/
	public function get($response, int  $expectedCode = 200, $default = null)
	{
		// Validate the response code.
		if ($response->code != $expectedCode)
		{
			// Decode the error response and throw an exception.
			$message =  $this->error($response);

			throw new \DomainException("Invalid response received from API. $message", $response->code);

		}

		return $this->body($response, $default);
	}

	/**
	 * Process the response and decode it. (when we have multiple success codes)
	 *
	 * @param   JoomlaResponse  $response                    The response.
	 * @param   array           [$expectedCode => $default]  The expected "good" code. and The default if body not have length
	 *
	 * @return  mixed
	 *
	 * @since   3.2.0
	 * @throws  \DomainException
	 **/
	public function get_($response, array $validate = [200 => null])
	{
		// Validate the response code.
		if (!isset($validate[$response->code]))
		{
			// Decode the error response and throw an exception.
			$message =  $this->error($response);

			throw new \DomainException("Invalid response received from API. $message", $response->code);

		}

		return $this->body($response, $validate[$response->code]);
	}

	/**
	 * Return the body from the response
	 *
	 * @param   JoomlaResponse  $response    The response.
	 * @param   mixed           $default     The default if body not have length
	 *
	 * @return  mixed
	 * @since   3.2.0
	 **/
	protected function body($response, $default = null)
	{
		$body = $response->body ?? null;
		// check that we have a body
		if (StringHelper::check($body))
		{
			if (JsonHelper::check($body))
			{
				$body = json_decode((string) $body);

				if (isset($body->content_base64))
				{
					$body->content = base64_decode((string) $body->content_base64);
				}
			}

			return $body;
		}

		return $default;
	}

	/**
	 * Get the error message from the return object
	 *
	 * @param   JoomlaResponse  $response   The response.
	 *
	 * @return  string
	 * @since   3.2.0
	 **/
	protected function error($response): string
	{
		// do we have a json string
		if (isset($response->body) && JsonHelper::check($response->body))
		{
			$error = json_decode($response->body);
		}
		else
		{
			return '';
		}

		// check
		if (isset($error->error))
		{
			return $error->error;
		}
		elseif (isset($error->message))
		{
			return $error->message;
		}

		return '';
	}
}

