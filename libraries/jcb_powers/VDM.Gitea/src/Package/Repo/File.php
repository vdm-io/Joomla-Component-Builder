<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    3rd September, 2020
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Gitea\Package\Repo;


use Joomla\CMS\Http\Http;
use Joomla\Registry\Registry;
use VDM\Gitea\AbstractPackage;


/**
 * Start looking here:
 * https://git.vdm.dev/api/swagger#/repository/repoGetContents
 */
class File extends AbstractPackage
{
	/**
	 * Gets the metadata and contents (if a file) of an entry in a repository, or a list of entries if a dir
	 *
	 * @param   string  $owner       Repository owner.
	 * @param   string  $repo         Repository name.
	 * @param   string  $filepath    Repository file path.
	 *
	 * @return  object
	 *
	 * @since   1.0
	 */
	public function get($owner, $repo, $filepath)
	{
		// Build the request path.
		$path = '/repos/' . $owner . '/' . $repo . '/contents/' . $filepath;

		// Send the request.
		return $this->processResponse(
			$this->client->get($this->fetchUrl($path))
		);
	}

}

