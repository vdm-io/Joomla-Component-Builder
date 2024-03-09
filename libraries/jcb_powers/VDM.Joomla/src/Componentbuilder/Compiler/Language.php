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

namespace VDM\Joomla\Componentbuilder\Compiler;


use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Componentbuilder\Compiler\Factory as Compiler;
use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\LanguageInterface;


/**
 * Compiler Language Content
 * 
 * @since 3.2.0
 */
class Language implements LanguageInterface
{
	/**
	 * The language content
	 *
	 * @var    array
	 * @since 3.2.0
	 **/
	protected array $content = [];

	/**
	 * Compiler Config
	 *
	 * @var    Config
	 * @since 3.2.0
	 **/
	protected Config $config;

	/**
	 * Constructor.
	 *
	 * @param Config|null          $config           The compiler config object.
	 *
	 * @since 3.2.0
	 */
	public function __construct(?Config $config = null)
	{
		$this->config = $config ?: Compiler::_('Config');
	}

	/**
	 * Get the language string key
	 *
	 * @param   string  $string  The plan text string (English)
	 *
	 * @return  string   The key language string (all uppercase)
	 * @since 3.2.0
	 */
	public function key($string): string
	{
		// this is there to insure we don't break already added Language strings
		if (StringHelper::safe($string, 'U', '_', false, false) === $string)
		{
			return false;
		}

		// build language key
		$key_lang = $this->config->lang_prefix . '_' . StringHelper::safe($string, 'U');

		// set the language string
		$this->set($this->config->lang_target, $key_lang, $string);

		return $key_lang;
	}

	/**
	 * check if the language string exist
	 *
	 * @param   string   $target     The target area for the language string
	 * @param   string|null   $language   The language key string
	 *
	 * @return  bool
	 * @since 3.2.0
	 */
	public function exist(string $target, ?string $language = null): bool
	{
		if ($language)
		{
			return isset($this->content[$target][$language]);
		}

		return isset($this->content[$target]);
	}

	/**
	 * get the language string
	 *
	 * @param   string   $target     The target area for the language string
	 * @param   string|null   $language   The language key string
	 *
	 * @return  Mixed The language string found or empty string if none is found
	 * @since 3.2.0
	 */
	public function get(string $target, string $language): string
	{
		if (isset($this->content[$target][$language]))
		{
			return $this->content[$target][$language];
		}

		return '';
	}

	/**
	 * get target array
	 *
	 * @param   string   $target     The target area for the language string
	 *
	 * @return  array The target array or empty array if none is found
	 * @since 3.2.0
	 */
	public function getTarget(string $target): array
	{
		if (isset($this->content[$target]) && ArrayHelper::check($this->content[$target]))
		{
			return $this->content[$target];
		}

		return [];
	}

	/**
	 * set target array
	 *
	 * @param string      $target     The target area for the language string
	 * @param array|null  $content    The language content string
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function setTarget(string $target, ?array $content)
	{
		$this->content[$target] = $content;
	}

	/**
	 * set the language content values to language content array
	 *
	 * @param   string   $target     The target area for the language string
	 * @param   string   $language   The language key string
	 * @param   string   $string     The language string
	 * @param   bool  $addPrefix  The switch to add langPrefix
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function set(string $target, string $language, string $string, bool $addPrefix = false)
	{
		if ($addPrefix && empty($this->content[$target][$this->config->lang_prefix . '_' . $language]))
		{
			$this->content[$target][$this->config->lang_prefix . '_' . $language]
				= $this->fix($string);
		}
		elseif (empty($this->content[$target][$language]))
		{
			$this->content[$target][$language] = $this->fix($string);
		}
	}

	/**
	 * Removes all types of line breaks from a given string.
	 *
	 * This method is designed to strip out all kinds of new line characters from the input string
	 * to ensure a single-line output. It takes into consideration different operating systems'
	 * line endings, including the combination of Carriage Return and Line Feed.
	 *
	 * @param string $string The input string possibly containing line breaks.
	 *
	 * @return string The modified string with all line breaks removed.
	 * @since 3.2.0
	 */
	public function fix(string $string): string
	{
		if ($this->config->remove_line_breaks)
		{
			// Using a single str_replace call to handle all variations of line breaks.
			// The array includes \r\n (CR+LF used in Windows), \n (LF used in Unix/Linux),
			// and \r (CR used in old Macs) to cover all bases.
			$search = [PHP_EOL, "\r\n", "\n", "\r"];
			$string = str_replace($search, '', $string);
		}

		// Trim the string to remove any leading or trailing whitespace.
		return trim($string);
	}
}

