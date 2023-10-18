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

namespace VDM\Joomla\Componentbuilder\Compiler\Field;


use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Registry;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ListFieldClass;
use VDM\Joomla\Componentbuilder\Compiler\Builder\DoNotEscape;
use VDM\Joomla\Componentbuilder\Compiler\Placeholder;
use VDM\Joomla\Componentbuilder\Compiler\Customcode;
use VDM\Joomla\Componentbuilder\Compiler\Language;
use VDM\Joomla\Componentbuilder\Compiler\Field\Groups as FieldGroups;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\GetHelper;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Utilities\Base64Helper;
use VDM\Joomla\Utilities\String\FieldHelper;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\FieldHelper as UtilitiesFieldHelper;


/**
 * Compiler Field Attributes
 * 
 * @since 3.2.0
 */
final class Attributes
{
	/**
	 * The Config Class.
	 *
	 * @var   Config
	 * @since 3.2.0
	 */
	protected Config $config;

	/**
	 * The Registry Class.
	 *
	 * @var   Registry
	 * @since 3.2.0
	 */
	protected Registry $registry;

	/**
	 * The ListFieldClass Class.
	 *
	 * @var   ListFieldClass
	 * @since 3.2.0
	 */
	protected ListFieldClass $listfieldclass;

	/**
	 * The DoNotEscape Class.
	 *
	 * @var   DoNotEscape
	 * @since 3.2.0
	 */
	protected DoNotEscape $donotescape;

	/**
	 * The Placeholder Class.
	 *
	 * @var   Placeholder
	 * @since 3.2.0
	 */
	protected Placeholder $placeholder;

	/**
	 * The Customcode Class.
	 *
	 * @var   Customcode
	 * @since 3.2.0
	 */
	protected Customcode $customcode;

	/**
	 * The Language Class.
	 *
	 * @var   Language
	 * @since 3.2.0
	 */
	protected Language $language;

	/**
	 * The Groups Class.
	 *
	 * @var   FieldGroups
	 * @since 3.2.0
	 */
	protected FieldGroups $fieldgroups;

	/**
	 * Title Switch
	 *
	 * @var int
	 * @since 3.2.0
	 */
	private int $title;

	/**
	 * Alias Switch
	 *
	 * @var int
	 * @since 3.2.0
	 */
	private int $alias;

	/**
	 * Field Properties
	 *
	 * @var array
	 * @since 3.2.0
	 */
	private array $properties;

	/**
	 * PHP Tracking
	 *
	 * @var array
	 * @since 3.2.0
	 */
	private array $php;

	/**
	 * Field attributes
	 *
	 * @var array
	 * @since 3.2.0
	 */
	private array $attributes;

	/**
	 * Field custom switch
	 *
	 * @var bool
	 * @since 3.2.0
	 */
	private bool $custom;

	/**
	 * Field Custom Label
	 *
	 * @var string
	 * @since 3.2.0
	 */
	private string $customLabel;

	/**
	 * Field readonly switch
	 *
	 * @var bool
	 * @since 3.2.0
	 */
	private bool $readonly;

	/**
	 * Field View Type
	 *
	 * @var int
	 * @since 3.2.0
	 */
	private int $viewType;

	/**
	 * Field Name
	 *
	 * @var string
	 * @since 3.2.0
	 */
	private string $name;

	/**
	 * Field Type Name
	 *
	 * @var string
	 * @since 3.2.0
	 */
	private string $typeName;

	/**
	 * Field Multiple Switch
	 *
	 * @var bool
	 * @since 3.2.0
	 */
	private bool $multiple;

	/**
	 * Field Name Language Label
	 *
	 * @var string
	 * @since 3.2.0
	 */
	private string $langLabel;

	/**
	 * View Language String
	 *
	 * @var string
	 * @since 3.2.0
	 */
	private string $langView;

	/**
	 * View List Code
	 *
	 * @var string
	 * @since 3.2.0
	 */
	private string $nameListCode;

	/**
	 * View Single Code
	 *
	 * @var string
	 * @since 3.2.0
	 */
	private string $nameSingleCode;

	/**
	 * Field Placeholders
	 *
	 * @var array
	 * @since 3.2.0
	 */
	private array $placeholders;

