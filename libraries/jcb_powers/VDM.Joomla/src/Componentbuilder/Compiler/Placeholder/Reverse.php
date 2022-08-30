<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler\Placeholder;


use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Utilities\GetHelper;
use VDM\Joomla\Componentbuilder\Compiler\Factory as Compiler;
use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Placeholder;
use VDM\Joomla\Componentbuilder\Compiler\Language;
use VDM\Joomla\Componentbuilder\Compiler\Language\Extractor;


/**
 * Compiler Placeholder Reverse
 * 
 * @since 3.2.0
 */
class Reverse
{
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
	 * Compiler Language Extractor
	 *
	 * @var    Extractor
	 * @since 3.2.0
	 **/
	protected Extractor $extractor;

	/**
	 * Constructor.
	 *
	 * @param Config|null          $config          The compiler config object.
	 * @param Placeholder|null     $placeholder     The compiler placeholder object.
	 * @param Language|null        $language        The compiler language object.
	 * @param Extract|null         $extractor       The compiler language extractor object.
	 *
	 * @since 3.2.0
	 */
	public function __construct(
		?Config $config = null, ?Placeholder $placeholder = null,
		?Language $language = null, ?Extractor $extractor = null)
	{
		$this->config = $config ?: Compiler::_('Config');
		$this->placeholder = $placeholder ?: Compiler::_('Placeholder');
		$this->language = $language ?: Compiler::_('Language');
		$this->extractor = $extractor ?: Compiler::_('Language.Extractor');
	}

	/**
	 * Reverse Engineer the dynamic placeholders (TODO hmmmm this is not ideal)
	 *
	 * @param   string  $string        The string to revers
	 * @param   array   $placeholders  The values to search for
	 * @param   string  $target        The target path type
	 * @param   int|null     $id            The custom code id
	 * @param   string  $field         The field name
	 * @param   string  $table         The table name
	 *
	 * @return  string
	 * @since 3.2.0
	 */
	public function engine(string $string, array &$placeholders,
		string $target, ?int $id = null, $field = 'code', $table = 'custom_code'): string
	{
		// get local code if set
		if ($id > 0 && $code = base64_decode(
				GetHelper::var($table, $id, 'id', $field)
			))
		{
			$string = $this->setReverse(
				$string, $code, $target
			);
		}

		return $this->placeholder->update($string, $placeholders, 2);
	}

	/**
	 * Set the language strings for the reveres process
	 *
	 * @param   string  $updateString  The string to update
	 * @param   string  $string        The string to use language update
	 * @param   string  $target        The target path type
	 *
	 * @return  string
	 * @since 3.2.0
	 */
	protected function setReverse(string $updateString, string $string, string $target): string
	{
		// get targets to search for
		$lang_string_targets = array_filter(
			$this->config->lang_string_targets, function ($get) use ($string) {
				if (strpos($string, $get) !== false)
				{
					return true;
				}

				return false;
			}
		);
		// check if we should continue
		if (ArrayHelper::check($lang_string_targets))
		{
			// start lang holder
			$lang_holders = array();
			// set the lang for both since we don't know what area is being targeted
			$_tmp = $this->config->lang_target;
			// set the lang based on target
			if (strpos($target, 'module') !== false)
			{
				// backup lang prefix
				$_tmp_lang_prefix = $this->config->lang_prefix;
				// set the new lang prefix
				$lang_prefix = strtoupper(
					str_replace('module', 'mod', $target)
				);
				$this->config->set('lang_prefix', $lang_prefix);
				// now set the lang
				if (isset($this->extractor->langKeys[$this->config->lang_prefix]))
				{
					$this->config->lang_target = $this->extractor->langKeys[$this->config->lang_prefix];
				}
				else
				{
					$this->config->lang_target = 'module';
				}
			}
			elseif (strpos($target, 'plugin') !== false)
			{
				// backup lang prefix
				$_tmp_lang_prefix = $this->config->lang_prefix;
				// set the new lang prefix
				$lang_prefix = strtoupper(
					str_replace('plugin', 'plg', $target)
				);
				$this->config->set('lang_prefix', $lang_prefix);
				// now set the lang
				if (isset($this->extractor->langKeys[$this->config->lang_prefix]))
				{
					$this->config->lang_target = $this->extractor->langKeys[$this->config->lang_prefix];
				}
				else
				{
					$this->config->lang_target = 'plugin';
				}
			}
			else
			{
				$this->config->lang_target = 'both';
			}
			// set language data
			foreach ($lang_string_targets as $lang_string_target)
			{
				$lang_check[] = GetHelper::allBetween(
					$string, $lang_string_target . "'", "'"
				);
				$lang_check[] = GetHelper::allBetween(
					$string, $lang_string_target . "'", "'"
				);
			}
			// merge arrays
			$lang_array = ArrayHelper::merge($lang_check);
			// continue only if strings were found
			if (ArrayHelper::check(
				$lang_array
			)) //<-- not really needed hmmm
			{
				foreach ($lang_array as $lang)
				{
					$_key_lang = StringHelper::safe($lang, 'U');
					// this is there to insure we dont break already added Language strings
					if ($_key_lang === $lang)
					{
						continue;
					}
					// build lang key
					$key_lang = $this->config->lang_prefix . '_' . $_key_lang;
					// set lang content string
					$this->language->set($this->config->lang_target, $key_lang, $lang);
					// reverse the placeholders
					foreach ($lang_string_targets as $lang_string_target)
					{
						$lang_holders[$lang_string_target . "'" . $key_lang . "'"]
							= $lang_string_target . "'" . $lang . "'";
						$lang_holders[$lang_string_target . '"' . $key_lang . '"']
							= $lang_string_target . '"' . $lang . '"';
					}
				}
				// return the found placeholders
				$updateString = $this->placeholder->replace(
					$updateString, $lang_holders
				);
			}
			// reset the lang
			$this->config->lang_target = $_tmp;
			// also rest the lang prefix if set
			if (isset($_tmp_lang_prefix))
			{
				$lang_prefix = $_tmp_lang_prefix;
				$this->config->set('lang_prefix', $_tmp_lang_prefix);
			}
		}

		return $updateString;
	}

}

