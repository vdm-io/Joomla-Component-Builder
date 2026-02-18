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

namespace VDM\Joomla\Componentbuilder\Abstraction;


use Joomla\Registry\Registry as JoomlaRegistry;
use Joomla\CMS\Factory;
use Joomla\Input\Input;
use VDM\Joomla\Utilities\Component\Helper;
use VDM\Joomla\Utilities\String\ClassfunctionHelper;
use VDM\Joomla\Abstraction\FunctionRegistry;


/**
 * Component Configurations
 * 
 * @since 3.2.0
 */
abstract class ComponentConfig extends FunctionRegistry
{
	/**
	 * Hold a Input object for easier access to the input variables.
	 *
	 * @var    Input
	 * @since 3.2.0
	 */
	protected Input $input;

	/**
	 * The Params
	 *
	 * @var     JoomlaRegistry
	 * @since 3.2.0
	 */
	protected JoomlaRegistry $params;

	/**
	 * Constructor
	 *
	 * @param Input|null    $input  Input
	 * @param Registry|null $params The component parameters
	 *
	 * @throws \Exception
	 * @since 3.2.0
	 */
	public function __construct(?Input $input = null, ?JoomlaRegistry $params = null)
	{
		$this->input = $input ?: Factory::getApplication()->getInput();
		$this->params = $params ?: Helper::getParams('com_componentbuilder');
	}

	/**
	 * Get a config value.
	 *
	 * @param  string  $path     Registry path (e.g. joomla_content_showauthor)
	 * @param  mixed   $default  Optional default value, returned if the internal value is null.
	 *
	 * @return  mixed  Value of entry or null
	 *
	 * @since 5.1.4
	 */
	public function get(string $path, $default = null): mixed
	{
		// check if it has been set
		if (($value = parent::get($path, '__N0T_S3T_Y3T_')) !== '__N0T_S3T_Y3T_')
		{
			return $value;
		}
		// check if we have a parameter in the component of this path
		elseif (($value = $this->params->get($path, '__N0T_S3T_Y3T_')) !== '__N0T_S3T_Y3T_')
		{
			$this->set($path, $value);

			return $value;
		}
		// check if we have a input value of this path (only STRING values allowed)
		elseif (($value = $this->input->get($path, '__N0T_S3T_Y3T_', 'STRING')) !== '__N0T_S3T_Y3T_')
		{
			$this->set($path, $value);

			return $value;
		}

		return $default;
	}
}

