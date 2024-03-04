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


use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Application\CMSApplication;
use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ContentOne as Content;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ContentMulti as Contents;
use VDM\Joomla\Componentbuilder\Compiler\Builder\SiteFieldData as SiteField;
use VDM\Joomla\Componentbuilder\Compiler\Placeholder;
use VDM\Joomla\Componentbuilder\Compiler\Language;
use VDM\Joomla\Componentbuilder\Compiler\Component\Placeholder as ComponentPlaceholder;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Structure;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Field\InputButtonInterface as InputButton;
use VDM\Joomla\Componentbuilder\Compiler\Builder\FieldGroupControl;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ExtensionCustomFields;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\HeaderInterface as Header;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Field\CoreFieldInterface as CoreField;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Utilities\String\ClassfunctionHelper;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Placefix;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;
use VDM\Joomla\Utilities\String\FieldHelper;


/**
 * Custom Field Type File Creator Class
 * 
 * @since 3.2.0
 */
final class CustomFieldTypeFile
{
	/**
	 * The Config Class.
	 *
	 * @var   Config
	 * @since 3.2.0
	 */
	protected Config $config;

	/**
	 * The ContentOne Class.
	 *
	 * @var   Content
	 * @since 3.2.0
	 */
	protected Content $content;

	/**
	 * The ContentMulti Class.
	 *
	 * @var   Contents
	 * @since 3.2.0
	 */
	protected Contents $contents;

	/**
	 * The SiteFieldData Class.
	 *
	 * @var   SiteField
	 * @since 3.2.0
	 */
	protected SiteField $sitefield;

	/**
	 * The Placeholder Class.
	 *
	 * @var   Placeholder
	 * @since 3.2.0
	 */
	protected Placeholder $placeholder;

	/**
	 * The Language Class.
	 *
	 * @var   Language
	 * @since 3.2.0
	 */
	protected Language $language;

	/**
	 * The Placeholder Class.
	 *
	 * @var   ComponentPlaceholder
	 * @since 3.2.0
	 */
	protected ComponentPlaceholder $componentplaceholder;

	/**
	 * The Structure Class.
	 *
	 * @var   Structure
	 * @since 3.2.0
	 */
	protected Structure $structure;

	/**
	 * The InputButton Class.
	 *
	 * @var   InputButton
	 * @since 3.2.0
	 */
	protected InputButton $inputbutton;

	/**
	 * The FieldGroupControl Class.
	 *
	 * @var   FieldGroupControl
	 * @since 3.2.0
	 */
	protected FieldGroupControl $fieldgroupcontrol;

	/**
	 * The ExtensionCustomFields Class.
	 *
	 * @var   ExtensionCustomFields
	 * @since 3.2.0
	 */
	protected ExtensionCustomFields $extensioncustomfields;

	/**
	 * The HeaderInterface Class.
	 *
	 * @var   Header
	 * @since 3.2.0
	 */
	protected Header $header;

	/**
	 * The CoreFieldInterface Class.
	 *
	 * @var   CoreField
	 * @since 3.2.0
	 */
	protected CoreField $corefield;

	/**
	 * The core field mapper.
	 *
	 * @var   array
	 * @since 3.2.0
	 */
	protected array $fieldmap = [];

	/**
	 * Application object.
	 *
	 * @var    CMSApplication
	 * @since 3.2.0
	 **/
	protected CMSApplication $app;

	/**
	 * Array of php fields Allowed (15)
	 *
	 * @var    array
	 * @since 3.2.0
	 **/
	protected array $phpFieldArray = ['', 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'x'];

	/**
	 * The Local Placeholder Values.
	 *
	 * @var   array
	 * @since 3.2.0
	 */
	protected array $placeholders = [];

	/**
	 * The field data values.
	 *
	 * @var   array
	 * @since 3.2.0
	 */
	protected array $data;

	/**
	 * The List Code Name value.
	 *
	 * @var   string
	 * @since 3.2.0
	 */
	protected string $nameListCode;

	/**
	 * The Single Code Name value.
	 *
	 * @var   string
	 * @since 3.2.0
	 */
	protected string $nameSingleCode;

