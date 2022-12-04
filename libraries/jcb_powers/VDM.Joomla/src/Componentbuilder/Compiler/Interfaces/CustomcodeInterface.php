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
 * Compiler Customcode Interface
 * 
 * @since 3.2.0
 */
interface CustomcodeInterface
{
	/**
	 * Update **ALL** dynamic values in a strings here
	 *
	 * @param   string  $string  The content to check
	 * @param   int     $debug   The switch to debug the update
	 *                           We can now at any time debug the
	 *                           dynamic build values if it gets broken
	 *
	 * @return  string
	 * @since 3.2.0
	 */
	public function update(string $string, int $debug = 0): string;

	/**
	 * Set the custom code data & can load it in to string
	 *
	 * @param   string     $string  The content to check
	 * @param   int          $debug   The switch to debug the update
	 * @param   int|null   $not       The not switch
	 *
	 * @return  string
	 * @since 3.2.0
	 */
	public function set(string $string, int $debug = 0, ?int $not = null): string;

	/**
	 * Load the custom code from the system
	 *
	 * @param   array|null     $ids           The custom code ides if known
	 * @param   bool           $setLang       The set lang switch
	 * @param   int            $debug         The switch to debug the update
	 *
	 * @return  bool
	 * @since 3.2.0
	 */
	public function get(?array $ids = null, bool $setLang = true, $debug = 0): bool;
}

