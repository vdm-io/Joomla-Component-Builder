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


use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Language;
use VDM\Joomla\Componentbuilder\Compiler\Field;
use VDM\Joomla\Componentbuilder\Compiler\Field\Groups;
use VDM\Joomla\Componentbuilder\Compiler\Field\Name;
use VDM\Joomla\Componentbuilder\Compiler\Field\TypeName;
use VDM\Joomla\Componentbuilder\Compiler\Field\Attributes;
use VDM\Joomla\Componentbuilder\Compiler\Creator\CustomFieldTypeFile;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Counter;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\ObjectHelper;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Utilities\String\FieldHelper;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Creator\Fieldtypeinterface;


/**
 * Field String Creator Class
 * 
 * @since 3.2.0
 */
final class FieldString implements Fieldtypeinterface
{
	/**
	 * The Config Class.
	 *
	 * @var   Config
	 * @since 3.2.0
	 */
	protected Config $config;

	/**
	 * The Language Class.
	 *
	 * @var   Language
	 * @since 3.2.0
	 */
	protected Language $language;

	/**
	 * The Field Class.
	 *
	 * @var   Field
	 * @since 3.2.0
	 */
	protected Field $field;

	/**
	 * The Groups Class.
	 *
	 * @var   Groups
	 * @since 3.2.0
	 */
	protected Groups $groups;

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
	 * The CustomFieldTypeFile Class.
	 *
	 * @var   CustomFieldTypeFile
	 * @since 3.2.0
	 */
	protected CustomFieldTypeFile $customfieldtypefile;

	/**
	 * The Counter Class.
	 *
	 * @var   Counter
	 * @since 3.2.0
	 */
	protected Counter $counter;

	/**
	 * Constructor.
	 *
	 * @param Config                $config                The Config Class.
	 * @param Language              $language              The Language Class.
	 * @param Field                 $field                 The Field Class.
	 * @param Groups                $groups                The Groups Class.
	 * @param Name                  $name                  The Name Class.
	 * @param TypeName              $typename              The TypeName Class.
	 * @param Attributes            $attributes            The Attributes Class.
	 * @param CustomFieldTypeFile   $customfieldtypefile   The CustomFieldTypeFile Class.
	 * @param Counter               $counter               The Counter Class.
	 *
	 * @since 3.2.0
	 */
	public function __construct(Config $config, Language $language, Field $field,
		Groups $groups, Name $name, TypeName $typename,
		Attributes $attributes,
		CustomFieldTypeFile $customfieldtypefile,
		Counter $counter)
	{
		$this->config = $config;
		$this->language = $language;
		$this->field = $field;
		$this->groups = $groups;
		$this->name = $name;
		$this->typename = $typename;
		$this->attributes = $attributes;
		$this->customfieldtypefile = $customfieldtypefile;
		$this->counter = $counter;
	}