	/**
	 * The contents key value.
	 *
	 * @var   string
	 * @since 3.2.0
	 */
	protected string $contentsKey;

	/**
	 * The type field value.
	 *
	 * @var   string
	 * @since 3.2.0
	 */
	protected string $type;

	/**
	 * The base type field value.
	 *
	 * @var   string
	 * @since 3.2.0
	 */
	protected string $baseType;

	/**
	 * The raw type field value.
	 *
	 * @var   string
	 * @since 3.2.0
	 */
	protected string $rawType;

	/**
	 * The switch to check if the custom
	 *  type field value was set.
	 *
	 * @var   bool
	 * @since 3.2.0
	 */
	protected bool $customTypeWasSet;

	/**
	 * The extends field value.
	 *
	 * @var   string
	 * @since 3.2.0
	 */
	protected string $extends;

	/**
	 * Constructor.
	 *
	 * @param Config                  $config                  The Config Class.
	 * @param Content                 $content                 The ContentOne Class.
	 * @param Contents                $contents                The ContentMulti Class.
	 * @param SiteField               $sitefield               The SiteFieldData Class.
	 * @param Placeholder             $placeholder             The Placeholder Class.
	 * @param Language                $language                The Language Class.
	 * @param ComponentPlaceholder    $componentplaceholder    The Placeholder Class.
	 * @param Structure               $structure               The Structure Class.
	 * @param InputButton             $inputbutton             The InputButton Class.
	 * @param FieldGroupControl       $fieldgroupcontrol       The FieldGroupControl Class.
	 * @param ExtensionCustomFields   $extensioncustomfields   The ExtensionCustomFields Class.
	 * @param Header                  $header                  The HeaderInterface Class.
	 * @param CoreField               $corefield               The CoreFieldInterface Class.
	 * @param CMSApplication|null     $app                     The app object.
	 *
	 * @since 3.2.0
	 */
	public function __construct(Config $config, Content $content, Contents $contents,
		SiteField $sitefield, Placeholder $placeholder,
		Language $language,
		ComponentPlaceholder $componentplaceholder,
		Structure $structure, InputButton $inputbutton,
		FieldGroupControl $fieldgroupcontrol,
		ExtensionCustomFields $extensioncustomfields,
		Header $header, CoreField $corefield, ?CMSApplication $app = null)
	{
		$this->config = $config;
		$this->content = $content;
		$this->contents = $contents;
		$this->sitefield = $sitefield;
		$this->placeholder = $placeholder;
		$this->language = $language;
		$this->componentplaceholder = $componentplaceholder;
		$this->structure = $structure;
		$this->inputbutton = $inputbutton;
		$this->fieldgroupcontrol = $fieldgroupcontrol;
		$this->extensioncustomfields = $extensioncustomfields;
		$this->header = $header;
		$this->corefield = $corefield;
		$this->app = $app ?: Factory::getApplication();
	}

	/**
	 * Set Custom Field Type File
	 *
	 * This method handles the setting of a custom field type. It checks if the field has already been built,
	 * handles namespace in the custom field type name, sets various placeholders, and loads the global placeholders.
	 * Additionally, it manages the setting of dynamic contents based on the field type and other configurations.
	 *
	 * @param   array   $data            The field complete data set
	 * @param   string  $nameListCode    The list view code name
	 * @param   string  $nameSingleCode  The single view code name
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function set(array $data, string $nameListCode, string $nameSingleCode): void
	{
		$this->setTypeName($data);

		if (!$this->isFieldBuildable($data))
		{
			return;
		}

		$this->init($data, $nameSingleCode, $nameListCode);

		if (isset($data['custom']['own_custom']))
		{
			$this->handleOwnCustomField();
		}
		else
		{
			$this->handleStandardCustomField();
		}

		// Extension custom fields tracking for plugins or modules
		$this->trackExtensionCustomFields();
	}

	/**
	 * Set the type name of the custom field.
	 *
	 * This function checks if there is a namespace in the field type name (indicated by a dot).
	 * If a namespace exists, it extracts and removes the namespace from the type name.
	 *
	 * @param array $data The field data which contains the type name.
	 *
	 * @return void
	 * @since 3.2.0
	 */
	private function setTypeName(array $data): void
	{
		$type_name = $this->rawType = $data['type'] ?? '';

		$this->customTypeWasSet = isset($data['custom']['type']);

		// Check if the field type name contains a dot, indicating a namespace
		if (strpos($type_name, '.') !== false)
		{
			$dot_type_array = explode('.', $type_name);

			// If there are more than one parts, remove the first part (namespace)
			if (count($dot_type_array) > 1)
			{
				array_shift($dot_type_array); // Remove the namespace part
			}

			// Update the type name by concatenating the remaining parts
			$type_name = implode('', $dot_type_array);
			$data['custom']['type'] = ClassfunctionHelper::safe($type_name);
		}

		$base_type = $data['custom']['type'] ?? $type_name;

		$this->baseType = ClassfunctionHelper::safe($base_type);
		$this->type = ClassfunctionHelper::safe($type_name);
	}

