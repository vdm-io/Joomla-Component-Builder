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

namespace VDM\Joomla\Componentbuilder\Compiler\Placeholder;


use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Utilities\GetHelper;
use VDM\Joomla\Componentbuilder\Compiler\Factory as Compiler;
use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Placeholder;
use VDM\Joomla\Componentbuilder\Compiler\Language;
use VDM\Joomla\Componentbuilder\Compiler\Language\Extractor;
use VDM\Joomla\Componentbuilder\Compiler\Power\Extractor as Power;
use VDM\Joomla\Componentbuilder\Compiler\JoomlaPower\Extractor as JoomlaPower;


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
	 * Super Power Extractor
	 *
	 * @var    Power
	 * @since 3.2.0
	 **/
	protected Power $power;

	/**
	 * Joomla Power Extractor
	 *
	 * @var    Power
	 * @since 3.2.1
	 **/
	protected JoomlaPower $joomla;

	/**
	 * Constructor.
	 *
	 * @param Config       $config       The compiler config object.
	 * @param Placeholder  $placeholder  The compiler placeholder object.
	 * @param Language     $language     The compiler language object.
	 * @param Extractor    $extractor    The compiler language extractor object.
	 * @param Power        $power        The compiler power extractor object.
	 *
	 * @since 3.2.0
	 */
	public function __construct(
		Config $config, Placeholder $placeholder,
		Language $language, Extractor $extractor,
		Power $power, JoomlaPower $joomla)
	{
		$this->config = $config;
		$this->placeholder = $placeholder;
		$this->language = $language;
		$this->extractor = $extractor;
		$this->power = $power;
		$this->joomla = $joomla;
	}

	/**
	 * Reverse Engineer the dynamic placeholders (TODO hmmmm this is not ideal)
	 *
	 * @param   string       $string         The string to reverse
	 * @param   array        $placeholders   The values to search for
	 * @param   string       $target         The target path type
	 * @param   int|null     $id             The custom code id
	 * @param   string       $field          The field name
	 * @param   string       $table          The table name
	 * @param   array|null   $useStatements  The file use statements (needed for super powers)
	 *
	 * @return  string
	 * @since 3.2.0
	 */
	public function engine(string $string, array &$placeholders,
		string $target, ?int $id = null, string $field = 'code',
		string $table = 'custom_code', ?array $useStatements = null): string
	{
		// get local code if set
		if ($id > 0 && $code = base64_decode(
				(string) GetHelper::var($table, $id, 'id', $field)
			))
		{
			$string = $this->setReverse(
				$string, $code, $target, $useStatements
			);
		}

		return $this->placeholder->update($string, $placeholders, 2);
	}

	/**
	 * Reverse engineer the dynamic language, and super powers
	 *
	 * @param   string      $updateString   The string to update
	 * @param   string      $string         The string to use language update
	 * @param   string      $target         The target path type
	 * @param   array|null  $useStatements  The file use statements (needed for super powers)
	 *
	 * @return  string
	 * @since 3.2.0
	 */
	protected function setReverse(string $updateString, string $string,
		string $target, ?array $useStatements): string
	{
		// we have to reverse engineer of powers
		$updateString = $this->reverseSuperPowers($updateString, $string, $useStatements);
		$updateString = $this->reverseJoomlaPowers($updateString, $string, $useStatements);

		// reverse engineer the language strings
		$updateString = $this->reverseLanguage($updateString, $string, $target);

		// reverse engineer the custom code (if possible)
		// $updateString = $this->reverseCustomCode($updateString, $string); // TODO - we would like to also reverse basic customcode

		return $updateString;
	}

	/**
	 * Set the super powers keys for the reveres process
	 *
	 * @param   string      $updateString   The string to update
	 * @param   string      $string         The string to use for super power update
	 * @param   array|null  $useStatements  The file use statements (needed for super powers)
	 *
	 * @return  string
	 * @since 3.2.0
	 */
	protected function reverseSuperPowers(string $updateString, string $string,
		?array $useStatements): string
	{
		// only if we have use statements can we reverse engineer this
		if ($useStatements !== null && ($powers = $this->power->reverse($string)) !== null &&
			($reverse = $this->getReversePower($powers, $useStatements, 'Super')) !== null)
		{
			return $this->placeholder->update($updateString, $reverse);
		}

		return $updateString;
	}

	/**
	 * Set the joomla powers keys for the reveres process
	 *
	 * @param   string      $updateString   The string to update
	 * @param   string      $string         The string to use for super power update
	 * @param   array|null  $useStatements  The file use statements (needed for super powers)
	 *
	 * @return  string
	 * @since 3.2.0
	 */
	protected function reverseJoomlaPowers(string $updateString, string $string,
		?array $useStatements): string
	{
		// only if we have use statements can we reverse engineer this
		if ($useStatements !== null && ($powers = $this->joomla->reverse($string)) !== null &&
			($reverse = $this->getReversePower($powers, $useStatements, 'Joomla')) !== null)
		{
			return $this->placeholder->update($updateString, $reverse);
		}

		return $updateString;
	}

	/**
	 * Set the super powers keys for the reveres process
	 *
	 * @param   array   $powers         The powers found in the database text
	 * @param   array   $useStatements  The file use statements
	 * @param   string  $target         The power target type
	 *
	 * @return  array|null
	 * @since 3.2.0
	 */
	protected function getReversePower(array $powers, array $useStatements, string $target): ?array
	{
		$matching_statements = [];
		foreach ($useStatements as $use_statement)
		{
			$namespace = substr($use_statement, 4, -1); // remove 'use ' and ';'
			$class_name = '';

			// Check for 'as' alias
			if (strpos($namespace, ' as ') !== false)
			{
				list($namespace, $class_name) = explode(' as ', $namespace);
			}

			// If there is no 'as' alias, get the class name from the last '\'
			if (empty($class_name))
			{
				$last_slash = strrpos($namespace, '\\');
				if ($last_slash !== false)
				{
					$class_name = substr($namespace, $last_slash + 1);
				}
			}

			// Check if the namespace is in the powers array
			if (in_array($namespace, $powers))
			{
				$guid = array_search($namespace, $powers);
				$matching_statements[$class_name] =
					$target . '_'.'_'.'_' . str_replace('-', '_', $guid) . '_'.'_'.'_Power';
			}
		}

		if ($matching_statements !== [])
		{
			return $matching_statements;
		}

		return null;
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
	protected function reverseLanguage(string $updateString, string $string, string $target): string
	{
		// get targets to search for
		$lang_string_targets = array_filter(
			$this->config->lang_string_targets,
			fn($get): bool => strpos($string, (string) $get) !== false
		);
		// check if we should continue
		if (ArrayHelper::check($lang_string_targets))
		{
			// start lang holder
			$lang_holders = [];
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
					$string, $lang_string_target . '"', '"'
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
				$updateString = $this->placeholder->update(
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

	/**
	 * Set the custom code placeholder for the reveres process
	 *
	 * @param   string      $updateString   The string to update
	 * @param   string      $string         The string to use for super power update
	 *
	 * @return  string
	 * @since 3.2.0
	 */
	protected function reverseCustomCode(string $updateString, string $string): string
	{
		// check if content has custom code place holder
		if (strpos($string, '[CUSTO' . 'MCODE=') !== false)
		{
			$found  = GetHelper::allBetween(
				$string, '[CUSTO' . 'MCODE=', ']'
			);
			$bucket = [];
			if (ArrayHelper::check($found))
			{
				foreach ($found as $key)
				{
					// we only update those without args
					if (is_numeric($key) && $get_func_name = GetHelper::var(
						'custom_code', $key, 'id', 'function_name'
					))
					{
						$bucket[$get_func_name] = (int) $key;
					}
					elseif (StringHelper::check($key)
						&& strpos((string) $key, '+') === false)
					{
						$get_func_name = trim((string) $key);
						if (isset($bucket[$get_func_name]) || !$found_local = GetHelper::var(
							'custom_code', $get_func_name, 'function_name',
							'id'
						))
						{
							continue;
						}
						$bucket[$get_func_name] = (int) $found_local;
					}
				}
				// TODO - we need to now get the customcode
				// search and replace the customcode with the placeholder
			}
		}

		return $updateString;
	}
}

