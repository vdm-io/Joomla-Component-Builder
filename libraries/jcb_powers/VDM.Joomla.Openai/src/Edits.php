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
 * The Openai Edits
 * 
 * @since 3.2.0
 */
class Edits extends Api
{
	/**
	 * Create a new edit using OpenAI Edit API.
	 *  API Ref: https://platform.openai.com/docs/api-reference/edits
	 *
	 * @param   string       $model        The model to use.
	 * @param   string       $instruction  The instruction for the edit.
	 * @param   string|null  $input        The input text (optional).
	 * @param   int|null     $n            How many edits to generate (optional).
	 * @param   float|null   $temperature  The sampling temperature (optional).
	 * @param   float|null   $topP         Nucleus sampling parameter (optional).
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function create(
		string $model,
		string $instruction,
		?string $input = null,
		?int $n = null,
		?float $temperature = null,
		?float $topP = null
	): ?object
	{
		// Build the request path.
		$path = "/edits";

		// Set the data.
		$data = new \stdClass();
		$data->model = $model;
		$data->instruction = $instruction;

		if ($input !== null)
		{
			$data->input = $input;
		}

		if ($n !== null)
		{
			$data->n = $n;
		}

		if ($temperature !== null)
		{
			$data->temperature = $temperature;
		}

		if ($topP !== null)
		{
			$data->top_p = $topP;
		}

		// Send the post request.
		return $this->response->get(
			$this->http->post(
				$this->uri->get($path), json_encode($data)
			)
		);
	}
}

