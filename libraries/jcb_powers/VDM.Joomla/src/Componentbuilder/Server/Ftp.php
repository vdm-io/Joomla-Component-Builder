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


use Joomla\CMS\Client\FtpClient;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\ObjectHelper;
use VDM\Joomla\Componentbuilder\Interfaces\Serverinterface;


/**
 * Ftp Class
 * 
 * @since 3.2.0
 */
class Ftp implements Serverinterface
{
	/**
	* The client object
	 *
	 * @var     FtpClient|null
	 * @since 3.2.0
	 **/
	protected ?FtpClient $client = null;

	/**
	* The server details
	 *
	 * @var     object
	 * @since 3.2.0
	 **/
	protected ?object $details = null;

	/**
	 * set the server details
	 *
	 * @param   object     $details   The server details
	 *
	 * @return  Ftp
	 * @since 3.2.0
	 **/
	public function set(object $details): Ftp
	{
		// we need to make sure the if the details changed to get a new server client
		if (!ObjectHelper::equal($details, $this->details))
		{
			// set the details
			$this->details = $details;

			// reset the client if it was set before
			$this->client = null;
		}

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
		if ($this->connected())
		{
			return $this->client->store($localPath, $fileName);
		}

		return false;
	}

	/**
	 * Make sure we are connected
	 *
	 * @return  bool
	 * @since 3.2.0
	 **/
	private function connected(): bool
	{
		// check if we have a connection
		if ($this->client instanceof FtpClient && $this->client->isConnected())
		{
			return true;
		}

		$this->client = $this->getClient();

		return $this->client instanceof FtpClient;
	}

	/**
	 * get the FtpClient object
	 *
	 * @return  FtpClient|null
	 * @since 3.2.0
	 **/
	private function getClient(): ?FtpClient
	{
		// make sure we have a string and it is not default or empty
		if (StringHelper::check($this->details->signature))
		{
			// turn into array of variables
			$signature = [];
			parse_str((string) $this->details->signature, $signature);
			// set options
			if (isset($signature['options']) && ArrayHelper::check($signature['options']))
			{
				foreach ($signature['options'] as $o__p0t1on => $vAln3)
				{
					if ('timeout' === $o__p0t1on)
					{
						$options[$o__p0t1on] = (int) $vAln3;
					}
					if ('type' === $o__p0t1on)
					{
						$options[$o__p0t1on] = (string) $vAln3;
					}
				}
			}
			else
			{
				$options = [];
			}
			// get ftp object
			if (isset($signature['host']) && $signature['host'] != 'HOSTNAME' &&
				isset($signature['port']) && $signature['port'] != 'PORT_INT' &&
				isset($signature['username']) && $signature['username'] != 'user@name.com' &&
				isset($signature['password']) && $signature['password'] != 'password')
			{
				// this is a singleton
				return FtpClient::getInstance($host, $port, $options, $username, $password);
			}
		}

		return null;
	}

}

