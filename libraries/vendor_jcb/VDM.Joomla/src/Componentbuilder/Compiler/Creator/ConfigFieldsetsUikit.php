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
use VDM\Joomla\Componentbuilder\Compiler\Builder\ConfigFieldsets;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ExtensionsParams;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ConfigFieldsetsCustomfield as Customfield;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;


/**
 * Config Fieldsets Uikit Creator Class
 * 
 * @since 3.2.0
 */
final class ConfigFieldsetsUikit
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
	 * @param ConfigFieldsets    $configfieldsets    The ConfigFieldsets Class.
	 * @param ExtensionsParams   $extensionsparams   The ExtensionsParams Class.
	 * @param Customfield        $customfield        The ConfigFieldsetsCustomfield Class.
	 *
	 * @since 3.2.0
	 */
	public function __construct(Config $config, Language $language,
		ConfigFieldsets $configfieldsets,
		ExtensionsParams $extensionsparams,
		Customfield $customfield)
	{
		$this->config = $config;
		$this->language = $language;
		$this->configfieldsets = $configfieldsets;
		$this->extensionsparams = $extensionsparams;
		$this->customfield = $customfield;
	}

	/**
	 * Set Uikit Config Fieldsets
	 *
	 * @param string $lang
	 *
	 * @since 3.2.0
	 */
	public function set(string $lang): void
	{
		if ($this->config->uikit > 0)
		{
			// main lang prefix
			$lang = $lang . '';
			// start building field set for uikit functions
			$this->configfieldsets->add('component', Indent::_(1) . "<fieldset");
			$this->configfieldsets->add('component', Indent::_(2) . 'name="uikit_config"');
			$this->configfieldsets->add('component', Indent::_(2) . 'label="' . $lang
				. '_UIKIT_LABEL"');
			$this->configfieldsets->add('component', Indent::_(2) . 'description="' . $lang
				. '_UIKIT_DESC">');
			// set tab lang
			if (1 == $this->config->uikit)
			{
				$this->language->set(
					$this->config->lang_target, $lang . '_UIKIT_LABEL', "Uikit2 Settings"
				);
				$this->language->set(
					$this->config->lang_target, $lang . '_UIKIT_DESC', "<b>The Parameters for the uikit are set here.</b><br />Uikit is a lightweight and modular front-end framework
for developing fast and powerful web interfaces. For more info visit <a href='https://getuikit.com/v2/' target='_blank'>https://getuikit.com/v2/</a>"
				);
			}
			elseif (2 == $this->config->uikit)
			{
				$this->language->set(
					$this->config->lang_target, $lang . '_UIKIT_LABEL',
					"Uikit2 and Uikit3 Settings"
				);
				$this->language->set(
					$this->config->lang_target, $lang . '_UIKIT_DESC', "<b>The Parameters for the uikit are set here.</b><br />Uikit is a lightweight and modular front-end framework
for developing fast and powerful web interfaces. For more info visit <a href='https://getuikit.com/v2/' target='_blank'>version 2</a> or <a href='https://getuikit.com/' target='_blank'>version 3</a>"
				);
			}
			elseif (3 == $this->config->uikit)
			{
				$this->language->set(
					$this->config->lang_target, $lang . '_UIKIT_LABEL', "Uikit3 Settings"
				);
				$this->language->set(
					$this->config->lang_target, $lang . '_UIKIT_DESC', "<b>The Parameters for the uikit are set here.</b><br />Uikit is a lightweight and modular front-end framework
for developing fast and powerful web interfaces. For more info visit <a href='https://getuikit.com/' target='_blank'>https://getuikit.com/</a>"
				);
			}

			// set field lang
			$this->language->set(
				$this->config->lang_target, $lang . '_JQUERY_LOAD_LABEL', "Load Joomla jQuery"
			);
			$this->language->set(
				$this->config->lang_target, $lang . '_JQUERY_LOAD_DESC',
				"Would you like to load the Joomla jQuery Framework?"
			);
			$this->language->set($this->config->lang_target, $lang . '_JQUERY_LOAD', "Load jQuery");
			$this->language->set($this->config->lang_target, $lang . '_JQUERY_REMOVE', "Remove jQuery");

			// set the field
			$this->configfieldsets->add('component', Indent::_(2)
				. '<field name="add_jquery_framework"');
			$this->configfieldsets->add('component', Indent::_(3) . 'type="radio"');
			$this->configfieldsets->add('component', Indent::_(3) . 'label="' . $lang
				. '_JQUERY_LOAD_LABEL"');
			$this->configfieldsets->add('component', Indent::_(3) . 'description="' . $lang
				. '_JQUERY_LOAD_DESC"');
			$this->configfieldsets->add('component', Indent::_(3)
				. 'class="btn-group btn-group-yesno"');
			$this->configfieldsets->add('component', Indent::_(3) . 'default="">');
			$this->configfieldsets->add('component', Indent::_(3) . '<!--' . Line::_(
					__LINE__,__CLASS__
				) . ' Option Set. -->');
			$this->configfieldsets->add('component', Indent::_(3) . '<option value="0">');
			$this->configfieldsets->add('component', Indent::_(4) . $lang
				. '_JQUERY_REMOVE</option>"');
			$this->configfieldsets->add('component', Indent::_(3) . '<option value="1">');
			$this->configfieldsets->add('component', Indent::_(4) . $lang
				. '_JQUERY_LOAD</option>"');
			$this->configfieldsets->add('component', Indent::_(2) . "</field>");
			// set params defaults
			$this->extensionsparams->add('component', '"add_jquery_framework":"1"');

			// add version selection
			if (2 == $this->config->uikit)
			{
				// set field lang
				$this->language->set(
					$this->config->lang_target, $lang . '_UIKIT_VERSION_LABEL',
					"Uikit Versions"
				);
				$this->language->set(
					$this->config->lang_target, $lang . '_UIKIT_VERSION_DESC',
					"Select what version you would like to use"
				);
				$this->language->set(
					$this->config->lang_target, $lang . '_UIKIT_V2', "Version 2"
				);
				$this->language->set(
					$this->config->lang_target, $lang . '_UIKIT_V3', "Version 3"
				);
				// set the field
				$this->configfieldsets->add('component', Indent::_(2)
					. '<field name="uikit_version"');
				$this->configfieldsets->add('component', Indent::_(3) . 'type="radio"');
				$this->configfieldsets->add('component', Indent::_(3) . 'label="' . $lang
					. '_UIKIT_VERSION_LABEL"');
				$this->configfieldsets->add('component', Indent::_(3) . 'description="'
					. $lang . '_UIKIT_VERSION_DESC"');
				$this->configfieldsets->add('component', Indent::_(3)
					. 'class="btn-group btn-group-yesno"');
				$this->configfieldsets->add('component', Indent::_(3) . 'default="2">');
				$this->configfieldsets->add('component', Indent::_(3) . '<!--'
					. Line::_(__Line__, __Class__) . ' Option Set. -->');
				$this->configfieldsets->add('component', Indent::_(3) . '<option value="2">');
				$this->configfieldsets->add('component', Indent::_(4) . $lang
					. '_UIKIT_V2</option>"');
				$this->configfieldsets->add('component', Indent::_(3) . '<option value="3">');
				$this->configfieldsets->add('component', Indent::_(4) . $lang
					. '_UIKIT_V3</option>"');
				$this->configfieldsets->add('component', Indent::_(2) . "</field>");
				// set params defaults
				$this->extensionsparams->add('component', '"uikit_version":"2"');
			}

			// set field lang
			$this->language->set(
				$this->config->lang_target, $lang . '_UIKIT_LOAD_LABEL', "Loading Options"
			);
			$this->language->set(
				$this->config->lang_target, $lang . '_UIKIT_LOAD_DESC',
				"Set the uikit loading option."
			);
			$this->language->set($this->config->lang_target, $lang . '_AUTO_LOAD', "Auto");
			$this->language->set($this->config->lang_target, $lang . '_FORCE_LOAD', "Force");
			$this->language->set($this->config->lang_target, $lang . '_DONT_LOAD', "Not");
			$this->language->set(
				$this->config->lang_target, $lang . '_ONLY_EXTRA', "Only Extra"
			);
			// set the field
			$this->configfieldsets->add('component', Indent::_(2)
				. '<field name="uikit_load"');
			$this->configfieldsets->add('component', Indent::_(3) . 'type="radio"');
			$this->configfieldsets->add('component', Indent::_(3) . 'label="' . $lang
				. '_UIKIT_LOAD_LABEL"');
			$this->configfieldsets->add('component', Indent::_(3) . 'description="' . $lang
				. '_UIKIT_LOAD_DESC"');
			$this->configfieldsets->add('component', Indent::_(3)
				. 'class="btn-group btn-group-yesno"');
			$this->configfieldsets->add('component', Indent::_(3) . 'default="">');
			$this->configfieldsets->add('component', Indent::_(3) . '<!--' . Line::_(
					__LINE__,__CLASS__
				) . ' Option Set. -->');
			$this->configfieldsets->add('component', Indent::_(3) . '<option value="">');
			$this->configfieldsets->add('component', Indent::_(4) . $lang
				. '_AUTO_LOAD</option>"');
			$this->configfieldsets->add('component', Indent::_(3) . '<option value="1">');
			$this->configfieldsets->add('component', Indent::_(4) . $lang
				. '_FORCE_LOAD</option>"');
			if (2 == $this->config->uikit || 1 == $this->config->uikit)
			{
				$this->configfieldsets->add('component', Indent::_(3) . '<option value="3">');
				$this->configfieldsets->add('component', Indent::_(4) . $lang
					. '_ONLY_EXTRA</option>"');
			}
			$this->configfieldsets->add('component', Indent::_(3) . '<option value="2">');
			$this->configfieldsets->add('component', Indent::_(4) . $lang
				. '_DONT_LOAD</option>"');
			$this->configfieldsets->add('component', Indent::_(2) . "</field>");
			// set params defaults
			$this->extensionsparams->add('component', '"uikit_load":"1"');

			// set field lang
			$this->language->set(
				$this->config->lang_target, $lang . '_UIKIT_MIN_LABEL', "Load Minified"
			);
			$this->language->set(
				$this->config->lang_target, $lang . '_UIKIT_MIN_DESC',
				"Should the minified version of uikit files be loaded?"
			);
			$this->language->set($this->config->lang_target, $lang . '_YES', "Yes");
			$this->language->set($this->config->lang_target, $lang . '_NO', "No");
			// set the field
			$this->configfieldsets->add('component', Indent::_(2) . '<field name="uikit_min"');
			$this->configfieldsets->add('component', Indent::_(3) . 'type="radio"');
			$this->configfieldsets->add('component', Indent::_(3) . 'label="' . $lang
				. '_UIKIT_MIN_LABEL"');
			$this->configfieldsets->add('component', Indent::_(3) . 'description="' . $lang
				. '_UIKIT_MIN_DESC"');
			$this->configfieldsets->add('component', Indent::_(3)
				. 'class="btn-group btn-group-yesno"');
			$this->configfieldsets->add('component', Indent::_(3) . 'default="">');
			$this->configfieldsets->add('component', Indent::_(3) . '<!--' . Line::_(
					__LINE__,__CLASS__
				) . ' Option Set. -->');
			$this->configfieldsets->add('component', Indent::_(3) . '<option value="">');
			$this->configfieldsets->add('component', Indent::_(4) . $lang . '_NO</option>"');
			$this->configfieldsets->add('component', Indent::_(3) . '<option value=".min">');
			$this->configfieldsets->add('component', Indent::_(4) . $lang . '_YES</option>"');
			$this->configfieldsets->add('component', Indent::_(2) . "</field>");
			// set params defaults
			$this->extensionsparams->add('component', '"uikit_min":""');

			if (2 == $this->config->uikit || 1 == $this->config->uikit)
			{
				// set field lang
				$this->language->set(
					$this->config->lang_target, $lang . '_UIKIT_STYLE_LABEL', "css Style"
				);
				$this->language->set(
					$this->config->lang_target, $lang . '_UIKIT_STYLE_DESC',
					"Set the css style that should be used."
				);
				$this->language->set(
					$this->config->lang_target, $lang . '_FLAT_LOAD', "Flat"
				);
				$this->language->set(
					$this->config->lang_target, $lang . '_ALMOST_FLAT_LOAD', "Almost Flat"
				);
				$this->language->set(
					$this->config->lang_target, $lang . '_GRADIANT_LOAD', "Gradient"
				);
				// set the field
				$this->configfieldsets->add('component', Indent::_(2)
					. '<field name="uikit_style"');
				$this->configfieldsets->add('component', Indent::_(3) . 'type="radio"');
				$this->configfieldsets->add('component', Indent::_(3) . 'label="' . $lang
					. '_UIKIT_STYLE_LABEL"');
				$this->configfieldsets->add('component', Indent::_(3) . 'description="'
					. $lang . '_UIKIT_STYLE_DESC"');
				$this->configfieldsets->add('component', Indent::_(3)
					. 'class="btn-group btn-group-yesno"');
				if (2 == $this->config->uikit)
				{
					$this->configfieldsets->add('component', Indent::_(3)
						. 'showon="uikit_version:2"');
				}
				$this->configfieldsets->add('component', Indent::_(3) . 'default="">');
				$this->configfieldsets->add('component', Indent::_(3) . '<!--'
					. Line::_(__Line__, __Class__) . ' Option Set. -->');
				$this->configfieldsets->add('component', Indent::_(3) . '<option value="">');
				$this->configfieldsets->add('component', Indent::_(4) . $lang
					. '_FLAT_LOAD</option>"');
				$this->configfieldsets->add('component', Indent::_(3)
					. '<option value=".almost-flat">');
				$this->configfieldsets->add('component', Indent::_(4) . $lang
					. '_ALMOST_FLAT_LOAD</option>"');
				$this->configfieldsets->add('component', Indent::_(3)
					. '<option value=".gradient">');
				$this->configfieldsets->add('component', Indent::_(4) . $lang
					. '_GRADIANT_LOAD</option>"');
				$this->configfieldsets->add('component', Indent::_(2) . "</field>");
				// set params defaults
				$this->extensionsparams->add('component', '"uikit_style":""');
			}
			// add custom Uikit Settings fields
			if ($this->customfield->isArray('Uikit Settings'))
			{
				$this->configfieldsets->add('component', implode(
					"", $this->customfield->get('Uikit Settings')
				));
				$this->customfield->remove('Uikit Settings');
			}
			// close that fieldset
			$this->configfieldsets->add('component', Indent::_(1) . "</fieldset>");
		}
	}
}

