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

namespace VDM\Joomla\Utilities;


use VDM\Joomla\Utilities\StringHelper;


/**
 * The Base64 Helper
 * 
 * @since 3.2.0
 */
abstract class Base64Helper
{
	/**
	 * open base64 string if stored as base64 (in JCB)
	 *
	 * @param   string|null   $data     The base64 string
	 * @param   string|null   $key      We store the string with that suffix :)
	 * @param   string|null   $default  The default switch
	 *
	 * @return  string|null   The opened string
	 * @since 3.2.0
	 */
	public static function open(?string $data, ?string $key = '__.o0=base64=Oo.__', ?string $default = 'string'): ?string
	{
		// check that we have a string
		if (StringHelper::check($data))
		{
			// check if we have a key
			if (StringHelper::check($key))
			{
				if (strpos($data, $key) !== false)
				{
					return base64_decode(str_replace($key, '', $data));
				}
			}

			// fallback to this, not perfect method
			if (base64_encode(base64_decode($data, true)) === $data)
			{
				return base64_decode($data);
			}
		}

		// check if we should just return the string
		if ('string' === $default)
		{
			return $data;
		}

		return $default;
	}
}

