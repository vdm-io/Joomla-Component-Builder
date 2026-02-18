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
use Joomla\Http\Transport\Curl;
use Joomla\Http\Transport\Stream;
use Joomla\Http\Transport\Socket;
use Joomla\Registry\Registry;
use VDM\Joomla\Gitea\Utilities\Http\Transport\UnsafeCurl;


/**
 * The Gitea Http
 * 
 * @since 3.2.0
 */
final class Http extends JoomlaHttp
{
	/**
	 * The token
	 *
	 * @var    string|null
	 * @since 3.2.0
	 */
	protected ?string $_token_; // to avoid collisions (but allow swapping)

	/**
	 * Constructor.
	 *
	 * @param   string|null     $token     The Gitea API token.
	 *
	 * @since   3.2.0
	 * @throws  \InvalidArgumentException
	 **/
	public function __construct(?string $token = null)
	{
		// setup config
		$config = [
			'userAgent' => 'JoomlaGitea/3.0',
			'headers' => [
				'Content-Type' => 'application/json'
			]
		];

		// add the token if given
		if (is_string($token) && !empty($token))
		{
			$config['headers']['Authorization'] = 'token ' . $token;
			$this->_token_ = $token;
		}

		$options = new Registry($config);

		// Force-create the transport WITH your options
		$transport = null;
		if (UnsafeCurl::isSupported()) {
			$transport = new UnsafeCurl($options);
		} elseif (Curl::isSupported()) {
			$transport = new Curl($options);
		} elseif (Stream::isSupported()) {
			$transport = new Stream($options);
		} else {
			$transport = new Socket($options);
		}

		// run parent constructor
		parent::__construct($options, $transport);
	}

	/**
	 * Change the Token.
	 *
	 * @param   string     $token     The Gitea API token.
	 *
	 * @since   3.2.0
	 **/
	public function setToken(string $token): void
	{
		// get the current headers
		$headers = (array) $this->getOption('headers', [
				'Content-Type' => 'application/json'
			]
		);

		if (empty($token))
		{
			unset($headers['Authorization']);
		}
		else
		{
			// add the token
			$headers['Authorization'] = 'token ' . $token;
			$this->_token_ = $token;
		}

		$this->setOption('headers', $headers);
	}

	/**
	 * Get the Token.
	 *
	 * @return  string|null
	 * @since   3.2.0
	 **/
	public function getToken(): ?string
	{
		return $this->_token_ ?? null;
	}
}

