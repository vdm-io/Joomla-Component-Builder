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


use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Utilities\GetHelper;
use VDM\Joomla\Componentbuilder\Compiler\Factory as Compiler;
use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Placeholder;
use VDM\Joomla\Componentbuilder\Compiler\Language;


/**
 * Compiler Language Extractor
 * 
 * @since 3.2.0
 */
class Extractor
{
	/**
	 * The lang keys for extensions
	 *
	 * @var    array
	 * @since 3.2.0
	 **/
	public array $langKeys = [];

	/**
	 * The Language JS matching check
	 *
	 * @var    array
	 * @since 3.2.0
	 **/
	public array $langMismatch = [];

	/**
	 * The Language SC matching check
	 *
	 * @var    array
	 * @since 3.2.0
	 **/
	public array $langMatch = [];

	/**
	 * Compiler Config
	 *
	 * @var    Config
	 * @since 3.2.0
	 **/
	protected Config $config;

	/**
	 * Compiler Placeholder
	 *
	 * @var    Placeholder
	 * @since 3.2.0
	 **/
	protected Placeholder $placeholder;

	/**
	 * Compiler Language
	 *
	 * @var    Language
	 * @since 3.2.0
	 **/
	protected Language $language;

	/**
	 * Constructor.
	 *
	 * @param Config|null              $config           The compiler config object.
	 * @param Language|null        $language      The compiler Language object.
	 * @param Placeholder|null     $placeholder  The compiler placeholder object.
	 *
	 * @since 3.2.0
	 */
	public function __construct(?Config $config = null, ?Language $language = null, ?Placeholder $placeholder = null)
	{
		$this->config = $config ?: Compiler::_('Config');
		$this->language = $language ?: Compiler::_('Language');
		$this->placeholder = $placeholder ?: Compiler::_('Placeholder');
	}

	/**
	 * Extract Language Strings
	 *
	 * @param   string  $content  The content
	 *
	 * @return  string The content with the updated Language place holder
	 * @since 3.2.0
	 */
	public function engine(string $content): string
	{
		// get targets to search for
		$lang_string_targets = array_filter(
			$this->config->lang_string_targets, fn($get): bool => strpos($content, (string) $get) !== false
		);
		// check if we should continue
		if (ArrayHelper::check($lang_string_targets))
		{
			// insure string is not broken
			$content = $this->placeholder->update_($content);
			// reset some buckets
			$lang_holders = array();
			$lang_check   = array();
			$lang_only    = array();
			$js_text      = array();
			$sc_text      = array();
			// first get the Joomla .JText._()
			if (in_array('Joomla' . '.JText._(', $lang_string_targets))
			{
				$js_text[] = GetHelper::allBetween(
					$content, "Joomla" . ".JText._('", "'"
				);
				$js_text[] = GetHelper::allBetween(
					$content, 'Joomla' . '.JText._("', '"'
				);
				// combine into one array
				$js_text = ArrayHelper::merge($js_text);
				// we need to add a check to insure these JavaScript lang matchup
				if (ArrayHelper::check(
					$js_text
				)) //<-- not really needed hmmm
				{
					// load the JS text to mismatch array
					$lang_check[]        = $js_text;
					$this->langMismatch = ArrayHelper::merge(
						array($js_text, $this->langMismatch)
					);
				}
			}
			// now get the JText: :script()
			if (in_array('JText:' . ':script(', $lang_string_targets))
			{
				$sc_text[] = GetHelper::allBetween(
					$content, "JText:" . ":script('", "'"
				);
				$sc_text[] = GetHelper::allBetween(
					$content, 'JText:' . ':script("', '"'
				);
				// combine into one array
				$sc_text = ArrayHelper::merge($sc_text);
				// we need to add a check to insure these JavaScript lang matchup
				if (ArrayHelper::check($sc_text))
				{
					// load the Script text to match array
					$lang_check[]     = $sc_text;
					$this->langMatch = ArrayHelper::merge(
						array($sc_text, $this->langMatch)
					);
				}
			}
			// now do the little trick for JustTEXT: :_('Just uppercase text');
			if (in_array('JustTEXT:' . ':_(', $lang_string_targets))
			{
				$lang_only[] = GetHelper::allBetween(
					$content, "JustTEXT:" . ":_('", "')"
				);
				$lang_only[] = GetHelper::allBetween(
					$content, 'JustTEXT:' . ':_("', '")'
				);
				// merge lang only
				$lang_only = ArrayHelper::merge($lang_only);
			}
			// set language data
			foreach ($lang_string_targets as $lang_string_target)
			{
				// need some special treatment here
				if ($lang_string_target === 'Joomla' . '.JText._('
					|| $lang_string_target === 'JText:' . ':script('
					|| $lang_string_target === 'JustTEXT:' . ':_(')
				{
					continue;
				}
				$lang_check[] = GetHelper::allBetween(
					$content, $lang_string_target . "'", "'"
				);
				$lang_check[] = GetHelper::allBetween(
					$content, $lang_string_target . '"', '"'
				);
			}
			// the normal loading of the language strings
			$lang_check = ArrayHelper::merge($lang_check);
			if (ArrayHelper::check(
				$lang_check
			)) //<-- not really needed hmmm
			{
				foreach ($lang_check as $string)
				{
					if ($key_lang = $this->language->key($string))
					{
						// load the language targets
						foreach ($lang_string_targets as $lang_string_target)
						{
							// need some special treatment here
							if ($lang_string_target === 'JustTEXT:' . ':_(')
							{
								continue;
							}
							$lang_holders[$lang_string_target . "'" . $string
							. "'"]
								= $lang_string_target . "'" . $key_lang . "'";
							$lang_holders[$lang_string_target . '"' . $string
							. '"']
								= $lang_string_target . '"' . $key_lang . '"';
						}
					}
				}
			}
			// the uppercase loading only (for arrays and other tricks)
			if (ArrayHelper::check($lang_only))
			{
				foreach ($lang_only as $string)
				{
					if ($key_lang = $this->language->key($string))
					{
						// load the language targets
						$lang_holders["JustTEXT:" . ":_('" . $string . "')"]
							= "'" . $key_lang . "'";
						$lang_holders['JustTEXT:' . ':_("' . $string . '")']
							= '"' . $key_lang . '"';
					}
				}
			}
			// only continue if we have value to replace
			if (ArrayHelper::check($lang_holders))
			{
				$content = $this->placeholder->update($content, $lang_holders);
			}
		}

		return $content;
	}

}

