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


use VDM\Joomla\Componentbuilder\Compiler\Field\Groups as FieldGroups;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ScriptUserSwitch;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;


/**
 * Field Value Script Class.
 * 
 * Builds the javascript that reads the current value out of the field a form
 * condition watches, and reports whether that value arrives as an array, since
 * the condition function iterates one and compares the other.
 * 
 * @since  6.1.7
 */
final class ValueScript
{
	/**
	 * The Field Groups Class.
	 *
	 * @var   FieldGroups
	 * @since 6.1.7
	 */
	protected FieldGroups $fieldgroups;

	/**
	 * The Script User Switch Class.
	 *
	 * @var   ScriptUserSwitch
	 * @since 6.1.7
	 */
	protected ScriptUserSwitch $scriptuserswitch;

	/**
	 * Constructor.
	 *
	 * @param FieldGroups       $fieldgroups       The Field Groups Class.
	 * @param ScriptUserSwitch  $scriptuserswitch  The Script User Switch Class.
	 *
	 * @since 6.1.7
	 */
	public function __construct(FieldGroups $fieldgroups,
		ScriptUserSwitch $scriptuserswitch)
	{
		$this->fieldgroups = $fieldgroups;
		$this->scriptuserswitch = $scriptuserswitch;
	}

	/**
	 * Build the javascript that reads the watched field's value.
	 *
	 * The type, and the type it extends, stay untyped: a custom field carries
	 * the type of the field it extends, and the caller guarantees neither. A
	 * field whose type matches none of the shapes below is read by no statement
	 * at all, which is the quiet nothing the caller then builds around.
	 *
	 * @param   mixed   $type     The type of the field being watched.
	 * @param   string  $name     The name of the field being watched.
	 * @param   mixed   $extends  The type the field extends, when it is a custom field.
	 * @param   string  $unique   The unique key of the condition being built.
	 *
	 * @return  array{get: string, isArray: bool}  The read statement, and whether it yields an array.
	 *
	 * @since   6.1.7
	 */
	public function get($type, string $name, $extends, string $unique): array
	{
		$select  = '';
		$isArray = false;
		$keyName = $name . '_' . $unique;
		if ($type === 'checkboxes' || $extends === 'checkboxes')
		{
			$select  = "var " . $keyName . " = [];" . PHP_EOL . Indent::_(1)
				. "jQuery('#jform_" . $name
				. " input[type=checkbox]').each(function()" . PHP_EOL
				. Indent::_(1) . "{" . PHP_EOL . Indent::_(2)
				. "if (jQuery(this).is(':checked'))" . PHP_EOL . Indent::_(2)
				. "{" . PHP_EOL . Indent::_(3) . $keyName
				. ".push(jQuery(this).prop('value'));" . PHP_EOL . Indent::_(2)
				. "}" . PHP_EOL . Indent::_(1) . "});";
			$isArray = true;
		}
		elseif ($type === 'checkbox')
		{
			$select = 'var ' . $keyName . ' = jQuery("#jform_' . $name
				. '").prop(\'checked\');';
		}
		elseif ($type === 'radio')
		{
			$select = 'var ' . $keyName . ' = jQuery("#jform_' . $name
				. ' input[type=\'radio\']:checked").val();';
		}
		elseif ($this->scriptuserswitch->inArray($type))
		{
			// this is only since 3.3.4
			$select = 'var ' . $keyName . ' = jQuery("#jform_' . $name
				. '_id").val();';
		}
		elseif ($type === 'list'
			|| $this->fieldgroups->check(
				$type, 'dynamic'
			)
			|| !$this->fieldgroups->check($type))
		{
			$select  = 'var ' . $keyName . ' = jQuery("#jform_' . $name
				. '").val();';
			$isArray = true;
		}
		elseif ($this->fieldgroups->check($type, 'text'))
		{
			$select = 'var ' . $keyName . ' = jQuery("#jform_' . $name
				. '").val();';
		}

		return array('get' => $select, 'isArray' => $isArray);
	}
}

