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

namespace VDM\Joomla\Componentbuilder;


use VDM\Joomla\Componentbuilder\Crypt\FOF;
use VDM\Joomla\Componentbuilder\Crypt\Password;


/**
 * Crypto Class
 * 
 * @since 3.2.0
 */
class Crypt
{
	/**
	 * The Crypt AES FOF class
	 *   replacement class
	 *
	 * @var    FOF
	 * @since 3.2.0
	 */
	protected FOF $fof;

	/**
	 * The Password class
	 *
	 * @var    Password
	 * @since 3.2.0
	 */
	protected Password $password;

	/**
	 * Active encryption options
	 *
	 * @var    array
	 * @since 3.2.0
	 */
	protected array $options = ['basic' => true, 'medium' => true];

	/**
	 * Active passwords
	 *
	 * @var    array
	 * @since 3.2.0
	 */
	protected array $passwords = ['basic' => null, 'medium' => null];

	/**
	 * Constructor
	 *
	 * @param FOF        $fof        The FOF class
	 * @param Password   $password   The Password class
	 *
	 * @since 3.2.0
	 */
	public function __construct(FOF $fof, Password $password)
	{
		$this->fof = $fof;
		$this->password = $password;
	}

	/**
	 * Encrypt a string as needed
	 *
	 * @param   string       $string    The string to encrypt
	 * @param   string        $method    The encryption method to use
	 * @param   string|null   $default   The default password
	 *
	 * @return  string
	 * @since 3.2.0
	 **/
	public function encrypt(string $string, string $method,
		?string $default = null): string
	{
		if (($password = $this->getPassword($method, $default)) !== null)
		{
			return $this->fof->encrypt($string, $password);
		}

		return $string;
	}

	/**
	 * Decrypt a string as needed
	 *
	 * @param   string        $string    The string to decrypt
	 * @param   string        $method    The encryption method to use
	 * @param   string|null   $default   The default password
	 *
	 * @return  string
	 * @since 3.2.0
	 **/
	public function decrypt(string $string, string $method,
		?string $default = null): string
	{
		if (($password = $this->getPassword($method, $default)) !== null)
		{
			return $this->fof->decrypt($string, $password);
		}

		return $string;
	}

	/**
	* Check if a decryption method exist and is supported
	*
	* @param   string    $method    The encryption method to find
	*
	* @return  bool      true it it exist
	 * @since 3.2.0
	**/
	public function exist(string $method): bool
	{
		return $this->options[$method] ?? false;
	}

	/**
	 * Get the password
	 *
	 * @param   string    $method    The encryption method to find
	 * @param   string|null    $default    The default password
	 *
	 * @return  string|null     the password or null
	 * @since 3.2.0
	 **/
	protected function getPassword(string $method, ?string $default = null): ?string
	{
		if ($this->exist($method))
		{
			if (empty($this->passwords[$method]))
			{
				$this->passwords[$method] = $this->password->get($method, $default);
			}

			return $this->passwords[$method];
		}

		return null;
	}

}

