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
use VDM\Joomla\Componentbuilder\Compiler\Field\InputButton;
use VDM\Joomla\Componentbuilder\Compiler\Builder\FieldGroupControl;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ExtensionCustomFields;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\StringHelper;
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
	 * Application object.
	 *
	 * @var    CMSApplication
	 * @since 3.2.0
	 **/
	protected CMSApplication $app;

	/**
	 * Array of php fields Allowed (16)
	 *
	 * @var    array
	 * @since 3.2.0
	 **/
	protected array $phpFieldArray = ['', 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'x', 'HEADER'];

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
		?CMSApplication $app = null)
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
		$this->app = $app ?: Factory::getApplication();
	}

	/**
	 * set Custom Field Type File
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
		// make sure it is not already been build or if it is prime
		if (isset($data['custom']) && isset($data['custom']['extends'])
			&& ((isset($data['custom']['prime_php']) && $data['custom']['prime_php'] == 1)
				|| !$this->contents->isArray('customfield_' . $data['type']))
			)
		{
			// set J prefix
			$jprefix = 'J';
			// check if this field has a dot in field type name
			if (strpos((string) $data['type'], '.') !== false)
			{
				// so we have name spacing in custom field type name
				$dotTypeArray = explode('.', (string) $data['type']);
				// set the J prefix
				if (count((array) $dotTypeArray) > 1)
				{
					$jprefix = strtoupper(array_shift($dotTypeArray));
				}
				// update the type name now
				$data['type'] = implode('', $dotTypeArray);
				$data['custom']['type'] = $data['type'];
			}
			// set the contents key
			$contents_key = "customfield_{$data['type']}|";
			// set tab and break replacements
			$tabBreak = array(
				'\t' => Indent::_(1),
				'\n' => PHP_EOL
			);
			// set the [[[PLACEHOLDER]]] options
			$replace = array(
				Placefix::_('JPREFIX') => $jprefix,
				Placefix::_('TABLE') => (isset($data['custom']['table']))
					? $data['custom']['table'] : '',
				Placefix::_('ID') => (isset($data['custom']['id']))
					? $data['custom']['id'] : '',
				Placefix::_('TEXT') => (isset($data['custom']['text']))
					? $data['custom']['text'] : '',
				Placefix::_('CODE_TEXT') => (isset($data['code'], $data['custom']['text']))
					? $data['code'] . '_' . $data['custom']['text'] : '',
				Placefix::_('CODE') => (isset($data['code']))
					? $data['code'] : '',
				Placefix::_('view_type') => $nameSingleCode
					. '_' . $data['type'],
				Placefix::_('type')  => (isset($data['type']))
					? $data['type'] : '',
				Placefix::_('com_component') => (isset($data['custom']['component'])
					&& StringHelper::check(
						$data['custom']['component']
					)) ? StringHelper::safe(
					$data['custom']['component']
				) : 'com_' . $this->config->component_code_name,
				// set the generic values
				Placefix::_('component') => $this->config->component_code_name,
				Placefix::_('Component') => $this->content->get('Component'),
				Placefix::_('view')  => (isset($data['custom']['view'])
					&& StringHelper::check(
						$data['custom']['view']
					)) ? StringHelper::safe(
					$data['custom']['view']
				) : $nameSingleCode,
				Placefix::_('views') => (isset($data['custom']['views'])
					&& StringHelper::check(
						$data['custom']['views']
					)) ? StringHelper::safe(
					$data['custom']['views']
				) : $nameListCode
			);
			// now set the ###PLACEHOLDER### options
			foreach ($replace as $replacekey => $replacevalue)
			{
				// update the key value
				$replacekey = str_replace(
					array(Placefix::b(), Placefix::d()),
					array(Placefix::h(), Placefix::h()), $replacekey
				);
				// now set the value
				$replace[$replacekey] = $replacevalue;
			}
			// load the global placeholders
			foreach ($this->componentplaceholder->get() as $globalPlaceholder => $gloabalValue)
			{
				$replace[$globalPlaceholder] = $gloabalValue;
			}
			// start loading the field type

			// JPREFIX <<<DYNAMIC>>>
			$this->contents->set("{$contents_key}JPREFIX", $jprefix);
			// Type <<<DYNAMIC>>>
			$this->contents->set("{$contents_key}Type",
				StringHelper::safe(
					$data['custom']['type'], 'F'
				)
			);
			// type <<<DYNAMIC>>>
			$this->contents->set("{$contents_key}type", StringHelper::safe($data['custom']['type']));
			// is this a own custom field
			if (isset($data['custom']['own_custom']))
			{
				// make sure the button option notice is set to notify the developer that the button option is not available in own custom field types
				if (isset($data['custom']['add_button'])
					&& ($data['custom']['add_button'] === 'true'
						|| 1 == $data['custom']['add_button']))
				{
					// set error
					$this->app->enqueueMessage(
						Text::_('COM_COMPONENTBUILDER_HR_HTHREEDYNAMIC_BUTTON_ERRORHTHREE'), 'Error'
					);
					$this->app->enqueueMessage(
						Text::_('COM_COMPONENTBUILDER_THE_OPTION_TO_ADD_A_DYNAMIC_BUTTON_IS_NOT_AVAILABLE_IN_BOWN_CUSTOM_FIELD_TYPESB_YOU_WILL_HAVE_TO_CUSTOM_CODE_IT'), 'Error'
					);
				}
				// load another file
				$target = array('admin' => 'customfield');
				$this->structure->build(
					$target, 'fieldcustom', $data['custom']['type']
				);
				// get the extends name
				$JFORM_extends = StringHelper::safe(
					$data['custom']['extends']
				);
				// JFORM_TYPE_HEADER <<<DYNAMIC>>>
				$add_default_header = true;
				$this->contents->set("{$contents_key}JFORM_TYPE_HEADER",
					"//" . Line::_(
						__LINE__,__CLASS__
					) . " Import the " . $JFORM_extends
					. " field type classes needed"
				);
				// JFORM_extens <<<DYNAMIC>>>
				$this->contents->set("{$contents_key}JFORM_extends", $JFORM_extends
				);
				// JFORM_EXTENDS <<<DYNAMIC>>>
				$this->contents->set("{$contents_key}JFORM_EXTENDS",
					StringHelper::safe(
						$data['custom']['extends'], 'F'
					)
				);
				// JFORM_TYPE_PHP <<<DYNAMIC>>>
				$this->contents->set("{$contents_key}JFORM_TYPE_PHP",
					PHP_EOL . PHP_EOL . Indent::_(1) . "//" . Line::_(
						__LINE__,__CLASS__
					) . " A " . $data['custom']['own_custom'] . " Field"
				);
				// load the other PHP options
				foreach ($this->phpFieldArray as $x)
				{
					// reset the php bucket
					$phpBucket = '';
					// only set if available
					if (isset($data['custom']['php' . $x])
						&& ArrayHelper::check(
							$data['custom']['php' . $x]
						))
					{
						foreach ($data['custom']['php' . $x] as $line => $code)
						{
							if (StringHelper::check($code))
							{
								$phpBucket .= PHP_EOL . $this->placeholder->update(
										$code, $tabBreak
									);
							}
						}
						// check if this is header text
						if ('HEADER' === $x)
						{
							$this->contents->add("{$contents_key}JFORM_TYPE_HEADER",
								PHP_EOL . $this->placeholder->update(
									$phpBucket, $replace
								), false
							);
							// stop default headers from loading
							$add_default_header = false;
						}
						else
						{
							// JFORM_TYPE_PHP <<<DYNAMIC>>>
							$this->contents->add("{$contents_key}JFORM_TYPE_PHP",
								PHP_EOL . $this->placeholder->update(
									$phpBucket, $replace
								), false
							);
						}
					}
				}
				// check if we should add default header
				if ($add_default_header)
				{
					$this->contents->add("{$contents_key}JFORM_TYPE_HEADER",
						PHP_EOL . "jimport('joomla.form.helper');",
						false
					);
					$this->contents->add("{$contents_key}JFORM_TYPE_HEADER",
						PHP_EOL . "JFormHelper::loadFieldClass('" . $JFORM_extends . "');",
						false
					);
				}
				// check the the JFormHelper::loadFieldClass(..) was set
				elseif (strpos((string) $this->contents->get("{$contents_key}JFORM_TYPE_HEADER"),
						'JFormHelper::loadFieldClass(') === false)
				{
					$this->contents->add("{$contents_key}JFORM_TYPE_HEADER",
						PHP_EOL . "JFormHelper::loadFieldClass('"
						. $JFORM_extends . "');", false
					);
				}
			}
			else
			{
				// first build the custom field type file
				$target = array('admin' => 'customfield');
				$this->structure->build(
					$target, 'field' . $data['custom']['extends'],
					$data['custom']['type']
				);
				// make sure the value is reset
				$phpCode = '';
				// now load the php script
				if (isset($data['custom']['php'])
					&& ArrayHelper::check(
						$data['custom']['php']
					))
				{
					foreach ($data['custom']['php'] as $line => $code)
					{
						if (StringHelper::check($code))
						{
							if ($line == 1)
							{
								$phpCode .= $this->placeholder->update(
									$code, $tabBreak
								);
							}
							else
							{
								$phpCode .= PHP_EOL . Indent::_(2)
									. $this->placeholder->update($code, $tabBreak);
							}
						}
					}
					// replace the placholders
					$phpCode = $this->placeholder->update($phpCode, $replace);
				}
				// catch empty stuff
				if (!StringHelper::check($phpCode))
				{
					$phpCode = 'return null;';
				}
				// some house cleaning for users
				if ($data['custom']['extends'] === 'user')
				{
					// make sure the value is reset
					$phpxCode = '';
					// now load the php xclude script
					if (ArrayHelper::check(
						$data['custom']['phpx']
					))
					{
						foreach ($data['custom']['phpx'] as $line => $code)
						{
							if (StringHelper::check($code))
							{
								if ($line == 1)
								{
									$phpxCode .= $this->placeholder->update(
										$code, $tabBreak
									);
								}
								else
								{
									$phpxCode .= PHP_EOL . Indent::_(2)
										. $this->placeholder->update(
											$code, $tabBreak
										);
								}
							}
						}
						// replace the placholders
						$phpxCode = $this->placeholder->update($phpxCode, $replace);
					}
					// catch empty stuff
					if (!StringHelper::check($phpxCode))
					{
						$phpxCode = 'return null;';
					}
					// temp holder for name
					$tempName = $data['custom']['label'] . ' Group';
					// set lang
					$groupLangName = $this->config->lang_prefix . '_'
						. FieldHelper::safe(
							$tempName, true
						);
					// add to lang array
					$this->language->set(
						$this->config->lang_target, $groupLangName,
						StringHelper::safe($tempName, 'W')
					);
					// build the Group Control
					$this->fieldgroupcontrol->set($data['type'], $groupLangName);
					// JFORM_GETGROUPS_PHP <<<DYNAMIC>>>
					$this->contents->set("{$contents_key}JFORM_GETGROUPS_PHP",
						$phpCode
					);
					// JFORM_GETEXCLUDED_PHP <<<DYNAMIC>>>
					$this->contents->set("{$contents_key}JFORM_GETEXCLUDED_PHP",
						$phpxCode
					);
				}
				else
				{
					// JFORM_GETOPTIONS_PHP <<<DYNAMIC>>>
					$this->contents->set("{$contents_key}JFORM_GETOPTIONS_PHP",
						$phpCode
					);
				}
				// type <<<DYNAMIC>>>
				$this->contents->set("{$contents_key}ADD_BUTTON",
					$this->inputbutton->get($data['custom'])
				);
			}
		}
		// if this field gets used in plug-in or module we should track it so if needed we can copy it over
		if ((strpos($nameSingleCode, 'pLuG!n') !== false || strpos($nameSingleCode, 'M0dUl3') !== false)
			&& isset($data['custom'])
			&& isset($data['custom']['type']))
		{
			$this->extensioncustomfields->set($data['type'], $data['custom']['type']);
		}
	}
}

