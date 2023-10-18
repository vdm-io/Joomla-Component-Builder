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
 * The Openai Embeddings
 * 
 * @since 3.2.0
 */
class Embeddings extends Api
{
	/**
	 * Create an embedding of a given input.
	 *  API Ref: https://platform.openai.com/docs/api-reference/embeddings
	 *
	 * @param   string       $model     The ID of the model to use.
	 * @param   mixed        $input     The input text to get embeddings for, encoded as a string or array of tokens.
	 * @param   string|null  $user      A unique identifier representing your end-user (optional).
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function create(
		string $model,
		$input,
		?string $user = null
	): ?object
	{
		// Build the request path.
		$path = "/embeddings";

		// Set the request data.
		$data = new \stdClass();
		$data->model = $model;
		$data->input = $input;

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

