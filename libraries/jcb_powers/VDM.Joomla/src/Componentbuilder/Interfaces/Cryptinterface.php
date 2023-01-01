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

namespace VDM\Joomla\Componentbuilder\Interfaces;


/**
 * The Crypt Interface
 */
interface Cryptinterface
{
	/**
	 * Encrypt a string as needed
	 *
	 * @param   string     $string      The string to encrypt
	 * @param   string     $key         The encryption key
	 *
	 * @return  string
	 * @since 3.2.0
	 **/
	public function encrypt(string $string, string $key): string;

	/**
	 * Decrypt a string as needed
	 *
	 * @param   string     $string      The string to decrypt
	 * @param   string     $key         The decryption key
	 *
	 * @return  string
	 * @since 3.2.0
	 **/
	public function decrypt(string $string, string $key): string;

}

