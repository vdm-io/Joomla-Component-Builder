<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    18th August, 2026
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\Field;


use VDM\Joomla\Componentbuilder\Compiler\Field\Groups as FieldGroups;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ValidationFix;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Unique;
use VDM\Joomla\Utilities\ArrayHelper;


/**
 * Field Target Controls Script Class.
 * 
 * Builds the jQuery statements that reveal, hide and re-require every field a
 * form condition targets, along with the variables that remember whether a
 * target was required to begin with.
 * 
 * @since  6.1.7
 */
final class TargetControlsScript
{
	/**
	 * The Field Groups Class.
	 *
	 * @var   FieldGroups
	 * @since 6.1.7
	 */
	protected FieldGroups $fieldgroups;

	/**
	 * The Validation Fix Class.
	 *
	 * @var   ValidationFix
	 * @since 6.1.7
	 */
	protected ValidationFix $validationfix;

	/**
	 * The condition keys already built, so each is only built once.
	 *
	 * @var   array
	 * @since 6.1.7
	 */
	protected array $checked = [];

	/**
	 * Constructor.
	 *
	 * @param FieldGroups    $fieldgroups    The Field Groups Class.
	 * @param ValidationFix  $validationfix  The Validation Fix Class.
	 *
	 * @since 6.1.7
	 */
	public function __construct(FieldGroups $fieldgroups,
		ValidationFix $validationfix)
	{
		$this->fieldgroups = $fieldgroups;
		$this->validationfix = $validationfix;
	}

