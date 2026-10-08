<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    19th August, 2026
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\Field;


/**
 * Field Clear Value Class.
 * 
 * Builds the one statement that empties a watched field, which is written the
 * way the kind of field it is expects.
 * 
 * @since 6.1.7
 */
final class ClearValueScript
{
	/**
	 * Build the javascript that clears the watched field's value.
	 *
	 * A kind of field this was never taught to clear is left alone.
	 *
	 * @param   string  $type    The type of the field being watched.
	 * @param   string  $name    The name of the field being watched.
	 * @param   string  $unique  The unique key of the condition being built.
	 *
	 * @return  string  The statement.
	 *
	 * @since   6.1.7
	 */
	public function get($type, $name, $unique): string
	{
		$clear   = '';
		$isArray = false;
		$keyName = $name . '_' . $unique;
		if ($type === 'text' || $type === 'password' || $type === 'textarea')
		{
			$clear = "jQuery('#jform_" . $name . "').value = '';";
		}
		elseif ($type === 'radio')
		{
			$clear = "jQuery('#jform_" . $name . "').checked = false;";
		}
		elseif ($type === 'checkboxes' || $type === 'checkbox'
			|| $type === 'checkbox')
		{
			$clear = "jQuery('#jform_" . $name . "').selectedIndex = -1;";
		}

		return $clear;
	}
}

