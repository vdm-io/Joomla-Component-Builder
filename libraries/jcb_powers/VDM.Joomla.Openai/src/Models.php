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
 * The Openai Models
 * 
 * @since 3.2.0
 */
class Models extends Api
{
	/**
	 * List the available models from OpenAI API.
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function list(): ?object
	{
		// Build the request path.
		$path = "/models";

		// Send the get request.
		return $this->response->get(
			$this->http->get(
				$this->uri->get($path)
			)
		);
	}
}

