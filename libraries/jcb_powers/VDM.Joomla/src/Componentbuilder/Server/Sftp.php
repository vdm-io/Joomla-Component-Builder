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

namespace VDM\Joomla\Componentbuilder\Server;


use phpseclib3\Net\SFTP as SftpClient;
use VDM\Joomla\Componentbuilder\Crypt\KeyLoader;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Utilities\FileHelper;
use VDM\Joomla\Componentbuilder\Interfaces\Serverinterface;


/**
 * Sftp Class
 * 
 * @since 3.2.0
 */
class Sftp implements Serverinterface
{
	/**
	 * The KeyLoader
	 *
	 * @var    KeyLoader
	 * @since 3.2.0
	 */
	protected KeyLoader $key;

	/**
	* The client object
	 *
	 * @var     SftpClient
	 * @since 3.2.0
	 **/
	protected SftpClient $client;

	/**
	* The server details
	 *
	 * @var     object
	 * @since 3.2.0
	 **/
	protected object $details;

	/**
	 * Constructor
	 *
	 * @param KeyLoader    $key   The key loader object.
	 *
	 * @since 3.2.0
	 */
	public function __construct(KeyLoader $key)
	{
		$this->key = $key;
	}

	/**
	 * set the server details
	 *
	 * @param   object    $details    The server details
	 *
	 * @return  Sftp
	 * @since 3.2.0
	 **/
	public function set(object $details): Sftp
	{
		// set the details
		$this->details = $details;

		return $this;
	}

	/**
	 * move a file to server with the FTP client
	 *
	 * @param   string      $localPath      The full local path to the file
	 * @param   string      $fileName      The file name
	 *
	 * @return  bool
	 * @since 3.2.0
	 **/
	public function move(string $localPath, string $fileName): bool
	{
		if ($this->connected() &&
			($data = FileHelper::getContent($localPath, null)) !== null)
		{
			// get the remote path
			$path = '';
			if (isset($this->details->path) &&
				StringHelper::check($this->details->path) &&
				$this->details->path !== '/')
			{
				$path = '/' . trim((string) $this->details->path, '/');
			}

			return $this->client->put($path . '/' . $fileName, $data);
		}

		return false;
	}

	/**
	 * get the SftpClient object
	 *
	 * @return  SftpClient|null
	 * @since 3.2.0
	 **/
	protected function getClient(): ?SftpClient
	{
		// make sure we have a host value set
		if (isset($this->details->host) && StringHelper::check($this->details->host) &&
			isset($this->details->username) && StringHelper::check($this->details->username))
		{
			// insure the port is set
			$port = (isset($this->details->port) && is_numeric($this->details->port) && $this->details->port > 0)
					? (int) $this->details->port : 22;

			// open the connection
			$sftp = new SftpClient($this->details->host, $port);

			// set the passphrase if it exist
			$passphrase = $this->details->secret ?? null;

			// set the password if it exist
			$password = $this->details->password ?? null;

			// now login based on authentication type
			$key = null;
			switch($this->details->authentication)
			{
				case 1: // password
					$key = $this->details->password ?? null;
					$password = null;
				break;
				case 2: // private key file
				case 3: // both password and private key file
					if (isset($this->details->private) && StringHelper::check($this->details->private) &&
						($private_key = FileHelper::getContent($this->details->private, null)) !== null)
					{
						$key = $this->key::load($private_key, $passphrase);
					}
				break;
				case 4: // private key field
				case 5: // both password and private key field
					if (isset($this->details->private_key) && StringHelper::check($this->details->private_key))
					{
						$key = $this->key::load($this->details->private_key, $passphrase);
					}
				break;
			}

			// login
			if ((!empty($key) && !empty($password) && $sftp->login($this->details->username, $key, $password)) ||
				(!empty($key) && $sftp->login($this->details->username, $key)))
			{
				return $sftp;
			}
		}

		return null;
	}

	/**
	 * Make sure we are connected
	 *
	 * @return  bool
	 * @since 3.2.0
	 **/
	protected function connected(): bool
	{
		// check if we have a connection
		return ($this->client instanceof SftpClient && ($this->client->isConnected() || $this->client->ping())) ||
			($this->client = $this->getClient()) !== null;
	}

}

