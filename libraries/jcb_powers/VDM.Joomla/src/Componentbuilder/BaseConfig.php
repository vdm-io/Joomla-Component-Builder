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

namespace VDM\Joomla\Componentbuilder;


use Joomla\Registry\Registry;
use Joomla\CMS\Factory;
use Joomla\Input\Input;
use VDM\Joomla\Utilities\Component\Helper;
use VDM\Joomla\Utilities\String\ClassfunctionHelper;


/**
 * Configurations
 * 
 * @since 3.2.0
 */
abstract class BaseConfig extends Registry
{
	/**
	 * Hold a JInput object for easier access to the input variables.
	 *
	 * @var    Input
	 * @since 3.2.0
	 */
	protected $input;

	/**
	 * The Params
	 *
	 * @var     Registry
	 * @since 3.2.0
	 */
	protected Registry $params;

	/**
	 * Constructor
	 *
	 * @param Input|null    $input  Input
	 * @param Registry|null $params The component parameters
	 *
	 * @throws \Exception
	 * @since 3.2.0
	 */
	public function __construct(?Input $input = null, ?Registry $params = null)
	{
		$this->input = $input ?: Factory::getApplication()->input;
		$this->params = $params ?: Helper::getParams('com_componentbuilder');

		// use underscore as the separator
		$this->separator = '_';

		// Instantiate the internal data object.
		$this->data = new \stdClass();
	}

	/**
	 * setting any config value
	 *
	 * @param   String  $key    The value's key/path name
	 * @param  mixed    $value  Optional default value, returned if the internal value is null.
	 *
	 * @since 3.2.0
	 */
	public function __set($key, $value)
	{
		$this->set($key, $value);
	}

	/**
	 * getting any valid value
	 *
	 * @param   String       $key     The value's key/path name
	 *
	 * @since 3.2.0
	 * @throws  \InvalidArgumentException If $key is not a valid function name.
	 */
	public function __get($key)
	{
		// check if it has been set
		if (($value = $this->get($key, '__N0T_S3T_Y3T_')) !== '__N0T_S3T_Y3T_')
		{
			return $value;
		}

		throw new \InvalidArgumentException(sprintf('Argument %s could not be found as function [%s], or path.', $key, $method));
	}

	/**
	 * Get a config value.
	 *
	 * @param  string  $path     Registry path (e.g. joomla.content.showauthor)
	 * @param  mixed   $default  Optional default value, returned if the internal value is null.
	 *
	 * @return  mixed  Value of entry or null
	 *
	 * @since 3.2.0
	 */
	public function get($path, $default = null)
	{
		// function name with no underscores
		$method = 'get' . ucfirst(ClassfunctionHelper::safe(str_replace('_', '', $path)));

		// check if it has been set
		if (($value = parent::get($path, '__N0T_S3T_Y3T_')) !== '__N0T_S3T_Y3T_')
		{
			return $value;
		}
		elseif (method_exists($this, $method))
		{
			$value = $this->{$method}();

			$this->set($path, $value);

			return $value;
		}

		return $default;
	}

}

