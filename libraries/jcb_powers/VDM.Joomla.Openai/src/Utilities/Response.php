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

namespace VDM\Joomla\Openai\Utilities;


use Joomla\CMS\Http\Response as JoomlaResponse;
use VDM\Joomla\Utilities\JsonHelper;
use VDM\Joomla\Utilities\StringHelper;


/**
 * The Openai Response
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
		if ($response->code != $expectedCode)
		{
			// Decode the error response and throw an exception.
			$message = $this->error($response);

			// Throw an exception with the OpenAI error message and code.
			throw new \DomainException($message, $response->code);
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
		if (!isset($validate[$response->code]))
		{
			// Decode the error response and throw an exception.
			$message = $this->error($response);

			// Throw an exception with the OpenAI error message and code.
			throw new \DomainException($message, $response->code);

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
	protected function body(JoomlaResponse $response, $default = null)
	{
		// check that we have a body and that its JSON
		if (isset($response->body) && StringHelper::check($response->body))
		{
			if (JsonHelper::check($response->body))
			{
				return json_decode((string) $response->body);
			}

			return $response->body;
		}

		return $default;
	}

	/**
	 * Get the error message from the OpenAI API response
	 *
	 * @param   JoomlaResponse  $response   The response.
	 *
	 * @return  string
	 * @since   3.2.0
	 **/
	protected function error(JoomlaResponse $response): string
	{
		// do we have a json string
		if (isset($response->body) && JsonHelper::check($response->body))
		{
			$error = json_decode($response->body);
		}
		else
		{
			return 'Invalid or empty response body.';
		}

		// check if OpenAI returned an error object
		if (isset($error->error))
		{
			// error object found, extract message and code
			$errorMessage = isset($error->error->message) ? $error->error->message : 'Unknown error.';
			$errorCode = isset($error->error->code) ? $error->error->code : 'Unknown error code.';

			// return formatted error message
			return 'OpenAI Error: ' . $errorMessage . ' Code: ' . $errorCode;
		}

		return 'No error information found in response.';
	}
}