	/**
	 * Repeatable Switch
	 *
	 * @var bool
	 * @since 3.2.0
	 */
	private bool $repeatable;

	/**
	 * Constructor.
	 *
	 * @param Config           $config           The Config Class.
	 * @param Registry         $registry         The Registry Class.
	 * @param ListFieldClass   $listfieldclass   The ListFieldClass Class.
	 * @param DoNotEscape      $donotescape      The DoNotEscape Class.
	 * @param Placeholder      $placeholder      The Placeholder Class.
	 * @param Customcode       $customcode       The Customcode Class.
	 * @param Language         $language         The Language Class.
	 * @param FieldGroups      $fieldgroups      The Groups Class.
	 *
	 * @since 3.2.0
	 */
	public function __construct(Config $config, Registry $registry, ListFieldClass $listfieldclass, DoNotEscape $donotescape, Placeholder $placeholder,
		Customcode $customcode, Language $language, FieldGroups $fieldgroups)
	{
		$this->config = $config;
		$this->registry = $registry;
		$this->listfieldclass = $listfieldclass;
		$this->donotescape = $donotescape;
		$this->placeholder = $placeholder;
		$this->customcode = $customcode;
		$this->language = $language;
		$this->fieldgroups = $fieldgroups;
	}

	/**
	 * set field attributes
	 *
	 * @param   array    $field           The field data
	 * @param   int      $viewType        The view type
	 * @param   string   $name            The field name
	 * @param   string   $typeName        The field type
	 * @param   bool     $multiple        The switch to set multiple selection option
	 * @param   string   $langLabel       The language string for field label
	 * @param   string   $langView        The language string of the view
	 * @param   string   $nameListCode    The list view name
	 * @param   string   $nameSingleCode  The single view name
	 * @param   array    $placeholders    The place holder and replace values
	 * @param   bool     $repeatable      The repeatable field switch
	 *
	 * @return  array The field attributes
	 * @since 3.2.0
	 */
	public function set(
		array $field, int $viewType, string $name, string $typeName,
		bool &$multiple, string &$langLabel, string $langView, string $nameListCode,
		string $nameSingleCode, array $placeholders, bool $repeatable = false
	): array
	{
		if (!$this->setSettings($field))
		{
			return [];
		}

		// initialise the empty attributes and other global values
		$this->initialise($viewType, $name, $typeName, $multiple, $langLabel,
			$langView, $nameListCode, $nameSingleCode, $placeholders, $repeatable);

		if (!$this->setProperties())
		{
			return $this->attributes;
		}

		// set the attributes
		$this->setAttributes();

		// update global ref passed value
		$multiple = $this->multiple;
		$langLabel = $this->langLabel;

		return $this->attributes;
	}

	/**
	 * set field settings
	 *
	 * @param   array    $field     The field data
	 *
	 * @return  bool true if settings was set
	 * @since 3.2.0
	 */
	private function setSettings(array $field): bool
	{
		if (isset($field['settings']))
		{
			$this->settings = $field['settings'];
			$this->alias = $field['alias'] ?? 0;
			$this->title = $field['title'] ?? 0;

			return true;
		}

		return false;
	}

	/**
	 * set field properties
	 *
	 * @return  bool true if settings was set
	 * @since 3.2.0
	 */
	private function setProperties(): bool
	{
		if (isset($this->settings->properties) && ArrayHelper::check($this->settings->properties))
		{
			$this->properties = $this->settings->properties;

			return true;
		}

		return false;
	}

