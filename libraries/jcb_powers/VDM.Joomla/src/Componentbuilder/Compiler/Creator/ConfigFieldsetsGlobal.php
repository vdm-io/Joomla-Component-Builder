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
use VDM\Joomla\Componentbuilder\Compiler\Component;
use VDM\Joomla\Componentbuilder\Compiler\Builder\Contributors;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ConfigFieldsets;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ExtensionsParams;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ConfigFieldsetsCustomfield as Customfield;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;


/**
 * Config Fieldsets Global Creator Class
 * 
 * @since 3.2.0
 */
final class ConfigFieldsetsGlobal
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
	 * The Component Class.
	 *
	 * @var   Component
	 * @since 3.2.0
	 */
	protected Component $component;

	/**
	 * The Contributors Class.
	 *
	 * @var   Contributors
	 * @since 3.2.0
	 */
	protected Contributors $contributors;

	/**
	 * The ConfigFieldsets Class.
	 *
	 * @var   ConfigFieldsets
	 * @since 3.2.0
	 */
	protected ConfigFieldsets $configfieldsets;

	/**
	 * The ExtensionsParams Class.
	 *
	 * @var   ExtensionsParams
	 * @since 3.2.0
	 */
	protected ExtensionsParams $extensionsparams;

	/**
	 * The ConfigFieldsetsCustomfield Class.
	 *
	 * @var   Customfield
	 * @since 3.2.0
	 */
	protected Customfield $customfield;

	/**
	 * Constructor.
	 *
	 * @param Config             $config             The Config Class.
	 * @param Language           $language           The Language Class.
	 * @param Component          $component          The Component Class.
	 * @param Contributors       $contributors       The Contributors Class.
	 * @param ConfigFieldsets    $configfieldsets    The ConfigFieldsets Class.
	 * @param ExtensionsParams   $extensionsparams   The ExtensionsParams Class.
	 * @param Customfield        $customfield        The ConfigFieldsetsCustomfield Class.
	 *
	 * @since 3.2.0
	 */
	public function __construct(Config $config, Language $language, Component $component,
		Contributors $contributors,
		ConfigFieldsets $configfieldsets,
		ExtensionsParams $extensionsparams,
		Customfield $customfield)
	{
		$this->config = $config;
		$this->language = $language;
		$this->component = $component;
		$this->contributors = $contributors;
		$this->configfieldsets = $configfieldsets;
		$this->extensionsparams = $extensionsparams;
		$this->customfield = $customfield;
	}

	/**
	 * Set Global Config Fieldsets
	 *
	 * @param string $lang
	 * @param string $authorName
	 * @param string $authorEmail
	 *
	 * @since 3.2.0
	 */
	public function set(string $lang, string $authorName, string $authorEmail): void
	{
		// start building field set for config
		$this->configfieldsets->add('component', '<fieldset');

		if ($this->config->get('joomla_version', 3) == 3)
		{
			$this->configfieldsets->add('component', Indent::_(2)
				. 'addrulepath="/administrator/components/com_' . $this->config->component_code_name
				. '/models/rules"');
			$this->configfieldsets->add('component', Indent::_(2)
				. 'addfieldpath="/administrator/components/com_' . $this->config->component_code_name
				. '/models/fields"');
		}
		else
		{
			$this->configfieldsets->add('component', Indent::_(2)
				. 'addruleprefix="' . $this->config->namespace_prefix
				. '\Component\\' . StringHelper::safe($this->config->component_code_name, 'F')
				. '\Administrator\Rule"');
			$this->configfieldsets->add('component', Indent::_(2)
				. 'addfieldprefix="' . $this->config->namespace_prefix
				. '\Component\\' . StringHelper::safe($this->config->component_code_name, 'F')
				. '\Administrator\Field"');
		}
		$this->configfieldsets->add('component', Indent::_(2) . 'name="global_config"');
		$this->configfieldsets->add('component', Indent::_(2) . 'label="' . $lang
			. '_GLOBAL_LABEL"');
		$this->configfieldsets->add('component', Indent::_(2) . 'description="' . $lang
			. '_GLOBAL_DESC">');
		// setup lang
		$this->language->set($this->config->lang_target, $lang . '_GLOBAL_LABEL', "Global");
		$this->language->set(
			$this->config->lang_target, $lang . '_GLOBAL_DESC', "The Global Parameters"
		);

		// add auto checkin if required
		if ($this->config->get('add_checkin', false))
		{
			$this->configfieldsets->add('component', Indent::_(2) . "<field");
			$this->configfieldsets->add('component', Indent::_(3) . 'name="check_in"');
			$this->configfieldsets->add('component', Indent::_(3) . 'type="list"');
			$this->configfieldsets->add('component', Indent::_(3) . 'default="0"');
			$this->configfieldsets->add('component', Indent::_(3) . 'label="' . $lang
				. '_CHECK_TIMER_LABEL"');
			$this->configfieldsets->add('component', Indent::_(3) . 'description="' . $lang
				. '_CHECK_TIMER_DESC">');
			$this->configfieldsets->add('component', Indent::_(3) . '<option');
			$this->configfieldsets->add('component', Indent::_(4) . 'value="-5 hours">'
				. $lang . '_CHECK_TIMER_OPTION_ONE</option>');
			$this->configfieldsets->add('component', Indent::_(3) . '<option');
			$this->configfieldsets->add('component', Indent::_(4) . 'value="-12 hours">'
				. $lang . '_CHECK_TIMER_OPTION_TWO</option>');
			$this->configfieldsets->add('component', Indent::_(3) . '<option');
			$this->configfieldsets->add('component', Indent::_(4) . 'value="-1 day">' . $lang
				. '_CHECK_TIMER_OPTION_THREE</option>');
			$this->configfieldsets->add('component', Indent::_(3) . '<option');
			$this->configfieldsets->add('component', Indent::_(4) . 'value="-2 day">' . $lang
				. '_CHECK_TIMER_OPTION_FOUR</option>');
			$this->configfieldsets->add('component', Indent::_(3) . '<option');
			$this->configfieldsets->add('component', Indent::_(4) . 'value="-1 week">' . $lang
				. '_CHECK_TIMER_OPTION_FIVE</option>');
			$this->configfieldsets->add('component', Indent::_(3) . '<option');
			$this->configfieldsets->add('component', Indent::_(4) . 'value="0">' . $lang
				. '_CHECK_TIMER_OPTION_SIX</option>');
			$this->configfieldsets->add('component', Indent::_(2) . "</field>");
			$this->configfieldsets->add('component', Indent::_(2)
				. '<field type="spacer" name="spacerAuthor" hr="true" />');
			// setup lang
			$this->language->set(
				$this->config->lang_target, $lang . '_CHECK_TIMER_LABEL', "Check in timer"
			);
			$this->language->set(
				$this->config->lang_target, $lang . '_CHECK_TIMER_DESC',
				"Set the intervals for the auto checkin fuction of tables that checks out the items to an user."
			);
			$this->language->set(
				$this->config->lang_target, $lang . '_CHECK_TIMER_OPTION_ONE',
				"Every five hours"
			);
			$this->language->set(
				$this->config->lang_target, $lang . '_CHECK_TIMER_OPTION_TWO',
				"Every twelve hours"
			);
			$this->language->set(
				$this->config->lang_target, $lang . '_CHECK_TIMER_OPTION_THREE', "Once a day"
			);
			$this->language->set(
				$this->config->lang_target, $lang . '_CHECK_TIMER_OPTION_FOUR',
				"Every second day"
			);
			$this->language->set(
				$this->config->lang_target, $lang . '_CHECK_TIMER_OPTION_FIVE', "Once a week"
			);
			$this->language->set(
				$this->config->lang_target, $lang . '_CHECK_TIMER_OPTION_SIX', "Never"
			);
			// load the Global checkin defautls
			$this->extensionsparams->add('component', '"check_in":"-1 day"');
		}

		// set history control
		if ($this->config->get('set_tag_history', false))
		{
			$this->configfieldsets->add('component', Indent::_(2) . "<field");
			$this->configfieldsets->add('component', Indent::_(3) . 'name="save_history"');
			$this->configfieldsets->add('component', Indent::_(3) . 'type="radio"');
			$this->configfieldsets->add('component', Indent::_(3)
				. 'class="btn-group btn-group-yesno"');
			$this->configfieldsets->add('component', Indent::_(3) . 'default="1"');
			$this->configfieldsets->add('component', Indent::_(3)
				. 'label="JGLOBAL_SAVE_HISTORY_OPTIONS_LABEL"');
			$this->configfieldsets->add('component', Indent::_(3)
				. 'description="JGLOBAL_SAVE_HISTORY_OPTIONS_DESC"');
			$this->configfieldsets->add('component', Indent::_(3) . ">");
			$this->configfieldsets->add('component', Indent::_(3)
				. '<option value="1">JYES</option>');
			$this->configfieldsets->add('component', Indent::_(3)
				. '<option value="0">JNO</option>');
			$this->configfieldsets->add('component', Indent::_(2) . "</field>");
			$this->configfieldsets->add('component', Indent::_(2) . "<field");
			$this->configfieldsets->add('component', Indent::_(3) . 'name="history_limit"');
			$this->configfieldsets->add('component', Indent::_(3) . 'type="text"');
			$this->configfieldsets->add('component', Indent::_(3) . 'filter="integer"');
			$this->configfieldsets->add('component', Indent::_(3)
				. 'label="JGLOBAL_HISTORY_LIMIT_OPTIONS_LABEL"');
			$this->configfieldsets->add('component', Indent::_(3)
				. 'description="JGLOBAL_HISTORY_LIMIT_OPTIONS_DESC"');
			$this->configfieldsets->add('component', Indent::_(3) . 'default="10"');
			$this->configfieldsets->add('component', Indent::_(2) . "/>");
			$this->configfieldsets->add('component', Indent::_(2)
				. '<field type="spacer" name="spacerHistory" hr="true" />');
			// load the Global checkin defautls
			$this->extensionsparams->add('component', '"save_history":"1","history_limit":"10"');
		}
		// add custom global fields
		if ($this->customfield->isArray('Global'))
		{
			$this->configfieldsets->add('component', implode(
				"", $this->customfield->get('Global')
			));
			$this->customfield->remove('Global');
		}
		// set the author details
		$this->configfieldsets->add('component', Indent::_(2) . '<field name="autorTitle"');
		$this->configfieldsets->add('component', Indent::_(3) . 'type="spacer"');
		$this->configfieldsets->add('component', Indent::_(3) . 'label="' . $lang
			. '_AUTHOR"');
		$this->configfieldsets->add('component', Indent::_(2) . "/>");
		$this->configfieldsets->add('component', Indent::_(2) . '<field name="autorName"');
		$this->configfieldsets->add('component', Indent::_(3) . 'type="text"');
		$this->configfieldsets->add('component', Indent::_(3) . 'label="' . $lang
			. '_AUTHOR_NAME_LABEL"');
		$this->configfieldsets->add('component', Indent::_(3) . 'description="' . $lang
			. '_AUTHOR_NAME_DESC"');
		$this->configfieldsets->add('component', Indent::_(3) . 'size="60"');
		$this->configfieldsets->add('component', Indent::_(3) . 'default="' . $authorName . '"');
		$this->configfieldsets->add('component', Indent::_(3) . 'readonly="true"');
		$this->configfieldsets->add('component', Indent::_(3) . 'class="readonly"');
		$this->configfieldsets->add('component', Indent::_(2) . "/>");
		$this->configfieldsets->add('component', Indent::_(2) . '<field name="autorEmail"');
		$this->configfieldsets->add('component', Indent::_(3) . 'type="email"');
		$this->configfieldsets->add('component', Indent::_(3) . 'label="' . $lang
			. '_AUTHOR_EMAIL_LABEL"');
		$this->configfieldsets->add('component', Indent::_(3) . 'description="' . $lang
			. '_AUTHOR_EMAIL_DESC"');
		$this->configfieldsets->add('component', Indent::_(3) . 'size="60"');
		$this->configfieldsets->add('component', Indent::_(3) . 'default="' . $authorEmail . '"');
		$this->configfieldsets->add('component', Indent::_(3) . 'readonly="true"');
		$this->configfieldsets->add('component', Indent::_(3) . 'class="readonly"');
		$this->configfieldsets->add('component', Indent::_(2) . "/>");
		// setup lang
		$this->language->set($this->config->lang_target, $lang . '_AUTHOR', "Author Info");
		$this->language->set(
			$this->config->lang_target, $lang . '_AUTHOR_NAME_LABEL', "Author Name"
		);
		$this->language->set(
			$this->config->lang_target, $lang . '_AUTHOR_NAME_DESC',
			"The name of the author of this component."
		);
		$this->language->set(
			$this->config->lang_target, $lang . '_AUTHOR_EMAIL_LABEL', "Author Email"
		);
		$this->language->set(
			$this->config->lang_target, $lang . '_AUTHOR_EMAIL_DESC',
			"The email address of the author of this component."
		);

		// set if contributors were added
		$langCont = $lang . '_CONTRIBUTOR';
		if ($this->config->get('add_contributors', false)
			&& $this->component->isArray('contributors'))
		{
			foreach (
				$this->component->get('contributors') as $counter => $contributor
			)
			{
				// make sure we dont use 0
				$counter++;
				// get the word for this number
				$COUNTER = StringHelper::safe($counter, 'U');
				// set the dynamic values
				$cbTitle   = htmlspecialchars(
					(string) $contributor['title'], ENT_XML1, 'UTF-8'
				);
				$cbName    = htmlspecialchars(
					(string) $contributor['name'], ENT_XML1, 'UTF-8'
				);
				$cbEmail   = htmlspecialchars(
					(string) $contributor['email'], ENT_XML1, 'UTF-8'
				);
				$cbWebsite = htmlspecialchars(
					(string) $contributor['website'], ENT_XML1, 'UTF-8'
				); // StringHelper::html($contributor['website']);
				// load to the $fieldsets
				$this->configfieldsets->add('component', Indent::_(2)
					. '<field type="spacer" name="spacerContributor' . $counter
					. '" hr="true" />');
				$this->configfieldsets->add('component', Indent::_(2)
					. '<field name="contributor' . $counter . '"');
				$this->configfieldsets->add('component', Indent::_(3) . 'type="spacer"');
				$this->configfieldsets->add('component', Indent::_(3) . 'class="text"');
				$this->configfieldsets->add('component', Indent::_(3) . 'label="' . $langCont
					. '_' . $COUNTER . '"');
				$this->configfieldsets->add('component', Indent::_(2) . "/>");
				$this->configfieldsets->add('component', Indent::_(2)
					. '<field name="titleContributor' . $counter . '"');
				$this->configfieldsets->add('component', Indent::_(3) . 'type="text"');
				$this->configfieldsets->add('component', Indent::_(3) . 'label="' . $langCont
					. '_TITLE_LABEL"');
				$this->configfieldsets->add('component', Indent::_(3) . 'description="'
					. $langCont . '_TITLE_DESC"');
				$this->configfieldsets->add('component', Indent::_(3) . 'size="60"');
				$this->configfieldsets->add('component', Indent::_(3) . 'default="' . $cbTitle
					. '"');
				$this->configfieldsets->add('component', Indent::_(2) . "/>");
				$this->configfieldsets->add('component', Indent::_(2)
					. '<field name="nameContributor' . $counter . '"');
				$this->configfieldsets->add('component', Indent::_(3) . 'type="text"');
				$this->configfieldsets->add('component', Indent::_(3) . 'label="' . $langCont
					. '_NAME_LABEL"');
				$this->configfieldsets->add('component', Indent::_(3) . 'description="'
					. $langCont . '_NAME_DESC"');
				$this->configfieldsets->add('component', Indent::_(3) . 'size="60"');
				$this->configfieldsets->add('component', Indent::_(3) . 'default="' . $cbName
					. '"');
				$this->configfieldsets->add('component', Indent::_(2) . "/>");
				$this->configfieldsets->add('component', Indent::_(2)
					. '<field name="emailContributor' . $counter . '"');
				$this->configfieldsets->add('component', Indent::_(3) . 'type="email"');
				$this->configfieldsets->add('component', Indent::_(3) . 'label="' . $langCont
					. '_EMAIL_LABEL"');
				$this->configfieldsets->add('component', Indent::_(3) . 'description="'
					. $langCont . '_EMAIL_DESC"');
				$this->configfieldsets->add('component', Indent::_(3) . 'size="60"');
				$this->configfieldsets->add('component', Indent::_(3) . 'default="' . $cbEmail
					. '"');
				$this->configfieldsets->add('component', Indent::_(2) . "/>");
				$this->configfieldsets->add('component', Indent::_(2)
					. '<field name="linkContributor' . $counter . '"');
				$this->configfieldsets->add('component', Indent::_(3) . 'type="url"');
				$this->configfieldsets->add('component', Indent::_(3) . 'label="' . $langCont
					. '_LINK_LABEL"');
				$this->configfieldsets->add('component', Indent::_(3) . 'description="'
					. $langCont . '_LINK_DESC"');
				$this->configfieldsets->add('component', Indent::_(3) . 'size="60"');
				$this->configfieldsets->add('component', Indent::_(3) . 'default="'
					. $cbWebsite . '"');
				$this->configfieldsets->add('component', Indent::_(2) . "/>");
				$this->configfieldsets->add('component', Indent::_(2)
					. '<field name="useContributor' . $counter . '"');
				$this->configfieldsets->add('component', Indent::_(3) . 'type="list"');
				$this->configfieldsets->add('component', Indent::_(3) . 'default="'
					. (int) $contributor['use'] . '"');
				$this->configfieldsets->add('component', Indent::_(3) . 'label="' . $langCont
					. '_USE_LABEL"');
				$this->configfieldsets->add('component', Indent::_(3) . 'description="'
					. $langCont . '_USE_DESC">');
				$this->configfieldsets->add('component', Indent::_(3) . '<option value="0">'
					. $langCont . '_USE_NONE</option>');
				$this->configfieldsets->add('component', Indent::_(3) . '<option value="1">'
					. $langCont . '_USE_EMAIL</option>');
				$this->configfieldsets->add('component', Indent::_(3) . '<option value="2">'
					. $langCont . '_USE_WWW</option>');
				$this->configfieldsets->add('component', Indent::_(2) . "</field>");
				$this->configfieldsets->add('component', Indent::_(2)
					. '<field name="showContributor' . $counter . '"');
				$this->configfieldsets->add('component', Indent::_(3) . 'type="list"');
				$this->configfieldsets->add('component', Indent::_(3) . 'default="'
					. (int) $contributor['show'] . '"');
				$this->configfieldsets->add('component', Indent::_(3) . 'label="' . $langCont
					. '_SHOW_LABEL"');
				$this->configfieldsets->add('component', Indent::_(3) . 'description="'
					. $langCont . '_SHOW_DESC">');
				$this->configfieldsets->add('component', Indent::_(3) . '<option value="0">'
					. $langCont . '_SHOW_NONE</option>');
				$this->configfieldsets->add('component', Indent::_(3) . '<option value="1">'
					. $langCont . '_SHOW_BACK</option>');
				$this->configfieldsets->add('component', Indent::_(3) . '<option value="2">'
					. $langCont . '_SHOW_FRONT</option>');
				$this->configfieldsets->add('component', Indent::_(3) . '<option value="3">'
					. $langCont . '_SHOW_ALL</option>');
				$this->configfieldsets->add('component', Indent::_(2) . "</field>");
				// add the contributor
				$this->contributors->add('bom', PHP_EOL . Indent::_(1) . "@"
					. strtolower((string) $contributor['title']) . Indent::_(2)
					. $contributor['name'] . ' <' . $contributor['website']
					. '>');
				// setup lang
				$Counter = StringHelper::safe($counter, 'Ww');
				$this->language->set(
					$this->config->lang_target, $langCont . '_' . $COUNTER,
					"Contributor " . $Counter
				);
				// load the Global checkin defautls
				$this->extensionsparams->add('component', '"titleContributor' . $counter
					. '":"' . $cbTitle . '"');
				$this->extensionsparams->add('component', '"nameContributor' . $counter
					. '":"' . $cbName . '"');
				$this->extensionsparams->add('component', '"emailContributor' . $counter
					. '":"' . $cbEmail . '"');
				$this->extensionsparams->add('component', '"linkContributor' . $counter
					. '":"' . $cbWebsite . '"');
				$this->extensionsparams->add('component', '"useContributor' . $counter . '":"'
					. (int) $contributor['use'] . '"');
				$this->extensionsparams->add('component', '"showContributor' . $counter
					. '":"' . (int) $contributor['show'] . '"');
			}
		}

		// add more contributors if required
		if (1 == $this->component->get('emptycontributors', 0))
		{
			if (isset($counter))
			{
				$min = $counter + 1;
				unset($counter);
			}
			else
			{
				$min = 1;
			}
			$max = $min + $this->component->get('number') - 1;
			$moreContributerFields = range($min, $max, 1);
			foreach ($moreContributerFields as $counter)
			{
				$COUNTER = StringHelper::safe($counter, 'U');

				$this->configfieldsets->add('component', Indent::_(2)
					. '<field type="spacer" name="spacerContributor' . $counter
					. '" hr="true" />');
				$this->configfieldsets->add('component', Indent::_(2)
					. '<field name="contributor' . $counter . '"');
				$this->configfieldsets->add('component', Indent::_(3) . 'type="spacer"');
				$this->configfieldsets->add('component', Indent::_(3) . 'class="text"');
				$this->configfieldsets->add('component', Indent::_(3) . 'label="' . $langCont
					. '_' . $COUNTER . '"');
				$this->configfieldsets->add('component', Indent::_(2) . "/>");
				$this->configfieldsets->add('component', Indent::_(2)
					. '<field name="titleContributor' . $counter . '"');
				$this->configfieldsets->add('component', Indent::_(3) . 'type="text"');
				$this->configfieldsets->add('component', Indent::_(3) . 'label="' . $langCont
					. '_TITLE_LABEL"');
				$this->configfieldsets->add('component', Indent::_(3) . 'description="'
					. $langCont . '_TITLE_DESC"');
				$this->configfieldsets->add('component', Indent::_(3) . 'size="60"');
				$this->configfieldsets->add('component', Indent::_(3) . 'default=""');
				$this->configfieldsets->add('component', Indent::_(2) . "/>");
				$this->configfieldsets->add('component', Indent::_(2)
					. '<field name="nameContributor' . $counter . '"');
				$this->configfieldsets->add('component', Indent::_(3) . 'type="text"');
				$this->configfieldsets->add('component', Indent::_(3) . 'label="' . $langCont
					. '_NAME_LABEL"');
				$this->configfieldsets->add('component', Indent::_(3) . 'description="'
					. $langCont . '_NAME_DESC"');
				$this->configfieldsets->add('component', Indent::_(3) . 'size="60"');
				$this->configfieldsets->add('component', Indent::_(3) . 'default=""');
				$this->configfieldsets->add('component', Indent::_(2) . "/>");
				$this->configfieldsets->add('component', Indent::_(2)
					. '<field name="emailContributor' . $counter . '"');
				$this->configfieldsets->add('component', Indent::_(3) . 'type="email"');
				$this->configfieldsets->add('component', Indent::_(3) . 'label="' . $langCont
					. '_EMAIL_LABEL"');
				$this->configfieldsets->add('component', Indent::_(3) . 'description="'
					. $langCont . '_EMAIL_DESC"');
				$this->configfieldsets->add('component', Indent::_(3) . 'size="60"');
				$this->configfieldsets->add('component', Indent::_(3) . 'default=""');
				$this->configfieldsets->add('component', Indent::_(2) . "/>");
				$this->configfieldsets->add('component', Indent::_(2)
					. '<field name="linkContributor' . $counter . '"');
				$this->configfieldsets->add('component', Indent::_(3) . 'type="url"');
				$this->configfieldsets->add('component', Indent::_(3) . 'label="' . $langCont
					. '_LINK_LABEL"');
				$this->configfieldsets->add('component', Indent::_(3) . 'description="'
					. $langCont . '_LINK_DESC"');
				$this->configfieldsets->add('component', Indent::_(3) . 'size="60"');
				$this->configfieldsets->add('component', Indent::_(3) . 'default=""');
				$this->configfieldsets->add('component', Indent::_(2) . "/>");
				$this->configfieldsets->add('component', Indent::_(2)
					. '<field name="useContributor' . $counter . '"');
				$this->configfieldsets->add('component', Indent::_(3) . 'type="list"');
				$this->configfieldsets->add('component', Indent::_(3) . 'default="0"');
				$this->configfieldsets->add('component', Indent::_(3) . 'label="' . $langCont
					. '_USE_LABEL"');
				$this->configfieldsets->add('component', Indent::_(3) . 'description="'
					. $langCont . '_USE_DESC">');
				$this->configfieldsets->add('component', Indent::_(3) . '<option value="0">'
					. $langCont . '_USE_NONE</option>');
				$this->configfieldsets->add('component', Indent::_(3) . '<option value="1">'
					. $langCont . '_USE_EMAIL</option>');
				$this->configfieldsets->add('component', Indent::_(3) . '<option value="2">'
					. $langCont . '_USE_WWW</option>');
				$this->configfieldsets->add('component', Indent::_(2) . "</field>");
				$this->configfieldsets->add('component', Indent::_(2)
					. '<field name="showContributor' . $counter . '"');
				$this->configfieldsets->add('component', Indent::_(3) . 'type="list"');
				$this->configfieldsets->add('component', Indent::_(3) . 'default="0"');
				$this->configfieldsets->add('component', Indent::_(3) . 'label="' . $langCont
					. '_SHOW_LABEL"');
				$this->configfieldsets->add('component', Indent::_(3) . 'description="'
					. $langCont . '_SHOW_DESC">');
				$this->configfieldsets->add('component', Indent::_(3) . '<option value="0">'
					. $langCont . '_SHOW_NONE</option>');
				$this->configfieldsets->add('component', Indent::_(3) . '<option value="1">'
					. $langCont . '_SHOW_BACK</option>');
				$this->configfieldsets->add('component', Indent::_(3) . '<option value="2">'
					. $langCont . '_SHOW_FRONT</option>');
				$this->configfieldsets->add('component', Indent::_(3) . '<option value="3">'
					. $langCont . '_SHOW_ALL</option>');
				$this->configfieldsets->add('component', Indent::_(2) . "</field>");
				// setup lang
				$Counter = StringHelper::safe($counter, 'Ww');
				$this->language->set(
					$this->config->lang_target, $langCont . '_' . $COUNTER,
					"Contributor " . $Counter
				);
			}
		}

		if ($this->config->get('add_contributors', false)
			|| $this->component->get('emptycontributors', 0) == 1)
		{
			// setup lang
			$this->language->set(
				$this->config->lang_target, $langCont . '_TITLE_LABEL', "Contributor Job Title"
			);
			$this->language->set(
				$this->config->lang_target, $langCont . '_TITLE_DESC',
				"The job title that best describes the contributor's relationship to this component."
			);
			$this->language->set(
				$this->config->lang_target, $langCont . '_NAME_LABEL', "Contributor Name"
			);
			$this->language->set(
				$this->config->lang_target, $langCont . '_NAME_DESC',
				"The name of this contributor."
			);
			$this->language->set(
				$this->config->lang_target, $langCont . '_EMAIL_LABEL', "Contributor Email"
			);
			$this->language->set(
				$this->config->lang_target, $langCont . '_EMAIL_DESC',
				"The email of this contributor."
			);
			$this->language->set(
				$this->config->lang_target, $langCont . '_LINK_LABEL', "Contributor Website"
			);
			$this->language->set(
				$this->config->lang_target, $langCont . '_LINK_DESC',
				"The link to this contributor's website."
			);
			$this->language->set($this->config->lang_target, $langCont . '_USE_LABEL', "Use");
			$this->language->set(
				$this->config->lang_target, $langCont . '_USE_DESC',
				"How should we link to this contributor."
			);
			$this->language->set($this->config->lang_target, $langCont . '_USE_NONE', "None");
			$this->language->set(
				$this->config->lang_target, $langCont . '_USE_EMAIL', "Email"
			);
			$this->language->set(
				$this->config->lang_target, $langCont . '_USE_WWW', "Website"
			);
			$this->language->set(
				$this->config->lang_target, $langCont . '_SHOW_LABEL', "Show"
			);
			$this->language->set(
				$this->config->lang_target, $langCont . '_SHOW_DESC',
				"Select where you want this contributor's details to show in the component."
			);
			$this->language->set(
				$this->config->lang_target, $langCont . '_SHOW_NONE', "Hide"
			);
			$this->language->set(
				$this->config->lang_target, $langCont . '_SHOW_BACK', "Back-end"
			);
			$this->language->set(
				$this->config->lang_target, $langCont . '_SHOW_FRONT', "Front-end"
			);
			$this->language->set(
				$this->config->lang_target, $langCont . '_SHOW_ALL', "Both Front & Back-end"
			);
		}

		// close that fieldset
		$this->configfieldsets->add('component', Indent::_(1) . "</fieldset>");
	}
}

