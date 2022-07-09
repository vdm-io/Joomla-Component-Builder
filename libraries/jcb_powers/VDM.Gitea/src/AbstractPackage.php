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

namespace VDM\Gitea;


use Joomla\CMS\Http\Http as BaseHttp;
use Joomla\Registry\Registry;
use VDM\Gitea\AbstractGiteaObject;

abstract class AbstractPackage extends AbstractGiteaObject
{
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
		parent::__construct($options, $client);

		$this->package = \get_class($this);
		$this->package = substr($this->package, strrpos($this->package, '\\') + 1);
	}

	/**
	 * Magic method to lazily create API objects
	 *
	 * @param   string  $name  Name of property to retrieve
	 *
	 * @since   1.0
	 * @throws \InvalidArgumentException
	 *
	 * @return  AbstractPackage  Gitea API package object.
	 */
	public function __get($name)
	{
		$class = '\\VDM\\Gitea\\Package\\' . $this->package . '\\' . ucfirst($name);

		if (class_exists($class) == false)
		{
			throw new \InvalidArgumentException(
				sprintf(
					'Argument %1$s produced an invalid class name: %2$s in package %3$s',
					$name, $class, $this->package
				)
			);
		}

		if (isset($this->$name) == false)
		{
			$this->$name = new $class($this->options, $this->client);
		}

		return $this->$name;
	}

}

