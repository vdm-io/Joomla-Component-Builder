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


use Joomla\CMS\Factory as JoomlaFactory;
use Joomla\CMS\User\User;
use VDM\Joomla\Componentbuilder\Server\Load;
use VDM\Joomla\Componentbuilder\Server\Ftp;
use VDM\Joomla\Componentbuilder\Server\Sftp;
use VDM\Joomla\Utilities\StringHelper;


/**
 * Server Class
 * 
 * @since 3.2.0
 */
class Server
{
	/**
	 * The Loader
	 *
	 * @var    Load
	 * @since 3.2.0
	 */
	protected Load $load;

	/**
	* The Ftp object
	 *
	 * @var     Ftp
	 * @since 3.2.0
	 **/
	protected Ftp $ftp;

	/**
	* The Sftp object
	 *
	 * @var     Sftp
	 * @since 3.2.0
	 **/
	protected Sftp $sftp;

	/**
	 * Current User object
	 *
	 * @var    User
	 * @since 3.2.0
	 */
	protected User $user;

	/**
	 * Constructor
	 *
	 * @param Load       $load    The server details loader object.
	 * @param Ftp        $ftp     The server ftp object.
	 * @param Sftp       $sftp    The server sftp object.
	 * @param User|null  $user    The user object.
	 *
	 * @since 3.2.0
	 */
	public function __construct(Load $load, Ftp $ftp, Sftp $sftp, ?User $user = null)
	{
		$this->load = $load;
		$this->ftp = $ftp;
		$this->sftp = $sftp;
		$this->user = $user ?: JoomlaFactory::getUser();
	}

	/**
	 * Move File to Server
	 *
	 * @param   int       $id           The server local id to use
	 * @param   string    $localPath    The local path to the file
	 * @param   string    $fileName     The actual file name
	 * @param   int|null  $protocol     The protocol to use (if set)
	 * @param   string    $permission   The permission validation area
	 *
	 * @return  bool      true on success
	 * @since 3.2.0
	 */
	public function move(int $id, string $localPath, string $fileName,
		?int $protocol = null, string $permission = 'core.export'): bool
	{
		// get the server
		if ($this->user->authorise($permission, 'com_componentbuilder') &&
			(
				(
					is_numeric($protocol) &&
					($protocol == 1 || $protocol == 2)
				) || (
					($protocol = $this->load->value($id, 'protocol')) !== null &&
					($protocol == 1 || $protocol == 2)
				)
			)
		)
		{
			// use the FTP protocol
			if (1 == $protocol)
			{
				$protocol = 'ftp';
				$fields = [
					'name',
					'signature'
				];
			}
			// use the SFTP protocol
			else
			{
				$protocol = 'sftp';
				$fields = [
					'name',
					'authentication',
					'username',
					'host',
					'password',
					'path',
					'port',
					'private',
					'private_key',
					'secret'
				];
			}

			// get the details
			if (StringHelper::check($protocol) && ($details = $this->load->item($id, $fields)) !== null)
			{
				// now move the file
				return $this->{$protocol}->set($details)->move($localPath, $fileName);
			}
		}

		return false;
	}

}

