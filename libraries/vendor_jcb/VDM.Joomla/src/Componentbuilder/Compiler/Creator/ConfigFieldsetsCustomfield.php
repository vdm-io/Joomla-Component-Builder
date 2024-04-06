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
use VDM\Joomla\Componentbuilder\Compiler\Builder\ConfigFieldsetsCustomfield as Customfield;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ConfigFieldsets;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Utilities\GetHelper;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;


/**
 * Config Fieldsets Customfield Creator Class
 * 
 * @since 3.2.0
 */
final class ConfigFieldsetsCustomfield
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
	 * The ConfigFieldsetsCustomfield Class.
	 *
	 * @var   Customfield
	 * @since 3.2.0
	 */
	protected Customfield $customfield;

	/**
	 * The ConfigFieldsets Class.
	 *
	 * @var   ConfigFieldsets
	 * @since 3.2.0
	 */
	protected ConfigFieldsets $configfieldsets;

	/**
	 * Constructor.
	 *
	 * @param Config            $config            The Config Class.
	 * @param Language          $language          The Language Class.
	 * @param Customfield       $customfield       The ConfigFieldsetsCustomfield Class.
	 * @param ConfigFieldsets   $configfieldsets   The ConfigFieldsets Class.
	 *
	 * @since 3.2.0
	 */
	public function __construct(Config $config, Language $language,
		Customfield $customfield,
		ConfigFieldsets $configfieldsets)
	{
		$this->config = $config;
		$this->language = $language;
		$this->customfield = $customfield;
		$this->configfieldsets = $configfieldsets;
	}

	/**
	 * Set Custom Control Config Fieldsets
	 *
	 * @param string $lang
	 *
	 * @since 1.0
	 */
	public function set(string $lang): void
	{
		// add custom new global fields set
		if ($this->customfield->isActive())
		{
			foreach ($this->customfield->allActive() as $tab => $tabFields)
			{
				$tabCode  = StringHelper::safe($tab)
					. '_custom_config';
				$tabUpper = StringHelper::safe($tab, 'U');
				$tabLower = StringHelper::safe($tab);
				// remove display targeted fields
				$bucket = [];
				foreach ($tabFields as $tabField)
				{
					$display = GetHelper::between(
						$tabField, 'display="', '"'
					);
					if (!StringHelper::check($display)
						|| $display === 'config')
					{
						// remove this display since it is not used in Joomla
						$bucket[] = str_replace(
							'display="config"', '', (string) $tabField
						);
					}
				}
				// only add the tab if it has values
				if (ArrayHelper::check($bucket))
				{
					// setup lang
					$this->language->set(
						$this->config->lang_target, $lang . '_' . $tabUpper, $tab
					);
					// start field set
					$this->configfieldsets->add('component', Indent::_(1) . "<fieldset");
					$this->configfieldsets->add('component', Indent::_(2) . 'name="'
						. $tabCode . '"');
					$this->configfieldsets->add('component', Indent::_(2) . 'label="' . $lang
						. '_' . $tabUpper . '">');
					// set the fields
					$this->configfieldsets->add('component', implode("", $bucket));
					// close field set
					$this->configfieldsets->add('component', Indent::_(1) . "</fieldset>");
				}
				// remove after loading
				$this->customfield->remove($tab);
			}
		}
	}
}

