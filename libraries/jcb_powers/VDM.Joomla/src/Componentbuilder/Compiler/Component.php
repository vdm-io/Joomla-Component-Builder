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

namespace VDM\Joomla\Componentbuilder\Compiler;


use VDM\Joomla\Componentbuilder\Compiler\Factory as Compiler;
use VDM\Joomla\Componentbuilder\Compiler\Component\Data;
use VDM\Joomla\Componentbuilder\Abstraction\BaseRegistry;


/**
 * Compiler Component
 * 
 * @since 3.2.0
 */
final class Component extends BaseRegistry
{
	/**
	 * Constructor
	 *
	 * @param Data|null       $component    The component data class.
	 *
	 * @since 3.2.0
	 */
	public function __construct(?Data $component = null)
	{
		$component = $component ?: Compiler::_('Component.Data');

		parent::__construct($component->get());
	}

	/**
	 * getting any valid value
	 *
	 * @param   string       $path     The value's key/path name
	 *
	 * @since 3.2.0
	 */
	public function __get(string $path)
	{
		// check if it has been set
		if (($value = $this->get($path, '__N0T_S3T_Y3T_')) !== '__N0T_S3T_Y3T_')
		{
			return $value;
		}

		return null;
	}

}

