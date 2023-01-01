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


use phpseclib3\Crypt\AES;
use VDM\Joomla\Componentbuilder\Crypt\Random;
use VDM\Joomla\Componentbuilder\Interfaces\Cryptinterface;


/**
 * Replacement Class for FOFEncryptAes
 * 
 * @since 3.2.0
 */
class FOF implements Cryptinterface
{
	/**
	 * The Aes class
	 *
	 * @var    AES
	 * @since 3.2.0
	 */
	protected AES $aes;

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
	protected int $size = 128;

	/**
	 * Constructor
	 *
	 * @param AES      $aes       The Aes class
	 * @param Random   $random    The Random class
	 *
	 * @since 3.2.0
	 */
	public function __construct(AES $aes, Random $random)
	{
		$this->aes = $aes;
		$this->random = $random;

		// we set the length once
		$this->aes->setKeyLength($this->size);
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

		// load the key
		$this->aes->setKey($this->getExpandedKey($key, $iv_length, $iv));

		// encrypt the string, and base 64 encode the result
		return base64_encode($iv . $this->aes->encrypt($string));
	}

	/**
	 * Decrypt a string as needed
	 *
	 * @param   string     $string      The string to decrypt
	 * @param   string     $key         The decryption key
	 *
	 * @return  string
	 * @since 3.2.0
	 **/
	public function decrypt(string $string, string $key): string
	{
		// we get the IV length
		$iv_length = (int) $this->aes->getBlockLength() >> 3;

		// remove base 64 encoding
		$string = base64_decode($string);

		// get the IV
		$iv = substr($string, 0, $iv_length);
		// remove the IV
		$string = substr($string, $iv_length);

		// set the key
		$this->aes->setKey($this->getExpandedKey($key, $iv_length, $iv));

		// set the IV
		$this->aes->setIV($iv);

		return $this->aes->decrypt($string);
	}

	/**
	 * Function taken from FOFEncryptAes
	 *   changed a little but basically the same
	 *   to ensure we get the same passwords (not ideal)
	 *   we should use `$this->aes->setPassword(...)` instead
	 *   but can't for backwards compatibility issues with already encrypted string
	 *
	 * @param string  $key       The key to expand
	 * @param int     $blockSize The size of the block
	 * @param string  $iv        The IV used
	 *
	 * @return string
	 * @since 3.2.0
	 */
	protected function getExpandedKey(string $key, int $blockSize, string $iv): string
	{
		$pass_length = strlen($key);

		if (function_exists('mb_strlen'))
		{
			$pass_length = mb_strlen($key, 'ASCII');
		}

		if ($pass_length != $blockSize)
		{
			$iterations = 1000;
			$salt       = $this->resizeKey($iv, 16);
			$key        = hash_pbkdf2('sha256', $key, $salt, $iterations, $blockSize, true);
		}

		return $key;
	}

	/**
	 * Function taken from FOFEncryptAes
	 *   changed a little but basically the same
	 *   to ensure we get the same passwords (not ideal)
	 *   we should use `$this->aes->setPassword(...)` instead
	 *   but can't for backwards compatibility issues with already encrypted string
	 *
	 * @param string  $key     The key to resize
	 * @param int     $size    The size of the block
	 *
	 * @return string|null
	 * @since 3.2.0
	 */
	protected function resizeKey(string $key, int $size): ?string
	{
		if (empty($key))
		{
			return null;
		}

		$key_length = strlen($key);

		if (function_exists('mb_strlen'))
		{
			$key_length = mb_strlen($key, 'ASCII');
		}

		if ($key_length == $size)
		{
			return $key;
		}

		if ($key_length > $size)
		{
			if (function_exists('mb_substr'))
			{
				return mb_substr($key, 0, $size, 'ASCII');
			}

			return substr($key, 0, $size);
		}

		return $key . str_repeat("\0", ($size - $key_length));
	}

}

