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

namespace VDM\Joomla\Componentbuilder\Compiler\Interfaces\Creator;


/**
 * Field (Types) Creator Interface (needed for the container)
 * 
 * @since 3.2.0
 */
interface Fieldtypeinterface
{
	/**
	 * Create a field
	 *
	 * @param   string      $setType          The set of fields type
	 * @param   array       $fieldAttributes  The field values
	 * @param   string      $name             The field name
	 * @param   string      $typeName         The field type
	 * @param   string      $langView         The language string of the view
	 * @param   string      $nameSingleCode   The single view name
	 * @param   string      $nameListCode     The list view name
	 * @param   array       $placeholders     The place holder and replace values
	 * @param   array|null  $optionArray      The option bucket array used to set the field options if needed.
	 * @param   array|null  $custom           Used when field is from config
	 * @param   array|null  $custom           Used when field is from config
	 * @param   string      $taber            The tabs to add in layout
	 *
	 * @return mixed    The field (two return types based of field_builder_type selected Object->xml or String)
	 * @since 3.2.0
	 */
	public function get(string $setType, array &$fieldAttributes, string &$name,
		string &$typeName, string &$langView, string &$nameSingleCode, string &$nameListCode,
		array $placeholders, ?array &$optionArray, ?array $custom = null, string $taber = '');
}

