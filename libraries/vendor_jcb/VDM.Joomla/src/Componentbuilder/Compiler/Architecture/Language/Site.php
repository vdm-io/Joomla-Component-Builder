<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    19th August, 2026
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\Language;


use VDM\Joomla\Componentbuilder\Compiler\Builder\Languages;
use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\EventInterface as Event;
use VDM\Joomla\Componentbuilder\Compiler\Language;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Placefix;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\StringHelper;


/**
 * Language Site Class.
 * 
 * Registers every language string the site side needs.
 * 
 * @since 6.1.7
 */
final class Site
{
	/**
	 * The Config Class.
	 *
	 * @var   Config
	 * @since 6.1.7
	 */
	protected Config $config;

	/**
	 * The Languages Builder Class.
	 *
	 * @var   Languages
	 * @since 6.1.7
	 */
	protected Languages $languages;

	/**
	 * The Language Class.
	 *
	 * @var   Language
	 * @since 6.1.7
	 */
	protected Language $language;

	/**
	 * The Event Class.
	 *
	 * @var   Event
	 * @since 6.1.7
	 */
	protected Event $event;

	/**
	 * Constructor.
	 *
	 * @param Config    $config    The Config Class.
	 * @param Languages $languages The Languages Builder Class.
	 * @param Language  $language  The Language Class.
	 * @param Event     $event     The Event Class.
	 *
	 * @since 6.1.7
	 */
	public function __construct(Config $config,
		Languages $languages,
		Language $language,
		Event $event)
	{
		$this->config = $config;
		$this->languages = $languages;
		$this->language = $language;
		$this->event = $event;
	}

	/**
	 * Register every language string of the site side.
	 *
	 * What the component was built with decides which of them are needed,
	 * and the compiler is given the chance to add its own before they are read.
	 *
	 * @param   string  $componentName  The component name.
	 *
	 * @return  bool  Whether the strings were registered.
	 *
	 * @since   6.1.7
	 */
	public function get(string $componentName): bool
	{
		// Trigger Event: jcb_ce_onBeforeBuildSiteLang
		$this->event->trigger(
			'jcb_ce_onBeforeBuildSiteLang'
		);

		// add final list of needed lang strings
		$this->language->set('site', $this->config->lang_prefix, $componentName);
		// some more defaults
		$this->language->set('site', 'JTOOLBAR_APPLY', "Save");
		$this->language->set('site', 'JTOOLBAR_SAVE_AS_COPY', "Save as Copy");
		$this->language->set('site', 'JTOOLBAR_SAVE', "Save & Close");
		$this->language->set('site', 'JTOOLBAR_SAVE_AND_NEW', "Save & New");
		$this->language->set('site', 'JTOOLBAR_CANCEL', "Cancel");
		$this->language->set('site', 'JTOOLBAR_CLOSE', "Close");
		$this->language->set('site', 'JTOOLBAR_HELP', "Help");
		$this->language->set('site', 'JGLOBAL_FIELD_ID_LABEL', "ID");
		$this->language->set(
			'site', 'JGLOBAL_FIELD_ID_DESC', "Record number in the database."
		);
		$this->language->set(
			'site', 'JGLOBAL_FIELD_MODIFIED_LABEL', "Modified Date"
		);
		$this->language->set(
			'site', 'COM_CONTENT_FIELD_MODIFIED_DESC',
			"The last date this item was modified."
		);
		$this->language->set(
			'site', 'JGLOBAL_FIELD_MODIFIED_BY_LABEL', "Modified By"
		);
		$this->language->set(
			'site', 'JGLOBAL_FIELD_MODIFIED_BY_DESC',
			"The user who did the last modification."
		);
		$this->language->set('site', $this->config->lang_prefix . '_NEW', "New");
		$this->language->set(
			'site', $this->config->lang_prefix . '_CREATE_NEW_S', "Create New %s"
		);
		$this->language->set('site', $this->config->lang_prefix . '_EDIT_S', "Edit %s");
		$this->language->set(
			'site', $this->config->lang_prefix . '_NO_ACCESS_GRANTED',
			"No Access Granted!"
		);
		$this->language->set(
			'site', $this->config->lang_prefix . '_NOT_FOUND_OR_ACCESS_DENIED',
			"Not found or access denied!"
		);

		// check if the both array is set
		if ($this->language->exist('both'))
		{
			foreach ($this->language->getTarget('both') as $keylang => $langval)
			{
				$this->language->set('site', $keylang, $langval);
			}
		}

		// check if the both site array is set
		if ($this->language->exist('bothsite'))
		{
			foreach ($this->language->getTarget('bothsite') as $keylang => $langval)
			{
				$this->language->set('site', $keylang, $langval);
			}
		}

		if ($this->language->exist('site'))
		{
			// Trigger Event: jcb_ce_onAfterBuildSiteLang
			$this->event->trigger(
				'jcb_ce_onAfterBuildSiteLang'
			);

			// Get the site language content
			$langContent = $this->language->getTarget('site');
			// sort the strings
			ksort($langContent);
			// load to global languages
			$langTag = $this->config->get('lang_tag', 'en-GB');
			$this->languages->set(
				"components.{$langTag}.site",
				$langContent
			);
			// remove tmp array
			$this->language->setTarget('site', null);

			return true;
		}

		return false;
	}
}

