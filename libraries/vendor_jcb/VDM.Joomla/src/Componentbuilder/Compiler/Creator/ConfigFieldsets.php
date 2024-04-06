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
use VDM\Joomla\Componentbuilder\Compiler\Component;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\EventInterface as Event;
use VDM\Joomla\Componentbuilder\Compiler\Placeholder;
use VDM\Joomla\Componentbuilder\Compiler\Component\Placeholder as CPlaceholder;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ExtensionsParams;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ConfigFieldsetsCustomfield as Customfield;
use VDM\Joomla\Componentbuilder\Compiler\Creator\FieldAsString;
use VDM\Joomla\Componentbuilder\Compiler\Creator\ConfigFieldsetsGlobal;
use VDM\Joomla\Componentbuilder\Compiler\Creator\ConfigFieldsetsSiteControl;
use VDM\Joomla\Componentbuilder\Compiler\Creator\ConfigFieldsetsGroupControl;
use VDM\Joomla\Componentbuilder\Compiler\Creator\ConfigFieldsetsUikit;
use VDM\Joomla\Componentbuilder\Compiler\Creator\ConfigFieldsetsGooglechart;
use VDM\Joomla\Componentbuilder\Compiler\Creator\ConfigFieldsetsEmailHelper;
use VDM\Joomla\Componentbuilder\Compiler\Creator\ConfigFieldsetsEncryption;
use VDM\Joomla\Componentbuilder\Compiler\Creator\ConfigFieldsetsCustomfield;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Placefix;
use VDM\Joomla\Utilities\GetHelper;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;
use VDM\Joomla\Utilities\MathHelper;


/**
 * Config Fieldsets Creator Class
 * 
 * @since 3.2.0
 */
final class ConfigFieldsets
{
	/**
	 * The Config Class.
	 *
	 * @var   Config
	 * @since 3.2.0
	 */
	protected Config $config;

	/**
	 * The Component Class.
	 *
	 * @var   Component
	 * @since 3.2.0
	 */
	protected Component $component;

	/**
	 * The EventInterface Class.
	 *
	 * @var   Event
	 * @since 3.2.0
	 */
	protected Event $event;

	/**
	 * The Placeholder Class.
	 *
	 * @var   Placeholder
	 * @since 3.2.0
	 */
	protected Placeholder $placeholder;

	/**
	 * The Placeholder Class.
	 *
	 * @var   CPlaceholder
	 * @since 3.2.0
	 */
	protected CPlaceholder $cplaceholder;

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
	 * The FieldAsString Class.
	 *
	 * @var   FieldAsString
	 * @since 3.2.0
	 */
	protected FieldAsString $fieldasstring;

	/**
	 * The ConfigFieldsetsGlobal Class.
	 *
	 * @var   ConfigFieldsetsGlobal
	 * @since 3.2.0
	 */
	protected ConfigFieldsetsGlobal $configfieldsetsglobal;

	/**
	 * The ConfigFieldsetsSiteControl Class.
	 *
	 * @var   ConfigFieldsetsSiteControl
	 * @since 3.2.0
	 */
	protected ConfigFieldsetsSiteControl $configfieldsetssitecontrol;

	/**
	 * The ConfigFieldsetsGroupControl Class.
	 *
	 * @var   ConfigFieldsetsGroupControl
	 * @since 3.2.0
	 */
	protected ConfigFieldsetsGroupControl $configfieldsetsgroupcontrol;

	/**
	 * The ConfigFieldsetsUikit Class.
	 *
	 * @var   ConfigFieldsetsUikit
	 * @since 3.2.0
	 */
	protected ConfigFieldsetsUikit $configfieldsetsuikit;

	/**
	 * The ConfigFieldsetsGooglechart Class.
	 *
	 * @var   ConfigFieldsetsGooglechart
	 * @since 3.2.0
	 */
	protected ConfigFieldsetsGooglechart $configfieldsetsgooglechart;

	/**
	 * The ConfigFieldsetsEmailHelper Class.
	 *
	 * @var   ConfigFieldsetsEmailHelper
	 * @since 3.2.0
	 */
	protected ConfigFieldsetsEmailHelper $configfieldsetsemailhelper;

	/**
	 * The ConfigFieldsetsEncryption Class.
	 *
	 * @var   ConfigFieldsetsEncryption
	 * @since 3.2.0
	 */
	protected ConfigFieldsetsEncryption $configfieldsetsencryption;

