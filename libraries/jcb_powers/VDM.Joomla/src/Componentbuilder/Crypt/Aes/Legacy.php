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

namespace VDM\Joomla\Componentbuilder\Crypt\Aes;


use phpseclib3\Crypt\AES as BASEAES;
use VDM\Joomla\Componentbuilder\Interfaces\Cryptinterface;


/**
 * Legacy Class for Aes Encryption
 * 
 * @since 3.2.0
 */
class Legacy implements Cryptinterface
{
	/**
	 * The Aes class
	 *
	 * @var    BASEAES
	 * @since 3.2.0
	 */
	protected BASEAES $aes;

	/**
	 * The block size
	 *
	 * @var    int
	 * @since 3.2.0
	 */
	protected int $size = 128;

	/**
	 * Constructor
	 *
	 * @param BASEAES    $aes        The Aes class
	 *
	 * @since 3.2.0
	 */
	public function __construct(BASEAES $aes)
	{
		$this->aes = $aes;

		// we set the length once
		$this->aes->setKeyLength($this->size);

		// enable padding
		$this->aes->enablePadding();
	}

	/**
	 * Encrypt a string as needed
	 *
	 * @param   string     $string      The string to encrypt
	 * @param   string     $key         The encryption key
	 *
	 * @return  string
	 * @since 3.2.0
	 **/
	public function encrypt(string $string, string $key): string
	{
		// we get the IV length
		$iv_length = (int) $this->aes->getBlockLength() >> 3;

		// get the IV value
		$iv = str_repeat("\0", $iv_length);

		// Load the IV
		$this->aes->setIV($iv);

		// set the password
		$this->aes->setPassword($key, 'pbkdf2', 'sha256', 'VastDevelopmentMethod/salt');

		// encrypt the string, and base 64 encode the result
		return base64_encode($this->aes->encrypt($string));
	}

	/**
	 * Decrypt a string as needed
	 *
	 * @param   string     $string      The string to decrypt
	 * @param   string     $key         The decryption key
	 *
	 * @return  string|null
	 * @since 3.2.0
	 **/
	public function decrypt(string $string, string $key): ?string
	{
		// remove base 64 encoding
		$string = base64_decode($string);

		// we get the IV length
		$iv_length = (int) $this->aes->getBlockLength() >> 3;

		// get the IV value
		$iv = str_repeat("\0", $iv_length);

		// Load the IV
		$this->aes->setIV($iv);

		// set the password
		$this->aes->setPassword($key, 'pbkdf2', 'sha256', 'VastDevelopmentMethod/salt');

		try {
			return $this->aes->decrypt($string);
		} catch (\Exception $ex) {
			return null;
		}
	}
}

