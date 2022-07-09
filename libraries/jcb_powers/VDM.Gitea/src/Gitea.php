<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <http://www.joomlacomponentbuilder.com>
 * @gitea      Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @github     Joomla Component Builder <https://github.com/vdm-io/Joomla-Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Gitea;


use Joomla\CMS\Http\Http as BaseHttp;
use Joomla\CMS\Http\HttpFactory;
use Joomla\Registry\Registry;

class Gitea
{
	/**
	 * Options for the Gitea object.
	 *
	 * @var    array
	 * @since  1.0
	 */
	protected $options;

	/**
	 * The HTTP client object to use in sending HTTP requests.
	 *
	 * @var    BaseHttp
	 * @since  1.0
	 */
	protected $client;

	/**
	 * Constructor.
	 *
	 * @param   Registry  $options  Gitea options object.
	 * @param   Http      $client   The HTTP client object.
	 *
	 * @since   1.0
	 */
	public function __construct(Registry $options = null, BaseHttp $client = null)
	{
		$this->options = $options ?: new Registry;

		// Setup the default user agent if not already set.
		if (!$this->getOption('userAgent'))
		{
			$this->setOption('userAgent', 'JGitea/1.0');
		}

		// Setup the default API url if not already set.
		if (!$this->getOption('api.url'))
		{
			$this->setOption('api.url', 'https://git.vdm.dev/api/v1');
		}

		$this->client = $client ?: (new HttpFactory)->getHttp($this->options);
	}

	/**
	 * Magic method to lazily create API objects
	 *
	 * @param   string  $name  Name of property to retrieve
	 *
	 * @return  AbstractGiteaObject  Gitea API object (issues, pulls, etc).
	 *
	 * @since   1.0
	 * @throws  \InvalidArgumentException If $name is not a valid sub class.
	 */
	public function __get($name)
	{
		$class = '\\VDM\\Gitea\\Package\\' . ucfirst($name);

		if (class_exists($class))
		{
			if (isset($this->$name) == false)
			{
				$this->$name = new $class($this->options, $this->client);
			}

			return $this->$name;
		}

		throw new \InvalidArgumentException(sprintf('Argument %s produced an invalid class name: %s', $name, $class));
	}

	/**
	 * Get an option from the Gitea instance.
	 *
	 * @param   string  $key  The name of the option to get.
	 *
	 * @return  mixed  The option value.
	 *
	 * @since   1.0
	 */
	public function getOption($key)
	{
		return isset($this->options[$key]) ? $this->options[$key] : null;
	}

	/**
	 * Set an option for the Gitea instance.
	 *
	 * @param   string  $key    The name of the option to set.
	 * @param   mixed   $value  The option value to set.
	 *
	 * @return  Gitea  This object for method chaining.
	 *
	 * @since   1.0
	 */
	public function setOption($key, $value)
	{
		$this->options[$key] = $value;

		return $this;
	}

}

