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

namespace VDM\Joomla\Componentbuilder\Compiler\Interfaces\Power;


/**
 * Compiler Power Extractor
 * @since 3.2.1
 */
interface ExtractorInterface
{
	/**
	 * Get Super Powers from the code string
	 *
	 * @param string    $code The code
	 *
	 * @return array|null
	 * @since 3.2.0
	 */
	public function get_(): ?array;

	/**
	 * Get Super Powers from the code string
	 *
	 * @param string    $code The code
	 *
	 * @return array|null
	 * @since 3.2.0
	 */
	public function get(string $code): ?array;

	/**
	 * Get Super Powers from the code string
	 *
	 * @param string    $code The code
	 *
	 * @return array|null
	 * @since 3.2.0
	 */
	public function reverse(string $code): ?array;

	/**
	 * Get Super Powers from the code string and load it
	 *
	 * @param string    $code The code
	 *
	 * @return void
	 * @since 3.2.0
	 */
	public function search(string $code): void;
}

