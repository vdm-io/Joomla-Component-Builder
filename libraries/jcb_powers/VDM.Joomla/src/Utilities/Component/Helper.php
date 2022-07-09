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

namespace VDM\Joomla\Utilities\Component;


use Joomla\Input\Input;
use Joomla\CMS\Component\ComponentHelper;
use Joomla\Registry\Registry;


/**
 * Some component helper
 * 
 * @since  3.0.11
 */
abstract class Helper
{
	/**
	 * The current option
	 *
	 * @var    String
	 * @since   3.0.11
	 */
	public static $option;

	/**
	 * The component params list cache
	 *
	 * @var    Registry[]
	 * @since   3.0.11
	 */
	protected static $params = array();

	/**
	 * Gets the parameter object for the component
	 *
	 * @param   String               $option  The option for the component.
	 *
	 * @return  Registry            A Registry object.
	 *
	 * @see     Registry
	 * @since   3.0.11
	 */
	public static function getParams($option = null)
	{
		// check that we have an option
		if (empty($option))
		{
			$option = self::getOption();
		}

		// get global value
		if (!isset(self::$params[$option]) || !self::$params[$option] instanceof Registry)
		{
			self::$params[$option] = ComponentHelper::getParams($option);
		}

		return self::$params[$option];
	}

	/**
	 * Gets the component option
	 *
	 * @param   String|Bool      $default  The default return value if none is found
	 *
	 * @return  String|Bool      A component option
	 *
	 * @since   3.0.11
	 */
	public static function getOption($default = 'empty')
	{
		if (empty(self::$option))
		{
			// get the option from the url input
			self::$option = (new Input)->getString('option', false);
		}

		if (self::$option)
		{
			 return self::$option;
		}

		return $default;
	}

	/**
	 * Gets the component code name
	 *
	 * @param   String              $option  The option for the component.
	 * @param   String|Bool      $default  The default return value if none is found
	 *
	 * @return  String|Mixed      A component code name
	 *
	 * @since   3.0.11
	 */
	public static function getCode($option = null, $default = null)
	{
		// check that we have an option
		if (empty($option))
		{
			$option = self::getOption();
		}
		// option with com_
		if (is_string($option) && strpos($option, 'com_') === 0)
		{
			return strtolower(trim(substr($option, 4)));
		}

		return $default;
	}

	/**
	 * Gets the component abstract helper class
	 *
	 * @param   String              $option  The option for the component.
	 * @param   String|Bool      $default  The default return value if none is found
	 *
	 * @return  String|Mixed      A component helper name
	 *
	 * @since   3.0.11
	 */
	public static function get($option = null, $default = null)
	{
		// check that we have an option
		// and get the code name from it
		if (($code_name = self::getCode($option, false)) !== false)
		{
			// we build the helper class name
			$helper_name = '\\' . \ucfirst($code_name) . 'Helper';
			// check if class exist
			if (class_exists($helper_name))
			{
				return $helper_name;
			}
		}

		return $default;
	}

	/**
	 * Check if the helper class of this component has a method
	 *
	 * @param   String       $method  The method name to search for
	 * @param   String       $option    The option for the component.
	 *
	 * @return  bool          true if method exist
	 *
	 * @since   3.0.11
	 */
	public static function methodExists($method, $option = null)
	{
		// get the helper class
		if (($helper = self::get($option, false)) !== false)
		{
			if (method_exists($helper, $method))
			{
				return true;
			}
		}

		return false;
	}

}

