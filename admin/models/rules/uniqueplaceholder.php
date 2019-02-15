<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <http://www.joomlacomponentbuilder.com>
 * @github     Joomla Component Builder <https://github.com/vdm-io/Joomla-Component-Builder>
 * @copyright  Copyright (C) 2015 - 2018 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('JPATH_PLATFORM') or die;

use Joomla\CMS\Form\Form;
use Joomla\CMS\Form\FormRule;
use Joomla\Registry\Registry;

/**
 * Form Rule (Uniqueplaceholder) class for the Joomla Platform.
 */
class JFormRuleUniqueplaceholder extends FormRule
{
	/**
	 * Method to test the field value for uniqueness.
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
	 *
	 * @since   11.1
	 */
	public function test(\SimpleXMLElement $element, $value, $group = null, Registry $input = null, Form $form = null)
	{
		// Get the database object and a new query object.
		$db = \JFactory::getDbo();
		$query = $db->getQuery(true);

		// Get the extra field check attribute.
		$id = ($input instanceof Registry) ? $input->get('id', null) : null;

		// get the component & table name
		$table = ($form instanceof Form) ? $form->getName() : '';

		// get the column name
		$name = (array) $element->attributes()->{'name'};
		$column = (string) trim($name[0]);
		
		// check that we have a value
		if (strlen($table) > 3 && strpos($table, 'componentbuilder.') !== false)
		{
			// now get the table name
			$tableArray = explode('.', $table);
			// do we have two values
			if (count( (array) $tableArray) == 2)
			{
				// Build the query.
				$query->select('COUNT(*)')
					->from('#__componentbuilder_' . (string) $tableArray[1])
					->where($db->quoteName($column) . ' = ' . $db->quote($value));

				// remove this item from the list
				if ($id > 0)
				{
					$query->where($db->quoteName('id') . ' <> ' . (int) $id);
				}

				// Set and query the database.
				$db->setQuery($query);
				$duplicate = (bool) $db->loadResult();

				if ($duplicate)
				{
					return false;
				}
			}
		}
		// now test against all the placeholders in the compiler
		return ComponentbuilderHelper::validateUniquePlaceholder($value);
	}
}
