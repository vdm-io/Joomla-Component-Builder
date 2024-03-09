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
use VDM\Joomla\Utilities\ArrayHelper;

// No direct access to this file
\defined('JPATH_PLATFORM') or die;

/**
 * Form Rule (Sourcemapchecker) class for the Joomla Platform.
 *
 * @since  3.5
 */
class SourcemapcheckerRule extends FormRule
{
	/**
	 * Method to test if the selected source map has all the fields it would need
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
	 * @since   3.10.12
	 */
	public function test(\SimpleXMLElement $element, $value, $group = null, ?Registry $input = null, ?Form $form = null)
	{
		$fields = $this->getSelectedFields($value);

		$status = true;

		if ($fields === [])
		{
			// no fields selected (not good)
			$missing = Text::_('COM_COMPONENTBUILDER_NO_FIELDS_WHERE_SELECTED');
			$status = false;
		}
		// we only test if we have a table name
		elseif (($table = $input->get('table')) !== null)
		{
			// the fields to ignore Since 3.2
			$ignore = [
				'checked_out_time',
				'checked_out',
				'modified',
				'created',
				'modified_by',
				'created_by'
			];

			// get the database object.
			$db = Factory::getDbo();

			$columnDetails = $db->getTableColumns('#__' . $table, false);
			$requiredColumns = [];

			foreach ($columnDetails as $column => $details)
			{
				if (in_array($column, $ignore))
				{
					continue;
				}

				if ($details->Null === 'NO' && ($details->Default === null || strtolower($details->Extra) === 'auto_increment'))
				{
					$requiredColumns[] = $column;
				}
			}

			$_missing = array_diff($requiredColumns, $fields);

			if (!empty($_missing))
			{
				// Format missing fields for better readability
				$missing = implode(', ', $_missing);
				$status = false;
			}
		}

		// when we fail
		if (!$status)
		{
			Factory::getApplication()->enqueueMessage(Text::sprintf('COM_COMPONENTBUILDER_REQUIRED_FIELDS_MISSING_IN_THE_BMYSQL_TABLES_SOURCE_MAPB_SELECTIONBR_S', $missing), 'Error');
		}

		return $status;
	}

	/**
	 * Method to get array of fields
	 *
	 * @param string|null $value
	 *
	 * @return array
	 * @since  3.2.0
	 */
	private function getSelectedFields(?string $value): array
	{
		// reset array buckets
		$fields = [];
		// the other tables
		if (is_string($value) && strpos((string) $value, PHP_EOL) !== false)
		{
			$lines = explode(PHP_EOL, (string) $value);
			if (ArrayHelper::check($lines))
			{
				foreach ($lines as $field)
				{
					if (strpos($field, "=>") !== false)
					{
						list($source) = explode(
							"=>", $field, 2
						);
						$fields[] = trim($source);
					}
				}
			}
		}
		return $fields;
	}
}
