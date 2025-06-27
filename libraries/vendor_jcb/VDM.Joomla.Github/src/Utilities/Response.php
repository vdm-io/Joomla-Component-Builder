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

namespace VDM\Joomla\Github\Utilities;


use Joomla\Http\Response as JoomlaResponse;
use VDM\Joomla\Utilities\JsonHelper;
use VDM\Joomla\Utilities\StringHelper;


/**
 * The Github Response
 * 
 * @since 5.1.1
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
	 * @since    5.1.1
	 * @throws  \DomainException
	 **/
	public function get(JoomlaResponse $response, int  $expectedCode = 200, $default = null)
	{
		// Validate the response code.
		if ($response->code != $expectedCode)
		{
			// Decode the error response and throw an exception.
			$message =  $this->error($response);

			throw new \DomainException("Invalid response received from GitHub API. {$message}", $response->code);
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
	 * @since   5.1.1
	 * @throws  \DomainException
	 **/
	public function get_(JoomlaResponse $response, array $validate = [200 => null])
	{
		// Validate the response code.
		if (!array_key_exists($response->code, $validate))
		{
			// Decode the error response and throw an exception.
			$message =  $this->error($response);

			throw new \DomainException("Invalid response received from GitHub API. {$message}", $response->code);
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
	 * @since   5.1.1
	 **/
	protected function body(JoomlaResponse $response, $default = null)
	{
		$body = method_exists($response, 'getBody')
			? (string) $response->getBody()
			: ($response->body ?? null);

		// check that we have a body
		if ($body !== null && StringHelper::check($body))
		{
			if (JsonHelper::check($body))
			{
				$body = json_decode((string) $body);

				if (isset($body->content) && isset($body->encoding) && $body->encoding === 'base64')
				{
					$body->decoded_content = base64_decode((string) $body->content);
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
	 * @since   5.1.1
	 */
	protected function error(JoomlaResponse $response): string
	{
		// Try to get the raw response body
		$body = method_exists($response, 'getBody') ? (string) $response->getBody() : '';

		// Try to decode as JSON object
		$errorData = JsonHelper::check($body) ? json_decode($body) : null;

		if (is_object($errorData))
		{
			// GitHub's error structure may have a message and/or an errors array
			if (!empty($errorData->message)) {
				$errorMsg = $errorData->message;

				if (!empty($errorData->errors) && is_array($errorData->errors)) {
					$details = [];

					foreach ($errorData->errors as $err) {
						if (is_object($err)) {
							$details[] = trim(
								($err->resource ?? '') . ' ' .
								($err->field ?? '') . ' ' .
								($err->code ?? '')
							);
						} else {
							$details[] = (string) $err;
						}
					}

					$errorMsg .= ' (' . implode('; ', array_filter($details)) . ')';
				}

				return $errorMsg;
			}

			return json_encode($errorData, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
		}

		// Fallback to reason phrase or body
		if (!empty($body))
		{
			return $body;
		}

		return method_exists($response, 'getReasonPhrase')
			? $response->getReasonPhrase()
			: 'No error information found in GitHub API response.';
	}
}

