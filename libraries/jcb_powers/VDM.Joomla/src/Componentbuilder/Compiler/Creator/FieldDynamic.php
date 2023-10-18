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


use VDM\Joomla\Componentbuilder\Compiler\Field\Name;
use VDM\Joomla\Componentbuilder\Compiler\Field\TypeName;
use VDM\Joomla\Componentbuilder\Compiler\Field\Attributes;
use VDM\Joomla\Componentbuilder\Compiler\Field\Groups;
use VDM\Joomla\Componentbuilder\Compiler\Builder\FieldNames;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Creator\Fieldtypeinterface as Field;
use VDM\Joomla\Componentbuilder\Compiler\Creator\Builders;
use VDM\Joomla\Componentbuilder\Compiler\Creator\Layout;
use VDM\Joomla\Utilities\ObjectHelper;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Creator\Fielddynamicinterface;


/**
 * Dynamic Field Creator Class
 * 
 * @since 3.2.0
 */
final class FieldDynamic implements Fielddynamicinterface
{
	/**
	 * The Name Class.
	 *
	 * @var   Name
	 * @since 3.2.0
	 */
	protected Name $name;

	/**
	 * The TypeName Class.
	 *
	 * @var   TypeName
	 * @since 3.2.0
	 */
	protected TypeName $typename;

	/**
	 * The Attributes Class.
	 *
	 * @var   Attributes
	 * @since 3.2.0
	 */
	protected Attributes $attributes;

	/**
	 * The Groups Class.
	 *
	 * @var   Groups
	 * @since 3.2.0
	 */
	protected Groups $groups;

	/**
	 * The FieldNames Class.
	 *
	 * @var   FieldNames
	 * @since 3.2.0
	 */
	protected FieldNames $fieldnames;

	/**
	 * The Fieldtypeinterface Class.
	 *
	 * @var   Field
	 * @since 3.2.0
	 */
	protected Field $field;

	/**
	 * The Builders Class.
	 *
	 * @var   Builders
	 * @since 3.2.0
	 */
	protected Builders $builders;

	/**
	 * The Layout Class.
	 *
	 * @var   Layout
	 * @since 3.2.0
	 */
	protected Layout $layout;

	/**
	 * Constructor.
	 *
	 * @param Name         $name         The Name Class.
	 * @param TypeName     $typename     The TypeName Class.
	 * @param Attributes   $attributes   The Attributes Class.
	 * @param Groups       $groups       The Groups Class.
	 * @param FieldNames   $fieldnames   The FieldNames Class.
	 * @param Field        $field        The Fieldtypeinterface Class.
	 * @param Builders     $builders     The Builders Class.
	 * @param Layout       $layout       The Layout Class.
	 *
	 * @since 3.2.0
	 */
	public function __construct(Name $name, TypeName $typename,
		Attributes $attributes, Groups $groups, FieldNames $fieldnames,
		Field $field, Builders $builders, Layout $layout)
	{
		$this->name = $name;
		$this->typename = $typename;
		$this->attributes = $attributes;
		$this->groups = $groups;
		$this->fieldnames = $fieldnames;
		$this->field = $field;
		$this->builders = $builders;
		$this->layout = $layout;
	}

