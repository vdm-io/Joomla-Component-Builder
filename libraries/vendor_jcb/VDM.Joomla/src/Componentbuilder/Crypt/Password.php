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

namespace VDM\Joomla\Componentbuilder\Crypt;


use Joomla\CMS\Language\Text;
use VDM\Joomla\Utilities\Component\Helper;


/**
 * Password Class
 * 
 * @since 3.2.0
 */
class Password
{
	/**
	 * Get the type of password
	 *          Example: $this->get('basic', 'default-password');
	 *
	 * @param   string             $type    The value of password to get
	 * @param   string|null      $default    The default password if the type is not found
	 *
	 * @return  string|null
	 * @since 3.2.0
	 */
	public function get(string $type, ?string $default = null): ?string
	{
		// we have a local key for JCB only use
		if ('local' === $type)
		{
			return $this->local();
		}
		elseif (($password = Helper::_('getCryptKey', [$type, $default])) !== null)
		{
			return $password;
		}

		return $default;
	}

	/**
	 * Get the local password
	 *
	 * @return  string
	 * @since 3.2.0
	 */
	private function local(): string
	{
		return base64_decode(
			Text::sprintf(
				'COM_COMPONENTBUILDER_VJRZDESSMHBTRWFIFTYTWVZEROAESFLVVXJTMTHREEJTWOIXM',
				'QzdmV', '9kQ'
			)
		);
	}

}

