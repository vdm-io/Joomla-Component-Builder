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
	public function get(JoomlaResponse $response, int  $expectedCode = 200, $default = null)
	{
		// Validate the response code.
		$code = method_exists($response, 'getStatusCode')
			? (string) $response->getStatusCode()
			: ($response->code ?? null);

		if ($code != $expectedCode)
		{
			// Decode the error response and throw an exception.
			$message =  $this->error($response);

			throw new \DomainException("Invalid response received from Gitea API. $message", $code);
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
	public function get_(JoomlaResponse $response, array $validate = [200 => null])
	{
		// Validate the response code.
		$code = method_exists($response, 'getStatusCode')
			? (string) $response->getStatusCode()
			: ($response->code ?? null);

		if (!isset($validate[$code]))
		{
			// Decode the error response and throw an exception.
			$message =  $this->error($response);

			throw new \DomainException("Invalid response received from Gitea API. $message", $code);
		}

		return $this->body($response, $validate[$code]);
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
	protected function body(JoomlaResponse $response, $default = null)
	{
		// check that we have a body
		$body = is_object($response) && method_exists($response, 'getBody')
			? (string) $response->getBody()
			: (isset($response->body) ? (string) $response->body : null);

		if ($body !== null && StringHelper::check($body))
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
	 * Extract an error message from a response object.
	 *
	 * @param   JoomlaResponse  $response  The response object.
	 *
	 * @return  string  The extracted error message, or an empty string.
	 * @since   3.2.0
	 */
	protected function error(JoomlaResponse $response): string
	{
		// Try to get the raw response body
		$body = method_exists($response, 'getBody') ? (string) $response->getBody() : '';

		// Try to decode as JSON object
		$errorData = JsonHelper::check($body) ? json_decode($body) : null;

		if (is_object($errorData))
		{
			// Try to extract a useful error field
			if (!empty($errorData->error))
			{
				return $errorData->error;
			}

			if (!empty($errorData->message))
			{
				return $errorData->message;
			}

			// Fallback to a serialized message
			return json_encode($errorData, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
		}

		// Fallback to reason phrase or body
		if (!empty($body))
		{
			return $body;
		}

		// Try getting the reason phrase from response
		if (method_exists($response, 'getReasonPhrase'))
		{
			return $response->getReasonPhrase();
		}

		return 'No error information found in Gitea API response.';
	}
}

