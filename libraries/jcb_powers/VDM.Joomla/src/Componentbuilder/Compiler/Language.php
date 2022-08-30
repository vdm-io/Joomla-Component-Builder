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

namespace VDM\Joomla\Componentbuilder\Compiler;


use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Componentbuilder\Compiler\Factory as Compiler;
use VDM\Joomla\Componentbuilder\Compiler\Config;


/**
 * Compiler Language Content
 * 
 * @since 3.2.0
 */
class Language
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
		if (StringHelper::safe($string, 'U', '_', false, false)
			=== $string)
		{
			return false;
		}

		// build language key
		$key_lang = $this->config->lang_prefix . '_' . StringHelper::safe(
				$string, 'U'
			);

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
		if ($addPrefix && empty(
				$this->content[$target][$this->config->lang_prefix . '_' . $language]
			))
		{
			$this->content[$target][$this->config->lang_prefix . '_' . $language]
				= $this->fix($string);
		}
		elseif (empty($this->content[$target][$language]))
		{
			$this->content[$target][$language] = $this->fix(
				$string
			);
		}
	}

	/**
	 * We need to remove all text breaks from all language strings
	 *
	 * @param   string  $string  The language string
	 *
	 * @return  string
	 * @since 3.2.0
	 */
	protected function fix(string $string): string
	{
		if ($this->config->remove_line_breaks)
		{
			return trim(str_replace(array(PHP_EOL, "\r", "\n"), '', $string));
		}

		return trim($string);
	}

}

