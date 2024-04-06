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
use VDM\Joomla\Componentbuilder\Crypt\Aes;
use VDM\Joomla\Componentbuilder\Crypt\Aes\Legacy;
use VDM\Joomla\Componentbuilder\Crypt\Password;
use VDM\Joomla\Componentbuilder\Interfaces\Cryptinterface;
use VDM\Joomla\Utilities\StringHelper;


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
	 * The Crypt AES CBC class
	 *
	 * @var    Aes
	 * @since 3.2.0
	 */
	protected Aes $aes;

	/**
	 * The Crypt AES Legacy class
	 *
	 * @var    Legacy
	 * @since 3.2.0
	 */
	protected Legacy $legacy;

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
	protected array $options = [
		'basic' => 'fof',
		'medium' => 'fof',
		'local' => 'aes'
	];

	/**
	 * Active passwords
	 *
	 * @var    array
	 * @since 3.2.0
	 */
	protected array $passwords = [];

	/**
	 * Constructor
	 *
	 * @param FOF        $fof        The FOF class
	 * @param Aes        $aes        The AES CBC class
	 * @param Legacy     $legacy     The AES Legacy class
	 * @param Password   $password   The Password class
	 *
	 * @since 3.2.0
	 */
	public function __construct(FOF $fof, Aes $aes, Legacy $legacy, Password $password)
	{
		$this->fof = $fof;
		$this->aes = $aes;
		$this->legacy = $legacy;
		$this->password = $password;
	}

	/**
	 * Encrypt a string as needed
	 *
	 * @param   string       $string    The string to encrypt
	 * @param   string       $method    The encryption method to use
	 * @param   string|null  $password  The password
	 *
	 * @return  string
	 * @since 3.2.0
	 **/
	public function encrypt(string $string, string $method,
		?string $password = null): string
	{
		if (($password = $this->getPassword($method, $password)) !== null
			&& ($name = $this->getClassName($method)) !== null)
		{
			return $this->{$name}->encrypt($string, $password);
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
	 * @return  string|null
	 * @since 3.2.0
	 **/
	public function decrypt(string $string, string $method,
		?string $default = null): ?string
	{
		if (($password = $this->getPassword($method, $default)) !== null
			&& ($name = $this->getClassName($method)) !== null)
		{
			return $this->{$name}->decrypt($string, $password);
		}

		return null;
	}

	/**
	 * Check if a decryption method exist and is supported
	 *
	 * @param   string    $method    The encryption method to find
	 *
	 * @return  bool      true if it exist
	 * @since 3.2.0
	 **/
	public function exist(string $method): bool
	{
		return is_string($this->getClassName($method)) ?? false;
	}

	/**
	 * Get crypto class name to use
	 *
	 * @param   string    $method    The encryption method to find
	 *
	 * @return  string|null     The crypto class name
	 * @since 3.2.0
	 **/
	private function getClassName(string $method): ?string
	{
		if (($name = $this->getClassNameFromRegistry($method)) !== null)
		{
			return $name;
		}

		return $this->getClassNameFromOptions($method);
	}

	/**
	 * Get the crypto class name from the registry
	 *
	 * @param string   $method   The encryption method to use
	 *
	 * @return string|null The crypto class name, or null if not found
	 * @since 3.2.0
	 **/
	private function getClassNameFromRegistry(string $method): ?string
	{
		$name = $this->name($method);

		if (isset($this->{$name}) && $this->{$name} instanceof Cryptinterface)
		{
			return $name;
		}

		return null;
	}

	/**
	 * Get the crypto class name for the given encryption method and options
	 *
	 * @param string   $method   The encryption method to use
	 *
	 * @return string|null The crypto class name, or null if not found
	 * @since 3.2.0
	 **/
	private function getClassNameFromOptions(string $method): ?string
	{
		$key = $this->getPasswordKey($method);

		if (isset($this->options[$key]))
		{
			$name = $this->options[$key];

			if (isset($this->{$name}) && $this->{$name} instanceof Cryptinterface)
			{
				return $name;
			}
		}

		return null;
	}

	/**
	 * Get the password
	 *
	 * @param   string         $method     The encryption method to find
	 * @param   string|null    $password   The password
	 *
	 * @return  string|null     the password or null
	 * @since 3.2.0
	 **/
	private function getPassword(string $method, ?string $password = null): ?string
	{
		if (StringHelper::check($password))
		{
			return $password;
		}

		// get password key name
		$key = $this->getPasswordKey($method);

		if (empty($this->passwords[$key]))
		{
			$this->passwords[$key] = $this->password->get($key);
		}

		return $this->passwords[$key];
	}

	/**
	 * Get the key
	 *
	 * @param   string         $method    The encryption method to find
	 *
	 * @return  string        the password key name
	 * @since 3.2.0
	 **/
	private function getPasswordKey(string $method): string
	{
		if (($pos = strpos($method, '.')) !== false)
		{
			return substr($method, 0, $pos);
		}

		return $method;
	}

	/**
	 * Get the class name
	 *
	 * @param   string         $method    The encryption method to find
	 *
	 * @return  string     the class name
	 * @since 3.2.0
	 **/
	private function name(string $method): string
	{
		if (($pos = strpos($method, '.')) !== false)
		{
			return substr($method, $pos + 1);
		}

		return $method;
	}
}

