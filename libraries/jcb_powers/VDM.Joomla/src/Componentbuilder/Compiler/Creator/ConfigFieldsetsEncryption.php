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
use VDM\Joomla\Componentbuilder\Compiler\Builder\ConfigFieldsets;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ConfigFieldsetsCustomfield as Customfield;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;


/**
 * Config Fieldsets Encryption Creator Class
 * 
 * @since 3.2.0
 */
final class ConfigFieldsetsEncryption
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
	 * The ConfigFieldsets Class.
	 *
	 * @var   ConfigFieldsets
	 * @since 3.2.0
	 */
	protected ConfigFieldsets $configfieldsets;

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
	 * @param Config            $config            The Config Class.
	 * @param Language          $language          The Language Class.
	 * @param Component         $component         The Component Class.
	 * @param ConfigFieldsets   $configfieldsets   The ConfigFieldsets Class.
	 * @param Customfield       $customfield       The ConfigFieldsetsCustomfield Class.
	 *
	 * @since 3.2.0
	 */
	public function __construct(Config $config, Language $language, Component $component,
		ConfigFieldsets $configfieldsets,
		Customfield $customfield)
	{
		$this->config = $config;
		$this->language = $language;
		$this->component = $component;
		$this->configfieldsets = $configfieldsets;
		$this->customfield = $customfield;
	}

	/**
	 * Set Encryption Config Fieldsets
	 *
	 * @param string $lang
	 *
	 * @since 3.2.0
	 */
	public function set(string $lang): void
	{
		// enable the loading of dynamic field sets
		$dynamicAddFields = [];

		// Add encryption if needed
		if ($this->config->basic_encryption
			|| $this->config->whmcs_encryption
			|| $this->config->medium_encryption
			|| $this->component->get('add_license')
			|| $this->customfield->isArray('Encryption Settings'))
		{
			$dynamicAddFields[] = "Encryption Settings";
			// start building field set for encryption functions
			$this->configfieldsets->add('component', Indent::_(1) . "<fieldset");
			$this->configfieldsets->add('component', Indent::_(2)
				. 'name="encryption_config"');
			$this->configfieldsets->add('component', Indent::_(2) . 'label="' . $lang
				. '_ENCRYPTION_LABEL"');
			$this->configfieldsets->add('component', Indent::_(2) . 'description="' . $lang
				. '_ENCRYPTION_DESC">');

			// set tab lang
			if (($this->config->basic_encryption
					|| $this->config->medium_encryption
					|| $this->config->whmcs_encryption)
				&& $this->component->get('add_license')
				&& $this->component->get('license_type', 0) == 3)
			{
				$this->language->set(
					$this->config->lang_target, $lang . '_ENCRYPTION_LABEL',
					"License & Encryption Settings"
				);
				$this->language->set(
					$this->config->lang_target, $lang . '_ENCRYPTION_DESC',
					"The license & encryption keys are set here."
				);
				// add the next dynamic option
				$dynamicAddFields[] = "License & Encryption Settings";
			}
			elseif (($this->config->basic_encryption
					|| $this->config->medium_encryption
					|| $this->config->whmcs_encryption)
				&& $this->component->get('add_license')
				&& $this->component->get('license_type', 0) == 2)
			{
				$this->language->set(
					$this->config->lang_target, $lang . '_ENCRYPTION_LABEL',
					"Update & Encryption Settings"
				);
				$this->language->set(
					$this->config->lang_target, $lang . '_ENCRYPTION_DESC',
					"The update & encryption keys are set here."
				);
				// add the next dynamic option
				$dynamicAddFields[] = "Update & Encryption Settings";
			}
			elseif ($this->component->get('add_license')
				&& $this->component->get('license_type', 0) == 3)
			{
				$this->language->set(
					$this->config->lang_target, $lang . '_ENCRYPTION_LABEL', "License Settings"
				);
				$this->language->set(
					$this->config->lang_target, $lang . '_ENCRYPTION_DESC',
					"The license key is set here."
				);
				// add the next dynamic option
				$dynamicAddFields[] = "License Settings";
			}
			elseif ($this->component->get('add_license')
				&& $this->component->get('license_type', 0) == 2)
			{
				$this->language->set(
					$this->config->lang_target, $lang . '_ENCRYPTION_LABEL', "Update Settings"
				);
				$this->language->set(
					$this->config->lang_target, $lang . '_ENCRYPTION_DESC',
					"The update key is set here."
				);
				// add the next dynamic option
				$dynamicAddFields[] = "Update Settings";
			}
			else
			{
				$this->language->set(
					$this->config->lang_target, $lang . '_ENCRYPTION_LABEL',
					"Encryption Settings"
				);
				$this->language->set(
					$this->config->lang_target, $lang . '_ENCRYPTION_DESC',
					"The encryption key for the field encryption is set here."
				);
			}

			if ($this->config->basic_encryption)
			{
				// set field lang
				$this->language->set(
					$this->config->lang_target, $lang . '_BASIC_KEY_LABEL', "Basic Key"
				);
				$this->language->set(
					$this->config->lang_target, $lang . '_BASIC_KEY_DESC',
					"Set the basic local key here."
				);
				$this->language->set(
					$this->config->lang_target, $lang . '_BASIC_KEY_NOTE_LABEL',
					"Basic Encryption"
				);
				$this->language->set(
					$this->config->lang_target, $lang . '_BASIC_KEY_NOTE_DESC',
					"When using the basic encryption please use set a 32 character passphrase.<br />Never change this passphrase once it is set! <b>DATA WILL GET CORRUPTED IF YOU DO!</b>"
				);

				// set the field
				$this->configfieldsets->add('component', Indent::_(2)
					. '<field type="note" name="basic_key_note" class="alert alert-info" label="'
					. $lang . '_BASIC_KEY_NOTE_LABEL" description="' . $lang
					. '_BASIC_KEY_NOTE_DESC"  />');
				$this->configfieldsets->add('component', Indent::_(2)
					. '<field name="basic_key"');
				$this->configfieldsets->add('component', Indent::_(3) . 'type="text"');
				$this->configfieldsets->add('component', Indent::_(3) . 'label="' . $lang
					. '_BASIC_KEY_LABEL"');
				$this->configfieldsets->add('component', Indent::_(3) . 'description="'
					. $lang . '_BASIC_KEY_DESC"');
				$this->configfieldsets->add('component', Indent::_(3) . 'size="60"');
				$this->configfieldsets->add('component', Indent::_(3) . 'default=""');
				$this->configfieldsets->add('component', Indent::_(2) . "/>");
			}

			if ($this->config->medium_encryption)
			{
				// set field lang
				$this->language->set(
					$this->config->lang_target, $lang . '_MEDIUM_KEY_LABEL',
					"Medium Key (Path)"
				);
				$this->language->set(
					$this->config->lang_target, $lang . '_MEDIUM_KEY_DESC',
					"Set the full path to where the key file must be stored. Make sure it is behind the root folder of your website, so that it is not public accessible."
				);
				$this->language->set(
					$this->config->lang_target, $lang . '_MEDIUM_KEY_NOTE_LABEL',
					"Medium Encryption"
				);
				$this->language->set(
					$this->config->lang_target, $lang . '_MEDIUM_KEY_NOTE_DESC',
					"When using the medium encryption option, the system generates its own key and stores it in a file at the folder/path you set here.<br />Never change this key once it is set, or remove the key file! <b>DATA WILL GET CORRUPTED IF YOU DO!</b> Also make sure the full path to where the the key file should be stored, is behind the root folder of your website/system, so that it is not public accessible. Making a backup of this key file over a <b>secure connection</b> is recommended!"
				);

				// set the field
				$this->configfieldsets->add('component', Indent::_(2)
					. '<field type="note" name="medium_key_note" class="alert alert-info" label="'
					. $lang . '_MEDIUM_KEY_NOTE_LABEL" description="' . $lang
					. '_MEDIUM_KEY_NOTE_DESC" />');
				$this->configfieldsets->add('component', Indent::_(2)
					. '<field name="medium_key_path"');
				$this->configfieldsets->add('component', Indent::_(3) . 'type="text"');
				$this->configfieldsets->add('component', Indent::_(3) . 'label="' . $lang
					. '_MEDIUM_KEY_LABEL"');
				$this->configfieldsets->add('component', Indent::_(3) . 'description="'
					. $lang . '_MEDIUM_KEY_DESC"');
				$this->configfieldsets->add('component', Indent::_(3) . 'size="160"');
				$this->configfieldsets->add('component', Indent::_(3) . 'filter="PATH"');
				$this->configfieldsets->add('component', Indent::_(3)
					. 'hint="/home/user/hiddenfolder123/"');
				$this->configfieldsets->add('component', Indent::_(3) . 'default=""');
				$this->configfieldsets->add('component', Indent::_(2) . "/>");
				// set some error message if the path does not exist
				$this->language->set(
					$this->config->lang_target, $lang . '_MEDIUM_KEY_PATH_ERROR',
					"Medium key path (for encryption of various fields) does not exist, or is not writable. Please check the path and update it in the global option of this component."
				);
			}

			if ($this->config->whmcs_encryption
				|| $this->component->get('add_license'))
			{
				// set field lang label and description
				if ($this->component->get('add_license')
					&& $this->component->get('license_type', 0) == 3)
				{
					$this->language->set(
						$this->config->lang_target, $lang . '_WHMCS_KEY_LABEL',
						$this->component->get('companyname', '') . " License Key"
					);
					$this->language->set(
						$this->config->lang_target, $lang . '_WHMCS_KEY_DESC',
						"Add the license key you recieved from "
						. $this->component->get('companyname', '') . " here."
					);
				}
				elseif ($this->component->get('add_license')
					&& $this->component->get('license_type', 0) == 2)
				{
					$this->language->set(
						$this->config->lang_target, $lang . '_WHMCS_KEY_LABEL',
						$this->component->get('companyname', '') . " Update Key"
					);
					$this->language->set(
						$this->config->lang_target, $lang . '_WHMCS_KEY_DESC',
						"Add the update key you recieved from "
						. $this->component->get('companyname', '') . " here."
					);
				}
				else
				{
					$this->language->set(
						$this->config->lang_target, $lang . '_WHMCS_KEY_LABEL',
						$this->component->get('companyname', '') . " Key"
					);
					$this->language->set(
						$this->config->lang_target, $lang . '_WHMCS_KEY_DESC',
						"Add the key you recieved from "
						. $this->component->get('companyname', '') . " here."
					);
				}

				// adjust the notice based on license
				if ($this->component->get('license_type',0) == 3)
				{
					$this->language->set(
						$this->config->lang_target, $lang . '_WHMCS_KEY_NOTE_LABEL',
						"Your " . $this->component->get('companyname','')
						. " License Key"
					);
				}
				elseif ($this->component->get('license_type',0) == 2)
				{
					$this->language->set(
						$this->config->lang_target, $lang . '_WHMCS_KEY_NOTE_LABEL',
						"Your " . $this->component->get('companyname','')
						. " Update Key"
					);
				}
				else
				{
					if ($this->config->whmcs_encryption)
					{
						$this->language->set(
							$this->config->lang_target, $lang . '_WHMCS_KEY_NOTE_LABEL',
							"Your " . $this->component->get('companyname','')
							. " Field Encryption Key"
						);
					}
					else
					{
						$this->language->set(
							$this->config->lang_target, $lang . '_WHMCS_KEY_NOTE_LABEL',
							"Your " . $this->component->get('companyname','') . " Key"
						);
					}
				}

				// add the description based on global settings
				if ($this->config->whmcs_encryption)
				{
					$this->language->set(
						$this->config->lang_target, $lang . '_WHMCS_KEY_NOTE_DESC',
						"You need to get this key from <a href='"
						. $this->component->get('whmcs_buy_link','')
						. "' target='_blank'>"
						. $this->component->get('companyname','')
						. "</a>.<br />When using the "
						. $this->component->get('companyname','')
						. " field encryption you can never change this key once it is set! <b>DATA WILL GET CORRUPTED IF YOU DO!</b>"
					);
				}
				else
				{
					$this->language->set(
						$this->config->lang_target, $lang . '_WHMCS_KEY_NOTE_DESC',
						"You need to get this key from <a href='"
						. $this->component->get('whmcs_buy_link','')
						. "' target='_blank'>"
						. $this->component->get('companyname','') . "</a>."
					);
				}

				// set the fields
				$this->configfieldsets->add('component', Indent::_(2)
					. '<field type="note" name="whmcs_key_note" class="alert alert-info" label="'
					. $lang . '_WHMCS_KEY_NOTE_LABEL" description="' . $lang
					. '_WHMCS_KEY_NOTE_DESC"  />');
				$this->configfieldsets->add('component', Indent::_(2)
					. '<field name="whmcs_key"');  // We had to change this from license_key & advanced_key to whmcs_key
				$this->configfieldsets->add('component', Indent::_(3) . 'type="text"');
				$this->configfieldsets->add('component', Indent::_(3) . 'label="' . $lang
					. '_WHMCS_KEY_LABEL"');
				$this->configfieldsets->add('component', Indent::_(3) . 'description="'
					. $lang . '_WHMCS_KEY_DESC"');
				$this->configfieldsets->add('component', Indent::_(3) . 'size="60"');
				$this->configfieldsets->add('component', Indent::_(3) . 'default=""');
				$this->configfieldsets->add('component', Indent::_(2) . "/>");
			}

			// load the dynamic field sets
			foreach ($dynamicAddFields as $dynamicAddField)
			{
				// add custom Encryption Settings fields
				if ($this->customfield->isArray($dynamicAddField))
				{
					$this->configfieldsets->add('component', implode(
						"", $this->customfield->get($dynamicAddField)
					));
					$this->customfield->remove($dynamicAddField);
				}
			}

			// close that fieldset
			$this->configfieldsets->add('component', Indent::_(1) . "</fieldset>");
		}
	}
}