	/**
	 * The ConfigFieldsetsCustomfield Class.
	 *
	 * @var   ConfigFieldsetsCustomfield
	 * @since 3.2.0
	 */
	protected ConfigFieldsetsCustomfield $configfieldsetscustomfield;

	/**
	 * Constructor.
	 *
	 * @param Config                        $config                        The Config Class.
	 * @param Component                     $component                     The Component Class.
	 * @param Event                         $event                         The EventInterface Class.
	 * @param Placeholder                   $placeholder                   The Placeholder Class.
	 * @param CPlaceholder                  $cplaceholder                  The Placeholder Class.
	 * @param ExtensionsParams              $extensionsparams              The ExtensionsParams Class.
	 * @param Customfield                   $customfield                   The ConfigFieldsetsCustomfield Class.
	 * @param FieldAsString                 $fieldasstring                 The FieldAsString Class.
	 * @param ConfigFieldsetsGlobal         $configfieldsetsglobal         The ConfigFieldsetsGlobal Class.
	 * @param ConfigFieldsetsSiteControl    $configfieldsetssitecontrol    The ConfigFieldsetsSiteControl Class.
	 * @param ConfigFieldsetsGroupControl   $configfieldsetsgroupcontrol   The ConfigFieldsetsGroupControl Class.
	 * @param ConfigFieldsetsUikit          $configfieldsetsuikit          The ConfigFieldsetsUikit Class.
	 * @param ConfigFieldsetsGooglechart    $configfieldsetsgooglechart    The ConfigFieldsetsGooglechart Class.
	 * @param ConfigFieldsetsEmailHelper    $configfieldsetsemailhelper    The ConfigFieldsetsEmailHelper Class.
	 * @param ConfigFieldsetsEncryption     $configfieldsetsencryption     The ConfigFieldsetsEncryption Class.
	 * @param ConfigFieldsetsCustomfield    $configfieldsetscustomfield    The ConfigFieldsetsCustomfield Class.
	 *
	 * @since 3.2.0
	 */
	public function __construct(Config $config, Component $component, Event $event,
		Placeholder $placeholder, CPlaceholder $cplaceholder,
		ExtensionsParams $extensionsparams,
		Customfield $customfield, FieldAsString $fieldasstring,
		ConfigFieldsetsGlobal $configfieldsetsglobal,
		ConfigFieldsetsSiteControl $configfieldsetssitecontrol,
		ConfigFieldsetsGroupControl $configfieldsetsgroupcontrol,
		ConfigFieldsetsUikit $configfieldsetsuikit,
		ConfigFieldsetsGooglechart $configfieldsetsgooglechart,
		ConfigFieldsetsEmailHelper $configfieldsetsemailhelper,
		ConfigFieldsetsEncryption $configfieldsetsencryption,
		ConfigFieldsetsCustomfield $configfieldsetscustomfield)
	{
		$this->config = $config;
		$this->component = $component;
		$this->event = $event;
		$this->placeholder = $placeholder;
		$this->cplaceholder = $cplaceholder;
		$this->extensionsparams = $extensionsparams;
		$this->customfield = $customfield;
		$this->fieldasstring = $fieldasstring;
		$this->configfieldsetsglobal = $configfieldsetsglobal;
		$this->configfieldsetssitecontrol = $configfieldsetssitecontrol;
		$this->configfieldsetsgroupcontrol = $configfieldsetsgroupcontrol;
		$this->configfieldsetsuikit = $configfieldsetsuikit;
		$this->configfieldsetsgooglechart = $configfieldsetsgooglechart;
		$this->configfieldsetsemailhelper = $configfieldsetsemailhelper;
		$this->configfieldsetsencryption = $configfieldsetsencryption;
		$this->configfieldsetscustomfield = $configfieldsetscustomfield;
	}

