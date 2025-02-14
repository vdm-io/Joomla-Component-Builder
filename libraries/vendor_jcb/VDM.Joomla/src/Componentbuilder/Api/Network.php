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

namespace VDM\Joomla\Componentbuilder\Api;


use VDM\Joomla\Componentbuilder\Abstraction\Api;


/**
 * The Joomla Component Builder Network Api
 * 
 * @since 5.0.4
 */
final class Network extends Api
{
	/**
	 * Get the network repository statuses
	 *
	 * @param   string|null  $target   The target repositories.
	 * @param   int|null     $status   The repository status.
	 * @param   string       $project  The network project. (default: jcb)
	 * @param   string       $system   The network system. (default: community)
	 *
	 * @return  object|null   The set of status values
	 * @since   5.0.4
	 **/
	public function get(?string $target = null, ?int $status = null, string $project = 'jcb', string $system = 'community'): ?object
	{
		// Build the request path.
		$path = "/network/{$system}/{$project}";

		if (!empty($target))
		{
			$path .= "/{$target}";
		}

		if (!empty($status))
		{
			$path .= "/{$status}";
		}

		// Send the get request.
		return $this->response->get(
			$this->http->get(
				$this->uri->get($path)
			)
		);
	}
}