	/**
	 * Create a field using string manipulation
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
	 * @param   string      $taber            The tabs to add in layout
	 *
	 * @return  string   The field in a string
	 * @since 3.2.0
	 */
	public function get(string $setType, array &$fieldAttributes, string &$name,
		string &$typeName, string &$langView, string &$nameSingleCode, string &$nameListCode,
		array $placeholders, ?array &$optionArray, ?array $custom = null, string $taber = ''): string
	{
		// count the dynamic fields created
		$this->counter->field++;

		// build field set using string manipulation
		$field = '';
		if ($setType === 'option')
		{
			// now add to the field set
			$field     .= PHP_EOL . Indent::_(1) . $taber . Indent::_(1)
				. "<!--" . Line::_(__Line__, __Class__) . " " . ucfirst($name)
				. " Field. Type: " . StringHelper::safe(
					$typeName, 'F'
				) . ". (joomla) -->";
			$field     .= PHP_EOL . Indent::_(1) . $taber . Indent::_(1)
				. "<field";
			$optionSet = '';
			foreach ($fieldAttributes as $property => $value)
			{
				if ($property != 'option')
				{
					$field .= PHP_EOL . Indent::_(2) . $taber . Indent::_(1)
						. $property . '="' . $value . '"';
				}
				elseif ($property === 'option')
				{
					$optionSet = '';
					if (strtolower($typeName) === 'groupedlist'
						&& strpos(
							(string) $value, ','
						) !== false
						&& strpos((string) $value, '@@') !== false)
					{
						// reset the group temp arrays
						$groups_  = array();
						$grouped_ = array('group'  => array(),
							'option' => array());
						$order_   = array();
						// mulitpal options
						$options = explode(',', (string) $value);
						foreach ($options as $option)
						{
							if (strpos($option, '@@') !== false)
							{
								// set the group label
								$valueKeyArray = explode('@@', $option);
								if (count((array) $valueKeyArray) == 2)
								{
									$langValue = $langView . '_'
										. FieldHelper::safe(
											$valueKeyArray[0], true
										);
									// add to lang array
									$this->language->set(
										$this->config->lang_target, $langValue,
										$valueKeyArray[0]
									);
									// now add group label
									$groups_[$valueKeyArray[1]] = PHP_EOL
										. Indent::_(1) . $taber . Indent::_(2)
										. '<group label="' . $langValue . '">';
									// set order
									$order_['group' . $valueKeyArray[1]]
										= $valueKeyArray[1];
								}
							}
							elseif (strpos($option, '|') !== false)
							{
								// has other value then text
								$valueKeyArray = explode('|', $option);
								if (count((array) $valueKeyArray) == 3)
								{
									$langValue = $langView . '_'
										. FieldHelper::safe(
											$valueKeyArray[1], true
										);
									// add to lang array
									$this->language->set(
										$this->config->lang_target, $langValue,
										$valueKeyArray[1]
									);
									// now add to option set
									$grouped_['group'][$valueKeyArray[2]][]
										= PHP_EOL . Indent::_(1) . $taber
										. Indent::_(3) . '<option value="'
										. $valueKeyArray[0] . '">' . PHP_EOL
										. Indent::_(1) . $taber . Indent::_(4)
										. $langValue . '</option>';
									$optionArray[$valueKeyArray[0]]
										= $langValue;
									// set order
									$order_['group' . $valueKeyArray[2]]
										= $valueKeyArray[2];
								}
								else
								{
									$langValue = $langView . '_'
										. FieldHelper::safe(
											$valueKeyArray[1], true
										);
									// add to lang array
									$this->language->set(
										$this->config->lang_target, $langValue,
										$valueKeyArray[1]
									);
									// now add to option set
									$grouped_['option'][$valueKeyArray[0]]
										= PHP_EOL . Indent::_(1) . $taber
										. Indent::_(2) . '<option value="'
										. $valueKeyArray[0] . '">' . PHP_EOL
										. Indent::_(1) . $taber . Indent::_(3)
										. $langValue . '</option>';
									$optionArray[$valueKeyArray[0]]
										= $langValue;
									// set order
									$order_['option' . $valueKeyArray[0]]
										= $valueKeyArray[0];
								}
							}
							else
							{
								// text is also the value
								$langValue = $langView . '_'
									. FieldHelper::safe(
										$option, true
									);
								// add to lang array
								$this->language->set(
									$this->config->lang_target, $langValue, $option
								);
								// now add to option set
								$grouped_['option'][$option] = PHP_EOL
									. Indent::_(1) . $taber . Indent::_(2)
									. '<option value="' . $option . '">'
									. PHP_EOL . Indent::_(1) . $taber
									. Indent::_(3) . $langValue . '</option>';
								$optionArray[$option]        = $langValue;
								// set order
								$order_['option' . $option] = $option;
							}
						}
						// now build the groups
						foreach ($order_ as $pointer_ => $_id)
						{
							// load the default key
							$key_ = 'group';
							if (strpos($pointer_, 'option') !== false)
							{
								// load the option field
								$key_ = 'option';
							}
							// check if this is a group loader
							if ('group' === $key_ && isset($groups_[$_id])
								&& isset($grouped_[$key_][$_id])
								&& ArrayHelper::check(
									$grouped_[$key_][$_id]
								))
							{
								// set group label
								$optionSet .= $groups_[$_id];
								foreach ($grouped_[$key_][$_id] as $option_)
								{
									$optionSet .= $option_;
								}
								unset($groups_[$_id]);
								unset($grouped_[$key_][$_id]);
								// close the group
								$optionSet .= PHP_EOL . Indent::_(1) . $taber
									. Indent::_(2) . '</group>';
							}
							elseif (isset($grouped_[$key_][$_id])
								&& StringHelper::check(
									$grouped_[$key_][$_id]
								))
							{
								$optionSet .= $grouped_[$key_][$_id];
							}
						}
					}
					elseif (strpos((string) $value, ',') !== false)
					{
						// mulitpal options
						$options = explode(',', (string) $value);
						foreach ($options as $option)
						{
							if (strpos($option, '|') !== false)
							{
								// has other value then text
								list($v, $t) = explode('|', $option);
								$langValue = $langView . '_'
									. FieldHelper::safe(
										$t, true
									);
								// add to lang array
								$this->language->set(
									$this->config->lang_target, $langValue, $t
								);
								// now add to option set
								$optionSet       .= PHP_EOL . Indent::_(1)
									. $taber . Indent::_(2) . '<option value="'
									. $v . '">' . PHP_EOL . Indent::_(1)
									. $taber . Indent::_(3) . $langValue
									. '</option>';
								$optionArray[$v] = $langValue;
							}
							else
							{
								// text is also the value
								$langValue = $langView . '_'
									. FieldHelper::safe(
										$option, true
									);
								// add to lang array
								$this->language->set(
									$this->config->lang_target, $langValue, $option
								);
								// now add to option set
								$optionSet .= PHP_EOL . Indent::_(2)
									. $taber . Indent::_(1) . '<option value="'
									. $option . '">' . PHP_EOL . Indent::_(2)
									. $taber . Indent::_(2) . $langValue
									. '</option>';
								$optionArray[$option] = $langValue;
							}
						}
					}
					else
					{
						// one option
						if (strpos((string) $value, '|') !== false)
						{
							// has other value then text
							list($v, $t) = explode('|', (string) $value);
							$langValue = $langView . '_'
								. FieldHelper::safe(
									$t, true
								);
							// add to lang array
							$this->language->set($this->config->lang_target, $langValue, $t);
							// now add to option set
							$optionSet       .= PHP_EOL . Indent::_(2) . $taber
								. Indent::_(1) . '<option value="' . $v . '">'
								. PHP_EOL . Indent::_(2) . $taber . Indent::_(2)
								. $langValue . '</option>';
							$optionArray[$v] = $langValue;
						}
						else
						{
							// text is also the value
							$langValue = $langView . '_'
								. FieldHelper::safe(
									$value, true
								);
							// add to lang array
							$this->language->set(
								$this->config->lang_target, $langValue, $value
							);
							// now add to option set
							$optionSet           .= PHP_EOL . Indent::_(2)
								. $taber . Indent::_(1) . '<option value="'
								. $value . '">' . PHP_EOL . Indent::_(2)
								. $taber . Indent::_(2) . $langValue
								. '</option>';
							$optionArray[$value] = $langValue;
						}
					}
				}
			}
			// if options were found
			if (StringHelper::check($optionSet))
			{
				$field .= '>';
				$field .= PHP_EOL . Indent::_(3) . $taber . "<!--"
					. Line::_(__Line__, __Class__) . " Option Set. -->";
				$field .= $optionSet;
				$field .= PHP_EOL . Indent::_(2) . $taber . "</field>";
			}
			// if no options found and must have a list of options
			elseif ($this->groups->check($typeName, 'list'))
			{
				$optionArray = null;
				$field       .= PHP_EOL . Indent::_(2) . $taber . "/>";
				$field       .= PHP_EOL . Indent::_(2) . $taber . "<!--"
					. Line::_(__Line__, __Class__)
					. " No Manual Options Were Added In Field Settings. -->"
					. PHP_EOL;
			}
			else
			{
				$optionArray = null;
				$field       .= PHP_EOL . Indent::_(2) . $taber . "/>";
			}
		}
		elseif ($setType === 'plain')
		{
			// now add to the field set
			$field .= PHP_EOL . Indent::_(2) . $taber . "<!--" . Line::_(
					__LINE__,__CLASS__
				) . " " . ucfirst($name) . " Field. Type: "
				. StringHelper::safe($typeName, 'F')
				. ". (joomla) -->";
			$field .= PHP_EOL . Indent::_(2) . $taber . "<field";
			foreach ($fieldAttributes as $property => $value)
			{
				if ($property != 'option')
				{
					$field .= PHP_EOL . Indent::_(2) . $taber . Indent::_(1)
						. $property . '="' . $value . '"';
				}
			}
			$field .= PHP_EOL . Indent::_(2) . $taber . "/>";
		}
		elseif ($setType === 'spacer')
		{
			// now add to the field set
			$field .= PHP_EOL . Indent::_(2) . "<!--" . Line::_(__Line__, __Class__)
				. " " . ucfirst($name) . " Field. Type: "
				. StringHelper::safe($typeName, 'F')
				. ". A None Database Field. (joomla) -->";
			$field .= PHP_EOL . Indent::_(2) . "<field";
			foreach ($fieldAttributes as $property => $value)
			{
				if ($property != 'option')
				{
					$field .= " " . $property . '="' . $value . '"';
				}
			}
			$field .= " />";
		}
		elseif ($setType === 'special')
		{
			// set the repeatable field
			if ($typeName === 'repeatable')
			{
				// now add to the field set
				$field     .= PHP_EOL . Indent::_(2) . "<!--" . Line::_(
						__LINE__,__CLASS__
					) . " " . ucfirst($name) . " Field. Type: "
					. StringHelper::safe($typeName, 'F')
					. ". (joomla) -->";
				$field     .= PHP_EOL . Indent::_(2) . "<field";
				$fieldsSet = array();
				foreach ($fieldAttributes as $property => $value)
				{
					if ($property != 'fields')
					{
						$field .= PHP_EOL . Indent::_(3) . $property . '="'
							. $value . '"';
					}
				}
				$field .= ">";
				$field .= PHP_EOL . Indent::_(3) . '<fields name="'
					. $fieldAttributes['name'] . '_fields" label="">';
				$field .= PHP_EOL . Indent::_(4)
					. '<fieldset hidden="true" name="'
					. $fieldAttributes['name'] . '_modal" repeat="true">';
				if (strpos((string) $fieldAttributes['fields'], ',') !== false)
				{
					// mulitpal fields
					$fieldsSets = (array) explode(
						',', (string) $fieldAttributes['fields']
					);
				}
				elseif (is_numeric($fieldAttributes['fields']))
				{
					// single field
					$fieldsSets[] = (int) $fieldAttributes['fields'];
				}
				// only continue if we have a field set
				if (ArrayHelper::check($fieldsSets))
				{
					// set the resolver
					$_resolverKey = $fieldAttributes['name'];
					// load the field data
					$fieldsSets = array_map(
						function ($id) use (
							$nameSingleCode, $nameListCode, $_resolverKey
						) {
							// start field
							$field          = array();
							$field['field'] = $id;
							// set the field details
							$this->field->set(
								$field, $nameSingleCode, $nameListCode,
								$_resolverKey
							);

							// return field
							return $field;
						}, array_values($fieldsSets)
					);
					// start the build
					foreach ($fieldsSets as $fieldData)
					{
						// if we have settings continue
						if (ObjectHelper::check(
							$fieldData['settings']
						))
						{
							$r_name = $this->name->get(
								$fieldData, $nameListCode, $_resolverKey
							);
							$r_typeName  = $this->typename->get($fieldData);
							$r_multiple  = false;
							$viewType    = 0;
							$r_langLabel = '';
							// add the tabs needed
							$r_taber = Indent::_(3);
							// get field values
							$r_fieldValues = $this->attributes->set(
								$fieldData, $viewType, $r_name, $r_typeName,
								$r_multiple, $r_langLabel, $langView,
								$nameListCode, $nameSingleCode,
								$placeholders, true
							);
							// check if values were set
							if (ArrayHelper::check(
								$r_fieldValues
							))
							{
								//reset options array
								$r_optionArray = array();
								if ($this->groups->check(
									$r_typeName, 'option'
								))
								{
									// now add to the field set
									$field .= $this->get(
										'option', $r_fieldValues, $r_name,
										$r_typeName, $langView,
										$nameSingleCode, $nameListCode,
										$placeholders, $r_optionArray, null,
										$r_taber
									);
								}
								elseif (isset($r_fieldValues['custom'])
									&& ArrayHelper::check(
										$r_fieldValues['custom']
									))
								{
									// add to custom
									$custom = $r_fieldValues['custom'];
									unset($r_fieldValues['custom']);
									// now add to the field set
									$field .= $this->get(
										'custom', $r_fieldValues, $r_name,
										$r_typeName, $langView,
										$nameSingleCode, $nameListCode,
										$placeholders, $r_optionArray, null,
										$r_taber
									);
									// set lang (just incase)
									$r_listLangName = $langView . '_'
										. FieldHelper::safe(
											$r_name, true
										);
									// add to lang array
									$this->language->set(
										$this->config->lang_target, $r_listLangName,
										StringHelper::safe(
											$r_name, 'W'
										)
									);
									// if label was set use instead
									if (StringHelper::check(
										$r_langLabel
									))
									{
										$r_listLangName = $r_langLabel;
									}
									// set the custom array
									$data = array('type'   => $r_typeName,
										'code'   => $r_name,
										'lang'   => $r_listLangName,
										'custom' => $custom);
									// set the custom field file
									$this->customfieldtypefile->set(
										$data, $nameListCode,
										$nameSingleCode
									);
								}
								else
								{
									// now add to the field set
									$field .= $this->get(
										'plain', $r_fieldValues, $r_name,
										$r_typeName, $langView,
										$nameSingleCode, $nameListCode,
										$placeholders, $r_optionArray, null,
										$r_taber
									);
								}
							}
						}
					}
				}
				$field .= PHP_EOL . Indent::_(4) . "</fieldset>";
				$field .= PHP_EOL . Indent::_(3) . "</fields>";
				$field .= PHP_EOL . Indent::_(2) . "</field>";
			}
			// set the subform fields (it is a repeatable without the modal)
			elseif ($typeName === 'subform')
			{
				// now add to the field set
				$field     .= PHP_EOL . Indent::_(2) . $taber . "<!--"
					. Line::_(__Line__, __Class__) . " " . ucfirst($name)
					. " Field. Type: " . StringHelper::safe(
						$typeName, 'F'
					) . ". (joomla) -->";
				$field     .= PHP_EOL . Indent::_(2) . $taber . "<field";
				$fieldsSet = array();
				foreach ($fieldAttributes as $property => $value)
				{
					if ($property != 'fields')
					{
						$field .= PHP_EOL . Indent::_(3) . $taber . $property
							. '="' . $value . '"';
					}
				}
				$field .= ">";
				$field .= PHP_EOL . Indent::_(3) . $taber
					. '<form hidden="true" name="list_'
					. $fieldAttributes['name'] . '_modal" repeat="true">';
				if (strpos((string) $fieldAttributes['fields'], ',') !== false)
				{
					// mulitpal fields
					$fieldsSets = (array) explode(
						',', (string) $fieldAttributes['fields']
					);
				}
				elseif (is_numeric($fieldAttributes['fields']))
				{
					// single field
					$fieldsSets[] = (int) $fieldAttributes['fields'];
				}
				// only continue if we have a field set
				if (ArrayHelper::check($fieldsSets))
				{
					// set the resolver
					$_resolverKey = $fieldAttributes['name'];
					// load the field data
					$fieldsSets = array_map(
						function ($id) use (
							$nameSingleCode, $nameListCode, $_resolverKey
						) {
							// start field
							$field          = array();
							$field['field'] = $id;
							// set the field details
							$this->field->set(
								$field, $nameSingleCode, $nameListCode,
								$_resolverKey
							);

							// return field
							return $field;
						}, array_values($fieldsSets)
					);
					// start the build
					foreach ($fieldsSets as $fieldData)
					{
						// if we have settings continue
						if (ObjectHelper::check(
							$fieldData['settings']
						))
						{
							$r_name      = $this->name->get(
								$fieldData, $nameListCode, $_resolverKey
							);
							$r_typeName  = $this->typename->get($fieldData);
							$r_multiple  = false;
							$viewType    = 0;
							$r_langLabel = '';
							// add the tabs needed
							$r_taber = Indent::_(2) . $taber;
							// get field values
							$r_fieldValues = $this->attributes->set(
								$fieldData, $viewType, $r_name, $r_typeName,
								$r_multiple, $r_langLabel, $langView,
								$nameListCode, $nameSingleCode,
								$placeholders, true
							);
							// check if values were set
							if (ArrayHelper::check(
								$r_fieldValues
							))
							{
								//reset options array
								$r_optionArray = array();
								if ($this->groups->check(
									$r_typeName, 'option'
								))
								{
									// now add to the field set
									$field .= $this->get(
										'option', $r_fieldValues, $r_name,
										$r_typeName, $langView,
										$nameSingleCode, $nameListCode,
										$placeholders, $r_optionArray, null,
										$r_taber
									);
								}
								elseif ($r_typeName === 'subform')
								{
									// set nested depth
									if (isset($fieldAttributes['nested_depth']))
									{
										$r_fieldValues['nested_depth']
											= ++$fieldAttributes['nested_depth'];
									}
									else
									{
										$r_fieldValues['nested_depth'] = 1;
									}
									// only continue if nest is bellow 20 (this should be a safe limit)
									if ($r_fieldValues['nested_depth'] <= 20)
									{
										// now add to the field set
										$field .= $this->get(
											'special', $r_fieldValues, $r_name,
											$r_typeName, $langView,
											$nameSingleCode, $nameListCode,
											$placeholders, $r_optionArray, null,
											$r_taber
										);
									}
								}
								elseif (isset($r_fieldValues['custom'])
									&& ArrayHelper::check(
										$r_fieldValues['custom']
									))
								{
									// add to custom
									$custom = $r_fieldValues['custom'];
									unset($r_fieldValues['custom']);
									// now add to the field set
									$field .= $this->get(
										'custom', $r_fieldValues, $r_name,
										$r_typeName, $langView,
										$nameSingleCode, $nameListCode,
										$placeholders, $r_optionArray, null,
										$r_taber
									);
									// set lang (just incase)
									$r_listLangName = $langView . '_'
										. FieldHelper::safe(
											$r_name, true
										);
									// add to lang array
									$this->language->set(
										$this->config->lang_target, $r_listLangName,
										StringHelper::safe(
											$r_name, 'W'
										)
									);
									// if label was set use instead
									if (StringHelper::check(
										$r_langLabel
									))
									{
										$r_listLangName = $r_langLabel;
									}
									// set the custom array
									$data = array('type'   => $r_typeName,
										'code'   => $r_name,
										'lang'   => $r_listLangName,
										'custom' => $custom);
									// set the custom field file
									$this->customfieldtypefile->set(
										$data, $nameListCode,
										$nameSingleCode
									);
								}
								else
								{
									// now add to the field set
									$field .= $this->get(
										'plain', $r_fieldValues, $r_name,
										$r_typeName, $langView,
										$nameSingleCode, $nameListCode,
										$placeholders, $r_optionArray, null,
										$r_taber
									);
								}
							}
						}
					}
				}
				$field .= PHP_EOL . Indent::_(3) . $taber . "</form>";
				$field .= PHP_EOL . Indent::_(2) . $taber . "</field>";
			}
		}
		elseif ($setType === 'custom')
		{
			// now add to the field set
			$field     .= PHP_EOL . Indent::_(2) . $taber . "<!--"
				. Line::_(
					__LINE__,__CLASS__
				) . " " . ucfirst($name) . " Field. Type: "
				. StringHelper::safe($typeName, 'F')
				. ". (custom) -->";
			$field     .= PHP_EOL . Indent::_(2) . $taber . "<field";
			$optionSet = '';
			foreach ($fieldAttributes as $property => $value)
			{
				if ($property != 'option')
				{
					$field .= PHP_EOL . Indent::_(2) . $taber . Indent::_(1)
						. $property . '="' . $value . '"';
				}
				elseif ($property === 'option')
				{
					$optionSet = '';
					if (strtolower($typeName) === 'groupedlist'
						&& strpos(
							(string) $value, ','
						) !== false
						&& strpos((string) $value, '@@') !== false)
					{
						// reset the group temp arrays
						$groups_  = array();
						$grouped_ = array('group'  => array(),
							'option' => array());
						$order_   = array();
						// mulitpal options
						$options = explode(',', (string) $value);
						foreach ($options as $option)
						{
							if (strpos($option, '@@') !== false)
							{
								// set the group label
								$valueKeyArray = explode('@@', $option);
								if (count((array) $valueKeyArray) == 2)
								{
									$langValue = $langView . '_'
										. FieldHelper::safe(
											$valueKeyArray[0], true
										);
									// add to lang array
									$this->language->set(
										$this->config->lang_target, $langValue,
										$valueKeyArray[0]
									);
									// now add group label
									$groups_[$valueKeyArray[1]] = PHP_EOL
										. Indent::_(1) . $taber . Indent::_(2)
										. '<group label="' . $langValue . '">';
									// set order
									$order_['group' . $valueKeyArray[1]]
										= $valueKeyArray[1];
								}
							}
							elseif (strpos($option, '|') !== false)
							{
								// has other value then text
								$valueKeyArray = explode('|', $option);
								if (count((array) $valueKeyArray) == 3)
								{
									$langValue = $langView . '_'
										. FieldHelper::safe(
											$valueKeyArray[1], true
										);
									// add to lang array
									$this->language->set(
										$this->config->lang_target, $langValue,
										$valueKeyArray[1]
									);
									// now add to option set
									$grouped_['group'][$valueKeyArray[2]][]
										= PHP_EOL . Indent::_(1) . $taber
										. Indent::_(3) . '<option value="'
										. $valueKeyArray[0] . '">' . PHP_EOL
										. Indent::_(1) . $taber . Indent::_(4)
										. $langValue . '</option>';
									$optionArray[$valueKeyArray[0]]
										= $langValue;
									// set order
									$order_['group' . $valueKeyArray[2]]
										= $valueKeyArray[2];
								}
								else
								{
									$langValue = $langView . '_'
										. FieldHelper::safe(
											$valueKeyArray[1], true
										);
									// add to lang array
									$this->language->set(
										$this->config->lang_target, $langValue,
										$valueKeyArray[1]
									);
									// now add to option set
									$grouped_['option'][$valueKeyArray[0]]
										= PHP_EOL . Indent::_(1) . $taber
										. Indent::_(2) . '<option value="'
										. $valueKeyArray[0] . '">' . PHP_EOL
										. Indent::_(1) . $taber . Indent::_(3)
										. $langValue . '</option>';
									$optionArray[$valueKeyArray[0]]
										= $langValue;
									// set order
									$order_['option' . $valueKeyArray[0]]
										= $valueKeyArray[0];
								}
							}
							else
							{
								// text is also the value
								$langValue = $langView . '_'
									. FieldHelper::safe(
										$option, true
									);
								// add to lang array
								$this->language->set(
									$this->config->lang_target, $langValue, $option
								);
								// now add to option set
								$grouped_['option'][$option] = PHP_EOL
									. Indent::_(1) . $taber . Indent::_(2)
									. '<option value="' . $option . '">'
									. PHP_EOL . Indent::_(1) . $taber
									. Indent::_(3) . $langValue . '</option>';
								$optionArray[$option]        = $langValue;
								// set order
								$order_['option' . $option] = $option;
							}
						}
						// now build the groups
						foreach ($order_ as $pointer_ => $_id)
						{
							// load the default key
							$key_ = 'group';
							if (strpos($pointer_, 'option') !== false)
							{
								// load the option field
								$key_ = 'option';
							}
							// check if this is a group loader
							if ('group' === $key_ && isset($groups_[$_id])
								&& isset($grouped_[$key_][$_id])
								&& ArrayHelper::check(
									$grouped_[$key_][$_id]
								))
							{
								// set group label
								$optionSet .= $groups_[$_id];
								foreach ($grouped_[$key_][$_id] as $option_)
								{
									$optionSet .= $option_;
								}
								unset($groups_[$_id]);
								unset($grouped_[$key_][$_id]);
								// close the group
								$optionSet .= PHP_EOL . Indent::_(1) . $taber
									. Indent::_(2) . '</group>';
							}
							elseif (isset($grouped_[$key_][$_id])
								&& StringHelper::check(
									$grouped_[$key_][$_id]
								))
							{
								$optionSet .= $grouped_[$key_][$_id];
							}
						}
					}
					elseif (strpos((string) $value, ',') !== false)
					{
						// mulitpal options
						$options = explode(',', (string) $value);
						foreach ($options as $option)
						{
							if (strpos($option, '|') !== false)
							{
								// has other value then text
								list($v, $t) = explode('|', $option);
								$langValue = $langView . '_'
									. FieldHelper::safe(
										$t, true
									);
								// add to lang array
								$this->language->set(
									$this->config->lang_target, $langValue, $t
								);
								// now add to option set
								$optionSet       .= PHP_EOL . Indent::_(1)
									. $taber . Indent::_(2) . '<option value="'
									. $v . '">' . PHP_EOL . Indent::_(1)
									. $taber . Indent::_(3) . $langValue
									. '</option>';
								$optionArray[$v] = $langValue;
							}
							else
							{
								// text is also the value
								$langValue = $langView . '_'
									. FieldHelper::safe(
										$option, true
									);
								// add to lang array
								$this->language->set(
									$this->config->lang_target, $langValue, $option
								);
								// now add to option set
								$optionSet            .= PHP_EOL . Indent::_(2)
									. $taber . Indent::_(1) . '<option value="'
									. $option . '">' . PHP_EOL . Indent::_(2)
									. $taber . Indent::_(2) . $langValue
									. '</option>';
								$optionArray[$option] = $langValue;
							}
						}
					}
					else
					{
						// one option
						if (strpos((string) $value, '|') !== false)
						{
							// has other value then text
							list($v, $t) = explode('|', (string) $value);
							$langValue = $langView . '_'
								. FieldHelper::safe(
									$t, true
								);
							// add to lang array
							$this->language->set($this->config->lang_target, $langValue, $t);
							// now add to option set
							$optionSet       .= PHP_EOL . Indent::_(2) . $taber
								. Indent::_(1) . '<option value="' . $v . '">'
								. PHP_EOL . Indent::_(2) . $taber . Indent::_(2)
								. $langValue . '</option>';
							$optionArray[$v] = $langValue;
						}
						else
						{
							// text is also the value
							$langValue = $langView . '_'
								. FieldHelper::safe(
									$value, true
								);
							// add to lang array
							$this->language->set(
								$this->config->lang_target, $langValue, $value
							);
							// now add to option set
							$optionSet           .= PHP_EOL . Indent::_(2)
								. $taber . Indent::_(1) . '<option value="'
								. $value . '">' . PHP_EOL . Indent::_(2)
								. $taber . Indent::_(2) . $langValue
								. '</option>';
							$optionArray[$value] = $langValue;
						}
					}
				}
			}
			// if options were found
			if (StringHelper::check($optionSet))
			{
				$field .= '>';
				$field .= PHP_EOL . Indent::_(3) . $taber . "<!--"
					. Line::_(__Line__, __Class__) . " Option Set. -->";
				$field .= $optionSet;
				$field .= PHP_EOL . Indent::_(2) . $taber . "</field>";
			}
			// if no options found and must have a list of options
			elseif ($this->groups->check($typeName, 'list'))
			{
				$optionArray = null;
				$field       .= PHP_EOL . Indent::_(2) . $taber . "/>";
				$field       .= PHP_EOL . Indent::_(2) . $taber . "<!--"
					. Line::_(__Line__, __Class__)
					. " No Manual Options Were Added In Field Settings. -->"
					. PHP_EOL;
			}
			else
			{
				$optionArray = null;
				$field       .= PHP_EOL . Indent::_(2) . $taber . "/>";
			}
			// incase the field is in the config and has not been set
			if ('config' === $nameSingleCode && 'configs' === $nameListCode
				|| (strpos($nameSingleCode, 'pLuG!n') !== false
					|| strpos(
						$nameSingleCode, 'M0dUl3'
					) !== false))
			{
				// set lang (just incase)
				$listLangName = $langView . '_'
					. StringHelper::safe($name, 'U');
				// set the custom array
				$data = array('type' => $typeName, 'code' => $name,
					'lang' => $listLangName, 'custom' => $custom);
				// set the custom field file
				$this->customfieldtypefile->set(
					$data, $nameListCode, $nameSingleCode
				);
			}
		}

		// return field
		return $field;
	}
}