	/**
	 * Checks if the field is eligible to be built.
	 *
	 * This method examines the 'custom' attribute of the field data to determine if the field has
	 * already been built or if it is marked as 'prime'. It returns true if the field should be built,
	 * and false otherwise.
	 *
	 * @param array $data The field data.
	 *
	 * @return bool True if the field is buildable, false otherwise.
	 * @since 3.2.0
	 */
	private function isFieldBuildable(array $data): bool
	{
		// Check if 'custom' key is set in the data.
		if (!isset($data['custom']))
		{
			return false;
		}

		// Check if 'extends' key is set under 'custom'.
		if (!isset($data['custom']['extends']))
		{
			return false;
		}

		// Check if the field is marked as 'prime' or if it hasn't been built yet.
		$isPrime = isset($data['custom']['prime_php']) && $data['custom']['prime_php'] == 1;
		$notBuilt = !$this->contents->isArray('customfield_' . $this->type);

		return $isPrime || $notBuilt;
	}

	/**
	 * The function to set the class values to the current field being build.
	 *
	 * @param   array   $data            The field complete data set
	 * @param   string  $nameListCode    The list view code name
	 * @param   string  $nameSingleCode  The single view code name
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	private function init(array $data, string $nameListCode, string $nameSingleCode): void
	{
		$this->data = $data;
		$this->nameListCode = $nameListCode;
		$this->nameSingleCode = $nameSingleCode;
		$this->contentsKey = "customfield_{$this->baseType}|";

		$this->jprefix = $this->determineJPrefix();
		$this->extends = ClassfunctionHelper::safe($data['custom']['extends']);

		$this->setLocalPlaceholders();
		$this->setContentPlaceholders();
	}

	/**
	 * The function to set the default content placeholder.
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	private function setContentPlaceholders(): void
	{
		$contents_key = $this->contentsKey;

		// Start loading the field type
		$this->contents->set("{$contents_key}JPREFIX", $this->jprefix);

		$this->contents->set("{$contents_key}JFORM_extends", $this->extends);
		$this->contents->set("{$contents_key}JFORM_EXTENDS",
			StringHelper::safe($this->extends, 'F')
		);

		// if own custom field
		if (isset($this->data['custom']['own_custom']))
		{
			$this->contents->set("{$contents_key}FORM_EXTENDS",
				$this->getClassNameExtends()
			);
		}

		$this->contents->set("{$contents_key}type", $this->baseType);
		$this->contents->set("{$contents_key}Type",
			StringHelper::safe($this->baseType, 'F')
		);
	}

	/**
	 * Determines the J prefix for the field type.
	 *
	 * This method extracts the prefix from the field type name if it contains a dot, indicating namespace usage.
	 * If no dot is present, it defaults to 'J'.
	 *
	 * @return  string  The determined J prefix.
	 * @since 3.2.0
	 */
	private function determineJPrefix(): string
	{
		// Default prefix
		$jprefix = 'J';

		// Check if the field type name contains a dot, indicating namespace usage
		if (strpos($this->rawType, '.') !== false)
		{
			// Explode the type by dot to get the namespace parts
			$dot_type_array = explode('.', $this->rawType);

			// If there are multiple parts, use the first part as the prefix
			if (count($dot_type_array) > 1)
			{
				$jprefix = strtoupper(array_shift($dot_type_array));
			}
		}

		return $jprefix;
	}

