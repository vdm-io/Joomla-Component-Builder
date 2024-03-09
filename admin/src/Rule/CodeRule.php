<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
namespace VDM\Component\Componentbuilder\Administrator\Rule;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Form\Form;
use Joomla\CMS\Form\FormRule;
use Joomla\Registry\Registry;
use Joomla\CMS\HTML\HTMLHelper as Html;
use Joomla\CMS\Component\ComponentHelper;
use VDM\Component\Componentbuilder\Administrator\Helper\ComponentbuilderHelper;

// No direct access to this file
\defined('JPATH_PLATFORM') or die;

/**
 * Form Rule (Code) class for the Joomla Platform.
 *
 * @since  3.5
 */
class CodeRule extends FormRule
{
	/**
	 * Method to test the value.
	 *
	 * @param   \SimpleXMLElement  $element  The SimpleXMLElement object representing the `<field>` tag for the form field object.
	 * @param   mixed              $value    The form field value to validate.
	 * @param   string             $group    The field name group control value. This acts as an array container for the field.
	 *                                       For example if the field has name="foo" and the group value is set to "bar" then the
	 *                                       full field name would end up being "bar[foo]".
	 * @param   Registry           $input    An optional Registry object with the entire data set to validate against the entire form.
	 * @param   Form               $form     The form object for which the field is being tested.
	 *
	 * @return  boolean  True if the value is valid, false otherwise.
	 */
	public function test(\SimpleXMLElement $element, $value, $group = null, Registry $input = null, Form $form = null)
	{
		// This removes all validation (is dangerous) but needed to submit code via JCB
		return true;

		/**
		 * My idea is to add some kind of validation to improve JCB code (per/language)
		 *
		 * So at this time this code validation is used for JavaScript,CSS,HTML and PHP.
		 * We can see what language is being worked on with the syntax property in the $element. (in JCB)
		 * What complicates things is the placeholders, of both custom code, component, and view names.
		 * Ideally we could strip them and then validate the code to being syntactically correct.
		 * But since some of the placeholders form part of the class/function names and the more, it seems like we are pressed for a much more advance solution.
		 * If you have any ideas to how we can go about to do this, then please open an issue on github and lets begin. (this is a nice to have, so don't break a leg...)
		 */
	}
}