	/**
	 * Set the attributes with properties
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	private function setAttributes(): void
	{
		foreach ($this->properties as $property)
		{
			$name = $property['name'] ?? 'error';
			$example = $property['example'] ?? 'error';
			$translatable = $property['translatable'] ?? 0;
			$mandatory = $property['mandatory'] ?? 0;

			$this->setValue(
				$this->modelValue(
					$this->getValue($name),
					$name,
					(int) $translatable
				),
				$name,
				$example,
				(int) $mandatory
			);
		}

		$this->setPHP();

		$this->extraAttributes();
	}

	/**
	 * Set the extra attributes
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	private function extraAttributes(): void
	{
		// do some nice twigs beyond the default
		if (isset($this->attributes['name']))
		{
			// check if we have class value for the list view of this field
			$listclass = GetHelper::between(
				$this->settings->xml, 'listclass="', '"'
			);
			if (StringHelper::check($listclass))
			{
				$this->listfieldclass->set($this->nameListCode . '.' . $this->attributes['name'], $listclass);
			}

			// check if we find reason to remove this field from being escaped
			$escaped = GetHelper::between(
				$this->settings->xml, 'escape="', '"'
			);
			if (StringHelper::check($escaped))
			{
				$this->donotescape->set($this->nameListCode . '.' .
					$this->attributes['name'], true);
			}

			// check if we have display switch for dynamic placement
			$display = GetHelper::between(
				$this->settings->xml, 'display="', '"'
			);
			if (StringHelper::check($display))
			{
				$this->attributes['display'] = $display;
			}

			// make sure validation is set if found (even it not part of field properties)
			if (!isset($this->attributes['validate']))
			{
				// check if we have validate (validation rule set)
				$validationRule = GetHelper::between(
					$this->settings->xml, 'validate="', '"'
				);
				if (StringHelper::check($validationRule))
				{
					$this->attributes['validate']
						= StringHelper::safe(
						$validationRule
					);
				}
			}

			// make sure ID is always readonly
			if ($this->attributes['name'] === 'id' && !$this->readonly)
			{
				$this->attributes['readonly'] = 'true';
			}
		}
	}

	/**
	 * Get XML value
	 *
	 * @param   string   $name   The property name
	 *
	 * @return  string|null   The property value
	 * @since 3.2.0
	 */
	private function getValue(string $name): ?string
	{
		if ($name === 'type')
		{
			return $this->getType();
		}

		if ($name === 'name')
		{
			return $this->getName();
		}

		if ($name === 'validate')
		{
			return $this->getValidation();
		}

		if (in_array($name, ['extension', 'directory', 'formsource']))
		{
			return $this->getXmlValue($name);
		}

		if (strpos((string) $name, 'type_php') !== false && $this->custom)
		{
			return $this->getTypePHP($name);
		}

		if ($name === 'prime_php' && $this->custom)
		{
			return $this->getPrimePHP($name);
		}

		if ($name === 'extends' && $this->custom)
		{
			return $this->getExtends();
		}

		if ($name === 'view' && $this->custom)
		{
			return $this->getView();
		}

		if ($name === 'views' && $this->custom)
		{
			return $this->getViews();
		}

		if ($name === 'component' && $this->custom)
		{
			return $this->getComponent();
		}

		if ($name === 'table' && $this->custom)
		{
			return $this->getTable();
		}

		if ($name === 'value_field' && $this->custom)
		{
			return $this->getValueField();
		}

		if ($name === 'key_field' && $this->custom)
		{
			return $this->getKeyField();
		}

		if ($name === 'button' && $this->repeatable && $this->custom)
		{
			return $this->removeButtonRepeatable();
		}

		if ($name === 'button' && $this->custom)
		{
			return $this->getButton();
		}

		if ($name === 'required' && 'repeatable' === $this->typeName)
		{
			return $this->removeRequired();
		}

		if ($this->viewType == 2 && in_array($name, ['readonly', 'disabled']))
		{
			return $this->setReadonly($name);
		}

		if ($name === 'multiple')
		{
			return $this->getMultiple($name);
		}

		if ($name === 'class' && in_array($this->typeName, ['note', 'spacer']))
		{
			return $this->getClass();
		}

		// Default action if no condition is met
		return $this->getXmlValue($name);
	}