	/**
	 * Set placeholder options for the custom field.
	 *
	 * This method maps various data points to their corresponding placeholders.
	 * It takes custom field data, view codes, and a J prefix, and prepares an associative array
	 * of placeholders and their values.
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	private function setLocalPlaceholders(): void
	{
		// The data set for the custom field
		$data = $this->data;

		// Initialize the array for placeholder options
		$placeholders = [];

		// Populate the array with specific placeholder options
		$placeholders[Placefix::_('JPREFIX')] = $this->jprefix;

		$placeholders[Placefix::_('JFORM_extends')] = $this->extends;
		$placeholders[Placefix::_('JFORM_EXTENDS')] = StringHelper::safe($this->extends, 'F');

		// if own custom field
		if (isset($data['custom']['own_custom']))
		{
			$placeholders[Placefix::_('FORM_EXTENDS')] = $this->getClassNameExtends();
		}

		$placeholders[Placefix::_('TABLE')] = $data['custom']['table'] ?? '';
		$placeholders[Placefix::_('ID')] = $data['custom']['id'] ?? '';
		$placeholders[Placefix::_('TEXT')] = $data['custom']['text'] ?? '';
		$placeholders[Placefix::_('CODE_TEXT')] =
			isset($data['code'], $data['custom']['text']) ? $data['code'] . '_' . $data['custom']['text'] : '';
		$placeholders[Placefix::_('CODE')] = $data['code'] ?? '';

		$placeholders[Placefix::_('com_component')] = $this->getComComponentName();
		$placeholders[Placefix::_('component')] = $this->config->component_code_name;
		$placeholders[Placefix::_('Component')] = $this->content->get('Component');

		$placeholders[Placefix::_('type')] = $this->baseType;
		$placeholders[Placefix::_('Type')] = StringHelper::safe($this->baseType, 'F');

		$placeholders[Placefix::_('view_type')] = $this->getViewName() . '_' . $this->baseType;
		$placeholders[Placefix::_('view')] = $this->getViewName();
		$placeholders[Placefix::_('views')] = $this->getViewsName();

		// Gymnastics to help with transition to Joomla 4
		if ($this->config->get('joomla_version', 3) == 4)
		{
			$placeholders['JFactory::getUser()'] = 'Factory::getApplication()->getIdentity()';
			$placeholders['Factory::getUser()'] = 'Factory::getApplication()->getIdentity()';
			$placeholders['JFactory::'] = 'Factory::';
			$placeholders['JHtml::'] = 'Html::';
			$placeholders['JText::'] = 'Text::';
			$placeholders['JComponentHelper::'] = 'ComponentHelper::';
			$placeholders['\JComponentHelper::'] = 'ComponentHelper::';
		}

		$this->placeholders = $placeholders;

		$this->updatePlaceholderValues();
		$this->loadGlobalPlaceholders();
	}

	/**
	 * Gets the component name for the custom field.
	 *
	 * This method extracts the component name from the custom field data.
	 * If the component name is explicitly set in the custom field data,
	 * it returns that name after ensuring it's a safe string. Otherwise,
	 * it defaults to a name constructed from the component code name in the configuration.
	 *
	 * @return  string    The name of the component.
	 * @since 3.2.0
	 */
	private function getComComponentName(): string
	{
		// Check if the component name is explicitly set in the custom field data
		if (isset($this->data['custom']['component']) && StringHelper::check($this->data['custom']['component']))
		{
			// Return the safe version of the component name
			return StringHelper::safe($this->data['custom']['component']);
		}

		// Default to a component name constructed from the component code name in the configuration
		return 'com_' . $this->config->component_code_name;
	}

