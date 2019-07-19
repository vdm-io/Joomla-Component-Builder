<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <http://www.joomlacomponentbuilder.com>
 * @github     Joomla Component Builder <https://github.com/vdm-io/Joomla-Component-Builder>
 * @copyright  Copyright (C) 2015 - 2019 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('JPATH_PLATFORM') or die;

use Joomla\CMS\Form\Form;
use Joomla\CMS\Form\FormRule;
use Joomla\Registry\Registry;

/**
 * Form Rule (Int) class for the Joomla Platform.
 */
class JFormRuleInt extends FormRule
{
	/**
	 * Method to test that an integer value was added.
	 *
	 * @param   \SimpleXMLElement  $element  The SimpleXMLElement object representing the `<field>` tag for the form field object.
	 * @param   mixed              $value    The form field value to validate.
	 * @param   string             $group    The field name group control value. This acts as an array container for the field.
	 *                                       For example if the field has name="foo" and the group value is set to "bar" then the
	 *                                       full field name would end up being "bar[foo]".
	 * @param   Registry           $input    An optional Registry object with the entire data set to validate against the entire form.
	 * @param   Form               $form     The form object for which the field is being tested.
	 *
	 * @return  boolean  True if the value is valid integer, false otherwise.
	 *
	 */
	public function test(\SimpleXMLElement $element, $value, $group = null, Registry $input = null, Form $form = null)
	{
		// Check if the field is required.
		$required = ((string) $element['required'] == 'true' || (string) $element['required'] == 'required');

		// If the value is empty and the field is not required return True.
		if (($value === '' || $value === null) && ! $required)
		{
			return true;
		}

		// now validate the value to be an integer
		// we need to validate a string with the integer in it
		// since this is how Joomla passes the value to the test method
		// so we use type coercion along with is_numeric
		return is_numeric($value) && is_int(+$value);
		// if you have a better idea... lets hear it.
	}
}
