<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
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
 * https://git.vdm.dev/api/swagger#/repository/repoCreateWikiPage
 */
class Wiki extends AbstractPackage
{
	/**
	 * Get a repository wiki page
	 *
	 * @param   string  $owner               The repository owner
	 * @param   string  $repo                 The repository name
	 * @param   string  $pageName       The page name
	 *
	 * @return  object
	 *
	 * @since   1.0
	 */
	public function get(string $owner, string $repo, string $pageName)
	{
		// Build the request path.
		$path = '/repos/' . $owner . '/' . $repo . '/wiki/page/' . $pageName;

		// Send the request.
		return $this->processResponse(
			$this->client->get($this->fetchUrl($path))
		);
	}

	/**
	 * Get a repository wiki html page
	 *
	 * @param   string  $owner               The repository owner
	 * @param   string  $repo                 The repository name
	 * @param   string  $pageName       The page name
	 *
	 * @return  object
	 *
	 * @since   1.0
	 */
	public function getHtml(string $owner, string $repo, string $pageName)
	{
		// get the gitea wiki page
		$page = $this->get($owner, $repo, $pageName);

		if (empty($page->content))
		{
			throw new \Exception('Wiki page could not be found.');
		}

		// Build the request path.
		$path = '/markdown';

		// Get headers
		$headers = $this->client->getOption('headers', array());

		$headers['accept'] = 'text/html';
		$headers['Content-Type'] = 'application/json';

		// build the post body
		$data = [
			'Context' => 'string',
			'Mode' => 'string',
			'Text' => $page->content,
			'Wiki' => true
		];

		// Post the request.
		return $this->processResponse(
			$this->client->post($this->fetchUrl($path), json_encode($data), $headers)
		);
	}

}