	/**
	 * Determines the view name for a custom field.
	 *
	 * This method extracts the view name from the custom field data, with a fallback
	 * to a provided single view code name if the view name is not explicitly set in the data.
	 *
	 * @return  string    The determined view name.
	 * @since 3.2.0
	 */
	private function getViewName(): string
	{
		// Check if a specific view name is set in the custom field data
		if (isset($this->data['custom']['view']) && StringHelper::check($this->data['custom']['view']))
		{
			// If a specific view name is set, use it after sanitizing
			return StringHelper::safe($this->data['custom']['view']);
		}

		// If no specific view name is set, use the single view code name as a fallback
		return $this->nameSingleCode;
	}

	/**
	 * Gets the formatted name for the views associated with the custom field.
	 *
	 * This method checks if a specific views name is provided in the custom field data.
	 * If it is, it formats and returns this name. If not, it defaults to the provided list view name.
	 *
	 * @return  string    The formatted name for the views.
	 * @since 3.2.0
	 */
	private function getViewsName(): string
	{
		// Check if specific views name is provided in the custom field data
		if (isset($this->data['custom']['views']) && StringHelper::check($this->data['custom']['views']))
		{
			// If yes, use the provided name after ensuring it is properly formatted
			return StringHelper::safe($this->data['custom']['views']);
		}

		// If no specific name is provided, default to the provided list view name
		return $this->nameListCode;
	}

	/**
	 * Gets the class name being extended.
	 *
	 * This method is for the new namespace class name in Joomla 4 and above.
	 *
	 * @return  string    The class being name extended.
	 * @since 3.2.0
	 */
	private function getClassNameExtends(): string
	{
		if (isset($this->fieldmap[$this->extends]))
		{
			return $this->fieldmap[$this->extends];
		}

		$core_fields = $this->corefield->get();
		$extends = $this->extends;

		foreach ($core_fields as $core_field)
		{
			$field = strtolower((string) $core_field);
			if ($extends === $field)
			{
				$this->fieldmap[$extends] = $core_field;

				return $core_field;
			}
		}

		$this->fieldmap[$extends] = StringHelper::safe($extends, 'F');

		return $this->fieldmap[$extends];
	}

	/**
	 * Update placeholder values in the field data.
	 *
	 * This function iterates over the given replacements and applies them to the placeholders.
	 * It updates both the key and value of each placeholder, ensuring that they are correctly set.
	 *
	 * @return void
	 * @since 3.2.0
	 */
	private function updatePlaceholderValues(): void
	{
		foreach ($this->placeholders as $placeholder => $value)
		{
			// Update the key by replacing the placeholders for before and after
			$updatedPlaceholder = str_replace(
				[Placefix::b(), Placefix::d()],
				[Placefix::h(), Placefix::h()], 
				$placeholder
			);

			// Update the value in the replacements array
			$this->placeholders[$updatedPlaceholder] = $value;
		}
	}

	/**
	 * Load global placeholders into the placeholders array.
	 *
	 * This method iterates over the global placeholders and adds them to the replace array.
	 *
	 * @return void
	 * @since 3.2.0
	 */
	private function loadGlobalPlaceholders(): void
	{
		foreach ($this->componentplaceholder->get() as $globalPlaceholder => $globalValue)
		{
			$this->placeholders[$globalPlaceholder] = $globalValue;
		}
	}

	/**
	 * Handle the setting of a own custom field.
	 *
	 * This method manages the building of the custom field type file, the handling of PHP scripts,
	 * and specific operations for certain field types like user fields.
	 *
	 * @return void
	 * @since 3.2.0
	 */
	private function handleOwnCustomField(): void
	{
		if ($this->isButtonOptionSet())
		{
			$this->setButtonOptionErrorMessages();
		}

		$targets = [['admin' => 'customfield'], ['site' => 'customfield']];
		foreach ($targets as $target)
		{
			$this->structure->build($target, 'fieldcustom', $this->baseType);
		}

		$this->prepareCustomFieldHeader();
		$this->prepareCustomFieldBody();
	}