	/**
	 * Model the found value
	 *
	 * @param   string|null   $value          The property value
	 * @param   string        $name           The property name
	 * @param   int           $translatable   Switch to set translation
	 *
	 * @return  string|null   The property value
	 * @since 3.2.0
	 */
	private function modelValue(?string $value, string $name, int $translatable): ?string
	{
		// check if translatable
		if ($value !== null && StringHelper::check($value)
			&& $translatable == 1)
		{
			// update label if field use multiple times
			if ($name === 'label')
			{
				if (isset($this->attributes['name'])
					&& $this->registry->get("unique.names." . $this->nameListCode . ".names." . $this->attributes['name']) !== null)
				{
					$value .= ' ('
						. StringHelper::safe(
							$this->registry->get("unique.names." . $this->nameListCode . ".names." . $this->attributes['name'])
						) . ')';
				}
			}

			// replace placeholders
			$value = $this->placeholder->update(
				$value, $this->placeholders
			);

			// insure custom labels don't get messed up
			if ($this->custom)
			{
				$this->customLabel = $value;
			}

			// set lang key
			$lang_value = $this->langView . '_'
				. FieldHelper::safe(
					$this->name . ' ' . $name, true
				);

			// add to lang array
			$this->language->set($this->config->lang_target, $lang_value, $value);

			// use lang value
			$value = $lang_value;
		}
		elseif ($this->alias && $translatable == 1)
		{
			if ($name === 'label')
			{
				$value = 'JFIELD_ALIAS_LABEL';
			}
			elseif ($name === 'description')
			{
				$value = 'JFIELD_ALIAS_DESC';
			}
			elseif ($name === 'hint')
			{
				$value = 'JFIELD_ALIAS_PLACEHOLDER';
			}
		}
		elseif ($this->title && $translatable == 1)
		{
			if ($name === 'label')
			{
				$value = 'JGLOBAL_TITLE';
			}
		}

		return $value;
	}

	/**
	 * set the found value
	 *
	 * @param   string|null   $value          The property value
	 * @param   string        $name           The property name
	 * @param   string        $example        The example value
	 * @param   int           $mandatory      The mandatory switch
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	private function setValue(?string $value, string $name, string $example, int $mandatory): void
	{
		// only load value if found or is mandatory
		if (($value !== null && StringHelper::check($value))
			|| ($mandatory == 1 && !$this->custom))
		{
			// make sure mandatory fields are added
			if ($value === null || !StringHelper::check($value))
			{
				$value = $example;
			}

			// load to langBuilder down the line
			if ($name === 'label')
			{
				if ($this->custom)
				{
					$this->attributes['custom']['label'] = $this->customLabel ?? 'error';
				}

				$this->langLabel = $value;
			}

			// now set the value
			$this->attributes[$name] = $value;
		}
		// validate that the default field is set
		elseif ($name === 'default'
			&& ($xmlValidateValue = GetHelper::between(
				$this->settings->xml, 'default="', '"', 'none-set'
			)) !== 'none-set')
		{
			// we must allow empty defaults
			$this->attributes['default'] = $value;
		}
	}

	/**
	 * Set PHP if needed
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	private function setPHP(): void
	{
		// check if all php is loaded using the tracker
		if (ArrayHelper::check($this->php))
		{
			// little search validation
			$confirmation = '8qvZHoyuFYQqpj0YQbc6F3o5DhBlmS-_-a8pmCZfOVSfANjkmV5LG8pCdAY2JNYu6cB';
			foreach ($this->php as $search_key => $php_key)
			{
				// we must search for more code in the xml just encase
				foreach (range(2, 30) as $php_line)
				{
					$get_ = $search_key . '_' . $php_line;
					if (!isset($this->attributes['custom'][$php_key][$php_line])
						&& ($value = UtilitiesFieldHelper::getValue(
							$this->settings->xml, $get_, $confirmation
						)) !== $confirmation)
					{
						$this->attributes['custom'][$php_key][$php_line]
							= $this->customcode->update(
							Base64Helper::open($value)
						);
					}
				}
			}
		}
	}

	/**
	 * get an xml value (default)
	 *
	 * @param   string   $name   The property name
	 *
	 * @return  string|null
	 * @since 3.2.0
	 */
	private function getXmlValue(string $name): ?string
	{
		// get value & replace the placeholders
		return $this->placeholder->update(
			GetHelper::between(
				$this->settings->xml, $name . '="', '"'
			), $this->placeholders
		);
	}

	/**
	 * get type value
	 *
	 * @return  string
	 * @since 3.2.0
	 */
	private function getType(): string
	{
		// add to custom if it is custom
		if ($this->custom)
		{
			// set the type just to make sure.
			$this->attributes['custom']['type'] = $this->typeName;
		}

		return $this->typeName;
	}

