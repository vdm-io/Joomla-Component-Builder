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

namespace VDM\Joomla\Openai;


use VDM\Joomla\Openai\Abstraction\Api;


/**
 * The Openai Images
 * 
 * @since 3.2.0
 */
class Images extends Api
{
	/**
	 * Generate an image given a text prompt.
	 *  API Ref: https://platform.openai.com/docs/api-reference/images/create
	 *
	 * @param   string       $prompt              The text description of the desired image(s).
	 * @param   string|null  $size                The size of the generated images (optional).
	 * @param   string|null  $responseFormat      The format in which the images are returned (optional).
	 * @param   int|null     $n                   The number of images to generate (optional).
	 * @param   string|null  $user                A unique identifier representing the end-user (optional).
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function generate(
		string $prompt,
		?string $size = null,
		?string $responseFormat = null,
		?int $n = null,
		?string $user = null
	): ?object
	{
		// Build the request path.
		$path = "/images/generations";

		// Set the request data.
		$data = new \stdClass();
		$data->prompt = $prompt;

		if ($size !== null)
		{
			$data->size = $size;
		}

		if ($responseFormat !== null)
		{
			$data->response_format = $responseFormat;
		}

		if ($n !== null)
		{
			$data->n = $n;
		}

		if ($user !== null)
		{
			$data->user = $user;
		}

		// Send the post request.
		return $this->response->get(
			$this->http->post(
				$this->uri->get($path), json_encode($data)
			)
		);
	}

	/**
	 * Create an image edit with extended options.
	 *  API Ref: https://platform.openai.com/docs/api-reference/images/create-edit
	 *
	 * @param   string       $image          The original image to edit. Must be a valid PNG file, less than 4MB, and square.
	 * @param   string|null  $mask           An additional image for editing (optional).
	 * @param   string       $prompt         A text description of the desired image(s).
	 * @param   string|null  $size           The size of the generated images (optional).
	 * @param   string|null  $responseFormat The format in which the images are returned (optional).
	 * @param   int|null     $n              The number of images to generate (optional).
	 * @param   string|null  $user           A unique identifier representing your end-user (optional).
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function edit(
		string $image,
		string $prompt,
		?string $mask = null,
		?string $size = null,
		?string $responseFormat = null,
		?int $n = null,
		?string $user = null
	): ?object
	{
		// Build the request path.
		$path = "/images/edits";

		// Set the image edit data.
		$data = new \stdClass();
		$data->image = $image;
		$data->prompt = $prompt;

		if ($mask !== null)
		{
			$data->mask = $mask;
		}

		if ($size !== null)
		{
			$data->size = $size;
		}

		if ($responseFormat !== null)
		{
			$data->response_format = $responseFormat;
		}

		if ($n !== null)
		{
			$data->n = $n;
		}

		if ($user !== null)
		{
			$data->user = $user;
		}

		// Send the post request.
		return $this->response->get(
			$this->http->post(
				$this->uri->get($path), json_encode($data)
			)
		);
	}

	/**
	 * Create a variation of a given image.
	 *  API Ref: https://platform.openai.com/docs/api-reference/images/create-variation
	 *
	 * @param   string       $image              The image to use as the basis for the variation(s).
	 * @param   string|null  $size               The size of the generated images (optional).
	 * @param   string|null  $responseFormat     The format in which the generated images are returned (optional).
	 * @param   int|null     $n                  The number of images to generate (optional).
	 * @param   string|null  $user               A unique identifier representing your end-user (optional).
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function variation(
		string $image,
		?string $size = null,
		?string $responseFormat = null,
		?int $n = null,
		?string $user = null
	): ?object
	{
		// Build the request path.
		$path = "/images/variations";

		// Set the image variation data.
		$data = new \stdClass();
		$data->image = $image;

		if ($size !== null)
		{
			$data->size = $size;
		}

		if ($responseFormat !== null)
		{
			$data->response_format = $responseFormat;
		}

		if ($n !== null)
		{
			$data->n = $n;
		}

		if ($user !== null)
		{
			$data->user = $user;
		}

		// Send the post request.
		return $this->response->get(
			$this->http->post(
				$this->uri->get($path), json_encode($data)
			)
		);
	}
}