	/**
	 * Handle the setting of a standard custom field.
	 *
	 * This method manages the building of the custom field type file, the handling of PHP scripts,
	 * and specific operations for certain field types like user fields.
	 *
	 * @return void
	 * @since 3.2.0
	 */
	private function handleStandardCustomField(): void
	{
		// The key used for setting contents.
		$contents_key = $this->contentsKey;

		// Build the custom field type file
		$targets = [['admin' => 'customfield'], ['site' => 'customfield']];
		foreach ($targets as $target)
		{
			$this->structure->build(
				$target, 'field' . $this->extends, $this->baseType
			);
		}

		$php_code = $this->loadPhpScript('php');

		if ($this->extends === 'user')
		{
			$this->fieldgroupcontrol->set(
				$this->type, $this->generateGroupLanguageName()
			);
	
			$phpx_code = $this->loadPhpScript('phpx');

			$this->contents->set("{$contents_key}JFORM_GETGROUPS_PHP", $php_code);
			$this->contents->set("{$contents_key}JFORM_GETEXCLUDED_PHP", $phpx_code);
		}
		else
		{
			$this->contents->set("{$contents_key}JFORM_GETOPTIONS_PHP", $php_code);
		}

		$this->contents->set("{$contents_key}ADD_BUTTON", $this->inputbutton->get($this->data['custom']));
	}

	/**
	 * Checks if the button option is set for the custom field.
	 *
	 * This function examines the custom field data to determine if the 'add_button' option
	 * is set and configured to a truthy value. It's used to manage specific behaviors or
	 * display messages related to the button option in custom fields.
	 *
	 * @return bool Returns true if the button option is set and true, otherwise false.
	 * @since 3.2.0
	 */
	private function isButtonOptionSet(): bool
	{
		// Check if 'own_custom' field is set and if 'add_button' option is available and truthy
		if (isset($this->data['custom']['own_custom'], $this->data['custom']['add_button']))
		{
			$addButton = $this->data['custom']['add_button'];
			return $addButton === 'true' || $addButton === 1;
		}

		return false;
	}

	/**
	 * Enqueue error messages related to the dynamic button option in custom fields.
	 *
	 * This method adds error messages to the queue when there's an attempt to use the dynamic button
	 * option in custom field types where it's not supported. It's specifically used in the context of 'own custom'
	 * field types.
	 *
	 * @return void
	 * @since 3.2.0
	 */
	private function setButtonOptionErrorMessages(): void
	{
		$headerMessage = '<hr /><h3>' . Text::_('COM_COMPONENTBUILDER_DYNAMIC_BUTTON_ERROR') . '</h3>';
		$detailMessage = Text::_('COM_COMPONENTBUILDER_THE_OPTION_TO_ADD_A_DYNAMIC_BUTTON_IS_NOT_AVAILABLE_IN_BOWN_CUSTOM_FIELD_TYPESB_YOU_WILL_HAVE_TO_CUSTOM_CODE_IT');

		$this->app->enqueueMessage($headerMessage, 'Error');
		$this->app->enqueueMessage($detailMessage, 'Error');
	}

	/**
	 * Prepare the header for a custom field file.
	 *
	 * This method sets up the necessary imports and configurations for the header section of a custom field.
	 * It handles the dynamic setting of comments and import statements based on the field's extension name.
	 *
	 * @return void
	 * @since 3.2.0
	 */
	private function prepareCustomFieldHeader(): void
	{
		// The data set for the custom field
		$data = $this->data['custom'];

		// get the default headers
		$headers = array_map(function ($h) {
				return $this->placeholder->update($h, $this->placeholders);
			}, explode(
				PHP_EOL, $this->header->get('form.custom.field', $this->baseType)
			)
		);

		if (isset($data['phpHEADER']) &&
			ArrayHelper::check($data['phpHEADER']))
		{
			// set tab and break replacements
			$tab_break = array(
				'\t' => Indent::_(1),
				'\n' => PHP_EOL
			);

			foreach ($data['phpHEADER'] as $line => $code)
			{
				if (StringHelper::check($code))
				{
					$h = array_map(function ($h) {
						return $this->placeholder->update($h, $this->placeholders);
					}, explode(PHP_EOL, $this->placeholder->update(
						$code, $tab_break
					)));

					$headers = array_merge($headers, $h);
				}
			}
		}

		// Remove duplicate values
		$headers = array_unique($headers);

		// add to the content updating engine
		$this->contents->set("{$this->contentsKey}FORM_CUSTOM_FIELD_HEADER",
			implode(PHP_EOL, $headers)
		);
	}

