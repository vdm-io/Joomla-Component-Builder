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

namespace VDM\Joomla\Openai\Utilities;


use Joomla\CMS\Http\Http as JoomlaHttp;
use Joomla\Registry\Registry;


/**
 * The Openai Http
 * 
 * @since 3.2.0
 */
final class Http extends JoomlaHttp
{
	/**
	 * The default Header
	 *
	 * @var    array
	 * @since 3.2.0
	 */
	protected array $defaultHeaders = ['Content-Type' => 'application/json'];

	/**
	 * Constructor.
	 *
	 * @param   string|null     $token     The Openai API token.
	 * @param   string|null     $orgToken  The Openai API Organization token.
	 *
	 * @since   3.2.0
	 * @throws  \InvalidArgumentException
	 **/
	public function __construct(?string $token, ?string $orgToken = null)
	{
		// add the token if given
		if (is_string($token))
		{
			$this->defaultHeaders['Authorization'] = 'Bearer ' . $token;
		}

		// add the organization token if given
		if (is_string($orgToken))
		{
			$this->defaultHeaders['OpenAI-Organization'] = $orgToken;
		}

		// setup config
		$config = [
			'userAgent' => 'JoomlaOpenai/3.0',
			'headers' => $this->defaultHeaders
		];

		$options = new Registry($config);

		// run parent constructor
		parent::__construct($options);
	}

	/**
	 * Change the Tokens.
	 *
	 * @param   string|null     $token     The Openai API token.
	 * @param   string|null     $orgToken  The Openai API Organization token.
	 *
	 * @since   3.2.0
	 **/
	public function setTokens(?string $token = null, ?string $orgToken = null)
	{
		// get the current headers
		$this->defaultHeaders = (array) $this->getOption('headers',
			$this->defaultHeaders
		);

		// add the token if given
		if (is_string($token))
		{
			$this->defaultHeaders['Authorization'] = 'Bearer ' . $token;
		}

		// add the organization token if given
		if (is_string($orgToken))
		{
			$this->defaultHeaders['OpenAI-Organization'] = $orgToken;
		}

		$this->setOption('headers', $this->defaultHeaders);
	}

	/**
	 * Change the User Token.
	 *
	 * @param   string     $token     The API token.
	 *
	 * @since   3.2.0
	 **/
	public function setToken(string $token)
	{
		// get the current headers
		$this->defaultHeaders = (array) $this->getOption('headers',
			$this->defaultHeaders
		);

		// add the token
		$this->defaultHeaders['Authorization'] = 'Bearer ' . $token;

		$this->setOption('headers', $this->defaultHeaders);
	}

	/**
	 * Change the Organization Token.
	 *
	 * @param   string     $token     The Organization API token.
	 *
	 * @since   3.2.0
	 **/
	public function setOrgToken(string $token)
	{
		// get the current headers
		$this->defaultHeaders = (array) $this->getOption('headers',
			$this->defaultHeader
		);

		// add the token
		$this->defaultHeaders['OpenAI-Organization'] = $token;

		$this->setOption('headers', $this->defaultHeaders);
	}
}