	/**
	 * Build the show, hide and required statements for every target field.
	 *
	 * @param   bool    $toggleSwitch    Whether the required attribute is toggled rather than set once.
	 * @param   mixed   $targets         The target fields, which the caller does not guarantee to be an array.
	 * @param   string  $targetBehavior  The jQuery call that reveals a target.
	 * @param   string  $targetDefault   The jQuery call that returns a target to its default.
	 * @param   string  $uniqueVar       The unique key of the condition being built.
	 * @param   string  $nameSingleCode  The single view code name.
	 *
	 * @return  array
	 *
	 * @since   6.1.7
	 */
	public function get(bool $toggleSwitch, $targets, string $targetBehavior,
		string $targetDefault, string $uniqueVar, string $nameSingleCode): array
	{
		$bucket = [];
		if (ArrayHelper::check($targets)
			&& !in_array(
				$uniqueVar, $this->checked
			))
		{
			foreach ($targets as $target)
			{
				if (ArrayHelper::check($target))
				{
					// set the required var
					if ($target['required'] === 'yes')
					{
						$unique                                 = $uniqueVar
							. Unique::get(3);
						$bucket[$target['name']]['requiredVar'] = "jform_"
							. $unique . "_required = false;" . PHP_EOL;
					}
					else
					{
						$bucket[$target['name']]['requiredVar'] = '';
					}
					// set target type
					$targetTypeSufix = "";
					if ($this->fieldgroups->check(
						$target['type'], 'spacer'
					))
					{
						// target a class if this is a note or spacer
						$targetType = ".";
					}
					elseif ($target['type'] === 'editor'
						|| $target['type'] === 'subform')
					{
						// target the label if  editor field
						$targetType = "#jform_";
						// since the id is not alway accessable we use the lable TODO (not best way)
						$targetTypeSufix = "-lbl";
					}
					else
					{
						// target an id if this is a field
						$targetType = "#jform_";
					}
					// set the target behavior
					$bucket[$target['name']]['behavior'] = PHP_EOL . Indent::_(
							2
						) . "jQuery('" . $targetType . $target['name']
						. $targetTypeSufix . "').closest('.control-group')."
						. $targetBehavior . "();";
					// set the target default
					$bucket[$target['name']]['default'] = PHP_EOL . Indent::_(2)
						. "jQuery('" . $targetType . $target['name']
						. $targetTypeSufix . "').closest('.control-group')."
						. $targetDefault . "();";
					// the hide required function
					if ($target['required'] === 'yes')
					{
						if ($toggleSwitch)
						{
							$hide                            = PHP_EOL
								. Indent::_(2) . "//" . Line::_(__Line__, __Class__)
								. " remove required attribute from "
								. $target['name'] . " field";
							$hide                            .= PHP_EOL
								. Indent::_(2) . "if (!jform_" . $unique
								. "_required)";
							$hide                            .= PHP_EOL
								. Indent::_(2) . "{";
							$hide                            .= PHP_EOL
								. Indent::_(3) . "updateFieldRequired('"
								. $target['name'] . "',1);";
							$hide                            .= PHP_EOL
								. Indent::_(3) . "jQuery('#jform_"
								. $target['name']
								. "').removeAttr('required');";
							$hide                            .= PHP_EOL
								. Indent::_(3) . "jQuery('#jform_"
								. $target['name']
								. "').removeAttr('aria-required');";
							$hide                            .= PHP_EOL
								. Indent::_(3) . "jQuery('#jform_"
								. $target['name']
								. "').removeClass('required');";
							$hide                            .= PHP_EOL
								. Indent::_(3) . "jform_" . $unique
								. "_required = true;";
							$hide                            .= PHP_EOL
								. Indent::_(2) . "}";
							$bucket[$target['name']]['hide'] = $hide;
							// the show required function
							$show                            = PHP_EOL
								. Indent::_(2) . "//" . Line::_(__Line__, __Class__)
								. " add required attribute to "
								. $target['name'] . " field";
							$show                            .= PHP_EOL
								. Indent::_(2) . "if (jform_" . $unique
								. "_required)";
							$show                            .= PHP_EOL
								. Indent::_(2) . "{";
							$show                            .= PHP_EOL
								. Indent::_(3) . "updateFieldRequired('"
								. $target['name'] . "',0);";
							$show                            .= PHP_EOL
								. Indent::_(3) . "jQuery('#jform_"
								. $target['name']
								. "').prop('required','required');";
							$show                            .= PHP_EOL
								. Indent::_(3) . "jQuery('#jform_"
								. $target['name']
								. "').attr('aria-required',true);";
							$show                            .= PHP_EOL
								. Indent::_(3) . "jQuery('#jform_"
								. $target['name'] . "').addClass('required');";
							$show                            .= PHP_EOL
								. Indent::_(3) . "jform_" . $unique
								. "_required = false;";
							$show                            .= PHP_EOL
								. Indent::_(2) . "}";
							$bucket[$target['name']]['show'] = $show;
						}
						else
						{
							$hide                            = PHP_EOL
								. Indent::_(2) . "//" . Line::_(__Line__, __Class__)
								. " remove required attribute from "
								. $target['name'] . " field";
							$hide                            .= PHP_EOL
								. Indent::_(2) . "updateFieldRequired('"
								. $target['name'] . "',1);";
							$hide                            .= PHP_EOL
								. Indent::_(2) . "jQuery('#jform_"
								. $target['name']
								. "').removeAttr('required');";
							$hide                            .= PHP_EOL
								. Indent::_(2) . "jQuery('#jform_"
								. $target['name']
								. "').removeAttr('aria-required');";
							$hide                            .= PHP_EOL
								. Indent::_(2) . "jQuery('#jform_"
								. $target['name']
								. "').removeClass('required');";
							$hide                            .= PHP_EOL
								. Indent::_(2) . "jform_" . $unique
								. "_required = true;" . PHP_EOL;
							$bucket[$target['name']]['hide'] = $hide;
							// the show required function
							$show                            = PHP_EOL
								. Indent::_(2) . "//" . Line::_(__Line__, __Class__)
								. " add required attribute to "
								. $target['name'] . " field";
							$show                            .= PHP_EOL
								. Indent::_(2) . "updateFieldRequired('"
								. $target['name'] . "',0);";
							$show                            .= PHP_EOL
								. Indent::_(2) . "jQuery('#jform_"
								. $target['name']
								. "').prop('required','required');";
							$show                            .= PHP_EOL
								. Indent::_(2) . "jQuery('#jform_"
								. $target['name']
								. "').attr('aria-required',true);";
							$show                            .= PHP_EOL
								. Indent::_(2) . "jQuery('#jform_"
								. $target['name'] . "').addClass('required');";
							$show                            .= PHP_EOL
								. Indent::_(2) . "jform_" . $unique
								. "_required = false;" . PHP_EOL;
							$bucket[$target['name']]['show'] = $show;
						}
						// make sure that the axaj and other needed things for this view is loaded
						$this->validationfix->add(
							$nameSingleCode, $target['name']
						);
					}
					else
					{
						$bucket[$target['name']]['hide'] = '';
						$bucket[$target['name']]['show'] = '';
					}
				}
			}
			$this->checked[] = $uniqueVar;
		}

		return $bucket;
	}
}

