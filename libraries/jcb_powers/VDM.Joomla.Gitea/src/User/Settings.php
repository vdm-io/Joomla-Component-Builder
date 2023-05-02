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

namespace VDM\Joomla\Gitea\User;


use VDM\Joomla\Gitea\Abstraction\Api;


/**
 * The Gitea User Settings
 * 
 * @since 3.2.0
 */
class Settings extends Api
{
	/**
	 * Get user settings for the authenticated user.
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function get(): ?object
	{
		// Build the request path.
		$path = '/user/settings';

		// Send the get request.
		return $this->response->get(
			$this->http->get(
				$this->uri->get($path)
			)
		);
	}

	/**
	 * Update user settings for the authenticated user.
	 *
	 * @param   string|null   $description            Optional. The description to update.
	 * @param   string|null   $diffViewStyle          Optional. The diff view style to update.
	 * @param   string|null   $fullName               Optional. The full name to update.
	 * @param   bool|null     $hideActivity           Optional. Whether to hide activity or not.
	 * @param   bool|null     $hideEmail              Optional. Whether to hide email or not.
	 * @param   string|null   $language               Optional. The language to update.
	 * @param   string|null   $location               Optional. The location to update.
	 * @param   string|null   $theme                  Optional. The theme to update.
	 * @param   string|null   $website                Optional. The website to update.
	 *
	 * @return  array|null
	 * @since   3.2.0
	 **/
	public function update(
		?string $description = null,
		?string $diffViewStyle = null,
		?string $fullName = null,
		?bool $hideActivity = null,
		?bool $hideEmail = null,
		?string $language = null,
		?string $location = null,
		?string $theme = null,
		?string $website = null
	): ?array
	{
		// Prepare settings data
		$settings = [];
		if ($description !== null) 
		{
			$settings['description'] = $description;
		}
		if ($diffViewStyle !== null) 
		{
			$settings['diff_view_style'] = $diffViewStyle;
		}
		if ($fullName !== null) 
		{
			$settings['full_name'] = $fullName;
		}
		if ($hideActivity !== null) 
		{
			$settings['hide_activity'] = $hideActivity;
		}
		if ($hideEmail !== null) 
		{
			$settings['hide_email'] = $hideEmail;
		}
		if ($language !== null) 
		{
			$settings['language'] = $language;
		}
		if ($location !== null) 
		{
			$settings['location'] = $location;
		}
		if ($theme !== null) 
		{
			$settings['theme'] = $theme;
		}
		if ($website !== null) 
		{
			$settings['website'] = $website;
		}

		// Build the request path.
		$path = '/user/settings';

		// Send the patch request.
		return $this->response->get(
			$this->http->patch(
				$this->uri->get($path),
				json_encode($settings)
			)
		);
	}

}

