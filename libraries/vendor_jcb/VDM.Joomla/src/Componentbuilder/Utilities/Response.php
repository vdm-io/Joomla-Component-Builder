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

namespace VDM\Joomla\Componentbuilder\Utilities;


use Joomla\Http\Response as JoomlaResponse;
use VDM\Joomla\Utilities\JsonHelper;
use VDM\Joomla\Utilities\StringHelper;


/**
 * The Response
 * 
 * @since 2.0.1
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
	 * @since   2.0.1
	 * @throws  \DomainException
	 **/
	public function get(JoomlaResponse $response, int  $expectedCode = 200, $default = null)
	{
		// Validate the response code.
		if ($response->code != $expectedCode)
		{
			// Decode the error response and throw an exception.
			$message = $this->error($response);

			// Throw an exception with the error message and code.
			throw new \DomainException($message, $response->code);
		}

		return $this->getBody($response, $default);
	}

	/**
	 * Return the body from the response
	 *
	 * @param   JoomlaResponse  $response    The response.
	 * @param   mixed           $default     The default if body not have length
	 *
	 * @return  mixed
	 * @since   2.0.1
	 **/
	protected function getBody(JoomlaResponse $response, $default = null)
	{
		$body = is_object($response) && method_exists($response, 'getBody')
			? (string) $response->getBody()
			: (isset($response->body) ? (string) $response->body : null);

		// check that we have a body
		if ($body !== null && StringHelper::check($body))
		{
			// if it's JSON, decode it
			if (JsonHelper::check($body))
			{
				return json_decode((string) $body);
			}
			
			// if it's XML, convert it to an object
			libxml_use_internal_errors(true);
			$xml = simplexml_load_string($body);
			if ($xml !== false)
			{
				return $xml;
			}

			// if it's neither JSON nor XML, return as is
			return $body;
		}

		return $default;
	}

	/**
	 * Get the error message from the System API response
	 *
	 * @param   JoomlaResponse  $response   The response.
	 *
	 * @return  string
	 * @since   2.0.1
	 **/
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

		return 'No error information found in response.';
	}
}

