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

namespace VDM\Joomla\Componentbuilder\Crypt;



use phpseclib3\Crypt\AES as BASEAES;
use phpseclib3\Exception\BadDecryptionException;
use VDM\Joomla\Componentbuilder\Crypt\Random;
use VDM\Joomla\Componentbuilder\Interfaces\Cryptinterface;


/**
 * Class for Aes Encryption
 * 
 * @since 3.2.0
 */
class Aes implements Cryptinterface
{
	/**
	 * The Aes class
	 *
	 * @var    BASEAES
	 * @since 3.2.0
	 */
	protected BASEAES $aes;

	/**
	 * The Random class
	 *
	 * @var    Random
	 * @since 3.2.0
	 */
	protected Random $random;

	/**
	 * The block size
	 *
	 * @var    int
	 * @since 3.2.0
	 */
	protected int $size = 256;

	/**
	 * Constructor
	 *
	 * @param BASEAES    $aes        The Aes class
	 * @param Random     $random     The Random class
	 *
	 * @since 3.2.0
	 */
	public function __construct(BASEAES $aes, Random $random)
	{
		$this->aes = $aes;
		$this->random = $random;

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
		$iv = $this->random::string($iv_length);

		// Load the IV
		$this->aes->setIV($iv);

		// set the password
		$this->aes->setPassword($key, 'pbkdf2', 'sha256', 'VastDevelopmentMethod/salt');

		// encrypt the string, and base 64 encode the result
		return base64_encode($iv . $this->aes->encrypt($string));
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
		// we get the IV length
		$iv_length = (int) $this->aes->getBlockLength() >> 3;

		// remove base 64 encoding
		$string = base64_decode($string);

		// get the IV
		$iv = substr($string, 0, $iv_length);

		// remove the IV
		$string = substr($string, $iv_length);

		// set the IV
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

