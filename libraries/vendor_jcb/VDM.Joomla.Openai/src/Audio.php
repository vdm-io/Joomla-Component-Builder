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
 * The Openai Audio
 * 
 * @since 3.2.0
 */
class Audio extends Api
{
	/**
	 * Transcribes audio into the input language.
	 *  API Ref: https://platform.openai.com/docs/api-reference/audio/create
	 *
	 * @param   string       $file              The audio file to transcribe. Formats: mp3, mp4, mpeg, mpga, m4a, wav, or webm (required).
	 * @param   string|null  $prompt            An optional text to guide the model's style (optional).
	 * @param   string|null  $responseFormat    The format of the transcript output. Options: json, text, srt, verbose_json, or vtt  (optional).
	 * @param   float|null   $temperature       The sampling temperature, between 0 and 1. Higher values like 0.8 will make the output more random, while lower values like 0.2 will make it more focused and deterministic (optional).
	 * @param   string|null  $language          The language of the input audio (optional).
	 * @param   string       $model             ID of the model to use. Only "whisper-1" is currently available.
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function transcribe(
		string $file,
		?string $prompt = null,
		?string $responseFormat = null,
		?float $temperature = null,
		?string $language = null,
		string $model = 'whisper-1'
	): ?object
	{
		// Build the request path.
		$path = "/audio/transcriptions";

		// Set the request data.
		$data = new \stdClass();
		$data->file = $file;

		if ($prompt !== null)
		{
			$data->prompt = $prompt;
		}

		if ($responseFormat !== null)
		{
			$data->response_format = $responseFormat;
		}

		if ($temperature !== null)
		{
			$data->temperature = $temperature;
		}

		if ($language !== null)
		{
			$data->language = $language;
		}

		$data->model = $model;

		// Send the post request.
		return $this->response->get(
			$this->http->post(
				$this->uri->get($path), json_encode($data), ['Content-Type' => 'multipart/form-data']
			)
		);
	}

	/**
	 * Translate an audio file into English.
	 *  API Ref: https://platform.openai.com/docs/api-reference/audio/create
	 *
	 * @param   string       $file            The the audio file. Formats: mp3, mp4, mpeg, mpga, m4a, wav, or webm (required).
	 * @param   string|null  $prompt          An optional text to guide the model's style or continue a previous audio segment. The prompt should be in English (optional).
	 * @param   string|null  $responseFormat  The format of the transcript output. Options: json, text, srt, verbose_json, or vtt (optional).
	 * @param   float|null   $temperature     The sampling temperature, between 0 and 1. Higher values like 0.8 will make the output more random, while lower values like 0.2 will make it more focused and deterministic (optional).
	 * @param   string       $model           ID of the model to use. Only "whisper-1" is currently available.
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function translation(
		string $file,
		?string $prompt = null,
		?string $responseFormat = null,
		?float $temperature = null,
		string $model = 'whisper-1'
	): ?object
	{
		// Build the request path.
		$path = "/audio/translations";

		// Set the data.
		$data = new \stdClass();
		$data->file = $file;

		if ($prompt !== null)
		{
			$data->prompt = $prompt;
		}

		if ($responseFormat !== null)
		{
			$data->response_format = $responseFormat;
		}

		if ($temperature !== null)
		{
			$data->temperature = $temperature;
		}

		$data->model = $model;

		// Send the post request.
		return $this->response->get(
			$this->http->post(
				$this->uri->get($path), json_encode($data), ['Content-Type' => 'multipart/form-data']
			)
		);
	}
}