	/**
	 * Get the Dynamic field and build all it needs
	 *
	 * @param   array    $field           The field data
	 * @param   array    $view            The view data
	 * @param   int      $viewType        The view type
	 * @param   string   $langView        The language string of the view
	 * @param   string   $nameSingleCode  The single view name
	 * @param   string   $nameListCode    The list view name
	 * @param   array    $placeholders    The placeholder and replace values
	 * @param   string   $dbkey           The custom table key
	 * @param   boolean  $build           The switch to set the build option
	 *
	 * @return  mixed   The complete field
	 * @since 3.2.0
	 */
	public function get(array &$field, array &$view, int &$viewType, string &$langView, string &$nameSingleCode,
		string &$nameListCode, array &$placeholders, string &$dbkey, bool $build)
	{
		// set default return
		$dynamicField = null;

		// make sure we have settings
		if (isset($field['settings'])
			&& ObjectHelper::check($field['settings']))
		{
			// reset some values
			$name            = $this->name->get($field, $nameListCode);
			$typeName        = $this->typename->get($field);
			$multiple        = false;
			$langLabel       = '';
			$fieldSet        = '';
			// set field attributes
			$fieldAttributes = $this->attributes->set(
				$field, $viewType, $name, $typeName, $multiple, $langLabel,
				$langView, $nameListCode, $nameSingleCode, $placeholders
			);
			// check if values were set
			if (ArrayHelper::check($fieldAttributes))
			{
				// set the array of field names
				$this->fieldnames->set(
					$nameSingleCode . '.' . $fieldAttributes['name'], $fieldAttributes['name']
				);

				// set options as null
				$optionArray = null;

				if ($this->groups->check($typeName, 'option'))
				{
					// set options array
					$optionArray = array();

					// now add to the field set
					$dynamicField = $this->field->get(
						'option', $fieldAttributes, $name, $typeName, $langView,
						$nameSingleCode, $nameListCode, $placeholders,
						$optionArray
					);

					if ($build)
					{
						// set builders
						$this->builders->set(
							$langLabel, $langView, $nameSingleCode,
							$nameListCode, $name, $view, $field, $typeName,
							$multiple, null, $optionArray
						);
					}
				}
				elseif ($this->groups->check($typeName, 'spacer'))
				{
					if ($build)
					{
						// make sure spacers gets loaded to layout
						$tabName = '';
						if (isset($view['settings']->tabs)
							&& isset($view['settings']->tabs[(int) $field['tab']]))
						{
							$tabName
								= $view['settings']->tabs[(int) $field['tab']];
						}
						elseif ((int) $field['tab'] == 15)
						{
							// set to publishing tab
							$tabName = 'publishing';
						}

						$this->layout->set(
							$nameSingleCode, $tabName, $name, $field
						);
					}

					// now add to the field set
					$dynamicField = $this->field->get(
						'spacer', $fieldAttributes, $name, $typeName, $langView,
						$nameSingleCode, $nameListCode, $placeholders,
						$optionArray
					);
				}
				elseif ($this->groups->check($typeName, 'special'))
				{
					// set the repeatable field or subform field
					if ($typeName === 'repeatable' || $typeName === 'subform')
					{
						if ($build)
						{
							// set builders
							$this->builders->set(
								$langLabel, $langView, $nameSingleCode,
								$nameListCode, $name, $view, $field,
								$typeName, $multiple, null
							);
						}

						// now add to the field set
						$dynamicField = $this->field->get(
							'special', $fieldAttributes, $name, $typeName,
							$langView, $nameSingleCode, $nameListCode,
							$placeholders, $optionArray
						);
					}
				}
				elseif (isset($fieldAttributes['custom'])
					&& ArrayHelper::check($fieldAttributes['custom']))
				{
					// set the custom array
					$custom = $fieldAttributes['custom'];
					unset($fieldAttributes['custom']);
					// set db key
					$custom['db'] = $dbkey;
					// increment the db key
					$dbkey++;
					if ($build)
					{
						// set builders
						$this->builders->set(
							$langLabel, $langView, $nameSingleCode,
							$nameListCode, $name, $view, $field, $typeName,
							$multiple, $custom
						);
					}

					// now add to the field set
					$dynamicField = $this->field->get(
						'custom', $fieldAttributes, $name, $typeName, $langView,
						$nameSingleCode, $nameListCode, $placeholders,
						$optionArray, $custom
					);
				}
				else
				{
					if ($build)
					{
						// set builders
						$this->builders->set(
							$langLabel, $langView, $nameSingleCode,
							$nameListCode, $name, $view, $field, $typeName,
							$multiple
						);
					}

					// now add to the field set
					$dynamicField = $this->field->get(
						'plain', $fieldAttributes, $name, $typeName, $langView,
						$nameSingleCode, $nameListCode, $placeholders,
						$optionArray
					);
				}
			}
		}

		return $dynamicField;
	}
}

