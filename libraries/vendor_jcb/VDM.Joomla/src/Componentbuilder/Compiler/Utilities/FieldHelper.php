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

namespace VDM\Joomla\Componentbuilder\Compiler\Utilities;


use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Utilities\GetHelper;
use VDM\Joomla\Utilities\Base64Helper;


/**
 * The Field Helper
 * 
 * @since 3.2.0
 */
abstract class FieldHelper
{
	/**
	 * Get a field value from the XML stored string
	 *
	 * @param   string     $xml           The xml string of the field
	 * @param   string     $get           The value key to get from the string
	 * @param   string     $confirmation  The value to confirm found value
	 *
	 * @return  string     The field value from xml
	 * @since 3.2.0
	 */
	public static function getValue(&$xml, string &$get, string $confirmation = ''): string
	{
		if (StringHelper::check($xml))
		{
			// if we have a PHP value, we must base64 decode it
			if (strpos($get, 'type_php') !== false)
			{
				return Base64Helper::open(GetHelper::between($xml, $get . '="', '"', $confirmation));
			}

			return GetHelper::between($xml, $get . '="', '"', $confirmation);
		}

		return $confirmation;
	}
}

