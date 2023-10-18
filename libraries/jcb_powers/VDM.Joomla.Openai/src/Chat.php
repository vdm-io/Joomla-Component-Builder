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
 * The Openai Chat
 * 
 * @since 3.2.0
 */
class Chat extends Api
{
	/**
	 * Create a chat completion with the OpenAI API.
	 *  API Ref: https://platform.openai.com/docs/api-reference/chat/create
	 *
	 * @param   string       $model           The model to use for completion.
	 * @param   array        $messages        A list of messages describing the conversation so far.
	 *
	 *                                        Each item in the array is an object with the following:
	 *                                         - role (string) Required
	 *                                                The role of the author of this message.
	 *                                                One of system, user, or assistant.
	 *                                         - content (string) Required
	 *                                                The contents of the message.
	 *                                         - name (string) Optional
	 *                                                The name of the author of this message.
	 *                                                May contain a-z, A-Z, 0-9, and underscores,
	 *                                                with a maximum length of 64 characters.
	 *
	 * @param   int|null     $maxTokens       Maximum number of tokens to generate (optional).
	 * @param   float|null   $temperature     The sampling temperature to use (optional).
	 * @param   float|null   $topP            The nucleus sampling parameter (optional).
	 * @param   int|null     $n               The number of chat completion choices to generate (optional).
	 * @param   bool|null    $stream          Partial message deltas (optional).
	 * @param   mixed|null   $stop            Sequences where the API will stop generating tokens (optional).
	 * @param   float|null   $presencePenalty Penalty for new tokens based on whether they appear in the text (optional).
	 * @param   float|null   $frequencyPenalty Penalty for new tokens based on their frequency in the text (optional).
	 * @param   array|null   $logitBias       Modify the likelihood of specified tokens appearing (optional).
	 * @param   string|null  $user            A unique identifier representing the end-user (optional).
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function create(
		string $model,
		array $messages,
		?int $maxTokens = null,
		?float $temperature = null,
		?float $topP = null,
		?int $n = null,
		?bool $stream = null,
		$stop = null,
		?float $presencePenalty = null,
		?float $frequencyPenalty = null,
		?array $logitBias = null,
		?string $user = null
	): ?object
	{
		// Build the request path.
		$path = "/chat/completions";

		// Set the request data.
		$data = new \stdClass();
		$data->model = $model;
		$data->messages = $messages;

		if ($maxTokens !== null)
		{
			$data->max_tokens = $maxTokens;
		}

		if ($temperature !== null)
		{
			$data->temperature = $temperature;
		}

		if ($topP !== null)
		{
			$data->top_p = $topP;
		}

		if ($n !== null)
		{
			$data->n = $n;
		}

		if ($stream !== null)
		{
			$data->stream = $stream;
		}

		if ($stop !== null)
		{
			$data->stop = $stop;
		}

		if ($presencePenalty !== null)
		{
			$data->presence_penalty = $presencePenalty;
		}

		if ($frequencyPenalty !== null)
		{
			$data->frequency_penalty = $frequencyPenalty;
		}

		if ($logitBias !== null)
		{
			$data->logit_bias = new \stdClass();
			foreach ($logitBias as $key => $val)
			{
				$data->logit_bias->$key = $val;
			}
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

