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
 * The Openai Moderate
 * 
 * @since 3.2.0
 */
class Moderate extends Api
{
	/**
	 * Classify if text violates OpenAI's Content Policy.
	 *  API Ref: https://platform.openai.com/docs/api-reference/moderations/create
	 *
	 * @param   string|array  $input    The input text to classify.
	 * @param   string|null   $model    The moderation model (optional).
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function text(
	    $input,
	    ?string $model = null
	): ?object
	{
	    // Build the request path.
	    $path = "/moderations";

	    // Set the moderation data.
	    $data = new \stdClass();
	    $data->input = $input;

	    if ($model !== null)
	    {
		$data->model = $model;
	    }

	    // Send the post request.
	    return $this->response->get(
		$this->http->post(
		    $this->uri->get($path), json_encode($data)
		)
	    );
	}
}

