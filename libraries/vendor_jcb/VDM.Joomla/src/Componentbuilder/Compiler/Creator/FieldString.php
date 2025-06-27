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
use VDM\Joomla\Componentbuilder\Compiler\Field\ModalSelect;
use VDM\Joomla\Componentbuilder\Compiler\Creator\CustomFieldTypeFile;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Counter;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ComponentFields;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\ObjectHelper;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Utilities\String\FieldHelper;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;
use VDM\Joomla\Utilities\GuidHelper;
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
	 * The ModalSelect Class.
	 *
	 * @var   ModalSelect
	 * @since 5.1.1
	 */
	protected ModalSelect $modalselect;

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
	 * The ComponentFields Class.
	 *
	 * @var   ComponentFields
	 * @since 5.1.1
	 */
	protected ComponentFields $componentfields;

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
	 * @param ModalSelect           $modalselect           The ModalSelect Class.
	 * @param CustomFieldTypeFile   $customfieldtypefile   The CustomFieldTypeFile Class.
	 * @param Counter               $counter               The Counter Class.
	 * @param ComponentFields       $componentfields       The Component Fields Class.
	 *
	 * @since 3.2.0
	 */
	public function __construct(Config $config, Language $language, Field $field,
		Groups $groups, Name $name, TypeName $typename, Attributes $attributes, ModalSelect $modalselect,
		CustomFieldTypeFile $customfieldtypefile, Counter $counter, ComponentFields $componentfields)
	{
		$this->config = $config;
		$this->language = $language;
		$this->field = $field;
		$this->groups = $groups;
		$this->name = $name;
		$this->typename = $typename;
		$this->attributes = $attributes;
		$this->modalselect = $modalselect;
		$this->customfieldtypefile = $customfieldtypefile;
		$this->counter = $counter;
		$this->componentfields = $componentfields;
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
	 * @since   3.2.0
	 */
	public function get(string $setType, array &$fieldAttributes, string $name,
		string $typeName, string $langView, string $nameSingleCode, string $nameListCode,
		array $placeholders, ?array &$optionArray, ?array $custom = null, string $taber = ''): string
	{
		$this->counter->field++;

		switch ($setType)
		{
			case 'option':
				return $this->buildOptionField($fieldAttributes, $name, $typeName, $langView, $optionArray, $taber);

			case 'plain':
				return $this->buildPlainField($fieldAttributes, $name, $typeName, $taber);

			case 'spacer':
				return $this->buildSpacerField($fieldAttributes, $name, $typeName);

			case 'special':
				$subform = []; // new subform starts here
				return $this->buildSpecialField($fieldAttributes, $name, $subform, $typeName, $langView,
					$nameSingleCode, $nameListCode, $placeholders, $taber);

			case 'custom':
				return $this->buildCustomField($fieldAttributes, $name, $typeName, $langView,
					$nameSingleCode, $nameListCode, $placeholders, $optionArray, $custom, $taber);

			default:
				return ''; // fallback, should never hit
		}
	}

	/**
	 * Build an option type field.
	 *
	 * @param   array       $fieldAttributes  The field values
	 * @param   string      $name             The field name
	 * @param   string      $typeName         The field type
	 * @param   string      $langView         The language string of the view
	 * @param   array|null  $optionArray      The option bucket array
	 * @param   string      $taber            The tabs to add in layout
	 *
	 * @return  string  The field XML string
	 * @since   5.1.1
	 */
	private function buildOptionField(array &$fieldAttributes, string $name, string $typeName, string $langView,
		?array &$optionArray, string $taber): string
	{
		$field = PHP_EOL . Indent::_(1) . $taber . Indent::_(1)
			. "<!--" . Line::_(__Line__, __Class__) . " " . ucfirst($name)
			. " Field. Type: " . StringHelper::safe($typeName, 'F') . ". (joomla) -->"
			. PHP_EOL . Indent::_(1) . $taber . Indent::_(1) . "<field";

		$optionSet = '';

		foreach ($fieldAttributes as $property => $value)
		{
			if ($property != 'option')
			{
				$field .= PHP_EOL . Indent::_(2) . $taber . Indent::_(1)
					. $property . '="' . $value . '"';
			}
			elseif (!StringHelper::check($optionSet))
			{
				$optionSet = $this->buildOptionSet($value, $typeName, $langView, $optionArray, $taber);
			}
		}

		if (StringHelper::check($optionSet))
		{
			$field .= '>';
			$field .= PHP_EOL . Indent::_(3) . $taber . "<!--" . Line::_(__Line__, __Class__) . " Option Set. -->";
			$field .= $optionSet;
			$field .= PHP_EOL . Indent::_(2) . $taber . "</field>";
		}
		elseif ($this->groups->check($typeName, 'list'))
		{
			$optionArray = null;
			$field .= PHP_EOL . Indent::_(2) . $taber . "/>";
			$field .= PHP_EOL . Indent::_(2) . $taber . "<!--"
				. Line::_(__Line__, __Class__)
				. " No Manual Options Were Added In Field Settings. -->"
				. PHP_EOL;
		}
		else
		{
			$optionArray = null;
			$field .= PHP_EOL . Indent::_(2) . $taber . "/>";
		}

		return $field;
	}

	/**
	 * Build a plain field (non-option, non-grouped).
	 *
	 * @param   array   $fieldAttributes  The field values
	 * @param   string  $name             The field name
	 * @param   string  $typeName         The field type
	 * @param   string  $taber            The tabs to add in layout
	 *
	 * @return  string  The field XML string
	 * @since   5.1.1
	 */
	private function buildPlainField(array $fieldAttributes, string $name, string $typeName, string $taber): string
	{
		$field = PHP_EOL . Indent::_(2) . $taber . "<!--"
			. Line::_(__LINE__, __CLASS__) . " " . ucfirst($name)
			. " Field. Type: " . StringHelper::safe($typeName, 'F')
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

		return $field;
	}

	/**
	 * Build a spacer field (non-database placeholder).
	 *
	 * @param   array   $fieldAttributes  The field values
	 * @param   string  $name             The field name
	 * @param   string  $typeName         The field type
	 *
	 * @return  string  The field XML string
	 * @since   5.1.1
	 */
	private function buildSpacerField(array $fieldAttributes, string $name, string $typeName): string
	{
		$field = PHP_EOL . Indent::_(2) . "<!--" . Line::_(__LINE__, __CLASS__)
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

		return $field;
	}

	/**
	 * Build a special field (e.g. repeatable, subform).
	 *
	 * @param   array       $fieldAttributes  The field values
	 * @param   string      $name             The field name
	 * @param   array       $subform          The subform field bucket
	 * @param   string      $typeName         The field type
	 * @param   string      $langView         The view language string
	 * @param   string      $nameSingleCode   The single view name
	 * @param   string      $nameListCode     The list view name
	 * @param   array       $placeholders     The placeholder map
	 * @param   string      $taber            The tab string
	 *
	 * @return  string  The field XML string
	 * @since   5.1.1
	 */
	private function buildSpecialField(array &$fieldAttributes, string $name, array &$subform, string $typeName, string $langView,
		string $nameSingleCode, string $nameListCode, array $placeholders, string $taber): string
	{
		if ($typeName === 'subform')
		{
			return $this->buildSubformField(
				$fieldAttributes, $name, $subform, $typeName, $langView,
				$nameSingleCode, $nameListCode, $placeholders, $taber
			);
		}

		if ($typeName === 'repeatable') // Just for Joomla 3 (will be removed when we drop support for J3, if we remember to look here :)
		{
			return $this->buildRepeatableField(
				$fieldAttributes, $name, $typeName, $langView,
				$nameSingleCode, $nameListCode, $placeholders, $taber
			);
		}

		return '';
	}

	/**
	 * Build a custom field (defined from config or external source).
	 *
	 * @param   array       $fieldAttributes  The field values
	 * @param   string      $name             The field name
	 * @param   string      $typeName         The field type
	 * @param   string      $langView         The view language string
	 * @param   string      $nameSingleCode   The single view name
	 * @param   string      $nameListCode     The list view name
	 * @param   array       $placeholders     The placeholder map
	 * @param   array|null  $optionArray      The option bucket array
	 * @param   array|null  $custom           The custom field data
	 * @param   string      $taber            The tab string
	 *
	 * @return  string  The custom field XML string
	 * @since   5.1.1
	 */
	private function buildCustomField(array &$fieldAttributes, string $name, string $typeName, string $langView,
		string $nameSingleCode, string $nameListCode, array $placeholders, ?array &$optionArray,
		?array $custom = null, string $taber = ''): string
	{
		$field = PHP_EOL . Indent::_(2) . $taber . "<!--" . Line::_(__LINE__, __CLASS__)
			. " " . ucfirst($name) . " Field. Type: " . StringHelper::safe($typeName, 'F') . ". (custom) -->";

		$field .= PHP_EOL . Indent::_(2) . $taber . "<field";

		$optionSet = '';

		foreach ($fieldAttributes as $property => $value)
		{
			if ($property != 'option')
			{
				$field .= PHP_EOL . Indent::_(2) . $taber . Indent::_(1)
					. $property . '="' . $value . '"';
			}
			else
			{
				$optionSet = $this->buildOptionSet($value, $typeName, $langView, $optionArray, $taber);
			}
		}

		if (StringHelper::check($optionSet))
		{
			$field .= '>';
			$field .= PHP_EOL . Indent::_(3) . $taber . "<!--"
				. Line::_(__LINE__, __CLASS__) . " Option Set. -->";
			$field .= $optionSet;
			$field .= PHP_EOL . Indent::_(2) . $taber . "</field>";
		}
		elseif ($this->groups->check($typeName, 'list'))
		{
			$optionArray = null;
			$field .= PHP_EOL . Indent::_(2) . $taber . "/>";
			$field .= PHP_EOL . Indent::_(2) . $taber . "<!--"
				. Line::_(__LINE__, __CLASS__)
				. " No Manual Options Were Added In Field Settings. -->"
				. PHP_EOL;
		}
		else
		{
			$optionArray = null;
			$field .= PHP_EOL . Indent::_(2) . $taber . "/>";
		}

		// check for config mode or plugin/module source
		if (
			$nameSingleCode === 'config'
			&& $nameListCode === 'configs'
			|| strpos($nameSingleCode, 'pLuG!n') !== false
			|| strpos($nameSingleCode, 'M0dUl3') !== false
		)
		{
			$listLangName = $langView . '_' . StringHelper::safe($name, 'U');

			$this->customfieldtypefile->set([
				'type'   => $typeName,
				'code'   => $name,
				'lang'   => $listLangName,
				'custom' => $custom
			], $nameListCode, $nameSingleCode);
		}

		return $field;
	}

	/**
	 * Build a subform field (special case of repeatable without modal).
	 *
	 * @param   array       $fieldAttributes  The field values
	 * @param   string      $name             The field name
	 * @param   array       $subform          The subform field bucket
	 * @param   string      $typeName         The field type
	 * @param   string      $langView         The view language string
	 * @param   string      $nameSingleCode   The single view name
	 * @param   string      $nameListCode     The list view name
	 * @param   array       $placeholders     The placeholder map
	 * @param   string      $taber            The tab string
	 *
	 * @return  string  The subform field XML string
	 * @since   5.1.1
	 */
	private function buildSubformField(array &$fieldAttributes, string $name, array &$subform, string $typeName, string $langView,
		string $nameSingleCode, string $nameListCode, array $placeholders, string $taber): string
	{
		$field = PHP_EOL . Indent::_(2) . $taber . "<!--"
			. Line::_(__LINE__, __CLASS__) . " " . ucfirst($name)
			. " Field. Type: " . StringHelper::safe($typeName, 'F') . ". (joomla) -->";

		$field .= PHP_EOL . Indent::_(2) . $taber . "<field";

		foreach ($fieldAttributes as $property => $value)
		{
			if ($property != 'fields' && $property !== 'formsource')
			{
				$field .= PHP_EOL . Indent::_(3) . $taber . $property . '="' . $value . '"';
			}
		}

		if (!empty($fieldAttributes['formsource']) && StringHelper::check($fieldAttributes['formsource']))
		{
			$field .= PHP_EOL . Indent::_(3) . $taber . 'formsource="' . $fieldAttributes['formsource'] . '"';
			$field .= PHP_EOL . Indent::_(2) . $taber . "</field>";

			return $field;
		}

		$fieldsSets = $this->normalizeFieldsSet($fieldAttributes['fields']);

		if (!ArrayHelper::check($fieldsSets))
		{
			$field .= PHP_EOL . Indent::_(2) . $taber . "</field>";
			return $field;
		}

		$field .= ">";
		$field .= PHP_EOL . Indent::_(3) . $taber . '<form hidden="true" name="list_' . $fieldAttributes['name'] . '_modal" repeat="true">';

		$_resolverKey = $fieldAttributes['name'];
		$fieldsSets = $this->resolveFieldSetData($fieldsSets, $nameSingleCode, $nameListCode, $_resolverKey);

		// get the base subform details
		$new = true;
		if (isset($fieldAttributes['nested_depth']))
		{
			$new = false;
		}

		foreach ($fieldsSets as $fieldData)
		{
			if (!ObjectHelper::check($fieldData['settings']))
			{
				continue;
			}

			$r_name = $this->name->get($fieldData, $nameListCode, $_resolverKey);
			$r_typeName = $this->typename->get($fieldData);
			$r_multiple = false;
			$viewType = 0;
			$r_langLabel = '';
			$r_optionArray = [];
			$r_taber = Indent::_(2) . $taber;

			$r_fieldValues = $this->attributes->set(
				$fieldData, $viewType, $r_name, $r_typeName, $r_multiple,
				$r_langLabel, $langView, $nameListCode, $nameSingleCode,
				$placeholders, true
			);

			if (!ArrayHelper::check($r_fieldValues))
			{
				continue;
			}

			if ($r_typeName === 'ModalSelect')
			{
				$r_fieldValues['custom'] = $this->modalselect->extract($r_fieldValues);
			}

			$subform[$r_name] = [
				'name' => $r_name,
				'type' => $r_typeName,
				'link' => $this->setLinkerRelations($r_fieldValues['custom'] ?? [])
			];

			if ($this->groups->check($r_typeName, 'option'))
			{
				$field .= $this->getSubformField(
					'option', $r_fieldValues, $r_name, $subform, $r_typeName, $langView,
					$nameSingleCode, $nameListCode, $placeholders, $r_optionArray, null, $r_taber
				);
			}
			elseif ($r_typeName === 'subform')
			{
				$r_fieldValues['nested_depth'] = isset($fieldAttributes['nested_depth'])
					? ++$fieldAttributes['nested_depth'] : 1;

				if ($r_fieldValues['nested_depth'] <= 20)
				{
					$subform[$r_name]['fields'] = [];
					$field .= $this->getSubformField(
						'special', $r_fieldValues, $r_name, $subform[$r_name]['fields'], $r_typeName, $langView,
						$nameSingleCode, $nameListCode, $placeholders, $r_optionArray, null, $r_taber
					);
				}
			}
			elseif (isset($r_fieldValues['custom']) && ArrayHelper::check($r_fieldValues['custom']))
			{
				$custom = $r_fieldValues['custom'];
				unset($r_fieldValues['custom']);

				$field .= $this->getSubformField(
					'custom', $r_fieldValues, $r_name, $subform, $r_typeName, $langView,
					$nameSingleCode, $nameListCode, $placeholders, $r_optionArray, null, $r_taber
				);

				$r_listLangName = StringHelper::check($r_langLabel)
					? $r_langLabel
					: $langView . '_' . FieldHelper::safe($r_name, true);

				$this->language->set(
					$this->config->lang_target,
					$r_listLangName,
					StringHelper::safe($r_name, 'W')
				);

				$this->customfieldtypefile->set([
					'type'   => $r_typeName,
					'code'   => $r_name,
					'lang'   => $r_listLangName,
					'custom' => $custom
				], $nameListCode, $nameSingleCode);
			}
			else
			{
				$field .= $this->getSubformField(
					'plain', $r_fieldValues, $r_name, $subform, $r_typeName, $langView,
					$nameSingleCode, $nameListCode, $placeholders, $r_optionArray, null, $r_taber
				);
			}
		}

		// set the base subform details
		if ($new && $subform !== [])
		{
			$com_field = $this->componentfields->get("{$nameSingleCode}.{$name}", null);
			if ($com_field !== null)
			{
				$com_field['fields'] = $subform;
				$this->componentfields->set("{$nameSingleCode}.{$name}", $com_field);
			}
		}

		$field .= PHP_EOL . Indent::_(3) . $taber . "</form>";
		$field .= PHP_EOL . Indent::_(2) . $taber . "</field>";

		return $field;
	}

	/**
	 * Create a field using string manipulation
	 *
	 * @param   string      $setType          The set of fields type
	 * @param   array       $fieldAttributes  The field values
	 * @param   string      $name             The field name
	 * @param   array       $subform          The current subform
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
	 * @since   5.1.1
	 */
	private function getSubformField(string $setType, array &$fieldAttributes, string $name, array &$subform,
		string $typeName, string $langView, string $nameSingleCode, string $nameListCode,
		array $placeholders, ?array &$optionArray, ?array $custom = null, string $taber = ''): string
	{
		$this->counter->field++;

		switch ($setType)
		{
			case 'option':
				return $this->buildOptionField($fieldAttributes, $name, $typeName, $langView, $optionArray, $taber);

			case 'plain':
				return $this->buildPlainField($fieldAttributes, $name, $typeName, $taber);

			case 'spacer':
				return $this->buildSpacerField($fieldAttributes, $name, $typeName);

			case 'special':
				return $this->buildSpecialField($fieldAttributes, $name, $subform, $typeName, $langView,
					$nameSingleCode, $nameListCode, $placeholders, $taber);

			case 'custom':
				return $this->buildCustomField($fieldAttributes, $name, $typeName, $langView,
					$nameSingleCode, $nameListCode, $placeholders, $optionArray, $custom, $taber);

			default:
				return ''; // fallback, should never hit
		}
	}

	/**
	 * Build a repeatable field.
	 *
	 * @param   array       $fieldAttributes  The field values
	 * @param   string      $name             The field name
	 * @param   string      $typeName         The field type
	 * @param   string      $langView         The view language string
	 * @param   string      $nameSingleCode   The single view name
	 * @param   string      $nameListCode     The list view name
	 * @param   array       $placeholders     The placeholder map
	 * @param   string      $taber            The tab string
	 *
	 * @return  string  The repeatable field XML
	 * @since   5.1.1
	 */
	private function buildRepeatableField(array &$fieldAttributes, string $name, string $typeName, string $langView,
		string $nameSingleCode, string $nameListCode, array $placeholders, string $taber): string
	{
		$field = PHP_EOL . Indent::_(2) . "<!--" . Line::_(__LINE__, __CLASS__)
			. " " . ucfirst($name) . " Field. Type: " . StringHelper::safe($typeName, 'F')
			. ". (joomla) -->";

		$field .= PHP_EOL . Indent::_(2) . "<field";

		foreach ($fieldAttributes as $property => $value)
		{
			if ($property != 'fields')
			{
				$field .= PHP_EOL . Indent::_(3) . $property . '="' . $value . '"';
			}
		}

		$fieldsSets = $this->normalizeFieldsSet($fieldAttributes['fields']);

		if (!ArrayHelper::check($fieldsSets))
		{
			$field .= PHP_EOL . Indent::_(2) . "</field>";
			return $field;
		}

		$field .= ">";

		$field .= PHP_EOL . Indent::_(3) . '<fields name="' . $fieldAttributes['name'] . '_fields" label="">';
		$field .= PHP_EOL . Indent::_(4) . '<fieldset hidden="true" name="'
			. $fieldAttributes['name'] . '_modal" repeat="true">';

		$_resolverKey = $fieldAttributes['name'];
		$fieldsSets = $this->resolveFieldSetData($fieldsSets, $nameSingleCode, $nameListCode, $_resolverKey);

		foreach ($fieldsSets as $fieldData)
		{
			if (!ObjectHelper::check($fieldData['settings']))
			{
				continue;
			}

			$field .= $this->buildRepeatableSubField(
				$fieldData, $langView, $nameSingleCode, $nameListCode,
				$placeholders, $_resolverKey, Indent::_(3)
			);
		}

		$field .= PHP_EOL . Indent::_(4) . "</fieldset>";
		$field .= PHP_EOL . Indent::_(3) . "</fields>";
		$field .= PHP_EOL . Indent::_(2) . "</field>";

		return $field;
	}

	/**
	 * Normalize the field definition string into an array.
	 *
	 * @param   mixed  $fields  Comma-separated, integer, or GUID
	 *
	 * @return  array
	 * @since   5.1.1
	 */
	private function normalizeFieldsSet($fields): array
	{
		if (strpos((string) $fields, ',') !== false)
		{
			return explode(',', (string) $fields);
		}
		elseif (is_numeric($fields))
		{
			return [(int) $fields];
		}
		elseif (GuidHelper::valid($fields))
		{
			return [(string) $fields];
		}

		return [];
	}

	/**
	 * Resolve the field data from a set of IDs using the internal field service.
	 *
	 * @param   array   $fields           Field identifiers
	 * @param   string  $nameSingleCode   Single code
	 * @param   string  $nameListCode     List code
	 * @param   string  $_resolverKey     Resolver key
	 *
	 * @return  array
	 * @since   5.1.1
	 */
	private function resolveFieldSetData(array $fields, string $nameSingleCode, string $nameListCode, string $_resolverKey): array
	{
		return array_map(
			function ($id) use ($nameSingleCode, $nameListCode, $_resolverKey) {
				$field = ['field' => $id];
				$this->field->set($field, $nameSingleCode, $nameListCode, $_resolverKey);
				return $field;
			}, array_values($fields)
		);
	}

	/**
	 * Build a single subfield in repeatable context.
	 *
	 * @param   array   $fieldData
	 * @param   string  $langView
	 * @param   string  $nameSingleCode
	 * @param   string  $nameListCode
	 * @param   array   $placeholders
	 * @param   string  $_resolverKey
	 * @param   string  $taber
	 *
	 * @return  string
	 * @since   5.1.1
	 */
	private function buildRepeatableSubField(array $fieldData, string $langView, string $nameSingleCode,
		string $nameListCode, array $placeholders, string $_resolverKey, string $taber): string
	{
		$r_name = $this->name->get($fieldData, $nameListCode, $_resolverKey);
		$r_typeName = $this->typename->get($fieldData);
		$r_multiple = false;
		$viewType = 0;
		$r_langLabel = '';
		$r_optionArray = [];

		$r_fieldValues = $this->attributes->set(
			$fieldData, $viewType, $r_name, $r_typeName, $r_multiple,
			$r_langLabel, $langView, $nameListCode, $nameSingleCode,
			$placeholders, true
		);

		if (!ArrayHelper::check($r_fieldValues))
		{
			return '';
		}

		if ($this->groups->check($r_typeName, 'option'))
		{
			return $this->get('option', $r_fieldValues, $r_name, $r_typeName, $langView,
				$nameSingleCode, $nameListCode, $placeholders, $r_optionArray, null, $taber);
		}
		elseif (isset($r_fieldValues['custom']) && ArrayHelper::check($r_fieldValues['custom']))
		{
			$custom = $r_fieldValues['custom'];
			unset($r_fieldValues['custom']);

			$fieldXml = $this->get('custom', $r_fieldValues, $r_name, $r_typeName, $langView,
				$nameSingleCode, $nameListCode, $placeholders, $r_optionArray, null, $taber);

			$r_listLangName = StringHelper::check($r_langLabel)
				? $r_langLabel
				: $langView . '_' . FieldHelper::safe($r_name, true);

			$this->language->set($this->config->lang_target, $r_listLangName, StringHelper::safe($r_name, 'W'));

			$this->customfieldtypefile->set([
				'type'   => $r_typeName,
				'code'   => $r_name,
				'lang'   => $r_listLangName,
				'custom' => $custom
			], $nameListCode, $nameSingleCode);

			return $fieldXml;
		}

		return $this->get('plain', $r_fieldValues, $r_name, $r_typeName, $langView,
			$nameSingleCode, $nameListCode, $placeholders, $r_optionArray, null, $taber);
	}

	/**
	 * Build an option set from a raw option string.
	 *
	 * @param   string      $value        The raw options string
	 * @param   string      $typeName     The field type name
	 * @param   string      $langView     The view language prefix
	 * @param   array|null  $optionArray  Reference to option array being populated
	 * @param   string      $taber        Indentation string
	 *
	 * @return  string
	 * @since   5.1.1
	 */
	private function buildOptionSet(string $value, string $typeName, string $langView, ?array &$optionArray, string $taber): string
	{
		if (strtolower($typeName) === 'groupedlist' && strpos($value, ',') !== false && strpos($value, '@@') !== false)
		{
			return $this->buildGroupedOptionSet($value, $langView, $optionArray, $taber);
		}
		return $this->buildFlatOptionSet($value, $langView, $optionArray, $taber);
	}

	/**
	 * Build a grouped option set.
	 *
	 * @param   string      $value        The raw options string
	 * @param   string      $langView     The view language prefix
	 * @param   array|null  $optionArray  Reference to option array being populated
	 * @param   string      $taber        Indentation string
	 *
	 * @return  string
	 * @since   5.1.1
	 */
	private function buildGroupedOptionSet(string $value, string $langView, ?array &$optionArray, string $taber): string
	{
		$groups_ = [];
		$grouped_ = ['group' => [], 'option' => []];
		$order_ = [];
		$optionSet = '';

		$options = explode(',', $value);
		foreach ($options as $option)
		{
			if (strpos($option, '@@') !== false)
			{
				$valueKeyArray = explode('@@', $option);
				if (count($valueKeyArray) === 2)
				{
					$langValue = $langView . '_' . FieldHelper::safe($valueKeyArray[0], true);
					$this->language->set($this->config->lang_target, $langValue, $valueKeyArray[0]);
					$groups_[$valueKeyArray[1]] = PHP_EOL . Indent::_(1) . $taber . Indent::_(2) . '<group label="' . $langValue . '">';
					$order_['group' . $valueKeyArray[1]] = $valueKeyArray[1];
				}
			}
			elseif (strpos($option, '|') !== false)
			{
				$valueKeyArray = explode('|', $option);
				if (count($valueKeyArray) === 3)
				{
					$langValue = $langView . '_' . FieldHelper::safe($valueKeyArray[1], true);
					$this->language->set($this->config->lang_target, $langValue, $valueKeyArray[1]);
					$grouped_['group'][$valueKeyArray[2]][] = PHP_EOL . Indent::_(1) . $taber . Indent::_(3)
						. '<option value="' . $valueKeyArray[0] . '">' . PHP_EOL
						. Indent::_(1) . $taber . Indent::_(4) . $langValue . '</option>';
					$optionArray[$valueKeyArray[0]] = $langValue;
					$order_['group' . $valueKeyArray[2]] = $valueKeyArray[2];
				}
				else
				{
					$langValue = $langView . '_' . FieldHelper::safe($valueKeyArray[1], true);
					$this->language->set($this->config->lang_target, $langValue, $valueKeyArray[1]);
					$grouped_['option'][$valueKeyArray[0]] = PHP_EOL . Indent::_(1) . $taber . Indent::_(2)
						. '<option value="' . $valueKeyArray[0] . '">' . PHP_EOL
						. Indent::_(1) . $taber . Indent::_(3) . $langValue . '</option>';
					$optionArray[$valueKeyArray[0]] = $langValue;
					$order_['option' . $valueKeyArray[0]] = $valueKeyArray[0];
				}
			}
			else
			{
				$this->addOptionToGroupOrFlat($option, $langView, $optionSet, $grouped_, $optionArray, $taber);
				$order_['option' . $option] = $option;
			}
		}

		foreach ($order_ as $pointer_ => $_id)
		{
			$key_ = (strpos($pointer_, 'option') !== false) ? 'option' : 'group';

			if ($key_ === 'group' && isset($groups_[$_id]) && isset($grouped_[$key_][$_id]) && ArrayHelper::check($grouped_[$key_][$_id]))
			{
				$optionSet .= $groups_[$_id];
				foreach ($grouped_[$key_][$_id] as $option_)
				{
					$optionSet .= $option_;
				}
				$optionSet .= PHP_EOL . Indent::_(1) . $taber . Indent::_(2) . '</group>';
			}
			elseif (isset($grouped_[$key_][$_id]) && StringHelper::check($grouped_[$key_][$_id]))
			{
				$optionSet .= $grouped_[$key_][$_id];
			}
		}

		return $optionSet;
	}

	/**
	 * Build a flat option set.
	 *
	 * @param   string      $value        The raw options string
	 * @param   string      $langView     The view language prefix
	 * @param   array|null  $optionArray  Reference to option array being populated
	 * @param   string      $taber        Indentation string
	 *
	 * @return  string
	 * @since   5.1.1
	 */
	private function buildFlatOptionSet(string $value, string $langView, ?array &$optionArray, string $taber): string
	{
		$optionSet = '';
		$options = explode(',', $value);

		foreach ($options as $option)
		{
			if (strpos($option, '|') !== false)
			{
				list($v, $t) = explode('|', $option);
				$langValue = $langView . '_' . FieldHelper::safe($t, true);
				$this->language->set($this->config->lang_target, $langValue, $t);
				$optionSet .= PHP_EOL . Indent::_(1) . $taber . Indent::_(2) . '<option value="' . $v . '">'
					. PHP_EOL . Indent::_(1) . $taber . Indent::_(3) . $langValue . '</option>';
				$optionArray[$v] = $langValue;
			}
			else
			{
				$this->addOptionToLanguage($option, $langView, $optionSet, $optionArray, $taber);
			}
		}

		return $optionSet;
	}

	/**
	 * Add a plain option to the language array and option set.
	 *
	 * @param   string      $option        The value
	 * @param   string      $langView      The language prefix
	 * @param   string      $optionSet     Reference to string of options
	 * @param   array|null  $optionArray   Reference to option array
	 * @param   string      $taber         Tab string
	 *
	 * @return  void
	 * @since   5.1.1
	 */
	private function addOptionToLanguage(string $option, string $langView, string &$optionSet, ?array &$optionArray, string $taber): void
	{
		$langValue = $langView . '_' . FieldHelper::safe($option, true);
		$this->language->set($this->config->lang_target, $langValue, $option);
		$optionSet .= PHP_EOL . Indent::_(2) . $taber . Indent::_(1)
			. '<option value="' . $option . '">' . PHP_EOL
			. Indent::_(2) . $taber . Indent::_(2) . $langValue . '</option>';
		$optionArray[$option] = $langValue;
	}

	/**
	 * Add an option to grouped or flat mode as fallback.
	 *
	 * @param   string      $option
	 * @param   string      $langView
	 * @param   string      $optionSet
	 * @param   array       $grouped_
	 * @param   array|null  $optionArray
	 * @param   string      $taber
	 *
	 * @return  void
	 * @since   5.1.1
	 */
	private function addOptionToGroupOrFlat(string $option, string $langView, string &$optionSet, array &$grouped_, ?array &$optionArray, string $taber): void
	{
		$langValue = $langView . '_' . FieldHelper::safe($option, true);
		$this->language->set($this->config->lang_target, $langValue, $option);
		$grouped_['option'][$option] = PHP_EOL . Indent::_(1) . $taber . Indent::_(2)
			. '<option value="' . $option . '">' . PHP_EOL
			. Indent::_(1) . $taber . Indent::_(3) . $langValue . '</option>';
		$optionArray[$option] = $langValue;
	}

	/**
	 * Sets the linker relations for a field based on the provided link data.
	 *
	 * The method determines the type of link relation based on the presence of a table.
	 * If no table is provided, it assigns a type 2 with a null table, otherwise it assigns type 1.
	 * It also extracts additional values from the input array, such as component, entity, value, and key.
	 *
	 * @param array  $link  The link data which may contain 'table', 'component', 'view', 'text', and 'id'.
	 *
	 * @return array|null The structured linker relation array, or null if input is an empty array.
	 * @since  5.1.1
	 */
	private function setLinkerRelations(array $link): ?array
	{
		if ($link === [])
		{
			return null;
		}

		$linker = [
			'type' => empty($link['table']) ? 2 : 1,
			'table' => $link['table'] ?? null,
			'component' => $link['component'] ?? null,
			'entity' => $link['view'] ?? null,
			'value' => $link['text'] ?? null,
			'key' => $link['id'] ?? null
		];

		return $linker;
	}
}

