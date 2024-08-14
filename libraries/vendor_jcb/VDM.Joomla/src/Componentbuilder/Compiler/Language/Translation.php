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

namespace VDM\Joomla\Componentbuilder\Compiler\Language;


use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Builder\LanguageMessages as Messages;


/**
 * Compiler Language Translation Checker
 * 
 * @since 5.0.2
 */
final class Translation
{
	/**
	 * The Config Class.
	 *
	 * @var   Config
	 * @since 5.0.2
	 */
	protected Config $config;

	/**
	 * The Language Messages Class.
	 *
	 * @var   Messages
	 * @since 5.0.2
	 */
	protected Messages $messages;

	/**
	 * Constructor.
	 *
	 * @param Config     $config     The Config Class.
	 * @param Messages    $messages  The Language Messages Class.
	 *
	 * @since 5.0.2
	 */
	public function __construct(Config $config, Messages $messages)
	{
		$this->config = $config;
		$this->messages = $messages;
	}

	/**
	 * Check if a translation should be added.
	 *
	 * This method determines if a translation should be included based on the percentage
	 * of translated strings and logs the decision.
	 *
	 * @param string $tag             The language tag.
	 * @param array  $languageStrings The active language strings.
	 * @param int    $total           The total number of strings.
	 * @param string $file_name       The file name.
	 *
	 * @return bool Returns true if the translation should be added; false otherwise.
	 * @since 5.0.2
	 */
	public function check(string &$tag, array &$languageStrings, int &$total, string &$file_name): bool
	{
		$langTag = $this->config->get('lang_tag', 'en-GB');
		if ($langTag !== $tag)
		{
			$langStringNr = count($languageStrings);
			$percentage = ($langStringNr / $total) * 100;
			$stringName = ($langStringNr == 1) ? "(string $tag translated)" : "(strings $tag translated)";

			if (!$this->config->get('debug_line_nr', false))
			{
				if ($percentage < $this->config->percentage_language_add)
				{
					$this->messages->set(
						"exclude.$file_name",
						"<b>$total</b>(total " . $langTag . " strings) only <b>$langStringNr</b> $stringName = $percentage"
					);

					return false;
				}
			}

			$this->messages->set(
				"include.$file_name",
				"<b>$total</b>(total " . $langTag . " strings) and <b>$langStringNr</b> $stringName = $percentage"
			);
		}

		return true;
	}
}

