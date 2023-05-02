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

namespace VDM\Joomla\Gitea\Utilities;


use Joomla\CMS\Http\Http as JoomlaHttp;
use Joomla\Registry\Registry;


/**
 * The Gitea Http
 * 
 * @since 3.2.0
 */
final class Http extends JoomlaHttp
{
	/**
	 * Constructor.
	 *
	 * @param   string|null     $token     The Gitea API token.
	 *
	 * @since   3.2.0
	 * @throws  \InvalidArgumentException
	 **/
	public function __construct(?string $token)
	{
		// setup config
		$config = [
			'userAgent' => 'JoomlaGitea/3.0',
			'headers' => [
				'Content-Type' => 'application/json'
			]
		];

		// add the token if given
		if (is_string($token))
		{
			$config['headers']['Authorization'] = 'token ' . $token;
		}

		$options = new Registry($config);

		// run parent constructor
		parent::__construct($options);
	}

	/**
	 * Change the Token.
	 *
	 * @param   string     $token     The Gitea API token.
	 *
	 * @since   3.2.0
	 **/
	public function setToken(string $token)
	{
		// get the current headers
		$headers = (array) $this->getOption('headers', [
				'Content-Type' => 'application/json'
			]
		);

		// add the token
		$headers['Authorization'] = 'token ' . $token;

		$this->setOption('headers', $headers);
	}

}

