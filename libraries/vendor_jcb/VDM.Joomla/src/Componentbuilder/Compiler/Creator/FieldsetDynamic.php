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

namespace VDM\Joomla\Componentbuilder\Compiler\Creator;


use VDM\Joomla\Componentbuilder\Compiler\Creator\FieldAsString;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Utilities\ArrayHelper;


/**
 * Fieldset Dynamic Creator Class
 * 
 * @since 3.2.0
 */
final class FieldsetDynamic
{
	/**
	 * The FieldAsString Class.
	 *
	 * @var   FieldAsString
	 * @since 3.2.0
	 */
	protected FieldAsString $fieldasstring;

	/**
	 * Constructor.
	 *
	 * @param FieldAsString   $fieldasstring   The FieldAsString Class.
	 *
	 * @since 3.2.0
	 */
	public function __construct(FieldAsString $fieldasstring)
	{
		$this->fieldasstring = $fieldasstring;
	}

	/**
	 * build field set
	 *
	 * @param   array    $fields          The fields data
	 * @param   string   $langView        The language string of the view
	 * @param   string   $nameSingleCode  The single view name
	 * @param   string   $nameListCode    The list view name
	 * @param   array    $placeholders    The placeholder and replace values
	 * @param   string   $dbkey           The custom table key
	 * @param   boolean  $build           The switch to set the build option
	 * @param   int      $return_type     The return type 1 = string, 2 = array
	 *
	 * @return  mixed   The complete field in string or array
	 * @since 3.2.0
	 */
	public function get(array &$fields, string &$langView, string &$nameSingleCode,
		string &$nameListCode, array &$placeholders, string &$dbkey, bool $build = false,
		int $returnType = 1)
	{
		// set some defaults
		$view     = [];
		$view_type = 0;
		// build the fieldset
		if ($returnType == 1)
		{
			$fieldset = '';
		}
		else
		{
			$fieldset = [];
		}
		// loop over the fields to build
		if (ArrayHelper::check($fields))
		{
			foreach ($fields as $field)
			{
				// get the field
				$field_xml_string = $this->fieldasstring->get(
					$field, $view, $view_type, $langView,
					$nameSingleCode, $nameListCode,
					$placeholders, $dbkey, $build
				);
				// make sure the xml is set and a string
				if (StringHelper::check($field_xml_string))
				{
					if ($returnType == 1)
					{
						$fieldset .= $field_xml_string;
					}
					else
					{
						$fieldset[] = $field_xml_string;
					}
				}
			}
		}

		return $fieldset;
	}
}