	/**
	 * Prepare the body for a custom field file.
	 *
	 * This method sets up the necessary imports and configurations for the body section of a custom field.
	 * It handles the dynamic setting of php code.
	 *
	 * @return void
	 * @since 3.2.0
	 */
	private function prepareCustomFieldBody(): void
	{
		// The own custom string value
		$own_custom = $this->data['custom']['own_custom'] ?? $this->baseType;

		// reset the body
		$body = [];

		// load the other PHP options
		foreach ($this->phpFieldArray as $x)
		{
			if (($code = $this->loadPhpScript('php' . $x, null)) !== null)
			{
				$body[] = $code;
			}
		}

		$php_body = PHP_EOL . PHP_EOL . Indent::_(1) . "//" .
			Line::_(__LINE__,__CLASS__) .
			" A " . $own_custom . " Field" . PHP_EOL;

		$php_body .= $this->placeholder->update(
			implode(PHP_EOL, $body),
			$this->placeholders
		);

		// add to the content updating engine
		$this->contents->set("{$this->contentsKey}FORM_CUSTOM_FIELD_PHP", $php_body);
	}

	/**
	 * Load and process a PHP script for the custom field.
	 *
	 * @param string       $scriptType  The type of script to load ('php' or 'phpx').
	 * @param string|null  $default     The default if none is found
	 *
	 * @return string|null The processed PHP code.
	 * @since 3.2.0
	 */
	private function loadPhpScript(string $scriptType, ?string $default = 'return null;'): ?string
	{
		$php_code = '';

		// The data set for the custom field
		$data = $this->data['custom'];

		if (isset($data[$scriptType]) && ArrayHelper::check($data[$scriptType]))
		{
			$tab_break = [
				'\t' => Indent::_(1),
				'\n' => PHP_EOL
			];

			foreach ($data[$scriptType] as $line => $code)
			{
				if (StringHelper::check($code))
				{
					$php_code .= $line == 1 ? $this->placeholder->update($code, $tab_break)
						: PHP_EOL . Indent::_(2) . $this->placeholder->update($code, $tab_break);
				}
			}

			$php_code = $this->placeholder->update($php_code, $this->placeholders);
		}

		return StringHelper::check($php_code) ? $php_code : $default;
	}

	/**
	 * Generate a group language name for the custom field.
	 *
	 * @return string The generated group language name.
	 * @since 3.2.0
	 */
	private function generateGroupLanguageName(): string
	{
		$label = $this->data['custom']['label'] ?? '(error: label not set)';
		$temp_name =  $label . ' Group';
		$group_lang_name = $this->config->lang_prefix . '_' . FieldHelper::safe($temp_name, true);

		$this->language->set(
			$this->config->lang_target,
			$group_lang_name,
			StringHelper::safe($temp_name, 'W')
		);

		return $group_lang_name;
	}

	/**
	 * Tracks extension custom fields for plugins or modules.
	 *
	 * This method is used to track custom fields when they are utilized in plugins or modules.
	 * If the field is used in a plugin or module, it records this information, potentially to facilitate
	 * actions like copying the field over to other parts of the system.
	 *
	 * @return void
	 * @since 3.2.0
	 */
	private function trackExtensionCustomFields(): void
	{
		if ($this->isUsedInPluginOrModule() && $this->customTypeWasSet)
		{
			$this->extensioncustomfields->set($this->type, $this->baseType);
		}
	}

	/**
	 * Determines if the field is used in a plugin or module.
	 *
	 * @return bool Returns true if the field is used in a plugin or module, false otherwise.
	 * @since 3.2.0
	 */
	private function isUsedInPluginOrModule(): bool
	{
		return strpos($this->nameSingleCode, 'pLuG!n') !== false || strpos($this->nameSingleCode, 'M0dUl3') !== false;
	}
}

