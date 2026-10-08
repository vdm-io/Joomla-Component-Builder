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
 * Language AdminSys Class.
 * 
 * Registers every language string the administrator side needs before it is
 * installed.
 * 
 * @since 6.1.7
 */
final class AdminSys
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
	 * Register every language string of the admin sys side.
	 *
	 * What the component was built with decides which of them are needed,
	 * and the compiler is given the chance to add its own before they are read.
	 *
	 *
	 * @return  bool  Whether the strings were registered.
	 *
	 * @since   6.1.7
	 */
	public function get(): bool
	{
		// Trigger Event: jcb_ce_onBeforeBuildAdminSysLang
		$this->event->trigger(
			'jcb_ce_onBeforeBuildAdminSysLang'
		);

		// check if the both admin array is set
		if ($this->language->exist('bothadmin'))
		{
			foreach ($this->language->getTarget('bothadmin') as $keylang => $langval)
			{
				$this->language->set('adminsys', $keylang, $langval);
			}
		}
		if ($this->language->exist('adminsys'))
		{
			// Trigger Event: jcb_ce_onAfterBuildAdminSysLang
			$this->event->trigger(
				'jcb_ce_onAfterBuildAdminSysLang'
			);
			// get admin system langauge content
			$langContent = $this->language->getTarget('adminsys');
			// sort strings
			ksort($langContent);
			// load to global languages
			$langTag = $this->config->get('lang_tag', 'en-GB');
			$this->languages->set(
				"components.{$langTag}.adminsys",
				$langContent
			);
			// remove tmp array
			$this->language->setTarget('adminsys', null);

			return true;
		}

		return false;
	}
}

