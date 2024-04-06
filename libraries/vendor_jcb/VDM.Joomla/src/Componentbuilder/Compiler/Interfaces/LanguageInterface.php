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

namespace VDM\Joomla\Componentbuilder\Compiler\Interfaces;


/**
 * Compiler Language Interface
 * 
 * @since 3.2.0
 */
interface LanguageInterface
{
	/**
	 * Get the language string key
	 *
	 * @param   string  $string  The plan text string (English)
	 *
	 * @return  string   The key language string (all uppercase)
	 * @since 3.2.0
	 */
	public function key($string): string;

	/**
	 * check if the language string exist
	 *
	 * @param   string   $target     The target area for the language string
	 * @param   string|null   $language   The language key string
	 *
	 * @return  bool
	 * @since 3.2.0
	 */
	public function exist(string $target, ?string $language = null): bool;

	/**
	 * get the language string
	 *
	 * @param   string   $target     The target area for the language string
	 * @param   string|null   $language   The language key string
	 *
	 * @return  Mixed The language string found or empty string if none is found
	 * @since 3.2.0
	 */
	public function get(string $target, string $language): string;

	/**
	 * get target array
	 *
	 * @param   string   $target     The target area for the language string
	 *
	 * @return  array The target array or empty array if none is found
	 * @since 3.2.0
	 */
	public function getTarget(string $target): array;

	/**
	 * set target array
	 *
	 * @param string      $target     The target area for the language string
	 * @param array|null  $content    The language content string
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function setTarget(string $target, ?array $content);

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
	public function set(string $target, string $language, string $string, bool $addPrefix = false);

}

