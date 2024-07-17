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

namespace VDM\Joomla\Interfaces\Git;


/**
 * The Git Api Interface
 * 
 * @since 3.2.0
 */
interface ApiInterface
{
	/**
	 * Load/Reload API.
	 *
	 * @param   string|null     $url          The url.
	 * @param   token|null     $token      The token.
	 * @param   bool             $backup   The backup swapping switch.
	 *
	 * @return  void
	 * @since   3.2.0
	 **/
	public function load_(?string $url = null, ?string $token = null, bool $backup = true): void;

	/**
	 * Reset to previous toke, url it set
	 *
	 * @return  void
	 * @since   3.2.0
	 **/
	public function reset_(): void;

	/**
	 * Get the API url
	 *
	 * @return  string
	 * @since   3.2.0
	 **/
	public function api();
}