	/**
	 * get name value
	 *
	 * @return  string
	 * @since 3.2.0
	 */
	private function getName(): string
	{
		// get the actual field name
		return $this->placeholder->update($this->name, $this->placeholders);
	}

	/**
	 * get validation value
	 *
	 * @return  string|null
	 * @since 3.2.0
	 */
	private function getValidation(): ?string
	{
		// check if we have validate (validation rule set)
		$value = GetHelper::between(
			$this->settings->xml, 'validate="', '"'
		);

		if (StringHelper::check($value))
		{
			$value = StringHelper::safe(
				$value
			);
		}

		return $value;
	}

	/**
	 * get type PHP code
	 *
	 * @param   string   $name   The property name
	 *
	 * @return  string|null
	 * @since 3.2.0
	 */
	private function getTypePHP(string $name): ?string
	{
		// set the line number
		$line = (int) preg_replace(
			'/[^0-9]/', '', (string) $name
		);

		// set the type key
		$key = (string) trim(
			str_replace(
				'type_', '',
				preg_replace('/[0-9]+/', '', (string) $name)
			), '_'
		);

		// load the php for the custom field file
		$this->attributes['custom'][$key][$line]
			=  $this->customcode->update(
			Base64Helper::open(
				GetHelper::between(
					$this->settings->xml,
					$name . '="', '"'
				)
			)
		);

		// load tracker
		$this->php['type_' . $key] = $key;

		return null;
	}

	/**
	 * get prime PHP code
	 *
	 * @param   string   $name   The property name
	 *
	 * @return  string|null
	 * @since 3.2.0
	 */
	private function getPrimePHP(string $name): ?string
	{
		// load the php for the custom field file
		$this->attributes['custom']['prime_php']
			= (int) GetHelper::between(
			$this->settings->xml, $name . '="', '"'
		);

		return null;
	}

	/**
	 * get extends value
	 *
	 * @return  string|null
	 * @since 3.2.0
	 */
	private function getExtends(): ?string
	{
		// load the class that is being extended
		$this->attributes['custom']['extends']
			= GetHelper::between(
			$this->settings->xml, 'extends="', '"'
		);

		return null;
	}

	/**
	 * get view value
	 *
	 * @return  string|null
	 * @since 3.2.0
	 */
	private function getView(): ?string
	{
		// load the view name & replace the placeholders
		$this->attributes['custom']['view']
			= StringHelper::safe(
			$this->placeholder->update(
				GetHelper::between(
					$this->settings->xml, 'view="', '"'
				), $this->placeholders
			)
		);

		return null;
	}

	/**
	 * get views value
	 *
	 * @return  string|null
	 * @since 3.2.0
	 */
	private function getViews(): ?string
	{
		// load the views name & replace the placeholders
		$this->attributes['custom']['views']
			= StringHelper::safe(
			$this->placeholder->update(
				GetHelper::between(
					$this->settings->xml, 'views="', '"'
				), $this->placeholders
			)
		);

		return null;
	}

	/**
	 * get component value
	 *
	 * @return  string|null
	 * @since 3.2.0
	 */
	private function getComponent(): ?string
	{
		// load the component name & replace the placeholders
		$this->attributes['custom']['component']
			= $this->placeholder->update(
			GetHelper::between(
				$this->settings->xml, 'component="', '"'
			), $this->placeholders
		);

		return null;
	}

	/**
	 * get table value
	 *
	 * @return  string|null
	 * @since 3.2.0
	 */
	private function getTable(): ?string
	{
		// load the main table that is queried & replace the placeholders
		$this->attributes['custom']['table']
			= $this->placeholder->update(
			GetHelper::between(
				$this->settings->xml, 'table="', '"'
			), $this->placeholders
		);

		return null;
	}

	/**
	 * get value field
	 *
	 * @return  string|null
	 * @since 3.2.0
	 */
	private function getValueField(): ?string
	{
		// load the text key
		$this->attributes['custom']['text']
			= StringHelper::safe(
			GetHelper::between(
				$this->settings->xml, 'value_field="', '"'
			)
		);

		return null;
	}