	/**
	 * Set Config Fieldsets
	 *
	 * @param int $timer
	 *
	 * @since 1.0
	 */
	public function set(int $timer = 0): void
	{
		// main lang prefix
		$lang = $this->config->lang_prefix . '_CONFIG';
		if (1 == $timer) // this is before the admin views are build
		{
			// start loading Global params
			$autorName = StringHelper::html(
				$this->component->get('author')
			);
			$autorEmail = StringHelper::html(
				$this->component->get('email')
			);
			$this->extensionsparams->add('component', '"autorName":"' . $autorName
				. '","autorEmail":"' . $autorEmail . '"');

			// set the custom fields
			if ($this->component->isArray('config'))
			{
				// set component code name
				$component      = $this->config->component_code_name;
				$nameSingleCode = 'config';
				$nameListCode   = 'configs';

				// set place holders
				$placeholders = [];
				$placeholders[Placefix::_h('component')]
					= $this->config->component_code_name;
				$placeholders[Placefix::_h('Component')]
					= StringHelper::safe(
					$this->component->get('name_code'), 'F'
				);
				$placeholders[Placefix::_h('COMPONENT')]
					= StringHelper::safe(
					$this->component->get('name_code'), 'U'
				);
				$placeholders[Placefix::_h('view')]
					= $nameSingleCode;
				$placeholders[Placefix::_h('views')]
					= $nameListCode;
				$placeholders[Placefix::_('component')]
					= $this->config->component_code_name;
				$placeholders[Placefix::_('Component')]
					= $placeholders[Placefix::_h('Component')];
				$placeholders[Placefix::_('COMPONENT')]
					= $placeholders[Placefix::_h('COMPONENT')];
				$placeholders[Placefix::_('view')]
					= $nameSingleCode;
				$placeholders[Placefix::_('views')]
					= $nameListCode;

				// load the global placeholders
				foreach ($this->cplaceholder->get() as $globalPlaceholder => $gloabalValue)
				{
					$placeholders[$globalPlaceholder] = $gloabalValue;
				}
				$view     = [];
				$viewType = 0;
				// set the custom table key
				$dbkey = 'g';

				// Trigger Event: jcb_ce_onBeforeSetConfigFieldsets
				$this->event->trigger(
					'jcb_ce_onBeforeSetConfigFieldsets', [&$timer]
				);

				// build the config fields
				foreach ($this->component->get('config') as $field)
				{
					// get the xml string
					$xmlField = $this->fieldasstring->get(
						$field, $view, $viewType, $lang, $nameSingleCode,
						$nameListCode, $placeholders, $dbkey, false
					);

					// make sure the xml is set and a string
					if (isset($xmlField) && StringHelper::check($xmlField))
					{
						$this->customfield->add($field['tabname'], $xmlField, true);
						// set global params to db on install
						$fieldName    = StringHelper::safe(
							$this->placeholder->update(
								GetHelper::between(
									$xmlField, 'name="', '"'
								), $placeholders
							)
						);
						$fieldDefault = $this->placeholder->update(
							GetHelper::between(
								$xmlField, 'default="', '"'
							), $placeholders
						);
						if (isset($field['custom_value'])
							&& StringHelper::check(
								$field['custom_value']
							))
						{
							// add array if found
							if ((strpos((string) $field['custom_value'], '["') !== false)
								&& (strpos((string) $field['custom_value'], '"]')
									!== false))
							{
								// load the Global checkin defautls
								$this->extensionsparams->add('component', '"' . $fieldName
									. '":' . $field['custom_value']);
							}
							else
							{
								// load the Global checkin defautls
								$this->extensionsparams->add('component', '"' . $fieldName
									. '":"' . $field['custom_value'] . '"');
							}
						}
						elseif (StringHelper::check($fieldDefault))
						{
							// load the Global checkin defautls
							$this->extensionsparams->add('component', '"' . $fieldName . '":"'
								. $fieldDefault . '"');
						}
					}
				}
			}

			// first run we must set the global
			$this->configfieldsetsglobal->set($lang, $autorName, $autorEmail);
			$this->configfieldsetssitecontrol->set($lang);
		}
		elseif (2 == $timer) // this is after the admin views are build
		{
			// Trigger Event: jcb_ce_onBeforeSetConfigFieldsets
			$this->event->trigger(
				'jcb_ce_onBeforeSetConfigFieldsets', [&$timer]
			);

			// these field sets can only be added after admin view is build
			$this->configfieldsetsgroupcontrol->set($lang);

			// these can be added anytime really (but looks best after groups
			$this->configfieldsetsuikit->set($lang);
			$this->configfieldsetsgooglechart->set($lang);
			$this->configfieldsetsemailhelper->set($lang);
			$this->configfieldsetsencryption->set($lang);

			// these are the custom settings
			$this->configfieldsetscustomfield->set($lang);
		}

		// Trigger Event: jcb_ce_onAfterSetConfigFieldsets
		$this->event->trigger(
			'jcb_ce_onAfterSetConfigFieldsets', [&$timer]
		);
	}
}

