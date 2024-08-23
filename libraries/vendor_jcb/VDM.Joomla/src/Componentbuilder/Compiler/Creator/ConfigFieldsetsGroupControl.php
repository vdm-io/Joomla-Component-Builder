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
use VDM\Joomla\Componentbuilder\Compiler\Builder\FieldGroupControl;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ConfigFieldsets;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ExtensionsParams;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ConfigFieldsetsCustomfield as Customfield;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;


/**
 * Config Fieldsets Group Control Creator Class
 * 
 * @since 3.2.0
 */
final class ConfigFieldsetsGroupControl
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
	 * The FieldGroupControl Class.
	 *
	 * @var   FieldGroupControl
	 * @since 3.2.0
	 */
	protected FieldGroupControl $fieldgroupcontrol;

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
	 * @param Config              $config              The Config Class.
	 * @param Language            $language            The Language Class.
	 * @param FieldGroupControl   $fieldgroupcontrol   The FieldGroupControl Class.
	 * @param ConfigFieldsets     $configfieldsets     The ConfigFieldsets Class.
	 * @param ExtensionsParams    $extensionsparams    The ExtensionsParams Class.
	 * @param Customfield         $customfield         The ConfigFieldsetsCustomfield Class.
	 *
	 * @since 3.2.0
	 */
	public function __construct(Config $config, Language $language,
		FieldGroupControl $fieldgroupcontrol,
		ConfigFieldsets $configfieldsets,
		ExtensionsParams $extensionsparams,
		Customfield $customfield)
	{
		$this->config = $config;
		$this->language = $language;
		$this->fieldgroupcontrol = $fieldgroupcontrol;
		$this->configfieldsets = $configfieldsets;
		$this->extensionsparams = $extensionsparams;
		$this->customfield = $customfield;
	}

	/**
	 * Set Group Control Config Fieldsets
	 *
	 * @param string $lang
	 *
	 * @since 1.0
	 */
	public function set(string $lang): void
	{
		// start loading Group control params if needed
		if ($this->fieldgroupcontrol->isActive())
		{
			// start building field set for config
			$this->configfieldsets->add('component', Indent::_(1) . "<fieldset");
			$this->configfieldsets->add('component', Indent::_(2) . 'name="group_config"');
			$this->configfieldsets->add('component', Indent::_(2) . 'label="' . $lang
				. '_GROUPS_LABEL"');
			$this->configfieldsets->add('component', Indent::_(2) . 'description="' . $lang
				. '_GROUPS_DESC">');
			// setup lang
			$this->language->set(
				$this->config->lang_target, $lang . '_GROUPS_LABEL', "Target Groups"
			);
			$this->language->set(
				$this->config->lang_target, $lang . '_GROUPS_DESC',
				"The Parameters for the targeted groups are set here."
			);
			$this->language->set(
				$this->config->lang_target, $lang . '_TARGET_GROUP_DESC',
				"Set the group/s being targeted by this user type."
			);

			foreach ($this->fieldgroupcontrol->allActive() as $selector => $label)
			{
				$this->configfieldsets->add('component', Indent::_(2) . '<field name="'
					. $selector . '"');
				$this->configfieldsets->add('component', Indent::_(3) . 'type="usergrouplist"');
				$this->configfieldsets->add('component', Indent::_(3) . 'label="' . $label . '"');
				$this->configfieldsets->add('component', Indent::_(3) . 'description="'
					. $lang . '_TARGET_GROUP_DESC"');
				$this->configfieldsets->add('component', Indent::_(3) . 'multiple="true"');
				$this->configfieldsets->add('component', Indent::_(2) . "/>");
				// set params defaults
				$this->extensionsparams->add('component', '"' . $selector . '":["2"]');
			}
			// add custom Target Groups fields
			if ($this->customfield->isArray('Target Groups'))
			{
				$this->configfieldsets->add('component', implode(
					"", $this->customfield->get('Target Groups')
				));
				$this->customfield->remove('Target Groups');
			}
			// close that fieldse
			$this->configfieldsets->add('component', Indent::_(1) . "</fieldset>");
		}
	}
}

