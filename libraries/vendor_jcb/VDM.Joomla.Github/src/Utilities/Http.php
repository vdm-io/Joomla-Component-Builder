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

namespace VDM\Joomla\Github\Utilities;


use Joomla\CMS\Http\Http as JoomlaHttp;
use Joomla\Registry\Registry;



/**
 * The Github Http
 * 
 * @since 5.1.1
 */
final class Http extends JoomlaHttp
{
	/**
	 * The token
	 *
	 * @var    string|null
	 * @since 5.1.1
	 */
	protected ?string $_token_; // to avoid collisions (but allow swapping)

	/**
	 * The GitHub API version header
	 *
	 * @var string
	 * @since 5.1.1
	 */
	protected string $apiVersion;

	/**
	 * The GitHub default headers
	 *
	 * @var string
	 * @since 5.1.1
	 */
	protected array $defaultHeaders;

	/**
	 * Constructor.
	 *
	 * @param   string|null  $token    The Gitea API token.
	 * @param   string       $version  GitHub API Version (e.g. 2022-11-28)
	 *
	 * @since   5.1.1
	 * @throws  \InvalidArgumentException
	 **/
	public function __construct(?string $token = null, string $version = '2022-11-28')
	{
		$this->apiVersion = $version;

		$this->defaultHeaders = [
			'Content-Type' => 'application/json',
			'Accept'       => 'application/vnd.github+json',
			'X-GitHub-Api-Version' => $this->apiVersion
		];

		// setup config
		$config = [
			'userAgent' => 'JoomlaGitHub/3.0',
			'headers' => $this->defaultHeaders
		];

		// add the token if given
		if (is_string($token) && !empty($token))
		{
			$config['headers']['Authorization'] = 'Bearer ' . $token;
			$this->_token_ = $token;
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
	 * @since   5.1.1
	 **/
	public function setToken(string $token): void
	{
		// get the current headers
		$headers = (array) $this->getOption('headers', $this->defaultHeaders);

		if (empty($token))
		{
			unset($headers['Authorization']);
		}
		else
		{
			// add the token
			$headers['Authorization'] = 'Bearer ' . $token;
			$this->_token_ = $token;
		}

		$this->setOption('headers', $headers);
	}

	/**
	 * Get the Token.
	 *
	 * @return  string|null
	 * @since   5.1.1
	 **/
	public function getToken(): ?string
	{
		return $this->_token_ ?? null;
	}

	/**
	 * Set Accept header to 'application/vnd.github+json'
	 *
	 * @return  static
	 * @since   5.1.1
	 */
	public function json(): self
	{
		$this->setAcceptHeader('application/vnd.github+json');
		return $this;
	}

	/**
	 * Set Accept header to 'application/vnd.github.raw+json'
	 *
	 * @return  static
	 * @since   5.1.1
	 */
	public function raw(): self
	{
		$this->setAcceptHeader('application/vnd.github.raw+json');
		return $this;
	}

	/**
	 * Set Accept header
	 *
	 * @return  void
	 * @since   5.1.1
	 */
	protected function setAcceptHeader(string $value): void
	{
		$headers = (array) $this->getOption('headers', $this->defaultHeaders);
		$headers['Accept'] = $value;
		$this->setOption('headers', $headers);
	}
}

