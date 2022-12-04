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
 * Compiler Placeholder Interface
 * 
 * @since 3.2.0
 */
interface PlaceholderInterface
{
	/**
	 * Set a type of placeholder with set of values
	 *
	 * @param   string  $key     The main string for placeholder key
	 * @param   array   $values  The values to add
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function setType(string $key, array $values);

	/**
	 * Remove a type of placeholder by main key
	 *
	 * @param   string  $key  The main string for placeholder key
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function clearType(string $key);

	/**
	 * Update the data with the placeholders
	 *
	 * @param   string  $data         The actual data
	 * @param   array   $placeholder  The placeholders
	 * @param   int     $action       The action to use
	 *
	 * THE ACTION OPTIONS ARE
	 * 1 -> Just replace (default)
	 * 2 -> Check if data string has placeholders
	 * 3 -> Remove placeholders not in data string
	 *
	 * @return  string
	 * @since 3.2.0
	 */
	public function update(string $data, array &$placeholder, int $action = 1): string;

	/**
	 * return the placeholders for inserted and replaced code
	 *
	 * @param   int         $type  The type of placement
	 * @param   int|null  $id    The code id in the system
	 *
	 * @return  array    with start and end keys
	 * @since 3.2.0
	 */
	public function keys(int $type, ?int $id = null): array;

}

