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
 * The Openai Completions
 * 
 * @since 3.2.0
 */
class Completions extends Api
{
	/**
	 * Create a completion using the OpenAI API.
	 *  API Ref: https://platform.openai.com/docs/api-reference/completions
	 *
	 * @param   string         $model             The ID of the model to use.
	 * @param   string|array   $prompt            The prompt(s) to generate completions for.
	 * @param   int|null       $maxTokens         The maximum number of tokens to generate (optional).
	 * @param   float|null     $temperature       The sampling temperature to use (optional).
	 * @param   string         $suffix            The suffix that comes after a completion of inserted text. (optional).
	 * @param   float|null     $topP              The top_p value for nucleus sampling (optional).
	 * @param   int|null       $n                 How many completions to generate (optional).
	 * @param   bool|null      $stream            Whether to stream back partial progress (optional).
	 * @param   int|null       $logprobs          Include the log probabilities on the most likely tokens (optional).
	 * @param   bool|null      $echo              Echo back the prompt in addition to the completion (optional).
	 * @param   string|null    $stop              Up to 4 sequences where the API will stop generating (optional).
	 * @param   float|null     $presencePenalty   The presence penalty to use (optional).
	 * @param   float|null     $frequencyPenalty  The frequency penalty to use (optional).
	 * @param   int|null       $bestOf            Generates best_of completions server-side (optional).
	 * @param   array|null     $logitBias         Modify the likelihood of specified tokens (optional).
	 * @param   string|null    $user              A unique identifier representing your end-user (optional).
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function create(
		string $model,
		$prompt,
		?int $maxTokens = null,
		?string $suffix = null,
		?float $temperature = null,
		?float $topP = null,
		?int $n = null,
		?bool $stream = null,
		?int $logprobs = null,
		?bool $echo = null,
		$stop = null,
		?float $presencePenalty = null,
		?float $frequencyPenalty = null,
		?int $bestOf = null,
		?array $logitBias = null,
		?string $user = null
	): ?object
	{
		// Build the request path.
		$path = "/completions";

		// Set the completion data.
		$data = new \stdClass();
		$data->model = $model;
		$data->prompt = $prompt;

		if ($maxTokens !== null)
		{
			$data->max_tokens = $maxTokens;
		}

		if ($temperature !== null)
		{
			$data->temperature = $temperature;
		}

		if ($suffix !== null)
		{
			$data->suffix = $suffix;
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

		if ($logprobs !== null)
		{
			$data->logprobs = $logprobs;
		}

		if ($echo !== null)
		{
			$data->echo = $echo;
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

		if ($bestOf !== null)
		{
			$data->best_of = $bestOf;
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

