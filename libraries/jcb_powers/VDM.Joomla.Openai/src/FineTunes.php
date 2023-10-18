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
 * The Openai Fine Tunes
 * 
 * @since 3.2.0
 */
class FineTunes extends Api
{
	/**
	 * List your organization's fine-tuning jobs
	 *  API Ref: https://platform.openai.com/docs/api-reference/fine-tunes/list
	 *
	 * @return  object|null  The response from the OpenAI API, or null if an error occurred.
	 * @since   3.2.0
	 */
	public function list(): ?object
	{
		// Build the request path.
		$path = "/fine-tunes";
		
		// Prepare the URI.
		$uri = $this->uri->get($path);

		// Send the GET request.
		return $this->response->get(
			$this->http->get($uri)
		);
	}

	/**
	 * More to follow: https://platform.openai.com/docs/api-reference/fine-tunes
	 **/
}