	/**
	 * get key field value
	 *
	 * @return  string|null
	 * @since 3.2.0
	 */
	private function getKeyField(): ?string
	{
		// load the id key
		$this->attributes['custom']['id']
			= StringHelper::safe(
			GetHelper::between(
				$this->settings->xml, 'key_field="', '"'
			)
		);

		return null;
	}

	/**
	 * remove the button on repeatable
	 *
	 * @return  string
	 * @since 3.2.0
	 */
	private function removeButtonRepeatable(): string
	{
		// do not add button
		$this->attributes['custom']['add_button'] = 'false';

		// don't load the button to repeatable
		return 'false';
	}

	/**
	 * get button value
	 *
	 * @return  string|null
	 * @since 3.2.0
	 */
	private function getButton(): ?string
	{
		// load the button string value if found
		$value = (string) StringHelper::safe(
			GetHelper::between(
				$this->settings->xml, 'button="', '"'
			)
		);

		// add to custom values
		$this->attributes['custom']['add_button']
			= (StringHelper::check($value)
			|| 1 == $value) ? $value : 'false';

		return $value;
	}

	/**
	 * remove the required value
	 *
	 * @return  string
	 * @since 3.2.0
	 */
	private function removeRequired(): string
	{
		// don't load the required to repeatable field type
		return 'false';
	}

	/**
	 * set the readonly switch
	 *
	 * @param   string   $name   The property name
	 *
	 * @return  string
	 * @since 3.2.0
	 */
	private function setReadonly(string $name): string
	{
		// trip the switch for readonly
		if ($name === 'readonly')
		{
			$this->readonly = true;
		}

		// set read only
		return 'true';
	}

	/**
	 * set the multiple switch
	 *
	 * @param   string   $name   The property name
	 *
	 * @return  string
	 * @since 3.2.0
	 */
	private function getMultiple(string $name): string
	{
		$value = (string) GetHelper::between(
			$this->settings->xml, $name . '="', '"'
		);

		// add the multiple
		if ('true' === $value)
		{
			$this->multiple = true;
		}

		return $value;
	}

	/**
	 * get class value
	 *
	 * @return  string
	 * @since 3.2.0
	 */
	private function getClass(): string
	{
		$value = GetHelper::between(
			$this->settings->xml, 'class="', '"'
		);

		// add the type class
		if (StringHelper::check($value))
		{
			if (strpos($value, $this->name) === false)
			{
				$value = $value . ' ' . $this->name;
			}

			return $value;
		}

		return $this->name;
	}

	/**
	 * Initialise the attributes and other global values
	 *
	 * @param   int      $viewType        The view type
	 * @param   string   $name            The field name
	 * @param   string   $typeName        The field type
	 * @param   bool     $multiple        The switch to set multiple selection option
	 * @param   string   $langLabel       The language string for field label
	 * @param   string   $langView        The language string of the view
	 * @param   string   $nameListCode    The list view name
	 * @param   string   $nameSingleCode  The single view name
	 * @param   array    $placeholders    The place holder and replace values
	 * @param   bool     $repeatable      The repeatable field switch
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	private function initialise(int $viewType, string $name, string $typeName,
		bool $multiple, string $langLabel, string $langView, string $nameListCode,
		string $nameSingleCode, array $placeholders, bool $repeatable): void
	{
		$this->attributes     = [];
		$this->php            = [];
		$this->custom         = false;
		$this->readonly       = false;
		$this->viewType       = $viewType;
		$this->name           = $name;
		$this->typeName       = $typeName;
		$this->multiple       = $multiple;
		$this->langLabel      = $langLabel;
		$this->langView       = $langView;
		$this->nameListCode   = $nameListCode;
		$this->nameSingleCode = $nameSingleCode;
		$this->placeholders   = $placeholders;
		$this->repeatable     = $repeatable;

		// setup Joomla default fields
		if (!$this->fieldgroups->check($typeName))
		{
			$this->attributes['custom'] = [];

			// is this an own custom field
			if (isset($this->settings->own_custom))
			{
				$this->attributes['custom']['own_custom'] 
					= $this->settings->own_custom;
			}
			$this->custom = true;
		}
	}
}

